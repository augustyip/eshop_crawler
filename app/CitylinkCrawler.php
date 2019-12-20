<?php

namespace App;

use Spatie\Crawler\Crawler;
use App\CrawlObserver\CitylinkCrawlObserver;
use App\CrawlProfile\CitylinkCrawlProfile;

class CitylinkCrawler {

    // private $start_url = 'https://www.citylink.com.hk/locale/zh-CHT/itemtable.aspx?netcatid=d79e02d4-2c76-4f87-8ba3-e451192f0d7b&corpname=citylink';
    private $start_url = 'https://www.citylink.com.hk/locale/zh-CHT/category/%e6%99%ba%e8%83%bd%e6%89%8b%e5%b8%b6';
    public function __invoke() {

        $user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36';
        Crawler::create()
            ->setUserAgent($user_agent)
            ->setCrawlObserver(new CitylinkCrawlObserver)
            ->setCrawlProfile(new CitylinkCrawlProfile($this->start_url))
            // ->setMaximumCrawlCount(1)
            ->startCrawling($this->start_url);
    }
}


