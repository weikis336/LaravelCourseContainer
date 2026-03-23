<?php

// namespace App\Listeners;

// use App\Events\GetMetrics;
// use Illuminate\Contracts\Queue\ShouldQueue;

// class ProcessCourseSitemap implements ShouldQueue
// {
//     public $queue = 'default';

//     public function __construct(protected GetMetrics $sitemapService)
//     {
//     }

//     public function handle(GetMetrics $event)
//     {
//         foreach ($event->course->locale as $language => $fields) {
//             $slugs = ['title' => \Str::slug($fields['title'])];
//             $this->sitemapService->updateOrCreateSlug('courses', $event->course->id, $language, 'course', $slugs);
//         }
//     }
// }