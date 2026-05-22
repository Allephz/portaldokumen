<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Create manager user
$manager = \App\Models\User::firstOrCreate(
    ['email' => 'manager@portal.com'],
    [
        'name' => 'Manager Portal',
        'password' => bcrypt('manager123'),
        'role' => 'manager',
        'id_card' => 'MGR-001'
    ]
);

echo "Manager created/found: " . $manager->email . "\n";
echo "Name: " . $manager->name . "\n";
echo "Role: " . $manager->role . "\n";
echo "Password: manager123\n";
