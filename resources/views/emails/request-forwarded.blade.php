@component('mail::message')
Dear Admin,

{{auth()->user()->name}} has requested to grant {{$deviceSubscription->device->name}} for home use!

Please note the subscription id is {{$deviceSubscription->subscription_id}}

@component('mail::button', ['url' => route('subscriptions.edit', ['deviceSubscription'=> $deviceSubscription])])
Approve
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
