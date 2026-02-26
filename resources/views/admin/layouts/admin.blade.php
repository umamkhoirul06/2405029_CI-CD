<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard' }} - {{ config('app.name') }}</title>
    <meta name="author" content="Umam">
    
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <style>
        [x-cloak] { display: none !important; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #6366f1; border-radius: 10px; }

        .sidebar-gradient {
            background: linear-gradient(180deg, #4f46e5 0%, #3730a3 100%);
        }
        
        .nav-link-active {
            @apply bg-white/10 border-l-4 border-white pl-4 text-white;
        }
    </style>
    @stack('head')
</head>

<body class="bg-slate-50 font-sans antialiased text-slate-900">

    <aside class="fixed inset-y-0 left-0 z-50 w-72 sidebar-gradient shadow-2xl transition-transform duration-300 transform -translate-x-full sm:translate-x-0">
        
        <div class="flex items-center justify-center h-20 border-b border-white/10">
            <a href="{{ route('admin.index') }}" class="flex items-center space-x-3">
                <div class="p-2 bg-white rounded-xl shadow-lg">
                    <i class="fas fa-rocket text-indigo-600 text-xl"></i>
                </div>
                <span class="text-white text-2xl font-bold tracking-tight uppercase">Blog<span class="font-light">CMS</span></span>
            </a>
        </div>

        <nav class="mt-6 px-4 space-y-2">
            <p class="text-xs font-semibold text-indigo-200 uppercase px-4 mb-2 opacity-50">Main Menu</p>
            
            <a href="{{ route('admin.index') }}" class="flex items-center space-x-3 text-indigo-100 p-3 rounded-xl transition duration-200 hover:bg-white/10 group {{ request()->routeIs('admin.index') ? 'nav-link-active' : '' }}">
                <i class="fas fa-columns w-5 text-center group-hover:scale-110 transition"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            @can('admin-only')
            <a href="{{ route('admin.category.index') }}" class="flex items-center space-x-3 text-indigo-100 p-3 rounded-xl transition duration-200 hover:bg-white/10 group {{ request()->routeIs('*.category.*') ? 'nav-link-active' : '' }}">
                <i class="fas fa-folder-tree w-5 text-center"></i>
                <span class="font-medium">Categories</span>
            </a>
            @endcan

            <a href="{{ route('admin.post.index') }}" class="flex items-center space-x-3 text-indigo-100 p-3 rounded-xl transition duration-200 hover:bg-white/10 group {{ request()->routeIs('*.post.*') ? 'nav-link-active' : '' }}">
                <i class="fas fa-file-signature w-5 text-center"></i>
                <span class="font-medium">Posts Management</span>
            </a>

            <div class="pt-4 pb-2">
                <p class="text-xs font-semibold text-indigo-200 uppercase px-4 opacity-50">System Settings</p>
            </div>

            @can('admin-only')
            <a href="{{ route('admin.user.index') }}" class="flex items-center space-x-3 text-indigo-100 p-3 rounded-xl transition duration-200 hover:bg-white/10 group">
                <i class="fas fa-user-shield w-5 text-center"></i>
                <span class="font-medium">User Access</span>
            </a>
            @endcan

            <form method="POST" action="{{ route('logout') }}" class="pt-10">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-3 text-red-200 p-3 rounded-xl hover:bg-red-500/20 hover:text-red-100 transition duration-200">
                    <i class="fas fa-power-off w-5 text-center"></i>
                    <span class="font-medium font-bold">Sign Out</span>
                </button>
            </form>
        </nav>
    </aside>

    <div class="sm:ml-72 min-h-screen flex flex-col">
        
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40 flex items-center justify-between px-8">
            <h1 class="text-xl font-bold text-slate-800">{{ $title ?? 'Dashboard' }}</h1>

            <div class="flex items-center space-x-6">
                <div class="hidden md:flex relative">
                    <input type="text" placeholder="Search data..." class="bg-slate-100 border-none rounded-full px-5 py-2 text-sm focus:ring-2 focus:ring-indigo-500 w-64 transition-all">
                    <i class="fas fa-search absolute right-4 top-3 text-slate-400"></i>
                </div>

                <div class="flex items-center space-x-3 border-l pl-6 border-slate-200">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-slate-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-indigo-600 font-medium">Administrator</p>
                    </div>
                    <img src="{{ $user_avatar }}" class="w-10 h-10 rounded-full object-cover border-2 border-indigo-500 p-0.5 shadow-sm">
                </div>
            </div>
        </header>

        <main class="p-8 flex-1">
            <div class="animate-fade-in-up">
                {{ $slot }}
            </div>
        </main>

        <footer class="p-6 bg-white border-t border-slate-200 text-center text-sm text-slate-500">
            <p>© {{ date('Y') }} <strong>{{ config('app.name') }}</strong>. Built with 
                <i class="fas fa-heart text-red-500 animate-pulse"></i> by 
                <span class="text-indigo-600 font-bold underline">Umam</span>
            </p>
        </footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        @if(session('message'))
            toastr.success("{{ session('message') }}");
        @endif
        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>
    @stack('scripts')
</body>
</html>