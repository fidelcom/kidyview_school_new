<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Owner extends MX_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('is_logged_in') != 'true' || ($this->session->userdata('user_role') != 'admin' && $this->session->userdata('user_role') != 'adminsubadmin')) {
            redirect('administrator');
        }
        $this->load->model('user_model');
        $schoolDetail = $this->session->all_userdata();
        if($this->session->userdata('user_role')=='adminsubadmin'){
        $roleid=$schoolDetail['user_data']['role_id'];
        $this->ALLPRIVILEGE=$this->user_model->checkAllPrivilege($roleid);;
       // $this->checkAllPrivilege($this->ALLPRIVILEGE);
        }
    }
    public function checkAllPrivilege($privelegeData){
        $uri=strtolower($this->uri->segment(2));
        $retrn=1;
        if($uri=='schoollist'){
            if($privelegeData['SchoolManagement']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addschool'){
            if($privelegeData['SchoolManagement']['add']==0){
                $retrn =0;
            }
        }   
        if($uri=='subadminlist'){
            if($privelegeData['SuperSubAdmin']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addsubadmin'){
            if($privelegeData['SuperSubAdmin']['add']==0){
                $retrn =0;
            }
        }
        if($uri=='editsubadmin'){
            if($privelegeData['SuperSubAdmin']['edit']==0){
                $retrn =0;
            }
        }  
        if($uri=='rolelist'){
            if($privelegeData['RoleManagement']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addrole'){
            if($privelegeData['RoleManagement']['add']==0){
                $retrn =0;
            }
        }
        if($uri=='editrole'){
            if($privelegeData['RoleManagement']['edit']==0){
                $retrn =0;
            }
        } 
        if($uri=='privilegelist'){
            if($privelegeData['PrivilegeManagement']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addprivilege'){
            if($privelegeData['PrivilegeManagement']['add']==0){
                $retrn =0;
            }
        }
        if($uri=='editprivilege'){
            if($privelegeData['PrivilegeManagement']['edit']==0){
                $retrn =0;
            }
        } 
        if($uri=='giftlist'){
            if($privelegeData['GiftManagement']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addgift'){
            if($privelegeData['GiftManagement']['add']==0){
                $retrn =0;
            }
        }
        if($uri=='editgift'){
            if($privelegeData['GiftManagement']['edit']==0){
                $retrn =0;
            }
        } 
        if($uri=='goallist'){
            if($privelegeData['GoalsManagement']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addgoal'){
            if($privelegeData['GoalsManagement']['add']==0){
                $retrn =0;
            }
        }
        if($uri=='editgoal'){
            if($privelegeData['GoalsManagement']['edit']==0){
                $retrn =0;
            }
        }
        if($uri=='goallist'){
            if($privelegeData['GoalsManagement']['view']==0){
                $retrn =0;
            }
        } 
        if($uri=='addgoal'){
            if($privelegeData['GoalsManagement']['add']==0){
                $retrn =0;
            }
        }
        if($uri=='editgoal'){
            if($privelegeData['GoalsManagement']['edit']==0){
                $retrn =0;
            }
        }
        if($retrn==0){
           echo "<script>window.location.href='".base_url()."owner';</script>";
        die; 
        }
    }

    public function index() {
        $data = array();
        $data['JSONPRIVILEGE']=array();
        if($this->session->userdata('user_role')=='adminsubadmin'){
        //$roleid=$schoolDetail['user_data']['role_id'];
        $data['ALLPRIVILEGE']= $this->ALLPRIVILEGE;
        $data['JSONPRIVILEGE']=$data['ALLPRIVILEGE'];
        }
        $this->load->view('index', $data);
    }

	public function dashboard() {
        $this->load->view('dashbord');
    } 
    
	public function changepassword() {
		$this->load->view('changepwd');
	}
	public function schoolView() {
		$this->load->view('schooldetails');
	}
	public function schoolList() {
		$this->load->view('schoolListing');
	}
	public function editSchool() {
		$this->load->view('editschool');
	}
	public function addSchool() {
		$this->load->view('addschool');
	}
	public function goalList() {
        $this->load->view('goallist');
    }
	public function addGoal() {
        $this->load->view('addgoal');
    }
	public function editGoal() {
        $this->load->view('editgoal');
    }
	public function giftList() {
        $this->load->view('giftlist');
    }
	public function addGift() {
        $this->load->view('addgift');
    }
	public function editGift() {
        $this->load->view('editgift');
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
        //echo "czczxc";die;
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
}
