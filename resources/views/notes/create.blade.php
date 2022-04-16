@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h1>Add a New Note</h1>
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
                @php
                    Session::forget('success');
                @endphp
            </div>
        @endif

        <form action="{{route('note.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="number" hidden value="{{Auth::user()->id}}" name="user_id">
            <div class="form-group mb-2">
                <label>Title</label>
                <input type="text" class="form-control" placeholder="Note Title" name="title">
                @error('title')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-2">
                <label for="exampleFormControlSelect2">Type</label>
                <select class="form-control" id="exampleFormControlSelect2" name="type">
                    <option disabled selected>Choose...</option>
                    <option value="urgent">urgent</option>
                    <option value="on date">on date</option>
                    <option value="normal">normal</option>
                </select>
                @error('type')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label for="exampleFormControlSelect2">Scope</label>
                <select class="form-control" id="exampleFormControlSelect2" name="scope">
                    <option disabled selected>Choose...</option>
                    <option value="private">private</option>
                    <option value="public">public</option>
                </select>
                @error('scope')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-2">
                <label for="exampleFormControlTextarea1">Upload Image</label>
                <input type="file" class="form-control" name="image">
                @error('image')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-2">
                <label for="exampleFormControlTextarea1">Content</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="content"></textarea>
                @error('content')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

              
            <div class="form-group mt-3">
                <button class="btn btn-primary form-control">Save</button>
            </div>
        </form>

    </div>
</div>
@endsection
