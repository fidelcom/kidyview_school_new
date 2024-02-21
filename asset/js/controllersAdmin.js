
'use strict';

//Controllers
function voucherListCtrl($scope, $http,$window) 
{
	$scope.encryptStr = function(id)
	{
		var qry = id.toString();
		var encrypted = CryptoJS.AES.encrypt(qry, "KidyView");
		var str = encrypted.toString();
		if(str.indexOf("/") == -1) {
			return str;
		}
		else{
			return $scope.encryptStr(id);
		}
		
	};
	$scope.getAllVoucherForSchool = function()
	{
		$scope.voucherList = [];
		$http.get(BASE_URL+'api/user/getAllVoucherForSchool',{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.voucherList = response.data.data;
				
				var encrypted ;
				for(var i = 0; i < $scope.voucherList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.voucherList[i].id);
					$scope.voucherList[i]['voucherID'] = encrypted;
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllVoucherForSchool();
	$scope.delete = function(ID)
	{
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':ID};
			$http.post(BASE_URL+'api/user/deleteVoucher',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey
				}
				}).then(function(response) {
				
				if(response.status == 200)
				{
					var result  = response.data;
					var Gritter = function () {
						$.gritter.add({
							title: 'Successfull',
							text: 'Voucher deleted successfully.'
						});
						
						$scope.getAllVoucherForSchool();
						return false;
					}();
				}
				
				}, function errorCallback(response){
				
			});
		}
	}

}
function addVoucherCtrl($scope, $http,$window) 
{
	$scope.getAllVoucherForSchool = function()
	{
		$scope.voucherList = [];
		$http.get(BASE_URL+'api/user/getAllGiftsForSchool',{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.voucherList = response.data.data;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllVoucherForSchool();
	$scope.convertDateNewFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [date.getFullYear(), mnth, day].join("-");
	}
	$scope.voucherObj={
		name:'',
		quantity:'',
		points:'',
		product_id:'',
		expire_date:'',
		description:''
	};
	$scope.addVoucher=function(){
		if($scope.voucherObj.name == '' || $scope.voucherObj.quantity == '' || $scope.voucherObj.points == '' || $scope.voucherObj.product_id == '' || $scope.voucherObj.expire_date == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill all required fields(Indicating With * Sign).'
				});
				return false;
			}();
			return false;
		}					
		$scope.voucherObj.expire_date=$scope.convertDateNewFormat($scope.voucherObj.expire_date);
		$http.post(BASE_URL+'api/user/addVoucher',$scope.voucherObj,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data.data;
			if(result){
				if(result == 'exist'){
					var Gritter = function () {
						$.gritter.add({
							title: 'Failed',
							text: response.data.message
						});
						return false;
					}();
				}else{
					var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: 'Voucher added successfully.'
					});
						$window.location.href = '#!/voucher-list';
						return false;
					}();	
				}
			}
			
			}, function errorCallback(response){
		});
}
}
function editVoucherCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
	
	$scope.voucherObj={
		id:'',
		name:'',
		quantity:'',
		points:'',
		product_id:'',
		expire_date:'',
		description:''
	};
	$scope.convertDateNewFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [date.getFullYear(), mnth, day].join("-");
	}
	$scope.getAllVoucherForSchool = function()
	{
		$scope.voucherList = [];
		$http.get(BASE_URL+'api/user/getAllGiftsForSchool',{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.voucherList = response.data.data;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllVoucherForSchool();
	var sid;
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.giftID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.giftID;
	};	
	$timeout($scope.setID(), 2000);
	$scope.voucherObj.id=$scope.giftID;
	$scope.getVoucherDetails = function()
	{
		var formData = {'id':$scope.voucherObj.id}
		$http.post(BASE_URL+'api/user/getVoucherDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.vdata 	= response.data.data;
				$scope.voucherObj.name=$scope.vdata.name;
				$scope.voucherObj.quantity=$scope.vdata.quantity;
				$scope.voucherObj.points=$scope.vdata.points;
				$scope.voucherObj.product_id=$scope.vdata.product_id;
				$scope.voucherObj.expire_date=new Date($scope.vdata.expire_date);
				$scope.voucherObj.description=$scope.vdata.description;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getVoucherDetails(); 
	$scope.editVoucher=function(){
		if($scope.voucherObj.id==''){
			return false;
		}
		if($scope.voucherObj.name == '' || $scope.voucherObj.quantity == '' || $scope.voucherObj.points == '' || $scope.voucherObj.product_id == '' || $scope.voucherObj.expire_date == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill all required fields(Indicating With * Sign).'
				});
				return false;
			}();
			return false;
		}					
		$scope.voucherObj.expire_date=$scope.convertDateNewFormat($scope.voucherObj.expire_date);
		$http.post(BASE_URL+'api/user/editVoucher',$scope.voucherObj,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data.data;
			if(result){
				if(result == 'exist'){
					var Gritter = function () {
						$.gritter.add({
							title: 'Failed',
							text: response.data.message
						});
						return false;
					}();
				}else{
				var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Voucher updated successfully.'
				});
					$window.location.href = '#!/voucher-list';
					return false;
				}();	
				}
			}
			
			}, function errorCallback(response){
		});
		}
	
}
function HomeCtrl($scope, $http) 
{
    var search = "all";
    $scope.dashboardData = "";
    $scope.revenue = "";
    $scope.transaction = "";
    $scope.schoolListing = [];
    
	$scope.encryptStr = function(id)
	{
		var qry = id.toString();
		var encrypted = CryptoJS.AES.encrypt(qry, "KidyView");
		var str = encrypted.toString();
		if(str.indexOf("/") == -1) {
			return str;
		}
		else{
			return $scope.encryptStr(id);
		}
		
	};
	$scope.currclass=0;
	$scope.getAllForDashboard = function(search)
	{
		$scope.currclass=search;
		var formData = {'search':search}
		$http.post(BASE_URL+'report/reportgraphrevenue/getAllForDashboard',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.dashboardData = response.data.data;
                                $scope.schoolListing = $scope.dashboardData.no_of_school;
                                $scope.revenue = $scope.dashboardData.revenue;
                                $scope.transaction = $scope.dashboardData.transaction;
				var encrypted ;
				for(var i = 0; i < $scope.schoolListing.length; i++)
				{
					encrypted = $scope.encryptStr($scope.schoolListing[i].id);
					$scope.schoolListing[i]['schoolID'] = encrypted;
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllForDashboard(search);
}
function getAllSchoolCtrl($scope, $http, $routeParams, $timeout) 
{
	$scope.encryptStr = function(id)
	{
		var qry = id.toString();
		var encrypted = CryptoJS.AES.encrypt(qry, "KidyView");
		var str = encrypted.toString();
		if(str.indexOf("/") == -1) {
			return str;
		}
		else{
			return $scope.encryptStr(id);
		}
		
	};
	
	$scope.getAllSchoolsForSchoolMngt = function()
	{
		
		$http.get(BASE_URL+'api/user/getAllSchoolsForSchoolMngt',{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.schoolList = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.schoolList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.schoolList[i].id);
					$scope.schoolList[i]['schoolID'] = encrypted;
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllSchoolsForSchoolMngt();
	
	$scope.schoolDisabled = function(schoolID, status)
	{
		
		//alert(status);
		//alert(schoolID); return false;
		var formData = {'id':schoolID, 'status':status};
		$http.post(BASE_URL+'api/user/schoolDisabled',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				var result  = response.data;
				var Gritter = function () {
					if(status == 0)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'School Status Disabled Now.'
						});
					}else if(status == 1)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'School Status Enabled Now.'
						});
					}
					
					$scope.getAllSchoolsForSchoolMngt();
					return false;
				}();
			}
			
			}, function errorCallback(response){
			
		});
		
	}
}

function allSchoolCtrl($scope, $http, $routeParams, $timeout) 
{
	var sid;
	$scope.schoolID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.schoolID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.schoolID;
	};	
	$timeout($scope.setID(), 2000);
	//alert($scope.schoolID); return false;
	$scope.schoolinfo = false;
	$scope.getSchoolDetails = function()
	{
		var formData = {'id':$scope.schoolID}
		$http.post(BASE_URL+'api/user/getSchoolDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.schoolinfo = response.data.data;
				
				$scope.schoolname 	= $scope.schoolinfo.school_name;
				$scope.email 		= $scope.schoolinfo.email;
				$scope.phone 		= $scope.schoolinfo.phone;
				$scope.avgStudent 	= $scope.schoolinfo.average_student;
				$scope.location 	= $scope.schoolinfo.location;
				$scope.mission 		= $scope.schoolinfo.mission;
				$scope.vision 		= $scope.schoolinfo.vision;
				$scope.coreValues 	= $scope.schoolinfo.core_values;
				$scope.avgStaff 	= $scope.schoolinfo.average_staff;
				$scope.city 		= $scope.schoolinfo.city;
				$scope.state 		= $scope.schoolinfo.state;
                                $scope.countryName 	= $scope.schoolinfo.countryName;
                                $scope.countryCode      = $scope.schoolinfo.countryCode;
				$scope.pincode 		= $scope.schoolinfo.pincode;
				$scope.skypeid 		= $scope.schoolinfo.skypeid;
				$scope.area 		= $scope.schoolinfo.area;
				$scope.motto 		= $scope.schoolinfo.motto;
				$scope.facebook 	= $scope.schoolinfo.facebook;
				$scope.twitter 		= $scope.schoolinfo.twitter;
				$scope.youtube 		= $scope.schoolinfo.youtube;
				$scope.linkdin 		= $scope.schoolinfo.linkdin;
				$scope.otherinfo 	= $scope.schoolinfo.otherinfo;
				$scope.schoolType 	= $scope.schoolinfo.schoolType;
				//$scope.schoolTypeNew = $scope.schoolType;
				$scope.pic 			= $scope.schoolinfo.pic;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getSchoolDetails();
}

function editSchoolCtrl($scope, $http, $routeParams, $timeout,$window,schoolTypeListData) 
{
	$scope.schoolTypeList=schoolTypeListData;
	var sid;
	$scope.schoolID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.schoolID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.schoolID;
	};	
	$timeout($scope.setID(), 2000);
	
	$scope.opsw 		= '';
	$scope.npsw 		= '';
	$scope.cpsw 		= '';
	
	$scope.schoolname 	= '';
	$scope.phone 		= '';
	$scope.email 		= '';
	$scope.avgStudent 	= '';
	$scope.location 	= '';
	$scope.mission 		= '';
	$scope.vision 		= '';
	$scope.coreValues 	= '';
	$scope.avgStaff 	= '';
	$scope.city 		= '';
	$scope.state 		= '';
	$scope.pincode 		= '';
	$scope.skypeid 		= '';
	$scope.currency		= '';
	$scope.area 		= '';
	$scope.motto 		= '';
	$scope.facebook 	= '';
	$scope.twitter 		= '';
	$scope.youtube 		= '';
	$scope.linkdin 		= '';
	$scope.otherinfo 	= '';
	$scope.schoolType 	= '';
	$scope.schoolTypeNew = '';
	$scope.pic 			= '';
        $scope.countrycode = '';
        $scope.sub_acc_number = "";
	
	
	$scope.getSchoolDetails = function()
	{
		var formData = {'id':$scope.schoolID}
		$scope.currencies =[];
		$http.post(BASE_URL+'api/user/getSchoolDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.result = response.data.data;
				
				$scope.schoolname 	= $scope.result.school_name;
				$scope.phone 		= $scope.result.phone;
				$scope.email 		= $scope.result.email;
				$scope.avgStudent 	= $scope.result.average_student;
				$scope.location 	= $scope.result.location;
				$scope.mission 		= $scope.result.mission;
				$scope.vision 		= $scope.result.vision;
				$scope.coreValues 	= $scope.result.core_values;
				$scope.avgStaff 	= $scope.result.average_staff;
				$scope.city 		= $scope.result.city;
				$scope.state 		= $scope.result.state;
                                $scope.countrycode 	= $scope.result.country;
				$scope.pincode 		= $scope.result.pincode;
				$scope.skypeid 		= $scope.result.skypeid;
				$scope.currency 	= $scope.result.currency;
				$scope.area 		= $scope.result.area;
				$scope.motto 		= $scope.result.motto;
				$scope.facebook 	= $scope.result.facebook;
				$scope.twitter 		= $scope.result.twitter;
				$scope.youtube 		= $scope.result.youtube;
				$scope.linkdin 		= $scope.result.linkdin;
				$scope.otherinfo 	= $scope.result.otherinfo;
				$scope.schoolType 	= $scope.result.schoolType;
				$scope.schoolTypeNew = $scope.schoolType;
				$scope.pic 			= $scope.result.pic;
				$scope.currencies	= $scope.result.currencies;
                                $scope.currency         = $scope.result.currency_id;
                                $scope.bank_name 	= $scope.result.bank_name;
				$scope.account_number   = $scope.result.account_number;
                                $scope.sort_code 	= $scope.result.sort_code;
                                $scope.sub_acc_number 	= $scope.result.sub_acc_number;
                                console.log($scope.countrycode);
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getSchoolDetails();
	$scope.updateProfileSchool = function()
	{
            
            if($scope.schoolname == '' || $scope.bank_name == ''  || $scope.sort_code == ''  || $scope.account_number == '' || $scope.sub_acc_number == ''  || $scope.currency == '' ||  $scope.email == '' || $scope.location == '' || $scope.phone == '' || $scope.schoolType == '')
            {
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill all required fields(Indicating With * Sign).'
				});
				return false;
			}();
			return false;
		}
            
		var oldSrc = '';
		var newSrc = '';
		var formData = new FormData();
		formData.append('schoolid', $scope.schoolID);
		formData.append('schoolname', $scope.schoolname);
		formData.append('email', $scope.email);
		formData.append('avgStudent', $scope.avgStudent);
		formData.append('location', $scope.location);
		formData.append('mission', $scope.mission);
		formData.append('vision', $scope.vision);
		formData.append('coreValues', $scope.coreValues);
		formData.append('phone', $scope.phone);
		formData.append('avgStaff', $scope.avgStaff);
		formData.append('city', $scope.city);
		formData.append('state', $scope.state);
                formData.append('country', $scope.countrycode);
		formData.append('pincode', $scope.pincode);
		formData.append('skypeid', $scope.skypeid);
		formData.append('area', $scope.area);
		formData.append('currency', $scope.currency);
		formData.append('motto', $scope.motto);
		formData.append('facebook', $scope.facebook);
		formData.append('twitter', $scope.twitter);
		formData.append('youtube', $scope.youtube);
		formData.append('linkdin', $scope.linkdin);
		formData.append('otherinfo', $scope.otherinfo);
		formData.append('schoolType', $scope.schoolType);
                formData.append('currency_id', $scope.currency);
                formData.append('bank_name', $scope.bank_name);
                formData.append('sort_code', $scope.sort_code);
                formData.append('account_number', $scope.account_number);
                formData.append('sub_acc_number', $scope.sub_acc_number);
                
		
		var files = document.getElementById('pic').files[0];
		formData.append('pic',files);
		//console.log(formData); return false;
		
		
		$http.post(BASE_URL+'api/user/updateProfileSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,
			}
			}).then(function(response) {
			
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Profile successfully Updated.'
				});
				$window.location.href = '#!/school-list';
				// $scope.getSchoolDetails();
				// return false;
			}();
			
            }, function errorCallback(){
			$scope.getSchoolDetails();
		});
	}
	
	$scope.removeProfilePic = function()
	{
		var oldSrc = '';
		var newSrc = '';
		
		var formData = {'photo':'default-profilePic.png','id':$scope.schoolID}
		
		$http.post(BASE_URL+'api/user/removeProfilePicSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,
			}
			}).then(function(response) {
			
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Profile Picture removed successfully.'
				});
				$scope.getSchoolDetails();
				return false;
			}();
			
            }, function errorCallback(){
			$scope.getSchoolDetails();
		});
		
	}
        
   $scope.countryCode = function()
    {
                var formData = {};
		
		$http.post(BASE_URL+'api/user/getCountryCode',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200){
                            $scope.countryCodes = response.data.data;
                        }},
                        function errorCallback(response){
				$scope.countryCodes = [];
                       }); 
                 
    }
    
    $scope.countryCode();    
	
}
function addSchoolCtrl($scope, $http, $window,schoolTypeListData) 
{
	$scope.schoolTypeList=schoolTypeListData;
	$scope.schoolname 	= '';
	$scope.phone 		= '';
	$scope.email 		= '';
	$scope.avgStudent 	= '';
	$scope.location 	= '';
	$scope.mission 		= '';
	$scope.vision 		= '';
	$scope.coreValues 	= '';
	$scope.avgStaff 	= '';
	$scope.city 		= '';
	$scope.state 		= '';
	$scope.pincode 		= '';
	$scope.skypeid 		= '';
	$scope.area 		= '';
	$scope.motto 		= '';
	$scope.facebook 	= '';
	$scope.twitter 		= '';
	$scope.youtube 		= '';
	$scope.linkdin 		= '';
	$scope.otherinfo 	= '';
	$scope.schoolType 	= '';
	$scope.schoolTypeNew = '';
	$scope.pic 	= '';
        $scope.countrycode = '';
        $scope.currency == '';
        $scope.bank_name == '';
        $scope.sort_code == '';
        $scope.account_number == '';
        
	
	
	$scope.addSchool = function(){
		
		if($scope.schoolname == '' || $scope.countrycode == '' ||  $scope.currency == ''  || $scope.bank_name == ''  || $scope.sort_code == ''  || $scope.account_number == ''  || $scope.email == '' || $scope.avgStudent == '' || $scope.location == '' || $scope.phone == '' || $scope.avgStaff == '' || $scope.city == '' || $scope.state == '' || $scope.pincode == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill all required fields.'
				});
				return false;
			}();
			return false;
		}
		
		var formData = new FormData();
		formData.append('schoolname', $scope.schoolname);
		formData.append('email', $scope.email);
		formData.append('avgStudent', $scope.avgStudent);
		formData.append('location', $scope.location);
		formData.append('mission', $scope.mission);
		formData.append('vision', $scope.vision);
		formData.append('coreValues', $scope.coreValues);
		formData.append('phone', $scope.phone);
		formData.append('avgStaff', $scope.avgStaff);
		formData.append('city', $scope.city);
		formData.append('state', $scope.state);
                formData.append('country', $scope.countrycode);
		formData.append('pincode', $scope.pincode);
		formData.append('skypeid', $scope.skypeid);
		formData.append('area', $scope.area);
		formData.append('motto', $scope.motto);
		formData.append('facebook', $scope.facebook);
		formData.append('twitter', $scope.twitter);
		formData.append('youtube', $scope.youtube);
		formData.append('linkdin', $scope.linkdin);
		formData.append('otherinfo', $scope.otherinfo);
		formData.append('schoolType', $scope.schoolType);
                formData.append('currency_id', $scope.currency);
                formData.append('bank_name', $scope.bank_name);
                formData.append('sort_code', $scope.sort_code);
                formData.append('account_number', $scope.account_number);
		
		var files = document.getElementById('pic').files[0];
		formData.append('pic',files);
		
		$http.post(BASE_URL+'api/user/addSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'School added successfully.'
				});
				$window.location.href = '#!/school-list';
				return false;
			}();
			
            }, function errorCallback(response){
			
			var errresult = response.data.message
			//console.log(response);
			if(errresult == 'Already Exists.')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Failed',
						text: 'Email already exist.'
					});
					
					return false;
				}();
			}
		});
	};
        
    $scope.countryCode = function()
    {
                var formData = {};
		
		$http.post(BASE_URL+'api/user/getCountryCode',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200){
                            $scope.countryCodes = response.data.data;
                        }},
                        function errorCallback(response){
				$scope.countryCodes = [];
                       }); 
                 
    }
    
    $scope.countryCode();
    
    $scope.currencies = [];
    $scope.getCountryCurrency = function(countryid)
    {
                var formData = {'countryid':countryid};
            	$http.post(BASE_URL+'api/user/getCountryCurrency',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200){
			$scope.currencies = response.data.data;
                   	}},
                        function errorCallback(response){
				$scope.currency = [];
                       }); 
    }
	
}

