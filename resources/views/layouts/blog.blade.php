<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @isset($title)
            {{ ucfirst($title) }} |
        @endisset
        {{ config('app.name') }}
    </title>

    @vite(['resources/css/blog.css', 'resources/js/blog.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            @apply bg-gradient-to-br from-slate-50 via-white to-slate-100 font-["Plus Jakarta Sans"];
        }

        .card-hover {
            @apply transition-all duration-300 ease-out;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            @apply shadow-xl;
        }

        .badge-glow {
            @apply inline-block px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 hover:shadow-lg;
        }

        .nav-item-active {
            @apply relative after:absolute after:bottom-0 after:left-0 after:right-0 after:h-1 after:bg-gradient-to-r after:from-indigo-600 after:to-purple-600 after:rounded-full;
        }

        .prose {
            @apply prose prose-slate max-w-none prose-h1:text-3xl prose-h1:font-bold prose-h2:text-2xl prose-a:text-indigo-600 hover:prose-a:text-indigo-700 prose-code:bg-slate-100 prose-code:rounded prose-code:px-2 prose-code:py-1;
        }
    </style>
</head>

<body class="antialiased">
    {{-- Flash Messages --}}
    @if (Session::has('message') || Session::has('error'))
        <div class="fixed top-6 right-6 z-50" x-data="{ show: true }" x-show="show" @click.away="show = false">
            <div class="rounded-lg bg-white {{ Session::has('message') ? 'border-l-4 border-green-500' : 'border-l-4 border-red-500' }} shadow-xl p-4 flex items-start gap-4 max-w-md">
                <i class="fas {{ Session::has('message') ? 'fa-check-circle text-green-600' : 'fa-exclamation-circle text-red-600' }} text-xl flex-shrink-0 mt-0.5"></i>
                <div class="flex-1">
                    <p class="text-slate-900 font-medium text-sm">
                        {{ Session::has('message') ? 'Success!' : 'Error!' }}
                    </p>
                    <p class="text-slate-600 text-sm mt-1">
                        {{ Session::get('message') ?? Session::get('error') }}
                    </p>
                </div>
                <button @click="show = false" class="text-slate-400 hover:text-slate-600 flex-shrink-0">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    {{-- Navigation --}}
    <nav class="sticky top-0 z-40 bg-white/80 backdrop-blur-lg border-b border-slate-200/50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                {{-- Logo --}}
                <a href="{{ route('webhome') }}" class="flex items-center space-x-2 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition">
                        <i class="fas fa-feather text-white"></i>
                    </div>
                    <span class="text-xl font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        {{ config('app.name') }}
                    </span>
                </a>

                {{-- Center Navigation --}}
                <ul class="hidden md:flex items-center space-x-1">
                    @foreach ($pages_nav as $page)
                        <li>
                            <a href="{{ route('page.show', $page->slug) }}"
                                class="nav-item-active px-4 py-2 text-sm font-medium text-slate-700 hover:text-indigo-600 transition-colors {{ request()->routeIs('page.show') && request('slug') == $page->slug ? 'text-indigo-600' : '' }}">
                                {{ $page->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                {{-- Right Icons & Auth --}}
                <div class="flex items-center space-x-4">

                    {{-- Social Icons --}}
                    <div class="hidden sm:flex items-center space-x-3">
                        @if ($setting->url_fb)
                            <a href="{{ $setting->url_fb }}" target="_blank" class="w-9 h-9 rounded-full bg-slate-100 text-slate-600 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition-all duration-300">
                                <i class="fab fa-facebook-f text-sm"></i>
                            </a>
                        @endif

                        @if ($setting->url_insta)
                            <a href="{{ $setting->url_insta }}" target="_blank" class="w-9 h-9 rounded-full bg-slate-100 text-slate-600 hover:bg-pink-600 hover:text-white flex items-center justify-center transition-all duration-300">
                                <i class="fab fa-instagram text-sm"></i>
                            </a>
                        @endif

                        @if ($setting->url_twitter)
                            <a href="{{ $setting->url_twitter }}" target="_blank" class="w-9 h-9 rounded-full bg-slate-100 text-slate-600 hover:bg-sky-500 hover:text-white flex items-center justify-center transition-all duration-300">
                                <i class="fab fa-twitter text-sm"></i>
                            </a>
                        @endif

                        @if ($setting->url_linkedin)
                            <a href="{{ $setting->url_linkedin }}" target="_blank" class="w-9 h-9 rounded-full bg-slate-100 text-slate-600 hover:bg-blue-700 hover:text-white flex items-center justify-center transition-all duration-300">
                                <i class="fab fa-linkedin-in text-sm"></i>
                            </a>
                        @endif
                    </div>

                    {{-- Auth Buttons --}}
                    @auth
                        @can('admin-login')
                            <a href="{{ route('admin.index') }}"
                                class="px-4 py-2 rounded-lg bg-gradient-to-r from-emerald-600 to-emerald-500 text-white text-sm font-semibold hover:shadow-lg transition-all duration-300">
                                Dashboard
                            </a>
                        @endcan

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button class="px-4 py-2 rounded-lg bg-slate-100 text-slate-700 text-sm font-semibold hover:bg-slate-200 transition-all duration-300">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 rounded-lg bg-slate-100 text-slate-700 text-sm font-semibold hover:bg-slate-200 transition-all duration-300">
                            Sign Up
                        </a>

                        <a href="{{ route('login') }}"
                            class="px-4 py-2 rounded-lg bg-gradient-to-r from-indigo-600 to-indigo-500 text-white text-sm font-semibold hover:shadow-lg transition-all duration-300">
                            Login
                        </a>
                    @endauth

                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Header --}}
    <header class="bg-gradient-to-br from-white via-blue-50/30 to-purple-50/30 border-b border-slate-200/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
            <h1 class="text-5xl md:text-6xl font-extrabold bg-gradient-to-r from-indigo-600 via-purple-600 to-rose-600 bg-clip-text text-transparent">
                {{ $setting->site_name }}
            </h1>
            <p class="mt-4 text-lg text-slate-600 max-w-2xl mx-auto">
                {{ $setting->description }}
            </p>
        </div>
    </header>

    {{-- Category Menu --}}
    <div class="bg-white/50 backdrop-blur-sm border-b border-slate-200/50 sticky top-20 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @include('front.partials.category-menu', [
                'categories' => $categories,
                'level' => 0,
                'orientation' => 'horizontal',
            ])
        </div>
    </div>

    {{-- Main Content Area --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            {{-- Main Content --}}
            <main class="lg:col-span-2">
                {{ $slot }}
            </main>

            {{-- Sidebar --}}
            @if (!request()->routeIs('page.show'))
                <aside class="space-y-8">

                    {{-- About Widget --}}
                    <div class="card-hover bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                        <div class="flex items-center space-x-3 mb-4">
                            <i class="fas fa-circle text-indigo-600 text-xs"></i>
                            <h3 class="text-lg font-bold text-slate-900">About This Blog</h3>
                        </div>
                        <p class="text-slate-600 leading-relaxed text-sm">{{ $setting->about }}</p>
                    </div>

                    {{-- Tags Widget --}}
                    <div class="card-hover bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                        <div class="flex items-center space-x-3 mb-5">
                            <i class="fas fa-circle text-purple-600 text-xs"></i>
                            <h3 class="text-lg font-bold text-slate-900">Popular Tags</h3>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @forelse ($tags as $tag)
                                <a href="{{ route('tag.show', $tag->name) }}"
                                    class="badge-glow px-3 py-1.5 text-xs font-semibold bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 hover:from-purple-200 hover:to-pink-200">
                                    #{{ $tag->name }}
                                </a>
                            @empty
                                <p class="text-sm text-slate-500">No tags yet.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Top Writers Widget --}}
                    <div class="card-hover bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                        <div class="flex items-center space-x-3 mb-5">
                            <i class="fas fa-circle text-rose-600 text-xs"></i>
                            <h3 class="text-lg font-bold text-slate-900">Top Writers</h3>
                        </div>

                        <div class="space-y-3">
                            @forelse ($top_users as $top)
                                <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors duration-200">
                                    <img src="{{ $top->avatar }}" alt="{{ $top->name }}" class="w-12 h-12 rounded-full object-cover border-2 border-slate-200">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-slate-900 truncate">{{ $top->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $top->posts_count }} posts</p>
                                    </div>
                                    <span class="inline-block px-2.5 py-1 text-xs font-bold bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-full whitespace-nowrap">
                                        ✨ Writer
                                    </span>
                                </div>
                            @empty
                                <p class="text-sm text-slate-500 text-center py-4">No writers found.</p>
                            @endforelse
                        </div>
                    </div>

                </aside>
            @endif

        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-gradient-to-b from-white to-slate-50 border-t border-slate-200/50 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            {{-- Footer Links --}}
            <div class="flex flex-wrap items-center justify-center gap-4 pb-8 border-b border-slate-200">
                @foreach ($pages_footer as $page)
                    <a href="{{ route('page.show', $page->slug) }}"
                        class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors {{ request()->routeIs('page.show') && request('slug') == $page->slug ? 'text-indigo-600' : '' }}">
                        {{ $page->name }}
                    </a>
                @endforeach
            </div>

            {{-- Copyright & Credits --}}
            <div class="pt-8 text-center">
                <p class="text-slate-600 text-sm">
                    {{ $setting->copy_rights }}
                </p>
                <p class="text-slate-500 text-xs mt-3">
                    Built with <span class="text-rose-600">❤️</span> using Laravel & Tailwind CSS
                </p>
            </div>

        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>

</html>
