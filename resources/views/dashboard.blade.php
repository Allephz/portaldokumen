@extends('layouts.app')

@section('title', 'Dashboard - Portal ISO 9001')

@section('content')
<div id="dashboardContent">
<div class="page-header">
    <h2><i class="bi bi-house-fill"></i> Dashboard</h2>
    <p>Selamat Datang di Portal Dokumen ISO 9001</p>
</div>

<div class="row">
    <!-- Welcome Card -->
    <div class="col-lg-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 28px; margin-right: 20px;">
                        <i class="bi bi-hand-thumbs-up"></i>
                    </div>
                    <div>
                        <h5 class="mb-2">Selamat Datang, <strong>{{ auth()->user()->name ?? 'User' }}</strong></h5>
                        <p class="text-muted mb-0">Anda telah berhasil login ke Portal Dokumen ISO 9001. Gunakan menu di sebelah kiri untuk mengakses folder manual, SOP, instruksi kerja, dan informasi lainnya.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-2">Folder Manual</p>
                        <h4 class="mb-0">12</h4>
                    </div>
                    <div style="width: 50px; height: 50px; background: rgba(168, 85, 247, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #a855f7;">
                        <i class="bi bi-folder" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-2">SOP Dokumen</p>
                        <h4 class="mb-0">28</h4>
                    </div>
                    <div style="width: 50px; height: 50px; background: rgba(59, 130, 246, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #3b82f6;">
                        <i class="bi bi-file-earmark-check" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-2">Instruksi Kerja</p>
                        <h4 class="mb-0">45</h4>
                    </div>
                    <div style="width: 50px; height: 50px; background: rgba(34, 197, 94, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #22c55e;">
                        <i class="bi bi-list-task" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-2">Catatan/Rekaman</p>
                        <h4 class="mb-0">18</h4>
                    </div>
                    <div style="width: 50px; height: 50px; background: rgba(239, 68, 68, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #ef4444;">
                        <i class="bi bi-camera-video" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Access -->
    <div class="col-lg-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h6 class="mb-0"><i class="bi bi-lightning-fill"></i> Akses Cepat</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <a href="#" class="btn btn-outline-primary w-100 py-3 d-flex align-items-center justify-content-center gap-2" style="text-decoration: none; color: #3b82f6;">
                            <i class="bi bi-folder"></i>
                            <span>Folder Manual</span>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="#" class="btn btn-outline-info w-100 py-3 d-flex align-items-center justify-content-center gap-2" style="text-decoration: none; color: #06b6d4;">
                            <i class="bi bi-file-earmark-check"></i>
                            <span>SOP Dokumen</span>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="#" class="btn btn-outline-success w-100 py-3 d-flex align-items-center justify-content-center gap-2" style="text-decoration: none; color: #22c55e;">
                            <i class="bi bi-list-task"></i>
                            <span>Instruksi Kerja</span>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="#" class="btn btn-outline-danger w-100 py-3 d-flex align-items-center justify-content-center gap-2" style="text-decoration: none; color: #ef4444;">
                            <i class="bi bi-camera-video"></i>
                            <span>Catatan/Rekaman</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h6 class="mb-0"><i class="bi bi-clock-history"></i> Informasi Sistem</h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <div>
                            <h6 class="mb-1">Portal ISO 9001</h6>
                            <small class="text-muted">Sistem Manajemen Kualitas Terintegrasi</small>
                        </div>
                        <span class="badge bg-success">Online</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <div>
                            <h6 class="mb-1">Database</h6>
                            <small class="text-muted">Semua dokumen tersimpan aman</small>
                        </div>
                        <span class="badge bg-success">Terhubung</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <div>
                            <h6 class="mb-1">Server</h6>
                            <small class="text-muted">Status: Responsif</small>
                        </div>
                        <span class="badge bg-success">Baik</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script>
    // Data dari backend Laravel dengan ID
    const directors = {!! json_encode($directors) !!};

    // Global function to show director list
    function showDirectorList(category) {
        const dashboardContent = document.getElementById('dashboardContent');
        
        let directorsHTML = directors.map(director => `
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card border-0 shadow-sm h-100" style="cursor: pointer; transition: all 0.3s; border-left: 4px solid #8B5CF6;" 
                     onclick="showDirectorDetails(${director.id}, '${director.title}', '${director.name}', '${category}')">
                    <div class="card-body text-center">
                        <div style="font-size: 32px; margin-bottom: 10px; color: #8B5CF6;">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <h4 class="card-title mb-1" style="font-size: 18px; font-weight: 700;">${director.title}</h4>
                        <p class="text-muted small mt-2">${director.name}</p>
                    </div>
                </div>
            </div>
        `).join('');
        
        dashboardContent.innerHTML = `
            <div class="page-header mb-4">
                <h2><i class="bi bi-people"></i> Daftar Director</h2>
                <p>Kategori: <strong>${category}</strong></p>
            </div>
            <div class="row">
                ${directorsHTML}
            </div>
        `;
    }

    // Global function to show director details
    function showDirectorDetails(directorId, directorTitle, directorName, category) {
        const dashboardContent = document.getElementById('dashboardContent');
        
        // Fetch divisions from API
        fetch(`/api/director/${directorId}/divisions`)
            .then(response => response.json())
            .then(data => {
                const divisions = data.divisions || [];
                const actualDirectorName = data.director.name; // Get actual name from DB
                
                let divisionsHTML = divisions.map(division => `
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #06B6D4;">
                            <div class="card-body" style="cursor: pointer;" onclick="showDivisionDocuments(${division.id}, '${division.name}', '${actualDirectorName}', '${category}')">
                                <div style="font-size: 28px; margin-bottom: 10px; color: #06B6D4;">
                                    <i class="bi bi-diagram-3"></i>
                                </div>
                                <h5 class="card-title" style="font-weight: 600;">${division.name}</h5>
                                <p class="text-muted small mt-2">Klik untuk melihat department</p>
                            </div>
                            <div class="card-footer bg-white border-top py-2 d-flex gap-2">
                                <button class="btn btn-sm btn-primary flex-grow-1" onclick="event.stopPropagation(); editDivision(${division.id}, '${division.name}', '${actualDirectorName}', '${directorTitle}', ${directorId}, '${category}')">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="event.stopPropagation(); deleteDivisionConfirm(${division.id}, ${directorId}, '${directorTitle}', '${actualDirectorName}', '${category}')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                `).join('');
                
                dashboardContent.innerHTML = `
                    <div class="page-header">
                        <h2><i class="bi bi-file-earmark-text"></i> ${category} - ${directorTitle}</h2>
                        <p>Divisi yang ada dibawah: <strong>${actualDirectorName}</strong></p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-white border-bottom">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0"><i class="bi bi-person-circle"></i> ${directorTitle}</h5>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-primary" onclick="editDirector(${directorId}, '${actualDirectorName}', '${directorTitle}', '${category}')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary" onclick="showDirectorList('${category}')">
                                                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Director
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-4">
                                        <h6 class="mb-3">Informasi Director</h6>
                                        <div class="list-group list-group-flush">
                                            <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                                <span>Nama Director</span>
                                                <strong>${actualDirectorName}</strong>
                                            </div>
                                            <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                                <span>Posisi</span>
                                                <strong>${directorTitle}</strong>
                                            </div>
                                            <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                                <span>Status</span>
                                                <span class="badge bg-success">Aktif</span>
                                            </div>
                                            <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                                <span>Total Divisi</span>
                                                <strong>${divisions.length}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="mb-3"><i class="bi bi-diagram-3"></i> Divisi & Departemen</h6>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div></div>
                        <button class="btn btn-sm btn-success" onclick="showAddDivisionForm(${directorId}, '${actualDirectorName}', '${directorTitle}', '${category}')">
                            <i class="bi bi-plus"></i> Tambah Divisi
                        </button>
                    </div>
                    <div class="row">
                        ${divisionsHTML}
                    </div>
                `;
            })
            .catch(error => {
                console.error('Error fetching divisions:', error);
                dashboardContent.innerHTML = `<div class="alert alert-danger">Error loading divisions</div>`;
            });
    }

    // Function to show division and its departments
    function showDivisionDocuments(divisionId, divisionName, directorName, category) {
        const dashboardContent = document.getElementById('dashboardContent');
        
        // Fetch departments for this division
        fetch(`/api/division/${divisionId}/departments`)
            .then(response => response.json())
            .then(data => {
                const departments = data.departments || [];
                
                let departmentsHTML = departments.map(dept => `
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #10B981; cursor: pointer;" onclick="showDepartmentFiles(${dept.id}, '${dept.name}', ${divisionId}, '${divisionName}', '${directorName}', '${category}')">
                            <div class="card-body">
                                <div style="font-size: 28px; margin-bottom: 10px; color: #10B981;">
                                    <i class="bi bi-briefcase"></i>
                                </div>
                                <h5 class="card-title" style="font-weight: 600;">${dept.name}</h5>
                                <p class="text-muted small mt-2">Klik untuk lihat file</p>
                                <div class="mt-3 d-flex gap-2">
                                    <button class="btn btn-sm btn-primary" onclick="event.stopPropagation(); editDepartment(${dept.id}, '${dept.name}', ${divisionId}, '${divisionName}', '${directorName}', '${category}')">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="event.stopPropagation(); deleteDepartmentConfirm(${dept.id}, ${divisionId}, '${divisionName}', '${directorName}', '${category}')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `).join('');

                dashboardContent.innerHTML = `
                    <div class="page-header">
                        <h2><i class="bi bi-diagram-3"></i> ${divisionName}</h2>
                        <p>Director: <strong>${directorName}</strong> | Divisi: <strong>${divisionName}</strong></p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-white border-bottom">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0"><i class="bi bi-diagram-3"></i> ${divisionName}</h5>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-primary" onclick="editDivision(${divisionId}, '${divisionName}', '${directorName}', '${category}')">
                                                <i class="bi bi-pencil"></i> Edit Divisi
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary" onclick="location.reload()">
                                                <i class="bi bi-arrow-left"></i> Kembali
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-4">
                                        <h6 class="mb-3">Informasi Divisi</h6>
                                        <div class="list-group list-group-flush">
                                            <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                                <span>Nama Divisi</span>
                                                <strong>${divisionName}</strong>
                                            </div>
                                            <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                                <span>Director</span>
                                                <strong>${directorName}</strong>
                                            </div>
                                            <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                                <span>Total Department</span>
                                                <strong>${departments.length}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6><i class="bi bi-briefcase"></i> Department</h6>
                        <button class="btn btn-sm btn-success" onclick="showAddDepartmentForm(${divisionId}, '${divisionName}', '${directorName}', '${category}')">
                            <i class="bi bi-plus"></i> Tambah Department
                        </button>
                    </div>
                    <div class="row">
                        ${departmentsHTML}
                    </div>
                `;
            })
            .catch(error => {
                console.error('Error fetching departments:', error);
                dashboardContent.innerHTML = `<div class="alert alert-danger">Error loading departments</div>`;
            });
    }

    // Function to edit director
    function editDirector(directorId, directorName, directorTitle, category) {
        const dashboardContent = document.getElementById('dashboardContent');
        
        dashboardContent.innerHTML = `
            <div class="page-header">
                <h2><i class="bi bi-pencil-square"></i> Edit Director</h2>
                <p>Update informasi untuk: <strong>${directorName}</strong></p>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0">Form Edit Director</h5>
                        </div>
                        <div class="card-body">
                            <form id="editDirectorForm">
                                <div class="mb-3">
                                    <label class="form-label">Nama Director</label>
                                    <input type="text" class="form-control" value="${directorName}" id="directorNameInput" placeholder="Masukkan nama director">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Posisi</label>
                                    <input type="text" class="form-control" value="${directorTitle}" id="directorTitleInput" placeholder="Masukkan posisi">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select">
                                        <option selected>Aktif</option>
                                        <option>Tidak Aktif</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Departemen</label>
                                    <input type="text" class="form-control" value="Divisi Utama" placeholder="Masukkan departemen">
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="saveDirectorChanges(${directorId}, '${directorTitle}', '${category}')">
                                        <i class="bi bi-check-circle"></i> Simpan
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="showDirectorDetails(${directorId}, '${directorTitle}', '${directorName}', '${category}')">
                                        <i class="bi bi-x-circle"></i> Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Function to save director changes
    function saveDirectorChanges(directorId, directorTitle, category) {
        const newName = document.getElementById('directorNameInput').value;
        const newTitle = document.getElementById('directorTitleInput').value;

        if (!newName || !newTitle) {
            alert('Nama dan Posisi tidak boleh kosong!');
            return;
        }

        const dashboardContent = document.getElementById('dashboardContent');
        dashboardContent.innerHTML = `
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="bi bi-hourglass-split"></i> <strong>Menyimpan...</strong> Mohon tunggu sebentar.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        // Send update to API
        fetch(`/api/director/${directorId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({
                name: newName,
                title: newTitle
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                dashboardContent.innerHTML = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> <strong>Berhasil!</strong> Data director telah diperbarui.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
                
                setTimeout(() => {
                    showDirectorDetails(directorId, newTitle, newName, category);
                }, 2000);
            } else {
                alert('Gagal menyimpan data');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan');
        });
    }

    // Function to show add division form
    function showAddDivisionForm(directorId, directorName, directorTitle, category) {
        const dashboardContent = document.getElementById('dashboardContent');
        
        dashboardContent.innerHTML = `
            <div class="page-header">
                <h2><i class="bi bi-plus-circle"></i> Tambah Divisi</h2>
                <p>Director: <strong>${directorName}</strong></p>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Nama Divisi</label>
                                    <input type="text" class="form-control" id="newDivisionNameInput" placeholder="Masukkan nama divisi" required>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-success" onclick="addDivision(${directorId}, '${directorName}', '${directorTitle}', '${category}')">
                                        <i class="bi bi-check-circle"></i> Tambah
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="showDirectorDetails(${directorId}, '${directorTitle}', '${directorName}', '${category}')">
                                        <i class="bi bi-x-circle"></i> Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Function to add new division
    function addDivision(directorId, directorName, directorTitle, category) {
        const newName = document.getElementById('newDivisionNameInput').value;

        if (!newName) {
            alert('Nama divisi tidak boleh kosong!');
            return;
        }

        const dashboardContent = document.getElementById('dashboardContent');
        dashboardContent.innerHTML = `<div class="alert alert-info">Menambahkan...</div>`;

        fetch(`/api/director/${directorId}/divisions`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ name: newName })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Divisi berhasil ditambahkan!');
                showDirectorDetails(directorId, directorTitle, directorName, category);
            } else {
                alert('Gagal menambahkan divisi');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }

    // Function to edit division
    function editDivision(divisionId, divisionName, directorName, directorTitle, directorId, category) {
        const dashboardContent = document.getElementById('dashboardContent');
        
        dashboardContent.innerHTML = `
            <div class="page-header">
                <h2><i class="bi bi-pencil-square"></i> Edit Divisi</h2>
                <p>Ubah informasi divisi: <strong>${divisionName}</strong></p>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Nama Divisi</label>
                                    <input type="text" class="form-control" id="divisionNameInput" value="${divisionName}" required>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="saveDivisionChanges(${divisionId}, ${directorId}, '${directorTitle}', '${directorName}', '${category}')">
                                        <i class="bi bi-check-circle"></i> Simpan
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="showDirectorDetails(${directorId}, '${directorTitle}', '${directorName}', '${category}')">
                                        <i class="bi bi-x-circle"></i> Batal
                                    </button>
                                    <button type="button" class="btn btn-danger" onclick="deleteDivisionConfirm(${divisionId}, ${directorId}, '${directorTitle}', '${directorName}', '${category}')">
                                        <i class="bi bi-trash"></i> Hapus Divisi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Function to save division changes
    function saveDivisionChanges(divisionId, directorId, directorTitle, directorName, category) {
        const newName = document.getElementById('divisionNameInput').value;

        if (!newName) {
            alert('Nama divisi tidak boleh kosong!');
            return;
        }

        const dashboardContent = document.getElementById('dashboardContent');
        dashboardContent.innerHTML = `<div class="alert alert-info">Menyimpan...</div>`;

        fetch(`/api/division/${divisionId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ name: newName })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Divisi berhasil diperbarui!');
                showDirectorDetails(directorId, directorTitle, directorName, category);
            } else {
                alert('Gagal menyimpan divisi');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }

    // Function to confirm delete division
    function deleteDivisionConfirm(divisionId, directorId, directorTitle, directorName, category) {
        if (confirm('Apakah Anda yakin ingin menghapus divisi ini? Department di dalamnya juga akan dihapus.')) {
            deleteDivision(divisionId, directorId, directorTitle, directorName, category);
        }
    }

    // Function to delete division
    function deleteDivision(divisionId, directorId, directorTitle, directorName, category) {
        const dashboardContent = document.getElementById('dashboardContent');
        dashboardContent.innerHTML = `<div class="alert alert-info">Menghapus...</div>`;

        fetch(`/api/division/${divisionId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Divisi berhasil dihapus!');
                showDirectorDetails(directorId, directorTitle, directorName, category);
            } else {
                alert('Gagal menghapus divisi');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }

    // Function to show add department form
    function showAddDepartmentForm(divisionId, divisionName, directorName, category) {
        const dashboardContent = document.getElementById('dashboardContent');
        
        dashboardContent.innerHTML = `
            <div class="page-header">
                <h2><i class="bi bi-plus-circle"></i> Tambah Department</h2>
                <p>Divisi: <strong>${divisionName}</strong></p>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Nama Department</label>
                                    <input type="text" class="form-control" id="departmentNameInput" placeholder="Masukkan nama department" required>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-success" onclick="addDepartment(${divisionId}, ${divisionId}, '${divisionName}', '${directorName}', '${category}')">
                                        <i class="bi bi-check-circle"></i> Tambah
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="showDivisionDocuments(${divisionId}, '${divisionName}', '${directorName}', '${category}')">
                                        <i class="bi bi-x-circle"></i> Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Function to add new department
    function addDepartment(divisionIdForAdd, divisionId, divisionName, directorName, category) {
        const newName = document.getElementById('departmentNameInput').value;

        if (!newName) {
            alert('Nama department tidak boleh kosong!');
            return;
        }

        const dashboardContent = document.getElementById('dashboardContent');
        dashboardContent.innerHTML = `<div class="alert alert-info">Menambahkan...</div>`;

        fetch(`/api/division/${divisionIdForAdd}/departments`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ name: newName })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Department berhasil ditambahkan!');
                showDivisionDocuments(divisionId, divisionName, directorName, category);
            } else {
                alert('Gagal menambahkan department');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }

    // Function to edit department
    function editDepartment(departmentId, departmentName, divisionId, divisionName, directorName, category) {
        const dashboardContent = document.getElementById('dashboardContent');
        
        dashboardContent.innerHTML = `
            <div class="page-header">
                <h2><i class="bi bi-pencil-square"></i> Edit Department</h2>
                <p>Department: <strong>${departmentName}</strong></p>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Nama Department</label>
                                    <input type="text" class="form-control" id="departmentNameEditInput" value="${departmentName}" required>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="saveDepartmentChanges(${departmentId}, ${divisionId}, '${divisionName}', '${directorName}', '${category}')">
                                        <i class="bi bi-check-circle"></i> Simpan
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="showDivisionDocuments(${divisionId}, '${divisionName}', '${directorName}', '${category}')">
                                        <i class="bi bi-x-circle"></i> Batal
                                    </button>
                                    <button type="button" class="btn btn-danger" onclick="deleteDepartmentConfirm(${departmentId}, ${divisionId}, '${divisionName}', '${directorName}', '${category}')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Function to save department changes
    function saveDepartmentChanges(departmentId, divisionId, divisionName, directorName, category) {
        const newName = document.getElementById('departmentNameEditInput').value;

        if (!newName) {
            alert('Nama department tidak boleh kosong!');
            return;
        }

        const dashboardContent = document.getElementById('dashboardContent');
        dashboardContent.innerHTML = `<div class="alert alert-info">Menyimpan...</div>`;

        fetch(`/api/department/${departmentId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ name: newName })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Department berhasil diperbarui!');
                showDivisionDocuments(divisionId, divisionName, directorName, category);
            } else {
                alert('Gagal menyimpan department');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }

    // Function to confirm delete department
    function deleteDepartmentConfirm(departmentId, divisionId, divisionName, directorName, category) {
        if (confirm('Apakah Anda yakin ingin menghapus department ini?')) {
            deleteDepartment(departmentId, divisionId, divisionName, directorName, category);
        }
    }

    // Function to delete department
    function deleteDepartment(departmentId, divisionId, divisionName, directorName, category) {
        const dashboardContent = document.getElementById('dashboardContent');
        dashboardContent.innerHTML = `<div class="alert alert-info">Menghapus...</div>`;

        fetch(`/api/department/${departmentId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Department berhasil dihapus!');
                showDivisionDocuments(divisionId, divisionName, directorName, category);
            } else {
                alert('Gagal menghapus department');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }

    // Function to show department files
    function showDepartmentFiles(departmentId, departmentName, divisionId, divisionName, directorName, category) {
        const dashboardContent = document.getElementById('dashboardContent');
        
        // Fetch files untuk department ini
        fetch(`/api/department/${departmentId}/files`)
            .then(response => response.json())
            .then(data => {
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
                                <a href="/api/file/${file.id}/download" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-download"></i> Download
                                </a>
                                <button class="btn btn-sm btn-danger" onclick="deleteFileConfirm(${file.id}, ${departmentId}, '${departmentName}', ${divisionId}, '${divisionName}', '${directorName}', '${category}')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                    `;
                }).join('') : '<p class="text-muted">Belum ada file</p>';

                dashboardContent.innerHTML = `
                    <div class="page-header">
                        <h2><i class="bi bi-file-earmark"></i> ${departmentName}</h2>
                        <p>Divisi: <strong>${divisionName}</strong> | Director: <strong>${directorName}</strong></p>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-white border-bottom">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0"><i class="bi bi-folder"></i> ${departmentName}</h5>
                                        <button class="btn btn-sm btn-outline-secondary" onclick="showDivisionDocuments(${divisionId}, '${divisionName}', '${directorName}', '${category}')">
                                            <i class="bi bi-arrow-left"></i> Kembali ke Divisi
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-4">
                                        <h6 class="mb-3">Informasi Department</h6>
                                        <div class="list-group list-group-flush">
                                            <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                                <span>Nama Department</span>
                                                <strong>${departmentName}</strong>
                                            </div>
                                            <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                                <span>Divisi</span>
                                                <strong>${divisionName}</strong>
                                            </div>
                                            <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                                <span>Total File</span>
                                                <strong>${files.length}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload File Form -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-white border-bottom">
                                    <h5 class="mb-0"><i class="bi bi-cloud-upload"></i> Tambah File</h5>
                                </div>
                                <div class="card-body">
                                    <form id="uploadForm">
                                        <div class="mb-3">
                                            <label class="form-label">Pilih File (Max 10MB)</label>
                                            <input type="file" class="form-control" id="fileInput" required>
                                        </div>
                                        <button type="button" class="btn btn-success" onclick="uploadFile(${departmentId}, '${departmentName}', ${divisionId}, '${divisionName}', '${directorName}', '${category}')">
                                            <i class="bi bi-upload"></i> Upload
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Files List -->
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-bottom">
                                    <h5 class="mb-0"><i class="bi bi-file-earmark-text"></i> Daftar File</h5>
                                </div>
                                <div class="card-body">
                                    <div class="list-group list-group-flush">
                                        ${filesHTML}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            })
            .catch(error => {
                console.error('Error fetching files:', error);
                dashboardContent.innerHTML = `<div class="alert alert-danger">Error loading files</div>`;
            });
    }

    // Function to upload file
    function uploadFile(departmentId, departmentName, divisionId, divisionName, directorName, category) {
        const fileInput = document.getElementById('fileInput');
        const file = fileInput.files[0];

        if (!file) {
            alert('Pilih file terlebih dahulu!');
            return;
        }

        const formData = new FormData();
        formData.append('file', file);

        const dashboardContent = document.getElementById('dashboardContent');
        const originalHTML = dashboardContent.innerHTML;
        dashboardContent.innerHTML += '<div class="alert alert-info mt-3">Uploading...</div>';

        fetch(`/api/department/${departmentId}/upload`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('File berhasil diupload!');
                showDepartmentFiles(departmentId, departmentName, divisionId, divisionName, directorName, category);
            } else {
                alert('Gagal upload file: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat upload');
        });
    }

    // Function to view file
    function viewFile(fileId, fileName, fileType) {
        const viewableTypes = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'txt'];
        
        if (viewableTypes.includes(fileType.toLowerCase())) {
            // Open file in new tab for preview
            window.open(`/api/file/${fileId}/download`, '_blank');
        } else {
            // For other types, download directly
            window.location.href = `/api/file/${fileId}/download`;
        }
    }

    // Function to delete file
    function deleteFileConfirm(fileId, departmentId, departmentName, divisionId, divisionName, directorName, category) {
        if (confirm('Apakah Anda yakin ingin menghapus file ini?')) {
            deleteFile(fileId, departmentId, departmentName, divisionId, divisionName, directorName, category);
        }
    }

    function deleteFile(fileId, departmentId, departmentName, divisionId, divisionName, directorName, category) {
        fetch(`/api/file/${fileId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('File berhasil dihapus!');
                showDepartmentFiles(departmentId, departmentName, divisionId, divisionName, directorName, category);
            } else {
                alert('Gagal menghapus file');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }

    // Handle director menu link clicks
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.director-menu-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const category = this.getAttribute('data-category');
                showDirectorList(category);
            });
        });
    });
</script>
@endsection

