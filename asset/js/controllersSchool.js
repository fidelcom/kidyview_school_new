'use strict';
//Controllers
function feeSuscriptionCtrl($scope, $http, $routeParams, $timeout, $window) 
{
		// Get Class List
	$scope.getAllClassForSchool = function()
	{
		$scope.classList = [];
		$scope.ob={'class':''};
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllClassForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.classList = response.data.data;
				// $scope.ob.class = $scope.classList[0].id;
			}
			 console.log($scope.classList);		
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
	$scope.getAllClassForSchool();

	// Get School Type 
	$scope.schoolTypeList = [];
	$scope.getSchoolType = function(){ 
			$http.get(BASE_URL+'api/timeTable/schoolType',{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
	        {
	            $scope.schoolTypeList  = response.data;
	        // console.log($scope.schoolTypeList);
	        });
		};
	$scope.getSchoolType();

	// Add Subscription
	$scope.subscription = {'school_id':School_ID,'currency':'NGN','amount':'','class_id':'','school_type':''}
	$scope.addFeeSubscription = function(subscription){

		// console.log(subscription);
		// return false
		if( (subscription.amount == '') ||  (subscription.class_id == '') ||  (subscription.school_type == '') )
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: `All field is mendatory.`
				});
			    // setTimeout(function() { location.reload();  }, 3000);
				return false;
			}();

		}else{

		$http.post(BASE_URL+'api/school/SubscriptionAmount/addFeesSubscription',subscription,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
				var result  = response.data;
				var Gritter = function () {
					$.gritter.add({
						title: result.success,
						text: result.message
					});
					$window.location.href = '#!/fee-suscription-list';
					 return false;
				}();
				
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
	}
}

function feeSuscriptionListCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.feeSuscriptionList = function()
	{
		$scope.feeSuscriptionList = [];
	
		var formData = {'school_id':School_ID};
		$http.post(BASE_URL+'api/school/SubscriptionAmount/feeSuscriptionList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.feeSuscriptionList = response.data.data;
			}
			// console.log($scope.feeSuscriptionList);
			}, function errorCallback(response){
		});
	}
	$scope.feeSuscriptionList();

	// Delete record
	$scope.subscriptionAmountDelete = function(id)
	{
		// Delete a Schedule
   
		var deleteMedia = window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':id};
			$http.post(BASE_URL+'api/school/SubscriptionAmount/subscriptionAmountDelete',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
					console.log(response.status);
				$scope.response = response.data.data;
				if($scope.response == 1 )
				{
						var Gritter = function () {
						$.gritter.add({
							title: 'Success',
							text: 'Subscription amount has been deleted successfully.'
						});
						$scope.feeSuscriptionList();
						$window.location.href = '#!/fee-suscription-list';
						}();
				}
				}, function errorCallback(error){
					if(error.status==401){	
						localStorage.setItem('TOKEN', '');
						$window.location = BASE_URL+'schoollogin/login';
						}
				});
		}
	
	}

}
function studentAttendanceCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.getAllClassForSchool = function()
	{
		$scope.classList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllClassForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.classList = response.data.data;
			}
			// console.log($scope.classList);
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
	$scope.getAllClassForSchool();

	// Month name with their year
	$scope.monthName=[{"val":"01","name":"January"},{"val":"02","name":"February"},{"val":"03","name":"March"},{"val":"04","name":"April"},{"val":"05","name":"May"},{"val":"06","name":"June"},{"val":"07","name":"July"},{"val":"08","name":"August"},{"val":"09","name":"September"},{"val":"10","name":"October"},{"val":"11","name":"November"},{"val":"12","name":"December"}];
	// console.log($scope.monthName);
	
	// Get All students attendance wise
	$scope.getAllStudentsAttendance = function()
	{
		$scope.attendanceList 	      = [];
		var formData = {'id':School_ID,class_id:$scope.class_id,month:$scope.month,year:$scope.year};
		$http.post(BASE_URL+'api/school/attendance/getAllStudentsAttendance',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.attendanceList = response.data.data.students;	
				$scope.dates      	  = response.data.data.monthData.selected_monthDays;
				$scope.colspan  	  = $scope.dates.length +2;
			}
			// console.log($scope.attendanceList);
			// return false
			}, function errorCallback(error){
			console.log(error)
				$scope.dates    	  = error.data.data.selected_monthDates;	
				$scope.colspan  	  = $scope.dates.length +2;
			if( error.status == 400)
			{
				var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: 'No student attendance available in this month.'
				});
				return false;
				}();
			}
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
	$scope.getAllStudentsAttendance();

	
	$scope.addStudentAttendance = function(){	
		var formData = new FormData();
		formData.append('name', $scope.name);
		
		$http.post(BASE_URL+'schooluser/addStudentAttendance',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	};
}
function addStudentAttendanceCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	 $scope.model = {};
	
     // This property will be bound to checkbox in table header
     $scope.model.allCheckedInItemsSelected = false;
     $scope.model.allCheckedOutItemsSelected = false;

	// Multiple Select
	   $scope.studentsSelected = []; 
	   $scope.students = []; 
	   $scope.selectedToTopSettings = { selectedToTop: true, displayProp: "child",enableSearch: false,
      scrollable: false };

	  $scope.setting1 = {
		  selectedToTop: true,
	      scrollableHeight: '200px',
	      scrollable: true,
		  enableSearch: true,
		  displayProp: 'name'
	  };

	$scope.getAllClassForSchool = function()
	{
		$scope.classList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllClassForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.classList = response.data.data;
			}
			// console.log($scope.classList);
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
	$scope.getAllClassForSchool();

	$scope.classStudents=[];
	$scope.multiStudents ={studentID:""};
	$scope.getClassStudents=function(){
		var formData={'class_id':$scope.class_id}

		$http.post(BASE_URL+'api/school/attendance/getClassStudents',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.model.classStudents = response.data.data;
              	  $scope.attendance_date = '';
			}
			}, function errorCallback(response){
				$scope.classStudents=[];
		});
	}


	 // This executes when entity in table is checked
	        $scope.selectPartialCheckedinAttendance = function () {
	            // If any entity is not checked, then uncheck the "allCheckedInItemsSelected" checkbox
	            for (var i = 0; i < $scope.model.classStudents.length; i++) {
	                if (!$scope.model.classStudents[i].checkin_status) {
	                    $scope.model.allCheckedInItemsSelected = false;
	                    return;
	                }
	            }
	
	            //If not the check the "allCheckedInItemsSelected" checkbox
	            $scope.model.allCheckedInItemsSelected = true;
	        };
	    // This executes when checkbox in table header is checked
	        $scope.selectAllCheckedIn = function () {
	            // Loop through all the classStudents and set their checkin_status property
	            for (var i = 0; i < $scope.model.classStudents.length; i++) {
	                $scope.model.classStudents[i].checkin_status = $scope.model.allCheckedInItemsSelected;
	            }
							// console.log($scope.model.allCheckedInItemsSelected);
	        }; 

	         // This executes when checkbox in table header is checked
	        $scope.selectAllCheckedOut = function () {
	            // Loop through all the teachersList and set their checkin_status property
	            for (var i = 0; i < $scope.model.classStudents.length; i++) {
	                $scope.model.classStudents[i].checkout_status = $scope.model.allCheckedOutItemsSelected;
	            }
							// console.log($scope.model.allCheckedOutItemsSelected);
	        };
	          // This executes when checkbox in table header is checked
	        $scope.selectAllCheckedOut = function () {
	            // Loop through all the classStudents and set their checkin_status property
	            for (var i = 0; i < $scope.model.classStudents.length; i++) {
	                $scope.model.classStudents[i].checkout_status = $scope.model.allCheckedOutItemsSelected;
	            }
							// console.log($scope.model.allCheckedOutItemsSelected);
	        }; 

	         // This executes when entity in table is checked
	        $scope.selectPartialCheckoutAttendance = function () {
	            // If any entity is not checked, then uncheck the "allCheckedOutItemsSelected" checkbox
	            for (var i = 0; i < $scope.model.classStudents.length; i++) {
	                if (!$scope.model.classStudents[i].checkout_status) {
	                    $scope.model.allCheckedOutItemsSelected = false;
	                    return;
	                }
	            }
	
	            //If not the check the "allCheckedOutItemsSelected" checkbox
	            $scope.model.allCheckedOutItemsSelected = true;
	        };

	$scope.convertDateFormat = function(str) {
			var date = new Date(str),
			mnth = ("0" + (date.getMonth() + 1)).slice(-2),
			day = ("0" + date.getDate()).slice(-2);
			return [day, mnth, date.getFullYear()].join("-");
	}
	$scope.class_id 	  		= '';
	$scope.attendance_date 	  	= '';
	$scope.studentAttendanceData = function(){
	 	
	 	if($scope.attendance_date == '' || $scope.attendance_date == 'undefined' || $scope.class_id == '' || $scope.model.classStudents.length <= '0')
	 	{
	 			var Gritter = function () {
						$.gritter.add({
							title: 'Failed',
							text: 'Attendance date is mandatory field.'
						});
						return false;
						}();
	 	}else{
	 			$scope.attendance_date = $scope.convertDateFormat( $scope.attendance_date);

	 	 		var formData = {'school_id':School_ID,'class_id':$scope.class_id,'attendance_date':$scope.attendance_date,'studentAttendance':$scope.model.classStudents};
			// console.log(formData);
			// return false
				$http.post(BASE_URL+'api/school/attendance/studentManualAttendanceBySchool',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
				
					if(response.status == 200)
					{
						var Gritter = function () {
						$.gritter.add({
							title: 'success',
							text: 'Student attendance has been punched successfully.'
						});
						$window.location.href = '#!add-student-attendance';
						// $scope.getAllStudentsAttendance();
						return false;
						}();

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
					var Gritter = function () {
						$.gritter.add({
							title: 'Failed',
							text: 'Attendance already punched on the same date.'
						});
						return false;
						}();
				});
	 	}
	}

}
function teacherAttendanceCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.checkOnlyAttendance = function(date,teacher_id,attendance_date){
		console.log(date+ "::" + teacher_id+ "::"+ attendance_date);
		if(date == attendance_date)
		{
			return true;
		}else{
			return false;
		}
	}
	// Month name with their year
	$scope.monthName=[{"val":"01","name":"January"},{"val":"02","name":"February"},{"val":"03","name":"March"},{"val":"04","name":"April"},{"val":"05","name":"May"},{"val":"06","name":"June"},{"val":"07","name":"July"},{"val":"08","name":"August"},{"val":"09","name":"September"},{"val":"10","name":"October"},{"val":"11","name":"November"},{"val":"12","name":"December"}];
	// console.log($scope.monthName);
	// Get All students attendance wise
	$scope.getAllTeachersAttendance = function()
	{
		$scope.teacherAttendance 	    = [];
		
		var formData = {'id':School_ID,month:$scope.month,year:$scope.year};
		$http.post(BASE_URL+'api/school/attendance/getAllTeachersAttendance',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.teacherAttendance = response.data.data.teachers;	
				$scope.dates      	     = response.data.data.monthData.selected_monthDays;
				$scope.colspan  	     = $scope.dates.length +2;
			}
			console.log($scope.teacherAttendance);
			// console.log('test');
			// console.log($scope.colspan);
			// return false
			}, function errorCallback(error){
			
			if(error.status == 400)
			{
				$scope.dates    	  = error.data.data.selected_monthDates;	
				$scope.colspan  	  = $scope.dates.length +2;

				var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: 'No teacher attendance available in this month.'
				});
				return false;
				}();
			}
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
	 $scope.getAllTeachersAttendance();
}
function addTeacherAttendanceCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	 $scope.model = {};
	
     // This property will be bound to checkbox in table header
     $scope.model.allCheckedInItemsSelected = false;
     $scope.model.allCheckedOutItemsSelected = false;
	// To get the school type
	$scope.schoolTypeList = [];
	$scope.getSchoolType = function(){ 
			$http.get(BASE_URL+'api/timeTable/schoolType',{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
	        {
	            $scope.schoolTypeList  = response.data;
	        // console.log($scope.schoolTypeList);
	        });
		};
	$scope.getSchoolType();

	// Get Teacher on basis of school type
	$scope.teacherAttendanceArr = [];
	$scope.getTeachersBySchoolType  = function(){
	
		$scope.teachersList = [];
		var formData = {'school_id':School_ID,'schoolType':$scope.schoolType};
		$http.post(BASE_URL+'api/teachers/attendance/getTeachersBySchoolType',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.model.teachersList = response.data.data;
              	  $scope.attendance_date = '';
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
	  // This executes when entity in table is checked
	        $scope.selectPartialCheckedinAttendance = function () {
	            // If any entity is not checked, then uncheck the "allCheckedInItemsSelected" checkbox
	            for (var i = 0; i < $scope.model.teachersList.length; i++) {
	                if (!$scope.model.teachersList[i].checkin_status) {
	                    $scope.model.allCheckedInItemsSelected = false;
	                    return;
	                }
	            }
	
	            //If not the check the "allCheckedInItemsSelected" checkbox
	            $scope.model.allCheckedInItemsSelected = true;
	        };
	    // This executes when checkbox in table header is checked
	        $scope.selectAllCheckedIn = function () {
	            // Loop through all the teachersList and set their checkin_status property
	            for (var i = 0; i < $scope.model.teachersList.length; i++) {
	                $scope.model.teachersList[i].checkin_status = $scope.model.allCheckedInItemsSelected;
	            }
							// console.log($scope.model.allCheckedInItemsSelected);
	        }; 
	     // This executes when checkbox in table header is checked
	        $scope.selectAllCheckedOut = function () {
	            // Loop through all the teachersList and set their checkin_status property
	            for (var i = 0; i < $scope.model.teachersList.length; i++) {
	                $scope.model.teachersList[i].checkout_status = $scope.model.allCheckedOutItemsSelected;
	            }
							// console.log($scope.model.allCheckedOutItemsSelected);
	        };
	          // This executes when checkbox in table header is checked
	        $scope.selectAllCheckedOut = function () {
	            // Loop through all the teachersList and set their checkin_status property
	            for (var i = 0; i < $scope.model.teachersList.length; i++) {
	                $scope.model.teachersList[i].checkout_status = $scope.model.allCheckedOutItemsSelected;
	            }
							// console.log($scope.model.allCheckedOutItemsSelected);
	        }; 

	         // This executes when entity in table is checked
	        $scope.selectPartialCheckoutAttendance = function () {
	            // If any entity is not checked, then uncheck the "allCheckedOutItemsSelected" checkbox
	            for (var i = 0; i < $scope.model.teachersList.length; i++) {
	                if (!$scope.model.teachersList[i].checkout_status) {
	                    $scope.model.allCheckedOutItemsSelected = false;
	                    return;
	                }
	            }
	
	            //If not the check the "allCheckedOutItemsSelected" checkbox
	            $scope.model.allCheckedOutItemsSelected = true;
	        };

	
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
	$scope.convertDateFormat = function(str) {
			var date = new Date(str),
			mnth = ("0" + (date.getMonth() + 1)).slice(-2),
			day = ("0" + date.getDate()).slice(-2);
			return [day, mnth, date.getFullYear()].join("-");
	}
    $scope.teacherAttendanceData = function(){
	 	
	 	if($scope.attendance_date == '' || $scope.attendance_date == 'undefined')
	 	{
	 			var Gritter = function () {
						$.gritter.add({
							title: 'Failed',
							text: 'Attendance date is mandatory field.'
						});
						return false;
						}();
	 	}else{
	 			$scope.attendance_date = $scope.convertDateFormat( $scope.attendance_date);

	 	 		for(var i =0; i < $scope.model.teachersList.length; i++)
           	    {
           	    	if(  ($scope.model.teachersList[i]['checkin_time'] == '') || ($scope.model.teachersList[i]['checkin_time'] == 'undefined') ||  ($scope.model.teachersList[i]['checkin_time'] == 'NaN:NaN AM')   )
           	    	{
              	  		$scope.model.teachersList[i]['checkin_time'] = '';

           	    	}else if(   ($scope.model.teachersList[i]['checkout_time'] == '') || ( $scope.model.teachersList[i]['checkout_time'] == 'undefined') || ($scope.model.teachersList[i]['checkout_time'] == 'NaN:NaN AM') )
           	    	{
              	  		$scope.model.teachersList[i]['checkout_time'] = '';
           	    	
           	    	}else{
    					$scope.model.teachersList[i]['checkin_time'] = $scope.timeFormat( $scope.model.teachersList[i]['checkin_time']);
              	  		$scope.model.teachersList[i]['checkout_time'] = $scope.timeFormat($scope.model.teachersList[i]['checkout_time']);
           	    	}
    			}

	    		var formData = {'school_id':School_ID,'attendance_date':$scope.attendance_date,'teacherAttendance':$scope.model.teachersList};
				$http.post(BASE_URL+'api/teachers/attendance/teacherAttendanceBySchool',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
				
					if(response.status == 200)
					{
						var Gritter = function () {
						$.gritter.add({
							title: 'success',
							text: 'Teacher attendance has been punched successfully.'
						});
							$window.location.href = '#!add-teacher-attendance';
						}();
					}
				}, function errorCallback(error){
					var Gritter = function () {
						$.gritter.add({
							title: 'Failed',
							text: 'Attendance already punched on the same date.'
						});
						return false;
						}();
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
	 
    }
}
function subadminAttendanceCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	
}
function addSubadminAttendanceCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	
}
function requestDayOffCtrl($scope, $http, $routeParams, $timeout, $window) 
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
	// Get All students and Teacher dayoff data	
	$scope.dayOff = [];
	$scope.getDayoff = function()
	{
		var formData = {'school_id':School_ID}
		$http.post(BASE_URL+'api/school/dayoff/allDayoff',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.dayOff   = response.data.data;	
				for(var i =0; i < $scope.dayOff.length; i++)
	            {
	                $scope.dayOff[i]['concat_id_encrypt'] = $scope.encryptStr($scope.dayOff[i].concat_id);
	    		}
			}
			// console.log($scope.dayOff);
			}, function errorCallback(error){

			if(  error.status == 400)
			{
				var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: 'No Day-Off request data is available.'
				});
				return false;
				}();
			}
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
	$scope.getDayoff();

	// Approved and disapproved dayoff request
	$scope.dayoffStatus = function(id,user_type,status){
		// console.log(id + "---"+ user_type + "---"+ status);
		var formData = {'school_id':School_ID,'id':id,'user_type':user_type,'status':status}
		$http.post(BASE_URL+'api/school/dayoff/dayoffStatus',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				var Gritter = function () {
				$.gritter.add({
					title: 'success',
					text: `Your request status has been ( ${status} ) .`
				});
				// return false;
				$scope.getDayoff();
				}();
			}
			// console.log($scope.dayOff);
			}, function errorCallback(error){

			if(  error.status == 400)
			{
				var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: 'Status has not been updated. please try again.'
				});
				return false;
				}();
			}
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
}
function requestDayOffDetailsCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	var sid;
	$scope.concat_id_encrypt = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.concat_id_encrypt = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.concat_id_encrypt;
	};	
	$timeout($scope.setID(), 2000);

	$scope.dayoffDetails = [];
	$scope.getDayoffDetails = function(){  
			var formData = {'concat_id':$scope.concat_id_encrypt};
			$http.post(BASE_URL+'api/school/dayoff/getDayoffDetails',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
				
				if(response.status == 200)
				{
					$scope.dayoffDetails  = response.data.data;
				}
	 // console.log($scope.dayoffDetails); 
				
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
    $scope.getDayoffDetails();
	 // console.log(sid); 
	 // return false;
}

function classScheduleCtrl($scope, $http, $routeParams, $timeout,$window)
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
        $http.get(BASE_URL+'api/scheduler',{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
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
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
		var school_type_data = [];
		for(var i=1; i <= 100; i++) {
			school_type_data.push({
				count: i
			});
		}
	$scope.getSchoolType = function(){ 
	  	$scope.lecture_count = school_type_data;
		//$scope.lecture_count = [{count : 1},{count : 2},{count : 3},{count : 4},{count : 5}];
	            
		$http.get(BASE_URL+'api/scheduler/schoolType',{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
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
  		var tempData = {school_id:School_ID,school_type:$scope.school_type,no_periods:$scope.lecture_counts,scheduleTime:$scope.scheduleTime};
	// console.log($scope.scheduleTime);
	// console.log(tempData);
	// return false
  	 	$http.post(BASE_URL+'api/scheduler',tempData,{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
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
            		
		},function errorCallback(error){
			var Gritter = function () {
                $.gritter.add({
					title: 'Error',
					text: error.data.message
				});
                return false;
			}();
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
	};
}
function detailsScheduleCtrl($scope, $http, $routeParams, $timeout,$window)
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.scheduletime 	= response.data.data.detailList;
				
				$scope.scheduleinfo 	= response.data.data;
				$scope.name 			= $scope.scheduleinfo.name;
				$scope.no_periods 		= $scope.scheduleinfo.no_periods;
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	};
}
function timeTableCtrl($scope, $http, $routeParams, $timeout,$window)
{
	// To get the school type
	$scope.schoolTypeList = [];
	$scope.getSchoolType = function(){ 
			$http.get(BASE_URL+'api/timeTable/schoolType',{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
				$scope.classList = response.data.data;
				 $scope.ob.class = '';
			//	$scope.ob.class = $scope.classList[0].id;	
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			$scope.TeacherList = response.data.data;
			//console.log($scope.TeacherList);			
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
	};
	$scope.getTeachers();

	// Get Subjects based on school-id and class-id
	$scope.SubjectList = [];
	$scope.getSubjects = function(){
		$http.post(BASE_URL+'api/timeTable/getAllSubjectForClass',{school_id:School_ID,class_id:$scope.ob.class},{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			$scope.SubjectList = response.data.data;
			//console.log($scope.TeacherList);			
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
	};
	$scope.getSubjects();

	/*Check schedule is Exist or not ? */
	$scope.lecturesList=[];
	$scope.checkSchedule = function(){

		var formData = {id:School_ID,class_id:$scope.ob.class,school_type:$scope.school_type};
		$http.post(BASE_URL+'api/timeTable',formData,{
			headers:{
				'Content-Type':undefined,'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
		}).then(function(response){
			var errormsg = response.data.message;
			$scope.timeTableList = response.data.data;

			// console.log('errormsg: '+ errormsg)
			// console.log('timeTableList: '+ $scope.timeTableList)
			// return false

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
	};
	// Insert values into time-table
	$scope.updateTimeTable = function(){
		 // console.log($scope.periodEdit); return false
		$http.post(BASE_URL+'api/timeTable/updateTimeTable',$scope.periodEdit,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	};	
	
}
function HomeCtrl($scope, $http,$timeout,$window) 
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
				'Content-Type':undefined,
				'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	$scope.getAllParentsForSchool();
	
	$scope.getAllTeachersForSchool = function()
	{
		var formData = {'schoolId':School_ID}
		$http.post(BASE_URL+'api/user/getAllTeacher',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
			}, function errorCallback(error){
				/* if(error.status==401){	
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
					}*/
			
		});
	}	
	$scope.getAllTeachersForSchool();
	$scope.pageSize = 10;
	$scope.getAllEventsForSchool = function()
	{
		
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllEventsForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
			}, function errorCallback(error){
				/*  if(error.status==401){	
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
					} */
			
		});
		
	}
	$scope.getAllEventsForSchool();
	
	$scope.getAllStudentsForSchool = function()
	{	
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllStudentsForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
			}, function errorCallback(error){
				/* if(error.status==401){	
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
					} */
			
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
			}, function errorCallback(error){
				/* if(error.status==401){	
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
					} */
			
		});
		
	}
	$scope.getAllDriverForSchool();
	
	$scope.convertDateFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [day, mnth, date.getFullYear()].join("-");
	}
        
        
     $scope.getfees = function()
     {
        $scope.feesdata = "";
        $scope.symbol = "";
        $scope.sumfees = "";
        var formData = {'schoolID':School_ID};
        $http.post(BASE_URL+'api/user/getfees',formData,{
        headers:{
                'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
        }
        }).then(function(response) {

        if(response.status == 200)
        {
        $scope.feesdata = response.data.data;
        $scope.sumfees = $scope.feesdata.currency_symbol+$scope.feesdata.total;
        
        console.log($scope.sumfees);
        //console.log($scope.notesdata);
        }

        }, function errorCallback(error){});
		
    }
   $scope.getfees();   
        
        
        
        
}
function LearningAndDevelopmentCtrl($scope, $http, $routeParams, $timeout,$window){
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
        $http.get(BASE_URL+'api/learningAndDevelopment',{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
        {		
            $scope.dataList  = response.data;
            for(var i =0; i < $scope.dataList.length; i++)
            {
                $scope.dataList[i].id = $scope.encryptStr($scope.dataList[i].id);
			}
		});
	}
        
    $scope.decrptID = function(id){
		var enkeyID = CryptoJS.AES.decrypt(id, "KidyView");
		var decryptID = enkeyID.toString(CryptoJS.enc.Utf8);
		return decryptID;
	};
    
   $scope.deleteList = function(ID,index)
	{
                var ID  =  $scope.decrptID(ID);
                var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':ID};
			$http.post(BASE_URL+'api/learningAndDevelopment/deleteList',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
				
				if(response.status == 200)
				{
					var result  = response.data;
					var Gritter = function () {
						$.gritter.add({
							title: 'Successfull',
							text: response.data.message
						});
						$scope.getDataList();
						//$scope.classboardPostData.splice(index, 1);;
						return false;
					}();
				}
				
				}, function errorCallback(response){
				
			});
		}
	}     
        
        
    $scope.getDataList();
}
function AddLearningAndDevelopmentCtrl($scope, $http, $routeParams, $timeout,$window){
    $scope.options = [];
    $scope.data = {id:"",name:"",class_id:"",detail:{"id": "","question": "","options": [],"option_type": "","category_id": ""},info:[]};
    $scope.getDetail = function(){        
        $http.get(BASE_URL+'api/learningAndDevelopment/detail?id='+$scope.id,{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
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
        $http.get(BASE_URL+'api/classes',{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
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
        $http.post(BASE_URL+'api/learningAndDevelopment',$scope.data,{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
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
			},function errorCallback(error){
			var Gritter = function () {
                $.gritter.add({
					title: 'Error',
					text: error.data.message
				});
                return false;
			}();
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
	};
}
function EditLearningAndDevelopmentCtrl($scope, $http, $routeParams, $timeout,$window){
    $scope.id = "";
    $scope.options = [];
    $scope.data = {id:"",name:"",class_id:"",detail:{"id": "","question": "","options": [],"option_type": "","category_id": ""},info:[]};
    $scope.getDetail = function(){        
        $http.get(BASE_URL+'api/learningAndDevelopment/detail?id='+$scope.id,{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
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
        $http.get(BASE_URL+'api/classes',{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
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
        $http.put(BASE_URL+'api/learningAndDevelopment',$scope.data,{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
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
			},function errorCallback(error){
			var Gritter = function () {
                $.gritter.add({
					title: 'Error',
					text: error.data.message
				});
                return false;
			}();
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
	};
}
function MealPlannerCtrl($scope, $http, $routeParams, $timeout,$window){
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
        $http.get(BASE_URL+'api/mealPlanner',{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
        {		
            $scope.mealList  = response.data;
            for(var i =0; i < $scope.mealList.length; i++)
            {
                $scope.mealList[i].id = $scope.encryptStr($scope.mealList[i].id);
			}
		});
	}
        
    $scope.deleteList = function(ID,index)
	{       var ID  =  $scope.decrptID(ID);
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':ID};
			$http.post(BASE_URL+'api/mealPlanner/deleteList',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
				
				if(response.status == 200)
				{
					var result  = response.data;
					var Gritter = function () {
						$.gritter.add({
							title: 'Successfull',
							text: response.data.message
						});
						$scope.getMealList();
						//$scope.classboardPostData.splice(index, 1);;
						return false;
					}();
				}
				
				}, function errorCallback(response){
				
			});
		}
	}
        
    $scope.decrptID = function(id){
		var enkeyID = CryptoJS.AES.decrypt(id, "KidyView");
		var decryptID = enkeyID.toString(CryptoJS.enc.Utf8);
		return decryptID;
	};     
        
    $scope.getMealList();
    
}
function addMealCtrl($scope, $http, $routeParams, $timeout,$window){
    $scope.schoolTypeList = [];
    $scope.classList = [];
    $scope.mealPlan = {school_type:"",from_date:"",to_date:"",detailList:[]};
    
    
    $scope.getSchoolType = function(){        
        $http.get(BASE_URL+'api/mealPlanner/schoolType',{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
        {	
		    $scope.schoolTypeList  = response.data;			
		});
	};
    $scope.getSchoolType();
    
    $scope.createMealList = function(){        
        $http.post(BASE_URL+'api/mealPlanner/dateRange',$scope.mealPlan,{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
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
        $http.post(BASE_URL+'api/mealPlanner',$scope.mealPlan,{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
        {
            var result  = response.data;
            var Gritter = function () {
                $.gritter.add({
					title: 'Successfull',
					text: 'Meal Plan Added Successfuly.'
				});
				$window.location.href = '#!/meal-planner';
			}();			
			},function errorCallback(error){
			var Gritter = function () {
                $.gritter.add({
					title: 'Error',
					text: error.data.message
				});
                return false;
			}();
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
	};
    
}
function editMealCtrl($scope, $http, $routeParams, $timeout,$window){
    $scope.id = "";
    $scope.mealPlan = {school_type:"",from_date:"",to_date:"",detailList:[]};
    $scope.getMealDetail = function(){        
        $http.get(BASE_URL+'api/mealPlanner/detail?id='+$scope.id,{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
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
        $http.get(BASE_URL+'api/mealPlanner/schoolType',{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
        {	
            $scope.schoolTypeList  = response.data;			
		});
	};
    $scope.getSchoolType();
    
    $scope.createMealList = function(){        
        $http.post(BASE_URL+'api/mealPlanner/dateRange',$scope.mealPlan,{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
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
        $http.put(BASE_URL+'api/mealPlanner',$scope.mealPlan,{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
        {	
            var result  = response.data;
            var Gritter = function () {
                $.gritter.add({
					title: 'Successfull',
					text: 'Meal Plan Updated Successfuly.'
				});
                return false;
			}();			
			},function errorCallback(error){
			var Gritter = function () {
                $.gritter.add({
					title: 'Error',
					text: error.data.message
				});
                return false;
			}();
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
	};
    
}
function HomeMealCtrl($scope, $http, $routeParams, $timeout,$location,$window){
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
        $http.get(BASE_URL+'api/homeMeal',{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
        {		
            $scope.mealList  = response.data.data;			
		});
	}
    $scope.getHomeMeal();
    $scope.addHomeMeal = function(){        
        $http.post(BASE_URL+'api/homeMeal',{name:$scope.meal.name},{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
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
            
			},function errorCallback(error){
			var Gritter = function () {
                $.gritter.add({
					title: 'Error',
					text: error.data.message
				});
                return false;
			}();
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
}
function editProfileCtrl($scope, $http, $route, $timeout,$window,schoolTypeListData) 
{
	$scope.schoolTypeList=schoolTypeListData;
	/* $(function() {
		$('#chkveg').multiselect({
		includeSelectAllOption: true
		});
	}); */
	
        $scope.onChange = function (files) {
		if(files[0] == undefined) return;
		$scope.fileExt = files[0].name.split(".").pop();
	}
	$scope.isImage = function(ext) {
		if(ext) {
			return ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png";
		}
	}
        
        
	
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
		// console.log(formData); return false
		$http.post(BASE_URL+'api/user/changePasswordSchool',formData,{
			headers:{
				'Content-Type':'application/json',
				'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
			}, function errorCallback(error){
			$scope.result = error.data.data;
			$scope.errormsg = 'Sorry! Your Password is not updated.';
			$scope.successmsg = '';
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
	
	
	$scope.getSchoolDetails = function()
	{
		var formData = {'id':School_ID}
		$scope.currencies = [];
		$http.post(BASE_URL+'api/user/getSchoolDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
                                $scope.countryCode 	= $scope.result.countryCode;
                                $scope.countryName      = $scope.result.countryName;
				$scope.pincode 		= $scope.result.pincode;
				$scope.skypeid 		= $scope.result.skypeid;
				$scope.area 		= $scope.result.area;
				$scope.currency 	= $scope.result.currency;
				$scope.motto 		= $scope.result.motto;
				$scope.facebook 	= $scope.result.facebook;
				$scope.twitter 		= $scope.result.twitter;
				$scope.youtube 		= $scope.result.youtube;
				$scope.linkdin 		= $scope.result.linkdin;
				$scope.otherinfo 	= $scope.result.otherinfo;
				$scope.schoolType 	= $scope.result.schoolType;
				$scope.pic 			= $scope.result.pic;
				$scope.typeOfSchool = $scope.schoolType;
				$scope.currencies 	= $scope.result.currencies;
                                $scope.currency         = $scope.result.currency_id;
                                $scope.bank_name 	= $scope.result.bank_name;
				$scope.account_number   = $scope.result.account_number;
                                $scope.sort_code 	= $scope.result.sort_code;
                                console.log($scope.currencies);
                                console.log($scope.currency);
                               
			// console.log($scope.result);
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
	$scope.getSchoolDetails();
	
	$scope.getSchoolDetailsForEdit = function()
	{
		var formData = {'id':School_ID}
		$http.post(BASE_URL+'api/user/getSchoolDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				$scope.pic 		= $scope.result.pic;
				$scope.typeOfSchool     = $scope.schoolType;
                                $scope.bank_name 	= $scope.result.bank_name;
				$scope.account_number   = $scope.result.account_number;
                                $scope.sort_code 	= $scope.result.sort_code;
                                
                                
                           
                                
				if($scope.pic!="")
                                {
				var oldSrc = $('.profileImageHeader').attr("src");
                            	var newSrc = BASE_URL+'img/school/'+$scope.pic;
                                    if(newSrc != oldSrc)
                                    {
                                            $('img[src="' + oldSrc + '"]').attr('src', newSrc);
                                    }
                                 }
				
				$('.username').text($scope.schoolname);
				
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
	
	$scope.updateProfile = function()
	{
		if($scope.schoolname == ''   || $scope.currency == '' ||  $scope.email == '' || $scope.location == '' || $scope.phone == '' || $scope.schoolType == '')
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
                formData.append('currency_id', $scope.currency);
                formData.append('bank_name', $scope.bank_name);
                formData.append('sort_code', $scope.sort_code);
                formData.append('account_number', $scope.account_number);
		
		var files = document.getElementById('pic').files[0];
		formData.append('pic',files);
		//console.log(formData); return false;
                
                var files4 = document.getElementById('signatureImg').files[0];
		formData.append('signatureImg',files4);
		
		
		$http.post(BASE_URL+'api/user/updateProfileSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
            }, function errorCallback(error){
			$scope.getSchoolDetailsForEdit();
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
	
	$scope.removeProfilePic = function()
	{
		var oldSrc = '';
		var newSrc = '';
		
		var formData = {'photo':'default-profilePic.png','id':School_ID}
		
		$http.post(BASE_URL+'api/user/removeProfilePicSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
                                        $('.profileImageHeader').attr('src',newSrc);
				}
				return false;
			}();
			
            }, function errorCallback(error){
			$scope.getSchoolDetails();
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
	
}

function subadminProfileCtrl($scope, $http, $route, $timeout,$window) 
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
				'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
			}, function errorCallback(error){
			$scope.result = error.data.data;
			$scope.errormsg = 'Sorry! Your Password is not updated.';
			$scope.successmsg = '';
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
	
	
	$scope.getDetails = function()
	{
		var formData = {'id':School_ID}
		$http.post(BASE_URL+'api/user/getSchoolSubadminDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	$scope.getDetails();
	
	$scope.getSchoolDetailsForEdit = function()
	{
		var formData = {'id':School_ID}
		$http.post(BASE_URL+'api/user/getSchoolSubadminDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
                                        $('.profileImageHeader').attr('src',newSrc);
				}	
				
				$('.username').text($scope.schoolname);
				
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
            }, function errorCallback(error){
			$scope.getSchoolDetailsForEdit();
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
	
	$scope.removeProfilePic = function()
	{
		var oldSrc = '';
		var newSrc = '';
		
		var formData = {'photo':'default-profilePic.png','id':School_ID}
		
		$http.post(BASE_URL+'api/user/removeProfilePicSchoolSubadmin',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
            }, function errorCallback(error){
			$scope.getSchoolDetails();
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
	
} 

function getAllParentCtrl($scope, $http, $routeParams, $timeout,$window) 
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
	$scope.parentList=[];
	$scope.getAllParentsForSchool = function()
	{
		var formData = {'schoolId':School_ID}
		$http.post(BASE_URL+'api/user/getAllParent',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.parentList = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.parentList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.parentList[i].id);
					$scope.parentList[i]['fathername'] = $scope.parentList[i]['fatherfname']?$scope.parentList[i]['fatherfname']+' '+$scope.parentList[i]['fatherlname']:$scope.parentList[i]['motherfname']+' '+$scope.parentList[i]['motherlname'];
					$scope.parentList[i]['label'] = $scope.parentList[i]['fatherfname']?$scope.parentList[i]['fatherfname']+' '+$scope.parentList[i]['fatherlname']:$scope.parentList[i]['motherfname']+' '+$scope.parentList[i]['motherlname'];
					$scope.parentList[i]['parentID'] = encrypted;
				}
				// console.log($scope.parentList);
			}
			
			}, function errorCallback(error){
				$scope.parentList=[];
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
	$scope.isNewParent=false;
	$scope.inputoptions	=[{"email":''}];

	$scope.addNewParentData = function(){
        $scope.inputoptions.push({email:""});
	}
	$scope.removeNewParentData = function(index){
        $scope.inputoptions.splice(index,1);
	}
	$scope.getAllParentsForSchool();
	$scope.parent=[];
	$scope.setting1 = {
		scrollableHeight: '150px',
		scrollable: true,
		enableSearch: true,
		displayProp: 'fathername'
	}
	$scope.settingCustomTexts={
		buttonDefaultText: 'Select Parent'
	}
	$scope.opentSendFormData=function(){
		$("#selectStudentList").modal('show');
	}
	$scope.parentIdArr=[];
	$scope.parentEmailArr=[];
	$scope.sendStudentFormLink=function(){
		if($scope.parent.length>0){
			for(var i = 0; i < $scope.parent.length; i++)
			{
				$scope.parentIdArr.push("P-"+$scope.parent[i]['id']);
			}
		}
		if($scope.inputoptions.length>0){
			for(var i = 0; i < $scope.inputoptions.length; i++)
			{
				$scope.parentEmailArr.push($scope.inputoptions[i]['email']);
			}
		}
		var formData1 = {'id':School_ID,'exitParentData':$scope.parentIdArr,'newParentEmailData':$scope.parentEmailArr};
		$http.post(BASE_URL+'api/user/sendStudentFormLinkToParent',formData1,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			console.log(response);
			return false;
			if(response.status == 200)
			{
				
				var result  = response.data;
				var Gritter = function () {
					if(status == 0)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'Call Status Disabled Now.'
						});
					}else if(status == 1)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'Call Status Enabled Now.'
						});
					}
					
					$scope.getAllParentsForSchool();
					return false;
				}();
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
	
	$scope.sort = function(keyname){
		$scope.sortKey = keyname;
		$scope.reverse = !$scope.reverse;
	}
	$scope.pageSize = 10;
        
        
        $scope.callDisabled = function(parentID, status)
	{
		
		var formData1 = {'id':parentID, 'status':status};
		$http.post(BASE_URL+'api/user/callDisabled',formData1,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
							text: 'Call Status Disabled Now.'
						});
					}else if(status == 1)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'Call Status Enabled Now.'
						});
					}
					
					$scope.getAllParentsForSchool();
					return false;
				}();
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
        
	
	$scope.parentDisabled = function(parentID, status)
	{
		
		var formData1 = {'id':parentID, 'status':status};
		$http.post(BASE_URL+'api/user/parentDisabled',formData1,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	
}
function allParentCtrl($scope, $http, $routeParams, $timeout,$window) 
{
	$scope.showChildLoginDetail=function(childlogin_id,cpass,cfname,cmname,clname){
		$scope.cloginid=childlogin_id;
		$scope.cpassword=cpass;
		$scope.cfullname=cfname+' '+cmname+' '+clname;
		$("#childLoginDetailModal").modal('show');
	}
	$scope.generateUserPass = function(fname,mname,femail,memail,childid,childrid,childfname,childmname,childlname){
		var formData = {'fname':fname,'mname':mname,'femail':femail,'memail':memail,'childid':childid,'childrid':childrid,'childfname':childfname,'childmname':childmname,'childlname':childlname}
		$http.post(BASE_URL+'api/user/getStudentUsernamePassword',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.classList = response.data.data;
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
	$scope.getAllClassForSchool();
	
	$scope.getParentDetails = function()
	{
		var formData = {'id':$scope.parentID}
		$http.post(BASE_URL+'api/user/getParentDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	$scope.isChildSubmit=false;
	$scope.addChild = function(){
	
		// console.log("childdob:"+$scope.childdob);
		// console.log("childphoto:"+$scope.childphoto);
		// return false
		///console.log($scope.childdob+'=============');
                
		if( $scope.childfname == '' || $scope.childlname == '' || $scope.childclass == '' || $.trim($scope.childdob) == '' || $scope.childgender == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill all required fields of child (Indicating With * Sign).'
				});
				return false;
			}();
			return false;
		}
                
              
		$scope.isChildSubmit=true;
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
            }, function errorCallback(error){
			
			var errresult = error.data.message
			$scope.getParentDetails();
			if(error.status==401){	
				localStorage.setItem('TOKEN', '');
				$window.location = BASE_URL+'schoollogin/login';
				}
				if(error.status==400){	
					$scope.isChildSubmit=false;
						var Gritter = function () {
						$.gritter.add({
							title: 'Error',
							text: error.data.message
						});
						return false;
						}();
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
	};
	
	$scope.editParent = function(){
		
		// if($scope.fatherfname == '' || $scope.fatherlname == '' || $scope.fatheremail == '' || $scope.fatherphone == '' || $scope.fatheraddress == '' || $scope.motherfname == '' || $scope.motherlname == '' || $scope.motheremail == '' || $scope.motherphone == '' || $scope.motheraddress == '' || $scope.emergencyfname == '' || $scope.emergencylname == '' || $scope.emergencyemail == '' || $scope.emergencyphone == '' || $scope.emergencyaddress == '')
		// {
		//if( ( ( ($scope.fatherfname == '' || $scope.fatherlname == '' || $scope.fatheremail == '' || $scope.fatherphone == '' || $scope.fatheraddress == '') || ($scope.motherfname == '' || $scope.motherlname == '' || $scope.motheremail == '' || $scope.motherphone == '' || $scope.motheraddress == '') ) && ($scope.emergencyfname == '' || $scope.emergencylname == '' || $scope.emergencyemail == '' || $scope.emergencyphone == '' || $scope.emergencyaddress == '') ) )
		//{
		//if( ( ( ($scope.fatherfname == '' && $scope.fatheremail == '' && $scope.fatherphone == '') || ($scope.motherfname == '' && $scope.motheremail == '' && $scope.motherphone == '') ) ) )
		//{
			if( ($scope.fatherfname == '' || $scope.fatheremail == '' || $scope.fatherphone == '') && ($scope.motherfname == '' || $scope.motheremail == '' || $scope.motherphone == '') ){
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
            }, function errorCallback(error){
			var errresult = error.data.message
			if(errresult == 'Already Exists.')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Failed',
						text: 'Email/Phone already exist.'
					});
					
					return false;
				}();
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
        $scope.deleteIt = 0;


	
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	$scope.getSingleChildDetails();
	$scope.getAllClassForSchool = function()
	{
		$scope.classList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllClassForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.classList = response.data.data;
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
	$scope.getAllClassForSchool();
        $scope.continue = 0;
	
	$scope.editChild = function(){
		
		if($scope.childemail == '' || $scope.childRegisterId == '' || $scope.childfname == '' || $scope.childlname == '' || $scope.childgender == '' || $scope.childclass == '' || $scope.childdob == '')
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
                
                //////// Check student driver asssignment if the same class not assign then stop display pop ///////////
                var checkData = {'childID':$scope.childID,'schoolId':School_ID,'childclass':$scope.childclass};
                $http.post(BASE_URL+'api/user/checkDriverChildList',checkData,{
                headers:{
			 'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
                        console.log(response);  
                        var result  = response.data;
                        if(result.count>0)
                        {  
                            if(confirm(result.message)){
                             $scope.continue = 0;
                             $scope.deleteIt = 1;
                            }
                            else {
                            $scope.continue = 1; 
                            $scope.deleteIt = 0;
                            }
                        }
                        if ($scope.continue==1) return false; 
                        /////// Update Code //////////////
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
                formData.append('deleteIt', $scope.deleteIt);
		
		var files1 = document.getElementById('pic').files[0];
		formData.append('pic',files1);
		
		var files2 = document.getElementById('certificate').files[0];
		formData.append('certificate',files2);
		
		$http.post(BASE_URL+'api/user/editChild',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
            }, function errorCallback(error){
			
			var errresult = error.data.message
			$scope.getSingleChildDetails();
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
                /////// End Update Code //////////
                        
                            
                        },function errorCallback(error){});
                     
                /////// End Check student driver asssignment if the same class not assign then stop display pop ///////////
                
               
            	
//		var formData = new FormData();
//		formData.append('schoolId', School_ID);
//		formData.append('childID', $scope.childID);
//		formData.append('childRegisterId', $scope.childRegisterId);
//		formData.append('childfname', $scope.childfname);
//		formData.append('childmname', $scope.childmname);
//		formData.append('childlname', $scope.childlname);
//		formData.append('childgender', $scope.childgender);
//		formData.append('childclass', $scope.childclass);
//		formData.append('childdob', $scope.convertDateNewFormat($scope.childdob));
//		formData.append('childemail', $scope.childemail);
//		formData.append('childemail', $scope.childemail);
//		formData.append('childhealthdetail', $scope.childhealthdetail);
//		formData.append('childallergy', $scope.childallergy);
//		formData.append('childSpecialneed', $scope.childSpecialneed);
//		formData.append('childApplicablemedication', $scope.childApplicablemedication);
//		formData.append('childbg', $scope.childbg);
//		formData.append('childaddress', $scope.childaddress);
//		formData.append('childphoto', $scope.childphoto);
//		formData.append('childcertificate', $scope.childcertificate);
//		
//		var files1 = document.getElementById('pic').files[0];
//		formData.append('pic',files1);
//		
//		var files2 = document.getElementById('certificate').files[0];
//		formData.append('certificate',files2);
//		
//		$http.post(BASE_URL+'api/user/editChild',formData,{
//			headers:{
//				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
//			}
//			}).then(function(response) {
//			var result  = response.data;
//			var errdata  = response.data.data;
//		
//				if(errdata == 'already-updated')
//				{
//						var Gritter = function () {
//							$.gritter.add({
//								title: 'successfully',
//								text: 'Child already updated.'
//							});
//							$window.location.href = '#!/student-list';
//							return false;
//						}();
//				}else{
//						var Gritter = function () {
//							$.gritter.add({
//								title: 'Successfull',
//								text: 'Child Updated successfully.'
//							});
//							$window.location.href = '#!/student-list';
//							return false;
//						}();
//				}
//			
//            }, function errorCallback(error){
//			
//			var errresult = error.data.message
//			$scope.getSingleChildDetails();
//			if(error.status==401){	
//				localStorage.setItem('TOKEN', '');
//				$window.location = BASE_URL+'schoollogin/login';
//				}
//				if(error.status==403){	
//					if(error.data.status==0){
//						var Gritter = function () {
//						$.gritter.add({
//							title: 'Error',
//							text: error.data.message
//						});
//						$timeout(
//							$window.location = BASE_URL+'schoollogin/logout'
//						, 200);
//						return false;
//						}();
//					}
//					if(error.data.status==2){
//						var Gritter = function () {
//						$.gritter.add({
//							title: 'Error',
//							text: error.data.message
//						});
//						$timeout(
//							$window.location = BASE_URL+'schooluser'
//						, 200);
//						return false;
//						}();
//					}
//				}
//		});
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
		componentForm[googleMapId + 'locality'] 			= 'long_name';
		componentForm[googleMapId + 'administrative_area_level_1'] 	= 'short_name';
		componentForm[googleMapId + 'country'] 				= 'long_name';
		componentForm[googleMapId + 'postal_code'] 			= 'short_name';
		
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
		console.log($scope.motherfname);
		console.log($scope.motheremail);
		console.log($scope.motherphone);
		console.log($scope.fatherfname);
	//if($scope.fatherfname == ''  || $scope.fatheremail == '' || $scope.fatherphone == '' || $scope.motherfname == '')
        //{
		//if( ( ( ($scope.fatherfname == '' || $scope.fatheremail == '' || $scope.fatherphone == '') || ($scope.motherfname == '' || $scope.motheremail == '' || $scope.motherphone == '' || $scope.motheraddress == '') ) ) )
		//{	
		if( ($scope.fatherfname == '' || $scope.fatheremail == '' || $scope.fatherphone == '') && ($scope.motherfname == '' || $scope.motheremail == '' || $scope.motherphone == '') ){
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Parent added successfully.'
				});
                                ///console.log('Parent added successfully');
				$window.location.href = '#!/parent-list';
				return false;
			}();
			
            }, function errorCallback(error){
			
			var errresult = error.data.message
			//console.log(response);
			if(errresult == 'Already Exists.')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Failed',
						text: error.data.err_message
					});
					
					return false;
				}();
			}
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	}
}
function allEventCtrl($scope, $http, $routeParams, $timeout,$window) 
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
		$scope.timeFormat = function(datetime)
		{
			// let d = new Date(datetime);
			// let pm = d.getHours() >= 12;
			// let hour12 = d.getHours() % 12;
			// if (!hour12) 
			//   hour12 += 12;
			// let minute = d.getMinutes();
			// return (`${hour12}:${minute} ${pm ? 'PM' : 'AM'}`);
			return datetime.toLocaleTimeString('en-GB');
		};

		var formData = new FormData();
		formData.append('eventtitle', $scope.eventtitle);
		formData.append('eventvisiblity', $scope.objE.eventvisiblity.join());
		formData.append('eventdate', $scope.convertDateNewFormat($scope.eventdate));
		formData.append('eventtime', $scope.timeFormat($scope.eventtime));
		formData.append('eventaddress', $scope.eventaddress);
		formData.append('eventdesc', $scope.eventdesc);
		formData.append('eventtype', $scope.eventtype);
		formData.append('eventamount', $scope.eventamount);
		formData.append('schoolId', School_ID);
		
		// console.log($scope.timeFormat($scope.eventtime));

		var files = document.getElementById('pic').files[0];
		formData.append('pic',files);
		
		// console.log(formData);
		// return false;
		$http.post(BASE_URL+'api/user/addEvent',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
		$scope.timeFormat = function(datetime)
		{
			return datetime.toLocaleTimeString('en-GB');
		};
		var formData = new FormData();
		formData.append('eventId', eventId);
		formData.append('eventtitle', $scope.eventtitle);
		formData.append('eventvisiblity', $scope.objE.eventvisiblity.join());
		formData.append('eventdate', $scope.convertDateNewFormat($scope.eventdate));
		formData.append('eventtime', $scope.timeFormat( $scope.eventtime));
		formData.append('eventaddress', $scope.eventaddress);
		formData.append('eventdesc', $scope.eventdesc);
		formData.append('eventtype', $scope.eventtype);
		formData.append('eventamount', $scope.eventamount);
		formData.append('schoolId', School_ID);
		
		var files = document.getElementById('pic').files[0];
		formData.append('pic',files);
		$http.post(BASE_URL+'api/user/editEvent',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	};
}

function feedbackCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
    console.log('feedbackCtrl');
    $scope.pageSize = 10;
    
    $scope.optionsList = [{ name: "teacher", id: 1 }, { name: "parent", id: 2 },{ name: "driver", id: 2 }];
    
        function upperCase(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        function capitalize(str) {
        return str.toUpperCase();    
        }
    
    
        $scope.getuserFeedback = function(userType)
        {
         console.log('getuserFeedback');
        $scope.feedback = false;
		var formData = {'userType':userType,'schoolId':School_ID};
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
                                        $scope.feedback[i]['user_type'] = upperCase($scope.feedback[i]['user_type']);
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
        
        function upperCase(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        function capitalize(str) {
        return str.toUpperCase();    
        }
        
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
                                $scope.driveremail              = $scope.feedinfo.driveremail;
				$scope.driverphone              = $scope.feedinfo.driverphone;
				$scope.message                  = $scope.feedinfo.message;
				$scope.message_for 		= $scope.feedinfo.message_for;
				$scope.school                   = $scope.feedinfo.school;
				$scope.user_type 		= upperCase($scope.feedinfo.user_type);
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

function getAllDriverCtrl($scope, $http, $routeParams, $timeout,$window) 
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
		$http.post(BASE_URL+'api/driver/getAllDriverForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
		var formData1 = {'id':driverID, 'status':status,'schoolid':School_ID};
		$http.post(BASE_URL+'api/driver/driverDisabled',formData1,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				var result  = response.data;
				var Gritter = function () {
					
                                        $.gritter.add({
					title: result.done,
					text: result.message
                                        });
					
					$scope.getAllDriverForSchool();
					return false;
				}();
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
       $scope.getAllDriverForSchool(); 
        
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
        $scope.password 	  	= '';
        $scope.confirmPassword 	= '';
        $scope.vehicleList = false;
       
        
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
        
       $scope.getAllvehicle = function()
	{
		
		var formData = {'schoolId':School_ID};
		$http.post(BASE_URL+'api/driver/getAllvehicle',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.vehicleList = response.data.data;
			}
			
			}, function errorCallback(error){});
		
	}
       $scope.getAllvehicle();  
        
	 
        
	
	$scope.addDriver = function(){
		
		$scope.convertDateNewFormat = function(str) {
			var date = new Date(str),
			mnth = ("0" + (date.getMonth() + 1)).slice(-2),
			day = ("0" + date.getDate()).slice(-2);
			return [date.getFullYear(), mnth, day].join("-");
		}
                
//                var password =  $scope.password.trim();
//                var confirmPassword = $scope.confirmPassword.trim();
                
		if($scope.driverfname == '' || $scope.driverlname == '' || $scope.driveremail == '' || $scope.driverphone == ''  || $scope.drivervehicle == ''  || $scope.driverlicense == '' || $scope.driverLicenseExpire == '' || $scope.driveraddress == '' || $scope.emergencyfname == '' || $scope.emergencylname == '' || $scope.emergencyphone == '' || $scope.emergencyemail == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill all required fields(Indicating With * Signss).'
				});
				return false;
			}();
			return false;
		}
                
              
                if($scope.password!=$scope.confirmPassword) {
                    console.log('checkpass');
                     var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Password and confirm Password Not matched..'
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
                formData.append('password', $scope.password);
	   
		formData.append('schoolId', School_ID);
		
		var files1 = document.getElementById('pic').files[0];
		formData.append('pic',files1);
		
		var files2 = document.getElementById('document').files[0];
		formData.append('document',files2);
		
		$http.post(BASE_URL+'api/driver/addDriver',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
			}, function errorCallback(error){
			var errresult = error.data.message;
                        var datamsg = error.data.data;
			//console.log(response);
                        if(errresult == 'Vehicle Exists.')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Failed',
						text: datamsg
					});
					
					return false;
				}();
			}
                        
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
		$http.post(BASE_URL+'api/driver/getDriverDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
                             
                                $scope.routetitlecode 	  		= $scope.driverinfo.routeTitle;
                                $scope.drivercode 	  		= $scope.driverinfo.drivercode;
                                $scope.vehicle_name 	  		= $scope.driverinfo.vehicle_name;
                                $scope.vehicle_number 	  		= $scope.driverinfo.vehicle_number;
                                $scope.vcode                            = $scope.driverinfo.vcode;
                                $scope.routepath 	  		= $scope.driverinfo.routepath;
                                $scope.stops                            = $scope.driverinfo.stops;
                                
				$scope.formattedDate = $scope.convertDateFormat($scope.driverLicenseExpire);
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
        
        $scope.getAllvehicle = function()
	{
		
		var formData = {'schoolId':School_ID};
		$http.post(BASE_URL+'api/driver/getAllvehicle',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.vehicleList = response.data.data;
			}
			
			}, function errorCallback(error){});
		
	}
       $scope.getAllvehicle();  
        
	$scope.getDriverDetails = function()
	{
		var formData = {'id':$scope.driverID}
		$http.post(BASE_URL+'api/user/getDriverDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				$scope.driverdeviceId                   = $scope.driverinfo.driverdeviceId;
				$scope.drivervehicle                    = $scope.driverinfo.drivervehicle;
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
		
		if($scope.driverfname == '' || $scope.driverlname == '' || $scope.driveremail == '' || $scope.driverphone == ''  || $scope.drivervehicle == ''  || $scope.driverlicense == '' || $scope.driverLicenseExpire == '' || $scope.driveraddress == '' || $scope.emergencyfname == '' || $scope.emergencylname == '' || $scope.emergencyphone == '' || $scope.emergencyemail == '')
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
		
		$http.post(BASE_URL+'api/driver/editDriver',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
			}, function errorCallback(error){
			
			var errresult = error.data.message
                        var datamsg = error.data.data;
			//console.log(response);
                        if(errresult == 'Vehicle Exists.')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Failed',
						text: datamsg
					});
					
					return false;
				}();
			}
			
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
	};
	
}
function getAllSessionCtrl($scope, $http, $routeParams, $timeout,$window) 
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	
	$scope.makeCurrentSession = function(sessionID, status,is_previous)
	{
		if(is_previous==1){
			alert("This is previous session.You can't make this current session.");
				return false;
		}
		var formData1 = {'id':sessionID, 'status':status};
		$http.post(BASE_URL+'api/user/makeCurrentSession',formData1,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
			}, function errorCallback(error){
			
			var errresult = error.data.message
			$scope.getSessionDetails();
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
	};
	
}
function getAllClassCtrl($scope, $http, $routeParams, $timeout,$window) 
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	$scope.exportClass = function()
	{
		var searchingData = $scope.classList;
		var userdata = [];
		if(searchingData.length>0){
		for(var i=0;i<searchingData.length;i++){
			
			var classID = searchingData[i]['id'] ? searchingData[i]['id'] : ''; 
			var className = searchingData[i]['class'] ? searchingData[i]['class'] : '';
			var section = searchingData[i]['section'] ? searchingData[i]['section'] : '';	
			userdata[i] = [
				classID.replace(/,|\n|_/g,'/'),
				className.replace(/,|\n|_/g,'/'),
				section.replace(/,|\n|_/g,'/')
				]
		}
			//console.log(userdata);
			
				var csv = 'Class Id,Class Name,Section\n';
				userdata.forEach(function(row) {
				csv += row.join(',');
				csv += "\n";	
				});

				//console.log(csv);
				var hiddenElement = document.createElement('a');
				hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
				hiddenElement.target = '_blank';
				hiddenElement.download = 'class-list.csv';
				hiddenElement.click();
		}
		else {
			var Gritter = function () {
			$.gritter.add({
			title: 'Error',
			text: `You don't have any data into the list to import.`
			});
			return false;
			}(); 
		}
	};  
}
function addClassCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.getAllSessionForSchool = function()
	{
		$scope.sessionList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllSessionForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.sessionList = response.data.data;
				//console.log($scope.sessionList);
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
	// To get the school type
	$scope.schoolTypeList = [];
	$scope.getSchoolType = function(){ 
	        $http.get(BASE_URL+'api/scheduler/schoolType',{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	};
}
function editClassCtrl($scope, $http, $routeParams, $timeout,$window) 
{
	$scope.getAllSessionForSchool = function()
	{
		$scope.sessionList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllSessionForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.sessionList = response.data.data;
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
	$scope.getAllSessionForSchool();

	// To get the school type
	$scope.schoolTypeList = [];
	$scope.getSchoolType = function(){ 
	        $http.get(BASE_URL+'api/scheduler/schoolType',{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
			}, function errorCallback(error){
			
			var errresult = error.data.message
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
	};
	
}
function getAllSubjectCtrl($scope, $http, $routeParams, $timeout,$window) 
{
	var sid='';
	$scope.class_ID = '';
	if($routeParams.ID){
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.class_ID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.class_ID;
	};
	$timeout($scope.setID(), 2000); 
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
	$scope.getAllSubjectForSchool = function()
	{
		$scope.subjectList = false;
		var formData = {'id':School_ID,'class_id':sid};
		$http.post(BASE_URL+'api/user/getAllSubjectForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	$scope.getAllSubjectForSchool();
	
	$scope.subjectsDisabled = function(subjectID, status)
	{
		var formData1 = {'id':subjectID, 'status':status};
		$http.post(BASE_URL+'api/user/subjectsDisabled',formData1,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
}
function addSubjectCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.subject 	= '';
	$scope.type 	= '';
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
	$scope.ob = {"class":"","teacher":"","type":""};
	$scope.addSubject = function(){
		
		if($scope.subject == '' || $scope.ob.class == '' || $scope.type == '' || $scope.ob.teacher == '' || $scope.description == '')
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
		formData.append('type', $scope.type);
		formData.append('subject_code', $scope.subject_code);
		formData.append('schoolId', School_ID);
		formData.append('class', $scope.ob.class);
		formData.append('teacher', $scope.ob.teacher);
		formData.append('description', $scope.description);
		var files = document.getElementById('pic').files[0];
		formData.append('pic',files);
		$http.post(BASE_URL+'api/user/addSubject',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	};
	$scope.TeacherList = [];
	$scope.getTeachers = function(){
		$http.post(BASE_URL+'api/user/getAllTeacherForSchool',{id:School_ID},{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			$scope.TeacherList = response.data.data;
			//console.log($scope.TeacherList);			
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
	};
	$scope.getTeachers();
	$scope.classList = [];
	$scope.getClasses = function(){
		$http.post(BASE_URL+'api/user/getAllClassForSchool',{id:School_ID},{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			$scope.classList = response.data.data;
			//console.log($scope.classList);			
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
	$scope.ob = {"id":"","subject":"","schoolId":School_ID,"class":"","teacher":"","type":""};
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.subjectinfo = response.data.data;
				$scope.subject  = $scope.subjectinfo.subject;
				$scope.type  = $scope.subjectinfo.type;
				$scope.ob.class  = $scope.subjectinfo.class;
				$scope.ob.teacher  = $scope.subjectinfo.teacher;
				$scope.description  = $scope.subjectinfo.description;
				$scope.photo  = $scope.subjectinfo.image;
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
	$scope.getSubjectDetails();
	//return false;
	$scope.editSubject = function(){		
		if($scope.subject == '' || $scope.type == '' || $scope.ob.class == '' || $scope.ob.teacher == '' || $scope.description == '')
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
		formData.append('type', $scope.type);
		formData.append('class', $scope.ob.class);
		formData.append('teacher', $scope.ob.teacher);
		formData.append('description', $scope.description);
		var files = document.getElementById('pic').files[0];
		formData.append('pic',files);			
		$http.post(BASE_URL+'api/user/editSubject',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	};
	
	$scope.TeacherList = [];
	$scope.getTeachers = function(){
		$http.post(BASE_URL+'api/user/getAllTeacherForSchool',{id:School_ID},{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			$scope.TeacherList = response.data.data;
			//console.log($scope.TeacherList);			
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
	};
	$scope.getTeachers();
	$scope.classList = [];
	$scope.getClasses = function(){
		$http.post(BASE_URL+'api/user/getAllClassForSchool',{id:School_ID},{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			$scope.classList = response.data.data;			
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
	};
	$scope.getClasses();
	
}
function getAllTeacherCtrl($scope, $http, $routeParams, $timeout,$window) 
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
        
        
        $scope.callDisabled = function(teacherID, status)
	{
		
		var formData1 = {'id':teacherID, 'status':status};
		$http.post(BASE_URL+'api/user/callDisabledTeacher',formData1,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
							text: 'Call Status Disabled Now.'
						});
					}else if(status == 1)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'Call Status Enabled Now.'
						});
					}
					
					$scope.getAllTeacherForSchool();
					return false;
				}();
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
        
        
        
        
        
	
}
function addTeacherCtrl($scope, $http, $routeParams, $timeout, $window,schoolTypeListData) 
{
	$scope.schoolTypeList=schoolTypeListData;
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.subjectList = response.data.data;
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
	$scope.getAllSubjectForSchool();
	
	$scope.getAllClassForSchool = function()
	{
		$scope.classList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllClassForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.classList = response.data.data;
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	
	$scope.uploadExperienceCertificate = function(fieldname,index)
	{
		var formData = new FormData();
		var files = document.getElementById('experiencecertificate').files[0];
		formData.append('experiencecertificate',files);
		
		$http.post(BASE_URL+'api/user/uploadExperienceCertificate',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
               
		if($scope.password == '' || $scope.confirmpassword == '' || $scope.teacherfname == '' || $scope.teacherlname == '' || $scope.teacheremail == '' || $scope.teacherphone == '' || $scope.schoolType == '' || $scope.assignclassteacher == '' || $scope.workexp== '' || $.trim($scope.date_of_birth)=='' || $scope.teachergender=='')
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
                
                //console.log('I am in');
                //return false;
		$scope.convertDateFormatForDOB = function(str) {
			var date = new Date(str);
			// var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
			// "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
			// ];
			// var mnth = monthNames[date.getMonth()];
			var mnth = ("0" + date.getMonth()).slice(-2);
			var year = date.getFullYear();
			var day = ("0" + date.getDate()).slice(-2);
			return [year,mnth,day].join("-");
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
		formData.append('date_of_joining', $scope.convertDateFormatForDOB($scope.date_of_joining));
		formData.append('bloodgroup', $scope.bloodgroup);
		formData.append('date_of_birth', $scope.convertDateFormatForDOB($scope.date_of_birth));
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
                
                var files4 = document.getElementById('signatureImg').files[0];
		formData.append('signatureImg',files4);
		
		///if(files3 == undefined)
		//{
		//	var Gritter = function () {
		//		$.gritter.add({
		//			title: 'Validation Error!',
		//			text: 'Please fill all required fields(Indicating With * Sign).'
		//		});
		//		return false;
		//	}();
		//	return false;
		//}
		
		$http.post(BASE_URL+'api/user/addTeacher',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
            }, function errorCallback(error){
			
			var errresult = error.data.message
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
	};
}
function allTeacherCtrl($scope, $http, $routeParams, $timeout,$window) 
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			//	$scope.subjectList		= $scope.teacherinfo.subjectList;
				$scope.qualifications	= $scope.teacherinfo.qualifications;
				var arr = $scope.schoolType.split(',');
				$scope.schoolTypeArr = arr;
				// $scope.date_of_joining = $scope.convertDateFormat($scope.date_of_joining);
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
	$scope.getTeacherDetails();
	
	$scope.convertDateFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [day, mnth, date.getFullYear()].join("-");
	}
}
function editTeacherCtrl($scope, $http, $routeParams, $timeout, $window,schoolTypeListData) 
{
	$scope.schoolTypeList=schoolTypeListData;
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.subjectList = response.data.data;
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.classList = response.data.data;
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
	$scope.getAllClassForSchool();
	
	$scope.uploadEducationCertificate = function(fieldname,index)
	{
		var formData = new FormData();
		var files = document.getElementById('educationcertificate' + index).files[0];
		formData.append('educationcertificate',files);
		
		$http.post(BASE_URL+'api/user/uploadEducationcertificate',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	
	$scope.uploadExperienceCertificate = function(fieldname,index)
	{
		var formData = new FormData();
		var files = document.getElementById('experiencecertificate' + index).files[0];
		formData.append('experiencecertificate',files);
		
		$http.post(BASE_URL+'api/user/uploadExperienceCertificate',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	
	$scope.teacherinfo = false;
	$scope.getTeacherDetails = function()
	{
		var formData = {'id':$scope.teacherID}
		$http.post(BASE_URL+'api/user/getTeacherDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				var datePartials 		= $scope.date_of_joining.split("-");
			  	$scope.date_of_joining  = new Date(datePartials[0], datePartials[1] - 1, datePartials[2]);


				// console.log($scope.date_of_joining);

				$scope.date_of_birth	= $scope.teacherinfo.date_of_birth;
				 var datePartials 		= $scope.date_of_birth.split("-");
			  	$scope.date_of_birth    = new Date(datePartials[0], datePartials[1] - 1, datePartials[2]);


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
                                $scope.signatureImg		= $scope.teacherinfo.signatureImg;

				
				
				if($scope.workexp == 'experience')
				{
					$('.exp-container').show();
				}
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
	$scope.getTeacherDetails();
	
	$scope.teacherQualificationinfo = false;
	$scope.getTeacherQualificationDetails = function()
	{
		var formData = {'id':$scope.teacherID}
		$http.post(BASE_URL+'api/user/getTeacherQualificationDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	$scope.getTeacherQualificationDetails();
	
	$scope.teacherExperienceinfo = false;
	$scope.getTeacherExperienceDetails = function()
	{
		var formData = {'id':$scope.teacherID}
		$http.post(BASE_URL+'api/user/getTeacherExperienceDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	
	$scope.isEditTeacher=false;
	$scope.editTeacher = function(){
		//if($scope.teacherfname == '' || $scope.teacherlname == '' || $scope.teacheremail == '' || $scope.teacherphone == '' || $scope.teachergender == '' || $scope.maritalStatus == '' || $scope.spousename == '' || $scope.spousenumber == '' || $scope.date_of_joining == '' || $scope.date_of_birth == '' || $scope.schoolType == '' || $scope.assignclassteacher == '' || $scope.teacheraddress == '' || $scope.workexp == '')
		//{
			if($scope.password == '' || $scope.confirmpassword == '' || $scope.teacherfname == '' || $scope.teacherlname == '' || $scope.teacheremail == '' || $scope.teacherphone == '' || $scope.schoolType == '' || $scope.assignclassteacher == '' || $scope.workexp== '' || $.trim($scope.date_of_birth)=='' || $scope.teachergender=='')
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
		$scope.isEditTeacher=true;
		$scope.convertDateFormatForDOB = function(str) {
			var date = new Date(str);
			var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
			"Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
			];
			var mnth = ("0" + date.getMonth()).slice(-2);
			var year = date.getFullYear();
			var day = ("0" + date.getDate()).slice(-2);
			return [year,mnth,day].join("-");
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
		formData.append('date_of_joining', $scope.convertDateFormatForDOB($scope.date_of_joining));
		formData.append('bloodgroup', $scope.bloodgroup);
		formData.append('date_of_birth', $scope.convertDateFormatForDOB($scope.date_of_birth));
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
                
                var files4 = document.getElementById('signatureImg').files[0];
		formData.append('signatureImg',files4);
		
		$http.post(BASE_URL+'api/user/editTeacher',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
            }, function errorCallback(error){
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
	};
}
function getAllStudentBirthdayCtrl($scope, $http, $routeParams, $timeout,$window) 
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
function allStudentCtrl($scope, $http, $routeParams, $timeout,$window) 
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.article 		= response.data.data;
				$scope.title 		= $scope.article.title;
				$scope.description 	= $scope.article.description;
				$scope.photo 		= $scope.article.pic;
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	}
}
function getAllAlbumCtrl($scope, $http, $routeParams, $timeout,$window) 
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	$scope.getAllAlbumForSchool();
	
	$scope.albumDisabled = function(albumID, status)
	{
		var formData1 = {'id':albumID, 'status':status};
		$http.post(BASE_URL+'api/user/albumDisabled',formData1,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	
	$scope.getAllTimelineForSchool();
	
	$scope.timelineDisabled = function(timelineID, status)
	{
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData1 = {'id':timelineID, 'status':status};
			$http.post(BASE_URL+'api/user/timelineDisabled',formData1,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	$scope.getTimelineDetails(); 
	
	$scope.timelineCommentDelete = function(timelineCommentID)
	{
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':timelineCommentID};
			$http.post(BASE_URL+'api/user/deleteTimelineComment',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
			}, function errorCallback(error){
			$scope.holidayList=[];
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
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
                        eventRender: function (calEvent, jsEvent, view) {
				//alert(calEvent);
                                $('.fc-today-button').remove();
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.sessionList = response.data.data;
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
			}, function errorCallback(error){
			//alert(response);
			var errresult = error.data.message
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.sessionList = response.data.data;
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.holidayinfo = response.data.data;
				$scope.academicsession  = $scope.holidayinfo.session;
				$scope.holidaytitle  = $scope.holidayinfo.title;
				$scope.holiday_date  = new Date($scope.holidayinfo.for_date);
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
			}, function errorCallback(error){
			
			var errresult = error.data.message
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
	};
	
}
function getAllDiscussionCatCtrl($scope, $http, $routeParams, $timeout,$window,$location) 
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.discussionCatinfo = response.data.data;
				$scope.name  = $scope.discussionCatinfo.name;
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
	$scope.getDiscussionCatDetails();
	
	$scope.editDiscussionCat = function(){
		
		if($scope.name == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill discussion title(Indicating With * Sign).'
				});
				return false;
			}();
			return false;
		}
		
		var formData = new FormData();
		formData.append('id', $scope.discussionCatID);
		formData.append('name', $scope.name);
		formData.append('schoolId', School_ID);
		
		$http.post(BASE_URL+'api/user/editDiscussionCat',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Discussion Category Updated successfully.'
				});
				$window.location.href = '#!/discussioncat-list';
				return false;
			}();
			
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
	};
	
}
function getAllDiscussionCtrl($scope, $http, $routeParams, $timeout, $window,$location) 
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
	
	$scope.getAllDiscussionForSchool = function()
	{
		$scope.picUrl = new Array();
		$scope.discussionattachmentinfo = new Array();
		$scope.discussionList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllDiscussionForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.discussionList = response.data.data;
				
				var encrypted ;
				for(var i = 0; i < $scope.discussionList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.discussionList[i].id);
					$scope.discussionList[i]['discussionID'] = encrypted;
				}
				var discussionattachmentinfo 	= $scope.discussionList;
				for(var v=0; v < discussionattachmentinfo.length; v++)
				{
					var media = discussionattachmentinfo[v].attachment;
					if(media.length > 0)
					{
						for(var i=0; i < media.length; i++)
						{
							var mediaName = media[i]['file'];
							var ext = mediaName.split('.')[1];
							if(ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png")
							{
								$scope.discussionList[v]['pic'] = mediaName.split('.')[0]+'.'+mediaName.split('.')[1];
							}
							else
							{
								$scope.discussionList[v]['pic'] = '';
							}
						}
					}
					else
					{
						$scope.discussionList[v]['pic'] = '';
					}
				}
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
	$scope.getAllDiscussionForSchool();
	$scope.sort = function(keyname){
		$scope.sortKey = keyname;
		$scope.reverse = !$scope.reverse;
	}
	
	$scope.discussionAccept = function(discussionID, status)
	{
		var deleteMedia = $window.confirm('Are you absolutely sure you want to Accept this Discussion?');
		if(deleteMedia == true)
		{
			var formData1 = {'id':discussionID, 'status':status};
			$http.post(BASE_URL+'api/user/discussionAccept',formData1,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
				
				if(response.status == 200)
				{
					var result  = response.data;
					var Gritter = function () {
						if(status == 1)
						{
							$.gritter.add({
								title: 'Successfull',
								text: 'This Discussion Has Been Accepted From School.'
							});
						}
						
						$scope.getAllDiscussionForSchool();
						return false;
					}();
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
		
	}
	
	$scope.discussionDecline = function(discussionID, status)
	{
		var retn=1
		var checlPrivilege=JSON.parse(jsonPrivilege);
		if(checlPrivilege.length==0){
			var cnt=checlPrivilege.length;
			}else{
			var cnt=jsonPrivilege.length;
		}
		if(cnt>0){
			if(checlPrivilege.Discussion['delete']==0){
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
		var deleteMedia = $window.confirm('Are you absolutely sure you want to Decline this Discussion?');
		if(deleteMedia == true)
		{
			var formData1 = {'id':discussionID, 'status':status};
			$http.post(BASE_URL+'api/user/discussionDecline',formData1,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
								text: 'This Discussion Has Been Declined From School.'
							});
						}
						$scope.getAllDiscussionForSchool();
						return false;
					}();
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
	}
}
function allDiscussionCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
	var sid;
	$scope.discussionID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.discussionID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.discussionID;
	};	
	$timeout($scope.setID(), 2000);
	
	$scope.discussioninfo = false;
	$scope.discussionattachmentinfo = false;
	$scope.discussionCommentinfo = false;
	$scope.picUrl = new Array();
	$scope.docUrl = new Array();
	$scope.getDiscussionDetails = function()
	{
		var formData = {'id':$scope.discussionID}
		$http.post(BASE_URL+'api/user/getDiscussionDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.discussioninfo 	= response.data.data;
				$scope.title = $scope.discussioninfo.detail;
				$scope.type = $scope.discussioninfo.category_name;
				$scope.optional_detail = $scope.discussioninfo.optional_detail;
				$scope.create_by = $scope.discussioninfo.create_by;
				$scope.create_by_photo = $scope.discussioninfo.create_by_photo;
				$scope.discussionCommentinfo 	= response.data.data2;
				$scope.discussionattachmentinfo 	= response.data.data1;
				var media = $scope.discussionattachmentinfo;
				for(var i=0; i < media.length; i++)
				{
					var mediaName = media[i]['attachment'];
					var ext = mediaName.split('.')[1];
					if(ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png")
					{
						$scope.picUrl.push(mediaName.split('.')[0]+'.'+mediaName.split('.')[1]);
						
					}else
					{
						$scope.docUrl.push(mediaName.split('.')[0]+'.'+mediaName.split('.')[1]);
					}
				}
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
	$scope.getDiscussionDetails();
	
	$scope.getIframeSrc = function(doc)
	{
		return  BASE_URL + 'img/discussion/' + doc;
	}
	
	$scope.discussionCommentDelete = function(discussionCommentID)
	{
		var retn=1
		var checlPrivilege=JSON.parse(jsonPrivilege);
		if(checlPrivilege.length==0){
			var cnt=checlPrivilege.length;
			}else{
			var cnt=jsonPrivilege.length;
		}
		if(cnt>0){
			if(checlPrivilege.DiscussionComment['delete']==0){
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
			var formData = {'id':discussionCommentID};
			$http.post(BASE_URL+'api/user/deleteDiscussionComment',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
				
				if(response.status == 200)
				{
					var result  = response.data;
					var Gritter = function () {
						$.gritter.add({
							title: 'Successfull',
							text: 'Discussion Comment deleted successfully.'
						});
						
						$window.location.reload();
						return false;
					}();
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
	}
}
function getAllCalendarCtrl($scope, $http, $routeParams, $timeout, $window,calendarData) 
{
	//console.log(calendarData);
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
	$scope.calendardate='';
	$scope.getAllCalendarDataForSchool = function()
	{
		$scope.calendarList = false;
		var formData = {'id':School_ID,'calendardate':$scope.calendardate,'iscalendardata':0};
		$http.post(BASE_URL+'api/user/getAllCalendarData',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.calendarList = response.data.data;
				
			}
			
			}, function errorCallback(respoerrornse){
			$scope.calendarList=[];
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
	$scope.getAllCalendarDataForSchool();
	$scope.sort = function(keyname){
		$scope.sortKey = keyname;
		$scope.reverse = !$scope.reverse;
	}
	
	$scope.convertDateNewFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [date.getFullYear(), mnth, day].join("-");
	}
	$scope.eventsF = function (start, end, timezone, callback) {
		
		var s = new Date(start).getTime() / 1000;
		
		var e = new Date(end).getYear() / 1000;
		var m = new Date(start).getMonth();
		//alert(e);
		var events = [{title: 'Feed Me ' + m,start: s + (50000),end: s + (100000),allDay: false, className: ['customFeed']}];
		//callback(events);
	};
	$scope.eventSources=[calendarData];
	
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
				
			},
			eventRender: function (calEvent, jsEvent, view) {
				//alert(calEvent);
                                $('.fc-today-button').remove();
			},
			viewRender: function(view, element) {
				
			},
			dayClick: function (calEvent, jsEvent, view) {
				$scope.calendardate=$scope.convertDateNewFormat(calEvent);
				$(".fc-day").css('background-color', '');
				$(this).css('background-color', '#00bed5');
				$scope.getAllCalendarDataForSchool();
			},
			
		}
	}	
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
			if(checlPrivilege.Role['delete']==0){
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
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				
				}, function errorCallback(error){
				
				var errresult = error.data.message
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
	}	
	
	$scope.roleDisabled = function(roleID, status)
	{
		
		var formData1 = {'id':roleID, 'status':status};
		$http.post(BASE_URL+'api/user/roleDisabled',formData1,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
		
	};
	$scope.pageSize = 10;
	$scope.getAllRoleForSchool = function()
	{
		$scope.roleList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllRoleForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
			}, function errorCallback(error){
			$scope.roleList=[];
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
		formData.append('schoolId', School_ID);
		
		$http.post(BASE_URL+'api/user/addRole',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.roleinfo = response.data.data;
				$scope.name  = $scope.roleinfo.name;
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
		formData.append('schoolId', School_ID);
		$http.post(BASE_URL+'api/user/editRole',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
			}, function errorCallback(error){
			
			var errresult = error.data.message
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
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllPrivilegeForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
			}, function errorCallback(error){
			$scope.privilegeList=[];
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
		}
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':eventID};
			$http.post(BASE_URL+'api/user/deletePrivilege',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllPermissionModuleForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	$scope.getAllPermissionModuleForSchool();
	
	$scope.getAllActiveRoleForSchool = function()
	{
		$scope.activeRoleList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllActiveRoleForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.activeRoleList = response.data.data;
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
		formData.append('schoolId', School_ID);
		$http.post(BASE_URL+'api/user/addPrivilege',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
		var formData = {'id':School_ID,'isEdit':1};
		$http.post(BASE_URL+'api/user/getAllActiveRoleForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.activeRoleList = response.data.data;
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.privilegeinfo = response.data.data;
				$scope.permissionRoleList=$scope.privilegeinfo;
				$scope.role  = $scope.privilegeID;
				//console.log($scope.permissionRoleList);
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
	$scope.getPrivilegeDetails();
	
	$scope.editPrivilege = function(){
		
		var formData = new FormData();
		formData.append('role_id', $scope.role);
		formData.append('permissionData', JSON.stringify($scope.permissionRoleList));
		formData.append('schoolId', School_ID);
		$http.post(BASE_URL+'api/user/editPrivilege',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
			}, function errorCallback(error){
			
			var errresult = error.data.message
			if(errresult == 'Role Already Exists.')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: 'This Privilege Already Exists.'
					});
					$scope.getRoleDetails();
					return false;
				}();
			}
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
		var formData = {'schoolId':School_ID}
		$http.post(BASE_URL+'api/user/getAllSubadminForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			if(checlPrivilege.SubAdmin['delete']==0){
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
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	}	
	
}
function allSubadminCtrl($scope, $http, $routeParams, $timeout,$window) 
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	$scope.getSubadminDetails();
	
}
function addSubadminCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
	$scope.getAllActiveRoleForSchool = function()
	{
		$scope.roleList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllRoleForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
		formData.append('schoolId', School_ID);
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
            }, function errorCallback(error){
			
			var errresult = error.data.message
			//console.log(response);
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
	};
}
function editSubadminCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.getAllActiveRoleForSchool = function()
	{
		$scope.roleList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllRoleForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
		formData.append('schoolId', School_ID);
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
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
			
            }, function errorCallback(error){
			var errresult = error.data.message
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
	};
	
}
function getAllLearningDevelopmentReportCtrl($scope, $http, $routeParams, $timeout, $window) 
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
	
	$scope.getAllLearningDevelopmentReportForSchool = function()
	{
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllLearningDevelopmentReportForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.LearningDevelopmentReportList = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.LearningDevelopmentReportList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.LearningDevelopmentReportList[i].id);
					$scope.LearningDevelopmentReportList[i]['learningDevelopmentReportListID'] = encrypted;
				}
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
	$scope.getAllLearningDevelopmentReportForSchool();
	
	/* $scope.albumDisabled = function(albumID, status)
		{
		var formData1 = {'id':albumID, 'status':status};
		$http.post(BASE_URL+'api/user/albumDisabled',formData1,{
		headers:{
		'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
		
	} */
	
}
function allLearningDevelopmentReportCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
	var sid;
	$scope.lndrID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.lndrID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.lndrID;
	};	
	$timeout($scope.setID(), 2000);
	
	$scope.lndrinfo = false;
	$scope.getLearningDevelopmentReportDetails = function()
	{
		var formData = {'id':$scope.lndrID}
		$http.post(BASE_URL+'api/user/getLearningDevelopmentReportDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.lndrinfo 	= response.data.data;
				$scope.answer = $scope.lndrinfo.answer;
				$scope.other_answer = $scope.lndrinfo.other_answer;
				$scope.childfname = $scope.lndrinfo.childfname;
				$scope.childmname = $scope.lndrinfo.childmname;
				$scope.childlname = $scope.lndrinfo.childlname;
				$scope.student_class = $scope.lndrinfo.student_class;
				$scope.student_section = $scope.lndrinfo.student_section;
				$scope.teacheremail = $scope.lndrinfo.teacheremail;
				$scope.teacherfname = $scope.lndrinfo.teacherfname;
				$scope.teacherlname = $scope.lndrinfo.teacherlname;
				$scope.category_Name = $scope.lndrinfo.category_Name;
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
	$scope.getLearningDevelopmentReportDetails();
}
function getAllMessageCtrl($scope, $http, $routeParams, $timeout, $window) 
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
	$scope.getAllMessageForSchool = function()
	{
		$scope.messageList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllMessageForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.messageList = response.data.data;
				//console.log($scope.messageList); return false;
				
				var encrypted ;
				for(var i = 0; i < $scope.messageList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.messageList[i].last_message.id);
					$scope.messageList[i]['messageID'] = encrypted;
				}
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
	$scope.getAllMessageForSchool();
}
function allMessageCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.previewImages= [];
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
	
	$scope.composemessage = function(message, user1, user2){
		if(message == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please Type A Message First.'
				});
				return false;
			}();
			return false;
		}
		
		if(user1 == 'SA-'+School_ID)
		{
			$scope.user = user2;
		}
		else
		{
			$scope.user = user1;
		}
		var formData = new FormData();
		formData.append('user', $scope.user);
		formData.append('message', message);
		formData.append('schoolId', School_ID);
		
		for (var i = 0; i < $scope.previewImages.length; i += 1) {
			var x=$scope.previewImages[i];
			formData.append("pic"+i, $scope.previewImages[i]);
		}
		
		$http.post(BASE_URL+'api/user/addMessage',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Message send successfully.'
				});
				$window.location.href = '#!/message-list';
				return false;
			}();
			
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
	};
	
	var sid;
	$scope.msgID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.msgID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.msgID;
	};	
	$timeout($scope.setID(), 2000);
	//alert($scope.msgID); return false;
	$scope.msgInfo = false;
	$scope.getGroupConversationDetails = function()
	{
		var formData = {'id':$scope.msgID}
		$http.post(BASE_URL+'api/user/getGroupConversationDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.msgInfo 	= response.data.data;
				$scope.schoolID = 'SA-'+School_ID;
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
	$scope.getGroupConversationDetails();
}
function addMessageCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
	$scope.usertype 	= '0';
	$scope.user 		= '0';
	$scope.message 		= '';
	$scope.pic 			= '';
	$scope.previewData 	= [];
	$scope.previewImages= [];
	$scope.userData = false;
	
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
	$scope.setting1 = {
		scrollableHeight: '200px',
		scrollable: true,
		enableSearch: true,
		displayProp: 'name'
	};
	$scope.user=[];
	$scope.getAllUser = function(usertype){
		$scope.user=[];
		var formData = new FormData();
		formData.append('user_type', usertype);
		formData.append('school_id', School_ID);
		$http.post(BASE_URL+'api/user/getAllUserForMessage',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.userList = response.data.data;
				if($scope.userList)
				{
				for(var i = 0; i < $scope.userList.length; i++)
				{ 
					$scope.userList[i]['name']=$scope.userList[i]['fname']+' '+$scope.userList[i]['lname'];
				}
				}
			}
			
			}, function errorCallback(error){
				$scope.userList=[];
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
	
	$scope.discarddetails = function(){
		$scope.usertype 	= '0';
		$scope.user 		= '0';
		$scope.message 		= '';
		$scope.pic 			= '';
		$scope.previewData 	= [];
		$scope.previewImages= [];
		$scope.userData = false;
	}
	
	$scope.composemessage = function(files){
		if($scope.user.length == 0 || $scope.message == '')
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
		formData.append('user', JSON.stringify($scope.user));
		formData.append('message', $scope.message);
		formData.append('schoolId', School_ID);
		
		if($scope.user.length > 0)
		{
			for(var i = 0; i < $scope.user.length; i++)
			{ 
				console.log($scope.user[i].id);
				formData.append('receiver_id[]', $scope.user[i].id);
			}
		}
		
		if($scope.previewImages.length > 0)
		{
			for(var i = 0; i < $scope.previewImages.length; i++)
			{ 
				formData.append('files[]', $scope.previewImages[i]);
			}
		}
		//console.log(formData);
		//return;
		$http.post(BASE_URL+'api/user/sendMessage',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			var result  = response.data;
			//console.log(result);
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Message send successfully.'
				});
				$window.location.href = '#!/messages-list';
				return false;
			}();
			
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
	};
}
function getAllTermCtrl($scope, $http, $routeParams, $timeout,$window) 
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
	
	$scope.getAllTermForSchool = function()
	{
		$scope.termList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllTermForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.termList = response.data.data;
				var formattedstart;
				for(var i = 0; i < $scope.termList.length; i++)
				{
					formattedstart = $scope.convertDateFormat($scope.termList[i].termstart);
					$scope.termList[i]['formattedstart'] = formattedstart;
				}
				var formattedend;
				for(var i = 0; i < $scope.termList.length; i++)
				{
					formattedend = $scope.convertDateFormat($scope.termList[i].termend);
					$scope.termList[i]['formattedend'] = formattedend;
				}
				
				var encrypted ;
				for(var i = 0; i < $scope.termList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.termList[i].id);
					$scope.termList[i]['termID'] = encrypted;
				}
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
	$scope.getAllTermForSchool();
	$scope.convertDateFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [day, mnth, date.getFullYear()].join("-");
	}
	
	$scope.termDisabled = function(termID, status)
	{
		var formData1 = {'id':termID, 'status':status};
		$http.post(BASE_URL+'api/user/termDisabled',formData1,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
							text: 'Term Status Disabled Now.'
						});
					}else if(status == 1)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'Term Status Enabled Now.'
						});
					}
					
					$scope.getAllTermForSchool();
					return false;
				}();
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
}
function addTermCtrl($scope, $http, $routeParams, $timeout,$window) 
{

	$scope.sessionListData=[];
	$scope.getAllSessionForSchool = function()
	{
		$scope.sessionList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllSessionForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.sessionList = response.data.data;
				for(var i=0; i < $scope.sessionList.length; i++){
					//console.log($scope.sessionList[i]['current_sesion']);
					if($scope.sessionList[i]['current_sesion']==1){
						$scope.sessionListData.push(
							{
								id:$scope.sessionList[i]['id'],
								current_sesion:$scope.sessionList[i]['current_sesion'],
								sessionstart:$scope.sessionList[i]['sessionstart'],
								sessionend:$scope.sessionList[i]['sessionend'],
								academicsession:$scope.sessionList[i]['academicsession']
							}
							);
					}
				}
			}
			if(  ($scope.sessionList.length) < 10 ){
						$scope.pageSize = $scope.sessionListData.length;
						$scope.currentPage=1;
						$scope.itemsPerPage=1;
				}else
				{
						$scope.pageSize = 10;
						$scope.currentPage=1;
						$scope.itemsPerPage=1;
				}
			
			}, function errorCallback(error){
				$scope.sessionListData=[];
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
	$scope.getAllSessionForSchool();
	$("#termstart").prop('disabled', true);
	$("#termend").prop('disabled', true);
	$scope.gettermdaterange = function(session)
    {   
		
		if(session[0].id!=''){
		$("#termstart").prop('disabled', false);
		$("#termend").prop('disabled', false);
		$("#termstart").val(session[0].sessionstart);
		$("#termend").val(session[0].sessionend);  
		$('#termstart').attr("min",session[0].sessionstart);
		$('#termstart').attr("max",session[0].sessionend); 
		$('#termend').attr("min",session[0].sessionstart);
		$('#termend').attr("max",session[0].sessionend); 
		}
		else {
		$("#termstart").prop('disabled', false);
		$("#termend").prop('disabled', false);
		}

     }
	$scope.convertedDateForTerm = function(str)
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
	
	$scope.term 	= '';
	$scope.academicsession 	= '0';
	$scope.termstart 	= '';
	$scope.termend 		= '';
	$scope.termstart 	= '';
	$scope.termend 		= '';
	
	$scope.addTerm = function(){
		if($scope.term == '' || $scope.academicsession == '0' || ($scope.termstart == '' || $scope.termstart == null ) || ($scope.termend == '' || $scope.termend == null))
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
		
		if(new Date($scope.termstart) >= new Date($scope.termend))
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Term End Date Must Be Greater Than Term Start Date.'
				});
				return false;
			}();
			return false;
		}
		
		$scope.formattedtermstart = $scope.convertedDateForTerm($scope.termstart);
		$scope.formattedtermend = $scope.convertedDateForTerm($scope.termend);
		
		var formData = new FormData();
		formData.append('term', $scope.term);
		formData.append('academicsession', $scope.academicsession);
		formData.append('termstart', $scope.convertDateNewFormat($scope.termstart));
		formData.append('termend', $scope.convertDateNewFormat($scope.termend));
		formData.append('formattedtermstart', $scope.formattedtermstart);
		formData.append('formattedtermend', $scope.formattedtermend);
		formData.append('schoolId', School_ID);
		
		$http.post(BASE_URL+'api/user/addTerm',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Term added successfully.'
				});
				$window.location.href = '#!/term-list';
				return false;
			}();
			
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
	};
}
function editTermCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
	$scope.convertDateNewFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [date.getFullYear(), mnth, day].join("-");
	}
	
	$scope.getAllSessionForSchool = function()
	{
		$scope.sessionList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllSessionForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.sessionList = response.data.data;
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
	$scope.getAllSessionForSchool();
	
	var sid;
	$scope.termID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.termID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.termID;
	};	
	$timeout($scope.setID(), 2000);
	//alert($scope.termID); return false;
	$scope.convertedDateForTerm = function(str)
	{
		var date = new Date(str),
		month = date.toLocaleString('default', { month: 'short' });
		return [date.getFullYear(),month].join(" ");
		
	}
	
	$scope.terminfo = false;
	$scope.getTermDetails = function()
	{
		var formData = {'id':$scope.termID}
		$http.post(BASE_URL+'api/user/getTermDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.terminfo = response.data.data;
				$scope.term  = $scope.terminfo.termname;
				$scope.academicsession  = $scope.terminfo.academicsession;
				$scope.termstart 	= new Date($scope.terminfo.termstart);
				$scope.termend 		= new Date($scope.terminfo.termend);
				$scope.schoolName 		= $scope.terminfo.school_name;
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
	$scope.getTermDetails();
	$scope.editTerm = function(){
		
		if($scope.term == '' || $scope.academicsession == '0' || $scope.termstart == '' || $scope.termend == ''|| $scope.termstart == null || $scope.termend == null)
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
		
		if(new Date($scope.termstart) >= new Date($scope.termend))
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Term End Date Must Be Greater Than Term Start Date.'
				});
				return false;
			}();
			return false;
		}
		
		$scope.formattedtermstart = $scope.convertedDateForTerm($scope.termstart);
		$scope.formattedtermend = $scope.convertedDateForTerm($scope.termend);
		
		var formData = new FormData();
		formData.append('id', $scope.termID);
		formData.append('term', $scope.term);
		formData.append('academicsession', $scope.academicsession);
		formData.append('termstart', $scope.convertDateNewFormat($scope.termstart));
		formData.append('termend', $scope.convertDateNewFormat($scope.termend));
		formData.append('formattedtermstart', $scope.formattedtermstart);
		formData.append('formattedtermend', $scope.formattedtermend);
		formData.append('schoolId', School_ID);
		
		$http.post(BASE_URL+'api/user/editTerm',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Term Updated successfully.'
				});
				$window.location.href = '#!/term-list';
				return false;
			}();
			
			}, function errorCallback(error){
			
			var errresult = error.data.message
			$scope.getTermDetails();
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
	};
}
function getAllStudentReportCtrl($scope, $http, $routeParams, $timeout,$window) 
{
	$scope.getAllClassForSchool = function()
	{
		$scope.classList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllClassForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.classList = response.data.data;
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
	$scope.getAllClassForSchool();
	
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

	$scope.classId = '0';
	$scope.getAllStudentForClass = function(classid)
	{
		$scope.studentList = false;
		var formData = {'id':classid};
		$http.post(BASE_URL+'api/user/getAllStudentForClass',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.studentList = response.data.data;
				// console.log($scope.studentList);
				// return false
				if(  ($scope.studentList.length) < 10 ){
						$scope.pageSize = $scope.studentList.length;
						$scope.currentPage=1;
						$scope.itemsPerPage=1;
				}else
				{
						$scope.pageSize = 10;
						$scope.currentPage=1;
						$scope.itemsPerPage=1;
				}
				var encrypted ;
				for(var i = 0; i < $scope.studentList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.studentList[i].id);
					$scope.studentList[i]['studentID'] = encrypted;
				}
				// console.log($scope.pageSize);
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
}
function allReportCtrl($scope, $http, $routeParams, $timeout,$window) 
{
        $scope.pageSize = 10;
	$scope.reporttype = 'daily';
        $scope.dailyreport = false;
	$scope.monthlyreport = false;
        $scope.reports = [];
        $scope.monthReports = false;
        $scope.Details = '';
        $scope.terms = '';
        $scope.yearList = '';
        $scope.termReports='';
        $scope.monthtly_month ='';
        $scope.monthtly_year = '';
        $scope.term='';
        
	var sid;
        var responseData = [];
	$scope.studentID = '';
        
        $(".tab").click(function () {
        $(".tab").removeClass("active");
        $(this).addClass("active");   
        });
        
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.studentID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.studentID;
	};	
        
        $scope.getYear =  function () {
        var max_year = new Date().getFullYear()
        var min_year = max_year - 9
        var years_list = [];
        for (var i = max_year; i >= min_year; i--) {
        years_list.push(i)
        }
        $scope.yearList = years_list;
        }
        
        
         
       $timeout($scope.setID(), 2000);
       $scope.getYear();
       console.log($scope.yearList);
        
       $scope.monthName=[{"val":"01","name":"January"},{"val":"02","name":"February"},{"val":"03","name":"March"},{"val":"04","name":"April"},{"val":"05","name":"May"},{"val":"06","name":"June"},{"val":"07","name":"July"},{"val":"08","name":"August"},{"val":"09","name":"September"},{"val":"10","name":"October"},{"val":"11","name":"November"},{"val":"12","name":"December"}];
        
        var requestType = ["Moods", "ClassParticipation", "Learning","Meals","Activities","Naps","Request For Tomorrow","Comment"];
        //// Get Daily Reports //////////////////////////////
        $scope.getDailyReports =  function () {
        var formData = {'studentId':sid,'School_ID':School_ID,'reportDate':$scope.termDate}
        $http.post(BASE_URL + 'api/user/getDailyReport', formData, {
            headers: {
                'Content-Type': undefined, 'x-api-key': xapikey, 'TOKEN': localStorage.getItem("TOKEN")
            }
        }).then(function (response) {

            if (response.status == 200)
            {
               //$scope.reports = response.data.data;
              var retData = response.data.data;
              var retDataLength = retData.length; 
              if(retDataLength>0){
                
                var k = 0;
                for( var i=0;i<requestType.length;i++)
                {
                    for( var d=0;d<retData.length;d++)
                    { 
                      if(requestType[i]==retData[d].report_type){
                      $scope.reports[k] = retData[d];
                      k++;
                      break; 
                    }
                 }
              }
              }
              else {
                $scope.reports = [];
              }

               console.log($scope.reports);
              
            }
            return false
        })
        }
        //// End Get Daily Reports //////////////////////////////
        
       
        
        //// Report By Month Reports //////////////////////////////
        $scope.getReportByMonth = function(){
        
        if($scope.monthtly_month == '' || $scope.monthtly_year =='' )
	{
			var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: 'please Select month and year'
				});
				return false;
			}();
             return false;           
	}    
            
            
        var formData = {'studentId':sid,'School_ID':School_ID,'reportMonth':$scope.monthtly_month,'reportYear':$scope.monthtly_year}
        $http.post(BASE_URL + 'api/user/getMonthlyReport', formData, {
            headers: {
                'Content-Type': undefined, 'x-api-key': xapikey, 'TOKEN': localStorage.getItem("TOKEN")
            }
        }).then(function (response) {

            if (response.status == 200)
            {
               $scope.monthReports = response.data.data;
               console.log($scope.monthReports);
            }
            return false
        })
        }    
        //// End ReportBy Month Reports ////////////////////////////// 
        
        
        //// Report By Term  //////////////////////////////
        $scope.getReportTerms = function(){
        
        if($scope.term == '' )
	{
			var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: 'please Select Term'
				});
				return false;
			}();
            return false;               
	}    
            
            
        var formData = {'studentId':sid,'School_ID':School_ID,'term':$scope.term}
        $http.post(BASE_URL + 'api/user/getTermReport', formData, {
            headers: {
                'Content-Type': undefined, 'x-api-key': xapikey, 'TOKEN': localStorage.getItem("TOKEN")
            }
        }).then(function (response) {

            if (response.status == 200)
            {
               $scope.termReports = response.data.data;
               //console.log($scope.monthReports);
            }
            return false
        })
        }    
        //// End Report By Term  ////////////////////////////// 
            
            
        $scope.getAllTerms =   function () {
         var responeArray = [];
           var formData = {'School_ID':School_ID}
		  $http.post(BASE_URL+'api/user/getAllTerms',formData,{
	                headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
                            
                            if (response.status == 200){
                             $scope.terms = response.data.data;
                            }
                         return false;
                        
                       });      
             
        } 
       
        
	$scope.getAllReportDetailsForUser = function()
	{
		var formData = {'id':$scope.studentID}
		$http.post(BASE_URL+'api/user/getAllReportDetailsForUser',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.dailyreport 	= response.data.data;
				$scope.monthlyreport	= response.data.data1;
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
        
        $scope.checkData=[];
        $scope.getCheckTime =   function () {
           var formData = {'school_ID':School_ID,'studentID':sid}
		  $http.post(BASE_URL+'api/user/getCheckTime',formData,{
	                headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
                            
                            if (response.status == 200){
                             $scope.checkData = response.data.data;
                             console.log($scope.checkData);
                             
                            }
                         return false;
                        
                       });      
             
        } 
        
	//$scope.getAllReportDetailsForUser();
	$scope.getAllTerms();
        $scope.getCheckTime();
	$scope.getreporttype = function(reporttype)
	{
		$scope.reporttype = reporttype;
	}
}
function getAllThoughtofthedayCtrl($scope, $http, $routeParams, $timeout, $window,$location) 
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
	
	$scope.getAllThoughtOfTheDayForSchool = function()
	{
		
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllThoughtOfTheDayForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.thoughtList = response.data.data;
				var formattedDate;
				for(var i = 0; i < $scope.thoughtList.length; i++)
				{
					formattedDate = $scope.convertDateFormat($scope.thoughtList[i].created_date);
					$scope.thoughtList[i]['formattedDate'] = formattedDate;
				}
				
				var encrypted ;
				for(var i = 0; i < $scope.thoughtList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.thoughtList[i].id);
					$scope.thoughtList[i]['thoughtID'] = encrypted;
				}
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
	$scope.getAllThoughtOfTheDayForSchool();
	
	$scope.convertDateFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [day, mnth, date.getFullYear()].join("-");
	}
	
	/* $scope.eventDelete = function(eventID)
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
		'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
	} */
}
function addThoughtofthedayCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	$scope.title 	  	= '';
	$scope.description 	= "";
	$scope.author 		= '';
	
	$scope.addThoughtoftheday = function(){		
		if($scope.description == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill required field(Indicating With * Sign).'
				});
				return false;
			}();
			return false;
		}
		var formData = new FormData();
		formData.append('title', $scope.title);
		formData.append('description', $scope.description);
		formData.append('author', $scope.author);
		formData.append('schoolId', School_ID);
		
		$http.post(BASE_URL+'api/user/addThoughtoftheday',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Thoughts Of The Day added successfully.'
				});
				$window.location.href = '#!/thoughtoftheday-list';
				return false;
			}();
			
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
	};
}
function editThoughtofthedayCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
	var sid;
	$scope.thoughtID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.thoughtID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.thoughtID;
	};	
	$timeout($scope.setID(), 2000);
	//alert($scope.thoughtID); return false;
	
	$scope.thoughtinfo = false;
	$scope.getThoughtOfTheDayDetails = function()
	{
		var formData = {'id':$scope.thoughtID}
		$http.post(BASE_URL+'api/user/getThoughtOfTheDayDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.thoughtinfo 	= response.data.data;
				$scope.title 		= $scope.thoughtinfo.title;
				$scope.description 	= $scope.thoughtinfo.description;
				$scope.author 		= $scope.thoughtinfo.author_name;
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
	$scope.getThoughtOfTheDayDetails();
	
	$scope.editThoughtoftheday = function(){
		
		if($scope.description == '')
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill required field(Indicating With * Sign).'
				});
				return false;
			}();
			return false;
		}
		var formData = new FormData();
		formData.append('id', $scope.thoughtID);
		formData.append('title', $scope.title);
		formData.append('description', $scope.description);
		formData.append('author', $scope.author);
		formData.append('schoolId', School_ID);
		
		$http.post(BASE_URL+'api/user/editThoughtOfTheDay',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: 'Thought Of The Day Updated successfully.'
				});
				$window.location.href = '#!/thoughtoftheday-list';
				return false;
			}();
			
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
	};
}
function newStudentCtrl($scope, $http, $routeParams, $timeout, $compile, $window,$location) 
{	
	$scope.succImport='';
	if($location.search().success){
		$scope.succImport = $location.search().success;
	}else{
	$scope.succImport='';	
	}
	var sid='';
	$scope.class_ID = '';
	if($routeParams.ID){
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.class_ID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.class_ID;
	};
	$timeout($scope.setID(), 2000); 
	}
	$scope.classList = [];
	$scope.getClasses = function(){
		$http.post(BASE_URL+'api/user/getAllClassForSchool',{id:School_ID},{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			$scope.classList = response.data.data;
			// $scope.classID = $scope.classList[0].id;
			// console.log($scope.classID);			
			}, function errorCallback(response){
		});
	};
	$scope.getClasses();

	// Student Enabled/Disabled
	$scope.studentDisabled = function(childID, status)
	{
		// alert(childID+":"+status);
		var formData1 = {'id':childID, 'status':status};
		$http.post(BASE_URL+'api/students/childDisabled',formData1,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
							text: 'Student Status Disabled Now.'
						});
					}else if(status == 1)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'Student Status Enabled Now.'
						});
					}
					$scope.getstudentsList();
					return false;
				}();
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

	$scope.studentData = [];
	$scope.getStudentsByclassID = function(classID){
		
		var formData = {'id':School_ID,classID:classID}
		$http.post(BASE_URL+'api/students/getStudentsList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.studentData = response.data.data;

				if(  ($scope.studentData.length) < 10 ){
						$scope.pageSize = $scope.studentData.length;
						$scope.currentPage=1;
						$scope.itemsPerPage=1;
				}else
				{
						$scope.pageSize = 10;
						$scope.currentPage=1;
						$scope.itemsPerPage=1;
				}

				for(var i =0; i < $scope.studentData.length; i++)
	            {
	                $scope.studentData[i]['student_id'] = $scope.studentData[i].childID;
	                $scope.studentData[i]['childID'] = $scope.encryptStr($scope.studentData[i].childID);
	    		}
				// console.log($scope.studentData);
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

	};
	if(sid!=''){
	$scope.getStudentsByclassID(sid);
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
	$scope.studentData = [];
	$scope.getstudentsList = function()
	{
		var formData = {'id':School_ID}
		$http.post(BASE_URL+'api/students/getStudentsList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.studentData = response.data.data;
				for(var i =0; i < $scope.studentData.length; i++)
	            {
	                $scope.studentData[i]['student_id'] = $scope.studentData[i].childID;
	                $scope.studentData[i]['childID'] = $scope.encryptStr($scope.studentData[i].childID);
	    		}
				// console.log($scope.studentData);
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
	if(sid==''){
	$scope.getstudentsList();
	}
	$scope.sort = function(keyname){
		$scope.sortKey = keyname;
		$scope.reverse = !$scope.reverse;
	}
	$scope.fileExt='';
	$scope.onChange = function (files) {
		if(files[0] == undefined) return;
		$scope.fileExt = files[0].name.split(".").pop();
	}
	$scope.ImportCsvData=function(){
		if($scope.fileExt!='csv'){
			alert('Only csv file allowed.');
			return false;
		}
		var formData = new FormData();
		formData.append('schoolId', School_ID);
		var file = document.getElementById('pic').files[0];
		formData.append('pic',file);
		$http.post(BASE_URL+'api/user/importStudentCsvData',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			var result  = response.data;
			var Gritter = function () {
				$.gritter.add({
					title: 'Successfull',
					text: response.data.message
				});
				$("#csvModal").modal("hide");
                                ///console.log('Parent added successfully');
				$window.location.href = '#!/student-list';
				return false;
			}();
			
            }, function errorCallback(error){
				$("#csvModal").modal("hide");
			var errresult = error.data.data
			//console.log(response);
			if(errresult == 0)
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Failed',
						text: error.data.message
					});
					
					return false;
				}();
			}
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
}
function schoolFAQCtrl($scope, $http, $timeout,$window) 
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

	$scope.faqData = [];
	$scope.getFAQList = function()
	{
		var formData = {'id':School_ID}
		$http.post(BASE_URL+'api/user/getFAQList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.faqData = response.data.data;
				for(var i =0; i < $scope.faqData.length; i++)
	            {
	                $scope.faqData[i]['faq_id'] = $scope.faqData[i].id;
	                $scope.faqData[i]['id'] = $scope.encryptStr($scope.faqData[i].id);
	    		}
				// console.log($scope.faqData);
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getFAQList();

	// Delete a FAQ
	$scope.faqDelete = function(id)
	{
		var deleteMedia = window.confirm('Are you sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':id}
			$http.post(BASE_URL+'api/user/deleteFAQ',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
				
				if(response.status == 200)
				{
					//$scope.faqData = response.data.data;
					var Gritter = function () {
						$.gritter.add({
							title: 'Failed',
							text: 'Question has been deleted successfully.'
						});
						$scope.getFAQList();
						$window.location.href = '#!/school-faq';

						}();
					// console.log($scope.faqData);
				}
				
				}, function errorCallback(response){
				
			});
		}
	};

		// Modal Open to Edit FAQs
	$scope.faqEdit =  { id:"",question:"",answer:"",user_type:"" };
 	$scope.faqEdit = function (faq){
 		// return false
 		// console.log(faq); 
 		$scope.faqEdit = { faq_id:faq.faq_id,question:faq.question,answer:faq.answer };
 		// console.log($scope.faqEdit); 
 	    	$("#myModal").modal("show");
	 }

	 // Get Updated data from Modal
	$scope.updateFAQs = function(){
		$scope.faqEdit.school_id=School_ID;
		  // console.log($scope.faqEdit); return false
		$http.post(BASE_URL+'api/user/updateFAQs',$scope.faqEdit,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			$scope.response = response.data.data;
			if($scope.response == 1)
			{
					$("#myModal").modal("hide");
					var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: 'Question has been updated successfully.'
					});
					$scope.getFAQList();
					$window.location.href = '#!/school-faq';
					}();
			}
			// console.log($scope.response);		
			}, function errorCallback(response){
		});
	};
	 // Add New FAQs data 
	$scope.addFaq = function(){
		  var formData = {'question':$scope.question,'answer':$scope.answer,school_id:School_ID};
		  // console.log(formData); return false
		$http.post(BASE_URL+'api/user/addFAQs',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			$scope.response = response.data.data;
			if($scope.response == 1)
			{
					var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: 'FAQ question has been save successfully.'
					});
					$scope.getFAQList();
					$window.location.href = '#!/school-faq';
					}();
			}
			// console.log($scope.response);		
			}, function errorCallback(response){
		});
	};
}

