<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Relation;

class Article extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'publishedat', 'url', 'urltoimage', 'source_id', 'author'];

    public function getFields() : array
    {
        return array_diff($this->fillable, ['publishedat']);
    }


    /**
     * Get article source
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function source()
    {
        return $this->belongsTo('App\Source');
    }

    public function keywords()
    {
        return $this
            ->belongsToMany('App\Keyword', 'article_keyword', 'article_id', 'keyword_id')
            ->where('disable', '=', false);
    }

}
