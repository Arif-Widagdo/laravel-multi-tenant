<x-central.app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Tenant Detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-4 text-gray-900">
                    <div>
                        <strong>{{ __('Name') }}:</strong> {{ $tenant->name }}
                    </div>
                    <div>
                        <strong>{{ __('Email') }}:</strong> {{ $tenant->email }}
                    </div>
                    <div>
                        <strong>{{ __('Domain') }}:</strong> {{ $tenant->domains->first()->domain ?? '-' }}
                    </div>
                    <div class="pt-4">
                        <a href="{{ route('tenants.edit', $tenant) }}" class="text-blue-600 hover:underline">
                            {{ __('Edit Tenant') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-central.app-layout>
