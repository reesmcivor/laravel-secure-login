<?php

use Illuminate\Support\Facades\Route;
use ReesMcIvor\SecureLogin\Http\Controllers\TrustDeviceController;

Route::get('secure-login/approve/{trustedDevice}', [TrustDeviceController::class, 'trust'])
    ->name('secure-login.approve')->middleware(['signed']);