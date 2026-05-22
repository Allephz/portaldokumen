<div class="sidebar">
    <!-- Sidebar Brand -->
    <div class="sidebar-brand">
        <h5><i class="bi bi-file-earmark-text"></i> Portal ISO 9001</h5>
        <small>Sistem Manajemen Kualitas</small>
    </div>

    <!-- Sidebar Navigation -->
    <nav class="sidebar-nav">
        @php
            // For user, admin, and manager dashboards, show file categories
            $categories = \App\Models\FileCategory::getOrdered();
            $isUserDashboard = Route::is('user.dashboard');
            $isAdminDashboard = Route::is('admin.dashboard');
            $isManagerDashboard = Route::is('manager.dashboard');
        @endphp

        @if(($isUserDashboard || $isAdminDashboard || $isManagerDashboard) && $categories->count() > 0)
            <!-- File Categories (User, Admin & Manager Dashboard) -->
            @foreach($categories as $category)
                <div class="nav-item">
                    <a href="javascript:void(0);" 
                       class="nav-link category-link" 
                       data-category-id="{{ $category->id }}" 
                       data-category-name="{{ $category->name }}"
                       onclick="handleCategoryClick(event, {{ $category->id }}, '{{ addslashes($category->name) }}')"
                       style="display: flex; align-items: center; gap: 10px;">
                        <i class="bi {{ $category->icon ?? 'bi-folder' }}"></i>
                        <span>{{ $category->name }}</span>
                    </a>
                </div>
            @endforeach
        @endif
    </nav>
</div>
