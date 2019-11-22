@component('mail::message')

    Dear {{$subscription->user->name}}, <br>

Your request for {{$subscription->item_name}} has been approved by {{$subscription->approved_by}} at {{$subscription->approved_at->diffForHumans()}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
