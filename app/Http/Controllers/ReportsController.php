<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;
use Auth;
use App\Models\DialStatByRows;
use App\Models\Campaigns;


class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dialstats()
    {
        return view('report/dialstats');        
    }

    public function dialstatsfull()
    {
        $campaigns = Campaigns::select('name')->where('instanceid', Auth::user()->instanceid)
                        ->groupby('name')->get();
        return view('report/dialstatsfull', compact('campaigns')); 
    }

    public function dialstats_submit(Request $request)
    {
        $datepicker_from = $request->input('datepicker_from');
        $datepicker_to = $request->input('datepicker_to');
        $dial_stat_by_rows = DB::table('dial_stat_by_rows')
                            ->select('campaign', 
                                    DB::raw('sum(dial) as dial'),
                                    DB::raw('sum(callduration) as callduration'),
                                    DB::raw('sum(connected) as connected'),
                                    DB::raw('sum(connected_duration) as connected_duration'),
                                    DB::raw('avg(connected_percent) as connected_percent'),
                                    DB::raw('sum(noanswer) as noanswer'),
                                    DB::raw('sum(noanswer_duration) as noanswer_duration'),
                                    DB::raw('avg(noanswer_percent) as noanswer_percent'),
                                    DB::raw('sum(callback) as callback'),
                                    DB::raw('sum(callback_duration) as callback_duration'),
                                    DB::raw('avg(callback_percent) as callback_percent'),
                                    DB::raw('sum(voicemail) as voicemail'),
                                    DB::raw('sum(voicemail_duration) as voicemail_duration'),
                                    DB::raw('avg(voicemail_percent) as voicemail_percent'),
                                    DB::raw('sum(silent) as silent'),
                                    DB::raw('sum(silent_duration) as silent_duration'),
                                    DB::raw('avg(silent_percent) as silent_percent'),
                                    DB::raw('sum(qualified) as qualified'),
                                    DB::raw('sum(qualified_duration) as qualified_duration'),
                                    DB::raw('avg(qualified_percent) as qualified_percent'),
                                    DB::raw('sum(busy) as busy'),
                                    DB::raw('sum(busy_duration) as busy_duration'),
                                    DB::raw('avg(busy_percent) as busy_percent'),
                                    DB::raw('sum(failed) as failed'),
                                    DB::raw('sum(failed_duration) as failed_duration'),
                                    DB::raw('avg(failed_percent) as failed_percent'),
                                    DB::raw('sum(notinterested) as notinterested'),
                                    DB::raw('sum(notinterested_duration) as notinterested_duration'),
                                    DB::raw('avg(notinterested_percent) as notinterested_percent'),
                                    DB::raw('sum(dnq) as dnq'),
                                    DB::raw('sum(dnq_duration) as dnq_duration'),
                                    DB::raw('avg(dnq_percent) as dnq_percent'),
                                    DB::raw('sum(others) as others'),
                                    DB::raw('sum(others_duration) as others_duration'),
                                    DB::raw('avg(others_percent) as others_percent')   
                                    )
                            ->where('dispositiondate', '>=' , $datepicker_from)
                            ->where('dispositiondate', '<=' , $datepicker_to)
                            ->where('instanceid', Auth::user()->instanceid)
                            ->groupby('campaign')
                            ->paginate(25);
        return view('report/dialstats_submit', compact('dial_stat_by_rows'));
    }

    public function dialstatsfull_submit(Request $request)
    {
        $datepicker_from = $request->input('datepicker_from');
        $datepicker_to = $request->input('datepicker_to');
        $campaign = $request->input('campaign');
        $campaigns = Campaigns::select('name')->where('instanceid', Auth::user()->instanceid)
                        ->groupby('name')->get();
        $dialstats = DB::table('dial_stat_by_rows')
                            ->select('campaign', 
                                    DB::raw('sum(dial) as dial'),
                                    DB::raw('sum(callduration) as callduration'),
                                    DB::raw('sum(connected) as connected'),
                                    DB::raw('sum(connected_duration) as connected_duration'),
                                    DB::raw('avg(connected_percent) as connected_percent'),
                                    DB::raw('sum(noanswer) as noanswer'),
                                    DB::raw('sum(noanswer_duration) as noanswer_duration'),
                                    DB::raw('avg(noanswer_percent) as noanswer_percent'),
                                    DB::raw('sum(callback) as callback'),
                                    DB::raw('sum(callback_duration) as callback_duration'),
                                    DB::raw('avg(callback_percent) as callback_percent'),
                                    DB::raw('sum(voicemail) as voicemail'),
                                    DB::raw('sum(voicemail_duration) as voicemail_duration'),
                                    DB::raw('avg(voicemail_percent) as voicemail_percent'),
                                    DB::raw('sum(silent) as silent'),
                                    DB::raw('sum(silent_duration) as silent_duration'),
                                    DB::raw('avg(silent_percent) as silent_percent'),
                                    DB::raw('sum(qualified) as qualified'),
                                    DB::raw('sum(qualified_duration) as qualified_duration'),
                                    DB::raw('avg(qualified_percent) as qualified_percent'),
                                    DB::raw('sum(busy) as busy'),
                                    DB::raw('sum(busy_duration) as busy_duration'),
                                    DB::raw('avg(busy_percent) as busy_percent'),
                                    DB::raw('sum(failed) as failed'),
                                    DB::raw('sum(failed_duration) as failed_duration'),
                                    DB::raw('avg(failed_percent) as failed_percent'),
                                    DB::raw('sum(notinterested) as notinterested'),
                                    DB::raw('sum(notinterested_duration) as notinterested_duration'),
                                    DB::raw('avg(notinterested_percent) as notinterested_percent'),
                                    DB::raw('sum(dnq) as dnq'),
                                    DB::raw('sum(dnq_duration) as dnq_duration'),
                                    DB::raw('avg(dnq_percent) as dnq_percent'),
                                    DB::raw('sum(dnc) as dnc'),
                                    DB::raw('sum(dnc_duration) as dnc_duration'),
                                    DB::raw('avg(dnc_percent) as dnc_percent'),
                                    DB::raw('sum(work_number) as work_number'),
                                    DB::raw('sum(work_number_duration) as work_number_duration'),
                                    DB::raw('avg(work_number_percent) as work_number_percent'),
                                    DB::raw('sum(unemployed) as unemployed'),
                                    DB::raw('sum(unemployed_duration) as unemployed_duration'),
                                    DB::raw('avg(unemployed_percent) as unemployed_percent'),
                                    DB::raw('sum(swearing) as swearing'),
                                    DB::raw('sum(swearing_duration) as swearing_duration'),
                                    DB::raw('avg(swearing_percent) as swearing_percent'),
                                    DB::raw('sum(`repeat`) as `repeat`'),
                                    DB::raw('sum(repeat_duration) as repeat_duration'),
                                    DB::raw('avg(repeat_percent) as repeat_percent'),
                                    DB::raw('sum(religion_barrier) as religion_barrier'),
                                    DB::raw('sum(religion_barrier_duration) as religion_barrier_duration'),
                                    DB::raw('avg(religion_barrier_percent) as religion_barrier_percent'),
                                    DB::raw('sum(relative_pays) as relative_pays'),
                                    DB::raw('sum(relative_pays_duration) as relative_pays_duration'),
                                    DB::raw('avg(relative_pays_percent) as relative_pays_percent'),
                                    DB::raw('sum(outdoor) as outdoor'),
                                    DB::raw('sum(outdoor_duration) as outdoor_duration'),
                                    DB::raw('avg(outdoor_percent) as outdoor_percent'),
                                    DB::raw('sum(others_pickup_call) as others_pickup_call'),
                                    DB::raw('sum(others_pickup_call_duration) as others_pickup_call_duration'),
                                    DB::raw('avg(others_pickup_call_percent) as others_pickup_call_percent'),
                                    DB::raw('sum(not_allowed) as not_allowed'),
                                    DB::raw('sum(not_allowed_duration) as not_allowed_duration'),
                                    DB::raw('avg(not_allowed_percent) as not_allowed_percent'),
                                    DB::raw('sum(no_car) as no_car'),
                                    DB::raw('sum(no_car_duration) as no_car_duration'),
                                    DB::raw('avg(no_car_percent) as no_car_percent'),
                                    DB::raw('sum(sick) as sick'),
                                    DB::raw('sum(sick_duration) as sick_duration'),
                                    DB::raw('avg(sick_percent) as sick_percent'),
                                    DB::raw('sum(angry) as angry'),
                                    DB::raw('sum(angry_duration) as angry_duration'),
                                    DB::raw('avg(angry_percent) as angry_percent'),
                                    DB::raw('sum(in_meeting) as in_meeting'),
                                    DB::raw('sum(in_meeting_duration) as in_meeting_duration'),
                                    DB::raw('avg(in_meeting_percent) as in_meeting_percent'),
                                    DB::raw('sum(home_chores) as home_chores'),
                                    DB::raw('sum(home_chores_duration) as home_chores_duration'),
                                    DB::raw('avg(home_chores_percent) as home_chores_percent'),
                                    DB::raw('sum(goodbyes) as goodbyes'),
                                    DB::raw('sum(goodbyes_duration) as goodbyes_duration'),
                                    DB::raw('avg(goodbyes_percent) as goodbyes_percent'),
                                    DB::raw('sum(fallback) as fallback'),
                                    DB::raw('sum(fallback_duration) as fallback_duration'),
                                    DB::raw('avg(fallback_percent) as fallback_percent'),
                                    DB::raw('sum(expecting_call) as expecting_call'),
                                    DB::raw('sum(expecting_call_duration) as expecting_call_duration'),
                                    DB::raw('avg(expecting_call_percent) as expecting_call_percent'),
                                    DB::raw('sum(driving) as driving'),
                                    DB::raw('sum(driving_duration) as driving_duration'),
                                    DB::raw('avg(driving_percent) as driving_percent'),
                                    DB::raw('sum(children) as children'),
                                    DB::raw('sum(children_duration) as children_duration'),
                                    DB::raw('avg(children_percent) as children_percent'),
                                    DB::raw('sum(broker) as broker'),
                                    DB::raw('sum(broker_duration) as broker_duration'),
                                    DB::raw('avg(broker_percent) as broker_percent'),
                                    DB::raw('sum(bathroom) as bathroom'),
                                    DB::raw('sum(bathroom_duration) as bathroom_duration'),
                                    DB::raw('avg(bathroom_percent) as bathroom_percent'),
                                    DB::raw('sum(already_your_client) as already_your_client'),
                                    DB::raw('sum(already_your_client_duration) as already_your_client_duration'),
                                    DB::raw('avg(already_your_client_percent) as already_your_client_percent'),
                                    DB::raw('sum(already_quoted) as already_quoted'),
                                    DB::raw('sum(already_quoted_duration) as already_quoted_duration'),
                                    DB::raw('avg(already_quoted_percent) as already_quoted_percent'),
                                    DB::raw('sum(already_covered) as already_covered'),
                                    DB::raw('sum(already_covered_duration) as already_covered_duration'),
                                    DB::raw('avg(already_covered_percent) as already_covered_percent'),
                                    DB::raw('sum(reason_unknown) as reason_unknown'),
                                    DB::raw('sum(reason_unknown_duration) as reason_unknown_duration'),
                                    DB::raw('avg(reason_unknown_percent) as reason_unknown_percent'),
                                    DB::raw('sum(timeout) as timeout'),
                                    DB::raw('sum(timeout_duration) as timeout_duration'),
                                    DB::raw('avg(timeout_percent) as timeout_percent'),
                                    DB::raw('sum(user_hangup) as user_hangup'),
                                    DB::raw('sum(user_hangup_duration) as user_hangup_duration'),
                                    DB::raw('avg(user_hangup_percent) as user_hangup_percent')
                                    )
                            ->where('dispositiondate', '>=' , $datepicker_from)
                            ->where('dispositiondate', '<=' , $datepicker_to)
                            ->where('campaign', $campaign)
                            ->where('instanceid', Auth::user()->instanceid)
                            ->groupby('campaign')
                            ->get();
                            
        return view('report/dialstatsfull_submit', compact('dialstats', 'campaigns'));
    }
}
