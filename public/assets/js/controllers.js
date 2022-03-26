
//'use strict';

//Controllers

function HomeCtrl($scope, $http, $routeParams, $interval, $timeout, $window)
{
    //PageDemo.init();
        
}
function UserCtrl($scope, $http, $routeParams, $interval, $timeout, $window)
{
    $scope.dataList = [];
    
    $scope.getDataList = function () {

        $http.get(BASE_URL + 'api/admin/users', {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            if(response.data.success === true)
            {
                $scope.dataList = response.data.data;
            }
        }, function errorCallback(response) {

        });
    };
    $scope.getDataList();
}
function HomeSliderCtrl($scope, $http, $routeParams, $interval, $timeout, $window)
{
    $scope.BASE_URL = BASE_URL;
    $scope.dataList = [];
    $scope.ob = {slider_type:"home", image:"", url:"", name:"", detail:"", feature_image:"", btn_text:"", btn_url:"", video_text:"", video_url:"", status:""};
    $scope.obEdit = {id:"",slider_type:"home", image:"", url:"", name:"", detail:"", feature_image:"", btn_text:"", btn_url:"", video_text:"", video_url:"", status:""};           
    $scope.getDataList = function () {
        $http.get(BASE_URL + 'api/admin/slider?slider_type=home', {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            if(response.data.success === true)
            {
                $scope.dataList = response.data.data;                
            }
        }, function errorCallback(response) {

        });  
    };
    $scope.getDataList();
    $scope.error = {};
    $scope.addData = function(){
        $scope.error = {};
        $http.post(BASE_URL + 'api/admin/slider',$scope.ob,{
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            if(response.data.success === true)
            {
                $.gritter.add({
			title: 'Success',
			text: 'Image Added Successfuly.',
			sticky: true,
			class_name: 'my-sticky-class'
		});
                $scope.ob = {slider_type:"home", image:"", url:"", name:"", detail:"", feature_image:"", btn_text:"", btn_url:"", video_text:"", video_url:"", status:""};
                $scope.getDataList();
                $("#add-modal").modal('hide');
            }
        }, function errorCallback(response) {
            $scope.error = response.data.data;
            
            $.gritter.add({
			title: 'Error',
			text: response.data.message,
			sticky: true,
			class_name: 'my-sticky-class'
		});
        });
    };
    $scope.editData = function(ob){
        $scope.obEdit = ob;
        $scope.obEdit.status = ob.status.toString();
        $("#update-modal").modal('show');
    };
    $scope.updateData = function(){
        $http.put(BASE_URL + 'api/admin/slider',$scope.obEdit,{
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            if(response.data.success === true)
            {
                $.gritter.add({
			title: 'Success',
			text: 'Image Updated Successfuly.',
			sticky: true,
			class_name: 'my-sticky-class'
		});
                $scope.obEdit = {id:"",slider_type:"home", image:"", url:"", name:"", detail:"", feature_image:"", btn_text:"", btn_url:"", video_text:"", video_url:"", status:""};           
                $scope.getDataList();
                $("#update-modal").modal('hide');
            }
        }, function errorCallback(response) {

        });
    };    
    
    $scope.imageUpload 	= function(f,type)
    {
        var varFile = f.files[0];
        var fd 	= new FormData();
        fd.append('image', varFile);
        $http.post(BASE_URL+'api/admin/slider/image', fd, {
            transformRequest: angular.identity,
            headers: {
                    'Content-Type': undefined,
                    'Authorization': TOKEN
            }
        }).then(function(response) {            
            if(type == 'add')
            {
                $scope.ob.image = response.data.data.filename;
            }
            else if(type == 'edit')
            {
                $scope.obEdit.image = response.data.data.filename;
            }
            
            var Gritter = function () {
                $.gritter.add({
                    title: "Success",
                    text: response.data.message
                });
            return false;
            }();
        }, function errorCallback(response){
                            
        });
    }
    $scope.featureImageUpload 	= function(f,type)
    {
        var varFile = f.files[0];
        var fd 	= new FormData();
        fd.append('image', varFile);
        $http.post(BASE_URL+'api/admin/slider/image', fd, {
            transformRequest: angular.identity,
            headers: {
                    'Content-Type': undefined,
                    'Authorization': TOKEN
            }
        }).then(function(response) {            
            if(type == 'add')
            {
                $scope.ob.feature_image = response.data.data.filename;
            }
            else if(type == 'edit')
            {
                $scope.obEdit.feature_image = response.data.data.filename;
            }
            
            var Gritter = function () {
                $.gritter.add({
                    title: "Success",
                    text: response.data.message
                });
            return false;
            }();
        }, function errorCallback(response){
                            
        });
    }
}


