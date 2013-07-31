<?php

use \Membership\User\User;

class UserTableSeeder extends \Illuminate\Database\Seeder {

    public function run()
    {
        DB::table('users')->delete();

        $user = User::create(array(
            'username' => 'kareem3d',
            'email'    => 'a.kareem_3d@yahoo.com',
            'password' => 'kareem123',
            'ip'       => '127.0.0.1',
            'type'     => User::DEVELOPER
        ));

        $user->accept();

        $this->command->info("User table seeded successfully");
    }

}