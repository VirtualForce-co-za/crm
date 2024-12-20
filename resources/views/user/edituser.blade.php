<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Auth::id() == 1 || Auth::user()->whitelabel == 1)

                <form id="editusersubmit" method="POST" action="/editusersubmit">
                    @csrf
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="name" value="{{ __('Name') }}" />
                        <x-input id="name" name="name" type="text" value="{{$user->name}}" class="mt-1 block w-full"  required />
                        <x-input-error for="name" class="mt-2" />
                    </div>
</br>
<div class="col-span-6 sm:col-span-4">
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" name="email" type="text" value="{{$user->email}}" class="mt-1 block w-full"  required />
                        <x-input-error for="email" class="mt-2" />
                    </div>
                    </br>
<div class="col-span-6 sm:col-span-4">
                        <x-label for="password" value="{{ __('Password') }}" />
                        <x-input id="password" name="password" type="text" class="mt-1 block w-full" />
                        <x-input-error for="password" class="mt-2" />
                    </div>
</br>

<div class="col-span-6 sm:col-span-4">
                        <x-label for="instance" value="{{ __('Instance') }}" />
                        <select id="instanceid" name="instanceid" class="mt-1 block w-full" required>
                                        <option value="">Choose...</option>
                                        @foreach($instances as $instance)
                                        <option value="{{$instance->id}}" 
                                        @if($user->instanceid == $instance->id)
                                             selected
                                        @endif
                                        >{{$instance->name}}</option>
                                        @endforeach
                                    </select>
                    </div>
</br>

@if (Auth::id() == 1)
</br>
<div class="col-span-6 sm:col-span-4">
                        <x-label for="whitelabel" value="{{ __('White Label') }}" />
                        <input id="whitelabel" name="whitelabel" type="checkbox" class="mt-1 block" value="1" 
                        @if ($user->whitelabel == 1)
                             checked
                        @endif 
                        />
                    </div>
</br>
@endif

                    <x-input id="userid" name="userid" type="hidden" value="{{$user->id}}" />
                    <x-button type="submit">Save</x-button>

                </form>

                <x-section-border />
            @endif
        </div>
    </div>
</x-app-layout>