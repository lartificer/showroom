<?php namespace Lartificer\News\Models;

use Illuminate\Database\Eloquent\Model;

class NewsTranslation extends Model {

    protected $fillable = ['title', 'content', 'slug', 'language', 'news_id'];

    public function newsEntry() {
        return $this->belongsTo('Lartificer\News\Models\News');
    }

}