function CourierItemsCtrl($scope, $http, $routeParams, $interval, $timeout, $window){
    $scope.BASE_URL = BASE_URL;
    $scope.dataList = [];
    $scope.ob = {item_name:"",description:""};
    $scope.obEdit = {id:"",item_name:"",description:""};
    $scope.getDataList = function () {
        $http.get(BASE_URL + 'api/admin/courier-items', {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            if(response.data.success === true)
            {
                $scope.dataList = response.data.data;                
            }
        }, function errorCallback(response) {

        });  
    };
    $scope.getDataList();
    $scope.error = {}; 
}
function AddCourierItemsCtrl($scope, $http, $routeParams, $interval, $timeout, $window){
    $scope.slugify = function(input) {
            if (!input)
                return;

            // make lower case and trim
            var slug = input.toLowerCase().trim();

            // replace invalid chars with spaces
            slug = slug.replace(/[^a-z0-9\s-]/g, ' ');

            // replace multiple spaces or hyphens with a single hyphen
            slug = slug.replace(/[\s-]+/g, '-');

            $scope.pageData.slug =  slug;
        };
    $scope.pageData = {slug:"",item_name:"",description:""};
    $scope.ckEditorOptions = {
         toolbar: 'full',
         uiColor: '#FAFAFA',
         height: '250px'
     };
    
    $scope.saveData = function(){
        $http.post(BASE_URL + 'api/admin/courier-items',$scope.pageData, {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            $.gritter.add({
			title: 'Success',
			text: response.data.message,
			sticky: true,
			class_name: 'my-sticky-class'
		});
            $scope.pageData = {slug:"",item_name:"",description:""};   
        }, function errorCallback(response) {

        });
    }; 
    
}
function UpdateCourierItemsCtrl($scope, $http, $routeParams, $interval, $timeout, $window){
    $scope.slugify = function(input) {
            if (!input)
                return;

            // make lower case and trim
            var slug = input.toLowerCase().trim();

            // replace invalid chars with spaces
            slug = slug.replace(/[^a-z0-9\s-]/g, ' ');

            // replace multiple spaces or hyphens with a single hyphen
            slug = slug.replace(/[\s-]+/g, '-');

            $scope.pageData.slug =  slug;
        };
    $scope.pageData = {id:"",slug:"",item_name:"",description:""};
    $scope.ckEditorOptions = {
         toolbar: 'full',
         uiColor: '#FAFAFA',
         height: '250px'
     };
    
    $scope.getData = function () {
        $http.get(BASE_URL + 'api/admin/courier-items?id='+$routeParams.id, {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            if(response.data.success === true)
            {
                $scope.pageData = response.data.data;
            }
        }, function errorCallback(response) {

        });
    };
    $scope.getData();
    $scope.saveData = function(){
        $http.put(BASE_URL + 'api/admin/courier-items',$scope.pageData, {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            $.gritter.add({
			title: 'Success',
			text: response.data.message,
			sticky: true,
			class_name: 'my-sticky-class'
		});
        }, function errorCallback(response) {

        });
    };
}