function profileCtrl($scope, $http) 
{
	$scope.opsw 		= '';
	$scope.npsw 		= '';
	$scope.name 	= '';
	$scope.email 		= '';
	$scope.phone 	= '';
	$scope.location 	= '';
	$scope.pic 	= '';
	$scope.errormsg 	= '';
	$scope.successmsg 	= '';
	
	$scope.getAdminDetails = function()
	{
		
		$http.get(BASE_URL+'api/user/getSubadminProfile',{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.result = response.data.data;				
				$scope.name 	= $scope.result.name;
				$scope.email 	= $scope.result.email;
				$scope.phone 	= $scope.result.phone;
				$scope.address 	= $scope.result.address;
				$scope.pic 	= $scope.result.pic;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	
	$scope.getAdminDetails();
	
	$scope.updateProfile = function()
	{
		var oldSrc = '';
		var newSrc = '';
		
		var formData = new FormData();
		formData.append('name', $scope.name);
		formData.append('email', $scope.email);
		formData.append('phone', $scope.phone);
		formData.append('address', $scope.address);
		
		var files = document.getElementById('pic').files[0];
		formData.append('pic',files);
		$http.post(BASE_URL+'api/user/updateProfileSubadmin',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,
			}
			}).then(function(response) {
			
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Profile successfully Updated.'
				});
				oldSrc = $('.profileImageHeader').attr("src");
				//var newSrc = $('.profilePic').attr("src");
				newSrc = BASE_URL+'img/admin/'+response.data.data.photo;
				if(newSrc != oldSrc)
				{
					$('img[src="' + oldSrc + '"]').attr('src', newSrc);
				}	
				
				$('.username').text(response.data.data.full_Name);
				$scope.getAdminDetails();
				return false;
			}();
			
            }, function errorCallback(){
			$scope.getAdminDetails();
		});
	}
	
	$scope.removeProfilePic = function()
	{
		var oldSrc = '';
		var newSrc = '';
		
		var formData = {'photo':'default-profilePic.png'}
		
		$http.post(BASE_URL+'api/user/removeProfilePicSubadmin',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,
			}
			}).then(function(response) {
			
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Profile Picture removed successfully.'
				});
				oldSrc = $('.profileImageHeader').attr("src");
				//var newSrc = $('.profilePic').attr("src");
				newSrc = BASE_URL+'img/admin/default-profilePic.png';
				if(newSrc != oldSrc)
				{
					$('img[src="' + oldSrc + '"]').attr('src', newSrc);
				}
				$scope.getAdminDetails();
				return false;
			}();
			
            }, function errorCallback(){
			$scope.getAdminDetails();
		});
		
	}
	
	$scope.changePassword = function()
	{
		if($scope.opsw == '')
		{
			$scope.errormsg = 'Old Password is required.';
			return false;
		}else if($scope.npsw == '')
		{
			$scope.errormsg = 'New Password is required.';
			return false;
		}
		var formData = {'opsw':$scope.opsw,'npsw':$scope.npsw}
		$http.post(BASE_URL+'api/user/changePasswordSubadmin',formData,{
			headers:{
				'Content-Type':'application/json',
                                'x-api-key':xapikey,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.result = response.data.data;
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: 'Password changed successfully.'
					});
					$scope.errormsg = '';
					return false;
				}();
			}
			
			}, function errorCallback(response){
			$scope.result = response.data.data;
			$scope.errormsg = 'Sorry! Your Password is not updated.';
			$scope.successmsg = '';
		});
		
		
	}
}

function changePasswordCtrl($scope, $http) 
{
	$scope.opsw 		= '';
	$scope.npsw 		= '';
	$scope.fullname 	= '';
	$scope.email 		= '';
	$scope.phonenumber 	= '';
	$scope.location 	= '';
	$scope.photo 	= '';
	$scope.errormsg 	= '';
	$scope.successmsg 	= '';
	
	$scope.getAdminDetails = function()
	{
		
		$http.get(BASE_URL+'api/user/getAdminDetails',{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.result = response.data.data;
				
				$scope.fullname 	= $scope.result.full_Name;
				$scope.email 		= $scope.result.email;
				$scope.phonenumber 	= $scope.result.phone_no;
				$scope.location 	= $scope.result.address;
				$scope.photo 		= $scope.result.photo;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	
	$scope.getAdminDetails();
	
	$scope.updateProfile = function()
	{
		var oldSrc = '';
		var newSrc = '';
		
		var formData = new FormData();
		formData.append('fullname', $scope.fullname);
		formData.append('email', $scope.email);
		formData.append('phonenumber', $scope.phonenumber);
		formData.append('location', $scope.location);
		
		var files = document.getElementById('pic').files[0];
		formData.append('pic',files);
		$http.post(BASE_URL+'api/user/updateProfileAdmin',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,
			}
			}).then(function(response) {
			
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Profile successfully Updated.'
				});
				oldSrc = $('.profileImageHeader').attr("src");
				//var newSrc = $('.profilePic').attr("src");
				newSrc = BASE_URL+'img/admin/'+response.data.data.photo;
				if(newSrc != oldSrc)
				{
					$('img[src="' + oldSrc + '"]').attr('src', newSrc);
				}	
				
				$('.username').text(response.data.data.full_Name);
				$scope.getAdminDetails();
				return false;
			}();
			
            }, function errorCallback(){
			$scope.getAdminDetails();
		});
	}
	
	$scope.removeProfilePic = function()
	{
		var oldSrc = '';
		var newSrc = '';
		
		var formData = {'photo':'default-profilePic.png'}
		
		$http.post(BASE_URL+'api/user/removeProfilePicAdmin',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,
			}
			}).then(function(response) {
			
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Profile Picture removed successfully.'
				});
				oldSrc = $('.profileImageHeader').attr("src");
				//var newSrc = $('.profilePic').attr("src");
				newSrc = BASE_URL+'img/admin/default-profilePic.png';
				if(newSrc != oldSrc)
				{
					$('img[src="' + oldSrc + '"]').attr('src', newSrc);
				}
				$scope.getAdminDetails();
				return false;
			}();
			
            }, function errorCallback(){
			$scope.getAdminDetails();
		});
		
	}
	
	$scope.changePassword = function()
	{
		if($scope.opsw == '')
		{
			$scope.errormsg = 'Old Password is required.';
			return false;
		}else if($scope.npsw == '')
		{
			$scope.errormsg = 'New Password is required.';
			return false;
		}
		var formData = {'opsw':$scope.opsw,'npsw':$scope.npsw}
		$http.post(BASE_URL+'api/user/changePasswordAdmin',formData,{
			headers:{
				'Content-Type':'application/json',
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.result = response.data.data;
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: 'Password changed successfully.'
					});
					$scope.errormsg = '';
					return false;
				}();
			}
			
			}, function errorCallback(response){
			$scope.result = response.data.data;
			$scope.errormsg = 'Sorry! Your Password is not updated.';
			$scope.successmsg = '';
		});
		
		
	}
}
function getAllGoalCtrl($scope, $http, $routeParams, $timeout, $window,$location) 
{
	$scope.encryptStr = function(id)
	{
		var qry = id.toString();
		var encrypted = CryptoJS.AES.encrypt(qry, "KidyView");
		var str = encrypted.toString();
		if(str.indexOf("/") == -1) {
			return str;
		}
		else{
			return $scope.encryptStr(id);
		}
		
	};
	$scope.pageSize = 10;
	
	$scope.getAllGoalsForSchool = function()
	{
		$scope.goalList = false;
		$http.get(BASE_URL+'api/user/getAllGoalsForSchool',{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.goalList = response.data.data;
				
				var encrypted ;
				for(var i = 0; i < $scope.goalList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.goalList[i].id);
					$scope.goalList[i]['goalID'] = encrypted;
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllGoalsForSchool();
	
	$scope.goalDelete = function(goalID)
	{
		var retn=1
		var checlPrivilege=JSON.parse(jsonPrivilege);
		if(checlPrivilege.length==0){
			var cnt=checlPrivilege.length;
		}else{
			var cnt=jsonPrivilege.length;
		}
		if(cnt>0){
			if(checlPrivilege.GoalsManagement['delete']==0){
				retn=0;
			}
		if(retn==0){
			var Gritter = function () {
				$.gritter.add({
					title: 'Error',
					text: 'You have not permiision fot this.'
				});
				return false;
			}();
			$location.path('#/')
			return false;
		} 
		}
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':goalID};
			$http.post(BASE_URL+'api/user/deleteGoal',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey
				}
				}).then(function(response) {
				
				if(response.status == 200)
				{
					var result  = response.data;
					var Gritter = function () {
						$.gritter.add({
							title: 'Successfull',
							text: 'Goal deleted successfully.'
						});
						
						$scope.getAllGoalsForSchool();
						return false;
					}();
				}
				
				}, function errorCallback(response){
				
			});
		}
	}
}
function addGoalCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.getAllSchools = function()
	{
		
		$http.get(BASE_URL+'api/user/getAllSchools',{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.schoolsListing = response.data.data;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllSchools();
	
	$scope.title 		= '';
	$scope.description 	= '';
	$scope.points 		= '';
	$scope.school 		= '';
	
	$scope.addGoal = function(){
		if($scope.title == '' || $scope.points == '' || $scope.school == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill all required fields(Indicating With * Sign).'
				});
				return false;
			}();
			return false;
		}						
		
		var formData = new FormData();
		formData.append('title', $scope.title);
		formData.append('description', $scope.description);
		formData.append('points', parseInt($scope.points));
		formData.append('school', parseInt($scope.school));
		
		$http.post(BASE_URL+'api/user/addGoal',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Goal added successfully.'
				});
				$window.location.href = '#!/goal-list';
				return false;
			}();
			
			}, function errorCallback(response){
		});
	};
}
function editGoalCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
	var sid;
	$scope.timelineID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.goalID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.goalID;
	};	
	$timeout($scope.setID(), 2000);
	
	$scope.getAllSchools = function()
	{
		
		$http.get(BASE_URL+'api/user/getAllSchools',{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.schoolsListing = response.data.data;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllSchools();
	
	$scope.goalinfo = false;
	$scope.getGoalDetails = function()
	{
		var formData = {'id':$scope.goalID}
		$http.post(BASE_URL+'api/user/getGoalDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.goalinfo 	= response.data.data;
				$scope.title 		= $scope.goalinfo.name;
				$scope.description 	= $scope.goalinfo.description;
				$scope.points 		= $scope.goalinfo.points;
				$scope.school 		= $scope.goalinfo.school_id;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getGoalDetails(); 
	
	$scope.editGoal = function(){
		
		if($scope.title == '' || $scope.points == '' || $scope.school == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill all required fields(Indicating With * Sign).'
				});
				return false;
			}();
			return false;
		}
		
		var formData = new FormData();
		formData.append('id', $scope.goalID);
		formData.append('title', $scope.title);
		formData.append('description', $scope.description);
		formData.append('points', parseInt($scope.points));
		formData.append('school', parseInt($scope.school));
		
		$http.post(BASE_URL+'api/user/editGoal',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Goal Updated successfully.'
				});
				$window.location.href = '#!/goal-list';
				return false;
			}();
			
			}, function errorCallback(response){
		});
	};
}
function getAllGiftCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.encryptStr = function(id)
	{
		var qry = id.toString();
		var encrypted = CryptoJS.AES.encrypt(qry, "KidyView");
		var str = encrypted.toString();
		if(str.indexOf("/") == -1) {
			return str;
		}
		else{
			return $scope.encryptStr(id);
		}
		
	};
	$scope.pageSize = 10;
	
	$scope.getAllGiftsForSchool = function()
	{
		$scope.giftList = false;
		$http.get(BASE_URL+'api/user/getAllGiftsForSchool',{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.giftList = response.data.data;
				
				var encrypted ;
				for(var i = 0; i < $scope.giftList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.giftList[i].id);
					$scope.giftList[i]['giftID'] = encrypted;
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllGiftsForSchool();
	
	$scope.giftDisabled = function(giftsID, status)
	{
		var formData1 = {'id':giftsID, 'status':status};
		$http.post(BASE_URL+'api/user/giftDisabled',formData1,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				var result  = response.data;
				var Gritter = function () {
					if(status == 0)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'Gift Status Disabled Now.'
						});
					}else if(status == 1)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'Gift Status Enabled Now.'
						});
					}
					
					$scope.getAllGiftsForSchool();
					return false;
				}();
			}
			
			}, function errorCallback(response){
			
		});
		
	}
}
function addGiftCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.title 		= '';
	$scope.description 	= '';
	$scope.points 		= '';
	$scope.amount 		= '';
	$scope.brand 		= '';
	$scope.pic 			= '';
	$scope.quantity 	= '';
	$scope.discount_type= '';
	$scope.discount 	= '';
	
	$scope.onChange = function (files) {
		if(files[0] == undefined) return;
		$scope.fileExt = files[0].name.split(".").pop();
	}
	$scope.isImage = function(ext) {
		if(ext) {
			return ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png";
		}
	}
	$scope.addGift = function(){

		if($scope.discount_type==''){
			$scope.discount_value='';
		}
		if($scope.quantity == '' || $scope.title == '' || $scope.points == '' || $scope.amount == '' || $scope.brand == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill all required fields(Indicating With * Sign).'
				});
				return false;
			}();
			return false;
		}	
		if($scope.discount_type!='' && $scope.discount_value==''){
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Discount value required.'
				});
				return false;
			}();
			return false;
		}					
		var formData = new FormData();
		formData.append('title', $scope.title);
		formData.append('description', $scope.description);
		formData.append('points', $scope.points);
		formData.append('amount', $scope.amount);
		formData.append('brand', $scope.brand);
		formData.append('quantity', $scope.quantity);
		formData.append('discount_type', $scope.discount_type);
		formData.append('discount_value', $scope.discount_value);
		
		var files = document.getElementById('pic').files[0];
		formData.append('pic',files);
		
		$http.post(BASE_URL+'api/user/addGift',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data.data;
			if(result == 'exist'){
					var Gritter = function () {
						$.gritter.add({
							title: 'Failed',
							text: 'Gift code already exist. Please try again !!'
						});
						$window.location.href = '#!/gift-list';
						return false;
					}();
			}else{
				var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Gift added successfully.'
				});
					$window.location.href = '#!/gift-list';
					return false;
				}();	
			}

			
			
			}, function errorCallback(response){
		});
	};
}
function editGiftCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
	var sid;
	$scope.timelineID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.giftID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.giftID;
	};	
	$timeout($scope.setID(), 2000);
	
	$scope.giftinfo = false;
	$scope.getGiftDetails = function()
	{
		var formData = {'id':$scope.giftID}
		$http.post(BASE_URL+'api/user/getGiftDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.giftinfo 	= response.data.data;
				$scope.title 		= $scope.giftinfo.name;
				$scope.description 	= $scope.giftinfo.description;
				$scope.points 		= $scope.giftinfo.points;
				$scope.amount 		= $scope.giftinfo.amount;
				$scope.brand 		= $scope.giftinfo.brand;
				$scope.photo 			= $scope.giftinfo.image;
				$scope.discount_type = $scope.giftinfo.discount_type;
				$scope.discount_value = $scope.giftinfo.discount_value;
				$scope.quantity 	= $scope.giftinfo.quantity;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getGiftDetails(); 
	$scope.imgPrev='';
	$scope.onChange = function (files) {
		$scope.imgPrev=files;
		if(files[0] == undefined) return;
		$scope.fileExt = files[0].name.split(".").pop();
	}
	$scope.isImage = function(ext) {
		if(ext) {
			return ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png";
		}
	}
	if($scope.discount_type==''){
		$scope.discount_value='';
	}
	$scope.editGift = function(){
		
		if($scope.quantity == '' || $scope.title == '' || $scope.points == '' || $scope.amount == '' || $scope.brand == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill all required fields(Indicating With * Sign).'
				});
				return false;
			}();
			return false;
		}	
		if($scope.discount_type!='' && $scope.discount_value==''){
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Discount value required.'
				});
				return false;
			}();
			return false;
		}	

		var formData = new FormData();
		formData.append('id', $scope.giftID);
		formData.append('title', $scope.title);
		formData.append('description', $scope.description);
		formData.append('points', $scope.points);
		formData.append('amount', $scope.amount);
		formData.append('brand', $scope.brand);
		formData.append('quantity', $scope.quantity);
		formData.append('discount_type', $scope.discount_type);
		formData.append('discount_value', $scope.discount_value);
		
		var files = document.getElementById('pic').files[0];
		formData.append('pic',files);
		
		$http.post(BASE_URL+'api/user/editGift',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Gift edited successfully.'
				});
				$window.location.href = '#!/gift-list';
				return false;
			}();
			
			}, function errorCallback(response){
		});
	};
}

function getAllRoleCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.roleDelete = function(eventID)
	{
		var retn=1
		var checlPrivilege=JSON.parse(jsonPrivilege);
		if(checlPrivilege.length==0){
			var cnt=checlPrivilege.length;
		}else{
			var cnt=jsonPrivilege.length;
		}
		
		if(cnt>0){
			if(checlPrivilege.RoleManagement['delete']==0){
				retn=0;
			}
		if(retn==0){
			var Gritter = function () {
				$.gritter.add({
					title: 'Error',
					text: 'You have not permiision fot this.'
				});
				return false;
			}();
			$location.path('#/')
			return false;
		} 
		}
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':eventID};
			$http.post(BASE_URL+'api/user/deleteRole',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey
				}
				}).then(function(response) {
				
				if(response.status == 200)
				{
					var result  = response.data;
					var Gritter = function () {
						$.gritter.add({
							title: 'Successfull',
							text: 'Role deleted successfully.'
						});
						
						$scope.getAllRoleForSchool();
						return false;
					}();
				}
				
				}, function errorCallback(response){

				var errresult = response.data.message
				if(errresult == 'Already Asign')
				{
				var Gritter = function () {
				$.gritter.add({
					title: 'Error',
					text: "This Role asign to a user.You can't delete this."
				});
				return false;
				}();
				}
			});
		}
	}
	$scope.roleDisabled = function(roleID, status)
	{
		
		var formData1 = {'id':roleID, 'status':status};
		$http.post(BASE_URL+'api/user/roleDisabled',formData1,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				var result  = response.data;
				var Gritter = function () {
					if(status == 0)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'Role Status Disabled Now.'
						});
					}else if(status == 1)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'Role Status Enabled Now.'
						});
					}
					
					$scope.getAllRoleForSchool();
					return false;
				}();
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	
	$scope.encryptStr = function(id)
	{
		var qry = id.toString();
		var encrypted = CryptoJS.AES.encrypt(qry, "KidyView");
		var str = encrypted.toString();
		if(str.indexOf("/") == -1) {
			return str;
		}
		else{
			return $scope.encryptStr(id);
		}
		
	};
	$scope.pageSize = 10;
	$scope.getAllRoleForSchool = function()
	{
		$scope.roleList = false;
		var formData = {'id':''};
		$http.post(BASE_URL+'api/user/getAllRoleForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.roleList = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.roleList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.roleList[i].id);
					$scope.roleList[i]['roleID'] = encrypted;
				}
			}
			
			}, function errorCallback(response){
			$scope.roleList=[];
		});
		
	}
	$scope.getAllRoleForSchool();
	$scope.sort = function(keyname){
		$scope.sortKey = keyname;
		$scope.reverse = !$scope.reverse;
	}
	
	
}
function addRoleCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.name 	= '';
	$scope.addRole = function(){
		if($scope.name == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill all required fields(Indicating With * Sign).'
				});
				return false;
			}();
			return false;
		}
		
		var formData = new FormData();
		formData.append('name', $scope.name);
		formData.append('schoolId', '');
		
		$http.post(BASE_URL+'api/user/addRole',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Role added successfully.'
				});
				$window.location.href = '#!/role-list';
				return false;
			}();
			
			}, function errorCallback(response){
		});
	};
	
}


function editRoleCtrl($scope, $http, $routeParams, $timeout,$window) 
{
	$scope.sort = function(keyname){
		$scope.sortKey = keyname;
		$scope.reverse = !$scope.reverse;
	}
	
	var sid;
	$scope.roleID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.roleID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.roleID;
	};	
	$timeout($scope.setID(), 2000);
	//alert($scope.classID); return false;
	$scope.roleinfo = false;
	$scope.name 	= '';
	$scope.getRoleDetails = function()
	{
		var formData = {'id':$scope.roleID}
		$http.post(BASE_URL+'api/user/getRoleDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.roleinfo = response.data.data;
				$scope.name  = $scope.roleinfo.name;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getRoleDetails();
	
	$scope.editRole = function(){
		
		if($scope.name == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill all required fields(Indicating With * Sign).'
				});
				return false;
			}();
			return false;
		}
		var formData = new FormData();
		//alert($scope.roleID);
		formData.append('id', $scope.roleID);
		formData.append('name', $scope.name);
		formData.append('schoolId', '');
		$http.post(BASE_URL+'api/user/editRole',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Role Updated successfully.'
				});
				$window.location.href = '#!/role-list';
				return false;
			}();
			
			}, function errorCallback(response){
			
			var errresult = response.data.message
			if(errresult == 'Role Already Exists.')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: 'This Role Already Exists.'
					});
					$scope.getRoleDetails();
					return false;
				}();
			}
		});
	};
	
}
function getAllPrivilegeCtrl($scope, $http, $routeParams, $timeout, $window,$location) 
{
	$scope.encryptStr = function(id)
	{
		var qry = id.toString();
		var encrypted = CryptoJS.AES.encrypt(qry, "KidyView");
		var str = encrypted.toString();
		if(str.indexOf("/") == -1) {
			return str;
		}
		else{
			return $scope.encryptStr(id);
		}
		
	};
	$scope.pageSize = 10;
	$scope.getAllPrivilegeForSchool = function()
	{
		$scope.privilegeList = false;
		var formData = {'id':''};
		$http.post(BASE_URL+'api/user/getAllPrivilegeForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.privilegeList = response.data.data;
				//console.log($scope.privilegeList);
				var encrypted ;
				for(var i = 0; i < $scope.privilegeList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.privilegeList[i].role_id);
					$scope.privilegeList[i]['privilegeID'] = encrypted;
				}
			}
			
			}, function errorCallback(response){
			$scope.privilegeList=[];
		});
		
	}
	$scope.getAllPrivilegeForSchool();
	$scope.sort = function(keyname){
		$scope.sortKey = keyname;
		$scope.reverse = !$scope.reverse;
	}
	
	$scope.privilegeDelete = function(eventID)
	{
		var retn=1
		var checlPrivilege=JSON.parse(jsonPrivilege);
		if(checlPrivilege.length==0){
			var cnt=checlPrivilege.length;
		}else{
			var cnt=jsonPrivilege.length;
		}
		if(cnt>0){
			if(checlPrivilege.PrivilegeManagement['delete']==0){
				retn=0;
			}
		if(retn==0){
			var Gritter = function () {
				$.gritter.add({
					title: 'Error',
					text: 'You have not permiision fot this.'
				});
				return false;
			}();
			$location.path('#/')
			return false;
		} 
		}
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':eventID};
			$http.post(BASE_URL+'api/user/deletePrivilege',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey
				}
				}).then(function(response) {
				
				if(response.status == 200)
				{
					var result  = response.data;
					var Gritter = function () {
						$.gritter.add({
							title: 'Successfull',
							text: 'Privilege deleted successfully.'
						});
						
						$scope.getAllPrivilegeForSchool();
						return false;
					}();
				}
				
				}, function errorCallback(response){
				
			});
		}
	}	
}
function addPrivilegeCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.checlAllPrivilege=function(moduleData){
		if(moduleData.view==1 || moduleData.add==1 || moduleData.edit==1 || moduleData.delete==1){
			moduleData.view='0';
			moduleData.add='0';
			moduleData.edit='0';
			moduleData.delete='0';
			}else{
			moduleData.view=1;
			moduleData.add=1;
			moduleData.edit=1;
			moduleData.delete=1;
		}	
	}
	$scope.getAllPermissionModuleForSchool = function()
	{
		$scope.permissionRoleList = false;
		var formData = {'id':''};
		$http.post(BASE_URL+'api/user/getAllPermissionModuleForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.permissionRoleList = response.data.data;
				for(var i = 0; i < $scope.permissionRoleList.length; i++)
				{
					
					$scope.permissionRoleList[i]['view'] = 0;
					$scope.permissionRoleList[i]['add'] = 0;
					$scope.permissionRoleList[i]['edit'] = 0;
					$scope.permissionRoleList[i]['delete'] = 0;
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllPermissionModuleForSchool();
	
	$scope.getAllActiveRoleForSchool = function()
	{
		$scope.activeRoleList = false;
		var formData = {'id':''};
		$http.post(BASE_URL+'api/user/getAllActiveRoleForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.activeRoleList = response.data.data;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllActiveRoleForSchool();
	$scope.role 	= '';
	
	$scope.addPrivilege = function(){
		if($scope.role == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill all required fields(Indicating With * Sign).'
				});
				return false;
			}();
			return false;
		}
		
		var formData = new FormData();
		formData.append('role_id', $scope.role);
		formData.append('permissionData', JSON.stringify($scope.permissionRoleList));
		formData.append('schoolId', '');
		$http.post(BASE_URL+'api/user/addPrivilege',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			//console.log(response);
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Privilege added successfully.'
				});
				$window.location.href = '#!/privilege-list';
				return false;
			}();
			
			}, function errorCallback(response){
		});
	};
	
}


function editPrivilegeCtrl($scope, $http, $routeParams, $timeout,$window) 
{
	$scope.checlAllPrivilege=function(moduleData){
		if(moduleData.view=='1' || moduleData.add=='1' || moduleData.edit=='1'  || moduleData.delete=='1'){
			moduleData.view='0';
			moduleData.add='0';
			moduleData.edit='0';
			moduleData.delete='0';
			}else{
			moduleData.view='1';
			moduleData.add='1';
			moduleData.edit='1';
			moduleData.delete='1';
		}	
	}
	
	$scope.getAllActiveRoleForSchool = function()
	{
		$scope.activeRoleList = false;
		var formData = {'id':'','isEdit':1};
		$http.post(BASE_URL+'api/user/getAllActiveRoleForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.activeRoleList = response.data.data;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllActiveRoleForSchool();
	$scope.sort = function(keyname){
		$scope.sortKey = keyname;
		$scope.reverse = !$scope.reverse;
	}
	
	var sid;
	$scope.privilegeID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.privilegeID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.privilegeID;
	};	
	$timeout($scope.setID(), 2000);
	//alert($scope.classID); return false;
	$scope.privilegeinfo = false;
	$scope.role 	= '';
	$scope.getPrivilegeDetails = function()
	{
		var formData = {'id':$scope.privilegeID}
		$http.post(BASE_URL+'api/user/getPrivilegeDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.privilegeinfo = response.data.data;
				$scope.permissionRoleList=$scope.privilegeinfo;
				$scope.role  = $scope.privilegeID;
				//console.log($scope.permissionRoleList);
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getPrivilegeDetails();

	$scope.editPrivilege = function(){
		
		var formData = new FormData();
		formData.append('role_id', $scope.role);
		formData.append('permissionData', JSON.stringify($scope.permissionRoleList));
		formData.append('schoolId', '');
		$http.post(BASE_URL+'api/user/editPrivilege',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Privilege Updated successfully.'
				});
				$window.location.href = '#!/privilege-list';
				return false;
			}();
			
			}, function errorCallback(response){
			
			var errresult = response.data.message
			if(errresult == 'Role Already Exists.')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: 'This Role Already Exists.'
					});
					$scope.getRoleDetails();
					return false;
				}();
			}
		});
	};
}


function getAllSubadminCtrl($scope, $http, $routeParams, $timeout,$window,$location) 
{
	$scope.encryptStr = function(id)
	{
		var qry = id.toString();
		var encrypted = CryptoJS.AES.encrypt(qry, "KidyView");
		var str = encrypted.toString();
		if(str.indexOf("/") == -1) {
			return str;
		}
		else{
			return $scope.encryptStr(id);
		}
		
	};
	$scope.getAllSubadminForSchool = function()
	{
		var formData = {'schoolId':''}
		$http.post(BASE_URL+'api/user/getAllSubadminForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.subadminList = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.subadminList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.subadminList[i].id);
					$scope.subadminList[i]['subadminID'] = encrypted;
				}
			}
			
			}, function errorCallback(response){
			
		});
	}	
	$scope.getAllSubadminForSchool();
	
	$scope.sort = function(keyname){
		$scope.sortKey = keyname;
		$scope.reverse = !$scope.reverse;
	}
	$scope.pageSize = 10;
	
	$scope.subadminDisabled = function(subadminID, status)
	{
		
		var formData1 = {'id':subadminID, 'status':status};
		$http.post(BASE_URL+'api/user/subadminDisabled',formData1,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				var result  = response.data;
				var Gritter = function () {
					if(status == 0)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'Parent Status Disabled Now.'
						});
					}else if(status == 1)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'Parent Status Enabled Now.'
						});
					}
					
					$scope.getAllSubadminForSchool();
					return false;
				}();
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	
	$scope.subadminDelete = function(eventID)
	{
		var retn=1
		var checlPrivilege=JSON.parse(jsonPrivilege);
		if(checlPrivilege.length==0){
			var cnt=checlPrivilege.length;
		}else{
			var cnt=jsonPrivilege.length;
		}
		if(cnt>0){
			if(checlPrivilege.SuperSubAdmin['delete']==0){
				retn=0;
			}
		if(retn==0){
			var Gritter = function () {
				$.gritter.add({
					title: 'Error',
					text: 'You have not permiision fot this.'
				});
				return false;
			}();
			$location.path('#/')
			return false;
		} 
	}
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':eventID};
			$http.post(BASE_URL+'api/user/deleteSubadmin',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey
				}
				}).then(function(response) {
				
				if(response.status == 200)
				{
					var result  = response.data;
					var Gritter = function () {
						$.gritter.add({
							title: 'Successfull',
							text: 'Sub admin deleted successfully.'
						});
						
						$scope.getAllSubadminForSchool();
						return false;
					}();
				}
				
				}, function errorCallback(response){
				
			});
		}
	}	
	
}
function allSubadminCtrl($scope, $http, $routeParams, $timeout) 
{
	var sid;
	$scope.subadminID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.subadminID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.subadminID;
	};	
	$timeout($scope.setID(), 2000);
	$scope.subadmininfo = false;
	$scope.getSubadminDetails = function()
	{
		var formData = {'id':$scope.subadminID}
		$http.post(BASE_URL+'api/user/getSUbadminDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.subadmininfoinfo = response.data.data;
				$scope.name			= $scope.subadmininfoinfo.name;
				$scope.role			= $scope.subadmininfoinfo.role_id;
				$scope.email		= $scope.subadmininfoinfo.email;
				$scope.designation	= $scope.subadmininfoinfo.designation;
				$scope.phone		= $scope.subadmininfoinfo.phone;
				$scope.pics			= $scope.subadmininfoinfo.pic;
				$scope.address		= $scope.subadmininfoinfo.address;
				$scope.city			= $scope.subadmininfoinfo.city;
				$scope.state		= $scope.subadmininfoinfo.state;
				$scope.country		= $scope.subadmininfoinfo.country;
				$scope.pincode		= $scope.subadmininfoinfo.pincode;
				$scope.otherinfo	= $scope.subadmininfoinfo.otherinfo;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getSubadminDetails();
	
}
function addSubadminCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
	$scope.getAllActiveRoleForSchool = function()
	{
		$scope.roleList = false;
		var formData = {'id':''};
		$http.post(BASE_URL+'api/user/getAllRoleForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.roleList = response.data.data;
				$scope.activeRoleList=[];
				for(var i = 0; i < $scope.roleList.length; i++)
				{
					
					if($scope.roleList[i].status==1){
						$scope.activeRoleList.push({ 
							'id':$scope.roleList[i].id,
							'name':$scope.roleList[i].name
						});
					}
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllActiveRoleForSchool();
	$scope.name 			= '';
	$scope.email 			= '';
	$scope.password 		= '';
	$scope.confirmpassword 	= '';
	$scope.designation 		= '';
	$scope.phone 			= '';
	$scope.address 			= '';
	$scope.city 			= '';
	$scope.state 			= '';
	$scope.pincode 			= '';
	$scope.country 			= '';
	$scope.photo 			= '';
	$scope.otherinfo 		= '';
	$scope.role 			= '';
	
	
	$scope.onChange = function (files) {
		if(files[0] == undefined) return;
		$scope.fileExt = files[0].name.split(".").pop();
	}
	$scope.isImage = function(ext) {
		if(ext) {
			return ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png";
		}
	}
	
	$scope.getAutoSuggesions = function(googleMapId)
	{
		//alert('scv');
		var placeSearch, autocomplete;
		var componentForm = {};
		
		var autocompleteFrom;
		componentForm[googleMapId + 'locality'] 					= 'long_name';
		componentForm[googleMapId + 'administrative_area_level_1'] 	= 'short_name';
		componentForm[googleMapId + 'country'] 						= 'long_name';
		componentForm[googleMapId + 'postal_code'] 					= 'short_name';
		
		autocomplete = new google.maps.places.Autocomplete(
		document.getElementById(googleMapId), {types: ['geocode']});
		
		autocomplete.setFields(['address_component']);
		
		autocomplete.addListener('place_changed', function() {
			var place = this.getPlace();
			//var places = autocomplete.getPlace();
			$scope.$apply()
			//console.log(places.formatted_address);
			for (var component in componentForm) {
				document.getElementById(component).value = '';
				document.getElementById(component).disabled = false;
			}
			for (var i = 0; i < place.address_components.length; i++) {
				var addressType = place.address_components[i].types[0];
				var lastaddressType = googleMapId + addressType;
				//alert(lastaddressType);
				if (componentForm[lastaddressType]) {
					var val = place.address_components[i][componentForm[lastaddressType]];
					document.getElementById(lastaddressType).value = val;
					var element = document.getElementById(lastaddressType);
					var event = new Event('change');
					element.dispatchEvent(event);
				}
			}
			
		});
	}
	
	$scope.addSubadmin = function(){
		
		if($scope.role =='' || $scope.name == '' || $scope.email == '' || $scope.designation == '' || $scope.phone == '' || $scope.password == ''|| $scope.confirmpassword == '' || $scope.address == '' )
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill all required fields(Indicating With * Sign).'
				});
				return false;
			}();
			return false;
		}
		$scope.address 			= $('#address').val();
		var formData = new FormData();
		formData.append('schoolId', '');
		formData.append('role_id', $scope.role);
		formData.append('name', $scope.name);
		formData.append('email', $scope.email);
		formData.append('password', $scope.password);
		formData.append('designation', $scope.designation);
		formData.append('phone', $scope.phone);
		formData.append('address', $scope.address);
		formData.append('city', $scope.city);
		formData.append('state', $scope.state);
		formData.append('pincode', $scope.pincode);
		formData.append('country', $scope.country);
		formData.append('otherinfo', $scope.otherinfo);
		
		
		var files1 = document.getElementById('pic').files[0];
		formData.append('pic',files1);
		$http.post(BASE_URL+'api/user/addSubadmin',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Sub Admin added successfully.'
				});
				$window.location.href = '#!/subadmin-list';
				return false;
			}();
			
            }, function errorCallback(response){
			
			var errresult = response.data.message

			if(errresult == 'Already Email Exists.')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Failed',
						text: 'Email already exist.'
					});
					
					return false;
				}();
			}
			if(errresult == 'Already Phone Exists.')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Failed',
						text: 'Phone already exist.'
					});
					
					return false;
				}();
			}
		});
	};
}
function editSubadminCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.getAllActiveRoleForSchool = function()
	{
		$scope.roleList = false;
		var formData = {'id':''};
		$http.post(BASE_URL+'api/user/getAllRoleForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.roleList = response.data.data;
				$scope.activeRoleList=[];
				for(var i = 0; i < $scope.roleList.length; i++)
				{
					
					if($scope.roleList[i].status==1){
						$scope.activeRoleList.push({ 
							'id':$scope.roleList[i].id,
							'name':$scope.roleList[i].name
						});
					}
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllActiveRoleForSchool();
	var sid;
	$scope.subadminID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.subadminID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.subadminID;
	};	
	$timeout($scope.setID(), 2000);
	//alert($scope.parentID); return false;
	$scope.subadmininfoinfo = false;
	
	
	
	$scope.getSubadminDetails = function()
	{
		var formData = {'id':$scope.subadminID}
		$http.post(BASE_URL+'api/user/getSubadminDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.subadmininfoinfo = response.data.data;
				$scope.name			= $scope.subadmininfoinfo.name;
				$scope.role			= $scope.subadmininfoinfo.role_id;
				$scope.email		= $scope.subadmininfoinfo.email;
				$scope.designation	= $scope.subadmininfoinfo.designation;
				$scope.phone		= $scope.subadmininfoinfo.phone;
				$scope.pics			= $scope.subadmininfoinfo.pic;
				$scope.address		= $scope.subadmininfoinfo.address;
				$scope.city			= $scope.subadmininfoinfo.city;
				$scope.state		= $scope.subadmininfoinfo.state;
				$scope.country		= $scope.subadmininfoinfo.country;
				$scope.pincode		= $scope.subadmininfoinfo.pincode;
				$scope.otherinfo	= $scope.subadmininfoinfo.otherinfo;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getSubadminDetails();
	
	$scope.getAutoSuggesions = function(googleMapId)
	{
		var placeSearch, autocomplete;
		var componentForm = {};
		componentForm[googleMapId + 'locality'] 					= 'long_name';
		componentForm[googleMapId + 'administrative_area_level_1'] 	= 'short_name';
		componentForm[googleMapId + 'country'] 						= 'long_name';
		componentForm[googleMapId + 'postal_code'] 					= 'short_name';
		autocomplete = new google.maps.places.Autocomplete(
		document.getElementById(googleMapId), {types: ['geocode']});
		
		autocomplete.setFields(['address_component']);
		
		autocomplete.addListener('place_changed', function() {
			var place = this.getPlace();
			for (var component in componentForm) {
				document.getElementById(component).value = '';
				document.getElementById(component).disabled = false;
			}
			for (var i = 0; i < place.address_components.length; i++) {
				var addressType = place.address_components[i].types[0];
				var lastaddressType = googleMapId + addressType;
				if (componentForm[lastaddressType]) {
					var val = place.address_components[i][componentForm[lastaddressType]];
					document.getElementById(lastaddressType).value = val;
					var element = document.getElementById(lastaddressType);
					var event = new Event('change');
					element.dispatchEvent(event);
				}
			}
			
		});
	}
	$scope.convertDateNewFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [date.getFullYear(), mnth, day].join("-");
	}
	$scope.name 			= '';
	$scope.email 			= '';
	$scope.password 		= '';
	$scope.confirmpassword 	= '';
	$scope.designation 		= '';
	$scope.phone 			= '';
	$scope.address 			= '';
	$scope.city 			= '';
	$scope.state 			= '';
	$scope.pincode 			= '';
	$scope.country 			= '';
	$scope.pics 			= '';
	$scope.otherinfo 		= '';
	$scope.role 			= '';
	$scope.onChange = function (files) {
		if(files[0] == undefined) return;
		$scope.fileExt = files[0].name.split(".").pop();
	}
	$scope.isImage = function(ext) {
		if(ext) {
			return ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png";
		}
	}
	
	
	$scope.editSubadmin = function(){
		if($scope.role =='' || $scope.name == '' || $scope.email == '' || $scope.designation == '' || $scope.phone == '' || $scope.address == '' )
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill all required fields(Indicating With * Sign).'
				});
				return false;
			}();
			return false;
		}
		$scope.address 			= $('#address').val();
		var formData = new FormData();
		formData.append('schoolId', '');
		formData.append('subadminID', $scope.subadminID);
		formData.append('role_id', $scope.role);
		formData.append('name', $scope.name);
		formData.append('email', $scope.email);
		formData.append('password', $scope.password);
		formData.append('designation', $scope.designation);
		formData.append('phone', $scope.phone);
		formData.append('address', $scope.address);
		formData.append('city', $scope.city);
		formData.append('state', $scope.state);
		formData.append('pincode', $scope.pincode);
		formData.append('country', $scope.country);
		formData.append('otherinfo', $scope.otherinfo);
		formData.append('photo', $scope.pics);
		var files1 = document.getElementById('pic').files[0];
		formData.append('pic',files1);
		
		$http.post(BASE_URL+'api/user/editSubadmin',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Subadmin Updated successfully.'
				});
				$window.location.href = '#!/subadmin-list';
				return false;
			}();
			
            }, function errorCallback(response){
			var errresult = response.data.message
			if(errresult == 'Already Email Exists.')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Failed',
						text: 'Email already exist.'
					});
					
					return false;
				}();
			}
			if(errresult == 'Already Phone Exists.')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Failed',
						text: 'Phone already exist.'
					});
					
					return false;
				}();
			}
		});
	};
	
}

