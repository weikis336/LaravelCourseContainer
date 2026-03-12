<?php

namespace App\Models\SQL\Metrics\Usage;

use Illuminate\Database\Eloquent\Model;

class Network extends Model
{   
    public $timestamps = false;
    protected $fillable = [
        'server_id',
        'network_address',
        'ip_address',
        'mac_address',
        'iface_type',
        'recorded_at',
    ];

    public function server()
    {
        return $this->belongsTo(Servers::class);
    }
}
