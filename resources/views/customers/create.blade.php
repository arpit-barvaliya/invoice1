<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Customer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('customers.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" type="text" name="name" :value="old('name')" class="mt-1 block w-full" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Email Address')" />
                                <x-text-input id="email" type="email" name="email" :value="old('email')" class="mt-1 block w-full" required autocomplete="email" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <!-- Phone -->
                            <div>
                                <x-input-label for="phone" :value="__('Phone Number')" />
                                <x-text-input id="phone" type="text" name="phone" :value="old('phone')" class="mt-1 block w-full" autocomplete="phone" />
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            </div>

                            <!-- Address -->
                            <div>
                                <x-input-label for="address" :value="__('Address')" />
                                <x-text-input id="address" type="text" name="address" :value="old('address')" class="mt-1 block w-full" autocomplete="address" />
                                <x-input-error class="mt-2" :messages="$errors->get('address')" />
                            </div>

                            <!-- City -->
                            <div>
                                <x-input-label for="city" :value="__('City')" />
                                <x-text-input id="city" type="text" name="city" :value="old('city')" class="mt-1 block w-full" autocomplete="city" />
                                <x-input-error class="mt-2" :messages="$errors->get('city')" />
                            </div>

                            <!-- State -->
                            <div>
                                <x-input-label for="state" :value="__('State')" />
                                <x-text-input id="state" type="text" name="state" :value="old('state')" class="mt-1 block w-full" autocomplete="state" />
                                <x-input-error class="mt-2" :messages="$errors->get('state')" />
                            </div>

                            <!-- Country -->
                            <div>
                                <x-input-label for="country" :value="__('Country')" />
                                <x-text-input id="country" type="text" name="country" :value="old('country')" class="mt-1 block w-full" autocomplete="country" />
                                <x-input-error class="mt-2" :messages="$errors->get('country')" />
                            </div>

                            <!-- Postal Code -->
                            <div>
                                <x-input-label for="postal_code" :value="__('Postal Code')" />
                                <x-text-input id="postal_code" type="text" name="postal_code" :value="old('postal_code')" class="mt-1 block w-full" autocomplete="postal_code" />
                                <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
                            </div>

                            <!-- Notes -->
                            <div class="col-span-2">
                                <x-input-label for="notes" :value="__('Notes')" />
                                <x-text-input id="notes" type="text" name="notes" :value="old('notes')" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Add Customer') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 