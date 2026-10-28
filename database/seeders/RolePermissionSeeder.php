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

            'salereturn.view',
            'salereturn.create',
            'salereturn.edit',

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

            'salereturn.view',
            'salereturn.create',
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
