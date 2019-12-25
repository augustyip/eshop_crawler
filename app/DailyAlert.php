<?php

namespace App;

class DailyAlert {

    public function __invoke() {
        $items = Item::where('updated_at', '>', date('Y-m-d 00:00:00'))
            ->orderBy('discount')
            ->take(10)
            ->get();
        logger($items);
    }
}


