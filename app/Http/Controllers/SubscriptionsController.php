<?php

namespace App\Http\Controllers;

use App\Subscription;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['update']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        abort_if(auth()->user()->subscriptions()->where('item_id', \request('item_id'))->exists(), 401);

        auth()->user()->subscribe()->notify();

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @return void
     */
    public function update(Subscription $subscription)
    {
        $subscription->approve()->inform();

        //return view('items-subscription.completed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Subscription $subscription
     * @return void
     */
    public function destroy(Subscription $subscription)
    {
        return $subscription->revoke();
    }
}
