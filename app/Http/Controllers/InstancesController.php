<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instances;
use Illuminate\Support\Facades\Session;
use DB;
use Auth;

class InstancesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function instances()
    {
        if (auth::id() == 1) {
            $instances = Instances::paginate(25);
            return view('instance/instances', compact('instances'));
        }
    }

    public function editinstance(Request $request)
    {
        if (auth::id() == 1) {
            $instanceid = $request->input('id');
            $instance = Instances::where('id', $instanceid)->first();
            return view('instance/editinstance', compact('instance'));
        }
    }

    public function addinstancesubmit(Request $request)
    {
        if (auth::id() == 1) {
            $instance = new Instances();
            $instance->name = $request->input('name');
            $instance->accountsid = $request->input('accountsid');
            $instance->applicationsid = $request->input('applicationsid');
            $instance->bearer = $request->input('bearer');
            $instance->dialprefix = $request->input('dialprefix');
            $instance->cps = $request->input('cps');
            $instance->save();
            Session::flash('status', 'Instance Created Successfully!');
            return redirect('/instances');
        }
    }

    public function editinstancesubmit(Request $request)
    {
        if (auth::id() == 1) {
            $instanceid = $request->input('instanceid');
            $instancename = $request->input('name');
            $accountsid = $request->input('accountsid');
            $applicationsid = $request->input('applicationsid');
            $bearer = $request->input('bearer');
            $dialprefix = $request->input('dialprefix');
            $cps = $request->input('cps');

            DB::update("update instances set 
                        name='" . $instancename . "', 
                        accountsid='" . $accountsid . "', 
                        applicationsid='" . $applicationsid . "', 
                        bearer='" . $bearer . "', 
                        dialprefix='" . $dialprefix . "', 
                        cps=" . $cps . ", 
                        updated_at=NOW() where id=" . $instanceid . ";");

            Session::flash('status', 'Instance Updated Successfully!');
            return redirect('/instances');
        }
    }
}
