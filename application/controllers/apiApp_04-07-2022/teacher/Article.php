<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Article extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('parent/article_model','model');
        $this->load->helper('common_helper');
    }

    public function index_get() {
        $schoolId  = $this->token->school_id;
        $user_id  = $this->token->user_id;
        $usertype  = 'teacher';
        $articleResult = $this->model->articleList($schoolId, $user_id, $usertype);
        // prd($articleResult);

        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = !empty($articleResult) ? 'Record found successfully.' : "No record found.";
        $return['data'] = $articleResult ? $articleResult : array();
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }
}