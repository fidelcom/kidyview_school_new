'use strict';
//var app = angular.module('KidyViewStudent',['ngRoute','ngIntlTelInput','angularUtils.directives.dirPagination','datatables','moment-picker','ui.calendar','textAngular','angularSpectrumColorpicker']).
var app = angular.module('KidyViewStudent',['ngRoute','ngSanitize','ui.calendar','angularUtils.directives.dirPagination','datatables','angularjs-dropdown-multiselect','textAngular']).
config(['$routeProvider', function ($routeProvider) {
	$routeProvider.
	when('/', {
		templateUrl: BASE_URL+'student/dashboard',
		controller: HomeCtrl,
		activetab: 'dashboard'
  }).
  when('/student-profile', {
		templateUrl: BASE_URL+'student/studentProfile',
		controller: studentProfileCtrl,
		activetab: 'studentprofile'
	}).
	when('/assignment-list', {
		templateUrl: BASE_URL+'student/assignmentList',
		controller: studentAssignmentCtrl,
		activetab: 'studentassignment'
	}).
	when('/assignment-detail/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'student/assignmentView';
		},
		controller: allAssignmentCtrl,
		activetab: 'assignmentView'
  }).
	when('/submit-assignment/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'student/submitAssignment';
		},
		controller: submitAssignmentCtrl,
		activetab: 'submitAssignment'
	}).
	when('/submit-assignment-list', {
		templateUrl: BASE_URL+'student/submitAssignmentList',
		controller: studentSubmitAssignmentCtrl,
		activetab: 'studentsubmitassignment'
	}).
	when('/submit-assignment-detail/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'student/submitassignmentView';
		},
		controller: allSubmitAssignmentCtrl,
		activetab: 'submitassignmentView'
	 }).
	 when('/edit-submit-assignment/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'student/editsubmitassignment';
		},
		controller: editSubmitAssignmentCtrl,
		activetab: 'editsubmitassignment'
	  }).
	when('/teacher-list', {
		templateUrl: BASE_URL+'student/teacherList',
		controller: teacherListCtrl,
		activetab: 'teacherList'
	 }).
	when('/student-list', {
	   templateUrl: BASE_URL+'student/studentList',
	   controller: studentListCtrl,
	   activetab: 'studentList'
	}).
	when('/teacher-details/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'student/teacherView';
		},
		controller: allTeacherCtrl,
		activetab: 'teacherView'
	 }).
	when('/student-details/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'student/studentView';
		},
		controller: allStudentCtrl,
		activetab: 'studentView'
	 }).
	when('/classboard-list', {
		templateUrl: BASE_URL+'student/classboardList',
		controller: classboardListCtrl,
		activetab: 'classboardList'
	}).
	when('/view-post/:ID', {
	 templateUrl: function(urlattr){
	 return BASE_URL+'student/viewPost';
	 },
	 controller: allPostCtrl,
	 activetab: 'viewPost'
	}).
	when('/message-list', {
		templateUrl: BASE_URL+'student/messageList',
		controller: messageListCtrl,
		activetab: 'messageList'
	}).
	when('/send-message', {
		templateUrl: BASE_URL+'student/sendMessage',
		controller: sendMessageCtrl,
		activetab: 'sendmessage'
	}).
	when('/conversation/:ID', {
		templateUrl: BASE_URL+'student/conversation',
		controller: sendMessageCtrl,
		activetab: 'conversation'
	}).
	when('/subject-detail/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'student/subjectDetail';
		},
		controller: allSubjectCtrl,
		activetab: 'subjectDetail'
	  }).
	when('/to-do-list/:ID', {
		templateUrl: BASE_URL+'student/todoList',
		controller: todoListCtrl,
		activetab: 'todoList'
	}).
	when('/to-do-list', {
		templateUrl: BASE_URL+'student/todoList',
		controller: todoListCtrl,
		activetab: 'todoList'
	}).when('/calendar-list', {
		templateUrl: BASE_URL+'student/calendarList',
		controller: getAllCalendarCtrl,
		activetab: 'calendarList',
		resolve: {
            calendarData: function(calendar) {
                return calendar.calendarListData();
			}
		} 
	}).
	when('/class-schedule', {
		templateUrl: BASE_URL+'student/scheduleList',
		controller: classScheduleListCtrl,
		activetab: 'scheduleList'
	}).
	when('/faqs', {
		templateUrl: BASE_URL+'student/faqList',
		controller: faqListCtrl,
		activetab: 'faqList'
	}).
	when('/goals', {
		templateUrl: BASE_URL+'student/goalList',
		controller: goalListCtrl,
		activetab: 'goalList'
	}).
	when('/goal-details/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'student/goalDetails';
		},
		controller: allGoalCtrl,
		activetab: 'allGoalCtrl'
	}).
	when('/gifts', {
		templateUrl: BASE_URL+'student/giftList',
		controller: giftListCtrl,
		activetab: 'giftList'
	}).
	when('/gift-details/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'student/giftDetails';
		},
		controller: allGiftCtrl,
		activetab: 'allGiftCtrl'
	}).
	when('/exam-list', {
		templateUrl: BASE_URL+'student/examList',
		controller: examListCtrl,
		activetab: 'examList'
	}).
	when('/exam-details/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'student/examDetails';
		},
		controller: allExamCtrl,
		activetab: 'allExamCtrl'
	}).
	when('/exam-start/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'student/examStart';
		},
		controller: startExamCtrl,
		activetab: 'startExamCtrl',
		resolve: {
            examData: function(exam) {
                return exam.checkExamData();
			},
			/*timerData: function(examtimer) {
				return examtimer;
			}*/
		}
		/*resolve: {
           
			timerData: function(examtimer) {
				return examtimer.duration();
				return examtimer.getRemainigTime();
			},
			tData: function(examtimer) {
				return examtimer.getRemainigTime();
			}
		}*/
	}).
	when('/edit-exam/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'student/editExam';
		},
		controller: editExamCtrl,
		activetab: 'editExamCtrl',
		resolve: {
            examData: function(exam) {
                return exam.checkExamData();
			}
		}
	}).
	when('/notification', {
		templateUrl: BASE_URL+'student/notificationList',
		controller: notificationListCtrl,
		activetab: 'notificationList'
	}).
	when('/project-list', {
		templateUrl: BASE_URL+'student/projectList',
		controller: studentProjectCtrl,
		activetab: 'studentproject'
	}).
	when('/project-detail/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'student/projectView';
		},
		controller: allProjectCtrl,
		activetab: 'projectView'
  	}).
	when('/submit-project/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'student/submitProject';
		},
		controller: submitProjectCtrl,
		activetab: 'submitProject'
	}).
	when('/submit-project-list', {
		templateUrl: BASE_URL+'student/submitProjectList',
		controller: studentSubmitProjectCtrl,
		activetab: 'studentsubmitproject'
	}).
	when('/submit-project-detail/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'student/submitprojectView';
		},
		controller: allSubmitProjectCtrl,
		activetab: 'submitprojectView'
	 }).
	 when('/edit-submit-project/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'student/editsubmitproject';
		},
		controller: editSubmitProjectCtrl,
		activetab: 'editsubmitproject'
	  }).
	  when('/notification-settings', {
		templateUrl: BASE_URL+'student/notificationSettings',
		controller: notificationSettingCtrl,
		activetab: 'notificationSetting'
	  }).
	  when('/result', {
		templateUrl: BASE_URL+'student/result',
		controller: resultCtrl,
		activetab: 'result'
	  }).
	when('/result-detail/:ID', {
	templateUrl: function(urlattr){
	return BASE_URL+'student/resultView';
	},
	controller: allResultCtrl,
	activetab: 'resultView'
	}).
       when('/note-list', {
        templateUrl: BASE_URL+'student/notelist',
        controller: notelistCtrl,
        activetab: 'notelist'
	}).
        when('/view-note/:ID', {
	templateUrl: function(urlattr){
	return BASE_URL+'student/viewnote';
	},
	controller: viewnoteCtrl,
	activetab: 'viewnote'
	}).
        when('/add-comment/:ID', {
	templateUrl: function(urlattr){
	return BASE_URL+'student/addcomment';
	},
	controller: addcommentCtrl,
	activetab: 'addcomment'
	}).
        when('/comment-list/:ID', {
	templateUrl: function(urlattr){
	return BASE_URL+'student/commentlist';
	},
	controller: commentlistCtrl,
	activetab: 'commentlist'
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
			var formData = {'id':schoolID,'classID':classID,'calendardate':'','iscalendardata':1};
			return $http.post(BASE_URL+'api/student/calendar/getAllCalendarData',formData,{
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
app.factory('exam', function ($http,$location,$window) {
	var checkExamData = function() {
		var url = $location.path().split('/');
		var ID = url[2];
		var decrypted = CryptoJS.AES.decrypt(ID, "KidyView");
		ID = decrypted.toString(CryptoJS.enc.Utf8);
		var formData = {'schoolID':schoolID,'classID':classID,'examID':ID};
			return $http.post(BASE_URL+'api/student/exam/checkExamStatus',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey
				}
				}).then(function(response) {
				if(response.status == 200)
				{
					var examData=response.data.data;
					if(examData==1){
						return true;
					}else if(examData==0){
						$window.location.href = '#!/exam-list';
					}else{
						$window.location.href = '#!/exam-list';
					}	
				}
				}, function errorCallback(response){
					return false;
					
			});
		
	};
	return {
		checkExamData: checkExamData
	};
});
app.factory('examtimer', ['$timeout', function ($timeout) {
    var duration = function (timeSpan) {
        var days = Math.floor(timeSpan / 86400000);
        var diff = timeSpan - days * 86400000;
        var hours = Math.floor(diff / 3600000);
        diff = diff - hours * 3600000;
        var minutes = Math.floor(diff / 60000);
        diff = diff - minutes * 60000;
        var secs = Math.floor(diff / 1000);
        return { 'days': days, 'hours': hours, 'minutes': minutes, 'seconds': secs };
    };
    function getRemainigTime(referenceTime) {
        var now = moment().utc();
        return moment(referenceTime) - now;
    }
    return {
        duration: duration,
       getRemainigTime: getRemainigTime
    };
}]);
app.filter('durationview', ['examtimer', function (examtimer) {
	return function (input, css) {
        var duration = examtimer.duration(input);
        return duration.days + "d:" + duration.hours + "h:" + duration.minutes + "m:" + duration.seconds + "s";
    };
}]);

/*
app.config(function($provide){
    $provide.decorator('taOptions', ['taRegisterTool', '$delegate', function(taRegisterTool, taOptions){
        // $delegate is the taOptions we are decorating
        // register the tool with textAngular

        taRegisterTool('backgroundColor', {
            display: "<div spectrum-colorpicker ng-model='color' on-change='!!color && action(color)' format='\"hex\"' options='options'></div>",
            action: function (color) {
                var me = this;
                if (!this.$editor().wrapSelection) {
                    setTimeout(function () {
                        me.action(color);
                    }, 100)
                } else {
                    return this.$editor().wrapSelection('backColor', color);
                }
            },
            options: {
                replacerClassName: 'fa fa-paint-brush', showButtons: false
            },
            color: "#fff"
        });
        taRegisterTool('fontColor', {
            display:"<spectrum-colorpicker trigger-id='{{trigger}}' ng-model='color' on-change='!!color && action(color)' format='\"hex\"' options='options'></spectrum-colorpicker>",
            action: function (color) {
                var me = this;
                if (!this.$editor().wrapSelection) {
                    setTimeout(function () {
                        me.action(color);
                    }, 100)
                } else {
                    return this.$editor().wrapSelection('foreColor', color);
                }
            },
            options: {
                replacerClassName: 'fa fa-font', showButtons: false
            },
            color: "#000"
        });


       /* taRegisterTool('fontName', {
            display: "<span class='bar-btn-dropdown dropdown'>" +
            "<button class='btn btn-blue dropdown-toggle' type='button' ng-disabled='showHtml()' style='padding-top: 4px'><i class='fa fa-font'></i><i class='fa fa-caret-down'></i></button>" +
            "<ul class='dropdown-menu'><li ng-repeat='o in options'><button class='btn btn-blue checked-dropdown' style='font-family: {{o.css}}; width: 100%' type='button' ng-click='action($event, o.css)'><i ng-if='o.active' class='fa fa-check'></i>{{o.name}}</button></li></ul></span>",
            action: function (event, font) {
                //Ask if event is really an event.
                if (!!event.stopPropagation) {
                    //With this, you stop the event of textAngular.
                    event.stopPropagation();
                    //Then click in the body to close the dropdown.
                    $("body").trigger("click");
                }
                return this.$editor().wrapSelection('fontName', font);
            },
            options: [
                { name: 'Sans-Serif', css: 'Arial, Helvetica, sans-serif' },
                { name: 'Serif', css: "'times new roman', serif" },
                { name: 'Wide', css: "'arial black', sans-serif" },
                { name: 'Narrow', css: "'arial narrow', sans-serif" },
                { name: 'Comic Sans MS', css: "'comic sans ms', sans-serif" },
                { name: 'Courier New', css: "'courier new', monospace" },
                { name: 'Garamond', css: 'garamond, serif' },
                { name: 'Georgia', css: 'georgia, serif' },
                { name: 'Tahoma', css: 'tahoma, sans-serif' },
                { name: 'Trebuchet MS', css: "'trebuchet ms', sans-serif" },
                { name: "Helvetica", css: "'Helvetica Neue', Helvetica, Arial, sans-serif" },
                { name: 'Verdana', css: 'verdana, sans-serif' },
                { name: 'Proxima Nova', css: 'proxima_nova_rgregular' }
            ]
        });


        taRegisterTool('fontSize', {
            display: "<span class='bar-btn-dropdown dropdown'>" +
            "<button class='btn btn-blue dropdown-toggle' type='button' ng-disabled='showHtml()' style='padding-top: 4px'><i class='fa fa-text-height'></i><i class='fa fa-caret-down'></i></button>" +
            "<ul class='dropdown-menu'><li ng-repeat='o in options'><button class='btn btn-blue checked-dropdown' style='font-size: {{o.css}}; width: 100%' type='button' ng-click='action($event, o.value)'><i ng-if='o.active' class='fa fa-check'></i> {{o.name}}</button></li></ul>" +
            "</span>",
            action: function (event, size) {
                //Ask if event is really an event.
                if (!!event.stopPropagation) {
                    //With this, you stop the event of textAngular.
                    event.stopPropagation();
                    //Then click in the body to close the dropdown.
                    $("body").trigger("click");
                }
                return this.$editor().wrapSelection('fontSize', parseInt(size));
            },
            options: [
                { name: 'xx-small', css: 'xx-small', value: 1 },
                { name: 'x-small', css: 'x-small', value: 2 },
                { name: 'small', css: 'small', value: 3 },
                { name: 'medium', css: 'medium', value: 4 },
                { name: 'large', css: 'large', value: 5 },
                { name: 'x-large', css: 'x-large', value: 6 },
                { name: 'xx-large', css: 'xx-large', value: 7 }

            ]
        });


        // add the button to the default toolbar definition
        //taOptions.toolbar[1].push('backgroundColor','fontColor','fontName','fontSize');
		taOptions.toolbar[1].push('backgroundColor','fontColor');
		return taOptions;
    }]);
});
*/