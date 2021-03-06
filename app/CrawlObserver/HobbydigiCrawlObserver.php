<?php

namespace App\CrawlObserver;
use Psr\Http\Message\UriInterface;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Spatie\Crawler\CrawlObserver;
use PHPHtmlParser\Dom;
use App\Item;


class HobbydigiCrawlObserver extends CrawlObserver {
    private $shop_id = 5;

    /**
     * Called when the crawler will crawl the url.
     *
     * @param \Psr\Http\Message\UriInterface $url
     */
    public function willCrawl(UriInterface $url)
    {

    }

    /**
     * Called when the crawler has crawled the given url successfully.
     *
     * @param \Psr\Http\Message\UriInterface $url
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Psr\Http\Message\UriInterface|null $foundOnUrl
     */
    public function crawled(
        UriInterface $url,
        ResponseInterface $response,
        ?UriInterface $foundOnUrl = null
    ) {
        $dom = new Dom;
        $dom->loadStr((string) $response->getBody(), []);
        $product_items = $dom->find('li.product-item');
        foreach($product_items as $el) {

            $link_el = $el->find('a.product-item-link')[0];
            $name = trim($link_el->text);
            $link = $link_el->getAttribute('href');
            $parsed_url = parse_url($link);
            $path = $parsed_url['path'];

            $id_el =  $el->find('div.price-final_price')[0];

            if (empty($id_el)) {
                continue;
            }
            $id = $id_el->getAttribute('data-product-id');
            $price_el = $el->find('#product-price-' . $id)[0];
            if (empty($price_el)) {
                continue;
            }
            $price = $price_el->getAttribute('data-price-amount');

            $hash = md5($path);

            $item = Item::firstOrCreate([
                'shop_id' => $this->shop_id,
                'hash' => $hash
            ]);

            if ($item->price != $price) {
                $item->name = $name;
                $item->path = $path;
                $item->original = $item->price ?? $price;
                $item->price = $price;
                $item->discount = round($item->price / $item->original, 2);
                $item->save();
            }
        }
    }

    /**
     * Called when the crawler had a problem crawling the given url.
     *
     * @param \Psr\Http\Message\UriInterface $url
     * @param \GuzzleHttp\Exception\RequestException $requestException
     * @param \Psr\Http\Message\UriInterface|null $foundOnUrl
     */
    public function crawlFailed(
        UriInterface $url,
        RequestException $requestException,
        ?UriInterface $foundOnUrl = null
    ) {

    }

    /**
     * Called when the crawl has ended.
     */
    public function finishedCrawling() {
        logger('finishedCrawling shop ' . $this->shop_id);
    }

}