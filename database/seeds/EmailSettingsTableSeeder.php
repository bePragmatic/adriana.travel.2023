<?php

use Illuminate\Database\Seeder;

class EmailSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('email_settings')->delete();

        DB::table('email_settings')->insert([
            ['name' => 'driver', 'value' => 'smtp'],
            ['name' => 'host', 'value' => 'smtp.gmail.com'],
            ['name' => 'port', 'value' => '25'],
            ['name' => 'from_address', 'value' => 'support@tempusmeida.hr'],
            ['name' => 'from_name', 'value' => 'Adriana'],
            ['name' => 'encryption', 'value' => 'tls'],
            ['name' => 'username', 'value' => 'support@gmail.com'],
            ['name' => 'password', 'value' => 'hismljhblilxdusd'],
            ['name' => 'domain', 'value' => 's.mailgun.org'],
            ['name' => 'secret', 'value' => 'key-s'],
        ]);
    }
}
