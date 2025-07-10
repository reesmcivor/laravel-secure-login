<?php

namespace ReesMcIvor\SecureLogin\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ReesMcIvor\SecureLogin\Database\Factories\SecureLoginFactory;
use ReesMcIvor\Labels\Traits\HasLabels;

class TrustedDevice extends Model
{
    protected $fillable = ['user_id', 'ip_address', 'user_agent', 'attempts'];

    protected $dates = ['verified_at', 'notified_at'];

    protected $casts = [
        'notified_at' => 'datetime',
        'verified_at' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
