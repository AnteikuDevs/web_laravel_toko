<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class IsKasir
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->cookie('uid');
        if(!empty($token))
        {
            $user = PersonalAccessToken::findToken($token);
            if($user)
            {
                $data = User::find($user->tokenable_id);
                if($data && $data->role == '2')
                {
                    Auth::login($data);
                    return $next($request);
                }
            }
        }
        return redirect('logout');
    }
}
