<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;

echo "Checking Admin User...\n\n";

$admin = User::where('email', 'admin@sama3.com')->first();

if (!$admin) {
    echo "❌ Admin user not found!\n";
    exit;
}

echo "✅ Admin User Found: {$admin->name} (ID: {$admin->id})\n";
echo "Email: {$admin->email}\n\n";

echo "Current Roles: ";
$roles = $admin->getRoleNames();
if ($roles->isEmpty()) {
    echo "❌ NO ROLES ASSIGNED!\n";
} else {
    echo $roles->implode(', ') . "\n";
}

echo "\nPermissions Count: " . $admin->getAllPermissions()->count() . "\n";

// Check if Admin role exists
$adminRole = Role::where('name', 'Admin')->first();
if (!$adminRole) {
    echo "\n❌ Admin role doesn't exist!\n";
} else {
    echo "\n✅ Admin Role exists with " . $adminRole->permissions->count() . " permissions\n";
}

// Fix if needed
if ($roles->isEmpty() || !$roles->contains('Admin')) {
    echo "\n🔧 Fixing: Assigning Admin role...\n";
    $admin->syncRoles(['Admin']);
    echo "✅ Admin role assigned!\n";
    
    // Clear cache
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    echo "✅ Permission cache cleared!\n";
}

echo "\n--- DONE ---\n";
