<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::unguard(); 

        User::create([
            'identification_card' => '162655545',
            'name' => 'Jassy Melissa',
            'lastname' => 'Perea Mosquera',
            'phone' => "3123015393",
            'email' => 'jassym.peream@gmail.com',
            'age' => 20,
            'gender' => 'F',
            'type' => 'cliente',
            'password' => 'hola123',
        ]);

        User::create([
            'identification_card' => '13255154',
            'name' => 'Juan Manuel',
            'lastname' => 'Cabrera Montes',
            'phone' => "3103015393",
            'email' => 'juanm.cabreram@gmail.com',
            'age' => 25,
            'gender' => 'M',
            'type' => 'cliente',
            'password' => 'hola123',
        ]);

        User::create([
            'identification_card' => '11515545',
            'name' => 'Carlos',
            'lastname' => 'Marin Ortiz',
            'phone' => "3113015393",
            'email' => 'carlos.marino@gmail.com',
            'age' => 31,
            'gender' => 'M',
            'type' => 'cliente',
            'password' => 'hola123',
        ]);

        User::reguard();
    }
}
