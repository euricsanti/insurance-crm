<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('roles')->insert([
                [
                    'name' => 'root',
                    'display_name' => 'root_user',
                    'description' => 'crm_root_user'
                ],
                [
                    'name' => 'super_user',
                    'display_name' => 'administrator',
                    'description' => 'crm_super_user'
                ],
                [
                    'name' => 'sells',
                    'display_name' => 'ventas',
                    'description' => 'crm_sells_user'
                ],
                [
                    'name' => 'collect',
                    'display_name' => 'cobros',
                    'description' => 'crm_collect_user'
                ],
                [
                    'name' => 'cashier',
                    'display_name' => 'pos',
                    'description' => 'crm_cashier_user'
                ]
        ]);
    }

}
