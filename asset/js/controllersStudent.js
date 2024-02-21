'use strict';
//Controllers
function HomeCtrl($scope, $http,$window) 
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
	$scope.getSubjectList=function(){
		var formData={'schoolID':schoolID,'classID':classID}
		$http.post(BASE_URL+'api/student/dashboard/getSubjectList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.subjectData = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.subjectData.length; i++)
				{
					encrypted = $scope.encryptStr($scope.subjectData[i].id);
					$scope.subjectData[i]['subjectID'] = encrypted;
				}
				
			}
			}, function errorCallback(response){
				$scope.subjectData=[];
		});
	}
	$scope.getSubjectList();
	$scope.getAllToDoDataList=function(){
		var formData={'schoolID':schoolID,'classID':classID}
		$http.post(BASE_URL+'api/student/dashboard/getAllToDoDataList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.toDoData = response.data.data;
				$scope.removeData = response.data.removeData;
				var encrypted ;
				for(var i = 0; i < $scope.toDoData.length; i++)
				{
					encrypted = $scope.encryptStr($scope.toDoData[i].id);
					$scope.toDoData[i]['ID'] = encrypted;
				}
				$scope.currDate = new Date();
			}
			}, function errorCallback(response){
				$scope.toDoData=[];
		});
	}
	$scope.getAllToDoDataList();
	$scope.showToDoRemoveData=function(){
		var formData = {'id':''};
		$http.post(BASE_URL+'api/student/dashboard/showToDoRemoveData',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.getAllToDoDataList();
			}
			
			}, function errorCallback(response){
			
		});
	}
	$scope.deleteToDo = function(data,index)
	{
		
			var formData = {'id':data.id,'type':data.type};
			$http.post(BASE_URL+'api/student/dashboard/deleteToDo',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey
				}
				}).then(function(response) {
				
				if(response.status == 200)
				{
					var result  = response.data;
					/*var Gritter = function () {
						$.gritter.add({
							title: 'Successfull',
							text: result.message
						});
					}();*/
					$scope.getAllToDoDataList();
					//$scope.toDoData.splice(index, 1);
				}
				
				}, function errorCallback(response){
				
			});
		
	}
}
function studentProfileCtrl($scope, $http, $route, $window) 
{
	$scope.removeProfilePic = function(studentData)
	{
		var formData = {'pic':studentData.childphoto}
		$http.post(BASE_URL+'api/student/profile/removeProfilePic',formData,{
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
				studentData.childphoto='';
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
        $http.post(BASE_URL+'api/student/profile/profileImage', fd, {
            transformRequest: angular.identity,
            headers:{
                'Content-Type':undefined, 'x-api-key':xapikey,
            }
        }).then(function(response) {
			$scope.studentData.childphoto = response.data.file_name; 
			var newSrc = BASE_URL+'img/child/'+$scope.studentData.childphoto;
			$('.user-profile img').attr('src', newSrc);
			$('.user-settings img').attr('src', newSrc);           
                        
        }, function errorCallback(response){
                            
        });
    }
	$scope.editHobieObj={'id':'','student_id':'','hobie_name':''};
	$scope.editHobieButton=function(data){
		$scope.editHobieObj.id=data.id;
		$scope.editHobieObj.student_id=data.student_id;
		$scope.editHobieObj.hobie_name=data.hobie_name;
	}
	$scope.updateHobie=function(hobieData){
		$scope.id=hobieData.id;
		$scope.hobie_name=hobieData.hobie_name;
		var formData={'id':$scope.id,'hobie_name':$scope.hobie_name}
		$http.post(BASE_URL+'api/student/profile/updateStudentHobie',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.editHobieObj={'id':'','student_id':'','hobie_name':''};
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
	$scope.editQuoteObj={'id':'','student_id':'','quote_name':''};
	$scope.editQuoteButton=function(data){
		$scope.editQuoteObj.id=data.id;
		$scope.editQuoteObj.student_id=data.student_id;
		$scope.editQuoteObj.quote_name=data.quote_name;
	}
	$scope.updateQuote=function(quoteData){
		$scope.id=quoteData.id;
		$scope.quote_name=quoteData.quote_name;
		var formData={'id':$scope.id,'quote_name':$scope.quote_name}
		$http.post(BASE_URL+'api/student/profile/updateStudentQuote',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.editQuoteObj={'id':'','student_id':'','quote_name':''};
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
	$scope.quoteDelete = function(quoteID,index)
	{
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':quoteID};
			$http.post(BASE_URL+'api/student/profile/quoteDelete',formData,{
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
							text: 'Quote deleted successfully.'
						});
						$scope.studentQuoteData.splice(index, 1);
						return false;
					}();
				}
				
				}, function errorCallback(response){
				
			});
		}
	}
	$scope.quotes='';
	$scope.addQuotes=function(quote){
		if(quote==''){
			return false;
		}
		var formData={'quote':quote}
		$http.post(BASE_URL+'api/student/profile/addStudentQuote',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.quotes='';
				$scope.getStudentQuoteList();
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
	$scope.getStudentQuoteList=function(){
		var formData={'quote':''}
		$http.post(BASE_URL+'api/student/profile/getStudentQuoteList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.studentQuoteData = response.data.data;
			}
			
			}, function errorCallback(response){
			
		});
	}
	$scope.getStudentQuoteList();

	$scope.hobieDelete = function(hobieID,index)
	{
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':hobieID};
			$http.post(BASE_URL+'api/student/profile/hobieDelete',formData,{
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
							text: 'Hobie deleted successfully.'
						});
						$scope.studentHobieData.splice(index, 1);
						return false;
					}();
				}
				
				}, function errorCallback(response){
				
			});
		}
	}
	$scope.hobies='';
	$scope.addHobies=function(hobie){
		//alert(hobie);
		if(hobie==''){
			return false;
		}
		var formData={'hobie':hobie}
		$http.post(BASE_URL+'api/student/profile/addStudentHobie',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.hobies='';
				$scope.getStudentHobieList();
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
	$scope.getStudentHobieList=function(){
		var formData={'hobie':''}
		$http.post(BASE_URL+'api/student/profile/getStudentHobieList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.studentHobieData = response.data.data;
			}
			
			}, function errorCallback(response){
			
		});
	}
	$scope.getStudentHobieList();

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
		$http.post(BASE_URL+'api/student/profile/changePasswordStudent',formData,{
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
		$http.post(BASE_URL+'api/student/profile/getStudentDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.studentData = response.data.data;
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getDetails();
	
} 

function studentAssignmentCtrl($scope, $http, $route, $window) 
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
	$scope.subject_id='';
	$scope.category='';
	$scope.subjectArray=[];
	$scope.categoryArray=[];
	$scope.getStudentAssignmentList=function(){
		var formData={'classID':classID,'filterbydate':$scope.datefilter,'subject_id':$scope.subject_id,'category':$scope.category}
		$http.post(BASE_URL+'api/student/assignment/getStudentAssignmentList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.studentAssignmentData = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.studentAssignmentData.length; i++)
				{
					encrypted = $scope.encryptStr($scope.studentAssignmentData[i].id);
					$scope.studentAssignmentData[i]['assignmentID'] = encrypted;
					$scope.studentAssignmentData[i]['currDate'] = new Date();
					$scope.subjectArray.push({
						'id':$scope.studentAssignmentData[i].subject_id,
						'name':$scope.studentAssignmentData[i].subject
					});
					$scope.categoryArray.push({
						'name':$scope.studentAssignmentData[i].category
					});
				}
			}
			}, function errorCallback(response){
				$scope.studentAssignmentData=[];
		});
	}
	$scope.getStudentAssignmentList();
} 
function allAssignmentCtrl($scope, $http, $routeParams, $timeout,$window) 
{
	
	$scope.attemptCount=function(id,attempt,userAttemptCount){
		if(parseInt(attempt)<=parseInt(userAttemptCount)){
			var Gritter = function () {
				$.gritter.add({
					title: 'Error',
					text: 'You have exceed submission limit.'
				});
			}();
			return false;
		}
		$window.location.href = '#!/submit-assignment/'+id;
		return false;
	}
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
	$scope.showAtachment=0;
	$scope.viewAttachment=function(val){
		if($scope.showAtachment==0){
			$scope.showAtachment=1;
		}else if($scope.showAtachment==1){
			$scope.showAtachment=0;
		}
	}
	var sid;
	$scope.assignmentID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.assignmentID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.assignmentID;
	};	
	$timeout($scope.setID(), 2000);
	//alert($scope.assignmentID); return false;
	$scope.assignmentinfo = false;
	$scope.getAssignmentDetails = function()
	{
		var formData = {'id':$scope.assignmentID}
		$http.post(BASE_URL+'api/student/assignment/getAssignmentDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{   
				var encrypted;
				$scope.assignmentinfo = response.data.data;

				if($scope.assignmentinfo.isAssignmentOpen==0){
					var Gritter = function () {
						$.gritter.add({
							title: 'Error',
							text: 'Assignment Locked'
						});
					}();
					$window.location.href = '#!/assignment-list/';
					return false;
				}
				
				
				encrypted = $scope.encryptStr($scope.assignmentinfo.id);
				$scope.viewassignmentID = encrypted;
				$scope.assignmentname=$scope.assignmentinfo.title;
				$scope.category=$scope.assignmentinfo.category;
				$scope.totalmarks=$scope.assignmentinfo.total_marks;
				$scope.no_of_attempt=$scope.assignmentinfo.no_of_attempt;
				$scope.userAttemptCount=$scope.assignmentinfo.userAttemptCount;
				$scope.class=$scope.assignmentinfo.classname;
				$scope.teacher=$scope.assignmentinfo.teachername;
				$scope.submissiondate=$scope.assignmentinfo.submission_date;
				$scope.description=$scope.assignmentinfo.description;
				$scope.subject=$scope.assignmentinfo.subject;
				$scope.dateofissue=$scope.assignmentinfo.created;
				$scope.latedays=$scope.assignmentinfo.latedays;
				$scope.leftdays=$scope.assignmentinfo.leftdays;
				$scope.attachment=$scope.assignmentinfo.attachment;
				$scope.attachment_type=$scope.assignmentinfo.attachment_type;
				var attachmentSplit=$scope.attachment.split(',');
				var attachtypeSplit=$scope.attachment_type.split(',');
				$scope.attachmentArray=[];
				for(var i = 0; i < attachmentSplit.length; i++)
				{
					$scope.attachmentArray.push({ 
						'attachment':attachmentSplit[i],
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
function submitAssignmentCtrl($scope, $http, $routeParams, $timeout,$window,$sce) 
{
	var file_not_allowed_msg="Only jpeg,jpg,png,doc file supported.";
	var validImageTypes=new Array('image/jpeg','image/jpg','image/png','application/pdf','application/msword',
	'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
	$scope.previewImages	= [];
	$scope.PreviewImage=[];
	$scope.SelectFile = function (e) {
		
	for(var i=0;i<e.target.files.length;i++){
		//alert(e.target.files[i].type);
		//return false;
		var type;
		if (( !validImageTypes.includes(e.target.files[i].type) ) )
		{
			//$window.alert(file_not_allowed_msg);
			//return false;
		}
		$scope.previewImages.push(e.target.files[i]);

		var reader = new FileReader();
		reader.fileName = e.target.files[i].name;
		reader.onload = function (e) {
		var imgtype=e.target.result.split(';');
		imgtype=imgtype[0].split(':');
		imgtype=imgtype[1].split('/');
		if(imgtype[0]=='image'){
			var type='image';
		}else{
			var type='all';
		}
			$scope.PreviewImage.push({'name':e.target.fileName,'type':type});
			$scope.$apply();
		};
		reader.readAsDataURL(e.target.files[i]);
	}
	}
	$scope.remove=function(data){
		console.log(data);
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

	$scope.description 	  	= '';
	$scope.pic 	  	= '';
	$scope.showLoader=0;
	$scope.submitAssignment=function(){
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
		formData.append('classID', classID);
		formData.append('schoolID', schoolID);
		formData.append('assignment_id', $scope.assignmentID);
		var files = document.getElementById('pic').files;
		if($scope.previewImages.length > 0)
		{
			for(var i = 0; i < $scope.previewImages.length; i++)
			{ 
				formData.append('files[]', $scope.previewImages[i]);
			}
		}
		//formData.append('pic[]',files);
		$http.post(BASE_URL+'api/student/assignment/submitAssignment',formData,{
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
						text: 'Assigntment submitted successfully.'
					});
					$window.location.href = '#!/assignment-list';
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
}

function studentSubmitAssignmentCtrl($scope, $http, $route, $window) 
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
	$scope.getStudentSubmitAssignmentList=function(){
		var formData={'classID':classID}
		$http.post(BASE_URL+'api/student/assignment/getStudentSubmitAssignmentList',formData,{
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
					$scope.studentSubmitAssignmentData[i]['currDate'] = new Date();
				}
				
			}
			}, function errorCallback(response){
			
		});
	}
	$scope.getStudentSubmitAssignmentList();
	$scope.deleteSubmitAssignment = function(id,index)
	{
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':id};
			$http.post(BASE_URL+'api/student/assignment/deleteSubmitAssignment',formData,{
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
							text: 'Assignment deleted successfully.'
						});
						if (index > -1) {
						$scope.studentSubmitAssignmentData.splice(index, 1);;
						return false;
						}
					}();
				}
				
				}, function errorCallback(response){
				
			});
		}
	}
} 
function allSubmitAssignmentCtrl($scope, $http, $routeParams, $timeout,$window) 
{
	$scope.submitassignmentdownload=function(id) {
		$window.location.href = BASE_URL+'download/submitassignmentdownload/'+id;
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
	$scope.showAtachment=0;
	$scope.viewAttachment=function(val){
		if($scope.showAtachment==0){
			$scope.showAtachment=1;
		}else if($scope.showAtachment==1){
			$scope.showAtachment=0;
		}
	}
	var sid;
	$scope.assignmentID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.assignmentID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.assignmentID;
	};	
	$timeout($scope.setID(), 2000);
	//alert($scope.parentID); return false;
	$scope.assignmentinfo = false;
	$scope.getSubmitAssignmentDetails = function()
	{
		var formData = {'id':$scope.assignmentID}
		$http.post(BASE_URL+'api/student/assignment/getSubmitAssignmentDetails',formData,{
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
				$scope.assignmentname=$scope.assignmentinfo.title;
				$scope.category=$scope.assignmentinfo.category;
				$scope.totalmarks=$scope.assignmentinfo.total_marks;
				$scope.class=$scope.assignmentinfo.classname;
				$scope.teacher=$scope.assignmentinfo.teachername;
				$scope.submissiondate=$scope.assignmentinfo.submission_date;
				$scope.lastsubmissiondate=$scope.assignmentinfo.sdate;
				$scope.description=$scope.assignmentinfo.description;
				$scope.feedback=$scope.assignmentinfo.feedback;
				$scope.subject=$scope.assignmentinfo.subject;
				$scope.dateofissue=$scope.assignmentinfo.dateofissue;
				$scope.latedays=$scope.assignmentinfo.latedays;
				$scope.leftdays=$scope.assignmentinfo.leftdays;
				$scope.attachment=$scope.assignmentinfo.saattachment;
				$scope.attachmenttype=$scope.assignmentinfo.saattachmenttype;
				var attachmentSplit=$scope.attachment.split(',');
				var attachtypeSplit=$scope.attachmenttype.split(',');
				$scope.attachmentArray=[];
				for(var i = 0; i < attachmentSplit.length; i++)
				{
					$scope.attachmentArray.push({ 
						'attachment':attachmentSplit[i],
						'downloadurl':BASE_URL+'img/submitassignment/'+attachmentSplit[i]
					});
					
				}
			}
			
			}, function errorCallback(response){
				$scope.assignmentinfo=[];
				$scope.attachmentArray=[];
		});
		
	}
	$scope.getSubmitAssignmentDetails();
}

