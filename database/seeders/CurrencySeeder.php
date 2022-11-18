<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function run()
    {

        Currency::create([
            'name' => 'Tether USD',
            'symbol' => 'USDT',
            'decimals' => 6,
            'contract_address' => "0xdAC17F958D2ee523a2206206994597C13D831ec7",
            'blockchain_id' => 1,
        ]);

//        Currency::create([
//            'name' => 'Sahaba',
//            'symbol' => 'SHB',
//            'decimals' => 18,
//            'contract_address' => "",
//            'blockchain_id' => 5,
//        ]);

        Currency::create([
            'name' => 'Tether USD',
            'symbol' => 'USDT',
            'decimals' => 6,
            'contract_address' => "0xC2C527C0CACF457746Bd31B2a698Fe89de2b6d49",
            'blockchain_id' => 5,
        ]);

        Currency::create([
            'name' => 'Sahaba',
            'symbol' => 'SHB',
            'decimals' => 18,
            'contract_address' => "0x54460CC6574442b1ac12dd71C509Ac421E3Ab031",
            'blockchain_id' => 5,
        ]);

    }
}
