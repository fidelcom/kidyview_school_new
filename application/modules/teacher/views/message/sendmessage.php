<!-- BEGIN .app-main -->
<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
<div class="container-fluid">
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 align-self-center">
        <div class="page-icon">
        <a href="#!/message-list"> <i class="icon-arrow-back"></i></a>
        </div>
        <div class="page-title">
            <h5>New Chat</h5>
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
            <div class="inbox-body">
                <div class="mail-list">
                    <div class="compose-mail">
                    <div class="error" ng-show="errormsg">{{errormsg}}</div>
                        <form>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 mb-2">
                                    <div class="form-group">
                                        <select class="form-control" ng-model="usertype" ng-change="getUser();">
                                            <option value="{{usertype.value}}" ng-repeat="usertype in usertypeData">{{usertype.label}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 mb-2">
                                <div ng-dropdown-multiselect="" options="userData" selected-model="user" checkboxes="true" extra-settings="setting1"></div>
                                    <!--<div class="form-group select_mutli">
                                        <select multiple="multiple" ng-model="user">
                                            <option value="{{user.id}}" ng-repeat="user in userData">{{user.name}}</option>
                                        </select>
                                    </div>-->
                                </div>
                            </div>
                
                            <div class="form-group mt-2">
                                <textarea class="form-control" ng-model="message" placeholder="Message"></textarea>
                            </div>
                            <div class="col-md-12 prev-section mt-2" ng-repeat="prev in PreviewImage">
							<div class="row">
							<div class="col-md-12 fpUploadImg">
							<i class="icon-trash2" ng-click="remove($index);"></i>
							<div class="upload-preview-box">{{prev.name}}</div>
							</div>
							</div>
							</div>
                            <div class=" mt-4 ">
                                <div class="btn-group send_btn">
                                    <button ng-click="sendMessage();" class="btn btn-primary btn-sm mr-3"><i class="fa fa-check"></i> Send</button>
                                    <a href="#!/message-list" class="btn btn-sm btn-default"><i class="fa fa-times"></i> Discard</a>
                                
                                </div>
                                <div class="add-attach uploadlogo ml-4">
                                    <span>
                                    <input class="files file-upload ng-pristine ng-valid ng-not-empty ng-touched" id="pic" ng-model="photo" multiple accept="image/png, image/jpeg, application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,audio/*,video/*" type="file" onchange="angular.element(this).scope().SelectFile(event)">
                                    <i class="icon-attachment4"></i>
                                    </span>
                                </div>
                                
                            </div>
                            <div ng-show="showLoader==1">
                                <div class="loader-bx-container">
                                <div class="loader-bx"></div>
                                </div>
                                </div>
                        </form>
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