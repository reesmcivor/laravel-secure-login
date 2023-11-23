<?php

namespace ReesMcIvor\SecureLogin\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use ReesMcIvor\SecureLogin\Models\TrustedDevice;

class TrustedDeviceFactory extends Factory
{

    protected $model = TrustedDevice::class;

    public function definition() : array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'ip_address' => $this->faker->ipv4,
            'user_agent' => $this->faker->userAgent,
        ];
    }
}
