<!-- start sidebar -->
<aside class="app-side" id="app-side">
                <div class="side-content ">
                    <!-- user profile -->
                    <div class="user-profile">

                        <img src="<?php echo base_url(); ?>img/teacher/<?php echo $TEACHERDATA->teacherphoto;?>" class="profile-thumb" alt="User Thumb">
                        <h6 class="profile-name"><?php echo $TEACHERDATA->teacherfname;?></h6>
                        <div class="dept-position"><?php echo $TEACHERDATA->school_name;?></div>
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
                    <!-- sidebar navigation -->
                    <nav class="side-nav">
                        <ul class="unifyMenu customScroll" id="unifyMenu">
                            <li class="active selected">
                                <a class="menu-link" href="#!/" aria-expanded="false">
                                    <span class="has-icon">
                                        <i class="icon-laptop_windows"></i>
                                    </span>
                                    <span class="nav-title">Dashboard</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="#" class="has-arrow" aria-expanded="false">
                                    <span class="has-icon">
                                        <i class="far fa-file-alt"></i>
                                    </span>
                                    <span class="nav-title">Assignments</span>
                                </a>
                                <ul aria-expanded="false" class="collapse" style="">
                                    <li><a class="menu-link" href="#!/assignment-list">List of Assignments</a></li>
                                    <li><a class="menu-link" href="#!/submitted-assignment-list">Submitted Assignments</a></li>
                                </ul>
                            </li>
                            <li class="">
                                <a class="menu-link" href="#!/calendar-list" aria-expanded="false">
                                    <span class="has-icon">
                                        <i class="far fa-calendar"></i>
                                    </span>
                                    <span class="nav-title">Calendar</span>
                                </a>
                            </li>
                            <li class="">
                                <a class="menu-link" href="#!/class-schedule" aria-expanded="false">
                                    <span class="has-icon">
                                        <i class="icon-calendar"></i>
                                    </span>
                                    <span class="nav-title">Class Schedule</span>
                                </a>
                            </li>
                            <li class="">
                                <a class="menu-link" href="#!/classboard-list" aria-expanded="false">
                                    <span class="has-icon">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                    </span>
                                    <span class="nav-title">Class Board</span>
                                </a>
                            </li>
                            <li class="">
                                <a class="menu-link" href="#!/student-list" aria-expanded="false">
                                    <span class="has-icon">
                                        <i class="fas fa-user-graduate"></i>
                                    </span>
                                    <span class="nav-title">Student Listing</span>
                                </a>
                            </li>
                            <li class="">
                                <a class="menu-link" href="#" aria-expanded="false">
                                    <span class="has-icon">
                                        <i class="fas fa-book"></i>
                                    </span>
                                    <span class="nav-title">Exam</span>
                                </a>
                                <ul aria-expanded="false" class="collapse" style="">
                                    <li><a class="menu-link" href="#!/exam-list">List of exam</a></li>
                                    <li><a class="menu-link" href="#!/submitted-exam-list">Submitted Exam</a></li>
                          
                                </ul>
                            </li>
                            <li class="">
                                <a class="menu-link" href="#!/message-list" aria-expanded="false">
                                    <span class="has-icon">
                                        <i class="fas fa-comment-dots"></i>
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