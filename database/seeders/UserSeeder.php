<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('users')->insert([
//            [
//                'name' => 'admin',
//                'email' => 'admin@gmail.com',
//                'password' => Hash::make('123456'),
//                'created_at' => now(),
//                'updated_at' => now(),
//                'email_verified_at' => now(),
//            ],
//            [
//                'name' => 'user',
//                'email' => 'user@gmail.com',
//                'password' => Hash::make('123456'),
//                'created_at' => now(),
//                'updated_at' => now(),
//                'email_verified_at' => now(),
//            ],
//        ]);
//
//        DB::table('permissions')->insert([
//            ['name' => 'review_post'],
//            ['name' => 'update_post'],
//            ['name' => 'delete_post'],
//            ['name' => 'restore_post'],
//            ['name' => 'force_delete_post'],
//        ]);
//
//        DB::table('roles')->insert([
//            ['name' => 'admin'],
//        ]);
//        DB::table('role_user')->insert([
//            'role_id' => 1,
//            'user_id' => 1,
//        ]);
        DB::table('permission_role')->insert([
            ['permission_id' => 1, 'role_id' => 1],
            ['permission_id' => 2, 'role_id' => 1],
            ['permission_id' => 3, 'role_id' => 1],
            ['permission_id' => 4, 'role_id' => 1],
            ['permission_id' => 5, 'role_id' => 1],
        ]);
    }
}
