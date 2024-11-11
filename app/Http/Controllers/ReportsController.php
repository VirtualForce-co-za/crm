<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;
use Auth;
use App\Models\DialStatByRows;

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
}
