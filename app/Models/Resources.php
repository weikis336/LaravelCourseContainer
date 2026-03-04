<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resources extends Model
{
    protected $fillable = [
        'server_id',
        'cpu_percentage',
        'cpu_load',
        'cpu_temp',
        'memory_percentage',
        'disk_used',
        'network_in',
        'network_out',
        'timestamp',
    ];

    public function server()
    {
        return $this->belongsTo(Servers::class);
    }
}
