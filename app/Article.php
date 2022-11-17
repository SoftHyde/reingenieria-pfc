<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function articleVotedUsers(){
        return $this->hasMany(ArticleVotedUsers::class);
    }

    public function commentArticle(){
        return $this->hasMany(CommentArticle::class);
    }


    public function supporters(){
        return $this->belongsToMany(User::class, 'user_support_article')->withTimestamps();
    }

}