function examCtrl($scope,$http,$timeout,$window){
	// Get Class List
	$scope.getAllClassForSchool = function()
	{
		$scope.classList = [];
		$scope.ob={'class':''};
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllClassForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.classList = response.data.data;
				// $scope.ob.class = $scope.classList[0].id;
			}
			// console.log($scope.classList);		
			}, function errorCallback(response){
			
		});
	}
	$scope.getAllClassForSchool();

	$scope.getCurrentSession = function()
	{
		$scope.currentSession = [];
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/exam/getCurrentSession',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.currentSession 	= response.data.data;
				$scope.academicsession 	= $scope.currentSession.academicsession;
				$scope.sessionstart 	= new Date($scope.currentSession.sessionstart);
				$scope.sessionstart		= $scope.sessionstart.getFullYear();
				$scope.sessionend 		= new Date($scope.currentSession.sessionend);
				$scope.sessionend    	= $scope.sessionend.getFullYear();
				// $scope.ob.class = $scope.classList[0].id;
			}
			// console.log($scope.currentSession);		
			}, function errorCallback(response){
			
		});
	}
	$scope.getCurrentSession();

	// Get Exam Schedule List Data
	$scope.getExamList = function()
	{
		$scope.examList = [];
		var formData = {'school_id':School_ID};
		$http.post(BASE_URL+'api/exam/examList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				$scope.examList = response.data.data;
				for(var i =0; i < $scope.examList.length; i++)
	            {
	                $scope.examList[i]['exam_id']   = $scope.examList[i].id;
	                $scope.examList[i]['exam_last_datetime']   = $scope.examList[i].last_submission_date+" "+$scope.examList[i].exam_time;
	                
	                   var today = new Date();
	                   let todayDate = today.getDate();
	                   let currentMinute = today.getMinutes();
	                   todayDate = (todayDate > 9) ? todayDate : '0'+todayDate;
                       let thisMonth = ((today.getMonth()+1) > 9) ? (today.getMonth()+1) : '0'+(today.getMonth()+1);
	                   currentMinute = (currentMinute > 9) ? currentMinute : '0'+currentMinute;
	                   var date = today.getFullYear()+'-'+(thisMonth)+'-'+todayDate; 
					   var time = today.getHours() + ":" + currentMinute + ":" + today.getSeconds(); 
					$scope.examList[i]['current_datetime']   = date+' '+time;
	                $scope.examList[i]['id'] 		= $scope.encryptStr($scope.examList[i].id);
	    		}
				if(  ($scope.examList.length) < 10 ){
					$scope.pageSize = $scope.examList.length;
					$scope.currentPage=1;
					$scope.itemsPerPage=1;
				}else
				{
					$scope.pageSize = 10;
					$scope.currentPage=1;
					$scope.itemsPerPage=1;
				}
			}
			// console.log($scope.examList);		
			}, function errorCallback(response){
			
		});
	}
	$scope.getExamList();

	// unlock exam process block
	$scope.unlockData ={school_id:"",exam_id:"",subject_id:"",class_id:"",user_id:"",name:"" };
 	$scope.unlockExam = function (data){
 		$scope.unlockData = {school_id:data.school_id,exam_id:data.exam_id,subject_id:data.subject_id,class_id:data.class_id,user_id:data.user_id,name:data.name };
 			
 		var formData = {'school_id':data.school_id};
		$scope.studentList=[];
		$http.post(BASE_URL+'api/exam/getStudentsBySchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			// console.log(response);	
			if(response.status == 200)
			{
				 $scope.studentList = response.data.data;
			}
					
			}, function errorCallback(response){
		});
 	
 		$("#myModal").modal("show");
	}

	// Get Modal Data all the unlock users for save
	$scope.unlockExamForUsers = function(){
		$http.post(BASE_URL+'api/exam/unlockExamRequest',$scope.unlockData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
				$scope.response = response.data.data;
				if($scope.response > 0)
				{
					    $("#myModal").modal("hide");
						var Gritter = function () {
						$.gritter.add({
							title: 'Successfull',
							text: 'Exam has been unlocked for selected users has been approved successfully.'
						});
						}();
				}
				$window.location.href = '#!/exam';
					
			}, function errorCallback(response){
		});
	}
	// Get subject List
	$scope.SubjectList = [];
	$scope.ob={'subject':''};
	$scope.getSubjects = function(class_id){
	var formData = {'school_id':School_ID,class_id:class_id};
		$http.post(BASE_URL+'api/exam/getAllSubjectForClass',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			// console.log(response);	
			if(response.status == 200)
			{
				 $scope.SubjectList = response.data.data;
				
			}
			// console.log($scope.SubjectList);	
					
			}, function errorCallback(response){
		});
	};
	// Insert Exam Schedule
	$scope.name     			= '';
	$scope.ob.class 			= '';
	$scope.ob.subject 			= '';
	$scope.exam_date 			= '';
	$scope.exam_duration		= '';
	$scope.exam_time			= '';
	$scope.exam_instruction 	= '';
	$scope.total_question	 	= '';
	$scope.total_marks		 	= '';
	// $scope.exam_code		 	= '';
	$scope.last_submission_date = '';
	$scope.exam_attempt_no		= '';
	$scope.exam_mode			= '';
	$scope.session 				= '';
	$scope.exam_type			= '';
	$scope.exam_category		= '';
	$scope.addExam = function()
	{

		if($scope.exam_duration > 200 ){
			var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: `You entered minutes exceed the exam time limit. Please Try Again !!`
				});
				return false;
			}();
		}else if($scope.name == '' || $scope.exam_time ==''  || $scope.last_submission_date == ''|| $scope.exam_attempt_no == ''  || $scope.ob.class == ''  || $scope.exam_date == '' || $scope.exam_duration == ''  || $scope.exam_instruction == '' || $scope.ob.subject == '' || $scope.session =='' || $scope.exam_mode =='' || $scope.exam_category == '' )
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: 'All mendatory (*) fields can`t be empty.'
				});
				return false;
			}();
		}else{
		$scope.timeFormat = function(datetime)
		{
			// let d = new Date(datetime);
			// let pm = d.getHours() >= 12;
			// let hour12 = d.getHours() % 12;
			// if (!hour12) 
			//   hour12 += 12;
			// let minute = d.getMinutes();
			// return (`${hour12}:${minute} ${pm ? 'PM' : 'AM'}`);
			return datetime.toLocaleTimeString('en-GB');
		};
		$scope.dateFormat = function(datetime)
		{
			var d  		= new Date(datetime);
			var month 	= d.getMonth();
			month = month+1;
			var date= d.getFullYear()+'-'+month+'-'+d.getDate();
			return date;
		};

	 	var formData = {school_id:School_ID,name:$scope.name,class_id:$scope.ob.class,subject_id:$scope.ob.subject,exam_date:$scope.dateFormat($scope.exam_date),last_submission_date:$scope.dateFormat($scope.last_submission_date),exam_time:$scope.timeFormat($scope.exam_time),exam_duration:$scope.exam_duration,instruction:$scope.exam_instruction,total_question:$scope.total_question,total_marks:$scope.total_marks,exam_attempt_no:$scope.exam_attempt_no,exam_mode:$scope.exam_mode,session:$scope.session,exam_type:$scope.exam_type,exam_category:$scope.exam_category};
		 // console.log(formData); 
			$http.post(BASE_URL+'api/exam',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {

				$scope.response = response.data.data;
				// console.log(response);
				// return false
					// if( parseInt($scope.response) > 0 'exist')
					if( parseInt($scope.response) > 0 )
					{
						var Gritter = function () {
						$.gritter.add({
							title: 'Successfull',
							text: 'Online assessment has been created successfully.'
						});
						}();
						$window.location.href = '#!/exam';
					
					}else{

						var Gritter = function () {
								$.gritter.add({
									title: 'failed',
									text: response.data.message
								});
							}();
						
					}
			
				}, function errorCallback(response){

					
				});
		}
	};

	// Delete Online Exam Schedule
	$scope.examDelete = function(exam_id)
	{
			$http.post(BASE_URL+'api/exam/deleteExam',{id:exam_id},{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
				$scope.response = response.data.data;
				if($scope.response == 1 )
				{
						var Gritter = function () {
						$.gritter.add({
							title: 'Success',
							text: 'Exam Schedule has been deleted successfully.'
						});
						$scope.getExamList();
						$window.location.href = '#!/exam';
						}();
				}
				// console.log($scope.response);		
				}, function errorCallback(response){
			});
	}
}
function editExamCtrl($scope,$http,$window,$routeParams,$timeout)
{
	var examID;
	$scope.id = "";
	 $scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.id = decrypted.toString(CryptoJS.enc.Utf8);
		examID = $scope.id;
	};
    $timeout($scope.setID(), 200);
   // alert($scope.id);

   // Get Exam Schedule List Data
	$scope.examDetail = [];
	$scope.ob={'class':''};
	$scope.ob={'subject':''};
	$scope.getExamDetails = function()
	{
		var formData = {'id':examID};
		$http.post(BASE_URL+'api/exam/examDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.examDetail 		= response.data.data;
				$scope.name 			= $scope.examDetail.name;
				$scope.school_id		= $scope.examDetail.school_id;
				$scope.school_name		= $scope.examDetail.school_name;
				$scope.ob.subject 		= $scope.examDetail.SubjectList;
				$scope.subjectName 		= $scope.ob.subject.subject;
				$scope.class 			= $scope.examDetail.class;
				$scope.section 			= $scope.examDetail.section;
				$scope.ob.class 		= $scope.examDetail.class_id;
				$scope.total_question	= $scope.examDetail.total_question;
				$scope.total_marks		= $scope.examDetail.total_marks;
				$scope.exam_instruction	= $scope.examDetail.exam_instruction;
				$scope.exam_attempt_no	= $scope.examDetail.exam_attempt_no;
				$scope.exam_mode		= $scope.examDetail.exam_mode;
				$scope.exam_type		= $scope.examDetail.exam_type;
				$scope.exam_category	= $scope.examDetail.exam_category;
				$scope.session 			= $scope.examDetail.session;
				$scope.exam_duration	= $scope.examDetail.exam_duration;
				$scope.exam_time		= new Date (new Date().toDateString() + ' ' + $scope.examDetail.exam_time);
				$scope.exam_time_format	= $scope.examDetail.exam_time;
				$scope.exam_date_format	= $scope.examDetail.exam_date;
				$scope.exam_date		= new Date ($scope.examDetail.exam_date);
				$scope.last_submission_date		= new Date ($scope.examDetail.last_submission_date);
				$scope.last_submission_date_format		= $scope.examDetail.last_submission_date;
				$scope.created_at		= $scope.examDetail.created_at;
			}
			 // console.log($scope.examDetail);		
			}, function errorCallback(response){
			
		});
	}
	$scope.getExamDetails();

	// Save Update Exam Data
	$scope.editExam = function(){
		
		if($scope.name == '' || $scope.exam_time ==''  || $scope.last_submission_date == ''|| $scope.exam_attempt_no == ''  || $scope.ob.class == ''  || $scope.exam_date == '' || $scope.exam_duration == ''  || $scope.exam_instruction == '' || $scope.ob.subject == '' || $scope.exam_mode == '' || $scope.session == '' || $scope.exam_category == '' || $scope.exam_type == '' )
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: 'All mendatory (*) fields can`t be empty.'
				});
				return false;
			}();
		}
		$scope.timeFormat = function(datetime)
		{
			// let d = new Date(datetime);
			// let pm = d.getHours() >= 12;
			// let hour12 = d.getHours() % 12;
			// if (!hour12) 
			//   hour12 += 12;
			// let minute = d.getMinutes();
			// return (`${hour12}:${minute} ${pm ? 'PM' : 'AM'}`);
			return datetime.toLocaleTimeString('en-GB');
		};
		$scope.dateFormat = function(datetime)
		{
			var d  		= new Date(datetime);
			var month 	= d.getMonth();
			month = month+1;
			var date= d.getFullYear()+'-'+month+'-'+d.getDate();
			return date;
		};
		var formData = {'id':examID,'name':$scope.name,'exam_time':$scope.timeFormat($scope.exam_time),'class_id':$scope.ob.class,'subject_id':$scope.ob.subject,'last_submission_date':$scope.dateFormat($scope.last_submission_date),'exam_attempt_no':$scope.exam_attempt_no,'exam_date':$scope.dateFormat($scope.exam_date),'exam_duration':$scope.exam_duration,'exam_instruction':$scope.exam_instruction,'total_marks':$scope.total_marks,'total_question':$scope.total_question,exam_mode:$scope.exam_mode,session:$scope.session,exam_type:$scope.exam_type,exam_category:$scope.exam_category,'old_submission_date':$scope.last_submission_date_format,'school_id':$scope.school_id};
