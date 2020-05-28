<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use App\Http\Requests\TeamStoreRequest;
use App\Models\Employee;
use App\Models\Team;
use App\Notifications\TeamIncluded;
use App\Notifications\TeamUpdated;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Notification;

class TeamController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Team::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('teams.index')->with([
            'teams' => Auth::user()->isAdmin() ? Team::all() : Auth::user()->employee->teams
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('teams.add')->with([
            'members' => Employee::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TeamStoreRequest $request
     *
     * @return Response
     */
    public function store(TeamStoreRequest $request)
    {
        $team = Team::create($request->all());
        /** @var Team $team */
        $team->members()->sync($request->members);
        $members = Employee::find($request->members);
        foreach ($members as $member) {
            $member->user->notify(new TeamIncluded($team));
        }
        if (!Auth::user()->isAdmin()) {
            Auth::user()->notify(new TeamIncluded($team));
            $team->members()->attach([Auth::user()->employee->id => ['role' => 'creator']]);
        }

        return redirect()->route('teams.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Team $team
     *
     * @return Response
     */
    public function show(Team $team)
    {
        return view('teams.show', ['team' => $team])->with([
            'team'  => $team,
            'roles' => Team::$roles
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Team $team
     *
     * @return Response
     */
    public function edit(Team $team)
    {
        return view('teams.edit')->with([
            'team'        => $team,
            'members'     => Employee::all(),
            'teamMembers' => array_column($team->members->toArray(), 'id')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TeamStoreRequest $request
     * @param Team             $team
     *
     * @return Response
     */
    public function update(TeamStoreRequest $request, Team $team)
    {
        $team->update($request->all());
        if ($request->roles) {
            $data = $request->roles;
            array_walk($data, function (&$el) {
                $el = ['role' => $el];
            });
            $team->members()->sync($data);
        } else {
            $team->members()->sync($request->members);
        }
        if (!Auth::user()->isAdmin()) {
            $team->members()->syncWithoutDetaching([Auth::user()->employee->id => ['role' => 'creator']]);
        }
        foreach ($team->members() as $member) {
            $member->user->notify(new TeamUpdated($team));
        }

        return redirect()->route('teams.show', $team);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Team $team
     *
     * @return Response
     * @throws Exception
     */
    public function destroy(Team $team)
    {
        $team->delete();

        return redirect()->route('teams.index');
    }
}
