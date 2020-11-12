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

class AdminController extends Controller
{

    public function fieldsperm(Request $request)
    {   
        $sequence = $request->input('sequence');
        $data = $request->input('perm');
        foreach($data as $row){
            DB::table('customer_fields')->where('id',$row['id'])->update([
                'perm'=>$row['perm']
            ]);
        }
        $this->customerfields($request);
    }

    public function adminsite(Request $request)
    {   
        $sequence = $request->input('sequence');
        $data = $request->input('data');
        $id = DB::table($sequence."_datatable")->insertGetid([
            'latitude' => '24.778787',
            'longitude' => '74.778787',
            'created_at'=>now(),
            'created_by_id'=> "777",
            'created_by'=> "test"
        ]);
        foreach($data['form'] as $key=>$nature){
            if($key != 'Option'){
                foreach($nature as $row){
                    DB::table($sequence."_datatable")->where('id',$id)->update([
                        $row['field_name']=>$row['value']
                    ]);
                } 
            }
            
        }
        $data = DB::table('users')->get();
        return response($data);
    }
    // public function applogin(Request $request){
    //     $data1 = array();
    //     $data1['userId'] = "yahoo";
    //     $data1['id'] = "online";
    //     $data1['title'] = "lolwa";
    //     // $data2 = array();
    //     // $data2['name'] = "google";
    //     // $data2['_active'] = "offline";
    //     // $final = array();
    //     // array_push($final, $data1);
    //     // array_push($final, $data2);
    //     return response(json_encode($data1));
    // }
    // public function testt(Request $request)
    // { 
    //     return "tes";

    // }
    // public function keytest(Request $request)
    // { 
    //     return 'done';
    //     $name = $request->input('to');
    //     $past = $request->input('from');
    //     return $name;
    //     Schema::table("9_datatable", function (Blueprint $table) use ($name,$past) 
    //         {
    //             $table->renameColumn($past, $name);
                
    //         });
    //     return 'done';

    // }



    //This code is accessible by urls meant for admin side.
    ////////////////////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////
    //api error  
    //-----done-----
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
            case "package":
                return $this->allpackages($request);
            break;
            case "form":
                return $this->customerfields($request);
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

    ////////////////////////////////////////////////////
    //All Package data provider 
    //-----done-----
    public function allpackages(Request $request)
    {   
        $data =  DB::table('packages')->get();
        return response($data);    
    }

    ////////////////////////////////////////////////////
    //Specific Customer assigned Fields data provider (Text,Droprown(Option),Date)
    //-----done-----
    public function customerfields (Request $request)
    {
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
        if(count($data) != 0){
            return response($data);
        }
    }


    ////////////////////////////////////////////////////
    //Dynamic User Cards data provider     
    //-----done-----
    public function allcard(Request $request)
    {   
        $data['users'] =  DB::table('users')->count();
        $data['customers'] =  DB::table('users')->where('role','Customer')->count();
        $data['administrators'] =  DB::table('users')->where('role','Administrator')->count();
        $data['operators'] =  DB::table('users')->where('role','Operator')->count();
        $data['agents'] =  DB::table('users')->where('role','Agent')->count();
        $data['vendors'] =  DB::table('users')->where('role','Partner')->count();
        return response($data);    
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
                if($data['Register']['dropdown_fields']['Role']['value'] == "Customer" && $data['Register']['dropdown_fields']['Type']['value'] == "GIS"){
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
                        $table->string('object_ID');
                        $table->string('name');
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
          }
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
                    'partner_num' => $data['Package']['dropdown_fields']['partner_num']['value'],
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
                        $vendorcheck = DB::table('assignment_config')->where('customer_id',$id['id'])
                        ->where('role','Partner')->count();
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
                        if($vendorcheck > $data['Package']['dropdown_fields']['partner_num']['value']){
                            return $this->errAPI('This Package is already assigned to a Customer having more Partners than defined in the package!');
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
                    'partner_num' => $data['Package']['dropdown_fields']['partner_num']['value'],
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
            case 'Assign':
            break;
        }
    }

    public function newpackage(Request $request)
    {   
        $name = $request->input('name');
        $administrators_num = $request->input('adminsNum');
        $operators_num = $request->input('operatorsNum');
        $agents_num = $request->input('agentsNum');
        $vendors_num = $request->input('vendorsNum');
        $sites_num = $request->input('sitesNum');
        $Type = $request->input('Type');
        $Cost = $request->input('Cost');
        $CostLetters = $request->input('CostLetters');
        $data =  DB::table('packages')->insert([
            'name' => $name,
            'administrators_num' => $administrators_num,
            'operators_num' => $operators_num,
            'sites_num' => $sites_num,
            'agents_num' => $agents_num,
            'partner_num' => $vendors_num,
            'cost' => $Cost,
            'cost_in_letters' => $CostLetters,
            'package_type' => $Type,
        ]);
        return $this->syslog("admin", "package", "Admin created a new package by the name ".$name, 'New Package.',$request, 'package');
        //return $this->allpackages($request);    
    }

