<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount',
        'video_cost',
        'total_earn',
        'min_withdrawal',
        'expires_on',
        'user_id',
    ];
}
