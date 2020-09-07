<?php

namespace App\Http\Middleware;

use App\Models\HostDetail;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckHostDetail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        if (Auth::check()) {
            $user = Auth::user();
            $hostDetails = HostDetail::where('user_id', $user->id)->count();
            if ($hostDetails > config('constance.const.zero')) {
                return $next($request);
            } else {
                alert()->error(trans('contents.common.error'),trans('contents.common.alert.message.host_detail'));

                return redirect()->route('host.getDetail');
            }
        } else {
            return redirect()->route('host.getLogin');
        }
    }
}
