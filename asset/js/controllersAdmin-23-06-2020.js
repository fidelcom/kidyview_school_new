
'use strict';

//Controllers
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

function editSchoolCtrl($scope, $http, $routeParams, $timeout) 
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
				$scope.getSchoolDetails();
				return false;
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
function getAllGoalCtrl($scope, $http, $routeParams, $timeout, $window) 
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
		if($scope.title == '' || $scope.points == '' || $scope.amount == '' || $scope.brand == '')
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
		formData.append('points', $scope.points);
		formData.append('amount', $scope.amount);
		formData.append('brand', $scope.brand);
		
		var files = document.getElementById('pic').files[0];
		formData.append('pic',files);
		
		$http.post(BASE_URL+'api/user/addGift',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Gift added successfully.'
				});
				$window.location.href = '#!/gift-list';
				return false;
			}();
			
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
				$scope.pic 		= $scope.giftinfo.image;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getGiftDetails(); 
	
	$scope.onChange = function (files) {
		if(files[0] == undefined) return;
		$scope.fileExt = files[0].name.split(".").pop();
	}
	$scope.isImage = function(ext) {
		if(ext) {
			return ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png";
		}
	}
	$scope.editGift = function(){
		
		if($scope.title == '' || $scope.points == '' || $scope.amount == '' || $scope.brand == '')
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
		formData.append('id', $scope.giftID);
		formData.append('title', $scope.title);
		formData.append('description', $scope.description);
		formData.append('points', $scope.points);
		formData.append('amount', $scope.amount);
		formData.append('brand', $scope.brand);
		
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


function editRoleCtrl($scope, $http, $routeParams, $timeout) 
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
				$scope.getRoleDetails();
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
		/*var retn=1
		var checlPrivilege=JSON.parse(jsonPrivilege);
		if(jsonPrivilege.length>0){
			if(checlPrivilege.Privilege['delete']==0){
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
		}*/
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


function editPrivilegeCtrl($scope, $http, $routeParams, $timeout) 
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
				$scope.getRoleDetails();
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