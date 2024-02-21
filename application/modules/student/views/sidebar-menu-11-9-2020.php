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
                            </li>
                            <li class="">
                                <a href="#!/calendar-list" aria-expanded="false">
                                    <span class="has-icon">
                                        <i class="fas fa-book"></i>
                                    </span>
                                    <span class="nav-title">Calendar</span>
                                </a>
                            </li>
							<li class="">
                                <a href="#!/classboard-list" aria-expanded="false">
                                    <span class="has-icon">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                    </span>
                                    <span class="nav-title">Classe Board</span>
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
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <span class="nav-title">Chat</span>
                                </a>
                            </li>
                        </ul>
                        <!-- END: side-nav-content -->
                    </nav>
                    <!-- END: .side-nav -->
                </div>
                <!-- END: .side-content -->
            </aside>
            <!-- END: .app-side -->