function editSubmitAssignmentCtrl($scope, $http, $routeParams, $timeout,$window,$sce) 
{
	var file_not_allowed_msg="Only jpeg,jpg,png,doc file supported.";
	var validImageTypes=new Array('image/jpeg','image/jpg','image/png','application/pdf','application/msword',
	'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
	$scope.removeAfterSelect=function(data){
		var index= $scope.PreviewImage.indexOf(data);
		$scope.PreviewImage.splice(data, 1);	
		$scope.previewImages.splice(data, 1);				
	}
	$scope.remove=function(data,index){
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':data.id,'filename':data.name};
			$http.post(BASE_URL+'api/student/assignment/deleteSubmitAttachData',formData,{
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
							text: 'Deleted successfully.'
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

	var sid;
	$scope.attachmentID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.attachmentID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.attachmentID;
	};	
	$timeout($scope.setID(), 2000);
	$scope.previewImages	= [];
	$scope.PreviewImage=[];
	$scope.SelectFile = function (e) {
	for(var i=0;i<e.target.files.length;i++){
		var type;
		if (( !validImageTypes.includes(e.target.files[i].type) ) )
		{
			//$window.alert(file_not_allowed_msg);
			//return false;
		}
		$scope.previewImages.push(e.target.files[i]);
		var reader = new FileReader();
		reader.fileName = e.target.files[i].name;
		reader.onload = function (e) {
		var imgtype=e.target.result.split(';');
		imgtype=imgtype[0].split(':');
		imgtype=imgtype[1].split('/');
		if(imgtype[0]=='image'){
			var type='image';
		}else{
			var type='all';
		}
			$scope.PreviewImage.push({'name':e.target.fileName,'type':type});
			$scope.$apply();
		};
		reader.readAsDataURL(e.target.files[i]);
	
	}
	}
	$scope.assignmentinfo = false;
	$scope.getSubmitAtachmentDetails = function()
	{
		var formData = {'id':$scope.attachmentID}
		$http.post(BASE_URL+'api/student/assignment/getSubmitAtachmentDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{   
				$scope.assignmentinfo = response.data.data;
				$scope.attachment=$scope.assignmentinfo.attachment;
				$scope.description=$scope.assignmentinfo.description;
				$scope.assignment_id=$scope.assignmentinfo.assignment_id;
				$scope.ID=$scope.assignmentinfo.id;
				$scope.attachmentID=$scope.assignmentinfo.said;
				$scope.attachment=$scope.assignmentinfo.saattachment;
				$scope.attachmenttype=$scope.assignmentinfo.saattachmenttype;
				var attachmentIdSplit=$scope.attachmentID.split(',');
				var attachmentSplit=$scope.attachment.split(',');
				var attachtypeSplit=$scope.attachmenttype.split(',');
				$scope.attachmentArray=[];
				for(var i = 0; i < attachmentSplit.length; i++)
				{
					$scope.attachmentArray.push({ 
						'id':attachmentIdSplit[i],
						'type':attachtypeSplit[i],
						'name':attachmentSplit[i],
						'url':BASE_URL+'img/submitassignment/'+attachmentSplit[i]
					});
					
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getSubmitAtachmentDetails();
	$scope.showLoader=0;
	$scope.editAttachment=function(attachmentID){
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
			formData.append('classID', classID);
			formData.append('id', attachmentID);
			formData.append('assignment_id', $scope.assignment_id);
			var files = document.getElementById('pic').files;
			if($scope.previewImages.length > 0)
			{
				for(var i = 0; i < $scope.previewImages.length; i++)
				{ 
					formData.append('files[]', $scope.previewImages[i]);
				}
			}
			$http.post(BASE_URL+'api/student/assignment/editSubmitAssignment',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey
				}
				}).then(function(response) {
					$scope.showLoader=0;
					var result  = response.data;
					var Gritter = function () {
						$.gritter.add({
							title: 'Successfull',
							text: 'Assigntment updated successfully.'
						});
						$window.location.href = '#!/submit-assignment-list';
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
}
function teacherListCtrl($scope, $http, $route, $window) 
{
	$scope.pageSize = 12;
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
	$scope.getTeacherList=function(){
		var formData={'classID':classID}
		$http.post(BASE_URL+'api/student/profile/getTeacherList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.teacherData = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.teacherData.length; i++)
				{
					encrypted = $scope.encryptStr($scope.teacherData[i].id);
					$scope.teacherData[i]['teacherID'] = encrypted;
				}
			}
			}, function errorCallback(response){
			
		});
	}
	$scope.getTeacherList();
} 
function studentListCtrl($scope, $http, $route, $window) 
{
	$scope.pageSize = 12;
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
	$scope.getStudentList=function(){
		var formData={'classID':classID}
		$http.post(BASE_URL+'api/student/profile/getStudentList',formData,{
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
function allTeacherCtrl($scope, $http, $routeParams, $timeout) 
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
	var sid;
	$scope.teacherID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.teacherID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.teacherID;
	};	
	$timeout($scope.setID(), 2000);
	$scope.assignmentinfo = false;
	$scope.getTeacherDetails = function()
	{
		var formData = {'id':$scope.teacherID,'classID':classID}
		$http.post(BASE_URL+'api/student/profile/getTeacherDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{   
				var encrypted;
				$scope.teacherinfo = response.data.data;
				$scope.chatUserID = $scope.encryptStr("T-"+$scope.teacherinfo.id);
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getTeacherDetails();
}
function allStudentCtrl($scope, $http, $routeParams, $timeout) 
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
	var sid;
	$scope.studentID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.studentID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.studentID;
	};	
	$timeout($scope.setID(), 2000);
	$scope.assignmentinfo = false;
	$scope.getStudentDetailsById = function()
	{
		var formData = {'id':$scope.studentID,'classID':classID}
		$http.post(BASE_URL+'api/student/profile/getStudentDetailsById',formData,{
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
		var formData={'classID':classID,'offset':$scope.start,'per_page':$scope.limit}
		$http.post(BASE_URL+'api/student/classboard/getClassboardList',formData,{
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
		$http.post(BASE_URL+'api/student/classboard/getClassboardList',formData,{
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
	$scope.start=0;
	$scope.limit=10;
	$scope.getClassboardPostList=function(){
		var formData={'classboardID':$scope.classboardID,'offset':$scope.start,'per_page':$scope.limit}
		$http.post(BASE_URL+'api/student/classboard/getClassboardPostList',formData,{
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
		$http.post(BASE_URL+'api/student/classboard/getClassboardPostList',formData,{
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
	$scope.postcomment=[];
	$scope.comment=function(commentdata,index){
		if($scope.postcomment.length==0){
			return false;
		}
		var formData = {'post_id':commentdata.id,'classboard_id':commentdata.classboard_id,'comment':$scope.postcomment[index]}
		$http.post(BASE_URL+'api/student/classboard/addClaasboarPostComment',formData,{
			headers:{
				'Content-Type':'application/json',
				'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{
				$scope.result = response.data.data;
				commentdata.commentData.push($scope.result);
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
			$http.post(BASE_URL+'api/student/classboard/deleteComment',formData,{
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
function messageListCtrl($scope, $http, $route, $window,$interval) 
{
	$scope.deleteMessage = function(user)
	{
		//console.log(user);return false;
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'user':user};
			$http.post(BASE_URL+'api/student/message/deleteConversationMessage',formData,{
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
		$http.post(BASE_URL+'api/student/message/getMessageList',formData,{
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
	$scope.selectedToTopModel = []; 
	$scope.selectedToTopData = [ { id: 1, label: 'David' }, { id: 2, label: 'Jhon' }, { id: 3, label: 'Danny' }, ]; 
	$scope.selectedToTopSettings = { selectedToTop: true, };
  $scope.setting1 = {
	  selectedToTop: true,
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
			$http.post(BASE_URL+'api/student/message/deleteConversationMessage',formData,{
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
		var formData={'classID':classID,'user_type':$scope.usertype}
		$http.post(BASE_URL+'api/student/message/getUser',formData,{
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
	var i=0;
	$scope.getConversationList=function(){
		var formData={'user_id':$scope.userID}
		$http.post(BASE_URL+'api/student/message/getConversationList',formData,{
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
						$scope.conversationData.conversation[i]['attachments'][j]['filetype']=angular.lowercase(extn);
					}
					}
				}
				}
				
			}
			}, function errorCallback(response){
				$scope.conversationData=[];
			});
			
	}
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
	var totalImageSize = 0;
	//size in MB
	var maxphotosize = 8;
	var totalImageSize;
	$scope.SelectFile = function (e) {
	for(var i=0;i<e.target.files.length;i++){
		totalImageSize = parseInt(totalImageSize) + parseInt(e.target.files[i].size);
		//return false;
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
	var totalphotosize = totalImageSize / (1024 * 1024);
	if (parseInt(totalphotosize) > parseInt(maxphotosize)) {
		//alert('sc');
		var msg = 'Attachment should not be greater than '+maxphotosize+' MB';
		$scope.previewImages=[];
		$scope.PreviewImage=[];
		var Gritter = function () {
			$.gritter.add({
				title: 'Error',
				text: msg
			});
			return false;
		}();
	}
	return false;
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
		$scope.isMsg=1;
		$scope.showLoader=1;
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
		
		$http.post(BASE_URL+'api/student/message/sendMessage',formData,{
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
				$scope.previewImages=[];
				$scope.PreviewImage=[];
				$scope.isMsg=0;
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
function allSubjectCtrl($scope, $http, $routeParams, $timeout) 
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
	var sid;
	$scope.subjectID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.subjectID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.subjectID;
	};	
	$timeout($scope.setID(), 2000);
	$scope.subjectinfo = false;
	$scope.getSubjectDetails = function()
	{
		var formData = {'id':$scope.subjectID,'classID':classID}
		$http.post(BASE_URL+'api/student/dashboard/getSubjectDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{   
				$scope.subjectinfo = response.data.data;
				//alert($scope.subjectinfo.length);
				if($scope.subjectinfo)
				{
				for(var i = 0; i < $scope.subjectinfo.assignments.length; i++)
				{ 
					$scope.subjectinfo.assignments[i]['id']=$scope.encryptStr($scope.subjectinfo.assignments[i]['id']);
				}
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getSubjectDetails();
}
function todoListCtrl($scope, $http, $route, $window,$timeout,$routeParams) 
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
	$scope.todoID = '';
	if($routeParams.ID!=undefined){
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.todoID = decrypted.toString(CryptoJS.enc.Utf8);
		//sid = $scope.todoID;
	};	
	
	$timeout($scope.setID(), 2000);
}
	$scope.getToDoList=function(){
		var formData={'schoolID':schoolID,'classID':classID}
		$http.post(BASE_URL+'api/student/dashboard/getAllToDoDataList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.todoData = response.data.data;
				if($scope.todoID!=''){
					$scope.getAssignmentDetails($scope.todoID);
				}else{
					$scope.todoID=$scope.todoData[0]['id'];
					$scope.getAssignmentDetails($scope.todoData[0]['id']);
				}
				var encrypted ;
				for(var i = 0; i < $scope.todoData.length; i++)
				{
					encrypted = $scope.encryptStr($scope.todoData[i].id);
					$scope.todoData[i]['ID'] = encrypted;
				}
				
			}
			}, function errorCallback(response){
				$scope.todoData=[];
		});
	}
	$scope.getToDoList();
	
	$scope.assignmentinfo = false;
	$scope.getAssignmentDetails = function(assignmentID)
	{
		var formData = {'id':assignmentID}
		$http.post(BASE_URL+'api/student/assignment/getAssignmentDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{   
				var encrypted;
				$scope.indexID=$scope.todoID;
				$scope.assignmentinfo = response.data.data;				
				encrypted = $scope.encryptStr($scope.assignmentinfo.id);
				$scope.viewassignmentID = encrypted;
				$scope.assignmentname=$scope.assignmentinfo.title;
				$scope.no_of_attempt=$scope.assignmentinfo.no_of_attempt;
				$scope.open_submission_date=$scope.assignmentinfo.open_submission_date;
				$scope.isAssignmentOpen=$scope.assignmentinfo.isAssignmentOpen;
				$scope.class=$scope.assignmentinfo.classname;
				$scope.teacher=$scope.assignmentinfo.teachername;
				$scope.submissiondate=$scope.assignmentinfo.submission_date;
				$scope.description=$scope.assignmentinfo.description;
				$scope.subject=$scope.assignmentinfo.subject;
				$scope.attachment=$scope.assignmentinfo.attachment;
				$scope.attachment_type=$scope.assignmentinfo.attachment_type;
				var attachmentSplit='';
				var attachtypeSplit='';
				if($scope.attachment){
				attachmentSplit=$scope.attachment.split(',');
				}
				if($scope.attachment_type){
				 attachtypeSplit=$scope.attachment_type.split(',');
				}
				$scope.attachmentArray=[];
				for(var i = 0; i < attachmentSplit.length; i++)
				{
					$scope.attachmentArray.push({ 
						'attachment':attachmentSplit[i],
						'type':attachtypeSplit[i],
						'downloadurl':BASE_URL+'img/assignment/'+attachmentSplit[i]
					});
					
				}
				$scope.fileTypeArr=[];
				for(var i = 0; i < attachtypeSplit.length; i++)
				{
					var filename=attachmentSplit[i];
					var extn = filename.split(".").pop();
					var checkExist = $scope.fileTypeArr.indexOf(extn);
					if(checkExist==-1){
					$scope.fileTypeArr.push(extn);
					}
				}
				if(attachmentSplit.length>0 && $scope.description){
					$scope.submissionType="Text & File Upload";
				}if(attachmentSplit==''){
					$scope.submissionType="Text";
				}

				$scope.currDate = new Date();
			}
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
		var formData = {'id':schoolID,'classID':classID,'calendardate':$scope.calendardate,'iscalendardata':0};
		$http.post(BASE_URL+'api/student/calendar/getAllCalendarData',formData,{
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
	
	$scope.getClassScheduleList=function(){
		var formData={'schoolID':schoolID,'classID':classID}
		$http.post(BASE_URL+'api/student/timetable/getClassScheduleList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.timeTableData = response.data.data;
				$scope.day_timeTable=[];
				//if($scope.timeTableData.length>0){
				for (const [key, value] of Object.entries($scope.timeTableData)) {
					 let temp = {'val': key,'lectureList':value};
					 $scope.day_timeTable.push(temp);
				//}
			}
			}
			}, function errorCallback(response){
				$scope.day_timeTable=[]
		});
	}
	$scope.getClassScheduleList();
}
function faqListCtrl($scope, $http, $route, $window) 
{
	
	$scope.getFaqList=function(){
		var formData={'schoolID':schoolID,'classID':''}
		$http.post(BASE_URL+'api/student/faq/getFaqList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.faqData = response.data.data;
				
			}
			}, function errorCallback(response){
				$scope.faqData=[]
		});
	}
	$scope.getFaqList();
}
function goalListCtrl($scope, $http, $route, $window) 
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
	$scope.getGoalList=function(){
		var formData={'schoolID':schoolID,'classID':classID}
		$http.post(BASE_URL+'api/student/goal/getGoalList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.goalData = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.goalData.length; i++)
				{
					encrypted = $scope.encryptStr($scope.goalData[i].id);
					$scope.goalData[i]['goalID'] = encrypted;
				}
				
			}
			}, function errorCallback(response){
				$scope.goalData=[]
		});
	}
	$scope.getGoalList();
}
function allGoalCtrl($scope, $http, $routeParams, $timeout,$window) 
{
	var sid;
	$scope.goalID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.goalID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.goalID;
	};	
	$timeout($scope.setID(), 2000);
	$scope.goalinfo = false;
	$scope.getGoalDetails = function()
	{
		$scope.goalinfo=[];
		var formData = {'goalID':$scope.goalID,'schoolID':schoolID}
		$http.post(BASE_URL+'api/student/goal/getGoalDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{  
				$scope.goalinfo = response.data.data;
				
					if($scope.goalinfo['attachment'].length > 0)
					{
					for(var j = 0; j < $scope.goalinfo['attachment'].length; j++)
					{ 
						var filename=$scope.goalinfo['attachment'][j]['file'];
						//alert(filename);
						var extn = filename.split(".").pop();
						$scope.goalinfo['attachment'][j]['filetype']=angular.lowercase(extn);
					}
					}

			}
			}, function errorCallback(response){
				$scope.goalinfo=[];
		});
		
	}
	$scope.getGoalDetails();
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
		var formData={'schoolID':schoolID,'classID':classID}
		$http.post(BASE_URL+'api/student/gift/getGiftList',formData,{
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
		var formData = {'giftID':$scope.giftID,'schoolID':schoolID}
		$http.post(BASE_URL+'api/student/gift/getGiftDetails',formData,{
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
		$scope.subject_id='';
		$scope.status='';
		$scope.subjectArray=[];
		$scope.statusArray=[];
		$scope.sessionArray=[];
		$scope.sessionval='';
		//$scope.sessionval=new Date().getFullYear()+'-'+(new Date().getFullYear() + 1);
		$scope.getExamList=function(){
		var formData={'schoolID':schoolID,'classID':classID,'subject_id':$scope.subject_id,'status':$scope.status,'session':$scope.sessionval}
		$http.post(BASE_URL+'api/student/exam/getExamList',formData,{
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
					$scope.subjectArray.push({
						'id':$scope.examData[i].subject_id,
						'name':$scope.examData[i].subject
					});
					$scope.statusArray.push({
						'name':$scope.examData[i].exam_status
					});
					$scope.sessionArray.push({
						'name':$scope.examData[i].session
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
		var formData = {'examID':$scope.examID,'schoolID':schoolID,'classID':classID}
		$http.post(BASE_URL+'api/student/exam/getExamDetails',formData,{
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
					var dt =  new Date();
					dt.setMinutes( dt.getMinutes() + parseInt($scope.examinfo.exam_duration) );
					//dt.setSeconds(dt.getSeconds()+10);
					//console.log(dt);
	                //var countDownDate = dt;
					var countDownDate = dt;
					$scope.StartTimer = function () {
						$scope.Timer = $interval(function () {
                        var now = new Date().getTime();
                        var distance = countDownDate - now;
                        $scope.days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        $scope.hours  = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        $scope.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        $scope.seconds = Math.floor((distance % (1000 * 60)) / 1000);
						if(distance < 0) {
						$scope.days = 0;
                        $scope.hours  =0;
                        $scope.minutes = 0;
                        $scope.seconds = 0;
						$scope.StopTimer();
						  }	
					}, 1000);
					};
					$scope.StartTimer();
					
				}
			}
			}, function errorCallback(response){
				$scope.examinfo=[];
		});
		
	}
	$scope.getExamDetails();
	
}
function startExamCtrl($scope, $http, $routeParams, $timeout,$window,$interval) 
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
	$scope.startExam = function()
	{
		$scope.examinfo=[];
		var formData = {'examID':$scope.examID,'schoolID':schoolID,'classID':classID}
		$http.post(BASE_URL+'api/student/exam/startExam',formData,{
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
					
					var countDownDate = new Date($scope.examinfo.end_time).getTime();
					$scope.StartTimer = function () {
						$scope.Timer = $interval(function () {
                        var now = new Date().getTime();
                        var distance = countDownDate - now;
                        $scope.days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        $scope.hours  = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        $scope.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        $scope.seconds = Math.floor((distance % (1000 * 60)) / 1000);
						if(distance < 0) {
						$scope.days = 0;
                        $scope.hours  =0;
                        $scope.minutes = 0;
                        $scope.seconds = 0;
						$scope.StopTimer();
						var confirm = $window.confirm('Your exam time has been over.Are you want to submit this exam?');
							if(confirm == true)
							{
								$scope.updateExam();	
							}else{
								$window.location.href = '#!/exam-list';
							}
						  }	
					}, 1000);
					};
					$scope.StartTimer();
					
				}
			}
			}, function errorCallback(response){
				$scope.examinfo=[];
		});
		
	}
	$scope.StopTimer = function () {
		if (angular.isDefined($scope.Timer)) {
			$interval.cancel($scope.Timer);
		}
	};
	$scope.startExam();
	$scope.isSubmit=false;
	$scope.StopTimer = function () {
		if (angular.isDefined($scope.Timer)) {
			$interval.cancel($scope.Timer);
		}
	};
	$scope.updateExam=function(){
		var formData = {'examData':$scope.examinfo,'schoolID':schoolID,'classID':classID,'hours':$scope.hours,'minutes':$scope.minutes,'seconds':$scope.seconds}
		$http.post(BASE_URL+'api/student/exam/updateExam',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{  
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: response.data.message
					});
					$scope.errormsg = '';
					$scope.message = '';
					return false;
				}();
				$window.location.href = '#!/exam-list';
			}
			}, function errorCallback(response){
				var Gritter = function () {
					$.gritter.add({
						title: 'Error',
						text: response.data.message
					});
					return false;
				}();
		});
	}
	$scope.setChoiceForQuestion = function (q, c) {
		
        angular.forEach(q.option_value, function (c) {
            c.isUserAnswer = "false";
        });
        
	   c.isUserAnswer = "true";
    };
}
function editExamCtrl($scope, $http, $routeParams, $timeout,$window,$interval) 
{
	$scope.isSubmit=false;
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
		var formData = {'examID':$scope.examID,'schoolID':schoolID,'classID':classID}
		$http.post(BASE_URL+'api/student/exam/getExamDetails',formData,{
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
					var remaingTime=$scope.examinfo.exam_duration-$scope.examinfo.answer_duration;
					var remaingTimeSpt=remaingTime.toString().split('.');
					var remaingMinutes=remaingTimeSpt[0];
					var remaingSeconds=remaingTimeSpt[1];
					var seconds=0;
					if(remaingSeconds>0){
					seconds='0.'+remaingSeconds;
					seconds=Math.round(seconds*60);
					}
					var dt =  new Date();
					//dt.setMinutes( dt.getMinutes() + parseInt(remaingMinutes) );
					dt.setSeconds(dt.getSeconds()+ parseInt(seconds) );
					console.log(dt);
	                //var countDownDate = dt;
					var countDownDate = dt;
					$scope.StartTimer = function () {
						$scope.Timer = $interval(function () {
                        var now = new Date().getTime();
                        var distance = countDownDate - now;
                        $scope.days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        $scope.hours  = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        $scope.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        $scope.seconds = Math.floor((distance % (1000 * 60)) / 1000);
						if(distance < 0) {
						$scope.days = 0;
                        $scope.hours  =0;
                        $scope.minutes = 0;
						$scope.seconds = 0;
						$scope.isSubmit=true;
						//$("#examModal").modal('show');
						$scope.StopTimer();
						  }	
					}, 1000);
					};
					$scope.StartTimer();
				}
			}
			}, function errorCallback(response){
				$scope.examinfo=[];
		});
		
	}
	$scope.getExamDetails();
	$scope.StopTimer = function () {
		if (angular.isDefined($scope.Timer)) {
			$interval.cancel($scope.Timer);
		}
	};
	$scope.updateExam=function(){
		var formData = {'examData':$scope.examinfo,'schoolID':schoolID,'classID':classID,'hours':$scope.hours,'minutes':$scope.minutes,'seconds':$scope.seconds}
		$http.post(BASE_URL+'api/student/exam/updateExam',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{  
				var Gritter = function () {
					$.gritter.add({
						title: 'Successfull',
						text: response.data.message
					});
					$scope.errormsg = '';
					$scope.message = '';
					return false;
				}();
				$window.location.href = '#!/exam-list';
			}
			}, function errorCallback(response){
				var Gritter = function () {
					$.gritter.add({
						title: 'Error',
						text: response.data.message
					});
					return false;
				}();
		});
	}
	$scope.setChoiceForQuestion = function (q, c) {
		
        angular.forEach(q.option_value, function (c) {
            c.isUserAnswer = "false";
        });
        
	   c.isUserAnswer = "true";
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
		$http.post(BASE_URL+'api/student/notification/getAllNotification',formData,{
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
						$scope.notificationData[i]['senderUrl'] = 'teacher-details/'+encrypted;
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
		$http.post(BASE_URL+'api/student/notification/updateNotification',formData,{
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
			$http.post(BASE_URL+'api/student/notification/deleteNotification',formData,{
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

function studentProjectCtrl($scope, $http, $route, $window) 
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
	$scope.subject_id='';
	$scope.category='';
	$scope.subjectArray=[];
    $scope.categoryArray=[];
	$scope.getStudentProjectList=function(){
		var formData={'classID':classID,'filterbydate':$scope.datefilter,'subject_id':$scope.subject_id,'category':$scope.category}
		$http.post(BASE_URL+'api/student/project/getStudentProjectList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.studentAssignmentData = response.data.data;
				var encrypted ;
				for(var i = 0; i < $scope.studentAssignmentData.length; i++)
				{
					encrypted = $scope.encryptStr($scope.studentAssignmentData[i].id);
					$scope.studentAssignmentData[i]['assignmentID'] = encrypted;
					$scope.studentAssignmentData[i]['currDate'] = new Date();
					$scope.subjectArray.push({
						'id':$scope.studentAssignmentData[i].subject_id,
						'name':$scope.studentAssignmentData[i].subject
					});
					$scope.categoryArray.push({
						'name':$scope.studentAssignmentData[i].category
					});
				}
			}
			}, function errorCallback(response){
				$scope.studentAssignmentData=[];
		});
	}
	$scope.getStudentProjectList();
} 
function allProjectCtrl($scope, $http, $routeParams, $timeout,$window) 
{
	
	$scope.attemptCount=function(id,attempt,userAttemptCount){
		if(parseInt(attempt)<=parseInt(userAttemptCount)){
			var Gritter = function () {
				$.gritter.add({
					title: 'Error',
					text: 'You have exceed submission limit.'
				});
			}();
			return false;
		}
		$window.location.href = '#!/submit-project/'+id;
		return false;
	}
	 	$scope.assignmentdownload=function(id) {
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
	$scope.showAtachment=0;
	$scope.viewAttachment=function(val){
		if($scope.showAtachment==0){
			$scope.showAtachment=1;
		}else if($scope.showAtachment==1){
			$scope.showAtachment=0;
		}
	}
	var sid;
	$scope.assignmentID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.assignmentID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.assignmentID;
	};	
	$timeout($scope.setID(), 2000);
	//alert($scope.assignmentID); return false;
	$scope.assignmentinfo = false;
	$scope.getProjectDetails = function()
	{
		var formData = {'id':$scope.assignmentID}
		$http.post(BASE_URL+'api/student/project/getProjectDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{   
				var encrypted;
				$scope.assignmentinfo = response.data.data;

				if($scope.assignmentinfo.isAssignmentOpen==0){
					var Gritter = function () {
						$.gritter.add({
							title: 'Error',
							text: 'Assignment Locked'
						});
					}();
					$window.location.href = '#!/assignment-list/';
					return false;
				}
				
				
				encrypted = $scope.encryptStr($scope.assignmentinfo.id);
				$scope.viewassignmentID = encrypted;
				$scope.assignmentname=$scope.assignmentinfo.title;
				$scope.no_of_attempt=$scope.assignmentinfo.no_of_attempt;
				$scope.userAttemptCount=$scope.assignmentinfo.userAttemptCount;
				$scope.class=$scope.assignmentinfo.classname;
				$scope.teacher=$scope.assignmentinfo.teachername;
				$scope.submissiondate=$scope.assignmentinfo.submission_date;
				$scope.description=$scope.assignmentinfo.description;
				$scope.subject=$scope.assignmentinfo.subject;
				$scope.dateofissue=$scope.assignmentinfo.created;
				$scope.latedays=$scope.assignmentinfo.latedays;
				$scope.leftdays=$scope.assignmentinfo.leftdays;
				$scope.attachment=$scope.assignmentinfo.attachment;
				$scope.attachment_type=$scope.assignmentinfo.attachment_type;
				var attachmentSplit=$scope.attachment.split(',');
				var attachtypeSplit=$scope.attachment_type.split(',');
				$scope.attachmentArray=[];
				for(var i = 0; i < attachmentSplit.length; i++)
				{
					$scope.attachmentArray.push({ 
						'attachment':attachmentSplit[i],
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
function submitProjectCtrl($scope, $http, $routeParams, $timeout,$window,$sce) 
{
	var file_not_allowed_msg="Only jpeg,jpg,png,doc file supported.";
	var validImageTypes=new Array('image/jpeg','image/jpg','image/png','application/pdf','application/msword',
	'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
	$scope.previewImages	= [];
	$scope.PreviewImage=[];
	$scope.SelectFile = function (e) {
		
	for(var i=0;i<e.target.files.length;i++){
		//alert(e.target.files[i].type);
		//return false;
		var type;
		if (( !validImageTypes.includes(e.target.files[i].type) ) )
		{
			//$window.alert(file_not_allowed_msg);
			//return false;
		}
		$scope.previewImages.push(e.target.files[i]);

		var reader = new FileReader();
		reader.fileName = e.target.files[i].name;
		reader.onload = function (e) {
		var imgtype=e.target.result.split(';');
		imgtype=imgtype[0].split(':');
		imgtype=imgtype[1].split('/');
		if(imgtype[0]=='image'){
			var type='image';
		}else{
			var type='all';
		}
			$scope.PreviewImage.push({'name':e.target.fileName,'type':type});
			$scope.$apply();
		};
		reader.readAsDataURL(e.target.files[i]);
	}
	}
	$scope.remove=function(data){
		console.log(data);
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

	$scope.description 	  	= '';
	$scope.pic 	  	= '';
	$scope.showLoader=0;
	$scope.submitProject=function(){
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
		formData.append('classID', classID);
		formData.append('schoolID', schoolID);
		formData.append('assignment_id', $scope.assignmentID);
		var files = document.getElementById('pic').files;
		if($scope.previewImages.length > 0)
		{
			for(var i = 0; i < $scope.previewImages.length; i++)
			{ 
				formData.append('files[]', $scope.previewImages[i]);
			}
		}
		//formData.append('pic[]',files);
		$http.post(BASE_URL+'api/student/project/submitProject',formData,{
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
						text: 'Project submitted successfully.'
					});
					$window.location.href = '#!/project-list';
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
}

function studentSubmitProjectCtrl($scope, $http, $route, $window) 
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
	$scope.getStudentSubmitProjectList=function(){
		var formData={'classID':classID}
		$http.post(BASE_URL+'api/student/project/getStudentSubmitProjectList',formData,{
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
					$scope.studentSubmitAssignmentData[i]['currDate'] = new Date();
				}
				
			}
			}, function errorCallback(response){
			
		});
	}
	$scope.getStudentSubmitProjectList();
	$scope.deleteSubmitProject = function(id,index)
	{
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':id};
			$http.post(BASE_URL+'api/student/project/deleteSubmitProject',formData,{
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
							text: 'Project deleted successfully.'
						});
						if (index > -1) {
						$scope.studentSubmitAssignmentData.splice(index, 1);;
						return false;
						}
					}();
				}
				
				}, function errorCallback(response){
				
			});
		}
	}
} 
function allSubmitProjectCtrl($scope, $http, $routeParams, $timeout,$window) 
{
	$scope.submitprojectdownload=function(id) {
		$window.location.href = BASE_URL+'download/submitprojectdownload/'+id;
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
	$scope.showAtachment=0;
	$scope.viewAttachment=function(val){
		if($scope.showAtachment==0){
			$scope.showAtachment=1;
		}else if($scope.showAtachment==1){
			$scope.showAtachment=0;
		}
	}
	var sid;
	$scope.assignmentID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.assignmentID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.assignmentID;
	};	
	$timeout($scope.setID(), 2000);
	//alert($scope.parentID); return false;
	$scope.assignmentinfo = false;
	$scope.getSubmitProjectDetails = function()
	{
		var formData = {'id':$scope.assignmentID}
		$http.post(BASE_URL+'api/student/project/getSubmitProjectDetails',formData,{
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
				$scope.assignmentname=$scope.assignmentinfo.title;
				$scope.class=$scope.assignmentinfo.classname;
				$scope.teacher=$scope.assignmentinfo.teachername;
				$scope.submissiondate=$scope.assignmentinfo.submission_date;
				$scope.lastsubmissiondate=$scope.assignmentinfo.sdate;
				$scope.description=$scope.assignmentinfo.description;
				$scope.feedback=$scope.assignmentinfo.feedback;
				$scope.subject=$scope.assignmentinfo.subject;
				$scope.dateofissue=$scope.assignmentinfo.dateofissue;
				$scope.latedays=$scope.assignmentinfo.latedays;
				$scope.leftdays=$scope.assignmentinfo.leftdays;
				$scope.attachment=$scope.assignmentinfo.saattachment;
				$scope.attachmenttype=$scope.assignmentinfo.saattachmenttype;
				var attachmentSplit=$scope.attachment.split(',');
				var attachtypeSplit=$scope.attachmenttype.split(',');
				$scope.attachmentArray=[];
				for(var i = 0; i < attachmentSplit.length; i++)
				{
					$scope.attachmentArray.push({ 
						'attachment':attachmentSplit[i],
						'downloadurl':BASE_URL+'img/submitproject/'+attachmentSplit[i]
					});
					
				}
			}
			
			}, function errorCallback(response){
				$scope.assignmentinfo=[];
				$scope.attachmentArray=[];
		});
		
	}
	$scope.getSubmitProjectDetails();
}

function editSubmitProjectCtrl($scope, $http, $routeParams, $timeout,$window,$sce) 
{
	var file_not_allowed_msg="Only jpeg,jpg,png,doc file supported.";
	var validImageTypes=new Array('image/jpeg','image/jpg','image/png','application/pdf','application/msword',
	'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
	$scope.removeAfterSelect=function(data){
		var index= $scope.PreviewImage.indexOf(data);
		$scope.PreviewImage.splice(data, 1);	
		$scope.previewImages.splice(data, 1);				
	}
	$scope.remove=function(data,index){
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':data.id,'filename':data.name};
			$http.post(BASE_URL+'api/student/project/deleteSubmitAttachData',formData,{
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
							text: 'Deleted successfully.'
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

	var sid;
	$scope.attachmentID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
		$scope.attachmentID = decrypted.toString(CryptoJS.enc.Utf8);
		sid = $scope.attachmentID;
	};	
	$timeout($scope.setID(), 2000);
	$scope.previewImages	= [];
	$scope.PreviewImage=[];
	$scope.SelectFile = function (e) {
	for(var i=0;i<e.target.files.length;i++){
		var type;
		if (( !validImageTypes.includes(e.target.files[i].type) ) )
		{
			//$window.alert(file_not_allowed_msg);
			//return false;
		}
		$scope.previewImages.push(e.target.files[i]);
		var reader = new FileReader();
		reader.fileName = e.target.files[i].name;
		reader.onload = function (e) {
		var imgtype=e.target.result.split(';');
		imgtype=imgtype[0].split(':');
		imgtype=imgtype[1].split('/');
		if(imgtype[0]=='image'){
			var type='image';
		}else{
			var type='all';
		}
			$scope.PreviewImage.push({'name':e.target.fileName,'type':type});
			$scope.$apply();
		};
		reader.readAsDataURL(e.target.files[i]);
	
	}
	}
	$scope.assignmentinfo = false;
	$scope.getSubmitAtachmentDetails = function()
	{
		var formData = {'id':$scope.attachmentID}
		$http.post(BASE_URL+'api/student/project/getSubmitAtachmentDetails',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{   
				$scope.assignmentinfo = response.data.data;
				$scope.attachment=$scope.assignmentinfo.attachment;
				$scope.description=$scope.assignmentinfo.description;
				$scope.assignment_id=$scope.assignmentinfo.project_id;
				$scope.ID=$scope.assignmentinfo.id;
				$scope.attachmentID=$scope.assignmentinfo.said;
				$scope.attachment=$scope.assignmentinfo.saattachment;
				$scope.attachmenttype=$scope.assignmentinfo.saattachmenttype;
				var attachmentIdSplit=$scope.attachmentID.split(',');
				var attachmentSplit=$scope.attachment.split(',');
				var attachtypeSplit=$scope.attachmenttype.split(',');
				$scope.attachmentArray=[];
				for(var i = 0; i < attachmentSplit.length; i++)
				{
					$scope.attachmentArray.push({ 
						'id':attachmentIdSplit[i],
						'type':attachtypeSplit[i],
						'name':attachmentSplit[i],
						'url':BASE_URL+'img/submitproject/'+attachmentSplit[i]
					});
					
				}
			}
			
			}, function errorCallback(response){
			
		});
		
	}
	$scope.getSubmitAtachmentDetails();
	$scope.showLoader=0;
	$scope.editAttachment=function(attachmentID){
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
			formData.append('classID', classID);
			formData.append('id', attachmentID);
			formData.append('assignment_id', $scope.assignment_id);
			var files = document.getElementById('pic').files;
			if($scope.previewImages.length > 0)
			{
				for(var i = 0; i < $scope.previewImages.length; i++)
				{ 
					formData.append('files[]', $scope.previewImages[i]);
				}
			}
			$http.post(BASE_URL+'api/student/project/editSubmitProject',formData,{
				headers:{
					'Content-Type':undefined, 'x-api-key':xapikey
				}
				}).then(function(response) {
					$scope.showLoader=0;
					var result  = response.data;
					var Gritter = function () {
						$.gritter.add({
							title: 'Successfull',
							text: 'Project updated successfully.'
						});
						$window.location.href = '#!/submit-project-list';
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
		$http.post(BASE_URL+'api/student/setting/getNotificationSetting',formData,{
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
		$http.post(BASE_URL+'api/student/setting/updateNotificationSetting',formData,{
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
	
	$scope.getResultList=function(){
		var formData={'schoolID':schoolID,'classID':classID,'filterbydate':'','class_id':$scope.class_id,'subject_id':$scope.subject_id,'category':$scope.category}
		$http.post(BASE_URL+'api/student/result/getResultList',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			if(response.status == 200)
			{
				$scope.resultData = response.data.data;
				var encrypted ;
				if($scope.resultData.length>0){
				for(var i = 0; i < $scope.resultData.length; i++)
				{
					encrypted = $scope.encryptStr($scope.resultData[i].student_id);
					$scope.resultData[i]['studentID'] = encrypted;
				}
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
		$http.post(BASE_URL+'api/student/result/calculateSubjectTermResult',formData,{
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
		$http.post(BASE_URL+'api/student/result/getSubjectGrandsResult',formData,{
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
		$http.post(BASE_URL+'api/student/result/getStudentExamDetails',formData,{
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



function notelistCtrl($scope, $http, $routeParams, $timeout,$window) 
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
  $scope.lessonlist = function()
    {   
            var formData = {'schoolID': schoolID};
            $http.post(BASE_URL + 'api/student/lesssonnotestd/studentlessonlist', formData, {
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
    
  $scope.lessonlist();     
    
}

function viewnoteCtrl($scope, $http, $routeParams, $timeout,$window) 
{
    $scope.noteid = '';
    $scope.notesdata = '';
    $scope.comment = '';
    $scope.setID = function(){
    var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
    $scope.noteid = decrypted.toString(CryptoJS.enc.Utf8);
    var sid = $scope.noteid;
    };
    $timeout($scope.setID(), 2000);
  
  
    
    $scope.getNotesData = function()
     {
		$scope.lessondownload=function(id) {
			$window.location.href = BASE_URL+'download/lessondownload/'+id;
		}
        $scope.termList = false;
        var formData = {'schoolID':schoolID,'noteid':$scope.noteid};
        $http.post(BASE_URL+'api/student/lesssonnotestd/viewdetailsharednote',formData,{
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
        
        console.log("getNotesData"); 
        //console.log($scope.notesdata);
        }

        }, function errorCallback(error){});
		
    }
    
    
    $scope.addcomment = function() 
    {
    if( $scope.comment == '')
    {
        var Gritter = function () {
        $.gritter.add({
        title: 'Failed',
        text: `Please add some comments.`
        });
        return false;
        }();
 
    }
    else 
    {
        var formData = {'schoolID':schoolID,'noteid':$scope.noteid,'comment':$scope.comment};
        $http.post(BASE_URL+'api/student/lesssonnotestd/addcomment',formData,{
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
            }();
            
          setTimeout(function(){ $window.location.href = '#!/note-list'; }, 1000);  
              
            
        }   
        }, function errorCallback(error){});
     
        
    }
  }
    
   $scope.getNotesData();  
   $scope.comment='';
	$scope.addComment=function(){
		if($scope.comment==''){
			return false;
		}
		var formData = {'noteid':$scope.noteid,'schoolID':schoolID,'comment':$scope.comment}
		$http.post(BASE_URL+'api/student/lesssonnotestd/addLessonComment',formData,{
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
			$http.post(BASE_URL+'api/student/lesssonnotestd/deleteComment',formData,{
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

function addcommentCtrl($scope, $http, $routeParams, $timeout,$window) 
{
    
    
}

function commentlistCtrl($scope, $http, $routeParams, $timeout,$window) 
{
    $scope.commentdata
    $scope.noteid = '';
    $scope.setID = function(){
    var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "KidyView");
    $scope.noteid = decrypted.toString(CryptoJS.enc.Utf8);
    var sid = $scope.noteid;
    };
    $timeout($scope.setID(), 2000);
 
 
 
  $scope.commentlist = function()
  {   
        var formData = {'schoolID':schoolID,'noteid':$scope.noteid};
        $http.post(BASE_URL + 'api/student/lesssonnotestd/commentlist', formData, {
            headers: {
                'Content-Type': undefined, 'x-api-key': xapikey, 'TOKEN': localStorage.getItem("TOKEN")
            }
        }).then(function (response) {

            if (response.status == 200)
            {

                $scope.commentdata = response.data.data;

                for(var i = 0; i < $scope.commentdata.length; i++)
                {
                var  encrypted = $scope.encryptStr($scope.commentdata[i].id);
                $scope.commentdata[i]['lessonID'] = encrypted;
                }
                console.log($scope.commentdata);
            }

        }, function errorCallback(error) {});

    }
    
  $scope.commentlist();   
    
}