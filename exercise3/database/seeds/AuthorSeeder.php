<?php

use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('authors')->insert([
        'lname' => 'Антонов',
        'fname' => 'Андрей',
        'user_id' => 1,
      ]);

      DB::table('authors')->insert([
        'lname' => 'Случайный',
        'fname' => 'Пользователь',
        'user_id' => 2,
      ]);

      DB::table('authors')->insert([
        'lname' => 'Главный',
        'fname' => 'Админ',
        'user_id' => 3
      ]);
    }
}
