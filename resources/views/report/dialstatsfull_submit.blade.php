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
                                                        <td><strong>Campaign</strong></td><td>{{$dialstat->campaign}}</td>
                                                        <td><strong>Dial</strong></td><td>{{$dialstat->dial}}<br/>{{number_format($dialstat->callduration/60, 2)}} minutes</td>
                                                        <td><strong>Connected</strong></td><td>{{$dialstat->connected}}<br/>{{number_format($dialstat->connected_percent, 2)}}%<br/>{{number_format($dialstat->connected_duration/60, 2)}} minutes</td>
                                                        <td><strong>No Answer</strong></td><td>{{$dialstat->noanswer}}<br/>{{number_format($dialstat->noanswer_percent, 2)}}%<br/>{{number_format($dialstat->noanswer_duration/60, 2)}} minutes</td>
                                                        </tr>
                                                        <tr style="border: 1px solid #dddddd;background-color:#ffffff;">
                                                        <td><strong>Callback</strong></td><td>{{$dialstat->callback}}<br/>{{number_format($dialstat->callback_percent, 2)}}%<br/>{{number_format($dialstat->callback_duration/60, 2)}} minutes</td>
                                                        <td><strong>Voicemail</strong></td><td>{{$dialstat->voicemail}}<br/>{{number_format($dialstat->voicemail_percent, 2)}}%<br/>{{number_format($dialstat->voicemail_duration/60, 2)}} minutes</td>  
                                                        <td><strong>Silent</strong></td><td>{{$dialstat->silent}}<br/>{{number_format($dialstat->silent_percent, 2)}}%<br/>{{number_format($dialstat->silent_duration/60, 2)}} minutes</td>
                                                        <td><strong>Qualified</strong></td><td>{{$dialstat->qualified}}<br/>{{number_format($dialstat->qualified_percent, 2)}}%<br/>{{number_format($dialstat->qualified_duration/60, 2)}} minutes</td>
                                                        </tr>
                                                        <tr style="border: 1px solid #dddddd;background-color:#ffffff;">
                                                        <td><strong>Busy</strong></td><td>{{$dialstat->busy}}<br/>{{number_format($dialstat->busy_percent, 2)}}%<br/>{{number_format($dialstat->busy_duration/60, 2)}} minutes</td>  
                                                        <td><strong>Failed</strong></td><td>{{$dialstat->failed}}<br/>{{number_format($dialstat->failed_percent, 2)}}%<br/>{{number_format($dialstat->failed_duration/60, 2)}} minutes</td>  
                                                        <td><strong>Not Interested</strong></td><td>{{$dialstat->notinterested}}<br/>{{number_format($dialstat->notinterested_percent, 2)}}%<br/>{{number_format($dialstat->notinterested_duration/60, 2)}} minutes</td>  
                                                        <td><strong>DNQ</strong></td><td>{{$dialstat->dnq}}<br/>{{number_format($dialstat->dnq_percent, 2)}}%<br/>{{number_format($dialstat->dnq_duration/60, 2)}} minutes</td> 
                                                        </tr>
                                                        
                                                    
            @endforeach
                                                
                                            </table>
                <x-section-border />
            
        </div>
    </div>
</x-app-layout>