// console.log(formData);
// return false
		$http.post(BASE_URL+'api/exam/updateExam',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			$scope.response = response.data.data;
			if($scope.response == 1 )
			{
				var Gritter = function () {
						$.gritter.add({
							title: 'Success',
							text: 'Assessment has been updated successfully.'
						});
						$window.location.href = '#!/exam';
						}();	
			}else{
				var Gritter = function () {
						$.gritter.add({
							title: 'Success',
							text: 'Exam already updated.'
						});
						$window.location.href = '#!/exam';
						}();
			}

			}, function errorCallback(response){
			
			});
		// console.log(formData);
	}
    // Get Class List
	$scope.getAllClassForSchool = function()
	{
		$scope.classList = [];
		$scope.ob={'class':''};
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllClassForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.classList = response.data.data;
				// $scope.ob.class = $scope.classList[0].id;
			}
			// console.log($scope.classList);		
			}, function errorCallback(response){
			
		});
	}
	$scope.getAllClassForSchool();

	// Get subject List
	$scope.SubjectList = [];
	$scope.ob={'subject':''};
	$scope.getSubjects = function(class_id){
	var formData = {'school_id':School_ID,class_id:class_id};

		$http.post(BASE_URL+'api/exam/getAllSubjectForClass',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				 $scope.SubjectList = response.data.data;
			}
			// console.log($scope.SubjectList);	
			}, function errorCallback(response){
		});
	};
}
function editOfflineExamCtrl($scope,$http,$window,$routeParams,$timeout)
{
	var examID;
	$scope.id = "";
	 $scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.id = decrypted.toString(CryptoJS.enc.Utf8);
		examID = $scope.id;
	};
    $timeout($scope.setID(), 200);
   // alert($scope.id);
   // return false

   // Get Exam Schedule List Data
	$scope.examDetail = [];
	$scope.ob={'class':''};
	$scope.ob={'subject':''};
	$scope.getExamDetails = function()
	{
		var formData = {'id':examID};
		$http.post(BASE_URL+'api/exam/examDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.examDetail 		= response.data.data;
				$scope.name 			= $scope.examDetail.name;
				$scope.school_name		= $scope.examDetail.school_name;
				$scope.school_id		= $scope.examDetail.school_id;
				$scope.ob.subject 		= $scope.examDetail.SubjectList;
				$scope.subjectName 		= $scope.ob.subject.subject;
				$scope.class 			= $scope.examDetail.class;
				$scope.section 			= $scope.examDetail.section;
				$scope.ob.class 		= $scope.examDetail.class_id;
				$scope.total_question	= '';
				// $scope.total_question	= $scope.examDetail.total_question;
				$scope.total_marks		= $scope.examDetail.total_marks;
				$scope.exam_instruction	= $scope.examDetail.exam_instruction;
				$scope.exam_attempt_no	= '';
				// $scope.exam_attempt_no	= $scope.examDetail.exam_attempt_no;
				$scope.exam_mode		= $scope.examDetail.exam_mode;
				$scope.exam_type		= $scope.examDetail.exam_type;
				$scope.exam_category	= $scope.examDetail.exam_category;
				$scope.session 			= $scope.examDetail.session;
				$scope.exam_duration	= $scope.examDetail.exam_duration;
				$scope.marks_validity_days	= $scope.examDetail.marks_validity_days ? $scope.examDetail.marks_validity_days : 0;
				$scope.exam_time		= new Date (new Date().toDateString() + ' ' + $scope.examDetail.exam_time);
				$scope.exam_time_format	= $scope.examDetail.exam_time;
				$scope.exam_date_format	= $scope.examDetail.exam_date;
				$scope.exam_date		= new Date ($scope.examDetail.exam_date);
				$scope.last_submission_date		= new Date ($scope.examDetail.last_submission_date);
				$scope.last_submission_date_format		= $scope.examDetail.last_submission_date;
				$scope.created_at		= $scope.examDetail.created_at;

				// Validity extends days array
   				$scope.validityDays = [{'days':'30'},{'days':'45'},{'days':'60'},{'days':'75'}];
				$scope.offline_exam_type= 'offline';
			}
			 // console.log($scope.examDetail);		
			}, function errorCallback(response){
			
		});
	}
	$scope.getExamDetails();

	// Save Update Exam Data
	$scope.editOfflineExam = function(){
		
		if($scope.name == '' || $scope.exam_time ==''  || $scope.last_submission_date == ''||  $scope.ob.class == ''  || $scope.exam_date == '' || $scope.exam_duration == ''  || $scope.exam_instruction == '' || $scope.ob.subject == '' || $scope.exam_mode == '' || $scope.session == '' || $scope.exam_category == '' || $scope.exam_type == '' )
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: 'All mendatory (*) fields can`t be empty.'
				});
				return false;
			}();
		}
		$scope.timeFormat = function(datetime)
		{
			// let d = new Date(datetime);
			// let pm = d.getHours() >= 12;
			// let hour12 = d.getHours() % 12;
			// if (!hour12) 
			//   hour12 += 12;
			// let minute = d.getMinutes();
			// return (`${hour12}:${minute} ${pm ? 'PM' : 'AM'}`);
			return datetime.toLocaleTimeString('en-GB');
		};
		$scope.dateFormat = function(datetime)
		{
			var d  		= new Date(datetime);
			var month 	= d.getMonth();
			month = month+1;
			var date= d.getFullYear()+'-'+month+'-'+d.getDate();
			return date;
		};
		var formData = {'id':examID,'name':$scope.name,'exam_time':$scope.timeFormat($scope.exam_time),'class_id':$scope.ob.class,'subject_id':$scope.ob.subject,'last_submission_date':$scope.dateFormat($scope.last_submission_date),'exam_attempt_no':$scope.exam_attempt_no,'exam_date':$scope.dateFormat($scope.exam_date),'exam_duration':$scope.exam_duration,'exam_instruction':$scope.exam_instruction,'total_marks':$scope.total_marks,'total_question':$scope.total_question,exam_mode:$scope.exam_mode,session:$scope.session,exam_type:$scope.exam_type,exam_category:$scope.exam_category,'old_submission_date':$scope.last_submission_date_format,'school_id':$scope.school_id,'marks_validity_days':$scope.marks_validity_days,'offline_exam_type':$scope.offline_exam_type};
		$http.post(BASE_URL+'api/exam/updateExam',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			$scope.response = response.data.data;
			if($scope.response == 1 )
			{
				var Gritter = function () {
						$.gritter.add({
							title: 'Success',
							text: 'Assessment has been updated successfully.'
						});
						$window.location.href = '#!/offline-assessment';
						}();	
			}else{
				var Gritter = function () {
						$.gritter.add({
							title: 'Success',
							text: 'Exam already updated.'
						});
						$window.location.href = '#!/offline-assessment';
						}();
			}

			}, function errorCallback(response){
			
			});
		// console.log(formData);
	}
    // Get Class List
	$scope.getAllClassForSchool = function()
	{
		$scope.classList = [];
		$scope.ob={'class':''};
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllClassForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.classList = response.data.data;
				// $scope.ob.class = $scope.classList[0].id;
			}
			// console.log($scope.classList);		
			}, function errorCallback(response){
			
		});
	}
	$scope.getAllClassForSchool();

	// Get subject List
	$scope.SubjectList = [];
	$scope.ob={'subject':''};
	$scope.getSubjects = function(class_id){
	var formData = {'school_id':School_ID,class_id:class_id};

		$http.post(BASE_URL+'api/exam/getAllSubjectForClass',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				 $scope.SubjectList = response.data.data;
			}
			// console.log($scope.SubjectList);	
			}, function errorCallback(response){
		});
	};
}
function feesCategoryCtrl($scope,$http,$window,$routeParams,$timeout)
{
	// Get Fees Category List
	$scope.getFeesCategories = function()
	{
		$scope.feesCategory = [];
		var formData = {'school_id':School_ID,'type':'school'};
		$http.post(BASE_URL+'api/school/fees/getFeesCategories',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
		$http.post(BASE_URL+'api/school/fees/deleteCategory',{id:id},{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
function feesInvoiceCtrl($scope,$http,$window,$routeParams,$timeout)
{
	
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

			var formData = {'school_id':School_ID,category:$scope.category,description:$scope.description};

			$http.post(BASE_URL+'api/school/fees/addFeesCategory',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
		$http.post(BASE_URL+'api/school/fees/editCategory',{id:$scope.id},{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
		var formData = {id:$scope.id,category:$scope.category,description:$scope.description,school_id:School_ID};
		// console.log(formData);
		// return false
			$http.post(BASE_URL+'api/school/fees/updateFeesCategory',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
function feesCtrl($scope,$http,$window,$routeParams,$timeout)
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
	$scope.classList=[];
	$scope.sessionList=[];
	$scope.class_id='';
	$scope.getAllSession = function(){
		$http.get(BASE_URL+'api/user/getAllSchoolSession?school_id='+School_ID,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.sessionList=response.data.data;
				$scope.sessionID=$scope.sessionList[0].id;
				$scope.getfeesList();
			}
			
			}, function errorCallback(error){
				$scope.sessionList=[];
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
	};
	$scope.getAllSession();
	$scope.getAllClassForSchool = function()
	{
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllClassForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.classList = response.data.data;
			}
			// console.log($scope.classList);
			}, function errorCallback(response){
				$scope.classList=[];
		});
	}
	$scope.getAllClassForSchool();
	$scope.feesList = [];
	// Get Class List
	$scope.getfeesList = function()
	{
		$scope.feesList = [];
		$scope.ob={'class':''};
		var formData = {'class_id':$scope.class_id,'session_id':$scope.sessionID,'school_id':School_ID};
		$http.post(BASE_URL+'api/school/fees/feesList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
				if(response.status == 200)
				{
					$scope.feesList = response.data.data;
					for(var i =0; i < $scope.feesList.length; i++)
		            {
		                $scope.feesList[i]['id']   = $scope.feesList[i].id;
		                $scope.feesList[i]['id_encrypt'] = $scope.encryptStr($scope.feesList[i].id);
		    		}

				}		
			}, function errorCallback(response){
			
		});
	}

	// Delete Exam Schedule
	$scope.feeDelete = function(fee_id)
	{

			$http.post(BASE_URL+'api/school/fees/feeDelete',{id:fee_id},{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
				$scope.response = response.data.data;
				// $scope.feesList();
				// console.log($scope.response);
				if($scope.response == 1 )
				{
						var Gritter = function () {
						$.gritter.add({
							title: 'Success',
							text: 'Fee has been deleted successfully.'
						});
						$scope.feesList();
						//$window.location.href = '#!/fees-list';
						
						}();
				}
				// console.log($scope.response);		
				}, function errorCallback(response){
			});
	}
	$scope.student_id='';
	$scope.getStudentData=function(){
		
		if( $scope.class_id == '')
		{
			alert('Please select class.');
			return false;
		}else{
		$("#selectStudentList").modal('show');
			$scope.getClassStudentBySession=function(){
				$http.get(BASE_URL+'api/school/fees/getClassStudentBySession?school_id='+School_ID+'&session_id='+$scope.sessionID+'&class_id='+$scope.class_id,{
					headers:{
						'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
					}
					}).then(function(response) {
					if(response.status == 200)
					{
						$scope.classStudents = response.data.data;
					}
					}, function errorCallback(response){
						$scope.classStudents=[];
				});
			}
			$scope.getClassStudentBySession();
		}
	}
	$scope.downloadFeeCard=function(){
		if( $scope.student_id == '')
		{
			alert('Please select student.');
			return false;
		}
		$window.location.href = BASE_URL+'api/invoicedownload/feesinvoice/0/'+School_ID+'/'+$scope.sessionID+'/'+$scope.class_id+'/'+$scope.student_id;
	}
}
function feeDetailsCtrl($scope,$http,$window,$routeParams,$timeout)
{
	var feesID;
	$scope.id = "";
	 $scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.id = decrypted.toString(CryptoJS.enc.Utf8);
		feesID = $scope.id;
	};
    $timeout($scope.setID(), 200);
	// console.log(feesID);
	
		$scope.feesDetails = [];
                $scope.currencySym= "";
	
		var formData = {'id':$scope.id,'school_id':School_ID};
		$http.post(BASE_URL+'api/school/fees/feesDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
				if(response.status == 200)
				{
					$scope.feesDetails = response.data.data;
                                        $scope.currencySym = $scope.feesDetails.school_currency.school_currency_symbol;
                                         console.log($scope.currencySym);
				}
				// console.log($scope.feesDetails);		
			}, function errorCallback(response){
			
		});	
}
function editFeesCtrl($scope, $http, $routeParams, $timeout, $window) 
{
	var feesID;
	$scope.id = "";
	 $scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.id = decrypted.toString(CryptoJS.enc.Utf8);
		feesID = $scope.id;
	};
    $timeout($scope.setID(), 200);
	// console.log(feesID);

	// Fee dettails for edit value
		$scope.feesDetails = [];
                $scope.category_ids = [];
		$scope.fees ={'class_id':'','session_id':'','school_type':''};
	
		var formData = {'id':feesID,'school_id':School_ID};
		$http.post(BASE_URL+'api/school/fees/feesDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
				if(response.status == 200)
				{
					$scope.feesDetails 	     = response.data.data;
					$scope.fees.class_id  	 = $scope.feesDetails.class_id;
					$scope.fees.session_id   = $scope.feesDetails.session_id;
					$scope.fees.school_type  = $scope.feesDetails.school_type;
					$scope.fees.description  = $scope.feesDetails.description;
					$scope.category_ids      = $scope.feesDetails.category_id.split(',');
                                        console.log($scope.feesDetails.suscription_fee);

                                        if($scope.feesDetails.suscription_fee!="" && $scope.feesDetails.suscription_fee!='0' ){
                                        $('#subscriptionAmount').html($scope.feesDetails.suscription_fee);    
                                        $('#add_suscription_fee').attr('checked','checked');
                                        $('#suscription_fee').val($scope.feesDetails.suscription_fee);
                                        $scope.isInclude();
                                        }
                                        
                                      
                                        
                                      
                                        
				}
				console.log($scope.feesDetails);		
			}, function errorCallback(response){
			
		});	


	// Get Class List
	$scope.getAllClassForSchool = function()
	{
		$scope.classList = [];
		$scope.ob={'class':''};
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllClassForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.classList = response.data.data;
				// $scope.ob.class = $scope.classList[0].id;
			}
			// console.log($scope.feesDetails.class_id);		
			}, function errorCallback(response){
			
			});
	}
	$scope.getAllClassForSchool();

	// Get Fees Categories
	$scope.getAllFeesCategories = function()
	{
		$scope.feesCategory = [];
		
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/school/fees/getAllFeesCategories',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.feesCategory = response.data.data;
			}
			// console.log($scope.feesCategory);		
			}, function errorCallback(response){
			
		});
	}
	$scope.getAllFeesCategories();
	
	// Get Sessions 
	$scope.sessions = function()
	{
			var formData = {'school_id':School_ID};
			var sessions = [];
			$http.post(BASE_URL+'api/school/fees/sessions',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
					$scope.sessions = response.data.data;
				
				// console.log($scope.sessions);	
				}, function errorCallback(response){
			});
			// console.log($scope.category + "::" + $scope.description);
	}
	$scope.sessions();

	// Get School Type 
	$scope.schoolTypeList = [];
	$scope.getSchoolType = function(){ 
			$http.get(BASE_URL+'api/timeTable/schoolType',{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
	        {
	            $scope.schoolTypeList  = response.data;
	        // console.log($scope.schoolTypeList);
	        });
		};
	$scope.getSchoolType();
        
        ///////////// Update fees ///////////////
        
        $scope.UpdateFees = function(fees){
            
         //console.log(fees.category_ids);
         //return false;
           //console.log('-------------------------------------------------');
            
           var formData ={feesID:feesID,
               //category_ids:$scope.fees.category_ids,
               session_id:$scope.fees.session_id,
               class_id:$scope.fees.class_id,
               school_type:$scope.fees.school_type,
               fee_type:$scope.feesDetails.fee_type,
			   fee_amount:$scope.feesDetails.fee_amount,
			   description:$scope.feesDetails.description };
           
                if( $('#add_suscription_fee').is(':checked') && $.trim($('#suscription_fee').val())!='0'  ){
                formData.suscription_fee = $('#suscription_fee').val();
                }
                else {
                formData.suscription_fee = "";    
                }
              
               
               //if( $('#catList option:selected').length == 0  ||  formData.session_id == ''|| formData.class_id == ''|| formData.school_type == ''|| formData.fee_type == ''|| formData.fee_amount == '' )
			   if(formData.session_id == ''|| formData.class_id == ''|| formData.school_type == ''|| formData.fee_type == ''|| formData.fee_amount == '' )
			   {
			var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: 'All mendatory (*) fields can`t be empty.'
				});
				return false;
			}();

		} else {
                 
                  $http.post(BASE_URL+'api/school/fees/updateFees',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
				$scope.response = response.data.data;
				if($scope.response == 1 )
				{
						var Gritter = function () {
						$.gritter.add({
							title: 'Success',
							text: 'Updated successfully.'
						});
						$window.location.href = '#!/fees-list';
						}();
				}
				// console.log($scope.response);		
				}, function errorCallback(response){
			});
          
           
         		
                    }
            
            
            
        }
        
        $scope.getSubscriptionAmount = function(class_id)
	{
		// console.log(class_id);
		$scope.subscriptionAmount = [];
		$scope.amount='';
		
		var formData = {'school_id':School_ID,'class_id':class_id};
		$http.post(BASE_URL+'api/school/fees/getsubscriptionAmount',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
	
	
			if( response.status == 200 ){
				$scope.subscriptionAmount = response.data.data;
                                console.log($scope.subscriptionAmount.amount);
                                $('#subscriptionAmount').html($scope.subscriptionAmount.amount); 
			}else{
                                $('#subscriptionAmount').html('0'); 
				var Gritter = function () {
						$.gritter.add({
							title: 'Success',
							text: 'No amount found.'
						});
						//$window.location.href = '#!/fees-list';
						
						}();
			}
			
			// console.log($scope.amount);		
			}, function errorCallback(response){
                             $('#subscriptionAmount').html('0'); 
				// if(response.status  == 400 )
				// {
				// 		var Gritter = function () {
				// 		$.gritter.add({
				// 			title: 'Success',
				// 			text: 'No amount found.'
				// 		});
				// 		//$window.location.href = '#!/fees-list';
						
				// 		}();
				// }
		});
	}
        
        $scope.isInclude = function()
	{
		$scope.subAmount = !$scope.subAmount;
		// console.log('test');
	}
        
        /////////    End update fesss ///////////
        
        
        
}

