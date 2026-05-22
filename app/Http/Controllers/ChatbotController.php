<?php

namespace App\Http\Controllers;

use App\Models\DepartmentFile;
use App\Models\FileCategory;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    /**
     * Search files based on user query
     */
    public function searchFiles(Request $request)
    {
        $query = $request->input('query', '');
        
        if (strlen($query) < 2) {
            return response()->json([
                'success' => false,
                'message' => 'Masukkan minimal 2 karakter untuk pencarian'
            ]);
        }

        try {
            // Split query into individual words for partial matching
            $queryWords = preg_split('/[\s\-_]+/', trim($query), -1, PREG_SPLIT_NO_EMPTY);
            
            // Search files by name, category, or department
            $files = DepartmentFile::with(['department', 'category'])
                ->where(function($q) use ($queryWords, $query) {
                    // Search exact phrase first
                    $q->where('file_name', 'LIKE', "%{$query}%");
                    
                    // Then search for any individual word in file_name
                    foreach ($queryWords as $word) {
                        $q->orWhere('file_name', 'LIKE', "%{$word}%");
                    }
                    
                    // Search by category name
                    $q->orWhereHas('category', function($cat) use ($queryWords, $query) {
                        $cat->where('name', 'LIKE', "%{$query}%");
                        foreach ($queryWords as $word) {
                            $cat->orWhere('name', 'LIKE', "%{$word}%");
                        }
                    });
                    
                    // Search by department name
                    $q->orWhereHas('department', function($dept) use ($queryWords, $query) {
                        $dept->where('name', 'LIKE', "%{$query}%");
                        foreach ($queryWords as $word) {
                            $dept->orWhere('name', 'LIKE', "%{$word}%");
                        }
                    });
                })
                ->where('approval_status', 'approved') // Only show approved files
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get();

            if ($files->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'found' => false,
                    'message' => "Tidak ada file yang ditemukan untuk pencarian: '$query'",
                    'files' => []
                ]);
            }

            // Format results
            $results = $files->map(function($file) {
                return [
                    'id' => $file->id,
                    'name' => $file->file_name,
                    'category' => $file->category?->name ?? 'Uncategorized',
                    'department' => $file->department?->name ?? 'Unknown',
                    'uploadedAt' => $file->created_at->format('d M Y H:i'),
                    'size' => $this->formatFileSize($file->file_size),
                    'path' => $file->file_path,
                    'type' => $file->file_type
                ];
            });

            return response()->json([
                'success' => true,
                'found' => true,
                'message' => "Ditemukan " . count($results) . " file untuk pencarian: '$query'",
                'files' => $results
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get file statistics
     */
    public function getStatistics(Request $request)
    {
        try {
            $totalFiles = DepartmentFile::where('approval_status', 'approved')->count();
            $totalCategories = FileCategory::count();
            $recentFiles = DepartmentFile::where('approval_status', 'approved')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
                ->pluck('file_name');

            $stats = [
                'total_files' => $totalFiles,
                'total_categories' => $totalCategories,
                'recent_files' => $recentFiles
            ];

            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all categories for suggestions
     */
    public function getCategories(Request $request)
    {
        try {
            $categories = FileCategory::orderBy('name')->get(['id', 'name']);

            return response()->json([
                'success' => true,
                'categories' => $categories
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Format file size in human readable format
     */
    private function formatFileSize($bytes)
    {
        if ($bytes == 0) return '0 B';
        $k = 1024;
        $sizes = ['B', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes, $k));
        return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
    }
}
