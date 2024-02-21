<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Reportschool extends REST_Controller {

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
        $this->load->model('reports/School_model', 'schoolreport');
    }

   

    public function getAllSchool_post() {

        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        
        $countryID   = isset($postData['countryID']) ? $postData['countryID'] : '';
        $result = $this->schoolreport->getAllSchool($countryID);

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

        $result = $this->schoolreport->getAllSectionClass($schoolid);

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

        $result = $this->schoolreport->getCountryList();

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

        if (isset($postData['classSectionList']) && isset($postData['schoolLists']) && isset($postData['countryCodes']) && isset($postData['fromdate']) && isset($postData['todate'])) {
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

            $schoolParent = $this->schoolreport->getSchoolReport($searchingArray);
            if ($schoolParent) {
                $return['success'] = "true";
                $return['message'] = "All School list";
                $return['data'] = $schoolParent;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
            } else {
                $return['success'] = "false";
                $return['message'] = "No School found.";
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
