<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use App\Events\ServerStatsReceived;

class RedisSubscriber extends Command
{
    protected $signature = 'redis:subscribe';
    protected $description = 'Subscribe to Redis channels';

    public function handle(): void
    {
        $this->line('Subscriber started, connecting...');

        Redis::connection('subscriber')->subscribe(['ServerStats'], function ($message) {
            $this->line('Message received: ' . substr($message, 0, 50));

            try {
                $usage = json_decode($message);

                if (!$usage) {
                    $this->warn('Invalid JSON');
                    return;
                }

                event(new ServerStatsReceived($usage));

                $this->line('[' . now() . '] Event dispatched for: ' . ($usage->server->name ?? 'unknown'));

            } catch (\Throwable $e) {
                $this->error('Exception: ' . $e->getMessage());
            }
        });
    }
}
