
'use strict';

//Controllers
function HomeCtrl($scope, $http) 
{
	$scope.search 				= '';
	$scope.limit 				= 9999;
	$scope.page 				= 1;
	
	$scope.userTeamList 		= false;
	
	$scope.encryptStr = function(id)
	{
		var qry = id.toString();
		var encrypted = CryptoJS.AES.encrypt(qry, "Amistos");
		var str = encrypted.toString();
		if(str.indexOf("/") == -1) {
			return str;
		}
		else{
			return $scope.encryptStr(id);
		}
		
	};
	
	$scope.getUserTeamList 		= function()
	{
		$http.get(BASE_URL+'/api/team/teamList?page='+$scope.page+'&limit='+$scope.limit, {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.userTeamList = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.userTeamList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.userTeamList[i].team_id);
					$scope.userTeamList[i]['teamID'] = encrypted;
				}
			}
			
			}, function errorCallback(response){
			
		});
	}
	
	$scope.viewby = 4;
	$scope.totalItems = $scope.userTeamList.length;
	$scope.currentPage = 1;
	$scope.itemsPerPage = $scope.viewby;
	$scope.maxSize = 5;
	
	$scope.setPage = function (pageNo) {
		$scope.currentPage = pageNo;
	};
	
	$scope.pageChanged = function() {
		//console.log('Page changed to: ' + $scope.currentPage);
	};
	
	$scope.setItemsPerPage = function(num) {
		$scope.itemsPerPage = num;
		$scope.currentPage = 1;
	}
	
	$scope.getUserTeamList();
}

function TeamCtrl($scope, $http) 
{
	
}

function CreateTeamCtrl($scope, $http) 
{
	$scope.userinfo 		= false;
	
    $scope.getUserTDetail 		= function()
	{
		$http.get(BASE_URL+'/api/user/user', {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
            
			if(response.status == 200)
			{
				$scope.userinfo = response.data.data;				
			}
			
			}, function errorCallback(response){
			
		});
	}
	
	$scope.getUserTDetail();
	
	$scope.levelList 		= false;
	
    $scope.getPlayLevel 		= function()
	{
		$http.get(BASE_URL+'/api/Level/levelList', {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
            
			if(response.status == 200)
			{
				$scope.levelList = response.data.data;				
			}
			
			}, function errorCallback(response){
		});
	}
	
	$scope.getPlayLevel();
	
	
	$scope.ageGroupList 		= false;
	
    $scope.getAgeGroup 		= function()
	{
		$http.get(BASE_URL+'/api/AgeGroup/ageGroupList', {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
            
			if(response.status == 200)
			{
				$scope.ageGroupList = response.data.data;				
			}
			
			}, function errorCallback(response){
		});
	}
	
	$scope.getAgeGroup();
	
	$scope.sportsList 		= false;
	
    $scope.getSportList 		= function()
	{
		$http.get(BASE_URL+'/api/Sports/sportsList', {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
            
			if(response.status == 200)
			{
				$scope.sportsList = response.data.data;				
			}
			
			}, function errorCallback(response){
		});
	}
	
	$scope.getSportList();
	
	$scope.add = function(){
		$scope.is_active = 1;
		$scope.min_age = 0;
		$scope.max_age = 100;
		
		var formData = new FormData();
		formData.append( 'team_name', $scope.team_name );
		formData.append( 'sports', $scope.sports);
		formData.append( 'age_group', $scope.age_group);
		formData.append( 'gender', $scope.gender);
		formData.append( 'level', $scope.level);
		formData.append( 'home', $scope.home);
		formData.append( 'min_age', $scope.min_age);
		formData.append( 'max_age', $scope.max_age);
		formData.append( 'time_zone', $scope.time_zone);
		formData.append( 'is_active', $scope.is_active);
		formData.append( 'user_role', $scope.user_role);
		
		var files = document.getElementById('team_logo').files[0];
		formData.append('team_logo',files);
		
		
		
		$http.post(BASE_URL+'api/team/createTeam',formData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function (response) {
			var result  = response.data;
			
			if(result.success == 'true')
			{
				$scope.team_name="";
				$scope.sports="";
				$scope.age_group="";
				$scope.gender="";
				$scope.level="";
				$scope.home="";
				$scope.min_age="";
				$scope.max_age="";
				$scope.time_zone="";
				$scope.is_active="";
				$scope.user_role="";
				$scope.team_logo="";
				
			}
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Team successfully created.'
				});
				return false;
			}();
			
            }, function errorCallback(){
			
		});
		
		
	};
	
}

function EditTeamCtrl($scope, $http, $routeParams,$timeout) 
{
	$scope.userinfo 		= false;
	var tid;
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "Amistos");
		$scope.teamID = decrypted.toString(CryptoJS.enc.Utf8);
		tid = $scope.teamID;
	};	
	
	$timeout($scope.setID(), 2000);
	
	$scope.getTeamDetail = function()
	{
		
		$http.get(BASE_URL+"api/team/getTeam/"+tid, {headers:{'token':TOKEN,}}).then(function(response) {
			
			$scope.eteamDetail = response.data.data;
			
			$scope.team_name = $scope.eteamDetail.team_name;
			$scope.user_role = $scope.eteamDetail.user_role;
			$scope.sports = $scope.eteamDetail.sports;
			$scope.age_group = $scope.eteamDetail.age_group;
			$scope.gender = $scope.eteamDetail.gender;
			$scope.level = $scope.eteamDetail.level;
			$scope.home = $scope.eteamDetail.home;
			$scope.time_zone = $scope.eteamDetail.time_zone;
			$scope.team_logo = $scope.eteamDetail.team_logo;
			
		});
	}
	$scope.getTeamDetail();
	
	$scope.getUserTDetail 		= function()
	{
		$http.get(BASE_URL+'/api/user/user', {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.userinfo = response.data.data;				
			}
			
			}, function errorCallback(response){
			
		});
	}
	
	$scope.getUserTDetail();
	
	$scope.levelList 		= false;
	
    $scope.getPlayLevel 		= function()
	{
		$http.get(BASE_URL+'/api/Level/levelList', {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
            
			if(response.status == 200)
			{
				$scope.levelList = response.data.data;				
			}
			
			}, function errorCallback(response){
		});
	}
	
	$scope.getPlayLevel();
	
	
	$scope.ageGroupList 		= false;
	
    $scope.getAgeGroup 		= function()
	{
		$http.get(BASE_URL+'/api/AgeGroup/ageGroupList', {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
            
			if(response.status == 200)
			{
				$scope.ageGroupList = response.data.data;				
			}
			
			}, function errorCallback(response){
		});
	}
	
	$scope.getAgeGroup();
	
	$scope.sportsList 		= false;
	
    $scope.getSportList 		= function()
	{
		$http.get(BASE_URL+'/api/Sports/sportsList', {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
            
			if(response.status == 200)
			{
				$scope.sportsList = response.data.data;				
			}
			
			}, function errorCallback(response){
		});
	}
	
	$scope.getSportList();
	
	$scope.updateTeam = function(){
		$scope.is_active = 1;
		$scope.min_age = 0;
		$scope.max_age = 100;
		
		var formData = new FormData();
		formData.append( 'team_name', $scope.team_name );
		formData.append( 'sports', $scope.sports);
		formData.append( 'age_group', $scope.age_group);
		formData.append( 'gender', $scope.gender);
		formData.append( 'level', $scope.level);
		formData.append( 'home', $scope.home);
		formData.append( 'min_age', $scope.min_age);
		formData.append( 'max_age', $scope.max_age);
		formData.append( 'time_zone', $scope.time_zone);
		formData.append( 'is_active', $scope.is_active);
		formData.append( 'user_role', $scope.user_role);
		formData.append( 'team_id', $scope.teamID);
		
		var files = document.getElementById('team_logo').files[0];
		formData.append('team_logo',files);
		
		
		
		$http.post(BASE_URL+'api/team/updateTeam',formData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function (response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Team successfully Updated.'
				});
				$scope.getTeamDetail();
				return false;
			}();
			
            }, function errorCallback(){
		});
		
		
	};
	
}

