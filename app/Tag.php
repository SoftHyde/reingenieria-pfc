<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public function projectTag(){
        return $this->belongsToMany(Project::class, 'project_tags')->withTimestamps();
    }

    public function actionTag(){
        return $this->belongsToMany(Action::class, 'project_tags')->withTimestamps();
    }
}
