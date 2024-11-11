<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Campaigns;
use App\Models\Leads;
use App\Models\Dialdispositions;
use DB;
use Str;

class DialStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dial:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        set_time_limit(0);
        DB::statement(' SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED');

        /*
        DB::statement("insert into dial_stats (dispositiondate, campaignid, instanceid, campaign, dispositionid, disposition, callduration)
        select DATE_FORMAT(dd.created_at, '%Y-%m-%d') as dispositiondate, campaignid, dd.instanceid, c.name as campaign, dispositionid, 
        disposition, sum(callduration) as callduration from dial_dispositions dd join campaigns c on dd.campaignid=c.id
        group by DATE_FORMAT(dd.created_at, '%Y-%m-%d'), campaignid, dd.instanceid, c.name, dispositionid, 
        disposition ON DUPLICATE KEY UPDATE 
        dispositiondate=DATE_FORMAT(dispositiondate, '%Y-%m-%d'), 
        campaignid=campaignid,
        instanceid=instanceid,
        campaign=campaign,
        dispositionid=dispositionid,
        disposition=disposition,
        callduration=callduration;");
        */

        //dial
        DB::statement("insert into dial_stat_by_rows (dispositiondate, campaignid, instanceid, campaign, callduration, dial)
        SELECT * FROM (
        select DATE_FORMAT(dd.created_at, '%Y-%m-%d') as dispositiondate, campaignid, dd.instanceid, c.name as campaign, 
        sum(callduration) as callduration, 
        count(dd.id) as dial
        from dial_dispositions dd join campaigns c on dd.campaignid=c.id
        where DATE_FORMAT(dd.created_at, '%Y-%m-%d')=curdate()
        group by DATE_FORMAT(dd.created_at, '%Y-%m-%d'), campaignid, instanceid, c.name 
        ) A
        ON DUPLICATE KEY UPDATE 
        instanceid=A.instanceid,
        campaign=A.campaign,
        callduration=A.callduration,
        dial=A.dial;");

        //connected
        DB::statement("insert into dial_stat_by_rows (dispositiondate, campaignid, instanceid, campaign, connected, connected_duration)
        SELECT * FROM (
        select DATE_FORMAT(dd.created_at, '%Y-%m-%d') as dispositiondate, campaignid, dd.instanceid, c.name as campaign, 
        count(dd.id) as connected,
        sum(callduration) as connected_duration
        from dial_dispositions dd join campaigns c on dd.campaignid=c.id
        where dd.disposition not in ('No Answer', 'Busy', 'Failed', 'Voicemail', 'Silent')
        and DATE_FORMAT(dd.created_at, '%Y-%m-%d')=curdate()
        group by DATE_FORMAT(dd.created_at, '%Y-%m-%d'), campaignid, instanceid, c.name
        ) A
        ON DUPLICATE KEY UPDATE 
        instanceid=A.instanceid,
        campaign=A.campaign,
        connected=A.connected,
        connected_duration=A.connected_duration;");

        //All Dispositions
        DB::statement("insert into dial_stat_by_rows (dispositiondate, campaignid, instanceid, campaign, qualified, qualified_duration, noanswer, noanswer_duration, 
        busy, busy_duration, failed, failed_duration, silent, silent_duration, notinterested, notinterested_duration, dnq, dnq_duration, callback, callback_duration, 
        voicemail, voicemail_duration, dnc, dnc_duration, work_number, work_number_duration, unemployed, unemployed_duration, swearing, swearing_duration, `repeat`, 
        repeat_duration, religion_barrier, religion_barrier_duration, relative_pays, relative_pays_duration, outdoor, outdoor_duration, others_pickup_call, 
        others_pickup_call_duration, not_allowed, not_allowed_duration, no_car, no_car_duration, sick, sick_duration, angry, angry_duration, in_meeting, 
        in_meeting_duration, home_chores, home_chores_duration, goodbyes, goodbyes_duration, fallback, fallback_duration, expecting_call, expecting_call_duration, 
        driving, driving_duration, children, children_duration, broker, broker_duration, bathroom, bathroom_duration, already_your_client, already_your_client_duration, 
        already_quoted, already_quoted_duration, already_covered, already_covered_duration, reason_unknown, reason_unknown_duration, timeout, timeout_duration, 
        user_hangup, user_hangup_duration)
        SELECT * FROM (
        select DATE_FORMAT(dd.created_at, '%Y-%m-%d') as dispositiondate, campaignid, dd.instanceid, c.name as campaign, 
        SUM(CASE WHEN dd.disposition = 'Qualified' THEN 1 ELSE 0 END) AS qualified,
        SUM(CASE WHEN dd.disposition = 'Qualified' THEN dd.callduration ELSE 0 END) AS qualified_duration,
        SUM(CASE WHEN dd.disposition = 'No Answer' THEN 1 ELSE 0 END) AS noanswer,
        SUM(CASE WHEN dd.disposition = 'No Answer' THEN dd.callduration ELSE 0 END) AS noanswer_duration,
        SUM(CASE WHEN dd.disposition = 'Busy' THEN 1 ELSE 0 END) AS busy,
        SUM(CASE WHEN dd.disposition = 'Busy' THEN dd.callduration ELSE 0 END) AS busy_duration,
        SUM(CASE WHEN dd.disposition = 'Failed' THEN 1 ELSE 0 END) AS failed,
        SUM(CASE WHEN dd.disposition = 'Failed' THEN dd.callduration ELSE 0 END) AS failed_duration,
        SUM(CASE WHEN dd.disposition = 'Silent' THEN 1 ELSE 0 END) AS silent,
        SUM(CASE WHEN dd.disposition = 'Silent' THEN dd.callduration ELSE 0 END) AS silent_duration,
        SUM(CASE WHEN dd.disposition = 'Not Interested' THEN 1 ELSE 0 END) AS notinterested,
        SUM(CASE WHEN dd.disposition = 'Not Interested' THEN dd.callduration ELSE 0 END) AS notinterested_duration,
        SUM(CASE WHEN dd.disposition = 'DNQ' THEN 1 ELSE 0 END) AS dnq,
        SUM(CASE WHEN dd.disposition = 'DNQ' THEN dd.callduration ELSE 0 END) AS dnq_duration,
        SUM(CASE WHEN dd.disposition = 'Callback' THEN 1 ELSE 0 END) AS callback,
        SUM(CASE WHEN dd.disposition = 'Callback' THEN dd.callduration ELSE 0 END) AS callback_duration,
        SUM(CASE WHEN dd.disposition = 'Voicemail' THEN 1 ELSE 0 END) AS voicemail,
        SUM(CASE WHEN dd.disposition = 'Voicemail' THEN dd.callduration ELSE 0 END) AS voicemail_duration,
        SUM(CASE WHEN dd.disposition = 'DNC' THEN 1 ELSE 0 END) AS dnc,
        SUM(CASE WHEN dd.disposition = 'DNC' THEN dd.callduration ELSE 0 END) AS dnc_duration,
        SUM(CASE WHEN dd.disposition = 'Work Number' THEN 1 ELSE 0 END) AS work_number,
        SUM(CASE WHEN dd.disposition = 'Work Number' THEN dd.callduration ELSE 0 END) AS work_number_duration,
        SUM(CASE WHEN dd.disposition = 'Unemployed' THEN 1 ELSE 0 END) AS unemployed,
        SUM(CASE WHEN dd.disposition = 'Unemployed' THEN dd.callduration ELSE 0 END) AS unemployed_duration,
        SUM(CASE WHEN dd.disposition = 'Swearing' THEN 1 ELSE 0 END) AS swearing,
        SUM(CASE WHEN dd.disposition = 'Swearing' THEN dd.callduration ELSE 0 END) AS swearing_duration,
        SUM(CASE WHEN dd.disposition = 'Repeat' THEN 1 ELSE 0 END) AS `repeat`,
        SUM(CASE WHEN dd.disposition = 'Repeat' THEN dd.callduration ELSE 0 END) AS repeat_duration,
        SUM(CASE WHEN dd.disposition = 'Religion Barrier' THEN 1 ELSE 0 END) AS religion_barrier,
        SUM(CASE WHEN dd.disposition = 'Religion Barrier' THEN dd.callduration ELSE 0 END) AS religion_barrier_duration,
        SUM(CASE WHEN dd.disposition = 'Relatives Pays' THEN 1 ELSE 0 END) AS relative_pays,
        SUM(CASE WHEN dd.disposition = 'Relatives Pays' THEN dd.callduration ELSE 0 END) AS relative_pays_duration,
        SUM(CASE WHEN dd.disposition = 'Outdoor' THEN 1 ELSE 0 END) AS outdoor,
        SUM(CASE WHEN dd.disposition = 'Outdoor' THEN dd.callduration ELSE 0 END) AS outdoor_duration,
        SUM(CASE WHEN dd.disposition = 'Others Pickup Call' THEN 1 ELSE 0 END) AS others_pickup_call,
        SUM(CASE WHEN dd.disposition = 'Others Pickup Call' THEN dd.callduration ELSE 0 END) AS others_pickup_call_duration,
        SUM(CASE WHEN dd.disposition = 'Not Allowed' THEN 1 ELSE 0 END) AS not_allowed,
        SUM(CASE WHEN dd.disposition = 'Not Allowed' THEN dd.callduration ELSE 0 END) AS not_allowed_duration, 
        SUM(CASE WHEN dd.disposition = 'No Car' THEN 1 ELSE 0 END) AS no_car,
        SUM(CASE WHEN dd.disposition = 'No Car' THEN dd.callduration ELSE 0 END) AS no_car_duration, 
        SUM(CASE WHEN dd.disposition = 'Sick' THEN 1 ELSE 0 END) AS sick,
        SUM(CASE WHEN dd.disposition = 'Sick' THEN dd.callduration ELSE 0 END) AS sick_duration,
        SUM(CASE WHEN dd.disposition = 'Angry' THEN 1 ELSE 0 END) AS angry,
        SUM(CASE WHEN dd.disposition = 'Angry' THEN dd.callduration ELSE 0 END) AS angry_duration, 
        SUM(CASE WHEN dd.disposition = 'In Meeting' THEN 1 ELSE 0 END) AS in_meeting,
        SUM(CASE WHEN dd.disposition = 'In Meeting' THEN dd.callduration ELSE 0 END) AS in_meeting_duration, 
        SUM(CASE WHEN dd.disposition = 'Home Chores' THEN 1 ELSE 0 END) AS home_chores,
        SUM(CASE WHEN dd.disposition = 'Home Chores' THEN dd.callduration ELSE 0 END) AS home_chores_duration,
        SUM(CASE WHEN dd.disposition = 'Goodbyes' THEN 1 ELSE 0 END) AS goodbyes,
        SUM(CASE WHEN dd.disposition = 'Goodbyes' THEN dd.callduration ELSE 0 END) AS goodbyes_duration,
        SUM(CASE WHEN dd.disposition = 'Fallback' THEN 1 ELSE 0 END) AS fallback,
        SUM(CASE WHEN dd.disposition = 'Fallback' THEN dd.callduration ELSE 0 END) AS fallback_duration, 
        SUM(CASE WHEN dd.disposition = 'Expecting Call' THEN 1 ELSE 0 END) AS expecting_call,
        SUM(CASE WHEN dd.disposition = 'Expecting Call' THEN dd.callduration ELSE 0 END) AS expecting_call_duration, 
        SUM(CASE WHEN dd.disposition = 'Driving' THEN 1 ELSE 0 END) AS driving,
        SUM(CASE WHEN dd.disposition = 'Driving' THEN dd.callduration ELSE 0 END) AS driving_duration,
        SUM(CASE WHEN dd.disposition = 'Children' THEN 1 ELSE 0 END) AS children,
        SUM(CASE WHEN dd.disposition = 'Children' THEN dd.callduration ELSE 0 END) AS children_duration, 
        SUM(CASE WHEN dd.disposition = 'Broker' THEN 1 ELSE 0 END) AS broker,
        SUM(CASE WHEN dd.disposition = 'Broker' THEN dd.callduration ELSE 0 END) AS broker_duration, 
        SUM(CASE WHEN dd.disposition = 'Bathroom' THEN 1 ELSE 0 END) AS bathroom,
        SUM(CASE WHEN dd.disposition = 'Bathroom' THEN dd.callduration ELSE 0 END) AS bathroom_duration, 
        SUM(CASE WHEN dd.disposition = 'Already Your Client' THEN 1 ELSE 0 END) AS already_your_client,
        SUM(CASE WHEN dd.disposition = 'Already Your Client' THEN dd.callduration ELSE 0 END) AS already_your_client_duration, 
        SUM(CASE WHEN dd.disposition = 'Already Quoted' THEN 1 ELSE 0 END) AS already_quoted,
        SUM(CASE WHEN dd.disposition = 'Already Quoted' THEN dd.callduration ELSE 0 END) AS already_quoted_duration, 
        SUM(CASE WHEN dd.disposition = 'Already Covered' THEN 1 ELSE 0 END) AS already_covered,
        SUM(CASE WHEN dd.disposition = 'Already Covered' THEN dd.callduration ELSE 0 END) AS already_covered_duration, 
        SUM(CASE WHEN dd.disposition = 'Reason Unknown' THEN 1 ELSE 0 END) AS reason_unknown,
        SUM(CASE WHEN dd.disposition = 'Reason Unknown' THEN dd.callduration ELSE 0 END) AS reason_unknown_duration, 
        SUM(CASE WHEN dd.disposition = 'Timeout' THEN 1 ELSE 0 END) AS timeout,
        SUM(CASE WHEN dd.disposition = 'Timeout' THEN dd.callduration ELSE 0 END) AS timeout_duration, 
        SUM(CASE WHEN dd.disposition = 'User Hangup' THEN 1 ELSE 0 END) AS user_hangup,
        SUM(CASE WHEN dd.disposition = 'User Hangup' THEN dd.callduration ELSE 0 END) AS user_hangup_duration
        from dial_dispositions dd join campaigns c on dd.campaignid=c.id
        where DATE_FORMAT(dd.created_at, '%Y-%m-%d')=curdate()
        group by DATE_FORMAT(dd.created_at, '%Y-%m-%d'), campaignid, instanceid, c.name
        ) A
        ON DUPLICATE KEY UPDATE 
        instanceid=A.instanceid,
        campaign=A.campaign,
        qualified=A.qualified,
        qualified_duration=A.qualified_duration,
        noanswer=A.noanswer,
        noanswer_duration=A.noanswer_duration,
        busy=A.busy,
        busy_duration=A.busy_duration,
        failed=A.failed,
        failed_duration=A.failed_duration,
        silent=A.silent,
        silent_duration=A.silent_duration,
        notinterested=A.notinterested,
        notinterested_duration=A.notinterested_duration,
        dnq=A.dnq,
        dnq_duration=A.dnq_duration,
        callback=A.callback,
        callback_duration=A.callback_duration,
        voicemail=A.voicemail,
        voicemail_duration=A.voicemail_duration,
        dnc=A.dnc,
        dnc_duration=A.dnc_duration,
        work_number=A.work_number,
        work_number_duration=A.work_number_duration,
        unemployed=A.unemployed,
        unemployed_duration=A.unemployed_duration,
        swearing=A.swearing,
        swearing_duration=A.swearing_duration,
        `repeat`=A.repeat,
        repeat_duration=A.repeat_duration,
        religion_barrier=A.religion_barrier,
        religion_barrier_duration=A.religion_barrier_duration,
        relative_pays=A.relative_pays,
        relative_pays_duration=A.relative_pays_duration,
        outdoor=A.outdoor,
        outdoor_duration=A.outdoor_duration,
        others_pickup_call=A.others_pickup_call,
        others_pickup_call_duration=A.others_pickup_call_duration,
        not_allowed=A.not_allowed,
        not_allowed_duration=A.not_allowed_duration,
        no_car=A.no_car,
        no_car_duration=A.no_car_duration,
        sick=A.sick,
        sick_duration=A.sick_duration,
        angry=A.angry,
        angry_duration=A.angry_duration,
        in_meeting=A.in_meeting,
        in_meeting_duration=A.in_meeting_duration,
        home_chores=A.home_chores,
        home_chores_duration=A.home_chores_duration,
        goodbyes=A.goodbyes,
        goodbyes_duration=A.goodbyes_duration,
        fallback=A.fallback,
        fallback_duration=A.fallback_duration,
        expecting_call=A.expecting_call,
        expecting_call_duration=A.expecting_call_duration,
        driving=A.driving,
        driving_duration=A.driving_duration,
        children=A.children,
        children_duration=A.children_duration,
        broker=A.broker,
        broker_duration=A.broker_duration,
        bathroom=A.bathroom,
        bathroom_duration=A.bathroom_duration,
        already_your_client=A.already_your_client,
        already_your_client_duration=A.already_your_client_duration,
        already_quoted=A.already_quoted,
        already_quoted_duration=A.already_quoted_duration,
        already_covered=A.already_covered,
        already_covered_duration=A.already_covered_duration,
        reason_unknown=A.reason_unknown,
        reason_unknown_duration=A.reason_unknown_duration,
        timeout=A.timeout,
        timeout_duration=A.timeout_duration,
        user_hangup=A.user_hangup,
        user_hangup_duration=A.user_hangup_duration;");

        //Other
        DB::statement("insert into dial_stat_by_rows (dispositiondate, campaignid, instanceid, campaign, others, others_duration)
        SELECT * FROM (
        select DATE_FORMAT(dd.created_at, '%Y-%m-%d') as dispositiondate, campaignid, dd.instanceid, c.name as campaign, 
        count(dd.id) as others,
        sum(callduration) as others_duration
        from dial_dispositions dd join campaigns c on dd.campaignid=c.id
        where dd.disposition not in ('Qualified', 'No Answer', 'Busy', 'Failed', 'Silent', 'Not Interested', 'DNQ', 'Callback', 'Voicemail')
        # and DATE_FORMAT(dd.created_at, '%Y-%m-%d')=curdate()
        group by DATE_FORMAT(dd.created_at, '%Y-%m-%d'), campaignid, instanceid, c.name
        ) A
        ON DUPLICATE KEY UPDATE 
        instanceid=A.instanceid,
        campaign=A.campaign,
        others=A.others,
        others_duration=A.others_duration;");

        //update percent
        DB::update("update dial_stat_by_rows 
        set connected_percent = CASE WHEN dial > 0 THEN (connected/dial)*100 ELSE 0 END,
        noanswer_percent = CASE WHEN dial > 0 THEN (noanswer/dial)*100 ELSE 0 END,
        callback_percent = CASE WHEN connected > 0 THEN (callback/connected)*100 ELSE 0 END,
        voicemail_percent = CASE WHEN dial > 0 THEN (voicemail/dial)*100 ELSE 0 END,
        silent_percent = CASE WHEN dial > 0 THEN (silent/dial)*100 ELSE 0 END,
        qualified_percent = CASE WHEN connected > 0 THEN (qualified/connected)*100 ELSE 0 END,
        busy_percent = CASE WHEN dial > 0 THEN (busy/dial)*100 ELSE 0 END,
        failed_percent = CASE WHEN dial > 0 THEN (failed/dial)*100 ELSE 0 END,
        notinterested_percent = CASE WHEN connected > 0 THEN (notinterested/connected)*100 ELSE 0 END,
        dnq_percent = CASE WHEN connected > 0 THEN (dnq/connected)*100 ELSE 0 END,
        others_percent = CASE WHEN connected > 0 THEN (others/connected)*100 ELSE 0 END, 
        dnc_percent = CASE WHEN connected > 0 THEN (dnc/connected)*100 ELSE 0 END, 
        work_number_percent = CASE WHEN connected > 0 THEN (work_number/connected)*100 ELSE 0 END, 
        unemployed_percent = CASE WHEN connected > 0 THEN (unemployed/connected)*100 ELSE 0 END, 
        swearing_percent = CASE WHEN connected > 0 THEN (swearing/connected)*100 ELSE 0 END, 
        repeat_percent = CASE WHEN connected > 0 THEN (`repeat`/connected)*100 ELSE 0 END, 
        religion_barrier_percent = CASE WHEN connected > 0 THEN (religion_barrier/connected)*100 ELSE 0 END, 
        relative_pays_percent = CASE WHEN connected > 0 THEN (relative_pays/connected)*100 ELSE 0 END, 
        outdoor_percent = CASE WHEN connected > 0 THEN (outdoor/connected)*100 ELSE 0 END, 
        others_pickup_call_percent = CASE WHEN connected > 0 THEN (others_pickup_call/connected)*100 ELSE 0 END, 
        not_allowed_percent = CASE WHEN connected > 0 THEN (not_allowed/connected)*100 ELSE 0 END, 
        no_car_percent = CASE WHEN connected > 0 THEN (no_car/connected)*100 ELSE 0 END, 
        sick_percent = CASE WHEN connected > 0 THEN (sick/connected)*100 ELSE 0 END, 
        angry_percent = CASE WHEN connected > 0 THEN (angry/connected)*100 ELSE 0 END, 
        in_meeting_percent = CASE WHEN connected > 0 THEN (in_meeting/connected)*100 ELSE 0 END, 
        home_chores_percent = CASE WHEN connected > 0 THEN (home_chores/connected)*100 ELSE 0 END, 
        goodbyes_percent = CASE WHEN connected > 0 THEN (goodbyes/connected)*100 ELSE 0 END, 
        fallback_percent = CASE WHEN connected > 0 THEN (fallback/connected)*100 ELSE 0 END, 
        expecting_call_percent = CASE WHEN connected > 0 THEN (expecting_call/connected)*100 ELSE 0 END, 
        driving_percent = CASE WHEN connected > 0 THEN (driving/connected)*100 ELSE 0 END, 
        children_percent = CASE WHEN connected > 0 THEN (children/connected)*100 ELSE 0 END, 
        broker_percent = CASE WHEN connected > 0 THEN (broker/connected)*100 ELSE 0 END, 
        bathroom_percent = CASE WHEN connected > 0 THEN (bathroom/connected)*100 ELSE 0 END, 
        already_your_client_percent = CASE WHEN connected > 0 THEN (already_your_client/connected)*100 ELSE 0 END, 
        already_quoted_percent = CASE WHEN connected > 0 THEN (already_quoted/connected)*100 ELSE 0 END, 
        already_covered_percent = CASE WHEN connected > 0 THEN (already_covered/connected)*100 ELSE 0 END, 
        reason_unknown_percent = CASE WHEN connected > 0 THEN (reason_unknown/connected)*100 ELSE 0 END, 
        timeout_percent = CASE WHEN connected > 0 THEN (timeout/connected)*100 ELSE 0 END, 
        user_hangup_percent = CASE WHEN connected > 0 THEN (user_hangup/connected)*100 ELSE 0 END        
        where DATE_FORMAT(dd.created_at, '%Y-%m-%d')=curdate();");

        return 0;
    }
}