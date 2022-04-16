<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Auth;

class NoteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Note::latest()->paginate(9);
        return view('notes.index',[
            'notes' => $notes
        ]);
    }

    public function deletedNote()
    {
        $notes = Note::onlyTrashed()->latest()->paginate(9);
        return view('notes.deleted',[
            'notes' => $notes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'numeric|required',
            'title' => 'required',
            'content'  => 'required',
            'type'  => 'required',
        ]);
        if($request->hasFile('image')){
            
            $des_path = 'public/images/notes';
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $path = $request->file('image')->storeAs($des_path, $image_name);
            $request->image = $image_name;
        }
        Note::create([
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'user_id' => Auth::user()->id,
            'image' => $request->image,
            "scope" => $request->scope,
        ]);

        return redirect()->back()->with('success', 'Note created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        $note = Note::findOrFail($note->id);

        if(Auth::user()->id == $note->user_id){
            return view('notes.show', [
                'note' => $note,
            ]);
        }else{
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        return view('notes.edit',[
            'note' => $note
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        $request->validate([
            'user_id' => 'numeric|required',
            'title' => 'required',
            'content'  => 'required',
            'type'  => 'required',
            // 'image'  => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $note->update($request->all());

        return redirect()->route('note.show', $note->id)->with('success', 'Note update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        // soft delete
        $note->delete();
        return redirect()->route('note.index')->with('success', 'Note delete successfully.');
    }

    /**
     * restore specific post
     *
     * @return void
     */
    public function restore($note)
    {
        Note::withTrashed()->find($note)->restore();
  
        return redirect()->route('note.index')->with('success', 'Note restored successfully.');
    }  
  
    /**
     * restore all post
     *
     * @return response()
     */
    public function restoreAll()
    {
        $note = Note::onlyTrashed()->restore();
        
        if($note == 0){
            return redirect()->route('note.index')->with('danger', 'Not found any Deleted Notes');
        }
        return redirect()->route('note.index')->with('success', 'All Note restored successfully.');
    }
}
