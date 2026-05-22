<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Public routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'handleLogin']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'handleRegister']);

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->middleware('admin')->name('admin.dashboard');
    Route::get('/manager/dashboard', [DashboardController::class, 'managerDashboard'])->middleware('manager')->name('manager.dashboard');
    Route::get('/user/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
    
    // Admin & Manager routes (both can do CRUD operations)
    Route::middleware('admin_or_manager')->group(function () {
        // File approval routes (manager only)
        Route::post('/api/file/{id}/approve', [DashboardController::class, 'approveFile'])->middleware('manager')->name('file.approve');
        Route::post('/api/file/{id}/reject', [DashboardController::class, 'rejectFile'])->middleware('manager')->name('file.reject');
        
        // Director routes
        Route::get('/api/directors', [DashboardController::class, 'getDirectors'])->name('directors.list');
        Route::post('/api/directors', [DashboardController::class, 'createDirector'])->name('director.create');
        Route::get('/api/director/{id}/divisions', [DashboardController::class, 'getDivisions'])->name('director.divisions');
        Route::put('/api/director/{id}', [DashboardController::class, 'updateDirector'])->name('director.update');
        
        // Division routes
        Route::get('/api/division/{id}/departments', [DashboardController::class, 'getDepartments'])->name('division.departments');
        Route::post('/api/director/{id}/divisions', [DashboardController::class, 'createDivision'])->name('division.create');
        Route::put('/api/division/{id}', [DashboardController::class, 'updateDivision'])->name('division.update');
        Route::delete('/api/division/{id}', [DashboardController::class, 'deleteDivision'])->name('division.delete');
        
        // Department routes
        Route::post('/api/division/{id}/departments', [DashboardController::class, 'createDepartment'])->name('department.create');
        Route::put('/api/department/{id}', [DashboardController::class, 'updateDepartment'])->name('department.update');
        Route::delete('/api/department/{id}', [DashboardController::class, 'deleteDepartment'])->name('department.delete');
        
        // File management (delete, update category, and view)
        Route::delete('/api/file/{id}', [DashboardController::class, 'deleteFile'])->name('file.delete');
        Route::post('/api/file/{id}/update-category', [DashboardController::class, 'updateFileCategory'])->name('file.update-category');
        
        // File view - get all files from all departments
        Route::get('/api/admin/files', [DashboardController::class, 'getAllFiles'])->name('admin.files');
        
        // File view - get files from specific department
        Route::get('/api/admin/department/{id}/files', [DashboardController::class, 'getAdminDepartmentFiles'])->name('admin.department.files');
        
        // Delete all files
        Route::delete('/api/admin/files/delete-all', [DashboardController::class, 'deleteAllFiles'])->name('admin.files.delete-all');
    });
    
    // File routes (for all authenticated users)
    Route::get('/api/department/{id}/files', [DashboardController::class, 'getDepartmentFiles'])->name('department.files');
    Route::post('/api/department/{id}/upload', [DashboardController::class, 'uploadFile'])->name('file.upload');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Home redirect
Route::get('/', function () {
    return redirect()->route('login');
});

// Public file download/view route
Route::get('/file/{id}/download', [DashboardController::class, 'downloadFile'])->name('file.download');
Route::get('/file/{id}/view', [DashboardController::class, 'viewFile'])->name('file.view');

// Direct file access route for convenience
Route::get('/files/{path}', function($path) {
    return response()->file(Storage::disk('public')->path($path));
})->where('path', '.*')->name('file.show');

// Debug route - check activity logs (remove in production)
Route::middleware('admin')->get('/debug/activity-logs', function() {
    $logs = \App\Models\ActivityLog::with('user')->latest()->limit(50)->get();
    return response()->json([
        'count' => $logs->count(),
        'logs' => $logs->map(function($log) {
            return [
                'id' => $log->id,
                'user' => $log->user ? ['id' => $log->user->id, 'name' => $log->user->name, 'email' => $log->user->email] : null,
                'action' => $log->action,
                'description' => $log->description,
                'created_at' => $log->created_at
            ];
        })
    ]);
});

// Chatbot routes (protected by authentication)
Route::middleware('auth')->group(function () {
    Route::post('/api/chatbot/search', [App\Http\Controllers\ChatbotController::class, 'searchFiles'])->name('chatbot.search');
    Route::get('/api/chatbot/stats', [App\Http\Controllers\ChatbotController::class, 'getStatistics'])->name('chatbot.stats');
    Route::get('/api/chatbot/categories', [App\Http\Controllers\ChatbotController::class, 'getCategories'])->name('chatbot.categories');
});
