<?php

namespace Database\Seeders;

use App\Models\DepartmentFile;
use App\Models\Department;
use App\Models\FileCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DepartmentFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua department dan kategori
        $departments = Department::all();
        $categories = FileCategory::all();

        if ($departments->isEmpty()) {
            $this->command->warn('Tidak ada department yang ditemukan. Jalankan DirectorDivisionSeeder terlebih dahulu.');
            return;
        }

        if ($categories->isEmpty()) {
            $this->command->warn('Tidak ada kategori yang ditemukan. Jalankan FileCategorySeeder terlebih dahulu.');
            return;
        }

        // Base storage path
        $baseStoragePath = storage_path('app/department_files');
        
        // Buat sample file untuk setiap department dan kategori
        foreach ($departments as $department) {
            // Buat direktori untuk department
            $departmentDir = $baseStoragePath . '/' . $department->id;
            
            if (!is_dir($departmentDir)) {
                mkdir($departmentDir, 0755, true);
            }

            // Untuk setiap kategori, buat 1-2 file sample
            foreach ($categories as $category) {
                for ($i = 1; $i <= 2; $i++) {
                    $fileName = $category->name . '_' . $department->id . '_' . $i . '.txt';
                    $fullPath = $departmentDir . '/' . $fileName;
                    $relativePath = 'department_files/' . $department->id . '/' . $fileName;

                    // Buat konten file
                    $content = "Document Type: {$category->name}\n";
                    $content .= "Department: {$department->name}\n";
                    $content .= "Created at: " . now() . "\n";
                    $content .= "This is {$category->name} document number {$i}.\n";

                    try {
                        // Simpan file ke disk
                        file_put_contents($fullPath, $content);

                        // Catat di database dengan kategori
                        DepartmentFile::create([
                            'department_id' => $department->id,
                            'file_category_id' => $category->id,
                            'file_name' => $fileName,
                            'file_path' => $relativePath,
                            'file_size' => strlen($content),
                            'file_type' => 'txt'
                        ]);

                        $this->command->info("Created {$category->name} file: {$fileName} for Department: {$department->name}");
                    } catch (\Exception $e) {
                        $this->command->error("Error creating file {$fileName}: " . $e->getMessage());
                    }
                }
            }
        }

        $this->command->info('DepartmentFileSeeder completed successfully!');
    }
}

