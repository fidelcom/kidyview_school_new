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
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5">
					<div class="right-actions">
						<a href="#!/compose-message" class="btn btn-primary"> <i class="icon-plus2"></i> New Message</a>
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
							<div class="col-md-6">
								<div class="form-group">
									<label>Search</label>
									<input type="text" ng-model="search" class="form-control" placeholder="Search">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="search">items per page:</label>
									<input type="number" min="1" max="100" class="form-control" ng-model="pageSize">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="inbox-body">
							<div class="inbox-header">
								<div class="mail-option no-pad-left">
									<ul>
										<li>list of user</li>
									</ul>
								</div>
							</div>
							<div class="no-pad table-responsive white-space-nowrap">
								<table class="table table-inbox table-hover">
									<thead>
										<tr>
											<th>Sender</th>
											<th>Reciever</th>
											<th>Last Message</th>
											<th>Time</th>
										</tr>
									</thead>
									<tbody>
										<tr class="unread" dir-paginate="message in messageList|filter:search|itemsPerPage:pageSize">
											<td>    
                                                                                                  
                                                                                                <a href="#!/all-conversation/{{message.messageID}}">
												<span  class="avatar">
												<img ng-show="message.last_message.senderDetails.photo != '' && message.last_message.senderDetails.user_type == 'Teacher'" src="<?= base_url(); ?>img/teacher/{{message.last_message.senderDetails.photo}}">
												<img ng-show="message.last_message.senderDetails.photo != '' && message.last_message.senderDetails.user_type == 'School Admin'" src="<?= base_url(); ?>img/school/{{message.last_message.senderDetails.photo}}">
                                                                                                <img ng-show="message.last_message.senderDetails.photo != '' && message.last_message.senderDetails.user_type == 'Parent'" src="<?= base_url(); ?>img/parent/{{message.last_message.senderDetails.photo}}">
                                                                                                <img ng-show="message.last_message.senderDetails.photo != '' && message.last_message.senderDetails.user_type == 'Student'" src="<?= base_url(); ?>img/child/{{message.last_message.senderDetails.photo}}">
                                                                                                <img ng-show="message.last_message.senderDetails.photo != '' && message.last_message.senderDetails.user_type == 'School'" src="<?= base_url(); ?>img/school/{{message.last_message.senderDetails.photo}}">
												<img ng-show="message.last_message.senderDetails.photo == ''" src="<?= base_url(); ?>img/article/noImage.png">
												</span>
												<span class="view-message  dont-show">{{message.last_message.senderDetails.fname}} {{message.last_message.senderDetails.lname}}</span>
                                                                                            </a>
                                                                                        </td>
											<td>
                                                                                               
                                                                                                <a href="#!/all-conversation/{{message.messageID}}">
												<span class="avatar">
												<img ng-show="message.last_message.recieverDetails.photo != '' && message.last_message.recieverDetails.user_type == 'Teacher'" src="<?= base_url(); ?>img/teacher/{{message.last_message.recieverDetails.photo}}">
												<img ng-show="message.last_message.recieverDetails.photo != '' && message.last_message.recieverDetails.user_type == 'School Admin'" src="<?= base_url(); ?>img/school/{{message.last_message.recieverDetails.photo}}">
                                                                                                <img ng-show="message.last_message.recieverDetails.photo != '' && message.last_message.recieverDetails.user_type == 'Parent'" src="<?= base_url(); ?>img/parent/{{message.last_message.recieverDetails.photo}}">
												<img ng-show="message.last_message.recieverDetails.photo != '' && message.last_message.recieverDetails.user_type == 'Student'" src="<?= base_url(); ?>img/child/{{message.last_message.recieverDetails.photo}}">
                                                                                                <img ng-show="message.last_message.recieverDetails.photo != '' && message.last_message.recieverDetails.user_type == 'School'" src="<?= base_url(); ?>img/school/{{message.last_message.recieverDetails.photo}}">
                                                                                                <img ng-show="message.last_message.recieverDetails.photo == ''" src="<?= base_url(); ?>img/article/noImage.png">
												</span>
                                                                                            
												<span class="view-message  dont-show">{{message.last_message.recieverDetails.fname}} {{message.last_message.recieverDetails.lname}}</span>
                                                                                                </a>
                                                                                                </td>
											<td class="view-message"><a href="#!/all-conversation/{{message.messageID}}">{{message.last_message.message}}</a></td>
											<td class="view-message"><a href="#!/all-conversation/{{message.messageID}}">{{message.last_message.time_elapsed}}</a></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<dir-pagination-controls
		max-size="10" class="mt-3 mb-5 mb-5 float-left"
		direction-links="true"
		boundary-links="true">
		</dir-pagination-controls>
		<dir-pagination-controls
		max-size="10"
		direction-links="true" class=" mt-3 mb-5 float-right display_nmbr"
		boundary-links="true"
		template-url="asset/js/dirPagination.tpl.html">
		</dir-pagination-controls>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->