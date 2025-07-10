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
use ReesMcIvor\SecureLogin\Models\TrustedIp;
use ReesMcIvor\SecureLogin\Notifications\UnrecognisedLoginNotification;

class UnrecognisedLoginCheckMiddleware
{

    public function handle($request, Closure $next)
    {
        if (!$this->isRecognised($request))
        {

            $trustedDevice = $this->getTrustedDevice($request);
            $trustedIpAddress = $this->getTrustedIp($request);

            $isPast30Mins = \Carbon\Carbon::parse($trustedDevice?->notified_at)?->addMinutes(30)?->isPast() ?? false;
            if(!$trustedDevice->notified_at || $isPast30Mins) {
                $notificationUsers = User::whereIn('email', config('secure-login.notification_emails'))->get();
                $notificationUsers->each(fn($user) => $user->notify(new UnrecognisedLoginNotification($trustedDevice)));
                $trustedDevice->notified_at = now();
                $trustedDevice->save();

                $trustedIpAddress->notified_at = now();
                $trustedIpAddress->save();
            }

            return redirect()->route('secure-login.unrecognised')->with('warning', 'This login attempt is not recognised. Please verify your identity.');
        }
        return $next($request);
    }

    private function isRecognised($request)
    {
        $userId = Auth::id();
        $ipAddress = $request->ip();
        $userAgent = $request->header('User-Agent');

        if (in_array($request->ip(), $this->getWhiteListedIps())) {
            return true;
        }

        return TrustedDevice::where('user_id', $userId)
                ->where('ip_address', $ipAddress)
                ->where('user_agent', $userAgent)
                ->whereNotNull('verified_at')
                ->exists() || TrustedIp::where('ip_address', $ipAddress)->whereNotNull('verified_at')->exists();
    }

    /**
     * @param $request
     * @return TrustedDevice
     */
    protected function getTrustedDevice($request) : TrustedDevice
    {
        $trustedDevice = TrustedDevice::firstOrCreate([
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);

        $trustedDevice->attempts++;
        $trustedDevice->save();

        return $trustedDevice;
    }

    /**
     * @param $request
     * @return TrsutedIp
     */
    protected function getTrustedIp($request) : TrustedIp
    {
        $trustedIp = TrustedIp::firstOrCreate([
            'ip_address' => $request->ip(),
        ], [
            'user_id' => auth()->id() ?? null,
        ]);

        $trustedIp->attempts = $trustedIp->attempts + 1;
        $trustedIp->save();
        return $trustedIp;
    }

    protected function getWhiteListedIps() : array
    {
        return TrustedIp::whereNotNull('verified_at')->pluck('ip_address')->toArray();
    }
}