///////////////////////////////////
function SpeciesCtrl($scope, $http, $routeParams, $interval, $timeout, $window){
    $scope.BASE_URL = BASE_URL;
    $scope.dataList = [];
    
    $scope.getDataList = function () {
        $http.get(BASE_URL + 'api/admin/species', {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            if(response.data.success === true)
            {
                $scope.dataList = response.data.data;                
            }
        }, function errorCallback(response) {

        });  
    };
    $scope.getDataList();
    $scope.error = {};      
}
function AddSpeciesCtrl($scope, $http, $routeParams, $interval, $timeout, $window){
    
    $scope.pageData = {species_name:"",scientific_name:"",family:"",species_description:"",silvicultural_requirements:"",utility:"",image:""};
    $scope.ckEditorOptions = {
         toolbar: 'full',
         uiColor: '#FAFAFA',
         height: '250px'
     };
    
    $scope.saveData = function(){
        $http.post(BASE_URL + 'api/admin/species',$scope.pageData, {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            $.gritter.add({
			title: 'Success',
			text: response.data.message,
			sticky: true,
			class_name: 'my-sticky-class'
		});
            $scope.pageData = {slug:"",title:"",description:"",keywords:"",content:"",feature_image:""};   
        }, function errorCallback(response) {

        });
    }; 
    
    $scope.featureImageUpload 	= function(f,type)
    {
        var varFile = f.files[0];
        var fd 	= new FormData();
        fd.append('image', varFile);
        $http.post(BASE_URL+'api/admin/species/image', fd, {
            transformRequest: angular.identity,
            headers: {
                    'Content-Type': undefined,
                    'Authorization': TOKEN
            }
        }).then(function(response) {            
            $scope.pageData.image = response.data.data.filename;                        
            var Gritter = function () {
                $.gritter.add({
                    title: "Success",
                    text: response.data.message
                });
            return false;
            }();
        }, function errorCallback(response){
                            
        });
    }
}
function UpdateSpeciesCtrl($scope, $http, $routeParams, $interval, $timeout, $window){
    
    $scope.pageData = {id:"",species_name:"",scientific_name:"",family:"",species_description:"",silvicultural_requirements:"",utility:"",image:""};
    $scope.ckEditorOptions = {
         toolbar: 'full',
         uiColor: '#FAFAFA',
         height: '250px'
     };
    
    $scope.getData = function () {
        $http.get(BASE_URL + 'api/admin/species?id='+$routeParams.id, {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            if(response.data.success === true)
            {
                $scope.pageData = response.data.data;
            }
        }, function errorCallback(response) {

        });
    };
    $scope.getData();
    $scope.saveData = function(){
        $http.put(BASE_URL + 'api/admin/species',$scope.pageData, {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            $.gritter.add({
			title: 'Success',
			text: response.data.message,
			sticky: true,
			class_name: 'my-sticky-class'
		});
        }, function errorCallback(response) {

        });
    }; 
    
    $scope.featureImageUpload 	= function(f,type)
    {
        var varFile = f.files[0];
        var fd 	= new FormData();
        fd.append('image', varFile);
        $http.post(BASE_URL+'api/admin/species/image', fd, {
            transformRequest: angular.identity,
            headers: {
                    'Content-Type': undefined,
                    'Authorization': TOKEN
            }
        }).then(function(response) {            
            $scope.pageData.image = response.data.data.filename;                        
            var Gritter = function () {
                $.gritter.add({
                    title: "Success",
                    text: response.data.message
                });
            return false;
            }();
        }, function errorCallback(response){
                            
        });
    }
}

