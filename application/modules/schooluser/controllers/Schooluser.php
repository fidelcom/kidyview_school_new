<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Schooluser extends MX_Controller {
    public $schoolID ='';
    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('is_logged_in') != 'true' || ($this->session->userdata('user_role') != 'school' && $this->session->userdata('user_role') != 'schoolsubadmin')) {
            redirect('schoollogin');
        }
        $this->load->model('user_model');
        $schoolDetail = $this->session->all_userdata();
        $this->schoolID=$schoolDetail['user_data']['school_id'];
		//print_r($schoolDetail);
        if($this->session->userdata('user_role')=='schoolsubadmin'){
        $roleid=$schoolDetail['user_data']['role_id'];
        $this->ALLPRIVILEGE=$this->user_model->checkAllPrivilege($roleid);
        $this->checkAllPrivilege($this->ALLPRIVILEGE);
        }elseif($this->session->userdata('user_role')=='school'){
            $school_id=$schoolDetail['user_data']['school_id'];
            $subscription_id=$schoolDetail['user_data']['subscription_id'];
            $this->school_access=$this->user_model->school_access($school_id,$subscription_id);
            //prd($this->school_access);
            $this->school_access($this->school_access);
        }
    }
    public function getcurrency($currencyID)
    {
          $curData = array(); 
          $this->db->select("*");
          $this->db->where('id',$currencyID);
          $query = $this->db->get('admin_currency'); 
           
        if($query->num_rows() > 0) 
        {
         $curData  = json_decode(json_encode($query->row()), true); 
        }
        return $curData;
    }
    public function feature_list($subscription_id=''){
        $this->db->where("subscription_id",$subscription_id);
        //$this->db->where("is_enable","1");
        $query = $this->db->get("subscription_feature");  
        if($query->num_rows() > 0)
        {
            return $query->result_array();
        }
        else
        {
            return array();
        }
    }
    function update_child_session(){
        $this->db->select('id,schoolId,class_session_id,childclass');
        $this->db->from('child');
        $this->db->where('schoolId',14);
		$query=$this->db->get();
        $result = $query->result_array();

        //echo count($result);
        //print_r($result);die;
        for($i=0;$i<count($result);$i++){
            $school_id=$result[$i]['schoolId'];
            $current_session_data =get_current_session($school_id);
           // print_r($current_session_data);die;
            if(!empty($current_session_data)){
            $cData=array('class_session_id'=>$current_session_data->id);
            $this->db->where('id',$result[$i]['id']);
            $this->db->update('child',$cData);
            $childClassArr = array(
                'school_id' => $school_id,
                'child_id' => $result[$i]['id'],
                'session_id' => $current_session_data->id,
                'class_id' => $result[$i]['childclass'],
                'created_date'=> date('Y-m-d H:i:s')              
            );
            }
            $this->db->insert('child_class',$childClassArr);
        }

    }

	 public function school_access($privelegeData){
	 
        $uri=strtolower($this->uri->segment(2));
        $retrn=1;
        if($uri=='parentlist'){
            if($privelegeData['Parents']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='addparent'){
            if($privelegeData['Parents']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='editparent'){
            if($privelegeData['Parents']['module']==0){
                $retrn =0;
            }
        }   
        if($uri=='teacherlist'){
            if($privelegeData['Teacher']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='addteacher'){
            if($privelegeData['Teacher']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='editteacher'){
            if($privelegeData['Teacher']['module']==0){
                $retrn =0;
            }
        }      
        if($uri=='driverlist'){
            if($privelegeData['Driver']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='adddriver'){
            if($privelegeData['Driver']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='editdriver'){
            if($privelegeData['Driver']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='subadminlist'){
            if($privelegeData['SubAdmin']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='addsubadmin'){
            if($privelegeData['SubAdmin']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='editsubadmin'){
            if($privelegeData['SubAdmin']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='rolelist'){
            if($privelegeData['Role']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='addrole'){
            if($privelegeData['Role']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='editrole'){
            if($privelegeData['Role']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='privilegelist'){
            if($privelegeData['Privilege']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='addprivilege'){
            if($privelegeData['Privilege']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='editprivilege'){
            if($privelegeData['Privilege']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='eventlist'){
            if($privelegeData['Events']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='addevent'){
            if($privelegeData['Events']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='editevent'){
            if($privelegeData['Events']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='studentbirthdaylist'){
            if($privelegeData['StudentsBirthday']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='calendarlist'){
            if($privelegeData['Calendar']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='mealplanner'){
            if($privelegeData['MealPlanner']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='addmeal'){
            if($privelegeData['MealPlanner']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='editmeal'){
            if($privelegeData['MealPlanner']['module']==0){
                $retrn =0;
            }
        }
        if($uri=='homemeal'){
            if($privelegeData['HomeMeal']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='holidaylist'){
            if($privelegeData['HolidayList']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='addholiday'){
            if($privelegeData['HolidayList']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='editholiday'){
            if($privelegeData['HolidayList']['module']==0){
                $retrn =0;
            }
        }
        if($uri=='sessionlist'){
            if($privelegeData['Session']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='addsession'){
            if($privelegeData['Session']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='editsession'){
            if($privelegeData['Session']['module']==0){
                $retrn =0;
            }
        }
        if($uri=='classlist'){
            if($privelegeData['Class']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='addclass'){
            if($privelegeData['Class']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='editclass'){
            if($privelegeData['Class']['module']==0){
                $retrn =0;
            }
        }
        if($uri=='subjectlist'){
            if($privelegeData['Subject']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='addsubject'){
            if($privelegeData['Subject']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='editsubject'){
            if($privelegeData['Subject']['module']==0){
                $retrn =0;
            }
        }
        if($uri=='discussioncatlist'){
            if($privelegeData['DiscussionCategory']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='adddiscussioncat'){
            if($privelegeData['DiscussionCategory']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='editdiscussioncat'){
            if($privelegeData['DiscussionCategory']['module']==0){
                $retrn =0;
            }
        }
        if($uri=='discussionlist'){
            if($privelegeData['Discussion']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='timelinelist'){
            if($privelegeData['Timeline']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='addtimeline'){
            if($privelegeData['Timeline']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='edittimeline'){
            if($privelegeData['Timeline']['module']==0){
                $retrn =0;
            }
        }
        if($uri=='articlelist'){
            if($privelegeData['Article']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='addarticle'){
            if($privelegeData['Article']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='editarticle'){
            if($privelegeData['Article']['module']==0){
                $retrn =0;
            }
        }
        if($uri=='albumlist'){
            if($privelegeData['Album']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='addalbum'){
            if($privelegeData['Album']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='editalbum'){
            if($privelegeData['Album']['module']==0){
                $retrn =0;
            }
        }
        if($uri=='learningdevelopment'){
            if($privelegeData['LearningDevelopmentCategory']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='addlearningdevelopment'){
            if($privelegeData['LearningDevelopmentCategory']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='editlearningdevelopment'){
            if($privelegeData['LearningDevelopmentCategory']['module']==0){
                $retrn =0;
            }
        }
        if($uri=='learningdevelopmentreportList'){
            if($privelegeData['LearningDevelopmentReport']['module']==0){
                $retrn =0;
            }
        }
		if($uri=='messagelist'){
            if($privelegeData['Messages']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='addmessage'){
            if($privelegeData['Messages']['module']==0){
                $retrn =0;
            }
        }
		if($uri=='termlist'){
            if($privelegeData['Term']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='addterm'){
            if($privelegeData['Term']['module']==0){
                $retrn =0;
            }
        }
		if($uri=='editterm'){
            if($privelegeData['Term']['module']==0){
                $retrn =0;
            }
        }
		if($uri=='studentreportlist'){
            if($privelegeData['Report']['module']==0){
                $retrn =0;
            }
        }
		if($uri=='thoughtofthedaylist'){
            if($privelegeData['Thoughts']['module']==0){
                $retrn =0;
            }
        } 
        if($uri=='addthoughtoftheday'){
            if($privelegeData['Thoughts']['module']==0){
                $retrn =0;
            }
        }
		if($uri=='editthoughtoftheday'){
            if($privelegeData['Thoughts']['module']==0){
                $retrn =0;
            }
        }
		if($retrn==0){
           echo "<script>window.location.href='".base_url()."schooluser';</script>";
			die; 
        }
    }
    public function checkAllPrivilege($privelegeData){
        $uri=strtolower($this->uri->segment(2));
        $retrn=1;
        if($uri=='parentlist'){
            if($privelegeData['Parents']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addparent'){
            if($privelegeData['Parents']['add']==0){
                $retrn =0;
            }
        } 
        if($uri=='editparent'){
            if($privelegeData['Parents']['edit']==0){
                $retrn =0;
            }
        }   
        if($uri=='teacherlist'){
            if($privelegeData['Teacher']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addteacher'){
            if($privelegeData['Teacher']['add']==0){
                $retrn =0;
            }
        } 
        if($uri=='editteacher'){
            if($privelegeData['Teacher']['edit']==0){
                $retrn =0;
            }
        }      
        if($uri=='driverlist'){
            if($privelegeData['Driver']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='adddriver'){
            if($privelegeData['Driver']['add']==0){
                $retrn =0;
            }
        } 
        if($uri=='editdriver'){
            if($privelegeData['Driver']['edit']==0){
                $retrn =0;
            }
        } 
        if($uri=='subadminlist'){
            if($privelegeData['SubAdmin']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addsubadmin'){
            if($privelegeData['SubAdmin']['add']==0){
                $retrn =0;
            }
        } 
        if($uri=='editsubadmin'){
            if($privelegeData['SubAdmin']['edit']==0){
                $retrn =0;
            }
        } 
        if($uri=='rolelist'){
            if($privelegeData['Role']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addrole'){
            if($privelegeData['Role']['add']==0){
                $retrn =0;
            }
        } 
        if($uri=='editrole'){
            if($privelegeData['Role']['edit']==0){
                $retrn =0;
            }
        } 
        if($uri=='privilegelist'){
            if($privelegeData['Privilege']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addprivilege'){
            if($privelegeData['Privilege']['add']==0){
                $retrn =0;
            }
        } 
        if($uri=='editprivilege'){
            if($privelegeData['Privilege']['edit']==0){
                $retrn =0;
            }
        } 
        if($uri=='eventlist'){
            if($privelegeData['Events']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addevent'){
            if($privelegeData['Events']['add']==0){
                $retrn =0;
            }
        } 
        if($uri=='editevent'){
            if($privelegeData['Events']['edit']==0){
                $retrn =0;
            }
        } 
        if($uri=='studentbirthdaylist'){
            if($privelegeData['StudentsBirthday']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='calendarlist'){
            if($privelegeData['Calendar']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='mealplanner'){
            if($privelegeData['MealPlanner']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addmeal'){
            if($privelegeData['MealPlanner']['add']==0){
                $retrn =0;
            }
        } 
        if($uri=='editmeal'){
            if($privelegeData['MealPlanner']['edit']==0){
                $retrn =0;
            }
        }
        if($uri=='homemeal'){
            if($privelegeData['HomeMeal']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='holidaylist'){
            if($privelegeData['HolidayList']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addholiday'){
            if($privelegeData['HolidayList']['add']==0){
                $retrn =0;
            }
        } 
        if($uri=='editholiday'){
            if($privelegeData['HolidayList']['edit']==0){
                $retrn =0;
            }
        }
        if($uri=='sessionlist'){
            if($privelegeData['Session']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addsession'){
            if($privelegeData['Session']['add']==0){
                $retrn =0;
            }
        } 
        if($uri=='editsession'){
            if($privelegeData['Session']['edit']==0){
                $retrn =0;
            }
        }
        if($uri=='classlist'){
            if($privelegeData['Class']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addclass'){
            if($privelegeData['Class']['add']==0){
                $retrn =0;
            }
        } 
        if($uri=='editclass'){
            if($privelegeData['Class']['edit']==0){
                $retrn =0;
            }
        }
        if($uri=='subjectlist'){
            if($privelegeData['Subject']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addsubject'){
            if($privelegeData['Subject']['add']==0){
                $retrn =0;
            }
        } 
        if($uri=='editsubject'){
            if($privelegeData['Subject']['edit']==0){
                $retrn =0;
            }
        }
        if($uri=='discussioncatlist'){
            if($privelegeData['DiscussionCategory']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='adddiscussioncat'){
            if($privelegeData['DiscussionCategory']['add']==0){
                $retrn =0;
            }
        } 
        if($uri=='editdiscussioncat'){
            if($privelegeData['DiscussionCategory']['edit']==0){
                $retrn =0;
            }
        }
        if($uri=='discussionlist'){
            if($privelegeData['Discussion']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='timelinelist'){
            if($privelegeData['Timeline']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addtimeline'){
            if($privelegeData['Timeline']['add']==0){
                $retrn =0;
            }
        } 
        if($uri=='edittimeline'){
            if($privelegeData['Timeline']['edit']==0){
                $retrn =0;
            }
        }
        if($uri=='articlelist'){
            if($privelegeData['Article']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addarticle'){
            if($privelegeData['Article']['add']==0){
                $retrn =0;
            }
        } 
        if($uri=='editarticle'){
            if($privelegeData['Article']['edit']==0){
                $retrn =0;
            }
        }
        if($uri=='albumlist'){
            if($privelegeData['Album']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addalbum'){
            if($privelegeData['Album']['add']==0){
                $retrn =0;
            }
        } 
        if($uri=='editalbum'){
            if($privelegeData['Album']['edit']==0){
                $retrn =0;
            }
        }
        if($uri=='learningdevelopment'){
            if($privelegeData['LearningDevelopmentCategory']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addlearningdevelopment'){
            if($privelegeData['LearningDevelopmentCategory']['add']==0){
                $retrn =0;
            }
        } 
        if($uri=='editlearningdevelopment'){
            if($privelegeData['LearningDevelopmentCategory']['edit']==0){
                $retrn =0;
            }
        }
        if($uri=='learningdevelopmentreportList'){
            if($privelegeData['LearningDevelopmentReport']['view']==0){
                $retrn =0;
            }
        }
		if($uri=='messagelist'){
            if($privelegeData['Messages']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addmessage'){
            if($privelegeData['Messages']['add']==0){
                $retrn =0;
            }
        }
		if($uri=='termlist'){
            if($privelegeData['Term']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addterm'){
            if($privelegeData['Term']['add']==0){
                $retrn =0;
            }
        }
		if($uri=='editterm'){
            if($privelegeData['Term']['edit']==0){
                $retrn =0;
            }
        }
		if($uri=='studentreportlist'){
            if($privelegeData['Report']['view']==0){
                $retrn =0;
            }
        }
		if($uri=='thoughtofthedaylist'){
            if($privelegeData['Thoughts']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addthoughtoftheday'){
            if($privelegeData['Thoughts']['add']==0){
                $retrn =0;
            }
        }
		if($uri=='editthoughtoftheday'){
            if($privelegeData['Thoughts']['edit']==0){
                $retrn =0;
            }
        }
		if($retrn==0){
           echo "<script>window.location.href='".base_url()."schooluser';</script>";
			die; 
        }
    }
	public function index() {
        $data = array();
        $schoolDetail = $this->session->all_userdata();
        $data['JSONPRIVILEGE']=array();
        $data['SCHOOLACCESS']=array();
        $data['schoolAccess']=array();
        if($this->session->userdata('user_role')=='schoolsubadmin'){
        $roleid=$schoolDetail['user_data']['role_id'];
        $data['ALLPRIVILEGE']= $this->ALLPRIVILEGE;
        $data['JSONPRIVILEGE']=$data['ALLPRIVILEGE'];
        }elseif($this->session->userdata('user_role')=='school'){
            $data['ALLPRIVILEGE']= $this->school_access;
            $data['schoolAccess']=$data['ALLPRIVILEGE']?$data['ALLPRIVILEGE']:array();
          
        }
        //prd($data['SCHOOLACCESS']);die;
        $this->load->view('index', $data);
    }
    public function dashboard() {
        $this->load->view('dashbord');
    }

    public function editprofile() {
        $this->load->view('editprofile');
	}
	
	public function subadminprofile() {
        $this->load->view('subadminprofile');
    } 

    public function parentList() {
        $this->load->view('parentlist');
    }
    public function studentList() {
        $this->load->view('studentlist');
    }
    public function studentDetails() {
       $this->load->view('studentdetail');
    }

    public function addParent() {
        $this->load->view('addparent');
    }

    public function parentView() {
        $this->load->view('parentdetail');
    }

    public function editParent() {
        $this->load->view('editparent');
    }

    public function editChild() {
        $this->load->view('editchild');
    }

    public function eventList() {
        $this->load->view('eventlist');
    }

    public function addEvent() {
        $this->load->view('addevent');
    }

    public function eventView() {
        $this->load->view('eventdetail');
    }

    public function editEvent() {
        $this->load->view('editevent');
    }

    public function driverList() {
        $this->load->view('driverlist');
    }

    public function addDriver() {
        $this->load->view('adddriver');
    }

    public function driverView() {
        $this->load->view('driverdetail');
    }

    public function editDriver() {
        $this->load->view('editdriver');
    }

    public function sessionList() {
        $this->load->view('sessionlist');
    }

    public function addSession() {
        $this->load->view('addsession');
    }

    public function editSession() {
        $this->load->view('editsession');
    }

    public function classList() {
        $this->load->view('classlist');
    }

    public function addClass() {
        $this->load->view('addclass');
    }

    public function editClass() {
        $this->load->view('editclass');
    }

    public function subjectList() {
        $this->load->view('subjectlist');
    }

    public function addSubject() {
        $this->load->view('addsubject');
    }

    public function editSubject() {
        $this->load->view('editsubject');
    }

    public function teacherList() {
        $this->load->view('teacherlist');
    }

    public function addTeacher() {
        $this->load->view('addteacher');
    }

    public function teacherView() {
        $this->load->view('teacherdetail');
    }

    public function editTeacher() {
        $this->load->view('editteacher');
    }

    public function studentBirthdayList() {
        $this->load->view('studentbirthdaylist');
    }

    public function studentView() {
        $this->load->view('studentdetail');
    }

    public function articleList() {
        $this->load->view('articlelist');
    }

    public function addArticle() {
        $this->load->view('addarticle');
    }

    public function editArticle() {
        $this->load->view('editarticle');
    }
    
    public function feedback() {
        $this->load->view('feedback');
    }
    public function feedbackView() {
        $this->load->view('feedback-detail');
    }

    public function articleView() {
        $data['JSONPRIVILEGE']=array();
        $schoolDetail = $this->session->all_userdata();
        if($this->session->userdata('user_role')=='schoolsubadmin'){
        $roleid=$schoolDetail['user_data']['role_id'];
        $data['ALLPRIVILEGE']= $this->ALLPRIVILEGE;
        $data['JSONPRIVILEGE']=$data['ALLPRIVILEGE'];
        }
        $this->load->view('articledetail',$data);
    }

    public function albumList() {
        $this->load->view('albumlist');
    }

    public function addAlbum() {
        $this->load->view('addalbum');
    }

    public function albumView() {
        $data['JSONPRIVILEGE']=array();
        $schoolDetail = $this->session->all_userdata();
        if($this->session->userdata('user_role')=='schoolsubadmin'){
        $roleid=$schoolDetail['user_data']['role_id'];
        $data['ALLPRIVILEGE']= $this->ALLPRIVILEGE;
        $data['JSONPRIVILEGE']=$data['ALLPRIVILEGE'];
        }
        $this->load->view('albumdetail',$data);
    }

    public function editAlbum() {
        $this->load->view('editalbum');
    }
    
    public function mealPlanner() {
        $this->load->view('mealPlanner');
    }
    public function addMeal() {
        $this->load->view('addMeal');
    }
    public function editMeal() {
        $this->load->view('editMeal');
    }
    public function learningDevelopment() {
        $this->load->view('learningDevelopment');
    }
    public function addLearningDevelopment() {
        $this->load->view('addLearningDevelopment');
    }
    public function editLearningDevelopment() {
        $this->load->view('editLearningDevelopment');
    }
    public function homeMeal() {
        $this->load->view('homeMeal');
    }
	public function timelineList() {
        $data['JSONPRIVILEGE']=array();
        $schoolDetail = $this->session->all_userdata();
        if($this->session->userdata('user_role')=='schoolsubadmin'){
        $roleid=$schoolDetail['user_data']['role_id'];
        $data['ALLPRIVILEGE']= $this->ALLPRIVILEGE;
        $data['JSONPRIVILEGE']=$data['ALLPRIVILEGE'];
        }
        $this->load->view('timelinelist',$data);
    }
	public function addTimeline() {
        $this->load->view('addtimeline');
    }
	public function editTimeline() {
        $this->load->view('edittimeline');
    }
    public function holidayList() {
        $this->load->view('holidaylist');
    }
    public function addHoliday() {
        $this->load->view('addholiday');
    }
    public function editHoliday() {
        $this->load->view('editholiday');
    }
	public function discussioncatList() {
        $this->load->view('discussioncatlist');
    }
	public function addDiscussionCat() {
        $this->load->view('adddiscussioncat');
    }
	public function editDiscussionCat() {
        $this->load->view('editdiscussioncat');
    }
	public function discussionList() {
        $this->load->view('discussionlist');
    }
	public function discussionView() {
        $data['JSONPRIVILEGE']=array();
        $schoolDetail = $this->session->all_userdata();
        if($this->session->userdata('user_role')=='schoolsubadmin'){
        $roleid=$schoolDetail['user_data']['role_id'];
        $data['ALLPRIVILEGE']= $this->ALLPRIVILEGE;
        $data['JSONPRIVILEGE']=$data['ALLPRIVILEGE'];
        }
        $this->load->view('discussiondetail',$data);
    }
    public function calendarList() {
        $this->load->view('calendarlist');
    }
    public function roleList() {
        $this->load->view('rolelist');
    }
    public function addRole() {
        $this->load->view('addrole');
    }
    public function editRole() {
        $this->load->view('editrole');
    }

    public function privilegeList() {
        $this->load->view('privilegelist');
    }
    public function addPrivilege() {
        $this->load->view('addprivilege');
    }
    public function editPrivilege() {
        $this->load->view('editprivilege');
    }

    public function subAdminList() {
        $this->load->view('subadminlist');
    }

    public function addSubAdmin() {
        $this->load->view('addsubadmin');
    }
    public function editSubAdmin() {
        $this->load->view('editsubadmin');
    }

    public function subAdminView() {
        $this->load->view('subadmindetail');
    }
	public function learningdevelopmentreportList() {
        $this->load->view('learningdevelopmentreportlist');
    }
	public function learningdevelopmentreportView() {
        $this->load->view('learningdevelopmentreportdetail');
    }
	public function messageList() {
		$this->load->view('messagelist');
	}
	public function messageView() {
        $this->load->view('messagedetail');
    }
	public function addMessage() {
        $this->load->view('addmessage');
    }
	public function termList() {
        $this->load->view('termlist');
    }
	public function addTerm() {
        $this->load->view('addterm');
    }
	public function editTerm() {
        $this->load->view('editterm');
    }
	public function studentReportList() {
        $this->load->view('studentreportlist');
    }
	public function reportView() {
        $this->load->view('studentreportdetail');
    }
	public function thoughtofthedayList() {
        $this->load->view('thoughtofthedaylist');
    }
	public function addThoughtoftheday() {
        $this->load->view('addthoughtoftheday');
    }
	public function editThoughtoftheday() {
        $this->load->view('editthoughtoftheday');
    }
	// public function studentAttendance()
	// {
	// 	$this->load->view('studentattendance');		
	// }
	public function classSchedule()
	{
		$this->load->view('classschedule');
	}
    public function viewScheduleDetails()
    {
        $this->load->view('viewscheduledetails');
    }
    public function editSchedule()
    {
        $this->load->view('editschedule');
    }
    public function addSchedule()
    {
        $this->load->view('addschedule');
    }
    public function timeTable()
    {
        $this->load->view('timetable');
    }
    public function editTimeTable()
    {
        $this->load->view('edittimetable');
    }
    public function schoolFaq()
    {
        $this->load->view('schoolfaq');
    }
    public function addfaq()
    {
        $this->load->view('addfaq');
    }
    public function exam()
    {
        $this->load->view('exam');
    }
    public function editExam()
    {
        $this->load->view('examedit');
    }
    public function addExam()
    {
        $this->load->view('addexam');
    }
    public function examDetails()
    {
        $this->load->view('examdetail');
    }
    public function offlineAssessment()
    {
        $this->load->view('offline-assessment');
    }
    public function addOfflineAssessment()
    {
        $this->load->view('add-offline-assessment');
    } 
    public function editOfflineExam()
    {
        $this->load->view('edit-offline-assessment');
    }
    public function offlineAssessmentStudent()
    {
        $this->load->view('offline-assessment-student');
    } 
    public function feesCategory()
    {
        $this->load->view('fees-category');
    }
    public function addFeesCategory()
    {
        $this->load->view('add-fees-category');
    }
    public function editFeesCategory()
    {
        $this->load->view('edit-fees-category');
    }
    public function fees()
    {
        $this->load->view('fees');
    }
    public function addFees()
    {
        $this->load->view('add-fees');
    } 
    public function editFees()
    {
        $this->load->view('edit-fees');
    } 
    public function feeDetails()
    {
        $this->load->view('fees-details');
    }
    public function feesInvoice()
    {
        $this->load->view('invoice');
    }
    public function questionList()
    {
        $this->load->view('questionlist');
    }
    public function addQuestion()
    {
        $this->load->view('addquestion');
    }
    public function editQuestion()
    {
        $this->load->view('editquestion');
    }
    public function detailsQuestion()
    {
        $this->load->view('detailsquestion');
    }
    public function examSubmit()
    {
        $this->load->view('examsubmit');
    }
    public function gradeList()
    {
        $this->load->view('gradelist');
    }
    public function addGrade()
    {
        $this->load->view('addgrade');
    }
    public function viewSubmitExam()
    {
        $this->load->view('viewsubmitexam');
    }
    public function submitExamDetails()
    {
        $this->load->view('submitexamdetails');
    }
    
    public function assignmentList() {
        $this->load->view('assignment/assignmentlist');
    }
    public function editAssignment() {
        $this->load->view('assignment/editassignment');
    }
    public function assignmentView() {
        $this->load->view('assignment/assignmentdetail');
    }
    public function createAssignment() {
        $this->load->view('assignment/createassignment');
    }

    public function submittedAssignmentList() {
        $this->load->view('assignment/submittedassignmentlist');
    }
    public function submitedassignmentView() {
        $this->load->view('assignment/submitedassignmentdetail');
    }
    public function projectList() {
        $this->load->view('project/projectlist');
    }
    public function editProject() {
        $this->load->view('project/editproject');
    }
    public function projectView() {
        $this->load->view('project/projectdetail');
    }
    public function createProject() {
        $this->load->view('project/createproject');
    }
    public function submittedProjectList() {
        $this->load->view('project/submittedprojectlist');
    }
    public function submitedprojectView() {
        $this->load->view('project/submitedprojectdetail');
    }
    
    public function resultList()
    {
        $this->load->view('result-list');
    }
    public function addResult()
    {
        $this->load->view('addresult');
    }
    public function resultDetail()
    {
        $this->load->view('resultdetail');
    }
    public function studentAttendance()
    {
        $this->load->view('student-attendance');
    }
    public function addStudentAttendance()
    {
        $this->load->view('add-student-attendance');
    }
    public function teacherAttendance()
    {
        $this->load->view('teacher-attendance');
    }
    public function addTeacherAttendance()
    {
        $this->load->view('add-teacher-attendance');
    }
    public function subadminAttendance()
    {
        $this->load->view('subadmin-attendance');
    }
    public function addSubadminAttendance()
    {
        $this->load->view('add-subadmin-attendance');
    }
    public function requestDayOff()
    {
        $this->load->view('request-day-off');
    }
    public function requestDayOffDetails()
    {
        $this->load->view('request-day-off-details');
    }
	public function subscribe()
    {	
        $this->load->view('subscribe');
    }
    public function feeSuscription()
    {   
        $this->load->view('fee-suscription');
    }
    public function feeSuscriptionList()
    {   
        $this->load->view('fee-suscription-list');
    }
    public function giftList() {
        $this->load->view('gift/giftlist');
    }
    public function giftDetails() {
        $this->load->view('gift/giftdetails');
    }
    public function studentPointManagement() 
    {
         $this->load->view('points-management');
    }
    public function pointDetails() 
    {
         $this->load->view('points-details');
    }
    
    public function addVehicle() {
        $this->load->view('addVehicle');
    }
    
    public function vehicleList() {
        $this->load->view('vehicleList');
    }
    
     public function addRoute() {
        $this->load->view('addRoute');
    }
     public function assignStudent() {
        $this->load->view('assignStudent');
    }
    
     public function editRoute() {
        $this->load->view('editRoute');
    }
     public function editAssignStudent() {
        $this->load->view('editAssignStudent');
    }
     public function editVehicle() {
        $this->load->view('editVehicle');
    }
    
     public function transactionHistory() {
        $this->load->view('transactionHistory');
    }
    
    public function viewDriverStudents() {
        $this->load->view('viewDriverStudents');
    }
    
    public function journeyLogStudents() {
        $this->load->view('journeyLogStudents');
    }
    public function trackdriver() {
        $this->load->view('trackdriver');
    }
    public function lessonnote() {
        $this->load->view('lessonnote');
    }
    public function viewnote() {
        $this->load->view('viewnote');
    }
    public function notificationSettings() {
        $this->load->view('setting/notification-settings');
    }
    public function notificationList() {
        $this->load->view('notification/notification-list');
    }
    public function transferStudent() {
        $this->load->view('transferStudent');
    }
    public function activityperformancelist() {
        $this->load->view('performance/activityperformancelist');
    }
    public function editactivityperformance() {
        $this->load->view('performance/editactivityperformance');
    }
    public function uploadStudentCsvData() {
        $this->load->library('csvimport');
        $csv = $_FILES['csvFile']['tmp_name'];
        $csv_student_data=array();
        $csv_parent_data=array();
        $return=0;
        if($csv!=''){
        $csv_data = $this->csvimport->parse_file($csv);
        if(!empty($csv_data)){
                foreach($csv_data as $student){
                if($return==1){
                   $csv_student_data['schoolId']=$this->schoolID;
                   $csv_student_data['childfname']=$student[0];
                   $csv_student_data['childlname']=$student[1];
                   $csv_student_data['childgender']=$student[2];
                   $csv_student_data['childclass']=$student[3];
                   $csv_student_data['childdob']=date('Y-m-d',strtotime($student[4]));
                   $csv_student_data['childemail']=$student[5];
                   $csv_student_data['class_session_id']=get_current_session($this->schoolID)->id;
                   $csv_parent_data['fatherfname']=$student[6];
                   $csv_parent_data['fatheremail']=$student[7];
                   $csv_parent_data['fatherphone']=$student[8];
                   $csv_parent_data['motherfname']=$student[9];
                   $csv_parent_data['motheremail']=$student[10];
                   $csv_parent_data['motherphone']=$student[11];
                   $csv_parent_data['schoolId']=$this->schoolID;
                   $isParentExist= $this->user_model->checkParentExist($csv_parent_data);
                   if(count($isParentExist)== 0){
                        $this->db->insert('parent',$csv_parent_data);
                        $last_parent_insert_id = $this->db->insert_id();
                        if($last_parent_insert_id){
                            $csv_student_data['parent_id']=$last_parent_insert_id;
                            $csv_student_data['created_date']=date('Y-m-d H:i:s');
                            $last_insert_id  =  $this->db->insert('child',$csv_student_data);
                            $this->db->where('schoolId', $this->schoolID);
                            $this->db->where('id', $last_parent_insert_id);
                            $this->db->set('child_id', "CONCAT(child_id,',',$last_insert_id)",FALSE);
                            $this->db->update('parent');
                            $return=1;
                        }
                  }else{
                    if($isParentExist){
                        $csv_student_data['created_date']=date('Y-m-d H:i:s');
                        $csv_student_data['parent_id']=$isParentExist['id'];
                        $isChildExist= $this->user_model->checkChildExist($csv_student_data);
                        if($isChildExist==0){
                        $this->db->insert('child',$csv_student_data);
                        $last_child_insert_id = $this->db->insert_id();
                        $this->db->where('schoolId', $this->schoolID);
                        $this->db->where('id', $isParentExist['id']);
                        $this->db->set('child_id', "CONCAT(child_id,',',$last_child_insert_id)",FALSE);
                        $this->db->update('parent');
                        $return=1;
                        }
                    }
                  }
                }
             }
         }
         if($return=1){
            $this->session->set_flashdata('success','Data has been imported successfully.');
            echo '<script>window.location.href="schooluser#!/student-list?success=1"</script>';
         }else{
            $this->session->set_flashdata('error','Data not imported.Pleae import again.');
            echo '<script>window.location.href="schooluser#!/student-list?success=0"</script>';
         }
        }else{
            //echo 'd';die;
            $this->session->set_flashdata('error','Please import csv file.');
            echo '<script>window.location.href="schooluser#!/student-list?success=0"</script>';
            //redirect('schooluser#!/student-list?success=0');
        }
    }
}
