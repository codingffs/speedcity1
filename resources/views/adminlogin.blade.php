<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" ng-app="CMATool">
    <!--<![endif]-->
    <head>
        <meta charset="utf-8" />
        <title>Speed Couriers | Login Page</title>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />

        <!-- ================== BEGIN BASE CSS STYLE ================== -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,300,700" rel="stylesheet" id="fontFamilySrc" />
        <link href="{{ url('assets/css/animate.min.css')}}" rel="stylesheet" />
        <link href="{{ url('assets/css/style.min.css')}}" rel="stylesheet" />
        <link href="{{ url('assets/plugins/jquery-ui/jquery-ui.min.css')}}" rel="stylesheet" />
        <link href="{{ url('assets/plugins/bootstrap/bootstrap-4.1.1/css/bootstrap.min.css')}}" rel="stylesheet" />
        <link href="{{ url('assets/plugins/font-awesome/5.1/css/all.css')}}" rel="stylesheet" />
        
        <!-- ================== END BASE CSS STYLE ================== -->

        <!-- ================== BEGIN BASE JS ================== -->
        <script src="{{ url('assets/plugins/pace/pace.min.js')}}"></script>
        <script src = "{{ url('assets/js/angular-1.7.9/angular.min.js')}}"></script>
        <!-- ================== END BASE JS ================== -->
        <script>
        var BASE_URL = "<?php echo url('');?>/";
        </script>
        <!--[if lt IE 9]>
            <script src="{{ url('assets/crossbrowserjs/excanvas.min.js')}}"></script>
        <![endif]-->
    </head>
    <body class="pace-top" ng-controller="loginCtrl">
        <!-- begin #page-loader -->
        <div id="page-loader" class="page-loader fade in"><span class="spinner">Loading...</span></div>
        <!-- end #page-loader -->

        <!-- begin #page-container -->
        <div id="page-container" class="fade page-container">
            <!-- begin login -->
            <div class="login">
                <!-- begin login-brand -->
                <div class="login-brand bg-inverse text-white">
                    <img src="{{ url('assets/img/logo-white.png')}}" height="36" class="pull-right" alt="" /> Login Panel
                </div>
                <!-- end login-brand -->
                <!-- begin login-content -->
                <div class="login-content">
                    <h4 class="text-center m-t-0 m-b-20">Great to have you back!</h4>
                    <form onsubmit="return false;" id="loginform" name="loginform" ng-submit="validate()" class="form-input-flat">
                        <div class="form-group">
                            <input type="email" ng-model="user.email" class="form-control input-lg" placeholder="Email Address" required=""/>
                        </div>
                        
                        <div class="form-group">
                            <input type="password" ng-model="user.password" class="form-control input-lg" placeholder="Password" required=""/>
                        </div>
                        
                        <div class="row m-b-20">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-lime btn-lg btn-block">Sign in to your account</button>
                            </div>
                        </div>                        
                    </form>
                </div>
                <!-- end login-content -->
            </div>
            <!-- end login -->
        </div>
        <!-- end page container -->



        <!-- ================== BEGIN BASE JS ================== -->
        <script src="{{ url('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
        <script src="{{ url('assets/plugins/jquery/jquery-3.3.1.min.js')}}"></script>
        <script src="{{ url('assets/plugins/bootstrap/bootstrap-4.1.1/js/bootstrap.bundle.min.js')}}"></script>
        <!--[if lt IE 9]>
                <script src="{{ url('assets/crossbrowserjs/html5shiv.js')}}"></script>
                <script src="{{ url('assets/crossbrowserjs/respond.min.js')}}"></script>
        <![endif]-->
        <script src="{{ url('assets/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
        <script src="{{ url('assets/plugins/jquery-cookie/jquery.cookie.js')}}"></script>
        <!-- ================== END BASE JS ================== -->

        <!-- ================== BEGIN PAGE LEVEL JS ================== -->
        <script src="{{ url('assets/js/demo.min.js')}}"></script>
        <script src="{{ url('assets/js/apps.min.js')}}"></script>
        <!-- ================== END PAGE LEVEL JS ================== -->	
<script>
$(document).ready(function () {
    App.init();
    Demo.initThemePanel();
});
'use strict';
angular.module('CMATool', []).controller('loginCtrl', function ($scope, $http, $window) {
    $scope.user = {email:'',password:''};

    $scope.showFrogetPassword = function () {
        $("#signupform").hide();
        $("#loginform").hide();
        $("#forgetPasswordForm").show();
    };

    $scope.forgetPassword = function () {
        var formData = {
            "email": $scope.femail
        };
        $http.post(BASE_URL + 'api/admin/forget_password', formData).then(function (response) {

            $scope.status3 = response.data.status;
            $scope.message = response.data.message;

        }, function (error) {
            console.log(error);
            $scope.status3 = "error";
            $scope.message = error.data.message;
        });
    };
    
    $scope.validate = function ()
    {
        console.log($scope.user);
        $http.post(BASE_URL + 'api/admin/login', $scope.user).then(function (response) {
            if (response.status == 200) { 
                $http.post(BASE_URL + 'admin/savelogin', response.data.data).then(function (res) {
                    if (response.status == 200) 
                    {
                        $window.location.href = BASE_URL + 'admin';
                    }
                });
            }
        }, function (error) {
            console.log(error);
            $scope.status = "error";
            $scope.message = "Please check your credentials.";
        });
    }
});
    
</script>

    </body>
</html>
