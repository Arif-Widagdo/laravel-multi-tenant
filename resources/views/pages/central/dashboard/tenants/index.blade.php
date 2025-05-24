<x-central.app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Tenants') }}
            <x-btn-link class="float-right" href="{{ route('tenants.create') }}">Create Tenant</x-btn-link>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="flex flex-col p-6 text-gray-900 gap-y-2">
                    <div class="relative overflow-x-auto">
                        <table class="min-w-full text-sm divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-medium tracking-wider text-left text-gray-500 uppercase">#</th>
                                    <th scope="col" class="px-6 py-3 font-medium tracking-wider text-left text-gray-500 uppercase">Name</th>
                                    <th scope="col" class="px-6 py-3 font-medium tracking-wider text-left text-gray-500 uppercase">Email</th>
                                    <th scope="col" class="px-6 py-3 font-medium tracking-wider text-left text-gray-500 uppercase">Domain</th>
                                    <th scope="col" class="px-6 py-3 font-medium tracking-wider text-right text-gray-500 uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @if(count($tenants) > 0)
                                    @foreach ($tenants as $tenant)
                                        <tr class="transition hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">1</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $tenant->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $tenant->email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @foreach ($tenant->domains as $domain)
                                                    @php
                                                        /**
                                                        * Ambil skema protokol dari request aktif (http atau https)
                                                        * Contoh: 'http' atau 'https'
                                                        */
                                                        $scheme = request()->getScheme();

                                                        /**
                                                        * Ambil port dari request aktif
                                                        * Contoh: 8000, 443, atau 80
                                                        */
                                                        $port = request()->getPort();

                                                        /**
                                                        * Tentukan port default berdasarkan skema
                                                        * - https biasanya menggunakan port 443
                                                        * - http biasanya menggunakan port 80
                                                        */
                                                        $defaultPort = $scheme === 'https' ? 443 : 80;

                                                        /**
                                                        * Jika port yang digunakan bukan port default, maka tambahkan ke URL
                                                        * Contoh hasil:
                                                        * - Jika port 8000 → :8000
                                                        * - Jika port 80 (default http) → (tidak ditampilkan)
                                                        */
                                                        $portPart = ($port != $defaultPort) ? ':' . $port : '';

                                                        /**
                                                        * Bentuk URL lengkap dari domain tenant
                                                        * Format akhir: {scheme}://{domain}{optional_port}
                                                        * Contoh:
                                                        * - http://tenant1.localhost
                                                        * - https://tenant1.rsudkemayoran.go.id:8443
                                                        */
                                                        $fullDomain = $scheme . '://' . $domain->domain . $portPart;
                                                    @endphp

                                                    {{-- Tampilkan link domain tenant dengan target tab baru --}}
                                                    <a target="_blank" href="{{ $fullDomain }}" class="underline hover:text-indigo-600">
                                                        {{ $fullDomain }}
                                                    </a>{{ !$loop->last ? ',' : '' }}
                                                @endforeach
                                            </td>
                                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                                <div class="flex items-center justify-end space-x-3">
                                                    <!-- Show -->
                                                    <a href="{{ route('tenants.show', $tenant) }}" class="text-sm text-blue-600 hover:underline">Show</a>
                                                    <!-- Edit -->
                                                    <a href="{{ route('tenants.edit', $tenant) }}" class="text-sm text-indigo-600 hover:underline">Edit</a>
                                                    <!-- Delete -->
                                                    <form action="{{ route('tenants.destroy', $tenant) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this tenant?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-sm text-red-600 hover:underline">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="transition hover:bg-gray-50">
                                        <td colspan="5" class="px-6 py-4 text-center whitespace-nowrap">Tenant not found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</x-app-layout>
