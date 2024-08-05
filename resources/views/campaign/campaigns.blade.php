<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Campaigns') }}
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
                                                        <td><strong>status</strong></td>
                                                        <td><strong>instance</strong></td>
                                                        <td><strong>agent</strong></td>
                                                        <td><strong>Action</strong></td>
                                                        <td><strong>edit</strong></td>
                                                    </tr>

                                                    @foreach($campaigns as $campaign)
                                                    <tr>
                                                        <td>{{$campaign->id}}</td>
                                                        <td>{{$campaign->name}}</td>                                                        
                                                        <td>{{$campaign->created_at}}</td>
                                                        <td>{{$campaign->updated_at}}</td>
                                                        <td>{{$campaign->status}}</td>
                                                        <td>{{$campaign->instance->name}}</td>
                                                        <td>{{$campaign->agent->name}}</td>
                                                        <td>
                                                            @if($campaign->status == "ready")
                                                            <button type="button"  onclick="location.href='/actioncampaign?id={{$campaign->id}}&action=dial'">Dial</button>
                                                            @elseif($campaign->status == "dialing")
                                                            <button type="button"  onclick="location.href='/actioncampaign?id={{$campaign->id}}&action=pause'">Pause</button>
                                                            @elseif($campaign->status == "paused")
                                                            <button type="button"  onclick="location.href='/actioncampaign?id={{$campaign->id}}&action=resume'">Resume</button>
                                                            @elseif($campaign->status == "completed" || $campaign->status == "redialcompleted")
                                                            <button type="button"  onclick="location.href='/actioncampaign?id={{$campaign->id}}&action=redial'">Redial</button>
                                                            @elseif($campaign->status == "redialing")
                                                            <button type="button"  onclick="location.href='/actioncampaign?id={{$campaign->id}}&action=redialpaused'">Redial Paused</button>
                                                            @elseif($campaign->status == "redialpaused")
                                                            <button type="button"  onclick="location.href='/actioncampaign?id={{$campaign->id}}&action=resumeredial'">Resume Redial</button>
                                                            @endif
                                                        </td>
                                                        <td><button type="button"  onclick="location.href='/editcampaign?id={{$campaign->id}}'">Edit</button></td>
                                                    </tr>
                                                    @endforeach
                                                
                                            </table>
                                            <div>{{ $campaigns->links() }}</div>     

                <x-section-border />
            
        </div>
    </div>
</x-app-layout>