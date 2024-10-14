<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;
use App\Models\Instances;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function users()
    {
        if (auth::id() == 1) {
            $users = User::paginate(25);
            return view('user/users', compact('users'));
        }
        elseif (Auth::user()->whitelabel == 1) {
            $users = User::where('whitelabeluserid', auth::id())->paginate(25);
            return view('user/users', compact('users'));
        }
    }

    public function adduser()
    {
        if (auth::id() == 1) {
            $instances = Instances::all();
            return view('user/adduser', compact('instances'));
        }
        elseif (Auth::user()->whitelabel == 1) {
            $instances = Instances::where('whitelabeluserid', auth::id())->get();
            return view('user/adduser', compact('instances'));
        }
    }

    public function edituser(Request $request)
    {
        if (auth::id() == 1) {
            $userid = $request->input('id');
            $user = User::where('id', $userid)->first();
            $instances = Instances::all();
            return view('user/edituser', compact('user', 'instances'));
        }
        elseif (Auth::user()->whitelabel == 1) {
            $userid = $request->input('id');
            $user = User::where('id', $userid)->first();
            $instances = Instances::where('whitelabeluserid', auth::id())->get();
            return view('user/edituser', compact('user', 'instances'));
        }
    }

    public function addusersubmit(Request $request)
    {
        if (auth::id() == 1) {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->instanceid = $request->input('instanceid');
            $user->password = Hash::make($request->input('password'));
            if($request->input('whitelabel') == "1")
            {
                $user->whitelabel = $request->input('whitelabel');
            }            
            $user->whitelabeluserid = 1;
            $user->save();
            Session::flash('status', 'User Created Successfully!');
            return redirect('/users');
        }
        elseif (Auth::user()->whitelabel == 1) {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->instanceid = $request->input('instanceid');
            $user->password = Hash::make($request->input('password'));
            $user->whitelabeluserid = auth::id();
            $user->save();
            Session::flash('status', 'User Created Successfully!');
            return redirect('/users');
        }
    }

    public function editusersubmit(Request $request)
    {
        $password = "";
        if (auth::id() == 1) {
            $userid = $request->input('userid');
            $instanceid = $request->input('instanceid');
            $name = $request->input('name');
            $email = $request->input('email');
            $whitelabel = 0;
            if($request->input('password') != ""){
                $password = ", password='" . Hash::make($request->input('password')) . "'";
            }
            
            if($request->input('whitelabel') == "1")
            {
                $whitelabel = 1;
            }            
            DB::update("update users set name='" . $name . "'
            , email='" . $email . "'
            " . $password . "
            , instanceid='" . $instanceid . "'
            , whitelabel='" . $whitelabel . "'
            , updated_at=NOW() where id=" . $userid . ";");
            Session::flash('status', 'User Updated Successfully!');
            return redirect('/users');
        }
        elseif (Auth::user()->whitelabel == 1) {
            $userid = $request->input('userid');
            $instanceid = $request->input('instanceid');
            $name = $request->input('name');
            $email = $request->input('email');
            if($request->input('password') != ""){
                $password = ", password='" . Hash::make($request->input('password')) . "'";
            }
            DB::update("update users set name='" . $name . "'
            , email='" . $email . "'
            " . $password . "
            , instanceid='" . $instanceid . "'
            , updated_at=NOW() where id=" . $userid . ";");
            Session::flash('status', 'User Updated Successfully!');
            return redirect('/users');
        }
    }
}