function addFeesCtrl($scope,$http,$window,$routeParams,$timeout)
{
	// Get Class List
	// $scope.getAllClassForSchool = function()
	// {
	// 	$scope.classList = [];
	// 	$scope.ob={'class':''};
	// 	var formData = {'id':School_ID};
	// 	$http.post(BASE_URL+'api/user/getAllClassForSchool',formData,{
	// 		headers:{
	// 			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
	// 		}
	// 		}).then(function(response) {
			
	// 		if(response.status == 200)
	// 		{
	// 			$scope.classList = response.data.data;
	// 			// $scope.ob.class = $scope.classList[0].id;
	// 		}
	// 		// console.log($scope.classList);		
	// 		}, function errorCallback(response){
			
	// 		});
	// }
	// $scope.getAllClassForSchool();

	// Get Class List based on school type
	$scope.classList = [];
	$scope.ob={'class':''};
	$scope.getClasses = function(schoolType){
		// console.log(schoolType);
		// return false;
	var formData = {'school_id':School_ID,schoolType:schoolType};
		$http.post(BASE_URL+'api/admin/Fees/getAllClassBySchoolType',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
				if(response.status == 200)
				{
					 $scope.classList = response.data.data;
					
				}
				// console.log($scope.SubjectList);					
			}, function errorCallback(response){
		});
	};

	// get subscription amount of class wise
	$scope.getSubscriptionAmount = function(class_id)
	{
		// console.log(class_id);
		$scope.subscriptionAmount = [];
		$scope.amount='';
		
		var formData = {'school_id':School_ID,'class_id':class_id};
		$http.post(BASE_URL+'api/school/fees/getsubscriptionAmount',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
	
	
			if( response.status == 200 ){
				$scope.subscriptionAmount = response.data.data;
			}else{
				var Gritter = function () {
						$.gritter.add({
							title: 'Success',
							text: 'No amount found.'
						});
						//$window.location.href = '#!/fees-list';
						
						}();
			}
			
			// console.log($scope.amount);		
			}, function errorCallback(response){
				// if(response.status  == 400 )
				// {
				// 		var Gritter = function () {
				// 		$.gritter.add({
				// 			title: 'Success',
				// 			text: 'No amount found.'
				// 		});
				// 		//$window.location.href = '#!/fees-list';
						
				// 		}();
				// }
		});
	}

	// To show/Hide Subscription amount
	$scope.isInclude = function()
	{
		$scope.subAmount = !$scope.subAmount;
		// console.log('test');
	}

	// Get Fees Categories
	$scope.getAllFeesCategories = function()
	{
		$scope.feesCategory = [];
		
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/school/fees/getAllFeesCategories',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.feesCategory = response.data.data;
			}
			// console.log($scope.feesCategory);		
			}, function errorCallback(response){
			
		});
	}
	$scope.getAllFeesCategories();
	
	// Get Sessions 
	$scope.sessions = function()
	{
			var formData = {'school_id':School_ID};
			var sessions = [];
			$http.post(BASE_URL+'api/school/fees/sessions',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
					$scope.sessions = response.data.data;
				
				// console.log($scope.sessions);	
				}, function errorCallback(response){
			});
			// console.log($scope.category + "::" + $scope.description);
	}
	$scope.sessions();
	
	// Get School Type 
	$scope.schoolTypeList = [];
	$scope.getSchoolType = function(){ 
			$http.get(BASE_URL+'api/timeTable/schoolType',{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
	        {
	            $scope.schoolTypeList  = response.data;
	        // console.log($scope.schoolTypeList);
	        });
		};
	$scope.getSchoolType();

	// Add School Fees Details
        $scope.fees ={school_id:School_ID,category_ids:"",session_id:"",class_id:"",school_type:"",fee_type:"",suscription_fee:"",fee_amount:"" };
	$scope.addFees = function(formData){
                if( $('#add_suscription_fee').is(':checked') && $.trim($('#suscription_fee').val())!='0' ){
                formData.suscription_fee = $('#suscription_fee').val();
                }
                else {
                formData.suscription_fee = "";    
                }
              if( $scope.fees.session_id == ''|| $scope.fees.class_id == ''|| $scope.fees.school_type == ''|| $scope.fees.fee_type == ''|| $scope.fees.fee_amount == '' )
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: 'All mendatory (*) fields can`t be empty.'
				});
				return false;
			}();

		}else{

				$http.post(BASE_URL+'api/school/fees/addFees',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
							$window.location.href = '#!/fees-list';
							}();
					}
				// console.log($scope.response);		
				}, function errorCallback(response){
						if(response.status == 400 )
						{
							var Gritter = function () {
								$.gritter.add({
									title: 'Failed',
									text: response.data.message
								});
								return false;
							}();
						}
				});
		}
	}
}
function offlineAssessmentCtrl($scope,$http,$window,$routeParams,$timeout)
{
	// Get Offline Assessment List Data
	$scope.getExamList = function()
	{
		$scope.examList = [];
		var formData = {'school_id':School_ID};
		$http.post(BASE_URL+'api/exam/offlineAssessmentList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
				$scope.examList = response.data.data;
				for(var i =0; i < $scope.examList.length; i++)
	            {
	                $scope.examList[i]['exam_id']   = $scope.examList[i].id;
	                $scope.examList[i]['exam_last_datetime']   = $scope.examList[i].last_submission_date+" "+$scope.examList[i].exam_time;
	                
	                   var today = new Date();
	                   let todayDate = today.getDate();
	                   let currentMinute = today.getMinutes();
	                   todayDate = (todayDate > 9) ? todayDate : '0'+todayDate;
                       let thisMonth = ((today.getMonth()+1) > 9) ? (today.getMonth()+1) : '0'+(today.getMonth()+1);
	                   currentMinute = (currentMinute > 9) ? currentMinute : '0'+currentMinute;
	                   var date = today.getFullYear()+'-'+(thisMonth)+'-'+todayDate; 
					   var time = today.getHours() + ":" + currentMinute + ":" + today.getSeconds(); 
					$scope.examList[i]['current_datetime']   = date+' '+time;
	                $scope.examList[i]['id'] 		= $scope.encryptStr($scope.examList[i].id);
	    		}
				if(  ($scope.examList.length) < 10 ){
					$scope.pageSize = $scope.examList.length;
					$scope.currentPage=1;
					$scope.itemsPerPage=1;
				}else
				{
					$scope.pageSize = 10;
					$scope.currentPage=1;
					$scope.itemsPerPage=1;
				}
			}
			// console.log($scope.examList);		
			}, function errorCallback(response){
			
		});
	}
	$scope.getExamList();

	// Delete Exam Schedule
	$scope.examDelete = function(exam_id)
	{
			$http.post(BASE_URL+'api/exam/deleteExam',{id:exam_id},{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
				$scope.response = response.data.data;
				if($scope.response == 1 )
				{
						var Gritter = function () {
						$.gritter.add({
							title: 'Success',
							text: 'Exam Schedule has been deleted successfully.'
						});
						$scope.getExamList();
						$window.location.href = '#!/offline-assessment';
						}();
				}
				// console.log($scope.response);		
				}, function errorCallback(response){
			});
	}

}
function addOfflineAssessmentCtrl($scope,$http,$window,$routeParams,$timeout)
{
	// Get Class List
	$scope.getAllClassForSchool = function()
	{
		$scope.classList = [];
		$scope.ob={'class':''};
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllClassForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.classList = response.data.data;
				// $scope.ob.class = $scope.classList[0].id;
			}
			// console.log($scope.classList);		
			}, function errorCallback(response){
			
		});
	}
	$scope.getAllClassForSchool();

	$scope.getCurrentSession = function()
	{
		$scope.currentSession = [];
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/exam/getCurrentSession',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.currentSession 	= response.data.data;
				$scope.academicsession 	= $scope.currentSession.academicsession;
				$scope.sessionstart 	= new Date($scope.currentSession.sessionstart);
				$scope.sessionstart		= $scope.sessionstart.getFullYear();
				$scope.sessionend 		= new Date($scope.currentSession.sessionend);
				$scope.sessionend    	= $scope.sessionend.getFullYear();
				// $scope.ob.class = $scope.classList[0].id;
			}
			// console.log($scope.currentSession);		
			}, function errorCallback(response){
			
		});
	}
	$scope.getCurrentSession();

	// Get subject List
	$scope.SubjectList = [];
	$scope.ob={'subject':''};
	$scope.getSubjects = function(class_id){
	var formData = {'school_id':School_ID,class_id:$scope.ob.class};
		$http.post(BASE_URL+'api/exam/getAllSubjectForClass',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
				if(response.status == 200)
				{
					 $scope.SubjectList = response.data.data;
					
				}
				// console.log($scope.SubjectList);					
			}, function errorCallback(response){
		});
	};

	$scope.getSubjects();

	// Insert Offline assessment
	$scope.name     			= '';
	$scope.ob.class 			= '';
	$scope.ob.subject 			= '';
	$scope.exam_date 			= '';
	$scope.exam_duration		= '';
	$scope.exam_time			= '';
	$scope.exam_instruction 	= '';
	// $scope.total_question	 	= '';
	$scope.total_marks		 	= '';
	// $scope.exam_code		 	= '';
	$scope.last_submission_date = '';
	// $scope.exam_attempt_no		= '';
	$scope.exam_mode			= '';
	$scope.session 				= '';
	// $scope.exam_type			= '';
	$scope.exam_category		= '';
	$scope.addOfflineExam = function()
	{
		if($scope.exam_duration > 200 ){
			var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: `You entered minutes exceed the exam time limit. Please Try Again !!`
				});
				return false;
			}();
		}else if($scope.name == '' || $scope.exam_time ==''  || $scope.last_submission_date == ''|| $scope.exam_attempt_no == ''  || $scope.ob.class == ''  || $scope.exam_date == '' || $scope.exam_duration == ''  || $scope.exam_instruction == '' || $scope.ob.subject == '' || $scope.session =='' || $scope.exam_mode =='' || $scope.exam_category == '' )
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: 'All mendatory (*) fields can`t be empty.'
				});
				return false;
			}();
		}else{
		$scope.timeFormat = function(datetime)
		{
			return datetime.toLocaleTimeString('en-GB');
		};
		$scope.dateFormat = function(datetime)
		{
			var d  		= new Date(datetime);
			var month 	= d.getMonth();
			month = month+1;
			var date= d.getFullYear()+'-'+month+'-'+d.getDate();
			return date;
		};

	 	var formData = {school_id:School_ID,name:$scope.name,class_id:$scope.ob.class,subject_id:$scope.ob.subject,exam_date:$scope.dateFormat($scope.exam_date),last_submission_date:$scope.dateFormat($scope.last_submission_date),exam_time:$scope.timeFormat($scope.exam_time),exam_duration:$scope.exam_duration,instruction:$scope.exam_instruction,total_marks:$scope.total_marks,exam_mode:$scope.exam_mode,session:$scope.session,exam_category:$scope.exam_category};
		 // console.log(formData); 
			$http.post(BASE_URL+'api/exam/addOfflineExam',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
					// console.log(response.status)
					// return false
				$scope.response = response.data.data;
				// console.log($scope.response);
				// return false
				// if($scope.response == 'exist')
				if( parseInt($scope.response) > 0 )
				{
					var Gritter = function () {
						$.gritter.add({
							title: 'Successfull',
							text: 'Offline assignment has been created successfully.'
						});
						}();
						$window.location.href = '#!/offline-assessment';
					
				}else
				{
						var Gritter = function () {
							$.gritter.add({
								title: 'failed',
								text: response.data.message
							});
						}();
				}
				
				}, function errorCallback(response){
			});
		}
	};
}
function offlineAssessmentStudentCtrl($scope,$http,$window,$routeParams,$timeout)
{
	// console.log($scope.exam);
	var examID;
	$scope.id = "";
	 $scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.id = decrypted.toString(CryptoJS.enc.Utf8);
		examID = $scope.id;
	};
    $timeout($scope.setID(), 200);
	// console.log(examID);
	// console.log($routeParams.ID);
	
	$scope.examData 	 = [];
	$scope.classStudents = [];
	$scope.marksValue  = {marks:""};
	var formData = {'id':$scope.id};
	$http.post(BASE_URL+'api/exam/classwiseStudentsData',formData,{
		headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
		}
		}).then(function(response) {
		
		if(response.status == 200)
		{
			$scope.classStudents 		     = response.data.data.classStudents;
			
			$scope.examData 			     = response.data.data.examDetails;
			$scope.name 				     = $scope.examData.name;
			$scope.class 				     = $scope.examData.class+' '+$scope.examData.section;
			$scope.subject 				     = $scope.examData.subject;
			$scope.total_marks			     = $scope.examData.total_marks;
			// $scope.marks_obtained		     = $scope.examData.marks_obtained;
			// $scope.studentID		     	 = $scope.examData.studentID;
			$scope.exam_date 			     = $scope.examData.exam_date;

			$scope.last_submission_date      = $scope.examData.last_submission_date;
			$scope.last_submission_datetime  = $scope.examData.last_submission_date+ " "+$scope.examData.exam_time;
			$scope.exam_time 			     = $scope.examData.exam_time;

	                   var today = new Date();
	                   let todayDate = today.getDate();
	                   let currentMinute = today.getMinutes();
	                   todayDate = (todayDate > 9) ? todayDate : '0'+todayDate;
                       let thisMonth = ((today.getMonth()+1) > 9) ? (today.getMonth()+1) : '0'+(today.getMonth()+1);
	                   currentMinute = (currentMinute > 9) ? currentMinute : '0'+currentMinute;
	                   var date = today.getFullYear()+'-'+(thisMonth)+'-'+todayDate; 
					   var time = today.getHours() + ":" + currentMinute + ":" + today.getSeconds(); 
			$scope.current_datetime   = date+' '+time;

			$scope.marks_validity_extends 		= $scope.examData.marks_validity_extends;
			$scope.exam_duration 		= $scope.examData.exam_duration;
			$scope.exam_instruction 	= $scope.examData.exam_instruction;
		}
		// console.log($scope.marks_validity_extends);		
		console.log($scope.marks_obtained);		
		// console.log($scope.classStudents);		
		}, function errorCallback(response){
		
		});

		$scope.marksUpdate = function(child_id,examData,marks_obtain){
			// console.log(child_id);
			
			// console.log('obtain marks  '+ marks_obtain);
			// console.log('obttttt marks '+ $scope.marks_obtain);
			// console.log('total marks '+ $scope.total_marks);
			// return false 
			if( parseInt($scope.total_marks) >= parseInt(marks_obtain) )
			{
					$scope.marksObtainData = false;
					var formData = {'child_id':child_id,'marks_obtain':marks_obtain,'examData':examData};
					$http.post(BASE_URL+'api/exam/offlineExamMarkObtain',formData,{
						headers:{
							'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
						}
					}).then(function(response) {
					
					$scope.marksObtainData 			= response.data.data;
					$scope.myMarksObtained   		=	$scope.marksObtainData.marks_obtained;
					// console.log($scope.myMarksObtained);
					// return false
					if(response.status == 200)
					{
						var Gritter = function () {
						$.gritter.add({
							title: 'Success',
							text: 'Marks saved successfully.'
						});
						}();

						$window.setTimeout(function(){
							$window.location.href = '#!/offline-assessment-student/'+$routeParams.ID;
							$scope.myMarksObtained   		=	$scope.marksObtainData.marks_obtained;
							$scope.user_id		     		=	$scope.marksObtainData.user_id;
						//	$window.location.reload();
						 }, 4000);
					}
					// console.log($scope.examQuestMarkCount);		
					}, function errorCallback(response){
						
						if(response.status == 400)
						{
							var Gritter = function () {
							$.gritter.add({
								title: 'Failed',
								text: response.data.message
							});
							}();

							$window.setTimeout(function(){
								$window.location.href = '#!/offline-assessment-student/'+$routeParams.ID;
								$window.location.reload();
							 }, 3000);
						}
					});
				
			}else{
					var Gritter = function () {
						$.gritter.add({
							title: 'failed',
							text: 'Obtained marks can`t greater than total marks.'
						});
						// $window.location.reload();
						return false;
					}();
			}
		

		};

}
function questionCtrl($scope,$http,$window,$routeParams,$timeout)
{
	var examID;
	$scope.id = "";
	 $scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.id = decrypted.toString(CryptoJS.enc.Utf8);
		examID = $scope.id;
	};
    $timeout($scope.setID(), 200);
	// console.log(examID);
	
	 // Get Class List
	$scope.examAndQuestionMarksCount = function()
	{
		$scope.examQuestMarkCount = [];
		var formData = {'id':examID};
		$http.post(BASE_URL+'api/exam/examAndQuestionMarksCount',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.examQuestMarkCount 	= response.data.data;
				$scope.total_marks 			= $scope.examQuestMarkCount.total_marks;
				$scope.question_marks_total = $scope.examQuestMarkCount.question_marks;
				$scope.total_question		= $scope.examQuestMarkCount.total_question;
				$scope.question_qty		    = $scope.examQuestMarkCount.question_qty;
				$scope.exam_type		    = $scope.examQuestMarkCount.exam_type;
			}
			// console.log($scope.examQuestMarkCount);		
			}, function errorCallback(response){
		});
	}
	$scope.examAndQuestionMarksCount();
	
	 // Get All Question base on exams
	$scope.questionList = function()
	{
		$scope.questionList = [];
		$scope.examData = [];
		var formData = {'id':examID};
		$http.post(BASE_URL+'api/exam/questionList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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

				$scope.questionList     = response.data.data.questionList;
				$scope.examData 		= response.data.data;
				$scope.name   			= $scope.examData.name;
				$scope.exam_date_time   = $scope.examData.exam_date_time;
				$scope.examDateTime		= $scope.examData.exam_date+" "+$scope.examData.exam_time;
	            $scope.examEncrpID 	= $scope.encryptStr($scope.examData.id);
	             var today = new Date();
	                   let todayDate = today.getDate();
	                   let currentMinute = today.getMinutes();
	                   todayDate = (todayDate > 9) ? todayDate : '0'+todayDate;
	                   let thisMonth = ((today.getMonth()+1) > 9) ? (today.getMonth()+1) : '0'+(today.getMonth()+1);
	                   currentMinute = (currentMinute > 9) ? currentMinute : '0'+currentMinute;
	                   var date = today.getFullYear()+'-'+(thisMonth)+'-'+todayDate; 
					   var time = today.getHours() + ":" + currentMinute + ":" + today.getSeconds(); 
				$scope.current_datetime   = date+' '+time;
	           
				for(var i =0; i < $scope.questionList.length; i++)
	            {
	                $scope.questionList[i]['ques_id']   = $scope.questionList[i].id;
	                $scope.questionList[i]['id'] 		= $scope.encryptStr($scope.questionList[i].id);
	    		}
				if(  ($scope.questionList.length) < 10 ){
					$scope.pageSize = $scope.questionList.length;
					$scope.currentPage=1;
					$scope.itemsPerPage=1;
				}else
				{
					$scope.pageSize = 10;
					$scope.currentPage=1;
					$scope.itemsPerPage=1;
				}
			}
			// console.log($scope.examData);		
			console.log($scope.questionList);		
			}, function errorCallback(response){
			
		});
	}
	$scope.questionList();
	// Delete single question in exam
	$scope.questionDelete = function(questID)
	{
		var deleteMedia = window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':questID};
			$http.post(BASE_URL+'api/exam/deleteQuestion',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
				
				if(response.status == 200)
				{
					var result  = response.data;
					var Gritter = function () {
						$.gritter.add({
							title: 'Successfull',
							text: 'Question deleted successfully.'
						});
						$window.location.reload();
						return false;
					}();
				}
				
				}, function errorCallback(response){
				
			});
		}
	}
	$scope.selectChoice = function(choice){
	
		if(choice=='multiple'){
		 let count = 4;
			$scope.multiAnswer=[];
			for (var i = 0; i < count; i++) {
				$scope.multiAnswer.push({
				    optionVal: ''
				});
			}
		}		
		if(choice=='radio'){
		 let count = 2;
			$scope.multiAnswer=[];
			for (var i = 0; i < count; i++) {
				$scope.multiAnswer.push({
				    optionVal: ''
				});
			}
		}
		if(choice=='boolean'){
				$scope.multiAnswer=[{"optionVal": "true"}, {"optionVal": "false"}];
		}
		
		if(choice=='textual'){
		 let count = 1;
			$scope.multiAnswer=[];
			for (var i = 0; i < count; i++) {
				$scope.multiAnswer.push({
				    optionVal: ''
				});
			}
		}
		 
		// console.log($scope.multiAnswer);
	};

	$scope.question 		= '';
	$scope.question_type 	= '';
	$scope.question_mark 	= '';
	// $scope.add_answer	 	= '';
	$scope.multiAnswers ={ values:"" };
 	
	$scope.addQuestion = function()
	{
		if($scope.question_marks_total == null){
			$scope.question_marks 		= parseInt($scope.question_marks);
			$scope.question_marks_total =  parseInt(0);	
		}else{
			$scope.question_marks 		= parseInt($scope.question_marks);
			$scope.question_marks_total = parseInt($scope.question_marks_total) + parseInt($scope.question_marks);	
		}
		$scope.question_qty = parseInt($scope.question_qty)+1;
		
		if( parseInt($scope.total_question) <  $scope.question_qty )
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: `No. of total questions can't greater than created questions for any exam.`
				});
			    setTimeout(function() { location.reload();  }, 3000);
				return false;
			}();
		}else if( ($scope.total_marks < $scope.question_marks_total) || ($scope.total_marks < $scope.question_marks) )
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: `Total exam marks can't be greater than total question marks.`
				});
				setTimeout(function() { location.reload();  }, 3000);
				return false;
			}();
		}else if($scope.question == '' || $scope.question_type ==''  || $scope.question_marks == ''  )
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: 'All mendatory (*) fields can`t be empty.'
				});
				setTimeout(function() { location.reload();  }, 3000);
				return false;
			}();
		
		}else{
		
				var formData = {exam_id:examID,question:$scope.question,question_marks:$scope.question_marks,question_type:$scope.question_type,answer:$scope.add_answer,options:$scope.multiAnswer};
				// console.log(formData);
				$http.post(BASE_URL+'api/exam/addQuestion',formData,{
					headers:{
						'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
					}
					}).then(function(response) {
					$scope.quesValues = response.data.data.quesValues;
					$scope.questStatus = response.data.data.questStatus;
					$scope.question_id = response.data.data.question_id;
					// console.log($scope.quesValues);		
					// console.log($scope.questStatus);		
					// console.log($scope.question_id);		
					// return false
					if($scope.response == 1 )
					{
							var Gritter = function () {
							$.gritter.add({
								title: 'Success',
								text: 'Question has been added successfully.'
							});
							$window.location.href = '#!/exam';
							}();
					}
				
					}, function errorCallback(response){
				});
		}
	}
	$scope.addAnswersChoices = function()
	{
		// alert('test');
		// return false
		if( ($scope.questStatus != 'answer_added') )
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: 'Answer field is mendatory.'
				});
				// setTimeout(function() { location.reload();  }, 3000);
				return false;
			}();
		}else{


				var formData = {ques_id:$scope.question_id,questStatus:$scope.questStatus,optionAnswers:$scope.multiAnswers};
				$http.post(BASE_URL+'api/exam/addMultipleAnswers',formData,{
					headers:{
						'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
					}
					}).then(function(response) {
					$scope.response = response.data.data;
					if($scope.response == 1 )
					{
							var Gritter = function () {
							$.gritter.add({
								title: 'Success',
								text: 'Multiple answers has been added successfully.'
							});
							$window.location.href = '#!/exam';
							}();
					}
				
					}, function errorCallback(response){
				});

		}
			
	}
}
function detailsCtrl($scope,$http,$window,$routeParams,$timeout)
{
	var quesID;
	$scope.id = "";
	 $scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.id = decrypted.toString(CryptoJS.enc.Utf8);
		quesID = $scope.id;
	};
    $timeout($scope.setID(), 200);
	// console.log(quesID);
	$scope.selectChoice = function(choice){
	
		if(choice=='multiple'){
		 let count = 4;
			$scope.multiAnswer=[];
			for (var i = 0; i < count; i++) {
				$scope.multiAnswer.push({
				    optionVal: ''
				});
			}
		}		
		if(choice=='radio'){
		 let count = 2;
			$scope.multiAnswer=[];
			for (var i = 0; i < count; i++) {
				$scope.multiAnswer.push({
				    optionVal: ''
				});
			}
		}
		if(choice=='boolean'){
				$scope.multiAnswer=[{"optionVal": "true"}, {"optionVal": "false"}];
		}
		if(choice=='textual'){
		 let count = 1;
			$scope.multiAnswer=[];
			for (var i = 0; i < count; i++) {
				$scope.multiAnswer.push({
				    optionVal: ''
				});
			}
		}
		 // console.log($scope.multiAnswer);
	};
	// Edit question block
	$scope.editQuestion = function()
	{
		var formData = {ques_id:$scope.id,question:$scope.question,question_marks:$scope.question_marks,question_type:$scope.question_type,options:$scope.multiAnswer};
			$http.post(BASE_URL+'api/exam/updateQuestion',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
				$scope.response = response.data.data;
				if($scope.response == 1 )
				{
						var Gritter = function () {
						$.gritter.add({
							title: 'Success',
							text: 'Question has been updated successfully.'
						});
						$window.location.href = '#!/exam';
						}();
				}
				// console.log($scope.response);		
				}, function errorCallback(response){
			});
	};

	// Get All Question base on exams
	$scope.questionDetails = function()
	{
		$scope.questionDetails = [];
		var formData = {'id':quesID};
		$http.post(BASE_URL+'api/exam/questionDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.questionDetails     = response.data.data;
				$scope.question   		   = $scope.questionDetails.question;
				$scope.name   			   = $scope.questionDetails.name;
				$scope.question_marks      = $scope.questionDetails.question_marks;
				$scope.question_type       = $scope.questionDetails.question_type;
				$scope.answer       	   = $scope.questionDetails.answer;
				$scope.option_value        = $scope.questionDetails.option_value;
		    }
			// console.log($scope.questionDetails);		
			}, function errorCallback(response){
			
		});
	}
	$scope.questionDetails();
	
	
}
function examSubmitCtrl($scope,$http,$window,$routeParams,$timeout)
{
	var formData = {"school_id":School_ID};
	$scope.examsSubmitted =[];
	$scope.getExamSubmitted = function(){

		$http.post(BASE_URL+'api/exam/getExamSubmitted',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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

					$scope.examsSubmitted = response.data.data;
					for(var i =0; i < $scope.examsSubmitted.length; i++)
		            {
		                $scope.examsSubmitted[i]['id'] = $scope.encryptStr($scope.examsSubmitted[i].id);
		    		}
					if(  ($scope.examsSubmitted.length) < 10 ){
						$scope.pageSize = $scope.examsSubmitted.length;
						$scope.currentPage=1;
						$scope.itemsPerPage=1;
					}else
					{
						$scope.pageSize = 10;
						$scope.currentPage=1;
						$scope.itemsPerPage=1;
					}
				}
				 // console.log($scope.examsSubmitted);		
				}, function errorCallback(response){
			});
	}
	$scope.getExamSubmitted();
}
function gradeSystemCtrl($scope,$http,$window,$routeParams,$timeout)
{
	// Add New Grade Section
   $scope.data = {id:School_ID,info:[]};
   $scope.addGrade = function(){
        $scope.data.info.push({grade_name:"",min_percent:"",max_percent:""});
	}
 	$scope.saveGrades = function(){
 		// console.log($scope.data);
 			$http.post(BASE_URL+'api/exam/saveGrades',$scope.data,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
				$scope.response = response.data.data;
				if($scope.response == 1 )
				{
						var Gritter = function () {
						$.gritter.add({
							title: 'Success',
							text: 'Grades has been save successfully.'
						});
						$window.location.href = '#!/grade-list';
						}();
				}
				// console.log($scope.response);		
				}, function errorCallback(response){
			});
 	}
 	// END New Grade Section
 	// Get  Grade List Data
 	$scope.gradeList = false;
	$scope.getGradeDetails = function()
	{
		var formData = {'school_id':School_ID}
		$http.post(BASE_URL+'api/exam/getGrades',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.gradeList = response.data.data;

				if(  ($scope.gradeList.length) < 10 ){
					$scope.pageSize = $scope.gradeList.length;
					$scope.currentPage=1;
					$scope.itemsPerPage=1;
				}else
				{
					$scope.pageSize = 10;
					$scope.currentPage=1;
					$scope.itemsPerPage=1;
				}
			}
			
			}, function errorCallback(response){
			
		});
	}
	$scope.getGradeDetails();
	// Delete Grade 
	$scope.deleteGrade = function(id)
	{
		var deleteMedia = window.confirm('Are you absolutely sure you want to delete?');
			if(deleteMedia == true)
			{
				var formData = {'id':id};
				$http.post(BASE_URL+'api/exam/deleteGrade',formData,{
					headers:{
						'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
					}
					}).then(function(response) {
					
					if(response.status == 200)
					{
						var result  = response.data;
						var Gritter = function () {
							$.gritter.add({
								title: 'Successfull',
								text: 'Grade deleted successfully.'
							});
							$scope.getGradeDetails();
							return false;
						}();
					}
					
					}, function errorCallback(response){
					
				});
			}
		
	}
}
function viewExamSubmitCtrl($scope,$http,$window,$routeParams,$timeout)
{
	var quesAnsID;
	$scope.id = "";
	 $scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.id = decrypted.toString(CryptoJS.enc.Utf8);
		quesAnsID = $scope.id;
	};
    $timeout($scope.setID(), 200);
	// console.log(quesAnsID);

	var formData = {"id":quesAnsID};
	$scope.studentExamDetails =[];
	$scope.questionList =[];
	$scope.myExamDetails = function(){
		$http.post(BASE_URL+'api/exam/myExamDetails',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
					$scope.studentExamDetails = response.data.data;
					$scope.questionList = response.data.data.questionList;
					for (var i = $scope.questionList.length - 1; i >= 0; i--) {
						$scope.questionList[i]['marks_obtain'] = 0;
					}
					$scope.optionValues = response.data.data.questionList.option_value;
					$scope.answerValue = response.data.data.questionList.answer_value;
					$scope.studentExamDetails['answer_id'] = $scope.studentExamDetails.id;
					$scope.studentExamDetails['id'] = $scope.encryptStr($scope.studentExamDetails.id);
		    	}
				 console.log($scope.questionList);
				}, function errorCallback(response){
		});
	}
	$scope.myExamDetails();

	// Get Total marks from form data
	$scope.calculateMarks = function(answer_id,total_marks){
		var formData = {'answer_id':answer_id,'total_marks':total_marks,'questionList':$scope.questionList};
				$http.post(BASE_URL+'api/exam/calculateMarks',formData,{
					headers:{
						'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
					}
					}).then(function(response) {
					
					if(response.status == 200)
					{
						var result  = response.data;
						var Gritter = function () {
							$.gritter.add({
								title: 'Successfull',
								text: 'Mark has been added successfully.'
							});

						}();
						$scope.myExamDetails();
					}
					
					}, function errorCallback(response){
			});
	}
}
function schoolProjectCtrl($scope, $http, $route, $timeout,$window) 
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
	$scope.datefilter='';
	$scope.class_id='';
	$scope.subject_id='';
	$scope.category='';
	$scope.classArray=[];
	$scope.subjectArray=[];
	$scope.categoryArray=[];
	$scope.getProjectList=function(){
		var formData={'classID':'','filterbydate':'','class_id':$scope.class_id,'subject_id':$scope.subject_id,'category':$scope.category}
		$http.post(BASE_URL+'api/school/project/getProjectList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.assignmentData = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.assignmentData.length; i++)
				{
					encrypted = $scope.encryptStr($scope.assignmentData[i].id);
					$scope.assignmentData[i]['assignmentID'] = encrypted;
					$scope.assignmentData[i]['currDate'] = new Date();
					$scope.classArray.push({
						'id':$scope.assignmentData[i].class_id,
						'name':$scope.assignmentData[i].classname
					});
					$scope.subjectArray.push({
						'id':$scope.assignmentData[i].subject_id,
						'name':$scope.assignmentData[i].subject
					});
					$scope.categoryArray.push({
						'name':$scope.assignmentData[i].category
					});
				}
			}
			}, function errorCallback(response){
				$scope.assignmentData=[];
		});
	}
	$scope.getProjectList();
	$scope.deleteProject = function(ID,index)
	{
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':ID};
			$http.post(BASE_URL+'api/school/project/deleteProject',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
				
				if(response.status == 200)
				{
					var result  = response.data;
					var Gritter = function () {
						$.gritter.add({
							title: 'Successfull',
							text: response.data.message
						});
						$scope.getProjectList();
						//$scope.classboardPostData.splice(index, 1);;
						return false;
					}();
				}
				
				}, function errorCallback(response){
				
			});
		}
	}
} 
function allProjectCtrl($scope, $http, $routeParams, $timeout,$window) 
{
	$scope.projectdownload=function(id) {
		$window.location.href = BASE_URL+'download/projectdownload/'+id;
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
	var sid;
	$scope.assignmentID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.assignmentID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.assignmentID;
	};	
	$timeout($scope.setID(), 2000);
	$scope.assignmentinfo = false;
	$scope.getProjectDetails = function()
	{
		var formData = {'id':$scope.assignmentID}
		$http.post(BASE_URL+'api/school/project/getProjectDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{   
				var encrypted;
				$scope.assignmentinfo = response.data.data;
				encrypted = $scope.encryptStr($scope.assignmentinfo.id);
				$scope.viewassignmentID = encrypted;
				$scope.category=$scope.assignmentinfo.category;
				$scope.total_marks=$scope.assignmentinfo.total_marks;
				$scope.assignmentname=$scope.assignmentinfo.title;
				$scope.class=$scope.assignmentinfo.classname;
				$scope.submissiondate=$scope.assignmentinfo.submission_date;
				$scope.description=$scope.assignmentinfo.description;
				$scope.subject=$scope.assignmentinfo.subject;
				$scope.dateofissue=$scope.assignmentinfo.created;
				$scope.openassignmentdate=$scope.assignmentinfo.open_submission_date;
				$scope.attachment=$scope.assignmentinfo.attachment;
				$scope.attachment_type=$scope.assignmentinfo.attachment_type;
				var attachmentSplit=$scope.attachment.split(',');
				var attachtypeSplit=$scope.attachment_type.split(',');
				$scope.attachmentArray=[];
				for(var i = 0; i < attachmentSplit.length; i++)
				{
					$scope.attachmentArray.push({ 
						'attachment':attachmentSplit[i],
						'type':attachtypeSplit,
						'downloadurl':BASE_URL+'img/project/'+attachmentSplit[i]
					});
					
				}
				$scope.currDate = new Date();
			}
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getProjectDetails();
}
function createProjectCtrl($scope, $http, $route, $timeout,$window) 
{
	$scope.categoryData=[{'name':'Graded','val':'graded'},{'name':'Non-Graded','val':'non-graded'}];
	var file_not_allowed_msg="Only jpeg,jpg,png,doc file supported.";
	var validImageTypes=new Array('image/jpeg','image/jpg','image/png','application/pdf','application/doc','application/docx');
	$scope.previewImages=[];
	$scope.PreviewImage=[];
	$scope.SelectFile = function (e) {
	for(var i=0;i<e.target.files.length;i++){
		var type;
		var reader = new FileReader();
		reader.fileName = e.target.files[i].name;
		if (( !validImageTypes.includes(e.target.files[i].type) ) )
		{
			//$window.alert(file_not_allowed_msg);
			//return false;
		}
		$scope.previewImages.push(e.target.files[i]);
		
		reader.onload = function (e) {
		$scope.PreviewImage.push({'name':e.target.fileName});
		$scope.$apply();
		};
		reader.readAsDataURL(e.target.files[i]);
	}
	}
	
	$scope.remove=function(data){
		var index= $scope.PreviewImage.indexOf(data);
		$scope.PreviewImage.splice(data, 1);	
		$scope.previewImages.splice(data, 1);				
	}
	$scope.category='';
	$scope.total_marks='';
	$scope.class_id='';
	$scope.subject='';
	$scope.title='';
	$scope.date='';
	$scope.opendate='';
	$scope.no_of_attampt='';
	$scope.description='';
	$scope.showLoader=0;
	$scope.convertDateNewFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [date.getFullYear(), mnth, day].join("-");
	}
	$scope.createProject=function(){
		if($scope.class_id == '')
		{
			$scope.errormsg = 'Class is required.';
			return false;
		}else if($scope.subject == '')
		{
			$scope.errormsg = 'Subject is required.';
			return false;
		}else if($scope.category=='')
		{
			$scope.errormsg = 'Project category is required.';
			return false;
		}else if($scope.title=='')
		{
			$scope.errormsg = 'Project name is required.';
			return false;
		}else if($scope.total_marks=='')
		{
			$scope.errormsg = 'Project total marks is required.';
			return false;
		}else if($scope.date=='')
		{
			$scope.errormsg = 'Submission date is required.';
			return false;
		}else if($scope.description=='')
		{
			$scope.errormsg = 'Description is required.';
			return false;
		} 
		$scope.showLoader=1;
		var formData = new FormData();
		formData.append('school_id', School_ID);
		formData.append('category', $scope.category);
		formData.append('total_marks', $scope.total_marks);
		formData.append('class_id', $scope.class_id);
		formData.append('subject_id', $scope.subject);
		formData.append('title', $scope.title);
		formData.append('no_of_attampt', $scope.no_of_attampt);
		formData.append('date', $scope.convertDateNewFormat($scope.date));
		if($scope.opendate!=''){
			$scope.opendate=$scope.convertDateNewFormat($scope.opendate);
		}
		formData.append('opendate', $scope.opendate);
		formData.append('description', $scope.description);
		if($scope.previewImages.length > 0)
		{
			for(var i = 0; i < $scope.previewImages.length; i++)
			{ 
				formData.append('files[]', $scope.previewImages[i]);
			}
		}
		
		$http.post(BASE_URL+'api/school/project/createProject',formData,{
			transformRequest: angular.identity,
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.showLoader=0;
				$scope.result = response.data.data;
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: response.data.message
					});
					$scope.errormsg = '';
					return false;
				}();
				$window.location.href = '#!/project-list';
			}
			
			}, function errorCallback(response){
				$scope.showLoader=0;
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
	
	$scope.getTeacherSubjectClass=function(){
		var formData={'classID':''}
		$http.post(BASE_URL+'api/school/project/getTeacherSubjectClass',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.classData = response.data.data;
			}
			}, function errorCallback(response){
				$scope.classData=[];
		});
	}
	$scope.getTeacherSubjectClass();
	$scope.getTeacherSubject=function(){
		var formData={'classID':$scope.class_id}
		$http.post(BASE_URL+'api/school/project/getTeacherSubject',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.subjectData = response.data.data;
			}
			}, function errorCallback(response){
				$scope.subjectData=[];
		});
	}
}
function submitedProjectCtrl($scope, $http, $route, $timeout,$window) 
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
	$scope.class_id='';
	$scope.subject_id='';
	$scope.category='';
	$scope.classArray=[];
	$scope.subjectArray=[];
	$scope.categoryArray=[];
	$scope.getStudentSubmitedProjectList=function(){
		var formData={'schoolID':School_ID,'class_id':$scope.class_id,'subject_id':$scope.subject_id,'category':$scope.category}
		$http.post(BASE_URL+'api/school/project/getStudentSubmitedProjectList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.studentSubmitAssignmentData = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.studentSubmitAssignmentData.length; i++)
				{
					encrypted = $scope.encryptStr($scope.studentSubmitAssignmentData[i].asid);
					$scope.studentSubmitAssignmentData[i]['assignmentID'] = encrypted;
					$scope.classArray.push({
						'id':$scope.studentSubmitAssignmentData[i].class_id,
						'name':$scope.studentSubmitAssignmentData[i].classname
					});
					$scope.subjectArray.push({
						'id':$scope.studentSubmitAssignmentData[i].subject_id,
						'name':$scope.studentSubmitAssignmentData[i].subject
					});
					$scope.categoryArray.push({
						'name':$scope.studentSubmitAssignmentData[i].category
					});
				}
				$scope.currDate = new Date();
			}
			}, function errorCallback(response){
			
		});
	}
	$scope.getStudentSubmitedProjectList();
	
} 
function allSubmitedProjectCtrl($scope, $http, $routeParams, $timeout,$window) 
{
	$scope.assignMarks=function(data){
		var formData = new FormData();
		formData.append('title', data.title);
		formData.append('user_id', data.user_id);
		formData.append('submission_id', data.id);
		formData.append('project_id', data.project_id);
		formData.append('school_id', data.school_id);
		formData.append('class_id', data.class_id);
		formData.append('subject_id', data.subject_id);
		formData.append('total_marks', data.total_marks);
		formData.append('marks_obtained', data.getAssignMarkData.marks_obtained);
		formData.append('category', data.category);
		formData.append('submission_date', data.submission_date);

		$http.post(BASE_URL+'api/school/project/assignMarks',formData,{
			transformRequest: angular.identity,
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.result = response.data.data;
				$scope.getSubmitedProjectDetails();
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: response.data.message
					});
					return false;
				}();
			}
			
			}, function errorCallback(response){
				console.log(response);
				var Gritter = function () {
					$.gritter.add({
						title: 'Error',
						text: response.data.message
					}	);
					return false;
				}();
		});
	}
	$scope.isEdit=0;
	$scope.feedbackButton="Submit";
	$scope.editFeedBack=function(){
		$scope.isEdit=1;
	}
	$scope.updateProjectFeedback=function(id,feedback){
		var formData = new FormData();
		formData.append('id', id);
		formData.append('feedback',feedback );
		$http.post(BASE_URL+'api/school/project/updateProjectFeedback',formData,{
			transformRequest: angular.identity,
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.result = response.data.data;
				$scope.isEdit=0;
				if($scope.feedback!=''){
					$scope.feedbackButton="Update";
				}else{
					$scope.feedbackButton="Submit";
				}
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: response.data.message
					});
					$scope.errormsg = '';
					return false;
				}();
			}
			
			}, function errorCallback(response){
				var Gritter = function () {
					$.gritter.add({
						title: 'Error',
						text: response.data.message
					}	);
					$scope.errormsg = '';
					return false;
				}();
				$scope.isEdit=1;
		});

	}
	$scope.submitprojectdownload=function(id,user_id) {
		//alert(user_id);
		$window.location.href = BASE_URL+'download/submitprojectdownload/'+id+'/'+user_id;
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
	var sid;
	$scope.assignmentID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.assignmentID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.assignmentID;
	};	
	$timeout($scope.setID(), 2000);
	$scope.assignmentinfo = false;
	$scope.getSubmitedProjectDetails = function()
	{
		var formData = {'id':$scope.assignmentID}
		$http.post(BASE_URL+'api/school/project/getSubmitedProjectDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{   
				var attachmentSplit;
				var attachtypeSplit;
				$scope.attachmentArray=[];
				$scope.assignmentinfo = response.data.data;
				$scope.id=$scope.assignmentinfo.id;
				$scope.category=$scope.assignmentinfo.category;
				$scope.total_marks=$scope.assignmentinfo.total_marks;
				$scope.assignmentname=$scope.assignmentinfo.title;
				$scope.class=$scope.assignmentinfo.classname;
				$scope.studentname=$scope.assignmentinfo.studentname;
				$scope.submissiondate=$scope.assignmentinfo.submission_date;
				$scope.lastsubmissiondate=$scope.assignmentinfo.sdate;
				$scope.description=$scope.assignmentinfo.description;
				$scope.feedback=$scope.assignmentinfo.feedback;
				if($scope.feedback!=''){
					$scope.feedbackButton="Update";
				}else{
					$scope.feedbackButton="Submit";
				}
				$scope.subject=$scope.assignmentinfo.subject;
				$scope.dateofissue=$scope.assignmentinfo.dateofissue;
				$scope.attachment=$scope.assignmentinfo.saattachment;
				$scope.attachmenttype=$scope.assignmentinfo.saattachmenttype;
				if($scope.attachment!=''){
				var attachmentSplit=$scope.attachment.split(',');
				for(var i = 0; i < attachmentSplit.length; i++)
				{
					$scope.attachmentArray.push({ 
						'attachment':attachmentSplit[i],
						'downloadurl':BASE_URL+'img/submitproject/'+attachmentSplit[i]
					});
					
				}
				}
			}
			
			}, function errorCallback(response){
				$scope.assignmentinfo=[];
				$scope.attachmentArray=[];
		});
		
	}
	$scope.getSubmitedProjectDetails();
}
function editProjectCtrl($scope, $http, $routeParams, $window,$timeout) 
{
	$scope.categoryData=[{'name':'Graded','val':'graded'},{'name':'Non-Graded','val':'non-graded'}];
	var file_not_allowed_msg="Only jpeg,jpg,png,doc file supported.";
	var validImageTypes=new Array('image/jpeg','image/jpg','image/png','application/pdf','application/doc','application/docx');
	$scope.previewImages	= [];
	$scope.PreviewImage=[];
	$scope.SelectFile = function (e) {
	for(var i=0;i<e.target.files.length;i++){
		var type;
		var reader = new FileReader();
		reader.fileName = e.target.files[i].name;
		if (( !validImageTypes.includes(e.target.files[i].type) ) )
		{
			//$window.alert(file_not_allowed_msg);
			//return false;
		}
		$scope.previewImages.push(e.target.files[i]);
		
		reader.onload = function (e) {
		$scope.PreviewImage.push({'name':e.target.fileName});
		$scope.$apply();
		};
		reader.readAsDataURL(e.target.files[i]);
	}
	}
	
	$scope.remove=function(data){
		var index= $scope.PreviewImage.indexOf(data);
		$scope.PreviewImage.splice(data, 1);	
		$scope.previewImages.splice(data, 1);				
	}
	var sid;
	$scope.assignmentID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.assignmentID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.assignmentID;
	};	
	$timeout($scope.setID(), 2000);
	$scope.convertDateNewFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [date.getFullYear(), mnth, day].join("-");
	}
	$scope.removeEdit=function(data,index){
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':data.id,'filename':data.attachment};
			$http.post(BASE_URL+'api/school/project/deleteAttachmentAttachData',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
				
				if(response.status == 200)
				{
					var result  = response.data;
					var Gritter = function () {
						$.gritter.add({
							title: 'Successfull',
							text: result.message
						});
						if (index > -1) {
						$scope.attachmentArray.splice(index, 1);;
						return false;
						}
					}();
				}
				
				}, function errorCallback(response){
				
			});
		} 
	}
	$scope.category='';
	$scope.total_marks='';
	$scope.class_id='';
	$scope.subject='';
	$scope.title='';
	$scope.no_of_attampt='';
	$scope.date='';
	$scope.opendate='';
	$scope.description='';
	$scope.getProjectDetails = function()
	{
		var formData = {'id':$scope.assignmentID}
		$http.post(BASE_URL+'api/school/project/getProjectDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.assignmentinfo = response.data.data;
				$scope.subject=$scope.assignmentinfo.subject_id;
				$scope.class_id=$scope.assignmentinfo.class_id;
				$scope.getTeacherSubject();
				$scope.category=$scope.assignmentinfo.category;
				$scope.total_marks=$scope.assignmentinfo.total_marks;
				$scope.title=$scope.assignmentinfo.title;
				$scope.no_of_attampt=$scope.assignmentinfo.no_of_attempt;
				$scope.description=$scope.assignmentinfo.description;
				$scope.date=new Date($scope.assignmentinfo.submission_date);
				if($scope.assignmentinfo.open_submission_date!=null){
				$scope.opendate=new Date($scope.assignmentinfo.open_submission_date);
				}
				$scope.attachmentArray=[];
				if($scope.assignmentinfo.attachid!=null){
				$scope.attachment=$scope.assignmentinfo.attachment;
				$scope.attachment_type=$scope.assignmentinfo.attachment_type;
				var attachmentSplit=$scope.attachment.split(',');
				var attachtypeSplit=$scope.attachment_type.split(',');
				var atchid=$scope.assignmentinfo.attachid.split(',');
				for(var i = 0; i < attachmentSplit.length; i++)
				{
					$scope.attachmentArray.push({ 
						'id':atchid[i],
						'attachment':attachmentSplit[i]
					});
					
				}
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getProjectDetails();
	$scope.getTeacherSubjectClass=function(){
		var formData={'classID':''}
		$http.post(BASE_URL+'api/school/project/getTeacherSubjectClass',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.classData = response.data.data;
			}
			}, function errorCallback(response){
				$scope.classData=[];
		});
	}
	$scope.getTeacherSubjectClass();
	$scope.getTeacherSubject=function(){
		var formData={'classID':$scope.class_id}
		$http.post(BASE_URL+'api/school/project/getTeacherSubject',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.subjectData = response.data.data;
			}
			}, function errorCallback(response){
				$scope.subjectData=[];
		});
	}
	$scope.editProject=function(){
		if($scope.class_id == '')
		{
			$scope.errormsg = 'Class is required.';
			return false;
		}else if($scope.subject == '')
		{
			$scope.errormsg = 'Subject is required.';
			return false;
		}else if($scope.category=='')
		{
			$scope.errormsg = 'Project category is required.';
			return false;
		}else if($scope.title=='')
		{
			$scope.errormsg = 'Project name is required.';
			return false;
		}else if($scope.total_marks=='')
		{
			$scope.errormsg = 'Project total marks is required.';
			return false;
		}else if($scope.date=='')
		{
			$scope.errormsg = 'Submission date is required.';
			return false;
		}else if($scope.description=='')
		{
			$scope.errormsg = 'Description is required.';
			return false;
		} 
		$scope.showLoader=1;
		var formData = new FormData();
		formData.append('school_id', School_ID);
		formData.append('category', $scope.category);
		formData.append('total_marks', $scope.total_marks);
		formData.append('assignmentID', $scope.assignmentID);
		formData.append('subject_id', $scope.subject);
		formData.append('class_id', $scope.class_id);
		formData.append('title', $scope.title);
		formData.append('no_of_attampt', $scope.no_of_attampt);
		formData.append('date', $scope.convertDateNewFormat($scope.date));
		formData.append('old_due_date',$scope.assignmentinfo.submission_date);
		if($scope.opendate!=''){
			$scope.opendate=$scope.convertDateNewFormat($scope.opendate);
		}
		formData.append('opendate', $scope.opendate);
		formData.append('description', $scope.description);
		if($scope.previewImages.length > 0)
		{
			for(var i = 0; i < $scope.previewImages.length; i++)
			{ 
				formData.append('files[]', $scope.previewImages[i]);
			}
		}
		
		$http.post(BASE_URL+'api/school/project/editProject',formData,{
			transformRequest: angular.identity,
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.showLoader=0;
				$scope.result = response.data.data;
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: response.data.message
					});
					$scope.errormsg = '';
					return false;
				}();
				$window.location.href = '#!/project-list';
			}
			
			}, function errorCallback(response){
				$scope.showLoader=0;
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
function schoolAssignmentCtrl($scope, $http, $route, $timeout,$window) 
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
	$scope.class_id='';
	$scope.subject_id='';
	$scope.category='';
	$scope.datefilter='';
	$scope.classArray=[];
	$scope.subjectArray=[];
	$scope.categoryArray=[];
	$scope.getAssignmentList=function(){
		var formData={'class_id':$scope.class_id,'subject_id':$scope.subject_id,'category':$scope.category,'filterbydate':''}
		// var formData={'school_id':School_ID}
		$http.post(BASE_URL+'api/assignment/getAssignmentList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.assignmentData = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.assignmentData.length; i++)
				{
					encrypted = $scope.encryptStr($scope.assignmentData[i].id);
					$scope.assignmentData[i]['assignmentID'] = encrypted;
					$scope.assignmentData[i]['currDate'] = new Date();
					$scope.classArray.push({
						'id':$scope.assignmentData[i].class_id,
						'name':$scope.assignmentData[i].classname
					});
					$scope.subjectArray.push({
						'id':$scope.assignmentData[i].subject_id,
						'name':$scope.assignmentData[i].subject
					});
					$scope.categoryArray.push({
						'name':$scope.assignmentData[i].category
					});
				}
			}
			// console.log($scope.assignmentData);
			}, function errorCallback(response){
				$scope.assignmentData=[];
		});
	}
	$scope.getAssignmentList();
	$scope.deleteAssignment = function(ID,index)
	{
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':ID};
			$http.post(BASE_URL+'api/assignment/deleteAssignment',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
				
				if(response.status == 200)
				{
					var result  = response.data;
					var Gritter = function () {
						$.gritter.add({
							title: 'Successfull',
							text: response.data.message
						});
						$scope.getAssignmentList();
						//$scope.classboardPostData.splice(index, 1);;
						return false;
					}();
				}
				
				}, function errorCallback(response){
				
			});
		}
	}
} 
function allAssignmentCtrl($scope, $http, $routeParams, $timeout,$window) 
{
	$scope.assignmentdownload=function(id) {
		$window.location.href = BASE_URL+'download/assignmentdownload/'+id;
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
	var sid;
	$scope.assignmentID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.assignmentID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.assignmentID;
	};	
	$timeout($scope.setID(), 2000);
	$scope.assignmentinfo = false;
	$scope.getAssignmentDetails = function()
	{
		var formData = {'id':$scope.assignmentID}
		$http.post(BASE_URL+'api/assignment/getAssignmentDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{   
				var encrypted;
				$scope.assignmentinfo = response.data.data;
				encrypted = $scope.encryptStr($scope.assignmentinfo.id);
				$scope.viewassignmentID = encrypted;
				$scope.category=$scope.assignmentinfo.category;
				$scope.total_marks=$scope.assignmentinfo.total_marks;
				$scope.assignmentname=$scope.assignmentinfo.title;
				$scope.class=$scope.assignmentinfo.classname;
				$scope.submissiondate=$scope.assignmentinfo.submission_date;
				$scope.description=$scope.assignmentinfo.description;
				$scope.subject=$scope.assignmentinfo.subject;
				$scope.dateofissue=$scope.assignmentinfo.created;
				$scope.openassignmentdate=$scope.assignmentinfo.open_submission_date;
				$scope.attachment=$scope.assignmentinfo.attachment;
				$scope.attachment_type=$scope.assignmentinfo.attachment_type;
				var attachmentSplit=$scope.attachment.split(',');
				var attachtypeSplit=$scope.attachment_type.split(',');
				$scope.attachmentArray=[];
				for(var i = 0; i < attachmentSplit.length; i++)
				{
					$scope.attachmentArray.push({ 
						'attachment':attachmentSplit[i],
						'type':attachtypeSplit,
						'downloadurl':BASE_URL+'img/assignment/'+attachmentSplit[i]
					});
					
				}
				$scope.currDate = new Date();
			}
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAssignmentDetails();
	
	
}
function createAssignmentCtrl($scope, $http, $route, $timeout,$window) 
{
	$scope.categoryData=[{'name':'Graded','val':'graded'},{'name':'Non-Graded','val':'non-graded'}];
	var file_not_allowed_msg="Only jpeg,jpg,png,doc file supported.";
	var validImageTypes=new Array('image/jpeg','image/jpg','image/png','application/pdf','application/doc','application/docx');
	$scope.previewImages=[];
	$scope.PreviewImage=[];
	$scope.SelectFile = function (e) {
	for(var i=0;i<e.target.files.length;i++){
		var type;
		var reader = new FileReader();
		reader.fileName = e.target.files[i].name;
		if (( !validImageTypes.includes(e.target.files[i].type) ) )
		{
			//$window.alert(file_not_allowed_msg);
			//return false;
		}
		$scope.previewImages.push(e.target.files[i]);
		
		reader.onload = function (e) {
		$scope.PreviewImage.push({'name':e.target.fileName});
		$scope.$apply();
		};
		reader.readAsDataURL(e.target.files[i]);
	}
	}
	
	$scope.remove=function(data){
		var index= $scope.PreviewImage.indexOf(data);
		$scope.PreviewImage.splice(data, 1);	
		$scope.previewImages.splice(data, 1);				
	}
	$scope.category='';
	$scope.total_marks='';
	$scope.class_id='';
	$scope.subject='';
	$scope.title='';
	$scope.date='';
	$scope.opendate='';
	$scope.no_of_attampt='';
	$scope.description='';
	$scope.showLoader=0;
	$scope.convertDateNewFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [date.getFullYear(), mnth, day].join("-");
	}
	$scope.createAssignment=function(){
		if($scope.class_id == '')
		{
			$scope.errormsg = 'Class is required.';
			return false;
		}else if($scope.subject == '')
		{
			$scope.errormsg = 'Subject is required.';
			return false;
		}else if($scope.category=='')
		{
			$scope.errormsg = 'Assignment category is required.';
			return false;
		}
		else if($scope.title=='')
		{
			$scope.errormsg = 'Assignment name is required.';
			return false;
		}else if($scope.total_marks=='')
		{
			$scope.errormsg = 'Total marks is required.';
			return false;
		}else if($scope.date=='')
		{
			$scope.errormsg = 'Submission date is required.';
			return false;
		}else if($scope.description=='')
		{
			$scope.errormsg = 'Description is required.';
			return false;
		} 
		$scope.showLoader=1;
		var formData = new FormData();
		formData.append('school_id', School_ID);
		formData.append('class_id', $scope.class_id);
		formData.append('subject_id', $scope.subject);
		formData.append('category', $scope.category);
		formData.append('total_marks', $scope.total_marks);
		formData.append('title', $scope.title);
		formData.append('no_of_attampt', $scope.no_of_attampt);
		formData.append('date', $scope.convertDateNewFormat($scope.date));
		if($scope.opendate!=''){
			$scope.opendate=$scope.convertDateNewFormat($scope.opendate);
		}
		formData.append('opendate', $scope.opendate);
		formData.append('description', $scope.description);
		if($scope.previewImages.length > 0)
		{
			for(var i = 0; i < $scope.previewImages.length; i++)
			{ 
				formData.append('files[]', $scope.previewImages[i]);
			}
		}
		
		$http.post(BASE_URL+'api/assignment/createAssignment',formData,{
			transformRequest: angular.identity,
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.showLoader=0;
				$scope.result = response.data.data;
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: response.data.message
					});
					$scope.errormsg = '';
					return false;
				}();
				$window.location.href = '#!/assignment-list';
			}
			
			}, function errorCallback(response){
				$scope.showLoader=0;
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
	
	$scope.getSchoolSubjectClass=function(){
		var formData={'classID':'','school_id':School_ID}
		$http.post(BASE_URL+'api/assignment/getSchoolSubjectClass',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.classData = response.data.data;
			}
			}, function errorCallback(response){
				$scope.classData=[];
		});
	}
	$scope.getSchoolSubjectClass();

	$scope.getSchoolSubject=function(){
		var formData={'classID':$scope.class_id,'school_id':School_ID}
		$http.post(BASE_URL+'api/assignment/getSchoolSubject',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.subjectData = response.data.data;
			}
			}, function errorCallback(response){
				$scope.subjectData=[];
		});
	}
}
function editAssignmentCtrl($scope, $http, $routeParams, $window,$timeout) 
{
	$scope.categoryData=[{'name':'Graded','val':'graded'},{'name':'Non-Graded','val':'non-graded'}];
	var file_not_allowed_msg="Only jpeg,jpg,png,doc file supported.";
	var validImageTypes=new Array('image/jpeg','image/jpg','image/png','application/pdf','application/doc','application/docx');
	$scope.previewImages	= [];
	$scope.PreviewImage=[];
	$scope.SelectFile = function (e) {
	for(var i=0;i<e.target.files.length;i++){
		var type;
		var reader = new FileReader();
		reader.fileName = e.target.files[i].name;
		if (( !validImageTypes.includes(e.target.files[i].type) ) )
		{
			//$window.alert(file_not_allowed_msg);
			//return false;
		}
		$scope.previewImages.push(e.target.files[i]);
		
		reader.onload = function (e) {
		$scope.PreviewImage.push({'name':e.target.fileName});
		$scope.$apply();
		};
		reader.readAsDataURL(e.target.files[i]);
	}
	}
	
	$scope.remove=function(data){
		var index= $scope.PreviewImage.indexOf(data);
		$scope.PreviewImage.splice(data, 1);	
		$scope.previewImages.splice(data, 1);				
	}
	var sid;
	$scope.assignmentID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.assignmentID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.assignmentID;
	};	
	$timeout($scope.setID(), 2000);
	$scope.convertDateNewFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [date.getFullYear(), mnth, day].join("-");
	}
	$scope.removeEdit=function(data,index){
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':data.id,'filename':data.attachment};
			$http.post(BASE_URL+'api/teachers/assignment/deleteAttachmentAttachData',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
				
				if(response.status == 200)
				{
					var result  = response.data;
					var Gritter = function () {
						$.gritter.add({
							title: 'Successfull',
							text: result.message
						});
						if (index > -1) {
						$scope.attachmentArray.splice(index, 1);;
						return false;
						}
					}();
				}
				
				}, function errorCallback(response){
				
			});
		} 
	}
	$scope.category='';
	$scope.total_marks='';
	$scope.class_id='';
	$scope.subject='';
	$scope.title='';
	$scope.no_of_attampt='';
	$scope.date='';
	$scope.opendate='';
	$scope.description='';
	$scope.getAssignmentDetails = function()
	{
		var formData = {'id':$scope.assignmentID}
		$http.post(BASE_URL+'api/assignment/getAssignmentDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.assignmentinfo = response.data.data;
				$scope.subject=$scope.assignmentinfo.subject_id;
				$scope.class_id=$scope.assignmentinfo.class_id;
				$scope.getSchoolSubject();
				$scope.category=$scope.assignmentinfo.category;
				$scope.total_marks=$scope.assignmentinfo.total_marks;
				$scope.title=$scope.assignmentinfo.title;
				$scope.no_of_attampt=$scope.assignmentinfo.no_of_attempt;
				$scope.description=$scope.assignmentinfo.description;
				$scope.date=new Date($scope.assignmentinfo.submission_date);
				if($scope.assignmentinfo.open_submission_date!=null){
				$scope.opendate=new Date($scope.assignmentinfo.open_submission_date);
				}
				$scope.attachmentArray=[];
				if($scope.assignmentinfo.attachid!=null){
				$scope.attachment=$scope.assignmentinfo.attachment;
				$scope.attachment_type=$scope.assignmentinfo.attachment_type;
				var attachmentSplit=$scope.attachment.split(',');
				var attachtypeSplit=$scope.attachment_type.split(',');
				var atchid=$scope.assignmentinfo.attachid.split(',');
				for(var i = 0; i < attachmentSplit.length; i++)
				{
					$scope.attachmentArray.push({ 
						'id':atchid[i],
						'attachment':attachmentSplit[i]
					});
					
				}
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getAssignmentDetails();
	$scope.getSchoolSubjectClass=function(){
		var formData={'classID':'','school_id':School_ID}
		$http.post(BASE_URL+'api/assignment/getSchoolSubjectClass',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.classData = response.data.data;
			}
			}, function errorCallback(response){
				$scope.classData=[];
		});
	}
	$scope.getSchoolSubjectClass();

	$scope.getSchoolSubject=function(){
		var formData={'classID':$scope.class_id,'school_id':School_ID}
		$http.post(BASE_URL+'api/assignment/getSchoolSubject',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.subjectData = response.data.data;
			}
			}, function errorCallback(response){
				$scope.subjectData=[];
		});
	}
	$scope.editAssignment=function(){
		if($scope.class_id == '')
		{
			$scope.errormsg = 'Class is required.';
			return false;
		}else if($scope.subject == '')
		{
			$scope.errormsg = 'Subject is required.';
			return false;
		}else if($scope.category=='')
		{
			$scope.errormsg = 'Assignment category is required.';
			return false;
		}else if($scope.title=='')
		{
			$scope.errormsg = 'Assignment name is required.';
			return false;
		}else if($scope.total_marks=='')
		{
			$scope.errormsg = 'Total marks is required.';
			return false;
		}else if($scope.date=='')
		{
			$scope.errormsg = 'Submission date is required.';
			return false;
		}else if($scope.description=='')
		{
			$scope.errormsg = 'Description is required.';
			return false;
		} 
		$scope.showLoader=1;
		var formData = new FormData();
		formData.append('school_id', School_ID);
		formData.append('assignmentID', $scope.assignmentID);
		formData.append('subject_id', $scope.subject);
		formData.append('class_id', $scope.class_id);
		formData.append('category', $scope.category);
		formData.append('title', $scope.title);
		formData.append('total_marks', $scope.total_marks);
		formData.append('no_of_attampt', $scope.no_of_attampt);
		formData.append('date', $scope.convertDateNewFormat($scope.date));
		formData.append('old_due_date',$scope.assignmentinfo.submission_date);
		if($scope.opendate!=''){
			$scope.opendate=$scope.convertDateNewFormat($scope.opendate);
		}
		formData.append('opendate', $scope.opendate);
		formData.append('description', $scope.description);
		if($scope.previewImages.length > 0)
		{
			for(var i = 0; i < $scope.previewImages.length; i++)
			{ 
				formData.append('files[]', $scope.previewImages[i]);
			}
		}
		
		$http.post(BASE_URL+'api/assignment/editAssignment',formData,{
			transformRequest: angular.identity,
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.showLoader=0;
				$scope.result = response.data.data;
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: response.data.message
					});
					$scope.errormsg = '';
					return false;
				}();
				$window.location.href = '#!/assignment-list';
			}
			
			}, function errorCallback(response){
				$scope.showLoader=0;
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
function submitedAssignmentCtrl($scope, $http, $route, $timeout,$window) 
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
	$scope.class_id='';
	$scope.subject_id='';
	$scope.category='';
	$scope.classArray=[];
	$scope.subjectArray=[];
	$scope.categoryArray=[];
	$scope.getStudentSubmitedAssignmentList=function(){
		var formData={'schoolID':School_ID,'class_id':$scope.class_id,'subject_id':$scope.subject_id,'category':$scope.category}
		$http.post(BASE_URL+'api/assignment/getStudentSubmitedAssignmentList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.studentSubmitAssignmentData = response.data.data;
				console.log($scope.studentSubmitAssignmentData);
				var encrypted ;
				for(var i = 0; i < $scope.studentSubmitAssignmentData.length; i++)
				{
					encrypted = $scope.encryptStr($scope.studentSubmitAssignmentData[i].asid);
					$scope.studentSubmitAssignmentData[i]['assignmentID'] = encrypted;
					$scope.classArray.push({
						'id':$scope.studentSubmitAssignmentData[i].class_id,
						'name':$scope.studentSubmitAssignmentData[i].classname
					});
					$scope.subjectArray.push({
						'id':$scope.studentSubmitAssignmentData[i].subject_id,
						'name':$scope.studentSubmitAssignmentData[i].subject
					});
					$scope.categoryArray.push({
						'name':$scope.studentSubmitAssignmentData[i].category
					});
				}
				$scope.currDate = new Date();
			}
			}, function errorCallback(response){
			
		});
	}
	$scope.getStudentSubmitedAssignmentList();
	
} 
function allSubmitedAssignmentCtrl($scope, $http, $routeParams, $timeout,$window) 
{
	$scope.assignMarks=function(data){
		var formData = new FormData();
		formData.append('title', data.title);
		formData.append('user_id', data.user_id);
		formData.append('submission_id', data.id);
		formData.append('assignment_id', data.assignment_id);
		formData.append('school_id', data.school_id);
		formData.append('class_id', data.class_id);
		formData.append('subject_id', data.subject_id);
		formData.append('total_marks', data.total_marks);
		formData.append('marks_obtained', data.getAssignMarkData.marks_obtained);
		formData.append('category', data.category);
		formData.append('submission_date', data.submission_date);
		
		$http.post(BASE_URL+'api/teachers/assignment/assignMarks',formData,{
			transformRequest: angular.identity,
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.result = response.data.data;
				$scope.getSubmitedAssignmentDetails();
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: response.data.message
					});
					return false;
				}();
			}
			
			}, function errorCallback(response){
				console.log(response);
				var Gritter = function () {
					$.gritter.add({
						title: 'Error',
						text: response.data.message
					}	);
					return false;
				}();
		});
	}
	$scope.isEdit=0;
	$scope.feedbackButton="Submit";
	$scope.editFeedBack=function(){
		$scope.isEdit=1;
	}
	$scope.updateAssignmentFeedback=function(id,feedback){
		var formData = new FormData();
		formData.append('id', id);
		formData.append('feedback',feedback );
		$http.post(BASE_URL+'api/teachers/assignment/updateAssignmentFeedback',formData,{
			transformRequest: angular.identity,
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.result = response.data.data;
				$scope.isEdit=0;
				if($scope.feedback!=''){
					$scope.feedbackButton="Update";
				}else{
					$scope.feedbackButton="Submit";
				}
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: response.data.message
					});
					$scope.errormsg = '';
					return false;
				}();
			}
			
			}, function errorCallback(response){
				var Gritter = function () {
					$.gritter.add({
						title: 'Error',
						text: response.data.message
					}	);
					$scope.errormsg = '';
					return false;
				}();
				$scope.isEdit=1;
		});

	}
	$scope.submitassignmentdownload=function(id,user_id) {
		//alert(user_id);
		$window.location.href = BASE_URL+'download/submitassignmentdownload/'+id+'/'+user_id;
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
	var sid;
	$scope.assignmentID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.assignmentID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.assignmentID;
	};	
	$timeout($scope.setID(), 2000);
	$scope.assignmentinfo = false;
	$scope.getSubmitedAssignmentDetails = function()
	{
		var formData = {'id':$scope.assignmentID}
		$http.post(BASE_URL+'api/teachers/assignment/getSubmitedAssignmentDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{   
				var attachmentSplit;
				var attachtypeSplit;

				$scope.attachmentArray=[];
				$scope.assignmentinfo = response.data.data;
				$scope.id=$scope.assignmentinfo.id;
				$scope.category=$scope.assignmentinfo.category;
				$scope.total_marks=$scope.assignmentinfo.total_marks;
				$scope.assignmentname=$scope.assignmentinfo.title;
				$scope.class=$scope.assignmentinfo.classname;
				$scope.studentname=$scope.assignmentinfo.studentname;
				$scope.submissiondate=$scope.assignmentinfo.submission_date;
				$scope.lastsubmissiondate=$scope.assignmentinfo.sdate;
				$scope.description=$scope.assignmentinfo.description;
				$scope.feedback=$scope.assignmentinfo.feedback;
				//$scope.marks_obtained=$scope.assignmentinfo.getAssignMarkData.marks_obtained;
				//$scope.grade.grade=$scope.assignmentinfo.getAssignMarkData.grade;
				if($scope.feedback!=''){
					$scope.feedbackButton="Update";
					//$scope.isEdit=0;
				}else{
					//$scope.isEdit=1;
					$scope.feedbackButton="Submit";
				}
				$scope.subject=$scope.assignmentinfo.subject;
				$scope.dateofissue=$scope.assignmentinfo.dateofissue;
				$scope.attachment=$scope.assignmentinfo.saattachment;
				$scope.attachmenttype=$scope.assignmentinfo.saattachmenttype;
				if($scope.attachment!=''){
				var attachmentSplit=$scope.attachment.split(',');
				for(var i = 0; i < attachmentSplit.length; i++)
				{
					$scope.attachmentArray.push({ 
						'attachment':attachmentSplit[i],
						'downloadurl':BASE_URL+'img/submitassignment/'+attachmentSplit[i]
					});
					
				}
				}
			}
			
			}, function errorCallback(response){
				$scope.assignmentinfo=[];
				$scope.attachmentArray=[];
		});
		
	}
	$scope.getSubmitedAssignmentDetails();
}

