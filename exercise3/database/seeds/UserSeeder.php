<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
        'name' => 'antonov.ad',
        'email' => 'an_42@mail.ru',
        'password' => 'antonov.ad',
      ]);

      DB::table('users')->insert([
        'name' => 'user',
        'email' => 'user@mail.ru',
        'password' => 'user',
      ]);

      DB::table('users')->insert([
        'name' => 'admin',
        'email' => 'admin@mail.ru',
        'password' => '123456',
      ]);
    }
}
