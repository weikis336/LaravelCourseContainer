<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resources extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'server_id',
        'cpu_percentage',
        'cpu_load',
        'cpu_temp',
        'memory_percentage',
        'memory_used',
        'memory_free',
        'memory_total',
        'swap_used',
        'swap_free',
        'swap_total',
        'recorded_at',
    ];

    public function server()
    {
        return $this->belongsTo(Servers::class);
    }
}
