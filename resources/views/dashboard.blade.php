<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-blue-600 rounded-lg shadow-lg p-6 mb-8 text-white">
                <h3 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                <p class="mt-2 opacity-90">Sistem CI/CD kamu sudah berjalan di <strong>khoirul.cicd.web.id</strong>. Berikut ringkasan data kamu hari ini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border-b-4 border-blue-500 p-6 transition hover:scale-105 duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium uppercase">Categories</p>
                            <p class="text-3xl font-bold text-gray-800">12</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-xl border-b-4 border-green-500 p-6 transition hover:scale-105 duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium uppercase">Total Posts</p>
                            <p class="text-3xl font-bold text-gray-800">45</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-xl border-b-4 border-purple-500 p-6 transition hover:scale-105 duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium uppercase">Users</p>
                            <p class="text-3xl font-bold text-gray-800">150</p>
                        </div>
                        <div class="p-3 bg-purple-100 rounded-full">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-xl border-b-4 border-red-500 p-6 transition hover:scale-105 duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium uppercase">CI/CD Status</p>
                            <p class="text-lg font-bold text-green-600 animate-pulse">Active & Online</p>
                        </div>
                        <div class="p-3 bg-red-100 rounded-full">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                    </div>
                </div>

            </div>

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 italic underline decoration-blue-500">Tugas CI/CD Berhasil Terpenuhi!</h4>
                    <div class="p-4 bg-gray-50 rounded-lg border border-dashed border-gray-300 text-gray-700">
                        Pesan: "Website ini telah melewati tahap pengujian <strong>php artisan test</strong> dan dideploy menggunakan <strong>GitHub Actions</strong>."
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>