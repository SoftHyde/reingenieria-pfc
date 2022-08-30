<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newvent extends Model
{
    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 6;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'newvents';

    public function action(){
        return $this->belongsTo(Action::class);
    }
}
