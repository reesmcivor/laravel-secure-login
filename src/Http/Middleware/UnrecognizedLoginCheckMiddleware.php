<?php

namespace ReesMcIvor\SecureLogin\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use App\Models\UnrecognizedLoginAttempt;
use Illuminate\Support\Facades\Auth;

class UnrecognizedLoginCheckMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Session::get('unrecognized_login_checked', false))
        {
            if (!$this->isRecognized($request))
            {
                UnrecognizedLoginAttempt::create([
                    'user_id' => Auth::id(),
                    'ip_address' => $request->ip(),
                    'browser_details' => $request->header('User-Agent')
                ]);

                Session::put('unrecognized_login_checked', true);
            }
        }

        return $next($request);
    }

    private function isRecognized($request)
    {
        $userId = Auth::id();
        $ipAddress = $request->ip();
        $userAgent = $request->header('User-Agent');

        return TrustedDevice::where('user_id', $userId)
            ->where('ip_address', $ipAddress)
            ->where('user_agent', $userAgent)
            ->exists();
    }
}
