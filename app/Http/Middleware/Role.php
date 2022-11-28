<?php

namespace App\Http\Middleware;

use Closure;

class Role
{

    protected $hierarchy = [
        'moderador'     => 4,
        'admin'         => 3,
        'action_admin'  => 2,
        'general'       => 1
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {

        $user = auth()->user();

        if ($this->hierarchy[$user->role] < $this->hierarchy[$role]){
            abort(404);
        }

        return $next($request);
    }
}
