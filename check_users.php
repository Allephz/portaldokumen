<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$users = \App\Models\User::all();
echo "Total users: " . count($users) . "\n";
foreach($users as $u) {
    echo $u->email . ' (role: ' . $u->role . ")\n";
}

echo "\n--- Checking password for admin@portal.com ---\n";
$admin = \App\Models\User::where('email', 'admin@portal.com')->first();
if ($admin) {
    echo "Found! Name: " . $admin->name . "\n";
    echo "Role: " . $admin->role . "\n";
    echo "Testing password 'admin123': " . (password_verify('admin123', $admin->password) ? 'OK' : 'FAILED') . "\n";
} else {
    echo "NOT FOUND! Need to create...\n";
}
