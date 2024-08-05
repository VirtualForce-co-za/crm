<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Instance') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Auth::id() == 1)

                <form id="addinstancesubmit" method="POST" action="/addinstancesubmit">
                    @csrf
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="name" value="{{ __('Name') }}" />
                        <x-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                        <x-input-error for="name" class="mt-2" />
                    </div>
                    </br>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="accountsid" value="{{ __('Account SID') }}" />
                        <x-input id="accountsid" name="accountsid" type="text" class="mt-1 block w-full" required />
                        <x-input-error for="accountsid" class="mt-2" />
                    </div>
                    </br>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="applicationsid" value="{{ __('Application SID') }}" />
                        <x-input id="applicationsid" name="applicationsid" type="text" class="mt-1 block w-full" required />
                        <x-input-error for="applicationsid" class="mt-2" />
                    </div>
                    </br>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="bearer" value="{{ __('Bearer') }}" />
                        <x-input id="bearer" name="bearer" type="text" class="mt-1 block w-full" required />
                        <x-input-error for="bearer" class="mt-2" />
                    </div>
                    </br>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="dialprefix" value="{{ __('Dial Prefix') }}" />
                        <x-input id="dialprefix" name="dialprefix" type="text" class="mt-1 block w-full" required />
                        <x-input-error for="dialprefix" class="mt-2" />
                    </div>
                    </br>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="cps" value="{{ __('CPS') }}" />
                        <x-input id="cps" name="cps" type="text" class="mt-1 block w-full" required />
                        <x-input-error for="cps" class="mt-2" />
                    </div>
                    </br>
                    <x-button type="submit">Save</x-button>

                </form>

                <x-section-border />
            @endif
        </div>
    </div>
</x-app-layout>