function TeacherDetailCtrl($scope, $http, $routeParams, $timeout, $window) {
    var sid;
	$scope.teacherID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.teacherID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.teacherID;
	};	
	$timeout($scope.setID(), 2000);
	//alert($scope.teacherID); return false;
	$scope.teacherinfo = false;
	$scope.getTeacherDetails = function()
	{
		var formData = {'id':$scope.teacherID}
		$http.post(BASE_URL+'api/user/getTeacherDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.teacherinfo 		= response.data.data;
				$scope.teacherfname		= $scope.teacherinfo.teacherfname;
				$scope.teachermname		= $scope.teacherinfo.teachermname;
				$scope.teacherlname		= $scope.teacherinfo.teacherlname;
				$scope.teacheremail		= $scope.teacherinfo.teacheremail;
				$scope.teacherphone		= $scope.teacherinfo.teacherphone;
				$scope.teachergender	= $scope.teacherinfo.teachergender;
				$scope.teacheraddress	= $scope.teacherinfo.teacheraddress;
				$scope.teacherphoto		= $scope.teacherinfo.teacherphoto;
				$scope.maritalStatus	= $scope.teacherinfo.maritalStatus;
				$scope.spousename		= $scope.teacherinfo.spousename;
				$scope.date_of_joining	= $scope.teacherinfo.date_of_joining;
				$scope.bloodgroup		= $scope.teacherinfo.bloodgroup;
				$scope.religion			= $scope.teacherinfo.religion;
				$scope.schoolType		= $scope.teacherinfo.schoolType;
				$scope.subjectteacher	= $scope.teacherinfo.subjectteacher;
				$scope.certificate		= $scope.teacherinfo.certificate;
				$scope.document			= $scope.teacherinfo.document;
				$scope.workexperience	= $scope.teacherinfo.workexperience;
				$scope.classes			= $scope.teacherinfo.class;
				$scope.qualifications	= $scope.teacherinfo.qualifications;
				var arr = $scope.schoolType.split(',');
				$scope.schoolTypeArr = arr;
				$scope.date_of_joining = $scope.convertDateFormat($scope.date_of_joining);
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getTeacherDetails();
	
	$scope.convertDateFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [day, mnth, date.getFullYear()].join("-");
	}
}
function TeacherListCtrl($scope, $http, $routeParams, $timeout, $window) {
    $scope.schoolList = [];
    $scope.dataList = [];
    $scope.school_id = 0;
    $scope.encryptStr = function(id)
    {
        var qry = id.toString();
        var encrypted = CryptoJS.AES.encrypt(qry, "KidyView");
        var str = encrypted.toString();
        if(str.indexOf("/") == -1) {
                return str;
        }
        else{
                return $scope.encryptStr(id);
        }
    };

    $scope.getAllSchools = function()
    {
        $http.get(BASE_URL+'api/user/getAllSchoolsForSchoolMngt',{
            headers:{
                'Content-Type':undefined, 'x-api-key':xapikey,
            }
            }).then(function(response) {

            if(response.status == 200)
            {
                $scope.schoolList = response.data.data;                
            }
            }, function errorCallback(response){
        });
    }
    $scope.getAllSchools();
    $scope.getData = function()
    {
        $http.get(BASE_URL+'api/teacher?school_id='+$scope.school_id,{
            headers:{
                'Content-Type':undefined, 'x-api-key':xapikey,
            }
            }).then(function(response) {

            if(response.status == 200)
            {
                $scope.dataList = response.data.data;
                var encrypted ;
                for(var i = 0; i < $scope.dataList.length; i++)
                {
                    encrypted = $scope.encryptStr($scope.dataList[i].id);
                    $scope.dataList[i]['teacherID'] = encrypted;
                }
            }
            }, function errorCallback(response){
        });
    }
    //$scope.getData();
    
}

function DriverDetailCtrl($scope, $http, $routeParams, $timeout, $window) {
    var sid;
    $scope.driverID = '';
    $scope.setID = function(){
            var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
            $scope.driverID = decrypted.toString(CryptoJS.enc.Utf8);
            sid = $scope.driverID;
    };	
    $timeout($scope.setID(), 2000);
    //alert($scope.driverID); return false;
    $scope.driverinfo = false;
    $scope.getDriverDetails = function()
    {
            var formData = {'id':$scope.driverID}
            $http.post(BASE_URL+'api/user/getDriverDetails',formData,{
                    headers:{
                            'Content-Type':undefined, 'x-api-key':xapikey
                    }
                    }).then(function(response) {

                    if(response.status == 200)
                    {
                            $scope.driverinfo = response.data.data;

                            $scope.driverfname 	  		= $scope.driverinfo.driverfname;
                            $scope.driverlname 			= $scope.driverinfo.driverlname;
                            $scope.driveremail 			= $scope.driverinfo.driveremail;
                            $scope.driverphone 			= $scope.driverinfo.driverphone;
                            $scope.driverdeviceId 		= $scope.driverinfo.driverdeviceId;
                            $scope.drivervehicle 		= $scope.driverinfo.driverVechiclenumber;
                            $scope.driverroute 			= $scope.driverinfo.driverroute;
                            $scope.driverlicense 		= $scope.driverinfo.driverlicense;
                            $scope.driverLicenseExpire 	= $scope.driverinfo.driverLicenseExpire;
                            $scope.driverphoto 			= $scope.driverinfo.driverphoto;
                            $scope.driverdocument 		= $scope.driverinfo.driverdocument;
                            $scope.driveraddress 		= $scope.driverinfo.driveraddress;
                            $scope.dpincode 			= $scope.driverinfo.dpincode;
                            $scope.dcity 				= $scope.driverinfo.dcity;
                            $scope.dstate 				= $scope.driverinfo.dstate;
                            $scope.dcountry 			= $scope.driverinfo.dcountry;
                            $scope.emergencyfname 		= $scope.driverinfo.emergencyfname;
                            $scope.emergencylname 		= $scope.driverinfo.emergencylname;
                            $scope.emergencyphone 		= $scope.driverinfo.emergencyphone;
                            $scope.emergencyemail 		= $scope.driverinfo.emergencyemail;
                            $scope.schoolName 			= $scope.driverinfo.school_name;
                            $scope.formattedDate = $scope.convertDateFormat($scope.driverLicenseExpire);
                    }

                    }, function errorCallback(response){

            });

    }
    $scope.getDriverDetails();
    $scope.convertDateFormat = function(str) {
            var date = new Date(str),
            mnth = ("0" + (date.getMonth() + 1)).slice(-2),
            day = ("0" + date.getDate()).slice(-2);
            return [day, mnth, date.getFullYear()].join("-");
    }
}
function DriverListCtrl($scope, $http, $routeParams, $timeout, $window) {
    $scope.schoolList = [];
    $scope.dataList = [];
    $scope.school_id = 0;
    $scope.encryptStr = function(id)
    {
        var qry = id.toString();
        var encrypted = CryptoJS.AES.encrypt(qry, "KidyView");
        var str = encrypted.toString();
        if(str.indexOf("/") == -1) {
                return str;
        }
        else{
                return $scope.encryptStr(id);
        }
    };

    $scope.getAllSchools = function()
    {
        $http.get(BASE_URL+'api/user/getAllSchoolsForSchoolMngt',{
            headers:{
                'Content-Type':undefined, 'x-api-key':xapikey,
            }
            }).then(function(response) {

            if(response.status == 200)
            {
                $scope.schoolList = response.data.data;                
            }
            }, function errorCallback(response){
        });
    }
    $scope.getAllSchools();
    $scope.getData = function()
    {
        $http.get(BASE_URL+'api/driver?school_id='+$scope.school_id,{
            headers:{
                'Content-Type':undefined, 'x-api-key':xapikey,
            }
            }).then(function(response) {

            if(response.status == 200)
            {
                $scope.dataList = response.data.data;
                var encrypted ;
                for(var i = 0; i < $scope.dataList.length; i++)
                {
                    encrypted = $scope.encryptStr($scope.dataList[i].id);
                    $scope.dataList[i]['driverID'] = encrypted;
                }
            }
            }, function errorCallback(response){
        });
    }
    //$scope.getData();
    
}

function ParentDetailCtrl($scope, $http, $routeParams, $timeout, $window) {
    var sid;
    $scope.parentID = '';
    $scope.setID = function(){
            var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
            $scope.parentID = decrypted.toString(CryptoJS.enc.Utf8);
            sid = $scope.parentID;
    };	
    $timeout($scope.setID(), 2000);
    //alert($scope.parentID); return false;
    $scope.parentinfo = false;
    $scope.guardianinfo = false;
    $scope.getParentDetails = function()
    {
            var formData = {'id':$scope.parentID}
            $http.post(BASE_URL+'api/user/getParentDetails',formData,{
                    headers:{
                            'Content-Type':undefined, 'x-api-key':xapikey
                    }
                    }).then(function(response) {

                    if(response.status == 200)
                    {
                            $scope.parentinfo = response.data.data;
                            $scope.guardianinfo = response.data.data1;
                            //console.log($scope.parentinfo); return false;
                            $scope.fatherfname		= $scope.parentinfo.fatherfname;
                            $scope.fatherlname		= $scope.parentinfo.fatherlname;
                            $scope.fatheroccupation = $scope.parentinfo.fatheroccupation;
                            $scope.fatheremail		= $scope.parentinfo.fatheremail;
                            $scope.fatherphone		= $scope.parentinfo.fatherphone;
                            $scope.fatheraddress	= $scope.parentinfo.fatheraddress;
                            $scope.fcity			= $scope.parentinfo.fcity;
                            $scope.fstate			= $scope.parentinfo.fstate;
                            $scope.fcountry			= $scope.parentinfo.fcountry;
                            $scope.fpincode			= $scope.parentinfo.fpincode;
                            $scope.fatherphoto		= $scope.parentinfo.fatherphoto;
                            $scope.motherfname		= $scope.parentinfo.motherfname;
                            $scope.motherlname		= $scope.parentinfo.motherlname;
                            $scope.motheroccupation	= $scope.parentinfo.motheroccupation;
                            $scope.motheremail		= $scope.parentinfo.motheremail;
                            $scope.motherphone		= $scope.parentinfo.motherphone;
                            $scope.motheraddress	= $scope.parentinfo.motheraddress;
                            $scope.mcity			= $scope.parentinfo.mcity;
                            $scope.mstate			= $scope.parentinfo.mstate;
                            $scope.mcountry			= $scope.parentinfo.mcountry;
                            $scope.mpincode			= $scope.parentinfo.mpincode;
                            $scope.motherphoto		= $scope.parentinfo.motherphoto;
                            $scope.emergencyfname	= $scope.parentinfo.emergencyfname;
                            $scope.emergencylname	= $scope.parentinfo.emergencylname;
                            $scope.emergencyemail	= $scope.parentinfo.emergencyemail;
                            $scope.emergencyphone	= $scope.parentinfo.emergencyphone;
                            $scope.emergencyaddress	= $scope.parentinfo.emergencyaddress;
                            $scope.ecity			= $scope.parentinfo.ecity;
                            $scope.estate			= $scope.parentinfo.estate;
                            $scope.ecountry			= $scope.parentinfo.ecountry;
                            $scope.epincode			= $scope.parentinfo.epincode;
                            $scope.emergencyphoto	= $scope.parentinfo.emergencyphoto;
                            $scope.childId			= $scope.parentinfo.child_id;

                    }

                    }, function errorCallback(response){

            });

    }
    $scope.getParentDetails();

    if($scope.childId != '')
    {
            $scope.encryptStr = function(id)
            {
                    var qry = id.toString();
                    var encrypted = CryptoJS.AES.encrypt(qry, "KidyView");
                    var str = encrypted.toString();
                    if(str.indexOf("/") == -1) {
                            return str;
                    }
                    else{
                            return $scope.encryptStr(id);
                    }

            };

            $scope.convertDateFormat = function(str) {
                    var date = new Date(str),
                    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                    day = ("0" + date.getDate()).slice(-2);
                    return [day, mnth, date.getFullYear()].join("-");
            }

            $scope.getChildDetails = function()
            {
                    var formData = {'id':$scope.parentID}
                    $http.post(BASE_URL+'api/user/getChildDetails',formData,{
                            headers:{
                                    'Content-Type':undefined, 'x-api-key':xapikey
                            }
                            }).then(function(response) {

                            if(response.status == 200)
                            {
                                    $scope.childinfo = response.data.data;
                                    var dob;
                                    for(var i = 0; i < $scope.childinfo.length; i++)
                                    {
                                            dob = $scope.convertDateFormat($scope.childinfo[i].childdob);
                                            $scope.childinfo[i]['childDOB'] = dob;
                                    }
                                    var encrypted ;
                                    for(var i = 0; i < $scope.childinfo.length; i++)
                                    {
                                            encrypted = $scope.encryptStr($scope.childinfo[i].id);
                                            $scope.childinfo[i]['childID'] = encrypted;
                                    }
                            }

                            }, function errorCallback(response){

                    });

            }
            $scope.getChildDetails();
    }
}
function ParentListCtrl($scope, $http, $routeParams, $timeout, $window) {
    $scope.schoolList = [];
    $scope.dataList = [];
    $scope.school_id = 0;
    $scope.encryptStr = function(id)
    {
        var qry = id.toString();
        var encrypted = CryptoJS.AES.encrypt(qry, "KidyView");
        var str = encrypted.toString();
        if(str.indexOf("/") == -1) {
                return str;
        }
        else{
                return $scope.encryptStr(id);
        }
    };

    $scope.getAllSchools = function()
    {
        $http.get(BASE_URL+'api/user/getAllSchoolsForSchoolMngt',{
            headers:{
                'Content-Type':undefined, 'x-api-key':xapikey,
            }
            }).then(function(response) {

            if(response.status == 200)
            {
                $scope.schoolList = response.data.data;                
            }
            }, function errorCallback(response){
        });
    }
    $scope.getAllSchools();
    $scope.getData = function()
    {
        $http.get(BASE_URL+'api/parents?school_id='+$scope.school_id,{
            headers:{
                'Content-Type':undefined, 'x-api-key':xapikey,
            }
            }).then(function(response) {

            if(response.status == 200)
            {
                $scope.dataList = response.data.data;
                var encrypted ;
                for(var i = 0; i < $scope.dataList.length; i++)
                {
                    encrypted = $scope.encryptStr($scope.dataList[i].id);
                    $scope.dataList[i]['parentID'] = encrypted;
                }
            }
            }, function errorCallback(response){
        });
    }
    //$scope.getData();
    
}

