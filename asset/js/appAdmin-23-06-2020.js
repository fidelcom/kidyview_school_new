'use strict';

var app = angular.module('KidyViewAdmin',['ngRoute','ngFileUpload','ngIntlTelInput','ngPatternRestrict','ui.select','angularUtils.directives.dirPagination','datatables','moment-picker']).
config(['$routeProvider', function ($routeProvider) {
	$routeProvider.
	when('/', {
		templateUrl: BASE_URL+'owner/dashboard',
		controller: HomeCtrl,
		activetab: 'dashboard'
	}).
	when('/admin-profile', {
		templateUrl: BASE_URL+'owner/changepassword',
		controller: changePasswordCtrl,
		activetab: 'changepassword'
	}).
	when('/school-view/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/schoolView';
		},
		controller: allSchoolCtrl,
		activetab: 'schoolView'
	}).
	when('/school-list', {
		templateUrl: BASE_URL+'owner/schoolList',
		controller: getAllSchoolCtrl,
		activetab: 'schoolList'
	}).
	when('/edit-school/:ID', {
		templateUrl: function(urlattr){
			return BASE_URL+'owner/editSchool';
		},
		controller: editSchoolCtrl,
		activetab: 'editSchool'
	}).
	when('/add-school', {
		templateUrl: BASE_URL+'owner/addSchool',
		controller: addSchoolCtrl,
		activetab: 'addSchool'
	}).
	when('/goal-list', {
		templateUrl: BASE_URL+'owner/goalList',
		controller: getAllGoalCtrl,
		activetab: 'goalList'
	}).
	when('/add-goal', {
		templateUrl: BASE_URL+'owner/addGoal',
		controller: addGoalCtrl,
		activetab: 'addGoal'
	}).
	when('/edit-goal/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/editGoal';
		},
		controller: editGoalCtrl,
		activetab: 'editGoal'
	}).
	when('/gift-list', {
		templateUrl: BASE_URL+'owner/giftList',
		controller: getAllGiftCtrl,
		activetab: 'giftList'
	}).
	when('/add-gift', {
		templateUrl: BASE_URL+'owner/addGift',
		controller: addGiftCtrl,
		activetab: 'addGift'
	}).
	when('/edit-gift/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/editGift';
		},
		controller: editGiftCtrl,
		activetab: 'editGift'
	}).
	when('/role-list', {
		templateUrl: BASE_URL+'owner/roleList',
		controller: getAllRoleCtrl,
		activetab: 'roleList'
	}).
	when('/add-role', {
		templateUrl: BASE_URL+'owner/addRole',
		controller: addRoleCtrl,
		activetab: 'addRole'
	}).
	when('/edit-role/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/editRole';
		},
		controller: editRoleCtrl,
		activetab: 'editRole'
	}).
	when('/privilege-list', {
		templateUrl: BASE_URL+'owner/privilegeList',
		controller: getAllPrivilegeCtrl,
		activetab: 'privilegeList'
	}).
	when('/add-privilege', {
		templateUrl: BASE_URL+'owner/addPrivilege',
		controller: addPrivilegeCtrl,
		activetab: 'addPrivilege'
	}).
	when('/edit-privilege/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/editPrivilege';
		},
		controller: editPrivilegeCtrl,
		activetab: 'editPrivilege'
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

app.config(['$locationProvider', function ($location) {
	$location.hashPrefix('!');
	//$location.html5Mode(true);
}]);