<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class ServerStatsReceived
{
    use Dispatchable;

    public function __construct(
        public object $usage
    ) {
    }
}