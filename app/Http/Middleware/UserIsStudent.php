<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserIsStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if($user->role == 'student'){
            $request->request->add(['profile'=>$user->profile->load('user')]);
            return $next($request);
        }

        return response()->json([
            'message' => 'Unauthorized Role'
        ], 404);
    }
}
