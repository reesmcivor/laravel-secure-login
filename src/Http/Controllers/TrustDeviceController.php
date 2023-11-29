<?php

namespace ReesMcIvor\SecureLogin\Http\Controllers;

use App\Http\Controllers\Controller;
use ReesMcIvor\SecureLogin\Models\TrustedDevice;
use ReesMcIvor\SecureLogin\Models\TrustedIp;

class TrustDeviceController extends Controller
{

    public function trust( $trustedDevice, $whitelistIp )
    {
        $trustedDevice = TrustedDevice::findOrFail($trustedDevice);
        $trustedDevice->verified_at = now();
        $trustedDevice->save();

        if($whitelistIp) {
            $trustedIp = TrustedIp::where('ip_address', $trustedDevice->ip_address)->get()->first();
            $trustedIp->verified_at = now();
            $trustedIp->save();
        }

        return response()->json([sprintf("Verified IP vs User Agent %s %s", $trustedDevice->ip_address, $whitelistIp ? "Whitelisted IP" : "Whitelist IP + User Agent" )] );
    }

    public function unrecognised()
    {
        return view('secure-login::unrecognised');
    }
}
