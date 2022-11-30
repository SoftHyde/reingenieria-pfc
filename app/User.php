<?php

/* namespace App;

use Illuminate\Auth\Authenticatable;

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
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;

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

    public function supportArticle(){
        
        return $this->belongsToMany(Article::class, 'user_support_article')->withTimestamps();;
    }

    public function likeComment(){
        
        return $this->belongsToMany(Comment::class, 'user_like_comment')->withTimestamps();;
    }

    public function votes(){
        return $this->belongsToMany(Option::class, 'user_vote_option');
    }

    //return array of polls ids
    public function polls(){
        return $this->votes()->pluck('poll_id')->toArray();
    }

    public function ratings(){
        return $this->hasMany(Rating::class);
    }

    public function articleVotedUsers(){
        return $this->hasMany(ArticleVotedUsers::class);
    }

    public function article(){
        return $this->hasMany(Article::class);
    }

    public function project(){
        return $this->hasMany(Project::class);
    }

    public function commentArticle(){
        return $this->hasMany(CommentArticle::class);
    }
    public function commentProject(){
        return $this->hasMany(CommentProject::class);
    }

    public function moderator(){
        return $this->hasMany(Moderator::class);
    }

    public function likeCommentArticle(){
        
        return $this->belongsToMany(CommentArticle::class, 'user_like_comment_article')->withTimestamps();
    }

    public function likeCommentProject(){
        
        return $this->belongsToMany(CommentProject::class, 'user_like_comment_project')->withTimestamps();
    }
    

    //return array of works ids
    public function ratedWorks(){
        return $this->ratings()->pluck('work_id')->toArray();
    }    

    public function getIsAdminAttribute()
    {
        return true;
    }

}