<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use DateTime;
use App\Models\SQL\Metrics\SF\SourceForgeEditions;
use App\Models\SQL\Metrics\SF\SourceForgePlatforms;
use App\Models\SQL\Metrics\SF\SourceForgeCountries;
use App\Models\SQL\Metrics\SF\SourceForgeDownloads;

class FetchSourceForgeStats extends Command
{
    protected $signature = 'sf:fetch-stats {project : The project name} {--feed : Feed the database}';
    protected $description = 'Fetches download stats from SourceForge API and persists them';
    protected $project;

    protected $feed;

    public function handle()
    {
        $project = $this->argument('project');
        $feed = $this->option('feed');
        if ($feed) {
            $this->getHistoricalStats($project);
        }
        else {
            $editions = $this->getEditions($project);
            foreach ($editions as $edition) {
                $today = date('Y-m-d');
                $url = "https://sourceforge.net/projects/{$project}/files/{$edition['name']}/stats/json?start_date={$today}&end_date={$today}&period=daily";
                $stats = $this->getStats($url);
                $this->feedDB($edition, $stats, $project, $today);
            }
        }
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
            $startDate = new DateTime($edition['pubDate']);
            $endDate   = new DateTime(date('Y-m-d'));
            
            for ($i = clone $startDate; $i <= $endDate; $i->modify('+1 day')) {
                $dateStr = $i->format('Y-m-d');
                $url = "https://sourceforge.net/projects/{$project}/files/{$edition['name']}/stats/json?start_date={$dateStr}&end_date={$dateStr}&period=daily";
                $stats = $this->getStats($url);
                $this->feedDB($edition, $stats, $project, $dateStr);
            }
        }
    }

    public function feedDB($edition, $stats, $project, $date)
    {
        $distroname = $edition['name'];
        $parts = explode('-', $edition['name']);
        $codename = strtolower($parts[count($parts) - 1]);
        $version = $parts[count($parts) - 2];
        $strReleaseDate = new DateTime($edition['pubDate']);

        $editionDB = SourceForgeEditions::updateOrCreate(
            ['name' => $distroname, 'project' => $project],
            [
                'codename'     => $codename,
                'version'      => $version,
                'release_date' => $strReleaseDate,
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

