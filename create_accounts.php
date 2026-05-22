<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Create Admin Account
$admin = \App\Models\User::firstOrCreate(
    ['email' => 'admin@portal.com'],
    [
        'name' => 'Admin Portal',
        'password' => bcrypt('admin123'),
        'role' => 'admin',
        'id_card' => '1234567890123456',
        'department_id' => null
    ]
);
echo "✓ Admin account created: admin@portal.com (password: admin123)\n";

// Get first department for user account
$department = \App\Models\Department::first();
if ($department) {
    $user = \App\Models\User::firstOrCreate(
        ['email' => 'user@portal.com'],
        [
            'name' => 'Regular User',
            'password' => bcrypt('user123'),
            'role' => 'user',
            'id_card' => '9876543210987654',
            'department_id' => $department->id
        ]
    );
    echo "✓ User account created: user@portal.com (password: user123)\n";
    echo "  - Department: " . $department->name . "\n";
} else {
    echo "⚠ No department found! Create a department first.\n";
}

echo "\n✓ Setup complete!\n";
