<?php

namespace App\Http\Controllers;

use App\Article;
use App\Console\Commands\GetNews;
use App\Keyword;
use App\Source;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->q;
        if ($q) {
            $articles = Article::where('title', 'ilike', "%{$q}%")->orderBy('title')->get();
        } else {
            $articles = Article::orderBy('id', 'asc')->take(100)->get();
        }
        return view('articles.index', compact('articles', $articles));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sources = Source::all();
        return view('articles.create', compact('sources', $sources));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->articleValidate($request);
        $article = new Article();
        $this->articleSetFields($request, $article);
        $article->save();
        GetNews::saveKeywordsByArticle($article);

        return redirect('articles/' . $article->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return view('articles.show', compact('article', $article));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $sources = Source::all();
        return view('articles.edit', compact(['article', 'sources'], [$article, $sources]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $this->articleValidate($request);
        $this->articleSetFields($request, $article);
        GetNews::saveKeywordsByArticle($article);
        $article->save();
        return redirect('articles/' . $article->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  \App\Article $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Article $article)
    {
        $words = GetNews::getWordsArray($article);
        foreach ($words as $keyword) {
            $word = Keyword::where(['keyword' => $keyword])->first();
            if ($word !== null) {
                $word->counter -= $words[$keyword];
            }
            $word->save();
        }
        $article->delete();
        $request->session()->flash('message', 'Successfully deleted the article!');
        return redirect('articles');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function articleValidate(Request $request) : void
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required|min:30',
            'author' => 'required'
        ]);
    }

    /**
     * @param Request $request
     * @param Article $article
     *
     * @return void
     */
    protected function articleSetFields(Request $request, Article $article) : void
    {
        foreach ($article->getFields() as $field) {
            if ($article->$field !== $request->$field) {
                $article->$field = $request->$field;
            }
        }
    }
}