function resultCtrl($scope,$http,$window,$routeParams,$timeout)
{
	$scope.classList = [];
	$scope.sessionList = [];
	$scope.sessionID='';

	$scope.getAllSession = function(){
		$http.get(BASE_URL+'api/user/getAllSchoolSession?school_id='+School_ID,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.sessionList=response.data.data;
				$scope.sessionID=$scope.sessionList[0].id;
				$scope.calculateStudentsResult();
				
			}
			
			}, function errorCallback(error){
				$scope.sessionList=[];
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
	};
	$scope.getAllSession();
	$scope.getAllClassForSchool = function()
	{
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllClassForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.classList = response.data.data;
			}
			// console.log($scope.classList);
			}, function errorCallback(response){
		});
	}
	$scope.getAllClassForSchool();	
	
	$scope.calculateStudentsResult = function()
	{
		//alert($scope.sessionID);
		// $scope.studentResult = [];
		var formData = {'session_id':$scope.sessionID,'school_id':School_ID};
		$http.post(BASE_URL+'api/school/result/calculateStudentsResult',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.getStudentsResultList();
			}
			// console.log(studentResult);
			}, function errorCallback(response){
				$scope.getStudentsResultList();
		});
		
	}
	//$scope.calculateStudentsResult();


	$scope.getStudentsResultList = function()
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

		$scope.studentsList = [];
		var formData = {'school_id':School_ID,class_id:$scope.class_id,sessionID:$scope.sessionID};
		$http.post(BASE_URL+'api/school/result/getStudentsResultList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.termsList = response.data.data.termsList;
				$scope.studentsList = response.data.data.studentsList;
				
				for(var i =0; i < $scope.studentsList.length; i++)
	            {
	                $scope.studentsList[i]['student_id'] = $scope.studentsList[i].studentID;
	                $scope.studentsList[i]['studentID'] = $scope.encryptStr($scope.studentsList[i].studentID);
	    		}
			}
			// console.log($scope.studentsList); 
			// console.log($scope.termsList);
			}, function errorCallback(response){
		});
	}	

	$scope.generateResult = function(student_id)
	{
		var formData = {'session_id':$scope.sessionID,'school_id':School_ID,'student_id':student_id};
		$http.post(BASE_URL+'api/school/result/generateStudentResult',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
				if(response.status == 200)
				{
					var Gritter = function () {
						$.gritter.add({
							title: 'success',
							text: `Result has been generated successfully.`
						});
						$scope.calculateStudentsResult();
						  /* setTimeout(function() { location.reload();  }, 2000);
					*/
						}();
				}
			}, function errorCallback(response){
				if(response.status == 400)
				{
					var Gritter = function () {
						$.gritter.add({
							title: 'Failed',
							text: `Something went wrong.`
						});
					  	return false;
					}();
					// $scope.totalTermResult = response.data.data;
				}
		});
	}
        
        
      function isKeyExists(obj,key){
        if( obj[key] == undefined ){
        return false;
        }else{
        return true;
        }
        }  
        
       $scope.exportResult = function()
       {
        var searchingData = $scope.studentsList;
        var userdata = [];
         if(searchingData.length>0){
         for(var i=0;i<searchingData.length;i++){
            var termList = [];  
            var term1 = "";
            var term2 = "";
            var term3 = "";
            var term4 = "";
            var total = "";
            
            var stud_name = searchingData[i]['stud_name'] ? searchingData[i]['stud_name'] : ''; 
            var father_name = searchingData[i]['father_name'] ? searchingData[i]['father_name'] : '';
            var mother_name = searchingData[i]['mother_name'] ? searchingData[i]['mother_name'] : ''; 
            var classSec = searchingData[i]['class'] ? searchingData[i]['class'] : ''; 
            var teacher_name = searchingData[i]['teacher_name'] ? searchingData[i]['teacher_name'] : ''; 
            if(isKeyExists(searchingData[i],"termListData")){
             termList = searchingData[i].termListData;
             }
           
             total = searchingData[i].overall_marks_obtain ? searchingData[i].overall_marks_obtain+'/'+searchingData[i].overall_total_marks: 'N/A';
             
            if(termList.length>0) {
            console.log(termList);
                for(var k=0;k<termList.length;k++)
                {
					console.log(termList[k]['obtainTermMarks']);
                   /*if(termList[k]['term_id']=='1') {
                   term1 = termList[k]['obtainTermMarks'] ? termList[k]['obtainTermMarks']+'/'+termList[k]['totalTermMarks']: 'N/A'; 
				  }*/
				   if(k==0) {
					term1 = termList[k]['obtainTermMarks'] ? termList[k]['obtainTermMarks']+'/'+termList[k]['totalTermMarks']: 'N/A'; 
				   }
                   if(k==2) {
                   term2 = termList[k]['obtainTermMarks'] ? termList[k]['obtainTermMarks']+'/'+termList[k]['totalTermMarks']: 'N/A'; 
                  }
                   if(k==2) {
                   term3 = termList[k]['obtainTermMarks'] ? termList[k]['obtainTermMarks']+'/'+termList[k]['totalTermMarks']: 'N/A';   
                  }
                   if(k==3) {
                   term4 = termList[k]['obtainTermMarks'] ? termList[k]['obtainTermMarks']+'/'+termList[k]['totalTermMarks']: 'N/A'; 
                  }
                }
                       
            }
            
            userdata[i] = [
                stud_name.replace(/,|\n|_/g,'/'),
                father_name.replace(/,|\n|_/g,'/'),
                mother_name.replace(/,|\n|_/g,'/'),
                classSec.replace(/,|\n|_/g,'/'),
                teacher_name.replace(/,|\n|_/g,'/'),
                term1.replace(/,|\n|_/g,'/'),
                term2.replace(/,|\n|_/g,'/'),
                term3.replace(/,|\n|_/g,'/'),
                term4.replace(/,|\n|_/g,'/'),
                total.replace(/,|\n|_/g,'/'),
                ]
           }
            //console.log(userdata);
            
                var csv = 'Student Name,Father Name,Mother Name,Class,Class Teacher,Term 1,Term 2,Term 3, Term 4,Total\n';
                userdata.forEach(function(row) {
                csv += row.join(',');
                csv += "\n";
                });

                //console.log(csv);
                var hiddenElement = document.createElement('a');
                hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
                hiddenElement.target = '_blank';
                hiddenElement.download = 'result-list.csv';
                hiddenElement.click();
         }
         else {
            var Gritter = function () {
            $.gritter.add({
            title: 'Error',
            text: `You don't have any data into the list to import.`
            });
            return false;
            }(); 
         }
    };    
        
        
        
}
function resultDetailsCtrl($scope,$http,$window,$routeParams,$timeout)
{
	// Single time refresh the page
	var refresh = $window.localStorage.getItem('refresh');
	if (refresh===null){
	   $window.location.reload();
	    $window.localStorage.setItem('refresh', "1");
	}

	// var foo = true;
 //        if (foo){
 //            $window.location.reload(true);
 //            foo = false;
 //    }

	var sid;
	$scope.studentID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.studentID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.studentID;
	};	
	$timeout($scope.setID(), 2000);
	// alert($scope.studentID);

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
	
	$scope.approveDisapproveActivityResult = function(activity)
	{
		$http.post(BASE_URL+'api/user/activityResultIsApproved',activity,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Success',
						text: response.data.message
					});
					return false;
					}();
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
					
					}else{
						var Gritter = function () {
							$.gritter.add({
								title: 'Error',
								text: error.data.message
							});
							return false;
							}();
					}
		});
	}
	$scope.updateActivities = function(activity,key1='',key2='',key3='',key4='')
	{
		activity.is_beginner=key1;
		activity.is_intermediate=key2;
		activity.is_advanced=key3;
		activity.is_expert=key4;
		console.log(activity);
		$http.post(BASE_URL+'api/user/activityResultUpdate',activity,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				/* var Gritter = function () {
					$.gritter.add({
						title: 'Success',
						text: response.data.message
					});
					return false;
					}();
					*/
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
	// Calculate Term wise total marks
	$scope.calculateSubjectTermResult = function()
	{
		$scope.totalTermResult = [];
		var formData = {'session_id':$routeParams.SESSIONID,'school_id':School_ID,'student_id':$scope.studentID};
		$http.post(BASE_URL+'api/school/result/calculateSubjectTermResult',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.totalTermResult = response.data.data;
			}
			// console.log($scope.totalTermResult);
			}, function errorCallback(response){
			
		});
		
	}
	$scope.calculateSubjectTermResult();

	// Calculate Grand total marks on subjects wise
	$scope.getSubjectGrandsResult = function()
	{
		$scope.totalGrandResult = [];
		$scope.grandTotalMarks	    = [];
		var formData = {'session_id':$routeParams.SESSIONID,'school_id':School_ID,'student_id':$scope.studentID};
		$http.post(BASE_URL+'api/school/result/getSubjectGrandsResult',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.totalGrandResult = response.data.data.finalDataArr;
				$scope.grandTotalMarks	= response.data.data.grandTotal;
			}
			// console.log($scope.totalGrandResult);
			// console.log($scope.grandTotalMarks);
			// return false
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getSubjectGrandsResult();

	$scope.getStudentExamDetails = function()
	{
		$scope.studentExamDetails = [];
		$scope.termsList = [];
		$scope.termListData =[];
		var formData = {'session_id':$routeParams.SESSIONID,'school_id':School_ID,'student_id':$scope.studentID};
		$http.post(BASE_URL+'api/school/result/getStudentExamDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.studentExamDetails = response.data.data;
				$scope.termListData		  = response.data.data.studentsList[0].termListData;
				$scope.termsList 		  = response.data.data.termsList;
				$scope.examTermsTotal=0;
				$scope.examTermsObtailedTotal=0;
				for(var i =0; i < $scope.termListData.length; i++)
	            {
	                $scope.termListData[i]['id_encrypt']   = $scope.encryptStr($scope.termListData[i].id);
	           }
	           $scope.calculateSubjectTermResult();
	           $scope.getSubjectGrandsResult();
	      	}
			// console.log($scope.studentExamDetails);
			}, function errorCallback(response){
		});
	}
	$scope.getStudentExamDetails();

	// Approove and Disapprove term wise result
	$scope.approveDisapproveResult = function(term_id,student_id,resultStatus,reason)
	{
		if( (resultStatus == undefined) && (resultStatus == undefined))
				var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: `All fields are mendatory.`
				});
			  	return false;
			}();

		else if((resultStatus == 'disapproved') && (reason == undefined) )
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: `Reason is mendatory.`
				});
			    // setTimeout(function() { location.reload();  }, 3000);
				return false;
			}();

		}else{
			var formData = {'session_id':$routeParams.SESSIONID,resultStatus:resultStatus,reason:reason,term_id:term_id,student_id:student_id};
			$http.post(BASE_URL+'api/school/result/resultIsApproved',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
				}
				}).then(function(response) {
				
				if(response.status == 200)
				{
					$scope.resultIsApproved = response.data.data;
					var Gritter = function () {
					$.gritter.add({
						title: 'success',
						text: response.data.message
					});
						$scope.reason = '';
						$scope.resultStatus = '';
						$scope.getStudentExamDetails();
						$scope.calculateSubjectTermResult();
						$scope.getSubjectGrandsResult();
					    // setTimeout(function() { location.reload();  }, 3000);
					}();	
				}
				// console.log($scope.studentExamDetails);
				}, function errorCallback(response){
					var Gritter = function () {
					$.gritter.add({
						title: 'success',
						text: 'No Result Found'
					});
						$scope.reason = '';
						$scope.resultStatus = '';
						$scope.getStudentExamDetails();
						$scope.calculateSubjectTermResult();
						$scope.getSubjectGrandsResult();
					    // setTimeout(function() { location.reload();  }, 3000);
					}();	
			});
		}
	}
	// $scope.generateResult = function(student_id){
	// 	alert('test'+ student_id);
	// 	// alert($scope.class_id);
	// }
}
function subscribeCtrl($scope,$http,$window,$routeParams,$timeout)
{
	$scope.getSchoolSubscription = function()
	{
                
		$scope.getSubscriptionList = [];
		var formData = {'school_id':School_ID};
		$http.get(BASE_URL+'api/school/subscription/getSchoolSubscription/'+School_ID,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.getSubscriptionList = response.data.data;
                                console.log($scope.getSubscriptionList);
			}
			// console.log($scope.totalTermResult);
			}, function errorCallback(error){
				$scope.getSubscriptionLis=[];
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
		$scope.getSchoolSubscription();
                
       $scope.benefitModal=function(subscriptionData){
		$scope.subscriptionData=subscriptionData;
		//console.log($scope.subscriptionData);
		$("#benefitModal").modal('show');
	}         

}
function giftListCtrl($scope, $http, $route, $window) 
{
	$scope.pageSize = 12;
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
	$scope.getGiftList=function(){
		var formData={'schoolID':School_ID}
		$http.post(BASE_URL+'api/school/gift/getGiftList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.giftData = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.giftData.length; i++)
				{
					encrypted = $scope.encryptStr($scope.giftData[i].id);
					$scope.giftData[i]['giftID'] = encrypted;
				}
				
			}
			}, function errorCallback(response){
				$scope.giftData=[]
		});
	}
	$scope.getGiftList();
}
function allGiftCtrl($scope, $http, $routeParams, $timeout,$window) 
{
	var sid;
	$scope.giftID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.giftID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.giftID;
	};	
	$timeout($scope.setID(), 2000);
	$scope.giftnfo = false;
	$scope.getGiftDetails = function()
	{
		$scope.goalinfo=[];
		var formData = {'giftID':$scope.giftID}
		$http.post(BASE_URL+'api/school/gift/getGiftDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{  
				$scope.giftinfo = response.data.data;

			}
			}, function errorCallback(response){
				$scope.giftinfo=[];
		});
		
	}
	$scope.getGiftDetails();
}
function pointsManagementCtrl($scope,$http,$window)
{
	
	// console.log('test'); 
	// $scope.pointMgmt = [];
        $scope.stdclass= "";
	$scope.pointManagement = function(stdclass)
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

		$scope.pointMgmt = [];
		var formData = {'school_id':School_ID,'stdclass':stdclass}
		$http.post(BASE_URL+'api/school/gift/getStudentPoint',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{  
				$scope.pointMgmt = response.data.data;
				for(var i =0; i < $scope.pointMgmt.length; i++)
	            {
	                $scope.pointMgmt[i]['student_id_encrypt'] = $scope.encryptStr($scope.pointMgmt[i].student_id);
	    		}

			}
			// console.log($scope.pointMgmt);
			}, function errorCallback(response){
				$scope.pointMgmt = [];
		});
	}
        
        
        $scope.getAllClassForSchool = function()
	{
		$scope.classList = [];
		$scope.ob={'class':''};
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/user/getAllClassForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.classList = response.data.data;
				// $scope.ob.class = $scope.classList[0].id;
			}
			// console.log($scope.classList);		
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
	$scope.getAllClassForSchool();
    	//$scope.pointManagement();
}
function pointDetailsCtrl($scope, $http, $routeParams, $timeout,$window)
{
	var sid;
	$scope.studentID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.studentID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.studentID;
	};	
	$timeout($scope.setID(), 2000);

	$scope.pointManagementDetails = function()
	{

		$scope.totalPoint = [];
		$scope.allPointsData = [];
		var formData = { 'school_id':School_ID,'student_id':$scope.studentID }
		$http.post(BASE_URL+'api/school/gift/getStudentPointDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{  
				$scope.totalPoint = response.data.data.totalPoint;
				$scope.allPointsData = response.data.data.allPointsData;
				// $scope.pointMgmt = response.data.data;
				// for(var i =0; i < $scope.pointMgmt.length; i++)
	   //          {
	   //              $scope.pointMgmt[i]['student_id_encrypt'] = $scope.encryptStr($scope.pointMgmt[i].student_id);
	   //  		}

			}
			// console.log($scope.totalPoint);
			}, function errorCallback(response){
				$scope.pointMgmt = [];
		});
	}
	$scope.pointManagementDetails();

	// console.log($scope.pointsID);
}


