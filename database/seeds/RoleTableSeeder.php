<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'administrador',
            'description' => 'encargado del sitio'
        ]);
        DB::table('roles')->insert([
            'name' => 'organizador',
            'description' => 'encargado de realizar las actividades'
        ]);
    }
}
