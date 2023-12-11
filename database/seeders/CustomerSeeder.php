<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::unguard(); 

        Customer::create([
            'info_personal' => '1',
            'home' => '1',
        ]);

        Customer::create([
            'info_personal' => '2',
            'home' => '1',
            'verification' => 'verificado',
        ]);

        Customer::create([
            'info_personal' => '3',
            'home' => '3',
        ]);

        Customer::reguard();
        
    }
}
