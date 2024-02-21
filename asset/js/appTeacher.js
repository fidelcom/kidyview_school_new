'use strict';

var app = angular.module('KidyViewStudent',['ngRoute','ngSanitize','ui.calendar','angularUtils.directives.dirPagination','datatables','angularjs-dropdown-multiselect']).
config(['$routeProvider', function ($routeProvider) {
	$routeProvider.
	when('/', {
		templateUrl: BASE_URL+'teacher/dashboard',
		controller: HomeCtrl,
		activetab: 'dashboard'
    }).
	when('/student-list', {
	   templateUrl: BASE_URL+'teacher/studentList',
	   controller: studentListCtrl,
	   activetab: 'studentList'
  }).
	when('/student-details/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'teacher/studentView';
		},
		controller: allStudentCtrl,
		activetab: 'studentView'
   }).
 when('/classboard-list', {
    templateUrl: BASE_URL+'teacher/classboardList',
    controller: classboardListCtrl,
    activetab: 'classboardList'
 }).
 when('/create-classboard', {
  templateUrl: BASE_URL+'teacher/createClassboard',
  controller: createClassboardCtrl,
  activetab: 'createClassboard'
}).
when('/edit-classboard/:ID', {
  templateUrl: function(urlattr){
  return BASE_URL+'teacher/editClassboard';
  },
  controller: editClassboardCtrl,
  activetab: 'editClassboard'
 }).
 when('/view-post/:ID', {
  templateUrl: function(urlattr){
  return BASE_URL+'teacher/viewPost';
  },
  controller: allPostCtrl,
  activetab: 'viewPost'
 }).
 when('/assignment-list', {
  templateUrl: BASE_URL+'teacher/assignmentList',
  controller: teacherAssignmentCtrl,
  activetab: 'teacherassignment'
}).
when('/assignment-detail/:ID', {
  templateUrl: function(urlattr){
  return BASE_URL+'teacher/assignmentView';
  },
  controller: allAssignmentCtrl,
  activetab: 'assignmentView'
}).
 when('/create-assignment', {
  templateUrl: BASE_URL+'teacher/createAssignment',
  controller: createAssignmentCtrl,
  activetab: 'createAssignment'
}).
when('/edit-assignment/:ID', {
  templateUrl: function(urlattr){
  return BASE_URL+'teacher/editAssignment';
  },
  controller: editAssignmentCtrl,
  activetab: 'assignmentedit'
}).
when('/submitted-assignment-list', {
  templateUrl: function(urlattr){
  return BASE_URL+'teacher/submittedAssignmentList';
  },
  controller: submitedAssignmentCtrl,
  activetab: 'submitedAssignment'
}).
when('/submited-assignment-detail/:ID', {
  templateUrl: function(urlattr){
  return BASE_URL+'teacher/submitedassignmentView';
  },
  controller: allSubmitedAssignmentCtrl,
  activetab: 'submitedassignmentView'
 }).
when('/message-list', {
  templateUrl: BASE_URL+'teacher/messageList',
  controller: messageListCtrl,
  activetab: 'messageList'
}).
when('/send-message', {
  templateUrl: BASE_URL+'teacher/sendMessage',
  controller: sendMessageCtrl,
  activetab: 'sendmessage'
}).
when('/conversation/:ID', {
  templateUrl: BASE_URL+'teacher/conversation',
  controller: sendMessageCtrl,
  activetab: 'conversation'
}).
when('/profile', {
  templateUrl: BASE_URL+'teacher/profile',
  controller: teacherProfileCtrl,
  activetab: 'teacherprofile'
}).when('/calendar-list', {
  templateUrl: BASE_URL+'teacher/calendarList',
  controller: getAllCalendarCtrl,
  activetab: 'calendarList',
  resolve: {
          calendarData: function(calendar) {
              return calendar.calendarListData();
    }
  } 
}).
when('/class-schedule', {
  templateUrl: BASE_URL+'teacher/scheduleList',
  controller: classScheduleListCtrl,
  activetab: 'scheduleList'
}).
when('/exam-list', {
  templateUrl: BASE_URL+'teacher/examList',
  controller: examListCtrl,
  activetab: 'examList'
}).
when('/exam-details/:ID', {
  templateUrl: function(urlattr){
  return BASE_URL+'teacher/examDetails';
  },
  controller: allExamCtrl,
  activetab: 'allExamCtrl',
}).
when('/submitted-exam-list', {
  templateUrl: BASE_URL+'teacher/submittedExamList',
  controller: submittedExamListCtrl,
  activetab: 'submittedExamList'
}).
when('/submitted-exam-details/:ID', {
  templateUrl: function(urlattr){
  return BASE_URL+'teacher/submittedExamDetails';
  },
  controller: allSubmittedExamCtrl,
  activetab: 'allSubmittedExam',
}).
when('/notification', {
  templateUrl: BASE_URL+'teacher/notificationList',
  controller: notificationListCtrl,
  activetab: 'notificationList'
}).
when('/project-list', {
 templateUrl: BASE_URL+'teacher/projectList',
 controller: teacherProjectCtrl,
 activetab: 'teacherproject'
}).
when('/project-detail/:ID', {
 templateUrl: function(urlattr){
 return BASE_URL+'teacher/projectView';
 },
 controller: allProjectCtrl,
 activetab: 'projectView'
}).
when('/create-project', {
 templateUrl: BASE_URL+'teacher/createProject',
 controller: createProjectCtrl,
 activetab: 'createProject'
}).
when('/edit-project/:ID', {
 templateUrl: function(urlattr){
 return BASE_URL+'teacher/editProject';
 },
 controller: editProjectCtrl,
 activetab: 'projectedit'
}).
when('/submitted-project-list', {
 templateUrl: function(urlattr){
 return BASE_URL+'teacher/submittedProjectList';
 },
 controller: submitedProjectCtrl,
 activetab: 'submitedProject'
}).
when('/submited-project-detail/:ID', {
 templateUrl: function(urlattr){
 return BASE_URL+'teacher/submitedProjectView';
 },
 controller: allSubmitedProjectCtrl,
 activetab: 'submitedprojectView'
}).
when('/notification-settings', {
  templateUrl: BASE_URL+'teacher/notificationSettings',
  controller: notificationSettingCtrl,
  activetab: 'notificationSetting'
}).
when('/result', {
  templateUrl: BASE_URL+'teacher/result',
  controller: resultCtrl,
  activetab: 'result'
}).
when('/result-detail/:ID', {
  templateUrl: function(urlattr){
  return BASE_URL+'teacher/resultView';
  },
  controller: allResultCtrl,
  activetab: 'resultView'
}).
when('/lesson-note/', {
templateUrl: function(urlattr){
return BASE_URL+'teacher/lessonnote';
},
controller: lessonnoteCtrl,
activetab: 'lessonnoteCtrl'
}).
when('/lesson-note-edit/:ID', {
  templateUrl: function(urlattr){
  return BASE_URL+'teacher/editlessonnote';
  },
  controller: editlessonnoteCtrl,
  activetab: 'editlessonnoteCtrl'
}). 
when('/lesson-note-list/', {
templateUrl: function(urlattr){
return BASE_URL+'teacher/lessonnotelist';
},
controller: lessonnotelistCtrl,
activetab: 'lessonnotelistCtrl'
}).
when('/shared-lesson-list/', {
templateUrl: function(urlattr){
return BASE_URL+'teacher/sharedlessonlist';
},
controller: sharedlessonCtrl,
activetab: 'sharedlessonCtrl'
}).
when('/shared-lesson-edit/:ID', {
  templateUrl: function(urlattr){
  return BASE_URL+'teacher/editsharedlesson';
  },
  controller: editsharedlessonCtrl,
  activetab: 'editsharedlessonCtrl'
}).
when('/view-shared-note/:ID', {
  templateUrl: function(urlattr){
  return BASE_URL+'teacher/viewsharednote';
  },
  controller: viewsharednoteCtrl,
  activetab: 'viewsharednoteCtrl'
}).
when('/view-note/:ID', {
  templateUrl: function(urlattr){
  return BASE_URL+'teacher/viewdnote';
  },
  controller: viewnoteCtrl,
  activetab: 'viewnoteCtrl'
}).        

otherwise({redirectTo: '/'});
	}]).run(['$rootScope','$location', '$http', '$browser', '$timeout', "$route", function ($scope, $location,$http, $browser, $timeout, $route) {
	
	$scope.$on('$routeChangeStart', function ($event, next, current) {
		$scope.isRouteLoading = true;   
	
	});
	
	$scope.$on("$routeChangeSuccess", function (scope, next, current) {
		$scope.part = $route.current.activetab;
	});
	
}]);
app.factory('calendar', function($http) {
  var calendarListData = function() {
    var formData = {'id':schoolID,'classID':'','calendardate':'','iscalendardata':1};
    return $http.post(BASE_URL+'api/teachers/calendar/getAllCalendarData',formData,{
      headers:{
        'Content-Type':undefined, 'x-api-key':xapikey
      }
      }).then(function(response) {
      var	calendarDataList=false;
      if(response.status == 200)
      {
        var nietos = [];
        var obj = [];
        calendarDataList = response.data.data;
        for(var i = 0; i < calendarDataList.length; i++)
        {
          if(calendarDataList[i]['type']=='Birthday'){
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
          }
        
        }
        calendarDataList=calendarDataList.concat(obj);
      }
      return calendarDataList; 
      }, function errorCallback(response){
        return false;
        
    });
  };

  return {
    calendarListData: calendarListData
  };

});

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
	
}]);
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
app.filter('myDate', function($filter) {    
  var angularDateFilter = $filter('date');
  return function(theDate) {
     return angularDateFilter(theDate, 'dd MMM y');
  }
});
app.filter("unique", function() {
	// we will return a function which will take in a collection
	// and a keyname
	return function(collection, keyname) {
	  // we define our output and keys array;
	  var output = [],
	  keys = [];
	  // we utilize angular's foreach function
	  // this takes in our original collection and an iterator function
	  angular.forEach(collection, function(item) {
		var key = item[keyname];
		if (keys.indexOf(key) === -1) {
		  keys.push(key);
		  output.push(item);
		}
	  });
	  return output;
	};
});
app.directive('schrollBottom', function () {
	return {
	  scope: {
		schrollBottom: "="
	  },
	  link: function (scope, element) {
		scope.$watchCollection('schrollBottom', function (newValue) {
		  if (newValue)
		  {
			$(element).scrollTop($(element)[0].scrollHeight);
		  }
		});
	  }
	}
});
app.directive('numericonly', function () {  
  return {  
      require: 'ngModel',  
      link: function (scope, element, attr, ngModelCtrl) {  
          function fromUser(text) {  
              var transformedInput = text.replace(/[^0-9]/g, '');  
              if (transformedInput !== text) {  
                  ngModelCtrl.$setViewValue(transformedInput);  
                  ngModelCtrl.$render();  
              }  
              return transformedInput;   
          }  
          ngModelCtrl.$parsers.push(fromUser);  
      }  
  };  
});