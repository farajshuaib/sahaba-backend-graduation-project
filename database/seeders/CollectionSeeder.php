<?php

namespace Database\Seeders;

use App\Models\Collection;
use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{
    public function run()
    {
        $collections = Collection::factory()->count(10)->create();


        $images = [
            "http://127.0.0.1:8000/images/nfts/1.png",
            "http://127.0.0.1:8000/images/nfts/2.png",
            "http://127.0.0.1:8000/images/nfts/3.png",
            "http://127.0.0.1:8000/images/nfts/4.png",
            "http://127.0.0.1:8000/images/nfts/5.png",
            "http://127.0.0.1:8000/images/nfts/6.png",
            "http://127.0.0.1:8000/images/nfts/7.png",
            "http://127.0.0.1:8000/images/nfts/8.png",
            "http://127.0.0.1:8000/images/nfts/9.png",
            "http://127.0.0.1:8000/images/nfts/10.png",
            "http://127.0.0.1:8000/images/nfts/11.png",
            "http://127.0.0.1:8000/images/nfts/12.png",
            "http://127.0.0.1:8000/images/nfts/13.png",
            "http://127.0.0.1:8000/images/nfts/14.png",
            "http://127.0.0.1:8000/images/nfts/15.png",
            "http://127.0.0.1:8000/images/nfts/16.png",
        ];


        foreach ($collections as $collection) {
            $collection->addMediaFromUrl($images[round(count($images) - 1)])->toMediaCollection('collection_logo_image');
        }
    }
}
