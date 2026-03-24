<?php

namespace App\Events;

use App\Models\SQL\Metrics\Usage\Servers;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GetMetrics implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public function __construct(protected Servers $server)
    {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('server-metrics'),
        ];
    }
    public function broadcastWith(): array
    {
        return [
            'server' => [
                'name' => $this->server->name,
                'platform' => $this->server->platform,
                'ip' => $this->server->ip,
                'port' => $this->server->port,
                'status' => $this->server->status,
                'created_at' => $this->server->created_at,
                'updated_at' => $this->server->updated_at,
            ],
        ];
    }
}
