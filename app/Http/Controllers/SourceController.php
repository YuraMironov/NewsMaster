<?php

namespace App\Http\Controllers;

use App\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sources = Source::all();
        return view('sources.index', compact('sources', $sources));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sources.create');
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
            'name' => 'required'
        ]);
        $source = Source::firstOrCreate(['name' => $request->get('name')]);
        return redirect('sources/' . $source->id);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Source $source
     * @return \Illuminate\Http\Response
     */
    public function show(Source $source)
    {
        return view('sources.show', compact('source', $source));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function edit(Source $source)
    {
        return view('sources.edit', compact('source', $source));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Source $source)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $source->name = $request->name;
        $source->save();
        $request->session()->flash('message', 'Successfully modified the source!');
        return redirect('sources/' . $source->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  \App\Source $source
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Source $source)
    {
        $source->delete();
        $request->session()->flash('message', 'Successfully deleted the source!');
        return redirect('sources');
    }
}
