<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Campaigns;
use App\Models\Leads;
use DB;

class CampaignFileUploads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:campaign-file-uploads {campaignid} {datatype}';

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
        $campaignid = $this->argument('campaignid');
        $datatype = $this->argument('datatype');
        $campaign = Campaigns::where('id', $campaignid)->first();
        $file = storage_path('imports/' . $campaign->filename);
        $linenumber = 0;
        $dialprefix = $campaign->instance->dialprefix;

        if (($handle = fopen($file, "r")) !== FALSE) {
            while (($row = fgetcsv($handle, 0, ',')) !== false) {
                if($linenumber == 1){
if($datatype == "cellnoonly"){
    $row[0] = utf8_encode($row[0]);
                if ($row[0] != "" && $row[0] != "NULL" && $row[0] != null) {
                    $cellno = str_replace(' ', '', $row[0]);
                    $cellno = preg_replace('/[^0-9]/', '', $cellno);
                    $cellno = '0' . substr($cellno, -9);
                    
                    $cellnodncs = DB::table('cellnodncs')->where('cellno', $cellno)
                    ->where('instanceid', $campaign->instance->id)->first();

                        if (strlen($cellno) === 10) {
                            $lead = new Leads();
                            $lead->campaignid = $campaignid;
                            $lead->instanceid = $campaign->instance->id;
                            $lead->cellno = $cellno;
                            $lead->save();
                    }
                }
}
                    else{
                $row[3] = utf8_encode($row[3]);
                if ($row[3] != "" && $row[3] != "NULL" && $row[3] != null) {
                    $cellno = str_replace(' ', '', $row[3]);
                    $cellno = preg_replace('/[^0-9]/', '', $cellno);
                    $cellno = '0' . substr($cellno, -9);
                    
                    $cellnodncs = DB::table('cellnodncs')->where('cellno', $cellno)
                    ->where('instanceid', $campaign->instance->id)->first();

                    $idnodncs = DB::table('idnodncs')->where('idno', $row[4])
                    ->where('instanceid', $campaign->instance->id)->first();

                        if (strlen($cellno) === 10) {
                            $lead = new Leads();
                            $lead->campaignid = $campaignid;
                            $lead->instanceid = $campaign->instance->id;
                            $lead->title = $row[0];
                            $lead->name = $row[1];
                            $lead->surname = $row[2];
                            $lead->cellno = $cellno;
                            $lead->idno = $row[4];
                            $lead->save();
                    }
                }
            }
            }else{
                $linenumber = 1;
                $campaign->status = 'data importing';
                $campaign->save();
            }
        
        }
            $campaign->status = 'ready';
            $campaign->save();
        }
    }
}
