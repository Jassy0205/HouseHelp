<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::unguard(); 
        
        Customer::create([
            'name' => 'Jassy Melissa',
            'lastname' => 'Perea Mosquera',
            'phone' => 3123015393,
            'email' => 'jassym.peream@gmail.com',
            'age' => 20,
            'gender' => 'F',
            'verification' => '1',
            'password' => 'hola123',
            'home' => '1'
        ]);

        Customer::create([
            'name' => 'Juan Manuel',
            'lastname' => 'Cabrera Montes',
            'phone' => 3103015393,
            'email' => 'juanm.cabreram@gmail.com',
            'age' => 25,
            'gender' => 'M',
            'verification' => '0',
            'password' => 'hola123',
            'home' => '1'
        ]);

        Customer::create([
            'name' => 'Carlos',
            'lastname' => 'Marin Ortiz',
            'phone' => 3113015393,
            'email' => 'carlos.marino@gmail.com',
            'age' => 31,
            'gender' => 'M',
            'verification' => '1',
            'password' => 'hola123',
            'home' => '3'
        ]);

        Customer::reguard();
    }
}
