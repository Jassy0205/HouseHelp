<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rating::unguard(); 
        
        Rating::create([
            'star' => '5',
            'comment' => 'Buen servicio',
            'provider' => '1',
            'client' => '3',
        ]);

        Rating::create([
            'star' => '2',
            'comment' => 'Nunca llegó el encargado',
            'provider' => '2',
            'client' => '1',
        ]);

        Rating::reguard();
    }
}