function MatchFinderCtrl($scope, $http, $routeParams,$timeout) 
{
    $scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "Amistos");
		$scope.teamID = decrypted.toString(CryptoJS.enc.Utf8);
	};	
	
	$timeout($scope.setID(), 2000);
	
	$scope.levelList 		= false;
	
    $scope.getPlayLevel 		= function()
	{
		$http.get(BASE_URL+'api/Level/levelList', {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
            
			if(response.status == 200)
			{
				$scope.levelList = response.data.data;				
			}
			
			}, function errorCallback(response){
		});
	}
	
	$scope.getPlayLevel();
	
	
	$scope.ageGroupList 		= false;
	
    $scope.getAgeGroup 		= function()
	{
		$http.get(BASE_URL+'api/AgeGroup/ageGroupList', {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
            
			if(response.status == 200)
			{
				$scope.ageGroupList = response.data.data;				
			}
			
			}, function errorCallback(response){
		});
	}
	
	$scope.getAgeGroup();
	
	$scope.matchFinderinfo 		= false;
    $scope.getMatchFinderDetail 		= function()
	{
		$http.get(BASE_URL+'api/Matchfinder/matchFinderDetail/'+$scope.teamID, {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.matchFinderinfo = response.data.data;
				//console.log($scope.matchFinderinfo);
				$scope.gender = $scope.matchFinderinfo[0].gender;
				$scope.age_group = $scope.matchFinderinfo[0].age_group;
				$scope.level = $scope.matchFinderinfo[0].play_level;
				$scope.field_court = $scope.matchFinderinfo[0].field_selection;
				$scope.current_address = $scope.matchFinderinfo[0].address;
				$scope.search_within = $scope.matchFinderinfo[0].in_distance;
				$scope.zipcode = $scope.matchFinderinfo[0].zip_code;
				$scope.recieve_notification = $scope.matchFinderinfo[0].recieve_notification;
				if($scope.recieve_notification == 'on')
				{
					$scope.recieve_notification = true;	
					}else{
					$scope.recieve_notification = false;
				}
				
				$scope.recieve_sms = $scope.matchFinderinfo[0].recieve_sms;
				if($scope.recieve_sms == 'on')
				{
					$scope.recieve_sms = true;	
					}else{
					$scope.recieve_sms = false;
				}
			}
			
			$scope.addMtchFinderSetting = function(){
				
				if($scope.field_court == 'We\'ll come to you' && $scope.field_court.length == 1)
				{
					$scope.current_address = '';
				}
				if($scope.field_court == 'You come to us' && $scope.field_court.length == 1)
				{
					$scope.search_within = '';
					$scope.zipcode = '';
				}
				
				
				$scope.is_enabled = 1;
				$scope.lat = '';
				$scope.lng = '';
				$scope.min_age = 0;
				$scope.max_age = 100;
				
				if($scope.recieve_sms == true)
				{
					$scope.recieve_sms = 'on';
				}else if($scope.recieve_sms == false)
				{
					$scope.recieve_sms = 'off';
				}
				
				if($scope.recieve_notification == true)
				{
					$scope.recieve_notification = 'on';
				}else if($scope.recieve_notification == false)
				{
					$scope.recieve_notification = 'off';
				}
				
				var formData = {
					'team_id': $scope.teamID,
					'gender': $scope.gender,
					'age_group': $scope.age_group,
					'play_level': $scope.level,
					'age_max': $scope.max_age,
					'age_min': $scope.min_age,
					'address': $scope.current_address,
					'lat': $scope.lat,
					'lng': $scope.lng,
					'in_distance': $scope.search_within,
					'field_selection': $scope.field_court,
					'zip_code': $scope.zipcode,
					'recieve_notification': $scope.recieve_notification,
					'recieve_sms': $scope.recieve_sms,
					'is_enabled': $scope.is_enabled,
				};
				
				$http.put(BASE_URL+'api/Matchfinder/updateMatchsetting',formData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function (response) {
					var result  = response.data;			
					if(result.success == 'true')
					{
					}
					var Gritter = function () {
						$.gritter.add({
							title: 'Successfull',
							text: 'Match Finder Setting successfully updated.'
						});
						return false;
					}();
					
					}, function errorCallback(){
					
				});
				
				
			};
			
			
			
			}, function errorCallback(response){
			
			$scope.addMtchFinderSetting = function(){
				
				if($scope.field_court == 'We\'ll come to you' && $scope.field_court.length == 1)
				{
					$scope.current_address = '';
				}
				if($scope.field_court == 'You come to us' && $scope.field_court.length == 1)
				{
					$scope.search_within = '';
					$scope.zipcode = '';
				}
				
				
				$scope.is_enabled = 1;
				$scope.lat = '';
				$scope.lng = '';
				$scope.min_age = 0;
				$scope.max_age = 100;
				
				if($scope.recieve_sms == true)
				{
					$scope.recieve_sms = 'on';
				}else if($scope.recieve_sms == false)
				{
					$scope.recieve_sms = 'off';
				}
				
				if($scope.recieve_notification == true)
				{
					$scope.recieve_notification = 'on';
				}else if($scope.recieve_notification == false)
				{
					$scope.recieve_notification = 'off';
				}
				
				var formData = {
					'team_id': $scope.teamID,
					'gender': $scope.gender,
					'age_group': $scope.age_group,
					'play_level': $scope.level,
					'age_max': $scope.max_age,
					'age_min': $scope.min_age,
					'address': $scope.current_address,
					'lat': $scope.lat,
					'lng': $scope.lng,
					'in_distance': $scope.search_within,
					'field_selection': $scope.field_court,
					'zip_code': $scope.zipcode,
					'recieve_notification': $scope.recieve_notification,
					'recieve_sms': $scope.recieve_sms,
					'is_enabled': $scope.is_enabled,
				};
				
				$http.post(BASE_URL+'api/Matchfinder/addMatchsetting',formData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function (response) {
					var result  = response.data;			
					if(result.success == 'true')
					{
						$scope.gender = '';
						$scope.age_group = '';
						$scope.level = '';
						$scope.current_address = '';
						$scope.search_within = '';
						$scope.field_court = '';
						$scope.zipcode = '';
						$scope.recieve_notification = '';
						$scope.recieve_sms = '';
						$scope.is_enabled = '';		
					}
					
					
					//alert(result.message);
					var Gritter = function () {
						$.gritter.add({
							title: 'Successfull',
							text: 'Match Finder Setting successfully added.'
						});
						return false;
					}();
					
					}, function errorCallback(){
					
				});
				
				
			};
			
			
			
			
		});
	}
	
	$scope.getMatchFinderDetail();
	
}