function addRouteCtrl($scope, $http, $routeParams, $timeout,$window)
{
   $scope.route_title ="";
   $scope.route_start ="";
   $scope.route_end ="";
   $scope.route_stops = [];
   $scope.latitude = [];
   $scope.longitude = [];
   
   
//   $(document).on('keyup', '.routrstopcell', function() {
//        var myID  = $(this).attr("id");
//        var  mydata  = $scope.getAutoSuggesions(myID);
//   });
    $(document).on('keyup', '.routrstopcell', function() {
                
                var googleMapId = $(this).attr("id"); 
                var idTag = googleMapId.split("_");
                var latitudeID = 'latitude_'+idTag[2];
                var longitudeID = 'longitude_'+idTag[2];
          	var placeSearch, autocomplete;
                    autocomplete =  new google.maps.places.Autocomplete(document.getElementById(googleMapId), {types: ['geocode']});
                    autocomplete.addListener('place_changed', function() {
			var place = this.getPlace();
                        var latitude = place.geometry.location.lat();
                        var lngitude = place.geometry.location.lng();
                        $("#"+latitudeID).val(latitude);
                        $("#"+longitudeID).val(lngitude);
         	});
               
                   
     });
     
     
   
    
   var counter = 1;
   var label = counter+1;
   $(".add-route").click(function () {
   var stop = '<div class="controls input-group"><input type="text" class="form-control routrstopcell" placeholder="Enter Stop"   id="route_stops_'+counter+'" name="route_stops[]" ng-model="route_stops['+counter+']"><input type="text" readonly="true" class="form-control stopcell latitude" placeholder="Enter Latitude"  id="latitude_'+counter+'" name="latitude[]" ng-model="latitude['+counter+']"><input readonly="true" type="text" class="form-control stopcell longitude" placeholder="Enter Longitude " id="longitude_'+counter+'" name="longitude[]" ng-model="longitude['+counter+']"><span class="input-group-btn "><button class="btn btn-default removeStop" type="button">Remove</button></span></div>';
   $(".stoplist").append(stop);
    counter++;
    label++;
     });
     
   $(document).on("click",".removeStop",function() {  
     if(counter>1){ 
      $(this).closest(".controls").remove();  
      counter--;
      label--;
     }  
   }); 
   
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
        
  $scope.decryptStr = function(id){
    if(id==null || id==="")
    return '0';    
    var decrypted = CryptoJS.AES.decrypt(id, "KidyView");
    $scope.concat_id_encrypt = decrypted.toString(CryptoJS.enc.Utf8);
    return $scope.concat_id_encrypt
   }; 
   
   
	$scope.addRoute = function()
        {
            
                var stop_set = '1';
                var lat_set = '1';
                var long_set = '1';
                $('.routrstopcell').each(function () {
                if ($.trim($(this).val()).length == 0) {
                stop_set = '0';
                return false;
                }
                });
                $('.latitude').each(function () {
                if ($.trim($(this).val()).length == 0) {
                lat_set = '0';
                return false;
                }
                });
                $('.longitude').each(function () {
                if ($.trim($(this).val()).length == 0) {
                long_set = '0';
                return false;
                }
                })
                
            
            
            
            
            
        	if( ($scope.route_title == '') ||  ($scope.route_start == '') ||  ($scope.route_end == '') )
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: `All * field is mendatory.`
				});
			 	return false;
			}();

		}
                else if (stop_set=='0' || lat_set=='0' || long_set=='0') {
                  var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: `Each Stop Route Location,Latitude and Longitude must be fill.`
				});
			 	return false;
			}();  
                }
                
                else
                {
                //var route_stops = document.getElementsByName('route_stops');  
                var formData = new FormData();
                var latitude = document.querySelectorAll('input[name*=latitude]'); 
                var longitude = document.querySelectorAll('input[name*=longitude]');
                var route_stops = document.querySelectorAll('input[name*=route_stops]');
                
                    for( var i = 0; i < route_stops.length; i++ ){
                    formData.append(route_stops[i].name, route_stops[i].value);
                    formData.append(latitude[i].name, latitude[i].value);
                    formData.append(longitude[i].name, longitude[i].value);
                    
                }
               
                formData.append('schoolId', School_ID);
		formData.append('route_title', $scope.route_title);
		formData.append('route_start', $scope.route_start);
		formData.append('route_end', $scope.route_end);
               
                $http.post(BASE_URL+'api/driver/addroute',formData,{
                    headers:{
                    'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
                    }
                    }).then(function(response) {
                    var result  = response.data;
                    var Gritter = function () {
                    $.gritter.add({
                    title: 'Successfull',
                    text: 'New Route Addedd Successfully.'
                    });
                    $scope.getAllRoute();
                    setTimeout(function(){ location.reload() }, 3000);
                     return false;
                    }();
                    }, function errorCallback(error){
                        
                     var errresult = error.data.message
			if(errresult == 'Already Exists.')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Failed',
						text: 'Route already exist.'
					});
					
					return false;
				}();
			}   
                        
                    });
		}
	}
   
        
        $scope.getAllRoute = function()
	{
		$scope.routeList = false;
		var formData = {'schoolId':School_ID};
		$http.post(BASE_URL+'api/driver/getAllRoute',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.routeList = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.routeList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.routeList[i].id);
					$scope.routeList[i]['id'] = encrypted;
				}
			}
			
			}, function errorCallback(error){});
		
	}
        
     $scope.deleteRoute = function(delID) {
         if(confirm('Are you Sure to Delete it?')){
            var id = $scope.decryptStr(delID);
            var formData = {'schoolId':School_ID,'RouteID':id};
		$http.post(BASE_URL+'api/driver/deleteRoute',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
                            $scope.resultReturn = response.data.message;
                            $scope.preused = response.data.data;
                            if(response.data.done=='1')
                            var succesHead = 'Success';
                            else
                            var succesHead = 'Error'; 
                        
                            var Gritter = function () {
                            $.gritter.add({
                            title: succesHead,
                            text: response.data.message
                            });
                            }();
                            if(response.data.done=='1'){
                             $scope.resultReturn = "";
                             $scope.preused = "";
                             $scope.getAllRoute();
                            }
			}
			
			}, function errorCallback(error){});
            }
        }   
        
        
        
	$scope.getAllRoute();
   
}




