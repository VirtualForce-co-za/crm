<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Campaign') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

                <form id="addcampaignsubmit" method="POST" action="/addcampaignsubmit"  enctype="multipart/form-data">
                    @csrf
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="name" value="{{ __('Name') }}" />
                        <x-input id="name" name="name" type="text" class="mt-1 block w-full"  required />
                        <x-input-error for="name" class="mt-2" />
                    </div>
</br>
<div class="col-span-6 sm:col-span-4">
                        <x-label for="cli" value="{{ __('cli') }}" />
                        <x-input id="cli" name="cli" type="text" class="mt-1 block w-full"  required />
                        <x-input-error for="cli" class="mt-2" />
                    </div>
</br>

@if(isset($instance))
<x-input id="instanceid" name="instanceid" type="hidden" value="{{$instance->id}}" />
@endif

@if(isset($instances))
<div class="col-span-6 sm:col-span-4">
                        <x-label for="instance" value="{{ __('Instance') }}" />
                        <select id="instanceid" name="instanceid" class="mt-1 block w-full" required>
                                        <option value="">Choose...</option>
                                        @foreach($instances as $instance)
                                        <option value="{{$instance->id}}">{{$instance->name}}</option>
                                        @endforeach
                                    </select>
                    </div>

                    </br>
@endif



<div class="col-span-6 sm:col-span-4">
                        <x-label for="agent" value="{{ __('Agent') }}" />
                        <select id="agentid" name="agentid" class="mt-1 block w-full" required>
                                        <option value="">Choose...</option>
                                        @foreach($agents as $agent)
                                        <option value="{{$agent->id}}">{{$agent->name}}</option>
                                        @endforeach
                                    </select>
                    </div>
                    
                    </br>

<div class="col-span-6 sm:col-span-4">
                        <x-label for="filename" value="{{ __('Upload CSV File') }}" />
                        <input type="file" accept=".csv" name="filename" class="mt-1 block w-full" id="filename" required="required" />
                        </br>
                        File Format Example (only cellno is mandatory and first line should be a header as example below):
                        </br>
                        title,name,surname,cellno,idno
                        </br>
                        ,,,0635047355,
                    </div>

                    

                </br>



                    <x-button type="submit">Save</x-button>

                </form>

                <x-section-border />
        </div>
    </div>
</x-app-layout>