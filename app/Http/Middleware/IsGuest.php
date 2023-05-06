<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class IsGuest
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
                if($data)
                {
                    if($data->role == '1')
                    {
                        return redirect()->route('admin.dashboard.index');
                    }elseif($data->role == '2')
                    {
                        return redirect()->route('kasir.dashboard.index');
                    }
                }
            }
        }

        return $next($request);
    }
}