function LoginImageCtrl($scope, $http, $routeParams, $timeout, $window){
    $scope.BASE_URL = BASE_URL;
    $scope.dataList = [];
    $scope.ob = {image:"",bg_image:""};
    $scope.obEdit = {id:"", image:"",bg_image:""};
    $scope.getDataList = function () {
        $http.get(BASE_URL + 'api/loginImage', {
            headers:{
                'Content-Type':undefined, 'x-api-key':xapikey,
            }
        }).then(function (response) {
            $scope.dataList = response.data.data;                
            
        }, function errorCallback(response) {

        });  
    };
    $scope.getDataList();
    $scope.error = {};    
    $scope.editData = function(ob){
		var retn=1
		var checlPrivilege=JSON.parse(jsonPrivilege);
		if(checlPrivilege.length==0){
			var cnt=checlPrivilege.length;
		}else{
			var cnt=jsonPrivilege.length;
		}
		if(cnt>0){
			if(checlPrivilege.PrivilegeManagement['edit']==0){
				retn=0;
			}
		if(retn==0){
			var Gritter = function () {
				$.gritter.add({
					title: 'Error',
					text: 'You have not access permission fot this.'
				});
				return false;
			}();
			$location.path('#/')
			return false;
		} 
		}
        $scope.obEdit = ob;
        $("#update-modal").modal('show');
	};
	$scope.isUpload=0;
    $scope.updateData = function(){
		
        $http.put(BASE_URL + 'api/loginImage',$scope.obEdit,{
            headers:{
                'Content-Type':undefined, 'x-api-key':xapikey,
            }
        }).then(function (response) {
            $.gritter.add({
			title: 'Success',
			text: 'Image Updated Successfuly.',
			sticky: true,
			class_name: 'my-sticky-class'
		});
            $scope.obEdit = {id:"", image:""};
			$("#update-modal").modal('hide');
			$scope.isUpload=0;
        }, function errorCallback(response) {

        });
    };    
    $scope.ImageUpload 	= function(f,type)
    {
		$scope.isUpload=0;
        var varFile = f.files[0];
        var fd 	= new FormData();
        fd.append('image', varFile);
        $http.post(BASE_URL+'api/loginImage/image', fd, {
            transformRequest: angular.identity,
            headers:{
                'Content-Type':undefined, 'x-api-key':xapikey,
            }
        }).then(function(response) { 
            $scope.isUpload=1;
            $scope.obEdit.image = response.data.file_name;            
                        
        }, function errorCallback(response){
                            
        });
	}
	$scope.bgImageUpload 	= function(f,type)
    {
		$scope.isUpload=0;
        var varFile = f.files[0];
        var fd 	= new FormData();
        fd.append('image', varFile);
        $http.post(BASE_URL+'api/loginImage/image', fd, {
            transformRequest: angular.identity,
            headers:{
                'Content-Type':undefined, 'x-api-key':xapikey,
            }
        }).then(function(response) { 
			$scope.isUpload=1;
            $scope.obEdit.bg_image = response.data.file_name;            
                        
        }, function errorCallback(response){
                            
        });
    }
}
function SubscriptionListCtrl($scope, $http, $routeParams, $timeout, $window) {
	$scope.subscriptionDisabled = function(subscription, status)
	{
		
		//alert(status);
		//alert(schoolID); return false;
		var formData = {'id':subscription.id, 'status':status};
		$http.post(BASE_URL+'api/admin/subscription/changeStatus',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				subscription.status=status;
				var result  = response.data;
				var Gritter = function () {
					if(status == 0)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'Status Disabled Now.'
						});
					}else if(status == 1)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'Status Enabled Now.'
						});
					}
					return false;
				}();
			}
			
			}, function errorCallback(response){
			
		});
		
	}
    $scope.subscriptionList = [];
    $scope.encryptStr = function(id)
    {
        var qry = id.toString();
        var encrypted = CryptoJS.AES.encrypt(qry, "KidyView");
        var str = encrypted.toString();
        if(str.indexOf("/") == -1) {
                return str;
        }
        else{
                return $scope.encryptStr(id);
        }
    };

    $scope.getSubscriptionList = function()
    {
        $http.get(BASE_URL+'api/admin/subscription/getSubscriptionList',{
            headers:{
                'Content-Type':undefined, 'x-api-key':xapikey,
            }
            }).then(function(response) {

            if(response.status == 200)
            {
				$scope.subscriptionList = response.data.data;  
				var encrypted ;
                for(var i = 0; i < $scope.subscriptionList.length; i++)
                {
                    encrypted = $scope.encryptStr($scope.subscriptionList[i].id);
                    $scope.subscriptionList[i]['subscriptionID'] = encrypted;
                }              
            }
            }, function errorCallback(response){
        });
    }
	$scope.getSubscriptionList();
	$scope.delete = function(id)
	{
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			 $http.get(BASE_URL+'api/admin/subscription/delete?subscription_id='+id,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey
				}
				}).then(function(response) {
				
				if(response.status == 200)
				{
					var Gritter = function () {
						$.gritter.add({
							title: 'Successfull',
							text: response.data.message
						});
						$scope.getSubscriptionList();
						return false;
					}();
				}
				
				}, function errorCallback(response){
					var Gritter = function () {
						$.gritter.add({
							title: 'Error',
							text: response.data.message
						});
						return false;
					}();
			});
		}
	}
}
function AddSubscriptionCtrl($scope, $http, $route, $window) 
{
	$scope.checkAllData=function(data,val){
		for(var i = 0; i < data.length; i++)
		{
			if(val=='1'){
				data[i]['is_enable'] = val
			}else{
				data[i]['is_enable'] = val;
			}
		}     
	}
	$scope.featureList=[];
	$scope.getFeatureList = function()
    {
        $http.get(BASE_URL+'api/admin/subscription/getFeatureList',{
            headers:{
                'Content-Type':undefined, 'x-api-key':xapikey,
            }
            }).then(function(response) {

            if(response.status == 200)
            {
				$scope.featureList = response.data.data;  
				for(var i = 0; i < $scope.featureList.length; i++)
				{
					
					$scope.featureList[i]['is_enable'] = '0';
				}           
            }
            }, function errorCallback(response){
        });
    }
	$scope.getFeatureList();
	$scope.validityArray=[{'val':'Monthly','label':'Monthly'},{'val':'Quarterly','label':'Quarterly'},{'val':'Yearly','label':'Yearly'}];
	$scope.subscriptionTypeArray=[{'val':'Free','label':'Free'},{'val':'Paid','label':'Paid'}];
	$scope.type=$scope.subscriptionTypeArray[0].val
	$scope.name='';
	$scope.validity='';
	$scope.amount='0.00';
	$scope.description='';
	$scope.no_of_student='';
	$scope.createSubscription=function(){
		if($scope.name == '')
		{
			$scope.errormsg = 'Title is required.';
			return false;
		}else if($scope.type == '')
		{
			$scope.errormsg = 'Type is required.';
			return false;
		}else if($scope.validity=='')
		{
			$scope.errormsg = 'Validity is required.';
			return false;
		}else if($scope.amount=='')
		{
			$scope.errormsg = 'Amount is required.';
			return false;
		}else if($scope.no_of_student=='')
		{
			$scope.errormsg = 'Maximum number of children';
			return false;
		}/*else if($scope.description=='')
		{
			$scope.errormsg = 'Description is required.';
			return false;
		}*/
		var formData = new FormData();
		formData.append('name', $scope.name);
		formData.append('type', $scope.type);
		formData.append('validity', $scope.validity);
		formData.append('amount', $scope.amount);
		formData.append('no_of_student', $scope.no_of_student);
		formData.append('description', $scope.description);
		formData.append('featureData', JSON.stringify($scope.featureList));
		$http.post(BASE_URL+'api/admin/subscription/createSubscription',formData,{
			transformRequest: angular.identity,
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.result = response.data.data;
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: response.data.message
					});
					$scope.errormsg = '';
					return false;
				}();
				$window.location.href = '#!/subscription-list';
			}
			
			}, function errorCallback(response){
				var Gritter = function () {
					$.gritter.add({
						title: 'Error',
						text: response.data.message
					});
					$scope.errormsg = '';
					return false;
				}();
			
		});
	}
	
}

function EditSubscriptionCtrl($scope, $http, $route, $window,$timeout,$routeParams) 
{
	$scope.checkAllData=function(data,val){
		for(var i = 0; i < data.length; i++)
		{
			if(val=='1'){
				data[i]['is_enable'] = val
			}else{
				data[i]['is_enable'] = val;
			}
		}     
	}
	$scope.validityArray=[{'val':'Monthly','label':'Monthly'},{'val':'Quarterly','label':'Quarterly'},{'val':'Yearly','label':'Yearly'}];
	$scope.subscriptionTypeArray=[{'val':'Free','label':'Free'},{'val':'Paid','label':'Paid'}];
	$scope.type=$scope.subscriptionTypeArray[0].val
	$scope.name='';
	$scope.validity='';
	$scope.amount='';
	$scope.description='';
	var sid;
	$scope.subscriptionID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.subscriptionID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.subscriptionID;
	};	
	$timeout($scope.setID(), 2000);
	$scope.featureList=[];
	$scope.getFeatureList = function()
    {
        $http.get(BASE_URL+'api/admin/subscription/getFeatureList?subscription_id='+$scope.subscriptionID,{
            headers:{
                'Content-Type':undefined, 'x-api-key':xapikey,
            }
            }).then(function(response) {

            if(response.status == 200)
            {
				$scope.featureList = response.data.data;             
            }
            }, function errorCallback(response){
        });
    }
	$scope.getFeatureList();
	$scope.subscriptioninfo = false;
	$scope.getSubscriptionDetails = function()
	{
		$http.get(BASE_URL+'api/admin/subscription/getSubscriptionDetails?subscription_id='+$scope.subscriptionID,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.subscriptioninfo = response.data.data;
				$scope.name				= $scope.subscriptioninfo.name;
				$scope.type				= $scope.subscriptioninfo.type;
				$scope.validity			= $scope.subscriptioninfo.validity;
				$scope.amount			= $scope.subscriptioninfo.amount;
				$scope.no_of_student	= $scope.subscriptioninfo.no_of_student;
				$scope.description		= $scope.subscriptioninfo.description;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getSubscriptionDetails();
	$scope.editSubscription=function(){
		if($scope.name == '')
		{
			$scope.errormsg = 'Title is required.';
			return false;
		}else if($scope.type == '')
		{
			$scope.errormsg = 'Type is required.';
			return false;
		}else if($scope.validity=='')
		{
			$scope.errormsg = 'Validity is required.';
			return false;
		}else if($scope.amount=='')
		{
			$scope.errormsg = 'Amount is required.';
			return false;
		}else if($scope.no_of_student=='')
		{
			$scope.errormsg = 'Maximum number of children is required.';
			return false;
		}/*else if($scope.description=='')
		{
			$scope.errormsg = 'Description is required.';
			return false;
		}*/
		var formData = new FormData();
		formData.append('name', $scope.name);
		formData.append('type', $scope.type);
		formData.append('validity', $scope.validity);
		formData.append('amount', $scope.amount);
		formData.append('no_of_student', $scope.no_of_student);
		formData.append('description', $scope.description);
		formData.append('subscription_id', $scope.subscriptionID);
		formData.append('featureData', JSON.stringify($scope.featureList));
		$http.post(BASE_URL+'api/admin/subscription/editSubscription',formData,{
			transformRequest: angular.identity,
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.result = response.data.data;
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: response.data.message
					});
					$scope.errormsg = '';
					return false;
				}();
				$window.location.href = '#!/subscription-list';
			}
			
			}, function errorCallback(response){
				var Gritter = function () {
					$.gritter.add({
						title: 'Error',
						text: response.data.message
					});
					$scope.errormsg = '';
					return false;
				}();
			
		});
	}
	
}


function feesCategoryCtrl($scope,$http,$window,$routeParams,$timeout)
{
	// Get Fees Category List
	$scope.getFeesCategories = function()
	{
		$scope.feesCategory = [];
		var formData = {'type':'admin'};
		$http.post(BASE_URL+'api/admin/fees/getFeesCategories',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.encryptStr = function(id)
				{
					var qry = id.toString();
					var encrypted = CryptoJS.AES.encrypt(qry, "KidyView");
					var str = encrypted.toString();
					if(str.indexOf("/") == -1) {
						return str;
					}
					else{
						 return $scope.encryptStr(id); 
					}
				};

				$scope.feesCategory = response.data.data;
				for(var i =0; i < $scope.feesCategory.length; i++)
	            {
	                $scope.feesCategory[i]['id']   			= $scope.feesCategory[i].id;
	                $scope.feesCategory[i]['encrypt_id'] 	= $scope.encryptStr($scope.feesCategory[i].id);
	    		}
			}
			// console.log($scope.feesCategory);		
			}, function errorCallback(response){

				if(response.status == 400)
				{
					var Gritter = function () {
						$.gritter.add({
							title: 'Failed',
							text: 'No category found.'
						});
						return false;
					}();
				}
			
		});
	}
	$scope.getFeesCategories();

	// Delete category list
	$scope.delete = function(id)
	{
		var retn=1
		var checlPrivilege=JSON.parse(jsonPrivilege);
		if(checlPrivilege.length==0){
			var cnt=checlPrivilege.length;
		}else{
			var cnt=jsonPrivilege.length;
		}
		if(cnt>0){
			if(checlPrivilege.PrivilegeManagement['delete']==0){
				retn=0;
			}
		if(retn==0){
			var Gritter = function () {
				$.gritter.add({
					title: 'Error',
					text: 'You have not access permission fot this.'
				});
				return false;
			}();
			$location.path('#/')
			return false;
		} 
		}
		$http.post(BASE_URL+'api/admin/fees/deleteCategory',{id:id},{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey
				}
				}).then(function(response) {
				$scope.response = response.data.data;
				if($scope.response == 1 )
				{
						var Gritter = function () {
						$.gritter.add({
							title: 'Success',
							text: 'Fees Category has been deleted successfully.'
						});
						$scope.getFeesCategories();
						$window.location.href = '#!/fees-category';
						}();
				}
				// console.log($scope.response);		
				}, function errorCallback(response){

			});
	}
}
function addFeesCategoryCtrl($scope,$http,$window,$routeParams,$timeout)
{
	$scope.addCategory = function()
	{
		if( ($scope.category == 'undefined' && $scope.category == '') || ( $scope.description == 'undefined' && $scope.description == '') )
		{
			console.log('empty');
			var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: 'All mendatory (*) fields can`t be empty.'
				});
				return false;
			}();

		}else{

			var formData = {category:$scope.category,description:$scope.description};

			$http.post(BASE_URL+'api/admin/fees/addFeesCategory',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey
				}
				}).then(function(response) {
				if(response.status == 200)
				{
					var Gritter = function () {
						$.gritter.add({
							title: 'Success',
							text: response.data.message
						});
						// $scope.getExamList();
						// $scope.getFeesCategories();
						$window.location.href = '#!/fees-category';
						}();
				}
				// console.log($scope.SubjectList);	
				}, function errorCallback(response){
			});
			// console.log($scope.category + "::" + $scope.description);

		}
		
	}
}

function editFeesCategoryCtrl($scope,$http,$window,$routeParams,$timeout)
{
	var catID;
	$scope.id = "";
	 $scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.id = decrypted.toString(CryptoJS.enc.Utf8);
		catID = $scope.id;
	};
    $timeout($scope.setID(), 200);
