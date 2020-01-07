<?php

namespace App;

use Spatie\Crawler\Crawler;
use App\CrawlObserver\HgcCrawlObserver;
use App\CrawlProfile\HgcCrawlProfile;

class HgcCrawler {

    private $start_url = 'https://www.hgcmore.com/tc/electrical-appliances';
    public function __invoke() {

        $user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36';
        Crawler::create()
            ->setUserAgent($user_agent)
            ->setCrawlObserver(new HgcCrawlObserver)
            ->setCrawlProfile(new HgcCrawlProfile($this->start_url))
            // ->setMaximumCrawlCount(1)
            ->startCrawling($this->start_url);
    }
}


