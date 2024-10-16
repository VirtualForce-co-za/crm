<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('dispositions') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            

            <table  cellspacing="0" width="100%">
                                                    <tr>
                                                        <td><strong>id</strong></td>
                                                        <td><strong>name</strong></td>
                                                        @if (Auth::id() == 1)
                                                        <td><strong>created at</strong></td>
                                                        <td><strong>updated at</strong></td>
                                                        <td><strong>edit</strong></td>
                                                        @endif
                                                    </tr>

                                                    @foreach($dispositions as $disposition)
                                                    <tr>
                                                        <td>{{$disposition->id}}</td>
                                                        <td>{{$disposition->name}}</td>
                                                        @if (Auth::id() == 1)
                                                        <td>{{$disposition->created_at}}</td>
                                                        <td>{{$disposition->updated_at}}</td>
                                                        <td><button type="button"  onclick="location.href='/editdisposition?id={{$disposition->id}}'">Edit</button></td>
                                                        @endif
                                                    </tr>
                                                    @endforeach
                                                
                                            </table>
                                            <div>{{ $dispositions->links() }}</div>     

                <x-section-border />
            
        </div>
    </div>
</x-app-layout>