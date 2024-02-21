<!-- stard app header -->
<header class="app-header">
	<div class="container-fluid">
		<div class="row gutters">
			<div class="col-xl-7 col-lg-7 col-md-7 col-sm-3 col-3">
				<a class="mini-nav-btn" href="javascipt:void(0);" id="app-side-mini-toggler">
					<span class="brandlogo"><img src="<?php echo base_url(); ?>studentasset/img/logo.png" alt="Airo.Life" /></span>
					<i class="icon-menu5"></i>
				</a>
				<a data-target="#app-side" href="javascipt:void(0);" data-toggle="onoffcanvas" class="onoffcanvas-toggler" aria-expanded="true">
					<i class="icon-chevron-thin-right"></i>
				</a>
			</div>
			<div class="col-xl-5 col-lg-5 col-md-5 col-sm-9 col-9	">
				<ul class="header-actions">

					<li class="dropdown">
						<a href="#" id="notifications" data-toggle="dropdown" aria-haspopup="true">
							<i class="icon-notifications_none"></i>
							<span class="count-label">3</span>
						</a>
						<div class="dropdown-menu dropdown-menu-right lg" aria-labelledby="notifications">
							<ul class="imp-notify">
								<li>
									<a href="javascript:void(0);">
										<div class="icon">W</div>
										<div class="details">
											<p><span>Wilson</span> The best Dashboard design I have seen ever.</p>
										</div>
									</a>
								</li>
								<li>
									<a href="javascript:void(0);">
										<div class="icon">J</div>
										<div class="details">
											<p><span>John Smith</span> Jhonny sent you a message. Read now!</p>
										</div>
									</a>
								</li>
								<li>
									<a href="javascript:void(0);">
										<div class="icon secondary">R</div>
										<div class="details">
											<p><span>Justin Mezzell</span> Stella, Added you as a Friend. Accept it!</p>
										</div>
									</a>
								</li>
								<li class="text-center">
									<a class="see-all-link" href="notification_deatil.html">See All</a>
								</li>
							</ul>
						</div>
					</li>
					<li class="dropdown">
						<a href="javascript:void(0);" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
							<?php if($STUDENTDATA->childphoto!=''){?>
							<img class="avatar addPic" src="<?php echo base_url(); ?>img/child/<?php echo $STUDENTDATA->childphoto;?>" alt="" />
							<?php }else{?>
								<img class="avatar addPic" src="<?= base_url(); ?>img/default-profilePic.png" alt="" />
							<?php }?>
							<span class="user-name"><?php echo $STUDENTDATA->childfname;?></span>
							<i class="icon-chevron-small-down"></i>
						</a>
						<div class="dropdown-menu lg dropdown-menu-right" aria-labelledby="userSettings">
							<ul class="user-settings-list">
								<li>
									<a href="#!/student-profile">
										<div class="icon">
											<i class="icon-account_circle"></i>
										</div>
										<p>Profile</p>
									</a>
								</li>
								<li>
									<a href="<?php echo base_url();?>student/logout">
										<div class="icon">
											<i class="icon-log-out"></i>
										</div>
										<p>Logout</p>
									</a>
								</li>
							</ul>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</header>