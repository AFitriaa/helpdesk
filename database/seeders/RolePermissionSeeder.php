<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'tickets.create','tickets.view.own','tickets.view.unit','tickets.view.all','tickets.comment',
            'tickets.assign','tickets.reassign','tickets.close','tickets.escalate','tickets.export',
            'users.manage','roles.manage','units.manage','categories.manage',
            'sla.manage','notifications.manage','reports.view.unit','reports.view.all','reports.export',
            'agents.manage','kb.manage'
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name'=>$p]);
        }

        $super = Role::firstOrCreate(['name'=>'Superadmin']);
        $super->givePermissionTo(Permission::all());

        $adminUnit = Role::firstOrCreate(['name'=>'Admin Unit']);
        $adminUnit->givePermissionTo([
            'tickets.view.unit',
            'tickets.assign',
            'tickets.reassign',
            'tickets.close',
            'tickets.export',
            'users.manage',
            'units.manage',
            'categories.manage',
            'sla.manage',
            'reports.view.unit'
        ]);

        $agent = Role::firstOrCreate(['name'=>'Agent']);
        $agent->givePermissionTo([
            'tickets.view.unit','tickets.comment','tickets.close','tickets.reassign'
        ]);

        $user = Role::firstOrCreate(['name'=>'User']);
        $user->givePermissionTo([
            'tickets.create','tickets.view.own','tickets.comment'
        ]);

        $pimpinan = Role::firstOrCreate(['name'=>'Pimpinan']);
        $pimpinan->givePermissionTo([
            'tickets.view.unit','tickets.view.all','reports.view.unit','reports.view.all','reports.export'
        ]);
    }
}
