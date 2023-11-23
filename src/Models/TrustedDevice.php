<?php

namespace ReesMcIvor\SecureLogin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ReesMcIvor\SecureLogin\Database\Factories\SecureLoginFactory;
use ReesMcIvor\Labels\Traits\HasLabels;

class TrustedDevice extends Model
{
    protected $fillable = ['user_id', 'ip_address', 'user_agent'];
}
