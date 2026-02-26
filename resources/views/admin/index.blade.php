<x-admin-layout>
    <div class="space-y-8">
        
        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center shadow-lg">
                        <i class="fas fa-chart-line text-white"></i>
                    </div>
                    <span>Dashboard Overview</span>
                </h1>
                <p class="text-slate-600 mt-2">Welcome back! Here's what's happening with your blog.</p>
            </div>
        </div>

        {{-- Statistics Grid --}}
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
            @foreach ($statistics as $stat)
                <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-slate-200/50 hover:border-indigo-500/30">
                    <div class="mb-4 text-sm font-semibold text-slate-600 uppercase tracking-wide">
                        {{ $stat['label'] }}
                    </div>
                    <div class="flex items-end justify-between">
                        <div>
                            <div class="text-4xl font-extrabold text-slate-900">{{ $stat['value'] }}</div>
                            <p class="text-xs text-slate-500 mt-1">Total records</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-lg flex items-center justify-center group-hover:from-indigo-200 group-hover:to-purple-200 transition">
                            <i class="fas fa-arrow-up text-indigo-600 text-lg"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Quick Actions --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Recent Posts --}}
            <div class="md:col-span-2 bg-white rounded-2xl shadow-md border border-slate-200/50 p-8">
                <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center space-x-3">
                    <i class="fas fa-newspaper text-indigo-600"></i>
                    <span>Recent Posts</span>
                </h2>
                <div class="space-y-4">
                    {{-- Placeholder content --}}
                    <p class="text-slate-500 text-center py-8">Latest posts will appear here</p>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="bg-white rounded-2xl shadow-md border border-slate-200/50 p-8">
                <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center space-x-3">
                    <i class="fas fa-lightning-bolt text-purple-600"></i>
                    <span>Quick Actions</span>
                </h2>
                <div class="space-y-3">
                    <a href="{{ route('admin.post.create') }}" class="block px-4 py-3 bg-gradient-to-r from-indigo-600 to-indigo-500 text-white rounded-lg font-semibold hover:shadow-lg transition-all duration-300 text-center transform hover:scale-105">
                        <i class="fas fa-plus mr-2"></i> New Post
                    </a>
                    <a href="{{ route('admin.post.index') }}" class="block px-4 py-3 bg-slate-100 text-slate-700 rounded-lg font-semibold hover:bg-slate-200 transition text-center">
                        <i class="fas fa-list mr-2"></i> View Posts
                    </a>
                    <a href="{{ route('admin.category.index') }}" class="block px-4 py-3 bg-slate-100 text-slate-700 rounded-lg font-semibold hover:bg-slate-200 transition text-center">
                        <i class="fas fa-folder mr-2"></i> Categories
                    </a>
                    <a href="{{ route('admin.tag.index') }}" class="block px-4 py-3 bg-slate-100 text-slate-700 rounded-lg font-semibold hover:bg-slate-200 transition text-center">
                        <i class="fas fa-tags mr-2"></i> Tags
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
