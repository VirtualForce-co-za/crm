<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Campaigns;
use App\Models\Leads;
use DB;
use Str;

class CampaignActions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:action {instanceid}';

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
        $instanceid = $this->argument('instanceid');
        while (1) {
            $campaigns = Campaigns::where('instanceid', $instanceid)->where(function ($query) {
                $query->where('status', 'dialing')
                    ->orWhere('status', 'redialing');
            })->get();
            if ($campaigns->isNotEmpty()) {
                foreach ($campaigns as $campaign) {
                    if ($campaign->instance->owntrunk == 1) {
                        $cps = $campaign->instance->cps;
                        $accountsid = $campaign->instance->accountsid;
                        $applicationsid = $campaign->instance->applicationsid;
                        $bearer = $campaign->instance->bearer;
                        $dialprefix = $campaign->instance->dialprefix;
                    } else {
                        $cps = $campaign->whitelabelinstance->cps;
                        $accountsid = $campaign->whitelabelinstance->accountsid;
                        $applicationsid = $campaign->whitelabelinstance->applicationsid;
                        $bearer = $campaign->whitelabelinstance->bearer;
                        $dialprefix = $campaign->whitelabelinstance->dialprefix;
                    }
                    $agentid = $campaign->agent->id;
                    if($agentid == 4){
                        $cps = 10;
                    }
                    $agent = $campaign->agent->location;
                    $cli = $campaign->cli;
                    if ($campaign->status == 'dialing') {
                        $leads = Leads::where('status', 0)
                            ->where('campaignid', $campaign->id)
                            ->limit($cps)->get();
                    } elseif ($campaign->status == 'redialing') {
                        $leads = Leads::where('campaignid', $campaign->id)
                            ->where(function ($query) {
                                $query->where('dispositionid', 5)
                                    ->orWhere('dispositionid', 6)
                                    ->orWhere('dispositionid', 7);
                            })
                            ->limit($cps)->get();
                    }
                    if ($leads->isNotEmpty()) {
                        foreach ($leads as $lead) {
                            try {
                                if ($dialprefix === '27') {
                                    $cellno = '27' . Str::substr($lead->cellno, 1);
                                } else {
                                    $cellno = $lead->cellno;
                                }
                                $curl = curl_init();
                                curl_setopt_array(
                                    $curl,
                                    array(
                                        CURLOPT_URL => 'http://localhost/api/v1/Accounts/' . $accountsid . '/Calls',
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => '',
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 10,
                                        CURLOPT_FOLLOWLOCATION => true,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_CUSTOMREQUEST => 'POST',
                                        CURLOPT_POSTFIELDS => '{
                                                            "application_sid": "' . $applicationsid . '",
                                                            "agent": "' . $agent . '",
                                                            "from": "' . $cli . '",
                                                            "to": {
                                                                    "type": "phone",
                                                                    "number": "' . $cellno . '"
                                                            }
                                                        }',
                                        CURLOPT_HTTPHEADER => array(
                                            'Authorization: Bearer ' . $bearer,
                                            'Content-Type: application/json'
                                        ),
                                    )
                                );
                                $response_curl = curl_exec($curl);
                                $response = json_decode($response_curl);
                                curl_close($curl);

                                if ($response->sid !== null) {
                                    $callsid = ", callsid='" . $response->sid . "'";
                                } else {
                                    $callsid = "";
                                }

                                DB::update("update leads set status=1  " . $callsid . ", updated_at=NOW() where id='" . $lead->id . "';");
                            } catch (\Exception $e) {
                                DB::update("update leads set status=1, dial_api_response='" . $e->getMessage() . "', updated_at=NOW() where id='" . $lead->id . "';");
                            }
                        }
                        sleep(1);
                    } else {
                        DB::update("update campaigns set status='Completed' where id=" . $campaign->id . ";");
                        return 0;
                    }
                }
            } else {
                return 0;
            }
        }
    }
}
