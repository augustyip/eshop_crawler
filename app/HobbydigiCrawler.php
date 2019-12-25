<?php

namespace App;

use Spatie\Crawler\Crawler;
use App\CrawlObserver\HobbydigiCrawlObserver;
use App\CrawlProfile\HobbydigiCrawlProfile;

class HobbydigiCrawler {

    private $start_url = 'https://www.hobbydigi.com/zh_hant_hk/model-car/brands/tomica';
    public function __invoke() {

        $user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36';
        Crawler::create()
            ->setUserAgent($user_agent)
            ->setCrawlObserver(new HobbydigiCrawlObserver)
            ->setCrawlProfile(new HobbydigiCrawlProfile($this->start_url))
            ->setMaximumCrawlCount(100)
            ->startCrawling($this->start_url);
    }
}


