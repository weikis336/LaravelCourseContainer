<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
class FetchSourceforgeStats extends Command
{
    protected $signature = 'sf:fetch-stats {project}';
    protected $description = 'Fetches download stats from SourceForge API and persists them';
    protected $project;
    


    public function handle(): int
    {
        $project = $this->argument('project');
        // $url = "https://sourceforge.net/projects/{$project}/files/{$edition}/stats/json?start_date={$start}&end_date={$end}&period={$period}";
        $rssurl = "https://sourceforge.net/projects/{$project}/rss?path=/";

        $editions = $this->getEditions($project);
        return 0;
    }
    public function getEditions($project)
    {
        $rssurl = "https://sourceforge.net/projects/{$project}/rss?path=/";
        $rss = $this->getRSS($rssurl);

        $editions = [];

        foreach ($rss->channel->item as $item) {
            $title = (string)$item->title;
            $pubDate = (string)$item->pubDate;

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

    public function feedDB($project, $editions)
    {
        foreach ($editions as $edition) {
            $this->info('Fetching stats for: ' . $edition['name']);
            $this->info('PubDate: ' . $edition['pubDate']);
        }
    }



}

