<?php 
	$adminDetail 	= $this->session->userdata();
	$adminName 		= $adminDetail['user_data']['full_Name'];
	$adminPhoto 	= $adminDetail['user_data']['photo'];
	
?>
<div class="side-content ">
<!-- user profile -->
<div class="user-profile">
<?php if($this->session->userdata('user_role')=='admin'){?>
<img src="<?php echo base_url(); ?>img/admin/<?php echo $adminPhoto; ?>" class="profile-thumb profileImageHeader" alt="User Thumb" />
<?php }elseif($this->session->userdata('user_role')=='adminsubadmin'){ ?>
<img src="<?php echo base_url(); ?>img/school/subadmin/<?php echo $adminPhoto; ?>" class="profile-thumb profileImageHeader" alt="User Thumb" />
<?php } ?>
	<h6 class="profile-name username"><?php echo $adminName; ?></h6>
	<div class="dept-position">
	<?php if($this->session->userdata('user_role')=='admin'){
		echo "Admin";
	}else{
		echo "Sub Admin";
	}
	?>
	</div>
	<ul class="profile-actions">
		<li class=" ">
			<a href="javascript:void0;">
			<i class="icon-notifications_none"></i>
			</a>
		</li>
		<li class="">
			<a href="javascript:void0;">
			<i class="icon-person_outline"></i>
			</a>
		</li>
		<li>
			<a href="javascript:void0;">
			<i class="icon-log-out"></i>
			</a>
		</li>
	</ul>
