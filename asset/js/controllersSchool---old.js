'use strict';
//Controllers
function studentAttendanceCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.name 	  	= '';
	$scope.addStudentAttendance = function(){	
		var formData = new FormData();
		formData.append('name', $scope.name);
		
		$http.post(BASE_URL+'schooluser/addStudentAttendance',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Student Attendance added successfully.'
				});
				$window.location.href = '#!/student-attendance';
				return false;
			}();
			
			}, function errorCallback(response){
		});
	};
}

function classScheduleCtrl($scope, $http, $routeParams, $timeout)
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

	 $scope.getScheduleList = function(){        
        $http.get(BASE_URL+'api/scheduler',{headers:{'Content-Type':undefined, 'x-api-key':xapikey}}).then(function(response) 
        {		
            $scope.scheduleList  = response.data;
            for(var i =0; i < $scope.scheduleList.length; i++)
            {
                $scope.scheduleList[i]['scheduleID'] = $scope.encryptStr($scope.scheduleList[i].id);
    		}
		});
	}
    $scope.getScheduleList();

    // Delete a Schedule
    $scope.scheduleDelete = function(scheduleID)
	{
		var deleteMedia = window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':scheduleID};
			$http.post(BASE_URL+'api/scheduler/deleteSchedule',formData,{
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
							text: 'Schedule deleted successfully.'
						});
						$scope.getScheduleList();
						return false;
					}();
				}
				
				}, function errorCallback(response){
				
			});
		}
	}
 	$scope.getPeriodTime=function(cnt){
		$scope.scheduleTime=[];
		for (var i = 0; i < cnt; i++) {
			$scope.scheduleTime.push({
			    start_level: 'Start Time',
			    start_time: "",
			    end_level: 'End Time',
			    end_time: "",
			    name:""
			});
		}
	}
	$scope.timeFormat = function(datetime){
		let d = new Date(datetime);
		let pm = d.getHours() >= 12;
		let hour12 = d.getHours() % 12;
		if (!hour12) 
		  hour12 += 12;
		let minute = d.getMinutes();
		return (`${hour12}:${minute} ${pm ? 'PM' : 'AM'}`);
		// console.log(`${hour12}:${minute} ${pm ? 'pm' : 'am'}`);
	};
   
	// To get the school type
	$scope.schoolTypeList = [];
	$scope.getSchoolType = function(){ 
	  	$scope.lecture_count = [{count : 1},{count : 2},{count : 3},{count : 4},{count : 5}];
	        $http.get(BASE_URL+'api/scheduler/schoolType',{headers:{'Content-Type':undefined, 'x-api-key':xapikey}}).then(function(response) 
	        {
	            $scope.schoolTypeList  = response.data;			
	            $scope.start_time = new Date (new Date().toDateString() + ' ' + '00:00');
	            $scope.end_time = new Date (new Date().toDateString() + ' ' + '00:00');
	        });
		};
	$scope.getSchoolType();
    // To create the schedule data
   $scope.createSchedule = function(){
   	if($scope.school_type == '' || $scope.school_type == null || $scope.lecture_counts == '' || $scope.lecture_counts == null)
	{
				var Gritter = function () {
					$.gritter.add({
						title: 'Failed',
						text: 'All mendatory (*) fields can`t be empty.'
					});
					return false;
				}();
	}

  	for(var i =0; i < $scope.scheduleTime.length; i++)
    {
        $scope.scheduleTime[i].start_time = $scope.timeFormat($scope.scheduleTime[i].start_time);
        $scope.scheduleTime[i].end_time = $scope.timeFormat($scope.scheduleTime[i].end_time);
        $scope.scheduleTime[i].name = $scope.scheduleTime[i].name;
	}
  		var tempData = {school_type:$scope.school_type,no_periods:$scope.lecture_counts,scheduleTime:$scope.scheduleTime};
	// console.log($scope.scheduleTime);
	// console.log(tempData);
	// return false
  	 	$http.post(BASE_URL+'api/scheduler',tempData,{headers:{'Content-Type':undefined, 'x-api-key':xapikey}}).then(function(response) 
        {
            var result  = response.data.data;
            if(result == 'exist'){
            		var Gritter = function () {
		                $.gritter.add({
							title: 'Failed',
							text: response.data.message
						});
						window.location.href = '#!/class-schedule';
						return false;
					}();	
            }else{
            	var Gritter = function () {
	                $.gritter.add({
						title: 'Successfull',
						text: 'Schedule Added Successfuly.'
					});
					window.location.href = '#!/class-schedule';
					return false;
					}();	
            }
            		
		},function errorCallback(response){
			var Gritter = function () {
                $.gritter.add({
					title: 'Error',
					text: response.data.message
				});
                return false;
			}();
		});	
	};
}
function detailsScheduleCtrl($scope, $http, $routeParams, $timeout)
{
	var sid;
	$scope.scheduleID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.scheduleID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.scheduleID;
	};	
	$timeout($scope.setID(), 2000);
	 // alert($scope.schoolTypeID); return false;
	 $scope.scheduleinfo = false;
	 $scope.scheduletime = [];
	$scope.getScheduleDetails = function()
	{
		var formData = {'scheduleID':$scope.scheduleID}
		$http.post(BASE_URL+'api/scheduler/details',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.scheduletime 	= response.data.data.detailList;
				
				$scope.scheduleinfo 	= response.data.data;
				$scope.name 			= $scope.scheduleinfo.name;
				$scope.no_periods 		= $scope.scheduleinfo.no_periods;
				}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getScheduleDetails();	
}
function editScheduleCtrl($scope, $http, $routeParams, $timeout, $window)
{
	var sid;
	$scope.scheduleID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.scheduleID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.scheduleID;
	};
	$timeout($scope.setID(), 2000);
	
	 $scope.scheduleinfo = false;
	 $scope.scheduletime = [];
	$scope.getScheduleDetails = function()
	{
		var formData = {'scheduleID':$scope.scheduleID}
		$http.post(BASE_URL+'api/scheduler/details',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.scheduletime 	= response.data.data.detailList;

				for(var i = 0; i < $scope.scheduletime.length; i++)
				{
					$scope.scheduletime[i]['startTime'] = new Date (new Date().toDateString() + ' ' + $scope.scheduletime[i].start_time);
					$scope.scheduletime[i]['endTime'] = new Date (new Date().toDateString() + ' ' + $scope.scheduletime[i].end_time);
					$scope.scheduletime[i]['lectName'] =  $scope.scheduletime[i].name;
				}
				$scope.scheduleinfo 	= response.data.data;
				$scope.name 			= $scope.scheduleinfo.name;
				$scope.no_periods 		= $scope.scheduleinfo.no_periods;
			}
			
			}, function errorCallback(response){
		});
	}
	$scope.getScheduleDetails();

	$scope.editSchedule = function(scheduletime,scheduleID)
	{
		var startTime='';
		var endTime='';
		$scope.timeFormat = function(datetime){
			let d = new Date(datetime);
			let pm = d.getHours() >= 12;
			let hour12 = d.getHours() % 12;
			if (!hour12) 
			  hour12 += 12;
			let minute = d.getMinutes();
			return (`${hour12}:${minute} ${pm ? 'PM' : 'AM'}`);
		};

		for(var i =0; i < $scope.scheduletime.length; i++)
	    {
	        $scope.scheduletime[i].startTime 	 =   $scope.timeFormat($scope.scheduletime[i].startTime);
	        $scope.scheduletime[i].endTime 	 	 =   $scope.timeFormat($scope.scheduletime[i].endTime);
	        $scope.scheduletime[i].name 	 	 =   $scope.scheduletime[i].lectName;
		}
		var formData = {name:$scope.name,schedule_id:scheduleID,updatedTime:$scope.scheduletime};
		$http.post(BASE_URL+'api/scheduler/editSchedule',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Schedule updated successfully.'
				});
				$window.location.href = '#!/class-schedule';
				return false;
			}();
			
			}, function errorCallback(response){
		});
	};
}
function timeTableCtrl($scope, $http, $routeParams, $timeout,$window)
{
	// To get the school type
	$scope.schoolTypeList = [];
	$scope.getSchoolType = function(){ 
			$http.get(BASE_URL+'api/timeTable/schoolType',{headers:{'Content-Type':undefined, 'x-api-key':xapikey}}).then(function(response) 
	        {
	            $scope.schoolTypeList  = response.data;	
	            // $scope.school_type = $scope.schoolTypeList[0].value;
	        });
		};
	$scope.getSchoolType();
	// Number of Days Array
	$scope.days = [{'val': 'Monday'},{'val' : 'Tuesday'},{'val' : 'Wednesday'},{'val' : 'Thursday'},{'val': 'Friday'},{'val' : 'Saturday'}];
	$scope.day_timeTable = [];
	// Send Lectures based on school-Type 
	$scope.classList = [];
	$scope.ob={'class':''};
	$scope.schoolType = function(){
		$scope.day_timeTable=[];
		$http.post(BASE_URL+'api/timeTable/getClasses',{school_type:$scope.school_type,school_id:School_ID},{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
				$scope.classList = response.data.data;
				 $scope.ob.class = '';
			//	$scope.ob.class = $scope.classList[0].id;	
			}, function errorCallback(response){
		});
	};

	// Modal Open to assigned subject and teacher
	$scope.periodEdit ={ id:"",period_id:"",teacher_id:"",subject_id:"",day_name:"",class_id:"",zoom_link:"",other_info:"",schooltype_id:"" };
 	$scope.assignTeacher = function (timetable){
 		$scope.periodEdit ={ id:timetable.id,period_id:timetable.period_id,teacher_id:timetable.teacher_id,subject_id:timetable.subject_id,day_name:timetable.day_name,class_id:timetable.class_id,zoom_link:timetable.zoom_link,other_info:timetable.other_info,schooltype_id:timetable.schooltype_id };
 	    	$("#myModal").modal("show");
	 	}
	 // Get Teacher based on school
	$scope.TeacherList = [];
	$scope.getTeachers = function(){
		$http.post(BASE_URL+'api/timeTable/getAllTeacherForSchool',{id:School_ID},{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			$scope.TeacherList = response.data.data;
			//console.log($scope.TeacherList);			
			}, function errorCallback(response){
		});
	};
	$scope.getTeachers();

	// Get Subjects based on school-id and class-id
	$scope.SubjectList = [];
	$scope.getSubjects = function(){
		$http.post(BASE_URL+'api/timeTable/getAllSubjectForClass',{school_id:School_ID,class_id:$scope.ob.class},{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			$scope.SubjectList = response.data.data;
			//console.log($scope.TeacherList);			
			}, function errorCallback(response){
		});
	};
	$scope.getSubjects();

	/*Check schedule is Exist or not ? */
	$scope.lecturesList=[];
	$scope.checkSchedule = function(){

		var formData = {id:School_ID,class_id:$scope.ob.class,school_type:$scope.school_type};
		$http.post(BASE_URL+'api/timeTable',formData,{
			headers:{
				'Content-Type':undefined,'x-api-key':xapikey
			}
		}).then(function(response){
			var errormsg = response.data.message;
			if(errormsg == 'schedule_required')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Failed',
						text: 'Please create a schedule first.'
					});
					$window.location.href='#!/add-schedule';
					return false;
				}();
			}else if(errormsg == 'deleted')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Failed',
						text: 'Schedule has been deleted. Create new schedule again.'
					});
					$window.location.href='#!/add-schedule';
					return false;
				}();
			}else{
				$scope.timeTableList = response.data.data;
				
			 // console.log($scope.timeTableList);
			 // return false
				$scope.day_timeTable=[];
				for (const [key, value] of Object.entries($scope.timeTableList)) {
					 let temp = {'val': key,'lectureList':value};
					 $scope.day_timeTable.push(temp);
				}			
			}
		}, function errorCallback(response){
		});
	};
	// Insert values into time-table
	$scope.updateTimeTable = function(){
		 // console.log($scope.periodEdit); return false
		$http.post(BASE_URL+'api/timeTable/updateTimeTable',$scope.periodEdit,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			$scope.response = response.data.data;
			if($scope.response == 1)
			{
					$("#myModal").modal("hide");
					var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: 'Teacher and Subject has been updated successfully.'
					});
					$scope.checkSchedule();
					$window.location.href = '#!/time-table';
					}();
			}
			if($scope.response == 2)
			{
					 $("#myModal").modal("hide");
					var Gritter = function () {
					$.gritter.add({
						title: 'Failed',
						text: 'You selected already assigned teacher Today.'
					});
					$scope.checkSchedule();
					$window.location.href = '#!/time-table';

					}();
			}
			// console.log($scope.response);		
			}, function errorCallback(response){
		});
	};	
	
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
	$scope.getAllParentsForSchool = function()
	{
		var formData = {'schoolId':School_ID}
		$http.post(BASE_URL+'api/user/getAllParent',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.parentList = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.parentList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.parentList[i].id);
					$scope.parentList[i]['parentID'] = encrypted;
				}
			}
			
			}, function errorCallback(response){
			
		});
	}	
	$scope.getAllParentsForSchool();
	
	$scope.getAllTeachersForSchool = function()
	{
		var formData = {'schoolId':School_ID}
		$http.post(BASE_URL+'api/user/getAllTeacher',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.teacherList = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.teacherList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.teacherList[i].id);
					$scope.teacherList[i]['teacherID'] = encrypted;
				}
			}
			
			}, function errorCallback(response){
			
		});
	}	
	$scope.getAllTeachersForSchool();
	$scope.pageSize = 10;
	$scope.getAllEventsForSchool = function()
	{
		
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllEventsForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.eventList = response.data.data;
				var formattedDate;
				for(var i = 0; i < $scope.eventList.length; i++)
				{
					formattedDate = $scope.convertDateFormat($scope.eventList[i].date);
					$scope.eventList[i]['formattedDate'] = formattedDate;
				}
				
				var encrypted ;
				for(var i = 0; i < $scope.eventList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.eventList[i].id);
					$scope.eventList[i]['eventID'] = encrypted;
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllEventsForSchool();
	
	$scope.getAllStudentsForSchool = function()
	{	
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllStudentsForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.studentList = response.data.data;
				var formattedDate;
				for(var i = 0; i < $scope.studentList.length; i++)
				{
					formattedDate = $scope.convertDateFormat($scope.studentList[i].childdob);
					$scope.studentList[i]['formattedDOB'] = formattedDate;
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllStudentsForSchool();
	$scope.sort = function(keyname){
		$scope.sortKey = keyname;
		$scope.reverse = !$scope.reverse;
	}
	
	$scope.getAllDriverForSchool = function()
	{
		$scope.driverList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllDriverForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.driverList = response.data.data;
				var formattedDate;
				for(var i = 0; i < $scope.driverList.length; i++)
				{
					formattedDate = $scope.convertDateFormat($scope.driverList[i].date);
					$scope.driverList[i]['formattedDate'] = formattedDate;
				}
				
				var encrypted ;
				for(var i = 0; i < $scope.driverList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.driverList[i].id);
					$scope.driverList[i]['driverID'] = encrypted;
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllDriverForSchool();
	
	$scope.convertDateFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [day, mnth, date.getFullYear()].join("-");
	}
}
function LearningAndDevelopmentCtrl($scope, $http, $routeParams, $timeout){
    $scope.dataList = [];
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
    $scope.getDataList = function(){        
        $http.get(BASE_URL+'api/learningAndDevelopment',{headers:{'Content-Type':undefined, 'x-api-key':xapikey}}).then(function(response) 
        {		
            $scope.dataList  = response.data;
            for(var i =0; i < $scope.dataList.length; i++)
            {
                $scope.dataList[i].id = $scope.encryptStr($scope.dataList[i].id);
			}
		});
	}
    $scope.getDataList();
}
function AddLearningAndDevelopmentCtrl($scope, $http, $routeParams, $timeout,$window){
    $scope.options = [];
    $scope.data = {id:"",name:"",class_id:"",detail:{"id": "","question": "","options": [],"option_type": "","category_id": ""},info:[]};
    $scope.getDetail = function(){        
        $http.get(BASE_URL+'api/learningAndDevelopment/detail?id='+$scope.id,{headers:{'Content-Type':undefined, 'x-api-key':xapikey}}).then(function(response) 
        {
            $scope.data  = response.data;
            for(var i=0; i < $scope.data.detail.options.length; i++)
            {
                $scope.options.push({text:$scope.data.detail.options[i]});
			}            
		});
	};    	
	
    $scope.classList = [];        
    
    $scope.getClass = function(){        
        $http.get(BASE_URL+'api/classes',{headers:{'Content-Type':undefined, 'x-api-key':xapikey}}).then(function(response) 
        {	
            $scope.classList  = response.data.data;			
		});
	};
    $scope.getClass();    
    
    $scope.addInfo = function(){
        $scope.data.info.push({title:"",detail:""});
	}
    $scope.addNewOption = function(){
        $scope.options.push({text:""});
	}
    $scope.removeOption = function(index){
        $scope.options.splice(index,1);
	}
    
    $scope.saveData = function(){
        $scope.data.detail.options = [];
        for(var i=0; i < $scope.options.length; i++)
        {
            $scope.data.detail.options.push($scope.options[i].text);
		}
        $http.post(BASE_URL+'api/learningAndDevelopment',$scope.data,{headers:{'Content-Type':undefined, 'x-api-key':xapikey}}).then(function(response) 
        {	
            var result  = response.data;
            var Gritter = function () {
                $.gritter.add({
					title: 'Successfull',
					text: response.data.message
				});
                return false;
			}();	
            $window.location.href = BASE_URL + "schooluser#!/learning-and-development";
			},function errorCallback(response){
			var Gritter = function () {
                $.gritter.add({
					title: 'Error',
					text: response.data.message
				});
                return false;
			}();
		});
	};
}
function EditLearningAndDevelopmentCtrl($scope, $http, $routeParams, $timeout,$window){
    $scope.id = "";
    $scope.options = [];
    $scope.data = {id:"",name:"",class_id:"",detail:{"id": "","question": "","options": [],"option_type": "","category_id": ""},info:[]};
    $scope.getDetail = function(){        
        $http.get(BASE_URL+'api/learningAndDevelopment/detail?id='+$scope.id,{headers:{'Content-Type':undefined, 'x-api-key':xapikey}}).then(function(response) 
        {	
            $scope.data  = response.data;
            for(var i=0; i < $scope.data.detail.options.length; i++)
            {
                $scope.options.push({text:$scope.data.detail.options[i]});
			}            
		});
	};
    $scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.id = decrypted.toString(CryptoJS.enc.Utf8);
		$scope.getDetail();
	};	
    $timeout($scope.setID(), 200);        
    $scope.classList = [];        
    
    $scope.getClass = function(){        
        $http.get(BASE_URL+'api/classes',{headers:{'Content-Type':undefined, 'x-api-key':xapikey}}).then(function(response) 
        {	
            $scope.classList  = response.data.data;			
		});
	};
    $scope.getClass();    
    
    $scope.addInfo = function(){
        $scope.data.info.push({title:"",detail:""});
	}
    $scope.addNewOption = function(){
        $scope.options.push({text:""});
	}
    $scope.removeOption = function(index){
        $scope.options.splice(index,1);
	}
    
    $scope.saveData = function(){
        $scope.data.detail.options = [];
        for(var i=0; i < $scope.options.length; i++)
        {
            $scope.data.detail.options.push($scope.options[i].text);
		}
        $http.put(BASE_URL+'api/learningAndDevelopment',$scope.data,{headers:{'Content-Type':undefined, 'x-api-key':xapikey}}).then(function(response) 
        {	
            var result  = response.data;
            var Gritter = function () {
                $.gritter.add({
					title: 'Successfull',
					text: 'Updated Successfuly.'
				});
				window.location.href = '#!/learning-and-development';
                // return false;
			}();			
			},function errorCallback(response){
			var Gritter = function () {
                $.gritter.add({
					title: 'Error',
					text: response.data.message
				});
                return false;
			}();
		});
	};
}
function MealPlannerCtrl($scope, $http, $routeParams, $timeout){
    $scope.mealList = [];
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
    $scope.getMealList = function(){        
        $http.get(BASE_URL+'api/mealPlanner',{headers:{'Content-Type':undefined, 'x-api-key':xapikey}}).then(function(response) 
        {		
            $scope.mealList  = response.data;
            for(var i =0; i < $scope.mealList.length; i++)
            {
                $scope.mealList[i].id = $scope.encryptStr($scope.mealList[i].id);
			}
		});
	}
    $scope.getMealList();
    
}
function addMealCtrl($scope, $http, $routeParams, $timeout){
    $scope.schoolTypeList = [];
    $scope.classList = [];
    $scope.mealPlan = {school_type:"",from_date:"",to_date:"",detailList:[]};
    
    
    $scope.getSchoolType = function(){        
        $http.get(BASE_URL+'api/mealPlanner/schoolType',{headers:{'Content-Type':undefined, 'x-api-key':xapikey}}).then(function(response) 
        {	
		    $scope.schoolTypeList  = response.data;			
		});
	};
    $scope.getSchoolType();
    
    $scope.createMealList = function(){        
        $http.post(BASE_URL+'api/mealPlanner/dateRange',$scope.mealPlan,{headers:{'Content-Type':undefined, 'x-api-key':xapikey}}).then(function(response) 
        {	
            $scope.mealPlan.detailList = [];
            var tmp  = response.data;
            for(var i=0; i < tmp.length ; i++)
            {
                $scope.mealPlan.detailList.push({for_date:tmp[i],breakfast:"",snacks:"",meal:""})
			}            			
		});
	};
    $scope.saveMealPlan = function(){
        $http.post(BASE_URL+'api/mealPlanner',$scope.mealPlan,{headers:{'Content-Type':undefined, 'x-api-key':xapikey}}).then(function(response) 
        {
            var result  = response.data;
            var Gritter = function () {
                $.gritter.add({
					title: 'Successfull',
					text: 'Meal Plan Added Successfuly.'
				});
                return false;
			}();			
			},function errorCallback(response){
			var Gritter = function () {
                $.gritter.add({
					title: 'Error',
					text: response.data.message
				});
                return false;
			}();
		});
	};
    
}
function editMealCtrl($scope, $http, $routeParams, $timeout){
    $scope.id = "";
    $scope.mealPlan = {school_type:"",from_date:"",to_date:"",detailList:[]};
    $scope.getMealDetail = function(){        
        $http.get(BASE_URL+'api/mealPlanner/detail?id='+$scope.id,{headers:{'Content-Type':undefined, 'x-api-key':xapikey}}).then(function(response) 
        {	
            $scope.mealPlan  = response.data;			
		});
	};
    $scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.id = decrypted.toString(CryptoJS.enc.Utf8);
		$scope.getMealDetail();
	};	
    $timeout($scope.setID(), 200);
    
    $scope.schoolTypeList = [];
    $scope.classList = [];
    $scope.mealPlan = {school_type:"",from_date:"",to_date:"",detailList:[]};
    
    
    
    $scope.getSchoolType = function(){        
        $http.get(BASE_URL+'api/mealPlanner/schoolType',{headers:{'Content-Type':undefined, 'x-api-key':xapikey}}).then(function(response) 
        {	
            $scope.schoolTypeList  = response.data;			
		});
	};
    $scope.getSchoolType();
    
    $scope.createMealList = function(){        
        $http.post(BASE_URL+'api/mealPlanner/dateRange',$scope.mealPlan,{headers:{'Content-Type':undefined, 'x-api-key':xapikey}}).then(function(response) 
        {	
            $scope.mealPlan.detailList = [];
            var tmp  = response.data;
            for(var i=0; i < tmp.length ; i++)
            {
                $scope.mealPlan.detailList.push({for_date:tmp[i],breakfast:"",snacks:"",meal:""})
			}            			
		});
	};
    $scope.saveMealPlan = function(){
        $http.put(BASE_URL+'api/mealPlanner',$scope.mealPlan,{headers:{'Content-Type':undefined, 'x-api-key':xapikey}}).then(function(response) 
        {	
            var result  = response.data;
            var Gritter = function () {
                $.gritter.add({
					title: 'Successfull',
					text: 'Meal Plan Updated Successfuly.'
				});
                return false;
			}();			
			},function errorCallback(response){
			var Gritter = function () {
                $.gritter.add({
					title: 'Error',
					text: response.data.message
				});
                return false;
			}();
		});
	};
    
}
function HomeMealCtrl($scope, $http, $routeParams, $timeout,$location){
	$scope.addMealModal= function(popid){
		var retn=1
		var checlPrivilege=JSON.parse(jsonPrivilege);
		if(checlPrivilege.length==0){
			var cnt=checlPrivilege.length;
			}else{
			var cnt=jsonPrivilege.length;
		}
		if(cnt>0){
			if(checlPrivilege.HomeMeal['add']==0){
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
		//$("#"+popid).modal('show');
	}
    $scope.mealList = [];
    $scope.meal = {id:"",name:""};
    $scope.getHomeMeal = function(){        
        $http.get(BASE_URL+'api/homeMeal',{headers:{'Content-Type':undefined, 'x-api-key':xapikey}}).then(function(response) 
        {		
            $scope.mealList  = response.data.data;			
		});
	}
    $scope.getHomeMeal();
    $scope.addHomeMeal = function(){        
        $http.post(BASE_URL+'api/homeMeal',{name:$scope.meal.name},{headers:{'Content-Type':undefined, 'x-api-key':xapikey}}).then(function(response) 
        {			
            var result  = response.data;
            var Gritter = function () {
                $.gritter.add({
					title: 'Successfull',
					text: 'Meal Added Successfuly.'
				});
                return false;
			}();
            $scope.meal.name = "";
            $("#addMealModal").modal('hide');
            $scope.getHomeMeal();
            
			},function errorCallback(response){
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
function editProfileCtrl($scope, $http, $route, $window) 
{
	/* $(function() {
		$('#chkveg').multiselect({
		includeSelectAllOption: true
		});
	}); */
	
	
	$scope.opsw 		= '';
	$scope.npsw 		= '';
	$scope.cpsw 		= '';
	/* 
		$scope.schoolname 	= '';
		$scope.phone 		= '';
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
	*/
	$scope.changePassword = function()
	{
		if($scope.opsw == '')
		{
			$scope.errormsg = 'Old Password is required.';
			return false;
		}
		else if($scope.npsw == '')
		{
			$scope.errormsg = 'New Password is required.';
			return false;
		}
		else if($scope.cpsw == '')
		{
			$scope.errormsg = 'Confirm Password is required.';
			return false;
		}
		else if($scope.npsw != $scope.cpsw)
		{
			$scope.errormsg = 'New Password and Confirm Password should be same.';
			return false;
		}
		var formData = {'opsw':$scope.opsw,'npsw':$scope.npsw, 'id':School_ID}
		$http.post(BASE_URL+'api/user/changePasswordSchool',formData,{
			headers:{
				'Content-Type':'application/json',
				'x-api-key':xapikey
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
	
	
	$scope.getSchoolDetails = function()
	{
		var formData = {'id':School_ID}
		$http.post(BASE_URL+'api/user/getSchoolDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.result = response.data.data;
				
				$scope.schoolname 	= $scope.result.school_name;
				$scope.phone 		= $scope.result.phone;
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
				$scope.pic 			= $scope.result.pic;
				$scope.typeOfSchool = $scope.schoolType;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getSchoolDetails();
	
	$scope.getSchoolDetailsForEdit = function()
	{
		var formData = {'id':School_ID}
		$http.post(BASE_URL+'api/user/getSchoolDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.result = response.data.data;
				
				$scope.schoolname 	= $scope.result.school_name;
				$scope.phone 		= $scope.result.phone;
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
				$scope.pic 			= $scope.result.pic;
				$scope.typeOfSchool = $scope.schoolType;
				
				var oldSrc = $('.profileImageHeader').attr("src");
				var newSrc = BASE_URL+'img/school/'+$scope.pic;
				if(newSrc != oldSrc)
				{
					$('img[src="' + oldSrc + '"]').attr('src', newSrc);
				}	
				
				$('.username').text($scope.schoolname);
				
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	
	$scope.updateProfile = function()
	{
		if($scope.schoolname == '' || $scope.email == '' || $scope.location == '' || $scope.phone == '' || $scope.schoolType == '')
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
		formData.append('schoolid', School_ID);
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
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Profile successfully Updated.'
				});
				$scope.getSchoolDetailsForEdit();
				return false;
			}();
			
            }, function errorCallback(){
			$scope.getSchoolDetailsForEdit();
		});
		
	}
	
	$scope.removeProfilePic = function()
	{
		var oldSrc = '';
		var newSrc = '';
		
		var formData = {'photo':'default-profilePic.png','id':School_ID}
		
		$http.post(BASE_URL+'api/user/removeProfilePicSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Profile Picture removed successfully.'
				});
				$scope.getSchoolDetails();
				oldSrc = $('.profileImageHeader').attr("src");
				//var newSrc = $('.profilePic').attr("src");
				newSrc = BASE_URL+'img/school/default-profilePic.png';
				if(newSrc != oldSrc)
				{
					$('img[src="' + oldSrc + '"]').attr('src', newSrc);
				}
				return false;
			}();
			
            }, function errorCallback(){
			$scope.getSchoolDetails();
		});
		
	}
	
}

function subadminProfileCtrl($scope, $http, $route, $window) 
{
	$scope.opsw 		= '';
	$scope.npsw 		= '';
	$scope.cpsw 		= '';
	
	$scope.changePassword = function()
	{
		if($scope.opsw == '')
		{
			$scope.errormsg = 'Old Password is required.';
			return false;
		}
		else if($scope.npsw == '')
		{
			$scope.errormsg = 'New Password is required.';
			return false;
		}
		else if($scope.cpsw == '')
		{
			$scope.errormsg = 'Confirm Password is required.';
			return false;
		}
		else if($scope.npsw != $scope.cpsw)
		{
			$scope.errormsg = 'New Password and Confirm Password should be same.';
			return false;
		}
		var formData = {'opsw':$scope.opsw,'npsw':$scope.npsw, 'id':School_ID}
		$http.post(BASE_URL+'api/user/changePasswordSchoolSubadmin',formData,{
			headers:{
				'Content-Type':'application/json',
				'x-api-key':xapikey
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
	
	
	$scope.getDetails = function()
	{
		var formData = {'id':School_ID}
		$http.post(BASE_URL+'api/user/getSchoolSubadminDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.result = response.data.data;
				
				$scope.name 	= $scope.result.name;
				$scope.phone 	= $scope.result.phone;
				$scope.email 	= $scope.result.email;
				$scope.address = $scope.result.address;				
				$scope.pic 	= $scope.result.pic;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getDetails();
	
	$scope.getSchoolDetailsForEdit = function()
	{
		var formData = {'id':School_ID}
		$http.post(BASE_URL+'api/user/getSchoolSubadminDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.result = response.data.data;
				
				$scope.name 	= $scope.result.name;
				$scope.phone 	= $scope.result.phone;
				$scope.email 	= $scope.result.email;
				$scope.address = $scope.result.address;				
				$scope.pic 	= $scope.result.pic;
				
				var oldSrc = $('.profileImageHeader').attr("src");
				var newSrc = BASE_URL+'img/school/subadmin/'+$scope.pic;
				if(newSrc != oldSrc)
				{
					$('img[src="' + oldSrc + '"]').attr('src', newSrc);
				}	
				
				$('.username').text($scope.schoolname);
				
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	
	$scope.updateProfile = function()
	{					
		var oldSrc = '';
		var newSrc = '';
		var formData = new FormData();
		formData.append('name', $scope.name);
		formData.append('email', $scope.email);
		formData.append('address', $scope.address);
		formData.append('phone', $scope.phone);
		
		var files = document.getElementById('pic').files[0];
		formData.append('pic',files);
		
		$http.post(BASE_URL+'api/user/updateProfileSchoolSubadmin',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Profile successfully Updated.'
				});
				$scope.getSchoolDetailsForEdit();
				return false;
			}();
			
            }, function errorCallback(){
			$scope.getSchoolDetailsForEdit();
		});
		
	}
	
	$scope.removeProfilePic = function()
	{
		var oldSrc = '';
		var newSrc = '';
		
		var formData = {'photo':'default-profilePic.png','id':School_ID}
		
		$http.post(BASE_URL+'api/user/removeProfilePicSchoolSubadmin',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Profile Picture removed successfully.'
				});
				$scope.getSchoolDetails();
				oldSrc = $('.profileImageHeader').attr("src");
				//var newSrc = $('.profilePic').attr("src");
				newSrc = BASE_URL+'img/school/default-profilePic.png';
				if(newSrc != oldSrc)
				{
					$('img[src="' + oldSrc + '"]').attr('src', newSrc);
				}
				return false;
			}();
			
            }, function errorCallback(){
			$scope.getSchoolDetails();
		});
		
	}
	
} 

function getAllParentCtrl($scope, $http, $routeParams, $timeout) 
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
	$scope.getAllParentsForSchool = function()
	{
		var formData = {'schoolId':School_ID}
		$http.post(BASE_URL+'api/user/getAllParent',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.parentList = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.parentList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.parentList[i].id);
					$scope.parentList[i]['parentID'] = encrypted;
				}
				// console.log($scope.parentList);
			}
			
			}, function errorCallback(response){
			
		});
	}	
	$scope.getAllParentsForSchool();
	
	$scope.sort = function(keyname){
		$scope.sortKey = keyname;
		$scope.reverse = !$scope.reverse;
	}
	$scope.pageSize = 10;
	
	$scope.parentDisabled = function(parentID, status)
	{
		
		var formData1 = {'id':parentID, 'status':status};
		$http.post(BASE_URL+'api/user/parentDisabled',formData1,{
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
					
					$scope.getAllParentsForSchool();
					return false;
				}();
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	
}
function allParentCtrl($scope, $http, $routeParams, $timeout) 
{
	$scope.showChildLoginDetail=function(childlogin_id,cpass,cfname,cmname,clname){
		$scope.cloginid=childlogin_id;
		$scope.cpassword=cpass;
		$scope.cfullname=cfname+' '+cmname+' '+clname;
		$("#childLoginDetailModal").modal('show');
	}
	$scope.generateUserPass = function(femail,memail,childid,childrid,childfname,childmname,childlname){
		var formData = {'femail':femail,'memail':memail,'childid':childid,'childrid':childrid,'childfname':childfname,'childmname':childmname,'childlname':childlname}
		$http.post(BASE_URL+'api/user/getStudentUsernamePassword',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.getChildDetails();
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: 'Login Details generated successfully.'
					});
					//$window.location.href = '#!/parent-list';
					return false;
				}();
				
			}
			
			}, function errorCallback(response){
			
		});
		
	}
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
function editParentCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$('.open-children').click(function(){
		$('.children-data').toggleClass('show');
	})
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
	
	$scope.getAllClassForSchool = function()
	{
		$scope.classList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllClassForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.classList = response.data.data;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllClassForSchool();
	
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
				/* $scope.guardianfname	= $scope.parentinfo.guardianfname;
					$scope.guardianlname	= $scope.parentinfo.guardianlname;
					$scope.guardianemail	= $scope.parentinfo.guardianemail;
					$scope.guardianphone	= $scope.parentinfo.guardianphone;
					$scope.guardianaddress	= $scope.parentinfo.guardianaddress;
					$scope.gcity			= $scope.parentinfo.gcity;
					$scope.gstate			= $scope.parentinfo.gstate;
					$scope.gcountry			= $scope.parentinfo.gcountry;
					$scope.gpincode			= $scope.parentinfo.gpincode;
				$scope.guardianphoto	= $scope.parentinfo.guardianphoto; */
				
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getParentDetails();
	
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
	//$scope.childRegisterId 	= '';
	$scope.childfname 		= '';
	$scope.childmname 		= '';
	$scope.childlname 		= '';
	$scope.childgender 		= '';
	$scope.childclass 		= '';
	$scope.childsection 	= '';
	$scope.childdob 		= '';
	$scope.childemail 		= '';
	$scope.childhealthdetail 		= '';
	$scope.childallergy 		= '';
	$scope.childSpecialneed 		= '';
	$scope.childApplicablemedication 		= '';
	$scope.childbg 			= '';
	$scope.childaddress 	= '';
	$scope.childphoto 		= '';
	$scope.childcertificate = '';
	
	$scope.onChange = function (files) {
		if(files[0] == undefined) return;
		$scope.fileExt = files[0].name.split(".").pop();
	}
	$scope.isImage = function(ext) {
		if(ext) {
			return ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png";
		}
	}
	
	$scope.addChild = function(){
		// console.log("childdob:"+$scope.childdob);
		// console.log("childphoto:"+$scope.childphoto);
		// return false
		
		if($scope.childemail=='' || $scope.childfname == '' || $scope.childlname == '' || $scope.childgender == '' || $scope.childclass == '' || $scope.childdob == '' || $scope.childphoto == '')
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
		formData.append('child_id', $scope.childId);
		formData.append('schoolId', School_ID);
		formData.append('parentID', $scope.parentID);
		// formData.append('childRegisterId', $scope.childRegisterId);
		formData.append('childfname', $scope.childfname);
		formData.append('childmname', $scope.childmname);
		formData.append('childlname', $scope.childlname);
		formData.append('childgender', $scope.childgender);
		formData.append('childclass', $scope.childclass);
		formData.append('childdob', $scope.convertDateNewFormat($scope.childdob));
		formData.append('childemail', $scope.childemail);
		formData.append('childhealthdetail', $scope.childhealthdetail);
		formData.append('childallergy', $scope.childallergy);
		formData.append('childSpecialneed', $scope.childSpecialneed);
		formData.append('childApplicablemedication', $scope.childApplicablemedication);
		formData.append('childbg', $scope.childbg);
		formData.append('childaddress', $scope.childaddress);
		
		var files1 = document.getElementById('pic').files[0];
		formData.append('pic',files1);
		
		var files2 = document.getElementById('certificate').files[0];
		formData.append('certificate',files2);

		$http.post(BASE_URL+'api/user/addChild',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Child added successfully.'
				});
				$window.location.href = '#!/student-list';
				return false;
			}();
			
            }, function errorCallback(response){
			
			var errresult = response.data.message
			$scope.getParentDetails();
		});
	};
	
	$scope.editParent = function(){
		
		// if($scope.fatherfname == '' || $scope.fatherlname == '' || $scope.fatheremail == '' || $scope.fatherphone == '' || $scope.fatheraddress == '' || $scope.motherfname == '' || $scope.motherlname == '' || $scope.motheremail == '' || $scope.motherphone == '' || $scope.motheraddress == '' || $scope.emergencyfname == '' || $scope.emergencylname == '' || $scope.emergencyemail == '' || $scope.emergencyphone == '' || $scope.emergencyaddress == '')
		// {
		if( ( ( ($scope.fatherfname == '' || $scope.fatherlname == '' || $scope.fatheremail == '' || $scope.fatherphone == '' || $scope.fatheraddress == '') || ($scope.motherfname == '' || $scope.motherlname == '' || $scope.motheremail == '' || $scope.motherphone == '' || $scope.motheraddress == '') ) && ($scope.emergencyfname == '' || $scope.emergencylname == '' || $scope.emergencyemail == '' || $scope.emergencyphone == '' || $scope.emergencyaddress == '') ) )
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
		formData.append('parentID', $scope.parentID);
		formData.append('schoolId', School_ID);
		formData.append('fatherfname', $scope.fatherfname);
		formData.append('fatherlname', $scope.fatherlname);
		formData.append('fatheroccupation', $scope.fatheroccupation);
		formData.append('fatheremail', $scope.fatheremail);
		formData.append('fatherphone', $scope.fatherphone);
		formData.append('fatheraddress', $scope.fatheraddress);
		formData.append('fcity', $scope.fcity);
		formData.append('fstate', $scope.fstate);
		formData.append('fpincode', $scope.fpincode);
		formData.append('fcountry', $scope.fcountry);
		formData.append('fatherphoto', $scope.fatherphoto);
		formData.append('motherfname', $scope.motherfname);
		formData.append('motherlname', $scope.motherlname);
		formData.append('motheroccupation', $scope.motheroccupation);
		formData.append('motheremail', $scope.motheremail);
		formData.append('motherphone', $scope.motherphone);
		formData.append('motheraddress', $scope.motheraddress);
		formData.append('mcity', $scope.mcity);
		formData.append('mstate', $scope.mstate);
		formData.append('mpincode', $scope.mpincode);
		formData.append('mcountry', $scope.mcountry);
		formData.append('motherphoto', $scope.motherphoto);
		formData.append('emergencyfname', $scope.emergencyfname);
		formData.append('emergencylname', $scope.emergencylname);
		formData.append('emergencyemail', $scope.emergencyemail);
		formData.append('emergencyphone', $scope.emergencyphone);
		formData.append('emergencyaddress', $scope.emergencyaddress);
		formData.append('ecity', $scope.ecity);
		formData.append('estate', $scope.estate);
		formData.append('epincode', $scope.epincode);
		formData.append('ecountry', $scope.ecountry);
		formData.append('emergencyphoto', $scope.emergencyphoto);
		
		/* formData.append('guardianfname', $scope.guardianfname);
			formData.append('guardianlname', $scope.guardianlname);
			formData.append('guardianemail', $scope.guardianemail);
			formData.append('guardianphone', $scope.guardianphone);
			formData.append('guardianaddress', $scope.guardianaddress);
			formData.append('gcity', $scope.gcity);
			formData.append('gstate', $scope.gstate);
			formData.append('gpincode', $scope.gpincode);
			formData.append('gcountry', $scope.gcountry);
		formData.append('guardianphoto', $scope.guardianphoto); */
		
		var files1 = document.getElementById('fpic').files[0];
		formData.append('fpic',files1);
		
		var files2 = document.getElementById('mpic').files[0];
		formData.append('mpic',files2);
		
		var files3 = document.getElementById('epic').files[0];
		formData.append('epic',files3);
		
		/* var files4 = document.getElementById('gpic').files[0];
		formData.append('gpic',files3); */
		
		$http.post(BASE_URL+'api/user/editParent',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var errdata = response.data.data
			// console.log(errdata);
			// return false
				if(errdata == 'already-updated')
				{
						var Gritter = function () {
							$.gritter.add({
								title: 'successfully',
								text: 'Already updated record.'
							});
							$window.location.href = '#!/parent-list';
							return false;
						}();
				}else{
						var Gritter = function () {
							$.gritter.add({
								title: 'Successfull',
								text: 'Parent Updated successfully.'
							});
							$window.location.href = '#!/parent-list';
							return false;
						}();
				}
			
            }, function errorCallback(response){
			var errresult = response.data.message
			if(errresult == 'Already Exists.')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Failed',
						text: 'Email/Phone already exist.'
					});
					
					return false;
				}();
			}
		});
	};
	
}
function editChildCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.childRegisterId 				= '';
	$scope.childfname 					= '';
	$scope.childmname 					= '';
	$scope.childlname 					= '';
	$scope.childgender 					= '';
	$scope.childclass 					= '';
	$scope.childsection 				= '';
	$scope.childdob 					= '';
	$scope.childemail 					= '';
	$scope.childhealthdetail 			= '';
	$scope.childallergy 				= '';
	$scope.childSpecialneed 			= '';
	$scope.childApplicablemedication 	= '';
	$scope.childbg 						= '';
	$scope.childaddress 				= '';
	$scope.childphoto 					= '';
	$scope.childcertificate 			= '';
	$scope.childsectionForFirstView 	= '';


	
	var sid;
	$scope.childID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.childID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.childID;
	};
	$timeout($scope.setID(), 2000);
	$scope.onChange = function (files) {
			if(files[0] == undefined) return;
			$scope.fileExt = files[0].name.split(".").pop();
		}
	$scope.isImage = function(ext) {
		if(ext) {
			return ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png";
		}
	}
	$scope.convertDateNewFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [date.getFullYear(), mnth, day].join("-");
	}
	
	$scope.childinfo = false;
	$scope.getSingleChildDetails = function()
	{
		var formData = {'id':$scope.childID}
		$http.post(BASE_URL+'api/user/getSingleChildDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.childinfo = response.data.data;
				$scope.childRegisterId 	= $scope.childinfo.childRegisterId;
				$scope.childfname 		= $scope.childinfo.childfname;
				$scope.childmname 		= $scope.childinfo.childmname;
				$scope.childlname 		= $scope.childinfo.childlname;
				$scope.childgender 		= $scope.childinfo.childgender;
				$scope.childclass 		= $scope.childinfo.childclass;
				$scope.childdob 		= new Date($scope.childinfo.childdob);
				$scope.childemail 		= $scope.childinfo.childemail;
				$scope.childhealthdetail = $scope.childinfo.healthdetail;
				$scope.childallergy 		= $scope.childinfo.allergy;
				$scope.childSpecialneed 		= $scope.childinfo.specialneed;
				$scope.childApplicablemedication 		= $scope.childinfo.applicablemedication;
				$scope.childbg 			= $scope.childinfo.childbg;
				$scope.childaddress 	= $scope.childinfo.childaddress;
				$scope.childphoto 		= $scope.childinfo.childphoto;
				$scope.childcertificate = $scope.childinfo.childcertificate;
				$scope.fatherfname 		= $scope.childinfo.fatherfname;
				$scope.fatherlname 		= $scope.childinfo.fatherlname;
				// console.log($scope.fatherfname);
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getSingleChildDetails();
	$scope.getAllClassForSchool = function()
	{
		$scope.classList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllClassForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.classList = response.data.data;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllClassForSchool();
	
	$scope.editChild = function(){
		
		if($scope.childemail == '' || $scope.childRegisterId == '' || $scope.childfname == '' || $scope.childlname == '' || $scope.childgender == '' || $scope.childclass == '' || $scope.childdob == '' || $scope.childphoto == '')
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
		//alert($scope.childsection); return false;
		
		var formData = new FormData();
		formData.append('schoolId', School_ID);
		formData.append('childID', $scope.childID);
		formData.append('childRegisterId', $scope.childRegisterId);
		formData.append('childfname', $scope.childfname);
		formData.append('childmname', $scope.childmname);
		formData.append('childlname', $scope.childlname);
		formData.append('childgender', $scope.childgender);
		formData.append('childclass', $scope.childclass);
		formData.append('childdob', $scope.convertDateNewFormat($scope.childdob));
		formData.append('childemail', $scope.childemail);
		formData.append('childemail', $scope.childemail);
		formData.append('childhealthdetail', $scope.childhealthdetail);
		formData.append('childallergy', $scope.childallergy);
		formData.append('childSpecialneed', $scope.childSpecialneed);
		formData.append('childApplicablemedication', $scope.childApplicablemedication);
		formData.append('childbg', $scope.childbg);
		formData.append('childaddress', $scope.childaddress);
		formData.append('childphoto', $scope.childphoto);
		formData.append('childcertificate', $scope.childcertificate);
		
		var files1 = document.getElementById('pic').files[0];
		formData.append('pic',files1);
		
		var files2 = document.getElementById('certificate').files[0];
		formData.append('certificate',files2);
		
		$http.post(BASE_URL+'api/user/editChild',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var errdata  = response.data.data;
		
				if(errdata == 'already-updated')
				{
						var Gritter = function () {
							$.gritter.add({
								title: 'successfully',
								text: 'Child already updated.'
							});
							$window.location.href = '#!/student-list';
							return false;
						}();
				}else{
						var Gritter = function () {
							$.gritter.add({
								title: 'Successfull',
								text: 'Child Updated successfully.'
							});
							$window.location.href = '#!/student-list';
							return false;
						}();
				}
			
            }, function errorCallback(response){
			
			var errresult = response.data.message
			$scope.getSingleChildDetails();
		});
	};
	
}
function addParentCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
	$scope.fatherfname 		= '';
	$scope.fatherlname 		= '';
	$scope.fatheroccupation = '';
	$scope.fatheremail 		= '';
	$scope.fatherphone 		= '';
	$scope.fatheraddress 	= '';
	$scope.fcity 			= '';
	$scope.fstate 			= '';
	$scope.fpincode 		= '';
	$scope.fcountry 		= '';
	$scope.fatherphoto 		= '';
	$scope.motherfname 		= '';
	$scope.motherlname 		= '';
	$scope.motheroccupation = '';
	$scope.motheremail 		= '';
	$scope.motherphone 		= '';
	$scope.motheraddress 	= '';
	$scope.mcity 			= '';
	$scope.mstate 			= '';
	$scope.mpincode 		= '';
	$scope.mcountry 		= '';
	$scope.motherphoto 		= '';
	$scope.guardianfname 	= '';
	$scope.guardianlname 	= '';
	$scope.guardianemail 	= '';
	$scope.guardianphone 	= '';
	$scope.emergencyContact = '';
	$scope.guardianaddress 	= '';
	$scope.gcity 			= '';
	$scope.gstate 			= '';
	$scope.gpincode 		= '';
	$scope.gcountry 		= '';
	$scope.guardianphoto 	= '';
	$scope.emergencyfname 	= '';
	$scope.emergencylname 	= '';
	$scope.emergencyemail 	= '';
	$scope.emergencyphone 	= '';
	$scope.emergencyaddress 	= '';
	$scope.ecity 			= '';
	$scope.estate 			= '';
	$scope.epincode 		= '';
	$scope.ecountry 		= '';
	$scope.emergencyphoto 	= '';
	
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
	
	$scope.addParent = function(){
		
		if( ( ( ($scope.fatherfname == '' || $scope.fatherlname == '' || $scope.fatheremail == '' || $scope.fatherphone == '' || $scope.fatheraddress == '') || ($scope.motherfname == '' || $scope.motherlname == '' || $scope.motheremail == '' || $scope.motherphone == '' || $scope.motheraddress == '') ) && ($scope.emergencyfname == '' || $scope.emergencylname == '' || $scope.emergencyemail == '' || $scope.emergencyphone == '' || $scope.emergencyaddress == '') ) )
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
		formData.append('schoolId', School_ID);
		formData.append('fatherfname', $scope.fatherfname);
		formData.append('fatherlname', $scope.fatherlname);
		formData.append('fatheroccupation', $scope.fatheroccupation);
		formData.append('fatheremail', $scope.fatheremail);
		formData.append('fatherphone', $scope.fatherphone);
		formData.append('fatheraddress', $scope.fatheraddress);
		formData.append('fcity', $scope.fcity);
		formData.append('fstate', $scope.fstate);
		formData.append('fpincode', $scope.fpincode);
		formData.append('fcountry', $scope.fcountry);
		formData.append('motherfname', $scope.motherfname);
		formData.append('motherlname', $scope.motherlname);
		formData.append('motheroccupation', $scope.motheroccupation);
		formData.append('motheremail', $scope.motheremail);
		formData.append('motherphone', $scope.motherphone);
		formData.append('motheraddress', $scope.motheraddress);
		formData.append('mcity', $scope.mcity);
		formData.append('mstate', $scope.mstate);
		formData.append('mpincode', $scope.mpincode);
		formData.append('mcountry', $scope.mcountry);
		formData.append('emergencyfname', $scope.emergencyfname);
		formData.append('emergencylname', $scope.emergencylname);
		formData.append('emergencyemail', $scope.emergencyemail);
		formData.append('emergencyphone', $scope.emergencyphone);
		formData.append('emergencyaddress', $scope.emergencyaddress);
		formData.append('ecity', $scope.ecity);
		formData.append('estate', $scope.estate);
		formData.append('epincode', $scope.epincode);
		formData.append('ecountry', $scope.ecountry);
		formData.append('guardianfname', $scope.guardianfname);
		formData.append('guardianlname', $scope.guardianlname);
		formData.append('guardianemail', $scope.guardianemail);
		formData.append('guardianphone', $scope.guardianphone);
		formData.append('guardianaddress', $scope.guardianaddress);
		formData.append('gcity', $scope.gcity);
		formData.append('gstate', $scope.gstate);
		formData.append('gpincode', $scope.gpincode);
		formData.append('gcountry', $scope.gcountry);
		
		var files1 = document.getElementById('fpic').files[0];
		
		formData.append('fpic',files1);
		
		var files2 = document.getElementById('mpic').files[0];
		formData.append('mpic',files2);
		
		var files3 = document.getElementById('epic').files[0];
		formData.append('epic',files3);
		
		var files4 = document.getElementById('gpic').files[0];
		formData.append('gpic',files3);
		
		$http.post(BASE_URL+'api/user/addParent',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Parent added successfully.'
				});
				$window.location.href = '#!/parent-list';
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
						text: 'Email/Phone already exist.'
					});
					
					return false;
				}();
			}
		});
	};
}
function getAllEventCtrl($scope, $http, $routeParams, $timeout, $window,$location) 
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
	$scope.getAllEventsForSchool = function()
	{
		
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllEventsForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.eventList = response.data.data;
				var formattedDate;
				for(var i = 0; i < $scope.eventList.length; i++)
				{
					formattedDate = $scope.convertDateFormat($scope.eventList[i].date);
					$scope.eventList[i]['formattedDate'] = formattedDate;
				}
				
				var encrypted ;
				for(var i = 0; i < $scope.eventList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.eventList[i].id);
					$scope.eventList[i]['eventID'] = encrypted;
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllEventsForSchool();
	$scope.sort = function(keyname){
		$scope.sortKey = keyname;
		$scope.reverse = !$scope.reverse;
	}
	
	$scope.convertDateFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [day, mnth, date.getFullYear()].join("-");
	}
	
	$scope.eventDelete = function(eventID)
	{
		var retn=1
		var checlPrivilege=JSON.parse(jsonPrivilege);
		if(checlPrivilege.length==0){
			var cnt=checlPrivilege.length;
			}else{
			var cnt=jsonPrivilege.length;
		}
		if(cnt>0){
			if(checlPrivilege.Events['delete']==0){
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
			$http.post(BASE_URL+'api/user/deleteEvent',formData,{
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
							text: 'Event deleted successfully.'
						});
						
						$scope.getAllEventsForSchool();
						return false;
					}();
				}
				
				}, function errorCallback(response){
				
			});
		}
	}
}
function allEventCtrl($scope, $http, $routeParams, $timeout) 
{
	var sid;
	$scope.eventID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.eventID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.eventID;
	};	
	$timeout($scope.setID(), 2000);
	//alert($scope.eventID); return false;
	$scope.eventinfo = false;
	$scope.getEventDetails = function()
	{
		var formData = {'id':$scope.eventID}
		$http.post(BASE_URL+'api/user/getEventDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.eventinfo = response.data.data;
				
				$scope.title 		= $scope.eventinfo.title;
				$scope.address 		= $scope.eventinfo.address;
				$scope.pic 			= $scope.eventinfo.pic;
				$scope.visibility 	= $scope.eventinfo.visibility;
				$scope.date 		= $scope.eventinfo.date;
				$scope.time 		= $scope.eventinfo.time;
				$scope.description 	= $scope.eventinfo.description;
				$scope.is_paid 		= $scope.eventinfo.is_paid;
				$scope.amount 		= $scope.eventinfo.amount;
				var arr = $scope.visibility.split(',');
				$scope.visiblityArr = arr;
				$scope.formattedDate = $scope.convertDateFormat($scope.date);
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getEventDetails();
	$scope.convertDateFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [day, mnth, date.getFullYear()].join("-");
	}
}
function addEventCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.eventtitle 	  	= '';
	$scope.eventvisiblity 	= "";
	$scope.eventdate 		= '';
	$scope.eventtime 		= '';
	$scope.eventaddress 	= '';
	$scope.eventdesc 		= '';
	$scope.eventtype 		= '';
	$scope.eventamount 		= '';
	$scope.eventphoto 		= '';
	$scope.objE = {eventvisiblity:[]};
	$scope.userTypeList = [{"val":"0","name":"Teacher"},{"val":"1","name":"Parent"}]; 
	
	
	$scope.convertDateNewFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [date.getFullYear(), mnth, day].join("-");
	}
	$scope.onChange = function (files) {
		if(files[0] == undefined) return;
		$scope.fileExt = files[0].name.split(".").pop();
	}
	$scope.isImage = function(ext) {
		if(ext) {
			return ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png";
		}
	}
	
	$scope.addEvent = function(){		
		if($scope.eventtype == '1' && $scope.eventamount == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Event Amount Should Not Be Empty.'
				});
				window.location.reload();
				// return false;
			}();
				window.location.reload();
			// return false;
		}
		
		if($scope.eventtitle == '' || $scope.objE.eventvisiblity.length == 0 || $scope.eventdate == ''|| $scope.eventdate == null|| $scope.eventtime == ''|| $scope.eventtime == null || $scope.eventaddress == '' || $scope.eventtype == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill all required fields(Indicating With * Sign).'
				});
				// return false;
				window.location.reload();
			}();
			// return false;
			window.location.reload();
		}
		var formData = new FormData();
		formData.append('eventtitle', $scope.eventtitle);
		formData.append('eventvisiblity', $scope.objE.eventvisiblity.join());
		formData.append('eventdate', $scope.convertDateNewFormat($scope.eventdate));
		formData.append('eventtime', $scope.eventtime);
		formData.append('eventaddress', $scope.eventaddress);
		formData.append('eventdesc', $scope.eventdesc);
		formData.append('eventtype', $scope.eventtype);
		formData.append('eventamount', $scope.eventamount);
		formData.append('schoolId', School_ID);
		
		var files = document.getElementById('pic').files[0];
		formData.append('pic',files);
		
		$http.post(BASE_URL+'api/user/addEvent',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Event added successfully.'
				});
				$window.location.href = '#!/event-list';
				return false;
			}();
			
			}, function errorCallback(response){
		});
	};
}
function editEventCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	var sid;
	$scope.eventID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.eventID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.eventID;
	};
	$timeout($scope.setID(), 2000);
	$scope.convertDateNewFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [date.getFullYear(), mnth, day].join("-");
	}
	$scope.eventinfo = false;
	$scope.userTypeList = [{"val":"0","name":"Teacher"},{"val":"1","name":"Parent"}]; 
	$scope.objE = {eventvisiblity:[]};
	$scope.getEventDetails = function()
	{
		var formData = {'id':$scope.eventID}
		$http.post(BASE_URL+'api/user/getEventDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.eventinfo = response.data.data;
				
				$scope.eventId 			= $scope.eventinfo.id;
				$scope.eventtitle 		= $scope.eventinfo.title;
				$scope.eventaddress 	= $scope.eventinfo.address;
				$scope.eventphoto 		= $scope.eventinfo.pic;
				$scope.eventvisiblity 	= $scope.eventinfo.visibility;
				$scope.eventdate 		= new Date($scope.eventinfo.date);
				$scope.eventtime 		= new Date (new Date().toDateString() + ' ' + $scope.eventinfo.time);
				$scope.eventdesc 		= $scope.eventinfo.description;
				$scope.eventtype 		= $scope.eventinfo.is_paid;
				$scope.eventamount 		= $scope.eventinfo.amount;
				$scope.visibility 		= $scope.eventvisiblity;
				$scope.objE.eventvisiblity = $scope.eventvisiblity.split(',');
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getEventDetails();
	$scope.editEvent = function(eventId)
	{
		
		if($scope.eventtitle == '' || $scope.objE.eventvisiblity.length == 0 || $scope.eventdate == ''|| $scope.eventdate == null|| $scope.eventtime == ''|| $scope.eventtime == null || $scope.eventaddress == '' || $scope.eventtype == '')
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
		
		if($scope.eventtype == '1' && $scope.eventamount == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Event Amount Should Not Be Empty.'
				});
				return false;
			}();
			return false;
		}
		var formData = new FormData();
		formData.append('eventId', eventId);
		formData.append('eventtitle', $scope.eventtitle);
		formData.append('eventvisiblity', $scope.objE.eventvisiblity.join());
		formData.append('eventdate', $scope.convertDateNewFormat($scope.eventdate));
		formData.append('eventtime', $scope.eventtime);
		formData.append('eventaddress', $scope.eventaddress);
		formData.append('eventdesc', $scope.eventdesc);
		formData.append('eventtype', $scope.eventtype);
		formData.append('eventamount', $scope.eventamount);
		formData.append('schoolId', School_ID);
		
		var files = document.getElementById('pic').files[0];
		formData.append('pic',files);
		$http.post(BASE_URL+'api/user/editEvent',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Event updated successfully.'
				});
				$window.location.href = '#!/event-list';
				return false;
			}();
			
			}, function errorCallback(response){
		});
	};
}
function getAllDriverCtrl($scope, $http, $routeParams, $timeout) 
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
	$scope.getAllDriverForSchool = function()
	{
		$scope.driverList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllDriverForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.driverList = response.data.data;
				var formattedDate;
				for(var i = 0; i < $scope.driverList.length; i++)
				{
					formattedDate = $scope.convertDateFormat($scope.driverList[i].date);
					$scope.driverList[i]['formattedDate'] = formattedDate;
				}
				
				var encrypted ;
				for(var i = 0; i < $scope.driverList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.driverList[i].id);
					$scope.driverList[i]['driverID'] = encrypted;
				}
				console.log($scope.driverList); return false
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllDriverForSchool();
	
	$scope.sort = function(keyname){
		$scope.sortKey = keyname;
		$scope.reverse = !$scope.reverse;
	}
	
	$scope.convertDateFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [day, mnth, date.getFullYear()].join("-");
	}
	
	$scope.driverDisabled = function(driverID, status)
	{
		var formData1 = {'id':driverID, 'status':status};
		$http.post(BASE_URL+'api/user/driverDisabled',formData1,{
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
							text: 'Driver Status Disabled Now.'
						});
					}else if(status == 1)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'Driver Status Enabled Now.'
						});
					}
					
					$scope.getAllDriverForSchool();
					return false;
				}();
			}
			
			}, function errorCallback(response){
			
		});
		
	}
}
function addDriverCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.driverfname 	  		= '';
	$scope.driverlname 			= '';
	$scope.driveremail 			= '';
	$scope.driverphone 			= '';
	$scope.driverdeviceId 		= '';
	$scope.drivervehicle 		= '';
	$scope.driverroute 			= '';
	$scope.driverlicense 		= '';
	$scope.driverLicenseExpire 	= '';
	$scope.driverphoto 			= '';
	$scope.driverdocument 		= '';
	$scope.driveraddress 		= '';
	$scope.dpincode 			= '';
	$scope.dcity 				= '';
	$scope.dstate 				= '';
	$scope.dcountry 			= '';
	$scope.emergencyfname 		= '';
	$scope.emergencylname 		= '';
	$scope.emergencyphone 		= '';
	$scope.emergencyemail 		= '';
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
	
	$scope.addDriver = function(){
		
		$scope.convertDateNewFormat = function(str) {
			var date = new Date(str),
			mnth = ("0" + (date.getMonth() + 1)).slice(-2),
			day = ("0" + date.getDate()).slice(-2);
			return [date.getFullYear(), mnth, day].join("-");
		}
		if($scope.driverfname == '' || $scope.driverlname == '' || $scope.driveremail == '' || $scope.driverphone == '' || $scope.driverdeviceId == '' || $scope.drivervehicle == '' || $scope.driverroute == '' || $scope.driverlicense == '' || $scope.driverLicenseExpire == '' || $scope.driveraddress == '' || $scope.emergencyfname == '' || $scope.emergencylname == '' || $scope.emergencyphone == '' || $scope.emergencyemail == '')
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
		formData.append('driverfname', $scope.driverfname);
		formData.append('driverlname', $scope.driverlname);
		formData.append('driveremail', $scope.driveremail);
		formData.append('driverphone', $scope.driverphone);
		formData.append('driverdeviceId', $scope.driverdeviceId);
		formData.append('drivervehicle', $scope.drivervehicle);
		formData.append('driverroute', $scope.driverroute);
		formData.append('driverlicense', $scope.driverlicense);
		formData.append('driverLicenseExpire', $scope.convertDateNewFormat($scope.driverLicenseExpire));
		formData.append('driveraddress', $scope.driveraddress);
		formData.append('dpincode', $scope.dpincode);
		formData.append('dcity', $scope.dcity);
		formData.append('dstate', $scope.dstate);
		formData.append('dcountry', $scope.dcountry);
		formData.append('emergencyfname', $scope.emergencyfname);
		formData.append('emergencylname', $scope.emergencylname);
		formData.append('emergencyphone', $scope.emergencyphone);
		formData.append('emergencyemail', $scope.emergencyemail);
		formData.append('schoolId', School_ID);
		
		var files1 = document.getElementById('pic').files[0];
		formData.append('pic',files1);
		
		var files2 = document.getElementById('document').files[0];
		formData.append('document',files2);
		
		$http.post(BASE_URL+'api/user/addDriver',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Driver added successfully.'
				});
				$window.location.href = '#!/driver-list';
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
						text: 'Email/Phone already exist.'
					});
					
					return false;
				}();
			}
		});
	};
}
function allDriverCtrl($scope, $http, $routeParams, $timeout, $window) 
{
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
function editDriverCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.convertDateNewFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [date.getFullYear(), mnth, day].join("-");
	}
	$scope.driverfname 	  		= '';
	$scope.driverlname 			= '';
	$scope.driveremail 			= '';
	$scope.driverphone 			= '';
	$scope.driverdeviceId 		= '';
	$scope.drivervehicle 		= '';
	$scope.driverroute 			= '';
	$scope.driverlicense 		= '';
	$scope.driverLicenseExpire 	= '';
	$scope.driverphoto 			= '';
	$scope.driverdocument 		= '';
	$scope.driveraddress 		= '';
	$scope.dpincode 			= '';
	$scope.dcity 				= '';
	$scope.dstate 				= '';
	$scope.dcountry 			= '';
	$scope.emergencyfname 		= '';
	$scope.emergencylname 		= '';
	$scope.emergencyphone 		= '';
	$scope.emergencyemail 		= '';
	
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
				//console.log($scope.driverinfo);
				$scope.driverfname 	  		= $scope.driverinfo.driverfname;
				$scope.driverlname 			= $scope.driverinfo.driverlname;
				$scope.driveremail 			= $scope.driverinfo.driveremail;
				$scope.driverphone 			= $scope.driverinfo.driverphone;
				$scope.driverdeviceId 		= $scope.driverinfo.driverdeviceId;
				$scope.drivervehicle 		= $scope.driverinfo.driverVechiclenumber;
				$scope.driverroute 			= $scope.driverinfo.driverroute;
				$scope.driverlicense 		= $scope.driverinfo.driverlicense;
				$scope.driverLicenseExpire 	= $scope.driverinfo.driverLicenseExpire;
				if($scope.driverLicenseExpire != '')
				{
					$scope.driverLicenseExpire 	= new Date($scope.driverinfo.driverLicenseExpire);
				}
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
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getDriverDetails();
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
	
	$scope.editDriver = function(){
		
		if($scope.driverfname == '' || $scope.driverlname == '' || $scope.driveremail == '' || $scope.driverphone == '' || $scope.driverdeviceId == '' || $scope.drivervehicle == '' || $scope.driverroute == '' || $scope.driverlicense == '' || $scope.driverLicenseExpire == '' || $scope.driveraddress == '' || $scope.emergencyfname == '' || $scope.emergencylname == '' || $scope.emergencyphone == '' || $scope.emergencyemail == '')
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
		formData.append('driverfname', $scope.driverfname);
		formData.append('id', $scope.driverID);
		formData.append('driverlname', $scope.driverlname);
		formData.append('driveremail', $scope.driveremail);
		formData.append('driverphone', $scope.driverphone);
		formData.append('driverdeviceId', $scope.driverdeviceId);
		formData.append('drivervehicle', $scope.drivervehicle);
		formData.append('driverroute', $scope.driverroute);
		formData.append('driverlicense', $scope.driverlicense);
		formData.append('driverLicenseExpire', $scope.convertDateNewFormat($scope.driverLicenseExpire));
		formData.append('driveraddress', $scope.driveraddress);
		formData.append('dpincode', $scope.dpincode);
		formData.append('dcity', $scope.dcity);
		formData.append('dstate', $scope.dstate);
		formData.append('dcountry', $scope.dcountry);
		formData.append('emergencyfname', $scope.emergencyfname);
		formData.append('emergencylname', $scope.emergencylname);
		formData.append('emergencyphone', $scope.emergencyphone);
		formData.append('emergencyemail', $scope.emergencyemail);
		formData.append('schoolId', School_ID);
		formData.append('driverphoto', $scope.driverphoto);
		formData.append('driverdocument', $scope.driverdocument);
		
		var files1 = document.getElementById('pic').files[0];
		formData.append('pic',files1);
		
		var files2 = document.getElementById('document').files[0];
		formData.append('document',files2);
		
		$http.post(BASE_URL+'api/user/editDriver',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Driver Updated successfully.'
				});
				$window.location.href = '#!/driver-list';
				return false;
			}();
			
			}, function errorCallback(response){
			
			var errresult = response.data.message
			var errresult = response.data.message
			//console.log(response);
			if(errresult == 'Already Exists.')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Failed',
						text: 'Email/Phone already exist.'
					});
					
					return false;
				}();
			}
		});
	};
	
}
function getAllSessionCtrl($scope, $http, $routeParams, $timeout) 
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
	$scope.getAllSessionForSchool = function()
	{
		$scope.sessionList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllSessionForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.sessionList = response.data.data;
				var formattedstart;
				for(var i = 0; i < $scope.sessionList.length; i++)
				{
					formattedstart = $scope.convertDateFormat($scope.sessionList[i].sessionstart);
					$scope.sessionList[i]['formattedstart'] = formattedstart;
				}
				var formattedend;
				for(var i = 0; i < $scope.sessionList.length; i++)
				{
					formattedend = $scope.convertDateFormat($scope.sessionList[i].sessionend);
					$scope.sessionList[i]['formattedend'] = formattedend;
				}
				
				var encrypted ;
				for(var i = 0; i < $scope.sessionList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.sessionList[i].id);
					$scope.sessionList[i]['sessionID'] = encrypted;
				}
				if(  ($scope.sessionList.length) < 10 ){
						$scope.pageSize = $scope.sessionList.length;
						$scope.currentPage=1;
						$scope.itemsPerPage=1;
				}else
				{
						$scope.pageSize = 10;
						$scope.currentPage=1;
						$scope.itemsPerPage=1;
				}
				// console.log($scope.sessionList);
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllSessionForSchool();
	$scope.convertDateFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [day, mnth, date.getFullYear()].join("-");
	}
	
	$scope.sessionDisabled = function(sessionID, status)
	{
		var formData1 = {'id':sessionID, 'status':status};
		$http.post(BASE_URL+'api/user/sessionDisabled',formData1,{
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
							text: 'Session Status Disabled Now.'
						});
					}else if(status == 1)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'Session Status Enabled Now.'
						});
					}
					
					$scope.getAllSessionForSchool();
					return false;
				}();
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	
	$scope.makeCurrentSession = function(sessionID, status)
	{
		var formData1 = {'id':sessionID, 'status':status};
		$http.post(BASE_URL+'api/user/makeCurrentSession',formData1,{
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
							text: 'Current Session Status Disabled Now.'
						});
					}else if(status == 1)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'This Session Status Is Current Now.'
						});
					}
					
					$scope.getAllSessionForSchool();
					return false;
				}();
			}
			
			}, function errorCallback(response){
			
		});
		
	}
}
function addSessionCtrl($scope, $http, $routeParams, $timeout,$window) 
{
	$scope.convertedDateForSession = function(str)
	{
		var date = new Date(str),
		month = date.toLocaleString('default', { month: 'short' });
		return [date.getFullYear(),month].join(" ");
		
	}
	
	$scope.convertDateNewFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [date.getFullYear(), mnth, day].join("-");
	}
	
	$scope.academicsession 	= '';
	$scope.sessionstart 	= '';
	$scope.sessionend 		= '';
	$scope.formattedsessionstart 	= '';
	$scope.formattedsessionend 		= '';
	
	$scope.addSession = function(){
		if($scope.academicsession == '' || $scope.sessionstart == '' || $scope.sessionend == ''|| $scope.sessionstart == null || $scope.sessionend == null)
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
		
		if(new Date($scope.sessionstart) >= new Date($scope.sessionend))
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Session End Date Must Be Greater Than Session Start Date.'
				});
				return false;
			}();
			return false;
		}
		
		$scope.formattedsessionstart = $scope.convertedDateForSession($scope.sessionstart);
		$scope.formattedsessionend = $scope.convertedDateForSession($scope.sessionend);
		
		var formData = new FormData();
		formData.append('academicsession', $scope.academicsession);
		formData.append('sessionstart', $scope.convertDateNewFormat($scope.sessionstart));
		formData.append('sessionend', $scope.convertDateNewFormat($scope.sessionend));
		formData.append('formattedsessionstart', $scope.formattedsessionstart);
		formData.append('formattedsessionend', $scope.formattedsessionend);
		formData.append('schoolId', School_ID);
		
		$http.post(BASE_URL+'api/user/addSession',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			// var result  = response.data;
			var result  = response.data.data;
			if(result == 'exist'){
				var Gritter = function () {
					$.gritter.add({
						title: 'Failed',
						text: 'Session Data already exist.'
					});
					$window.location.href = '#!/add-session';
					return false;
				}();
			}else{

				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: 'Session added successfully.'
					});
					$window.location.href = '#!/session-list';
					return false;
				}();

			}
			
			}, function errorCallback(response){
		});
	};
}
function editSessionCtrl($scope, $http, $routeParams, $timeout,$window) 
{
	var sid;
	$scope.sessionID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.sessionID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.sessionID;
	};	
	$timeout($scope.setID(), 2000);
	//alert($scope.sessionID); return false;
	$scope.convertedDateForSession = function(str)
	{
		var date = new Date(str),
		month = date.toLocaleString('default', { month: 'short' });
		return [date.getFullYear(),month].join(" ");
		
	}
	
	$scope.convertDateNewFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [date.getFullYear(), mnth, day].join("-");
	}
	
	$scope.sessioninfo = false;
	$scope.getSessionDetails = function()
	{
		var formData = {'id':$scope.sessionID}
		$http.post(BASE_URL+'api/user/getSessionDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.sessioninfo = response.data.data;
				$scope.academicsession  = $scope.sessioninfo.academicsession;
				$scope.sessionstart 	= new Date($scope.sessioninfo.sessionstart);
				$scope.sessionend 		= new Date($scope.sessioninfo.sessionend);
				$scope.schoolName 		= $scope.sessioninfo.school_name;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getSessionDetails();
	$scope.editSession = function(){
		
		if($scope.academicsession == '' || $scope.sessionstart == '' || $scope.sessionend == ''|| $scope.sessionstart == null || $scope.sessionend == null)
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
		
		if(new Date($scope.sessionstart) >= new Date($scope.sessionend))
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Session End Date Must Be Greater Than Session Start Date.'
				});
				return false;
			}();
			return false;
		}
		
		$scope.formattedsessionstart = $scope.convertedDateForSession($scope.sessionstart);
		$scope.formattedsessionend = $scope.convertedDateForSession($scope.sessionend);
		
		var formData = new FormData();
		formData.append('id', $scope.sessionID);
		formData.append('academicsession', $scope.academicsession);
		formData.append('sessionstart', $scope.convertDateNewFormat($scope.sessionstart));
		formData.append('sessionend', $scope.convertDateNewFormat($scope.sessionend));
		formData.append('formattedsessionstart', $scope.formattedsessionstart);
		formData.append('formattedsessionend', $scope.formattedsessionend);
		formData.append('schoolId', School_ID);
		
		$http.post(BASE_URL+'api/user/editSession',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Session Updated successfully.'
				});
				$window.location.href = '#!/session-list';
				return false;
			}();
			
			}, function errorCallback(response){
			
			var errresult = response.data.message
			$scope.getSessionDetails();
		});
	};
	
}
function getAllClassCtrl($scope, $http, $routeParams, $timeout) 
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
	$scope.getAllClassForSchool = function()
	{
		$scope.classList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllClassForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.classList = response.data.data;
				
				var encrypted ;
				for(var i = 0; i < $scope.classList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.classList[i].id);
					$scope.classList[i]['classID'] = encrypted;
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllClassForSchool();
	$scope.sort = function(keyname){
		$scope.sortKey = keyname;
		$scope.reverse = !$scope.reverse;
	}
	$scope.sectionDisabled = function(sectionID, status)
	{
		var formData1 = {'id':sectionID, 'status':status};
		$http.post(BASE_URL+'api/user/sectionDisabled',formData1,{
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
							text: 'Section Status Disabled Now.'
						});
					}else if(status == 1)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'section Status Enabled Now.'
						});
					}
					
					$scope.getAllClassForSchool();
					return false;
				}();
			}
			
			}, function errorCallback(response){
			
		});
		
	}
}
function addClassCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.getAllSessionForSchool = function()
	{
		$scope.sessionList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllSessionForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.sessionList = response.data.data;
				//console.log($scope.sessionList);
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	// To get the school type
	$scope.schoolTypeList = [];
	$scope.getSchoolType = function(){ 
	        $http.get(BASE_URL+'api/scheduler/schoolType',{headers:{'Content-Type':undefined, 'x-api-key':xapikey}}).then(function(response) 
	        {
	            $scope.schoolTypeList  = response.data;	
	            $scope.school_type = $scope.schoolTypeList[0].value;		
	            //console.log($scope.schoolTypeList);
			});
		};
	$scope.getSchoolType();

	$scope.getAllSessionForSchool();
	
	$scope.academicsession 	= '';
	$scope.class 			= '';
	$scope.section 			= '';
	$scope.school_type 		= '';
	
	$scope.addClass = function(){
		if($scope.academicsession == '' || $scope.class == '' || $scope.section == '' ||  $scope.school_type == '')
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
		formData.append('academicsession', $scope.academicsession);
		formData.append('class', $scope.class);
		formData.append('section', $scope.section);
		formData.append('school_type', $scope.school_type);
		formData.append('schoolId', School_ID);
		
		$http.post(BASE_URL+'api/user/addClass',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Class added successfully.'
				});
				$window.location.href = '#!/class-list';
				return false;
			}();
			
			}, function errorCallback(response){
		});
	};
}
function editClassCtrl($scope, $http, $routeParams, $timeout) 
{
	$scope.getAllSessionForSchool = function()
	{
		$scope.sessionList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllSessionForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.sessionList = response.data.data;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllSessionForSchool();

	// To get the school type
	$scope.schoolTypeList = [];
	$scope.getSchoolType = function(){ 
	        $http.get(BASE_URL+'api/scheduler/schoolType',{headers:{'Content-Type':undefined, 'x-api-key':xapikey}}).then(function(response) 
	        {
	            $scope.schoolTypeList  = response.data;	
	            // $scope.school_type = $scope.schoolTypeList[0].value;		
	            //console.log($scope.schoolTypeList);
			});
		};
	$scope.getSchoolType();

	$scope.sort = function(keyname){
		$scope.sortKey = keyname;
		$scope.reverse = !$scope.reverse;
	}
	
	var sid;
	$scope.classID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.classID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.classID;
	};	
	$timeout($scope.setID(), 2000);
	//alert($scope.classID); return false;
	$scope.classinfo = false;
	$scope.getClassDetails = function()
	{
		var formData = {'id':$scope.classID}
		$http.post(BASE_URL+'api/user/getClassDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.classinfo = response.data.data;
				$scope.academicsession  = $scope.classinfo.academicsession;
				$scope.class  = $scope.classinfo.class;
				$scope.section  = $scope.classinfo.section;
				$scope.school_type  = $scope.classinfo.school_type;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getClassDetails();
	
	$scope.editClass = function(){
		
		if($scope.academicsession == '' || $scope.class == '' || $scope.section == '')
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
		formData.append('id', $scope.classID);
		formData.append('academicsession', $scope.academicsession);
		formData.append('class', $scope.class);
		formData.append('section', $scope.section);
		formData.append('school_type', $scope.school_type);
		formData.append('schoolId', School_ID);
		
		$http.post(BASE_URL+'api/user/editClass',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Class Updated successfully.'
				});
				$scope.getClassDetails();
				return false;
			}();
			
			}, function errorCallback(response){
			
			var errresult = response.data.message
			if(errresult == 'Section Already Exists.')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: 'This Section Already Exists.'
					});
					$scope.getClassDetails();
					return false;
				}();
			}
		});
	};
	
}
function getAllSubjectCtrl($scope, $http, $routeParams, $timeout) 
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
	$scope.getAllSubjectForSchool = function()
	{
		$scope.subjectList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllSubjectForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.subjectList = response.data.data;
				
				var encrypted ;
				for(var i = 0; i < $scope.subjectList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.subjectList[i].id);
					$scope.subjectList[i]['subjectID'] = encrypted;
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllSubjectForSchool();
	
	$scope.subjectsDisabled = function(subjectID, status)
	{
		var formData1 = {'id':subjectID, 'status':status};
		$http.post(BASE_URL+'api/user/subjectsDisabled',formData1,{
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
							text: 'Subject Status Disabled Now.'
						});
					}else if(status == 1)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'Subject Status Enabled Now.'
						});
					}
					
					$scope.getAllSubjectForSchool();
					return false;
				}();
			}
			
			}, function errorCallback(response){
			
		});
		
	}
}
function addSubjectCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.subject 	= '';
	$scope.class 	= '';
	$scope.teacher 	= '';
	$scope.description 	= '';
	$scope.pic 	= '';

	$scope.onChange = function (files) {
		if(files[0] == undefined) return;
		$scope.fileExt = files[0].name.split(".").pop();
	}
	$scope.isImage = function(ext) {
		if(ext) {
			return ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png";
		}
	}
	$scope.ob = {"class":"","teacher":""};
	$scope.addSubject = function(){
		
		if($scope.subject == '' || $scope.ob.class == '' || $scope.ob.teacher == '' || $scope.description == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill required field.'
				});
				return false;
			}();
			return false;
		}
		$scope.subject_code = $scope.subject.substring(0,3).toUpperCase()+School_ID;
		var formData = new FormData();
		formData.append('subject', $scope.subject);
		formData.append('subject_code', $scope.subject_code);
		formData.append('schoolId', School_ID);
		formData.append('class', $scope.ob.class);
		formData.append('teacher', $scope.ob.teacher);
		formData.append('description', $scope.description);
		var files = document.getElementById('pic').files[0];
		formData.append('pic',files);
		$http.post(BASE_URL+'api/user/addSubject',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Subject added successfully.'
				});
				$window.location.href = '#!/subject-list';
				return false;
			}();
			
			}, function errorCallback(response){
		});
	};
	$scope.TeacherList = [];
	$scope.getTeachers = function(){
		$http.post(BASE_URL+'api/user/getAllTeacherForSchool',{id:School_ID},{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			$scope.TeacherList = response.data.data;
			//console.log($scope.TeacherList);			
			}, function errorCallback(response){
		});
	};
	$scope.getTeachers();
	$scope.classList = [];
	$scope.getClasses = function(){
		$http.post(BASE_URL+'api/user/getAllClassForSchool',{id:School_ID},{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			$scope.classList = response.data.data;
			//console.log($scope.classList);			
			}, function errorCallback(response){
		});
	};
	$scope.getClasses();
	
	//api/user/getAllTeacherForSchool
}
function editSubjectCtrl($scope, $http, $routeParams, $timeout,$window) 
{
	$scope.onChange = function (files) {
		if(files[0] == undefined) return;
		$scope.fileExt = files[0].name.split(".").pop();
	}
	$scope.isImage = function(ext) {
		if(ext) {
			return ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png";
		}
	}
	var sid;
	$scope.subjectID = '';
	$scope.ob = {"id":"","subject":"","schoolId":School_ID,"class":"","teacher":""};
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.subjectID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.subjectID;
	};	
	$timeout($scope.setID(), 2000);
	//alert($scope.subjectID); return false;
	$scope.subjectinfo = false;
	$scope.getSubjectDetails = function()
	{
		var formData = {'id':$scope.subjectID}
		$http.post(BASE_URL+'api/user/getSubjectDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.subjectinfo = response.data.data;
				$scope.subject  = $scope.subjectinfo.subject;
				$scope.ob.class  = $scope.subjectinfo.class;
				$scope.ob.teacher  = $scope.subjectinfo.teacher;
				$scope.description  = $scope.subjectinfo.description;
				$scope.photo  = $scope.subjectinfo.image;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getSubjectDetails();
	//return false;
	$scope.editSubject = function(){		
		if($scope.subject == '' || $scope.ob.class == '' || $scope.ob.teacher == '' || $scope.description == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill required field.'
				});
				return false;
			}();
			return false;
		}
		$scope.ob.id = $scope.subjectID;	
		var formData = new FormData();
		formData.append('id', $scope.subjectID);
		formData.append('schoolId', School_ID);
		formData.append('subject', $scope.subject);
		formData.append('class', $scope.ob.class);
		formData.append('teacher', $scope.ob.teacher);
		formData.append('description', $scope.description);
		var files = document.getElementById('pic').files[0];
		formData.append('pic',files);			
		$http.post(BASE_URL+'api/user/editSubject',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Subject Updated successfully.'
				});
				$window.location.href = '#!/subject-list';
				return false;
			}();
			
			}, function errorCallback(response){
		});
	};
	
	$scope.TeacherList = [];
	$scope.getTeachers = function(){
		$http.post(BASE_URL+'api/user/getAllTeacherForSchool',{id:School_ID},{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			$scope.TeacherList = response.data.data;
			//console.log($scope.TeacherList);			
			}, function errorCallback(response){
		});
	};
	$scope.getTeachers();
	$scope.classList = [];
	$scope.getClasses = function(){
		$http.post(BASE_URL+'api/user/getAllClassForSchool',{id:School_ID},{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			$scope.classList = response.data.data;			
			}, function errorCallback(response){
		});
	};
	$scope.getClasses();
	
}
function getAllTeacherCtrl($scope, $http, $routeParams, $timeout) 
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
	$scope.getAllTeacherForSchool = function()
	{
		$scope.teacherList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllTeacherForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.teacherList = response.data.data;
				// console.log($scope.teacherList);
				// return false
				var encrypted ;
				for(var i = 0; i < $scope.teacherList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.teacherList[i].id);
					$scope.teacherList[i]['teacherID'] = encrypted;
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllTeacherForSchool();
	
	$scope.sort = function(keyname){
		$scope.sortKey = keyname;
		$scope.reverse = !$scope.reverse;
	}
	
	$scope.teacherDisabled = function(subjectID, status)
	{
		var formData1 = {'id':subjectID, 'status':status};
		$http.post(BASE_URL+'api/user/teacherDisabled',formData1,{
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
							text: 'Teacher Status Disabled Now.'
						});
					}else if(status == 1)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'Teacher Status Enabled Now.'
						});
					}
					
					$scope.getAllTeacherForSchool();
					return false;
				}();
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	
}
function addTeacherCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.convertDateNewFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [date.getFullYear(), mnth, day].join("-");
	}
	
	$scope.educationalfields = [{
		qualification:'',
		year_of_passing:'',
		percentage:'',
		board:'',
		educationcertificate:''
	}];
	
	$scope.addEducationalFields = function() {
		$scope.educationalfields.push({
			qualification:'',
			year_of_passing:'',
			percentage:'',
			board:'',
			educationcertificate:''
		});
	}
	
	$scope.removeEducationalFields = function(index) {
		$scope.educationalfields.splice(index,1);
	}
	
	$scope.experiancefields = [{
		schoolname:'',
		numofyears:'',
		designation:'',
		datefrom:'',
		dateto:'',
		experiencecertificate:''
		
	}];
	
	$scope.addExperianceFields = function() {
		$scope.experiancefields.push({
			schoolname:'',
			numofyears:'',
			designation:'',
			datefrom:'',
			dateto:'',
			experiencecertificate:''
			
		});
	}
	
	$scope.removeExperianceFields = function(index) {
		$scope.experiancefields.splice(index,1);
	}
	
	$('#experience').click(function() {
		if ($(this).is(':checked')) {
			$('.exp-container').show();
		}
	});
	$('#Fresher').click(function() {
		if ($(this).is(':checked')) {
			$('.exp-container').hide();
		}
	});
	$scope.pageSize = 10;
	$scope.getAllSubjectForSchool = function()
	{
		$scope.subjectList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllSubjectForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.subjectList = response.data.data;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllSubjectForSchool();
	
	$scope.getAllClassForSchool = function()
	{
		$scope.classList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllClassForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.classList = response.data.data;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllClassForSchool();
	
	$scope.teacherfname 		= '';
	$scope.teachermname 		= '';
	$scope.teacherlname 		= '';
	$scope.teacheremail 		= '';
	$scope.teacherphone 		= '';
	$scope.teachergender 		= '';
	$scope.maritalStatus 		= '';
	$scope.spousename 			= '';
	$scope.spousenumber 		= '';
	$scope.date_of_joining 		= '';
	$scope.bloodgroup 			= '';
	$scope.date_of_birth 		= '';
	$scope.religion 			= '';
	$scope.schoolType 			= '';
	$scope.assignclassteacher 	= '';
	$scope.subjectteacher 		= '';
	$scope.teacheraddress 		= '';
	$scope.tcountry 			= '';
	$scope.tstate 				= '';
	$scope.tcity 				= '';
	$scope.tpincode 			= '';
	$scope.health 				= '';
	$scope.identification 		= '';
	$scope.workexp 				= '';
	$scope.password 			= '';
	$scope.confirmpassword 		= '';
	
	$scope.uploadEducationCertificate = function(fieldname,index)
	{
		var formData = new FormData();
		var files = document.getElementById('educationcertificate').files[0];
		formData.append('educationcertificate',files);
		
		$http.post(BASE_URL+'api/user/uploadEducationcertificate',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var resultmain  = response.data.data;
			$scope.educationalfields[index].educationcertificate = resultmain;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Education Certificate Uploaded successfully.'
				});
				return false;
			}();
			
            }, function errorCallback(response){
		});
	}
	
	$scope.uploadExperienceCertificate = function(fieldname,index)
	{
		var formData = new FormData();
		var files = document.getElementById('experiencecertificate').files[0];
		formData.append('experiencecertificate',files);
		
		$http.post(BASE_URL+'api/user/uploadExperienceCertificate',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var resultmain  = response.data.data;
			$scope.experiancefields[index].experiencecertificate = resultmain;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Experience Certificate Uploaded successfully.'
				});
				return false;
			}();
			
            }, function errorCallback(response){
		});
	}
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
	
	$scope.addTeacher = function(){
		
		if($scope.password == '' || $scope.confirmpassword == '' || $scope.teacherfname == '' || $scope.teacherlname == '' || $scope.teacheremail == '' || $scope.teacherphone == '' || $scope.teachergender == '' || $scope.maritalStatus == '' || $scope.spousename == '' || $scope.spousenumber == '' || $scope.date_of_joining == '' || $scope.date_of_birth == '' || $scope.schoolType == '' || $scope.assignclassteacher == '' || $scope.teacheraddress == '' || $scope.workexp == '')
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
		//return false;
		var formData = new FormData();
		formData.append('schoolId', School_ID);
		formData.append('password', $scope.password);
		formData.append('teacherfname', $scope.teacherfname);
		formData.append('teachermname', $scope.teachermname);
		formData.append('teacherlname', $scope.teacherlname);
		formData.append('teacheremail', $scope.teacheremail);
		formData.append('teacherphone', $scope.teacherphone);
		formData.append('teachergender', $scope.teachergender);
		formData.append('maritalStatus', $scope.maritalStatus);
		formData.append('spousename', $scope.spousename);
		formData.append('spousenumber', $scope.spousenumber);
		formData.append('date_of_joining', $scope.date_of_joining);
		formData.append('bloodgroup', $scope.bloodgroup);
		formData.append('date_of_birth', $scope.date_of_birth);
		formData.append('religion', $scope.religion);
		formData.append('schoolType', $scope.schoolType);
		formData.append('assignclassteacher', $scope.assignclassteacher);
		formData.append('subjectteacher', $scope.subjectteacher);
		formData.append('teacheraddress', $scope.teacheraddress);
		formData.append('tcountry', $scope.tcountry);
		formData.append('tstate', $scope.tstate);
		formData.append('tcity', $scope.tcity);
		formData.append('tpincode', $scope.tpincode);
		formData.append('workexp', $scope.workexp);
		formData.append('educationalfields', JSON.stringify($scope.educationalfields));
		formData.append('experiancefields', JSON.stringify($scope.experiancefields));
		
		var files1 = document.getElementById('health').files[0];
		formData.append('health',files1);
		
		var files2 = document.getElementById('identification').files[0];
		formData.append('identification',files2);
		
		var files3 = document.getElementById('teacherphoto').files[0];
		formData.append('teacherphoto',files3);
		
		if(files3 == undefined)
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
		
		$http.post(BASE_URL+'api/user/addTeacher',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Teacher added successfully.'
				});
				$window.location.href = '#!/teacher-list';
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
						text: 'Email/Phone already exist.'
					});
					
					return false;
				}();
			}
		});
	};
}
function allTeacherCtrl($scope, $http, $routeParams, $timeout) 
{
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
				$scope.subjectList		= $scope.teacherinfo.subjectList;
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
function editTeacherCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	var sid;
	$scope.teacherID = '';
	$scope.password = '';
	$scope.confirmpassword = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.teacherID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.teacherID;
	};	
	$timeout($scope.setID(), 2000);
	$scope.convertDateNewFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [date.getFullYear(), mnth, day].join("-");
	}
	$scope.educationalfields = [{
		qualification:'',
		year_of_passing:'',
		percentage:'',
		board:'',
		educationcertificate:''
	}];
	
	$scope.addEducationalFields = function() {
		$scope.educationalfields.push({
			qualification:'',
			year_of_passing:'',
			percentage:'',
			board:'',
			educationcertificate:''
		});
	}
	
	$scope.removeEducationalFields = function(index) {
		$scope.educationalfields.splice(index,1);
	}
	
	$scope.experiancefields = [{
		schoolname:'',
		numofyears:'',
		designation:'',
		datefrom:'',
		dateto:'',
		experiencecertificate:''
		
	}];
	
	$scope.addExperianceFields = function() {
		$scope.experiancefields.push({
			schoolname:'',
			numofyears:'',
			designation:'',
			datefrom:'',
			dateto:'',
			experiencecertificate:''
			
		});
	}
	
	$scope.removeExperianceFields = function(index) {
		$scope.experiancefields.splice(index,1);
	}
	
	$('#experience').click(function() {
		if ($(this).is(':checked')) {
			$('.exp-container').show();
		}
	});
	$('#Fresher').click(function() {
		if ($(this).is(':checked')) {
			$('.exp-container').hide();
		}
	});
	$scope.pageSize = 10;
	$scope.getAllSubjectForSchool = function()
	{
		$scope.subjectList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllSubjectForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.subjectList = response.data.data;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllSubjectForSchool();
	$scope.sort = function(keyname){
		$scope.sortKey = keyname;
		$scope.reverse = !$scope.reverse;
	}
	$scope.getAllClassForSchool = function()
	{
		$scope.classList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllClassForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.classList = response.data.data;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllClassForSchool();
	
	$scope.uploadEducationCertificate = function(fieldname,index)
	{
		var formData = new FormData();
		var files = document.getElementById('educationcertificate' + index).files[0];
		formData.append('educationcertificate',files);
		
		$http.post(BASE_URL+'api/user/uploadEducationcertificate',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var resultmain  = response.data.data;
			$scope.educationalfields[index].educationcertificate = resultmain;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Education Certificate Uploaded successfully.'
				});
				return false;
			}();
			
            }, function errorCallback(response){
		});
	}
	
	$scope.uploadExperienceCertificate = function(fieldname,index)
	{
		var formData = new FormData();
		var files = document.getElementById('experiencecertificate' + index).files[0];
		formData.append('experiencecertificate',files);
		
		$http.post(BASE_URL+'api/user/uploadExperienceCertificate',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var resultmain  = response.data.data;
			$scope.experiancefields[index].experiencecertificate = resultmain;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Experience Certificate Uploaded successfully.'
				});
				return false;
			}();
			
            }, function errorCallback(response){
		});
	}
	
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
				$scope.maritalStatus	= $scope.teacherinfo.maritalStatus;
				$scope.spousename		= $scope.teacherinfo.spousename;
				$scope.spousenumber		= $scope.teacherinfo.spousenumber;
				$scope.date_of_joining	= $scope.teacherinfo.date_of_joining;
				$scope.date_of_birth	= $scope.teacherinfo.date_of_birth;
				$scope.bloodgroup		= $scope.teacherinfo.bloodgroup;
				$scope.religion			= $scope.teacherinfo.religion;
				$scope.schoolType		= $scope.teacherinfo.schoolType;
				$scope.subjectteacher	= $scope.teacherinfo.subjectteacher;
				$scope.assignclassteacher	= $scope.teacherinfo.assignclassteacher;
				$scope.workexp			= $scope.teacherinfo.workexperience;
				$scope.classes			= $scope.teacherinfo.class;
				$scope.qualifications	= $scope.teacherinfo.qualifications;
				$scope.tcountry			= $scope.teacherinfo.tcountry;
				$scope.tstate			= $scope.teacherinfo.tstate;
				$scope.tcity			= $scope.teacherinfo.tcity;
				$scope.tpincode			= $scope.teacherinfo.tpincode;
				$scope.health			= $scope.teacherinfo.certificate;
				$scope.identification	= $scope.teacherinfo.document;
				$scope.teacherphoto		= $scope.teacherinfo.teacherphoto;
				
				if($scope.workexp == 'experience')
				{
					$('.exp-container').show();
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getTeacherDetails();
	
	$scope.teacherQualificationinfo = false;
	$scope.getTeacherQualificationDetails = function()
	{
		var formData = {'id':$scope.teacherID}
		$http.post(BASE_URL+'api/user/getTeacherQualificationDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.teacherQualificationinfo = response.data.data;
				$scope.educationalfields = $scope.teacherQualificationinfo;
				for(var i = 0; i < $scope.educationalfields.length; i++)
				{
					$scope.educationalfields[i]['year_of_passing'] = $scope.educationalfields[i].yearofpassing;
					$scope.educationalfields[i]['educationcertificate'] = $scope.educationalfields[i].certificate;
				}
				
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getTeacherQualificationDetails();
	
	$scope.teacherExperienceinfo = false;
	$scope.getTeacherExperienceDetails = function()
	{
		var formData = {'id':$scope.teacherID}
		$http.post(BASE_URL+'api/user/getTeacherExperienceDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.teacherExperienceinfo = response.data.data;
				$scope.experiancefields = $scope.teacherExperienceinfo;
				
				for(var i = 0; i < $scope.experiancefields.length; i++)
				{
					$scope.experiancefields[i]['datefrom'] = new Date($scope.experiancefields[i].datefrom);
					$scope.experiancefields[i]['experiencecertificate'] = $scope.experiancefields[i].employercertificate;
				}
				
				for(var i = 0; i < $scope.experiancefields.length; i++)
				{
					$scope.experiancefields[i]['dateto'] = new Date($scope.experiancefields[i].dateto);
				}
				for(var i = 0; i < $scope.experiancefields.length; i++)
				{
					$scope.experiancefields[i]['numofyears'] = $scope.experiancefields[i].numberofyears;
				}
				
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getTeacherExperienceDetails();
	
	$scope.convertDateFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [day, mnth, date.getFullYear()].join("-");
	}
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
	
	$scope.editTeacher = function(){
		if($scope.teacherfname == '' || $scope.teacherlname == '' || $scope.teacheremail == '' || $scope.teacherphone == '' || $scope.teachergender == '' || $scope.maritalStatus == '' || $scope.spousename == '' || $scope.spousenumber == '' || $scope.date_of_joining == '' || $scope.date_of_birth == '' || $scope.schoolType == '' || $scope.assignclassteacher == '' || $scope.teacheraddress == '' || $scope.workexp == '')
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
		formData.append('teacherId', $scope.teacherID);
		formData.append('password', $scope.password);
		formData.append('schoolId', School_ID);
		formData.append('teacherfname', $scope.teacherfname);
		formData.append('teachermname', $scope.teachermname);
		formData.append('teacherlname', $scope.teacherlname);
		formData.append('teacheremail', $scope.teacheremail);
		formData.append('teacherphone', $scope.teacherphone);
		formData.append('teachergender', $scope.teachergender);
		formData.append('maritalStatus', $scope.maritalStatus);
		formData.append('spousename', $scope.spousename);
		formData.append('spousenumber', $scope.spousenumber);
		formData.append('date_of_joining', $scope.date_of_joining);
		formData.append('bloodgroup', $scope.bloodgroup);
		formData.append('date_of_birth', $scope.date_of_birth);
		formData.append('religion', $scope.religion);
		formData.append('schoolType', $scope.schoolType);
		formData.append('assignclassteacher', $scope.assignclassteacher);
		formData.append('subjectteacher', $scope.subjectteacher);
		formData.append('teacheraddress', $scope.teacheraddress);
		formData.append('tcountry', $scope.tcountry);
		formData.append('tstate', $scope.tstate);
		formData.append('tcity', $scope.tcity);
		formData.append('tpincode', $scope.tpincode);
		formData.append('workexp', $scope.workexp);
		formData.append('healthnew', $scope.health);
		formData.append('identificationnew', $scope.identification);
		formData.append('teacherphotonew', $scope.teacherphoto);
		formData.append('educationalfields', JSON.stringify($scope.educationalfields));
		formData.append('experiancefields', JSON.stringify($scope.experiancefields));
		
		var files1 = document.getElementById('health').files[0];
		
		formData.append('health',files1);
		
		var files2 = document.getElementById('identification').files[0];
		formData.append('identification',files2);
		
		var files3 = document.getElementById('teacherphoto').files[0];
		formData.append('teacherphoto',files3);
		
		$http.post(BASE_URL+'api/user/editTeacher',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Teacher updated successfully.'
				});
				$window.location.href = '#!/teacher-list';
				return false;
			}();
			
            }, function errorCallback(response){
			if(errresult == 'Already Exists.')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Failed',
						text: 'Email/Phone already exist.'
					});
					
					return false;
				}();
			}
		});
	};
}
function getAllStudentBirthdayCtrl($scope, $http, $routeParams, $timeout) 
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
	$scope.getAllStudentsForSchool = function()
	{
		
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllStudentsForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.studentList = response.data.data;
				var formattedDate;
				for(var i = 0; i < $scope.studentList.length; i++)
				{
					formattedDate = $scope.convertDateFormatForDOB($scope.studentList[i].childdob);
					$scope.studentList[i]['formattedDOB'] = formattedDate;
				}
				var encrypted ;
				for(var i = 0; i < $scope.studentList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.studentList[i].id);
					$scope.studentList[i]['childID'] = encrypted;
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllStudentsForSchool();
	$scope.convertDateFormatForDOB = function(str) {
		var date = new Date(str);
		var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
		"Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
		];
		var mnth = monthNames[date.getMonth()];
		var day = ("0" + date.getDate()).slice(-2);
		return [(day + 'th'), mnth].join(" ");
	}
}
function allStudentCtrl($scope, $http, $routeParams, $timeout) 
{
	var sid;
	$scope.studentID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.studentID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.studentID;
	};	
	$timeout($scope.setID(), 2000);
	//alert($scope.studentID); return false;
	
	//return false;
	$scope.studentinfo = false;
	$scope.getStudentDetails = function()
	{
		var formData = {'id':$scope.studentID}
		$http.post(BASE_URL+'api/user/getSingleChildDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.childinfo = response.data.data;
				$scope.childRegisterId 	= $scope.childinfo.childRegisterId;
				$scope.child_login_id 	= $scope.childinfo.child_login_id;
				$scope.childfname 		= $scope.childinfo.childfname;
				$scope.childmname 		= $scope.childinfo.childmname;
				$scope.childlname 		= $scope.childinfo.childlname;
				$scope.childgender 		= $scope.childinfo.childgender;
				$scope.childclass 		= $scope.childinfo.childclass;
				$scope.fatheremail 		= $scope.childinfo.fatheremail;
				$scope.motheremail 		= $scope.childinfo.motheremail;
				$scope.class 			= $scope.childinfo.class;
				$scope.section 			= $scope.childinfo.section;
				$scope.childdob 		= new Date($scope.childinfo.childdob);
				$scope.childemail 		= $scope.childinfo.childemail;
				$scope.childbg 			= $scope.childinfo.childbg;
				$scope.childaddress 	= $scope.childinfo.childaddress;
				$scope.childphoto 		= $scope.childinfo.childphoto;
				$scope.childcertificate = $scope.childinfo.childcertificate;
				$scope.fatherfname 		= $scope.childinfo.fatherfname;
				$scope.fatherlname 		= $scope.childinfo.fatherlname;
				$scope.childdob			= $scope.convertDateFormatForDOB($scope.childdob);
				$scope.convertDateFormatForDOB = function(str) {
					var date = new Date(str);
					var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
					"Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
					];
					var mnth = monthNames[date.getMonth()];
					var day = ("0" + date.getDate()).slice(-2);
					return [(day + 'th'), mnth].join(" ");
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getStudentDetails();
	
	$scope.convertDateFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [day, mnth, date.getFullYear()].join("-");
	}
}
function getAllArticleCtrl($scope, $http, $routeParams, $timeout, $window,$location) 
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
	$scope.getAllArticleForSchool = function()
	{
		
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllArticleForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.articleList = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.articleList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.articleList[i].id);
					$scope.articleList[i]['articleID'] = encrypted;
					$scope.articleList[i]['description'] = $scope.articleList[i].description.substr(0,100);
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllArticleForSchool();
	
	$scope.articleDelete = function(articleID)
	{
		var retn=1
		var checlPrivilege=JSON.parse(jsonPrivilege);
		if(checlPrivilege.length==0){
			var cnt=checlPrivilege.length;
			}else{
			var cnt=jsonPrivilege.length;
		}
		if(cnt>0){
			if(checlPrivilege.Article['delete']==0){
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
			var formData = {'id':articleID};
			$http.post(BASE_URL+'api/user/deleteArticle',formData,{
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
							text: 'Article deleted successfully.'
						});
						
						$scope.getAllArticleForSchool();
						return false;
					}();
				}
				
				}, function errorCallback(response){
				
			});
		}
	}
	
}
function addArticleCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
	$scope.title 	  	= '';
	$scope.description 	= '';
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
	$scope.addArticle = function(){
		
		if($scope.title == '' || $scope.description == '')
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
		formData.append('schoolId', School_ID);
		
		var files = document.getElementById('pic').files[0];
		formData.append('pic',files);
		
		$http.post(BASE_URL+'api/user/addArticle',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Article added successfully.'
				});
				$window.location.href = '#!/article-list';
				return false;
			}();
			
			}, function errorCallback(response){
		});
	};
}
function editArticleCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
	var sid;
	$scope.articleID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.articleID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.articleID;
	};	
	$timeout($scope.setID(), 2000);
	//alert($scope.articleID);
	$scope.onChange = function (files) {
		if(files[0] == undefined) return;
		$scope.fileExt = files[0].name.split(".").pop();
	}
	$scope.isImage = function(ext) {
		if(ext) {
			return ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png";
		}
	}
	$scope.articleinfo = false;
	$scope.getArticleDetails = function()
	{
		var formData = {'id':$scope.articleID}
		$http.post(BASE_URL+'api/user/getArticleDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.article 		= response.data.data;
				$scope.title 		= $scope.article.title;
				$scope.description 	= $scope.article.description;
				$scope.photo 		= $scope.article.pic;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getArticleDetails();
	$scope.editArticle = function(){
		
		if($scope.title == '' || $scope.description == '')
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
		formData.append('id', $scope.articleID);
		formData.append('title', $scope.title);
		formData.append('description', $scope.description);
		formData.append('schoolId', School_ID);
		
		var files = document.getElementById('pic').files[0];
		formData.append('pic',files);
		
		$http.post(BASE_URL+'api/user/editArticle',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Article Updated successfully.'
				});
				$window.location.href = '#!/article-list';
				return false;
			}();
			
			}, function errorCallback(response){
		});
	};
}
function allArticleCtrl($scope, $http, $routeParams, $timeout, $compile, $window,$location) 
{
	var sid;
	$scope.articleID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.articleID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.articleID;
	};	
	$timeout($scope.setID(), 2000);
	
	$scope.articleinfo = false;
	$scope.articleCommentinfo = false;
	$scope.getArticleDetails = function()
	{
		var formData = {'id':$scope.articleID}
		$http.post(BASE_URL+'api/user/getArticleDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.articleinfo 	= response.data.data;
				$scope.articleCommentinfo = response.data.data1;
				$scope.title 		= $scope.articleinfo.title;
				$scope.description 	= $scope.articleinfo.description;
				$scope.photo 		= $scope.articleinfo.pic;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getArticleDetails();
	
	$scope.articleCommentDelete = function(articleCommentID)
	{
		var retn=1
		var checlPrivilege=JSON.parse(jsonPrivilege);
		if(checlPrivilege.length==0){
			var cnt=checlPrivilege.length;
			}else{
			var cnt=jsonPrivilege.length;
		}
		
		if(cnt>0){
			if(checlPrivilege.ArticleComment['delete']==0){
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
			var formData = {'id':articleCommentID};
			$http.post(BASE_URL+'api/user/deleteArticleComment',formData,{
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
							text: 'Article Comment deleted successfully.'
						});
						
						$window.location.reload();
						return false;
					}();
				}
				
				}, function errorCallback(response){
				
			});
		}
	}
}
function getAllAlbumCtrl($scope, $http, $routeParams, $timeout) 
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
	$scope.pageSize = 12;
	$scope.getAllAlbumForSchool = function()
	{
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllAlbumForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.albumList = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.albumList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.albumList[i].id);
					$scope.albumList[i]['albumID'] = encrypted;
					$scope.albumList[i]['description'] = $scope.albumList[i].description.substr(0,100);
					$scope.albumList[i]['attachments'] = $scope.albumList[i].attachment_id;
					var media = $scope.albumList[i]['attachments'];
					for(var v=0; v < media.length; v++)
					{
						var ext = media[v].split('.')[1];
						if(ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png")
						{
							$scope.albumList[i]['picUrl'] = media[v].split('.')[0]+'.'+media[v].split('.')[1];
							//$scope.picUrl = media[v].split('.')[0]+'.'+media[v].split('.')[1];
							/* if($scope.picUrl != '')
								{
								return false;
							} */
						}
					}
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllAlbumForSchool();
	
	$scope.albumDisabled = function(albumID, status)
	{
		var formData1 = {'id':albumID, 'status':status};
		$http.post(BASE_URL+'api/user/albumDisabled',formData1,{
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
							text: 'Album Status Disabled Now.'
						});
					}else if(status == 1)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'Album Status Enabled Now.'
						});
					}
					
					$scope.getAllAlbumForSchool();
					return false;
				}();
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	
}
function addAlbumCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
	$scope.title 	  		= '';
	$scope.description 		= '';
	$scope.pic 				= '';
	$scope.onChangeVideo	= '';
	$scope.previewData 		= [];
	$scope.previewImages	= [];
	$scope.previewVideoData	= [];
	$scope.previewVideos	= [];
	
	$scope.previewFile = function (file) {
		$scope.previewImages.push(file);
		var reader = new FileReader();
		var obj = new FormData().append('file',file);			
		reader.onload=function(data){
			var src = data.target.result;
			var size = ((file.size/(1024*1024)) > 1)? (file.size/(1024*1024)) + ' mB' : (file.size/		1024)+' kB';
			$scope.$apply(function(){
				$scope.previewData.push({'name':file.name,'size':size,'type':file.type,
				'src':src,'data':obj});
			});
		}
		reader.readAsDataURL(file);
	}
	$scope.onChange = function (files) {
		for(var i=0;i<files.length;i++){
			var file = files[i];
			if(file.type.indexOf("image") !== -1){
				$scope.previewFile(file);								
				} else {
				//console.log(file.name + " is not supported");
				return false;
			}
		}
	}
	$scope.isImage = function(ext) {
		if(ext) {
			return ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png";
		}
	}
	$scope.remove = function(data) {
		var index= $scope.previewData.indexOf(data);
		$scope.previewData.splice(index,1);
		$scope.previewImages.splice(index,1);
	}
	
	$scope.previewVideoFile = function (file) {
		$scope.previewVideos.push(file);
		var reader = new FileReader();
		var obj = new FormData().append('file',file);			
		reader.onload=function(data){
			var src = data.target.result;
			var size = ((file.size/(1024*1024)) > 1)? (file.size/(1024*1024)) + ' gB' : (file.size/		1024)+' mB';
			$scope.$apply(function(){
				$scope.previewVideoData.push({'name':file.name,'size':size,'type':file.type,
				'src':src,'data':obj});
			});
		}
		reader.readAsDataURL(file);
	}
	$scope.onChangeVideo = function (files) {
		for(var i=0;i<files.length;i++){
			var file = files[i];
			if(file.type.indexOf("video") !== -1){
				$scope.previewVideoFile(file);								
				} else {
				//console.log(file.name + " is not supported");
				return false;
			}
		}
	}
	$scope.removeVideo = function(data) {
		var index= $scope.previewVideoData.indexOf(data);
		$scope.previewVideoData.splice(index,1);
		$scope.previewVideos.splice(index,1);
	}
	
	$scope.addAlbum = function(files){
		if($scope.title == '')
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
		
		if($scope.previewImages.length == 0 && $scope.previewVideos.length == 0)
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please Upload Atleast 1 Photo Or 1 Video.'
				});
				return false;
			}();
			return false;
		}
		var formData = new FormData();
		formData.append('title', $scope.title);
		formData.append('description', $scope.description);
		formData.append('schoolId', School_ID);
		
		/* angular.forEach($scope.previewImages, function (value, key) {
			formData.append(key, value);
		}); */
		
		for (var i = 0; i < $scope.previewImages.length; i += 1) {
			var x=$scope.previewImages[i];
			formData.append("pic"+i, $scope.previewImages[i]);
		}
		
		for (var i = 0; i < $scope.previewVideos.length; i += 1) {
			var x=$scope.previewVideos[i];
			formData.append("video"+i, $scope.previewVideos[i]);
		}
		
		$http.post(BASE_URL+'api/user/addAlbum',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Album added successfully.'
				});
				$window.location.href = '#!/album-list';
				return false;
			}();
			
			}, function errorCallback(response){
		});
	};
}
function allAlbumCtrl($scope, $http, $routeParams, $timeout, $compile, $window,$location) 
{
	var sid;
	$scope.albumID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.albumID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.albumID;
	};	
	$timeout($scope.setID(), 2000);
	
	$scope.albuminfo = false;
	$scope.albumattachmentinfo = false;
	$scope.picUrl = new Array();
	$scope.videoUrl = new Array();
	$scope.getAlbumDetails = function()
	{
		var formData = {'id':$scope.albumID}
		$http.post(BASE_URL+'api/user/getAlbumDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.albuminfo 	= response.data.data;
				$scope.title = $scope.albuminfo.title;
				$scope.albumattachmentinfo 	= response.data.data1;
				var media = $scope.albumattachmentinfo;
				for(var i=0; i < media.length; i++)
				{
					var mediaName = media[i]['attachment'];
					var ext = mediaName.split('.')[1];
					if(ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png")
					{
						$scope.picUrl.push({ 'attachment': media[i]['attachment'],'comment_detail': media[i]['comment_detail'] });
						
					}else
					{
						$scope.videoUrl.push({ 'attachment': media[i]['attachment'],'comment_detail': media[i]['comment_detail'] });
					}
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAlbumDetails();
	
	$scope.albumCommentDelete = function(albumCommentID)
	{
		var retn=1
		var checlPrivilege=JSON.parse(jsonPrivilege);
		if(checlPrivilege.length==0){
			var cnt=checlPrivilege.length;
			}else{
			var cnt=jsonPrivilege.length;
		}
		
		if(cnt>0){
			if(checlPrivilege.AlbumComment['delete']==0){
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
			var formData = {'id':albumCommentID};
			$http.post(BASE_URL+'api/user/deleteAlbumComment',formData,{
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
							text: 'Album Comment deleted successfully.'
						});
						
						$window.location.reload();
						return false;
					}();
				}
				
				}, function errorCallback(response){
				
			});
		}
	}
}
function editAlbumCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
	var sid;
	$scope.albumID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.albumID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.albumID;
	};	
	$timeout($scope.setID(), 2000);
	
	$scope.albuminfo = false;
	$scope.albumattachmentinfo = false;
	$scope.picUrl = new Array();
	$scope.videoUrl = new Array();
	$scope.getAlbumDetails = function()
	{
		var formData = {'id':$scope.albumID}
		$http.post(BASE_URL+'api/user/getAlbumDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.albuminfo 	= response.data.data;
				$scope.title = $scope.albuminfo.title;
				$scope.description = $scope.albuminfo.description;
				$scope.albumattachmentinfo 	= response.data.data1;
				var media = $scope.albumattachmentinfo;
				for(var i=0; i < media.length; i++)
				{
					var mediaName = media[i]['attachment'];
					var ext = mediaName.split('.')[1];
					if(ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png")
					{
						$scope.picUrl.push(mediaName.split('.')[0]+'.'+mediaName.split('.')[1]);
						
					}else
					{
						$scope.videoUrl.push(mediaName.split('.')[0]+'.'+mediaName.split('.')[1]);
					}
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAlbumDetails(); 
	
	$scope.onChangeVideo	= '';
	$scope.previewData 		= [];
	$scope.previewImages	= [];
	$scope.previewVideoData	= [];
	$scope.previewVideos	= [];
	
	$scope.previewFile = function (file) {
		$scope.previewImages.push(file);
		var reader = new FileReader();
		var obj = new FormData().append('file',file);			
		reader.onload=function(data){
			var src = data.target.result;
			var size = ((file.size/(1024*1024)) > 1)? (file.size/(1024*1024)) + ' mB' : (file.size/		1024)+' kB';
			$scope.$apply(function(){
				$scope.previewData.push({'name':file.name,'size':size,'type':file.type,
				'src':src,'data':obj});
			});
		}
		reader.readAsDataURL(file);
	}
	$scope.onChange = function (files) {
		for(var i=0;i<files.length;i++){
			var file = files[i];
			if(file.type.indexOf("image") !== -1){
				$scope.previewFile(file);								
				} else {
				//console.log(file.name + " is not supported");
				return false;
			}
		}
	}
	$scope.isImage = function(ext) {
		if(ext) {
			return ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png";
		}
	}
	$scope.remove = function(data) {
		var index= $scope.previewData.indexOf(data);
		$scope.previewData.splice(index,1);
		$scope.previewImages.splice(index,1);
	}
	
	$scope.previewVideoFile = function (file) {
		$scope.previewVideos.push(file);
		var reader = new FileReader();
		var obj = new FormData().append('file',file);			
		reader.onload=function(data){
			var src = data.target.result;
			var size = ((file.size/(1024*1024)) > 1)? (file.size/(1024*1024)) + ' gB' : (file.size/		1024)+' mB';
			$scope.$apply(function(){
				$scope.previewVideoData.push({'name':file.name,'size':size,'type':file.type,
				'src':src,'data':obj});
			});
		}
		reader.readAsDataURL(file);
	}
	$scope.onChangeVideo = function (files) {
		for(var i=0;i<files.length;i++){
			var file = files[i];
			if(file.type.indexOf("video") !== -1){
				$scope.previewVideoFile(file);								
				} else {
				//console.log(file.name + " is not supported");
				return false;
			}
		}
	}
	$scope.removeVideo = function(data) {
		var index= $scope.previewVideoData.indexOf(data);
		$scope.previewVideoData.splice(index,1);
		$scope.previewVideos.splice(index,1);
	}
	
	$scope.deleteMedia = function(media)
	{
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		var formData = new FormData();
		formData.append('attachment', media);
		if(deleteMedia == true)
		{
			$http.post(BASE_URL+'api/user/deleteAttachment',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey
				}
				}).then(function(response) {
				var result  = response.data;
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: 'Attchment Deleted Now.'
					});
					$window.location.reload();
					return false;
				}();
				
				}, function errorCallback(response){
			});
		}
	}
	
	$scope.editAlbum = function(){
		
		if($scope.title == '')
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
		if($scope.previewImages.length == 0 && $scope.previewVideos.length == 0 && $scope.videoUrl.length == 0 && $scope.picUrl.length == 0)
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please Upload Atleast 1 Photo Or 1 Video.'
				});
				return false;
			}();
			return false;
		}
		
		var formData = new FormData();
		formData.append('id', $scope.albumID);
		formData.append('title', $scope.title);
		formData.append('description', $scope.description);
		formData.append('schoolId', School_ID);
		
		/* angular.forEach($scope.previewImages, function (value, key) {
			formData.append(key, value);
		}); */
		
		for (var i = 0; i < $scope.previewImages.length; i += 1) {
			var x=$scope.previewImages[i];
			formData.append("pic"+i, $scope.previewImages[i]);
		}
		
		for (var i = 0; i < $scope.previewVideos.length; i += 1) {
			var x=$scope.previewVideos[i];
			formData.append("video"+i, $scope.previewVideos[i]);
		}
		
		$http.post(BASE_URL+'api/user/editAlbum',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Album Updated successfully.'
				});
				$window.location.href = '#!/album-list';
				return false;
			}();
			
			}, function errorCallback(response){
		});
	};
}
function getAllTimelineCtrl($scope, $http, $routeParams, $timeout, $window) 
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
	$scope.getAllTimelineForSchool = function()
	{
		
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllTimelineForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.timelineList = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.timelineList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.timelineList[i].id);
					$scope.timelineList[i]['timelineID'] = encrypted;
				}
				// console.log($scope.timelineList);
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	
	$scope.getAllTimelineForSchool();
	
	$scope.timelineDisabled = function(timelineID, status)
	{
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData1 = {'id':timelineID, 'status':status};
			$http.post(BASE_URL+'api/user/timelineDisabled',formData1,{
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
								text: 'Timeline has been deleted Now.'
							});
						$scope.getAllTimelineForSchool();
						return false;
					}();
				}
				
				}, function errorCallback(response){
				
			});
		}
		
	}
}
function addTimelineCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
	$scope.description 		= '';
	$scope.pic 				= '';
	$scope.previewData 		= [];
	$scope.previewImages	= [];
	
	$scope.previewFile = function (file) {
		$scope.previewImages.push(file);
		var reader = new FileReader();
		var obj = new FormData().append('file',file);			
		reader.onload=function(data){
			var src = data.target.result;
			var size = ((file.size/(1024*1024)) > 1)? (file.size/(1024*1024)) + ' mB' : (file.size/		1024)+' kB';
			$scope.$apply(function(){
				$scope.previewData.push({'name':file.name,'size':size,'type':file.type,
				'src':src,'data':obj});
			});
		}
		reader.readAsDataURL(file);
	}
	$scope.onChange = function (files) {
		for(var i=0;i<files.length;i++){
			var file = files[i];
			if(file.type.indexOf("image") !== -1){
				$scope.previewFile(file);								
				} else {
				//console.log(file.name + " is not supported");
				return false;
			}
		}
	}
	$scope.isImage = function(ext) {
		if(ext) {
			return ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png";
		}
	}
	$scope.remove = function(data) {
		var index= $scope.previewData.indexOf(data);
		$scope.previewData.splice(index,1);
		$scope.previewImages.splice(index,1);
	}
	$scope.addTimeline = function(files){
		if($scope.description == '' && $scope.previewData.length == 0)
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill Description Field(Indicating With * Sign).'
				});
				return false;
			}();
			return false;
		}
		
		/* if($scope.previewImages.length == 0)
			{
			var Gritter = function () {
			$.gritter.add({
			title: 'Validation Error!',
			text: 'Please Upload Atleast 1 Photo.'
			});
			return false;
			}();
			return false;
		} */
		var formData = new FormData();
		formData.append('description', $scope.description);
		formData.append('schoolId', School_ID);
		
		for (var i = 0; i < $scope.previewImages.length; i += 1) {
			var x=$scope.previewImages[i];
			formData.append("pic"+i, $scope.previewImages[i]);
		}
		
		$http.post(BASE_URL+'api/user/addTimeline',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Timeline added successfully.'
				});
				$window.location.href = '#!/timeline-list';
				return false;
			}();
			
			}, function errorCallback(response){
		});
	};
}
function editTimelineCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
	var sid;
	$scope.timelineID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.timelineID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.timelineID;
	};	
	$timeout($scope.setID(), 2000);
	
	$scope.timelineinfo = false;
	$scope.timelineattachmentinfo = false;
	$scope.picUrl = new Array();
	$scope.getTimelineDetails = function()
	{
		var formData = {'id':$scope.timelineID}
		$http.post(BASE_URL+'api/user/getTimelineDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.timelineinfo 	= response.data.data;
				$scope.description = $scope.timelineinfo.description;
				$scope.timelineattachmentinfo 	= response.data.data1;
				var media = $scope.timelineattachmentinfo;
				for(var i=0; i < media.length; i++)
				{
					var mediaName = media[i]['attachment'];
					var ext = mediaName.split('.')[1];
					$scope.picUrl.push(mediaName.split('.')[0]+'.'+mediaName.split('.')[1]);
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getTimelineDetails(); 
	
	$scope.timelineCommentDelete = function(timelineCommentID)
	{
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':timelineCommentID};
			$http.post(BASE_URL+'api/user/deleteTimelineComment',formData,{
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
							text: 'Timeline Comment deleted successfully.'
						});
						
						$window.location.reload();
						return false;
					}();
				}
				
				}, function errorCallback(response){
				
			});
		}
	}
	
	$scope.onChangeVideo	= '';
	$scope.previewData 		= [];
	$scope.previewImages	= [];
	
	$scope.previewFile = function (file) {
		$scope.previewImages.push(file);
		var reader = new FileReader();
		var obj = new FormData().append('file',file);			
		reader.onload=function(data){
			var src = data.target.result;
			var size = ((file.size/(1024*1024)) > 1)? (file.size/(1024*1024)) + ' mB' : (file.size/		1024)+' kB';
			$scope.$apply(function(){
				$scope.previewData.push({'name':file.name,'size':size,'type':file.type,
				'src':src,'data':obj});
			});
		}
		reader.readAsDataURL(file);
	}
	$scope.onChange = function (files) {
		for(var i=0;i<files.length;i++){
			var file = files[i];
			if(file.type.indexOf("image") !== -1){
				$scope.previewFile(file);								
				} else {
				//console.log(file.name + " is not supported");
				return false;
			}
		}
	}
	$scope.isImage = function(ext) {
		if(ext) {
			return ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png";
		}
	}
	$scope.remove = function(data) {
		var index= $scope.previewData.indexOf(data);
		$scope.previewData.splice(index,1);
		$scope.previewImages.splice(index,1);
	}
	
	$scope.deleteMedia = function(media)
	{
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete? All Preview attachments will be lost.');
		var formData = new FormData();
		formData.append('attachment', media);
		if(deleteMedia == true)
		{
			$http.post(BASE_URL+'api/user/deleteTimelineAttachment',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey
				}
				}).then(function(response) {
				var result  = response.data;
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: 'Attchment Deleted Now.'
					});
					$window.location.reload();
					return false;
				}();
				
				}, function errorCallback(response){
			});
		}
	}
	
	$scope.editTimeline = function(){
		
	if($scope.description == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill Description field(Indicating With * Sign).'
				});
				return false;
			}();
			return false;
		}
		
		// if($scope.previewData.length == 0  && $scope.picUrl.length == 0)
		// {
		// 	var Gritter = function () {
		// 		$.gritter.add({
		// 			title: 'Validation Error!',
		// 			text: 'Please fill Description field(Indicating With * Sign).'
		// 		});
		// 		return false;
		// 	}();
		// 	return false;
		// }
		
		var formData = new FormData();
		formData.append('id', $scope.timelineID);
		formData.append('description', $scope.description);
		formData.append('schoolId', School_ID);
		
		for (var i = 0; i < $scope.previewImages.length; i += 1) {
			var x=$scope.previewImages[i];
			formData.append("pic"+i, $scope.previewImages[i]);
		}
		
		$http.post(BASE_URL+'api/user/editTimeline',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Timeline Updated successfully.'
				});
				$window.location.href = '#!/timeline-list';
				return false;
			}();
			
			}, function errorCallback(response){
		});
	};
}

