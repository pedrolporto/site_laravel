<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComentariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('comentarios')->insert([
            'produto_id' => 1,
            'usuario' => 'Pedro DEV 1',
            'comentario' => 'Comentario 1',
            'created_at' => date("Y/m/d h:i:s"),
            'updated_at' => date("Y/m/d h:i:s"),
        ]);

        DB::table('comentarios')->insert([
            'produto_id' => 1,
            'usuario' => 'Pedro DEV 2',
            'comentario' => 'Comentario 2',
            'created_at' => date("Y/m/d h:i:s"),
            'updated_at' => date("Y/m/d h:i:s"),
        ]);

        DB::table('comentarios')->insert([
            'produto_id' => 1,
            'usuario' => 'Pedro DEV 3',
            'comentario' => 'Comentario 3',
            'created_at' => date("Y/m/d h:i:s"),
            'updated_at' => date("Y/m/d h:i:s"),
        ]);

        DB::table('comentarios')->insert([
            'produto_id' => 1,
            'usuario' => 'Pedro DEV 4',
            'comentario' => 'Comentario 1',
            'created_at' => date("Y/m/d h:i:s"),
            'updated_at' => date("Y/m/d h:i:s"),
        ]);

        DB::table('comentarios')->insert([
            'produto_id' => 1,
            'usuario' => 'Pedro DEV 5',
            'comentario' => 'Comentario 5',
            'created_at' => date("Y/m/d h:i:s"),
            'updated_at' => date("Y/m/d h:i:s"),
        ]);
    }
}
