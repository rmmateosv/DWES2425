<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConciertoS extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('conciertos')->insert([
        'titulo' => 'La momia 2', 
        'fecha'=>'2025-03-04',
        'aforo'=>100, 
        'precioEntrada'=>10
       ]);
     DB::table('conciertos')->insert([
        'titulo' => 'Elena y su discurso', 
        'fecha'=>'2025-05-16',
        'aforo'=>500, 
        'precioEntrada'=>20
    ]);
    }
}
