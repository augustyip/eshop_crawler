<?php

namespace App;

use Spatie\Crawler\Crawler;
use App\CrawlObserver\SupremeCoCrawlObserver;
use App\CrawlProfile\SupremeCoCrawlProfile;

class SupremeCoCrawler {

    private $start_url = 'https://shop.supremeco.com.hk/categories/outerwear';
    public function __invoke() {

        $user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36';
        Crawler::create()
            ->setUserAgent($user_agent)
            ->setCrawlObserver(new SupremeCoCrawlObserver)
            ->setCrawlProfile(new SupremeCoCrawlProfile($this->start_url))
            ->setMaximumCrawlCount(1)
            ->startCrawling($this->start_url);
    }
}


