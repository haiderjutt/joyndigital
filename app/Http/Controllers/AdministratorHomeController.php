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

class AdministratorHomeController extends Controller
{
 public function administratorall(Request $request){
    $dataARR = array();
    $user = auth()->user();
    $id=$user['id'];
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
    return $dataARR;
 }

 public function workersall(Request $request){
    $dataARR = array();
    $id = $request->input('sequence1');
    $worker=DB::table('assignment_config')
    ->where('customer_id',$id)
    ->where('role','!=','Administrator')
    ->select('worker_id')
    ->get()
    ->toArray();  
     $worker = array_map(function ($value) {
        return (array)$value;
  }, $worker);
  foreach($worker as $row){
    $name=DB::table('users')
    ->where('id',$row['worker_id'])
    ->select('id','username','name', 'email', 'phone', 'role','ban')
    ->get()
    ->toArray();
    $name = array_map(function ($value) {
        return (array)$value;
  }, $name);
  foreach($name as $row){
    array_push($dataARR,$row);
}
}
return $dataARR;
 }

 

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
        $dataARR = array();
        $workerslist = array();
        $user = auth()->user();
        $id=$user['id'];
            if($request->input('role_name')){
                $role = $request->input('role_name');
                $data = DB::table('users')
                ->where('role',$role)
                ->select('id','name','username', 'email', 'phone', 'role', 'ban','avatar')
                ->get();
                return response($data);
            }else{
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
                        ->select('id','name','username', 'email', 'phone', 'role', 'ban','avatar')
                        ->get()
                        ->toArray();
                        $name = array_map(function ($value) {
                            return (array)$value;
                    }, $name);
                    foreach($name as $row){
                        array_push($dataARR,$row);
                    }
                    } 
                    foreach($customerid as $row){
                        $workers=DB::table('assignment_config')
                        ->where('customer_id',$row)
                        ->where('role','!=','Administrator')
                        ->select('worker_id')
                        ->get()
                        ->toArray();
                        $workers = array_map(function ($value) {
                            return (array)$value;
                    }, $workers);
                    foreach($workers as $row){
                        $name=DB::table('users')
                        ->where('id',$row['worker_id'])
                        ->select('id','name','username', 'email', 'phone', 'role', 'ban','avatar')
                        ->get()
                        ->toArray();
                        $name = array_map(function ($value) {
                            return (array)$value;
                    }, $name);
                    foreach($name as $row){
                        array_push($dataARR,$row);
                    }
                    } 
                    }      
            return $dataARR;
            }
         
     }
 
 
 
     
     ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
     ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
     public function userCRUD(Request $request){
        $user = auth()->user();
        $name = $user['username'];
         $sequence = $request->input('sequence');
         $data = $request->input('data');
         $type = $request->input('type');
         switch ($type) {
            case 'Update':
                DB::table('users')->where('id',$sequence)->update([ 
                    'name' => $data['Update']['text_fields']['Name']['value'], 
                    'username' => $data['Update']['text_fields']['Username']['value'],
                    'email' => $data['Update']['text_fields']['Email']['value'],
                    'phone' => $data['Update']['text_fields']['Phone']['value']
                  ]);
                return $this->syslog("$name", $sequence, "$name changed the credentials of ".$data['Update']['text_fields']['Email']['value'], 'Credentials Update.',$request, 'users');
            break;
            case 'Password':
                DB::table('users')->where('id',$sequence)->update(['password' => Hash::make($data['Password']['text_fields']['Password']['value']),'updated_at' => now()]);
                DB::table('password_resets')->insert([
                    'of_id'=> $sequence,
                    'by_id' => "$name",
                    'created_at' => now()
                ]);
                
                return $this->all($request); 
            break;
            case 'Ban':
                $check = DB::table('users')->where('id', $sequence)->select('ban','email')->get()->toArray();
                $check = array_map(function ($value) {
                    return (array)$value;
                }, $check);
                if($check[0]['ban'] == "no"){
                    DB::table('users')->where('id',$sequence)->update(['ban' => "yes"]);
                    return $this->syslog("$name", $sequence, "$name banned the user having email :  ".$check[0]['email'], 'User BAN.',$request, 'users');
                }else{
                    DB::table('users')->where('id',$sequence)->update(['ban' => "no"]);
                    return $this->syslog("$name", $sequence, "$name un-banned the user having email :  ".$check[0]['email'], 'User UN-BAN.',$request, 'users');
                }
             
            break;

            case 'ProfilePicture':
                if($file = $request->file('file')){
                    $Name = $request->file('file')->getClientOriginalName();
                    DB::table('users')->where('id',$sequence)->update([
                        'avatar' => $Name
                    ]);
                    $destinationPath = public_path('avatars');
                    $file->move($destinationPath,$Name);
                    return $this->syslog("$name", $sequence, "$name changed the Profile picture of a user.", 'Profile Picture',$request, 'users');

                }
                //return $this->all($request);
            break; 
           }
     }
     
 }
 

