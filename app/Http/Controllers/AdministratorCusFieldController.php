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

class AdministratorCusFieldController extends Controller
{
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
            case "form":
                return $this->fieldsinit($request);
            break;

              
            default:
              return ;
          }  
    }

    public function fieldsinit (Request $request)
    {
        $user = auth()->user();
        $id = $user['id'];
        $name = $user['name'];
        $dataARR = array();
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
        $customer=DB::table('assignment_config')
        ->where('worker_id',$id)
        ->select('customer_id')
        ->get()
        ->toArray();
         $customerid = array_map(function ($value) {
            return (array)$value;
      }, $customer);
      foreach($customerid as $row){
            $name=DB::table('users')
            ->where('id',$row['customer_id'])
            ->select('id','name')
            ->get()
            ->toArray();
            $name = array_map(function ($value) {
                return (array)$value;
          }, $name);
          foreach($name as $row){
            array_push($dataARR,$row);
        }
        }
        $name=DB::table('users')
        ->where('id',$sequence)
        ->select('username')
        ->get()
        ->toArray();
        $name = array_map(function ($value) {
            return (array)$value;
      }, $name);
      foreach($name as $row){
       $name=$row['username'];
       }
        $data['customers'] = $dataARR;
        $data['name'] = $name;
        if(count($data) != 0){
            return response($data);
        }
    }
        /////////////////////////////////////////////////////
    /////Customer Db Check for a new field if it exists or not
    /////if not then adding to DB

    public function addDBfield(Request $request,$name)
    {
        $sequence = $request->input('sequence');
        $tbData = Schema::getColumnListing($sequence."_datatable");
        $state = in_array($name,$tbData);
        if($state == true){
            return "exist";
        }else{
            Schema::table($sequence."_datatable", function (Blueprint $table) use ($name) 
            {
                $table->string($name)->nullable();
            });
            return "added";
        }   
    }

    /////////////////////////////////////////////////////
    /////Customer Db Check for a new field if it exists or not
    //////if not then update the column

    public function updateDBfield(Request $request,$name,$past)
    {
        $sequence = $request->input('sequence');
        $tbData = Schema::getColumnListing($sequence."_datatable");
        
        $state = in_array($past,$tbData);
        if($state == true){
            Schema::table($sequence."_datatable", function (Blueprint $table) use ($name,$past) 
            {
                $table->renameColumn($past, $name);
            });
            return "updated";
        }else{
            return "404";
        }   
    }
    /////////////////////////////////////////////////////
    /////Customer DB Field Delete
    //////

    public function deleteDBfield(Request $request,$name)
    {
        $sequence = $request->input('sequence');
        $tbData = Schema::getColumnListing($sequence."_datatable");
        $state = in_array($name,$tbData);
        if($state == true){
            Schema::table($sequence."_datatable", function (Blueprint $table) use ($name) 
            {
                $table->dropColumn($name);
                
            });
            return "deleted";
        }else{
            return "404";
        }   
    }

    public function customerfieldCRUD(Request $request)
    {   
        $user = auth()->user();
        $name = $user['username'];
        $id = $user['id'];
        $sequence = $request->input('sequence');
        $data = $request->input('data');
        $type = $request->input('type');
        switch ($type) {
            case 'AddTextField':
                if($data['CustomerField']['type']['field_type']['value'] != "Option"){
                    $check = $this->addDBfield($request,$data['CustomerField']['text_fields']['Name']['value']);
                    if($check == "exist"){
                        return $this->errAPI('The new field name already exists in Customer Database. Please change the name and try again!');
                    }  
                }else{
                    $sequence = $data['CustomerField']['type']['field_type']['pre'];
                }
                DB::table('customer_fields')->insert([
                    'destination_id' => $sequence,
                    'field_name' => $data['CustomerField']['text_fields']['Name']['value'],
                    'field_type' => $data['CustomerField']['type']['field_type']['value']
                ]);
                return $this->syslog("$id", $request->input('sequence'), "$name added a new field of type ". $data['CustomerField']['type']['field_type']['value']."for a customer", 'Add Field.',$request, 'form');
                 
            break;
            case 'EditTextField':
                $past = DB::table('customer_fields')->where('id',$data['CustomerField']['type']['field_type']['pre'])->pluck('field_name');
                if($data['CustomerField']['type']['field_type']['value'] != "Option"){
                    $check = $this->updateDBfield($request,$data['CustomerField']['text_fields']['Name']['value'],$past[0]);
                    if($check == "404"){
                        return $this->errAPI('The fields you selected is not available in the database for Update.');
                    }
                }else{

                }
                 
                DB::table('customer_fields')
                    ->where('id',$data['CustomerField']['type']['field_type']['pre'])
                        ->update([
                            'field_name' => $data['CustomerField']['text_fields']['Name']['value'],
                            'field_type' => $data['CustomerField']['type']['field_type']['value']
                        ]);
                return $this->syslog("$id", $request->input('sequence'), "$name updated a field of type ".$data['CustomerField']['type']['field_type']['value']."for a customer", 'Update Field.',$request, 'form');
            break;
            case 'DeleteTextField':
                $type = DB::table('customer_fields')->where('id',$data['CustomerField']['type']['field_type']['pre'])->select('field_type','field_name')->get()->toArray();
                $type = array_map(function ($value) {
                    return (array)$value;
                }, $type);
                $check = $this->deleteDBfield($request,$type[0]['field_name']);
                if($check == "404" && $data['CustomerField']['type']['field_type']['value'] != 'Option'){
                    return $this->errAPI('Field was not found in the Customer DB!');
                } 
                if($type[0]['field_type'] == "Dropdown" || $type[0]['field_type'] == "Controlled"){
                    DB::table('customer_fields')
                    ->where('destination_id',$data['CustomerField']['type']['field_type']['pre'])
                    ->where('field_type',"Option")
                    ->delete();
                } 
                DB::table('customer_fields')
                    ->where('id',$data['CustomerField']['type']['field_type']['pre'])
                    ->delete();
                return $this->syslog("$id", $request->input('sequence'), "$name deleted a field of type ".$type[0]['field_type']."for a customer", 'Delete Field.',$request, 'form');
            break;
        }
    }


}
