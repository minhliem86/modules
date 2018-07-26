<?php

namespace App\Modules\Admin\Middlewares;

use Closure;
use Auth;

class CheckIsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function __construct()
    {
        $this->auth = Auth::guard();
    }

    public function handle($request, Closure $next)
    {
        if(!$this->auth->check()){
            return redirect()->url('/admin/login');
        }else if (!$this->auth->user()->hasRole('admin')){
            return redirect()->back()->with('error','You do not admin role');
        }else{
            return $next($request);
        }

    }
}
