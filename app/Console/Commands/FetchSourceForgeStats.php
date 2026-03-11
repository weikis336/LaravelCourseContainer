<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use DateTime;
use App\Models\SourceForgeEditions;
use App\Models\SourceForgePlatforms;
use App\Models\SourceForgeCountries;
use App\Models\SourceForgeDownloads;

class FetchSourceForgeStats extends Command
{
    protected $signature = 'sf:fetch-stats {project}';
    protected $description = 'Fetches download stats from SourceForge API and persists them';
    protected $project;
    


    public function handle()
    {
        $project = $this->argument('project');
        $this->getHistoricalStats($project);
        // $project = $this->argument('project');
        // $editions = $this->getEditions($project);
        // foreach ($editions as $edition) {
        //     $end = date('Y-m-d');
        //     $url = "https://sourceforge.net/projects/{$project}/files/{$edition['name']}/stats/json?start_date={$edition['pubDate']}&end_date={$end}&period=daily";
        //     $stats = $this->getStats($url);
        //     echo $edition['name'] . ": " . json_encode($stats, JSON_PRETTY_PRINT) . "\n";
        // }
    }
    public function getEditions($project)
    {
        $rssurl = "https://sourceforge.net/projects/{$project}/rss?path=/";
        $rss = $this->getRSS($rssurl);

        $editions = [];

        foreach ($rss->channel->item as $item) {
            $title = (string)$item->title;
            $crudDate = (string)$item->pubDate;
            $date = str_replace(' UT', ' UTC', $crudDate);
            $date = new DateTime($date);
            $pubDate = $date->format('Y-m-d');

            if (preg_match('#^/([^/]+)/#', $title, $m)) {
                $name = $m[1];
                if (!isset($editions[$name])) {
                    $editions[$name] = [
                        'name'    => $name,
                        'pubDate' => $pubDate,
                    ];
                }
            }
        }
        foreach ($editions as $edition) {
            echo $edition['name'] . "\n";
            echo $edition['pubDate'] . "\n";
        }
        return array_values($editions); 
    }
    public function getRSS($rssurl)
    {
        $response = Http::get($rssurl);
        return simplexml_load_string($response->body());
    }

    public function getStats($url)
    {
        $response = Http::get($url);
        return $response->json();
    }
    public function getHistoricalStats($project)
    {
        $editions = $this->getEditions($project);
        foreach ($editions as $edition) {
            $start = new DateTime($edition['pubDate']);
            $end   = new DateTime(date('Y-m-d'));
            
            for ($i = clone $start; $i <= $end; $i->modify('+1 day')) {
                $dateStr = $i->format('Y-m-d');
                $url = "https://sourceforge.net/projects/{$project}/files/{$edition['name']}/stats/json?start_date={$dateStr}&end_date={$dateStr}&period=daily";
                $stats = $this->getStats($url);
                $this->feedDB($edition['name'], $stats, $project, $dateStr);
            }
        }
    }

    public function feedDB($edition, $stats, $project, $date)
    {
        $parts = explode('-', $edition);
        $codename = strtolower($parts[count($parts) - 1]);
        $version = $parts[count($parts) - 2];

        $editionDB = SourceForgeEditions::updateOrCreate(
            ['name' => $edition, 'project' => $project],
            [
                'code_name'    => $codename,
                'version'      => $version,
                'release_date' => $date,
            ]
        );

        foreach ($stats['oses_by_country'] as $country => $osCounts) {
            $countryDB  = SourceForgeCountries::updateOrCreate(['name' => $country]);
            foreach ($osCounts as $osName => $count) {
                $platformDB = SourceForgePlatforms::updateOrCreate(['name' => $osName]);
                SourceForgeDownloads::updateOrCreate(
                    [
                        'edition_id'  => $editionDB->id,
                        'platform_id' => $platformDB->id,
                        'country_id'  => $countryDB->id,
                        'date'        => $date,
                    ],
                    ['downloads' => $count]
                );
            }
        }
    }

}

