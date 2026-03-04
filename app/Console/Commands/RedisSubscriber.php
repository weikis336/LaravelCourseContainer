<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use App\Models\Resources;
use App\Models\Servers;

class RedisSubscriber extends Command
{
    protected $signature   = 'redis:subscribe';
    protected $description = 'Subscribe to Redis channels';

    public function handle()
    {
        Redis::subscribe(['ServerStats'], function ($message) {
            $usage = json_decode($message);

            if (!$usage) {
                $this->warn('Invalid JSON, skipping.');
                return;
            }

            // Upsert server — only creates once, updates if hardware info changes
            $server = Servers::updateOrCreate(
                [
                    'machine_id' => $usage->node_id,   // match condition
                ],
                [
                    'server_name'               => $usage->server->name,
                    'server_distro'             => $usage->server->distro,
                    'cpu_brand'                 => $usage->cpu->cpu_brand,
                    'cpu_cores'                 => $usage->cpu->cpu_cores,
                    'cpu_threads'               => $usage->cpu->cpu_threads,
                    'cpu_frequency'             => $usage->cpu->cpu_frequency,
                    'memory_size'               => $usage->memory->memory_size,
                    'disk_size'                 => $usage->disk->disk_size,
                    'network_address'           => $usage->network->network_address,
                    'ip_address'                => $usage->ip_address ?? null,
                ]
            );

            // Insert a new resource snapshot linked to the server
            Resources::create([
                'server_id'          => $server->id,
                'cpu_percentage'     => $usage->cpu->cpu_percentage,
                'cpu_load'           => $usage->cpu->cpu_load,
                'cpu_temp'           => $usage->cpu->cpu_temp,
                'memory_percentage'  => $usage->memory->memory_percentage,
                'disk_used'          => $usage->disk->disk_percentage,
                'network_in'         => $usage->network->network_in,
                'network_out'        => $usage->network->network_out,
                'network_total'      => $usage->network->network_total,
                'timestamp'          => now(),
            ]);

            $this->line('[' . now() . '] Saved stats for: ' . $usage->server_name);
        });
    }
}
