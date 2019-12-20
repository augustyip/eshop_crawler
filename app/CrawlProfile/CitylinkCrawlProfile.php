<?php

namespace App\CrawlProfile;

use Spatie\Crawler\CrawlSubdomains;
use Psr\Http\Message\UriInterface;

class CitylinkCrawlProfile extends CrawlSubdomains
{
    /**
     * Determine if the given url should be crawled.
     *
     * @param \Psr\Http\Message\UriInterface $url
     *
     * @return bool
     */
    public function shouldCrawl(UriInterface $url): bool {
        $current_path = $url->getPath();
        $sub_domain = $this->isSubdomainOfHost($url);
        $paths = [
            '/locale/zh-CHT/itemtable.aspx',
            '/categoryofcorp.aspx',
        ];

        $flag = in_array($current_path, $paths);

        if (!$flag) {
            $prefix_path = '/locale/zh-CHT/category/';
            $flag = (substr($current_path, 0, strlen($prefix_path)) == $prefix_path);
        }

        return $sub_domain && $flag;
    }
}