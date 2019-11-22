@component('mail::message')
    Dear {{$device->user->name}} your request for {{$device->name}} has been approved by {{$approvedBy}}

 @endcomponent
