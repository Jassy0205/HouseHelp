<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::unguard(); 
        
        Supplier::create([
            'name' => 'Construcciones S.A',
            'owner' => 'Sebastian Alvarez',
            'phone' => "3153015393",
            'description' => 'Somos una empresa lider en consrucción y planificación de espacios',
            'email' => 'construcciones_sa@gmail.com',
            'password' => 'hola123',
            'company' => '4'
        ]);

        Supplier::create([
            'name' => 'InElectric',
            'owner' => 'Maria Castro',
            'phone' => "3163015393",
            'description' => 'Expertos en instalación y repación de redes o dispositivos eléctrica',
            'email' => 'in_electric@gmail.com',
            'password' => 'hola123',
            'company' => '5'
        ]);

        Supplier::reguard();
    }
}
