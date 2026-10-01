<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'dashboard.view',

            'user.view',
            'user.create',
            'user.edit',
            'user.delete',

            'role.view',
            'role.create',
            'role.edit',
            'role.delete',

            'permission.view',
            'permission.create',
            'permission.edit',
            'permission.delete',

            'product.view',
            'product.create',
            'product.edit',
            'product.delete',

            'category.view',
            'category.create',
            'category.edit',
            'category.delete',

            'customer.view',
            'customer.create',
            'customer.edit',
            'customer.delete',

            'supplier.view',
            'supplier.create',
            'supplier.edit',
            'supplier.delete',

            'shopping.view',
            'shopping.create',
            'shopping.edit',
            'shopping.delete',

            'sale.view',
            'sale.create',
            'sale.edit',
            'sale.delete',

            'sale-return.view',
            'sale-return.create',
            'sale-return.edit',
            'sale-return.delete',

            'expense.view',
            'expense.create',
            'expense.edit',
            'expense.delete',

            'inventory-adjustment.view',
            'inventory-adjustment.create',
            'inventory-adjustment.edit',
            'inventory-adjustment.delete',

            'kardex.view',

            'report.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $admin = Role::firstOrCreate([
            'name' => 'Administrador',
            'guard_name' => 'web',
        ]);

        $supervisor = Role::firstOrCreate([
            'name' => 'Supervisor',
            'guard_name' => 'web',
        ]);

        $vendedor = Role::firstOrCreate([
            'name' => 'Vendedor',
            'guard_name' => 'web',
        ]);

        $almacen = Role::firstOrCreate([
            'name' => 'Almacén',
            'guard_name' => 'web',
        ]);

        $allPermissions = Permission::all();

        $admin->syncPermissions($allPermissions);

        $supervisor->syncPermissions([
            'dashboard.view',

            'user.view',

            'role.view',

            'permission.view',

            'product.view',
            'product.create',
            'product.edit',

            'category.view',
            'category.create',
            'category.edit',

            'customer.view',
            'customer.create',
            'customer.edit',

            'supplier.view',
            'supplier.create',
            'supplier.edit',

            'shopping.view',
            'shopping.create',
            'shopping.edit',

            'sale.view',
            'sale.create',
            'sale.edit',

            'sale-return.view',
            'sale-return.create',
            'sale-return.edit',

            'expense.view',
            'expense.create',
            'expense.edit',

            'inventory-adjustment.view',
            'inventory-adjustment.create',
            'inventory-adjustment.edit',

            'kardex.view',

            'report.view',
        ]);

        $vendedor->syncPermissions([
            'dashboard.view',

            'product.view',

            'category.view',

            'customer.view',
            'customer.create',
            'customer.edit',

            'sale.view',
            'sale.create',

            'sale-return.view',
            'sale-return.create',
        ]);

        $almacen->syncPermissions([
            'dashboard.view',

            'product.view',
            'product.create',
            'product.edit',

            'category.view',
            'category.create',
            'category.edit',

            'supplier.view',
            'supplier.create',
            'supplier.edit',

            'shopping.view',
            'shopping.create',
            'shopping.edit',

            'inventory-adjustment.view',
            'inventory-adjustment.create',
            'inventory-adjustment.edit',

            'kardex.view',

            'report.view',
        ]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
