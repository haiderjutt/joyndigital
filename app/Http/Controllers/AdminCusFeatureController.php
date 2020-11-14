<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Storage;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Arr;
use DateTime;
use Auth;

class AdminCusFeatureController extends Controller
{
    //
    public function featuresinit(Request $request){
        $sequence = $request->input('sequence');
        $usercheck = DB::table('assignment_config')->where('customer_id',$sequence)->pluck('worker_id');
        $data['users'] = DB::table('users')->whereIn('id',$usercheck)->get();
        $data['customers'] = DB::table('users')->where('role','Customer')->get();
        $data['features'] = DB::table('customer_features')->where('customer_id',$sequence)->get();
        return response($data);
    }
}
