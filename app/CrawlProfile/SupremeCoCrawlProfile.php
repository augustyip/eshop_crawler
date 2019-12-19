<?php

namespace App\CrawlProfile;

use Spatie\Crawler\CrawlInternalUrls;
use Psr\Http\Message\UriInterface;

class SupremeCoCrawlProfile extends CrawlInternalUrls
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
        $paths = [
            '/categories/',
        ];

        $substr = substr($url->getPath(), 0, 12);
        $filtered = in_array($substr, $paths);
        return $internal && $filtered;
    }
}