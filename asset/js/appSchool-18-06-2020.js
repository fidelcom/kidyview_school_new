'use strict';

var app = angular.module('KidyViewSchool',['ngRoute','ngFileUpload','ngIntlTelInput','ngPatternRestrict','ui.select','angularUtils.directives.dirPagination','datatables','moment-picker','ui.calendar']).
config(['$routeProvider', function ($routeProvider) {
	$routeProvider.
	when('/', {
		templateUrl: BASE_URL+'schooluser/dashboard',
		controller: HomeCtrl,
		activetab: 'dashboard'
	}).
	when('/school-profile', {
		templateUrl: BASE_URL+'schooluser/editprofile',
		controller: editProfileCtrl,
		activetab: 'editprofile'
	}).
	when('/parent-list', {
		templateUrl: BASE_URL+'schooluser/parentList',
		controller: getAllParentCtrl,
		activetab: 'parentList'
	}).
	when('/add-parent', {
		templateUrl: BASE_URL+'schooluser/addParent',
		controller: addParentCtrl,
		activetab: 'addParent'
	}).
	when('/parent-detail/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/parentView';
		},
		controller: allParentCtrl,
		activetab: 'parentView'
	}).
	when('/edit-parent/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/editParent';
		},
		controller: editParentCtrl,
		activetab: 'editParent'
	}).
	when('/edit-child/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/editChild';
		},
		controller: editChildCtrl,
		activetab: 'editChild'
	}).
	when('/event-list', {
		templateUrl: BASE_URL+'schooluser/eventList',
		controller: getAllEventCtrl,
		activetab: 'eventList'
	}).
	when('/add-event', {
		templateUrl: BASE_URL+'schooluser/addEvent',
		controller: addEventCtrl,
		activetab: 'addEvent'
	}).
	when('/event-detail/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/eventView';
		},
		controller: allEventCtrl,
		activetab: 'eventView'
	}).
	when('/edit-event/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/editEvent';
		},
		controller: editEventCtrl,
		activetab: 'editEvent'
	}).
	when('/meal-planner', {
		templateUrl: BASE_URL+'schooluser/mealPlanner',
		controller: MealPlannerCtrl,
		activetab: 'mealPlannerList'
	}).
	when('/add-meal', {
		templateUrl: BASE_URL+'schooluser/addMeal',
		controller: addMealCtrl,
		activetab: 'addMeal'
	}).
	when('/edit-meal/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/editMeal';
		},
		controller: editMealCtrl,
		activetab: 'editMeal'
	}).
	when('/learning-and-development', {
		templateUrl: BASE_URL+'schooluser/learningDevelopment',
		controller: LearningAndDevelopmentCtrl,
		activetab: 'learningDevelopment'
	}).
	when('/add-learning-and-development', {
		templateUrl: BASE_URL+'schooluser/addLearningDevelopment',
		controller: AddLearningAndDevelopmentCtrl,
		activetab: 'learningDevelopment'
	}).
	when('/edit-learning-and-development/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/editLearningDevelopment';
		},
		controller: EditLearningAndDevelopmentCtrl,
		activetab: 'learningDevelopment'
	}).
	when('/home-meal', {
		templateUrl: BASE_URL+'schooluser/homeMeal',
		controller: HomeMealCtrl,
		activetab: 'homeMeal'
	}).
	when('/driver-list', {
		templateUrl: BASE_URL+'schooluser/driverList',
		controller: getAllDriverCtrl,
		activetab: 'driverList'
	}).
	when('/add-driver', {
		templateUrl: BASE_URL+'schooluser/addDriver',
		controller: addDriverCtrl,
		activetab: 'addDriver'
	}).
	when('/driver-detail/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/driverView';
		},
		controller: allDriverCtrl,
		activetab: 'driverView'
	}).
	when('/edit-driver/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/editDriver';
		},
		controller: editDriverCtrl,
		activetab: 'editDriver'
	}).
	when('/session-list', {
		templateUrl: BASE_URL+'schooluser/sessionList',
		controller: getAllSessionCtrl,
		activetab: 'sessionList'
	}).
	when('/add-session', {
		templateUrl: BASE_URL+'schooluser/addSession',
		controller: addSessionCtrl,
		activetab: 'addSession'
	}).
	when('/edit-session/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/editSession';
		},
		controller: editSessionCtrl,
		activetab: 'editSession'
	}).
	when('/class-list', {
		templateUrl: BASE_URL+'schooluser/classList',
		controller: getAllClassCtrl,
		activetab: 'classList'
	}).
	when('/add-class', {
		templateUrl: BASE_URL+'schooluser/addClass',
		controller: addClassCtrl,
		activetab: 'addClass'
	}).
	when('/edit-class/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/editClass';
		},
		controller: editClassCtrl,
		activetab: 'editClass'
	}).
	when('/subject-list', {
		templateUrl: BASE_URL+'schooluser/subjectList',
		controller: getAllSubjectCtrl,
		activetab: 'subjectList'
	}).
	when('/add-subject', {
		templateUrl: BASE_URL+'schooluser/addSubject',
		controller: addSubjectCtrl,
		activetab: 'addSubject'
	}).
	when('/edit-subject/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/editSubject';
		},
		controller: editSubjectCtrl,
		activetab: 'editSubject'
	}).
	when('/teacher-list', {
		templateUrl: BASE_URL+'schooluser/teacherList',
		controller: getAllTeacherCtrl,
		activetab: 'teacherList'
	}).
	when('/add-teacher', {
		templateUrl: BASE_URL+'schooluser/addTeacher',
		controller: addTeacherCtrl,
		activetab: 'addTeacher'
	}).
	when('/teacher-detail/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/teacherView';
		},
		controller: allTeacherCtrl,
		activetab: 'teacherView'
	}).
	when('/edit-teacher/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/editTeacher';
		},
		controller: editTeacherCtrl,
		activetab: 'editTeacher'
	}).
	when('/student-birthday', {
		templateUrl: BASE_URL+'schooluser/studentBirthdayList',
		controller: getAllStudentBirthdayCtrl,
		activetab: 'studentBirthdayList'
	}).
	when('/student-detail/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/studentView';
		},
		controller: allStudentCtrl,
		activetab: 'studentView'
	}).
	when('/article-list', {
		templateUrl: BASE_URL+'schooluser/articleList',
		controller: getAllArticleCtrl,
		activetab: 'articleList'
	}).
	when('/add-article', {
		templateUrl: BASE_URL+'schooluser/addArticle',
		controller: addArticleCtrl,
		activetab: 'addArticle'
	}).
	when('/edit-article/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/editArticle';
		},
		controller: editArticleCtrl,
		activetab: 'editArticle'
	}).
	when('/article-detail/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/articleView';
		},
		controller: allArticleCtrl,
		activetab: 'articleView'
	}).
	when('/album-list', {
		templateUrl: BASE_URL+'schooluser/albumList',
		controller: getAllAlbumCtrl,
		activetab: 'albumList'
	}).
	when('/add-album', {
		templateUrl: BASE_URL+'schooluser/addAlbum',
		controller: addAlbumCtrl,
		activetab: 'addAlbum'
	}).
	when('/album-detail/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/albumView';
		},
		controller: allAlbumCtrl,
		activetab: 'albumView'
	}).
	when('/edit-album/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/editAlbum';
		},
		controller: editAlbumCtrl,
		activetab: 'editAlbum'
	}).
	when('/timeline-list', {
		templateUrl: BASE_URL+'schooluser/timelineList',
		controller: getAllTimelineCtrl,
		activetab: 'timelineList'
	}).
	when('/add-timeline', {
		templateUrl: BASE_URL+'schooluser/addTimeline',
		controller: addTimelineCtrl,
		activetab: 'addTimeline'
	}).
	when('/edit-timeline/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/editTimeline';
		},
		controller: editTimelineCtrl,
		activetab: 'editTimeline'
	}).
	when('/holiday-list', {
		templateUrl: BASE_URL+'schooluser/holidayList',
		controller: getAllHolidayCtrl,
		activetab: 'holidayList',
		resolve: {
            holidaycalendarData: function(calendar) {
                return calendar.holidaycalendarList();
            }
        }
	}).
	when('/calendar-list', {
		templateUrl: BASE_URL+'schooluser/calendarList',
		controller: getAllCalendarCtrl,
		activetab: 'calendarList',
		resolve: {
            calendarData: function(calendar) {
                return calendar.calendarListData();
			}
		}
        
	}).
	when('/add-holiday', {
		templateUrl: BASE_URL+'schooluser/addHoliday',
		controller: addHolidayCtrl,
		activetab: 'addHoliday'
	}).
	when('/edit-holiday/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/editHoliday';
		},
		controller: editHolidayCtrl,
		activetab: 'editHoliday'
	}).
	when('/role-list', {
		templateUrl: BASE_URL+'schooluser/roleList',
		controller: getAllRoleCtrl,
		activetab: 'roleList'
	}).
	when('/add-role', {
		templateUrl: BASE_URL+'schooluser/addRole',
		controller: addRoleCtrl,
		activetab: 'addRole'
	}).
	when('/edit-role/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/editRole';
		},
		controller: editRoleCtrl,
		activetab: 'editRole'
	}).
	when('/privilege-list', {
		templateUrl: BASE_URL+'schooluser/privilegeList',
		controller: getAllPrivilegeCtrl,
		activetab: 'privilegeList'
	}).
	when('/add-privilege', {
		templateUrl: BASE_URL+'schooluser/addPrivilege',
		controller: addPrivilegeCtrl,
		activetab: 'addPrivilege'
	}).
	when('/edit-privilege/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/editPrivilege';
		},
		controller: editPrivilegeCtrl,
		activetab: 'editPrivilege'
	}).
	when('/subadmin-list', {
		templateUrl: BASE_URL+'schooluser/subAdminList',
		controller: getAllSubadminCtrl,
		activetab: 'subAdminList'
	}).
	when('/add-subadmin', {
		templateUrl: BASE_URL+'schooluser/addSubAdmin',
		controller: addSubadminCtrl,
		activetab: 'addSubAdmin'
	}).
	when('/subadmin-detail/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/subAdminView';
		},
		controller: allSubadminCtrl,
		activetab: 'parentView'
	}).
	when('/edit-subadmin/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/editSubadmin';
		},
		controller: editSubadminCtrl,
		activetab: 'editSubadmin'
	}).
	when('/discussioncat-list', {
		templateUrl: BASE_URL+'schooluser/discussioncatList',
		controller: getAllDiscussionCatCtrl,
		activetab: 'discussioncatList'
	}).
	when('/add-discussioncat', {
		templateUrl: BASE_URL+'schooluser/addDiscussionCat',
		controller: addDiscussionCatCtrl,
		activetab: 'addDiscussionCat'
	}).
	when('/edit-discussioncat/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/editDiscussionCat';
		},
		controller: editDiscussionCatCtrl,
		activetab: 'editDiscussionCat'
	}).
	when('/discussion-list', {
		templateUrl: BASE_URL+'schooluser/discussionList',
		controller: getAllDiscussionCtrl,
		activetab: 'discussionList'
	}).
	when('/discussion-detail/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/discussionView';
		},
		controller: allDiscussionCtrl,
		activetab: 'discussionView'
	}).
	when('/learning-and-development-report-list', {
		templateUrl: BASE_URL+'schooluser/learningdevelopmentreportList',
		controller: getAllLearningDevelopmentReportCtrl,
		activetab: 'learningdevelopmentreportList'
	}).
	when('/learning-and-development-report-detail/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/learningdevelopmentreportView';
		},
		controller: allLearningDevelopmentReportCtrl,
		activetab: 'learningdevelopmentreportView'
	}).
	otherwise({redirectTo: '/'});
	}]).run(['$rootScope', '$http', '$browser', '$timeout', "$route", function ($scope, $http, $browser, $timeout, $route) {
	
	$scope.$on('$routeChangeStart', function () {
		$scope.isRouteLoading = true;            
	});
	
	$scope.$on("$routeChangeSuccess", function (scope, next, current) {
		$scope.part = $route.current.activetab;
	});
	
}]);