function NewMatchCtrl($scope, $http, $filter, $routeParams,$timeout) 
{
    $scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "Amistos");
		$scope.teamID = decrypted.toString(CryptoJS.enc.Utf8);
	};	
	
	$timeout($scope.setID(), 2000);
	
	$scope.levelList 		= false;
	
    $scope.getPlayLevel 		= function()
	{
		$http.get(BASE_URL+'/api/Level/levelList', {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
            
			if(response.status == 200)
			{
				$scope.levelList = response.data.data;				
			}
			
			}, function errorCallback(response){
		});
	}
	
	$scope.getPlayLevel();
	
	
	$scope.ageGroupList 		= false;
	
    $scope.getAgeGroup 		= function()
	{
		$http.get(BASE_URL+'/api/AgeGroup/ageGroupList', {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
            
			if(response.status == 200)
			{
				$scope.ageGroupList = response.data.data;				
			}
			
			}, function errorCallback(response){
		});
	}
	
	$scope.getAgeGroup();
	
	$scope.sportsList 		= false;
	
    $scope.getSportList 		= function()
	{
		$http.get(BASE_URL+'/api/Sports/sportsList', {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
            
			if(response.status == 200)
			{
				$scope.sportsList = response.data.data;				
			}
			
			}, function errorCallback(response){
		});
	}
	
	$scope.getSportList();
	
	$scope.add = function(){
		if($scope.choose_opponent != 'Send invitation to specific team')
		{
			$scope.opponent_email = '';
		}
		if($scope.choose_opponent != ' MatchFinder')
		{
			$scope.gender = '';
			$scope.min_age = '';
			$scope.max_age = '';
			$scope.level = '';
			$scope.age_group = '';
		}
		if($scope.field_court == 'We\'ll come to you' && $scope.field_court.length == 1)
		{
			$scope.current_address = '';
		}
		if($scope.field_court == 'You come to us' && $scope.field_court.length == 1)
		{
			$scope.search_within = '';
			$scope.zipcode = '';
		}
		
		
		$scope.is_enabled = 1;
		$scope.lat = '';
		$scope.lng = '';
		$scope.min_age = 0;
		$scope.max_age = 100;
		
		var formData = {
			'name': $scope.match_name,
			'email': $scope.opponent_email,
			'opponent': $scope.choose_opponent,
			'field_selection': $scope.field_court,
			'age_max': $scope.max_age,
			'age_min': $scope.min_age,
			'date': $filter('date')($scope.match_date, 'MM-dd-yyyy'),
			'time': $filter('date')($scope.match_time, 'hh:mm a'),
			'gender': $scope.gender,
			'lat': $scope.lat,
			'lng': $scope.lng,
			'in_distance': $scope.search_within,
			'location': $scope.current_address,
			'age_group': $scope.age_group,
			'zip_code': $scope.zipcode,
			'play_lavel': $scope.level,
			'team_id': $scope.teamID,
			'notes': $scope.notes,
			'is_enabled': $scope.is_enabled,
		};
		
		$http.post(BASE_URL+'api/user/createMatch',formData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function (response) {
			var result  = response.data;			
			if(result.success == 'true')
			{
				$scope.match_name="";
				$scope.opponent_email="";
				$scope.choose_opponent="";
				$scope.field_court="";
				$scope.match_time="";
				$scope.match_date="";
				$scope.min_age="";
				$scope.max_age="";
				$scope.gender="";
				$scope.search_within="";
				$scope.current_address="";
				$scope.age_group="";
				$scope.zipcode="";
				$scope.level="";
				$scope.notes="";				
			}
			
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Match successfully created.'
				});
				return false;
			}();
			
            }, function errorCallback(){
			
		});
		
		
	};
	
	
}

function EditMatchCtrl($scope, $http, $filter, $routeParams,$timeout) 
{
    var tid;
	$scope.encMatchID = $routeParams.ID;
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "Amistos");
		$scope.matchID = decrypted.toString(CryptoJS.enc.Utf8);
		tid = $scope.matchID;
	};	
	
	$timeout($scope.setID(), 2000);
	
	$http.get(BASE_URL+"api/user/getMatchDetail/"+tid, {headers:{'token':TOKEN,}}).then(function(response) {
		
		$scope.matchDetail = response.data.data;
		var time = $scope.matchDetail[0].time;
		var hours = Number(time.match(/^(\d+)/)[1]);
		var minutes = Number(time.match(/:(\d+)/)[1]);
		var AMPM = time.match(/\s(.*)$/)[1];
		if(AMPM == "PM" && hours<12) hours = hours+12;
		if(AMPM == "AM" && hours==12) hours = hours-12;
		var sHours = hours.toString();
		var sMinutes = minutes.toString();
		if(hours<10) sHours = "0" + sHours;
		if(minutes<10) sMinutes = "0" + sMinutes;
		$scope.matchTiming = sHours + ":" + sMinutes;
		
		$scope.match_name = $scope.matchDetail[0].name;
		$scope.choose_opponent = $scope.matchDetail[0].opponent;
		$scope.match_date = new Date($scope.matchDetail[0].date);
		$scope.match_time = $scope.matchDetail[0].time;
		$scope.field_court = $scope.matchDetail[0].field_selection;
		$scope.current_address = $scope.matchDetail[0].location;
		$scope.search_within = $scope.matchDetail[0].in_distance;
		if($scope.matchDetail[0].zipcode != null)
		{
			$scope.zipcode = $scope.matchDetail[0].zipcode;
		}else
		{
			$scope.zipcode = "";
		}
		
		$scope.gender = $scope.matchDetail[0].gender;
		$scope.level = $scope.matchDetail[0].play_level;
		$scope.age_group = $scope.matchDetail[0].age_group;
		$scope.notes = $scope.matchDetail[0].notes;
		$scope.is_enabled = $scope.matchDetail[0].is_enabled;
		$scope.teamID = $scope.matchDetail[0].team_id;
		$scope.lat = $scope.matchDetail[0].lat;
		$scope.lng = $scope.matchDetail[0].lng;
		$scope.max_age = $scope.matchDetail[0].age_max;
		$scope.min_age = $scope.matchDetail[0].age_min;
		
	});
	
	$scope.updateMatch = function(){
		$scope.is_active = 1;
		$scope.min_age = 0;
		$scope.max_age = 100;
		
		var formData = {
			'name': $scope.match_name,
			'opponent': $scope.choose_opponent,
			'field_selection': $scope.field_court,
			'age_max': $scope.max_age,
			'age_min': $scope.min_age,
			'date': $filter('date')($scope.match_date, 'MM-dd-yyyy'),
			'time': $filter('date')($scope.match_time, 'hh:mm a'),
			'gender': $scope.gender,
			'lat': $scope.lat,
			'lng': $scope.lng,
			'in_distance': $scope.search_within,
			'location': $scope.current_address,
			'age_group': $scope.age_group,
			'zip_code': $scope.zipcode,
			'play_lavel': $scope.level,
			'team_id': $scope.teamID,
			'notes': $scope.notes,
			'is_enabled': $scope.is_enabled,
		};
		//console.log(formData); 
		$http.put(BASE_URL+'api/user/updateMatch/'+tid,formData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function (response) {
			var result  = response.data;
			if(result.success == 1)
			{
				//$scope.getTeamDetail();
			}
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Match successfully Updated.'
				});
				return false;
			}();
			
            }, function errorCallback(){
		});
		
		
	};
	
	
}

