@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
                @php
                    Session::forget('success');
                @endphp
            </div>
        @endif
        @if (Auth::user()->id == $note->user_id)
        <h1>{{$note->title}}</h1>
        <div class="card">
            <img class="card-img-top" src="{{asset('storage/images/notes/'.$note->image)}}" alt="Card image cap">
            <div class="card-body">
                <div class="alert alert-info" role="alert">
                    Type: {{$note->type}}
                  </div>
                <p class="card-text">{{$note->content}}</p>
                <p class="card-text"><small class="text-muted">Created at {{$note->created_at}}</small></p>
                <div class="col-6">
                    <form action="{{route('note.destroy', $note->id)}}" method="post">
                        @csrf
                        @method("delete")
                    <a href="{{route('note.edit', $note->id)}}" class="card-link text-warning">Edit</a>
                    <button type="submit" class="btn btn-link link-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
            
        @else
            
        @endif
    </div>
</div>
@endsection
