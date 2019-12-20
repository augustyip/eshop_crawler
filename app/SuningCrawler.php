<?php

namespace App;

use Spatie\Crawler\Crawler;
use App\CrawlObserver\SuningCrawlObserver;
use App\CrawlProfile\SuningCrawlProfile;

class SuningCrawler {

    private $start_url = 'https://search.hksuning.com/search/list?ci=503505';
    public function __invoke() {

        $user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36';
        Crawler::create()
            ->executeJavaScript()
            ->setUserAgent($user_agent)
            ->setCrawlObserver(new SuningCrawlObserver)
            ->setCrawlProfile(new SuningCrawlProfile($this->start_url))
            ->startCrawling($this->start_url);
    }
}


