@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Authorize Device: {{$subscription->item_name}} for {{$subscription->user->name}}</div>
                    <div class="card-body">
                        <form action ="{{route('items.subscriptions.update', ['subscription' => $subscription])}}" method="POST">
                            @csrf
                            <label for="">Approved By</label>
                            <input type="text" class="form-control" name="approved_by">

                            <label for="comment">Comment</label>
                            <textarea name="comment" class="form-control" id="" cols="5" rows="5"></textarea>

                            <div class="form-group">
                                <input type="submit" class="btn btn-primary btn-sm float-right" value="Approve">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
