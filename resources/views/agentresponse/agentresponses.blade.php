<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Agent Responses') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            

            <table  cellspacing="0" width="100%">
                                                    <tr>
                                                        @if (Auth::id() == 1)
                                                        <td><strong>id</strong></td>
                                                        <td><strong>Agent Response</strong></td>                                                        
                                                        <td><strong>created at</strong></td>
                                                        <td><strong>updated at</strong></td>
                                                        <td><strong>instance</strong></td>
                                                        <td><strong>edit</strong></td>
                                                        @endif
                                                    </tr>
                                                    @if (Auth::id() == 1)
                                                    @foreach($agentresponses as $agentresponse)
                                                    <tr>
                                                        <td>{{$agentresponse->id}}</td>
                                                        <td>{{$agentresponse->agentresponse}}</td>                                                        
                                                        <td>{{$agentresponse->created_at}}</td>
                                                        <td>{{$agentresponse->updated_at}}</td>                                                        
                                                        <td>{{$agentresponse->instance->name}}</td>
                                                        <td><button type="button" onclick="location.href='/editagentresponse?id={{$agentresponse->id}}'">Edit</button></td>                                                        
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                            </table>
                                            <div>{{ $agentresponses->links() }}</div>     

                <x-section-border />
            
        </div>
    </div>
</x-app-layout>