function GameDetailCtrl($scope, $http, $routeParams,$timeout, $window) 
{
	var tid;
	$scope.encMatchID = $routeParams.ID;
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "Amistos");
		$scope.matchID = decrypted.toString(CryptoJS.enc.Utf8);
		tid = $scope.matchID;
	};	
	
	$timeout($scope.setID(), 2000);
	
	$scope.userinfo 		= false;
	$scope.getUserTDetail 		= function()
	{
		$http.get(BASE_URL+'/api/user/user', {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.userinfo = response.data.data;
				$scope.userEmail = $scope.userinfo.email;
				$scope.userId = $scope.userinfo.user_id;
			}
			
			}, function errorCallback(response){
			
		});
	}
	
	$scope.getUserTDetail();
	
	var teamID;
	$scope.availablity = false;
	$scope.memberGoing = [];
	
	$http.get(BASE_URL+"api/user/getMatchDetail/"+tid, {headers:{'token':TOKEN,}}).then(function(response) {
		
		$scope.matchDetail = response.data.data;
		teamID = $scope.matchDetail[0].team_id;
		$scope.opponent_count = $scope.matchDetail[0].opponent_count;
		$scope.matchUserId = $scope.matchDetail[0].user_id;
		$scope.location = $scope.matchDetail[0].location;
		$scope.date = $scope.matchDetail[0].date;
		$scope.time = $scope.matchDetail[0].time;
		
		var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
		var monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
		
		var d = new Date($scope.date);
		$scope.dayName = days[d.getDay()];
		$scope.monthName = monthNames[d.getMonth()];
		$scope.exactDayName = $scope.dayName.split('').join(' ');
		
		var d = $scope.date;
		
		var b=d.slice(0,10);
		var c=b.split('-');
		var e=c[Symbol.iterator]();
		
		$scope.monthcount = e.next().value;
		$scope.daycount = e.next().value;
		
		$http.get(BASE_URL+"api/team/getTeam/"+teamID, {headers:{'token':TOKEN,}}).then(function(response) {
			
			$scope.eteamDetail = response.data.data;
			$scope.team_name = $scope.eteamDetail.team_name;
			$scope.team_id 	 = teamID;
			$scope.user_role = $scope.eteamDetail.user_role;
		});
		
		var formData = {
			'event_id': tid,
			'member_id': '',
		};
		
		$http.post(BASE_URL+'api/user/memberAvailability',formData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function (response) {
			$scope.availablity  = response.data.data;
			//console.log($scope.availablity);
			for(var i = 0; i < $scope.availablity.length; i++)
			{
				$scope.memberStatus = $scope.availablity[i].status;
				if($scope.memberStatus == 'Going')
				{
					$scope.memberGoing.push($scope.availablity[i].status);
				}
			}
			
			
			$scope.availablityCount = $scope.memberGoing.length;
			
		});
		
		var formopponentData = {
			'event_id': tid,
			'user_email': '',
			'team_id': '',
		};
		
		$http.post(BASE_URL+'api/team/opponentTeam',formopponentData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function (response) {
			$scope.opponentList  = response.data.data;
			//console.log($scope.opponentList);
		});
		
		
		
	});
	
	$scope.cancelMatch 			= function()
	{
		var formData = {
			'id': tid,
			'team_id': teamID,
			'user_id': $scope.userinfo.user_id,
		};
		$http.put(BASE_URL+'api/user/DidnotPlay',formData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function (response) {
			var result  = response.data;
			if(result.success == 1)
			{
				//$scope.getTeamDetail();
			}
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'You have canceled this match now.'
				});
				$window.location.href = 'user#!/';
				return false;
			}();
			
            }, function errorCallback(){
		});
	}
	
	$scope.playWithThisTeam 			= function(opponentTeamId, opponentEmailId)
	{
		var formData = {
			'event_id': tid,
			'team_id': opponentTeamId,
			'inviteduser_email': opponentEmailId,
			'status': "PlayWithThisTeam",
		};
		
		//console.log(formData);
		//return false;
		$http.post(BASE_URL+'api/user/playWithTeam',formData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function (response) {
			var result  = response.data;
			if(result.success == 1)
			{
				//$scope.getTeamDetail();
			}
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'You will play with this team now.'
				});
				
				var formopponentData = {
					'event_id': tid,
					'user_email': '',
					'team_id': '',
				};
				
				$http.post(BASE_URL+'api/team/opponentTeam',formopponentData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function (response) {
					$scope.opponentList  = response.data.data;
					//console.log($scope.opponentList);
				});
				
				return false;
			}();
			
            }, function errorCallback(){
		});
	}
	
	$scope.openChatModalPopup = function()
	{
		$('#myModalChat1').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}
	$scope.hideChatModalPopup = function()
	{
		$('#myModalChat1').modal('toggle');
	}
	
	$scope.saveMessage = function(messageText) {
	var toId = '1HvEsYDkuih10sOdorKDewBH2Cj2';
	// Add a new message entry to the Firebase database.
	if (firebase.auth().currentUser) {
	firebase.auth().onAuthStateChanged(function(user) {
		if (user) {
			var userUID = user.uid;
			$scope.b = '';
			var ref = firebase.database().ref("users/" + userUID);
			ref.once("value")
			  .then(function(snapshot) {
				$scope.b = snapshot.child("conversations/" + toId + "/location").exists();
				console.log($scope.b);
			});
			console.log($scope.b);
			return false;
			/* if(snapshot.exists()){
				var data = snapshot.value as! [String: String]
                var location = data["location"]!	
				
				
			} */
			
			firebase.database().ref('/conversations/').push({
			content: messageText,
			fromID: userUID,
			isRead: true,
			timestamp: Date.now(),
			toID: toId,
			type: "text"
			
			}).then((response) => {
			  const key = response.key;
			  console.log(key);
				if (key) {
					firebase.database().ref('users/' + userUID +'/conversations/' + toId).set({
						location: key
					});
				}
			});
			 
			
		 }
	 });
	}
	
}

