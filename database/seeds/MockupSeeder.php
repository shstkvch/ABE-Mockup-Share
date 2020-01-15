<?php

use Illuminate\Database\Seeder;

class MockupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new App\User();

        $user->password = Hash::make( 'password' );
        $user->email    = 'david@abigegg.com';
        $user->name     = 'David';

        $user->save();
    }
}
