<?php

use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->truncate();
        factory(\App\User::class)->create(['id' => 1, 'job' => 'admin', 'username' => 'admin', 'password' => 'admin']);
        factory(\App\User::class)->create(['id' => 2, 'job' => 'manager', 'username' => 'manager', 'password' => 'manager', 'active' => 1, 'work_hours' => 0]);
        factory(\App\User::class, 20)->create(['job' => 'manager']);
    }
}
