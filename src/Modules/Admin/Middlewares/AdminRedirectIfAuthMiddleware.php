<?php

namespace App\Modules\Admin\Middlewares;

use Closure;
use Auth;

class AdminRedirectIfAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function __construct(){
      $this->auth = Auth::guard('web');
    }
    public function handle($request, Closure $next)
    {
        if($this->auth->check() && $this->auth->user()->can('login')){
          return redirect('/admin/dashboard');
        }
        return $next($request);
    }
}
