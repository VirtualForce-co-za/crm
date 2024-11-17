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
                <form id="qualifiedleads_submit" method="GET" action="/qualifiedleads_submit" onsubmit="javascript: return validate();">
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
            <table width="100%" style="border: 1px solid #dddddd; font-size:10px;">
                                                    <tr style="border: 1px solid #dddddd;">
                                                        <td><strong>campaign</strong></td>
                                                        <td><strong>Lead ID</strong></td>
                                                        <td><strong>Cell Number</strong></td>
                                                        <td><strong>Call Recording</strong></td>
                                                        
                                                    </tr>

                                                    @foreach($qualifiedleads as $lead)
                                                    <tr style="border: 1px solid #dddddd;background-color:#ffffff;">
                                                        <td>{{$lead->campaignname}}</td>
                                                        <td>{{$lead->id}}</td>
                                                        <td>{{$lead->cellno}}</td>
                                                        <td><a href="callrecording/?id={{$lead->id}}">Download</a></td>                                                        
                                                    </tr>
                                                    @endforeach
                                                
                                            </table>
                                            <div>{{ $qualifiedleads->links() }}</div>     
                <x-section-border />
            
        </div>
    </div>
</x-app-layout>