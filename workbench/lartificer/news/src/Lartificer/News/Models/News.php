<?php namespace Lartificer\News\Models;


use Illuminate\Database\Eloquent\Model;

class News extends Model {

    protected $fillable = ['user_id', 'visible'];

    public function newsTranslations() {
        return $this->hasMany('Lartificer\News\Models\NewsTranslation');
    }

    public function user() {
        return User::find($this->user_id);
    }

}
