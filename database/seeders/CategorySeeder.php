<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;


class CategorySeeder extends Seeder
{
    public function run()
    {
        $names = ["Arts", "Music", "News", "Science", "Sports", "Technology",];
        $icons = [
            "http://127.0.0.1:8000/images/nfts/cat1.png",
            "http://127.0.0.1:8000/images/nfts/cat2.png",
            "http://127.0.0.1:8000/images/nfts/cat3.png",
            "http://127.0.0.1:8000/images/nfts/cat4.png",
            "http://127.0.0.1:8000/images/nfts/cat5.png",
            "http://127.0.0.1:8000/images/nfts/cat6.png"
        ];

        $index = 0;
        foreach ($names as $value) {
            $category = Category::create([
                'name' => $value
            ]);
            $category->addMediaFromUrl($icons[$index])->toMediaCollection('category_icon');
            $index++;
        }


    }
}
