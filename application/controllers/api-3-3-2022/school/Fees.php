<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	require APPPATH . '/libraries/REST_Controller.php';
	require APPPATH . '/libraries/crypto/autoload.php';
	use Blocktrail\CryptoJSAES\CryptoJSAES;
	class Fees extends REST_Controller {
		
		public $error = array();
		public $data = array();
		
		public function __construct() {
			parent::__construct();
			if($this->session->userdata('user_role')=='school' OR $this->session->userdata('user_role')=='schoolsubadmin'){
				$this->token->validate();
			}
			//$this->token->validate();
			$this->load->library('form_validation');
			$this->load->library("security");
			$this->load->model(array('admin/Fees_model','Fees_model'));
			$this->load->library('settings');
		}
		
	public function getFeesCategories_post() 
	{
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$result = $this->Fees_model->feesCategories($postData);
		// prd($result);

		if ($result) {
			$return['success'] = "true";
			$return['message'] = "Fee category List.";
			$return['data'] = $result;
			$return['error'] = $this->error;

			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "No category found.";
			$return['error'] = $this->error;
			$return['data'] = $result;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function getsubscriptionAmount_post() 
	{
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$result = $this->Fees_model->getsubscriptionAmount($postData);
		// prd($result);

		if ($result) {
			$return['success'] = "true";
			$return['message'] = "Fee subscription amount.";
			$return['data'] = $result;
			$return['error'] = $this->error;

			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "No amount found.";
			$return['error'] = $this->error;
			$return['data'] = $result;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function addFeesCategory_post() 
	{
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		// prd($postData);
		$result = $this->Fees_model->addFeesCategory($postData);

		if ($result) {
			$return['success'] = "true";
			$return['message'] = "Fee category created successfully.";
			$return['data'] = $result;
			$return['error'] = $this->error;

			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "Not found.";
			$return['error'] = $this->error;
			$return['data'] = $result;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function editCategory_post() 
	{
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		// prd($postData);
		$result = $this->Fees_model->getCategoryDetails($postData);

		if ($result) {
			$return['success'] = "true";
			$return['message'] = "Fee category details.";
			$return['data'] = $result;
			$return['error'] = $this->error;

			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "Not found.";
			$return['error'] = $this->error;
			$return['data'] = $result;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function updateFeesCategory_post() 
	{
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		// prd($postData);
		$result = $this->Fees_model->updateFeesCategory($postData);

		if ($result) {
			$return['success'] = "true";
			$return['message'] = "Fee category data updated successfully.";
			$return['data'] = $result;
			$return['error'] = $this->error;

			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "No data update.";
			$return['error'] = $this->error;
			$return['data'] = $result;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function deleteCategory_post() 
	{
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		// prd($postData);
		$result = $this->Fees_model->deleteCategory($postData);

		if ($result) {
			$return['success'] = "true";
			$return['message'] = "Category has been deleted.";
			$return['data'] = $result;
			$return['error'] = $this->error;

			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "No record found.";
			$return['error'] = $this->error;
			$return['data'] = $result;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function feeDelete_post() 
	{
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		// prd($postData);
		$result = $this->Fees_model->feeDelete($postData);

		if ($result) {
			$return['success'] = "true";
			$return['message'] = "Fee has been deleted.";
			$return['data'] = $result;
			$return['error'] = $this->error;

			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "Not found.";
			$return['error'] = $this->error;
			$return['data'] = $result;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function getAllFeesCategories_post() 
	{
		// $postData = json_decode(file_get_contents('php://input'), true);
		// if ($postData == '') {
		// 	$postData = $_POST;
		// }
		$result = $this->Fees_model->getAllFeesCategories();
		// prd($result);

		if ($result) {
			$return['success'] = "true";
			$return['message'] = "Fee category List.";
			$return['data'] = $result;
			$return['error'] = $this->error;

			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "No fees category found.";
			$return['error'] = $this->error;
			$return['data'] = $result;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function sessions_post()
	{
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$result = $this->Fees_model->getSession($postData['school_id']);
		// prd($result);

		if ($result) {
			$return['success'] = "true";
			$return['message'] = "Sessions List.";
			$return['data'] = $result;
			$return['error'] = $this->error;

			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "No Sessions found.";
			$return['error'] = $this->error;
			$return['data'] = '';
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function feesList_post()
	{
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		$result = $this->Fees_model->feesList($postData['school_id']);
		// prd($result);
		if ($result) {
			$return['success'] = "true";
			$return['message'] = "Class fee has been created successfully.";
			$return['data'] = $result;
			$return['error'] = $this->error;

			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "something went wrong.";
			$return['error'] = $this->error;
			$return['data'] = $result;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function feesDetails_post()
	{
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		// prd($result);
        $school_id =  $postData['school_id'];
	
                $currData = array();
                $query = $this->db->query("select
              s.currency_id as school_currency_id,
              ac.currency_name as school_currency_name,
              ac.currency_code as  school_currency_code,
              ac.currency_symbol as  school_currency_symbol
              from school as s 
              left join admin_currency as ac on ac.id = s.currency_id 
              where s.id = '$school_id'");
                //echo $this->db->last_query();exit;
                if($query->num_rows() > 0)
                {
                 $currData =  $query->row();
                }
		$result = $this->Fees_model->feesDetails($postData['id']);
		// prd($result);
		if ($result) {
			$return['success'] = "true";
			$return['message'] = "Class fee has been created successfully.";
			$return['data'] = $result;
                        $return['data']['school_currency'] = $currData;
			$return['error'] = $this->error;

			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "something went wrong.";
			$return['error'] = $this->error;
			$return['data'] = $result;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function addFees_post()
	{
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		// prd($postData);
		$result = $this->Fees_model->addFees($postData);
		if ($result) {
			$return['success'] = "true";
			$return['message'] = "Class fee has been created successfully.";
			$return['data'] = $result;
			$return['error'] = $this->error;

			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "something went wrong.";
			$return['error'] = $this->error;
			$return['data'] = $result;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
        
        public function updateFees_post()
	{
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		// prd($postData);
		$result = $this->Fees_model->updateFees($postData);
		if ($result) {
			$return['success'] = "true";
			$return['message'] = "Updated successfully.";
			$return['data'] = $result;
			$return['error'] = $this->error;

			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "something went wrong.";
			$return['error'] = $this->error;
			$return['data'] = $result;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
        
        public function transactionHistory_post()
	{
            
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
                $classID =  $postData['classId'];
                $School_ID =  $postData['schoolId'];
                
                if(empty($classID) || empty($School_ID)){
                $return['success'] = "false";
                $return['message'] = "something went wrong.";
                $return['error'] = $this->error;
                $return['data'] = $result;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                }
		$result = $this->Fees_model->paymentHistory($classID,$School_ID);
		if ($result) {
			$return['success'] = "true";
			$return['message'] = "Transaction History.";
			$return['data'] = $result;
			$return['error'] = $this->error;
			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "something went wrong.";
			$return['error'] = $this->error;
			$return['data'] = $result;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
}
