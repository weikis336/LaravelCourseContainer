<?php

namespace App\Models\SQL\Metrics\Usage;

use Illuminate\Database\Eloquent\Model;

class InterfacesTraffics extends Model
{   
    public $timestamps = false;
    protected $fillable = [
        'server_id',
        'interface',
        'network_in',
        'network_out',
        'network_total',
        'recorded_at',
    ];

    public function server()
    {
        return $this->belongsTo(Servers::class);
    }
}
