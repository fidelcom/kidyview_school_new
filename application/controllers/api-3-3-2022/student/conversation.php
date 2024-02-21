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
                            <img ng-show="conversationData.user_type=='Teacher'" src="<?php echo base_url();?>img/teacher/{{conversationData.user_detail.photo}}" alt="{{converation.user_detail.fname}}" />
                                    <img ng-show="conversationData.user_type=='Student'" src="<?php echo base_url();?>img/child/{{conversationData.user_detail.photo}}" alt="{{converation.user_detail.fname}}" />    
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
                                <button class="dropdown-item" type="button">Delete</button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                
                <div id="frame">
                    <div class="content">
                        <div class="messages">
                            <ul>
                                <li class="sent" ng-show="converation.message_type=='recieved'" ng-repeat="converation in conversationData.conversation track by $index">
                                    {{converation.message_type}}
                                    <img ng-show="converation.user_type=='Teacher'" src="<?php echo base_url();?>img/teacher/{{conversationData.user_detail.photo}}" alt="{{converation.user_detail.fname}}" />
                                    <img ng-show="converation.user_type=='Student'" src="<?php echo base_url();?>img/child/{{conversationData.user_detail.photo}}" alt="{{converation.user_detail.fname}}" />    
                                    <div class="txt-msg-box">
                                        <div class="msg-content-m">
                                            <p>{{converation.message}}</p>
                                        </div>
                                        <div class="msg-time-blk">{{converation.time_elapsed}}</div>
                                    </div>
                                </li>
                                <li class="replies" ng-show="converation.message_type=='send'" ng-repeat="converation in conversationData.conversation track by $index">
                                <img ng-show="converation.user_type=='Teacher'" src="<?php echo base_url();?>img/teacher/{{conversationData.user_detail.photo}}" alt="{{converation.user_detail.fname}}" />
                                <img ng-show="converation.user_type=='Student'" src="<?php echo base_url();?>img/child/{{conversationData.user_detail.photo}}" alt="{{converation.user_detail.fname}}" />    
                                <div class="txt-msg-box">
                                        <div class="msg-content-m">
                                            <p>{{converation.message}}</p>
                                        </div>
                                        <div class="msg-time-blk">{{converation.time_elapsed}}</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="message-input">
                            <div class="wrap">
                            <input type="text" ng-model="message" placeholder="Write your message..." />
                            <span class="file-btn-msg"><input type="file" /></span>
                            <button ng-click="sendMessage();" class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
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