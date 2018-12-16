<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = new Role();
        $role_admin->name = "admin";
        $role_admin->description = "Full access";
        $role_admin->save();
        
        $role_support = new Role();
        $role_support->name = "support";
        $role_support->description = "Limited access";
        $role_support->save();
                
    }
}
