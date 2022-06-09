<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$admin = DB::table('users')->where('is_admin', 1)->first();
        if(!$admin) {
            DB::table('users')->insert(['name' => 'Miheretab Alemu', 'email' => 'mihrtab@gmail.com', 'password' => Hash::make('123456'), 'is_admin' => true]);
            $admin = DB::table('users')->where('email', 'mihrtab@gmail.com')->first();
            if($admin) {
                DB::table('users')->where('email', 'mihrtab@gmail.com')->update(['is_admin' => true]);
            }
		}
    }
}
