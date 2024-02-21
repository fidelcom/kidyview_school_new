<!-- BEGIN .app-main -->
<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 align-self-center">
            <div class="page-icon">
                <i class="icon-email"></i>
            </div>
            <div class="page-title">
                <h5>Messages</h5>
            </div>
        </div>
    </div>
</div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-xl- col-lg-7 col-md-7 col-sm-7 align-self-center">
                        <div class="media">
                            <div class="msg-user-img mr-3 align-self-center">
                            <img ng-if="conversationData.user_detail.user_type=='Teacher' && conversationData.user_detail.photo!=''" src="<?php echo base_url();?>img/teacher/{{conversationData.user_detail.photo}}" alt="{{converation.user_detail.fname}}" />
                            <img ng-if="conversationData.user_detail.photo==''" src="<?php echo base_url();?>img/noImage.png" alt="user">
                            <img ng-if="conversationData.user_detail.user_type=='Student' && conversationData.user_detail.photo!=''" src="<?php echo base_url();?>img/child/{{conversationData.user_detail.photo}}" alt="{{converation.user_detail.fname}}" />    
                            </div>
                            <div class="media-body align-self-center">
                                <h5 class="mt-0">{{conversationData.user_detail.fname+' '+conversationData.user_detail.lname}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                        <div class="right-actions float-right" style="position:relative;">
                            <div class="dropdown del-dropdown-m">
                                <a href="javascript:void(0);" class="" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-dots-three-horizontal"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                <button ng-click="deleteConversation(conversationData.user_detail.id);" class="dropdown-item" type="button">Delete</button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="frame">
                    <div class="content">
                        <div class="messages" id="conversationDiv" schroll-bottom="conversationData">
                            <ul ng-repeat="converation in conversationData.conversation track by $index">
                                <li class="sent" ng-show="converation.message_type=='recieved'" >
                                    <img ng-if="conversationData.user_detail.user_type=='Teacher' && conversationData.user_detail.photo!=''" src="<?php echo base_url();?>img/teacher/{{conversationData.user_detail.photo}}" alt="{{converation.user_detail.fname}}" />
                                    <img ng-if="conversationData.user_detail.user_type=='Student' && conversationData.user_detail.photo!=''" src="<?php echo base_url();?>img/child/{{conversationData.user_detail.photo}}" alt="{{converation.user_detail.fname}}" />    
                                    <img ng-if="conversationData.user_detail.photo==''" src="<?php echo base_url();?>img/noImage.png" alt="user">
                                    <div class="txt-msg-box">
                                        <div class="msg-content-m">
                                            <p>{{converation.message}}</p>
                                            <div ng-repeat="attachment in converation.attachments">
                                            <div ng-show="attachment.filetype=='jpeg' || attachment.filetype=='jpg' || attachment.filetype=='png'">
                                            <a href="<?php echo base_url();?>img/message/{{attachment.file}}" download="{{attachment.file}}">
                                            <img class="doctor-pic" src="<?php echo base_url();?>img/message/{{attachment.file}}">
                                            </a>
                                           </div>
                                           <div ng-show="attachment.filetype=='pdf' || attachment.filetype=='doc' || attachment.filetype=='docx'">
                                            <a href="<?php echo base_url();?>img/message/{{attachment.file}}" download="{{attachment.file}}"><i class="far fa-file"></i></i> {{attachment.file}}</a>
                                           </div>
                                           <div ng-show="attachment.filetype=='mp4' || attachment.filetype=='3gp' || attachment.filetype=='avi' || attachment.filetype=='flv'  || attachment.filetype=='wmv'">
                                           <a href="<?php echo base_url();?>img/message/{{attachment.file}}" download="{{attachment.file}}"> <video width="320" height="240" controls>
                                                <source src="<?php echo base_url();?>img/message/{{attachment.file}}" type="video/mp4">
                                                <source src="<?php echo base_url();?>img/message/{{attachment.file}}" type="video/3gp">
                                                <source src="<?php echo base_url();?>img/message/{{attachment.file}}" type="video/avi">
                                                <source src="<?php echo base_url();?>img/message/{{attachment.file}}" type="video/flv">
                                                <source src="<?php echo base_url();?>img/message/{{attachment.wmv}}" type="video/flv">
                                                Your browser does not support the video tag.
                                                </video></a>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="msg-time-blk">{{converation.time_elapsed}}</div>
                                    </div>
                                </li>
                                <li class="replies" ng-show="converation.message_type=='send'">
                                <div class="txt-msg-box">
                                        <div class="msg-content-m">
                                            <p>{{converation.message}}</p>
                                            <div ng-repeat="attachment in converation.attachments">
                                            <div ng-show="attachment.filetype=='jpeg' || attachment.filetype=='jpg' || attachment.filetype=='png'">
                                            <a href="<?php echo base_url();?>img/message/{{attachment.file}}" download="{{attachment.file}}">
                                            <img class="doctor-pic" src="<?php echo base_url();?>img/message/{{attachment.file}}">
                                            </a>
                                           </div>
                                           <div ng-show="attachment.filetype=='pdf' || attachment.filetype=='doc' || attachment.filetype=='docx'  || attachment.filetype=='xlsx' || attachment.filetype=='xls'">
                                            <a href="<?php echo base_url();?>img/message/{{attachment.file}}" download="{{attachment.file}}"><i class="far fa-file"></i> {{attachment.file}}</a>
                                           </div>
                                           <div ng-show="attachment.filetype=='mp3'||attachment.filetype=='mp4' || attachment.filetype=='3gp' || attachment.filetype=='avi' || attachment.filetype=='flv'  || attachment.filetype=='wmv' || attachment.filetype=='mkv' || attachment.filetype=='mov' || attachment.filetype=='mkv'">
                                           <a href="<?php echo base_url();?>img/message/{{attachment.file}}" download="{{attachment.file}}"> 
                                           <video width="320" height="240" controls>
                                                <source src="<?php echo base_url();?>img/message/{{attachment.file}}" type="video/mp4">
                                                <source src="<?php echo base_url();?>img/message/{{attachment.file}}" type="video/3gp">
                                                <source src="<?php echo base_url();?>img/message/{{attachment.file}}" type="video/avi">
                                                <source src="<?php echo base_url();?>img/message/{{attachment.file}}" type="video/flv">
                                                <source src="<?php echo base_url();?>img/message/{{attachment.file}}" type="video/3gpp">
                                                <source src="<?php echo base_url();?>img/message/{{attachment.file}}" type="video/mov">
                                                <source src="<?php echo base_url();?>img/message/{{attachment.file}}" type="video/mkv">
                                                Your browser does not support the video tag.
                                            </video>
                                            </a>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="msg-time-blk">{{converation.time_elapsed}}</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
						
                        <div class="message-input">
							<div class="uploaded-img-prev" ng-if="PreviewImage.length>0">
							<ul>
								<li ng-repeat="prev in PreviewImage" >
                                <div ng-show="prev.filetype=='jpeg' || prev.filetype=='jpg' || prev.filetype=='png'">
									<span class="close-upload-p-btn"><i ng-click="remove($index);" class="fa fa-trash" aria-hidden="true"></i></span>
									<img class="" src="{{prev.file}}" />
                                </div> 
                                <div ng-show="prev.filetype=='pdf' || prev.filetype=='doc' || prev.filetype=='docx' || prev.filetype=='xlsx' || prev.filetype=='xls'">
                                    <span class="close-upload-p-btn"><i ng-click="remove($index);" class="fa fa-trash" aria-hidden="true"></i></span>
									<i class="far fa-file"></i>
                                </div>
                                <div ng-show="prev.filetype=='mp4' || prev.filetype=='mp3' || prev.filetype=='3gp' || prev.filetype=='3gpp' || prev.filetype=='avi' || prev.filetype=='flv'  || prev.filetype=='wmv' || prev.filetype=='mov' || prev.filetype=='mkv'">
                                <span class="close-upload-p-btn"><i ng-click="remove($index);" class="fa fa-trash" aria-hidden="true"></i></span>
								<i class="far fa-file-video"></i>
                               <!-- <video width="320" height="240" controls>
                                <source src="{{prev.file}}" type="video/mp4">
                                <source src="{{prev.file}}" type="video/3gp">
                                <source src="{{prev.file}}" type="video/3gpp">
                                <source src="{{prev.file}}" type="video/avi">
                                <source src="{{prev.file}}" type="video/flv">
                                <source src="{{prev.file}}" type="video/flv">
                                <source src="{{prev.file}}" type="video/mov">
                                <source src="{{prev.file}}" type="video/mkv">
                                Your browser does not support the video tag.
                                </video>-->
                                </div>
                                
								</li>
								<!--<li>
									<span class="close-upload-p-btn"><i class="fa fa-trash" aria-hidden="true"></i></span>
									<i class="far fa-file-video"></i>
								</li>
								<li>
									<span class="close-upload-p-btn"><i class="fa fa-trash" aria-hidden="true"></i></span>
									<i class="far fa-file-image"></i>
								</li>
								<li>
									<span class="close-upload-p-btn"><i class="fa fa-trash" aria-hidden="true"></i></span>
									<i class="far fa-file-audio"></i>
								</li>
								<li>
									<span class="close-upload-p-btn"><i class="fa fa-trash" aria-hidden="true"></i></span>
									<i class="far fa-file-archive"></i>
								</li>
								<li>
									<span class="close-upload-p-btn"><i class="fa fa-trash" aria-hidden="true"></i></span>
									<i class="far fa-file"></i>
								</li>-->
								
							</ul>
						</div>
                            <div class="wrap" id="isDivFocus">
                            <form>
							
                            <input type="text" ng-submit="sendMessage();" ng-model="message" placeholder="Write your message..." />
                           
                            <span class="file-btn-msg"><input type="file" id="pic" ng-model="photo" multiple type="file" onchange="angular.element(this).scope().SelectFile(event)"/></span>
                            <button ng-disabled="isMsg==1" ng-click="sendMessage();" class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
<!-- Row end -->
</div>
<!-- END: .main-content -->
</div>
<!-- END: .app-main -->