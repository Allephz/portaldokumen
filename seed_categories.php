<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$categories = [
    [
        'name' => 'Folder Manual',
        'slug' => 'folder-manual',
        'description' => 'Dokumen manual dan panduan',
        'icon' => 'bi-folder-fill',
        'order' => 1
    ],
    [
        'name' => 'SOP',
        'slug' => 'sop',
        'description' => 'Standard Operating Procedure',
        'icon' => 'bi-file-earmark-check',
        'order' => 2
    ],
    [
        'name' => 'Instruksi Kerja',
        'slug' => 'instruksi-kerja',
        'description' => 'Instruksi kerja detail',
        'icon' => 'bi-list-task',
        'order' => 3
    ],
    [
        'name' => 'Catatan / Rekaman',
        'slug' => 'catatan-rekaman',
        'description' => 'Catatan dan rekaman meeting',
        'icon' => 'bi-camera-video',
        'order' => 4
    ]
];

foreach ($categories as $cat) {
    \App\Models\FileCategory::firstOrCreate(
        ['slug' => $cat['slug']],
        $cat
    );
}

echo "✓ File categories created successfully!\n";