// console.log($scope.id);
// return false

	// Update category 
	$scope.categoryDetails = function()
	{
		$scope.categoryDetails = [];
		$http.post(BASE_URL+'api/admin/fees/editCategory',{id:$scope.id},{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey
				}
				}).then(function(response) {
					$scope.categoryDetails = response.data.data;
						$scope.id 			= $scope.categoryDetails.id;
						$scope.category 	= $scope.categoryDetails.category;
						$scope.description  = $scope.categoryDetails.description;
				
				// console.log($scope.categoryDetails);		
				}, function errorCallback(response){
					if(response.status == 400)
					{
						var Gritter = function () {
							$.gritter.add({
								title: 'Failed',
								text: 'Something went wrong.'
							});
							return false;
						}();
					}
			});
	}
	$scope.categoryDetails();

	// Edit fees category
	$scope.updateCategory = function()
	{
		var formData = {id:$scope.id,category:$scope.category,description:$scope.description};
		// console.log(formData);
		// return false
			$http.post(BASE_URL+'api/admin/fees/updateFeesCategory',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey
				}
				}).then(function(response) {
				$scope.response = response.data.data;
				if($scope.response == 1 )
				{
						var Gritter = function () {
						$.gritter.add({
							title: 'Success',
							text: response.data.message
						});
						$window.location.href = '#!/fees-category';
						}();
				}
				// console.log($scope.response);		
				}, function errorCallback(response){
			});
	};
}

function feedbackCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
    console.log('feedbackCtrl');
    $scope.pageSize = 10;
    
    $scope.optionsList = [{ name: "teacher", id: 1 }, { name: "parent", id: 2 },{ name: "driver", id: 2 }];
    
    
        $scope.getuserFeedback = function(userType)
        {
         console.log('getuserFeedback');
        $scope.feedback = false;
		var formData = {'userType':userType};
		$http.post(BASE_URL+'api/user/getAllFeedback',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.feedback = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.feedback.length; i++)
				{
					//console.log($scope.feedback[i].id); 
					encrypted = $scope.encryptStr($scope.feedback[i].id);
					$scope.feedback[i]['id'] = encrypted;
				}
				console.log($scope.feedback); 
                return false
			}
			
			}, function errorCallback(error){
				if(error.status==401){	
					localStorage.setItem('TOKEN', '');
					$window.location = BASE_URL+'schoollogin/login';
					}
					if(error.status==403){	
						if(error.data.status==0){
							var Gritter = function () {
							$.gritter.add({
								title: 'Error',
								text: error.data.message
							});
							$timeout(
								$window.location = BASE_URL+'schoollogin/logout'
							, 200);
							return false;
							}();
						}
						if(error.data.status==2){
							var Gritter = function () {
							$.gritter.add({
								title: 'Error',
								text: error.data.message
							});
							$timeout(
								$window.location = BASE_URL+'schooluser'
							, 200);
							return false;
							}();
						}
					}
			
		});
		
	}

	$scope.encryptStr = function(id)
	{
		var qry = id.toString();
		var encrypted = CryptoJS.AES.encrypt(qry, "KidyView");
		var str = encrypted.toString();
		if(str.indexOf("/") == -1) {
			return str;
		}
		else{
			return $scope.encryptStr(id);
		}
		
	}
   
}


function feedbackViews($scope, $http, $routeParams, $timeout,$window) 
{
	var sid;
	$scope.feedID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.feedID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.feedID;
	};	
	$timeout($scope.setID(), 2000);
	//alert($scope.studentID); return false;
	
	//return false;
	$scope.studentinfo = false;
	$scope.getFeedbackDetails = function()
	{
		var formData = {'id':$scope.feedID}
		$http.post(BASE_URL+'api/user/getSingleFeedbackDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.feedinfo                 = response.data.data;
				$scope.fname                    = $scope.feedinfo.fname;
				$scope.lname                    = $scope.feedinfo.lname;
				$scope.message                  = $scope.feedinfo.message;
				$scope.message_for 		= $scope.feedinfo.message_for;
				$scope.school                   = $scope.feedinfo.school;
				$scope.user_type 		= $scope.feedinfo.user_type;
				$scope.message                  = $scope.feedinfo.message;
				$scope.created 			= $scope.feedinfo.created;
			
				
			}
			
			}, function errorCallback(error){
				if(error.status==401){	
					localStorage.setItem('TOKEN', '');
					$window.location = BASE_URL+'schoollogin/login';
					}
					if(error.status==403){	
						if(error.data.status==0){
							var Gritter = function () {
							$.gritter.add({
								title: 'Error',
								text: error.data.message
							});
							$timeout(
								$window.location = BASE_URL+'schoollogin/logout'
							, 200);
							return false;
							}();
						}
						if(error.data.status==2){
							var Gritter = function () {
							$.gritter.add({
								title: 'Error',
								text: error.data.message
							});
							$timeout(
								$window.location = BASE_URL+'schooluser'
							, 200);
							return false;
							}();
						}
					}
		});
		
	}
	$scope.getFeedbackDetails();
	
	$scope.convertDateFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [day, mnth, date.getFullYear()].join("-");
	}
}

function reportParent($scope, $http, $routeParams, $timeout,$window) {
    
    
    $scope.parent ={classSectionList:"",schoolLists:"",countryCodes:"",fromdate:"",todate:""};
    $scope.schoolLists = [];
    $scope.classSectionList = [];  
    $scope.countryCodes = [];
    $scope.searchingData = false;
    $scope.pageSize = 10;
    $scope.allSchoolList = [];
    
    
    $scope.countryCode = function()
    {
                var formData = {};
		
		$http.post(BASE_URL+'report/reportparent/getCountryList',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200){
                            $scope.countryCodes = response.data.data;
                        }},
                        function errorCallback(response){
				$scope.countryCodes = [];
                       }); 
                 
      }
    
    $scope.getAllSchool = function(countryID)
    {
                var formData = {'countryID':countryID};
		$http.post(BASE_URL+'report/reportparent/getAllSchool',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200){
				$scope.schoolLists = response.data.data;
                                console.log($scope.schoolLists.length);
                                for(var i=0;i<$scope.schoolLists.length;i++){
                                 $scope.allSchoolList[i] = $scope.schoolLists[i]['id'];
                                }
                                //console.log($scope.schoolLists);
				}},
                        function errorCallback(response){
				$scope.schoolLists = [];
                       }); 
                 
      }
             
           
      $scope.getAllSectionClass = function(schoolid)
       {
               // var formData = {getAllSectionClass:'getAllSectionClass'};
                var formData = {'userType':'teacher','schoolid':schoolid};
		
		
		$http.post(BASE_URL+'report/reportparent/getAllSectionClass',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200){
			$scope.classSectionList = response.data.data;
				
			}},
                        function errorCallback(response){
				$scope.classSectionList = [];
                       }); 
        }
             
     $scope.getReport = function()
     {
          $scope.searchingData = [];
           var classSectionList     =   $scope.parent.classSectionList;
           var schoolLists          =   $scope.parent.schoolLists;
           var countryCodes         =   $scope.parent.countryCodes;
           var fromdate             =   $('#fromdate').val();
           var todate               =   $('#todate').val();
           
           if(schoolLists.length>0){
           var schoolLists = schoolLists;    
           }
           else {
           var schoolLists = $scope.allSchoolList;    
           } 
           
           
           
           var formData = {'classSectionList':classSectionList,'schoolLists':schoolLists,'countryCodes':countryCodes,'fromdate':fromdate,'todate':todate};
            
            if(countryCodes.length>0 ){
             
		$http.post(BASE_URL+'report/reportparent/getReport',formData,{
		headers:{ 
                    'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
                    }
		 }).then(function(response) {
                if(response.status == 200){     
		$scope.searchingData = response.data.data;
                console.log($scope.searchingData);
                return false
                }
			
            }, function errorCallback(response){});
				$scope.searchingData=[];
            }
            else {
              var Gritter = function () {
                $.gritter.add({
                        title: 'Searching Error',
                        text: 'Please Seclect Country.'
                });
                return false;
                }();
            }
       	
	};
        
     $scope.exportCSV = function()
     {
         var searchingData = $scope.searchingData;
         var userdata = [];
         if(searchingData.length>0){
         for(var i=0;i<searchingData.length;i++){
            var school_name = searchingData[i]['school_name'];
            var name = searchingData[i]['childfname'] +' ' +searchingData[i]['childmname'] +' ' +searchingData[i]['childlname']; 
            var classname = searchingData[i]['class'] +' ' +searchingData[i]['section'];
            var father = searchingData[i]['fatherfname'] +' ' +searchingData[i]['fatherlname'];
            var motherfname = searchingData[i]['motherfname'] +' ' +searchingData[i]['motherlname'];
            var fatheraddress = searchingData[i]['fatheraddress'];
            var fatherphone = searchingData[i]['fatherphone'];
            userdata[i] = [school_name.replace(/,|\n|_/g,'/'),name.replace(/,|\n|_/g,'/'),classname.replace(/,|\n|_/g,'/'),father.replace(/,|\n|_/g,'/'),motherfname.replace(/,|\n|_/g,'/'),fatheraddress.replace(/,|\n|_/g,'/'),fatherphone.replace(/,|\n|_/g,'/')]
           }
           
                var csv = 'School Name,Student Name, Class Name,Father Name,Mother Name,Address,Phone Number\n';
                userdata.forEach(function(row) {
                csv += row.join(',');
                csv += "\n";
                });

                console.log(csv);
                var hiddenElement = document.createElement('a');
                hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
                hiddenElement.target = '_blank';
                hiddenElement.download = 'parentreport.csv';
                hiddenElement.click();
         }
    };
        
      ///$scope.getAllSectionClass();   
      $scope.getAllSchool();
      $scope.countryCode();
      
    
}
function reportStudent($scope, $http, $routeParams, $timeout,$window) {
   
    $scope.parent ={classSectionList:"",schoolLists:"",countryCodes:"",fromdate:"",todate:""};
    $scope.schoolLists = [];
    $scope.classSectionList = [];  
    $scope.countryCodes = [];
    $scope.searchingData = false;
    $scope.pageSize = 10;
    $scope.allSchoolList = [];
    
    
    $scope.countryCode = function()
    {
                var formData = {};
		
		$http.post(BASE_URL+'report/reportstudent/getCountryList',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200){
                            $scope.countryCodes = response.data.data;
                        }},
                        function errorCallback(response){
				$scope.countryCodes = [];
                       }); 
                 
      }
    
    $scope.getAllSchool = function(countryID)
    {
                var formData = {'countryID':countryID};
		$http.post(BASE_URL+'report/reportstudent/getAllSchool',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200){
				$scope.schoolLists = response.data.data;
                                for(var i=0;i<$scope.schoolLists.length;i++){
                                $scope.allSchoolList[i] = $scope.schoolLists[i]['id'];
                                }

                                //console.log($scope.schoolLists);
				}},
                        function errorCallback(response){
				$scope.schoolLists = [];
                       }); 
                 
      }
             
           
      $scope.getAllSectionClass = function(schoolid)
       {
               // var formData = {getAllSectionClass:'getAllSectionClass'};
                var formData = {'userType':'teacher','schoolid':schoolid};
		
		
		$http.post(BASE_URL+'report/reportstudent/getAllSectionClass',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200){
			$scope.classSectionList = response.data.data;
				
			}},
                        function errorCallback(response){
				$scope.classSectionList = [];
                       }); 
        }
             
     $scope.getReport = function()
     {
         $scope.searchingData = [];
           var classSectionList     =   $scope.parent.classSectionList;
           var schoolLists          =   $scope.parent.schoolLists;
           var countryCodes         =   $scope.parent.countryCodes;
           var fromdate             =   $('#fromdate').val();
           var todate               =   $('#todate').val();
           
            if(schoolLists.length>0){
            var schoolLists = schoolLists;    
             }
            else {
            var schoolLists = $scope.allSchoolList;    
            }
           
           var formData = {'classSectionList':classSectionList,'schoolLists':schoolLists,'countryCodes':countryCodes,'fromdate':fromdate,'todate':todate};
            
            if(countryCodes.length>0 ){
             
		$http.post(BASE_URL+'report/reportstudent/getReport',formData,{
		headers:{ 
                    'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
                    }
		 }).then(function(response) {
                if(response.status == 200){     
		$scope.searchingData = response.data.data;
                console.log($scope.searchingData);
                return false
                }
			
            }, function errorCallback(response){});
			$scope.searchingData=[];
            }
            else {
              var Gritter = function () {
                $.gritter.add({
                        title: 'Searching Error',
                        text: 'Please Seclect Country.'
                });
                return false;
                }();
            }
       	
	};
        
     $scope.exportCSV = function()
     {
         var searchingData = $scope.searchingData;
         var userdata = [];
         if(searchingData.length>0){
         for(var i=0;i<searchingData.length;i++){
            var school_name = searchingData[i]['school_name'];
            var name = searchingData[i]['childfname'] +' ' +searchingData[i]['childmname'] +' ' +searchingData[i]['childlname']; 
            var classname = searchingData[i]['class'] +' ' +searchingData[i]['section'];
            var father = searchingData[i]['fatherfname'] +' ' +searchingData[i]['fatherlname'];
            var motherfname = searchingData[i]['motherfname'] +' ' +searchingData[i]['motherlname'];
            var fatheraddress = searchingData[i]['fatheraddress'];
            var fatherphone = searchingData[i]['fatherphone'];
            userdata[i] = [school_name.replace(/,|\n|_/g,'/'),name.replace(/,|\n|_/g,'/'),classname.replace(/,|\n|_/g,'/'),father.replace(/,|\n|_/g,'/'),motherfname.replace(/,|\n|_/g,'/'),fatheraddress.replace(/,|\n|_/g,'/'),fatherphone.replace(/,|\n|_/g,'/')]
           }
           
                var csv = 'School Name,Student Name, Class Name,Father Name,Mother Name,Address,Phone Number\n';
                userdata.forEach(function(row) {
                csv += row.join(',');
                csv += "\n";
                });

                console.log(csv);
                var hiddenElement = document.createElement('a');
                hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
                hiddenElement.target = '_blank';
                hiddenElement.download = 'studentreport.csv';
                hiddenElement.click();
         }
    };
        
      //$scope.getAllSectionClass();   
      $scope.getAllSchool();
      $scope.countryCode();    
}




function reportTeacher($scope, $http, $routeParams, $timeout,$window) {
    
    $scope.parent ={classSectionList:"",schoolLists:"",countryCodes:"",fromdate:"",todate:""};
    $scope.schoolLists = [];
    $scope.classSectionList = [];  
    $scope.countryCodes = [];
    $scope.searchingData = false;
    $scope.pageSize = 10;
    $scope.allSchoolList = [];
    
    
    $scope.countryCode = function()
    {
                var formData = {};
		
		$http.post(BASE_URL+'report/reportteacher/getCountryList',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200){
                            $scope.countryCodes = response.data.data;
                        }},
                        function errorCallback(response){
				$scope.countryCodes = [];
                       }); 
                 
      }
    
    $scope.getAllSchool = function(countryID)
    {
                var formData = {'countryID':countryID};
		$http.post(BASE_URL+'report/reportteacher/getAllSchool',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200){
				$scope.schoolLists = response.data.data;
                                for(var i=0;i<$scope.schoolLists.length;i++){
                                $scope.allSchoolList[i] = $scope.schoolLists[i]['id'];
                                }

                                //console.log($scope.schoolLists);
				}},
                        function errorCallback(response){
				$scope.schoolLists = [];
                       }); 
                 
      }
             
           
      $scope.getAllSectionClass = function(schoolid)
       {
               // var formData = {getAllSectionClass:'getAllSectionClass'};
                var formData = {'userType':'teacher','schoolid':schoolid};
		
		
		$http.post(BASE_URL+'report/reportteacher/getAllSectionClass',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200){
			$scope.classSectionList = response.data.data;
				
			}},
                        function errorCallback(response){
				$scope.classSectionList = [];
                       }); 
        }
             
     $scope.getReport = function()
     {
          $scope.searchingData = [];
           var classSectionList     =   $scope.parent.classSectionList;
           var schoolLists          =   $scope.parent.schoolLists;
           var countryCodes         =   $scope.parent.countryCodes;
           var fromdate             =   $('#fromdate').val();
           var todate               =   $('#todate').val();
           
           if(schoolLists.length>0){
            var schoolLists = schoolLists;    
            }
            else {
            var schoolLists = $scope.allSchoolList;    
            } 
           
           var formData = {'classSectionList':classSectionList,'schoolLists':schoolLists,'countryCodes':countryCodes,'fromdate':fromdate,'todate':todate};
            
            if(countryCodes.length>0 ){
             
		$http.post(BASE_URL+'report/reportteacher/getReport',formData,{
		headers:{ 
                    'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
                    }
		 }).then(function(response) {
                if(response.status == 200){     
		$scope.searchingData = response.data.data;
                //console.log($scope.searchingData);
                return false
                }
			
            }, function errorCallback(response){});
			$scope.searchingData=[];
            }
            else {
              var Gritter = function () {
                $.gritter.add({
                        title: 'Searching Error',
                        text: 'Please Seclect Country.'
                });
                return false;
                }();
            }
       	
	};
        
     $scope.exportCSV = function()
     {
         var searchingData = $scope.searchingData;
         var userdata = [];
         if(searchingData.length>0){
         for(var i=0;i<searchingData.length;i++){
           
            var name = searchingData[i]['teacherfname'] +' ' +searchingData[i]['teachermname'] +' ' +searchingData[i]['teacherlname']; 
            var email = searchingData[i]['teacheremail'];
            var address = searchingData[i]['teacheraddress'];
            var city = searchingData[i]['tcity'];
            var pincode = searchingData[i]['tpincode'];
            userdata[i] = [name.replace(/,|\n|_/g,'/'),email.replace(/,|\n|_/g,'/'),address.replace(/,|\n|_/g,'/'),city.replace(/,|\n|_/g,'/'),pincode.replace(/,|\n|_/g,'/')]
           }
            console.log(userdata);
            
                var csv = 'Teacher Name,Email ID, Address,city,pincode\n';
                userdata.forEach(function(row) {
                csv += row.join(',');
                csv += "\n";
                });

                console.log(csv);
                var hiddenElement = document.createElement('a');
                hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
                hiddenElement.target = '_blank';
                hiddenElement.download = 'teacherreport.csv';
                hiddenElement.click();
         }
    };
        
      //$scope.getAllSectionClass();   
      $scope.getAllSchool();
      $scope.countryCode(); 
    
}


