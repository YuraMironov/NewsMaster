<?php

namespace App\Http\Controllers;

use App\Article;
use App\Keyword;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $alphabet = $request->q;
        $keywords = [];
        if ($alphabet) {
            $keywords = Keyword::where('keyword', 'ilike', $alphabet . '%')->orderBy('keyword')->get();
        }
        $alphabet = ["а", "б", "в", "г", "д", "е", "ё", "ж", "з", "и", "й", "к", "л", "м", "н", "о", "п",
            "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш", "щ", "ь", "ъ", "э", "ю", "я"];
        return view('keywords.index', compact('keywords', 'alphabet'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('keywords.create');
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
            'keyword' => 'required'
        ]);
        $keyword = Keyword::firstOrCreate([
            'keyword' => $request->get('keyword'),
            'disable' => (bool) $request->get('disable')]);
        return redirect('keywords/' . $keyword->id);
    }

    /**
     * Display the specified resource.
     *
     * @param Keyword $keyword
     * @return \Illuminate\Http\Response
     * @internal param \App\Source $source
     */
    public function show(Keyword $keyword)
    {
        return view('keywords.show', compact('keyword'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Keyword $keyword
     * @return \Illuminate\Http\Response
     * @internal param Source|\App\Source $source
     */
    public function edit(Keyword $keyword)
    {
        return view('keywords.edit', compact('keyword'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Keyword $keyword
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Keyword $keyword)
    {
        $request->validate([
            'keyword' => 'required'
        ]);
        if ($keyword->disable !== (bool) $request->disable) {
            $keyword->keyword = $request->keyword;
        }

        $keyword->disable = (bool) $request->disable;
        $keyword->save();
        $request->session()->flash('message', 'Successfully modified the keyword!');
        return redirect('keywords/' . $keyword->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Keyword $keyword
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Keyword $keyword)
    {
        $keyword->delete();
        $request->session()->flash('message', 'Successfully deleted the source!');
        return redirect('keywords');
    }

    /**
     * Get most popular tag in system
     * @param int $count
     * @return array
     */
    public function popular(int $count)
    {
        $popular = Keyword::active()->orderBy('counter', 'desc')->take($count)->get();
        return view('reports.index', compact('popular'));
    }
}
