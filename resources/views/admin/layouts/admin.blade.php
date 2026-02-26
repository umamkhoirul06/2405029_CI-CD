<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog CMS - Admin Dashboard</title>
    <meta name="author" content="Yasser Elgammal">
    <meta name="description" content="Admin panel for managing blog content and settings.">
    <!-- Tailwind -->
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #818cf8;
        }
        
        body {
            @apply bg-gradient-to-br from-slate-50 via-slate-50 to-slate-100;
        }

        .sidebar {
            @apply transition-all duration-300;
        }

        .nav-item {
            @apply transition-all duration-200 hover:bg-white/10 hover:pl-8;
        }

        .active-nav-link {
            @apply bg-white/20 border-l-4 border-white/50 pl-5 backdrop-blur-sm;
        }

        .btn-primary {
            @apply bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-700 hover:to-indigo-600 text-white font-medium py-2 px-4 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105;
        }

        .card {
            @apply bg-white rounded-lg shadow-md border border-slate-200 hover:shadow-lg transition-shadow duration-200;
        }

        .header-search {
            @apply transition-all duration-200 focus-within:shadow-md;
        }
    </style>
    @stack('head')
</head>

<body class="font-sans antialiased">

    <!-- Sidebar -->
    <aside
        class="sidebar hidden sm:flex fixed inset-y-0 left-0 w-72 flex-col z-40 bg-gradient-to-b from-indigo-600 via-indigo-600 to-indigo-700 shadow-2xl">
        
        <!-- Logo Section -->
        <div class="p-6 border-b border-indigo-500/30">
            <a href="{{ route('admin.index') }}" class="flex items-center space-x-3 group">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center group-hover:bg-white/30 transition">
                    <i class="fas fa-pencil-alt text-white text-lg"></i>
                </div>
                <div>
                    <div class="text-white text-xl font-bold">{{ config('app.name', 'BlogCMS') }}</div>
                    <div class="text-indigo-200 text-xs">
                        @can('admin-only')
                            Admin Panel
                        @else
                            Writer Panel
                        @endcan
                    </div>
                </div>
            </a>
        </div>

        <!-- New Post Button -->
        <div class="px-6 py-4 border-b border-indigo-500/30">
            <button onclick="location.href='{{ route('admin.post.create') }}';"
                class="w-full btn-primary flex items-center justify-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>New Post</span>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto px-3 py-6 space-y-1">
            <a href="{{ route('admin.index') }}"
                class="nav-item {{ request()->routeIs('admin.index') ? 'active-nav-link' : 'text-indigo-100' }} flex items-center space-x-3 px-4 py-3 rounded-lg">
                <i class="fas fa-chart-line w-5 text-center"></i>
                <span>Dashboard</span>
            </a>

            @can('admin-only')
                <a href="{{ route('admin.category.index') }}"
                    class="nav-item {{ request()->routeIs('*.category.*') ? 'active-nav-link' : 'text-indigo-100' }} flex items-center space-x-3 px-4 py-3 rounded-lg">
                    <i class="fas fa-folder w-5 text-center"></i>
                    <span>Categories</span>
                </a>
            @endcan

            <a href="{{ route('admin.post.index') }}"
                class="nav-item {{ request()->routeIs('*.post.*') ? 'active-nav-link' : 'text-indigo-100' }} flex items-center space-x-3 px-4 py-3 rounded-lg">
                <i class="fas fa-newspaper w-5 text-center"></i>
                <span>Posts</span>
            </a>

            <a href="{{ route('admin.tag.index') }}"
                class="nav-item {{ request()->routeIs('*.tag.*') ? 'active-nav-link' : 'text-indigo-100' }} flex items-center space-x-3 px-4 py-3 rounded-lg">
                <i class="fas fa-tags w-5 text-center"></i>
                <span>Tags</span>
            </a>

            @can('admin-only')
                <a href="{{ route('admin.page.index') }}"
                    class="nav-item {{ request()->routeIs('*.page.*') ? 'active-nav-link' : 'text-indigo-100' }} flex items-center space-x-3 px-4 py-3 rounded-lg">
                    <i class="far fa-file w-5 text-center"></i>
                    <span>Pages</span>
                </a>

                <div class="border-t border-indigo-500/30 my-2"></div>

                <a href="{{ route('admin.role.index') }}"
                    class="nav-item {{ request()->routeIs('*.role.*') ? 'active-nav-link' : 'text-indigo-100' }} flex items-center space-x-3 px-4 py-3 rounded-lg">
                    <i class="fas fa-shield-alt w-5 text-center"></i>
                    <span>Roles</span>
                </a>

                <a href="{{ route('admin.user.index') }}"
                    class="nav-item {{ request()->routeIs('*.user.*') ? 'active-nav-link' : 'text-indigo-100' }} flex items-center space-x-3 px-4 py-3 rounded-lg">
                    <i class="fas fa-users w-5 text-center"></i>
                    <span>Users</span>
                </a>

                <a href="{{ route('admin.setting.index') }}"
                    class="nav-item {{ request()->routeIs('*.setting.*') ? 'active-nav-link' : 'text-indigo-100' }} flex items-center space-x-3 px-4 py-3 rounded-lg">
                    <i class="fas fa-cog w-5 text-center"></i>
                    <span>Settings</span>
                </a>
            @endcan
        </nav>

        <!-- Logout Button -->
        <div class="p-6 border-t border-indigo-500/30">
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button class="w-full flex items-center justify-center space-x-2 text-indigo-100 hover:text-white bg-indigo-500/20 hover:bg-indigo-500/40 py-3 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Sign Out</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Layout -->
    <div class="sm:ml-72 flex flex-col min-h-screen">

        <!-- Header -->
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-slate-200/50 shadow-sm">
            <div class="flex items-center justify-between px-4 sm:px-6 py-4">

                <!-- Search Bar -->
                <form action="{{ route('admin.post.search') }}" method="GET" class="header-search flex-1 max-w-md">
                    <div class="relative">
                        <input class="w-full bg-slate-100 border border-slate-200 rounded-lg pl-4 pr-10 py-2 text-sm placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                            type="text" placeholder="Search posts..." name="search" value="{{ old('search') }}">
                        <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-slate-600 transition">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    @error('search')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </form>

                <!-- Profile Menu -->
                <div x-data="{ isOpen: false }" class="relative ml-6">
                    <button @click="isOpen = !isOpen" @click.away="isOpen = false"
                        class="flex items-center space-x-2 hover:bg-slate-100 rounded-lg p-2 transition duration-200 group">
                        <img src="{{ $user_avatar }}" alt="Profile" class="w-10 h-10 rounded-full border-2 border-slate-200 object-cover group-hover:border-indigo-500 transition">
                        <i class="fas fa-chevron-down text-slate-500 text-xs"></i>
                    </button>

                    <div x-show="isOpen"
                        class="absolute right-0 mt-2 w-48 card py-1 z-50"
                        @click.away="isOpen = false">
                        <a href="{{ route('admin.account.index') }}"
                            class="block px-4 py-3 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition flex items-center space-x-2">
                            <i class="fas fa-user-circle"></i>
                            <span>My Account</span>
                        </a>
                        <hr class="my-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="block w-full text-left px-4 py-3 text-sm text-slate-700 hover:bg-red-50 hover:text-red-600 transition flex items-center space-x-2">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto px-4 sm:px-6 py-8">
            <div class="max-w-7xl mx-auto">
                {{ $slot }}
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 px-4 sm:px-6 py-4 text-center text-sm text-slate-600">
            <p>© {{ date('Y') }} Blog CMS. Developed with <i class="fas fa-heart text-red-500"></i> by <a href="#" class="text-indigo-600 hover:text-indigo-700 font-medium">Your Team</a></p>
        </footer>

    </div>

    <!-- Font Awesome and Alpine.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Toastr Configuration
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        @if (session('message'))
            toastr.success("{{ session('message') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>

    @stack('scripts')
</body>

</html>
