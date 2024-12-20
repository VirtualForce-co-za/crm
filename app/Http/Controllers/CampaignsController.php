<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaigns;
use App\Models\Agents;
use Illuminate\Support\Facades\Session;
use DB;
use Auth;
use App\Models\Instances;

class CampaignsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function campaigns()
    {
        if (auth::id() == 1) {
            $campaigns = Campaigns::paginate(25);
        } elseif (Auth::user()->whitelabel == 1) {
            $campaigns = Campaigns::where('instanceid', Auth::user()->instanceid)
                        ->orWhere('whitelabeluserid', auth::id())->paginate(25);
        } else {
            $campaigns = Campaigns::where('instanceid', Auth::user()->instanceid)->paginate(25);
        }
        return view('campaign/campaigns', compact('campaigns'));

    }

    public function addcampaign()
    {
        if (auth::id() == 1) {
            $instances = Instances::all();
            $agents = Agents::all();
            return view('campaign/addcampaign', compact('instances', 'agents'));
        }
        elseif (Auth::user()->whitelabel == 1) {
            $instances = Instances::where('whitelabeluserid', auth::id())
                            ->orWhere('id', Auth::user()->instanceid)->get();
            $agents = Agents::where('whitelabeluserid', auth::id())
                            ->orWhere('instanceid', Auth::user()->instanceid)->get();
            return view('campaign/addcampaign', compact('instances', 'agents'));
        } 
        else {
            $instance = Instances::where('id', Auth::user()->instanceid)->first();
            $agents = Agents::where('instanceid', Auth::user()->instanceid)->get();
            return view('campaign/addcampaign', compact('instance', 'agents'));
        }
    }

    public function editcampaign(Request $request)
    {
        if (auth::id() == 1) {
            $campaignid = $request->input('id');
            $campaign = Campaigns::where('id', $campaignid)->first();
            $instances = Instances::all();
            $agents = Agents::all();
            return view('campaign/editcampaign', compact('campaign', 'instances', 'agents'));
        } 
        elseif (Auth::user()->whitelabel == 1) {
            $campaignid = $request->input('id');
            $campaign = Campaigns::where('id', $campaignid)->first();
            $instances = Instances::where('whitelabeluserid', auth::id())
                                    ->orWhere('id', Auth::user()->instanceid)->get();
            $agents = Agents::where('whitelabeluserid', auth::id())
                            ->orWhere('instanceid', Auth::user()->instanceid)->get();
            return view('campaign/editcampaign', compact('campaign', 'instances', 'agents'));
        }
        else {
            $campaignid = $request->input('id');
            $campaign = Campaigns::where('id', $campaignid)
                ->where('instanceid', Auth::user()->instanceid)->first();
            $instance = Instances::where('id', Auth::user()->instanceid)->first();
            $agents = Agents::where('instanceid', Auth::user()->instanceid)->get();
            return view('campaign/editcampaign', compact('campaign', 'instance', 'agents'));
        }
    }

    public function addcampaignsubmit(Request $request)
    {
        $file = $request->file('filename');
        if ($file) {
            $campaign = new Campaigns();
            $campaign->name = $request->input('name');
            $campaign->cli = $request->input('cli');
            $campaign->agentid = $request->input('agentid');
            if (auth::id() == 1 || Auth::user()->whitelabel == 1) {
                $campaign->instanceid = $request->input('instanceid');
            } else {
                $campaign->instanceid = Auth::user()->instanceid;
            }
            $campaign->whitelabelinstanceid = Auth::user()->whitelabelinstanceid;
            $campaign->status = "file uploading";
            $campaign->save();

            $storage_location = storage_path('imports');
            if (!file_exists($storage_location)) {
                if (!mkdir($storage_location, 0755, true)) {
                    throw new \Exception("Unable to create storage location");
                }
            }

            $campaignid = $campaign->id;
            $campaign->filename = $campaignid . ' - ' . $file->getClientOriginalName();
            $file->move($storage_location, $campaign->filename);
            $campaign->status = "file uploaded";
            $campaign->save();

            $cmd = "php /var/www/crm/artisan app:campaign-file-uploads " . $campaignid. " " . $request->input('datatype');
            $outputfile = '/var/www/crm/storage/output' . $campaignid;
            $pidfile = '/var/www/crm/storage/pidfile' . $campaignid;
            exec(sprintf("%s > %s 2>&1 & echo $! >> %s", $cmd, $outputfile, $pidfile));

            Session::flash('status', 'Campaign Created Successfully!');
            return redirect('/campaigns');
        } else {
            return redirect('/addcampaign');
        }
    }

    public function editcampaignsubmit(Request $request)
    {
        $campaign->whitelabelinstanceid = Auth::user()->whitelabelinstanceid;
        if (auth::id() == 1) {
            $campaignid = $request->input('campaignid');
            $name = $request->input('name');
            $cli = $request->input('cli');
            $agentid = $request->input('agentid');
            $instanceid = $request->input('instanceid');
            $whitelabelinstanceid = 1;
            DB::update("update campaigns set 
                        name='" . $name . "', cli='" . $cli . "', agentid=" . $agentid . ", 
                        instanceid=" . $instanceid . ", whitelabelinstanceid=" . $whitelabelinstanceid . ", 
                        updated_at=NOW() where id=" . $campaignid . ";");
            Session::flash('status', 'Campaign Updated Successfully!');
            return redirect('/campaigns');
        } else {
            $campaignid = $request->input('campaignid');
            $name = $request->input('name');
            $cli = $request->input('cli');
            $agentid = $request->input('agentid');
            $instanceid = Auth::user()->instanceid;
            $whitelabelinstanceid = Auth::user()->whitelabelinstanceid;
            DB::update("update campaigns set 
                        name='" . $name . "', cli='" . $cli . "', agentid=" . $agentid . ", whitelabelinstanceid=" . $whitelabelinstanceid . ", 
                        updated_at=NOW() where id=" . $campaignid . " and instanceid=" . $instanceid . ";");
            Session::flash('status', 'Campaign Updated Successfully!');
            return redirect('/campaigns');
        }
    }

    public function actioncampaign(Request $request)
    {
        $campaignid = $request->input('id');
        if (auth::id() != 1) {
            $campaign = Campaigns::where('id', $campaignid)->where('instanceid', Auth::user()->instanceid)->first();
            if ($campaign->instanceid != Auth::user()->instanceid) {
                return redirect('/campaigns');
            }
        } else {
            $campaign = Campaigns::where('id', $campaignid)->first();
        }
        $action = $request->input('action');
        if ($action == "dial" || $action == "resume" || $action == "redial" || $action == "resumeredial") {
            if ($action == "dial" || $action == "resume") {
                $status = "dialing";
            } elseif ($action == "redial" || $action == "resumeredial") {
                $status = "redialing";
            }
            DB::update("update campaigns set status='" . $status . "', updated_at=NOW() where id=" . $campaignid . ";");
            $campaign_runcheck = Campaigns::where('id', "!=", $campaignid)
                ->where('instanceid', $campaign->instance->id)
                ->where(function ($query) {
                    $query->where('status', 'dialing')
                        ->orWhere('status', 'redialing');
                })->first();
            if ($campaign_runcheck == null) {
                $cmd = "php /var/www/crm/artisan campaign:action " . $campaign->instanceid;
                $outputfile = '/var/www/crm/storage/output' . $campaign->instanceid;
                $pidfile = '/var/www/crm/storage/pidfile' . $campaign->instanceid;
                exec(sprintf("%s > %s 2>&1 & echo $! >> %s", $cmd, $outputfile, $pidfile));
            }
        } elseif ($action == "pause" || $action == "redialpaused") {
            if ($action == "pause") {
                $status = "paused";
            } elseif ($action == "redialpaused") {
                $status = "redialpaused";
            }
            DB::update("update campaigns set status='" . $status . "', updated_at=NOW() where id=" . $campaignid . ";");
        }
        return redirect('/campaigns');
    }
}
