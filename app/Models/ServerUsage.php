<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerUsage extends Model
{
    protected $fillable = [
        'cpu_percentage',
        'memory_percentage',
        'disk_percentage',
        'network_in',
        'network_out',
        'timestamp',
    ];
}
