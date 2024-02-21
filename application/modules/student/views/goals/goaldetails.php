<!-- BEGIN .app-main -->
<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 d-flex">
            <div class="page-icon">
            <i class="fas fa-gift"></i>
            </div>
            <div class="page-title align-self-center ml-3">
                <h5>Goals & Points Earned</h5>
            </div>
        </div>
    </div>
</div>
</header>
<!-- END: .main-heading -->

<!-- BEGIN .main-content -->
<div class="main-content">
<div class="row same-height-card">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card dataTables_wrapper">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-7">
                        <h4 class="mt-1">{{goalinfo.title}}</h4>
                    </div>
                    <div class="col-md-5 text-md-right">
                        <h5 class="mt-2 text-danger">{{goalinfo.status}}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-3">
                        <span class="text-mdm">Date of completion</span>
                    </div>
                    <div class="col-md-7">
                    {{goalinfo.completion_date|myDate}}
                    </div>
                </div>
                <!--<div class="row mb-2">
                    <div class="col-md-3">
                        <span class="text-mdm">Timeline</span>
                    </div>
                    <div class="col-md-7">
                        ---
                    </div>
                </div>-->
                <div class="row mb-2">
                    <div class="col-md-3">
                        <span class="text-mdm">Points</span>
                    </div>
                    <div class="col-md-7">
                    {{goalinfo.points}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3">
                        <span class="text-mdm">Created By</span>
                    </div>
                    <div class="col-md-7">
                    {{goalinfo.user_type}}
                    </div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-md-3">
                        <span class="text-mdm">Attachment</span>
                    </div>
                    <div class="col-md-3" ng-repeat="attachment in goalinfo.attachment" ng-show="goalinfo.attachment.length>0">
                    <div ng-show="attachment.filetype=='jpeg' || attachment.filetype=='jpg' || attachment.filetype=='png'">
                        <a target="_blank" href="<?php echo base_url();?>img/goal/{{attachment.file}}">
                        <img class="img-fluid" src="<?php echo base_url();?>img/goal/{{attachment.file}}" />
                        </a>
                    </div>
                    <div ng-show="attachment.filetype=='pdf' || attachment.filetype=='doc' || attachment.filetype=='docx'  || attachment.filetype=='xlsx' || attachment.filetype=='xls'">
                         <a href="<?php echo base_url();?>img/goal/{{attachment.file}}" download="{{attachment.file}}"><i class="far fa-file"></i> {{attachment.file}}</a>
                    </div>
                </div>
                <div class="col-md-3" ng-show="goalinfo.attachment.length==0">
                    No attachment added.
                </div>
                </div>
                <div class="row mb-2">
                <div class="col-md-3">
                        <span class="text-mdm">Description</span>
                    </div>
                    <div class="col-md-7">
                       {{goalinfo.description}}
                    </div>
                </div>
                
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <a class="btn btn-secondary" href="#!/goals">Back To List</a>
            </div>
        </div>
    </div>
</div>
<!-- Row end -->
</div>
<!-- END: .main-content -->
</div>
<!-- END: .app-main -->