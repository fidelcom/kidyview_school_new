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
	when('/subadmin-profile', {
		templateUrl: BASE_URL+'schooluser/subadminprofile',
		controller: subadminProfileCtrl,
		activetab: 'subadminprofile'
	}).
	when('/parent-list', {
		templateUrl: BASE_URL+'schooluser/parentList',
		controller: getAllParentCtrl,
		activetab: 'parentList'
	}).
	when('/student-list', {
		templateUrl: BASE_URL+'schooluser/studentList',
		controller: newStudentCtrl,
		activetab: 'studentList'
	}).
	when('/student-detail/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/studentView';
		},
		controller: allStudentCtrl,
		activetab: 'studentView'
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
	when('/student-attendance', {
		templateUrl: BASE_URL+'schooluser/studentAttendance',
		controller: studentAttendanceCtrl,
		activetab: 'studentAttendance'
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
	when('/messages-list', {
		templateUrl: BASE_URL+'schooluser/messageList',
		controller: getAllMessageCtrl,
		activetab: 'messageList'
	}).
	when('/all-conversation/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/messageView';
		},
		controller: allMessageCtrl,
		activetab: 'messageView'
	}).
	when('/compose-message', {
		templateUrl: BASE_URL+'schooluser/addMessage',
		controller: addMessageCtrl,
		activetab: 'addMessage'
	}).
	when('/term-list', {
		templateUrl: BASE_URL+'schooluser/termList',
		controller: getAllTermCtrl,
		activetab: 'termList'
	}).
	when('/add-term', {
		templateUrl: BASE_URL+'schooluser/addTerm',
		controller: addTermCtrl,
		activetab: 'addTerm'
	}).
	when('/edit-term/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/editTerm';
		},
		controller: editTermCtrl,
		activetab: 'editTerm'
	}).
	when('/student-report', {
		templateUrl: BASE_URL+'schooluser/studentReportList',
		controller: getAllStudentReportCtrl,
		activetab: 'studentReportList'
	}).
	when('/report-view/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/reportView';
		},
		controller: allReportCtrl,
		activetab: 'reportView'
	}).
	when('/thoughtoftheday-list', {
		templateUrl: BASE_URL+'schooluser/thoughtofthedayList',
		controller: getAllThoughtofthedayCtrl,
		activetab: 'thoughtofthedayList'
	}).
	when('/add-thoughtoftheday', {
		templateUrl: BASE_URL+'schooluser/addThoughtoftheday',
		controller: addThoughtofthedayCtrl,
		activetab: 'addThoughtoftheday'
	}).
	when('/edit-thoughtoftheday/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'schooluser/editThoughtoftheday';
		},
		controller: editThoughtofthedayCtrl,
		activetab: 'editThoughtoftheday'
	}).
	when('/class-schedule', {
		templateUrl: BASE_URL+'schooluser/classSchedule',
		controller: classScheduleCtrl,
		activetab: 'classSchedule'
	}).
	when('/view-schedule-details/:ID', {
		templateUrl: BASE_URL+'schooluser/viewScheduleDetails',
		controller: detailsScheduleCtrl,
		activetab: 'viewScheduleDetails'
	}).
	when('/edit-schedule/:ID', {
		templateUrl: BASE_URL+'schooluser/editSchedule',
		controller: editScheduleCtrl,
		activetab: 'editSchedule'
	}).
	when('/add-schedule', {
		templateUrl: BASE_URL+'schooluser/addSchedule',
		controller: classScheduleCtrl,
		activetab: 'addSchedule'
	}).
	when('/time-table', {
		templateUrl: BASE_URL+'schooluser/timeTable',
		controller: timeTableCtrl,
		activetab: 'timeTable'
	}).
	when('/edit-time-table', {
		templateUrl: BASE_URL+'schooluser/editTimeTable',
		controller: timeTableCtrl,
		activetab: 'editTimeTable'
	}).
	when('/school-faq', {
		templateUrl: BASE_URL+'schooluser/schoolFaq',
		controller: schoolFAQCtrl,
		activetab: 'schoolFaq'
	}).
	when('/add-faq', {
		templateUrl: BASE_URL+'schooluser/addfaq',
		controller: schoolFAQCtrl,
		activetab: 'addfaq'
	}).
	when('/exam', {
		templateUrl: BASE_URL+'schooluser/exam',
		controller: examCtrl,
		activetab: 'exam'
	}).
	when('/edit-exam/:ID', {
		templateUrl: BASE_URL+'schooluser/editExam',
		controller: editExamCtrl,
		activetab: 'editExam'
	}).
	when('/add-exam', {
		templateUrl: BASE_URL+'schooluser/addExam',
		controller: examCtrl,
		activetab: 'addExam'
	}).
	when('/details-exam/:ID', {
		templateUrl: BASE_URL+'schooluser/examDetails',
		controller: editExamCtrl,
		activetab: 'addExam'
	}).
	when('/exam-submit', {
		templateUrl: BASE_URL+'schooluser/examSubmit',
		controller: examSubmitCtrl,
		activetab: 'examSubmit'
	}).
	when('/view-submit-exam/:ID', {
		templateUrl: BASE_URL+'schooluser/viewSubmitExam',
		controller: viewExamSubmitCtrl,
		activetab: 'examSubmit'
	}).
	when('/submitted-exam-details/:ID', {
		templateUrl: BASE_URL+'schooluser/submitExamDetails',
		controller: viewExamSubmitCtrl,
		activetab: 'examSubmit'
	}).
	when('/grade-list', {
		templateUrl: BASE_URL+'schooluser/gradeList',
		controller: gradeSystemCtrl,
		activetab: 'gradeList'
	}).
	when('/add-grade', {
		templateUrl: BASE_URL+'schooluser/addGrade',
		controller: gradeSystemCtrl,
		activetab: 'addGrade'
	}).
	when('/questions/:ID', {
		templateUrl: BASE_URL+'schooluser/questionList',
		controller: questionCtrl,
		activetab: 'questionList'
	}).
	when('/add-question/:ID', {
		templateUrl: BASE_URL+'schooluser/addQuestion',
		controller: questionCtrl,
		activetab: 'addQuestion'
	}).
	when('/edit-question/:ID', {
		templateUrl: BASE_URL+'schooluser/editQuestion',
		controller: detailsCtrl,
		activetab: 'editQuestion'
	}).
	when('/details-question/:ID', {
		templateUrl: BASE_URL+'schooluser/detailsQuestion',
		controller: detailsCtrl,
		activetab: 'detailsQuestion'
	}).	
	otherwise({redirectTo: '/'});
	}]).run(['$rootScope','$location', '$http', '$browser', '$timeout', "$route", function ($scope, $location,$http, $browser, $timeout, $route) {
	
	$scope.$on('$routeChangeStart', function ($event, next, current) {
		$scope.isRouteLoading = true;   
		var orgpath=next.$$route.originalPath;  
		var retn=1;
		var checlPrivilege=JSON.parse(jsonPrivilege);
		if(orgpath=='/parent-list'){
			if(checlPrivilege.Parents['view']==0){
				retn=0;
			}
		}
		if(orgpath=='/add-parent'){
			if(checlPrivilege.Parents['add']==0){
				retn=0;
			}
		}
		if(orgpath=='/edit-parent/:ID'){
			if(checlPrivilege.Parents['edit']==0){
				retn=0;
			}
		}
		if(orgpath=='/teacher-list'){
			if(checlPrivilege.Teacher['view']==0){
				retn=0;
			}
		}
		if(orgpath=='/add-teacher'){
			if(checlPrivilege.Teacher['add']==0){
				retn=0;
			}
		}
		if(orgpath=='/edit-teacher/:ID'){
			if(checlPrivilege.Teacher['edit']==0){
				retn=0;
			}
		}
		if(orgpath=='/driver-list'){
			if(checlPrivilege.Driver['view']==0){
				retn=0;
			}
		}
		if(orgpath=='/add-driver'){
			if(checlPrivilege.Driver['add']==0){
				retn=0;
			}
		}
		if(orgpath=='/edit-driver/:ID'){
			if(checlPrivilege.Driver['edit']==0){
				retn=0;
			}
		}
		if(orgpath=='/subadmin-list'){
			if(checlPrivilege.SubAdmin['view']==0){
				retn=0;
			}
		}
		if(orgpath=='/add-subadmin'){
			if(checlPrivilege.SubAdmin['add']==0){
				retn=0;
			}
		}
		if(orgpath=='/edit-subadmin/:ID'){
			if(checlPrivilege.SubAdmin['edit']==0){
				retn=0;
			}
		}
		if(orgpath=='/role-list'){
			if(checlPrivilege.Role['view']==0){
				retn=0;
			}
		}
		if(orgpath=='/add-role'){
			if(checlPrivilege.Role['add']==0){
				retn=0;
			}	
		}
		if(orgpath=='/edit-role/:ID'){
			if(checlPrivilege.Role['edit']==0){
				retn=0;
			}	
		}
		if(orgpath=='/privilege-list'){
			if(checlPrivilege.Privilege['view']==0){
				retn=0;
			}
		}
		if(orgpath=='/add-privilege'){
			if(checlPrivilege.Privilege['add']==0){
				retn=0;
			}	
		}
		if(orgpath=='/edit-privilege/:ID'){
			if(checlPrivilege.Privilege['edit']==0){
				retn=0;
			}	
		}
		if(orgpath=='/event-list'){
			if(checlPrivilege.Events['view']==0){
				retn=0;
			}
		}
		if(orgpath=='/add-event'){
			if(checlPrivilege.Events['add']==0){
				retn=0;
			}	
		}
		if(orgpath=='/edit-event/:ID'){
			if(checlPrivilege.Events['edit']==0){
				retn=0;
			}	
		}
		if(orgpath=='/student-birthday'){
			if(checlPrivilege.StudentsBirthday['view']==0){
				retn=0;
			}
		}
		if(orgpath=='/edit-child/:ID'){
			if(checlPrivilege.StudentsBirthday['edit']==0){
				retn=0;
			}	
		}
		if(orgpath=='/calendar-list'){
			if(checlPrivilege.Calendar['view']==0){
				retn=0;
			}	
		}

		if(orgpath=='/meal-planner'){
			if(checlPrivilege.MealPlanner['view']==0){
				retn=0;
			}
		}
		if(orgpath=='/add-meal'){
			if(checlPrivilege.MealPlanner['add']==0){
				retn=0;
			}	
		}
		if(orgpath=='/edit-meal/:ID'){
			if(checlPrivilege.MealPlanner['edit']==0){
				retn=0;
			}	
		}
		if(orgpath=='/home-meal'){
			if(checlPrivilege.HomeMeal['view']==0){
				retn=0;
			}
		}
		if(orgpath=='/holiday-list'){
			if(checlPrivilege.HolidayList['view']==0){
				retn=0;
			}
		}
		if(orgpath=='/add-holiday'){
			if(checlPrivilege.HolidayList['add']==0){
				retn=0;
			}	
		}
		if(orgpath=='/edit-holiday/:ID'){
			if(checlPrivilege.HolidayList['edit']==0){
				retn=0;
			}	
		}
		if(orgpath=='/session-list'){
			if(checlPrivilege.Session['view']==0){
				retn=0;
			}
		}
		if(orgpath=='/add-session'){
			if(checlPrivilege.Session['add']==0){
				retn=0;
			}	
		}
		if(orgpath=='/edit-session/:ID'){
			if(checlPrivilege.Session['edit']==0){
				retn=0;
			}	
		}

		if(orgpath=='/class-list'){
			if(checlPrivilege.Class['view']==0){
				retn=0;
			}
		}
		if(orgpath=='/add-class'){
			// if(checlPrivilege.Class['add']==0){
			// 	retn=0;
			// }	
		}
		if(orgpath=='/edit-class/:ID'){
			if(checlPrivilege.Class['edit']==0){
				retn=0;
			}	
		}

		if(orgpath=='/subject-list'){
			if(checlPrivilege.Subject['view']==0){
				retn=0;
			}
		}
		if(orgpath=='/add-subject'){
			if(checlPrivilege.Subject['add']==0){
				retn=0;
			}	
		}
		if(orgpath=='/edit-subject/:ID'){
			if(checlPrivilege.Subject['edit']==0){
				retn=0;
			}	
		}

		if(orgpath=='/discussioncat-list'){
			if(checlPrivilege.DiscussionCategory['view']==0){
				retn=0;
			}
		}
		if(orgpath=='/add-discussioncat'){
			if(checlPrivilege.DiscussionCategory['add']==0){
				retn=0;
			}	
		}
		if(orgpath=='/edit-discussioncat/:ID'){
			if(checlPrivilege.DiscussionCategory['edit']==0){
				retn=0;
			}	
		}

		if(orgpath=='/discussion-list'){
			if(checlPrivilege.Discussion['view']==0){
				retn=0;
			}
		}

		if(orgpath=='/timeline-list'){
			if(checlPrivilege.Timeline['view']==0){
				retn=0;
			}
		}
		if(orgpath=='/add-timeline'){
			if(checlPrivilege.Timeline['add']==0){
				retn=0;
			}	
		}
		if(orgpath=='/edit-timeline/:ID'){
			if(checlPrivilege.Timeline['edit']==0){
				retn=0;
			}	
		}
		if(orgpath=='/article-list'){
			if(checlPrivilege.Article['view']==0){
				retn=0;
			}
		}
		if(orgpath=='/add-article'){
			if(checlPrivilege.Article['add']==0){
				retn=0;
			}	
		}
		if(orgpath=='/edit-article/:ID'){
			if(checlPrivilege.Article['edit']==0){
				retn=0;
			}	
		}
		if(orgpath=='/album-list'){
			if(checlPrivilege.Album['view']==0){
				retn=0;
			}
		}
		if(orgpath=='/add-album'){
			if(checlPrivilege.Album['add']==0){
				retn=0;
			}	
		}
		if(orgpath=='/edit-album/:ID'){
			if(checlPrivilege.Album['edit']==0){
				retn=0;
			}	
		}
		if(orgpath=='/learning-and-development'){
			if(checlPrivilege.LearningDevelopmentCategory['view']==0){
				retn=0;
			}
		}
		if(orgpath=='/add-learning-and-development'){
			if(checlPrivilege.LearningDevelopmentCategory['add']==0){
				retn=0;
			}	
		}
		if(orgpath=='/edit-learning-and-development/:ID'){
			if(checlPrivilege.LearningDevelopmentCategory['edit']==0){
				retn=0;
			}	
		}
		if(orgpath=='/learning-and-development-report-list'){
			if(checlPrivilege.LearningDevelopmentReport['view']==0){
				retn=0;
			}
		}
		if(orgpath=='/message-list'){
			if(checlPrivilege.Messages['view']==0){
				retn=0;
			}
		}
		if(orgpath=='/compose-message'){
			if(checlPrivilege.Messages['add']==0){
				retn=0;
			}
		}
		if(orgpath=='/term-list'){
			if(checlPrivilege.Term['view']==0){
				retn=0;
			}
		}
		if(orgpath=='/add-term'){
			if(checlPrivilege.Term['add']==0){
				retn=0;
			}	
		}
		if(orgpath=='/edit-term/:ID'){
			if(checlPrivilege.Term['edit']==0){
				retn=0;
			}	
		}
		if(orgpath=='/student-report/'){
			if(checlPrivilege.Report['view']==0){
				retn=0;
			}	
		}
		if(orgpath=='/thoughtoftheday-list'){
			if(checlPrivilege.Thoughts['view']==0){
				retn=0;
			}
		}
		if(orgpath=='/add-thoughtoftheday'){
			if(checlPrivilege.Thoughts['add']==0){
				retn=0;
			}	
		}
		if(orgpath=='/edit-thoughtoftheday/:ID'){
			if(checlPrivilege.Thoughts['edit']==0){
				retn=0;
			}	
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
		} 
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