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

class CustomerController extends Controller
{
    //
    public function customerInit(Request $request){
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
            //$daat3 = DB::table($sequence."_datatable")->get()->toArray();
            $tbData = Schema::getColumnListing($sequence."_datatable");
            // $exclude_columns = ['id','created_by', 'created_by_id','created_at', 'updated_at','updated_by', 'updated_by_id','latitude','longitude','site_cost'];
            // $get_columns =array_values(array_diff($tbData, $exclude_columns)) ;
            $daat = array_map(function ($value) {
                return (array)$value;
            }, $daat);
            $daat2 = array_map(function ($value) {
                return (array)$value;
            }, $daat2);
            
            foreach ($daat as $names) {
                $data['Options'][$names['field_name']] = DB::table('customer_fields')->where('destination_id',$names['id'])->where('field_type','Option')->select('field_name')->get();
            }
            foreach ($daat2 as $names) {
                $data['Options'][$names['field_name']] = DB::table('customer_fields')->where('destination_id',$names['id'])->where('field_type','Option')->select('field_name')->get();
            }
            foreach ($tbData as $names) {
                $data['Option'][$names] = DB::table($sequence."_datatable")->select($names)->get();
            }

            $resp['fields'] = $data;
            $resp['sites'] =  DB::table($sequence."_datatable")->get();
        }
        
        return response($resp);  
    }
    public function alldd(Request $request){
   
    $user = auth()->user();
    $sequence=$user['id'];
    $data=array();
    $tbData = Schema::getColumnListing($sequence."_datatable");
    $exclude_columns = ['id','created_by', 'created_by_id','created_at', 'updated_at','updated_by', 'updated_by_id','latitude','longitude','site_cost'];
    $get_columns =array_values(array_diff($tbData, $exclude_columns)) ;
     for($i=0; $i<sizeof($exclude_columns); $i++){
      $data1= $exclude_columns[$i];
      
      if (in_array($data1,$tbData)){
    
      }
     }
    return [$get_columns,'0'];
    }
}
