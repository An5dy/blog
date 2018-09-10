<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        $time = Carbon::now();
        DB::table('users')->insert([
            'name' => config('api.admin.name'),
            'password' => bcrypt(config('api.admin.password')),
            'created_at' => $time,
            'updated_at' => $time,
        ]);
    }
}
