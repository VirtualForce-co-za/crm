<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Agents') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            

            <table  cellspacing="0" width="100%">
                                                    <tr>
                                                        <td><strong>id</strong></td>
                                                        <td><strong>name</strong></td>                                                        
                                                        <td><strong>created at</strong></td>
                                                        <td><strong>updated at</strong></td>
                                                        @if (Auth::id() == 1)
                                                        <td><strong>location</strong></td>
                                                        <td><strong>instance</strong></td>
                                                        <td><strong>edit</strong></td>
                                                        @endif
                                                    </tr>

                                                    @foreach($agents as $agent)
                                                    <tr>
                                                        <td>{{$agent->id}}</td>
                                                        <td>{{$agent->name}}</td>                                                        
                                                        <td>{{$agent->created_at}}</td>
                                                        <td>{{$agent->updated_at}}</td>
                                                        @if (Auth::id() == 1)
                                                        <td>{{$agent->location}}</td>
                                                        <td>{{$agent->instance->name}}</td>
                                                        <td><button type="button"  onclick="location.href='/editagent?id={{$agent->id}}'">Edit</button></td>
                                                        @endif
                                                    </tr>
                                                    @endforeach
                                                
                                            </table>
                                            <div>{{ $agents->links() }}</div>     

                <x-section-border />
            
        </div>
    </div>
</x-app-layout>