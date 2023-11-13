<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Application::unguard(); 
        
        Application::create([
            'descripcion' => 'Quisiera colocar camaras de vigilancia en mi apartamento',
            'client' => '2'
        ]);

        Application::create([
            'descripcion' => 'Me gustaría instalar paneles solares en mi hogar',
            'client' => '2'
        ]);

        Application::reguard();
    }
}
