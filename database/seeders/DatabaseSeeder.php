<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use \App\Models\User;
use \App\Models\Employee;
use \App\Models\Client;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'create invoice']);
        Permission::create(['name' => 'edit invoice']);
        Permission::create(['name' => 'delete invoice']);
        Permission::create(['name' => 'view all invoice']);
        Permission::create(['name' => 'view single invoice']);
        Permission::create(['name' => 'edit clients']);
        Permission::create(['name' => 'delete clients']);
        Permission::create(['name' => 'view all clients']);

        // create roles and assign existing permissions
        $role_employee = Role::create(['name' => 'user']);
        $role_employee->givePermissionTo('view single invoice');
        $role_employee->givePermissionTo('view all invoice');
        $role_employee->givePermissionTo('edit invoice');
        $role_employee->givePermissionTo('delete invoice');
        $role_employee->givePermissionTo('view all clients');
        $role_employee->givePermissionTo('edit clients');
        $role_employee->givePermissionTo('delete clients');

        $role_customer = Role::create(['name' => 'customer']);
        $role_customer->givePermissionTo('create invoice');
        $role_customer->givePermissionTo('view all invoice');
        $role_customer->givePermissionTo('view single invoice');

        $role_super_admin = Role::create(['name' => 'Super-Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider
        // create demo customer
        $user = User::factory()->create([
            'name' => 'Example User',
            'email' => 'test@example.com',
        ]);
        Client::create([
            'phone' => '00258775758',
            'address' => 'giza ,cairo',
            'user_id' => $user->id,
        ]);
        $user->assignRole($role_customer);
       // create demo employee  
        $user = User::factory()->create([
            'name' => 'Example Admin User',
            'email' => 'admin@example.com',
        ]);
        Employee::create([
            'phone' => '00258775758',
            'user_id' => $user->id,
        ]);
        $user->assignRole($role_employee);
       // create demo Super Admin
        $user = User::factory()->create([
            'name' => 'Example Super-Admin User',
            'email' => 'superadmin@example.com',
        ]);
        $user->assignRole($role_super_admin);
    }
}
