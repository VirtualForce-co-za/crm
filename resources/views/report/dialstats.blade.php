<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Credits') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

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

                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                   
                                            </table>

                <x-section-border />
        </div>
    </div>
</x-app-layout>