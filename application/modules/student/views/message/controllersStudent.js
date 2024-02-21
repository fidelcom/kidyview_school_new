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
			$http.post(BASE_URL+'api/profile/students/quoteDelete',formData,{
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
	$scope.getStudentAssignmentList=function(){
		var formData={'classID':classID,'filterbydate':$scope.datefilter}
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
	//alert($scope.parentID); return false;
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
	$scope.deleteMessage = function(id,index)
	{
		var deleteMedia = $window.confirm('Are you absolutely sure you want to delete?');
		if(deleteMedia == true)
		{
			var formData = {'id':id};
			$http.post(BASE_URL+'api/student/message/deleteMessage',formData,{
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
	var maxphotosize = .1;
	var totalImageSize;
	$scope.SelectFile = function (e) {
	for(var i=0;i<e.target.files.length;i++){
		console.log(e.target.files[i]);
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
		
		$scope.previewImages=[];
		$scope.PreviewImage=[];
		var msg = 'Attachment should not be greater than '+maxphotosize+' MB';
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