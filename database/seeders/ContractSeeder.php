<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contract;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contract::unguard(); 
        
        Contract::create([
            'description' => 'Diseño y construcción de cocina integral',
            'price' => 1625300,
            'provider' => "1",
            'client' => '3',
        ]);

        Contract::reguard();
    }
}
