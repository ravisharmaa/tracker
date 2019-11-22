<?php

namespace App\Http\Controllers;

use App\Device;
use App\DeviceSubscription;
use App\Events\SubscriptionWasGranted;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class DeviceSubscriptionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['edit', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Device $device)
    {
        abort_if(
            Gate::denies('subscribe-to-device', $device),
            403,
            'Sorry! We are unable to complete this request.'
        );

        abort_if(
            $device->subscriptions()->exists(),
            403,
            'Sorry ! you are already subscribed to this device.'
        );

        $device->subscribe()->notify();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(DeviceSubscription $deviceSubscription)
    {
        return view('subscriptions.edit', compact('deviceSubscription'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(DeviceSubscription $deviceSubscription)
    {
        $deviceSubscription->complete();

        event(new SubscriptionWasGranted($deviceSubscription->device, request('approved_by')));

        return redirect('/home');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeviceSubscription $deviceSubscription): RedirectResponse
    {
        $deviceSubscription->revoke();

        return back();
    }
}