function OfficesCtrl($scope, $http, $routeParams, $interval, $timeout, $window){
    $scope.BASE_URL = BASE_URL;
    $scope.dataList = [];
    
    $scope.getDataList = function () {
        $http.get(BASE_URL + 'api/admin/offices', {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            if(response.data.success === true)
            {
                $scope.dataList = response.data.data;                
            }
        }, function errorCallback(response) {

        });  
    };
    $scope.getDataList();
    $scope.error = {};        
}
function AddOfficesCtrl($scope, $http, $routeParams, $interval, $timeout, $window){
    
    $scope.pageData = {branch_name:"",branch_code:"",street:"",city:"",state:"",zip_code:"",contact:""};
    $scope.ckEditorOptions = {
         toolbar: 'full',
         uiColor: '#FAFAFA',
         height: '250px'
     };
    
    $scope.saveData = function(){
        $http.post(BASE_URL + 'api/admin/offices',$scope.pageData, {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            $.gritter.add({
			title: 'Success',
			text: response.data.message,
			sticky: true,
			class_name: 'my-sticky-class'
		});
        
        }, function errorCallback(response) {

        });
    }; 
    
}
function UpdateOfficesCtrl($scope, $http, $routeParams, $interval, $timeout, $window){
    
    $scope.pageData = {id:"",branch_name:"",branch_code:"",street:"",city:"",state:"",zip_code:"",contact:""};
    $scope.ckEditorOptions = {
         toolbar: 'full',
         uiColor: '#FAFAFA',
         height: '250px'
     };
    
    $scope.getData = function () {
        $http.get(BASE_URL + 'api/admin/offices?id='+$routeParams.id, {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            if(response.data.success === true)
            {
                $scope.pageData = response.data.data;
            }
        }, function errorCallback(response) {

        });
    };
    $scope.getData();
    $scope.saveData = function(){
        $http.put(BASE_URL + 'api/admin/offices',$scope.pageData, {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            $.gritter.add({
			title: 'Success',
			text: response.data.message,
			sticky: true,
			class_name: 'my-sticky-class'
		});
        }, function errorCallback(response) {

        });
    };
}

function LocalpackagesCtrl($scope, $http, $routeParams, $interval, $timeout, $window){
    $scope.BASE_URL = BASE_URL;
    $scope.dataList = [];
    
    $scope.getDataList = function () {
        $http.get(BASE_URL + 'api/admin/localpackages', {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            if(response.data.success === true)
            {
                $scope.dataList = response.data.data;                
            }
        }, function errorCallback(response) {

        });  
    };
    $scope.getDataList();
    $scope.error = {};        
}
function AddLocalpackagesCtrl($scope, $http, $routeParams, $interval, $timeout, $window){
    
    $scope.pageData = {itemsID:"",source_address:"",destination_address:"",city:"",state:"",zip_code:"",distance:"",price_per_km:"",notes:""};
    $scope.ckEditorOptions = {
         toolbar: 'full',
         uiColor: '#FAFAFA',
         height: '250px'
     };
    
    $scope.saveData = function(){
        $http.post(BASE_URL + 'api/admin/localpackages',$scope.pageData, {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            $.gritter.add({
			title: 'Success',
			text: response.data.message,
			sticky: true,
			class_name: 'my-sticky-class'
		});
        
        }, function errorCallback(response) {

        });
    }; 
    
}
function UpdateLocalpackagesCtrl($scope, $http, $routeParams, $interval, $timeout, $window){
    
    $scope.pageData = {id:"",itemsID:"",source_address:"",destination_address:"",city:"",state:"",zip_code:"",distance:"",price_per_km:"",notes:""};
    $scope.ckEditorOptions = {
         toolbar: 'full',
         uiColor: '#FAFAFA',
         height: '250px'
     };
    
    $scope.getData = function () {
        $http.get(BASE_URL + 'api/admin/localpackages?id='+$routeParams.id, {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            if(response.data.success === true)
            {
                $scope.pageData = response.data.data;
            }
        }, function errorCallback(response) {

        });
    };
    $scope.getData();
    $scope.saveData = function(){
        $http.put(BASE_URL + 'api/admin/localpackages',$scope.pageData, {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            $.gritter.add({
			title: 'Success',
			text: response.data.message,
			sticky: true,
			class_name: 'my-sticky-class'
		});
        }, function errorCallback(response) {

        });
    };
}

