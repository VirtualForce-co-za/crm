<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Agent') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Auth::id() == 1)

                <form id="editagentsubmit" method="POST" action="/editagentsubmit">
                    @csrf
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="name" value="{{ __('Name') }}" />
                        <x-input id="name" name="name" type="text" value="{{$agent->name}}" class="mt-1 block w-full"  required />
                        <x-input-error for="name" class="mt-2" />
                    </div>
                    </br>
<div class="col-span-6 sm:col-span-4">
                        <x-label for="location" value="{{ __('Location') }}" />
                        <x-input id="location" name="location" type="text" value="{{$agent->location}}" class="mt-1 block w-full"  required />
                        <x-input-error for="password" class="mt-2" />
                    </div>
</br>

<div class="col-span-6 sm:col-span-4">
                        <x-label for="instance" value="{{ __('Instance') }}" />
                        <select id="instanceid" name="instanceid" class="mt-1 block w-full" required>
                                        <option value="">Choose...</option>
                                        @foreach($instances as $instance)
                                        <option value="{{$instance->id}}" 
                                        @if($agent->instanceid == $instance->id)
                                             selected
                                        @endif
                                        >{{$instance->name}}</option>
                                        @endforeach
                                    </select>
                    </div>
</br>


                    <x-input id="agentid" name="agentid" type="hidden" value="{{$agent->id}}" />
                    <x-button type="submit">Save</x-button>

                </form>

                <x-section-border />
            @endif
        </div>
    </div>
</x-app-layout>