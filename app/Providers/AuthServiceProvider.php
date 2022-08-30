<?php

namespace App\Providers;


use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Poll;
//use Illuminate\Support\Facades\auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        
        Gate::define('admin',function($user){
            if (auth()->check()){
                return $user->role == 'admin';
            }
            else {
                return false;
            }
        });

        Gate::define('admin_action',function($user, $admin_id){
            if (auth()->check()){
                return $user->id == $admin_id or $user->role == 'admin';
            }
            else {
                return false;
            }
        });

        Gate::define('edit_proposal',function($user, $proposal){
            if (auth()->check()){
                return ($user->id == $proposal->user_id) or ($user->id == $proposal->action->admin_id) or ($user->role == 'admin');
            }
            else {
                return false;
            }
        });

        Gate::define('edit_comment',function($user, $comment){
            if (auth()->check()){
                return ($user->id == $comment->user_id) or ($user->id == $comment->proposal->action->admin_id) or ($user->role == 'admin');
            }
            else {
                return false;
            }
        });

        Gate::define('vote',function($user, $poll_id){
            $poll = Poll::findOrFail($poll_id);
            if (auth()->check()){
                return !in_array($poll_id, $user->polls()) and $poll->opened();
            }
            else {
                return false;
            }
        });

        Gate::define('support_proposal',function($user, $supporters){
            if (auth()->check()){
                return !in_array($user->id, $supporters->pluck('user_id')->toArray());
            }
            else {
                return false;
            }
        });

        Gate::define('like_comment',function($user, $comment){
            if (auth()->check()){
                return !in_array($user->id, $comment->likers()->pluck('user_id')->toArray());
            }
            else {
                return false;
            }
        });

        Gate::define('rate',function($user, $work_id){
            if (auth()->check()){
                return !in_array($work_id, $user->ratedWorks());
            }
            else {
                return false;
            }
        });

        Gate::define('config_profile',function($user, $profile_id){
            if (auth()->check()){
                return ($user->id == $profile_id) or ($user->role == 'admin');
            }
            else {
                return false;
            }
        });

        Gate::define('edit_profile',function($user, $profile_id){
            if (auth()->check()){
                return ($user->id == $profile_id);
            }
            else {
                return false;
            }
        });

    }
}
