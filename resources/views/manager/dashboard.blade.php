@extends('layouts.app')

@section('title', 'Manager Dashboard - Portal ISO 9001')

@section('content')
<div class="page-header">
    <h2><i class="bi bi-person-check"></i> Manager Dashboard <span id="adminCategoryTitle"></span></h2>
    <p>Kelola approval file dan struktur organisasi</p>
</div>

<div class="row">
    <!-- Statistics Row -->
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div style="width: 50px; height: 50px; background: rgba(59, 130, 246, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #3b82f6; font-size: 24px; margin-right: 15px;">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Users</h6>
                        <h4 class="mb-0">{{ \App\Models\User::count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div style="width: 50px; height: 50px; background: rgba(16, 185, 129, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #10b981; font-size: 24px; margin-right: 15px;">
                        <i class="bi bi-building"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Departments</h6>
                        <h4 class="mb-0">{{ \App\Models\Department::count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div style="width: 50px; height: 50px; background: rgba(168, 85, 247, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #a855f7; font-size: 24px; margin-right: 15px;">
                            <i class="bi bi-file"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Files</h6>
                            <h4 class="mb-0">{{ \App\Models\DepartmentFile::count() }}</h4>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-danger" onclick="deleteAllFiles()" title="Hapus semua file">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div style="width: 50px; height: 50px; background: rgba(249, 115, 22, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #f97316; font-size: 24px; margin-right: 15px;">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Activities</h6>
                        <h4 class="mb-0">{{ \App\Models\ActivityLog::count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div style="width: 50px; height: 50px; background: rgba(251, 146, 60, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fb923c; font-size: 24px; margin-right: 15px;">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Pending Approval</h6>
                        <h4 class="mb-0" id="pendingCount">{{ count($pendingApprovalFiles) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Approval Files -->
<div class="row">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-clipboard-check"></i> File Menunggu Approval</h5>
                @if(count($pendingApprovalFiles) > 0)
                <div class="btn-group" role="group">
                    <button class="btn btn-sm btn-success" onclick="approveAllFiles()" title="Approve semua file">
                        <i class="bi bi-check-double"></i> Approve All
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="rejectAllFiles()" title="Reject semua file">
                        <i class="bi bi-x-square"></i> Reject All
                    </button>
                </div>
                @endif
            </div>
            <div class="card-body p-0">
                @if(count($pendingApprovalFiles) > 0)
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light" style="position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <th style="width: 15%;">Department</th>
                                <th style="width: 20%;">File Name</th>
                                <th style="width: 15%;">Kategori</th>
                                <th style="width: 20%;">Uploaded</th>
                                <th style="width: 30%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingApprovalFiles as $file)
                            <tr>
                                <td><strong>{{ $file->department->name ?? 'N/A' }}</strong></td>
                                <td>{{ $file->file_name }}</td>
                                <td><span class="badge bg-info">{{ $file->category->name ?? 'N/A' }}</span></td>
                                <td><small class="text-muted">{{ $file->created_at->format('d M Y H:i') }}</small></td>
                                <td>
                                    <button class="btn btn-sm btn-success approval-btn" data-file-id="{{ $file->id }}" onclick="approveFile({{ $file->id }})" title="Approve">
                                        <i class="bi bi-check-circle"></i> Approve
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="rejectFile({{ $file->id }})" title="Reject">
                                        <i class="bi bi-x-circle"></i> Reject
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="bi bi-check-circle text-success" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
                    <p class="text-muted">Tidak ada file yang menunggu approval</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Activity Log -->
<div class="row">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Aktivitas Terbaru</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light" style="position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <th style="width: 15%;">User</th>
                                <th style="width: 15%;">Action</th>
                                <th style="width: 35%;">Deskripsi</th>
                                <th style="width: 20%;">Waktu</th>
                                <th style="width: 15%;">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activityLogs as $log)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; margin-right: 10px; font-size: 12px;">
                                            {{ strtoupper(substr($log->user->name ?? 'U', 0, 2)) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0" style="font-size: 13px;">{{ $log->user->name ?? 'Unknown' }}</h6>
                                            <small class="text-muted">{{ $log->user->email ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($log->action === 'upload')
                                        <span class="badge bg-success"><i class="bi bi-cloud-upload"></i> Upload</span>
                                    @elseif($log->action === 'delete')
                                        <span class="badge bg-danger"><i class="bi bi-trash"></i> Delete</span>
                                    @elseif($log->action === 'create')
                                        <span class="badge bg-info"><i class="bi bi-plus-circle"></i> Create</span>
                                    @elseif($log->action === 'update')
                                        <span class="badge bg-warning"><i class="bi bi-pencil"></i> Update</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($log->action) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <p class="mb-0" style="font-size: 13px;">{{ $log->description }}</p>
                                </td>
                                <td>
                                    <small class="text-muted d-block">{{ $log->created_at->format('d/m/Y H:i') }}</small>
                                    <small class="text-muted d-block">{{ $log->created_at->diffForHumans() }}</small>
                                </td>
                                <td>
                                    @if($log->data)
                                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $log->id }}">
                                            <i class="bi bi-info-circle"></i> Detail
                                        </button>

                                        <!-- Detail Modal -->
                                        <div class="modal fade" id="detailModal{{ $log->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Activity Detail</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <pre style="background: #f5f5f5; padding: 15px; border-radius: 8px; overflow-x: auto; max-height: 300px; font-size: 11px;">{{ json_encode(json_decode($log->data), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox"></i> Belum ada aktivitas
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Section - Director & Organizational Structure -->
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0"><i class="bi bi-diagram-3"></i> Struktur Organisasi</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Directors List (Left) -->
                    <div class="col-lg-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0"><i class="bi bi-people"></i> Director</h6>
                            <button class="btn btn-sm btn-success" onclick="showAddDirectorModal()" title="Tambah Director">
                                <i class="bi bi-plus"></i> Tambah
                            </button>
                        </div>
                        <div id="directorsList" class="list-group" style="max-height: 500px; overflow-y: auto;">
                            <p class="text-muted text-center py-4">Memuat directors...</p>
                        </div>
                    </div>

                    <!-- Divisions (Middle) -->
                    <div class="col-lg-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0"><i class="bi bi-diagram-2"></i> Divisi</h6>
                            <button class="btn btn-sm btn-primary" onclick="showAddDivisionModal()" id="addDivisionBtn" style="display:none;">
                                <i class="bi bi-plus"></i> Tambah
                            </button>
                        </div>
                        <div id="divisionsList" class="list-group" style="max-height: 500px; overflow-y: auto;">
                            <p class="text-muted text-center py-4">Pilih director terlebih dahulu</p>
                        </div>
                    </div>

                    <!-- Departments (Right) -->
                    <div class="col-lg-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0"><i class="bi bi-folder"></i> Department</h6>
                            <button class="btn btn-sm btn-primary" onclick="showAddDepartmentModal()" id="addDepartmentBtn" style="display:none;">
                                <i class="bi bi-plus"></i> Tambah
                            </button>
                        </div>
                        <div id="departmentsList" class="list-group" style="max-height: 500px; overflow-y: auto;">
                            <p class="text-muted text-center py-4">Pilih divisi terlebih dahulu</p>
                        </div>
                    </div>

                    <!-- Files (Right) -->
                    <div class="col-lg-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0"><i class="bi bi-file-earmark"></i> File</h6>
                            <button class="btn btn-sm btn-success" onclick="showAddFileModal()" id="addFileBtn" style="display:none;">
                                <i class="bi bi-plus"></i> Tambah
                            </button>
                        </div>
                        <div id="filesList" class="list-group" style="max-height: 500px; overflow-y: auto;">
                            <p class="text-muted text-center py-4">Pilih department terlebih dahulu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- File Categories Section -->
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0"><i class="bi bi-tags"></i> Kategori File</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @php
                        $categories = \App\Models\FileCategory::getOrdered();
                    @endphp
                    @forelse($categories as $category)
                    <div class="col-md-6 mb-3">
                        <div class="card border category-card" onclick="filterByCategory({{ $category->id }}, this)" style="background: linear-gradient(135deg, rgba(168, 85, 247, 0.1) 0%, rgba(236, 72, 153, 0.1) 100%); cursor: pointer; transition: all 0.3s ease;" data-category-id="{{ $category->id }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1"><i class="bi {{ $category->icon ?? 'bi-folder' }}"></i> {{ $category->name }}</h6>
                                        <p class="text-muted small mb-2">{{ $category->description }}</p>
                                        <small class="text-muted"><strong>{{ \App\Models\DepartmentFile::where('file_category_id', $category->id)->count() }}</strong> file</small>
                                    </div>
                                    <span class="badge bg-secondary">Order: {{ $category->order }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <p class="text-muted text-center py-4">Tidak ada kategori file</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.page-header {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #f0f0f0;
}

.page-header h2 {
    font-size: 32px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 5px;
}

.page-header p {
    color: #6b7280;
    margin: 0;
}

.accordion-button:not(.collapsed) {
    background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%);
    color: white;
}

.accordion-button:focus {
    box-shadow: 0 0 0 0.25rem rgba(168, 85, 247, 0.25);
}

.table-hover tbody tr:hover {
    background-color: rgba(168, 85, 247, 0.05);
}

.category-filter-btn.active {
    background-color: #a855f7;
    color: white;
    border-color: #a855f7;
}

.category-filter-btn:hover {
    background-color: #a855f7;
    color: white;
}

.category-card {
    position: relative;
    transition: all 0.3s ease;
}

.category-card:hover {
    box-shadow: 0 8px 16px rgba(168, 85, 247, 0.3);
    transform: translateY(-2px);
}

.category-card.active {
    background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%) !important;
    color: white;
    box-shadow: 0 8px 20px rgba(168, 85, 247, 0.4);
}

.category-card.active h6,
.category-card.active p,
.category-card.active small {
    color: white !important;
}
</style>

<script>
let currentSelectedDirectorId = null;
let currentSelectedDivisionId = null;
let currentSelectedDeptId = null;
let currentCategoryFilter = null;
let directors = [];
let categoriesData = @json($categories->map(function($cat) { return ['id' => $cat->id, 'name' => $cat->name]; })->values());

// Load organization structure on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin dashboard loaded. Loading directors...');
    loadDirectors();
});

// Handle category click from sidebar
function handleCategoryClick(event, categoryId, categoryName) {
    event.preventDefault();
    console.log('Category clicked:', {categoryId, categoryName});
    filterOrgByCategory(categoryId, categoryName);
}

// Filter files by category
function filterByCategory(categoryId, element) {
    // Remove active class from all category cards
    document.querySelectorAll('.category-card').forEach(card => {
        card.classList.remove('active');
    });
    
    // Add active class to clicked card
    element.classList.add('active');
    
    // Set the current category filter
    currentCategoryFilter = categoryId;
    
    console.log('Filtering by category:', categoryId);
    
    // Reload the files with the category filter
    // This will reload files from the file list that uses currentCategoryFilter
    // The files are typically loaded when a department is selected
    // So we just need to ensure the files show the filtered view
}

// Load all directors
function loadDirectors() {
    console.log('Fetching directors...');
    fetch('/api/directors')
        .then(response => {
            if (!response.ok) throw new Error('HTTP ' + response.status);
            return response.json();
        })
        .then(data => {
            console.log('Directors loaded:', data);
            directors = data.directors || [];
            
            let html = directors.length > 0 ? directors.map(director => `
                <div class="list-group-item text-start director-item" id="director-${director.id}" style="padding: 0;">
                    <div class="d-flex justify-content-between align-items-center" style="width: 100%;">
                        <button class="btn btn-link text-start" onclick="selectDirector(${director.id}, '${director.title} ${director.name}')" 
                                style="text-decoration: none; color: inherit; padding: 10px 15px; flex: 1; text-align: left;">
                            <h6 class="mb-0">${director.title}</h6>
                            <small class="text-muted">${director.name}</small>
                        </button>
                        <div style="display: flex; gap: 4px; padding: 10px 15px; border-left: 1px solid #dee2e6;">
                            <button class="btn btn-xs btn-warning" style="padding: 4px 8px; font-size: 11px;" 
                                    onclick="event.stopPropagation(); showEditDirectorModal(${director.id}, '${director.title}', '${director.name}')" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-xs btn-danger" style="padding: 4px 8px; font-size: 11px;" 
                                    onclick="event.stopPropagation(); deleteDirector(${director.id})" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `).join('') : '<p class="text-muted text-center py-3">Tidak ada director</p>';
            
            document.getElementById('directorsList').innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading directors:', error);
            document.getElementById('directorsList').innerHTML = '<p class="text-danger small">Error: ' + error.message + '</p>';
        });
}

// Select director and load divisions
function selectDirector(directorId, directorName) {
    console.log('selectDirector called:', {directorId, directorName});
    currentSelectedDirectorId = directorId;
    currentSelectedDivisionId = null;
    currentSelectedDeptId = null;
    
    // Update active state
    document.querySelectorAll('.director-item').forEach(btn => {
        btn.classList.remove('active');
    });
    document.getElementById('director-' + directorId).classList.add('active');
    
    // Show add division button and hide add department button
    document.getElementById('addDivisionBtn').style.display = 'block';
    document.getElementById('addDepartmentBtn').style.display = 'none';
    
    // Reset divisions and departments
    document.getElementById('divisionsList').innerHTML = '<p class="text-muted text-center py-4">Memuat divisi...</p>';
    document.getElementById('departmentsList').innerHTML = '<p class="text-muted text-center py-4">Pilih divisi terlebih dahulu</p>';
    document.getElementById('filesList').innerHTML = '<p class="text-muted text-center py-4">Pilih department terlebih dahulu</p>';
    
    loadDivisions(directorId);
}

// Load divisions for selected director
function loadDivisions(directorId) {
    console.log('Fetching divisions for director:', directorId);
    fetch('/api/director/' + directorId + '/divisions')
        .then(response => {
            if (!response.ok) throw new Error('HTTP ' + response.status);
            return response.json();
        })
        .then(data => {
            console.log('Divisions loaded:', data);
            const divisions = data.divisions || [];
            
            let html = divisions.length > 0 ? divisions.map(division => `
                <div class="list-group-item text-start division-item" id="division-${division.id}" style="padding: 0;">
                    <div class="d-flex justify-content-between align-items-center" style="width: 100%;">
                        <button class="btn btn-link text-start" onclick="selectDivision(${division.id}, '${division.name}')" 
                                style="text-decoration: none; color: inherit; padding: 10px 15px; flex: 1; text-align: left;">
                            <h6 class="mb-0">${division.name}</h6>
                        </button>
                        <div style="display: flex; gap: 4px; padding: 10px 15px; border-left: 1px solid #dee2e6;">
                            <button class="btn btn-xs btn-warning" style="padding: 4px 8px; font-size: 11px;" 
                                    onclick="event.stopPropagation(); showEditDivisionModal(${division.id}, '${division.name}')" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-xs btn-danger" style="padding: 4px 8px; font-size: 11px;" 
                                    onclick="event.stopPropagation(); deleteDivision(${division.id})" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `).join('') : '<p class="text-muted text-center small py-3">Tidak ada divisi</p>';
            
            document.getElementById('divisionsList').innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading divisions:', error);
            document.getElementById('divisionsList').innerHTML = '<p class="text-danger small">Error: ' + error.message + '</p>';
        });
}

// Select division and load departments
function selectDivision(divisionId, divisionName) {
    console.log('selectDivision called:', {divisionId, divisionName});
    currentSelectedDivisionId = divisionId;
    currentSelectedDeptId = null;
    
    // Update active state
    document.querySelectorAll('.division-item').forEach(btn => {
        btn.classList.remove('active');
    });
    document.getElementById('division-' + divisionId).classList.add('active');
    
    // Show add department button
    document.getElementById('addDepartmentBtn').style.display = 'block';
    
    // Reset departments and files
    document.getElementById('departmentsList').innerHTML = '<p class="text-muted text-center py-4">Memuat department...</p>';
    document.getElementById('filesList').innerHTML = '<p class="text-muted text-center py-4">Pilih department terlebih dahulu</p>';
    
    loadDepartments(divisionId);
}

// Load departments for selected division
function loadDepartments(divisionId) {
    console.log('Fetching departments for division:', divisionId);
    fetch('/api/division/' + divisionId + '/departments')
        .then(response => {
            if (!response.ok) throw new Error('HTTP ' + response.status);
            return response.json();
        })
        .then(data => {
            console.log('Departments loaded:', data);
            const departments = data.departments || [];
            
            let html = departments.length > 0 ? departments.map(department => `
                <div class="list-group-item text-start department-item" id="department-${department.id}" style="padding: 0;">
                    <div class="d-flex justify-content-between align-items-center" style="width: 100%;">
                        <button class="btn btn-link text-start" onclick="selectDepartment(${department.id}, '${department.name}')" 
                                style="text-decoration: none; color: inherit; padding: 10px 15px; flex: 1; text-align: left;">
                            <h6 class="mb-0">${department.name}</h6>
                        </button>
                        <div style="display: flex; gap: 4px; padding: 10px 15px; border-left: 1px solid #dee2e6;">
                            <button class="btn btn-xs btn-warning" style="padding: 4px 8px; font-size: 11px;" 
                                    onclick="event.stopPropagation(); showEditDepartmentModal(${department.id}, '${department.name}')" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-xs btn-danger" style="padding: 4px 8px; font-size: 11px;" 
                                    onclick="event.stopPropagation(); deleteDepartmentFn(${department.id})" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `).join('') : '<p class="text-muted text-center small py-3">Tidak ada department</p>';
            
            document.getElementById('departmentsList').innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading departments:', error);
            document.getElementById('departmentsList').innerHTML = '<p class="text-danger small">Error: ' + error.message + '</p>';
        });
}

// Select department and load files
function selectDepartment(departmentId, departmentName) {
    console.log('selectDepartment called:', {departmentId, departmentName});
    currentSelectedDeptId = departmentId;
    
    // Update active state
    document.querySelectorAll('.department-item').forEach(item => {
        item.classList.remove('active');
    });
    document.getElementById('department-' + departmentId).classList.add('active');
    
    // Load files
    loadFilesForDepartment(departmentId);
}

// Load files for selected department
let currentDepartmentId = null;

function loadFilesForDepartment(departmentId) {
    currentDepartmentId = departmentId;
    document.getElementById('addFileBtn').style.display = 'block';
    console.log('Fetching files for department:', departmentId);
    
    // Apply category filter if set
    let url = '/api/admin/department/' + departmentId + '/files';
    if (currentCategoryFilter) {
        url += '?category=' + currentCategoryFilter;
    }
    
    fetch(url)
        .then(response => {
            if (!response.ok) throw new Error('HTTP ' + response.status);
            return response.json();
        })
        .then(data => {
            console.log('Files loaded:', data);
            const files = data.files || [];
            
            let html = files.length > 0 ? files.map(file => {
                const sizeInKB = (file.file_size / 1024).toFixed(2);
                
                // Determine approval badge
                let approvalBadge = '';
                if (file.approval_status === 'approved') {
                    approvalBadge = '<span class="badge bg-success ms-2">✓ Approved</span>';
                } else if (file.approval_status === 'rejected') {
                    approvalBadge = '<span class="badge bg-danger ms-2">✗ Rejected</span>';
                } else {
                    approvalBadge = '<span class="badge bg-warning text-dark ms-2">⏳ Pending</span>';
                }
                
                return `
                    <div class="list-group-item text-start file-item" id="file-${file.id}" style="padding: 0;">
                        <div class="d-flex justify-content-between align-items-center" style="width: 100%;">
                            <button class="btn btn-link text-start" onclick="viewFile(${file.id}, '${file.file_name}', '${file.file_type}')" 
                                    style="text-decoration: none; color: inherit; padding: 10px 15px; flex: 1; text-align: left;">
                                <h6 class="mb-0">${file.file_name}</h6>
                                <small class="text-muted">${sizeInKB} KB ${approvalBadge}</small>
                            </button>
                            <div style="display: flex; gap: 4px; padding: 10px 15px; border-left: 1px solid #dee2e6;">
                                <a href="/file/${file.id}/download" class="btn btn-xs btn-outline-primary" style="padding: 4px 8px; font-size: 11px; text-decoration: none;" title="Download">
                                    <i class="bi bi-download"></i>
                                </a>
                                <button class="btn btn-xs btn-warning" style="padding: 4px 8px; font-size: 11px;" 
                                        onclick="showEditFileModal(${file.id}, '${file.file_name}', ${file.file_category_id})" title="Ubah Kategori">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-xs btn-danger" style="padding: 4px 8px; font-size: 11px;" 
                                        onclick="deleteFile(${file.id})" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            }).join('') : '<p class="text-muted text-center small py-3">Tidak ada file</p>';
            
            document.getElementById('filesList').innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading files:', error);
            document.getElementById('filesList').innerHTML = '<p class="text-danger small">Error: ' + error.message + '</p>';
        });
}

// Add director modal
// View file
function viewFile(fileId, fileName, fileType) {
    const viewableTypes = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'txt'];
    if (viewableTypes.includes(fileType.toLowerCase())) {
        window.open('/file/' + fileId + '/view', '_blank');
    } else {
        window.location.href = '/file/' + fileId + '/download';
    }
}

// Add director modal
function showAddDirectorModal() {
    const modal = `
        <div class="modal fade" id="addDirectorModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Director</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Jabatan</label>
                            <input type="text" class="form-control" id="directorTitle" placeholder="Contoh: PRESIDENT DIRECTOR">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" id="directorName" placeholder="Contoh: JOHN DOE">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" onclick="createDirector()">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modal);
    new bootstrap.Modal(document.getElementById('addDirectorModal')).show();
}

// Create director
function createDirector() {
    const title = document.getElementById('directorTitle').value.trim();
    const name = document.getElementById('directorName').value.trim();
    
    if (!title) {
        alert('Jabatan harus diisi');
        return;
    }
    
    if (!name) {
        alert('Nama harus diisi');
        return;
    }
    
    fetch('/api/directors', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({title: title, name: name})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Director berhasil ditambahkan');
            bootstrap.Modal.getInstance(document.getElementById('addDirectorModal')).hide();
            loadDirectors();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal menambahkan director');
    });
}

// Edit director modal
function showEditDirectorModal(directorId, title, name) {
    const modal = `
        <div class="modal fade" id="editDirectorModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Director</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Jabatan</label>
                            <input type="text" class="form-control" id="editDirectorTitle" value="${title}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" id="editDirectorName" value="${name}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" onclick="updateDirector(${directorId})">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modal);
    new bootstrap.Modal(document.getElementById('editDirectorModal')).show();
}

// Update director
function updateDirector(directorId) {
    const title = document.getElementById('editDirectorTitle').value.trim();
    const name = document.getElementById('editDirectorName').value.trim();
    
    if (!title) {
        alert('Jabatan harus diisi');
        return;
    }
    
    if (!name) {
        alert('Nama harus diisi');
        return;
    }
    
    fetch('/api/director/' + directorId, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({title: title, name: name})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Director berhasil diubah');
            bootstrap.Modal.getInstance(document.getElementById('editDirectorModal')).hide();
            loadDirectors();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal mengubah director');
    });
}

// Delete director
function deleteDirector(directorId) {
    if (confirm('Apakah Anda yakin ingin menghapus director ini?')) {
        fetch('/api/director/' + directorId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Director berhasil dihapus');
                loadDirectors();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal menghapus director');
        });
    }
}

// Add file modal
function showAddFileModal() {
    if (!currentDepartmentId) {
        alert('Silakan pilih department terlebih dahulu');
        return;
    }
    
    // Build category options
    let categoryOptions = '<option value="">Pilih Kategori</option>';
    categoriesData.forEach(cat => {
        categoryOptions += `<option value="${cat.id}">${cat.name}</option>`;
    });
    
    const modal = `
        <div class="modal fade" id="addFileModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" id="fileCategory">
                                ${categoryOptions}
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">File</label>
                            <input type="file" class="form-control" id="fileInput">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" onclick="uploadFileAsAdmin()">Upload</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modal);
    new bootstrap.Modal(document.getElementById('addFileModal')).show();
}

// Edit file modal
function showEditFileModal(fileId, fileName, categoryId) {
    // Build category options
    let categoryOptions = '<option value="">Pilih kategori</option>';
    categoriesData.forEach(cat => {
        const selected = cat.id == categoryId ? 'selected' : '';
        categoryOptions += `<option value="${cat.id}" ${selected}>${cat.name}</option>`;
    });
    
    const modal = `
        <div class="modal fade" id="editFileModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>File:</strong> ${fileName}</p>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" id="editCategorySelect">
                                ${categoryOptions}
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" onclick="updateFileCategory(${fileId})">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modal);
    new bootstrap.Modal(document.getElementById('editFileModal')).show();
}

// Upload file as admin
function uploadFileAsAdmin() {
    const fileInput = document.getElementById('fileInput');
    const categorySelect = document.getElementById('fileCategory');
    const file = fileInput.files[0];
    const categoryId = categorySelect.value;
    
    if (!file) {
        alert('Pilih file terlebih dahulu');
        return;
    }
    
    if (!categoryId) {
        alert('Pilih kategori terlebih dahulu');
        return;
    }
    
    const formData = new FormData();
    formData.append('file', file);
    formData.append('category_id', categoryId);
    
    fetch('/api/department/' + currentDepartmentId + '/upload', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('File berhasil diupload');
            bootstrap.Modal.getInstance(document.getElementById('addFileModal')).hide();
            loadFilesForDepartment(currentDepartmentId);
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal mengupload file');
    });
}

// Update file category
function updateFileCategory(fileId) {
    const categorySelect = document.getElementById('editCategorySelect');
    const categoryId = categorySelect.value;
    
    if (!categoryId) {
        alert('Pilih kategori terlebih dahulu');
        return;
    }
    
    fetch('/api/file/' + fileId + '/update-category', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({file_category_id: categoryId})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Kategori file berhasil diupdate');
            bootstrap.Modal.getInstance(document.getElementById('editFileModal')).hide();
            loadFilesForDepartment(currentDepartmentId);
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal mengupdate kategori file');
    });
}

// Delete file
function deleteFile(fileId) {
    if (confirm('Apakah Anda yakin ingin menghapus file ini?')) {
        fetch('/api/file/' + fileId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('File berhasil dihapus');
                loadFilesForDepartment(currentDepartmentId);
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal menghapus file');
        });
    }
}

// Filter by category (called from sidebar)
function filterOrgByCategory(categoryId, categoryName) {
    console.log('filterOrgByCategory called:', {categoryId, categoryName});
    currentCategoryFilter = categoryId;
    
    // Update heading with category name
    const categoryTitleSpan = document.getElementById('adminCategoryTitle');
    if (categoryTitleSpan) {
        if (categoryName) {
            categoryTitleSpan.textContent = categoryName;
        } else {
            categoryTitleSpan.textContent = '';
        }
    }
    
    // Update sidebar active state
    document.querySelectorAll('.category-link').forEach(link => {
        const linkId = link.getAttribute('data-category-id');
        if ((categoryId === null && linkId === null) || linkId == categoryId) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
    
    // Reset selections
    currentSelectedDirectorId = null;
    currentSelectedDivisionId = null;
    currentSelectedDeptId = null;
    
    // Clear all columns
    document.querySelectorAll('.director-item').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.division-item').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.department-item').forEach(btn => btn.classList.remove('active'));
    
    // Reset UI
    document.getElementById('divisionsList').innerHTML = '<p class="text-muted text-center py-4">Pilih director terlebih dahulu</p>';
    document.getElementById('departmentsList').innerHTML = '<p class="text-muted text-center py-4">Pilih divisi terlebih dahulu</p>';
    document.getElementById('filesList').innerHTML = '<p class="text-muted text-center py-4">Pilih department terlebih dahulu</p>';
    
    // Reload directors
    loadDirectors();
}

// Show add division modal
function showAddDivisionModal() {
    if (!currentSelectedDirectorId) {
        alert('Silakan pilih director terlebih dahulu');
        return;
    }
    
    const modal = `
        <div class="modal fade" id="addDivisionModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Divisi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Divisi</label>
                            <input type="text" class="form-control" id="divisionNameInput" placeholder="Masukkan nama divisi">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" onclick="createDivision()">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modal);
    new bootstrap.Modal(document.getElementById('addDivisionModal')).show();
}

// Create division
function createDivision() {
    const nameInput = document.getElementById('divisionNameInput');
    const name = nameInput.value.trim();
    
    if (!name) {
        alert('Masukkan nama divisi');
        return;
    }
    
    fetch('/api/director/' + currentSelectedDirectorId + '/divisions', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({name: name})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Divisi berhasil ditambahkan');
            bootstrap.Modal.getInstance(document.getElementById('addDivisionModal')).hide();
            loadDivisions(currentSelectedDirectorId);
        } else {
            alert('Error: ' + (data.message || 'Gagal menambahkan divisi'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal menambahkan divisi');
    });
}

// Show add department modal
function showAddDepartmentModal() {
    if (!currentSelectedDivisionId) {
        alert('Silakan pilih divisi terlebih dahulu');
        return;
    }
    
    const modal = `
        <div class="modal fade" id="addDepartmentModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Department</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Department</label>
                            <input type="text" class="form-control" id="departmentNameInput" placeholder="Masukkan nama department">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" onclick="createDepartment()">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modal);
    new bootstrap.Modal(document.getElementById('addDepartmentModal')).show();
}

// Create department
function createDepartment() {
    const nameInput = document.getElementById('departmentNameInput');
    const name = nameInput.value.trim();
    
    if (!name) {
        alert('Masukkan nama department');
        return;
    }
    
    fetch('/api/division/' + currentSelectedDivisionId + '/departments', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({name: name})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Department berhasil ditambahkan');
            bootstrap.Modal.getInstance(document.getElementById('addDepartmentModal')).hide();
            loadDepartments(currentSelectedDivisionId);
        } else {
            alert('Error: ' + (data.message || 'Gagal menambahkan department'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal menambahkan department');
    });
}

// Show edit division modal
function showEditDivisionModal(divisionId, divisionName) {
    const modal = `
        <div class="modal fade" id="editDivisionModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Divisi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Divisi</label>
                            <input type="text" class="form-control" id="editDivisionNameInput" value="${divisionName}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" onclick="updateDivisionFn(${divisionId})">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modal);
    new bootstrap.Modal(document.getElementById('editDivisionModal')).show();
}

// Update division
function updateDivisionFn(divisionId) {
    const nameInput = document.getElementById('editDivisionNameInput');
    const name = nameInput.value.trim();
    
    if (!name) {
        alert('Masukkan nama divisi');
        return;
    }
    
    fetch('/api/division/' + divisionId, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({name: name})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Divisi berhasil diupdate');
            bootstrap.Modal.getInstance(document.getElementById('editDivisionModal')).hide();
            loadDivisions(currentSelectedDirectorId);
        } else {
            alert('Error: ' + (data.message || 'Gagal mengupdate divisi'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal mengupdate divisi');
    });
}

// Delete division
function deleteDivision(divisionId) {
    if (confirm('Apakah Anda yakin ingin menghapus divisi ini?')) {
        fetch('/api/division/' + divisionId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Divisi berhasil dihapus');
                loadDivisions(currentSelectedDirectorId);
            } else {
                alert('Error: ' + (data.message || 'Gagal menghapus divisi'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal menghapus divisi');
        });
    }
}

// Show edit department modal
function showEditDepartmentModal(departmentId, departmentName) {
    const modal = `
        <div class="modal fade" id="editDepartmentModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Department</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Department</label>
                            <input type="text" class="form-control" id="editDepartmentNameInput" value="${departmentName}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" onclick="updateDepartmentFn(${departmentId})">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modal);
    new bootstrap.Modal(document.getElementById('editDepartmentModal')).show();
}

// Update department
function updateDepartmentFn(departmentId) {
    const nameInput = document.getElementById('editDepartmentNameInput');
    const name = nameInput.value.trim();
    
    if (!name) {
        alert('Masukkan nama department');
        return;
    }
    
    fetch('/api/department/' + departmentId, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({name: name})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Department berhasil diupdate');
            bootstrap.Modal.getInstance(document.getElementById('editDepartmentModal')).hide();
            loadDepartments(currentSelectedDivisionId);
        } else {
            alert('Error: ' + (data.message || 'Gagal mengupdate department'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal mengupdate department');
    });
}

// Delete department
function deleteDepartmentFn(departmentId) {
    if (confirm('Apakah Anda yakin ingin menghapus department ini?')) {
        fetch('/api/department/' + departmentId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Department berhasil dihapus');
                loadDepartments(currentSelectedDivisionId);
            } else {
                alert('Error: ' + (data.message || 'Gagal menghapus department'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal menghapus department');
        });
    }
}

// Approve file
function approveFile(fileId) {
    if (confirm('Apakah Anda yakin ingin approve file ini?')) {
        fetch('/api/file/' + fileId + '/approve', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('File berhasil di-approve');
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Gagal approve file'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal approve file');
        });
    }
}

// Reject file
function rejectFile(fileId) {
    if (confirm('Apakah Anda yakin ingin reject file ini?')) {
        fetch('/api/file/' + fileId + '/reject', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('File berhasil di-reject');
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Gagal reject file'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal reject file');
        });
    }
}

// Approve all files
function approveAllFiles() {
    // Get all file IDs from approval buttons
    const approvalButtons = Array.from(document.querySelectorAll('.approval-btn'));
    
    if (approvalButtons.length === 0) {
        alert('Tidak ada file untuk di-approve');
        return;
    }
    
    const fileIds = approvalButtons.map(btn => btn.getAttribute('data-file-id')).filter(id => id);
    
    if (fileIds.length === 0) {
        alert('Tidak dapat membaca file IDs');
        return;
    }
    
    const fileCount = fileIds.length;
    
    if (!confirm(`Apakah Anda yakin ingin approve ${fileCount} file sekaligus?`)) {
        return;
    }
    
    // Show processing indicator
    const buttons = document.querySelectorAll('.approval-btn');
    buttons.forEach(btn => {
        btn.disabled = true;
        btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Processing...';
    });
    
    // Approve all files sequentially
    let approvedCount = 0;
    let failedCount = 0;
    
    const approveNext = (index) => {
        if (index >= fileIds.length) {
            // All done
            let message = `Selesai! ${approvedCount} file berhasil di-approve`;
            if (failedCount > 0) {
                message += `, ${failedCount} gagal`;
            }
            alert(message);
            location.reload();
            return;
        }
        
        const fileId = fileIds[index];
        
        fetch('/api/file/' + fileId + '/approve', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                approvedCount++;
                console.log(`File ${fileId} approved (${index + 1}/${fileIds.length})`);
            } else {
                failedCount++;
                console.error(`File ${fileId} approval failed`, data);
            }
            // Continue to next file
            approveNext(index + 1);
        })
        .catch(error => {
            console.error('Error approving file ' + fileId + ':', error);
            failedCount++;
            // Continue to next file
            approveNext(index + 1);
        });
    };
    
    // Start approval process
    approveNext(0);
}

// Reject all files
function rejectAllFiles() {
    // Get all file IDs from approval buttons
    const approvalButtons = Array.from(document.querySelectorAll('.approval-btn'));
    
    if (approvalButtons.length === 0) {
        alert('Tidak ada file untuk di-reject');
        return;
    }
    
    const fileIds = approvalButtons.map(btn => btn.getAttribute('data-file-id')).filter(id => id);
    
    if (fileIds.length === 0) {
        alert('Tidak dapat membaca file IDs');
        return;
    }
    
    const fileCount = fileIds.length;
    
    if (!confirm(`Apakah Anda yakin ingin reject ${fileCount} file sekaligus?`)) {
        return;
    }
    
    // Show processing indicator
    const buttons = document.querySelectorAll('.approval-btn');
    buttons.forEach(btn => {
        btn.disabled = true;
        btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Processing...';
    });
    
    // Reject all files sequentially
    let rejectedCount = 0;
    let failedCount = 0;
    
    const rejectNext = (index) => {
        if (index >= fileIds.length) {
            // All done
            let message = `Selesai! ${rejectedCount} file berhasil di-reject`;
            if (failedCount > 0) {
                message += `, ${failedCount} gagal`;
            }
            alert(message);
            location.reload();
            return;
        }
        
        const fileId = fileIds[index];
        
        fetch('/api/file/' + fileId + '/reject', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                rejectedCount++;
                console.log(`File ${fileId} rejected (${index + 1}/${fileIds.length})`);
            } else {
                failedCount++;
                console.error(`File ${fileId} rejection failed`, data);
            }
            // Continue to next file
            rejectNext(index + 1);
        })
        .catch(error => {
            console.error('Error rejecting file ' + fileId + ':', error);
            failedCount++;
            // Continue to next file
            rejectNext(index + 1);
        });
    };
    
    // Start rejection process
    rejectNext(0);
}

    // Delete All Files Function
    function deleteAllFiles() {
        const fileCount = {{ \App\Models\DepartmentFile::count() }};
        
        if (fileCount === 0) {
            alert('Tidak ada file untuk dihapus');
            return;
        }

        if (!confirm(`Yakin mau menghapus semua ${fileCount} file? Operasi ini tidak bisa dibatalkan!`)) {
            return;
        }

        fetch('/api/admin/files/delete-all', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + (data.error || 'Gagal menghapus file'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal menghapus file: ' + error.message);
        });
    }

</script>

@endsection
