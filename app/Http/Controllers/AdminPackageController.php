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

class AdminPackageController extends Controller
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
            case "package":
                return $this->packageinit($request);
            break;

              
            default:
              return ;
          }  
    }
    ////////////////////////////////////////////////////
    //All Package data provider 
    //-----done-----
    public function allpackages(Request $request)
    {   
        $data =  DB::table('packages')->get();
        return response($data);    
    }

    public function packageinit(Request $request)
    {   
        $data['packages'] =  DB::table('packages')->get();
        $data['users'] =  DB::table('users')->select('id','name','email','phone','avatar','package_id')->where('role','Customer')->get();
        return response($data);    
    }

    ////////////////////////////////////////////////////
    //Add New Package
    //-----done-----
    public function packageCRUD(Request $request)
    {

        $sequence = $request->input('sequence');
        $data = $request->input('data');
        $type = $request->input('type');
        switch ($type) {
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
                return $this->syslog("admin", "package", "Admin created a new package by the name ".$data['Package']['text_fields']['Name']['value'], 'New Package.',$request, 'package');
            break;
            case 'UpdatePackage':
                $available = DB::table('users')->where('package_id',$sequence)->select('id')->get()->toArray();
                $available = array_map(function ($value) {
                    return (array)$value;
                }, $available);
                if($available){
                    foreach ($available as $id) {
                        $admincheck = DB::table('assignment_config')->where('customer_id',$id['id'])
                        ->where('role','Administrator')->count();
                        $operatorcheck = DB::table('assignment_config')->where('customer_id',$id['id'])
                        ->where('role','Operator')->count();
                        $agentcheck = DB::table('assignment_config')->where('customer_id',$id['id'])
                        ->where('role','Agent')->count();
                        $sitecheck = DB::table($id['id'].'_datatable')->count();
                        if($admincheck > $data['Package']['dropdown_fields']['administrators_num']['value']){
                            return $this->errAPI('This Package is already assigned to a Customer having more administrators than defined in the package!');
                        }
                        if($operatorcheck > $data['Package']['dropdown_fields']['operators_num']['value']){
                            return $this->errAPI('This Package is already assigned to a Customer having more operators than defined in the package!');
                        }
                        if($agentcheck > $data['Package']['dropdown_fields']['agents_num']['value']){
                            return $this->errAPI('This Package is already assigned to a Customer having more agents than defined in the package!');
                        }
                        if($sitecheck > $data['Package']['dropdown_fields']['sites_num']['value']){
                            return $this->errAPI('This Package is already assigned to a Customer having more Sites than defined in the package!');
                        }
                    }
                }
                DB::table('packages')->where('id',$sequence)->update([
                    'name' => $data['Package']['text_fields']['Name']['value'], 
                    'administrators_num' => $data['Package']['dropdown_fields']['administrators_num']['value'],
                    'operators_num' => $data['Package']['dropdown_fields']['operators_num']['value'],
                    'sites_num' =>$data['Package']['dropdown_fields']['sites_num']['value'],
                    'agents_num' => $data['Package']['dropdown_fields']['agents_num']['value'],
                    'cost' => $data['Package']['text_fields']['Cost']['value'],
                    'cost_in_letters' => $data['Package']['text_fields']['CostLetters']['value'],
                    'package_type' => $data['Package']['dropdown_fields']['package_type']['value']
                ]);   
                DB::table('users')->where('package_id',$sequence)->update([
                    'allowed_entries' => $data['Package']['dropdown_fields']['sites_num']['value']
                ]);
                return $this->syslog("admin", "package", "Admin updated a package by the name ".$data['Package']['text_fields']['Name']['value'], 'Update Package.',$request, 'package');
            break;
            case 'DeletePackage':
                $available = DB::table('users')->where('package_id',$sequence)->select('id')->get()->toArray();
                $available = array_map(function ($value) {
                    return (array)$value;
                }, $available);
                if(count($available) != 0){
                    return $this->errAPI('Packages can not be deleted while they are assigned to Customers.');
                }  
        
                DB::table('packages')->where('id',$sequence)->delete();
                return $this->syslog("admin", "package", "Admin deleted a package.", 'Delete Package.',$request, 'package');
            break;
            case 'AssignPackage':
                $id = $data['Package']['current']['config']['new']['id'];
                $user = DB::table('users')->where('id',$id)->pluck('package_id');
                if($user != null){
                    $admincheck = DB::table('assignment_config')->where('customer_id',$id)
                    ->where('role','Administrator')->count();
                    $operatorcheck = DB::table('assignment_config')->where('customer_id',$id)
                    ->where('role','Operator')->count();
                    $agentcheck = DB::table('assignment_config')->where('customer_id',$id)
                    ->where('role','Agent')->count();
                    $sitecheck = DB::table($id.'_datatable')->count();
                    if($admincheck > $data['Package']['current']['config']['details']['administrators_num']){
                        return $this->errAPI('The Customer have currently more Administrators than defined in the package.');
                    }
                    if($operatorcheck > $data['Package']['current']['config']['details']['operators_num']){
                        return $this->errAPI('The Customer have currently more Operators than defined in the package.');
                    }
                    if($agentcheck > $data['Package']['current']['config']['details']['agents_num']){
                        return $this->errAPI('The Customer have currently more Agents than defined in the package.');
                    }

                    if($sitecheck > $data['Package']['current']['config']['details']['sites_num']){
                        return $this->errAPI('The Customer have currently more Sites than defined in the package.');
                    }
                }
                DB::table('users')->where('id',$id)->update([
                    'package_id' => $sequence,
                    'allowed_entries' => $data['Package']['current']['config']['details']['sites_num']
                ]);
                return $this->syslog("admin", "package", "Admin assigned package, id=>".$sequence." to customer, id=> ".$id, 'Assign Package.',$request, 'package');

            break;
            case 'CreateUser':
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
                    return $this->syslog("admin", $sequence, "Admin created new CUSTOMER of type GIS. Customer's Name is ".$data['Register']['text_fields']['Name']['value'], 'User Registration.',$request, 'package');
                }else{
                    return $this->syslog("admin", $sequence, "Admin created new ".$data['Register']['dropdown_fields']['Role']['value']." with name ".$data['Register']['text_fields']['Name']['value'], 'User Registration.',$request, 'package');
                }
            break;
        }
    }


}
