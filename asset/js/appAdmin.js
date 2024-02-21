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
	when('/profile', {
		templateUrl: BASE_URL+'owner/profile',
		controller: profileCtrl,
		activetab: 'profile'
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
		activetab: 'editSchool',
		resolve: {
            schoolTypeListData: function(schooltype) {
                return schooltype.schoolTypeData();
            }
        }
	}).
	when('/add-school', {
		templateUrl: BASE_URL+'owner/addSchool',
		controller: addSchoolCtrl,
		activetab: 'addSchool',
		resolve: {
            schoolTypeListData: function(schooltype) {
                return schooltype.schoolTypeData();
            }
        }
	}).
	when('/teacher-view/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/teacherView';
		},
		controller: TeacherDetailCtrl,
		activetab: 'teacherView'
	}).
	when('/teacher-list', {
		templateUrl: BASE_URL+'owner/teacherList',
		controller: TeacherListCtrl,
		activetab: 'teacherList'
	}).
	when('/driver-list', {
		templateUrl: BASE_URL+'owner/driverList',
		controller: DriverListCtrl,
		activetab: 'driverList'
	}).
	when('/driver-view/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/driverView';
		},
		controller: DriverDetailCtrl,
		activetab: 'driverView'
	}).
	when('/parent-list', {
		templateUrl: BASE_URL+'owner/parentList',
		controller: ParentListCtrl,
		activetab: 'parentList'
	}).
	when('/parent-view/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/parentView';
		},
		controller: ParentDetailCtrl,
		activetab: 'parentView'
	}).
	when('/login-image', { 
		templateUrl: BASE_URL+'owner/loginimage',
		controller: LoginImageCtrl,
		activetab: 'loginimage'
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
	when('/subadmin-list', {
		templateUrl: BASE_URL+'owner/subAdminList',
		controller: getAllSubadminCtrl,
		activetab: 'subAdminList'
	}).
	when('/add-subadmin', {
		templateUrl: BASE_URL+'owner/addSubAdmin',
		controller: addSubadminCtrl,
		activetab: 'addSubAdmin'
	}).
	when('/subadmin-detail/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/subAdminView';
		},
		controller: allSubadminCtrl,
		activetab: 'parentView'
	}).
	when('/edit-subadmin/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/editSubadmin';
		},
		controller: editSubadminCtrl,
		activetab: 'editSubadmin'
	}).
	when('/subscription-list', {
		templateUrl: BASE_URL+'owner/subscriptionList',
		controller: SubscriptionListCtrl,
		activetab: 'subscriptionList'
	}).
	when('/add-subscription', {
		templateUrl: BASE_URL+'owner/addSubscription',
		controller: AddSubscriptionCtrl,
		activetab: 'AddSubscriptionCtrl'
	}).
	when('/subscription-detail/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/subscriptionView';
		},
		controller: EditSubscriptionCtrl,
		activetab: 'subscriptionView'
	}).
	when('/edit-subscription/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/editSubscription';
		},
		controller: EditSubscriptionCtrl,
		activetab: 'subscriptionEdit'
	}).
	when('/fees-category', {
		templateUrl: BASE_URL+'owner/feesCategory',
		controller: feesCategoryCtrl,
		activetab: 'feesCategory'
	}).
	when('/add-fees-category', {
		templateUrl: BASE_URL+'owner/addFeesCategory',
		controller: addFeesCategoryCtrl,
		activetab: 'addFeesCategory'
	}).
	when('/edit-fees-category/:ID', {
		templateUrl: BASE_URL+'owner/editFeesCategory',
		controller: editFeesCategoryCtrl,
		activetab: 'editFeesCategory'
	}).
	when('/voucher-list', {
		templateUrl: BASE_URL+'owner/voucher',
		controller: voucherListCtrl,
		activetab: 'voucher'
	}).
	when('/add-voucher', {
		templateUrl: BASE_URL+'owner/addVoucher',
		controller: addVoucherCtrl,
		activetab: 'addVoucher'
	}).
	when('/edit-voucher/:ID', {
		templateUrl: BASE_URL+'owner/editVoucher',
		controller: editVoucherCtrl,
		activetab: 'editVoucherCtrl'
	}).
        when('/feedback', {
		templateUrl: BASE_URL+'owner/feedback',
		controller: feedbackCtrl,
		activetab: 'feedbackList'
	}). 
        when('/feedback-view/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/feedbackView';
		},
		controller: feedbackViews,
		activetab: 'feedbackView'
	}).
         when('/reportParent', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/reportParent';
		},
		controller: reportParent,
		activetab: 'reportParent'
	}).
          when('/reportStudent', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/reportStudent';
		},
		controller: reportStudent,
		activetab: 'reportStudent'
	}).  
          when('/reportTeacher', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/reportTeacher';
		},
		controller: reportTeacher,
		activetab: 'reportTeacher'
	}).  
          when('/reportDriver', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/reportDriver';
		},
		controller: reportDriver,
		activetab: 'reportDriver'
	}).  
    when('/reportRevenue', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/reportRevenue';
		},
		controller: reportRevenue,
		activetab: 'reportRevenue'
	}).  
         when('/reportSchool', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/reportSchool';
		},
		controller: reportSchool,
		activetab: 'reportSchool'
	}).
        when('/revenue-graph', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/revenueGraph';
		},
		controller: revenueGraph,
		activetab: 'revenueGraph'
	}).
        when('/sponser', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/sponser';
		},
		controller: sponser,
		activetab: 'sponser'
	}).
        when('/edit-sponser/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/editsponser';
		},
		controller: editSponser,
		activetab: 'editSponser'
	}). 
        when('/add-currency', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/addcurrency';
		},
		controller: addcurrency,
		activetab: 'addcurrency'
	}).
        when('/edit-currency/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/editcurrency';
		},
		controller: editcurrency,
		activetab: 'editcurrency'
	}).
        when('/map-currency', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/mapcurrency';
		},
		controller: mapcurrency,
		activetab: 'mapcurrency'
	}).
        when('/transaction-list/:ID', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/transactionLlist';
		},
		controller: transactionLlist,
		activetab: 'transactionLlist'
	}).
	when('/notification', {
	  templateUrl: BASE_URL+'owner/notificationList',
	  controller: notificationListCtrl,
	  activetab: 'notificationList'
	}).
	when('/payment-list', {
		templateUrl: function(urlattr){
		return BASE_URL+'owner/paymentList';
		},
		controller: payment,
		activetab: 'payment'
	}).   
	otherwise({redirectTo: '/'});
	}]).run(['$rootScope','$location', '$http', '$browser', '$timeout', "$route", function ($scope,$location, $http, $browser, $timeout, $route) {
	
	$scope.$on('$routeChangeStart', function ($event, next, current) {
		console.log('test');
		$scope.isRouteLoading = true; 
                if(next.$$route != undefined)
                {
                    var orgpath=next.$$route.originalPath; 
                }
		var retn=1;
		var checlPrivilege = JSON.parse(jsonPrivilege);
                
                if(checlPrivilege.length > 0){
                    if(orgpath=='/school-list'){
                            if(checlPrivilege.SchoolManagement['view']==0){
                                    retn=0;
                            }
                    }
                    if(orgpath=='/add-school'){
                            if(checlPrivilege.SchoolManagement['add']==0){
                                    retn=0;
                            }
					}
					
                    if(orgpath=='/edit-school/:ID'){
                            if(checlPrivilege.SchoolManagement['edit']==0){
                                    retn=0;
                            }
                    }
                    if(orgpath=='/subadmin-list'){
                            if(checlPrivilege.SuperSubAdmin['view']==0){
                                    retn=0;
                            }
                    }
                    if(orgpath=='/add-subadmin'){
                            if(checlPrivilege.SuperSubAdmin['add']==0){
                                    retn=0;
                            }
                    }
                    if(orgpath=='/edit-subadmin/:ID'){
                            if(checlPrivilege.SuperSubAdmin['edit']==0){
                                    retn=0;
                            }
                    }
                    if(orgpath=='/role-list'){
                            if(checlPrivilege.RoleManagement['view']==0){
                                    retn=0;
                            }
                    }
                    if(orgpath=='/add-role'){
                            if(checlPrivilege.RoleManagement['add']==0){
                                    retn=0;
                            }
                    }
                    if(orgpath=='/edit-role/:ID'){
                            if(checlPrivilege.RoleManagement['edit']==0){
                                    retn=0;
                            }
                    }
                    if(orgpath=='/privilege-list'){
                            if(checlPrivilege.PrivilegeManagement['view']==0){
                                    retn=0;
                            }
                    }
                    if(orgpath=='/add-privilege'){
                            if(checlPrivilege.PrivilegeManagement['add']==0){
                                    retn=0;
                            }
                    }
                    if(orgpath=='/edit-privilege/:ID'){
                            if(checlPrivilege.PrivilegeManagement['edit']==0){
                                    retn=0;
                            }
                    }
                    if(orgpath=='/goal-list'){
                            if(checlPrivilege.GoalsManagement['view']==0){
                                    retn=0;
                            }
                    }
                    if(orgpath=='/add-goal'){
                            if(checlPrivilege.GoalsManagement['add']==0){
                                    retn=0;
                            }
                    }
                    if(orgpath=='/edit-goal/:ID'){
                            if(checlPrivilege.GoalsManagement['edit']==0){
                                    retn=0;
                            }
                    }
                    if(orgpath=='/gift-list'){
                            if(checlPrivilege.GiftManagement['view']==0){
                                    retn=0;
                            }
                    }
                    if(orgpath=='/add-gift'){
                            if(checlPrivilege.GiftManagement['add']==0){
                                    retn=0;
                            }
                    }
                    if(orgpath=='/edit-gift/:ID'){
                            if(checlPrivilege.GiftManagement['edit']==0){
                                    retn=0;
                            }
                    }	
                    if(retn==0){
                            var Gritter = function () {
                                    $.gritter.add({
                                            title: 'Error',
                                            text: 'You have not access permiision for this.'
                                    });
                                    return false;
                            }();
                            $location.path('#/');
                    } 

                }
	});
	
	$scope.$on("$routeChangeSuccess", function (scope, next, current) {
		$scope.part = $route.current.activetab;
	});
	
}]);

