<?php

use Illuminate\Database\Seeder;

class ModifyRoleTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('roles')->insert([
            [
                'name' => 'owner',
                'display_name' => 'owner_user',
                'description' => 'crm_owner_user'
            ]
        ]);
    }

}
