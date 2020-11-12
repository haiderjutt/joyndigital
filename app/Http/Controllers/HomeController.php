<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Storage;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Arr;
use DateTime;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $username = Auth::user()->username;
        $confirmation = DB::table('users')
        ->select('role','name')
        ->where ('username',$username)
        ->get()
        ->toArray();
        $confirmation = array_map(function ($value) {
            return (array)$value;
        },   $confirmation);
        if($confirmation[0]['role'] == 'Operator'){
            return view('operatorhome');
        }
        else if($confirmation[0]['role'] == 'Administrator'){
            return view('administratorhome');
        }
        else if($confirmation[0]['role'] == 'Partner'){
            return view('partnerhome');
        }
        else if($confirmation[0]['role'] == 'Customer'){
            return view('customerhome');
        }
        return view('home');
    }
}
