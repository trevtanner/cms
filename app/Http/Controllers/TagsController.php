<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\Tags\CreateTagRequest;
use App\Http\Requests\Tags\UpdateTagRequest;
use Illuminate\Http\Response;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('tags.index')->with('tags', Tag::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(CreateTagRequest $request)
    {

        Tag::create([
            'name' => $request->name,
        ]);

        session()->flash('success', 'Tag created successfully.');

        return redirect(route('tags.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Tag $tag)
    {

        return view('tags.create')->with('tag', $tag);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $tag->update([

            'name' => $request->name

        ]);

        $tag->save();

        session()->flash('success', 'Tag updated successfully.');

        return redirect(route('tags.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Tag $tag)
    {

        if ($tag->posts->count() > 0){
            session()->flash('error', 'Tag cannot be deleted because it is associated some posts.');

            return redirect()->back();
        }

        $tag->delete();

        session()->flash('success', 'Tag deleted successfully');

        return redirect(route('tags.index'));
    }
}
