<?php

namespace App\Console\Commands;

use App\Article;
use App\Keyword;
use App\Source;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GetNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'download and update news';


    /**
     * link for news getting
     *
     * @const string
     */
    protected const API_NEWS_LINK = 'https://newsapi.org/v2/everything?';

    /**
     * link for news getting
     *
     * @const string
     */
    protected const NEWS_REQUIRED_PARAMS= 'language=ru&q=и&sortedBy=publishedAt&pageSize=100';
    /**
     * apikey for newsapi.org
     * @const string
     */
    protected const API_KEY = '&apiKey=ccad8fe4b21c4186b5dd1f5848c03c16';

    /**
     * From parameter file
     * @const string
     */
    protected const FROM_PARAM_DIR = __DIR__. '/../../../storage/app/from_param';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->confirm('Start uploading news?', true)) {
            $this->processing();
        }
    }

    /**
     * @return void
     */
    public function processing() : void
    {
        $this->info('Checking and downloading');
        $last_date = '&from=' . $this->getLastDate() ?: '';
        ini_set("allow_url_fopen", 1);
        $url = $this::API_NEWS_LINK . $this::NEWS_REQUIRED_PARAMS . $last_date . $this::API_KEY;
        $this->info($url);
        $json = file_get_contents($url);
        $result = json_decode($json);
        $count = $result->totalResults;
        $pageSize = (int) substr($this::NEWS_REQUIRED_PARAMS, strpos($this::NEWS_REQUIRED_PARAMS, "pageSize=") + 9);
        if (($size = count($result->articles)) > 0) {
            $this->info('Downloading first ' . $size . ' news');
            $this->saveArticles($result->articles);
        }
        $count -= $pageSize;

        if ($count > 0) {
            if ($this->confirm('Realy upload all ' . $count . ' newses?', false)) {
                $new_count = (int)$this->ask("Please, input count news");
                $count = $new_count < $count ? $new_count : $count;
                for ($page = 2; $count > 0; $page++) {
                    $json = file_get_contents($url . '&page=' . $page);
                    $this->info($url . '&page=' . $page);
                    $result = json_decode($json);
                    $this->saveArticles($count < $pageSize ? array_slice($result->articles, 0, $count) : $result->articles);
                    $count -= $pageSize;
                }
            }
        }
        $this->info('Exit');
    }

    /**
     * saving articles in db
     * @param array $articles
     */
    private function saveArticles(array $articles) : void
    {
        foreach ($articles as $article) {
            if ($article->title && $article->description) {
                $s = Source::firstOrCreate(['name' => $article->source->name]);
                $a = Article::firstOrCreate(['title' => $article->title, 'description' => $article->description]);
                $a->author = $article->author;
                $a->source_id = $s->id;
                $a->url = $article->url;
                $a->urltoimage = $article->urlToImage;
                $date = str_replace_first('T', ' ', substr($article->publishedAt, 0, 19));
                $a->publishedat = $date . '.000000';
                $a->save();
                $this->saveKeywordsByArticle($a);
            }
        }
    }

    /**
     * saving articles in db
     * @param Article $article
     */
    public static function saveKeywordsByArticle(Article $article) : void
    {
        try {
            $keywords = self::getWordsArray($article);
            foreach (array_keys($keywords) as $keyword) {
                $word = Keyword::all()->where('keyword', $keyword)->first() ?? new Keyword();
                if ($word->id) {
                    $word->counter += $keywords[$keyword];
                } else {
                    $word->keyword = $keyword;
                    $word->counter = $keywords[$keyword];
                }
                $word->save();
                if (!$word->articles()->find($article->id)) {
                    $word->articles()->save($article);
                }
            }
        } catch (\ErrorException $e) {
            //Skip error with undefined symbols
        }
    }
    /**
     * Returning article description words array with count
     */
    public static function getWordsArray(Article $article) {
        $desc = $article->description;
        preg_match_all('/[^\w\s-\(\),\.!?;:"\'@%$#*&\/<>\]\[«»]+/', iconv('UTF-8', 'WINDOWS-1251', $desc), $keywords);
        $keywords = array_map(function ($word) {
            return preg_replace('/…/', '', iconv('WINDOWS-1251', 'UTF-8', strtolower($word)));
        }, $keywords[0]);
        return array_count_values($keywords);
    }
    /**
     * Returning last post published date in local db
     *
     * @return null|string
     */
    private function getLastDate() : ?string
    {
        $date = Article::where('publishedat', '<>', null)->orderBy('publishedat', 'desc')->first();
        return $date ? str_replace_first(' ', 'T', substr($date->publishedat, 0, 19)) : null;
    }
}
