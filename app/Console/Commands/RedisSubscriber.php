<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use App\Models\Resources;
use App\Models\Servers;
use App\Models\Network;
use App\Models\InterfacesTraffics;

class RedisSubscriber extends Command
{
    protected $signature   = 'redis:subscribe';
    protected $description = 'Subscribe to Redis channels';

    public function handle()
{   
    $this->line('Subscriber started, connecting...');

    Redis::connection('subscriber')->subscribe(['ServerStats'], function ($message) {
        $this->line('Message received: ' . substr($message, 0, 50));

        try {
            $usage = json_decode($message);

            if (!$usage) {
                $this->warn('Invalid JSON, skipping.');
                return;
            }

            $server = Servers::updateOrCreate(
                ['machine_id' => $usage->nodeid],
                [
                    'server_name'         => $usage->server->name,
                    'server_serial'       => $usage->server->serial ?? null,
                    'server_distro'       => $usage->server->distro ?? null,
                    'server_platform'     => $usage->server->platform ?? null,
                    'server_architecture' => $usage->server->arch ?? null,
                    'server_release'      => $usage->server->release ?? null,
                    'cpu_brand'           => $usage->cpu->cpu_brand ?? null,
                    'cpu_cores'           => $usage->cpu->cpu_cores ?? null,
                    'cpu_threads'         => $usage->cpu->cpu_threads ?? null,
                    'cpu_frequency'       => $usage->cpu->cpu_frequency ?? null,
                    'memory_size'         => $usage->memory->memory_size ?? null,
                    'disk_type'           => json_encode($usage->disk->disk_type ?? []),
                    'disk_bus'            => json_encode($usage->disk->disk_bus ?? []),
                    'disk_size'           => json_encode($usage->disk->disk_size ?? []),
                    'disk_name'           => json_encode($usage->disk->disk_name ?? []),
                    'disk_vendor'         => json_encode($usage->disk->disk_vendor ?? []),
                ]
            );

            Resources::create([
                'server_id'         => $server->id,
                'cpu_percentage'    => $usage->cpu->cpu_percentage ?? null,
                'cpu_load'          => $usage->cpu->cpu_load ?? null,
                'cpu_temp'          => $usage->cpu->cpu_temp ?? null,
                'memory_used'       => $usage->memory->memory_used ?? null,
                'memory_free'       => $usage->memory->memory_free ?? null,
                'memory_percentage' => $usage->memory->memory_percentage ?? null,
                'memory_total'      => $usage->memory->memory_size ?? null,
                'swap_used'         => $usage->memory->memory_swap_used ?? null,
                'swap_free'         => $usage->memory->memory_swap_free ?? null,
                'swap_total'        => $usage->memory->memory_swap_total ?? null,
                'recorded_at'       => now(),
            ]);

            $interfaces = (array) ($usage->network->network_interface ?? []);
            foreach ($interfaces as $ifaceName => $iface) {
                Network::updateOrCreate(
                    ['server_id' => $server->id, 'network_address' => $ifaceName],
                    [
                        'ip_address'  => $iface->ipv4 ?? null,
                        'mac_address' => $iface->mac  ?? null,
                        'iface_type'  => $iface->ifaceType ?? null,
                        'recorded_at'   => now(),
                    ]
                );
            }

            $networkUsage = (array) ($usage->network->network_usage ?? []);
            foreach ($networkUsage as $ifaceName => $stats) {
                if (is_null($stats->up ?? null) && is_null($stats->down ?? null)) {
                    continue;
                }
                InterfacesTraffics::create([
                    'server_id'     => $server->id,
                    'interface'     => $ifaceName,
                    'network_in'    => $stats->down ?? null,
                    'network_out'   => $stats->up   ?? null,
                    'network_total' => ($stats->up ?? 0) + ($stats->down ?? 0),
                    'recorded_at'     => now(),
                ]);
            }

            $this->line('[' . now() . '] Saved stats for: ' . $usage->server->name);

        } catch (\Throwable $e) {
            $this->error('Exception: ' . $e->getMessage());
            $this->error($e->getTraceAsString());
        }
    });
}

}
