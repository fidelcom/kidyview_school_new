<!-- BEGIN .app-main -->
<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
                <div class="page-icon">
                    <i class="icon-streetview"></i>
                </div>
                <div class="page-title">
                    <h5>Notifications</h5>
                </div>
            </div>
            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                <div class="right-actions">
                    <!-- <a href="add-driver.html" class="btn btn-primary"> <i class="icon-plus2"></i> Add Driver/Device</a> -->
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
            <div class="text-right mb-3" ng-if="notificationData.length>0">
                <a class="btn btn-primary" href="javascript:void(0);" ng-click="deleteNotification();">Clear Notification</a>
            </div>
            <hr class="mb-4" />
            <div class="media overflow-scroll media-notification" ng-repeat="notification in notificationData" ng-if="notificationData.length>0">
                <div class="media-body">
                        <h5 class="mt-0 media-heading"><span class="date">{{notification.created_on}}</span></h5>
                        <p>
                    <a href="#!/{{notification.senderUrl}}"><span class="NameChart">{{notification.iconText}}</span></a>
                    <a href="#!/{{notification.url}}" ng-click="updateNotification(notification.id);"><span ng-class="{'is-unread':notification.is_read==0}">{{notification.message}}</span></a></p>
                    </a>
                </div>
            </div>
            <div class="media overflow-scroll media-notification" ng-if="notificationData.length==0">
                No record.
            </div>
        </div>
    </div>
    <!-- Row end -->
</div>
<!-- END: .main-content -->
</div>
<!-- END: .app-main -->