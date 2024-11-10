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
        dispositiondate=DATE_FORMAT(A.dispositiondate, '%Y-%m-%d'), 
        campaignid=A.campaignid,
        instanceid=A.instanceid,
        campaign=A.campaign,
        callduration=A.callduration,
        dial=A.dial;");

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
        dispositiondate=DATE_FORMAT(A.dispositiondate, '%Y-%m-%d'), 
        campaignid=A.campaignid,
        instanceid=A.instanceid,
        campaign=A.campaign,
        connected=A.connected,
        connected_duration=A.connected_duration;");

        return 0;
    }
}