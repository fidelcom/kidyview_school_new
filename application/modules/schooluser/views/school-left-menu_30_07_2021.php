<?php
$schoolDetail = $this->session->all_userdata();
if($this->session->userdata('user_role')=='school'){
    $schoolID = $schoolDetail['user_data']['id'];
}elseif($this->session->userdata('user_role')=='schoolsubadmin'){
    $schoolID = $schoolDetail['user_data']['school_id'];
}
$schoolPhoto = $schoolDetail['user_data']['pic'];
$schoolName = $schoolDetail['user_data']['school_name'];
$schoolEmail = $schoolDetail['user_data']['email'];
?>
<div class="side-content ">
<!-- user profile -->
<div class="user-profile">
    <?php $profilePic =  !empty($schoolPhoto) ? $schoolPhoto : 'default-profilePic.png'; ?>
   
    <?php if($this->session->userdata('user_role')=='school'){?>
    <img src="<?php echo base_url(); ?>img/school/<?php echo $profilePic; ?>" class="profile-thumb profileImageHeader" alt="User Thumb">
    <?php }elseif($this->session->userdata('user_role')=='schoolsubadmin'){ ?>
    <img src="<?php echo base_url(); ?>img/school/subadmin/<?php echo $profilePic; ?>" class="profile-thumb profileImageHeader" alt="User Thumb">
    <?php } ?>
    
    <h6 class="profile-name username"><?php echo $schoolName; ?></h6>
    <div class="dept-position">
    <?php if($this->session->userdata('user_role')=='school'){
        echo "School";
    }elseif($this->session->userdata('user_role')=='schoolsubadmin'){
        echo "Sub Admin";
    }?>
    </div>
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
            <a href="#!/dashboard" aria-expanded="false">
                <span class="has-icon">
                    <i class="icon-laptop_windows"></i>
                </span>
                <span class="nav-title">Dashboard</span>
            </a>
        </li>
        <?php 
		if(isset($ALLPRIVILEGE['Parents']) && $ALLPRIVILEGE['Parents']['module']==1 OR isset($ALLPRIVILEGE['Teacher']) && $ALLPRIVILEGE['Teacher']['module']==1 OR isset($ALLPRIVILEGE['Driver']) && $ALLPRIVILEGE['Driver']['module']==1 OR isset($ALLPRIVILEGE['SubAdmin']) && $ALLPRIVILEGE['SubAdmin']['module']==1){ //prd($ALLPRIVILEGE);?>
        <li class="">
            <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
                <span class="has-icon">
                    <i class="icon-briefcase"></i>
                </span>
                <span class="nav-title">User Management</span>
            </a>
            <ul aria-expanded="false" class="collapse" style="">
            <?php if($ALLPRIVILEGE['Parents']['module']==1){?>
                <li><a href="#!/parent-list">Parents</a></li>
            <?php }if(!isset($ALLPRIVILEGE['Students']) && $ALLPRIVILEGE['Students']['module']!=1){?>
			 <?php }if( $ALLPRIVILEGE['Students']['module']==1){?>
                <li><a href="#!/student-list">Students</a></li>
            <?php }if($ALLPRIVILEGE['Teacher']['module']==1){?>
                <li><a href="#!/teacher-list">Teacher</a></li>
            <?php }if($ALLPRIVILEGE['Driver']['module']==1){?>
                <li><a href="#!/driver-list">Driver</a></li>
            <?php }if($ALLPRIVILEGE['SubAdmin']['module']==1){?>
                <li><a href="#!subadmin-list">Sub Admin</a></li>
            <?php } ?>
            </ul>
        </li>
        <?php }if(isset($ALLPRIVILEGE['Role']) && $ALLPRIVILEGE['Role']['module']==1 OR isset($ALLPRIVILEGE['Privilege']) && $ALLPRIVILEGE['Privilege']['module']==1){?>
        <li class="">
        <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
            <span class="has-icon">
                <i class="icon-tree"></i>
            </span>
            <span class="nav-title">Role Management</span>
        </a>
        <ul aria-expanded="false" class="collapse" style="">
        <?php if($ALLPRIVILEGE['Role']['module']==1){?>
            <li><a href="#!/role-list">Role</a></li>
        <?php }if($ALLPRIVILEGE['Privilege']['module']==1){?> 
            <li><a href="#!/privilege-list">Privilege</a></li>
        <?php } ?>
        </ul>
        </li>
        <?php }if(isset($ALLPRIVILEGE['ClassSchedule']) && $ALLPRIVILEGE['ClassSchedule']['module']==1 OR isset($ALLPRIVILEGE['TimeTable']) && $ALLPRIVILEGE['TimeTable']['module']==1){?>
		 <li class="">
            <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
                <span class="has-icon">
                    <i class="icon-calendar"></i>
                </span>
                <span class="nav-title">Schedule Tasks</span>
            </a>
            <ul aria-expanded="false" class="collapse" style="">
				<?php if($ALLPRIVILEGE['ClassSchedule']['module']==1){?>
                <li><a href="#!/class-schedule">Class Schedule</a></li>
				<?php }if($ALLPRIVILEGE['TimeTable']['module']==1){?>
                <li><a href="#!/time-table">Time Table</a></li>
				<?php } ?>
            </ul>
        </li>
        <?php }if(isset($ALLPRIVILEGE['Events']) && $ALLPRIVILEGE['Events']['module']==1 OR isset($ALLPRIVILEGE['StudentsBirthday']) && $ALLPRIVILEGE["StudentsBirthday"]['module']==1 OR isset($ALLPRIVILEGE['Calendar']) && $ALLPRIVILEGE['Calendar']['module']==1 OR isset($ALLPRIVILEGE['MealPlanner']) && $ALLPRIVILEGE['MealPlanner']['module']==1 OR isset($ALLPRIVILEGE['HomeMeal']) && $ALLPRIVILEGE['HomeMeal']['module']==1 OR isset($ALLPRIVILEGE['HolidayList']) && $ALLPRIVILEGE['HolidayList']['module']==1){?>
        <li class="">
        <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
            <span class="has-icon">
                <i class="icon-calendar"></i>
            </span>
            <span class="nav-title">Calendar</span>
        </a>
        <ul aria-expanded="false" class="collapse" style="">
        <?php if($ALLPRIVILEGE['Events']['module']==1){?> 
            <li><a href="#!/event-list">Events</a></li>
        <?php }if($ALLPRIVILEGE["StudentsBirthday"]['module']==1){?> 
            <li><a href="#!/student-birthday">Student's Birthday</a></li>
        <?php }if($ALLPRIVILEGE['Calendar']['module']==1){?> 
            <li><a href="#!/calendar-list">Calendar</a></li>
            <?php }if($ALLPRIVILEGE['MealPlanner']['module']==1){?> 
            <li><a href="#!/meal-planner">Meal Planner</a></li>
            <?php }if($ALLPRIVILEGE['HomeMeal']['module']==1){
            /*    ?> 
            <li><a href="#!/home-meal">Home Meal</a></li>
            <?php */ }if($ALLPRIVILEGE['HolidayList']['module']==1){?> 
            <li><a href="#!/holiday-list">Holiday List</a></li>
            <?php } ?>
        </ul>
        </li>
        <?php }if(isset($ALLPRIVILEGE['StudentAttendance']) && $ALLPRIVILEGE['StudentAttendance']['module']==1 OR isset($ALLPRIVILEGE['TeacherAttendance']) && $ALLPRIVILEGE['TeacherAttendance']['module']==1 OR isset($ALLPRIVILEGE['SubadminAttendance']) && $ALLPRIVILEGE['SubadminAttendance']['module']==1 OR isset($ALLPRIVILEGE['RequestDayOff']) && $ALLPRIVILEGE['RequestDayOff']['module']==1){?>
        <li class="">
        <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
            <span class="has-icon">
                <i class="icon-address-book"></i>
            </span>
            <span class="nav-title">Attendance</span>
        </a>
        <ul aria-expanded="false" class="collapse" style="">
        <?php if($ALLPRIVILEGE['StudentAttendance']['module']==1){?>
            <li><a href="#!/student-attendance">Student Attendance</a></li>
        <?php }if($ALLPRIVILEGE['TeacherAttendance']['module']==1){?>
            <li><a href="#!/teacher-attendance">Teacher Attendance</a>
        <?php }if($ALLPRIVILEGE['SubadminAttendance']['module']==1){?>
            <!--<li><a href="javascript:void(0);">Subadmin Attendance</a>-->
        <?php }if($ALLPRIVILEGE['RequestDayOff']['module']==1){?>
            <li><a href="#!/request-day-off">Request day off </a></li>
        <?php } ?>
        </ul>
        </li>
        <?php }if(isset($ALLPRIVILEGE['Session']) && $ALLPRIVILEGE['Session']['module']==1 OR isset($ALLPRIVILEGE['Term']) && $ALLPRIVILEGE['Term']['module']==1 OR isset($ALLPRIVILEGE['Class']) && $ALLPRIVILEGE['Class']['module'] OR isset($ALLPRIVILEGE['Subject']) && $ALLPRIVILEGE['Subject']['module']==1 OR isset($ALLPRIVILEGE['Assign']) && $ALLPRIVILEGE['Assign']['module']==1 OR isset($ALLPRIVILEGE['TransferStudents']) && $ALLPRIVILEGE['TransferStudents']['module'] OR isset($ALLPRIVILEGE['Fees']) && $ALLPRIVILEGE['Fees']['module']==1 OR isset($ALLPRIVILEGE['TrackCab']) && $ALLPRIVILEGE['TrackCab']['module']==1 OR isset($ALLPRIVILEGE['Result']) && $ALLPRIVILEGE['Result']['module']==1){?>
        <li class="">
        <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
            <span class="has-icon">
                <i class="icon-display"></i>
            </span>
            <span class="nav-title">Administration</span>
        </a>
        <ul aria-expanded="false" class="collapse" style="">
            <?php if($ALLPRIVILEGE['Session']['module']==1){?>
            <li><a href="#!/session-list">Session</a></li>
            <?php }if($ALLPRIVILEGE['Term']['module']==1){?>
            <li><a href="#!/term-list">Terms</a></li>
            <?php }if($ALLPRIVILEGE['Class']['module']==1){?>
            <li><a href="#!/class-list">Class</a></li>
            <?php }if($ALLPRIVILEGE['Subject']['module']==1){?>
            <li><a href="#!/subject-list">Subject</a></li>
            <?php }if($ALLPRIVILEGE['Assign']['module']==1){?>
            <li><a href="javascript:void(0);">Assign</a></li>
            <?php }if($ALLPRIVILEGE['TransferStudents']['module']==1){?>
            <li><a href="javascript:void(0);">Transfer Students</a></li>
           <!--  <?php }if($ALLPRIVILEGE['Fees']['module']==1){?>
            <li><a href="javascript:void(0);">Fees</a></li> -->
            <?php }if($ALLPRIVILEGE['TrackCab']['module']==1){?>
            <li><a href="javascript:void(0);">Track Cab</a></li>
            <?php }if($ALLPRIVILEGE['Result']['module']==1){?>
            <li><a href="#!/result-list">Result</a></li>
            <?php } ?>
        </ul>
        </li>
        
        <?php } if(isset($ALLPRIVILEGE['Fees']) && $ALLPRIVILEGE['Fees']['module']==1){ //prd($ALLPRIVILEGE); ?>
         <li class="">
        <a href="#!/fees-list" aria-expanded="false">
            <span class="has-icon">
                <i class="icon-wallet"></i>
            </span>
            <span class="nav-title">Fees</span>
        </a>
        <!-- <ul aria-expanded="false" class="collapse" style="">
        <?php if($ALLPRIVILEGE['Fees']['module']==1){?>
            <li><a href="#!/fees-list"> Fees</a></li>

        <?php }if($ALLPRIVILEGE['Fees']['module']==1){?>
             <li><a href="#!/fees-category">Fees Category</a></li>
        <?php } ?>
        </ul> -->
        </li>

         <!--   <li class="">
            <a href="#!/fees-invoice" aria-expanded="false">
                <span class="has-icon">
                    <i class="fa fa-files-o" aria-hidden="true"></i>
                </span>
                <span class="nav-title">Invoice</span>
            </a>
            </li> -->


        <?php } if(isset($ALLPRIVILEGE['DiscussionCategory']) && $ALLPRIVILEGE['DiscussionCategory']['module']==1 OR isset($ALLPRIVILEGE['Discussion']) && $ALLPRIVILEGE['Discussion']['module']==1){?>
        <li class="">
        <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
            <span class="has-icon">
                <i class="fas fa-comment"></i>
            </span>
            <span class="nav-title">Discussions</span>
        </a>
        <ul aria-expanded="false" class="collapse" style="">
        <?php if($ALLPRIVILEGE['DiscussionCategory']['module']==1){?>
            <li><a href="#!/discussioncat-list">Discussion Category</a></li>
        <?php }if($ALLPRIVILEGE['Discussion']['module']==1){?>
            <li><a href="#!/discussion-list">Discussion</a></li>
        <?php } ?>
        </ul>
        </li>
        <?php }if(isset($ALLPRIVILEGE['Timeline']) && $ALLPRIVILEGE['Timeline']['module']==1){?>
        <li>
        <a href="#!/timeline-list" aria-expanded="false">
            <span class="has-icon">
                <i class="icon-profile"></i>
            </span>
            <span class="nav-title">Timeline</span>
        </a>
        </li>
        <?php } ?>
        <?php if(isset($ALLPRIVILEGE['Article']) && $ALLPRIVILEGE['Article']['module']==1){?>
        <li>
        <a href="#!/article-list" aria-expanded="false">
            <span class="has-icon">
                <i class="icon-news"></i>
            </span>
            <span class="nav-title">Article</span>
        </a>
        </li>
       <?php }if(isset($ALLPRIVILEGE['OnlineAssessment']) && $ALLPRIVILEGE['OnlineAssessment']['module']==1){?>
         <li class="">
            <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
                <span class="has-icon">
                    <i class="icon-edit"></i>
                </span>
                <span class="nav-title">Online Assessment</span>
            </a>
            <ul aria-expanded="false" class="collapse" style="">
                <!-- <li><a href="#!/exam">Exam & Test</a></li> -->
                 <li>
                    <a href="#" class="has-arrow" aria-expanded="false">
                        <span class="has-icon">
                            <i class="fas fa-book-reader"></i>
                        </span>
                        <span class="nav-title">Exam & Test</span>
                    </a>
                    <ul aria-expanded="false" class="collapse" style="">
                    <li><a class="menu-link" href="#!/exam">List of Exam & Test</a></li>
                    <li><a class="menu-link" href="#!/exam-submit">Submitted Exam & Test</a></li>
                    </ul>
                </li>
                
                  <li>
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
                 <li>
                    <a href="#" class="has-arrow" aria-expanded="false">
                        <span class="has-icon">
                            <i class="fas fa-tasks"></i>
                        </span>
                        <span class="nav-title">Projects</span>
                    </a>
                    <ul aria-expanded="false" class="collapse" style="">
                    <li><a class="menu-link" href="#!/project-list">List of Projects</a></li>
                    <li><a class="menu-link" href="#!/submitted-project-list">Submitted Projects</a></li>
                    </ul>
                </li>
            </ul>
        </li>
		<?php }if(isset($ALLPRIVILEGE['OfflineAssessment']) && $ALLPRIVILEGE['OfflineAssessment']['module']==1){?>
          <li class="">
            <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
                <span class="has-icon">
                    <i class="icon-edit"></i>
                </span>
                <span class="nav-title">Offline Assessment</span>
            </a>
            <ul aria-expanded="false" class="collapse" style="">
                 <li>
                    <a href="#!/offline-assessment"> 
                        <span class="has-icon"><i class="fas fa-book-reader"></i></span>
                        <span class="nav-title">Exam & Test</span></a>
                </li>
             </ul>
        </li>
		<?php } ?>
        <!-- <li>
            <a href="#!/exam" aria-expanded="false">
                <span class="has-icon">
                    <i class="icon-edit"></i>
                </span>
                <span class="nav-title">Exam</span>
            </a>
        </li> -->

        <!--  <li class="">
            <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
                <span class="has-icon">
                    <i class="icon-edit"></i>
                </span>
                <span class="nav-title">Submitted Assessment</span>
            </a>
            <ul aria-expanded="false" class="collapse" style="">
                <li><a href="#!/exam-submit">Submitted Exam & Test</a></li> -->
                 <!-- <li><a href="#!/assignment-submit">Submitted Assignment & Project</a></li>
            </ul>
        </li> -->

        <!--<li>
            <a href="#!/exam-submit" aria-expanded="false">
                <span class="has-icon">
                    <i class="fas fa-book-reader"></i>
                </span>
                <span class="nav-title">Submitted Exam</span>
            </a>
        </li> -->
		

        <?php if(isset($ALLPRIVILEGE['Album']) && $ALLPRIVILEGE['Album']['module']==1){?>
        <li>
        <a href="#!/album-list" aria-expanded="false">
            <span class="has-icon">
                <i class="icon-news"></i>
            </span>
            <span class="nav-title">Album</span>
        </a>
        </li>
        <?php }if(isset($ALLPRIVILEGE['LearningDevelopmentCategory']) && $ALLPRIVILEGE['LearningDevelopmentCategory']['module']==1 OR isset($ALLPRIVILEGE['LearningDevelopmentReport']) && $ALLPRIVILEGE['LearningDevelopmentReport']['module']==1){?>
        <li class="">
        <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
            <span class="has-icon">
                <i class="icon-code"></i>
            </span>
            <span class="nav-title">Learning & Development</span>
        </a>
        <ul aria-expanded="false" class="collapse" style="">
        <?php if($ALLPRIVILEGE['LearningDevelopmentCategory']['module']==1){?>
            <li><a href="#!/learning-and-development">Learning & Development Category</a></li>
        <?php }if($ALLPRIVILEGE['LearningDevelopmentReport']['module']==1){?>
            <li><a href="#!/learning-and-development-report-list">Learning & Development Report</a></li>
            <?php } ?>
        </ul>
        </li>
        <?php }if(isset($ALLPRIVILEGE['Messages']) && $ALLPRIVILEGE['Messages']['module']==1){?>
        <li>
        <a href="#!/messages-list" aria-expanded="false">
            <span class="has-icon">
                <i class="icon-email"></i>
            </span>
            <span class="nav-title">Messages</span>
        </a>
        </li>
        <?php }if(isset($ALLPRIVILEGE['StudentReports']) && $ALLPRIVILEGE['StudentReports']['module']==1){?>
		<li>
            <a href="#!/student-report" aria-expanded="false">
                <span class="has-icon">
                    <i class="icon-edit"></i>
                </span>
                <span class="nav-title">Student Reports</span>
            </a>
        </li>
		<?php }if(isset($ALLPRIVILEGE['Faqs']) && $ALLPRIVILEGE['Faqs']['module']==1){?>
        <li>
            <a href="#!/school-faq" aria-expanded="false">
                <span class="has-icon">
                    <i class="fas fa-comment"></i>
                </span>
                <span class="nav-title">FAQs</span>
            </a>
        </li>
        <?php } ?>
        <li>
	<a href="#!/feedback" aria-expanded="false">
	<span class="has-icon"><i class="icon-drag_handle"></i></span>
	<span class="nav-title">Feedback</span>
	</a>
	</li>
        
        <?php if(isset($ALLPRIVILEGE['GiftManagement']) && $ALLPRIVILEGE['GiftManagement']['module']==1 OR isset($ALLPRIVILEGE['PointManagement']) && $ALLPRIVILEGE['PointManagement']['module']==1  OR isset($ALLPRIVILEGE['ThoughtOfTheDay']) && $ALLPRIVILEGE['ThoughtOfTheDay']['module']==1 OR 1){?>
        <li class="">
        <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
            <span class="has-icon">
                <i class="icon-cogs"></i>
            </span>
            <span class="nav-title">Setting</span>
        </a>
        <ul aria-expanded="false" class="collapse" style="">
            <?php //if($ALLPRIVILEGE['Subscribe']['module']==1){?>
            <li><a href="#!/subscribe">Subscribe</a></li>
            <?php if(isset($ALLPRIVILEGE['Subscribe']) && $ALLPRIVILEGE['Subscribe']['module']==1){?>
            <li><a href="#!/fee-suscription-list">Manage Subscription Amount</a></li>
            <?php }if(isset($ALLPRIVILEGE['GiftManagement']) && $ALLPRIVILEGE['GiftManagement']['module']==1){?>
            <li><a href="#!/gifts">Gift Management</a></li>
            <?php }if(isset($ALLPRIVILEGE['PointManagement']) && $ALLPRIVILEGE['PointManagement']['module']==1){?>
            <li><a href="#!/point-management">Point Management</a></li>
            <?php }if(isset($ALLPRIVILEGE['ThoughtOfTheDay']) && $ALLPRIVILEGE['ThoughtOfTheDay']['module']==1){?>
            <li><a href="#!/thoughtoftheday-list">Thought of the Day</a></li>
            <?php } ?>
        </ul>
        </li>
        <?php } ?>

    </ul>
    <!-- END: side-nav-content -->
</nav>
<!-- END: .side-nav -->
</div>