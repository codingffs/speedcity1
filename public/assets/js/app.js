'use strict';
//'ngAnimate', 'ngSanitize','datatables','NgSwitchery','ui.select','ui.bootstrap','moment-picker'
var app = angular.module('CMATool', ['ngRoute','ngAnimate', 'ngSanitize','NgSwitchery','ui.select','moment-picker','datatables','ngQuill','ckeditor','textAngular']).
        config(['$routeProvider', function ($routeProvider)  {
                angular.lowercase = angular.$$lowercase;
                $routeProvider.
                        when('/', {
                            templateUrl: BASE_URL+'admin/dashboard',
                            controller: HomeCtrl,
                            activetab: 'dashboard'
                        }).
                        when('/dashboard', {
                            templateUrl: BASE_URL+'admin/dashboard',
                            controller: HomeCtrl,
                            activetab: 'dashboard'
                        }).
                        when('/user', {
                            templateUrl: BASE_URL+'admin/user',
                            controller: UserCtrl,
                            activetab: 'user'
                        }).
                        when('/courier-items', {
                            templateUrl: BASE_URL+'admin/courier-items',
                            controller: CourierItemsCtrl,
                            activetab: 'courier-items'
                        }).
                        when('/courier-items/add', {
                            templateUrl: BASE_URL+'admin/add_courier_items',
                            controller: AddCourierItemsCtrl,
                            activetab: 'courier-items'
                        }).
                        when('/courier-items/update/:id', {
                            templateUrl: BASE_URL+'admin/update_courier_items',
                            controller: UpdateCourierItemsCtrl,
                            activetab: 'courier-items'
                        }).
                        when('/trees', {
                            templateUrl: BASE_URL+'admin/trees',
                            controller: TreesCtrl,
                            activetab: 'trees'
                        }).
                        when('/species', {
                            templateUrl: BASE_URL+'admin/species',
                            controller: SpeciesCtrl,
                            activetab: 'species'
                        }).
                        when('/species/add', {
                            templateUrl: BASE_URL+'admin/add_species',
                            controller: AddSpeciesCtrl,
                            activetab: 'species'
                        }).
                        when('/species/update/:id', {
                            templateUrl: BASE_URL+'admin/update_species',
                            controller: UpdateSpeciesCtrl,
                            activetab: 'species'
                        }).
						when('/offices', {
                            templateUrl: BASE_URL+'admin/offices',
                            controller: OfficesCtrl,
                            activetab: 'offices'
                        }).
                        when('/offices/add', {
                            templateUrl: BASE_URL+'admin/add_offices',
                            controller: AddOfficesCtrl,
                            activetab: 'offices'
                        }).
                        when('/offices/update/:id', {
                            templateUrl: BASE_URL+'admin/update_offices',
                            controller: UpdateOfficesCtrl,
                            activetab: 'offices'
                        }).
						when('/localpackages', {
                            templateUrl: BASE_URL+'admin/localpackages',
                            controller: LocalpackagesCtrl,
                            activetab: 'offices'
                        }).
                        when('/localpackages/add', {
                            templateUrl: BASE_URL+'admin/add_localpackages',
                            controller: AddLocalpackagesCtrl,
                            activetab: 'localpackages'
                        }).
                        when('/localpackages/update/:id', {
                            templateUrl: BASE_URL+'admin/update_localpackages',
                            controller: UpdateLocalpackagesCtrl,
                            activetab: 'localpackages'
                        }).
						when('/domesticpackages', {
                            templateUrl: BASE_URL+'admin/domesticpackages',
                            controller: DomesticpackagesCtrl,
                            activetab: 'domestic'
                        }).
                        when('/domesticpackages/add', {
                            templateUrl: BASE_URL+'admin/add_domesticpackages',
                            controller: AddDomesticpackagesCtrl,
                            activetab: 'domesticpackages'
                        }).
                        when('/domesticpackages/update/:id', {
                            templateUrl: BASE_URL+'admin/update_domesticpackages',
                            controller: UpdateDomesticpackagesCtrl,
                            activetab: 'domesticpackages'
                        }).
                        when('/admin-user', {
                            templateUrl: BASE_URL+'admin/admin',
                            controller: AdminCtrl,
                            activetab: 'admin'
                        }).
                        otherwise({redirectTo: '/'});
            }]).run(['$rootScope', '$http', '$browser', '$timeout', "$route",'$interval', function ($scope, $http, $browser, $timeout, $route,$interval) {
        $scope.$on('$routeChangeStart', function () {
            $scope.isRouteLoading = true;
            
        });
        $scope.$on("$routeChangeSuccess", function (scope, next, current) {
            $scope.part = $route.current.activetab;
        });
    }]);


app.filter('propsFilter', function() {
  return function(items, props) {
    var out = [];

    if (angular.isArray(items)) {
      var keys = Object.keys(props);

      items.forEach(function(item) {
        var itemMatches = false;

        for (var i = 0; i < keys.length; i++) {
          var prop = keys[i];
          var text = props[prop].toLowerCase();
          if (item[prop].toString().toLowerCase().indexOf(text) !== -1) {
            itemMatches = true;
            break;
          }
        }

        if (itemMatches) {
          out.push(item);
        }
      });
    } else {
      // Let the output be the input untouched
      out = items;
    }

    return out;
  };
});
app.config(['$locationProvider', function ($location) {
        $location.hashPrefix('!');
        //$location.html5Mode(true);
    }]);
app.filter('contains', function() {
  return function (array, needle) {
    return array.indexOf(needle) >= 0;
  };
});
app.controller('mediaController', function($scope, $http,$routeParams,$interval,$window) {
    $scope.copyInput = "";
    $scope.data = [];    
    $scope.getMedia = function()
    {
        $http.get(BASE_URL + 'api/admin/media', {headers: {'Authorization': TOKEN}}).then(function (response) {
            $scope.data = response.data.data;
        },function (error) {
            console.log(error);               
        }); 
    };  
    $scope.getMedia();
    
    $scope.deleteFile = function(ob){
        if(confirm("Do you waant to delete this file?"))
        {
            $http.delete(BASE_URL + 'api/admin/media/'+ob.id, {headers: {'Authorization': TOKEN}}).then(function (response) {
                $scope.getMedia();
            },function (error) {
                console.log(error);               
            }); 
        }
    };
    
    $scope.copy = function(name){
        var copyElement = document.createElement("textarea");
        copyElement.style.position = 'fixed';
        copyElement.style.opacity = '0';
        copyElement.textContent = BASE_URL+'storage/app/public/' + decodeURI(name);
        var body = document.getElementsByTagName('body')[0];
        body.appendChild(copyElement);
        copyElement.select();
        document.execCommand('copy');
        body.removeChild(copyElement);
        
        alert("Copied url");
     }
    
    $scope.fileUpload 	= function(f)
    {        
        var index = $(f).attr('data-index');
        var varFile = f.files[0];
        var fd 	= new FormData();
        fd.append('image', varFile);
        $http.post(BASE_URL+'api/admin/media', fd, {
            transformRequest: angular.identity,
            headers: {
                    'Content-Type': undefined,
                    'Authorization': TOKEN
            }
        }).then(function(response) {               
            var Gritter = function () {
                $.gritter.add({
                    title: "Success",
                    text: response.data.message
                });
            return false;
            }();
            $scope.getMedia();
        }, function errorCallback(response){
                            
        });
    }
});




