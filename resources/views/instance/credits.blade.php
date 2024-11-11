<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Credits') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <table  cellspacing="0" width="100%">
                                                    <tr>
                                                        <td><strong>Instance Name</strong></td>
                                                        <td><strong>Credits Available</strong></td>
                                                    </tr>

                                                    <tr>
                                                        <td>{{$instance->name}}</td>
                                                        <td>{{$instance->credits/60}} minutes</td>
                                                    </tr>
                                                   
                                            </table>

                <x-section-border />
        </div>
    </div>
</x-app-layout>