</div>
<!-- sidebar navigation -->
<nav class="side-nav">
	<ul class="unifyMenu customScroll" id="unifyMenu">
		<li class="active selected">
			<a href="#!/dashboard" aria-expanded="false">
			<span class="has-icon">
				<i class="icon-laptop_windows"></i>
			</span>
			<span class="nav-title">Dashboard</span>
			</a>
		</li>
		<?php if($ALLPRIVILEGE['SchoolManagement']['module']==1 || $ALLPRIVILEGE['ParentListing']['module']==1 || $ALLPRIVILEGE['TeacherListing']['module']==1 || $ALLPRIVILEGE['DriverListing']['module']==1 || $ALLPRIVILEGE['SuperSubAdmin']['module']==1){?>
		<li>
			<a class="has-arrow" aria-expanded="false" href="JavaScript:Void(0);">
			
			<span class="has-icon">
				<i class="icon-briefcase"></i>
			</span>
			<span class="nav-title">User Management</span>
			</a>
			<ul aria-expanded="false" class="collapse">
			<?php if($ALLPRIVILEGE['SchoolManagement']['module']==1){?>
				<li>
					<a href="#!/school-list" aria-expanded="false">
					School Management
					</a>
				</li>
			<?php }if($ALLPRIVILEGE['TeacherListing']['module']==1){?>
				<li>
				<a href="#!/teacher-list" aria-expanded="false">
					Teacher Management
				</a>
				</li>
				<?php }if($ALLPRIVILEGE['DriverListing']['module']==1){?>
				<li>
				<a href="#!/driver-list" aria-expanded="false">
					Driver Management
				</a>
				</li>
				<?php }if($ALLPRIVILEGE['ParentListing']['module']==1){?>
				<li>
				<a href="#!/parent-list" aria-expanded="false">
					Parent Listings
				</a>
				</li>
				<?php }if($ALLPRIVILEGE['SuperSubAdmin']['module']==1){?>
				<li><a href="#!subadmin-list">Super Sub Admin</a></li>
				<?php } ?>
			</ul>
			
		</li>
		<?php }if($ALLPRIVILEGE['RoleManagement']['module']==1 || $ALLPRIVILEGE['PrivilegeManagement']['module']==1){?>
		<li>
			<a class="has-arrow" aria-expanded="false" href="JavaScript:Void(0);">
			
			<span class="has-icon">
				<i class="icon-briefcase"></i>
			</span>
			<span class="nav-title">Role Management</span>
			</a>
			<ul aria-expanded="false" class="collapse">
			<?php if($ALLPRIVILEGE['RoleManagement']['module']==1){?>
				<li>
					<a href="#!/role-list" aria-expanded="false">
					Role
					</a>
				</li>
				<?php }if($ALLPRIVILEGE['PrivilegeManagement']['module']==1){?>
				<li>
					<a href="#!/privilege-list" aria-expanded="false">
					Privilege
					</a>
				</li>
				<?php } ?>
			</ul>
		</li>
		<?php }if($ALLPRIVILEGE['SubscriptionManagement']['module']==1){?>
			<li>
                <a class="has-arrow" aria-expanded="false" href="JavaScript:Void(0);">

                    <span class="has-icon">
                        <i class="icon-subscriptions"></i>
                    </span>
                    <span class="nav-title">Subscription Management</span>
                </a>
                <ul aria-expanded="false" class="collapse">
                    <li>
                        <a href="#!/subscription-list" aria-expanded="false">
                            Manage Subscription
                        </a>
                    </li>
                </ul>

            </li>
		<?php }if($ALLPRIVILEGE['GoalsManagement']['module']==1){?>
		<li>
			<a href="#!/goal-list" aria-expanded="false">
			<span class="has-icon">
				<i class="fas fa-bullseye"></i>
			</span>
			<span class="nav-title">Goals Management</span>
			</a>
		</li>
		<?php }if($ALLPRIVILEGE['GiftManagement']['module']==1){?>
		<li>
			<a href="#!/gift-list" aria-expanded="false">
			<span class="has-icon">
				<i class="fas fa-gift"></i>
			</span>
			<span class="nav-title">Gift Management</span>
			</a>
		</li>
		<?php }if($ALLPRIVILEGE['VoucherManagement']['module']==1){?>
		<li>
			<a href="#!/voucher-list" aria-expanded="false">
			<span class="has-icon">
				<i class="fas fa-gift"></i>
			</span>
			<span class="nav-title">Voucher Management</span>
			</a>
		</li>
		<?php }if($ALLPRIVILEGE['Payment']['module']==1){?>
		<li>
			<a href="javascript:void(0)" aria-expanded="false">
			<span class="has-icon">
				<i class="icon-payment"></i>
			</span>
			<span class="nav-title">Payment</span>
			</a>
		</li>
		<?php } ?>
		<!--<li>
			<a href="javascript:void(0)" aria-expanded="false">
			<span class="has-icon">
				<i class="icon-perm_data_setting"></i>
			</span>
			<span class="nav-title">Customisation </span>
			</a>
		</li>-->
		<?php if($ALLPRIVILEGE['ReportGeneration']['module']==1){?>
		<li>
			<a href="javascript:void(0)" aria-expanded="false">
			<span class="has-icon">
				<i class="icon-book2"></i>
			</span>
			<span class="nav-title">Report Generation</span>
			</a>
		</li>
		<?php }if($ALLPRIVILEGE['CMSManagement']['module']==1){?>
		<!--<li>
			<a href="javascript:void(0)" aria-expanded="false">
			<span class="has-icon">
				<i class="icon-settings_applications"></i>
			</span>
			<span class="nav-title">CMS</span>
			</a>
		</li>-->
		<?php } ?>
		<!--<li>
			<a href="javascript:void(0)" aria-expanded="false">
			<span class="has-icon">
				<i class="icon-drag_handle"></i>
			</span>
			<span class="nav-title">Feedback</span>
			</a>
		</li>-->
		<?php if($ALLPRIVILEGE['Revenues']['module']==1){?>
		<li>
			<a href="javascript:void(0)">
			<span class="has-icon">
				<i class="icon-coin-dollar"></i>
			</span>
			<span class="nav-title">Revenues</span>
			</a>
		</li>
		<?php }if($ALLPRIVILEGE['Notifications']['module']==1){?>
		<li>
			<a class="has-arrow" aria-expanded="false" href="JavaScript:Void(0);">
			<span class="has-icon">
				<i class="icon-settings"></i>
			</span>
			<span class="nav-title">Setting</span>
			</a>
			<ul aria-expanded="false" class="collapse">
			<?php if($ALLPRIVILEGE['FeeCategory']['module']==1){?>
				<li>
					<a href='#!/fees-category' class="current-page">
					<span class="has-icon">
						<i class="icon-notifications_active"></i>
					</span>
					<span class="nav-title">Free Category</span>
					</a>
				</li>
			<?php } if($ALLPRIVILEGE['Notifications']['module']==1){?>
				<li>
					<a href='javascript:void(0)' class="current-page">
					<span class="has-icon">
						<i class="icon-notifications_active"></i>
					</span>
					<span class="nav-title">Notification</span>
					</a>
				</li>
			<?php } if($ALLPRIVILEGE['LoginImage']['module']==1){?>
				<li>
				<a href='#!/login-image' class="current-page">
					<span class="has-icon">
						<i class="icon-log-out"></i>
					</span>
					<span class="nav-title">Login Image</span>
				</a> 
				</li>
			<?php } ?>
			</ul>
		</li>
		<?php } ?>
	</ul>
	<!-- END: side-nav-content -->
</nav>
<!-- END: .side-nav -->
</div>