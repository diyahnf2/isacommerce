<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UserTableSeeder');
        $this->call('AccessTokensTableSeeder');
        $this->call('AuthCodesTableSeeder');
        $this->call('ClientsTableSeeder');
        $this->call('GrantsTableSeeder');
        $this->call('OAuth2DatabaseSeeder');
        $this->call('RefreshTokensTableSeeder');
        $this->call('ScopesTableSeeder');
        $this->call('SessionsTableSeeder');
    }
}
