<?php

namespace App;

use Spatie\Crawler\Crawler;
use App\CrawlObserver\BroadwayCrawlObserver;
use App\CrawlProfile\BroadwayCrawlProfile;

class BroadwayCrawler {

    private $start_url = 'https://www.broadwaylifestyle.com/categories/usage/mobile-products/mobile-phone.html';
    public function __invoke() {

        $user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36';
        Crawler::create()
            ->setUserAgent($user_agent)
            ->setCrawlObserver(new BroadwayCrawlObserver)
            ->setCrawlProfile(new BroadwayCrawlProfile($this->start_url))
            // ->setMaximumCrawlCount(1)
            ->startCrawling($this->start_url);
    }
}


