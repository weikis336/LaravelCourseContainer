<?php

namespace App\Models\SQL\Metrics\Usage;

use Illuminate\Database\Eloquent\Model;

class Servers extends Model
{
    protected $fillable = [
        'machine_id',
        'server_name',
        'server_serial',
        'server_distro',
        'server_platform',
        'server_architecture',
        'server_release',
        'cpu_brand',
        'cpu_cores',
        'cpu_threads',
        'cpu_frequency',
        'memory_size',
        'disk_type',
        'disk_bus',
        'disk_size',
        'disk_name',
        'disk_vendor',
    ];

    public function resources()
    {
        return $this->hasMany(Resources::class);
    }

    public function networks()
    {
        return $this->hasMany(Network::class);
    }

    public function interfacesTraffics()
    {
        return $this->hasMany(InterfacesTraffics::class);
    }
}