function reportSchool($scope, $http, $routeParams, $timeout,$window) {
    
   $scope.parent ={classSectionList:"",schoolLists:"",countryCodes:"",fromdate:"",todate:""};
    $scope.schoolLists = [];
    $scope.classSectionList = [];  
    $scope.countryCodes = [];
    $scope.searchingData = false;
    $scope.pageSize = 10;
    $scope.allSchoolList = [];
    
    
    $scope.countryCode = function()
    {
                var formData = {};
		
		$http.post(BASE_URL+'report/reportschool/getCountryList',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200){
                            $scope.countryCodes = response.data.data;
                        }},
                        function errorCallback(response){
				$scope.countryCodes = [];
                       }); 
                 
      }
    
    $scope.getAllSchool = function(countryID)
    {
                var formData = {'countryID':countryID};
		$http.post(BASE_URL+'report/reportschool/getAllSchool',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200){
				$scope.schoolLists = response.data.data;
                                for(var i=0;i<$scope.schoolLists.length;i++){
                                $scope.allSchoolList[i] = $scope.schoolLists[i]['id'];
                                }
                                //console.log($scope.schoolLists);
				}},
                        function errorCallback(response){
				$scope.schoolLists = [];
                       }); 
                 
      }
             
           
      $scope.getAllSectionClass = function(schoolid)
       {
               // var formData = {getAllSectionClass:'getAllSectionClass'};
                var formData = {'userType':'teacher','schoolid':schoolid};
		$http.post(BASE_URL+'report/reportschool/getAllSectionClass',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200){
			$scope.classSectionList = response.data.data;
				
			}},
                        function errorCallback(response){
				$scope.classSectionList = [];
                       }); 
        }
             
     $scope.getReport = function()
     {
          $scope.searchingData = [];
           var classSectionList     =   $scope.parent.classSectionList;
           var schoolLists          =   $scope.parent.schoolLists;
           var countryCodes         =   $scope.parent.countryCodes;
           var fromdate             =   $('#fromdate').val();
           var todate               =   $('#todate').val();
           
            if(schoolLists.length>0){
            var schoolLists = schoolLists;    
            }
            else {
            var schoolLists = $scope.allSchoolList;    
            } 
           
           
           var formData = {'classSectionList':classSectionList,'schoolLists':schoolLists,'countryCodes':countryCodes,'fromdate':fromdate,'todate':todate};
            
            if(countryCodes.length>0 ){
             
		$http.post(BASE_URL+'report/reportschool/getReport',formData,{
		headers:{ 
                    'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
                    }
		 }).then(function(response) {
                if(response.status == 200){     
		$scope.searchingData = response.data.data;
                //console.log($scope.searchingData);
                return false
                }
			
            }, function errorCallback(response){});
			$scope.searchingData=[];
            }
            else {
				$scope.searchingData=[];
              var Gritter = function () {
                $.gritter.add({
                        title: 'Searching Error',
                        text: 'Please Seclect Country.'
                });
                return false;
                }();
            }
       	
	};
        
     $scope.exportCSV = function()
     {
         var searchingData = $scope.searchingData;
         var userdata = [];
         if(searchingData.length>0){
         for(var i=0;i<searchingData.length;i++){
           
            var name = searchingData[i]['school_name']; 
            var email = searchingData[i]['email'];
            var address = searchingData[i]['location'];
            var city = searchingData[i]['city'];
            var pincode = searchingData[i]['pincode'];
            var subcription = searchingData[i]['subTitle'];
            var valid = searchingData[i]['validity'];
            userdata[i] = [name.replace(/,|\n|_/g,'/'),email.replace(/,|\n|_/g,'/'),address.replace(/,|\n|_/g,'/'),city.replace(/,|\n|_/g,'/'),pincode.replace(/,|\n|_/g,'/'),subcription.replace(/,|\n|_/g,'/'),valid.replace(/,|\n|_/g,'/')]
           }
            console.log(userdata);
            
                var csv = 'School Name,Email,Address,City,Pincode,Subscription plan,Subscription validity\n';
                userdata.forEach(function(row) {
                csv += row.join(',');
                csv += "\n";
                });

                console.log(csv);
                var hiddenElement = document.createElement('a');
                hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
                hiddenElement.target = '_blank';
                hiddenElement.download = 'schoolreport.csv';
                hiddenElement.click();
         }
    };
        
      //$scope.getAllSectionClass();   
      $scope.getAllSchool();
      $scope.countryCode(); 
    
}



function reportDriver($scope, $http, $routeParams, $timeout,$window)
{
    $scope.parent ={classSectionList:"",schoolLists:"",countryCodes:"",fromdate:"",todate:""};
    $scope.schoolLists = [];
    $scope.classSectionList = [];  
    $scope.countryCodes = [];
    $scope.searchingData = false;
    $scope.pageSize = 10;
    $scope.allSchoolList = [];
    
    
    $scope.countryCode = function()
    {
                var formData = {};
		
		$http.post(BASE_URL+'report/reportdriver/getCountryList',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200){
                            $scope.countryCodes = response.data.data;
                        }},
                        function errorCallback(response){
				$scope.countryCodes = [];
                       }); 
                 
      }
    
    $scope.getAllSchool = function(countryID)
    {
                var formData = {'countryID':countryID};
		$http.post(BASE_URL+'report/reportdriver/getAllSchool',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200){
				$scope.schoolLists = response.data.data;
                                for(var i=0;i<$scope.schoolLists.length;i++){
                                $scope.allSchoolList[i] = $scope.schoolLists[i]['id'];
                                }
                                //console.log($scope.schoolLists);
				}},
                        function errorCallback(response){
				$scope.schoolLists = [];
                       }); 
                 
      }
             
           
      $scope.getAllSectionClass = function(schoolid)
       {
               // var formData = {getAllSectionClass:'getAllSectionClass'};
                var formData = {'userType':'teacher','schoolid':schoolid};
		
		
		$http.post(BASE_URL+'report/reportdriver/getAllSectionClass',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200){
			$scope.classSectionList = response.data.data;
				
			}},
                        function errorCallback(response){
				$scope.classSectionList = [];
                       }); 
        }
             
     $scope.getReport = function()
     {
           $scope.searchingData = [];  
           var classSectionList     =   $scope.parent.classSectionList;
           var schoolLists          =   $scope.parent.schoolLists;
           var countryCodes         =   $scope.parent.countryCodes;
           var fromdate             =   $('#fromdate').val();
           var todate               =   $('#todate').val();
           
           
            if(schoolLists.length>0){
            var schoolLists = schoolLists;    
            }
            else {
            var schoolLists = $scope.allSchoolList;    
            }
           
           var formData = {'classSectionList':classSectionList,'schoolLists':schoolLists,'countryCodes':countryCodes,'fromdate':fromdate,'todate':todate};
            
            if(countryCodes.length>0 ){
             
		$http.post(BASE_URL+'report/reportdriver/getReport',formData,{
		headers:{ 
                    'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
                    }
		 }).then(function(response) {
                if(response.status == 200){     
		$scope.searchingData = response.data.data;
                //console.log($scope.searchingData);
                return false
                }
			
            }, function errorCallback(response){});
			$scope.searchingData=[];
            }
            else {
              var Gritter = function () {
                $.gritter.add({
                        title: 'Searching Error',
                        text: 'Please Seclect Country.'
                });
                return false;
                }();
            }
       	
	};
        
     $scope.exportCSV = function()
     {
         var searchingData = $scope.searchingData;
         var userdata = [];
         if(searchingData.length>0){
         for(var i=0;i<searchingData.length;i++){
           
           
            var school_name = searchingData[i]['school_name']; 
            var driver = searchingData[i]['driverfname']+ ' '+ searchingData[i]['driverlname']; 
            var email = searchingData[i]['driveremail'];
            var driverphone = searchingData[i]['driverphone'];
            var address = searchingData[i]['driveraddress'];
            var pincode = searchingData[i]['dpincode'];
            userdata[i] = [school_name.replace(/,|\n|_/g,'/'),driver.replace(/,|\n|_/g,'/'),email.replace(/,|\n|_/g,'/'),driverphone.replace(/,|\n|_/g,'/'),address.replace(/,|\n|_/g,'/'),pincode.replace(/,|\n|_/g,'/')]
           }
            console.log(userdata);
            
                var csv = 'School Name,Driver Name,Email,Phone,Address,Pincode\n';
                userdata.forEach(function(row) {
                csv += row.join(',');
                csv += "\n";
                });

                console.log(csv);
                var hiddenElement = document.createElement('a');
                hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
                hiddenElement.target = '_blank';
                hiddenElement.download = 'driverreport.csv';
                hiddenElement.click();
         }
    };
        
      //$scope.getAllSectionClass();   
      $scope.getAllSchool();
      $scope.countryCode();     
}




function reportRevenue($scope, $http, $routeParams, $timeout,$window) {
   
   $scope.parent ={classSectionList:"",schoolLists:"",countryCodes:"",fromdate:"",todate:""};
    $scope.schoolLists = [];
    $scope.classSectionList = [];  
    $scope.countryCodes = [];
    $scope.searchingData = false;
    $scope.pageSize = 10;
    $scope.allSchoolList = [];
    
    
    $scope.countryCode = function()
    {
                var formData = {};
		
		$http.post(BASE_URL+'report/reportrevenue/getCountryList',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200){
                            $scope.countryCodes = response.data.data;
                        }},
                        function errorCallback(response){
				$scope.countryCodes = [];
                       }); 
                 
      }
    
    $scope.getAllSchool = function(countryID)
    {
		$scope.allSchoolList=[];
    var formData = {'countryID':countryID};
		$http.post(BASE_URL+'report/reportrevenue/getAllSchool',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200){
				$scope.schoolLists = response.data.data;
                                for(var i=0;i<$scope.schoolLists.length;i++){
                                $scope.allSchoolList[i] = $scope.schoolLists[i]['id'];
                                }
                                //console.log($scope.schoolLists);
				}},
                        function errorCallback(response){
							$scope.allSchoolList = [];
                       }); 
                 
      }
             
           
      $scope.getAllSectionClass = function(schoolid)
       {
               // var formData = {getAllSectionClass:'getAllSectionClass'};
                var formData = {'userType':'teacher','schoolid':schoolid};
		$http.post(BASE_URL+'report/reportrevenue/getAllSectionClass',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200){
			$scope.classSectionList = response.data.data;
				
			}},
                        function errorCallback(response){
				$scope.classSectionList = [];
                       }); 
        }
             
     $scope.getReport = function()
     {
           $scope.searchingData = [];
           var classSectionList     =   $scope.parent.classSectionList;
           var schoolLists          =   $scope.parent.schoolLists;
           var countryCodes         =   $scope.parent.countryCodes;
           var fromdate             =   $('#fromdate').val();
           var todate               =   $('#todate').val();
           
            if(schoolLists.length>0){
            var schoolLists = schoolLists;    
            }
            else {
            var schoolLists = $scope.allSchoolList;    
            } 
           
           var formData = {'classSectionList':classSectionList,'schoolLists':schoolLists,'countryCodes':countryCodes,'fromdate':fromdate,'todate':todate};
		   //console.log();
            if(countryCodes.length>0 ){
             
		$http.post(BASE_URL+'report/reportrevenue/getReport',formData,{
		headers:{ 
                    'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
                    }
		 }).then(function(response) {
                if(response.status == 200){     
				$scope.searchingData = response.data.data;
                console.log($scope.searchingData);
                return false
                }
			
            }, function errorCallback(response){});
			$scope.searchingData=[];
            }
            else {
              var Gritter = function () {
                $.gritter.add({
                        title: 'Searching Error',
                        text: 'Please Seclect Country.'
				});
				$scope.searchingData=[];
                return false;
                }();
            }
       	
	};
        
     $scope.exportCSV = function()
     {
         var searchingData = $scope.searchingData;
		 var userdata = [];
		 console.log(searchingData);
         if(searchingData.length>0){
         for(var i=0;i<searchingData.length;i++){
           
            var name = searchingData[i]['school_name']; 
            var email = searchingData[i]['email'];
            var address = searchingData[i]['location'];
            var city = searchingData[i]['city'];
            var pincode = searchingData[i]['pincode'];
            var subcription = searchingData[i]['subTitle'];
            var valid = searchingData[i]['validity'];
            var amount = searchingData[i]['amount'];
			console.log(amount);
			var period = searchingData[i]['period'];
            
            userdata[i] = [name.replace(/,|\n|_/g,'/'),email.replace(/,|\n|_/g,'/'),address.replace(/,|\n|_/g,'/'),city.replace(/,|\n|_/g,'/'),pincode.replace(/,|\n|_/g,'/'),subcription.replace(/,|\n|_/g,'/'),valid.replace(/,|\n|_/g,'/'),amount,period.replace(/,|\n|_/g,'/')]
           }
            console.log(userdata);
            
                var csv = 'School Name,Email,Address,City,Pincode,Subscription plan,Subscription validity,Subscription amount (NGN),Subscription period\n';
                userdata.forEach(function(row) {
                csv += row.join(',');
                csv += "\n";
                });

                console.log(csv);
                var hiddenElement = document.createElement('a');
                hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
                hiddenElement.target = '_blank';
                hiddenElement.download = 'revenuereport.csv';
                hiddenElement.click();
         }
    };
        
      //$scope.getAllSectionClass();   
      $scope.getAllSchool();
      $scope.countryCode();
   
}



function revenueGraph($scope, $http, $routeParams, $timeout,$window) {
    
    var manual = '0';
    $scope.jan = 0;
    $scope.feb = 0;
    $scope.mar = 0;
    $scope.apr = 0;
    $scope.may = 0;
    $scope.june = 0;
    $scope.july = 0;
    $scope.aug = 0;
    $scope.sep = 0;
    $scope.oct = 0;
    $scope.nov = 0;
    $scope.dec = 0;
	$scope.getRevenueGraphHome = function(manual)
	{   
		var formData = {'manual':manual}
	   $http.post(BASE_URL+'report/reportgraphrevenue/graphdata',formData,{
	   headers:{ 
				   'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				   }
		}).then(function(response) {
			   if(response.status == 200){     
			   $scope.graphDatas = response.data.data;
			   return false
			   }
		   
		   }, function errorCallback(response){});
	
	
   }
   $scope.getRevenueGraphHome(manual);
    $scope.currclass=0;
    $scope.getRevenueGraph = function(manual)
     {   
		 //return false;
		 $scope.currclass=manual;
         $scope.graphData = "";
         $scope.monthly_revenue ="";
         //$('#barColors').html('');
         var formData = {'manual':manual}
        $http.post(BASE_URL+'report/reportgraphrevenue/graphdata',formData,{
		headers:{ 
                    'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
                    }
		 }).then(function(response) {
                if(response.status == 200){     
				$scope.graphData = response.data.data;
                $scope.monthly_revenue = $scope.graphData.last_year_revenue.month_wise;
                
                    Morris.Bar({
                     element: 'barColors',
                     data: [
                             {x: 'Jan', Clicks: $scope.monthly_revenue[0] },
                             {x: 'Feb', Clicks: $scope.monthly_revenue[1]},
                             {x: 'Mar', Clicks: $scope.monthly_revenue[2]},
                             {x: 'Apr', Clicks: $scope.monthly_revenue[3]},
                             {x: 'May', Clicks: $scope.monthly_revenue[4]},
                             {x: 'Jun', Clicks: $scope.monthly_revenue[5]},
                             {x: 'Jul', Clicks: $scope.monthly_revenue[6]},
                             {x: 'Aug', Clicks: $scope.monthly_revenue[7]},
                             {x: 'Sep', Clicks: $scope.monthly_revenue[8]},
                             {x: 'Oct', Clicks: $scope.monthly_revenue[9]},
                             {x: 'Nov', Clicks: $scope.monthly_revenue[10]},
                             {x: 'Dec', Clicks: $scope.monthly_revenue[11]},	],
                     xkey: 'x',
                     ykeys: ['Clicks'],
                     labels: ['Total Revinue'],
                     resize: true,
                     gridLineColor: "#c1f8ff",
                     hideHover: "auto",
                     barColors:['#00bed5', '#CAB48F', '#00bed5'],
                 });
                    
                    return false
                }
			
            }, function errorCallback(response){});
     
     
    }
	$scope.getRevenueGraph(manual);
	
}


function sponser($scope, $http, $routeParams, $timeout,$window) {
    
    $scope.title 	= '';
    $scope.link 	= '';
    $scope.logophoto 	= '';
    $scope.sponsers     = '';
    
        $scope.onChange = function (files) {
		if(files[0] == undefined) return;
		$scope.fileExt = files[0].name.split(".").pop();
	}
	$scope.isImage = function(ext) {
		if(ext) {
			return ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png";
		}
	}  
        
       
	$scope.addSponser = function(){
		if( $scope.title == '' || $scope.link == '' )
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill all * mark feild. '
				});
				return false;
			}();
			return false;
		}
		
		var formData = new FormData();
		formData.append('title', $scope.title);
                formData.append('link', $scope.link);
                var files = document.getElementById('pic').files[0];
		formData.append('logophoto',files);
		
		
		$http.post(BASE_URL+'api/user/addSponser',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
                        if(result.success=="true"){
                        var Gritter = function () {
			$.gritter.add({
			title: 'Successfull',
			text: 'sponser added successfully.'
			});
			
			}();   
                        setTimeout(function(){ location.reload() }, 2000);
                        }
			
			}, function errorCallback(response){
		});
	};  
        
      
      
       $scope.getSponser = function()
       {
                var formData = "";
            	$http.post(BASE_URL+'api/user/getSponser',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200){
			$scope.sponsers = response.data.data;
                        var encrypted ;
                        for(var i = 0; i < $scope.sponsers.length; i++)
			{
			encrypted = $scope.encryptStr($scope.sponsers[i].id);
			$scope.sponsers[i]['id'] = encrypted;
			}
				
			}},
                        function errorCallback(response){
				$scope.sponsers = [];
                       }); 
        }
        
        $scope.sponserDisabled = function(sponserID, status)
	{
		
		var formData1 = {'id':$scope.setID(sponserID), 'status':status};
		$http.post(BASE_URL+'api/user/sponserDisabled',formData1,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				var result  = response.data;
				var Gritter = function () {
					if(status == 0)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'Sponser Status Disabled Now.'
						});
					}else if(status == 1)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'Sponser Status Enabled Now.'
						});
					}
					
					$scope.getSponser();
					return false;
				}();
			}
			
			}, function errorCallback(response){
			
		});
		
	}
        
        $scope.encryptStr = function(id)
	{
		var qry = id.toString();
		var encrypted = CryptoJS.AES.encrypt(qry, "KidyView");
		var str = encrypted.toString();
		if(str.indexOf("/") == -1) {
			return str;
		}
		else{
			return $scope.encryptStr(id);
		}
		
	};
        
         $scope.setID = function(id){
                var sid = '';
		var decrypted = CryptoJS.AES.decrypt(id, "KidyView");
		$scope.giftID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.giftID;
                return sid;
	};
        
	
        $scope.sponserDelete = function(id)
	{
          if(confirm('Are you sure to delete it?')) 
          {     
            var formData = new FormData();
            formData.append('id', $scope.setID(id))
            $http.post(BASE_URL+'api/user/deleteSponser',formData,{
                    headers:{
                            'Content-Type':undefined, 'x-api-key':xapikey,
                    }
                    }).then(function(response) {

                    if(response.status == 200)
                    {
                            var Gritter = function () {
                            $.gritter.add({
                                    title: 'Successfull',
                                    text: 'Sponser Deleted successfully.'
                            });
                                    $scope.getSponser();
                                    return false;
                            }();	
                    }
                    }, function errorCallback(response){

            });
          }
	}
        
        
        $scope.getSponser();
    
}


