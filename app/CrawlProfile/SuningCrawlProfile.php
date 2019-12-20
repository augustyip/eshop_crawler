<?php

namespace App\CrawlProfile;

use Spatie\Crawler\CrawlSubdomains;
use Psr\Http\Message\UriInterface;

class SuningCrawlProfile extends CrawlSubdomains
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
            '/search/list',
            '/search/result',
        ];

        $current_path = $url->getPath();
        return $sub_domain && in_array($current_path, $paths);
    }
}
