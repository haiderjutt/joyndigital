<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Latitude </title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <link href="css/topbar.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/onlinetable.css" rel="stylesheet">
    <link href="css/AdminForm.css" rel="stylesheet">
    <link href="css/modal.css" rel="stylesheet">
    <link href="css/circularmenu.css" rel="stylesheet">

    
  </head>

  <body  ng-app="myApp" >
      <input ng-model="showcontrol" ng-init="showcontrol = 1" hidden>
      <div class="container-fluid" ng-controller="mainbody">
      @include('includes.topbar')
      <!-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Users</div>

                <div class="card-body">

                    @php $users = DB::table('users')->get(); @endphp

                    <div class="container">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        @if(Cache::has('user-is-online-' . $user->id))
                                            <span class="text-success">Online</span>
                                        @else
                                            <span class="text-secondary">Offline</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div> -->
      @include('includes.mainbody')
      </div>
   
    <!-- Js -->
    <script>
        var global_sequence = 0;
        var adminside = {
            'Register' : {
                'text_fields' : {
                    'Name' : {'value':"",'label':"Name"},
                    'Username' :{'value':"",'label':"Username"},
                    'Email' :{'value':"",'label':"Email"},
                    'Password' :{'value':"",'label':"Password (*Min. 4 Characters)"},
                    'Phone' : {'value':"",'label':"Phone"}
                },
                'dropdown_fields' : {
                    'Role' : {'value':"Administrator",'label':"Role", 'options':['Administrator','Operator','Agent','Customer']},
                    'Type' :{'value':"Solar-GIS",'label':"Customer Type (*Applicable on Customers)", 'options':['Solar-GIS']}
                }
            },
             'Update' : {
                'text_fields' : {
                    'Name' : {'value':"",'label':"Name"},
                    'Username' :{'value':"",'label':"Username"},
                    'Email' :{'value':"",'label':"Email"},
                    'Phone' : {'value':"",'label':"Phone"}
                },
                'file_fields' : {
                    'Avatar' : {'value':"./images/user.png",'label':"Profile Picture"}
                }
            },
            'Password' : {
                'text_fields' : {
                    'Password' :{'value':"",'label':"Password (Min. 4 Characters)"}
                }

            },
            'Allocation' : {
                'workerdetails' : {
                    'Name' : {'value':"",'label':"Name"},
                    'Username' :{'value':"",'label':"Username"},
                    'Email' :{'value':"",'label':"Email"},
                    'Phone' : {'value':"",'label':"Phone"},
                    'Avatar' : {'url':"",'label':"Profile Picture"},
                    'Allocated' : {
                        'customerdetails' : {
                            '1' : {'name':"Haider" , 'email': "test", 'phone':"020202020202"},
                            '2' : {'name':"Haider" , 'email': "test", 'phone':"020202020202"},
                            '3' : {'name':"Haider" , 'email': "test", 'phone':"020202020202"},
                            '4' : {'name':"Haider" , 'email': "test", 'phone':"020202020202"},
                            '5' : {'name':"Haider" , 'email': "test", 'phone':"020202020202"},
                            '6' : {'name':"Haider" , 'email': "test", 'phone':"020202020202"},
                            '7' : {'name':"Haider" , 'email': "test", 'phone':"020202020202"},
                            '8' : {'name':"Haider" , 'email': "test", 'phone':"020202020202"},
                        }
                    },
                    'New' : {
                        'customer':{'id':""},
                        'worker':{'id':"",'role':""}
                    }
                }
            },
            'CAllocation' : {
                'customerdetails' : {
                    'Name' : {'value':"",'label':"Name"},
                    'Username' :{'value':"",'label':"Username"},
                    'Email' :{'value':"",'label':"Email"},
                    'Phone' : {'value':"",'label':"Phone"},
                    'Avatar' : {'url':"",'label':"Profile Picture"},
                    'Allocated' : {
                        'workerdetails' : {
                            '1' : {'name':"Haider" , 'email': "test", 'phone':"020202020202"},
                            '2' : {'name':"Haider" , 'email': "test", 'phone':"020202020202"},
                            '3' : {'name':"Haider" , 'email': "test", 'phone':"020202020202"},
                            '4' : {'name':"Haider" , 'email': "test", 'phone':"020202020202"},
                            '5' : {'name':"Haider" , 'email': "test", 'phone':"020202020202"},
                            '6' : {'name':"Haider" , 'email': "test", 'phone':"020202020202"},
                            '7' : {'name':"Haider" , 'email': "test", 'phone':"020202020202"},
                            '8' : {'name':"Haider" , 'email': "test", 'phone':"020202020202"},
                        }
                    },
                    'New' : {
                        'customer':{'id':""},
                        'worker':{'id':"",'role':""}
                    }
                }
            },
            'Package' :{
                'text_fields' : {
                    'Name' : {'value':"",'label':"Name"},
                    'Cost' :{'value':"",'label':"Cost"},
                    'CostLetters' :{'value':"",'label':"Cost in Letters"}
                },
                'dropdown_fields' : {
                    'package_type' :{'value':"Monthly",'label':" Package Type", 'options':['Monthly','Quaterly','Half-Yearly','Yearly']},
                    'sites_num' : {'value':"0",'label':"Site's Num", 'options':['1','2','3','4','5','6','7','10','15','20','25','30','50','100','200','300','400','500','1000','1500','2000']},
                    'administrators_num' : {'value':"0",'label':"Administrator's Num", 'options':['1','2','3','4','5','6','7','10','15','20','25','30']},
                    'operators_num' : {'value':"0",'label':"Operator's Num", 'options':['1','2','3','4','5','6','7','10','15','20','25','30']},
                    'agents_num' : {'value':"0",'label':"Agent's Num", 'options':['1','2','3','4','5','6','7','10','15','20','25','30']},
                 
                    
                },
                'current':{
                    'config':{
                        'details':{
                            'Name':"",
                            'Cost':"",
                            'sites_num':"",
                            'administrators_num':"",
                            'operators_num':"",
                            'agents_num':"",
                        },
                        'new':{'id':""},
                        'assigned':{}
                    }
                    
                }
            },
            'CustomerField' :{
                'text_fields' : {
                    'Name' : {'value':"",'label':"Name"},
                },
                'type' : {
                    'field_type' :{'value':"Input",'pre':'0'}
                }
            }
        };
        var operatorside = {
            'form' :{}

        }

    </script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/bootstrap-progressbar.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/angular-1.7.9/angular.min.js"></script>
    <script src="js/angular-1.7.9/angular-route.js"></script>
    <script src="js/Chart.js/Chart.js"></script>
    <script src="js/chart/angular-chart.js"></script>
    

    <script src="https://www.amcharts.com/lib/4/core.js"></script>
    <script src="https://www.amcharts.com/lib/4/maps.js"></script>
    <script src="https://www.amcharts.com/lib/4/geodata/worldLow.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
   

    <!-- My-Js -->
    <script src="<?= asset('AdminComponentsJs/routes.js') ?>"></script>
    <script src="<?= asset('AdminComponentsJs/AdminHome.js') ?>"></script>


    <script src="<?= asset('AdminComponentsJs/AllCustomers.js') ?>"></script>
    <script src="<?= asset('AdminComponentsJs/TableSorting.js') ?>"></script>
    <script src="<?= asset('AdminComponentsJs/AllAdministrator.js') ?>"></script>
    <script src="<?= asset('AdminComponentsJs/NewPackage.js') ?>"></script>
    <script src="<?= asset('AdminComponentsJs/AllOperators.js') ?>"></script>
    <script src="<?= asset('AdminComponentsJs/AllTemplates.js') ?>"></script>
    <script src="<?= asset('AdminComponentsJs/InternalTemplate.js') ?>"></script>
    <script src="<?= asset('AdminComponentsJs/AllVendors.js') ?>"></script>
    <script src="<?= asset('AdminComponentsJs/Inventory.js') ?>"></script>
    <script src="<?= asset('AdminComponentsJs/AllAgents.js') ?>"></script>
    <script src="<?= asset('AdminComponentsJs/All.js') ?>"></script>
    <script src="<?= asset('AdminComponentsJs/Form.js') ?>"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6l5bH_gXHS6Qjxk4MdS_bDaqicwzI_uE&callback=&libraries=places&v=weekly"
      defer
    ></script>
  </body>
</html>