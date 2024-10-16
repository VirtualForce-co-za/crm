<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Instance') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Auth::id() == 1 || Auth::user()->whitelabel == 1)

                <form id="editinstancesubmit" method="POST" action="/editinstancesubmit">
                    @csrf
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="name" value="{{ __('Name') }}" />
                        <x-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{$instance->name}}" required />
                        <x-input-error for="name" class="mt-2" />
                    </div>
                    </br>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="owntrunk" value="{{ __('owntrunk') }}" />
                        <input id="owntrunk" name="owntrunk" type="checkbox" class="mt-1 block" value="1" 
                        @if ($instance->owntrunk == 1)
                             checked
                        @endif 
                        />
                    </div>
                    </br>
                    @if (Auth::id() == 1)
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="accountsid" value="{{ __('Account SID') }}" />
                        <x-input id="accountsid" name="accountsid" type="text" class="mt-1 block w-full" value="{{$instance->accountsid}}" required />
                        <x-input-error for="accountsid" class="mt-2" />
                    </div>
                    </br>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="applicationsid" value="{{ __('Application SID') }}" />
                        <x-input id="applicationsid" name="applicationsid" type="text" class="mt-1 block w-full" value="{{$instance->applicationsid}}" required />
                        <x-input-error for="applicationsid" class="mt-2" />
                    </div>
                    </br>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="bearer" value="{{ __('Bearer') }}" />
                        <x-input id="bearer" name="bearer" type="text" class="mt-1 block w-full" value="{{$instance->bearer}}" required />
                        <x-input-error for="bearer" class="mt-2" />
                    </div>
                    </br>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="dialprefix" value="{{ __('Dial Prefix') }}" />
                        <x-input id="dialprefix" name="dialprefix" type="text" class="mt-1 block w-full" value="{{$instance->dialprefix}}" required />
                        <x-input-error for="dialprefix" class="mt-2" />
                    </div>
                    </br>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="cps" value="{{ __('CPS') }}" />
                        <x-input id="cps" name="cps" type="text" class="mt-1 block w-full" value="{{$instance->cps}}" required />
                        <x-input-error for="cps" class="mt-2" />
                    </div>
                    @endif
                    </br>
                    <x-input id="instanceid" name="instanceid" type="hidden" value="{{$instance->id}}" />
                    <x-button type="submit">Save</x-button>

                </form>

                <x-section-border />
            @endif
        </div>
    </div>
</x-app-layout>