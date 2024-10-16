<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Instances') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Auth::id() == 1 || Auth::user()->whitelabel == 1)

            <table  cellspacing="0" width="100%">
                                                    <tr>
                                                        <td><strong>id</strong></td>
                                                        <td><strong>name</strong></td>
                                                        <td><strong>whitelabeluserid</strong></td>
                                                        <td><strong>own trunk</strong></td>
                                                        <td><strong>created at</strong></td>
                                                        <td><strong>updated at</strong></td>
                                                        <td><strong>edit</strong></td>
                                                    </tr>

                                                    @foreach($instances as $instance)
                                                    <tr>
                                                        <td>{{$instance->id}}</td>
                                                        <td>{{$instance->name}}</td>
                                                        <td>{{$instance->whitelabeluserid}}</td>
                                                        <td>{{$instance->owntrunk}}</td>
                                                        <td>{{$instance->created_at}}</td>
                                                        <td>{{$instance->updated_at}}</td>
                                                        <td><button type="button"  onclick="location.href='/editinstance?id={{$instance->id}}'">Edit</button></td>
                                                    </tr>
                                                    @endforeach
                                                
                                            </table>
                                            <div>{{ $instances->links() }}</div>     

                <x-section-border />
            @endif
        </div>
    </div>
</x-app-layout>