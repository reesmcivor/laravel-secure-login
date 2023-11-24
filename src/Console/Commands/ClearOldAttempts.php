<?php

namespace ReesMcIvor\SecureLogin\Console\Commands;

use Google\Service\ManagedServiceforMicrosoftActiveDirectoryConsumerAPI\Trust;
use Illuminate\Console\Command;
use Carbon\Carbon;
use ReesMcIvor\SecureLogin\Models\TrustedDevice;

// Replace with your actual model

class ClearOldAttempts extends Command
{
    protected $signature = 'securelogin:clear-old-attempts';
    protected $description = 'Clear old, non-verified login attempts';

    public function handle()
    {
        $threshold = Carbon::now()->subDays(1);
        $count = TrustedDevice::where('created_at', '<', $threshold)->whereNull('verified_at')->delete();
        $this->info("Cleared $count old, non-verified login attempts.");
    }
}
