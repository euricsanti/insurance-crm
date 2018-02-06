<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('users')->insert([
            [
                'name' => 'CelesteMultimedia',
                'email' => 'celestemultimedia@gmail.com',
                'password' => Hash::make('CelesteOpenSource123'),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
                'updated_at' => date("Y-m-d H:i:s")
            ]
        ]);
    }

}
