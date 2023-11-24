<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SupplierApplication;

class SupplierApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SupplierApplication::unguard(); 
        
        SupplierApplication::create([
            'status' => 'rechazada',
            'publishing' => '1',
            'provider' => '1',
        ]);

        SupplierApplication::create([
            'status' => 'aceptada',
            'publishing' => '2',
            'provider' => '1',
        ]);

        SupplierApplication::create([
            'publishing' => '3',
            'provider' => '1',
        ]);

        SupplierApplication::create([
            'status' => 'aceptada',
            'publishing' => '1',
            'provider' => '2',
        ]);

        SupplierApplication::reguard();
    }
}
