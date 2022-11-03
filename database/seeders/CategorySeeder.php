<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;


class CategorySeeder extends Seeder
{
    public function run()
    {
        $names_en = [
            "Arts",
            "Entertainment",
            "Music",
            "Science",
            "Sports",
            "Technology",
        ];
        $names_ar = ["فن",
            "تسلية",
            "موسيقى",
            "علوم",
            "رياضة",
            "تقنية",
        ];

        $icons = [
            env('APP_URL') . "/images/nfts/cat1.png",
            env('APP_URL') . "/images/nfts/cat2.png",
            env('APP_URL') . "/images/nfts/cat3.png",
            env('APP_URL') . "/images/nfts/cat4.png",
            env('APP_URL') . "/images/nfts/cat5.png",
            env('APP_URL') . "/images/nfts/cat6.png"
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
