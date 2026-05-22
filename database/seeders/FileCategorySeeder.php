<?php

namespace Database\Seeders;

use App\Models\FileCategory;
use Illuminate\Database\Seeder;

class FileCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Folder Manual',
                'slug' => 'folder-manual',
                'description' => 'Dokumen manual dan panduan operasional',
                'icon' => 'bi-book',
                'order' => 1
            ],
            [
                'name' => 'SOP',
                'slug' => 'sop',
                'description' => 'Standard Operating Procedures (SOP)',
                'icon' => 'bi-file-text',
                'order' => 2
            ],
            [
                'name' => 'Instruksi Kerja',
                'slug' => 'instruksi-kerja',
                'description' => 'Instruksi kerja dan panduan pelaksanaan',
                'icon' => 'bi-list-check',
                'order' => 3
            ],
            [
                'name' => 'Catatan/Rekaman',
                'slug' => 'catatan-rekaman',
                'description' => 'Catatan dan rekaman aktivitas',
                'icon' => 'bi-card-checklist',
                'order' => 4
            ]
        ];

        foreach ($categories as $category) {
            FileCategory::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        $this->command->info('FileCategorySeeder completed successfully!');
    }
}
