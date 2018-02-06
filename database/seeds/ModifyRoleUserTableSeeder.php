<?php

use Illuminate\Database\Seeder;

class ModifyRoleUserTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('role_user')->insert([
            [
                'user_id' => (int) '3',
                'role_id' => (int) '1'
            ],
            [
                'user_id' => (int) '4',
                'role_id' => (int) '2'
            ],
            [
                'user_id' => (int) '5',
                'role_id' => (int) '6'
            ],
            [
                'user_id' => (int) '6',
                'role_id' => (int) '5'
            ],
            [
                'user_id' => (int) '7',
                'role_id' => (int) '3'
            ],
            [
                'user_id' => (int) '8',
                'role_id' => (int) '4'
            ],
            
        ]);
    }

}
