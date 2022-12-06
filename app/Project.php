<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Project extends Model
{
    use HasFactory;

    public function article(){
        return $this->hasMany(Article::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function projectTag(){
        return $this->hasMany(ProjectTag::class);
    }
    public function moderator(){
        return $this->hasMany(Moderator::class);
    }

    public function countdown(){
        // 
        if((new Carbon($this->limit_date))->greaterThan(Carbon::now())){
            return((new Carbon($this->limit_date))->diffInDays(Carbon::now()));
        }
        else{
            return 0;
        }
        
     }

     public function commentProject(){
        return $this->hasMany(CommentProject::class);
    }


}