function getAllHolidayCtrl($scope, $http, $routeParams, $timeout, $window,holidaycalendarData,$location) 
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
	$scope.holiydate='';
	$scope.getAllHolidayForSchool = function()
	{
		$scope.holidayList = false;
		var formData = {'id':School_ID,'holiday_date':$scope.holiydate};
		$http.post(BASE_URL+'api/user/getAllHolidayForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.holidayList = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.holidayList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.holidayList[i].id);
					$scope.holidayList[i]['holidayID'] = encrypted;
				}
			}
			
			}, function errorCallback(response){
			$scope.holidayList=[];
		});
		
	}
	$scope.getAllHolidayForSchool();
	$scope.sort = function(keyname){
		$scope.sortKey = keyname;
		$scope.reverse = !$scope.reverse;
	}
	$scope.holidayDelete = function(eventID)
	{
		var retn=1
		var checlPrivilege=JSON.parse(jsonPrivilege);
		if(checlPrivilege.length==0){
			var cnt=checlPrivilege.length;
			}else{
			var cnt=jsonPrivilege.length;
		}
		
		
		if(cnt>0){
			if(checlPrivilege.HolidayList['delete']==0){
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
			$http.post(BASE_URL+'api/user/deleteHoliday',formData,{
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
							text: 'Holiday deleted successfully.'
						});
						location.reload();
						return false;
					}();
				}
				
				}, function errorCallback(response){
				
			});
		}
	}
	$scope.convertDateNewFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [date.getFullYear(), mnth, day].join("-");
	}
	$scope.eventSources=[holidaycalendarData];
	/* config object */
	$scope.uiConfig = {
		calendar:{
			height: 450,
			editable: true,
			selectable: true,
			header:{
				left: 'title',
				center: '',
				right: 'today prev,next'
			},
			eventClick: function (calEvent, jsEvent, view) {
				//alert('ffsd');
			},
			dayClick: function (calEvent, jsEvent, view) {
				$scope.holiydate=$scope.convertDateNewFormat(calEvent);
				$(".fc-day").css('background-color', '');
				$(this).css('background-color', '#00bed5');
				$scope.getAllHolidayForSchool();
			},
			
		}
	}
	
}
function addHolidayCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.getAllSessionForSchool = function()
	{
		$scope.sessionList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllSessionForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.sessionList = response.data.data;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.convertDateNewFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [date.getFullYear(), mnth, day].join("-");
	}
	$scope.getAllSessionForSchool();
	$scope.academicsession 	= '';
	$scope.holiday_title 		= '';
	$scope.holiday_date 			= '';
	$scope.addHoliday = function(){
		
		if($scope.academicsession == '' || $scope.holiday_title == '' || $scope.holiday_date == '')
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
		formData.append('academicsession', $scope.academicsession);
		formData.append('holiday_title', $scope.holiday_title);
		formData.append('holiday_date', $scope.convertDateNewFormat($scope.holiday_date));
		formData.append('schoolId', School_ID);
		
		$http.post(BASE_URL+'api/user/addHoliday',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Holiday added successfully.'
				});
				$window.location.href = '#!/holiday-list';
				return false;
			}();
			
			}, function errorCallback(response){
			//alert(response);
			var errresult = response.data.message
			if(errresult == 'Holiday Already Exists.')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Error',
						text: 'This Holiday Already Exists.'
					});
					$scope.getHolidayDetails();
					return false;
				}();
			}
		});
	};
	
}