function editSponser($scope, $http, $routeParams, $timeout,$window) {
    
      var sid;
      $scope.title = "";
      $scope.link = "";
      $scope.logophoto 	= '';
      $scope.logo 	= '';
      
      
      
       $scope.onChange = function (files) {
                
		if(files[0] == undefined) return;
		$scope.fileExt = files[0].name.split(".").pop();
	}
	$scope.isImage = function(ext) {
		if(ext) {
			return ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png";
		}
	}  
      
      $scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.editID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.editID;
	};	
	$timeout($scope.setID(), 2000);
        
        $scope.getSchoolDetails = function()
	{
		var formData = {'id':sid}
		$http.post(BASE_URL+'api/user/getSponserDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.result = response.data.data;
				
				$scope.title 	= $scope.result.title;
				$scope.link 	= $scope.result.link;
				$scope.logo 	= $scope.result.pic;
		               
			}
			
			}, function errorCallback(response){
			
		});
		
	}
        
        
        $scope.updateSponser = function()
	{
                if( $scope.title == '' || $scope.link == '' )
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill all * mark feild. '
				});
				return false;
			}();
			return false;
		}
		
		var formData = new FormData();
                formData.append('id', sid);
		formData.append('title', $scope.title);
                formData.append('link', $scope.link);
                var files = document.getElementById('pic').files[0];
		formData.append('logophoto',files);
            
		
		$http.post(BASE_URL+'api/user/updateSponser',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
                                var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Sponser updated successfully.'
				});
					$window.location.href = '#!/sponser';
					return false;
				}();	
                        }
			}, function errorCallback(response){
			
		});
		
	}
        
        
      
       $scope.getSchoolDetails();  
    
}




function addcurrency($scope, $http, $routeParams, $timeout,$window) {
    
    $scope.currency_name 	= '';
    $scope.currency_code 	= '';
    $scope.currency_symbol 	= '';
    $scope.currency_rate 	= '';
    $scope.currency             = [];
    
        
        
       
	$scope.addCurrency = function(){
		if( $scope.currency_name == '' || $scope.currency_code == '' || $scope.currency_symbol == '' || $scope.currency_rate == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill all * mark feild. '
				});
				return false;
			}();
			return false;
		}
		
		var formData = new FormData();
		formData.append('currency_name', $scope.currency_name);
                formData.append('currency_code', $scope.currency_code);
                formData.append('currency_symbol', $scope.currency_symbol);
                formData.append('currency_rate', $scope.currency_rate);
          	$http.post(BASE_URL+'api/user/addCurrency',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
                        if(result.success=="true"){
                        var Gritter = function () {
			$.gritter.add({
			title: 'Successfull',
			text: 'Currency added successfully.'
			});
			
			}();   
                        setTimeout(function(){ location.reload() }, 1500);
                        }
			
			}, function errorCallback(response){
		});
	};  
        
      
      
       $scope.getCurrency = function()
       {
                var formData = "";
            	$http.post(BASE_URL+'api/user/getCurrency',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200){
			$scope.currency = response.data.data;
                        var encrypted ;
                        for(var i = 0; i < $scope.currency.length; i++)
			{
			encrypted = $scope.encryptStr($scope.currency[i].id);
			$scope.currency[i]['id'] = encrypted;
			}
				
			}},
                        function errorCallback(response){
				$scope.currency = [];
                       }); 
        }
        
        
        
        $scope.encryptStr = function(id)
	{
		var qry = id.toString();
		var encrypted = CryptoJS.AES.encrypt(qry, "KidyView");
		var str = encrypted.toString();
		if(str.indexOf("/") == -1) {
			return str;
		}
		else{
			return $scope.encryptStr(id);
		}
		
	};
        
         $scope.setID = function(id){
                var sid = '';
		var decrypted = CryptoJS.AES.decrypt(id, "KidyView");
		$scope.giftID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.giftID;
                return sid;
	};
        
	
        $scope.currencyDelete = function(id)
	{
          if(confirm('Are you sure to delete it?')) 
          {     
            var formData = new FormData();
            formData.append('id', $scope.setID(id))
            $http.post(BASE_URL+'api/user/deleteCurrency',formData,{
                    headers:{
                            'Content-Type':undefined, 'x-api-key':xapikey,
                    }
                    }).then(function(response) {

                    if(response.status == 200)
                    {       
                           var logs  = response.data;
                           console.log(response.data);
                            var Gritter = function () {
                            $.gritter.add({
                                    title: logs.data,
                                    text: logs.message
                            });
                                    $scope.getCurrency();
                                    return false;
                            }();	
                    }
                    }, function errorCallback(response){

            });
          }
	}
        
        
        $scope.getCurrency();
    
}




function editcurrency($scope, $http, $routeParams, $timeout,$window) {
    
      var sid;
      $scope.currency_name 	= '';
      $scope.currency_code 	= '';
      $scope.currency_symbol 	= '';
      $scope.currency_rate 	= '';
      
      $scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.editID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.editID;
	};	
	$timeout($scope.setID(), 2000);
        
        $scope.getCurrencyDetails = function()
	{
		var formData = {'id':sid}
		$http.post(BASE_URL+'api/user/getCurrencyDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.result = response.data.data;
				
				$scope.currency_name 	= $scope.result.currency_name;
				$scope.currency_code 	= $scope.result.currency_code;
				$scope.currency_symbol 	= $scope.result.currency_symbol;
                                $scope.currency_rate 	= $scope.result.currency_rate;
		               
			}
			
			}, function errorCallback(response){
			
		});
		
	}
        
        
        $scope.updateCurrency = function()
	{
               if( $scope.currency_name == '' || $scope.currency_code == '' || $scope.currency_symbol == '' || $scope.currency_rate == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill all * mark feild. '
				});
				return false;
			}();
			return false;
		}
		
		var formData = new FormData();
                formData.append('id', sid);
		formData.append('currency_name', $scope.currency_name);
                formData.append('currency_code', $scope.currency_code);
                formData.append('currency_symbol', $scope.currency_symbol);
                formData.append('currency_rate', $scope.currency_rate);
            
		
		$http.post(BASE_URL+'api/user/updateCurrency',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
                                var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Currency updated successfully.'
				});
					$window.location.href = '#!/add-currency';
					return false;
				}();	
                        }
			}, function errorCallback(response){
			
		});
		
	}
        
       $scope.getCurrencyDetails(); 
    
}


function mapcurrency($scope, $http, $routeParams, $timeout,$window) {
    
  
    $scope.currencycode       = "";
    $scope.countrycode          = "";
    
       
	$scope.mapCurrency = function(){
            
		if( $scope.currencycode == '' || $scope.countrycode == '' )
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill all * mark feild. '
				});
				return false;
			}();
			return false;
		}
		
		var formData = new FormData();
		formData.append('currencycode', $scope.currencycode);
                formData.append('countrycode', $scope.countrycode);
            	$http.post(BASE_URL+'api/user/mapcurrency',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
                        if(result.success=="true"){
                        var Gritter = function () {
			$.gritter.add({
			title: 'Successfull',
			text: 'Currency added successfully.'
			});
			
			}();   
                        $scope.getContentList($('#countrycode').val());
                        }
			
			}, function errorCallback(response){
		});
	};  
        
      
      
     $scope.getUnMapCurrency = function(countryID)
     {
        
        var formData = {'countryID':countryID};
        $http.post(BASE_URL+'api/user/getUnMapCurrency',formData,{
                headers:{
                'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
                }
                }).then(function(response) {
                if(response.status == 200){
                $scope.currency = response.data.data;
                }},
                function errorCallback(response){
                        $scope.currency = [];
               }); 
        }
        
     $scope.countryCode = function()
    {
                var formData = {};
		
		$http.post(BASE_URL+'api/user/getCountryCode',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200){
                            $scope.countryCodes = response.data.data;
                        }},
                        function errorCallback(response){
				$scope.countryCodes = [];
                       }); 
                 
    }
    
    $scope.getCurrencyList = function(countryID)
    {
                  
                var formData = {'countryID':countryID};
            	$http.post(BASE_URL+'api/user/getCurrencyList',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200){
			$scope.currencylist = response.data.data;
                   	}},
                        function errorCallback(response){
                        $scope.currencylist = [];
                       }); 
     }
     
     
   $scope.unMapCurrency = function(id)
   {
          if(confirm('Are you sure to delete it?')) 
          {     
            var formData = new FormData();
            formData.append('id', id)
            $http.post(BASE_URL+'api/user/unMapCurrency',formData,{
                    headers:{
                            'Content-Type':undefined, 'x-api-key':xapikey,
                    }
                    }).then(function(response) {

                    if(response.status == 200)
                    {       
                           var logs  = response.data;
                           console.log(response.data);
                            var Gritter = function () {
                            $.gritter.add({
                                    title: logs.data,
                                    text: logs.message
                            });
                                    
                                    $scope.getContentList($('#countrycode').val());
                                    return false;
                            }();	
                    }
                    }, function errorCallback(response){

            });
          }
    }  
    
    $scope.getContentList = function(countryid) {
        $scope.getCurrencyList(countryid);
        $scope.getUnMapCurrency(countryid);
    }
    $scope.countryCode(); 
        
    
}

function transactionLlist($scope, $http, $routeParams, $timeout,$window) 
{
    
        var sid;
	$scope.schoolID = '';
        $scope.transactionList = [];
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.schoolID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.schoolID;
	};	
	$timeout($scope.setID(), 2000);
        //console.log(sid);
    
        $scope.transactionLlist = function(id)
        {

                   
            var formData = new FormData();
            formData.append('schoolID', sid)
            $http.post(BASE_URL+'api/user/getTransactionList',formData,{
                    headers:{
                            'Content-Type':undefined, 'x-api-key':xapikey,
                    }
                    }).then(function(response) {

                    if(response.status == 200)
                    {       
                     $scope.transactionList  = response.data.data;
                    }
                    }, function errorCallback(response){

            });
                

        }
        $scope.transactionLlist();
}
function notificationListCtrl($scope, $http, $route, $window) 
{
	$scope.getAllNotification = function()
	{
		$scope.encryptStr = function(id)
		{
		var qry = id.toString();
		var encrypted = CryptoJS.AES.encrypt(qry, "KidyView");
		var str = encrypted.toString();
		if(str.indexOf("/") == -1) {
		return str;
		}
		else{
		return $scope.encryptStr(id);
		}

		};
		$scope.notificationData=[];
		var formData = {'schoolID':''}
		$http.post(BASE_URL+'api/admin/notification/getAllNotification',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{  
				$scope.notificationData = response.data.data;
				var encrypted;
				for(var i = 0; i < $scope.notificationData.length; i++)
				{
					var idSplit=$scope.notificationData[i].sender_id.split('-');
					idSplit=idSplit[1];
					encrypted = $scope.encryptStr(idSplit);
					var iconText = $scope.notificationData[i].name.match(/\b(\w)/g); // ['J','S','O','N']
					iconText = iconText.join('');
					if($scope.notificationData[i].user_type=='Teacher'){
						$scope.notificationData[i]['senderUrl'] = '';
					}else if($scope.notificationData[i].user_type=='Student'){
						$scope.notificationData[i]['senderUrl'] = 'student-details/'+encrypted;
					}
					$scope.notificationData[i]['iconText'] = angular.uppercase(iconText);
				}
				
			}
			}, function errorCallback(response){
				$scope.notificationData=[];
		});
		
	}
	$scope.getAllNotification();
	$scope.updateNotification = function(id)
	{
		var formData = {'id':id}
		$http.post(BASE_URL+'api/admin/notification/updateNotification',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{  
			
			}
			}, function errorCallback(response){

		});
	}
	$scope.deleteNotification = function()
	{
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':''};
			$http.post(BASE_URL+'api/admin/notification/deleteNotification',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey
				}
				}).then(function(response) {
				
				if(response.status == 200)
				{
					var result  = response.data;
					var Gritter = function () {
						$.gritter.add({
							title: 'Successfull',
							text: ' deleted successfully.'
						});
						return false;
					}();
					$window.location.reload();
					return false;
				}
				
				}, function errorCallback(response){
				
			});
		}
	}
}
function payment($scope, $http, $routeParams, $timeout,$window) {
   
	$scope.parent ={classSectionList:"",schoolLists:"",countryCodes:"",fromdate:"",todate:""};
	 $scope.schoolLists = [];
	 $scope.classSectionList = [];  
	 $scope.countryCodes = [];
	 $scope.searchingData = false;
	 $scope.pageSize = 10;
	 $scope.allSchoolList = [];
	 
	 
	 $scope.countryCode = function()
	 {
				 var formData = {};
		 
		 $http.post(BASE_URL+'report/reportrevenue/getCountryList',formData,{
			 headers:{
			 'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			 }
			 }).then(function(response) {
			 
			 if(response.status == 200){
							 $scope.countryCodes = response.data.data;
						 }},
						 function errorCallback(response){
				 $scope.countryCodes = [];
						}); 
				  
	   }
	 
	 $scope.getAllSchool = function(countryID)
	 {
		 $scope.allSchoolList=[];
	 var formData = {'countryID':countryID};
		 $http.post(BASE_URL+'report/reportrevenue/getAllSchool',formData,{
			 headers:{
			 'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			 }
			 }).then(function(response) {
			 
			 if(response.status == 200){
				 $scope.schoolLists = response.data.data;
								 for(var i=0;i<$scope.schoolLists.length;i++){
								 $scope.allSchoolList[i] = $scope.schoolLists[i]['id'];
								 }
								 //console.log($scope.schoolLists);
				 }},
						 function errorCallback(response){
							 $scope.allSchoolList = [];
						}); 
				  
	   }
			  
			
	   $scope.getAllSectionClass = function(schoolid)
		{
				// var formData = {getAllSectionClass:'getAllSectionClass'};
				 var formData = {'userType':'teacher','schoolid':schoolid};
		 $http.post(BASE_URL+'report/reportrevenue/getAllSectionClass',formData,{
			 headers:{
			 'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			 }
			 }).then(function(response) {
			 if(response.status == 200){
			 $scope.classSectionList = response.data.data;
				 
			 }},
						 function errorCallback(response){
				 $scope.classSectionList = [];
						}); 
		 }
			  
	  $scope.getReport = function()
	  {
			$scope.searchingData = [];
			var classSectionList     =   $scope.parent.classSectionList;
			var schoolLists          =   $scope.parent.schoolLists;
			var countryCodes         =   $scope.parent.countryCodes;
			var fromdate             =   $('#fromdate').val();
			var todate               =   $('#todate').val();
			
			 if(schoolLists.length>0){
			 var schoolLists = schoolLists;    
			 }
			 else {
			 var schoolLists = $scope.allSchoolList;    
			 } 
			
			var formData = {'classSectionList':classSectionList,'schoolLists':schoolLists,'countryCodes':countryCodes,'fromdate':fromdate,'todate':todate};
			//console.log();
			 if(countryCodes.length>0 ){
			  
		 $http.post(BASE_URL+'report/reportrevenue/getReport',formData,{
		 headers:{ 
					 'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
					 }
		  }).then(function(response) {
				 if(response.status == 200){     
				 $scope.searchingData = response.data.data;
				 console.log($scope.searchingData);
				 return false
				 }
			 
			 }, function errorCallback(response){});
			 $scope.searchingData=[];
			 }
			 else {
			   var Gritter = function () {
				 $.gritter.add({
						 title: 'Searching Error',
						 text: 'Please Seclect Country.'
				 });
				 $scope.searchingData=[];
				 return false;
				 }();
			 }
			
	 };
		 
	  $scope.exportCSV = function()
	  {
		  var searchingData = $scope.searchingData;
		  var userdata = [];
		  console.log(searchingData);
		  if(searchingData.length>0){
		  for(var i=0;i<searchingData.length;i++){
			
			 var name = searchingData[i]['school_name']; 
			 var email = searchingData[i]['email'];
			 var address = searchingData[i]['location'];
			 var city = searchingData[i]['city'];
			 var pincode = searchingData[i]['pincode'];
			 var subcription = searchingData[i]['subTitle'];
			 var valid = searchingData[i]['validity'];
			 var amount = searchingData[i]['amount'];
			 console.log(amount);
			 var period = searchingData[i]['period'];
			 
			 userdata[i] = [name.replace(/,|\n|_/g,'/'),email.replace(/,|\n|_/g,'/'),address.replace(/,|\n|_/g,'/'),city.replace(/,|\n|_/g,'/'),pincode.replace(/,|\n|_/g,'/'),subcription.replace(/,|\n|_/g,'/'),valid.replace(/,|\n|_/g,'/'),amount,period.replace(/,|\n|_/g,'/')]
			}
			 console.log(userdata);
			 
				 var csv = 'School Name,Email,Address,City,Pincode,Subscription plan,Subscription validity,Subscription amount (NGN),Subscription period\n';
				 userdata.forEach(function(row) {
				 csv += row.join(',');
				 csv += "\n";
				 });
 
				 console.log(csv);
				 var hiddenElement = document.createElement('a');
				 hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
				 hiddenElement.target = '_blank';
				 hiddenElement.download = 'payment.csv';
				 hiddenElement.click();
		  }
	 };
		 
	   //$scope.getAllSectionClass();   
	   $scope.getAllSchool();
	   $scope.countryCode();
	
 }