@component('mail::message')
Dear {{ $user->department->head }}, <br>
    {{$user->name}} has requested for {{ $subscription->item_name }}. <br>

To Accept the request please follow the url given.

@component('mail::button', ['url' => route('items.subscriptions.update', ['subscription'=> $subscription])])

Approve
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
