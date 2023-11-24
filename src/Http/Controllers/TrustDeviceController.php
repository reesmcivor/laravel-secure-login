<?php

namespace ReesMcIvor\SecureLogin\Http\Controllers;

use App\Http\Controllers\Controller;
use ReesMcIvor\SecureLogin\Models\TrustedDevice;

class TrustDeviceController extends Controller
{

    public function trust( $trustedDevice )
    {
        $trustedDevice = TrustedDevice::findOrFail($trustedDevice);
        $trustedDevice->verified_at = now();
        $trustedDevice->save();
        return response()->json([sprintf("Verified %s", $trustedDevice->ip_address )] );
    }

}
