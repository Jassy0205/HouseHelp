<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Application;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Application::unguard(); 
        
        Application::create([
            'description' => 'Quisiera colocar camaras de vigilancia en mi apartamento',
            'client' => '2'
        ]);

        Application::create([
            'description' => 'Me gustaría instalar paneles solares en mi hogar',
            'client' => '2'
        ]);

        Application::reguard();
    }
}
