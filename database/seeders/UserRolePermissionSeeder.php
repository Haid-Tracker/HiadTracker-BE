<?php

namespace  Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        Permission::create(['name' => 'view role']);
        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'update role']);
        Permission::create(['name' => 'delete role']);

        Permission::create(['name' => 'view permission']);
        Permission::create(['name' => 'create permission']);
        Permission::create(['name' => 'update permission']);
        Permission::create(['name' => 'delete permission']);

        Permission::create(['name' => 'view user']);
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'delete user']);

        // Create Roles
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Lets give all permission to super-admin role.
        $allPermissionNames = Permission::pluck('name')->toArray();

        $superAdminRole->givePermissionTo($allPermissionNames);

        // Let's give few permissions to admin role.
        $adminRole->givePermissionTo(['create role', 'view role', 'update role']);
        $adminRole->givePermissionTo(['create permission', 'view permission']);
        $adminRole->givePermissionTo(['create user', 'view user', 'update user']);

        // Let's Create User and assign Role to it.
        $superAdminUser = User::firstOrCreate([
                    'email' => 'superadmin@gmail.com',
                ], [
                    'id' => Str::uuid()->toString(),
                    'name' => 'Super Admin',
                    'email' => 'superadmin@gmail.com',
                    'password' => Hash::make ('12345678'),
                    'email_verified_at' => now(),
                ]);

        $superAdminUser->assignRole($superAdminRole);


        $adminUser = User::firstOrCreate([
                            'email' => 'admin@gmail.com'
                        ], [
                            'id' => Str::uuid()->toString(),
                            'name' => 'Admin',
                            'email' => 'admin@gmail.com',
                            'password' => Hash::make ('12345678'),
                            'email_verified_at' => now(),
                        ]);

        $adminUser->assignRole($adminRole);


        $user = User::firstOrCreate([
                            'email' => 'user@gmail.com',
                        ], [
                            'id' => Str::uuid()->toString(),
                            'name' => 'user',
                            'email' => 'user@gmail.com',
                            'password' => Hash::make('12345678'),
                            'email_verified_at' => now(),
                        ]);

        $user->assignRole($userRole);

        $user2 = User::firstOrCreate([
                            'email' => 'user2@gmail.com',
                        ], [
                            'id' => Str::uuid()->toString(),
                            'name' => 'user2',
                            'email' => 'user2@gmail.com',
                            'password' => Hash::make('12345678'),
                            'email_verified_at' => now(),
                        ]);

        $user2->assignRole($userRole);
    }
}
