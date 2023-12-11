<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::unguard(); 
        
        Location::create([
            'city' => 'Manizales',
            'department' => 'Caldas',
            'address' => 'Calle 25 #11-02',
            'neighborhood' => 'San jorge',
            'specifications' => 'apt. 101',
        ]);

        Location::create([
            'city' => 'Manizales',
            'department' => 'Caldas',
            'address' => 'Calle 32 #25A-02',
            'neighborhood' => 'Palermo',
            'specifications' => 'Casa verde de dos pisos',
        ]);

        Location::create([
            'city' => 'Medellin',
            'department' => 'Antioquia',
            'address' => 'Carrera 30B #9-11',
            'neighborhood' => 'Buenos aires',
            'specifications' => 'apt. 303, frente a la escuela',
        ]);

        Location::create([
            'city' => 'Medellin',
            'department' => 'Antioquia',
            'address' => 'Carrera 31A #9-11',
            'neighborhood' => 'Suba',
            'specifications' => 'local 303',
        ]);

        Location::create([
            'city' => 'Manizales',
            'department' => 'Caldas',
            'address' => 'Carrera 11 #26-7',
            'neighborhood' => 'Suba',
            'specifications' => 'local 101, primer piso del centro comercial',
        ]);

        Location::create([
            'city' => 'Manizales',
            'department' => 'Caldas',
            'address' => 'Carrera 56C #39-45',
            'neighborhood' => 'La sultana',
            'specifications' => 'local 205, segundo piso al lado de suspiros',
        ]);

        Location::reguard();
    }
}
