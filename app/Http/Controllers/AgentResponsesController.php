<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agentresponses;
use Illuminate\Support\Facades\Session;
use DB;
use Auth;
use App\Models\Instances;

class AgentResponsesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function agentresponses()
    {
        if (auth::id() == 1) {
            $agentresponses = Agentresponses::paginate(25);        
        return view('agentresponse/agentresponses', compact('agentresponses'));
    }
        
    }

    public function addagentresponse()
    {
        if (auth::id() == 1) {
            $instances = Instances::all();
            return view('agentresponse/addagentresponse', compact('instances'));
        }
    }

    public function editagentresponse(Request $request)
    {
        if (auth::id() == 1) {
            $agentresponseid = $request->input('id');
            $agentresponse = Agentresponses::where('id', $agentresponseid)->first();
            $instances = Instances::all();
            return view('agentresponse/editagentresponse', compact('agentresponse', 'instances'));
        }
    }

    public function addagentresponsesubmit(Request $request)
    {
        if (auth::id() == 1) {
            $agent = new Agentresponses();
            $agent->agentresponse = $request->input('agentresponse');
            $agent->instanceid = $request->input('instanceid');
            $agent->save();
            Session::flash('status', 'Agent Response Created Successfully!');
            return redirect('/agentresponses');
        }
    }

    public function editagentresponsesubmit(Request $request)
    {
        if (auth::id() == 1) {
            $agentresponseid = $request->input('agentresponseid');
            $agentresponse = $request->input('agentresponse');
            $instanceid = $request->input('instanceid');
            DB::update("update agentresponses set 
                        agentresponse='" . $agentresponse . "',
                         instanceid=" . $instanceid . ", 
                        updated_at=NOW() where id=" . $agentresponseid . ";");
            Session::flash('status', 'Agent Response Updated Successfully!');
            return redirect('/agentresponses');
        }
    }
}
