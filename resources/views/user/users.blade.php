<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Auth::id() == 1 || Auth::user()->whitelabel == 1)

            <table  cellspacing="0" width="100%">
                                                    <tr>
                                                        <td><strong>id</strong></td>
                                                        <td><strong>name</strong></td>
                                                        <td><strong>email</strong></td>
                                                        <td><strong>whitelabel</strong></td>
                                                        <td><strong>whitelabeluserid</strong></td>
                                                        <td><strong>instance</strong></td>
                                                        <td><strong>created at</strong></td>
                                                        <td><strong>updated at</strong></td>
                                                        <td><strong>edit</strong></td>
                                                    </tr>

                                                    @foreach($users as $user)
                                                    <tr>
                                                        <td>{{$user->id}}</td>
                                                        <td>{{$user->name}}</td>
                                                        <td>{{$user->email}}</td>
                                                        <td>{{$user->whitelabel ?? 'NULL'}}</td>
                                                        <td>{{$user->whitelabeluserid ?? 'NULL'}}</td>
                                                        <td>{{$user->instance->name ?? 'NULL'}}</td>
                                                        <td>{{$user->created_at}}</td>
                                                        <td>{{$user->updated_at}}</td>
                                                        <td><button type="button"  onclick="location.href='/edituser?id={{$user->id}}'">Edit</button></td>
                                                    </tr>
                                                    @endforeach
                                                
                                            </table>
                                            <div>{{ $users->links() }}</div>     

                <x-section-border />
            @endif
        </div>
    </div>
</x-app-layout>