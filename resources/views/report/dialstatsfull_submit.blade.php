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

                                                        <tr style="border: 1px solid #dddddd;background-color:#ffffff;">
                                                        <td><strong>DNC</strong></td><td>{{$dialstat->dnc}}<br/>{{number_format($dialstat->dnc_percent, 2)}}%<br/>{{number_format($dialstat->dnc_duration/60, 2)}} minutes</td>  
                                                        <td><strong>Work Number</strong></td><td>{{$dialstat->work_number}}<br/>{{number_format($dialstat->work_number_percent, 2)}}%<br/>{{number_format($dialstat->work_number_duration/60, 2)}} minutes</td>  
                                                        <td><strong>Unemployed</strong></td><td>{{$dialstat->unemployed}}<br/>{{number_format($dialstat->unemployed_percent, 2)}}%<br/>{{number_format($dialstat->unemployed_duration/60, 2)}} minutes</td>  
                                                        <td><strong>Swearing</strong></td><td>{{$dialstat->swearing}}<br/>{{number_format($dialstat->swearing_percent, 2)}}%<br/>{{number_format($dialstat->swearing_duration/60, 2)}} minutes</td> 
                                                        </tr>

                                                        <tr style="border: 1px solid #dddddd;background-color:#ffffff;">
                                                        <td><strong>Repeat</strong></td><td>{{$dialstat->repeat}}<br/>{{number_format($dialstat->repeat_percent, 2)}}%<br/>{{number_format($dialstat->repeat_duration/60, 2)}} minutes</td>  
                                                        <td><strong>Religion Barrier</strong></td><td>{{$dialstat->religion_barrier}}<br/>{{number_format($dialstat->religion_barrier_percent, 2)}}%<br/>{{number_format($dialstat->religion_barrier_duration/60, 2)}} minutes</td>  
                                                        <td><strong>Relative Pays</strong></td><td>{{$dialstat->relative_pays}}<br/>{{number_format($dialstat->relative_pays_percent, 2)}}%<br/>{{number_format($dialstat->relative_pays_duration/60, 2)}} minutes</td>  
                                                        <td><strong>Outdoor</strong></td><td>{{$dialstat->outdoor}}<br/>{{number_format($dialstat->outdoor_percent, 2)}}%<br/>{{number_format($dialstat->outdoor_duration/60, 2)}} minutes</td> 
                                                        </tr>

                                                        <tr style="border: 1px solid #dddddd;background-color:#ffffff;">
                                                        <td><strong>Others Pickup Call</strong></td><td>{{$dialstat->others_pickup_call}}<br/>{{number_format($dialstat->others_pickup_call_percent, 2)}}%<br/>{{number_format($dialstat->others_pickup_call_duration/60, 2)}} minutes</td>  
                                                        <td><strong>Not Allowed on phone</strong></td><td>{{$dialstat->not_allowed}}<br/>{{number_format($dialstat->not_allowed_percent, 2)}}%<br/>{{number_format($dialstat->not_allowed_duration/60, 2)}} minutes</td>  
                                                        <td><strong>No Car</strong></td><td>{{$dialstat->no_car}}<br/>{{number_format($dialstat->no_car_percent, 2)}}%<br/>{{number_format($dialstat->no_car_duration/60, 2)}} minutes</td>  
                                                        <td><strong>Sick</strong></td><td>{{$dialstat->sick}}<br/>{{number_format($dialstat->sick_percent, 2)}}%<br/>{{number_format($dialstat->sick_duration/60, 2)}} minutes</td> 
                                                        </tr>

                                                        <tr style="border: 1px solid #dddddd;background-color:#ffffff;">
                                                        <td><strong>Angry</strong></td><td>{{$dialstat->angry}}<br/>{{number_format($dialstat->angry_percent, 2)}}%<br/>{{number_format($dialstat->angry_duration/60, 2)}} minutes</td>  
                                                        <td><strong>In Meeting</strong></td><td>{{$dialstat->in_meeting}}<br/>{{number_format($dialstat->in_meeting_percent, 2)}}%<br/>{{number_format($dialstat->in_meeting_duration/60, 2)}} minutes</td>  
                                                        <td><strong>Home Chores</strong></td><td>{{$dialstat->home_chores}}<br/>{{number_format($dialstat->home_chores_percent, 2)}}%<br/>{{number_format($dialstat->home_chores_duration/60, 2)}} minutes</td>  
                                                        <td><strong>Goodbyes</strong></td><td>{{$dialstat->goodbyes}}<br/>{{number_format($dialstat->goodbyes_percent, 2)}}%<br/>{{number_format($dialstat->goodbyes_duration/60, 2)}} minutes</td> 
                                                        </tr>

                                                        <tr style="border: 1px solid #dddddd;background-color:#ffffff;">
                                                        <td><strong>Fallback</strong></td><td>{{$dialstat->fallback}}<br/>{{number_format($dialstat->fallback_percent, 2)}}%<br/>{{number_format($dialstat->fallback_duration/60, 2)}} minutes</td>  
                                                        <td><strong>Expecting Call</strong></td><td>{{$dialstat->expecting_call}}<br/>{{number_format($dialstat->expecting_call_percent, 2)}}%<br/>{{number_format($dialstat->expecting_call_duration/60, 2)}} minutes</td>  
                                                        <td><strong>Driving</strong></td><td>{{$dialstat->driving}}<br/>{{number_format($dialstat->driving_percent, 2)}}%<br/>{{number_format($dialstat->driving_duration/60, 2)}} minutes</td>  
                                                        <td><strong>Children</strong></td><td>{{$dialstat->children}}<br/>{{number_format($dialstat->children_percent, 2)}}%<br/>{{number_format($dialstat->children_duration/60, 2)}} minutes</td> 
                                                        </tr>

                                                        <tr style="border: 1px solid #dddddd;background-color:#ffffff;">
                                                        <td><strong>Broker</strong></td><td>{{$dialstat->broker}}<br/>{{number_format($dialstat->broker_percent, 2)}}%<br/>{{number_format($dialstat->broker_duration/60, 2)}} minutes</td>  
                                                        <td><strong>Bathroom</strong></td><td>{{$dialstat->bathroom}}<br/>{{number_format($dialstat->bathroom_percent, 2)}}%<br/>{{number_format($dialstat->bathroom_duration/60, 2)}} minutes</td>  
                                                        <td><strong>Already Your Client</strong></td><td>{{$dialstat->already_your_client}}<br/>{{number_format($dialstat->already_your_client_percent, 2)}}%<br/>{{number_format($dialstat->already_your_client_duration/60, 2)}} minutes</td>  
                                                        <td><strong>Already Quoted</strong></td><td>{{$dialstat->already_quoted}}<br/>{{number_format($dialstat->already_quoted_percent, 2)}}%<br/>{{number_format($dialstat->already_quoted_duration/60, 2)}} minutes</td> 
                                                        </tr>

                                                        <tr style="border: 1px solid #dddddd;background-color:#ffffff;">
                                                        <td><strong>Already Covered</strong></td><td>{{$dialstat->already_covered}}<br/>{{number_format($dialstat->already_covered_percent, 2)}}%<br/>{{number_format($dialstat->already_covered_duration/60, 2)}} minutes</td>  
                                                        <td><strong>Reason Unknown</strong></td><td>{{$dialstat->reason_unknown}}<br/>{{number_format($dialstat->reason_unknown_percent, 2)}}%<br/>{{number_format($dialstat->reason_unknown_duration/60, 2)}} minutes</td>  
                                                        <td><strong>Timeout</strong></td><td>{{$dialstat->timeout}}<br/>{{number_format($dialstat->timeout_percent, 2)}}%<br/>{{number_format($dialstat->timeout_duration/60, 2)}} minutes</td>  
                                                        <td><strong>User Hangup</strong></td><td>{{$dialstat->user_hangup}}<br/>{{number_format($dialstat->user_hangup_percent, 2)}}%<br/>{{number_format($dialstat->user_hangup_duration/60, 2)}} minutes</td> 
                                                        </tr>
                                                        
                                                    
            @endforeach
                                                
                                            </table>
                <x-section-border />
            
        </div>
    </div>
</x-app-layout>