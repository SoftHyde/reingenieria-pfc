<?php

/* namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword; */
    namespace App;

    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'avatar'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function comments(){
        
        return $this->hasMany(Comment::class);
    }

    public function proposals(){
        
        return $this->hasMany(Proposal::class);
    }

    public function actions(){
        
        return $this->hasMany(Action::class);
    }

    public function supportProposal(){
        
        return $this->belongsToMany(Proposal::class, 'user_support_proposal')->withTimestamps();;
    }

    public function likeComment(){
        
        return $this->belongsToMany(Comment::class, 'user_like_comment')->withTimestamps();;
    }

    public function votes(){
        return $this->belongsToMany(Option::class, 'user_vote_option');
    }

    //return array of polls ids
    public function polls(){
        return $this->votes()->lists('poll_id')->toArray();
    }

    public function ratings(){
        return $this->hasMany(Rating::class);
    }

    //return array of works ids
    public function ratedWorks(){
        return $this->ratings()->lists('work_id')->toArray();
    }    

    public function getIsAdminAttribute()
    {
        return true;
    }

}
