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
        <li class="">
            <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
                <span class="has-icon">
                    <i class="icon-briefcase"></i>
                </span>
                <span class="nav-title">User Management</span>
            </a>
            <ul aria-expanded="false" class="collapse" style="">
           
                <li><a href="#!/parent-list">Parents</a></li>
           
                <li><a href="#!/teacher-list">Teacher</a></li>
            
                <li><a href="#!/driver-list">Driver</a></li>
           
                <li><a href="#!subadmin-list">Sub Admin</a></li>
            
            </ul>
        </li>
        <li class="">
            <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
                <span class="has-icon">
                    <i class="icon-tree"></i>
                </span>
                <span class="nav-title">Role Management</span>
            </a>
            <ul aria-expanded="false" class="collapse" style="">
           
                <li><a href="#!/role-list">Role</a></li>
          
                <li><a href="#!/privilege-list">Privilege</a></li>
          
            </ul>
        </li>
        <li class="">
            <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
                <span class="has-icon">
                    <i class="icon-calendar"></i>
                </span>
                <span class="nav-title">Calendar</span>
            </a>
            <ul aria-expanded="false" class="collapse" style="">
           
                <li><a href="#!/event-list">Events</a></li>
           
                <li><a href="#!/student-birthday">Student's Birthday</a></li>
           
                <li><a href="#!/calendar-list">Calendar</a></li>
               
                <li><a href="#!/meal-planner">Meal Planner</a></li>
               
                <li><a href="#!/home-meal">Home Meal</a></li>
                
                <li><a href="#!/holiday-list">Holiday List</a></li>
               
            </ul>
        </li>
        <li class="">
            <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
                <span class="has-icon">
                    <i class="icon-address-book"></i>
                </span>
                <span class="nav-title">Attendance</span>
            </a>
            <ul aria-expanded="false" class="collapse" style="">
            
                <li><a href="javascript:void(0);">Student Attendance</a></li>
            
                <li><a href="javascript:void(0);">Teacher Attendance</a>
            
                <li><a href="javascript:void(0);">Subadmin Attendance</a>
           
                <li><a href="javascript:void(0);">Request day off </a></li>
           
            </ul>
        </li>
        <li class="">
            <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
                <span class="has-icon">
                    <i class="icon-display"></i>
                </span>
                <span class="nav-title">Administration</span>
            </a>
            <ul aria-expanded="false" class="collapse" style="">
                
                <li><a href="#!/session-list">Session</a></li>
				
				<li><a href="#!/term-list">Terms</a></li>
                
                <li><a href="#!/class-list">Class</a></li>
               
                <li><a href="#!/subject-list">Subject</a></li>
               
                <li><a href="javascript:void(0);">Assign</a></li>
                
                <li><a href="javascript:void(0);">Transfer Students</a></li>
                
                <li><a href="javascript:void(0);">Fees</a></li>
                
                <li><a href="javascript:void(0);">Track Cab</a></li>
                
                <li><a href="javascript:void(0);">Result</a></li>
                
            </ul>
        </li>
        <li class="">
            <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
                <span class="has-icon">
                    <i class="fas fa-comment"></i>
                </span>
                <span class="nav-title">Discussions</span>
            </a>
            <ul aria-expanded="false" class="collapse" style="">
            
                <li><a href="#!/discussioncat-list">Discussion Category</a></li>
           
                <li><a href="#!/discussion-list">Discussion</a></li>
           
            </ul>
        </li>
       
        <li>
            <a href="#!/timeline-list" aria-expanded="false">
                <span class="has-icon">
                    <i class="icon-profile"></i>
                </span>
                <span class="nav-title">Timeline</span>
            </a>
        </li>
       
       
        <li>
            <a href="#!/article-list" aria-expanded="false">
                <span class="has-icon">
                    <i class="icon-news"></i>
                </span>
                <span class="nav-title">Article</span>
            </a>
        </li>
        
        <li>
            <a href="#!/album-list" aria-expanded="false">
                <span class="has-icon">
                    <i class="icon-news"></i>
                </span>
                <span class="nav-title">Album</span>
            </a>
        </li>
      
        <li class="">
            <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
                <span class="has-icon">
                    <i class="icon-code"></i>
                </span>
                <span class="nav-title">Learning & Development</span>
            </a>
            <ul aria-expanded="false" class="collapse" style="">
           
            <li><a href="#!/learning-and-development">Learning & Development Category</a></li>
             <li><a href="#!/learning-and-development-report-list">Learning & Development Report</a></li>
              
            </ul>
        </li>
      
        <li>
            <a href="#!/messages-list" aria-expanded="false">
                <span class="has-icon">
                    <i class="icon-email"></i>
                </span>
                <span class="nav-title">Messages</span>
            </a>
        </li>
		<li>
            <a href="#!/student-report" aria-expanded="false">
                <span class="has-icon">
                    <i class="icon-edit"></i>
                </span>
                <span class="nav-title">Student Reports</span>
            </a>
        </li>
       
        <li class="">
            <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
                <span class="has-icon">
                    <i class="icon-cogs"></i>
                </span>
                <span class="nav-title">Setting</span>
            </a>
            <ul aria-expanded="false" class="collapse" style="">
                
                <li><a href="javascript:void(0);">Subscribe</a></li>
              
                <li><a href="javascript:void(0);">Gift Management</a></li>
               
                <li><a href="javascript:void(0);">Point Management</a></li>
               
                <li><a href="#!/thoughtoftheday-list">Thought of the Day</a></li>
              
            </ul>
        </li>

    </ul>
    <!-- END: side-nav-content -->
</nav>
<!-- END: .side-nav -->
</div>