<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('services.update', $service) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Service Name')" />
                                <x-text-input id="name" type="text" name="name" :value="old('name', $service->name)" class="mt-1 block w-full" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <!-- Rate -->
                            <div>
                                <x-input-label for="rate" :value="__('Rate')" />
                                <x-text-input id="rate" type="number" step="0.01" name="rate" :value="old('rate', $service->rate)" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('rate')" />
                            </div>

                            <!-- Unit -->
                            <div>
                                <x-input-label for="unit" :value="__('Unit')" />
                                <x-text-input id="unit" type="text" name="unit" :value="old('unit', $service->unit)" class="mt-1 block w-full" required placeholder="e.g., hour, day, piece" />
                                <x-input-error class="mt-2" :messages="$errors->get('unit')" />
                            </div>

                            <!-- Is Active -->
                            <div>
                                <x-input-label for="is_active" :value="__('Status')" />
                                <select id="is_active" name="is_active" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="1" {{ old('is_active', $service->is_active) ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active', $service->is_active) === '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('is_active')" />
                            </div>

                            <!-- Description -->
                            <div class="col-span-2">
                                <x-input-label for="description" :value="__('Description')" />
                                <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $service->description) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Update Service') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 