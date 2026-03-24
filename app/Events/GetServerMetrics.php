<?php

namespace App\Events;

use App\Models\SQL\Metrics\Usage\Resources;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GetServerMetrics implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Resources $resources)
    {
    }

    public function broadcastOn(): array
    {
        return [new Channel('server-metrics')];
    }

    public function broadcastAs(): string
    {
        return 'server.metrics.update';
    }

    public function broadcastWith(): array
    {
        return [
            'resources' => [
                'cpu_percentage' => $this->resources->cpu_percentage,
                'cpu_load' => $this->resources->cpu_load,
                'cpu_temp' => $this->resources->cpu_temp,
                'memory_percentage' => $this->resources->memory_percentage,
                'memory_used' => $this->resources->memory_used,
                'memory_free' => $this->resources->memory_free,
                'memory_total' => $this->resources->memory_total,
                'swap_used' => $this->resources->swap_used,
                'swap_free' => $this->resources->swap_free,
                'swap_total' => $this->resources->swap_total,
                'recorded_at' => $this->resources->recorded_at,
            ],
        ];
    }

    // Opcional, si quieres cambiar el nombre del evento en JS:
    // public function broadcastAs(): string
    // {
    //     return 'server.metrics.update';
    // }
}
