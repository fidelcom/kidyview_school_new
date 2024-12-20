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
<?php if($this->session->userdata('user_role')=='school'){?>
<img src="<?php echo base_url(); ?>img/school/<?php echo $schoolPhoto; ?>" class="profile-thumb profileImageHeader" alt="User Thumb">
<?php }elseif($this->session->userdata('user_role')=='schoolsubadmin'){ ?>
<img src="<?php echo base_url(); ?>img/school/subadmin/<?php echo $schoolPhoto; ?>" class="profile-thumb profileImageHeader" alt="User Thumb">
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
    <?php if($ALLPRIVILEGE['Parents']['module']==1 OR $ALLPRIVILEGE['Teacher']['module']==1 OR $ALLPRIVILEGE['Driver']['module']==1 OR $ALLPRIVILEGE['SubAdmin']['module']==1){?>
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
        <?php }if($ALLPRIVILEGE['Teacher']['module']==1){?>
            <li><a href="#!/teacher-list">Teacher</a></li>
        <?php }if($ALLPRIVILEGE['Driver']['module']==1){?>
            <li><a href="#!/driver-list">Driver</a></li>
        <?php }if($ALLPRIVILEGE['SubAdmin']['module']==1){?>
            <li><a href="#!subadmin-list">Sub Admin</a></li>
        <?php } ?>
        </ul>
    </li>
    <?php }if($ALLPRIVILEGE['Role']['module']==1 OR $ALLPRIVILEGE['Privilege']['module']){?>
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
    <?php }if($ALLPRIVILEGE['Events']['module']==1 OR $ALLPRIVILEGE["StudentsBirthday"]['module']==1 OR $ALLPRIVILEGE['Calendar']['module']==1 OR $ALLPRIVILEGE['MealPlanner']['module']==1 OR $ALLPRIVILEGE['HomeMeal']['module']==1 OR $ALLPRIVILEGE['HolidayList']['module']==1){?>
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
            <?php }if($ALLPRIVILEGE['HomeMeal']['module']==1){?> 
            <li><a href="#!/home-meal">Home Meal</a></li>
            <?php }if($ALLPRIVILEGE['HolidayList']['module']==1){?> 
            <li><a href="#!/holiday-list">Holiday List</a></li>
            <?php } ?>
        </ul>
    </li>
    <?php }if($ALLPRIVILEGE['StudentAttendance']['module']==1 OR $ALLPRIVILEGE['TeacherAttendance']['module']==1 OR $ALLPRIVILEGE['SubadminAttendance']['module']==1 OR $ALLPRIVILEGE['RequestDayOff']['module']==1){?>
    <li class="">
        <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
            <span class="has-icon">
                <i class="icon-address-book"></i>
            </span>
            <span class="nav-title">Attendance</span>
        </a>
        <ul aria-expanded="false" class="collapse" style="">
        <?php if($ALLPRIVILEGE['StudentAttendance']['module']==1){?>
            <li><a href="javascript:void(0);">Student Attendance</a></li>
        <?php }if($ALLPRIVILEGE['TeacherAttendance']['module']==1){?>
            <li><a href="javascript:void(0);">Teacher Attendance</a>
        <?php }if($ALLPRIVILEGE['SubadminAttendance']['module']==1){?>
            <li><a href="javascript:void(0);">Subadmin Attendance</a>
        <?php }if($ALLPRIVILEGE['RequestDayOff']['module']==1){?>
            <li><a href="javascript:void(0);">Request day off </a></li>
        <?php } ?>
        </ul>
    </li>
<?php }if($ALLPRIVILEGE['Session']['module']==1 OR $ALLPRIVILEGE['Class']['module'] OR $ALLPRIVILEGE['Subject']['module']==1 OR $ALLPRIVILEGE['Assign']['module']==1 OR $ALLPRIVILEGE['TransferStudents']['module'] OR $ALLPRIVILEGE['Fees']['module']==1 OR $ALLPRIVILEGE['TrackCab']['module']==1 OR $ALLPRIVILEGE['Result']['module']==1){?>
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
            <?php }if($ALLPRIVILEGE['Class']['module']==1){?>
            <li><a href="#!/class-list">Class</a></li>
            <?php }if($ALLPRIVILEGE['Subject']['module']==1){?>
            <li><a href="#!/subject-list">Subject</a></li>
            <?php }if($ALLPRIVILEGE['Assign']['module']==1){?>
            <li><a href="javascript:void(0);">Assign</a></li>
            <?php }if($ALLPRIVILEGE['TransferStudents']['module']==1){?>
            <li><a href="javascript:void(0);">Transfer Students</a></li>
            <?php }if($ALLPRIVILEGE['Fees']['module']==1){?>
            <li><a href="javascript:void(0);">Fees</a></li>
            <?php }if($ALLPRIVILEGE['TrackCab']['module']==1){?>
            <li><a href="javascript:void(0);">Track Cab</a></li>
            <?php }if($ALLPRIVILEGE['Result']['module']==1){?>
            <li><a href="javascript:void(0);">Result</a></li>
            <?php } ?>
        </ul>
    </li>
    <?php }if($ALLPRIVILEGE['DiscussionCategory']['module']==1 OR $ALLPRIVILEGE['Discussion']['module']==1){?>
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
    <?php }if($ALLPRIVILEGE['Timeline']['module']==1){?>
    <li>
        <a href="#!/timeline-list" aria-expanded="false">
            <span class="has-icon">
                <i class="icon-profile"></i>
            </span>
            <span class="nav-title">Timeline</span>
        </a>
    </li>
    <?php } ?>
    <?php if($ALLPRIVILEGE['Article']['module']==1){?>
    <li>
        <a href="#!/article-list" aria-expanded="false">
            <span class="has-icon">
                <i class="icon-news"></i>
            </span>
            <span class="nav-title">Article</span>
        </a>
    </li>
    <?php } ?>
    <?php if($ALLPRIVILEGE['Album']['module']==1){?>
    <li>
        <a href="#!/album-list" aria-expanded="false">
            <span class="has-icon">
                <i class="icon-news"></i>
            </span>
            <span class="nav-title">Album</span>
        </a>
    </li>
    <?php }if($ALLPRIVILEGE['LearningDevelopmentCategory']['module']==1 OR $ALLPRIVILEGE['LearningDevelopmentReport']['module']==1){?>
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
    <?php }if($ALLPRIVILEGE['Messages']['module']==1){?>
    <li>
        <a href="javascript:void(0);" aria-expanded="false">
            <span class="has-icon">
                <i class="icon-email"></i>
            </span>
            <span class="nav-title">Messages</span>
        </a>
    </li>
    <?php }if($ALLPRIVILEGE['Subscribe']['module']==1 OR $ALLPRIVILEGE['GiftManagement']['module']==1 OR $ALLPRIVILEGE['PointManagement']['module']==1  OR $ALLPRIVILEGE['ThoughtOfTheDay']['module']==1){?>
    <li class="">
        <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
            <span class="has-icon">
                <i class="icon-cogs"></i>
            </span>
            <span class="nav-title">Setting</span>
        </a>
        <ul aria-expanded="false" class="collapse" style="">
            <?php if($ALLPRIVILEGE['Subscribe']['module']==1){?>
            <li><a href="javascript:void(0);">Subscribe</a></li>
            <?php }if($ALLPRIVILEGE['GiftManagement']['module']==1){?>
            <li><a href="javascript:void(0);">Gift Management</a></li>
            <?php }if($ALLPRIVILEGE['PointManagement']['module']==1){?>
            <li><a href="javascript:void(0);">Point Management</a></li>
            <?php }if($ALLPRIVILEGE['ThoughtOfTheDay']['module']==1){?>
            <li><a href="javascript:void(0);">Thought of the Day</a></li>
            <?php } ?>
        </ul>
    </li>
    <?php } ?>
</ul>
<!-- END: side-nav-content -->
</nav>
<!-- END: .side-nav -->
</div>