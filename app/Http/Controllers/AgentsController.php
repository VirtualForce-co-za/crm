<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agents;
use Illuminate\Support\Facades\Session;
use DB;
use Auth;
use App\Models\Instances;

class AgentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function agents()
    {
        if (auth::id() == 1) {
            $agents = Agents::paginate(25);
        }
        elseif (Auth::user()->whitelabel == 1) {
            $agents = Agents::where('whitelabeluserid', auth::id())
                      ->orWhere('instanceid', Auth::user()->instanceid)->paginate(25);
        }
        else {
            $agents = Agents::where('instanceid', Auth::user()->instanceid)->paginate(25);
        }
        return view('agent/agents', compact('agents'));
        
    }

    public function addagent()
    {
        if (auth::id() == 1) {
            $instances = Instances::all();
            return view('agent/addagent', compact('instances'));
        }
    }

    public function editagent(Request $request)
    {
        if (auth::id() == 1) {
            $agentid = $request->input('id');
            $agent = Agents::where('id', $agentid)->first();
            $instances = Instances::all();
            return view('agent/editagent', compact('agent', 'instances'));
        }
    }

    public function addagentsubmit(Request $request)
    {
        if (auth::id() == 1) {
            $agent = new Agents();
            $agent->name = $request->input('name');
            $agent->location = $request->input('location');
            $agent->instanceid = $request->input('instanceid');
            $instance = Instances::where('id', $request->input('instanceid'))->first();
            $agent->whitelabeluserid = $instance->whitelabeluserid;
            $agent->save();
            Session::flash('status', 'Agent Created Successfully!');
            return redirect('/agents');
        }
    }

    public function editagentsubmit(Request $request)
    {
        if (auth::id() == 1) {
            $agentid = $request->input('agentid');
            $name = $request->input('name');
            $location = $request->input('location');
            $instanceid = $request->input('instanceid');
            $instance = Instances::where('id', $request->input('instanceid'))->first();
            $whitelabeluserid = $instance->whitelabeluserid;
            DB::update("update agents set 
                        name='" . $name . "', location='" . $location . "',
                         instanceid=" . $instanceid . ", 
                         whitelabeluserid=" . $whitelabeluserid . ", 
                        updated_at=NOW() where id=" . $agentid . ";");
            Session::flash('status', 'Agent Updated Successfully!');
            return redirect('/agents');
        }
    }
}
