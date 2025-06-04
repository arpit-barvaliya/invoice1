<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Customer Details') }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('customers.edit', $customer) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    {{ __('Edit Customer') }}
                </a>
                <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline" id="delete-form-{{ $customer->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500" onclick="confirmDelete('delete-form-{{ $customer->id }}')">
                        {{ __('Delete Customer') }}
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
                                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Email') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->email }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Phone') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->phone ?? __('Not provided') }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Address Information') }}</h3>
                            <dl class="mt-4 space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Address') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->address ?? __('Not provided') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('City') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->city ?? __('Not provided') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('State') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->state ?? __('Not provided') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Country') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->country ?? __('Not provided') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Postal Code') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->postal_code ?? __('Not provided') }}</dd>
                                </div>
                            </dl>
                        </div>

                        @if($customer->notes)
                            <div class="col-span-2">
                                <h3 class="text-lg font-medium text-gray-900">{{ __('Notes') }}</h3>
                                <div class="mt-4 text-sm text-gray-900">
                                    {{ $customer->notes }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 