<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
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

            'salereturn.view',
            'salereturn.create',
            'salereturn.edit',
            'salereturn.delete',

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

            'pos.view',
            'pos.create',
            'pos.edit',
            'pos.delete',

            'configuration.view',
            'configuration.create',
            'configuration.edit',
            'configuration.delete',

            'accounts-receivable.view',
            'accounts-receivable.create',
            'accounts-receivable.edit',
            'accounts-receivable.delete',

            'accounts-payable.view',
            'accounts-payable.create',
            'accounts-payable.edit',
            'accounts-payable.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
