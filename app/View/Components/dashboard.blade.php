<x-admin-layout title="Dashboard">
    
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            Statistics
        </h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center transition hover:-translate-y-1 hover:shadow-md duration-300">
            <h3 class="text-gray-600 font-semibold text-sm mb-2">Categories</h3>
            <p class="text-4xl font-bold text-blue-600">{{ $stats['categories'] }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center transition hover:-translate-y-1 hover:shadow-md duration-300">
            <h3 class="text-gray-600 font-semibold text-sm mb-2">Posts</h3>
            <p class="text-4xl font-bold text-blue-600">{{ $stats['posts'] }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center transition hover:-translate-y-1 hover:shadow-md duration-300">
            <h3 class="text-gray-600 font-semibold text-sm mb-2">Tags</h3>
            <p class="text-4xl font-bold text-blue-600">{{ $stats['tags'] }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center transition hover:-translate-y-1 hover:shadow-md duration-300">
            <h3 class="text-gray-600 font-semibold text-sm mb-2">Users</h3>
            <p class="text-4xl font-bold text-blue-600">{{ $stats['users'] }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center transition hover:-translate-y-1 hover:shadow-md duration-300">
            <h3 class="text-gray-600 font-semibold text-sm mb-2 text-center">Newsletter Subscribers</h3>
            <p class="text-4xl font-bold text-blue-600">{{ $stats['subscribers'] }}</p>
        </div>

    </div>

</x-admin-layout>