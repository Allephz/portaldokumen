<?php

namespace App\Http\Controllers;

use App\Models\Director;
use App\Models\DepartmentFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $startTime = microtime(true);
        
        // Check if admin, manager, or user and redirect accordingly
        if (auth()->user()->isAdmin()) {
            $response = $this->adminDashboard();
        } elseif (auth()->user()->isManager()) {
            $response = $this->managerDashboard();
        } else {
            $response = $this->userDashboard();
        }
        
        // Log query performance (non-blocking)
        $duration = microtime(true) - $startTime;
        \Log::info('Dashboard load time: ' . round($duration * 1000) . 'ms');
        
        return $response;
    }

    /**
     * Admin Dashboard
     */
    public function adminDashboard()
    {
        // Use cache to avoid repeated heavy queries (5 min cache)
        $cacheKey = 'admin_dashboard_data_' . auth()->id();
        
        $data = Cache::remember($cacheKey, 300, function() {
            // Fetch directors with pagination - only load what's needed
            $directors = Director::select('id', 'title', 'name')
                ->with(['divisions' => function($query) {
                    $query->select('id', 'director_id', 'name')
                        ->with(['departments' => function($q) {
                            $q->select('id', 'division_id', 'name');
                        }])->limit(10);
                }])
                ->orderBy('id')
                ->limit(50)
                ->get();
            
            // Transform data to format needed by frontend
            $directorsData = $directors->map(function($director) {
                return [
                    'id' => $director->id,
                    'title' => $director->title,
                    'name' => $director->name,
                    'divisions' => $director->divisions->map(function($div) {
                        return ['id' => $div->id, 'name' => $div->name];
                    })->toArray()
                ];
            });

            // Get recent activity logs - use select() to limit columns
            $activityLogs = \App\Models\ActivityLog::with(['user' => function($q) {
                $q->select('id', 'name', 'email');
            }])
                ->select('id', 'user_id', 'action', 'description', 'created_at')
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get();
            
            return [
                'directors' => $directorsData,
                'directorsModel' => $directors,
                'activityLogs' => $activityLogs
            ];
        });

        \Log::info('Admin dashboard loaded', ['cache_key' => $cacheKey]);

        return view('admin.dashboard', $data);
    }

    /**
     * Manager Dashboard
     */
    public function managerDashboard()
    {
        // Use cache to avoid repeated heavy queries (3 min cache for manager data)
        $cacheKey = 'manager_dashboard_data_' . auth()->id();
        
        $data = Cache::remember($cacheKey, 180, function() {
            // Fetch directors with pagination - only load what's needed
            $directors = Director::select('id', 'title', 'name')
                ->with(['divisions' => function($query) {
                    $query->select('id', 'director_id', 'name')
                        ->with(['departments' => function($q) {
                            $q->select('id', 'division_id', 'name');
                        }])->limit(10);
                }])
                ->orderBy('id')
                ->limit(50)
                ->get();
            
            // Transform data to format needed by frontend
            $directorsData = $directors->map(function($director) {
                return [
                    'id' => $director->id,
                    'title' => $director->title,
                    'name' => $director->name,
                    'divisions' => $director->divisions->map(function($div) {
                        return ['id' => $div->id, 'name' => $div->name];
                    })->toArray()
                ];
            });

            // Get recent activity logs - use select() to limit columns
            $activityLogs = \App\Models\ActivityLog::with(['user' => function($q) {
                $q->select('id', 'name', 'email');
            }])
                ->select('id', 'user_id', 'action', 'description', 'created_at')
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get();
            
            // Get files pending approval - with pagination to avoid timeout
            $pendingApprovalFiles = DepartmentFile::where('approval_status', 'pending')
                ->with(['department' => function($q) {
                    $q->select('id', 'name');
                }, 'category' => function($q) {
                    $q->select('id', 'name', 'icon');
                }])
                ->select('id', 'department_id', 'file_category_id', 'file_name', 'file_path', 'approval_status', 'created_at')
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();

            // Cache file categories separately (longer cache)
            $categories = Cache::remember('file_categories_' . auth()->id(), 600, function() {
                return \App\Models\FileCategory::getOrdered();
            });
            
            return [
                'directors' => $directorsData,
                'directorsModel' => $directors,
                'activityLogs' => $activityLogs,
                'pendingApprovalFiles' => $pendingApprovalFiles,
                'categories' => $categories
            ];
        });

        \Log::info('Manager dashboard loaded', ['cache_key' => $cacheKey]);

        return view('manager.dashboard', $data);
    }

    /**
     * User Dashboard
     */
    public function userDashboard()
    {
        $user = auth()->user();
        
        // Redirect manager to manager dashboard
        if ($user->isManager()) {
            return $this->managerDashboard();
        }
        
        // Redirect admin to admin dashboard
        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        // Use cache for user dashboard (2 min cache)
        $userId = auth()->id() ?? 'guest';
        $cacheKey = 'user_dashboard_data_' . auth()->id();
        
        $data = Cache::remember($cacheKey, 120, function() use ($user) {
            // Get department
            $department = $user->department;
            
            if (!$department) {
                $categories = Cache::remember('file_categories_' . auth()->id(), 600, function() {
                    return \App\Models\FileCategory::getOrdered();
                });
                return [
                    'user' => $user,
                    'department' => null,
                    'division' => null,
                    'categories' => $categories,
                    'selectedCategory' => null,
                    'files' => []
                ];
            }

            $division = $department->division ?? null;
            
            // Cache categories
            $categories = Cache::remember('file_categories_' . auth()->id(), 600, function() {
                return \App\Models\FileCategory::getOrdered();
            });
            
            // Get first category by default
            $selectedCategory = $categories->first();
            
            // Get files for selected category with pagination
            $files = $selectedCategory ? $department->files()
                ->where('file_category_id', $selectedCategory->id)
                ->select('id', 'file_name', 'file_path', 'file_category_id', 'created_at', 'approval_status')
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get() : [];

            return [
                'user' => $user,
                'department' => $department,
                'division' => $division,
                'categories' => $categories,
                'selectedCategory' => $selectedCategory,
                'files' => $files
            ];
        });

        return view('user.dashboard', $data);
    }

    public function getDirectors()
    {
        $directors = Director::orderBy('id')->get();
        
        return response()->json([
            'directors' => $directors->map(function($dir) {
                return [
                    'id' => $dir->id,
                    'title' => $dir->title,
                    'name' => $dir->name
                ];
            })->toArray()
        ]);
    }

    public function createDirector(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:100',
                'name' => 'required|string|max:100'
            ]);

            $director = Director::create($validated);

            return response()->json([
                'success' => true, 
                'message' => 'Director created successfully',
                'director' => [
                    'id' => $director->id,
                    'title' => $director->title,
                    'name' => $director->name
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getDivisions($directorId)
    {
        $director = Director::with('divisions')->find($directorId);
        
        if (!$director) {
            return response()->json(['error' => 'Director not found'], 404);
        }

        return response()->json([
            'director' => [
                'id' => $director->id,
                'title' => $director->title,
                'name' => $director->name
            ],
            'divisions' => $director->divisions->map(function($div) {
                return ['id' => $div->id, 'name' => $div->name];
            })->toArray()
        ]);
    }

    public function updateDirector(Request $request, $directorId)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3',
            'title' => 'required|string|min:3'
        ]);

        $director = Director::find($directorId);
        
        if (!$director) {
            return response()->json(['error' => 'Director not found'], 404);
        }

        $director->update([
            'name' => $validated['name'],
            'title' => $validated['title']
        ]);

        return response()->json([
            'success' => true,
            'director' => [
                'id' => $director->id,
                'title' => $director->title,
                'name' => $director->name
            ]
        ]);
    }

    public function deleteDirector($directorId)
    {
        try {
            $director = Director::find($directorId);
            
            if (!$director) {
                return response()->json(['success' => false, 'message' => 'Director not found'], 404);
            }

            $directorInfo = $director->title . ' ' . $director->name;

            $director->delete();

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'delete_director',
                'description' => 'Deleted director: ' . $directorInfo,
                'department_id' => null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Director deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getDepartments($divisionId)
    {
        $division = \App\Models\Division::with('departments')->find($divisionId);
        
        if (!$division) {
            return response()->json(['error' => 'Division not found'], 404);
        }

        return response()->json([
            'division' => [
                'id' => $division->id,
                'name' => $division->name
            ],
            'departments' => $division->departments->map(function($dept) {
                return ['id' => $dept->id, 'name' => $dept->name];
            })->toArray()
        ]);
    }

    public function createDivision(Request $request, $directorId)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3'
        ]);

        $director = Director::find($directorId);
        
        if (!$director) {
            return response()->json(['error' => 'Director not found'], 404);
        }

        $division = \App\Models\Division::create([
            'director_id' => $directorId,
            'name' => $validated['name']
        ]);

        return response()->json([
            'success' => true,
            'division' => ['id' => $division->id, 'name' => $division->name]
        ]);
    }

    public function updateDivision(Request $request, $divisionId)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3'
        ]);

        $division = \App\Models\Division::find($divisionId);
        
        if (!$division) {
            return response()->json(['error' => 'Division not found'], 404);
        }

        $division->update(['name' => $validated['name']]);

        return response()->json([
            'success' => true,
            'division' => ['id' => $division->id, 'name' => $division->name]
        ]);
    }

    public function deleteDivision($divisionId)
    {
        $division = \App\Models\Division::find($divisionId);
        
        if (!$division) {
            return response()->json(['error' => 'Division not found'], 404);
        }

        $division->delete();

        return response()->json(['success' => true, 'message' => 'Division deleted']);
    }

    public function createDepartment(Request $request, $divisionId)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3'
        ]);

        $division = \App\Models\Division::find($divisionId);
        
        if (!$division) {
            return response()->json(['error' => 'Division not found'], 404);
        }

        $department = \App\Models\Department::create([
            'division_id' => $divisionId,
            'name' => $validated['name']
        ]);

        return response()->json([
            'success' => true,
            'department' => ['id' => $department->id, 'name' => $department->name]
        ]);
    }

    public function updateDepartment(Request $request, $departmentId)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3'
        ]);

        $department = \App\Models\Department::find($departmentId);
        
        if (!$department) {
            return response()->json(['error' => 'Department not found'], 404);
        }

        $department->update(['name' => $validated['name']]);

        return response()->json([
            'success' => true,
            'department' => ['id' => $department->id, 'name' => $department->name]
        ]);
    }

    public function deleteDepartment($departmentId)
    {
        $department = \App\Models\Department::find($departmentId);
        
        if (!$department) {
            return response()->json(['error' => 'Department not found'], 404);
        }

        $department->delete();

        return response()->json(['success' => true, 'message' => 'Department deleted']);
    }

    /**
     * Get all files from all departments (for admin & manager)
     */
    public function getAllFiles(Request $request)
    {
        // Only admin and manager can access
        if (!auth()->user()->isAdmin() && !auth()->user()->isManager()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Get category filter from query parameter
        $categoryId = $request->query('category');
        
        // Query all files
        $query = \App\Models\DepartmentFile::with('department', 'category');
        
        if ($categoryId) {
            $query->where('file_category_id', $categoryId);
        }
        
        $files = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'files' => $files->map(function($file) {
                return [
                    'id' => $file->id,
                    'file_name' => $file->file_name,
                    'file_size' => $file->file_size,
                    'file_type' => $file->file_type,
                    'file_category_id' => $file->file_category_id,
                    'department_name' => $file->department->name ?? 'Unknown',
                    'category_name' => $file->category->name ?? 'Unknown',
                    'created_at' => $file->created_at->format('d/m/Y H:i')
                ];
            })->toArray()
        ]);
    }

    /**
     * Get files from specific department (for admin view)
     */
    public function getAdminDepartmentFiles(Request $request, $departmentId)
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isManager()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $department = \App\Models\Department::find($departmentId);
        
        if (!$department) {
            return response()->json(['error' => 'Department not found'], 404);
        }

        // Get category filter from query parameter
        $categoryId = $request->query('category');
        
        // Query files fresh from database
        $query = \App\Models\DepartmentFile::where('department_id', $departmentId);
        
        if ($categoryId) {
            $query->where('file_category_id', $categoryId);
        }
        
        $files = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'files' => $files->map(function($file) {
                return [
                    'id' => $file->id,
                    'file_name' => $file->file_name,
                    'file_size' => $file->file_size,
                    'file_type' => $file->file_type,
                    'file_category_id' => $file->file_category_id,
                    'approval_status' => $file->approval_status ?? 'pending',
                    'created_at' => $file->created_at->format('d/m/Y H:i')
                ];
            })->toArray()
        ]);
    }

    public function getDepartmentFiles(Request $request, $departmentId)
    {
        $department = \App\Models\Department::find($departmentId);
        
        if (!$department) {
            return response()->json(['error' => 'Department not found'], 404);
        }

        // Get category filter from query parameter
        $categoryId = $request->query('category');
        
        // Query files fresh from database
        $query = \App\Models\DepartmentFile::where('department_id', $departmentId);
        
        if ($categoryId) {
            $query->where('file_category_id', $categoryId);
        }
        
        $files = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'files' => $files->map(function($file) {
                return [
                    'id' => $file->id,
                    'file_name' => $file->file_name,
                    'file_size' => $file->file_size,
                    'file_type' => $file->file_type,
                    'file_category_id' => $file->file_category_id,
                    'created_at' => $file->created_at->format('d/m/Y H:i')
                ];
            })->toArray()
        ]);
    }

    public function uploadFile(Request $request, $departmentId)
    {
        $validated = $request->validate([
            'file' => 'required|file|max:10240', // Max 10MB
            'category_id' => 'required|exists:file_categories,id'
        ]);

        $department = \App\Models\Department::find($departmentId);
        
        if (!$department) {
            return response()->json(['error' => 'Department not found'], 404);
        }

        // Check if user is authorized to upload to this department
        if (auth()->user()->isUser() && auth()->user()->department_id != $departmentId) {
            return response()->json(['error' => 'Anda tidak memiliki akses ke department ini'], 403);
        }

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $fileSize = $file->getSize();
        $fileType = $file->getClientOriginalExtension();
        
        // Store file in public disk for easier access
        $path = $file->store('department_files/' . $departmentId, 'public');

        $departmentFile = \App\Models\DepartmentFile::create([
            'department_id' => $departmentId,
            'file_category_id' => $validated['category_id'],
            'file_name' => $fileName,
            'file_path' => $path,
            'file_size' => $fileSize,
            'file_type' => $fileType,
            'approval_status' => 'pending' // File starts as pending, waiting for manager approval
        ]);

        // Log activity
        $category = \App\Models\FileCategory::find($validated['category_id']);
        \App\Models\ActivityLog::log(
            'upload',
            'DepartmentFile',
            $departmentFile->id,
            auth()->user()->name . ' mengupload file "' . $fileName . '" ke kategori ' . $category->name . ' di department ' . $department->name
        );
        
        // Clear manager dashboard caches to show new pending file immediately
        // Since we don't know all manager IDs, we use pattern-based cache clearing
        $managers = \App\Models\User::where('role', 'manager')->get();
        foreach ($managers as $manager) {
            Cache::forget('manager_dashboard_data_' . $manager->id);
            Cache::forget('admin_dashboard_data_' . $manager->id);
        }

        return response()->json([
            'success' => true,
            'file' => [
                'id' => $departmentFile->id,
                'file_name' => $departmentFile->file_name,
                'file_size' => $departmentFile->file_size,
                'file_type' => $departmentFile->file_type,
                'created_at' => $departmentFile->created_at->format('d/m/Y H:i')
            ]
        ]);
    }

    public function deleteFile($fileId)
    {
        $file = \App\Models\DepartmentFile::find($fileId);
        
        if (!$file) {
            return response()->json(['error' => 'File not found'], 404);
        }

        // Delete file from public storage
        if (Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }

        // Store file info before delete for logging
        $fileName = $file->file_name;
        $department = $file->department;

        $file->delete();

        // Log activity
        \App\Models\ActivityLog::log(
            'delete',
            'DepartmentFile',
            null,
            auth()->user()->name . ' menghapus file "' . $fileName . '" dari department ' . $department->name
        );

        return response()->json(['success' => true, 'message' => 'File deleted']);
    }

    public function deleteAllFiles()
    {
        try {
            $allFiles = \App\Models\DepartmentFile::all();
            $deletedCount = 0;

            foreach ($allFiles as $file) {
                // Delete physical file from storage
                if (Storage::disk('public')->exists($file->file_path)) {
                    Storage::disk('public')->delete($file->file_path);
                }
                
                $file->delete();
                $deletedCount++;
            }

            return response()->json([
                'success' => true,
                'message' => 'Semua ' . $deletedCount . ' file berhasil dihapus!',
                'deletedCount' => $deletedCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error deleting files: ' . $e->getMessage()
            ], 500);
        }
    }

    public function downloadFile($fileId)
    {
        try {
            $file = \App\Models\DepartmentFile::find($fileId);
            
            if (!$file) {
                return abort(404, 'File not found');
            }

            if (!Storage::disk('public')->exists($file->file_path)) {
                return abort(404, 'File not found in storage');
            }

            // Use download method with proper headers
            return response()->streamDownload(
                function () use ($file) {
                    echo Storage::disk('public')->get($file->file_path);
                },
                $file->file_name,
                [
                    'Content-Type' => 'application/octet-stream',
                    'Content-Disposition' => 'attachment; filename="' . $file->file_name . '"'
                ]
            );
        } catch (\Exception $e) {
            return abort(500, 'Error downloading file: ' . $e->getMessage());
        }
    }

    public function viewFile($fileId)
    {
        try {
            $file = \App\Models\DepartmentFile::find($fileId);
            
            if (!$file) {
                abort(404, 'File not found');
            }

            if (!Storage::disk('public')->exists($file->file_path)) {
                abort(404, 'File not found in storage');
            }

            // Determine MIME type based on extension
            $mimeTypes = [
                'pdf' => 'application/pdf',
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'txt' => 'text/plain',
                'doc' => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'xls' => 'application/vnd.ms-excel',
                'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ];

            $fileExtension = strtolower($file->file_type);
            $mimeType = $mimeTypes[$fileExtension] ?? 'application/octet-stream';

            // Display file inline (for preview)
            return response()->file(
                Storage::disk('public')->path($file->file_path),
                [
                    'Content-Type' => $mimeType,
                    'Content-Disposition' => 'inline; filename="' . $file->file_name . '"'
                ]
            );
        } catch (\Exception $e) {
            return abort(500, 'Error viewing file: ' . $e->getMessage());
        }
    }

    public function updateFileCategory(Request $request, $fileId)
    {
        try {
            $file = DepartmentFile::find($fileId);
            
            if (!$file) {
                return response()->json(['success' => false, 'message' => 'File not found'], 404);
            }

            $validated = $request->validate([
                'file_category_id' => 'required|exists:file_categories,id'
            ]);

            $file->update(['file_category_id' => $validated['file_category_id']]);

            // Log activity
            \App\Models\ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'update_file_category',
                'description' => 'Updated file category for: ' . $file->file_name,
                'department_id' => $file->department_id
            ]);

            return response()->json(['success' => true, 'message' => 'File category updated']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Approve file (Manager action)
     */
    public function approveFile($fileId)
    {
        try {
            $file = DepartmentFile::find($fileId);
            
            if (!$file) {
                return response()->json(['error' => 'File not found'], 404);
            }

            $file->update(['approval_status' => 'approved']);

            \App\Models\ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'approve_file',
                'description' => 'Approved file: ' . $file->file_name,
                'department_id' => $file->department_id
            ]);
            
            // Clear dashboard cache to reflect changes immediately
            Cache::forget('manager_dashboard_data_' . auth()->id());
            Cache::forget('admin_dashboard_data_' . auth()->id());

            return response()->json(['success' => true, 'message' => 'File approved']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Reject file (Manager action)
     */
    public function rejectFile($fileId)
    {
        try {
            $file = DepartmentFile::find($fileId);
            
            if (!$file) {
                return response()->json(['error' => 'File not found'], 404);
            }

            $file->update(['approval_status' => 'rejected']);

            \App\Models\ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'reject_file',
                'description' => 'Rejected file: ' . $file->file_name,
                'department_id' => $file->department_id
            ]);
            
            // Clear dashboard cache to reflect changes immediately
            Cache::forget('manager_dashboard_data_' . auth()->id());
            Cache::forget('admin_dashboard_data_' . auth()->id());

            return response()->json(['success' => true, 'message' => 'File rejected']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

}
