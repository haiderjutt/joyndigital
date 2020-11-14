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

class AdminCusDocumentationController extends Controller
{
    //
    //
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
            case "feature":
                return $this->featureconfiginit($request);
            break;

              
            default:
              return ;
          }  
    }
    public function documentationinit(Request $request){
        $sequence = $request->input('sequence');
        $usercheck = DB::table('assignment_config')->where('customer_id',$sequence)->pluck('worker_id');
        $data['users'] = DB::table('users')->whereIn('id',$usercheck)->get();
        $data['customers'] = DB::table('users')->where('role','Customer')->get();
        $data['confi'] = DB::table('docx_config')->where('customer_id',$sequence)->get();
        return response($data);
    }

    
    public function documentationCRUD(Request $request){
        
        $sequence = $request->input('sequence');
        $check = DB::table('customer_features')->where('customer_id',$sequence)->where('feature_id',1)->pluck('id');
        if( !$check[0]){return response();}
        $data = $request->input('data');
        $type = $request->input('type');
        switch ($type) {
            case 'New':
                DB::table('docx_config')->insert([
                    'field_name' => $data['Feature']['text_fields']['Name']['value'], 
                    'customer_id' => $sequence
                ]);
                return $this->syslog("admin", $sequence, "Admin created new DOCUMENTATION TYPE for CUSTOMER. Customer's Id is ".$sequence, 'Documentation',$request, 'feature');
            break;
            case 'Update':
                DB::table('docx_config')->where('id',$data['Feature']['current']['pre'])->update([ 
                    'field_name' => $data['Feature']['text_fields']['Name']['value']
                  ]);
                  return $this->syslog("admin", $sequence, "Admin edited existing DOCUMENTATION TYPE for CUSTOMER. Customer's Id is ".$sequence, 'Documentation',$request, 'feature');
            break;


            case 'Delete':
                $meta = DB::table('docx_config')->where('id',$data['Feature']['current']['pre'])->pluck('field_name');
                DB::table('docx_db')->where('customer_id',$sequence)->whereIn('field_name',$meta)->delete();
                DB::table('docx_config')->where('id',$data['Feature']['current']['pre'])->delete();
                return $this->syslog("admin", $sequence, "Admin deleted existing DOCUMENTATION TYPE for CUSTOMER. Customer's Id is ".$sequence, 'Documentation',$request, 'feature');
            break;
    }

}
}