$scope.displayMessage = function(key, name, text, picUrl, imageUrl) {
	var div = document.getElementById(key);
	// If an element for that message does not exists yet we create it.
	if (!div) {
		var container = document.createElement('div');
		container.innerHTML = MESSAGE_TEMPLATE;
		div = container.firstChild;
		div.setAttribute('id', key);
		messageListElement.appendChild(div);
	}
	if (picUrl) {
		div.querySelector('.pic').style.backgroundImage = 'url(' + picUrl + ')';
	}
	div.querySelector('.name').textContent = name;
	var messageElement = div.querySelector('.message');
	if (text) { // If the message is text.
		messageElement.textContent = text;
		// Replace all line breaks by <br>.
		messageElement.innerHTML = messageElement.innerHTML.replace(/\n/g, '<br>');
		} else if (imageUrl) { // If the message is an image.
		var image = document.createElement('img');
		image.addEventListener('load', function() {
			messageListElement.scrollTop = messageListElement.scrollHeight;
		});
		image.src = imageUrl + '&' + new Date().getTime();
		messageElement.innerHTML = '';
		messageElement.appendChild(image);
	}
	// Show the card fading-in and scroll to view the new message.
	setTimeout(function() {div.classList.add('visible')}, 1);
	messageListElement.scrollTop = messageListElement.scrollHeight;
	messageInputElement.focus();
}
	
	
	
}

function TeamDashboardCtrl($scope, $http, $routeParams,$timeout) 
{
	$scope.userinfo 		= false;
	
	$scope.getUserTDetail 		= function()
	{
		$http.get(BASE_URL+'/api/user/user', {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.userinfo = response.data.data;
			}
			
			}, function errorCallback(response){
			
		});
	}
	
	$scope.getUserTDetail();
	
	var tid;
	$scope.encteamID = $routeParams.ID;
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "Amistos");
		$scope.teamID = decrypted.toString(CryptoJS.enc.Utf8);
		tid = $scope.teamID;
	};	
	
	$timeout($scope.setID(), 2000);
	
	$scope.matchFinderinfo 		= false;
    $scope.getMatchFinderDetail 		= function()
	{
		$http.get(BASE_URL+'api/Matchfinder/matchFinderDetail/'+tid, {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.matchFinderinfo = response.data.data;
				//console.log($scope.matchFinderinfo);
				$scope.is_enabled = $scope.matchFinderinfo[0].is_enabled;
				
				if($scope.is_enabled == '1')
				{
					$scope.is_enabled = true;	
					}else{
					$scope.is_enabled = false;
				}
				
			}
			
			
			
			}, function errorCallback(response){
			
		});
	}
	
	$scope.getMatchFinderDetail();
	
	$scope.updateMatchFinderStatus 			= function(status)
	{
		//console.log(status);
		if(status == true)
		{
			$scope.matchFinderStatus = '1';	
			}else{
			$scope.matchFinderStatus = '0';
		}
		var formData = {
			'team_id': tid,
			'is_enabled': $scope.matchFinderStatus,
		};
		$http.put(BASE_URL+'api/Matchfinder/updateMatchsettingStatus',formData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function (response) {
			var result  = response.data;
			if(result.success == 1)
			{
				//$scope.getTeamDetail();
			}
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Match Finder Setting Status Successfully Updated.'
				});
				return false;
			}();
			
            }, function errorCallback(){
		});
		
		
		
		
	}
	
	
	$http.get(BASE_URL+"api/team/getTeam/"+tid, {headers:{'token':TOKEN,}}).then(function(response) {
		
		$scope.eteamDetail = response.data.data;
		
		$scope.team_name = $scope.eteamDetail.team_name;
		$scope.user_role = $scope.eteamDetail.user_role;
		$scope.sports = $scope.eteamDetail.sports;
		$scope.age_group = $scope.eteamDetail.age_group;
		$scope.gender = $scope.eteamDetail.gender;
		$scope.level = $scope.eteamDetail.level;
		$scope.home = $scope.eteamDetail.home;
		$scope.time_zone = $scope.eteamDetail.time_zone;
		$scope.team_logo = $scope.eteamDetail.team_logo;
	});
	
	
	$scope.search 				= '';
	$scope.limit 				= 9999;
	$scope.page 				= 1;
	
	$scope.teamMatchList 		= new Array();
	
	$scope.encryptStr = function(id)
	{
		var qry = id.toString();
		var encrypted = CryptoJS.AES.encrypt(qry, "Amistos");
		var str = encrypted.toString();
		if(str.indexOf("/") == -1) {
			return str;
		}
		else{
			return $scope.encryptStr(id);
		}
		
	};
	$scope.opponentList = false;
	//$scope.mainMatchList = [];
	$scope.getteamMatchList 		= function()
	{
		$http.get(BASE_URL+"api/user/matchList/"+tid+"?page="+$scope.page+"&limit="+$scope.limit, {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
			
			$scope.teamMatchList = response.data.data;
			
			var formopponentData = {
				'user_email': $scope.userinfo.email,
				'event_id': '',
				'team_id': tid,
			};
			//console.log(formopponentData);
			$http.post(BASE_URL+'api/team/opponentTeam',formopponentData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function (response) {
				$scope.opponentList  = response.data.data;
				if($scope.opponentList == null)
				{
					$scope.teamMatchList = $scope.teamMatchList;
					
					Date.prototype.toShortFormat = function() {
						
						var month_names =["01","02","03","04","05","06","07","08","09","10","11","12"];
						
						var day = this.getDate();
						var month_index = this.getMonth();
						var year = this.getFullYear();
						
						return "" + month_names[month_index] + "-" + day + "-" + year;
					}
					
					var today = new Date();
					$scope.todayDate = today.getTime();
					var encrypted;
					for(var i = 0; i < $scope.teamMatchList.length; i++)
					{
						encrypted = $scope.encryptStr($scope.teamMatchList[i].id);
						$scope.teamMatchList[i]['matchID'] = encrypted;
						$scope.teamMatchList[i]['date_format'] = Date.parse($scope.teamMatchList[i]['date']);
					}
				}
				else
				{
					Array.prototype.push.apply($scope.teamMatchList,$scope.opponentList);
					
					Date.prototype.toShortFormat = function() {
						
						var month_names =["01","02","03","04","05","06","07","08","09","10","11","12"];
						
						var day = this.getDate();
						var month_index = this.getMonth();
						var year = this.getFullYear();
						
						return "" + month_names[month_index] + "-" + day + "-" + year;
					}
					
					var today = new Date();
					$scope.todayDate = today.getTime();
					var encrypted;
					for(var i = 0; i < $scope.teamMatchList.length; i++)
					{
						encrypted = $scope.encryptStr($scope.teamMatchList[i].id);
						$scope.teamMatchList[i]['matchID'] = encrypted;
						$scope.teamMatchList[i]['date_format'] = Date.parse($scope.teamMatchList[i]['date']);
					}
				}
				
				
			});
			}, function errorCallback(response){
			
		});
	}
	
	$scope.getteamMatchList();
	
	$scope.didnotPlay 			= function(matchID)
	{
		var formData = {
			'id': matchID,
			'team_id': tid,
			'user_id': $scope.userinfo.user_id,
		};
		
		//console.log(formData);
		//return false;
		$http.put(BASE_URL+'api/user/DidnotPlay',formData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function (response) {
			var result  = response.data;
			if(result.success == 1)
			{
				//$scope.getTeamDetail();
			}
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'You Did not play this game.'
				});
				$scope.getteamMatchList();
				return false;
			}();
			
            }, function errorCallback(){
		});
	}
	$scope.openRateModalPopup = function(TeamID, EventId, createdTeamName, createdTeamLogo)
	{
		//$("#myModalRate").modal('show');
		$('#myModalRate').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
		$scope.rateTeamId 		= TeamID;
		$scope.rateEventId 		= EventId;
		$scope.createdTeamName 	= createdTeamName;
		$scope.createdTeamLogo 	= createdTeamLogo;
	}
	$scope.ratingval = '';
	$scope.setRatingValue = function(ratingVal)
	{
		$scope.ratingval = ratingVal;
	}
	
	$scope.hideRateModalPopup = function()
	{
		$('#myModalRate').modal('toggle');
		$scope.rateTeamId 		= '';
		$scope.rateEventId 		= '';
		$scope.commentForTeam 	= '';
		$scope.ratingval 		= '';
	}
	
	
	$scope.rateThisteam 			= function(TeamID, EventId, commentForTeam)
	{
		var formData = {
			'team_id'	: TeamID,
			'event_id'	: EventId,
			'comment'	: commentForTeam,
			'points'	: $scope.ratingval,
		};
		
		$http.post(BASE_URL+'api/user/submitComment',formData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function (response) {
			var result  = response.data;
			if(result.success == 1)
			{
				//$('#myModalRate').modal('toggle');
			}
			$('#myModalRate').modal('toggle');
			$scope.rateTeamId 		= '';
			$scope.rateEventId 		= '';
			$scope.commentForTeam 	= '';
			$scope.ratingval 		= '';
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'You Rated this Team.'
				});
				$scope.getteamMatchList();
				return false;
			}();
			
            }, function errorCallback(){
		});
	}
	
}

