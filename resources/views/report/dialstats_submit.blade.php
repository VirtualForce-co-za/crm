<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dial Stats') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker_from" ).datepicker({
  dateFormat: "yy-mm-dd"
});
  } );

  $( function() {
    $( "#datepicker_to" ).datepicker({
  dateFormat: "yy-mm-dd"
});
  } );
  </script>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

        <table  cellspacing="0" width="100%">
                <tr>
                <td style="text-align:center;">
                <form id="addinstancesubmit" method="GET" action="/dialstats_submit">
                @csrf    
                <strong>Date From: <input type="text" id="datepicker_from" name="datepicker_from" size="30"></strong>
                <strong>&nbsp; Date To: <input type="text" id="datepicker_to" name="datepicker_to" size="30"></strong>
                &nbsp; 
                <x-button type="submit">Submit</x-button>
                </form>
                </td>
                </tr>
                </table>
            <br/><br/>
            <table  cellspacing="0" width="100%">
                                                    <tr>
                                                        <td><strong>campaign</strong></td>
                                                        <td><strong>Dial</strong></td>
                                                        <td><strong>Connected</strong></td>
                                                        <td><strong>No Answer</strong></td>
                                                        <td><strong>Callback</strong></td>
                                                        <td><strong>Voicemail</strong></td>
                                                        <td><strong>Silent</strong></td>
                                                        <td><strong>Qualified</strong></td>
                                                        <td><strong>Busy</strong></td>
                                                        <td><strong>Failed</strong></td>
                                                        <td><strong>Not Interested</strong></td>
                                                        <td><strong>DNQ</strong></td>
                                                        <td><strong>Others</strong></td>
                                                        
                                                    </tr>

                                                    @foreach($dial_stat_by_rows as $dialstats)
                                                    <tr>
                                                        <td>{{$dialstats->campaign}}</td>
                                                        <td>{{$dialstats->dial}}<br/>{{$dialstats->callduration}}</td>
                                                        <td>{{$dialstats->connected}}<br/>{{$dialstats->connected_percent}}<br/>{{$dialstats->connected_duration}}</td>
                                                        <td>{{$dialstats->noanswer}}<br/>{{$dialstats->noanswer_percent}}<br/>{{$dialstats->noanswer_duration}}</td>
                                                        <td>{{$dialstats->callback}}<br/>{{$dialstats->callback_percent}}<br/>{{$dialstats->callback_duration}}</td>
                                                        <td>{{$dialstats->voicemail}}<br/>{{$dialstats->voicemail_percent}}<br/>{{$dialstats->voicemail_duration}}</td>  
                                                        <td>{{$dialstats->silent}}<br/>{{$dialstats->silent_percent}}<br/>{{$dialstats->silent_duration}}</td>
                                                        <td>{{$dialstats->qualified}}<br/>{{$dialstats->qualified_percent}}<br/>{{$dialstats->qualified_duration}}</td>     
                                                        <td>{{$dialstats->busy}}<br/>{{$dialstats->busy_percent}}<br/>{{$dialstats->busy_duration}}</td>  
                                                        <td>{{$dialstats->failed}}<br/>{{$dialstats->failed_percent}}<br/>{{$dialstats->failed_duration}}</td>      
                                                        <td>{{$dialstats->notinterested}}<br/>{{$dialstats->notinterested_percent}}<br/>{{$dialstats->notinterested_duration}}</td>            
                                                        <td>{{$dialstats->dnq}}<br/>{{$dialstats->dnq_percent}}<br/>{{$dialstats->dnq_duration}}</td>            
                                                        <td>{{$dialstats->others}}<br/>{{$dialstats->others_percent}}<br/>{{$dialstats->others_duration}}</td>                                                        
                                                    </tr>
                                                    @endforeach
                                                
                                            </table>
                                            <div>{{ $dial_stat_by_rows->links() }}</div>     

                <x-section-border />
            
        </div>
    </div>
</x-app-layout>