//
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
app.factory('calendar', function($http) {
	//alert('xzv');
		var holidaycalendarList = function() {
			//$scope.holidayCalendarDataList = [];
			var formData = {'id':School_ID};
			return $http.post(BASE_URL+'api/user/getAllHolidayCalendarData',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey
				}
				}).then(function(response) {
				var	holidayCalendarDataList=false;
				if(response.status == 200)
				{
					holidayCalendarDataList = response.data.data;
					
				}
				return holidayCalendarDataList; 
				}, function errorCallback(response){
					return false;
					
			});
		};

		var calendarListData = function() {
			

			//$scope.holidayCalendarDataList = [];
			var formData = {'id':School_ID,'calendardate':'','iscalendardata':1};
			return $http.post(BASE_URL+'api/user/getAllCalendarData',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey
				}
				}).then(function(response) {
				var	calendarDataList=false;
				if(response.status == 200)
				{
					var nietos = [];
					var obj = [];
					
					//obj["01"] ='A';
					//obj["02"] = 'B';
					//nietos.push(obj);
					//console.log(nietos);
					calendarDataList = response.data.data;
					for(var i = 0; i < calendarDataList.length; i++)
					{
						if(calendarDataList[i]['type']=='Birthday'){
							//alert(calendarDataList[i]['type']);
						var title=calendarDataList[i]['title'];
						var start=calendarDataList[i]['start'];
						var allday=calendarDataList[i]['allday'];
						var type=calendarDataList[i]['type'];
						var yearexp=start.split('-');
						var year =yearexp[0];
						var curentyear = new Date().getFullYear();
						var prevyear=parseInt(curentyear)-parseInt(3);
						
						var nextyear=parseInt(curentyear)+parseInt(3);
						//alert(nextyear);
						for(var j=prevyear; j<=nextyear; j++){
							if(year==curentyear){ continue;}
							var years=j;
							obj.push({ 
								'title':title,
								'start':years+'-'+yearexp[1]+'-'+yearexp[2],
								'allday':allday,
								'type':type
							});
							
						}
						
						console.log(obj);
						}
					
					}
					calendarDataList=calendarDataList.concat(obj);
					//console.log(calendarDataList);
				}
				return calendarDataList; 
				}, function errorCallback(response){
					return false;
					
			});
		};
	
		return {
			holidaycalendarList:holidaycalendarList,
			calendarListData: calendarListData
		};
	
});
app.directive("compareTo", function ()  
{  
    return {  
        require: "ngModel",  
        scope:  
        {  
            confirmPassword: "=compareTo"  
        },  
        link: function (scope, element, attributes, modelVal)  
        {  
            modelVal.$validators.compareTo = function (val)  
            {  
                return val == scope.confirmPassword;  
            };  
            scope.$watch("confirmPassword", function ()  
            {  
                modelVal.$validate();  
            });  
        }  
    };  
});