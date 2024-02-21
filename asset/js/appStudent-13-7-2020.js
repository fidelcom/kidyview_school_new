'use strict';

var app = angular.module('KidyViewStudent',['ngRoute','angularUtils.directives.dirPagination','datatables']).
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
	otherwise({redirectTo: '/'});
	}]).run(['$rootScope','$location', '$http', '$browser', '$timeout', "$route", function ($scope, $location,$http, $browser, $timeout, $route) {
	
	$scope.$on('$routeChangeStart', function ($event, next, current) {
		$scope.isRouteLoading = true;   
	
	});
	
	$scope.$on("$routeChangeSuccess", function (scope, next, current) {
		$scope.part = $route.current.activetab;
	});
	
}]);

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