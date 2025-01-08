<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicioS extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('servicios')->insert([
            'descripcion'=>'Corte caballero',
            'precio'=>7.5
        ]);
        DB::table('servicios')->insert([
            'descripcion'=>'Lavado',
            'precio'=>3
        ]);
        DB::table('servicios')->insert([
            'descripcion'=>'Corte melena corta',
            'precio'=>10
        ]);
        DB::table('servicios')->insert([
            'descripcion'=>'Degradado',
            'precio'=>8
        ]);

        
    }
}