function DomesticpackagesCtrl($scope, $http, $routeParams, $interval, $timeout, $window){
    $scope.BASE_URL = BASE_URL;
    $scope.dataList = [];
    
    $scope.getDataList = function () {
        $http.get(BASE_URL + 'api/admin/domesticpackages', {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            if(response.data.success === true)
            {
                $scope.dataList = response.data.data;                
            }
        }, function errorCallback(response) {

        });  
    };
    $scope.getDataList();
    $scope.error = {};        
}
function AddDomesticpackagesCtrl($scope, $http, $routeParams, $interval, $timeout, $window){
    
    $scope.pageData = {itemsID:"",source_city:"",destination_city:"",price:"",notes:""};
    $scope.ckEditorOptions = {
         toolbar: 'full',
         uiColor: '#FAFAFA',
         height: '250px'
     };
    
    $scope.saveData = function(){
        $http.post(BASE_URL + 'api/admin/domesticpackages',$scope.pageData, {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            $.gritter.add({
			title: 'Success',
			text: response.data.message,
			sticky: true,
			class_name: 'my-sticky-class'
		});
        
        }, function errorCallback(response) {

        });
    }; 
    
}
function UpdateDomesticpackagesCtrl($scope, $http, $routeParams, $interval, $timeout, $window){
    
    $scope.pageData = {id:"",itemsID:"",source_city:"",destination_city:"",price:"",notes:""};
    $scope.ckEditorOptions = {
         toolbar: 'full',
         uiColor: '#FAFAFA',
         height: '250px'
     };
    
    $scope.getData = function () {
        $http.get(BASE_URL + 'api/admin/domesticpackages?id='+$routeParams.id, {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            if(response.data.success === true)
            {
                $scope.pageData = response.data.data;
            }
        }, function errorCallback(response) {

        });
    };
    $scope.getData();
    $scope.saveData = function(){
        $http.put(BASE_URL + 'api/admin/domesticpackages',$scope.pageData, {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            $.gritter.add({
			title: 'Success',
			text: response.data.message,
			sticky: true,
			class_name: 'my-sticky-class'
		});
        }, function errorCallback(response) {

        });
    };
}

function TreesCtrl($scope, $http, $routeParams, $interval, $timeout, $window){
    $scope.BASE_URL = BASE_URL;
    $scope.dataList = [];
    
    $scope.getDataList = function () {
        $http.get(BASE_URL + 'api/admin/trees', {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            if(response.data.success === true)
            {
                $scope.dataList = response.data.data;                
            }
        }, function errorCallback(response) {

        });  
    };
    $scope.getDataList();
    $scope.error = {};      
}

function AdminCtrl($scope, $http, $routeParams, $interval, $timeout, $window)
{
    $scope.dataList = [];
    $scope.obu = {"email":"","password":"","name":"","confirm_password":""};
    
    $scope.getDataList = function () {

        $http.get(BASE_URL + 'api/admin/admin_user', {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            if(response.data.success === true)
            {
                $scope.dataList = response.data.data;
            }
        }, function errorCallback(response) {

        });
    };
    $scope.getDataList(); 
            
    $scope.addUser = function(){
        $scope.error = {};
        $http.post(BASE_URL + 'api/admin/add_admin_user',$scope.obu,{
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            if(response.data.success === true)
            {
                $.gritter.add({
			title: 'Success',
			text: 'User Added Successfuly.',
			sticky: true,
			class_name: 'my-sticky-class'
		});
                
                $scope.obu = {"email":"","password":"","name":"","confirm_password":""};
                $scope.getDataList();
                $("#add-user-modal").modal('hide');
            }
        }, function errorCallback(response) {
            $scope.error = response.data.data;
            
            $.gritter.add({
			title: 'Error',
			text: response.data.message,
			sticky: true,
			class_name: 'my-sticky-class'
		});
        });
    };
    $scope.openAddUser = function(){
        $("#show-group-users").modal('hide');
        $("#add-user-modal").modal('show');
    };
    $scope.deactivateUser = function(user){
        
        var data = {id:user.id};
        $http.post(BASE_URL + 'api/admin/participants/deactivate',data, {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            $.gritter.add({
			title: 'Success',
			text: 'De-Activated Successfuly.',
			sticky: true,
			class_name: 'my-sticky-class'
		});
                $scope.getDataList();
        }, function errorCallback(response) {

        });
    };
    $scope.activateUser = function(user){
        
        var data = {id:user.id};
        $http.post(BASE_URL + 'api/admin/participants/activate',data, {
            headers: {
                'Authorization': TOKEN
            }
        }).then(function (response) {
            $.gritter.add({
			title: 'Success',
			text: 'Activated Successfuly.',
			sticky: true,
			class_name: 'my-sticky-class'
		});
                $scope.getDataList();
        }, function errorCallback(response) {

        });
    };
}



