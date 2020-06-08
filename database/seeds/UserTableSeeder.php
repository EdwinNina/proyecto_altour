<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'altourSysAdmin',
            'email' => 'sysAdmin.altour@gmail.com',
            'password' => Hash::make('mcedwin123'),
            'role_id' => 1
        ]);
    }
}
