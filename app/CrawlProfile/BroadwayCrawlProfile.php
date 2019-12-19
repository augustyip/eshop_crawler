<?php

namespace App\CrawlProfile;

use Spatie\Crawler\CrawlSubdomains;
use Psr\Http\Message\UriInterface;

class BroadwayCrawlProfile extends CrawlSubdomains
{
    /**
     * Determine if the given url should be crawled.
     *
     * @param \Psr\Http\Message\UriInterface $url
     *
     * @return bool
     */
    public function shouldCrawl(UriInterface $url): bool {

        $sub_domain = $this->isSubdomainOfHost($url);

        $paths = [
            '/categories/usage/',
        ];

        $substr = substr($url->getPath(), 0, 18);
        $filtered = in_array($substr, $paths);
        return $sub_domain && $filtered;
    }
}