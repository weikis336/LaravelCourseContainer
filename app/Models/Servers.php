<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servers extends Model
{
    protected $fillable = [
        'machine_id',
        'server_name',
        'cpu_brand',
        'cpu_cores',
        'cpu_threads',
        'cpu_frequency',
        'memory_size',
        'disk_size',
        'network_address',
        'ip_address',
    ];

    public function resources()
    {
        return $this->hasMany(Resources::class);
    }
}
