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
        DB::update("insert into dial_stats (dispositiondate, campaignid, instanceid, campaign, dispositionid, disposition, callduration)
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
        return 0;
    }
}