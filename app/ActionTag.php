<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class actionTag extends Model
{
    use HasFactory;
    public function action(){
        return $this->belongsTo(Action::class);
    }

    public function tag(){
        return $this->belongsTo(Tag::class);
    }
}
