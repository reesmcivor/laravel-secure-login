<?php

use Illuminate\Support\Facades\Route;
use ReesMcIvor\SecureLogin\Http\Controllers\TrustDeviceController;

Route::get('secure-login/approve/{trustedDevice}/{whitelistIp}', [TrustDeviceController::class, 'trust'])
    ->name('secure-login.approve')->middleware(['signed']);

Route::get('secure-login/unrecognised', [TrustDeviceController::class, 'unrecognised'])
    ->name('secure-login.unrecognised');