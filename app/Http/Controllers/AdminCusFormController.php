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

class AdminCusFormController extends Controller
{
    //
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

    public function forminit(Request $request)
    {   
        $sequence = 0;
        if($request->input('sequence') != 0){
            $sequence = $request->input('sequence');
            $data['Input'] = DB::table('customer_fields')->where('destination_id',$sequence)->where('field_type','Input')->get();
            $data['Dropdown'] = DB::table('customer_fields')->where('destination_id',$sequence)->where('field_type','Dropdown')->get();
            $data['Controlled'] = DB::table('customer_fields')->where('destination_id',$sequence)->where('field_type','Controlled')->get();
            $data['Range'] = DB::table('customer_fields')->where('destination_id',$sequence)->where('field_type','Range')->get();
            $data['Date'] = DB::table('customer_fields')->where('destination_id',$sequence)->where('field_type','Date')->get();
            $daat = DB::table('customer_fields')->where('destination_id',$sequence)->where('field_type','Dropdown')->get()->toArray();
            $daat2 = DB::table('customer_fields')->where('destination_id',$sequence)->where('field_type','Controlled')->get()->toArray();
            
            $daat = array_map(function ($value) {
                return (array)$value;
            }, $daat);
            $daat2 = array_map(function ($value) {
                return (array)$value;
            }, $daat2);
            
            foreach ($daat as $names) {
                $data['Option'][$names['field_name']] = DB::table('customer_fields')->where('destination_id',$names['id'])->where('field_type','Option')->get();
            }
            foreach ($daat2 as $names) {
                $data['Option'][$names['field_name']] = DB::table('customer_fields')->where('destination_id',$names['id'])->where('field_type','Option')->get();
            }
            $resp['fields'] = $data;
            $resp['sites'] =  DB::table($sequence."_datatable")->get();
        }
 
        $resp['customers'] =  DB::table('users')->select('id','name','email','phone','avatar','allowed_entries','entries_done')->where('role','Customer')->get();
        
        return response($resp);  
    }
    public function formCRUD(Request $request)
    { 
        $sequence = $request->input('sequence');
        
        $data = $request->input('data');
        $lat = $request->input('lat');
        $long = $request->input('long');
        //$check = DB::table($sequence."_datatable")->where('latitude',$lat)->where('longitude',$long)->pluck('id');
        if( $lat != "" && $long != "" ){
            $id = "0";
            if($data['form']['upd'] != '0'){
                $id = $data['form']['upd'];
                DB::table($sequence."_datatable")->where('id',$id)->update([
                    'latitude' => $lat,
                    'longitude' => $long,
                    'updated_at'=>now(),
                    'updated_by_id'=> "Admin",
                    'updated_by'=> "Admin"
                ]);
            }else{
                $id = DB::table($sequence."_datatable")->insertGetid([
                    'latitude' => $lat,
                    'longitude' => $long,
                    'created_at'=>now(),
                    'created_by_id'=> "Admin",
                    'created_by'=> "Admin"
                ]);
            }
            
            
            foreach($data['form'] as $key=>$nature){
                if($key != 'Option' && $key != 'upd'){
                    foreach($nature as $row){
                        if($key == 'Date'){
                            DB::table($sequence."_datatable")->where('id',$id)->update([
                                $row['field_name']=> (new DateTime($row['value']))->format('yy-m-d')
                            ]);
                        }else{
                            
                        }
                        
                    } 
                }
                
            }
            $data = DB::table('users')->get();
            return response($data);
    
        }
        
        
    }
}