function AccountCtrl($scope, $http, $filter) 
{
    $scope.userinfo 		= false;
    $scope.updateProfile 		= false;
	$scope.getUserTDetail 		= function()
	{
		$http.get(BASE_URL+'/api/user/user', {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.userinfo = response.data.data;
				$scope.name 	= $scope.userinfo.first_name;
				$scope.lastname = $scope.userinfo.last_name;
				$scope.email 	= $scope.userinfo.email;
				$scope.address 	= $scope.userinfo.address;
				$scope.phone 	= $scope.userinfo.phone;
				
				var d = $scope.userinfo.dob;
				var b=d.slice(0,10);
				var c=b.split('-');
				var e=c[Symbol.iterator]();
				
				$scope.daycount = e.next().value;
				$scope.monthcount = e.next().value;
				$scope.yearcount = e.next().value;
				
				$scope.formatteddob = $scope.monthcount + '-' + $scope.daycount + '-' + $scope.yearcount;
				$scope.dob 		= new Date($scope.formatteddob);
				$scope.pic 		= $scope.userinfo.pic;
			}
			
			}, function errorCallback(response){
			
		});
	}
	
	$scope.getUserTDetail();
	
	$scope.updateProfile = function(){
		
		var formData = new FormData();
		formData.append('first_name', $scope.name);
		formData.append('last_name', $scope.lastname);
		formData.append('email', $scope.email);
		formData.append('gender', $scope.gender);
		formData.append('address', $scope.address);
		formData.append('phone', $scope.phone);
		formData.append( 'dob', $filter('date')($scope.dob, 'dd-MM-yyyy'));
		
		var files = document.getElementById('pic').files[0];
		formData.append('pic',files);
		
		$http.post(BASE_URL+'api/user/updateProfile',formData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function (response) {
			var result  = response.data;
			
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Profile successfully Updated.'
				});
				$scope.getUserTDetail();
				return false;
			}();
			
            }, function errorCallback(){
		});
		
		
	};
	
	
}
function NotificationCtrl($scope, $http) 
{
    $scope.userinfo 		= false;
    //$scope.invitationList 	= [];
	$scope.getUserTDetail 	= function()
	{
		$http.get(BASE_URL+'/api/user/user', {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.userinfo = response.data.data;
				$scope.userEmail 	= $scope.userinfo.email;
				$scope.userId 	= $scope.userinfo.id;
				
				$scope.getinvitationList 		= function()
				{
					var formData = {
						'email': $scope.userEmail,
					};
					$scope.invitationList = [];
					$http.post(BASE_URL+'api/user/getInvitationList',formData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function(response) {
						
						if(response.status == 200)
						{
							$scope.invitationListdata = response.data.data;
							//console.log($scope.invitationListdata);
							for(var i = 0; i < $scope.invitationListdata.length; i++)
							{
								if($scope.invitationListdata[i].status == 'Not yet registered')
								{
									$scope.invitationList.push($scope.invitationListdata[i]);
								}
							}
							
							
							var matchInvititationData = {
								'inviteduser_email': $scope.userinfo.email,
							};
							$scope.matchInvititationListnew = [];
							$http.post(BASE_URL+'api/user/match_invitationList',matchInvititationData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function (response) {
								$scope.matchInvititationList  = response.data.data;
								//console.log($scope.matchInvititationList);
								for(var i = 0; i < $scope.matchInvititationList.length; i++)
								{
									if($scope.matchInvititationList[i].status == 'Pending')
									{
										$scope.matchInvititationListnew.push($scope.matchInvititationList[i]);
									}
								}
								
								if($scope.matchInvititationList == null)
								{
									$scope.invitationList = $scope.invitationList;
									}else{
									Array.prototype.push.apply($scope.invitationList,$scope.matchInvititationListnew); 
								}
								
							});
							
							var memberAvailabilityData = {
								'member_id': $scope.userId,
								'event_id': "",
							};
							$scope.memberAvailabilityListnew = [];
							$http.post(BASE_URL+'api/user/memberAvailability',memberAvailabilityData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function (response) {
								$scope.memberAvailabilityList  = response.data.data;
								for(var i = 0; i < $scope.memberAvailabilityList.length; i++)
								{
									if($scope.memberAvailabilityList[i].status == 'Not Responded')
									{
										$scope.memberAvailabilityListnew.push($scope.memberAvailabilityList[i]);
									}
								}
								
								if($scope.memberAvailabilityList == null)
								{
									$scope.invitationList = $scope.invitationList;
									}else{
									Array.prototype.push.apply($scope.invitationList,$scope.memberAvailabilityListnew); 
								}
								
							});
							
						}
						
						}, function errorCallback(response){
						
						$scope.invitationList = [];
						
						var matchInvititationData = {
							'inviteduser_email': $scope.userinfo.email,
						};
						
						$http.post(BASE_URL+'api/user/match_invitationList',matchInvititationData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function (response) {
							$scope.matchInvititationList  = response.data.data;
							//console.log($scope.matchInvititationList);
							if($scope.matchInvititationList == null)
							{
								$scope.invitationList = $scope.invitationList;
								}else{
								Array.prototype.push.apply($scope.invitationList,$scope.matchInvititationList); 
							}
							
						});
						
						var memberAvailabilityData = {
							'member_id': $scope.userId,
							'event_id': "",
						};
						
						$http.post(BASE_URL+'api/user/memberAvailability',memberAvailabilityData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function (response) {
							$scope.memberAvailabilityList  = response.data.data;
							//console.log($scope.memberAvailabilityList);
							if($scope.memberAvailabilityList == null)
							{
								$scope.invitationList = $scope.invitationList;
								}else{
								Array.prototype.push.apply($scope.invitationList,$scope.memberAvailabilityList); 
							}
							
						});
						
						
					});
				}
				
				$scope.getinvitationList();
				
			}
			
			}, function errorCallback(response){
			
		});
	}
	
	$scope.getUserTDetail();	
	
}

