@extends('layouts.app')

@section('content')
    <device-list-component :subscriptions="{{$subscriptions}}"></device-list-component>
@endsection
