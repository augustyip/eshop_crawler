<?php

namespace App\CrawlProfile;

use Spatie\Crawler\CrawlInternalUrls;
use Psr\Http\Message\UriInterface;
use Illuminate\Support\Str;

class HgcCrawlProfile extends CrawlInternalUrls
{
    /**
     * Determine if the given url should be crawled.
     *
     * @param \Psr\Http\Message\UriInterface $url
     *
     * @return bool
     */
    public function shouldCrawl(UriInterface $url): bool {

        $internal = $this->baseUrl->getHost() === $url->getHost();

        $current_path = $url->getPath();

        $filtered = Str::startsWith($current_path, '/tc/');

        return $internal && $filtered;
    }
}