function MatchInvitationCtrl($scope, $http, $routeParams,$timeout, $window) 
{
    $scope.jsondata = $routeParams.DATA;
	var temp = [];
    temp = angular.fromJson($scope.jsondata); 
	
	$scope.userinfo 		= false;
    $scope.getUserTDetail 		= function()
	{
		$http.get(BASE_URL+'/api/user/user', {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.userinfo = response.data.data;
				$scope.name 	= $scope.userinfo.first_name;
				$scope.lastname = $scope.userinfo.last_name;
				$scope.pic 		= $scope.userinfo.pic;
			}
			
			}, function errorCallback(response){
			
		});
	};
	$scope.getUserTDetail();
	
    
	$scope.event_id = temp.event_id;
	$scope.created_by = temp.created_by;
	$scope.inviteduser_email = temp.inviteduser_email;
	$scope.match_name = temp.match_name;
	$scope.sender_name = temp.sender_name;
	$scope.sender_lastname = temp.sender_lastname;
	$scope.status = temp.status;
	$scope.team_id = temp.team_id;
	$scope.team_name = temp.team_name;
	$scope.team_logo = temp.team_logo;
	
	$http.get(BASE_URL+"api/user/getMatchDetail/"+$scope.event_id, {headers:{'token':TOKEN,}}).then(function(response) {
		
		$scope.matchDetail = response.data.data;
		//console.log($scope.matchDetail);
		$scope.opponent_count = $scope.matchDetail[0].opponent_count;
		$scope.location = $scope.matchDetail[0].location;
		$scope.date = $scope.matchDetail[0].date;
		$scope.time = $scope.matchDetail[0].time;
		$scope.field_court = $scope.matchDetail[0].field_selection;
		$scope.location = $scope.matchDetail[0].location;
		
		var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
		var monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
		
		var d = new Date($scope.date);
		$scope.dayName = days[d.getDay()];
		$scope.monthName = monthNames[d.getMonth()];
		$scope.exactDayName = $scope.dayName.split('').join(' ');
		
		var d = $scope.date;
		
		var b=d.slice(0,10);
		var c=b.split('-');
		var e=c[Symbol.iterator]();
		
		$scope.monthcount = e.next().value;
		$scope.daycount = e.next().value;	
	});
	
	$scope.getUserTeamList 		= function()
	{
		$http.get(BASE_URL+'/api/team/teamList?page='+$scope.page+'&limit='+$scope.limit, {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.userTeamList = response.data.data;
			}
			
			}, function errorCallback(response){
			
		});
	}	
	$scope.getUserTeamList();
	
	$scope.updateOpponentTeamInvitation 	= function(status)
	{
		if($scope.myLocation != null)
		{
			$scope.myLocation = $scope.myLocation;	
			}else{
			$scope.myLocation = '';
		}
		
		if($scope.recieverTeam != null)
		{
			$scope.recieverTeam = $scope.recieverTeam;	
			}else{
			$scope.recieverTeam = '';
		}
		
		var formData = {
			'event_id': $scope.event_id,
			'team_id': $scope.recieverTeam,
			'status': status,
			'opponent_address': $scope.myLocation,
			'user_email': $scope.inviteduser_email,
		};
		$http.post(BASE_URL+'api/user/CreateEventRequest',formData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function (response) {
			var result  = response.data;
			if(result.success == 1)
			{
				//$scope.getTeamDetail();
			}
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'You have ' +status+ ' now for this match.'
				});
				$window.location.href = '#!/notification-list';
				return false;
			}();
			
            }, function errorCallback(){
		});
		
		
		
		
	}
	
	
}

