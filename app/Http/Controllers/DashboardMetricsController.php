<?php

// app/Http/Controllers/DashboardMetricsController.php

namespace App\Http\Controllers;

use App\Events\GetServerMetrics;
use App\Models\SQL\Metrics\Usage\Resources;

class DashboardMetricsController extends Controller
{
    // Si quieres devolver JSON normal (sin websockets)
    public function getMetrics()
    {
        $resource = Resources::latest('recorded_at')->first();

        return response()->json([
            'resources' => $resource,
        ]);
    }

    // Si quieres disparar un broadcast
    public function broadcastMetrics()
    {
        $resource = Resources::latest('recorded_at')->first();

        broadcast(new GetServerMetrics($resource));

        return response()->json(['status' => 'ok']);
    }
}
