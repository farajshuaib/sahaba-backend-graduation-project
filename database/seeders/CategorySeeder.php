<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;


class CategorySeeder extends Seeder
{
    public function run()
    {
        $names_en = ["Arts", "Entertainment", "Music", "News", "Science", "Sports", "Technology",];
        $names_ar = ["فن", "تسلية", "موسيقى", "أخبار", "علوم", "رياضة", "تقنية",];

        $icons = [
            "http://127.0.0.1:8000/images/nfts/cat1.png",
            "http://127.0.0.1:8000/images/nfts/cat2.png",
            "http://127.0.0.1:8000/images/nfts/cat3.png",
            "http://127.0.0.1:8000/images/nfts/cat4.png",
            "http://127.0.0.1:8000/images/nfts/cat5.png",
            "http://127.0.0.1:8000/images/nfts/cat5.png",
            "http://127.0.0.1:8000/images/nfts/cat6.png"
        ];

        for ($index = 0; $index <= count($icons) - 1; $index += 1) {
            $category = Category::create([
                'name_en' => $names_en[$index],
                'name_ar' => $names_ar[$index],
            ]);
            $category->addMediaFromUrl($icons[$index])->toMediaCollection('category_icon');
        }


    }
}
