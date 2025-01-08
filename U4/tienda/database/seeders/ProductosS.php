<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosS extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('productos')->insert([
            'nombre'=>'Ratón inalámbrico',
            'precio'=>10.20,
            'stock'=>30,
            'imagen'=>'1.png'
        ]);
        DB::table('productos')->insert([
            'nombre'=>'Módulo RAM 32GB',
            'precio'=>100.40,
            'stock'=>10,
            'imagen'=>'2.png'
        ]);
        DB::table('productos')->insert([
            'nombre'=>'Disco duro SSD 2TB',
            'precio'=>80.54,
            'stock'=>4,
            'imagen'=>'3.png'
        ]);
    }
}
