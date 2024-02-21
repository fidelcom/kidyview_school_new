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
			$return['message'] = "Not found.";
			$return['error'] = $this->error;
			$return['data'] = $result;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function getAllClassBySchoolType_post()
	{
		$postData = json_decode(file_get_contents('php://input'), true);
		if ($postData == '') {
			$postData = $_POST;
		}
		// prd($postData);
		$result = $this->Fees_model->classList($postData);

		if ($result) {
			$return['success'] = "true";
			$return['message'] = "Class list.";
			$return['data'] = $result;
			$return['error'] = $this->error;

			$this->response($return, REST_Controller::HTTP_OK);
			} else {
			$return['success'] = "false";
			$return['message'] = "No class found.";
			$return['error'] = $this->error;
			$return['data'] = $result;
			$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
		}	
	}
}
