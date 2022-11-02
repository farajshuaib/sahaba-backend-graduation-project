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
            env('APP_URL') . "/images/nfts/1.png",
            env('APP_URL') . "/images/nfts/2.png",
            env('APP_URL') . "/images/nfts/3.png",
            env('APP_URL') . "/images/nfts/4.png",
            env('APP_URL') . "/images/nfts/5.png",
            env('APP_URL') . "/images/nfts/6.png",
            env('APP_URL') . "/images/nfts/7.png",
            env('APP_URL') . "/images/nfts/8.png",
            env('APP_URL') . "/images/nfts/9.png",
            env('APP_URL') . "/images/nfts/10.png",
            env('APP_URL') . "/images/nfts/11.png",
            env('APP_URL') . "/images/nfts/12.png",
            env('APP_URL') . "/images/nfts/13.png",
            env('APP_URL') . "/images/nfts/14.png",
            env('APP_URL') . "/images/nfts/15.png",
            env('APP_URL') . "/images/nfts/16.png",
        ];


        foreach ($collections as $collection) {
            $collection->addMediaFromUrl($images[round(count($images) - 1)])->toMediaCollection('collection_logo_image');
        }
    }
}
