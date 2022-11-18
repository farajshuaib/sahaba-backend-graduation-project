<?php

namespace Database\Seeders;

use App\Models\Blockchain;
use Illuminate\Database\Seeder;

class BlockchainSeeder extends Seeder
{
    public function run()
    {
        Blockchain::create([
            'id' => 1,
            'name' => 'Ethereum Mainnet',
            'symbol' => 'ETH',
            'rpc_url' => 'https://mainnet.infura.io/v3/',
            'explorer_url' => 'https://etherscan.io/',
        ]);

        Blockchain::create([
            'id' => 5,
            'name' => 'Goerli Test Network',
            'symbol' => 'ETH',
            'rpc_url' => 'https://goerli.infura.io/v3',
            'explorer_url' => 'https://goerli.etherscan.io',
        ]);

    }
}
