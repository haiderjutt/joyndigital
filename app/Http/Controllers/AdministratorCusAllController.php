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

class AdminCusAllController extends Controller
{
    ///
    public function errAPI($message)
    {   
        $dataa = array();
        $dataa['err'] = "404";
        $dataa['message'] = $message;
        return response(json_encode($dataa));      
    }
    //sys per log api  
    //-----done-----
    public function syslog($by, $for, $activity, $type,Request $request,$redirect)
    {   
        DB::table('system_personal_log')->insert([
            'activity_by' => $by,
            'activity_on' => $for,
            'activity' => $activity,
            'activity_type' => $type,
            'activity_at' => now()
        ]);
        switch ($redirect) {
            case "users":
                return $this->all($request);
            break;

              
            default:
              return ;
          }  
    }
    
    ////////////////////////////////////////////////////
    //user generic (all or specified role) data provider  
    //-----done-----
    public function all(Request $request)
    {   
        if($request->input('role_name')){
            $role = $request->input('role_name');
            $data = DB::table('users')
            ->where('role',$role)
            ->select('id','name','username', 'email', 'phone', 'role', 'ban','avatar')
            ->get();
            return response($data);
        }else{
            $data = DB::table('users')
            ->select('id','username','name', 'email', 'phone', 'role', 'ban','avatar')
            ->get();
            return response($data);
        }
        
    }

}
