<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('services.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Service Name')" />
                                <x-text-input id="name" type="text" name="name" :value="old('name')" class="mt-1 block w-full" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                            <!-- HSN -->
                            <div>
                                <x-input-label for="hsn" :value="__('HSN Code')" />
                                <x-text-input id="hsn" type="text" name="hsn" :value="old('hsn')" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('hsn')" />
                            </div>

                            <!-- Rate -->
                            <div>
                                <x-input-label for="rate" :value="__('Rate')" />
                                <x-text-input id="rate" type="number" step="0.01" name="rate" :value="old('rate')" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('rate')" />
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <x-input-label for="cgst_rate" :value="__('CGST Rate (%)')" />
                                    <x-text-input id="cgst_rate" type="number" name="cgst_rate" :value="old('cgst_rate', 0)" class="mt-1 block w-full" min="0" max="100" step="0.01" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('cgst_rate')" />
                                </div>

                                <div>
                                    <x-input-label for="sgst_rate" :value="__('SGST Rate (%)')" />
                                    <x-text-input id="sgst_rate" type="number" name="sgst_rate" :value="old('sgst_rate', 0)" class="mt-1 block w-full" min="0" max="100" step="0.01" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('sgst_rate')" />
                                </div>

                                <div>
                                    <x-input-label for="igst_rate" :value="__('IGST Rate (%)')" />
                                    <x-text-input id="igst_rate" type="number" name="igst_rate" :value="old('igst_rate', 0)" class="mt-1 block w-full" min="0" max="100" step="0.01" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('igst_rate')" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('submit') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 