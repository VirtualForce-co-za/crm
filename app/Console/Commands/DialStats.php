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
        DB::update("insert into dial_stats
        select DATE_FORMAT(created_at, '%Y-%m-%d') as dispositiondate, campaignid, instanceid, campaign, dispositionid, 
        disposition, sum(callduration) as callduration from dial_dispositions dd join campaigns c on dd.campaignid=c.id
        group by DATE_FORMAT(created_at, '%Y-%m-%d'), campaignid, instanceid, campaign, dispositionid, 
        disposition
        on duplicate key update 
        dispositiondate=dd.DATE_FORMAT(created_at, '%Y-%m-%d'), 
        campaignid=dd.campaignid,
        instanceid=dd.instanceid,
        campaign=c.name,
        dispositionid=dd.dispositionid,
        disposition=dd.disposition,
        callduration=dd.callduration;");
        return 0;
    }
}