<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Service Details') }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('services.edit', $service) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    {{ __('Edit Service') }}
                </a>
                <form id="delete-form-{{ $service->id }}" action="{{ route('services.destroy', $service) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500" onclick="confirmDelete('delete-form-{{ $service->id }}')">
                        {{ __('Delete Service') }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Basic Information') }}</h3>
                            <dl class="mt-4 space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Name') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $service->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Rate') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ number_format($service->rate, 2) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('CGST Rate') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ number_format($service->cgst_rate, 2) }}%</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('SGST Rate') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ number_format($service->sgst_rate, 2) }}%</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('IGST Rate') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ number_format($service->igst_rate, 2) }}%</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 