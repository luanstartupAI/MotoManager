<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()["cache"]->forget("spatie.permission.cache");

        // Create permissions
        // Dashboard
        Permission::firstOrCreate(["name" => "view_dashboard"]);

        // Users
        Permission::firstOrCreate(["name" => "manage_users"]);

        // Customers
        Permission::firstOrCreate(["name" => "view_customers"]);
        Permission::firstOrCreate(["name" => "create_customers"]);
        Permission::firstOrCreate(["name" => "edit_customers"]);
        Permission::firstOrCreate(["name" => "delete_customers"]);

        // Motorcycles
        Permission::firstOrCreate(["name" => "view_motorcycles"]);
        Permission::firstOrCreate(["name" => "create_motorcycles"]);
        Permission::firstOrCreate(["name" => "edit_motorcycles"]);
        Permission::firstOrCreate(["name" => "delete_motorcycles"]);

        // Leads
        Permission::firstOrCreate(["name" => "view_leads"]);
        Permission::firstOrCreate(["name" => "create_leads"]);
        Permission::firstOrCreate(["name" => "edit_leads"]);
        Permission::firstOrCreate(["name" => "delete_leads"]);

        // Sales
        Permission::firstOrCreate(["name" => "view_sales"]);
        Permission::firstOrCreate(["name" => "create_sales"]);
        Permission::firstOrCreate(["name" => "edit_sales"]);
        Permission::firstOrCreate(["name" => "delete_sales"]);

        // Appraisals
        Permission::firstOrCreate(["name" => "view_appraisals"]);
        Permission::firstOrCreate(["name" => "create_appraisals"]);
        Permission::firstOrCreate(["name" => "edit_appraisals"]);
        Permission::firstOrCreate(["name" => "delete_appraisals"]);

        // Appraisal Items
        Permission::firstOrCreate(["name" => "view_appraisal_items"]);
        Permission::firstOrCreate(["name" => "create_appraisal_items"]);
        Permission::firstOrCreate(["name" => "edit_appraisal_items"]);
        Permission::firstOrCreate(["name" => "delete_appraisal_items"]);

        // Interactions
        Permission::firstOrCreate(["name" => "view_interactions"]);
        Permission::firstOrCreate(["name" => "create_interactions"]);
        Permission::firstOrCreate(["name" => "edit_interactions"]);
        Permission::firstOrCreate(["name" => "delete_interactions"]);

        // Lead Origins
        Permission::firstOrCreate(["name" => "view_lead_origins"]);
        Permission::firstOrCreate(["name" => "create_lead_origins"]);
        Permission::firstOrCreate(["name" => "edit_lead_origins"]);
        Permission::firstOrCreate(["name" => "delete_lead_origins"]);

        // Create roles and assign existing permissions
        $adminRole = Role::firstOrCreate(["name" => "admin"]);
        $adminRole->givePermissionTo(Permission::all());

        $gerenteRole = Role::firstOrCreate(["name" => "gerente"]);
        $gerenteRole->givePermissionTo([
            "view_dashboard",
            "view_customers", "create_customers", "edit_customers",
            "view_motorcycles", "create_motorcycles", "edit_motorcycles",
            "view_leads", "create_leads", "edit_leads",
            "view_sales", "create_sales", "edit_sales",
            "view_appraisals", "create_appraisals", "edit_appraisals",
            "view_appraisal_items", "create_appraisal_items", "edit_appraisal_items",
            "view_interactions", "create_interactions", "edit_interactions",
            "view_lead_origins",
        ]);

        $vendedorRole = Role::firstOrCreate(["name" => "vendedor"]);
        $vendedorRole->givePermissionTo([
            "view_dashboard",
            "view_customers", "create_customers", "edit_customers",
            "view_motorcycles",
            "view_leads", "create_leads", "edit_leads",
            "view_sales", "create_sales", "edit_sales",
            "view_interactions", "create_interactions", "edit_interactions",
        ]);

        $oficinaRole = Role::firstOrCreate(["name" => "oficina"]);
        $oficinaRole->givePermissionTo([
            "view_motorcycles", "edit_motorcycles",
            "view_appraisals", "edit_appraisals",
            "view_appraisal_items", "create_appraisal_items", "edit_appraisal_items",
        ]);

        // Assign roles to users
        $adminUser = User::where("email", "admin@motomanager.com")->first();
        if ($adminUser) {
            $adminUser->assignRole("admin");
        }

        $gerenteUser = User::where("email", "gerente@motomanager.com")->first();
        if ($gerenteUser) {
            $gerenteUser->assignRole("gerente");
        }

        $vendedorUser = User::where("email", "vendedor@motomanager.com")->first();
        if ($vendedorUser) {
            $vendedorUser->assignRole("vendedor");
        }

        $oficinaUser = User::where("email", "oficina@motomanager.com")->first();
        if ($oficinaUser) {
            $oficinaUser->assignRole("oficina");
        }
    }
}


