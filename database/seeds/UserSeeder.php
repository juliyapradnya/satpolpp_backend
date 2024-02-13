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
        DB::table('users')
                ->insert([
                    'name' => 'Lia',
                    'email' => 'lia@gmail.com',
                    'password' => '1bbd886460827015e5d605ed44252251',
                    'created_at' => 'Carbon\Carbon::now()',
                    'updated_at' => 'Carbon\Carbon::now()',
                ]);
    }
}
