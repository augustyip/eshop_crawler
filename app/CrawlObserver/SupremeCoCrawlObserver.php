<?php

namespace App\CrawlObserver;
use Psr\Http\Message\UriInterface;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Spatie\Crawler\CrawlObserver;
use PHPHtmlParser\Dom;
use App\Item;


class SupremeCoCrawlObserver extends CrawlObserver {
    private $shop_id = 1;

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
        $product_items = $dom->find('div.ProductList-content div.product-item');
        foreach($product_items as $item) {
            $title_el = $item->find('div.title')[0];
            $name = !empty($title_el) ? $title_el->text : NULL;
            $price_el = $item->find('div.price')[0];
            $price = !empty($price_el) ? $price_el->text : NULL;
            if (!empty($price)) {
                $item_url = $item->find('a.Product-item')[0]->getAttribute('href');

                $price = preg_replace( '/[^.\d]/', '', $price);
                $parsed_url = parse_url($item_url);
                $path = $parsed_url['path'];

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