function editRouteCtrl($scope, $http, $routeParams, $timeout,$window)
{
        $scope.route_title ="";
        $scope.route_start ="";
        $scope.route_end ="";
        $scope.route_stops = [];
        $scope.latitude = [];
        $scope.longitude = [];
        $scope.latlong = [];
        var sid;
        var counter = 0;
        var label = 0;
	$scope.scheduleID = '';
        $scope.routeData = [];
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.scheduleID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.scheduleID;
	};
	$timeout($scope.setID(), 2000); 
        console.log(sid);
        
        
         $(document).on('keyup', '.routrstopcell', function() {
            
                
                var googleMapId = $(this).attr("id"); 
                
                var idTag = googleMapId.split("_");
                var latitudeID = 'latitude_'+idTag[2];
                var longitudeID = 'longitude_'+idTag[2];
                console.log(latitudeID + '============'+longitudeID);
          	var placeSearch, autocomplete;
                    autocomplete =  new google.maps.places.Autocomplete(document.getElementById(googleMapId), {types: ['geocode']});
                    autocomplete.addListener('place_changed', function() {
			var place = this.getPlace();
                        var latitude = place.geometry.location.lat();
                        var lngitude = place.geometry.location.lng();
                        $("#"+latitudeID).val(latitude);
                        $("#"+longitudeID).val(lngitude);
         	});
               
                   
     });
        
        
        $scope.editRoute = function()
	{
		var formData = {'id':sid}
		$http.post(BASE_URL+'api/driver/getRoute',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				
				$scope.routeData          = response.data.data;
				$scope.route_stops         = $scope.routeData.stops;
				$scope.route_title        = $scope.routeData.route_title;
                                $scope.route_start 	  = $scope.routeData.route_start;
                                $scope.route_end 	  = $scope.routeData.route_end;
                                var route_stop            = $scope.route_stops;
                                //console.log($scope.route_stops);
                                //console.log($scope.routeData.lat_long);
                                if($scope.routeData.lat_long!=null && $scope.routeData.lat_long!=false){
                                var latlong               = $scope.routeData.lat_long.latLong;
                                 $scope.latitude             = latlong.latitude;
                                 $scope.longitude            = latlong.longitude;
                                }
                                else {
                                 $scope.latitude  = [];  
                                  $scope.longitude  = [];
                                }
                                counter = route_stop.length;
                                label = route_stop.length+1;
                                
                                for(var i=0;i<$scope.route_stops.length;i++){
                                    console.log($scope.route_stops[i]);
                                    var remove = "";
                                    if(i!=0) {
                                    var remove = '<span class="input-group-btn "><button class="btn btn-default removeStop" type="button">Remove</button></span>';    
                                    }
                                    $('.stoplist').append('<div class="controls input-group"><input type="text" class="form-control routrstopcell"  id="route_stops_'+i+'" name="route_stops[]" value="'+$scope.route_stops[i]+'"><input type="text" readonly="true" class="form-control stopcell latitude" placeholder="Enter Latitude"  id="latitude_'+i+'" name="latitude[]"  value="'+$scope.latitude[i]+'"><input type="text" readonly="true"  class="form-control stopcell longitude" placeholder="Enter Longitude " id="longitude_'+i+'" name="longitude[]" value="'+$scope.longitude[i]+'" >'+remove+'</div>');
                                }
                                //console.log(route_stop);
                                //console.log($scope.latitude);
                        }
			
			}, function errorCallback(error){});
		
	}
        
        $scope.updateRoute = function()
        {
            
                var stop_set = '1';
                var lat_set = '1';
                var long_set = '1';
                $('.routrstopcell').each(function () {
                if ($.trim($(this).val()).length == 0) {
                stop_set = '0';
                return false;
                }
                });
                $('.latitude').each(function () {
                if ($.trim($(this).val()).length == 0) {
                lat_set = '0';
                return false;
                }
                });
                $('.longitude').each(function () {
                if ($.trim($(this).val()).length == 0) {
                long_set = '0';
                return false;
                }
                })
            
            
            
        	if( ($scope.route_title == '') ||  ($scope.route_start == '') ||  ($scope.route_end == '') )
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: `All * field is mendatory.`
				});
			 	return false;
			}();

		}
                else if (stop_set=='0' || lat_set=='0' || long_set=='0') {
                  var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: `Each Stop Route Location,Latitude and Longitude must be fill.`
				});
			 	return false;
			}();  
                }
                else
                {
                    
                var route_stops = document.getElementsByName('route_stops');  
                
                
                var formData = new FormData();
                var route_stops = document.querySelectorAll('input[name*=route_stops]');
                var latitude = document.querySelectorAll('input[name*=latitude]'); 
                var longitude = document.querySelectorAll('input[name*=longitude]');
                
                    for( var i = 0; i < route_stops.length; i++ ){
                    formData.append(route_stops[i].name, route_stops[i].value);
                    formData.append(latitude[i].name, latitude[i].value);
                    formData.append(longitude[i].name, longitude[i].value);
                }
               
                formData.append('id', sid);
		formData.append('route_title', $scope.route_title);
		formData.append('route_start', $scope.route_start);
		formData.append('route_end', $scope.route_end);
               
                $http.post(BASE_URL+'api/driver/updateroute',formData,{
                    headers:{
                    'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
                    }
                    }).then(function(response) {
                    var result  = response.data;
                    var Gritter = function () {
                    $.gritter.add({
                    title: 'Successfull',
                    text: 'Route Updated Successfully.'
                    });
                     $window.location.href = '#!/add-route';
                     return false;
                    }();
                    }, function errorCallback(error){
                        
                     var errresult = error.data.message
			if(errresult == 'Already Exists.')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Failed',
						text: 'Route already exist.'
					});
					
					return false;
				}();
			}   
                        
                    });
		}
	}
        
        
          
  $(".add-route").click(function () {
   var stop = '<div class="controls input-group"><input type="text" class="form-control routrstopcell"  id="route_stops_'+counter+'" name="route_stops[]" ng-model="route_stops['+counter+']"><input type="text" readonly="true" class="form-control stopcell latitude" placeholder="Enter Latitude"  id="latitude_'+counter+'" name="latitude[]" ng-model="latitude['+counter+']"><input type="text" readonly="true" class="form-control stopcell longitude" placeholder="Enter Longitude " id="longitude_'+counter+'" name="longitude[]" ng-model="longitude['+counter+']"><span class="input-group-btn "><button class="btn btn-default removeStop" type="button">Remove</button></span></div>';
   $(".stoplist").append(stop);
    counter++;
    label++;
     });
     
   $(document).on("click",".removeStop",function() {  
     if(counter>1){ 
      $(this).closest(".controls").remove();  
      counter--;
      label--;
     }  
   });
        
     $scope.editRoute();   
        
        
}

function addVehicleCtrl($scope, $http, $routeParams, $timeout,$window)
{ 
        $scope.vehicle_type ="";
        $scope.vehicle_name ="";
        $scope.vehicle_number ="";
        $scope.vehicle_brand ="";
        $scope.model ="";
        $scope.colour ="";
        $scope.plate_number ="";
        $scope.routes ="";
       
    
       $scope.onChange = function (files) {
		if(files[0] == undefined) return;
		$scope.fileExt = files[0].name.split(".").pop();
	}
	$scope.isImage = function(ext) {
		if(ext) {
			return ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png";
		}
	}
        
        $scope.getAllRoute = function()
	{
		
		var formData = {'schoolId':School_ID};
		$http.post(BASE_URL+'api/driver/getAllRoute',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.routeList = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.routeList.length; i++)
				{
				
					$scope.routeList[i]['name'] = $scope.routeList[i].route_title+' ('+$scope.routeList[i].route_start+' To '+$scope.routeList[i].route_end+')';
				}
			}
			
			}, function errorCallback(error){});
		
	}
        
        $scope.addVehicle = function()
	{
            if( $scope.vehicle_name == '' ||  $scope.vehicle_number == '' ||  $scope.plate_number == '' || $scope.routes == ''  )
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: `All * field is mendatory.`
				});
			 	return false;
			}();

		}
                else
                {
                var formData = new FormData();    
                formData.append('schoolId', School_ID);
		formData.append('vehicle_type', $scope.vehicle_type);
		formData.append('vehicle_name', $scope.vehicle_name);
		formData.append('vehicle_number', $scope.vehicle_number);
                formData.append('vehicle_brand', $scope.vehicle_brand);
                formData.append('model', $scope.model);
                formData.append('colour', $scope.colour);
                formData.append('plate_number', $scope.plate_number);
                formData.append('routes', $scope.routes);
                var files1 = document.getElementById('pic').files[0];
		formData.append('pic',files1);
                
                
                $http.post(BASE_URL+'api/driver/addvehicle',formData,{
                    headers:{
                    'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
                    }
                    }).then(function(response) {
                    var result  = response.data;
                    console.log(result.success);
                    var Gritter = function () {
                    $.gritter.add({
                    title: 'Successfull',
                    text: 'New Vehicle Addedd Successfully.'
                    });
                    $window.location.href = "#!/vehicle-list";
                    }();
                    }, function errorCallback(error){
                        
                     var errresult = error.data.message
			if(errresult == 'Already Exists.')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Failed',
						text: 'Vehicle Plate Number OR Vehicle Number All ready Exist.'
					});
					
					return false;
				}();
			}   
                        
                    });
		}
        }
        
        
        
        
	$scope.getAllRoute();
    
}

function vehicleListCtrl($scope, $http, $routeParams, $timeout,$window)
{
   $scope.vehicleList = false;
   
   
   $scope.decryptStr = function(id){
    if(id==null || id==="")
    return '0';    
    var decrypted = CryptoJS.AES.decrypt(id, "KidyView");
    $scope.concat_id_encrypt = decrypted.toString(CryptoJS.enc.Utf8);
    return $scope.concat_id_encrypt
   };
   
   
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
        
    $scope.getAllvehicle = function()
	{
		
		var formData = {'schoolId':School_ID};
		$http.post(BASE_URL+'api/driver/getAllvehicle',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.vehicleList = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.vehicleList.length; i++)
				{
					encrypted = $scope.encryptStr($scope.vehicleList[i].id);
					$scope.vehicleList[i]['id'] = encrypted;
				}
			}
			
			}, function errorCallback(error){});
		
	}
        
        
        
        $scope.deleteVehicle = function(vhID) {
            if(confirm('Are you Sure to Delete it?')){
            var id = $scope.decryptStr(vhID);
            var formData = {'schoolId':School_ID,'VehicleID':id};
		$http.post(BASE_URL+'api/driver/deleteVehicle',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
                            if(response.data.done=='1')
                            var succesHead = 'Success';
                            else
                            var succesHead = 'Error'; 
                            
                            var Gritter = function () {
                            $.gritter.add({
                            title: succesHead,
                            text: response.data.message
                            });
                            }();
                            if(response.data.done=='1'){
                             $scope.getAllvehicle();   
                            }
			}
			
			}, function errorCallback(error){});
            }
        }
        
	$scope.getAllvehicle();       
}

function editVehicleCtrl($scope, $http, $routeParams, $timeout,$window)
{   
    var sid;
    $scope.vehicle_type ="";
    $scope.vehicle_name ="";
    $scope.vehicle_number ="";
    $scope.vehicle_brand ="";
    $scope.model ="";
    $scope.colour ="";
    $scope.plate_number ="";
    $scope.routes ="";
    $scope.photo = "";
    $scope.vehiclData = "";
    
   
    
    $scope.setID = function(){
            var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
            $scope.scheduleID = decrypted.toString(CryptoJS.enc.Utf8);
            sid = $scope.scheduleID;
    };
    $timeout($scope.setID(), 2000); 
    console.log(sid);
    
     $scope.onChange = function (files) {
		if(files[0] == undefined) return;
		$scope.fileExt = files[0].name.split(".").pop();
	}
	$scope.isImage = function(ext) {
		if(ext) {
			return ext == "jpg" || ext == "jpeg"|| ext == "gif" || ext=="png";
		}
	}
    
    $scope.getAllRoute = function()
	{
		
		var formData = {'schoolId':School_ID};
		$http.post(BASE_URL+'api/driver/getAllRoute',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.routeList = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.routeList.length; i++)
				{
				
					$scope.routeList[i]['name'] = $scope.routeList[i].route_title+' ('+$scope.routeList[i].route_code+')';
				}
			}
			
			}, function errorCallback(error){});
		
	}
    
    $scope.editVehicle = function()
	{
		var formData = {'id':sid}
		$http.post(BASE_URL+'api/driver/getVehicle',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				
				$scope.vehiclData               = response.data.data;
				$scope.vehicle_type             = $scope.vehiclData.vehicle_type;
				$scope.vehicle_name             = $scope.vehiclData.vehicle_name;
                                $scope.vehicle_number           = $scope.vehiclData.vehicle_number;
                                $scope.vehicle_brand            = $scope.vehiclData.vehicle_brand;
                                $scope.colour                   = $scope.vehiclData.colour;
                                $scope.model                    = $scope.vehiclData.model;
                                $scope.plate_number             = $scope.vehiclData.plate_number;
                                $scope.photo                    = $scope.vehiclData.photo;
                                $scope.routes                   = $scope.vehiclData.route;
                                
                                
                        }
			
			}, function errorCallback(error){});
		
	}
        
        
      $scope.updateVehicle = function()
	{
            if( $scope.vehicle_name == '' ||  $scope.vehicle_number == '' ||  $scope.plate_number == '' || $scope.routes == ''  )
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Failed',
					text: `All * field is mendatory.`
				});
			 	return false;
			}();

		}
                else
                {
                    
                var formData = new FormData();    
                formData.append('id', sid);
		formData.append('vehicle_type', $scope.vehicle_type);
		formData.append('vehicle_name', $scope.vehicle_name);
		formData.append('vehicle_number', $scope.vehicle_number);
                formData.append('vehicle_brand', $scope.vehicle_brand);
                formData.append('model', $scope.model);
                formData.append('colour', $scope.colour);
                formData.append('plate_number', $scope.plate_number);
                formData.append('routes', $scope.routes);
                formData.append('oldphoto', $scope.photo);
              
                var files1 = document.getElementById('pic').files[0];
		formData.append('pic',files1);
                
                
                $http.post(BASE_URL+'api/driver/updatevehicle',formData,{
                    headers:{
                    'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
                    }
                    }).then(function(response) {
                    var result  = response.data;
                    console.log(result.success);
                    var Gritter = function () {
                    $.gritter.add({
                    title: 'Successfull',
                    text: 'Vehicle Updated Successfully.'
                    });
                    $window.location.href = "#!/vehicle-list";
                    }();
                    }, function errorCallback(error){
                        
                     var errresult = error.data.message
			if(errresult == 'Already Exists.')
			{
				var Gritter = function () {
					$.gritter.add({
						title: 'Failed',
						text: 'Vehicle Plate Number OR Vehicle Number All ready Exist.'
					});
					
					return false;
				}();
			}   
                        
                    });
		}
        }   
        
       $scope.getAllRoute(); 
       $scope.editVehicle();  
}



function assignStudentCtrl($scope, $http, $routeParams, $timeout,$window)
{
   $scope.classSection = "";
   $scope.driver = "";
   $scope.students = "";
   
   $scope.classSectionList = [];
   $scope.childLists = [];
   $scope.driverList = [];
   $scope.preassign = "";
   $('.routeSection').hide();
   
   
 
  $scope.enbDisBox = function(){   
  if($('.checkall:checked').length>0){
    $(".checkall").attr("disabled", false); 
    
    }
    else {
      $(".checkall").attr("disabled", true);
      console.log('dis');
    } 
 
  } 
  
  
   $('.checkall').on('change', function() {     
     $('.childcheck').prop('checked', $(this).prop("checked"));              
    });
    
  $(document).on('change', '.childcheck', function() {  
    if($('.childcheck:checked').length == $('.childcheck').length){
           $('.checkall').prop('checked',true);
    }else{
           $('.checkall').prop('checked',false);
    }  
   }); 
   
   
   $scope.decryptStr = function(id){
    if(id==null || id==="")
    return '0';    
    var decrypted = CryptoJS.AES.decrypt(id, "KidyView");
    $scope.concat_id_encrypt = decrypted.toString(CryptoJS.enc.Utf8);
    return $scope.concat_id_encrypt
   }; 
   
   $scope.getAllDriverForSchool = function()
	{
		$scope.driverList = false;
		var formData = {'id':School_ID};
		$http.post(BASE_URL+'api/driver/getAllDriverForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.driverList = response.data.data;
				
			}
			
			}, function errorCallback(error){});
		
	}
   
   $scope.getAllSectionClass = function()
       {
               var formData = {'schoolId':School_ID};
		$http.post(BASE_URL+'api/driver/getAllSectionClass',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200){
			$scope.classSectionList = response.data.data;
                        return false;
				
			}},
                        function errorCallback(response){
				$scope.classSectionList = [];
                       }); 
                       
        } 
        
        
        
            $scope.getAllStudents = function() {
                
                $('.checkall').prop('checked',false); 
               //console.log($scope.classSection);
                var formData = {'schoolId':School_ID,'classSection':$scope.classSection};
		$http.post(BASE_URL+'api/driver/getAllStudents',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200){
			$scope.childLists = response.data.data;
                        var lenChild = $scope.childLists.length;
                        if(lenChild>0) {
                        $(".checkall").attr("disabled", false);     
                        }
                        }},
                        function errorCallback(response){
                        $scope.childLists = [];
                        var lenChild = $scope.childLists.length;
                        if(!lenChild){
                        $(".checkall").attr("disabled", true);        
                        }
                       }); 
                       
            }
            
      $scope.assignStudents = function() {
         $scope.preassign = "";  
         $scope.resultReturn = "";
          var lenChild = $('.childcheck:checked').length;
          //console.log(lenChild+'---'+$scope.classSection+'-----'+$scope.driver);
          if((lenChild!=='' && lenChild>0 ) && $scope.classSection!="" && $scope.driver!=""){
              
                var formData = new FormData();
                var student = document.querySelectorAll('input[name*=student]');
                    for( var i = 0; i < student.length; i++ ){
                    if (student[i].checked == true){    
                    formData.append(student[i].name, student[i].value);
                    }
                }
               
              
                formData.append('schoolId', School_ID);
		formData.append('classSection', $scope.classSection);
		formData.append('driver', $scope.driver);
               
                $http.post(BASE_URL+'api/driver/assignStudents',formData,{
                    headers:{
                    'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
                    }
                    }).then(function(response) {
                    $('.childcheck').prop('checked',false);     
                    $scope.resultReturn = response.data.message;
                    $scope.preassign = response.data.preAssign;
                    $scope.getDriverAssignList();
                    var Gritter = function () {
                    $.gritter.add({
                    title: 'Successfull',
                    text: response.data.message
                    });
                    //setTimeout(function(){  location.reload(); }, 8000);
                 
                    }();
                    }, function errorCallback(error){
                        console.log(error);
                        
                     var errresult = error.data.error
			if(errresult == 'Already Exists')
			{
                            $scope.resultReturn = error.data.message;
                            $scope.preassign = error.data.preAssign;
				var Gritter = function () {
					$.gritter.add({
						title: 'Error',
						text: error.data.error
					});
					
					return false;
				}();
			}   
                        
                    });  
             
          }
          else {
            var Gritter = function () {
            $.gritter.add({
            title: 'Failed',
            text: 'Please Select Driver, Class & Section And Students.'
            });

            return false;
            }();  
          }
         return false;  
      } 
      
      
       
      
            
    $scope.getDriverAssignList = function() {
    if($scope.driver==="")
    $scope.routeListData = [];    
    $('.routeSection').hide();

    $scope.assignLists = [];
    var formData = {'schoolId':School_ID,'driver':$scope.driver};
    $http.post(BASE_URL+'api/driver/getDriverAssignList',formData,{
            headers:{
            'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
            }
            }).then(function(response) {
            if(response.status == 200){
            $scope.assignLists = response.data.data;
            $scope.routeListData = $scope.assignLists[0].routeStops;
            if($scope.routeListData.length>0) {
            $('.routeSection').show();
            $('.routeName').html($scope.assignLists[0].vehicleWithCode+'('+$scope.assignLists[0].routepath+')');
            }
           
            }},
            function errorCallback(response){
            $scope.assignLists= [];
            }); 
                       
    }
    
    
   $scope.UnlinkStudent = function(assignId,driverID) {
            if(confirm('Are you Sure to Unlink This Student?')){
            var id = $scope.decryptStr(assignId);
            var formData = {'schoolId':School_ID,'assignId':assignId,'driverID':driverID};
		$http.post(BASE_URL+'api/driver/deleteAssignStudent',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
                            if(response.data.done=='1')
                            var succesHead = 'Success';
                            else
                            var succesHead = 'Error'; 
                            
                            var Gritter = function () {
                            $.gritter.add({
                            title: succesHead,
                            text: response.data.message
                            });
                            }();
                            if(response.data.done=='1'){
                             $scope.getDriverAssignList();
                            }
			}
			
			}, function errorCallback(error){
                            var Gritter = function () {
                            $.gritter.add({
                            title: 'Error',
                            text: error.data.message
                            });
                            }();
                            
                        });
            }
        } 
            

  $scope.getAllDriverForSchool();     
  $scope.getAllSectionClass(); 
  $scope.enbDisBox();
 
 
}

function transactionHistory($scope, $http, $routeParams, $timeout,$window)
{
	 var classId = $routeParams.ID;
	 var sessionId = $routeParams.SESSIONID;
	 $scope.transactionList=[];
     $scope.transactionHistory = function(classId) {
        var formData = {'session_id':sessionId,'schoolId':School_ID,'classId':classId};
		$http.post(BASE_URL+'api/school/fees/transactionHistory',formData,{
			headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			if(response.status == 200){
			$scope.transactionList = response.data.data;
                        }},
			function errorCallback(response){}); 
			$scope.transactionList=[];
            }
     $scope.transactionHistory(classId);      
}



function viewDriverStudentsCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
	var sid;
	$scope.driver = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.driver = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.driver;
	};	
	$timeout($scope.setID(), 2000);
        
        
        $scope.getDriverAssignList = function () {
        if ($scope.driver === "")
            $scope.routeListData = [];
        

        $scope.assignLists = [];
        var formData = {'schoolId': School_ID, 'driver': $scope.driver};
        $http.post(BASE_URL + 'api/driver/getDriverAssignList', formData, {
            headers: {
                'Content-Type': undefined, 'x-api-key': xapikey, 'TOKEN': localStorage.getItem("TOKEN")
            }
        }).then(function (response) {
            if (response.status == 200) {
                $scope.assignLists = response.data.data;
                $scope.routeListData = $scope.assignLists[0].routeStops;
                if ($scope.routeListData.length > 0) {
                  
                    $('.routeName').html($scope.assignLists[0].vehicleWithCode + '(' + $scope.assignLists[0].routepath + ')');
                }

            }
        },
                function errorCallback(response) {
                    $scope.assignLists = [];
                });

    }
       $scope.getDriverAssignList();
	
}


function journeyLogStudentsCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
	
       
        var paramID = $routeParams.ID.split("-");
	$scope.driver = paramID[1];
        $scope.studentId = paramID[0];
         console.log($scope.driver);
        
	
        
        
        $scope.journeyLogStudents = function () {
        if ($scope.driver === "" && $scope.studentId=== "")
            $scope.logData = [];
        

        $scope.assignLists = [];
        var formData = {'schoolId': School_ID, 'studentID': $scope.studentId,'driverID': $scope.driver};
        $http.post(BASE_URL + 'api/driver/journeyLogStudents', formData, {
            headers: {
                'Content-Type': undefined, 'x-api-key': xapikey, 'TOKEN': localStorage.getItem("TOKEN")
            }
        }).then(function (response) {
            if (response.status == 200) {
                $scope.logData = response.data.data;
                console.log($scope.logData);
                
            }
        },
                function errorCallback(response) {
                    $scope.assignLists = [];
                });

    }
    
   
    
    $scope.journeyLogStudents();
    
//    $('#mytab').DataTable({
//    "ordering": false,
//    });
	
}




function trackdriverCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
	
       $('.trackdiv').html('<img class="ajax-loader" src="https://cdnjs.cloudflare.com/ajax/libs/galleriffic/2.0.1/css/loader.gif" alt="" width="48" height="48">');
       var sid;
	$scope.driver = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.driver = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.driver;
	};	
	$timeout($scope.setID(), 2000);
        
        
        
             
        
        $scope.trackdriver = function () {
        $scope.assignLists = [];
        var formData = {'schoolId': School_ID,'driverID': $scope.driver};
        $http.post(BASE_URL + 'api/drivertrack/getJourneyStatus', formData, {
            headers: {
                'Content-Type': undefined, 'x-api-key': xapikey, 'TOKEN': localStorage.getItem("TOKEN")
            }
        }).then(function (response) {
            if (response.status == 200) {
                $scope.logData = response.data;
                var driverdata = $scope.logData.driver;
                var message = $scope.logData.message;
                console.log(driverdata.current_latitude+'++++++'+driverdata.current_longitude);
                if(driverdata.current_latitude!='' && driverdata.current_latitude!='0' && driverdata.current_latitude!='0.0' && driverdata.current_longitude!='' && driverdata.current_longitude!='0' && driverdata.current_longitude!='0.0'){
                var latitude =  parseFloat(driverdata.current_latitude);
                var longitude =  parseFloat(driverdata.current_longitude);
                console.log(latitude+'=========='+longitude);
                
                var Gritter = function () {
                $.gritter.add({
                title: 'Current Status',
                text: message
                });
                }();
                
                
                var myLatLng = { lat:latitude, lng: longitude };
                var map = new google.maps.Map(document.getElementById("dvMap"), {
                zoom: 16,
                center: myLatLng,
                });

              var marker =  new google.maps.Marker({
                position: myLatLng,map,
                title: driverdata.location_title,
                icon:  'https://chawtechsolutions.ch/kidyview/images/bus.png'
                });
            }
            else {
             $('.trackdiv').html('<h2>No Location Found.</h2>');   
            }
                
            }
        },
        function errorCallback(response) {
        $scope.logData = response.data;  
        console.log($scope.logData);
        $('.trackdiv').html('<h2>'+$scope.logData.message+'</h2>');
        });

    }
    
    $scope.trackdriver();
    setInterval(function(){ 
    $scope.trackdriver();    
    },15000);
	
}


function lessonnoteCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
  $scope.lessonnotelist = "";  
  
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
  $scope.lessonnotelist = function()
    {   
            var formData = {'schoolID': School_ID};
            $http.post(BASE_URL + 'api/lessonsnote/lessonnotelist', formData, {
                headers: {
                    'Content-Type': undefined, 'x-api-key': xapikey, 'TOKEN': localStorage.getItem("TOKEN")
                }
            }).then(function (response) {

                if (response.status == 200)
                {

                    $scope.lessonnotelist = response.data.data;
                    
                    for(var i = 0; i < $scope.lessonnotelist.length; i++)
                    {
                    var  encrypted = $scope.encryptStr($scope.lessonnotelist[i].id);
                    $scope.lessonnotelist[i]['lessonID'] = encrypted;
		    }
                    console.log($scope.lessonnotelist);
                }

            }, function errorCallback(error) {});

    }
    
  $scope.lessonnotelist(); 
  
  $scope.noteDisabled = function(noteID, status)
	{
		var formData1 = {'id':noteID, 'status':status};
		$http.post(BASE_URL+'api/lessonsnote/notedisabled',formData1,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
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
							text: 'Notes Status Disabled Now.'
						});
					}else if(status == 1)
					{
						$.gritter.add({
							title: 'Successfull',
							text: 'Notes Status Enabled Now.'
						});
					}
					
					setTimeout(function(){ location.reload(); }, 1000);
					return false;
				}();
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
    
       
}



function viewnoteCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
	$scope.lessondownload=function(id) {
		$window.location.href = BASE_URL+'download/lessondownload/'+id;
	}
    $scope.noteid = '';
    $scope.notesdata = '';
    $scope.setID = function(){
    var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
    $scope.noteid = decrypted.toString(CryptoJS.enc.Utf8);
    var sid = $scope.noteid;
    };
    $timeout($scope.setID(), 2000);
  
  
    
    $scope.getNotesData = function()
     {
        $scope.termList = false;
        var formData = {'schoolID':School_ID,'noteid':$scope.noteid};
        $http.post(BASE_URL+'api/lessonsnote/viewnote',formData,{
        headers:{
                'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
        }
        }).then(function(response) {

        if(response.status == 200)
        {
        $scope.notesdata = response.data.data;	
        $scope.term = $scope.notesdata.termname;
        $scope.activitytype = $scope.notesdata.activity_type;
        $scope.fromdate = $scope.notesdata.fromdate;
        $scope.todate = $scope.notesdata.todate;
        $scope.lessonsubject = $scope.notesdata.subjectname;
        $scope.topic = $scope.notesdata.topic;
        $scope.class_share = $scope.notesdata.sharewithclass;
        $scope.teacher_share = $scope.notesdata.sharewithteacher;
        $scope.lessonclass = $scope.notesdata.classlist;
        $scope.teacherlist = $scope.notesdata.teacherlist;
        $scope.student_notes = $scope.notesdata.student_notes;
		$scope.objectives = $scope.notesdata.objectives;
        $scope.material = $scope.notesdata.material;
        $scope.introduction = $scope.notesdata.concept;
        $scope.termend = $scope.notesdata.termend;
        $scope.termstart = $scope.notesdata.termstart;
        $scope.attachment=$scope.notesdata.attachmentData;
		$scope.attachmentArray=[];
		for(var i = 0; i < $scope.attachment.length; i++)
		{
			$scope.attachmentArray.push({ 
				'attachment':$scope.attachment[i].attachment,
				'type':$scope.attachment[i].type,
				'downloadurl':BASE_URL+'img/teacher/lessonnote/'+$scope.attachment[i].attachment
			});
			
		}
        //console.log($scope.notesdata);
        }

        }, function errorCallback(error){});
		
    }
   $scope.getNotesData(); 
   $scope.comment='';
   $scope.addComment=function(){
	   if($scope.comment==''){
		   return false;
	   }
	   var formData = {'noteid':$scope.noteid,'schoolID':School_ID,'comment':$scope.comment}
	   $http.post(BASE_URL+'api/lessonsnote/addLessonComment',formData,{
		   headers:{
			   'Content-Type':'application/json',
			   'x-api-key':xapikey,
			   'TOKEN':localStorage.getItem("TOKEN")
		   }
		   }).then(function(response) {
		   
		   if(response.status == 200)
		   {
			   $scope.result = response.data.data;
			   //console.log($scope.result);
			   $scope.notesdata.commentData.splice(0, 0, $scope.result);
			   //console.log($scope.notesdata.commentData);
			   $scope.comment='';
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
   $scope.deleteComment = function(commentdata,ID,index)
   {
	   var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
	   if(deleteMedia == true)
	   {
		   var formData = {'id':ID};
		   $http.post(BASE_URL+'api/lessonsnote/lesssonnotestd/deleteComment',formData,{
			   headers:{
				   'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			   }
			   }).then(function(response) {
			   
			   if(response.status == 200)
			   {
				   var result  = response.data;
				   var Gritter = function () {
					   $.gritter.add({
						   title: 'Successfull',
						   text: response.data.message
					   });
					   $scope.notesdata.commentData.splice(index, 1);
					   return false;
				   }();
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
}
function notificationSettingCtrl($scope, $http, $route, $window) 
{
	$scope.getNotificationSetting = function()
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
		var formData = {'schoolID':School_ID}
		$http.post(BASE_URL+'api/school/setting/getNotificationSetting',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{  
				$scope.notificationSettingData = response.data.data;
				
			}
			}, function errorCallback(response){
				$scope.notificationSettingData=[];
		});
		
	}
	$scope.getNotificationSetting();
	$scope.updateNotificationSetting = function(data,status,type)
	{
		if(type=="web"){
			data.is_web=status;
		}else if(type=="push"){
			data.is_push=status;
		}
		//return false;
		var formData = {'data':data}
		$http.post(BASE_URL+'api/school/setting/updateNotificationSetting',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{  
				$scope.msg = response.data.message;
					if($scope.msg){
						var Gritter = function () {
							$.gritter.add({
								title: 'Successfull',
								text: $scope.msg
							});
							$scope.errormsg = '';
							return false;
						}();
				}
			}
			}, function errorCallback(response){
				$scope.msg = response.data.message;
					if($scope.msg){
						var Gritter = function () {
							$.gritter.add({
								title: 'Error',
								text: $scope.msg
							});
							$scope.errormsg = '';
							return false;
						}();
					}
		});
	}
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
		var formData = {'schoolID':School_ID}
		$http.post(BASE_URL+'api/school/notification/getAllNotification',formData,{
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
		$http.post(BASE_URL+'api/school/notification/updateNotification',formData,{
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
			$http.post(BASE_URL+'api/school/notification/deleteNotification',formData,{
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
function transferStudentCtrl($scope, $http, $routeParams, $timeout,$window)
{

	$scope.isOutside=function(val){
		//console.log(val);
	}
	$scope.tranferData = {
		school_id:School_ID,
		from_session:'',
		from_class:'',
		to_session:'',
		to_class:'',
		child:[],
		is_outside:'',
	}
   $scope.sessionList = [];
   $scope.is_new=0;
   $scope.getAllAcademicSession = function()
	{
		
		$http.get(BASE_URL+'api/school/transferstudent/getAllAcademicSession?school_id='+School_ID+'&is_new='+$scope.is_new,{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
        {
            $scope.sessionList  = response.data.data;
                       
		});
		
	}
	$scope.getAllAcademicSession();
	$scope.sessionNewList = [];
	$scope.is_new=1;
   $scope.getNewAcademicSession = function()
	{
		
		$http.get(BASE_URL+'api/school/transferstudent/getAllAcademicSession?school_id='+School_ID+'&is_new='+$scope.is_new,{headers:{'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")}}).then(function(response) 
        {
            $scope.sessionNewList  = response.data.data;
                       
		});
		
	}
 	$scope.getNewAcademicSession();
	$scope.classList = [];
	$scope.getAllClass = function()
	{
	$http.get(BASE_URL+'api/school/transferstudent/getAllClass?school_id='+School_ID,{
		headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
		}
		}).then(function(response) {
		
		if(response.status == 200)
		{
			$scope.classList=response.data.data;
		}
		
		}, function errorCallback(error){
			$scope.classList=[];
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
	$scope.setting1 = {
		scrollableHeight: '200px',
		scrollable: true,
		enableSearch: true,
		displayProp: 'childname'
	};
	$scope.childData=[];
	$scope.getAllClassChild = function()
	{
	$http.get(BASE_URL+'api/school/transferstudent/getAllClassChild?school_id='+School_ID+'&session_id='+$scope.tranferData.from_session+'&class_id='+$scope.tranferData.from_class,{
		headers:{
			'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
		}
		}).then(function(response) {
		
		if(response.status == 200)
		{
			$scope.childData=response.data.data;
		}
		
		}, function errorCallback(error){
			$scope.childData=[];
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
  
  $scope.getAllClass();
	$scope.isTransferSubmit=false;
	$scope.transferChild = function(){
		
    if($scope.tranferData.is_outside==''){
		if( ($scope.tranferData.from_session == '' || $scope.tranferData.from_class == '' || $scope.tranferData.to_session == '' || $scope.tranferData.to_class == '' || $scope.tranferData.child.length==0))
		{
			var Gritter = function () {
				$.gritter.add({
					title: 'Validation Error!',
					text: 'Please fill all required fields (Indicating With * Sign).'
				});
				return false;
			}();
			return false;
		}
	}
		$scope.isTransferSubmit=true;
		$http.post(BASE_URL+'api/school/transferstudent/transferChild',$scope.tranferData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.isTransferSubmit=false;
				$scope.tranferData = {
					school_id:School_ID,
					from_session:'',
					from_class:'',
					to_session:'',
					to_class:'',
					child:[]
				}
				$scope.result = response.data.data;
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: response.data.message
					});
					return false;
				}();
			}
			// console.log($scope.classList);
			}, function errorCallback(error){
				$scope.isTransferSubmit=false;
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
}

function activityperformanceCtrl($scope, $http, $route, $window) 
{
	$scope.getActivityPerformance = function()
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
		$scope.performanceData=[];
		var formData = {'schoolID':School_ID}
		$http.post(BASE_URL+'api/school/activityperformance/getActivityPerformance',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{  
				$scope.performanceData = response.data.data;
				
			}
			}, function errorCallback(response){
				$scope.performanceData=[];
		});
		
	}
	$scope.getActivityPerformance();
	$scope.getData=function(data){
		$scope.name=data.name;
		$scope.id=data.id;
		$("#getpopup").modal('show');
	}
	
	$scope.updateActivityPerformance = function()
	{
		if($scope.name==''){
			return false;
		}
		var formData = {'schoolID':School_ID,'id':$scope.id,'name':$scope.name}
		$http.post(BASE_URL+'api/school/activityperformance/updateActivityPerformance',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{  
				$scope.msg = response.data.message;
					if($scope.msg){
						var Gritter = function () {
							$.gritter.add({
								title: 'Successfull',
								text: $scope.msg
							});
							$scope.errormsg = '';
							return false;
						}();
				}
				$("#getpopup").modal('hide');
				$scope.getActivityPerformance();
			}
			}, function errorCallback(response){
				$scope.msg = response.data.message;
					if($scope.msg){
						var Gritter = function () {
							$.gritter.add({
								title: 'Error',
								text: $scope.msg
							});
							$scope.errormsg = '';
							return false;
						}();
					}
		});
		
	}
	
}