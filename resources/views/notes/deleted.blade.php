@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
            <h1>All Deleted Notes</h1>

            <div class="float-end mb-3">
                <a href="{{ route('note.index') }}" class="btn btn-info">View All posts</a>
                <a href="{{ route('restoreAll') }}" class="btn btn-success">Restore All</a>
            </div>
            @foreach ($notes as $note)
            @if (Auth::user()->id == $note->user_id)
                <div class="col-4">
                    <div class="card-group mb-3">
                        <div class="card">
                            {{-- <img class="card-img-top" src="..." alt="Card image cap"> --}}
                            <div class="card-body">
                                <h5 class="card-title"><a href="{{ route('note.show', $note->id)}}">{{$note->title}}</a></h5>
                                <p class="card-text">{{Str::limit($note->content, 100)}}</p>
                                <p class="card-text"><small class="text-muted">Created at {{$note->created_at}}</small></p>
                                <p class="card-text"><small class="text-muted">Deleted at {{$note->deleted_at}}</small></p>
                                <div class="col-6">
                                    <a href="{{route('restore', $note->id)}}">
                                        <button type="button" class="btn btn-success mb-2">Restore</button>
                                    </a>
                                </div>
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
