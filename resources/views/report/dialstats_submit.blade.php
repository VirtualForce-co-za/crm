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
            <table width="100%" style="border: 1px solid #eeeeee; font-size:10px;">
                                                    <tr style="border: 1px solid #eeeeee;">
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
                                                    <tr style="border: 1px solid #eeeeee;">
                                                        <td>{{$dialstats->campaign}}</td>
                                                        <td>{{$dialstats->dial}}<br/>{{number_format($dialstats->callduration/60, 2)}} minutes</td>
                                                        <td>{{$dialstats->connected}}<br/>{{number_format($dialstats->connected_percent, 2)}}%<br/>{{number_format($dialstats->connected_duration/60, 2)}} minutes</td>
                                                        <td>{{$dialstats->noanswer}}<br/>{{number_format($dialstats->noanswer_percent, 2)}}%<br/>{{number_format($dialstats->noanswer_duration/60, 2)}} minutes</td>
                                                        <td>{{$dialstats->callback}}<br/>{{number_format($dialstats->callback_percent, 2)}}%<br/>{{number_format($dialstats->callback_duration/60, 2)}} minutes</td>
                                                        <td>{{$dialstats->voicemail}}<br/>{{number_format($dialstats->voicemail_percent, 2)}}%<br/>{{number_format($dialstats->voicemail_duration/60, 2)}} minutes</td>  
                                                        <td>{{$dialstats->silent}}<br/>{{number_format($dialstats->silent_percent, 2)}}%<br/>{{number_format($dialstats->silent_duration/60, 2)}} minutes</td>
                                                        <td>{{$dialstats->qualified}}<br/>{{number_format($dialstats->qualified_percent, 2)}}%<br/>{{number_format($dialstats->qualified_duration/60, 2)}} minutes</td>     
                                                        <td>{{$dialstats->busy}}<br/>{{number_format($dialstats->busy_percent, 2)}}%<br/>{{number_format($dialstats->busy_duration/60, 2)}} minutes</td>  
                                                        <td>{{$dialstats->failed}}<br/>{{number_format($dialstats->failed_percent, 2)}}%<br/>{{number_format($dialstats->failed_duration/60, 2)}} minutes</td>      
                                                        <td>{{$dialstats->notinterested}}<br/>{{number_format($dialstats->notinterested_percent, 2)}}%<br/>{{number_format($dialstats->notinterested_duration/60, 2)}} minutes</td>            
                                                        <td>{{$dialstats->dnq}}<br/>{{number_format($dialstats->dnq_percent, 2)}}%<br/>{{number_format($dialstats->dnq_duration/60, 2)}} minutes</td>            
                                                        <td>{{$dialstats->others}}<br/>{{number_format($dialstats->others_percent, 2)}}%<br/>{{number_format($dialstats->others_duration/60, 2)}} minutes</td>                                                        
                                                    </tr>
                                                    @endforeach
                                                
                                            </table>
                                            <div>{{ $dial_stat_by_rows->links() }}</div>     

                <x-section-border />
            
        </div>
    </div>
</x-app-layout>