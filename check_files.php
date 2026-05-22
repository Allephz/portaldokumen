<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$files = \App\Models\DepartmentFile::all();
foreach($files as $file) {
    echo 'ID: ' . $file->id . ' | Name: ' . $file->file_name . ' | Path: ' . $file->file_path . ' | Type: ' . $file->file_type . PHP_EOL;
}
