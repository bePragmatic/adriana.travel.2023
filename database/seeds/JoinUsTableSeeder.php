<?php

use Illuminate\Database\Seeder;

class JoinUsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('join_us')->delete();

        DB::table('join_us')->insert([
            ['name' => 'facebook', 'value' => 'https://www.facebook.com/adriana'],

        ]);
    }
}
