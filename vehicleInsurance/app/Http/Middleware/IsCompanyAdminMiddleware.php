<?php

namespace App\Http\Middleware;

use Closure;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth   ;
use Symfony\Component\HttpFoundation\Response;

class IsCompanyAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || !in_array($user->user_level, [1, 2])) {
            abort(403, 'غير مصرح لك بالدخول إلى هذه الصفحة.');
        }
    
        return $next($request);
    }
}
