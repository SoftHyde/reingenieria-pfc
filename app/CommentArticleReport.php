<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentArticleReport extends Model
{
    use HasFactory;

    public function comment(){
        return $this->belongsTo(CommentArticle::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}