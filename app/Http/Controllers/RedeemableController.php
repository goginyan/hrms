<?php

namespace App\Http\Controllers;

use App\Models\Redeemable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedeemableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('rewards.redeemables.index')->with([
            'redeemables' => Redeemable::all()
        ]);
    }

    /**
     * Show the information about redeemed products for manage them
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manage()
    {
        $redeemed = Redeemable::has('employees')->get();

        return view('rewards.redeemables.manage')->with([
            'redeemables' => $redeemed
        ]);
    }

    /**
     * Display a listing of the resource for employee
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function userIndex()
    {
        return view('rewards.redeemables.user_index')->with([
            'redeemables' => Redeemable::all()
        ]);
    }

    /**
     * Redeem the redeemable product by Auth user
     *
     * @param Request    $request
     * @param Redeemable $redeemable
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function redeem(Request $request, Redeemable $redeemable)
    {
        $employee = Auth::user()->employee;
        $reward   = (int)$employee->reward_received;
        $price    = (int)$redeemable->price;
        if ($price <= $reward) {
            $employee->reward_received -= $price;
            $employee->redeemables()->attach([
                $redeemable->id => [
                    'date' => now()
                ]
            ]);
            $employee->save();

            return response()->json([
                'status'       => true,
                'message'      => 'ok',
                'user_points'  => $employee->reward_received,
                'user_message' => sprintf(__('Success. You successfully redeemed "%s" for %d reward-points'), $redeemable->title, $price)
            ]);
        }

        return response()->json([
            'status'       => false,
            'message'      => 'rejected',
            'user_points'  => $employee->reward_received,
            'user_message' => __('Fail. You don\'t have enough reward-points to redeem the product'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $redeemable = Redeemable::create($request->all());
        $image      = $request->file('image');
        if ($image) {
            $ext  = $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images/redeemables/' . $redeemable->id, "image.$ext");

            $newImage          = str_replace('public/', 'storage/', $path);
            $redeemable->image = asset($newImage);
            $redeemable->save();
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Redeemable $redeemable
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Redeemable $redeemable)
    {
        return view('rewards.redeemables.show')->with([
            'redeemable' => $redeemable
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Redeemable   $redeemable
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Redeemable $redeemable)
    {
        $redeemable->update($request->all());
        $image = $request->file('image');
        if ($image) {
            $ext  = $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images/redeemables/' . $redeemable->id, "image.$ext");

            $newImage          = str_replace('public/', 'storage/', $path);
            $redeemable->image = asset($newImage);
            $redeemable->save();
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Redeemable $redeemable
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Redeemable $redeemable)
    {
        $redeemable->delete();

        return back();
    }
}
