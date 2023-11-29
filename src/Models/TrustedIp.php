<?php

namespace ReesMcIvor\SecureLogin\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ReesMcIvor\SecureLogin\Database\Factories\SecureLoginFactory;
use ReesMcIvor\Labels\Traits\HasLabels;

class TrustedIp extends Model
{
    protected $fillable = ['ip_address'];

    protected $dates = ['verified_at', 'notified_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
