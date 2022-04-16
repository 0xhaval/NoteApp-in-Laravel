@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
            <h1>All Notes</h1>
            <a href="{{ route('note.create')}}" class="mb-3">
                <button type="button" class="btn btn-primary">Add a New Note</button>
            </a>
            <div class="float-end mb-3">
                <a href="{{ route('deletedNote') }}" class="btn btn-warning">View Deleted posts</a>
            </div>
            @if(Session::has('danger'))
                <div class="alert alert-danger">
                    {{ Session::get('danger') }}
                    @php
                        Session::forget('danger');
                    @endphp
                </div>
            @endif
            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                    @php
                        Session::forget('success');
                    @endphp
                </div>
            @endif
            @foreach ($notes as $note)
            @if (Auth::user()->id == $note->user_id)
                <div class="col-4">
                    <div class="card-group mb-3">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title "><a href="{{route('note.show', $note->id)}}" style="text-decoration:none">{{$note->title}}</a></h5>
                              <p class="card-text">{{Str::limit($note->content, 90)}}</p>
                            </div>
                            <div class="card-body">
                                <form action="{{route('note.destroy', $note->id)}}" method="post">
                                    @csrf
                                    @method("delete")
                                <a href="{{route('note.edit', $note->id)}}" class="card-link text-dark">Edit</a>
                                <button type="submit" class="btn btn-link link-danger">Delete</button>
                                </form>
                            </div>
                          </div>
                    </div>
                </div>
            @else
                <h3>You Don't Have any Notes</h3>
                @break
            @endif     
            @endforeach
    </div>
    {{$notes->links()}}
</div>
@endsection
