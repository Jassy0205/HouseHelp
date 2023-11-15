<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Message::unguard(); 
        
        Message::create([
            'content' => 'Buenos días, la licuadora no me enciende. Me gustaría contratar un servicio de revisión',
            'by' => '1',
            'provider' => '2',
            'client' => '1',
        ]);

        Message::create([
            'content' => 'Buenos dias. No hay problema',
            'by' => '2',
            'provider' => '2',
            'client' => '1',
        ]);

        Message::create([
            'content' => '¿Le parece bien el martes a las 2:00 pm?',
            'Enviado por' => '2',
            'provider' => '2',
            'client' => '1',
        ]);

        Message::create([
            'content' => 'Si, claro',
            'Enviado por' => '1',
            'provider' => '2',
            'client' => '1',
        ]);

        Message::create([
            'content' => 'Ok, entonces el martes a las 2:00 pm irá el técnico Raúl',
            'by' => '2',
            'provider' => '2',
            'client' => '1',
        ]);

        Message::create([
            'content' => 'Muchas gracias',
            'by' => '1',
            'provider' => '2',
            'client' => '1',
        ]);

        Message::reguard();
    }
}
