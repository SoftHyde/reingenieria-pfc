<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentProjectReport extends Model
{
    use HasFactory;

    public function comment(){
        return $this->belongsTo(CommentProject::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}