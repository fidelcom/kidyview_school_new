
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
	
	$scope.getAllSchoolsForDashboard = function()
	{
		
		$http.get(BASE_URL+'api/user/getAllSchoolsForDashboard',{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.schoolListing = response.data.data;
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
	$scope.getAllSchoolsForDashboard();
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

function editSchoolCtrl($scope, $http, $routeParams, $timeout,$window) 
{
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
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getSchoolDetails();
	$scope.updateProfileSchool = function()
	{
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
	
}
function addSchoolCtrl($scope, $http, $window) 
{
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
	$scope.pic 			= '';
	
	
	$scope.addSchool = function(){
		
		if($scope.schoolname == '' || $scope.email == '' || $scope.avgStudent == '' || $scope.location == '' || $scope.phone == '' || $scope.avgStaff == '' || $scope.city == '' || $scope.state == '' || $scope.pincode == '')
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
		if($scope.discount_type!=''){
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