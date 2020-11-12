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

class AdminHomeController extends Controller
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



    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function userCRUD(Request $request){
        $sequence = $request->input('sequence');
        $data = $request->input('data');
        $type = $request->input('type');
        switch ($type) {
            case 'Register':
                DB::table('users')->insert([
                    'name' => $data['Register']['text_fields']['Name']['value'], 
                    'username' => $data['Register']['text_fields']['Username']['value'],
                    'email' => $data['Register']['text_fields']['Email']['value'],
                    'password' => Hash::make($data['Register']['text_fields']['Password']['value']),
                    'phone' => $data['Register']['text_fields']['Phone']['value'],
                    'role' => $data['Register']['dropdown_fields']['Role']['value'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                if($data['Register']['dropdown_fields']['Role']['value'] == "Customer" && $data['Register']['dropdown_fields']['Type']['value'] == "Solar-GIS"){
                    $temp_id=DB::table('users')->select('id')->where('name',$data['Register']['text_fields']['Name']['value'])->where('email',$data['Register']['text_fields']['Email']['value'])->get()->toArray();
                    $temp_id = array_map(function ($value) {
                        return (array)$value;
                    }, $temp_id);
                    $sequence = $temp_id[0]['id'];
                    $dataTable = ''.$temp_id[0]['id'].'_dataTable';
                    Schema::create($dataTable, function (Blueprint $table) {
                        $table->bigIncrements('id');
                        $table->string('created_by');
                        $table->string('created_by_id');
                        $table->timestamp('created_at');
                        $table->timestamp('updated_at')->nullable();
                        $table->string('updated_by')->nullable();
                        $table->string('updated_by_id')->nullable();
                        $table->string('latitude');
                        $table->string('longitude');
                        $table->string('site_cost')->default('0');
                    });
                    DB::table('users')->where('id', $sequence)->update(['auth_db'=> $dataTable,'type' => $data['Register']['dropdown_fields']['Type']['value'],]);
                    return $this->syslog("admin", $sequence, "Admin created new CUSTOMER of type GIS. Customer's Name is ".$data['Register']['text_fields']['Name']['value'], 'User Registration.',$request, 'users');
                }else{
                    return $this->syslog("admin", $sequence, "Admin created new ".$data['Register']['dropdown_fields']['Role']['value']." with name ".$data['Register']['text_fields']['Name']['value'], 'User Registration.',$request, 'users');
                }
            break;
            case 'Update':
                DB::table('users')->where('id',$sequence)->update([ 
                    'name' => $data['Update']['text_fields']['Name']['value'], 
                    'username' => $data['Update']['text_fields']['Username']['value'],
                    'email' => $data['Update']['text_fields']['Email']['value'],
                    'phone' => $data['Update']['text_fields']['Phone']['value']
                  ]);
                return $this->syslog("admin", $sequence, "Admin changed the credentials of ".$data['Update']['text_fields']['Email']['value'], 'Credentials Update.',$request, 'users');
            break;
            case 'Password':
                DB::table('users')->where('id',$sequence)->update(['password' => Hash::make($data['Password']['text_fields']['Password']['value']),'updated_at' => now()]);
                DB::table('password_resets')->insert([
                    'of_id'=> $sequence,
                    'by_id' => "Admin",
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
                    return $this->syslog("admin", $sequence, "Admin banned the user having email :  ".$check[0]['email'], 'User BAN.',$request, 'users');
                }else{
                    DB::table('users')->where('id',$sequence)->update(['ban' => "no"]);
                    return $this->syslog("admin", $sequence, "Admin un-banned the user having email :  ".$check[0]['email'], 'User UN-BAN.',$request, 'users');
                }
             
            break;
            case 'Delete':
                $data = DB::table('users')->where('id',$sequence)->select('role','name')->get()->toArray();
                $data = array_map(function ($value) {
                    return (array)$value;
                }, $data);
                DB::table('users')->where('id',$sequence)->delete();
                if($data[0]['role'] == "Customer"){
                    DB::table('assignment_config')->where('customer_id',$sequence)->delete();
                    Schema::dropIfExists($sequence.'_dataTable');
                }else{
                    DB::table('assignment_config')->where('worker_id',$sequence)->delete();
                }
                return $this->syslog("admin", $sequence, "Admin deleted the ".$data[0]['role']." with name ".$data[0]['name'], 'User Delete.',$request, 'users');
             
            break;

            case 'ProfilePicture':
                if($file = $request->file('file')){
                    $Name = $request->file('file')->getClientOriginalName();
                    DB::table('users')->where('id',$sequence)->update([
                        'avatar' => $Name
                    ]);
                    $destinationPath = public_path('avatars');
                    $file->move($destinationPath,$Name);
                    return $this->syslog("admin", $sequence, "Admin changed the Profile picture of a user.", 'Profile Picture',$request, 'users');

                }
                //return $this->all($request);
            break; 

            case 'Allocation':
                $role = $data['Allocation']['workerdetails']['New']['worker']['role'];
                $pkg = DB::table('users')->where('id',$data['Allocation']['workerdetails']['New']['customer']['id'])->pluck('package_id');
                $temprole = "";
                if($pkg == null){
                    return $this->errAPI('Please Assign a package first then try assigning workers.');
                }
                
                $datatemp = DB::table('packages')->where('id',$pkg)->get()->toArray();
                
                $datatemp = array_map(function ($value) {
                    return (array)$value;
                }, $datatemp);
                $check = DB::table('assignment_config')->where('customer_id',$data['Allocation']['workerdetails']['New']['customer']['id'])
                ->where('role',$role)->count();
                
                if($role == "Administrator"){
                    $temprole = $datatemp[0]["administrators_num"];
                }else if($role == "Operator"){
                    $temprole = $datatemp[0]["operators_num"];
                }else if($role == "Agent"){
                    $temprole =  $datatemp[0]["agents_num"];
                }else{}
                
                if($check >= $temprole){
                    return $this->errAPI('Assignment Failed!! Cannot exceed the package limit.');
                }else{
                    $temp = DB::table('assignment_config')->where('customer_id',$data['Allocation']['workerdetails']['New']['customer']['id'])->where('worker_id',$data['Allocation']['workerdetails']['New']['worker']['id'])->get();
                    if(count($temp) == 0){
                        DB::table('assignment_config')->insert([
                            'role'=>$role,
                            'worker_id'=>$data['Allocation']['workerdetails']['New']['worker']['id'],
                            'customer_id'=>$data['Allocation']['workerdetails']['New']['customer']['id']
                        ]);
                        return $this->syslog("admin", $sequence, "Admin assigned a ".$role." to customer with id => ".$data['Allocation']['workerdetails']['New']['customer']['id'], 'Assignment',$request, 'users');
                    }else{
                        return $this->errAPI('Assignment Failed!! Already assigned to the desired Customer.'); 
                    }
                }
                //return $this->all($request);
            break;   
            case 'CAllocation':
            
                $role = $data['CAllocation']['customerdetails']['New']['worker']['role'];
                $pkg = DB::table('users')->where('id',$data['CAllocation']['customerdetails']['New']['customer']['id'])->pluck('package_id');
                $temprole = "";
                if($pkg == null){
                    return $this->errAPI('Please Assign a package first then try assigning workers.');
                }
                $datatemp = DB::table('packages')->where('id',$pkg)->get()->toArray();
                $datatemp = array_map(function ($value) {
                    return (array)$value;
                }, $datatemp);
                $check = DB::table('assignment_config')->where('customer_id',$data['CAllocation']['customerdetails']['New']['customer']['id'])
                ->where('role',$role)->count();
                if($role == "Administrator"){
                    $temprole = $datatemp[0]["administrators_num"];
                }else if($role == "Operator"){
                    $temprole = $datatemp[0]["operators_num"];
                }else if($role == "Agent"){
                    $temprole =  $datatemp[0]["agents_num"];
                }else{}
                if($check >= $temprole){
                    return $this->errAPI('Assignment Failed!! Cannot exceed the package limit.');
                }else{
                    $temp = DB::table('assignment_config')->where('customer_id',$data['CAllocation']['customerdetails']['New']['customer']['id'])->where('worker_id',$data['CAllocation']['customerdetails']['New']['worker']['id'])->get();
                    if(count($temp) == 0){
                        DB::table('assignment_config')->insert([
                            'role'=>$role,
                            'worker_id'=>$data['CAllocation']['customerdetails']['New']['worker']['id'],
                            'customer_id'=>$data['CAllocation']['customerdetails']['New']['customer']['id']
                        ]);
                        return $this->syslog("admin", $sequence, "Admin assigned a ".$role." to customer with id => ".$data['CAllocation']['customerdetails']['New']['customer']['id'], 'Assignment',$request, 'users');
                    }else{
                        return $this->errAPI('Assignment Failed!! Already assigned to the desired Customer.'); 
                    }
                }
                //return $this->all($request);
            break;
            case 'NewPackage':
                DB::table('packages')->insert([
                    'name' => $data['Package']['text_fields']['Name']['value'], 
                    'administrators_num' => $data['Package']['dropdown_fields']['administrators_num']['value'],
                    'operators_num' => $data['Package']['dropdown_fields']['operators_num']['value'],
                    'sites_num' => $data['Package']['dropdown_fields']['sites_num']['value'],
                    'agents_num' => $data['Package']['dropdown_fields']['agents_num']['value'],
                    'cost' => $data['Package']['text_fields']['Cost']['value'],
                    'cost_in_letters' => $data['Package']['text_fields']['CostLetters']['value'],
                    'package_type' => $data['Package']['dropdown_fields']['package_type']['value']
                ]);
                return $this->syslog("admin", "package", "Admin created a new package by the name ".$data['Package']['text_fields']['Name']['value'], 'New Package.',$request, 'users');
            break;
          }
    }
    
}
