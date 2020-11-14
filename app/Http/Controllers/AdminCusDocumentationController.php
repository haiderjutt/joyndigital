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
            case "document":
                return $this->documentationinit($request);
            break;

              
            default:
              return ;
          }  
    }
    public function documentationinit(Request $request){
        $sequence = $request->input('sequence');
        $data['customers'] = DB::table('users')->where('role','Customer')->get();
        $data['confi'] = DB::table('docx_config')->where('customer_id',$sequence)->get();
        $data['sites'] = DB::table($sequence."_datatable")->get();
        $temp = DB::table('docx_config')->where('customer_id',$sequence)->pluck('field_name');
        foreach($temp as $type){
            $data['documents'][$type] = DB::table('docx_db')->where('field_name', $type)->where('customer_id',$sequence)->get();
        }
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
                if($file = $request->file('file')){
                    $site_id= $request->input('site_id');
                    $ftype = $request->input('ftype');
                    $field_name = $request->input('field_name');
                    $Name = $request->file('file')->getClientOriginalName();
                    $destinationPath = public_path('docx/'.$sequence.'/'.$field_name);
                    $file->move($destinationPath,$Name);
                    DB::table('docx_db')->insert([
                        'customer_id'=> $sequence,
                        'created_at'=>now(),
                        'created_by'=>"Admin",
                        'field_name'=>$field_name,
                        'type'=> $ftype,
                        'url'=> $destinationPath ,
                        'name'=>$Name,
                        'site_id'=>$site_id

                    ]);
                    return $this->syslog("admin", $sequence, "Admin added a new document of type ".$ftype." to the customer in document type ".$field_name, 'Documentation',$request, 'document');

                }
                //return $this->all($request);
            break; 


            case 'Delete':
                //$meta = DB::table('docx_config')->where('id',$data['Feature']['current']['pre'])->pluck('field_name');
                //DB::table('docx_db')->where('customer_id',$sequence)->where('id',$meta)->delete();
                //DB::table('docx_config')->where('id',$data['Feature']['current']['pre'])->delete();
                //return $this->syslog("admin", $sequence, "Admin deleted existing DOCUMENTATION TYPE for CUSTOMER. Customer's Id is ".$sequence, 'Documentation',$request, 'feature');
            break;
    }

}
}
