<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view_tickets',
            'create_tickets',
            'update_tickets',
            'delete_tickets',
            'assign_tickets',
            'change_ticket_status',
            'view_all_tickets',
            'manage_users',
            'manage_categories',
            'view_analytics',
            'export_reports',
            'manage_settings',
            'send_internal_notes',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles with permissions
        $masyarakat = Role::create(['name' => UserRole::MASYARAKAT->value]);
        $masyarakat->givePermissionTo(['view_tickets', 'create_tickets']);

        $admin = Role::create(['name' => UserRole::ADMIN->value]);
        $admin->givePermissionTo([
            'view_tickets', 'create_tickets', 'update_tickets',
            'assign_tickets', 'change_ticket_status', 'view_all_tickets',
            'view_analytics', 'export_reports', 'send_internal_notes',
        ]);

        $superAdmin = Role::create(['name' => UserRole::SUPER_ADMIN->value]);
        $superAdmin->givePermissionTo(Permission::all());
    }
}