    ////////////////////////////////////////////////////
    //Delete Existing Package
    //-----done-----
    public function deletepackage(Request $request)
    {
        $sequence = $request->input('sequence');
        $available = DB::table('users')->where('package_id',$sequence)->select('id')->get()->toArray();
        $available = array_map(function ($value) {
            return (array)$value;
        }, $available);
        if(count($available) != 0){
            return $this->errAPI('Packages can not be deleted while they are assigned to Customers.');
        }  

        DB::table('packages')->where('id',$sequence)->delete();
        return $this->syslog("admin", "package", "Admin deleted a package.", 'Delete Package.',$request, 'package');
        //return $this->allpackages($request); 
    }

    ////////////////////////////////////////////////////
    //Update Package Details
    //-----done-----
    public function updatepackage(Request $request)
    {
        $sequence = $request->input('sequence');
        $name = $request->input('name');
        $sitesNum = $request->input('sitesNum');
        $adminsNum = $request->input('adminsNum');
        $operatorsNum = $request->input('operatorsNum');
        $agentsNum = $request->input('agentsNum');
        $vendorsNum = $request->input('vendorsNum');
        $editType = $request->input('editType');
        $editCost = $request->input('editCost');
        $editCostLetters = $request->input('editCostLetters');

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
                $vendorcheck = DB::table('assignment_config')->where('customer_id',$id['id'])
                ->where('role','Partner')->count();
                $sitecheck = DB::table($id['id'].'_datatable')->count();
                if($admincheck > $adminsNum){
                    return $this->errAPI('This Package is already assigned to a Customer having more administrators than defined in the package!');
                }
                if($operatorcheck > $operatorsNum){
                    return $this->errAPI('This Package is already assigned to a Customer having more operators than defined in the package!');
                }
                if($agentcheck > $agentsNum){
                    return $this->errAPI('This Package is already assigned to a Customer having more agents than defined in the package!');
                }
                if($vendorcheck > $vendorsNum){
                    return $this->errAPI('This Package is already assigned to a Customer having more Partners than defined in the package!');
                }
                if($sitecheck > $sitesNum){
                    return $this->errAPI('This Package is already assigned to a Customer having more Sites than defined in the package!');
                }
            }        
        }
        DB::table('packages')->where('id',$sequence)->update([
            'name' => $name, 
            'sites_num' => $sitesNum, 
            'administrators_num' => $adminsNum,
            'operators_num' => $operatorsNum,
            'agents_num' => $agentsNum,
            'partner_num' => $vendorsNum,
            'package_type' => $editType,
            'cost' => $editCost,
            'cost_in_letters' => $editCostLetters
            ]);
        DB::table('users')->where('package_id',$sequence)->update([
            'allowed_entries' => $sitesNum
            ]);
        return $this->syslog("admin", "package", "Admin updated a package by the name ".$name, 'Update Package.',$request, 'package');
        //return $this->allpackages($request); 
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
    ////////////////////////////////////////////////////
    //Customer New Field w.r.t. types i.e Input , Dropdown , Date , Option (for dropdowns), Range
    //-----inprogress-----
    public function customerfieldCRUD(Request $request)
    {
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
                return $this->syslog("admin", $request->input('sequence'), "Admin added a new field of type ". $data['CustomerField']['type']['field_type']['value']."for a customer", 'Add Field.',$request, 'form');
                 
            break;
            case 'EditTextField':
                
                $past = DB::table('customer_fields')->where('id',$data['CustomerField']['type']['field_type']['pre'])->pluck('field_name');
                
                $check = $this->updateDBfield($request,$data['CustomerField']['text_fields']['Name']['value'],$past[0]);
                //return $this->errAPI($check);
                    if($check == "404"){
                        return $this->errAPI('The fields you selected is not available in the database for Update.');
                    } 
                DB::table('customer_fields')
                    ->where('id',$data['CustomerField']['type']['field_type']['pre'])
                        ->update([
                            'field_name' => $data['CustomerField']['text_fields']['Name']['value'],
                            'field_type' => $data['CustomerField']['type']['field_type']['value']
                        ]);
                return $this->syslog("admin", $request->input('sequence'), "Admin updated a field of type ".$data['CustomerField']['type']['field_type']['value']."for a customer", 'Update Field.',$request, 'form');
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
                return $this->syslog("admin", $request->input('sequence'), "Admin deleted a field of type ".$type[0]['field_type']."for a customer", 'Delete Field.',$request, 'form');
            break;
        }
    }
    public function customernewinput(Request $request)
    {
        $past = $request->input('past');
        $sequence = $request->input('sequence');
        $name = $request->input('name');
        $type = $request->input('type');
        $single = $request->input('single');
        $multiple = $request->input('multiple');
        if($type == "Option"){
            $sequence = $past;
        }else{
            $check = $this->addDBfield($request,$name);
            if($check == "exist"){
                return $this->errAPI('The new field name already exists in Customer Database. Please change the name and try again!');
            }   
        }
        DB::table('customer_fields')->insert([
            'destination_id' => $sequence,
            'field_name' => $name,
            'field_type' => $type,
            'single_select' => $single,
            'multi_select' => $multiple
        ]);
        return $this->syslog("admin", $request->input('sequence'), "Admin added a new field of type ".$type."for a customer", 'Add Field.',$request, 'form');
         
    }

    ////////////////////////////////////////////////////
    //Template Edit Existing Fiels w.r.t. types i.e Text , Dropdown , Date , Option (for dropdowns)
    //-----inprogress-----
    public function customereditinput(Request $request)
    {
        $id = $request->input('past');
        $sequence = $request->input('sequence');
        $name = $request->input('name');
        $type = $request->input('type');
        $single = $request->input('single');
        $multiple = $request->input('multiple');
        $past = DB::table('customer_fields')->where('id',$id)->select('field_name')->get()->toArray();
        $past = array_map(function ($value) {
            return (array)$value;
        }, $past);
        $check = $this->updateDBfield($request,$name,$past[0]['field_name']);
            if($check == "404"){
                return $this->errAPI('The fields you selected is not available in the database for Update.');
            } 
        DB::table('customer_fields')
            ->where('id',$id)
                ->update([
                    'destination_id' => $sequence,
                    'field_name' => $name,
                    'field_type' => $type,
                    'single_select' => $single,
                    'multi_select' => $multiple
                ]);
        return $this->syslog("admin", $request->input('sequence'), "Admin updated a field of type ".$type."for a customer", 'Update Field.',$request, 'form');
        //return $this->templatecards($request); 
    }

    ////////////////////////////////////////////////////
    //Template Delete Existing Input Field from template and from customers db straight away
    //inprogress
    public function customerdeleteinput(Request $request)
    {
        $id = $request->input('id');
        $sequence = $request->input('sequence');
        $type = DB::table('customer_fields')->where('id',$id)->select('field_type','field_name')->get()->toArray();
        $type = array_map(function ($value) {
            return (array)$value;
        }, $type);
        $check = $this->deleteDBfield($request,$type[0]['field_name']);
        if($check == "404"){
            return $this->errAPI('Field was not found in the Customer DB!');
        } 
        if($type[0]['field_type'] == "Dropdown"){
            
            DB::table('customer_fields')
            ->where('destination_id',$id)
            ->where('field_type',"Option")
            ->delete();
        }
        
        
        DB::table('customer_fields')
            ->where('id',$id)
            ->delete();
        
        
            return $this->syslog("admin", $id, "Admin deleted a field of type ".$type[0]['field_type']."for a customer", 'Delete Field.',$request, 'form');
        //return $this->templatecards($request); 
    }

    ////////////////////////////////////////////////////
    //Specific customer data provider (Administrators,Operators,Agent,Vendor)
    //-----inprogress-----
    public function customerassigns(Request $request)
    {
        $sequence = $request->input('sequence');
        $data = DB::table('assignment_config')->where('customer_id',$sequence)->select("id")->get()->toArray();
        $dataARR = array();
        $data = array_map(function ($value) {
            return (array)$value;
        }, $data);
        foreach($data as $row){
            array_push($dataARR,$row['id']);
        }
        $final['Administrator'] = DB::table('users')->whereIn('id',$dataARR)->where('role','Operator')->get();
        $final['Operator'] = DB::table('users')->whereIn('id',$dataARR)->where('role','Operator')->get();
        $final['Agent'] = DB::table('users')->whereIn('id',$dataARR)->where('role','Agent')->get();
        $final['Vendor'] = DB::table('users')->whereIn('id',$dataARR)->where('role','Partner')->get();
        return response($final);
        
    }

    ////////////////////////////////////////////////////
    //Specific user data provider (Customers)
    //-----inprogress-----
    public function userassigns(Request $request)
    {
        $sequence = $request->input('sequence');
        $data = DB::table('assignment_config')->where('name_id',$sequence)->get();
        return response($data);
        
    }

    ////////////////////////////////////////////////////
    //Assign package to a customer after checking validity conditions
    //-----inprogress-----
    public function packageassign(Request $request)
    {
        $sequence = $request->input('sequence');
        $packID = $request->input('packID');
        $data = DB::table('packages')->where('id',$packID)->get()->toArray();
        $data = array_map(function ($value) {
            return (array)$value;
        }, $data);
        $user = DB::table('users')->where('id',$sequence)->get()->toArray();
        $user = array_map(function ($value) {
            return (array)$value;
        }, $user);
        if($user[0]['package_id'] == null && $user[0]['package_name'] == null ){
            DB::table('users')->where('id',$sequence)->update([
                'package_id' => $data[0]['id'],
                'package_name' => $data[0]['name'],
                'allowed_entries' => $data[0]['sites_num']
            ]);
            return $this->all($request);
        }else{
            $admincheck = DB::table('assignment_config')->where('customer_id',$user[0]['id'])
            ->where('role','Administrator')->count();
            $operatorcheck = DB::table('assignment_config')->where('customer_id',$user[0]['id'])
            ->where('role','Operator')->count();
            $sitecheck = DB::table($user[0]['id'].'_datatable')->count();
            if($admincheck > $data[0]['administrators_num']){
                return $this->errAPI('The Customer have currently more Administrators than defined in the package.');
            }
            if($operatorcheck > $data[0]['operators_num']){
                return $this->errAPI('The Customer have currently more Operators than defined in the package.');
            }

            if($sitecheck > $data[0]['sites_num']){
                return $this->errAPI('The Customer have currently more Sites than defined in the package.');
            }
            DB::table('users')->where('id',$sequence)->update([
                'package_id' => $data[0]['id'],
                'package_name' => $data[0]['name'],
                'allowed_entries' => $data[0]['sites_num']
            ]);
            return $this->all($request);
            
            
        }
        
    }

    ////////////////////////////////////////////////////
    //Assign administrator to a customer after checking validity conditions
    //-----inprogress-----
    public function workerassign(Request $request)
    {
        $sequence = $request->input('sequence');
        $role_name = $request->input('worker');
        $roleID = $request->input('roleID');
        $temprole = "";
        
        $user = DB::table('users')->where('id',$sequence)->get()->toArray();
        $user = array_map(function ($value) {
            return (array)$value;
        }, $user);
        
        $worker = DB::table('users')->where('id',$roleID)->get()->toArray();
        $worker = array_map(function ($value) {
            return (array)$value;
        }, $worker);
        
        if($user[0]['package_id'] == null){
            return $this->errAPI('Please Assign a package first then try assigning workers.');
        }
        $data = DB::table('packages')->where('id',$user[0]['package_id'])->get()->toArray();
        $data = array_map(function ($value) {
            return (array)$value;
        }, $data);
        $check = DB::table('assignment_config')->where('customer_id',$sequence)
            ->where('role',$role_name)->count();
            
        if($role_name == "Administrator"){
            $temprole = $data[0]["administrators_num"];
        }else if($role_name == "Operator"){
            $temprole = $data[0]["operators_num"];
        }else if($role_name == "Agent" || $role_name == "Vendor"){
            $temprole = 5;
        }else{}
       
        if($check >= $temprole){
            return $this->errAPI('Assignment Failed!! Cannot exceed the package limit.');
        }else{
            $temp = DB::table('assignment_config')->where('customer_id',$sequence)->where('name_id',$roleID)->get();
            if(count($temp) == 0){
                DB::table('assignment_config')->insert([
                    'role'=>$role_name,
                    'name'=>$worker[0]['name'],
                    'name_id'=>$worker[0]['id'],
                    'email'=>$worker[0]['email'],
                    'contact'=>$worker[0]['phone'],
                    'customer_name'=>$user[0]['name'],
                    'customer_id'=>$user[0]['id'],
                ]);
                return $this->all($request);
            }else{
                return $this->errAPI('Assignment Failed!! Already assigned to the desired Customer.'); 
            }
        }
        
    }

    public function workerremove(Request $request)
    {
        $sequence = $request->input('sequence');
        $worker = $request->input('worker');
        DB::table('assignment_config')->where('customer_id',$sequence)->where('name_id',$worker)->delete();
        return $this->all($request);
    }


}





//////////////////////////
