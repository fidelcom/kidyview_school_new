'use strict';
//Controllers
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
	$scope.class_id='';
	$scope.subject_id='';
	$scope.category='';
	$scope.datefilter='';
	$scope.classArray=[];
	$scope.subjectArray=[];
	$scope.categoryArray=[];
	$scope.getAssignmentList=function(){
		var formData={'school_id':schoolID,'class_id':$scope.class_id,'subject_id':$scope.subject_id,'category':$scope.category,'filterbydate':''}
		$http.post(BASE_URL+'api/teachers/assignment/getAssignmentList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,
				'TOKEN':localStorage.getItem("TOKEN")
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
	$scope.getAssignmentList();
	$scope.deleteAssignment = function(ID,index)
	{
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':ID};
			$http.post(BASE_URL+'api/teachers/assignment/deleteAssignment',formData,{
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
function studentListCtrl($scope, $http, $route, $window) 
{
	$scope.showGridList=function(){
		$('#listView').hide();
		$('#gridView').show();
		$('#listView-tab').removeClass('active');
		$('#ridView-tab').addClass('active');
	}
	$scope.showList=function(){
		$('#listView').show();
		$('#gridView').hide();
		$('#listView-tab').addClass('active');
		$('#ridView-tab').removeClass('active');
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
	$scope.pageSize = 12;
	$scope.getStudentList=function(){
		var formData={'school_id':schoolID,'classID':''}
		$http.post(BASE_URL+'api/teachers/student/getStudentList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.studentData = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.studentData.length; i++)
				{
					encrypted = $scope.encryptStr($scope.studentData[i].id);
					$scope.studentData[i]['studentID'] = encrypted;
				}
			}
			}, function errorCallback(response){
			
		});
	}
	$scope.getStudentList();
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
	$scope.assignmentinfo = false;
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
	$scope.getStudentDetailsById = function()
	{
		var formData = {'id':$scope.studentID,'classID':''}
		$http.post(BASE_URL+'api/teachers/student/getStudentDetailsById',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{   
				var encrypted;
				$scope.studentinfo = response.data.data;
				$scope.chatUserID = $scope.encryptStr("ST-"+$scope.studentinfo.id);
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getStudentDetailsById();
}
function classboardListCtrl($scope, $http, $route, $window) 
{
	$scope.delete = function(ID,index)
	{
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':ID};
			$http.post(BASE_URL+'api/teachers/classboard/deleteClassboard',formData,{
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
							text: response.data.message
						});
						$scope.getClassboardList();
						//$scope.classboardData.splice(index, 1);;
						return false;
					}();
				}
				
				}, function errorCallback(response){
				
			});
		}
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
	$scope.start=0;
	$scope.limit=10;
	$scope.getClassboardList=function(){
		var formData={'school_id':schoolID,'classID':'','offset':$scope.start,'per_page':$scope.limit}
		$http.post(BASE_URL+'api/teachers/classboard/getClassboardList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.classboardData = response.data.data;
				$scope.countclassboardData = response.data.count;
				var encrypted ;
				for(var i = 0; i < $scope.classboardData.length; i++)
				{
					encrypted = $scope.encryptStr($scope.classboardData[i].id);
					$scope.classboardData[i]['classboardID'] = encrypted;
				}
			}
			}, function errorCallback(response){
				
				$scope.classboardData=[];
				$scope.countclassboardData = response.data.count;
				
		});
	}
	$scope.getClassboardList();
	$scope.loadMoreClassboardData=function(){
		$scope.start++;
		var formData={'classID':'','offset':$scope.start,'per_page':$scope.limit}
		$http.post(BASE_URL+'api/teachers/classboard/getClassboardList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.moreData = response.data.data;
				$scope.countclassboardData = response.data.count;
				var encrypted ;
				for(var i = 0; i < $scope.moreData.length; i++)
				{
					encrypted = $scope.encryptStr($scope.moreData[i].id);
					$scope.moreData[i]['classboardID'] = encrypted;
					$scope.classboardData.push($scope.moreData[i]);
				}
			}
			}, function errorCallback(response){
				$scope.moreData=[];
				$scope.countclassboardData = response.data.count;
		});
	}
} 
function createClassboardCtrl($scope, $http, $route, $window) 
{
	$scope.setting1 = {
		scrollableHeight: '200px',
		scrollable: true,
		enableSearch: true,
		displayProp: 'childname'
	};
	$scope.student=[];
	$scope.classroom='';
	$scope.description='';
	
	$scope.createClassboard=function(){
		if($scope.classroom == '')
		{
			$scope.errormsg = 'Classroom is required.';
			return false;
		}else if($scope.class=='')
		{
			$scope.errormsg = 'Class is required.';
			return false;
		}
		else if($scope.student.length==0)
		{
			$scope.errormsg = 'Please select at least one student.';
			return false;
		}
		var formData = {'school_id':schoolID,'classroom':$scope.classroom,'class_id':$scope.class,'student_id':$scope.student, 'description':$scope.description}
		$http.post(BASE_URL+'api/teachers/classboard/createClassboard',formData,{
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
						text: response.data.message
					});
					$scope.errormsg = '';
					return false;
				}();
				$window.location.href = '#!/classboard-list';
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
	$scope.class='';
	$scope.getStudentList=function(){
		$scope.student=[];
		var formData={'class':$scope.class}
		$http.post(BASE_URL+'api/teachers/classboard/getStudentByClass',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.studentData = response.data.data;
			}
			}, function errorCallback(response){
				$scope.studentData =[];
		});
	}
	$scope.getStudentList();
	$scope.getTeacherClass=function(){
		var formData={'schoolID':schoolID}
		$http.post(BASE_URL+'api/teachers/classboard/getTeacherClass',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
	$scope.getTeacherClass();
}
function editClassboardCtrl($scope, $http, $routeParams, $timeout,$window) 
{
	$scope.setting1 = {
		scrollableHeight: '200px',
		scrollable: true,
		enableSearch: true,
		displayProp: 'childname'
	};
	$scope.class='';
	$scope.getTeacherClass=function(){
		var formData={'schoolID':schoolID}
		$http.post(BASE_URL+'api/teachers/classboard/getTeacherClass',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
	$scope.getTeacherClass();
	$scope.getStudentList=function(classID=''){
		if(classID!=''){
			var classval=classID;
		}else{
			var classval=$scope.class;
			$scope.student=[];
		}
		
		var formData={'class':classval}
		$http.post(BASE_URL+'api/teachers/classboard/getStudentByClass',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.studentData = response.data.data;
			}
			}, function errorCallback(response){
				$scope.studentData =[];
		});
	}
	//$scope.getStudentList();
	var sid;
	$scope.classboardID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.classboardID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.classboardID;
	};	
	$timeout($scope.setID(), 2000);
	$scope.roleinfo = false;
	$scope.name 	= '';
	$scope.getClassboardDetails = function()
	{
		var formData = {'id':$scope.classboardID}
		$http.post(BASE_URL+'api/teachers/classboard/getClassboardDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.classboardinfo = response.data.data;
				$scope.classroom  = $scope.classboardinfo.name;
				$scope.class  = $scope.classboardinfo.class_id;
				$scope.description  = $scope.classboardinfo.description;
				$scope.stExp  = $scope.classboardinfo.stid.split(',');
				$scope.student=[];
				for(var i = 0; i < $scope.stExp.length; i++)
				{
					$scope.student.push({'id':$scope.stExp[i]});
					
				}
				console.log($scope.student);
				$scope.getStudentList($scope.class);
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getClassboardDetails();
	
	$scope.editClassboard=function(){
		if($scope.classroom == '')
		{
			$scope.errormsg = 'Classroom is required.';
			return false;
		}else if($scope.class=='')
		{
			$scope.errormsg = 'Class is required.';
			return false;
		}
		else if($scope.student.length==0)
		{
			$scope.errormsg = 'Please select at least one student.';
			return false;
		}
		var formData = {'classboardid':$scope.classboardID,'classroom':$scope.classroom,'class_id':$scope.class,'student_id':$scope.student, 'description':$scope.description}
		$http.post(BASE_URL+'api/teachers/classboard/editClassboard',formData,{
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
						text: response.data.message
					});
					$scope.errormsg = '';
					return false;
				}();
				$window.location.href = '#!/classboard-list';
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
function allPostCtrl($scope, $http, $routeParams, $timeout,$window,$sce) 
{
	$scope.addPost=function(postdata){
		$scope.editAttachmentData='';
		$scope.postID='';
		$scope.description='';
		$scope.previewImages=[];
		$scope.PreviewImage=[];
		$('#post-c-comment').modal('show');
	}
	var file_not_allowed_msg="Only jpeg,jpg,png,doc file supported.";
	var validImageTypes=new Array('image/jpeg','image/jpg','image/png','application/pdf','application/doc','application/docx');
	$scope.previewImages=[];
	$scope.SelectFile = function (e) {
		$scope.previewImages	= [];
		$scope.PreviewImage=[];
	for(var i=0;i<e.target.files.length;i++){
		var type;
		var reader = new FileReader();
		reader.fileName = e.target.files[i].name;
		if (( !validImageTypes.includes(e.target.files[i].type) ) )
		{
			$window.alert(file_not_allowed_msg);
			return false;
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
	$scope.classboardID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.classboardID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.classboardID;
	};	
	$timeout($scope.setID(), 2000);

	$scope.description 	  	= '';
	$scope.pic 	  	= '';
	$scope.showLoader=0;
	$scope.createPost=function(){
		if($scope.description == '')
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
		$scope.showLoader=1;
		var formData = new FormData();
		formData.append('description', $scope.description);
		formData.append('classboard_id', $scope.classboardID);
		formData.append('post_id', $scope.postID);
		var files = document.getElementById('pic').files;
		if($scope.previewImages.length > 0)
		{
			for(var i = 0; i < $scope.previewImages.length; i++)
			{ 
				formData.append('files[]', $scope.previewImages[i]);
			}
		}
		$http.post(BASE_URL+'api/teachers/classboard/createPost',formData,{
			transformRequest: angular.identity,
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
				var result  = response.data;
				$scope.showLoader=0;
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: response.data.message
					});
					//$window.location.href = '#!/view-post';
					$('#post-c-comment').modal('hide');
					$scope.description='';
					$scope.previewImages=[];
					$scope.PreviewImage=[];
					$scope.getClassboardPostList();
					return false;
				}();
			
			}, function errorCallback(response){
				$scope.showLoader=0;
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
	$scope.start=0;
	$scope.limit=10;
	$scope.getClassboardPostList=function(){
		var formData={'classboardID':$scope.classboardID,'offset':$scope.start,'per_page':$scope.limit}
		$http.post(BASE_URL+'api/teachers/classboard/getClassboardPostList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.classboardPostData = response.data.data;
				$scope.countclassboardPostData = response.data.count;
				var encrypted ;
				for(var i = 0; i < $scope.classboardPostData.length; i++)
				{
					encrypted = $scope.encryptStr($scope.classboardPostData[i].id);
					$scope.classboardPostData[i]['classboardPostID'] = encrypted;
				}
			}
			}, function errorCallback(response){
				$scope.classboardPostData=[];
				$scope.countclassboardPostData = response.data.count;
		});
	}
	$scope.getClassboardPostList();
	$scope.loadMoreClassboardPostList=function(){
		$scope.start++;
		var formData={'classboardID':$scope.classboardID,'offset':$scope.start,'per_page':$scope.limit}
		$http.post(BASE_URL+'api/teachers/classboard/getClassboardPostList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.moreData = response.data.data;
				$scope.countclassboardPostData = response.data.count;
				var encrypted ;
				for(var i = 0; i < $scope.moreData.length; i++)
				{
					encrypted = $scope.encryptStr($scope.moreData[i].id);
					$scope.moreData[i]['classboardPostID'] = encrypted;
					$scope.classboardPostData.push($scope.moreData[i]);
				}
			}
			}, function errorCallback(response){
				$scope.moreData=[];
				$scope.countclassboardPostData = response.data.count;
		});
	}
	$scope.editPost=function(postdata){
		$scope.description=postdata.description;
		$scope.editAttachmentData=postdata.attachmentData;
		$scope.postID=postdata.id;
		$('#post-c-comment').modal('show');
	}
	$scope.deletePost = function(ID,index)
	{
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':ID};
			$http.post(BASE_URL+'api/teachers/classboard/deletePost',formData,{
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
							text: response.data.message
						});
						$scope.getClassboardPostList();
						//$scope.classboardPostData.splice(index, 1);;
						return false;
					}();
				}
				
				}, function errorCallback(response){
				
			});
		}
	}
	$scope.removeEdit=function(data,index){
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':data.id,'filename':data.file};
			$http.post(BASE_URL+'api/teachers/classboard/deletePostAttachData',formData,{
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
							text: result.message
						});
						if (index > -1) {
						$scope.editAttachmentData.splice(index, 1);;
						return false;
						}
					}();
				}
				
				}, function errorCallback(response){
				
			});
		} 
	}
	$scope.postcomment=[];
	$scope.comment=function(commentdata,index){
		if($scope.postcomment.length==0){
			return false;
		}
		var formData = {'post_id':commentdata.id,'classboard_id':commentdata.classboard_id,'comment':$scope.postcomment[index]}
		$http.post(BASE_URL+'api/teachers/classboard/addClaasboarPostComment',formData,{
			headers:{
				'Content-Type':'application/json',
				'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.result = response.data.data;
				commentdata.commentData.splice(0, 0, $scope.result);
				$scope.postcomment[index]='';
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
			$http.post(BASE_URL+'api/teachers/classboard/deleteComment',formData,{
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
							text: response.data.message
						});
						commentdata.commentData.splice(index, 1);
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
function teacherAssignmentCtrl($scope, $http, $route, $window) 
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
		var formData={'school_id':schoolID,'class_id':$scope.class_id,'subject_id':$scope.subject_id,'category':$scope.category,'filterbydate':''}
		$http.post(BASE_URL+'api/teachers/assignment/getAssignmentList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
	$scope.getAssignmentList();
	$scope.deleteAssignment = function(ID,index)
	{
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':ID};
			$http.post(BASE_URL+'api/teachers/assignment/deleteAssignment',formData,{
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
		$http.post(BASE_URL+'api/teachers/assignment/getAssignmentDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
function createAssignmentCtrl($scope, $http, $route, $window) 
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
		formData.append('school_id', schoolID);
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
		
		$http.post(BASE_URL+'api/teachers/assignment/createAssignment',formData,{
			transformRequest: angular.identity,
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
	
	$scope.getTeacherSubjectClass=function(){
		var formData={'classID':''}
		$http.post(BASE_URL+'api/teachers/assignment/getTeacherSubjectClass',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
		$http.post(BASE_URL+'api/teachers/assignment/getTeacherSubject',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
function submitedAssignmentCtrl($scope, $http, $route, $window) 
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
		var formData={'schoolID':schoolID,'class_id':$scope.class_id,'subject_id':$scope.subject_id,'category':$scope.category}
		$http.post(BASE_URL+'api/teachers/assignment/getStudentSubmitedAssignmentList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
				'Content-Type':undefined, 'x-api-key':xapikey
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
				'Content-Type':undefined, 'x-api-key':xapikey
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
				'Content-Type':undefined, 'x-api-key':xapikey
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
					'Content-Type':undefined, 'x-api-key':xapikey
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
		$http.post(BASE_URL+'api/teachers/assignment/getAssignmentDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
	$scope.getAssignmentDetails();
	$scope.getTeacherSubjectClass=function(){
		var formData={'classID':''}
		$http.post(BASE_URL+'api/teachers/assignment/getTeacherSubjectClass',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
		$http.post(BASE_URL+'api/teachers/assignment/getTeacherSubject',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
		formData.append('school_id', schoolID);
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
		
		$http.post(BASE_URL+'api/teachers/assignment/editAssignment',formData,{
			transformRequest: angular.identity,
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
function messageListCtrl($scope, $http, $route, $window,$interval) 
{
	$scope.deleteMessage = function(user)
	{
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'user':user};
			$http.post(BASE_URL+'api/teachers/message/deleteConversationMessage',formData,{
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
							text: result.message
						});
					}();
					$scope.getMessageList();
				}
				
				}, function errorCallback(response){
				
			});
		}
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
	$scope.getMessageList=function(){
		var formData={'schoolID':schoolID}
		$http.post(BASE_URL+'api/teachers/message/getMessageList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.messageData = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.messageData.length; i++)
				{
					encrypted = $scope.encryptStr($scope.messageData[i].id);
					$scope.messageData[i]['userID'] = encrypted;
				}
				
			}
			}, function errorCallback(response){
				$scope.messageData=[];
		});
	}
	$scope.getMessageList();
	/*$interval(function () {
		//$scope.getMessageList();
	}, 3000);*/
} 
function sendMessageCtrl($scope, $http, $routeParams, $timeout,$window,$sce,$interval) 
{
	$scope.setting1 = {
		scrollableHeight: '200px',
		scrollable: true,
		enableSearch: true,
		displayProp: 'name'
	};
	$scope.deleteConversation = function(user)
	{
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'user':user};
			$http.post(BASE_URL+'api/teachers/message/deleteConversationMessage',formData,{
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
							text: result.message
						});
					}();
					$window.location.href = '#!/message-list';
				}
				
				}, function errorCallback(response){
				
			});
		}
	}
	$scope.user=[];
	$scope.userID='';
	$scope.usertype='';
	$scope.usertypeData=[{'label':'Student','value':'student'},{'label':'Teacher','value':'teacher'}]
	$scope.usertype=$scope.usertypeData[0]['value'];
	$scope.getUser=function(){
		$scope.user=[];
		var formData={'schoolID':schoolID,'user_type':$scope.usertype}
		$http.post(BASE_URL+'api/teachers/message/getUser',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.userData = response.data.data;
			}
			}, function errorCallback(response){
				$scope.userData=[];
		});
	}
	$scope.getUser();	
	var sid;
	$scope.setID = function(){
		if($routeParams.ID){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.userID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.userID;
		if(sid!=''){
		$scope.user.push({'id':sid});
		$scope.usertype='';
		}
	}
	};	
	$timeout($scope.setID(), 2000);
	$scope.getConversationList=function(){
		var formData={'user_id':$scope.userID}
		$http.post(BASE_URL+'api/teachers/message/getConversationList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.conversationData = response.data.data;
				if($scope.conversationData.conversation.length > 0)
				{
				for(var i = 0; i < $scope.conversationData.conversation.length; i++)
				{ 
					if($scope.conversationData.conversation[i]['attachments'].length > 0)
					{
					for(var j = 0; j < $scope.conversationData.conversation[i]['attachments'].length; j++)
					{ 
						var filename=$scope.conversationData.conversation[i]['attachments'][j]['file'];
						var extn = filename.split(".").pop();
						$scope.conversationData.conversation[i]['attachments'][j]['filetype']=extn;
					}
					}
				}
				}
				
			}
			}, function errorCallback(response){
				$scope.conversationData=[];
			});
	}
	//$scope.getConversationList();

	if($scope.userID==''){
		$scope.getConversationList();
	}else{
	$interval(function () {
		$scope.getConversationList();
		//$('#conversationDiv').scrollTop($(window).height());
	}, 1000);
	}
	$scope.previewImages=[];
	$scope.PreviewImage=[];
	$scope.SelectFile = function (e) {
		$scope.previewImages	= [];
		$scope.PreviewImage=[];
		for(var i=0;i<e.target.files.length;i++){
			var type;
			var reader = new FileReader();
			reader.fileName = e.target.files[i].name;
			var filename=e.target.files[i].name;
			var dd= filename.split(".").pop();
			reader.extn = angular.lowercase(dd);
			$scope.previewImages.push(e.target.files[i]);
			
			reader.onload = function (e) {	
			$scope.PreviewImage.push({'name':e.target.fileName,'filetype':dd,'file':e.target.result});
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
	$scope.title='';
	$scope.message='';
	$scope.showLoader=0;
	$scope.convertDateNewFormat = function(str) {
		var date = new Date(str),
		mnth = ("0" + (date.getMonth() + 1)).slice(-2),
		day = ("0" + date.getDate()).slice(-2);
		return [date.getFullYear(), mnth, day].join("-");
	}
	$scope.isMsg=0;
	$scope.sendMessage=function(){

		if($scope.user.length==0)
		{
			$scope.errormsg = 'Please select at least one receiver.';
			return false;
		}else if($scope.message=='' && $scope.PreviewImage.length==0)
		{
			$scope.errormsg = 'Message is required.';
			return false;
		}
		$scope.showLoader=1;
		$scope.isMsg=1;
		//console.log($scope.user);
		var formData = new FormData();
		formData.append('schoolID', schoolID);
		formData.append('message', $scope.message);
		formData.append('usertype', $scope.usertype);
		if($scope.user.length > 0)
		{
			for(var i = 0; i < $scope.user.length; i++)
			{ 
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
		
		$http.post(BASE_URL+'api/teachers/message/sendMessage',formData,{
			transformRequest: angular.identity,
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.showLoader=0;
				$scope.isMsg=0;
				$scope.result = response.data.data;
				if($scope.usertype!=''){
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: response.data.message
					});
					$scope.errormsg = '';
					$scope.message = '';
					return false;
				}();
				$window.location.href = '#!/message-list';
			}else{
				$scope.getConversationList();
				$scope.message='';
				$scope.isMsg=0;
				$scope.previewImages=[];
				$scope.PreviewImage=[];
			}
			}
			
			}, function errorCallback(response){
				$scope.showLoader=0;
				$scope.isMsg=0;
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
function teacherProfileCtrl($scope, $http, $route, $window) 
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
		var formData = {'opsw':$scope.opsw,'npsw':$scope.npsw, 'id':''}
		$http.post(BASE_URL+'api/teachers/profile/changePasswordTeacher',formData,{
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
			
			$scope.msg = response.data.message;
			if($scope.msg=="Old password not match."){
				var Gritter = function () {
					$.gritter.add({
						title: 'Error',
						text: 'Your old password not match.'
					});
					$scope.errormsg = '';
					return false;
				}();
			}else{
			$scope.errormsg = 'Sorry! Your Password is not updated.';
			$scope.successmsg = '';
			}
		});	
	}
	$scope.getDetails = function()
	{
		var formData = {'id':''}
		$http.post(BASE_URL+'api/teachers/profile/getTeacherDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.teacherData = response.data.data;
				console.log($scope.teacherData);
			}
			
			}, function errorCallback(response){
				$scope.teacherData=[];
		});
		
	}
	$scope.getDetails();
	$scope.removeProfilePic = function(teacherData)
	{
		var formData = {'pic':teacherData.teacherphoto}
		$http.post(BASE_URL+'api/teachers/profile/removeProfilePic',formData,{
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
				teacherData.teacherphoto='';
			}();
			var newSrc = BASE_URL+'img/default-profilePic.png';
			$('.user-profile img').attr('src', newSrc);
			$('.user-settings img').attr('src', newSrc);
			
            }, function errorCallback(){
		});
		
	}
	$scope.ImageUpload 	= function(f)
    {
        var varFile = f.files[0];
        var fd 	= new FormData();
		fd.append('image', varFile);
        $http.post(BASE_URL+'api/teachers/profile/profileImage', fd, {
            transformRequest: angular.identity,
            headers:{
                'Content-Type':undefined, 'x-api-key':xapikey,
            }
        }).then(function(response) {
			$scope.teacherData.teacherphoto = response.data.file_name; 
			var newSrc = BASE_URL+'img/teacher/'+$scope.teacherData.teacherphoto;
			$('.user-profile img').attr('src', newSrc);
			$('.user-settings img').attr('src', newSrc);           
                        
        }, function errorCallback(response){
                            
        });
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
		var formData = {'id':schoolID,'classID':'','calendardate':$scope.calendardate,'iscalendardata':0};
		$http.post(BASE_URL+'api/teachers/calendar/getAllCalendarData',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.calendarList = response.data.data;	
			}
			}, function errorCallback(response){
			$scope.calendarList=[];
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
		var events = [{title: 'Feed Me ' + m,start: s + (50000),end: s + (100000),allDay: false, className: ['customFeed']}];
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
function classScheduleListCtrl($scope, $http, $route, $window) 
{
	$scope.class_id='';
	$scope.getClassScheduleList=function(){
		var formData={'schoolID':schoolID,'classID':$scope.class_id}
		$http.post(BASE_URL+'api/teachers/timetable/getClassScheduleList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.timeTableData = response.data.data;;
				
			}
			}, function errorCallback(response){
				$scope.timeTableData=[]
		});
	}
	$scope.getClassScheduleList();
	$scope.getTeacherClass=function(){
		var formData={'schoolID':schoolID}
		$http.post(BASE_URL+'api/teachers/timetable/getTeacherClass',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
	$scope.getTeacherClass();
}
function examListCtrl($scope, $http, $route, $window) 
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
	$scope.status='';
	$scope.classArray=[];
	$scope.subjectArray=[];
	$scope.statusArray=[];
	$scope.getExamList=function(){
		var formData={'schoolID':schoolID,'classID':$scope.class_id,'subject_id':$scope.subject_id,'status':$scope.status}
		$http.post(BASE_URL+'api/teachers/exam/getExamList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.examData = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.examData.length; i++)
				{
					encrypted = $scope.encryptStr($scope.examData[i].id);
					$scope.examData[i]['examID'] = encrypted;
					$scope.classArray.push({
						'id':$scope.examData[i].class_id,
						'name':$scope.examData[i].classname
					});
					$scope.subjectArray.push({
						'id':$scope.examData[i].subject_id,
						'name':$scope.examData[i].subject
					});
					$scope.statusArray.push({
						'name':$scope.examData[i].exam_status
					});
				}
				
			}
			}, function errorCallback(response){
				$scope.examData=[]
		});
	}
	$scope.getExamList();
}
function allExamCtrl($scope, $http, $routeParams, $timeout,$window,$interval) 
{
	var sid;
	$scope.examID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.examID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.examID;
	};	
	$timeout($scope.setID(), 2000);
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
	$scope.exID='';
	$scope.getExamDetails = function()
	{
		$scope.examinfo=[];
		var formData = {'examID':$scope.examID,'schoolID':schoolID,'classID':''}
		$http.post(BASE_URL+'api/teachers/exam/getExamDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{  
				$scope.examinfo = response.data.data;
				if($scope.examinfo.id!=''){

					var encrypted = $scope.encryptStr($scope.examinfo.id);
					$scope.exID=encrypted;
				}
			}
			}, function errorCallback(response){
				$scope.examinfo=[];
		});
		
	}

	$scope.getExamDetails();
	
}
function submittedExamListCtrl($scope, $http, $route, $window) 
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
	$scope.getExamList=function(){
		var formData={'schoolID':schoolID,'classID':''}
		$http.post(BASE_URL+'api/teachers/exam/getSubmittedExamList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.examData = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.examData.length; i++)
				{
					encrypted = $scope.encryptStr($scope.examData[i].answerid);
					$scope.examData[i]['examID'] = encrypted;
				}
				
			}
			}, function errorCallback(response){
				$scope.examData=[]
		});
	}
	$scope.getExamList();
}
function allSubmittedExamCtrl($scope, $http, $routeParams, $timeout,$window,$interval) 
{
	var sid;
	$scope.examID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.examID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.examID;
	};	
	$timeout($scope.setID(), 2000);
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
	$scope.exID='';
	$scope.getExamDetails = function()
	{
		$scope.examinfo=[];
		var formData = {'examID':$scope.examID,'schoolID':schoolID,'classID':''}
		$http.post(BASE_URL+'api/teachers/exam/getSubmittedExamDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{  
				$scope.examinfo = response.data.data;
				if($scope.examinfo.id!=''){

					var encrypted = $scope.encryptStr($scope.examinfo.answerid);
					$scope.exID=encrypted;
				}
			}
			}, function errorCallback(response){
				$scope.examinfo=[];
		});
		
	}
	$scope.getExamDetails();
	$scope.isviewQuestion=false;
	$scope.viewQuestion=function(){
		$scope.isviewQuestion=true;	
	};
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
		var formData = {'schoolID':schoolID}
		$http.post(BASE_URL+'api/teachers/notification/getAllNotification',formData,{
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
		$http.post(BASE_URL+'api/teachers/notification/updateNotification',formData,{
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
			$http.post(BASE_URL+'api/teachers/notification/deleteNotification',formData,{
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
function teacherProjectCtrl($scope, $http, $route, $window) 
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
		var formData={'school_id':schoolID,'classID':'','filterbydate':'','class_id':$scope.class_id,'subject_id':$scope.subject_id,'category':$scope.category}
		$http.post(BASE_URL+'api/teachers/project/getProjectList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
			$http.post(BASE_URL+'api/teachers/project/deleteProject',formData,{
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
		$http.post(BASE_URL+'api/teachers/project/getProjectDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
function createProjectCtrl($scope, $http, $route, $window) 
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
		formData.append('school_id', schoolID);
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
		
		$http.post(BASE_URL+'api/teachers/project/createProject',formData,{
			transformRequest: angular.identity,
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
		$http.post(BASE_URL+'api/teachers/project/getTeacherSubjectClass',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
		$http.post(BASE_URL+'api/teachers/project/getTeacherSubject',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
function submitedProjectCtrl($scope, $http, $route, $window) 
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
		var formData={'schoolID':schoolID,'class_id':$scope.class_id,'subject_id':$scope.subject_id,'category':$scope.category}
		$http.post(BASE_URL+'api/teachers/project/getStudentSubmitedProjectList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
		$http.post(BASE_URL+'api/teachers/project/assignMarks',formData,{
			transformRequest: angular.identity,
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
		$http.post(BASE_URL+'api/teachers/project/updateProjectFeedback',formData,{
			transformRequest: angular.identity,
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
		$http.post(BASE_URL+'api/teachers/project/getSubmitedProjectDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
			$http.post(BASE_URL+'api/teachers/project/deleteAttachmentAttachData',formData,{
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
		$http.post(BASE_URL+'api/teachers/project/getProjectDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
		$http.post(BASE_URL+'api/teachers/project/getTeacherSubjectClass',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
		$http.post(BASE_URL+'api/teachers/assignment/getTeacherSubject',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
		formData.append('school_id', schoolID);
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
		
		$http.post(BASE_URL+'api/teachers/project/editProject',formData,{
			transformRequest: angular.identity,
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
		var formData = {'schoolID':schoolID}
		$http.post(BASE_URL+'api/teachers/setting/getNotificationSetting',formData,{
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
		$http.post(BASE_URL+'api/teachers/setting/updateNotificationSetting',formData,{
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
function resultCtrl($scope, $http, $route, $window) 
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
	$scope.getResultList=function(){
		var formData={'school_id':schoolID,'filterbydate':'','class_id':$scope.class_id}
		$http.post(BASE_URL+'api/teachers/result/getResultList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.resultData = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.resultData.length; i++)
				{
					encrypted = $scope.encryptStr($scope.resultData[i].student_id);
					$scope.resultData[i]['studentID'] = encrypted;
					$scope.classArray.push({
						'id':$scope.resultData[i].class_id,
						'name':$scope.resultData[i].classname
					});
				}
			}
			}, function errorCallback(response){
				$scope.resultData=[];
		});
	}
	$scope.getResultList();
	
}
function allResultCtrl($scope, $http, $routeParams, $timeout,$window) 
{
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
	// Calculate Term wise total marks
	$scope.calculateSubjectTermResult = function()
	{
		$scope.totalTermResult = [];
		var formData = {'school_id':schoolID,'student_id':$scope.studentID};
		$http.post(BASE_URL+'api/teachers/result/calculateSubjectTermResult',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
		var formData = {'school_id':schoolID,'student_id':$scope.studentID};
		$http.post(BASE_URL+'api/teachers/result/getSubjectGrandsResult',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
		var formData = {'school_id':schoolID,'student_id':$scope.studentID};
		$http.post(BASE_URL+'api/teachers/result/getStudentExamDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
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
}


function lessonnoteCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
    $scope.responsedata = "";
    $scope.termdates = "";
    $scope.allclass = "";
    $scope.allsubject = "";
    $scope.allteacher = "";
    
    $scope.term = "";
    $scope.activitytype = "";
    $scope.fromdate = "";
    $scope.todate = "";
    $scope.lessonsubject = "";
    $scope.topic = "";
    $scope.class_share = "";
    $scope.teacher_share = "";
    $scope.lessonclass = "";
	$scope.teacherlist = "";
	$scope.student_notes = "";
    $scope.objectives = "";
    $scope.material = "";
    $scope.introduction = "";
	$scope.document = "";
	
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
    
            
    
    
    $scope.getAllTermForSchool = function()
    {
		$scope.termList = false;
		var formData = {'id':schoolID};
		$http.post(BASE_URL+'api/teachers/lessonnote/getAllTermForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.termList = response.data.data;
                                var termlength = $scope.termList.length;
                               
                                $scope.newtermList = [];
                                var j = 0;
                                for(var i = termlength-1; i>=0; i--)
				{
                                 	if($scope.termList[i].status!='0'){
					$scope.newtermList[j] = $scope.termList[i];
                                        j++;
                                       }
				}
                                console.log($scope.newtermList);
				
			}
			
			}, function errorCallback(error){});
		
    }
        
        
    $scope.getsubject = function(classid)
    {
		$scope.subjectList = false;
		var formData = {'schoolID':schoolID,classID:classid};
		$http.post(BASE_URL+'api/teachers/lessonnote/getsubject',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.allsubject = response.data.data;
                               
			}
			
			}, function errorCallback(error){
				$scope.allsubject=[];
			});
		
    }
	
    $scope.getAllClass = function()
    {   
            var formData = {'schoolID': schoolID};
            $http.post(BASE_URL + 'api/teachers/lessonnote/getclass', formData, {
                headers: {
                    'Content-Type': undefined, 'x-api-key': xapikey, 'TOKEN': localStorage.getItem("TOKEN")
                }
            }).then(function (response) {

                if (response.status == 200)
                {
                    $scope.allclass = response.data.data;
                    $(".classrow").css("display", "none");
                    //setTimeout(function(){  $('.classrow').hide(); }, 3000);
                    console.log($scope.allclass);
                }

            }, function errorCallback(error) {});

    }  

    $scope.getAllTeacher = function()
    {   
            var formData = {'schoolID': schoolID};
            $http.post(BASE_URL + 'api/teachers/lessonnote/getteacher', formData, {
                headers: {
                    'Content-Type': undefined, 'x-api-key': xapikey, 'TOKEN': localStorage.getItem("TOKEN")
                }
            }).then(function (response) {

                if (response.status == 200)
                {

                    $scope.allteacher = response.data.data;
                    $(".teacherrow").css("display", "none");
                    //$scope.getAllClass();
                    //$('.teacherrow').hide();
                    console.log($scope.allteacher);
                }

            }, function errorCallback(error) {});

    }
      
    $scope.getdaterange = function(term)
    {   
            var formData = {'schoolID': schoolID,'term':term};
            $http.post(BASE_URL + 'api/teachers/lessonnote/gettermdates', formData, {
                headers: {
                    'Content-Type': undefined, 'x-api-key': xapikey, 'TOKEN': localStorage.getItem("TOKEN")
                }
            }).then(function (response) {

                if (response.status == 200)
                {
                    $scope.termdates = response.data.data;
                    console.log($scope.termdates);
                    $("#fromdate").prop('disabled', false);
                    $("#todate").prop('disabled', false);
                    $("#fromdate").val($scope.termdates.termstart);
                    $("#todate").val($scope.termdates.termstart);  
                    $('#fromdate').attr("min",$scope.termdates.termstart);
                    $('#fromdate').attr("max",$scope.termdates.termend); 
                    $('#todate').attr("min",$scope.termdates.termstart);
                    $('#todate').attr("max",$scope.termdates.termend); 

                }
                else {
                 $("#fromdate").prop('disabled', false);
                 $("#todate").prop('disabled', false);
                }

            }, function errorCallback(error) {});

     } 
    
    $("#fromdate").prop('disabled', true);
    $("#todate").prop('disabled', true); 

    $scope.getAllClass();
    $scope.getAllTeacher();
    
    
    $scope.getAllTermForSchool();

    //$('.classrow').hide();
    //$('.teacherrow').hide();

    $('#class_share').click(function() {
      if ($(this).is(':checked')) {
        $(".classrow").css("display", "block");  
        //$('.classrow').show();
      }
      else {
       $(".classrow").css("display", "none");   
       //$('.classrow').hide();   
      }
    });

    $('input:radio[name="teacher_share"]').change(function(){    
    if ($(this).is(':checked') && ($(this).val() == '1' || $(this).val() == '2')) {
    $(".teacherrow").css("display", "block");      
    //$('.teacherrow').show();
    }
    else {  
    $(".teacherrow").css("display", "none");     
    ///$('.teacherrow').hide();    
    }
    });
    
    
    $scope.convertDateNewFormat = function(str) {
    var date = new Date(str),
    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
    day = ("0" + date.getDate()).slice(-2);
    return [date.getFullYear(), mnth, day].join("-");
    }

    $('.classall').on('click',function(){
     $('.listclass').prop('checked',true);   
    });
    
    $('.teacherall').on('click',function(){
     $('.listteacher').prop('checked',true);     
    });
	$scope.is_disabled=false;
    $scope.addNote = function() 
    {
      var listclass = $('.listclass:checked').length;  
      var listteacher = $('.listteacher:checked').length; 
        
    if( $scope.term == '' ||  $scope.activitytype == '' || $('#fromdate').val() == '' || $('#todate').val() == '' &&  $scope.topic == '')
    {
        var Gritter = function () {
                $.gritter.add({
                        title: 'Failed',
                        text: `All * field is mendatory.`
                });
                return false;
        }();
 
    }
    else {
     
     if($scope.convertDateNewFormat($("#todate").val()) <= $scope.convertDateNewFormat($("#fromdate").val())){
       var Gritter = function () {
        $.gritter.add({
         title: 'Failed',
         text: `to date must be greater than from date`
        });
        return false;
        }(); 
     } 
     
     else if( $("#class_share").prop("checked") && (listclass == '' || listclass=='0')){
         var Gritter = function () {
                $.gritter.add({
                        title: 'Failed',
                        text: `Please Select Class From List...`
                });
                return false;
        }();   
        }
     
   
    else if(($scope.teacher_share == '1' || $scope.teacher_share == '2') && (listteacher == '' || listteacher=='0')){
      
         var Gritter = function () {
                $.gritter.add({
                        title: 'Failed',
                        text: `Please Select Teacher From List...`
                });
                return false;
        }();   
     }
     else 
     {
            var classarray = [];
            var teacherarray = [];
            
            $('[name="listclass"]:checked').each(function(i,e) {
            classarray.push(e.value);
            });
            
            $('[name="listteacher"]:checked').each(function(i,e) {
            teacherarray.push(e.value);
            });
           
            classarray = classarray.join(',');
            teacherarray = teacherarray.join(',');
            
        
         
        var formData = new FormData();
        formData.append('schoolID', schoolID);
        formData.append('term', $scope.term);
        formData.append('activitytype', $scope.activitytype);
        formData.append('fromdate', $scope.convertDateNewFormat($("#fromdate").val()));
        formData.append('todate', $scope.convertDateNewFormat($("#todate").val()));
        formData.append('lessonsubject', $scope.lessonsubject);
        formData.append('topic', $scope.topic);
        formData.append('class_share', $scope.class_share);
        formData.append('teacher_share', $scope.teacher_share);
        formData.append('lessonclass', $scope.lessonclass);
		formData.append('teacherlist', teacherarray);
		formData.append('student_notes', $scope.student_notes);
        formData.append('objectives', $scope.objectives);
        formData.append('material', $scope.material);
        formData.append('introduction', $scope.introduction);
        //var filedata = document.getElementById('document').files[0];
		formData.append('document','');
		$scope.is_disabled=true;
        if($scope.previewImages.length > 0)
		{
			for(var i = 0; i < $scope.previewImages.length; i++)
			{ 
				formData.append('files[]', $scope.previewImages[i]);
			}
		}
        $http.post(BASE_URL + 'api/teachers/lessonnote/addnote', formData, {
        headers: {
        'Content-Type': undefined, 'x-api-key': xapikey, 'TOKEN': localStorage.getItem("TOKEN")
        }
        }).then(function (response) {

        if (response.status == 200)
        {
            var Gritter = function () {
            $.gritter.add({
            title: 'Success',
            text: response.data.message
            });
            }();
            $window.location.href = '#!/lesson-note-list';
        }
     }, 
     function errorCallback(error) {
     
        var Gritter = function () {
        $.gritter.add({
        title: 'Error',
        text: error.data.message
        });
        }();
        $scope.is_disabled=false; 
     });
        
    }
    }
   }
}

function lessonnotelistCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
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
            var formData = {'schoolID': schoolID};
            $http.post(BASE_URL + 'api/teachers/lessonnote/lessonnotelist', formData, {
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
    
}

function editlessonnoteCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
    $scope.responsedata = "";
    $scope.termdates = "";
    $scope.allclass = "";
    $scope.allsubject = "";
	$scope.allteacher = "";
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
	$scope.removeEdit=function(data,index){
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':data.id,'filename':data.attachment};
			$http.post(BASE_URL+'api/teachers/lessonnote/deleteFileLessonData',formData,{
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
							text: result.message
						});
						if (index > -1) {
							$scope.notesdata.attachmentData.splice(index, 1);;
						return false;
						}
					}();
				}
				
				}, function errorCallback(response){
				
			});
		} 
	}
    
//    $scope.term = "";
//    $scope.activitytype = "";
//    $scope.fromdate = "";
//    $scope.todate = "";
//    $scope.lessonsubject = "";
//    $scope.topic = "";
//    $scope.class_share = "";
//    $scope.teacher_share = "";
//    $scope.lessonclass = "";
//    $scope.teacherlist = "";
//    $scope.objectives = "";
//    $scope.material = "";
//    $scope.introduction = "";
//    $scope.document = "";
            
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
        var formData = {'schoolID':schoolID,'noteid':$scope.noteid};
        $http.post(BASE_URL+'api/teachers/lessonnote/getnotesdata',formData,{
        headers:{
                'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
        }
        }).then(function(response) {

        if(response.status == 200)
        {
        $scope.notesdata = response.data.data;	
        $scope.term = $scope.notesdata.term;
        $scope.activitytype = $scope.notesdata.activity_type;
        //$scope.fromdate = $scope.notesdata.fromdate;
        ///$scope.todate = $scope.notesdata.todate;
        $scope.lessonsubject = $scope.notesdata.subject;
        $scope.topic = $scope.notesdata.topic;
        $scope.class_share = $scope.notesdata.sharewithclass;
		$scope.teacher_share = $scope.notesdata.sharewithteacher;
		$scope.edit_right = $scope.notesdata.edit_right;
		$scope.lessonclass = $scope.notesdata.classlist;
		$scope.getsubject($scope.notesdata.classlist);
        $scope.teacherlist = $scope.notesdata.teacherlist;
		$scope.student_notes = $scope.notesdata.student_notes;
		$scope.objectives = $scope.notesdata.objectives;
        $scope.material = $scope.notesdata.material;
        $scope.introduction = $scope.notesdata.concept;
        
        $scope.termend = $scope.notesdata.termend;
        $scope.termstart = $scope.notesdata.termstart;
        
        
        console.log($scope.teacherlist);
        console.log($scope.lessonclass);
        
         $scope.getAllClass();
         $scope.getAllTeacher();
        
        $("#fromdate").prop('disabled', false);
        $("#todate").prop('disabled', false);
        $("#fromdate").val($scope.notesdata.fromdate);
        $("#todate").val($scope.notesdata.todate);  
        $('#fromdate').attr("min",$scope.termstart);
        $('#fromdate').attr("max",$scope.termend); 
        $('#todate').attr("min",$scope.termstart);
        $('#todate').attr("max",$scope.termend); 
        
         /*if($scope.class_share=='1'){
         $(".classrow").css("display", "block"); 
         }*/
         
         
         if($scope.teacher_share=='1' || $scope.teacher_share=='2'){
         $(".teacherrow").css("display", "block"); 
         }
         
        //console.log("getNotesData"); 
        //console.log($scope.notesdata);
        }

        }, function errorCallback(error){});
		
    }
    
    $scope.getAllTermForSchool = function()
    {
		$scope.termList = false;
		var formData = {'id':schoolID};
		$http.post(BASE_URL+'api/teachers/lessonnote/getAllTermForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.termList = response.data.data;
                                var termlength = $scope.termList.length;
                               
                                $scope.newtermList = [];
                                var j = 0;
                                for(var i = termlength-1; i>=0; i--)
				{
                                 	if($scope.termList[i].status!='0'){
					$scope.newtermList[j] = $scope.termList[i];
                                        j++;
                                       }
				}
                                console.log($scope.newtermList);
				
			}
			
			}, function errorCallback(error){});
		
    }
        
        
    $scope.getsubject = function(classid)
    {
		$scope.subjectList = false;
		var formData = {'schoolID':schoolID,classID:classid};
		$http.post(BASE_URL+'api/teachers/lessonnote/getsubject',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.allsubject = response.data.data;
                               
			}
			
			}, function errorCallback(error){
				$scope.allsubject=[];
			});
		
    }
	
    $scope.getAllClass = function()
    {   
            var formData = {'schoolID': schoolID};
            $http.post(BASE_URL + 'api/teachers/lessonnote/getclass', formData, {
                headers: {
                    'Content-Type': undefined, 'x-api-key': xapikey, 'TOKEN': localStorage.getItem("TOKEN")
                }
            }).then(function (response) {

                if (response.status == 200)
                {
                    $scope.allclass = response.data.data;
                    ///$(".classrow").css("display", "none");
                    //setTimeout(function(){  $('.classrow').hide(); }, 3000);
                    console.log($scope.allclass);
                }

            }, function errorCallback(error) {});

    }  

    $scope.getAllTeacher = function()
    {   
            var formData = {'schoolID': schoolID};
            $http.post(BASE_URL + 'api/teachers/lessonnote/getteacher', formData, {
                headers: {
                    'Content-Type': undefined, 'x-api-key': xapikey, 'TOKEN': localStorage.getItem("TOKEN")
                }
            }).then(function (response) {

                if (response.status == 200)
                {

                    $scope.allteacher = response.data.data;
                    //$(".teacherrow").css("display", "none");
                    //$scope.getAllClass();
                    //$('.teacherrow').hide();
                    console.log($scope.allteacher);
                }

            }, function errorCallback(error) {});

    }
      
    $scope.getdaterange = function(term)
    {   
            var formData = {'schoolID': schoolID,'term':term};
            $http.post(BASE_URL + 'api/teachers/lessonnote/gettermdates', formData, {
                headers: {
                    'Content-Type': undefined, 'x-api-key': xapikey, 'TOKEN': localStorage.getItem("TOKEN")
                }
            }).then(function (response) {

                if (response.status == 200)
                {
                    $scope.termdates = response.data.data;
                    console.log($scope.termdates);
                    $("#fromdate").prop('disabled', false);
                    $("#todate").prop('disabled', false);
                    $("#fromdate").val($scope.termdates.termstart);
                    $("#todate").val($scope.termdates.termstart);  
                    $('#fromdate').attr("min",$scope.termdates.termstart);
                    $('#fromdate').attr("max",$scope.termdates.termend); 
                    $('#todate').attr("min",$scope.termdates.termstart);
                    $('#todate').attr("max",$scope.termdates.termend); 

                }
                else {
                 $("#fromdate").prop('disabled', false);
                 $("#todate").prop('disabled', false);
                }

            }, function errorCallback(error) {});

     } 
    
    //$("#fromdate").prop('disabled', true);
    //$("#todate").prop('disabled', true); 

    $scope.getNotesData();
    $scope.getAllTermForSchool();
    $scope.getsubject();
    
    
    

    
    
  
    //$('.classrow').hide();
    //$('.teacherrow').hide();

    $('#class_share').click(function() {
      if ($(this).is(':checked')) {
        $(".classrow").css("display", "block");  
        //$('.classrow').show();
      }
      else {
       $(".classrow").css("display", "none");   
       //$('.classrow').hide();   
      }
    });

    $('input:radio[name="teacher_share"]').change(function(){    
    if ($(this).is(':checked') && ($(this).val() == '1' || $(this).val() == '2')) {
    $(".teacherrow").css("display", "block");      
    //$('.teacherrow').show();
    }
    else {  
    $(".teacherrow").css("display", "none");     
    ///$('.teacherrow').hide();    
    }
    });
    
    
    $scope.convertDateNewFormat = function(str) {
    var date = new Date(str),
    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
    day = ("0" + date.getDate()).slice(-2);
    return [date.getFullYear(), mnth, day].join("-");
    }
    
    
    $('.classall').on('click',function(){
		if($('.listclass').prop('checked') == true){
			$('.listclass').prop('checked',false);  
		}else{
			$('.listclass').prop('checked',true);
		} 
    });
    
    $('.teacherall').on('click',function(){
		if($('.listteacher').prop('checked') == true){
			$('.listteacher').prop('checked',false);  
		}else{
			$('.listteacher').prop('checked',true);
		}   
    });
	$scope.is_disabled=false;
    $scope.updateNote = function() 
    {
    
    var listclass = $('.listclass:checked').length;  
    var listteacher = $('.listteacher:checked').length;     
        
    if( $scope.term == '' ||  $scope.activitytype == '' || $('#fromdate').val() == '' || $('#todate').val() == '' ||  $scope.topic == '')
    {
        var Gritter = function () {
                $.gritter.add({
                        title: 'Failed',
                        text: `All * field is mendatory.`
                });
                return false;
        }();
 
    }
    else {
     
     if($scope.convertDateNewFormat($("#todate").val()) <= $scope.convertDateNewFormat($("#fromdate").val())){
       var Gritter = function () {
        $.gritter.add({
         title: 'Failed',
         text: `to date must be greater than from date`
        });
        return false;
        }(); 
     } 
     
     else if( $("#class_share").prop("checked") && $scope.lessonclass == '' && (listclass == '' || listclass=='0' )){
         var Gritter = function () {
                $.gritter.add({
                        title: 'Failed',
                        text: `Please Select Class From List...`
                });
                return false;
        }();   
        }
     
   
    else if(($scope.teacher_share == '1' || $scope.teacher_share == '2') && (listteacher == '' || listteacher=='0' )){
      
         var Gritter = function () {
                $.gritter.add({
                        title: 'Failed',
                        text: `Please Select Teacher From List...`
                });
                return false;
        }();   
     }
     else 
     {
            var classarray = [];
            var teacherarray = [];
            
            $('[name="listclass"]:checked').each(function(i,e) {
            classarray.push(e.value);
            });
            
            $('[name="listteacher"]:checked').each(function(i,e) {
            teacherarray.push(e.value);
            });
           
            classarray = classarray.join(',');
            teacherarray = teacherarray.join(','); 
         
         
        var formData = new FormData();
        formData.append('noteid', $scope.noteid);
        formData.append('schoolID', schoolID);
        formData.append('term', $scope.term);
        formData.append('activitytype', $scope.activitytype);
        formData.append('fromdate', $scope.convertDateNewFormat($("#fromdate").val()));
        formData.append('todate', $scope.convertDateNewFormat($("#todate").val()));
        formData.append('lessonsubject', $scope.lessonsubject);
        formData.append('topic', $scope.topic);
        formData.append('class_share', $scope.class_share);
        formData.append('teacher_share', $scope.teacher_share);
        formData.append('lessonclass', $scope.lessonclass);
		formData.append('teacherlist', teacherarray);
		formData.append('student_notes', $scope.student_notes);
        formData.append('objectives', $scope.objectives);
        formData.append('material', $scope.material);
        formData.append('introduction', $scope.introduction);
        //var filedata = document.getElementById('document').files[0];
		formData.append('document','');
		if($scope.previewImages.length > 0)
		{
			for(var i = 0; i < $scope.previewImages.length; i++)
			{ 
				formData.append('files[]', $scope.previewImages[i]);
			}
		}
        $scope.is_disabled=true;
        $http.post(BASE_URL + 'api/teachers/lessonnote/updatenote', formData, {
        headers: {
        'Content-Type': undefined, 'x-api-key': xapikey, 'TOKEN': localStorage.getItem("TOKEN")
        }
        }).then(function (response) {

        if (response.status == 200)
        {
            var Gritter = function () {
            $.gritter.add({
            title: 'Success',
            text: response.data.message
            });
            }();
          $window.location.href = '#!/lesson-note-list';
        }
     }, 
     function errorCallback(error) {
     
        var Gritter = function () {
        $.gritter.add({
        title: 'Error',
        text: error.data.message
        });
        }();
		$scope.is_disabled=false;
     });
        
    }
    }
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
        var formData = {'schoolID':schoolID,'noteid':$scope.noteid};
        $http.post(BASE_URL+'api/teachers/lessonnote/viewdetailsharednote',formData,{
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
		//$scope.attachment = $scope.notesdata.attachment;
		$scope.commentData=$scope.notesdata.commentData;
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
        }

        }, function errorCallback(error){});
		
    }
   $scope.getNotesData(); 
   	$scope.comment='';
	$scope.addComment=function(){
		if($scope.comment==''){
			return false;
		}
		var formData = {'noteid':$scope.noteid,'schoolID':schoolID,'comment':$scope.comment}
		$http.post(BASE_URL+'api/teachers/lessonnote/addLessonComment',formData,{
			headers:{
				'Content-Type':'application/json',
				'x-api-key':xapikey
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
			$http.post(BASE_URL+'api/teachers/lessonnote/deleteComment',formData,{
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
function sharedlessonCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
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
  $scope.sharedlessonlist = function()
    {   
            var formData = {'schoolID': schoolID};
            $http.post(BASE_URL + 'api/teachers/lessonnote/sharedlessonlist', formData, {
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
    
  $scope.sharedlessonlist();    
    
}


function viewsharednoteCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
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
        var formData = {'schoolID':schoolID,'noteid':$scope.noteid};
        $http.post(BASE_URL+'api/teachers/lessonnote/viewdetailsharednote',formData,{
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
		//$scope.attachment = $scope.notesdata.attachment;
		$scope.commentData=$scope.notesdata.commentData;
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
        }

        }, function errorCallback(error){});
		
    }
   $scope.getNotesData(); 
   	$scope.comment='';
	$scope.addComment=function(){
		if($scope.comment==''){
			return false;
		}
		var formData = {'noteid':$scope.noteid,'schoolID':schoolID,'comment':$scope.comment}
		$http.post(BASE_URL+'api/teachers/lessonnote/addLessonComment',formData,{
			headers:{
				'Content-Type':'application/json',
				'x-api-key':xapikey
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
			$http.post(BASE_URL+'api/teachers/lessonnote/deleteComment',formData,{
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


function editsharedlessonCtrl($scope, $http, $routeParams, $timeout, $compile, $window) 
{
 $scope.responsedata = "";
    $scope.termdates = "";
    $scope.allclass = "";
    $scope.allsubject = "";
	$scope.allteacher = "";
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
    $scope.removeEdit=function(data,index){
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':data.id,'filename':data.attachment};
			$http.post(BASE_URL+'api/teachers/lessonnote/deleteFileLessonData',formData,{
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
							text: result.message
						});
						if (index > -1) {
							$scope.notesdata.attachmentData.splice(index, 1);;
							return false;
						}
					}();
				}
				
				}, function errorCallback(response){
				
			});
		} 
	}
//    $scope.term = "";
//    $scope.activitytype = "";
//    $scope.fromdate = "";
//    $scope.todate = "";
//    $scope.lessonsubject = "";
//    $scope.topic = "";
//    $scope.class_share = "";
//    $scope.teacher_share = "";
//    $scope.lessonclass = "";
//    $scope.teacherlist = "";
//    $scope.objectives = "";
//    $scope.material = "";
//    $scope.introduction = "";
//    $scope.document = "";
            
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
        var formData = {'schoolID':schoolID,'noteid':$scope.noteid};
        $http.post(BASE_URL+'api/teachers/lessonnote/getnotesdata',formData,{
        headers:{
                'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
        }
        }).then(function(response) {

        if(response.status == 200)
        {
        $scope.notesdata = response.data.data;	
        $scope.term = $scope.notesdata.term;
        $scope.activitytype = $scope.notesdata.activity_type;
        //$scope.fromdate = $scope.notesdata.fromdate;
        ///$scope.todate = $scope.notesdata.todate;
        $scope.lessonsubject = $scope.notesdata.subject;
        $scope.topic = $scope.notesdata.topic;
        $scope.class_share = $scope.notesdata.sharewithclass;
        $scope.teacher_share = $scope.notesdata.sharewithteacher;
		$scope.lessonclass = $scope.notesdata.classlist;
		$scope.getsubject($scope.lessonclass);
        $scope.teacherlist = $scope.notesdata.teacherlist;
		$scope.student_notes = $scope.notesdata.student_notes;
		$scope.objectives = $scope.notesdata.objectives;
        $scope.material = $scope.notesdata.material;
        $scope.introduction = $scope.notesdata.concept;
        
        $scope.termend = $scope.notesdata.termend;
        $scope.termstart = $scope.notesdata.termstart;
        
        
        $("#fromdate").prop('disabled', false);
        $("#todate").prop('disabled', false);
        $("#fromdate").val($scope.notesdata.fromdate);
        $("#todate").val($scope.notesdata.todate);  
        $('#fromdate').attr("min",$scope.termstart);
        $('#fromdate').attr("max",$scope.termend); 
        $('#todate').attr("min",$scope.termstart);
        $('#todate').attr("max",$scope.termend); 
        
//         if($scope.class_share=='1'){
//         $(".classrow").css("display", "block"); 
//         }
//         
//         
//         if($scope.teacher_share=='1' || $scope.teacher_share=='2'){
//         $(".teacherrow").css("display", "block"); 
//         }
         
        //console.log("getNotesData"); 
        //console.log($scope.notesdata);
        }

        }, function errorCallback(error){});
		
    }
    
    $scope.getAllTermForSchool = function()
    {
		$scope.termList = false;
		var formData = {'id':schoolID};
		$http.post(BASE_URL+'api/teachers/lessonnote/getAllTermForSchool',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.termList = response.data.data;
                                var termlength = $scope.termList.length;
                               
                                $scope.newtermList = [];
                                var j = 0;
                                for(var i = termlength-1; i>=0; i--)
				{
                                 	if($scope.termList[i].status!='0'){
					$scope.newtermList[j] = $scope.termList[i];
                                        j++;
                                       }
				}
                                console.log($scope.newtermList);
				
			}
			
			}, function errorCallback(error){});
		
    }
        
        
    $scope.getsubject = function(classID)
    {
		$scope.subjectList = false;
		var formData = {'schoolID':schoolID,'classID':classID,'isShared':1};
		$http.post(BASE_URL+'api/teachers/lessonnote/getsubject',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey,'TOKEN':localStorage.getItem("TOKEN")
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.allsubject = response.data.data;
                               
			}
			
			}, function errorCallback(error){});
		
    }
	
    $scope.getAllClass = function()
    {   
            var formData = {'schoolID': schoolID,'isShared':1};
            $http.post(BASE_URL + 'api/teachers/lessonnote/getclass', formData, {
                headers: {
                    'Content-Type': undefined, 'x-api-key': xapikey, 'TOKEN': localStorage.getItem("TOKEN")
                }
            }).then(function (response) {

                if (response.status == 200)
                {
                    $scope.allclass = response.data.data;
                    ///$(".classrow").css("display", "none");
                    //setTimeout(function(){  $('.classrow').hide(); }, 3000);
                    console.log($scope.allclass);
                }

            }, function errorCallback(error) {});

    }  

    $scope.getAllTeacher = function()
    {   
            var formData = {'schoolID': schoolID};
            $http.post(BASE_URL + 'api/teachers/lessonnote/getteacher', formData, {
                headers: {
                    'Content-Type': undefined, 'x-api-key': xapikey, 'TOKEN': localStorage.getItem("TOKEN")
                }
            }).then(function (response) {

                if (response.status == 200)
                {

                    $scope.allteacher = response.data.data;
                    //$(".teacherrow").css("display", "none");
                    //$scope.getAllClass();
                    //$('.teacherrow').hide();
                    console.log($scope.allteacher);
                }

            }, function errorCallback(error) {});

    }
      
    $scope.getdaterange = function(term)
    {   
            var formData = {'schoolID': schoolID,'term':term};
            $http.post(BASE_URL + 'api/teachers/lessonnote/gettermdates', formData, {
                headers: {
                    'Content-Type': undefined, 'x-api-key': xapikey, 'TOKEN': localStorage.getItem("TOKEN")
                }
            }).then(function (response) {

                if (response.status == 200)
                {
                    $scope.termdates = response.data.data;
                    console.log($scope.termdates);
                    $("#fromdate").prop('disabled', false);
                    $("#todate").prop('disabled', false);
                    $("#fromdate").val($scope.termdates.termstart);
                    $("#todate").val($scope.termdates.termstart);  
                    $('#fromdate').attr("min",$scope.termdates.termstart);
                    $('#fromdate').attr("max",$scope.termdates.termend); 
                    $('#todate').attr("min",$scope.termdates.termstart);
                    $('#todate').attr("max",$scope.termdates.termend); 

                }
                else {
                 $("#fromdate").prop('disabled', false);
                 $("#todate").prop('disabled', false);
                }

            }, function errorCallback(error) {});

     } 
    
    //$("#fromdate").prop('disabled', true);
    //$("#todate").prop('disabled', true); 

   
    $scope.getAllClass();
    $scope.getAllTeacher();
    $scope.getAllTermForSchool();
    //$scope.getsubject();
    $scope.getNotesData();
  
    //$('.classrow').hide();
    //$('.teacherrow').hide();

//    $('#class_share').click(function() {
//      if ($(this).is(':checked')) {
//        $(".classrow").css("display", "block");  
//        //$('.classrow').show();
//      }
//      else {
//       $(".classrow").css("display", "none");   
//       //$('.classrow').hide();   
//      }
//    });
//
//    $('input:radio[name="teacher_share"]').change(function(){    
//    if ($(this).is(':checked') && ($(this).val() == '1' || $(this).val() == '2')) {
//    $(".teacherrow").css("display", "block");      
//    //$('.teacherrow').show();
//    }
//    else {  
//    $(".teacherrow").css("display", "none");     
//    ///$('.teacherrow').hide();    
//    }
//    });
    
    
    $scope.convertDateNewFormat = function(str) {
    var date = new Date(str),
    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
    day = ("0" + date.getDate()).slice(-2);
    return [date.getFullYear(), mnth, day].join("-");
    }

    $scope.updateNote = function() 
    {
    if( $scope.term == '' ||  $scope.activitytype == '' || $scope.fromdate == '' || $scope.todate == '' || $scope.topic == '')
    {
        var Gritter = function () {
                $.gritter.add({
                        title: 'Failed',
                        text: `All * field is mendatory.`
                });
                return false;
        }();
 
    }
    else {
     
     if($scope.convertDateNewFormat($("#todate").val()) <= $scope.convertDateNewFormat($("#fromdate").val())){
       var Gritter = function () {
        $.gritter.add({
         title: 'Failed',
         text: `to date must be greater than from date`
        });
        return false;
        }(); 
     } 
     
//     else if( $("#class_share").prop("checked") && $scope.lessonclass == ''){
//         var Gritter = function () {
//                $.gritter.add({
//                        title: 'Failed',
//                        text: `Please Select Class From List...`
//                });
//                return false;
//        }();   
//        }
//     
//   
//    else if(($scope.teacher_share == '1' || $scope.teacher_share == '2') && ($scope.teacherlist == '')){
//      
//         var Gritter = function () {
//                $.gritter.add({
//                        title: 'Failed',
//                        text: `Please Select Teacher From List...`
//                });
//                return false;
//        }();   
//     }
     else 
     {
        var formData = new FormData();
        formData.append('noteid', $scope.noteid);
        formData.append('schoolID', schoolID);
        formData.append('term', $scope.term);
        formData.append('activitytype', $scope.activitytype);
        formData.append('fromdate', $scope.convertDateNewFormat($("#fromdate").val()));
        formData.append('todate', $scope.convertDateNewFormat($("#todate").val()));
        formData.append('lessonsubject', $scope.lessonsubject);
        formData.append('topic', $scope.topic);
        formData.append('class_share', $scope.class_share);
        formData.append('teacher_share', $scope.teacher_share);
        formData.append('lessonclass', $scope.lessonclass);
        formData.append('teacherlist', $scope.teacherlist);
		formData.append('objectives', $scope.objectives);
		formData.append('student_notes', $scope.student_notes);
        formData.append('material', $scope.material);
        formData.append('introduction', $scope.introduction);
        //var filedata = document.getElementById('document').files[0];
        //formData.append('document',filedata);
        if($scope.previewImages.length > 0)
		{
			for(var i = 0; i < $scope.previewImages.length; i++)
			{ 
				formData.append('files[]', $scope.previewImages[i]);
			}
		}
        $scope.is_disabled=true;
        $http.post(BASE_URL + 'api/teachers/lessonnote/updatesharednote', formData, {
        headers: {
        'Content-Type': undefined, 'x-api-key': xapikey, 'TOKEN': localStorage.getItem("TOKEN")
        }
        }).then(function (response) {

        if (response.status == 200)
        {
            var Gritter = function () {
            $.gritter.add({
            title: 'Success',
            text: response.data.message
            });
            }();
          $window.location.href = '#!/shared-lesson-list';
        }
     }, 
     function errorCallback(error) {
     
        var Gritter = function () {
        $.gritter.add({
        title: 'Error',
        text: error.data.message
        });
        }();
         
     });
        
    }
    }
   }    
    
}