<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $fillable = [
        'title',
        'content',
        'author'
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'author', 'id');
    }
    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'post_id', 'id');
    }
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'post_tags', 'post_id', 'tag_id');
    }
    public function image(){
        return $this->hasOne('App\Models\Image', 'post_id', 'id');
    }
}
