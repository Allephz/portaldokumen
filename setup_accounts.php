<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Department;

try {
    // Clear existing users
    User::truncate();
    
    // Create corporate affairs department if not exists
    $dept = Department::firstOrCreate(
        ['name' => 'Corporate Affairs'],
        ['description' => 'Corporate Affairs Department']
    );
    
    // Create admin user
    $admin = User::create([
        'name' => 'Administrator',
        'email' => 'admin@portal.com',
        'password' => bcrypt('admin123'),
        'role' => 'admin',
        'department_id' => $dept->id,
        'email_verified_at' => now()
    ]);
    
    // Create regular user
    $user = User::create([
        'name' => 'Test User',
        'email' => 'user@portal.com',
        'password' => bcrypt('user123'),
        'role' => 'user',
        'department_id' => $dept->id,
        'email_verified_at' => now()
    ]);
    
    echo "✓ Admin account created: admin@portal.com (password: admin123)\n";
    echo "✓ User account created: user@portal.com (password: user123)\n";
    echo "  - Department: " . $dept->name . "\n\n";
    echo "✓ Setup complete!\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
