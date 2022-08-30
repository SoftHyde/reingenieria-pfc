<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Poll;

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
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        
        $gate->define('admin',function($user){
            if (auth()->check()){
                return $user->role == 'admin';
            }
            else {
                return false;
            }
        });

        $gate->define('admin_action',function($user, $admin_id){
            if (auth()->check()){
                return $user->id == $admin_id or $user->role == 'admin';
            }
            else {
                return false;
            }
        });

        $gate->define('edit_proposal',function($user, $proposal){
            if (auth()->check()){
                return ($user->id == $proposal->user_id) or ($user->id == $proposal->action->admin_id) or ($user->role == 'admin');
            }
            else {
                return false;
            }
        });

        $gate->define('edit_comment',function($user, $comment){
            if (auth()->check()){
                return ($user->id == $comment->user_id) or ($user->id == $comment->proposal->action->admin_id) or ($user->role == 'admin');
            }
            else {
                return false;
            }
        });

        $gate->define('vote',function($user, $poll_id){
            $poll = Poll::findOrFail($poll_id);
            if (auth()->check()){
                return !in_array($poll_id, $user->polls()) and $poll->opened();
            }
            else {
                return false;
            }
        });

        $gate->define('support_proposal',function($user, $supporters){
            if (auth()->check()){
                return !in_array($user->id, $supporters->lists('user_id')->toArray());
            }
            else {
                return false;
            }
        });

        $gate->define('like_comment',function($user, $comment){
            if (auth()->check()){
                return !in_array($user->id, $comment->likers()->lists('user_id')->toArray());
            }
            else {
                return false;
            }
        });

        $gate->define('rate',function($user, $work_id){
            if (auth()->check()){
                return !in_array($work_id, $user->ratedWorks());
            }
            else {
                return false;
            }
        });

        $gate->define('config_profile',function($user, $profile_id){
            if (auth()->check()){
                return ($user->id == $profile_id) or ($user->role == 'admin');
            }
            else {
                return false;
            }
        });

        $gate->define('edit_profile',function($user, $profile_id){
            if (auth()->check()){
                return ($user->id == $profile_id);
            }
            else {
                return false;
            }
        });

    }
}
