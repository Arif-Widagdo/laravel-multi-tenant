<x-central.app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-slate-800">Tenant Overview</h2>
            <a href="{{ route('tenants.edit', $tenant) }}"
                class="inline-flex items-center gap-1 px-4 py-2 text-sm font-medium text-white transition rounded-lg bg-primary hover:bg-primary/75">
                ✏️ Edit Tenant
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="px-4 mx-auto space-y-8 max-w-7xl sm:px-6 lg:px-8">

            <!-- Tenant Summary Card -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="p-6 space-y-4 bg-white border shadow rounded-2xl border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-700">📄 Tenant Info</h3>
                    <div>
                        <div class="text-sm text-slate-500">Name</div>
                        <div class="text-base font-medium text-slate-800">{{ $tenant->name }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-slate-500">Email</div>
                        <div class="text-base font-medium text-slate-800">{{ $tenant->email }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-slate-500">Primary Domain</div>
                        <div class="text-base font-medium text-slate-800">
                            {{ $tenant->domains->first()->domain ?? '-' }}
                        </div>
                    </div>
                </div>

                <!-- Tenant Status (Dummy Slot for future use) -->
                <div class="p-6 space-y-4 bg-white border shadow rounded-2xl border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-700">🛠 Status</h3>
                    <p class="text-sm text-slate-600">Tenant is currently <span class="font-semibold text-green-600">active</span>.</p>
                    <p class="text-sm text-slate-500">Created at: {{ $tenant->created_at->format('d M Y') }}</p>
                </div>
            </div>

            <!-- Tabs Section -->
            <div x-data="{ tab: 'users' }" class="bg-white border shadow rounded-2xl border-slate-200">
                <!-- Tab Navigation -->
                <div class="px-6 pt-4 border-b border-slate-200">
                    <nav class="flex space-x-8" aria-label="Tabs">
                        <button @click="tab = 'users'"
                            :class="tab === 'users' ? 'text-indigo-600 border-indigo-600' : 'text-slate-500 hover:text-slate-700 border-transparent'"
                            class="pb-3 text-sm font-medium transition border-b-2">
                            👤 Users
                        </button>
                        <button @click="tab = 'posts'"
                            :class="tab === 'posts' ? 'text-indigo-600 border-indigo-600' : 'text-slate-500 hover:text-slate-700 border-transparent'"
                            class="pb-3 text-sm font-medium transition border-b-2">
                            📝 Posts
                        </button>
                    </nav>
                </div>

                <!-- Tab Contents -->
                <div class="p-6">
                    <!-- Users Table -->
                    <div x-show="tab === 'users'" x-cloak>
                        <div class="overflow-x-auto border rounded-lg border-slate-200">
                            <table class="min-w-full text-sm bg-white text-slate-700">
                                <thead class="text-xs uppercase bg-slate-50 text-slate-500">
                                    <tr>
                                        <th class="px-6 py-3 text-left">ID</th>
                                        <th class="px-6 py-3 text-left">Name</th>
                                        <th class="px-6 py-3 text-left">Email</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse ($users as $user)
                                        <tr class="transition hover:bg-slate-50">
                                            <td class="px-6 py-4">{{ $user->id }}</td>
                                            <td class="px-6 py-4">{{ $user->name }}</td>
                                            <td class="px-6 py-4">{{ $user->email }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 text-center text-slate-400">No users found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Posts Table -->
                    <div x-show="tab === 'posts'" x-cloak>
                        <div class="overflow-x-auto border rounded-lg border-slate-200">
                            <table class="min-w-full text-sm bg-white text-slate-700">
                                <thead class="text-xs uppercase bg-slate-50 text-slate-500">
                                    <tr>
                                        <th class="px-6 py-3 text-left">ID</th>
                                        <th class="px-6 py-3 text-left">Title</th>
                                        <th class="px-6 py-3 text-left">Author</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse ($posts as $post)
                                        <tr class="transition hover:bg-slate-50">
                                            <td class="px-6 py-4">{{ $post->id }}</td>
                                            <td class="px-6 py-4">{{ $post->title }}</td>
                                            <td class="px-6 py-4">{{ $post->user->name ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 text-center text-slate-400">No posts found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Tabs Section -->

        </div>
    </div>
</x-central.app-layout>
