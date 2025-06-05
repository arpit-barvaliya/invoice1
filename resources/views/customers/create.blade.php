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
                                <x-text-input id="phone" type="text" name="phone" :value="old('phone')" class="mt-1 block w-full" required autocomplete="phone" />
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            </div>

                            <!-- Address -->
                            <div>
                                <x-input-label for="address" :value="__('Address')" />
                                <textarea name="address" id="address" rows="3" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('address') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('address')" />
                            </div>

                            <!-- City -->
                            <div>
                                <x-input-label for="city" :value="__('City')" />
                                <x-text-input id="city" type="text" name="city" :value="old('city')" class="mt-1 block w-full" required autocomplete="city" />
                                <x-input-error class="mt-2" :messages="$errors->get('city')" />
                            </div>

                            <!-- State -->
                            <div>
                                <x-input-label for="state" :value="__('State')" />
                                <x-text-input id="state" type="text" name="state" :value="old('state')" class="mt-1 block w-full" required autocomplete="state" />
                                <x-input-error class="mt-2" :messages="$errors->get('state')" />
                            </div>

                            <!-- Country -->
                            <div>
                                <x-input-label for="country" :value="__('Country')" />
                                <x-text-input id="country" type="text" name="country" :value="old('country')" class="mt-1 block w-full" required autocomplete="country" />
                                <x-input-error class="mt-2" :messages="$errors->get('country')" />
                            </div>

                            <!-- Postal Code -->
                            <div>
                                <x-input-label for="postal_code" :value="__('Postal Code')" />
                                <x-text-input id="postal_code" type="text" name="postal_code" :value="old('postal_code')" class="mt-1 block w-full" required autocomplete="postal_code" />
                                <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
                            </div>

                            <!-- GST Number -->
                            <div>
                                <x-input-label for="gst" :value="__('GST Number')" />
                                <x-text-input id="gst" type="text" name="gst" :value="old('gst')" class="mt-1 block w-full" autocomplete="gst" />
                                <x-input-error class="mt-2" :messages="$errors->get('gst')" />
                            </div>

                            <!-- State Code -->
                            <div>
                                <x-input-label for="state_code" :value="__('State Code')" />
                                <x-text-input id="state_code" type="text" name="state_code" :value="old('state_code')" class="mt-1 block w-full" autocomplete="state_code" />
                                <x-input-error class="mt-2" :messages="$errors->get('state_code')" />
                            </div>

                            <!-- Place of Supply -->
                            <div>
                                <x-input-label for="place_of_supply" :value="__('Place of Supply')" />
                                <x-text-input id="place_of_supply" type="text" name="place_of_supply" :value="old('place_of_supply')" class="mt-1 block w-full" autocomplete="place_of_supply" />
                                <x-input-error class="mt-2" :messages="$errors->get('place_of_supply')" />
                            </div>

                            <!-- Credit Days -->
                            <div>
                                <x-input-label for="credit_days" :value="__('Credit Days')" />
                                <x-text-input id="credit_days" type="number" name="credit_days" :value="old('credit_days', 0)" class="mt-1 block w-full" min="0" required />
                                <x-input-error class="mt-2" :messages="$errors->get('credit_days')" />
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