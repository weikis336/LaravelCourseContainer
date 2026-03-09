<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FetchSourceforgeStats extends Command
{
    protected $signature = 'sf:fetch-stats
                            {project : Nombre corto del proyecto en SF}
                            {--days=30 : Días hacia atrás a consultar}';
    protected $description = 'Fetches download stats from SourceForge API and persists them';

    public function handle(): int
    {
        $project  = $this->argument('project');
        $end      = now()->toDateString();
        $start    = now()->subDays((int) $this->option('days'))->toDateString();

        $url  = "https://sourceforge.net/projects/{$project}/files/stats/json"
              . "?start_date={$start}&end_date={$end}";

        $response = Http::timeout(15)->get($url);

        if ($response->failed()) {
            $this->error("SourceForge API error: {$response->status()}");
            return self::FAILURE;
        }

        $data = $response->json();

        foreach ($data['downloads'] as [$date, $count]) {
            SfDownloadDaily::updateOrCreate(
                ['project' => $project, 'stat_date' => $date],
                ['downloads' => $count]
            );
        }

        foreach ($data['countries'] as $code => $count) {
            SfDownloadByCountry::updateOrCreate(
                ['project' => $project, 'period_start' => $start,
                 'period_end' => $end, 'country_code' => $code],
                ['downloads' => $count]
            );
        }

        foreach ($data['oses'] as $os => $count) {
            SfDownloadByOs::updateOrCreate(
                ['project' => $project, 'period_start' => $start,
                 'period_end' => $end, 'os_name' => $os],
                ['downloads' => $count]
            );
        }

        $this->info("Stats synced: {$data['total']} total downloads.");
        return self::SUCCESS;
    }
}

