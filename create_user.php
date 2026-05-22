<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = \App\Models\User::firstOrCreate(
    ['email' => 'test@test.com'],
    [
        'name' => 'Test User',
        'password' => bcrypt('password123')
    ]
);
echo "User created/found: " . $user->email . "\n";
