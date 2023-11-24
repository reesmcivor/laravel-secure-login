<?php

namespace ReesMcIvor\SecureLogin\Http\Middleware;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\UnrecognizedLoginAttempt;
use Illuminate\Support\Facades\Auth;
use ReesMcIvor\SecureLogin\Models\TrustedDevice;
use ReesMcIvor\SecureLogin\Notifications\UnrecognisedLoginNotification;

class UnrecognisedLoginCheckMiddleware
{

    public function handle($request, Closure $next)
    {

        if (!$this->isRecognized($request))
        {
            $trustedDevice = TrustedDevice::firstOrCreate([
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent')
            ], [
                'user_id' => Auth::id() ?? null,
            ]);

            $trustedDevice->attempts = $trustedDevice->attempts + 1;
            $trustedDevice->save();

            if(!$trustedDevice->notified_at || $trustedDevice->notified_at->addMinutes(30)->isPast()) {
                $notificationUsers = User::whereIn('email', config('secure-login.notification_emails'))->get();
                $notificationUsers->each(fn($user) => $user->notify(new UnrecognisedLoginNotification($trustedDevice)));
                $trustedDevice->notified_at = now();
                $trustedDevice->save();
            }

            return redirect('/');
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
            ->whereNotNull('verified_at')
            ->exists();
    }
}
