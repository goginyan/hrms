<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use App\Http\Requests\DocumentStoreRequest;
use App\Mail\DocumentApproved;
use App\Mail\DocumentForApprove;
use App\Mail\DocumentRejected;
use App\Models\Department;
use App\Models\DocType;
use App\Models\Document;
use App\Notifications\DocumentReceived;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;

class DocumentController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Document::class, 'document', ['except' => ['store', 'create']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('documents.index')->with([
            'documents'  => Auth::user()->employee->documents()->with(['type', 'waiting', 'rejectedBy'])->get(),
            'forApprove' => Auth::user()->employee->documentsForApprove
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('documents.create')->with([
            'docTypes'  => Auth::user()->creator->createDocTypes,
            'inProcess' => Auth::user()->employee->getDocTypesInProcess()
        ]);
    }

    /**
     * Display the form for filling the document
     *
     * @param DocType $docType
     *
     * @return Response
     */
    public function fill(DocType $docType)
    {
        $this->authorize('fill', ['App\Models\Document', $docType]);

        return view('documents.fill')->with([
            'docType' => $docType
        ]);
    }

    /**
     * Send a newly created document to approve
     *
     * @param DocumentStoreRequest $request
     *
     * @return Response
     */
    public function store(DocumentStoreRequest $request)
    {
        $this->authorize('create', ['App\Models\Document', $request->hidden_doc_type]);

        $fields   = collect($request->except('hidden_doc_type', '_token'))->mapWithKeys(function ($item, $key) {
            return [str_replace("_", " ", $key) => $item];
        })->toArray();
        $employee = Auth::user()->employee;
        $document = $employee->documents()->create([
            'fields' => $fields
        ]);
        /** @var Document $document */
        $document->type()->associate(DocType::find($request->hidden_doc_type));
        $waitingRole     = $document->type->approveRoles->first();
        $department      = $employee->department ? $employee->department : Department::find(1);
        $approveEmployee = $department->employees()
                                      ->with('user.role')
                                      ->whereHas('user',
                                          function (Builder $q) use ($waitingRole) {
                                              $q->where('role_id', $waitingRole->id);
                                          })
                                      ->first();
        if (!$approveEmployee) {
            $approveEmployee = $waitingRole->users->first()->employee;
        }
        $document->waiting()->associate($approveEmployee);
        Mail::to($approveEmployee->user)->send(new DocumentForApprove($document));
        $approveEmployee->user->notify(new DocumentReceived($document));
        $document->save();

        return redirect()->route('documents.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Document $document
     *
     * @return Response
     */
    public function show(Document $document)
    {
        //$this->authorize('view', $document);

        return view('documents.show')->with([
            'document' => $document
        ]);
    }

    /**
     * Display the details of document for approve
     *
     * @param Document $document
     *
     * @return Response
     */
    public function approve(Document $document)
    {
        $this->authorize('approve', $document);

        return view('documents.approve')->with([
            'document' => $document
        ]);
    }

    /**
     * Create a duplicate of the document and remove old version
     *
     * @param Document $document
     *
     * @return Response
     */
    public function resubmit(Document $document)
    {
        $this->authorize('view', $document); //resubmit has same restriction as the 'view'
        $new = $document->replicate();
        $document->delete();

        return view('documents.fill')->with([
            'docType'  => $new->type,
            'document' => $new,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request  $request
     * @param Document $document
     *
     * @return Response
     */
    public function update(Request $request, Document $document)
    {
        if ($request->approved) {
            $approveCurrentStep = $document->type
                ->approveRoles()
                ->where('role_id', Auth::user()->role->id)->first()->pivot->sequence;
            $approveMaxStep = $document->type
                ->approveRoles
                ->last()->pivot->sequence;
            if ($approveCurrentStep < $approveMaxStep) {
                $approveCurrentStep++;
                $waitingRole     = $document->type
                    ->approveRoles()
                    ->wherePivot('sequence', $approveCurrentStep)->first();
                $department      = $document->author->department;
                $approveEmployee = $department->employees()
                                              ->with('user.role')
                                              ->whereHas('user',
                                                  function (Builder $q) use ($waitingRole) {
                                                      $q->where('role_id', $waitingRole->id);
                                                  })
                                              ->first();
                if (!$approveEmployee) {
                    $approveEmployee = $waitingRole->users->first()->employee;
                }
                $document->waiting()->associate($approveEmployee);
                Mail::to($approveEmployee->user)->send(new DocumentForApprove($document));
                $approveEmployee->user->notify(new DocumentReceived($document));
            } else {
                $document->waiting()->dissociate();
                $document->approved = true;
                Mail::to($document->author->user)->send(new DocumentApproved($document));
                $document->author->user->notify(new \App\Notifications\DocumentApproved($document));
            }
        } else {
            $document->comment = $request->comment;
            $document->waiting()->dissociate();
            $document->rejectedBy()->associate(Auth::user()->employee);
            Mail::to($document->author->user)->send(new DocumentRejected($document));
            $document->author->user->notify(new \App\Notifications\DocumentRejected($document));
        }
        $document->save();

        return redirect()->route('documents.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Document $document
     *
     * @return Response
     * @throws Exception
     */
    public function destroy(Document $document)
    {
        $document->delete();

        return redirect()->route('documents.index');
    }
}
