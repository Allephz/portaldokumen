<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - Portal ISO 9001')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            padding-top: 20px;
            z-index: 1000;
        }

        .sidebar-brand {
            padding: 20px;
            color: white;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .sidebar-brand h5 {
            margin: 0;
            font-weight: 700;
            font-size: 16px;
        }

        .sidebar-brand small {
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
        }

        .sidebar-nav {
            padding: 0 15px;
        }

        .sidebar-nav .nav-item {
            margin-bottom: 8px;
        }

        .sidebar-nav .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 16px;
            border-radius: 6px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            cursor: pointer;
            border: none;
            width: 100%;
            text-align: left;
            background: none;
        }

        .sidebar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            padding-left: 20px;
        }

        .sidebar-nav .nav-link.active {
            background-color: rgba(168, 85, 247, 0.3);
            color: white;
            border-left: 3px solid #a855f7;
            padding-left: 13px;
        }

        .sidebar-nav .nav-link i {
            width: 24px;
            margin-right: 12px;
            text-align: center;
        }

        .sidebar-nav .collapse-item {
            padding-left: 45px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 5px;
        }

        .sidebar-nav .collapse-item a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            display: block;
            padding: 8px 12px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .sidebar-nav .collapse-item a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            padding-left: 16px;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        /* Top Navbar */
        .navbar-top {
            background: white;
            border-bottom: 1px solid #e0e0e0;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 900;
            flex-shrink: 0;
            height: 70px;
            display: flex;
            width: 100%;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .navbar-top .navbar-brand {
            margin: 0;
            font-weight: 600;
            color: #2c3e50;
            flex-grow: 1;
            white-space: nowrap;
        }

        .navbar-top .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-shrink: 0;
        }

        .navbar-top .user-avatar {
            width: 40px;
            height: 40px;
            min-width: 40px;
            background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            cursor: pointer;
            flex-shrink: 0;
        }

        /* Content Area */
        .content-area {
            padding: 30px;
            flex: 1;
            overflow: auto;
            -webkit-overflow-scrolling: touch;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-header h2 {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .page-header p {
            color: #7f8c8d;
            font-size: 14px;
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 250px;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .content-area {
                padding: 20px;
            }

            .navbar-top {
                padding: 12px 20px;
            }
        }

        /* Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="navbar-top">
            <div class="navbar-brand">Dashboard Portal ISO 9001</div>
            <div class="user-menu">
                <span class="text-muted small">{{ auth()->user()->name ?? 'User' }}</span>
                <div class="user-avatar" title="{{ auth()->user()->email ?? 'user@example.com' }}">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger" style="border: none; background: none; padding: 0; cursor: pointer;">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <!-- Chatbot Component -->
    @include('components.chatbot')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/chatbot.js') }}"></script>
    @yield('scripts')
</body>
</html>
