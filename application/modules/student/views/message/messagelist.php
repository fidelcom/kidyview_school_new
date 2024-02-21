<!-- BEGIN .app-main -->
<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
<div class="container-fluid">
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 align-self-center">
<div class="page-icon">
<i class="fas fa-envelope"></i>
</div>
<div class="page-title">
<h5>Chat list</h5>
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
    
    </div>
    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
        <div class="right-actions float-right">
            <a href="#!/send-message" class="btn btn-primary btn-sm"> <i class="icon-plus2"></i> New Chat</a>
        </div>
    </div>
</div>

</div>
<div class="col-md-12 col-sm-12 col-xs-12">
    
    <div class="no-pad table-responsive">
        <table datatable="ng" class="table table-striped table-bordered table-responsive">
				<thead>
					<tr>
						<th>Sr. No.</th>
						<th>Sender Image</th>
                        <th>Sender Name</th>
						<th>Message</th>
                        <th>Time</th>
						<th class="text-right">Action</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="message in messageData">
						<td>{{$index+1}}</td>
						<td>
                        <a ng-show="message.user_type=='Student'" href="#!conversation/{{message.userID}}" class="avatar">
                            <img ng-show="message.photo!=''" src="<?php echo base_url();?>img/child/{{message.photo}}" alt="user">
                            <img ng-show="message.photo==''" src="<?php echo base_url();?>img/noImage.png" alt="user">
                        </a>
                        <a ng-show="message.user_type=='Teacher'" href="#!conversation/{{message.userID}}" class="avatar">
                            <img ng-show="message.photo!=''" src="<?php echo base_url();?>img/teacher/{{message.photo}}" alt="user">
                            <img ng-show="message.photo==''" src="<?php echo base_url();?>img/noImage.png" alt="user">
                        </a>
                        </td>
                        <td>
                        <a href="#!conversation/{{message.userID}}">{{message.fname+' '+message.lname}}</a>
                        </td>
						<td>
                       <a href="#!conversation/{{message.userID}}">
                       <div ng-show="message.last_message.message!=''">{{message.last_message.message}}</div>
                       <div ng-show="message.last_message.message==''"><i class="fa fa-file" aria-hidden="true"></i></div>
                       </a>
                        </td>
						<td><a href="#!conversation/{{message.userID}}">{{message.last_message.time_elapsed}}</a></td>
						<td class="action text-right">
                        <a ng-click="deleteMessage(message.id);"><i class="icon-trash2"></i></a>
						</td>
					</tr>
					
				</tbody>
			</table>
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