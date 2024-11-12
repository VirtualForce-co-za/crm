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

  function validate()
  {
    if(document.getElementById('datepicker_from').value == "" || document.getElementById('datepicker_to').value == ""){
        alert("Select Date Range");
        return false;
    }
    else{
        return true;
    }
  }
  </script>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

        <table  cellspacing="0" width="100%">
                <tr>
                <td style="text-align:center;">
                <form id="dialstatsfull_submit" method="GET" action="/dialstatsfull_submit" onsubmit="javascript: return validate();">
                @csrf    
                <select id="campaign" name="campaign" style="width:250px;" required>
                                        <option value="">Choose...</option>
                                        @foreach($campaigns as $campaign)
                                        <option value="{{$campaign->name}}">{{$campaign->name}}</option>
                                        @endforeach
                                    </select>&nbsp;
                <strong>Date From: <input type="text" id="datepicker_from" name="datepicker_from" size="30"></strong>
                <strong>&nbsp; Date To: <input type="text" id="datepicker_to" name="datepicker_to" size="30"></strong>
                &nbsp; 
                <x-button type="submit">Submit</x-button>
                </form>
                </td>
                </tr>
                </table>
            <br/><br/>
            @foreach($dialstats as $dialstat)
            <table width="100%" style="border: 1px solid #dddddd; font-size:10px;">
                                                    <tr style="border: 1px solid #dddddd;background-color:#ffffff;">
                                                        <td><strong>Campaign</strong></td><td>{{$dialstats->campaign}}</td>
                                                        <td><strong>Dial</strong></td><td>{{$dialstats->dial}}<br/>{{number_format($dialstats->callduration/60, 2)}} minutes</td>
                                                        </tr>
                                                        <tr style="border: 1px solid #dddddd;background-color:#ffffff;">
                                                        <td><strong>Connected</strong></td><td>{{$dialstats->connected}}<br/>{{number_format($dialstats->connected_percent, 2)}}%<br/>{{number_format($dialstats->connected_duration/60, 2)}} minutes</td>
                                                        <td><strong>No Answer</strong></td><td>{{$dialstats->noanswer}}<br/>{{number_format($dialstats->noanswer_percent, 2)}}%<br/>{{number_format($dialstats->noanswer_duration/60, 2)}} minutes</td>
                                                        </tr>
                                                        <tr style="border: 1px solid #dddddd;background-color:#ffffff;">
                                                        <td><strong>Callback</strong></td><td>{{$dialstats->callback}}<br/>{{number_format($dialstats->callback_percent, 2)}}%<br/>{{number_format($dialstats->callback_duration/60, 2)}} minutes</td>
                                                        <td><strong>Voicemail</strong></td><td>{{$dialstats->voicemail}}<br/>{{number_format($dialstats->voicemail_percent, 2)}}%<br/>{{number_format($dialstats->voicemail_duration/60, 2)}} minutes</td>  
                                                        </tr>
                                                        <tr style="border: 1px solid #dddddd;background-color:#ffffff;">
                                                        <td><strong>Silent</strong></td><td>{{$dialstats->silent}}<br/>{{number_format($dialstats->silent_percent, 2)}}%<br/>{{number_format($dialstats->silent_duration/60, 2)}} minutes</td>
                                                        <td><strong>Qualified</strong></td><td>{{$dialstats->qualified}}<br/>{{number_format($dialstats->qualified_percent, 2)}}%<br/>{{number_format($dialstats->qualified_duration/60, 2)}} minutes</td>
                                                        </tr>
                                                        <tr style="border: 1px solid #dddddd;background-color:#ffffff;">
                                                        <td><strong>Busy</strong></td><td>{{$dialstats->busy}}<br/>{{number_format($dialstats->busy_percent, 2)}}%<br/>{{number_format($dialstats->busy_duration/60, 2)}} minutes</td>  
                                                        <td><strong>Failed</strong></td><td>{{$dialstats->failed}}<br/>{{number_format($dialstats->failed_percent, 2)}}%<br/>{{number_format($dialstats->failed_duration/60, 2)}} minutes</td>  
                                                        </tr>
                                                        <tr style="border: 1px solid #dddddd;background-color:#ffffff;">
                                                        <td><strong>Not Interested</strong></td><td>{{$dialstats->notinterested}}<br/>{{number_format($dialstats->notinterested_percent, 2)}}%<br/>{{number_format($dialstats->notinterested_duration/60, 2)}} minutes</td>  
                                                        <td><strong>DNQ</strong></td><td>{{$dialstats->dnq}}<br/>{{number_format($dialstats->dnq_percent, 2)}}%<br/>{{number_format($dialstats->dnq_duration/60, 2)}} minutes</td> 
                                                        </tr>
                                                        
                                                    
            @endforeach
                                                
                                            </table>
                <x-section-border />
            
        </div>
    </div>
</x-app-layout>