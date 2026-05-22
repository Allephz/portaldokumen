@extends('layouts.app')

@section('title', 'User Dashboard - Portal ISO 9001')

@section('content')
<div id="dashboardContent">
            @if($department)
                <div class="page-header">
                    <h2><i class="bi bi-folder-fill"></i> Dashboard <span id="categoryTitle">{{ $selectedCategory->name ?? 'Kategori' }}</span></h2>
                    <p>
                        Department: <strong>{{ $department->name }}</strong>
                        @if($division)
                            | Divisi: <strong>{{ $division->name }}</strong>
                        @endif
                    </p>
                </div>

                <div class="row">
                    <!-- Welcome Card -->
                    <div class="col-lg-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 28px; margin-right: 20px;">
                                        <i class="bi bi-person-check"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-2">Selamat Datang, <strong>{{ auth()->user()->name }}</strong></h5>
                                        <p class="text-muted mb-0">Anda dapat mengelola file di department <strong>{{ $department->name }}</strong>. Pilih kategori di sidebar untuk melihat atau menambah file.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload File Form -->
                    <div class="col-lg-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="mb-0"><i class="bi bi-cloud-upload"></i> Tambah File</h5>
                            </div>
                            <div class="card-body">
                                <form id="uploadForm">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Pilih File (Max 10MB)</label>
                                            <input type="file" class="form-control" id="fileInput" required>
                                        </div>
                                    </div>
                                    <div class="alert alert-info small mb-3">
                                        <i class="bi bi-info-circle"></i> File akan disimpan ke kategori: <strong><span id="selectedCategoryDisplay">pilih kategori di sidebar</span></strong>
                                    </div>
                                    <button type="button" class="btn btn-success" id="uploadBtn" onclick="uploadFile({{ $department->id }})">
                                        <i class="bi bi-upload"></i> Upload
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Files List -->
                    <div class="col-lg-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="mb-0"><i class="bi bi-file-earmark-text"></i> Daftar File</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush" id="filesList">
                                    <p class="text-muted text-center py-4">Pilih kategori untuk melihat file</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i> Anda belum ditetapkan ke department manapun. Hubungi admin untuk pengaturan lebih lanjut.
                </div>
            @endif
</div>

<script>
let currentCategoryId = {{ $selectedCategory->id ?? 'null' }};
let departmentId = {{ $department->id ?? 'null' }};

// Load category files on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard loaded. currentCategoryId:', currentCategoryId, 'departmentId:', departmentId);
    if (currentCategoryId && departmentId && currentCategoryId !== 'null') {
        console.log('Loading initial category...');
        loadCategory(currentCategoryId, '{{ $selectedCategory->name ?? '' }}', departmentId);
    } else {
        console.log('No category or department selected');
    }
});

// Handle category click from sidebar
function handleCategoryClick(event, categoryId, categoryName) {
    event.preventDefault();
    console.log('Category clicked:', {categoryId, categoryName});
    loadCategory(categoryId, categoryName, departmentId);
}

function loadCategory(categoryId, categoryName, deptId) {
    console.log('loadCategory called:', {categoryId, categoryName, deptId});
    currentCategoryId = categoryId;
    
    // Update active link in sidebar
    document.querySelectorAll('.category-link').forEach(link => {
        const linkId = link.getAttribute('data-category-id');
        if (linkId == categoryId) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });

    document.getElementById('categoryTitle').textContent = categoryName;
    
    // Update display kategori di form upload
    const selectedCategoryDisplay = document.getElementById('selectedCategoryDisplay');
    if (selectedCategoryDisplay) {
        selectedCategoryDisplay.textContent = categoryName;
    }

    const url = `/api/department/${deptId}/files?category=${categoryId}`;
    console.log('Fetching:', url);
    
    fetch(url)
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Files data:', data);
            const files = data.files || [];
            let filesHTML = files.length > 0 ? files.map(file => {
                const sizeInKB = (file.file_size / 1024).toFixed(2);
                return `
                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <div class="flex-grow-1">
                            <div class="d-flex gap-2 align-items-center">
                                <i class="bi bi-file-earmark"></i>
                                <div>
                                    <h6 class="mb-0">${file.file_name}</h6>
                                    <small class="text-muted">${sizeInKB} KB | ${file.created_at}</small>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-info" onclick="viewFile(${file.id}, '${file.file_name}', '${file.file_type}')">
                                <i class="bi bi-eye"></i> View
                            </button>
                            <a href="/file/${file.id}/download" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-download"></i> Download
                            </a>
                        </div>
                    </div>
                `;
            }).join('') : '<p class="text-muted text-center py-4">Belum ada file di kategori ini</p>';
            
            console.log('Setting filesList HTML, files count:', files.length);
            document.getElementById('filesList').innerHTML = filesHTML;
        })
        .catch(error => {
            console.error('Error loading files:', error);
            document.getElementById('filesList').innerHTML = '<p class="text-danger text-center py-4">Error: ' + error.message + '</p>';
        });
}

// Function to upload file
function uploadFile(deptId) {
    const fileInput = document.getElementById('fileInput');
    const file = fileInput.files[0];
    const categoryId = currentCategoryId;

    if (!file) {
        alert('Pilih file terlebih dahulu!');
        return;
    }

    if (!categoryId) {
        alert('Pilih kategori di sidebar terlebih dahulu!');
        return;
    }

    if (file.size > 10 * 1024 * 1024) {
        alert('Ukuran file terlalu besar (max 10MB)!');
        return;
    }

    console.log('Uploading file:', {file: file.name, categoryId: categoryId, departmentId: deptId});

    const formData = new FormData();
    formData.append('file', file);
    formData.append('category_id', categoryId);

    const uploadBtn = document.getElementById('uploadBtn');
    uploadBtn.disabled = true;
    uploadBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Uploading...';

    fetch(`/api/department/${deptId}/upload`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: formData
    })
    .then(response => {
        console.log('Upload response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Upload response data:', data);
        if (data.success) {
            alert('File berhasil diupload!');
            fileInput.value = '';
            uploadBtn.disabled = false;
            uploadBtn.innerHTML = '<i class="bi bi-upload"></i> Upload';
            
            // Reload files in current category
            console.log('Upload success, reloading category files...');
            loadCategory(currentCategoryId, document.getElementById('categoryTitle').textContent, deptId);
        } else {
            alert('Gagal upload file: ' + (data.error || 'Unknown error'));
            if (data.messages) {
                console.error('Validation errors:', data.messages);
            }
            uploadBtn.disabled = false;
            uploadBtn.innerHTML = '<i class="bi bi-upload"></i> Upload';
        }
    })
    .catch(error => {
        console.error('Upload error:', error);
        alert('Terjadi kesalahan saat upload: ' + error.message);
        uploadBtn.disabled = false;
        uploadBtn.innerHTML = '<i class="bi bi-upload"></i> Upload';
    });
}

// Function to view file
function viewFile(fileId, fileName, fileType) {
    const viewableTypes = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'txt'];
    
    if (viewableTypes.includes(fileType.toLowerCase())) {
        window.open(`/file/${fileId}/view`, '_blank');
    } else {
        window.location.href = `/file/${fileId}/download`;
    }
}
</script>

<style>
#dashboardContent {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
</style>
@endsection