function TeamInvitationCtrl($scope, $http, $routeParams,$timeout, $window) 
{
    $scope.jsondata = $routeParams.DATA;
	var temp = [];
    temp = angular.fromJson($scope.jsondata); 
	//console.log(temp);
	
	$scope.userinfo 		= false;
    $scope.getUserTDetail 		= function()
	{
		$http.get(BASE_URL+'/api/user/user', {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.userinfo = response.data.data;
				$scope.name 	= $scope.userinfo.first_name;
				$scope.email 	= $scope.userinfo.email;
				$scope.lastname = $scope.userinfo.last_name;
				$scope.pic 		= $scope.userinfo.pic;
			}
			
			}, function errorCallback(response){
			
		});
	};
	$scope.getUserTDetail();
	
    $scope.teamId = temp.team_id;
    $scope.role = temp.role;
    $scope.status = temp.status;
    $scope.user_id = temp.user_id;
    $scope.team_name = temp.team_name;
    $scope.sender_firstName = temp.sender_firstName;
    $scope.sender_lastName = temp.sender_lastName;
    $scope.ageGroup = temp.ageGrouptitle;
    $scope.playLevel = temp.playLeveltitle;
	//console.log($scope.teamId);
	
	$scope.getTeamDetail = function()
	{
		
		$http.get(BASE_URL+"api/team/getTeam/"+$scope.teamId, {headers:{'token':TOKEN,}}).then(function(response) {
			
			$scope.eteamDetail = response.data.data;
			$scope.team_name = $scope.eteamDetail.team_name;
			$scope.user_role = $scope.eteamDetail.user_role;
			$scope.sports = $scope.eteamDetail.sports;
			$scope.age_group = $scope.eteamDetail.age_group;
			$scope.gender = $scope.eteamDetail.gender;
			$scope.level = $scope.eteamDetail.level;
			$scope.home = $scope.eteamDetail.home;
			$scope.time_zone = $scope.eteamDetail.time_zone;
			$scope.team_logo = $scope.eteamDetail.team_logo;
			
		});
	}
	$scope.getTeamDetail();
	
	
	$scope.updateTeamInvitation 	= function(status)
	{
		var formData = {
			'email': $scope.email,
			'team_id': $scope.teamId,
			'role': $scope.role,
			'status': status,
		};
		$http.put(BASE_URL+'api/user/updateInvitation',formData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function (response) {
			var result  = response.data;
			if(result.success == 1)
			{
				//$scope.getTeamDetail();
			}
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'You have ' +status+ ' now for this team.'
				});
				$window.location.href = '#!/notification-list';
				return false;
			}();
			
            }, function errorCallback(){
		});
		
		
		
		
	}
	
	
	
}

function PlayingMatchCtrl($scope, $http, $routeParams,$timeout, $window) 
{
    $scope.jsondata = $routeParams.DATA;
	var temp = [];
    temp = angular.fromJson($scope.jsondata); 
	//console.log(temp);
	
	$scope.userinfo 		= false;
    $scope.getUserTDetail 		= function()
	{
		$http.get(BASE_URL+'/api/user/user', {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.userinfo = response.data.data;
				$scope.name 	= $scope.userinfo.first_name;
				$scope.lastname = $scope.userinfo.last_name;
				$scope.pic 		= $scope.userinfo.pic;
				$scope.memberId 		= $scope.userinfo.id;
			}
			
			}, function errorCallback(response){
			
		});
	};
	$scope.getUserTDetail();
	
	$scope.created_by = temp.created_by;
	$scope.event_id = temp.event_id;
	$scope.first_name = temp.first_name;
	$scope.id = temp.id;
	$scope.last_name = temp.last_name;
	$scope.member_id = temp.member_id;
	$scope.Matchname = temp.name;
	$scope.pic = temp.pic;
	$scope.role = temp.role;
	$scope.status = temp.status;
	$scope.team_id = temp.team_id;
	$scope.team_name = temp.team_name;
	
	$http.get(BASE_URL+"api/user/getMatchDetail/"+$scope.event_id, {headers:{'token':TOKEN,}}).then(function(response) {
		
		$scope.matchDetail = response.data.data;
		$scope.opponent_count = $scope.matchDetail[0].opponent_count;
		$scope.location = $scope.matchDetail[0].location;
		$scope.date = $scope.matchDetail[0].date;
		$scope.time = $scope.matchDetail[0].time;
		
		var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
		var monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
		
		var d = new Date($scope.date);
		$scope.dayName = days[d.getDay()];
		$scope.monthName = monthNames[d.getMonth()];
		$scope.exactDayName = $scope.dayName.split('').join(' ');
		
		var d = $scope.date;
		
		var b=d.slice(0,10);
		var c=b.split('-');
		var e=c[Symbol.iterator]();
		
		$scope.monthcount = e.next().value;
		$scope.daycount = e.next().value;	
	});
	
	
	$scope.updateMatchInvitation 			= function(status)
	{
		console.log(status);
		var formData = {
			'member_id': $scope.memberId,
			'event_id': $scope.event_id,
			'status': status,
		};
		//console.log(formData);
		//return false;
		$http.put(BASE_URL+'api/user/updateMemberAvailability',formData,{headers:{'token':TOKEN,'Content-type':undefined}}).then(function (response) {
			var result  = response.data;
			if(result.success == 1)
			{
				//$scope.getTeamDetail();
			}
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'You are ' +status+ ' now in this match.'
				});
				$window.location.href = '#!/notification-list';
				return false;
			}();
			
            }, function errorCallback(){
		});
		
		
		
		
	}
	
	
}

function MemberCtrl($scope, $http, $routeParams,$timeout) 
{
    
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "Amistos");
		$scope.encTeamId = $routeParams.ID;
		$scope.teamID = decrypted.toString(CryptoJS.enc.Utf8);
	};	
	
	$timeout($scope.setID(), 2000);
	
	$scope.add = function(){
		
		$scope.phone = '';
		var formData = {
			'name' : $scope.full_name,
			'team_id' : $scope.teamID,
			'email' : $scope.emailid,
			'role' : $scope.member_type,
			'phone' : $scope.phone,
		};
		
		$http.post(BASE_URL+'api/user/addMember',formData,{headers:{'token':TOKEN,'Content-type':'application/json'}}).then(function (response) {
			var result  = response.data;
			if(result.success == 'true')
			{
				$scope.full_name="";
				$scope.teamID="";
				$scope.emailid="";
				$scope.member_type="";
			}
			
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Member has been successfully added.'
				});
				return false;
			}();
			
            }, function errorCallback(){
			
		});
		
		
	};
}
function MemberlistCtrl($scope, $http, $routeParams,$timeout) 
{
    
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "Amistos");
		$scope.teamID = decrypted.toString(CryptoJS.enc.Utf8);
	};	
	
	$timeout($scope.setID(), 2000);
	
	$scope.teamMemberinfo 		= false;
    $scope.getTeamMemberListing 		= function()
	{
		$http.get(BASE_URL+'api/user/teamMemberList/'+$scope.teamID, {
			headers:{		
				'token':TOKEN,
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.teamMemberinfo = response.data.data;
				
				$http.get(BASE_URL+'api/team/teamInvitedMemberList/'+$scope.teamID, {
					headers:{		
						'token':TOKEN,
					}
					}).then(function(response) {
					$scope.teamInvitedMemberinfo = response.data.data;
					
					if($scope.teamInvitedMemberinfo == null)
					{
						$scope.teamMemberinfo = $scope.teamMemberinfo;
						}else{
						Array.prototype.push.apply($scope.teamMemberinfo,$scope.teamInvitedMemberinfo); 
					}
					
				});
				console.log($scope.teamMemberinfo);
			}
			
			}, function errorCallback(response){
			
		});
		
	};
	
	$scope.getTeamMemberListing();
	
}