<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Reportrevenue extends REST_Controller {

    public $error = array();
    public $data = array();

    public function __construct() {
        parent::__construct();

        if ($this->session->userdata('user_role') == 'school' OR $this->session->userdata('user_role') == 'schoolsubadmin') {
            $this->token->validate();
        }
        $this->load->library('form_validation');
        $this->load->library("security");
        $this->load->library('settings');
        $this->load->model('reports/Revenue_model', 'revenuereport');
    }

   

    public function getAllSchool_post() {

        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        
        $countryID   = isset($postData['countryID']) ? $postData['countryID'] : '';

        
        $result = $this->revenuereport->getAllSchool($countryID);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All School List";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "No school found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllSectionClass_post() {

        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        
        $schoolid   = isset($postData['schoolid']) ? $postData['schoolid'] : '';

        $result = $this->revenuereport->getAllSectionClass($schoolid);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All School class section list";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "No school found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getCountryList_post() {

        $result = $this->revenuereport->getCountryList();

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Country Code list";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "No school found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getReport_post() {

        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        if (isset($postData['classSectionList']) && isset($postData['schoolLists'])  && isset($postData['fromdate']) && isset($postData['todate'])) {
            $classSectionList_id = $postData['classSectionList'];



            $schoolLists_id = $postData['schoolLists'];
            $countryCodes_id = $postData['countryCodes'];
            $fromdate = $postData['fromdate'];
            $todate = $postData['todate'];
           
            $searchingArray = array(
                'classSectionList_id' => $classSectionList_id,
                'schoolLists_id' => $schoolLists_id,
                'fromdate' => $fromdate,
                'todate' => $todate);
                //print_r($searchingArray);die;
                if(empty($schoolLists_id)){
                    $return['success'] = "false";
                    $return['message'] = "No Revenue found.";
                    $return['error'] = $this->error;
                    $return['data'] = '';
                    $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                }

            $schoolParent = $this->revenuereport->getRevenueReport($searchingArray);
            
            if ($schoolParent) {
                $return['success'] = "true";
                $return['message'] = "Revenue list";
                $return['data'] = $schoolParent;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
            } else {
                $return['success'] = "false";
                $return['message'] = "No Revenue found.";
                $return['error'] = $this->error;
                $return['data'] = '';
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $return['success'] = "false";
            $return['message'] = "Invalid Input.";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}
