<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dispositions;
use Illuminate\Support\Facades\Session;
use DB;
use Auth;

class DispositionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dispositions()
    {
        $dispositions = Dispositions::paginate(25);
        return view('disposition/dispositions', compact('dispositions'));
    }

    public function editdisposition(Request $request)
    {
        if (auth::id() == 1) {
            $dispositionid = $request->input('id');
            $disposition = Dispositions::where('id', $dispositionid)->first();
            return view('disposition/editdisposition', compact('disposition'));
        }
    }

    public function adddispositionsubmit(Request $request)
    {
        if (auth::id() == 1) {
            $disposition = new Dispositions();
            $disposition->name = $request->input('name');
            $disposition->save();
            Session::flash('status', 'Disposition Created Successfully!');
            return redirect('/dispositions');
        }
    }

    public function editdispositionsubmit(Request $request)
    {
        if (auth::id() == 1) {
            $dispositionid = $request->input('dispositionid');
            $dispositionname = $request->input('name');
            
            DB::update("update dispositions set 
                        name='" . $dispositionname . "',
                        updated_at=NOW() where id=" . $dispositionid . ";");

            Session::flash('status', 'disposition Updated Successfully!');
            return redirect('/dispositions');
        }
    }
}