app.factory('schooltype', function($http) {

			var schoolTypeData = function() {

			var	schoolTypeList=[];
			return $http.get(BASE_URL+'api/user/schoolType',{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey
				}
				}).then(function(response) {
				
				if(response.status == 200)
				{
					schoolTypeList = response.data;
					//console.log(schoolTypeList);
				}
				return schoolTypeList; 
				}, function errorCallback(response){
					return false;
					
			});
		};
	
		return {
			schoolTypeData: schoolTypeData
		};
	
});

app.config(['$locationProvider', function ($location) {
	$location.hashPrefix('!');
	//$location.html5Mode(true);
}]);
app.filter('myDate', function($filter) {    
	var angularDateFilter = $filter('date');
	return function(theDate) {
	   return angularDateFilter(theDate, 'dd MMM y');
	}
});
app.directive('allowDecimalNumbers', function () {  
    return {  
        restrict: 'A',  
        link: function (scope, elm, attrs, ctrl) {  
            elm.on('keydown', function (event) {  
                var $input = $(this);  
                var value = $input.val();  
                value = value.replace(/[^0-9\.]/g, '')  
                var findsDot = new RegExp(/\./g)  
                var containsDot = value.match(findsDot)  
                if (containsDot != null && ([46, 110, 190].indexOf(event.which) > -1)) {  
                    event.preventDefault();  
                    return false;  
                }  
                $input.val(value);  
                if (event.which == 64 || event.which == 16) {  
                    // numbers  
                    return false;  
                } if ([8, 13, 27, 37, 38, 39, 40, 110].indexOf(event.which) > -1) {  
                    // backspace, enter, escape, arrows  
                    return true;  
                } else if (event.which >= 48 && event.which <= 57) {  
                    // numbers  
                    return true;  
                } else if (event.which >= 96 && event.which <= 105) {  
                    // numpad number  
                    return true;  
                } else if ([46, 110, 190].indexOf(event.which) > -1) {  
                    // dot and numpad dot  
                    return true;  
                } else {  
                    event.preventDefault();  
                    return false;  
                }  
            });  
        }  
    }  
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