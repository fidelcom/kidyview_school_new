<!-- start sidebar -->
<aside class="app-side" id="app-side">
                <div class="side-content ">
                    <!-- user profile -->
                    <div class="user-profile">
                            <?php if($STUDENTDATA->childphoto!=''){?>
							<img src="<?php echo base_url(); ?>img/child/<?php echo $STUDENTDATA->childphoto;?>" class="profile-thumb addPic" alt="User Thumb">
                            <h6 class="profile-name"><?php echo $STUDENTDATA->childfname;?></h6>
							<?php }else{?>
								<img class="avatar addPic" src="<?= base_url(); ?>img/default-profilePic.png" alt="" />
							<?php }?>
                        
                        <div class="dept-position"><?php echo $STUDENTDATA->school_name;?></div>
                        <div class="child-session"><?php echo $STUDENTDATA->academicsession;?></div>
                        <ul class="profile-actions">
                            <li class=" ">
                                <a href="#">
                                    <i class="icon-notifications_none"></i>
                                </a>
                            </li>
                            <li class="">
                                <a href="#">
                                    <i class="icon-person_outline"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="icon-log-out"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- sidebar navigation -->
                    <nav class="side-nav">
                        <ul class="unifyMenu customScroll" id="unifyMenu">
                            <li class="active selected">
                                <a href="#!/" aria-expanded="false">
                                    <span class="has-icon">
                                        <i class="icon-laptop_windows"></i>
                                    </span>
                                    <span class="nav-title">Dashboard</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="#" class="has-arrow" aria-expanded="false">
                                    <span class="has-icon">
                                        <i class="icon-edit"></i>
                                    </span>
                                    <span class="nav-title">Assessment</span>
                                </a>
                                <ul aria-expanded="false" class="collapse" style="">
                                <li>
										<a href="#" class="has-arrow" aria-expanded="false">
											<span class="has-icon">
												<i class="far fa-file-alt"></i>
											</span>
											<span class="nav-title">Assignments</span>
										</a>
										<ul aria-expanded="false" class="collapse" style="">
                                        <li><a href="#!/assignment-list">List of assignments</a></li>
                                        <li><a href="#!/submit-assignment-list">Submitted Assignments</a></li>
										</ul>
									</li>
                                    <li>
										<a href="#!/exam-list" class="nav-title" aria-expanded="false">
											<span class="has-icon">
												<i class="fas fa-book"></i>
											</span>
											<span class="nav-title">Exam & Test</span>
										</a>
										<!--<ul aria-expanded="false" class="collapse" style="">
                                        <li><a class="menu-link" href="#!/exam-list">List of exam & test</a></li>
                                        <li><a class="menu-link" href="#!/submitted-exam-list">Submitted Exam & test</a></li>
										</ul>-->
									</li>
                                    <li>
										<a href="#" class="has-arrow" aria-expanded="false">
											<span class="has-icon">
												<i class="fas fa-tasks"></i>
											</span>
											<span class="nav-title">Projects</span>
										</a>
										<ul aria-expanded="false" class="collapse" style="">
                                        <li><a href="#!/project-list">List of projects</a></li>
                                        <li><a href="#!/submit-project-list">Submitted Projects</a></li>
										</ul>
									</li>
                                </ul>
                            </li>
                            <!--<li class="">
                                <a href="#" aria-expanded="false">
                                    <span class="has-icon">
                                        <i class="far fa-file-alt"></i>
                                    </span>
                                    <span class="nav-title">Assignments</span>
                                </a>
                                <ul aria-expanded="false" class="collapse" style="">
                                    <li><a href="#!/assignment-list">List of assignments</a></li>
                                    <li><a href="#!/submit-assignment-list">Submitted Assignments</a></li>
                          
                                </ul>
                            </li>-->
                            <li class="">
                                <a href="#!/calendar-list" aria-expanded="false">
                                    <span class="has-icon">
                                        <i class="far fa-calendar"></i>
                                    </span>
                                    <span class="nav-title">Calendar</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="#!/class-schedule" aria-expanded="false">
                                    <span class="has-icon">
                                        <i class="icon-calendar"></i>
                                    </span>
                                    <span class="nav-title">Class Schedule</span>
                                </a>
                            </li>
							<li class="">
                                <a href="#!/classboard-list" aria-expanded="false">
                                    <span class="has-icon">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                    </span>
                                    <span class="nav-title">Class Board</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="#" aria-expanded="false">
                                    <span class="has-icon">
                                        <i class="far fa-user"></i>
                                    </span>
                                    <span class="nav-title">People</span>
                                </a>
                                <ul aria-expanded="false" class="collapse" style="">
                                    <li><a href="#!/teacher-list"> <span class="has-icon">
                                        <i class="fas fa-user-tie"></i>
                                    </span> Teachers</a></li>
                                    <li><a href="#!/student-list"><span class="has-icon">
                                        <i class="fas fa-user-graduate"></i>
                                    </span> Students</a></li>
                          
                                </ul>
                            </li>
							<!--<li class="">
                                <a href="#!/teacher-list" aria-expanded="false">
                                    <span class="has-icon">
                                        <i class="fas fa-user-tie"></i>
                                    </span>
                                    <span class="nav-title">Teacher</span>
                                </a>
                            </li>
							<li class="">
                                <a href="#!/student-list" aria-expanded="false">
                                    <span class="has-icon">
                                        <i class="fas fa-user-graduate"></i>
                                    </span>
                                    <span class="nav-title">Students</span>
                                </a>
                            </li>-->
                            <li class="">
                                <a href="#!/message-list" aria-expanded="false">
                                    <span class="has-icon">
                                        <i class="fas fa-comment-dots"></i>
                                    </span>
                                    <span class="nav-title">Chat</span>
                                </a>
                            </li>
                            <li class="">
                                <a class="menu-link" href="#!/result" aria-expanded="false">
                                    <span class="has-icon">
                                        <i class="fa fa-list-alt"></i>
                                    </span>
                                    <span class="nav-title">Result</span>
                                </a>
                            </li>
                            <li class="">
                                <a class="menu-link" href="#!/note-list" aria-expanded="false">
                                    <span class="has-icon">
                                    <i class="fa fa-sticky-note"></i>
                                    </span>
                                    <span class="nav-title">Lesson & Notes</span>
                                </a>
                            </li>
                            <!--<li class="">
                                <a href="#!/exam-list" aria-expanded="false">
                                    <span class="has-icon">
                                    <i class="fas fa-book"></i>
                                    </span>
                                    <span class="nav-title">Exam</span>
                                </a>
                            </li>-->
                            <li class="">
                                <a href="#!/goals" aria-expanded="false">
                                    <span class="has-icon">
                                    <i class="fas fa-crosshairs"></i>
                                    </span>
                                    <span class="nav-title">Goals & Earned Points</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="#!/gifts" aria-expanded="false">
                                    <span class="has-icon">
                                    <i class="fas fa-gift"></i>
                                    </span>
                                    <span class="nav-title">Gifts</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="#!/faqs" aria-expanded="false">
                                    <span class="has-icon">
                                    <i class="fas fa-question-circle"></i>
                                    </span>
                                    <span class="nav-title">FAQs</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="#" aria-expanded="false">
                                    <span class="has-icon">
                                        <i class="fa fa-cogs"></i>
                                    </span>
                                    <span class="nav-title">Settings</span>
                                </a>
                                <ul aria-expanded="false" class="collapse" style="">
                                    <li><a href="#!/notification-settings"> <span class="has-icon">
                                        <i class="fa fa-bell-o"></i>
                                    </span> Notifications</a></li>
                          
                                </ul>
                            </li>
                            
                        </ul>
                        <!-- END: side-nav-content -->
                    </nav>
                    <!-- END: .side-nav -->
                </div>
                <!-- END: .side-content -->
            </aside>
            <!-- END: .app-side -->