function editHolidayCtrl($scope, $http, $routeParams, $timeout,$window) 
{
	
	$scope.getAllSessionForSchool = function()
	{
		$scope.sessionList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllSessionForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.sessionList = response.data.data;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllSessionForSchool();
	$scope.sort = function(keyname){
		$scope.sortKey = keyname;
		$scope.reverse = !$scope.reverse;
	}
	
	var sid;
	$scope.holidayID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.holidayID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.holidayID;
	};	
	$timeout($scope.setID(), 2000);
	//alert($scope.classID); return false;
	$scope.holidayinfo = false;
	$scope.academicsession 	= '';
	$scope.holidaytitle 		= '';
	$scope.holiday_date 			= '';
	$scope.getHolidayDetails = function()
	{
		var formData = {'id':$scope.holidayID}
		$http.post(BASE_URL+'api/user/getHolidayDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.holidayinfo = response.data.data;
				$scope.academicsession  = $scope.holidayinfo.session;
				$scope.holidaytitle  = $scope.holidayinfo.title;
				$scope.holiday_date  = new Date($scope.holidayinfo.for_date);
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getHolidayDetails();
	
	$scope.editHoliday = function(){
		$scope.convertDateNewFormat = function(str) {
			var date = new Date(str),
			mnth = ("0" + (date.getMonth() + 1)).slice(-2),
			day = ("0" + date.getDate()).slice(-2);
			return [date.getFullYear(), mnth, day].join("-");
		}
		//alert($scope.holiday_title);
		if($scope.academicsession == '' || $scope.holidaytitle == '' || $scope.holiday_date == '')
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
		//alert($scope.holidaytitle);
		var formData = new FormData();
		
		formData.append('id', $scope.holidayID);
		formData.append('academicsession', $scope.academicsession);
		formData.append('holidaytitle', $scope.holidaytitle);
		formData.append('holiday_date', $scope.convertDateNewFormat($scope.holiday_date));
		formData.append('schoolId', School_ID);
		
		$http.post(BASE_URL+'api/user/editHoliday',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Holiday Updated successfully.'
				});
				$window.location.href = '#!/holiday-list';
				return false;
			}();
			
			}, function errorCallback(response){
			
			var errresult = response.data.message
			if(errresult == 'Holiday Already Exists.')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: 'This Holiday Already Exists.'
					});
					$scope.getHolidayDetails();
					return false;
				}();
			}
		});
	};
	
}
function getAllDiscussionCatCtrl($scope, $http, $routeParams, $timeout,$location) 
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
	
	$scope.getAllDiscussionCatForSchool = function()
	{
		$scope.discussionCatList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllDiscussionCatForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.discussionCatList = response.data.data;
				
				var encrypted ;
				for(var i = 0; i < $scope.discussionCatList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.discussionCatList[i].id);
					$scope.discussionCatList[i]['discussionCatID'] = encrypted;
				}
				if(  ($scope.discussionCatList.length) < 10 ){
					$scope.pageSize = $scope.discussionCatList.length;
					$scope.currentPage=1;
					$scope.itemsPerPage=1;
				}else
				{
					$scope.pageSize = 10;
					$scope.currentPage=1;
					$scope.itemsPerPage=1;
				}
				// console.log($scope.discussionCatList);
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAllDiscussionCatForSchool();
	$scope.sort = function(keyname){
		$scope.sortKey = keyname;
		$scope.reverse = !$scope.reverse;
	}
	
	$scope.discussionCatDisabled = function(discussionCatID, status)
	{
		var formData1 = {'id':discussionCatID, 'status':status};
		$http.post(BASE_URL+'api/user/discussionCatDisabled',formData1,{
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
							text: 'Discussion Category Status Disabled Now.'
						});
					}else if(status == 1)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'Discussion Category Status Enabled Now.'
						});
					}
					
					$scope.getAllDiscussionCatForSchool();
					return false;
				}();
			}
			
			}, function errorCallback(response){
			
		});
		
	}
}
function addDiscussionCatCtrl($scope, $http, $routeParams, $timeout,$window) 
{
	$scope.name 	= '';
	$scope.addDiscussionCat = function(){
		if($scope.name == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill title fields(Indicating With * Sign).'
				});
				return false;
			}();
			return false;
		}
		
		var formData = new FormData();
		formData.append('name', $scope.name);
		formData.append('schoolId', School_ID);
		
		$http.post(BASE_URL+'api/user/addDiscussionCat',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Discussion Category added successfully.'
				});
				$window.location.href = '#!/discussioncat-list';
				return false;
			}();
			
			}, function errorCallback(response){
		});
	};
}
function editDiscussionCatCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	var sid;
	$scope.discussionCatID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.discussionCatID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.discussionCatID;
	};	
	$timeout($scope.setID(), 2000);
	//alert($scope.discussionCatID); return false;
	$scope.discussionCatinfo = false;
	$scope.getDiscussionCatDetails = function()
	{
		var formData = {'id':$scope.discussionCatID}
		$http.post(BASE_URL+'api/user/getDiscussionCatDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.discussionCatinfo = response.data.data;
				$scope.name  = $scope.discussionCatinfo.name;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getDiscussionCatDetails();
	
	$scope.editDiscussionCat = function(){
		
		if($scope.name == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
