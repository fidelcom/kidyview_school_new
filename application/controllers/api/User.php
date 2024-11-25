<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/crypto/autoload.php';

use Blocktrail\CryptoJSAES\CryptoJSAES;

class User extends REST_Controller
{

    public $error = array();
    public $data = array();

    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('user_role') == 'school' or $this->session->userdata('user_role') == 'schoolsubadmin') {
            $this->token->validate();
        }
        $this->load->library('form_validation');
        $this->load->library('firebases');
        $this->load->library("security");
        $this->load->library('fcm');
        $this->load->model('User_model');
        $this->load->model("admin/result_model", 'model');
        $this->load->model('students/Message_model', 'smodel');
        $this->load->model('team_model');
        $this->load->model('parent/Parent_model');
        $this->load->library('settings');
    }

    public function getSchoolSubadminDetails_post()
    {
        $data = $this->session->userdata('user_data');
        $id = $data['id'];

        $result = $this->User_model->getSchoolSubadminProfileDetails($id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "School Sub Admin details found.";
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

    public function changePasswordSchoolSubadmin_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $oldPassword = $postData['opsw'];
        $newPassword = $postData['npsw'];
        $result = $this->User_model->changePasswordSchoolSubadmin($oldPassword, $newPassword);

        if ($result == 1) {
            $return['success'] = "true";
            $return['message'] = "Password updated successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Password not updated.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function updateProfileSchoolSubadmin_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $pic = $_FILES;
        //print_r($postData); die;

        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Sub Admin Profile Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $pic = '';
            $uploadPath = 'img/school/subadmin/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['pic']['name'])) {
            if (!$this->upload->do_upload('pic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg = $this->upload->data();
                $pic = $uplodimg['file_name'];
            }
        }
        $name = $postData['name'];
        $phone = $postData['phone'];
        $address = $postData['address'];

        if ($pic != null) {
            $updateArr = array(
                'name' => $name,
                'phone' => $phone,
                'address' => $address,
                'pic' => $pic,
            );
        } else {
            $updateArr = array(
                'name' => $name,
                'phone' => $phone,
                'address' => $address,
            );
        }

        $update = $this->User_model->updateSchoolSubadminProfile($updateArr);


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Profile Information successfully updated.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function removeProfilePicSchoolSubadmin_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $defaultProfilePic = $postData['photo'];
        $result = $this->User_model->removeProfilePicSchoolSubadmin($defaultProfilePic);

        if ($result == 1) {
            $return['success'] = "true";
            $return['message'] = "Profile Pic removed successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not removed.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function changePasswordAdmin_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $oldPassword = $postData['opsw'];
        $newPassword = $postData['npsw'];
        $result = $this->User_model->changePasswordAdmin($oldPassword, $newPassword);

        if ($result == 1) {
            $return['success'] = "true";
            $return['message'] = "Password updated successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Password not updated.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function changePasswordSubadmin_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $oldPassword = $postData['opsw'];
        $newPassword = $postData['npsw'];
        $result = $this->User_model->changePasswordSubadmin($oldPassword, $newPassword);

        if ($result == 1) {
            $return['success'] = "true";
            $return['message'] = "Password updated successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Password not updated.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getSubadminProfile_get()
    {
        $result = $this->User_model->getSubadminDetails($this->session->userdata('user_data')['id']);
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Sub Admin details found.";
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

    public function updateProfileSubadmin_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $pic = $_FILES;
        //print_r($postData); die;

        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Sub Admin Profile Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $pic = '';
            $uploadPath = 'img/admin/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['pic']['name'])) {
            if (!$this->upload->do_upload('pic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg = $this->upload->data();
                $pic = $uplodimg['file_name'];
            }
        }
        $name = $postData['name'];
        $phone = $postData['phone'];
        $address = $postData['address'];

        if ($pic != null) {
            $updateArr = array(
                'name' => $name,
                'phone' => $phone,
                'address' => $address,
                'pic' => $pic,
            );
        } else {
            $updateArr = array(
                'name' => $name,
                'phone' => $phone,
                'address' => $address,
            );
        }

        $update = $this->User_model->updateSubadminProfile($updateArr);


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Profile Information successfully updated.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function removeProfilePicSubadmin_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $defaultProfilePic = $postData['photo'];
        $result = $this->User_model->removeProfilePicSubadmin($defaultProfilePic);

        if ($result == 1) {
            $return['success'] = "true";
            $return['message'] = "Profile Pic removed successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not removed.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function changePasswordSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $oldPassword = $postData['opsw'];
        $newPassword = $postData['npsw'];
        $id = $postData['id'];
        // prd($postData);
        $result = $this->User_model->changePasswordSchool($oldPassword, $newPassword, $id);
        // lq();
        if ($result == 1) {
            $return['success'] = "true";
            $return['message'] = "Password updated successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Password not updated.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function removeProfilePicAdmin_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $defaultProfilePic = $postData['photo'];
        $result = $this->User_model->removeProfilePicAdmin($defaultProfilePic);

        if ($result == 1) {
            $return['success'] = "true";
            $return['message'] = "Profile Pic removed successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not removed.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function removeProfilePicSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $defaultProfilePic = $postData['photo'];
        $id = $postData['id'];
        $result = $this->User_model->removeProfilePicSchool($defaultProfilePic, $id);

        if ($result == 1) {
            $return['success'] = "true";
            $return['message'] = "Profile Pic removed successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not removed.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function updateProfileAdmin_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $pic = $_FILES;
        //print_r($postData); die;

        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Admin Profile Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $pic = '';
            $uploadPath = 'img/admin/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['pic']['name'])) {
            if (!$this->upload->do_upload('pic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg = $this->upload->data();
                $pic = $uplodimg['file_name'];
            }
        }
        $fullname = $postData['fullname'];
        $phonenumber = $postData['phonenumber'];
        $location = $postData['location'];

        if ($pic != null) {
            $updateArr = array(
                'full_Name' => $fullname,
                'phone_no' => $phonenumber,
                'address' => $location,
                'photo' => $pic,
            );
        } else {
            $updateArr = array(
                'full_Name' => $fullname,
                'phone_no' => $phonenumber,
                'address' => $location,
            );
        }

        $update = $this->User_model->updateAdminProfile($updateArr);


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Profile Information successfully updated.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function schoolDisabled_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $id = $postData['id'];
        $status = $postData['status'];

        $updateArr = array(
            'status' => $status,
        );

        $update = $this->User_model->schoolDisabled($updateArr, $id);


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "School Status Disabled Now.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function parentDisabled_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $status = $postData['status'];

        $updateArr = array(
            'status' => $status,
        );

        $update = $this->User_model->parentDisabled($updateArr, $id);


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Parent Status Disabled Now.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function driverDisabled_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $status = $postData['status'];

        $updateArr = array(
            'status' => $status,
        );

        $update = $this->User_model->driverDisabled($updateArr, $id);


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Driver Status Disabled Now.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function sessionDisabled_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $status = $postData['status'];

        $updateArr = array(
            'status' => $status,
        );

        $update = $this->User_model->sessionDisabled($updateArr, $id);


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Session Status Disabled Now.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function makeCurrentSession_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $status = $postData['status'];
        if ($status != '1') {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }

        $updateArr = array('current_sesion' => $status);

        $update = $this->User_model->makeCurrentSession($updateArr, $id);


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Current Session Status Changed Now.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function termDisabled_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $status = $postData['status'];

        $updateArr = array(
            'status' => $status,
        );

        $update = $this->User_model->termDisabled($updateArr, $id);


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Term Status Disabled Now.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function sectionDisabled_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $status = $postData['status'];

        $updateArr = array(
            'status' => $status,
        );

        $update = $this->User_model->sectionDisabled($updateArr, $id);


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Section Status Disabled Now.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function discussionCatDisabled_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $status = $postData['status'];

        $updateArr = array(
            'status' => $status,
        );

        $update = $this->User_model->discussionCatDisabled($updateArr, $id);


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Discussion Category Status Changed Now.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function discussionAccept_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $status = $postData['status'];

        $updateArr = array(
            'status' => $status,
            'admin_reviewed' => 1,
        );

        $update = $this->User_model->discussionAccept($updateArr, $id);


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Discussion Accepted.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function discussionDecline_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $status = $postData['status'];

        $updateArr = array(
            'status' => $status,
            'admin_reviewed' => 1,
        );

        $update = $this->User_model->discussionDecline($updateArr, $id);


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Discussion Declined.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function giftDisabled_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $status = $postData['status'];

        $updateArr = array(
            'status' => $status,
        );

        $update = $this->User_model->giftDisabled($updateArr, $id);


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Gift Status Changed Now.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function subjectsDisabled_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $status = $postData['status'];

        $updateArr = array(
            'status' => $status,
        );

        $update = $this->User_model->subjectsDisabled($updateArr, $id);


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Subject Status Disabled Now.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function timelineDisabled_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        // $status = $postData['status'];

        // $updateArr = array(
        //          'status' => $status,
        // );
        // prd($postData);
        $updateArr = array(
            'is_deleted' => '0',
            'deleted_at' => date('Y-m-d H:i:s')
        );

        $update = $this->User_model->timelineDisabled($updateArr, $id);


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Timeline Status Disabled Now.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function teacherDisabled_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $status = $postData['status'];

        $updateArr = array(
            'status' => $status,
        );

        $update = $this->User_model->teacherDisabled($updateArr, $id);


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Teacher Status Disabled Now.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function albumDisabled_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $status = $postData['status'];

        $updateArr = array(
            'status' => $status,
        );

        $update = $this->User_model->albumDisabled($updateArr, $id);


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Album Status Disabled Now.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function updateProfileSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $pic = $_FILES;
        //print_r($postData); die;
        //print_r($pic); die;

        $signatureImg = "";

        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid School Profile Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $pic = '';
            $uploadPath = 'img/school/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['pic']['name'])) {
            if (!$this->upload->do_upload('pic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg = $this->upload->data();
                $pic = $uplodimg['file_name'];
            }
        }

        if (isset($_FILES['signatureImg']['name']) && (!empty($_FILES['signatureImg']['name']))) {
            if (!$this->upload->do_upload('signatureImg')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg = $this->upload->data();
                $signatureImg = $uplodimg['file_name'];
            }
        }


        $schoolname = $postData['schoolname'];
        $avgStudent = $postData['avgStudent'];
        $avgStaff = $postData['avgStaff'];
        $location = $postData['location'];
        $mission = $postData['mission'];
        $vision = $postData['vision'];
        $coreValues = $postData['coreValues'];
        $phone = $postData['phone'];
        $id = $postData['schoolid'];
        $city = $postData['city'];
        $state = $postData['state'];
        //$country = $postData['country'];
        $pincode = $postData['pincode'];
        $skypeid = $postData['skypeid'];
        $area = $postData['area'];
        $motto = $postData['motto'];
        $facebook = $postData['facebook'];
        $twitter = $postData['twitter'];
        $youtube = $postData['youtube'];
        $linkdin = $postData['linkdin'];
        $otherinfo = $postData['otherinfo'];
        $schoolType = $postData['schoolType'];
        //$currency_id = $postData['currency_id'];
        $bank_name = $postData['bank_name'];
        $sort_code = $postData['sort_code'];
        $account_number = $postData['account_number'];
        $pic1 = $pic;

        if ($pic != null) {
            $updateArr = array(
                'school_name' => $schoolname,
                'phone' => $phone,
                'average_student' => $avgStudent,
                'mission' => $mission,
                'vision' => $vision,
                'core_values' => $coreValues,
                'average_staff' => $avgStaff,
                'pic' => $pic,
                'location' => $location,
                'city' => $city,
                'state' => $state,
                //'currency_id' => $currency_id,
                'pincode' => $pincode,
                'skypeid' => $skypeid,
                'area' => $area,
                'motto' => $motto,
                'facebook' => $facebook,
                'twitter' => $twitter,
                'youtube' => $youtube,
                'linkdin' => $linkdin,
                'otherinfo' => $otherinfo,
                'schoolType' => $schoolType,
                'bank_name' => $bank_name,
                'account_number' => $account_number,
                'sort_code' => $sort_code,
            );
        } else {
            $updateArr = array(
                'school_name' => $schoolname,
                'phone' => $phone,
                'average_student' => $avgStudent,
                'mission' => $mission,
                'vision' => $vision,
                'core_values' => $coreValues,
                'average_staff' => $avgStaff,
                'location' => $location,
                'city' => $city,
                'state' => $state,
                ///'currency_id' => $currency_id,
                'pincode' => $pincode,
                'skypeid' => $skypeid,
                'area' => $area,
                'motto' => $motto,
                'facebook' => $facebook,
                'twitter' => $twitter,
                'youtube' => $youtube,
                'linkdin' => $linkdin,
                'otherinfo' => $otherinfo,
                'schoolType' => $schoolType,
                'bank_name' => $bank_name,
                'account_number' => $account_number,
                'sort_code' => $sort_code,
            );
        }

        if ($signatureImg != "") {
            $updateArr['signatureImg'] = $signatureImg;
        }

        if (isset($postData['sub_acc_number'])) {
            $updateArr['sub_acc_number'] = $postData['sub_acc_number'];
        }

        $update = $this->User_model->updateSchoolProfile($updateArr, $id);
        if ($pic1 != null) {
            $updateArr1 = array(
                'pic' => $pic1,
                'fname' => $schoolname,
            );
        } else {
            $updateArr1 = array(
                'fname' => $schoolname,
            );
        }
        $update1 = $this->User_model->updateSchoolProfileLogo($updateArr1, $id);
        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Profile Information successfully updated.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function addSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $password = array();
        $alpha_length = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alpha_length);
            $password[] = $alphabet[$n];
        }
        $randPass = implode($password);
        //echo $randPass; die;

        if ($postData == '') {
            $postData = $_POST;
        }
        $pic = $_FILES;
        //print_r($postData); die;
        //print_r($pic); die;

        $email = $postData['email'];
        $result = $this->User_model->schoolExist($email);

        if ($result) {
            $return['success'] = "false";
            $return['message'] = "Already Exists.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }


        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid School Profile Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $pic = '';
            $uploadPath = 'img/school/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['pic']['name'])) {
            if (!$this->upload->do_upload('pic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg = $this->upload->data();
                $pic = $uplodimg['file_name'];
            }
        }
        $schoolname = $postData['schoolname'];
        $email = $postData['email'];
        $avgStudent = $postData['avgStudent'];
        $avgStaff = $postData['avgStaff'];
        $location = $postData['location'];
        $mission = $postData['mission'];
        $vision = $postData['vision'];
        $coreValues = $postData['coreValues'];
        $phone = $postData['phone'];
        $city = $postData['city'];
        $state = $postData['state'];
        $country = $postData['country'];
        $pincode = $postData['pincode'];
        $skypeid = $postData['skypeid'];
        $area = $postData['area'];
        $motto = $postData['motto'];
        $facebook = $postData['facebook'];
        $twitter = $postData['twitter'];
        $youtube = $postData['youtube'];
        $linkdin = $postData['linkdin'];
        $otherinfo = $postData['otherinfo'];
        $schoolType = $postData['schoolType'];
        $currency_id = $postData['currency_id'];
        $bank_name = $postData['bank_name'];
        $sort_code = $postData['sort_code'];
        $account_number = $postData['account_number'];

        if ($pic != null) {
            $addArr = array(
                'school_name' => $schoolname,
                'phone' => $phone,
                'email' => $email,
                'password' => md5($randPass),
                'average_student' => $avgStudent,
                'mission' => $mission,
                'vision' => $vision,
                'core_values' => $coreValues,
                'average_staff' => $avgStaff,
                'pic' => $pic,
                'location' => $location,
                'city' => $city,
                'state' => $state,
                'country' => $country,
                'pincode' => $pincode,
                'skypeid' => $skypeid,
                'area' => $area,
                'motto' => $motto,
                'facebook' => $facebook,
                'twitter' => $twitter,
                'youtube' => $youtube,
                'linkdin' => $linkdin,
                'otherinfo' => $otherinfo,
                'schoolType' => $schoolType,
                'currency_id' => $currency_id,
                'bank_name' => $bank_name,
                'account_number' => $account_number,
                'sort_code' => $sort_code,
                'is_email_verified' => '1',
                'created_date' => date("Y:m:d H:i:s"),
            );
        } else {
            $addArr = array(
                'school_name' => $schoolname,
                'phone' => $phone,
                'email' => $email,
                'password' => md5($randPass),
                'average_student' => $avgStudent,
                'mission' => $mission,
                'vision' => $vision,
                'core_values' => $coreValues,
                'average_staff' => $avgStaff,
                'location' => $location,
                'city' => $city,
                'state' => $state,
                'country' => $country,
                'pincode' => $pincode,
                'skypeid' => $skypeid,
                'area' => $area,
                'motto' => $motto,
                'facebook' => $facebook,
                'twitter' => $twitter,
                'youtube' => $youtube,
                'linkdin' => $linkdin,
                'otherinfo' => $otherinfo,
                'schoolType' => $schoolType,
                'currency_id' => $currency_id,
                'bank_name' => $bank_name,
                'account_number' => $account_number,
                'sort_code' => $sort_code,
                'is_email_verified' => '1',
                'created_date' => date("Y:m:d H:i:s"),
            );
        }

        $add = $this->User_model->addSchoolByAdmin($addArr);
        if ($add) {
            if ($pic != null) {
                $addArr1 = array(
                    'school_id' => $add,
                    'email' => $email,
                    'fname' => $schoolname,
                    'password' => $randPass,
                    'pic' => $pic,
                    'is_email_verified' => '1',
                    'created_date' => date("Y:m:d H:i:s"),
                );
            } else {
                $addArr1 = array(
                    'school_id' => $add,
                    'email' => $email,
                    'fname' => $schoolname,
                    'password' => $randPass,
                    'is_email_verified' => '1',
                    'created_date' => date("Y:m:d H:i:s"),
                );
            }

        }
        $add1 = $this->User_model->addSchoolMoreDataByAdmin($addArr1);
        if ($add) {
            $emailsubject = '<h2 style="margin:0; padding:5px 0 10px;margin-bottom:15px; border-bottom: 1px solid #bbb8af;color: #020a65;">KidyView Admin Register you as a school in Kidyview system.</h2>';

            $to = $email;
            $message = '<table width="614px" align="center" style="background: #F1F1F1;"><tr><td><div style="width:614px; border:1px solid #efefef; font: normal 12px Verdana, Arial, Helvetica, sans-serif; padding:2px; border:1px solid #ccc; margin:0px auto; 0">
				<div style="background:#fff; padding:15px 10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				<td align="center"><img src="' . base_url() . 'img/small_logo.png" width="150px" height="100px" alt="" /></td>
				</tr>
				</table>
				</div>
				<div style="min-height:300px; padding:10px;">' . $emailsubject . '					
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<h3 style="margin:0; padding:5px 0 10px;margin-bottom:15px; border-bottom: 1px solid #bbb8af;color: #020a65;">Hi</h3>
				
				
				<h3 style="margin:0; padding:5px 0 10px;margin-bottom:15px; border-bottom: 1px solid #bbb8af;color: #020a65;">Your email id and password are:</h3>
				<tr>
				<td height="25">Email Id</td>
				<td height="25">:</td>
				<td height="25">' . $email . '</td>
				</tr>
				<tr>
				<td height="25">Password</td>
				<td height="25">:</td>
				<td height="25">' . $randPass . '</td>
				</tr>
				<tr>
				<td height="25">Please click below url for login:</td>
				<td height="25">:</td>
				<td height="25"><a style = "color: #fff; border: 1px solid #000; background: #3C9F06;" href="' . base_url() . 'schoollogin">Login Here</a></td>
				</tr>
				</table>
				</table>';

            //$mailResponse = $this->sendMail($to, "A registration email for kidyview", $message);
            $mailResponse = sendKidyviewEmail($to, '', '', '', 'A registration email for kidyview', $message);
        }

        if ($add) {
            $return['success'] = "true";
            $return['message'] = "School added successfully.";
            $return['error'] = $this->error;
            $return['data'] = $add;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }


    public function addParent_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        //print_r($postData); die;
        if (isset($_FILES['fpic'])) {
            $fpic = $_FILES['fpic'];
        } else {
            $fpic = '';
        }
        if (isset($_FILES['mpic'])) {
            $mpic = $_FILES['mpic'];
        } else {
            $mpic = '';
        }
        if (isset($_FILES['epic'])) {
            $epic = $_FILES['epic'];
        } else {
            $epic = '';
        }
        if (isset($_FILES['gpic'])) {
            $gpic = $_FILES['gpic'];
        } else {
            $gpic = '';
        }
        //print_r($fpic);
        //print_r($mpic);
        //print_r($gpic); die;

        $fatherphone = $postData['fatherphone'];
        $fatheremail = $postData['fatheremail'];
        $motheremail = $postData['motheremail'];
        $motherphone = $postData['motherphone'];


        $result_father = $this->User_model->checkEmail($fatheremail, $motheremail);
        $result_mother = $this->User_model->checkPhone($fatherphone, $motherphone);


        if ($result_father) {
            $return['success'] = "false";
            $return['message'] = "Already Exists.";
            $return['err_message'] = "Father or Mother Email id already exists.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($result_mother) {
            $return['success'] = "false";
            $return['message'] = "Already Exists.";
            $return['err_message'] = "Father or Mother Phone Number already exists.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }


        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Parent Profile Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $uploadPath = 'img/parent/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['fpic']['name'])) {
            if (!$this->upload->do_upload('fpic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg1 = $this->upload->data();
                $fpic = $uplodimg1['file_name'];
            }
        }
        if (!empty($_FILES['mpic']['name'])) {
            if (!$this->upload->do_upload('mpic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg2 = $this->upload->data();
                $mpic = $uplodimg2['file_name'];
            }
        }
        if (!empty($_FILES['epic']['name'])) {
            if (!$this->upload->do_upload('epic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg3 = $this->upload->data();
                $epic = $uplodimg3['file_name'];
            }
        }

        if (!empty($_FILES['gpic']['name'])) {
            if (!$this->upload->do_upload('gpic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg3 = $this->upload->data();
                $gpic = $uplodimg3['file_name'];
            }
        }
        $schoolId = $postData['schoolId'];
        $fatherfname = $postData['fatherfname'];
        $fatherlname = $postData['fatherlname'];
        $fatheroccupation = $postData['fatheroccupation'];
        $fatheremail = $postData['fatheremail'];
        $fatherphone = $postData['fatherphone'];
        $fatheraddress = $postData['fatheraddress'];
        $fcity = $postData['fcity'];
        $fstate = $postData['fstate'];
        $fpincode = $postData['fpincode'];
        $fcountry = $postData['fcountry'];
        $motherfname = $postData['motherfname'];
        $motherlname = $postData['motherlname'];
        $motheroccupation = $postData['motheroccupation'];
        $motheremail = $postData['motheremail'];
        $motherphone = $postData['motherphone'];
        $motheraddress = $postData['motheraddress'];
        $mcity = $postData['mcity'];
        $mstate = $postData['mstate'];
        $mpincode = $postData['mpincode'];
        $mcountry = $postData['mcountry'];
        $emergencyfname = $postData['emergencyfname'];
        $emergencylname = $postData['emergencylname'];
        $emergencyemail = $postData['emergencyemail'];
        $emergencyphone = $postData['emergencyphone'];
        $emergencyaddress = $postData['emergencyaddress'];
        $ecity = $postData['ecity'];
        $estate = $postData['estate'];
        $epincode = $postData['epincode'];
        $ecountry = $postData['ecountry'];

        $guardianfname = $postData['guardianfname'];
        $guardianlname = $postData['guardianlname'];
        $guardianemail = $postData['guardianemail'];
        $guardianphone = $postData['guardianphone'];
        $guardianaddress = $postData['guardianaddress'];
        $gcity = $postData['gcity'];
        $gstate = $postData['gstate'];
        $gpincode = $postData['gpincode'];
        $gcountry = $postData['gcountry'];
        $created_date = date('Y-m-d H:i:s');

        $addArr = array(
            'schoolId' => $schoolId,
            'fatherfname' => $fatherfname,
            'fatherlname' => $fatherlname,
            'fatheroccupation' => $fatheroccupation,
            'fatheremail' => $fatheremail,
            'fatherphone' => $fatherphone,
            'fatheraddress' => $fatheraddress,
            'fcity' => $fcity,
            'fstate' => $fstate,
            'fpincode' => $fpincode,
            'fcountry' => $fcountry,
            'motherfname' => $motherfname,
            'motherlname' => $motherlname,
            'motheroccupation' => $motheroccupation,
            'motheremail' => $motheremail,
            'motherphone' => $motherphone,
            'motheraddress' => $motheraddress,
            'mcity' => $mcity,
            'mstate' => $mstate,
            'mpincode' => $mpincode,
            'mcountry' => $mcountry,
            'emergencyfname' => $emergencyfname,
            'emergencylname' => $emergencylname,
            'emergencyemail' => $emergencyemail,
            'emergencyphone' => $emergencyphone,
            'emergencyaddress' => $emergencyaddress,
            'ecity' => $ecity,
            'estate' => $estate,
            'epincode' => $epincode,
            'ecountry' => $ecountry,
            'fatherphoto' => $fpic,
            'motherphoto' => $mpic,
            'emergencyphoto' => $epic,
            'status' => '1',
            'created_date' => $created_date,
        );

        $add = $this->User_model->addParent($addArr);

        $addGuardianArr = array(
            'parent_id' => $add,
            'school_id' => $schoolId,
            'fname' => $guardianfname,
            'lname' => $guardianlname,
            'email' => $guardianemail,
            'phone' => $guardianphone,
            'address' => $guardianaddress,
            'city' => $gcity,
            'state' => $gstate,
            'pincode' => $gpincode,
            'country' => $gcountry,
            'photo' => $gpic,
            'status' => '1',
            'created_date' => date('Y-m-d'),
        );
        if ($guardianfname != '' && $guardianemail != '') {
            $addGuardian = $this->User_model->addParentGuardian($addGuardianArr);
        }

        if ($add)
        {
            $userID = 'P-'.$add;
            $moduleData=array('Event','Chat','Assignment','Project','Exam','Class Board','Class Schedule');
            $settingArray=array();
            $i=0;
            foreach($moduleData as $module) {
                $settingArray[$i]['module_name'] = $module;
                $settingArray[$i]['school_id'] = $schoolId;
                $settingArray[$i]['user_id'] = $userID;
                $settingArray[$i]['user_type'] = 'parent';
                $settingArray[$i]['is_web'] = '1';
                $settingArray[$i]['is_push'] = '1';
                $i++;
            }
            $this->db->insert_batch('notification_settings',$settingArray);
//            var_dump($add);
        }

        if ($add) {
            $emailsubject = "<h2 style='margin:0; padding:5px 0 10px;margin-bottom:15px; border-bottom: 1px solid #bbb8af;color: #020a65;'>Your children's school Registered you as Parent in Kidyview system.</h2>";

            $to = $fatheremail;
            $cc1 = $motheremail;
            $cc2 = $emergencyemail;
            $message = '<table width="614px" align="center" style="background: #F1F1F1;"><tr><td><div style="width:614px; border:1px solid #efefef; font: normal 12px Verdana, Arial, Helvetica, sans-serif; padding:2px; border:1px solid #ccc; margin:0px auto; 0">
				<div style="background:#fff; padding:15px 10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				<td align="center"><img src="' . base_url() . 'img/small_logo.png" width="150px" height="100px" alt="" /></td>
				</tr>
				</table>
				</div>
				<div style="min-height:300px; padding:10px;">' . $emailsubject . '					
				<table width="100%" border="0" cellspacing="0" cellpadding="0">';
            $sdata = $this->session->userdata('user_data');
            $edata['school_name'] = $sdata['school_name'];
            $edata['name'] = isset($fatherfname) && $fatherfname != '' ? $fatherfname : $mothername;
            $message = $this->load->view('emailtemplate/parentRegisterTemplate', $edata, true);
            $mailResponse = sendKidyviewEmail($to, $cc1, $cc2, '', 'A registration email for kidyview', $message);
        }

        if ($add) {
            $return['success'] = "true";
            $return['message'] = "Parent added successfully.";
            $return['error'] = $this->error;
            $return['data'] = $add;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function addTeacher_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
//        var_dump($postData);
        //echo $postData['password'];die;
        $this->load->library('settings');
        if (isset($_FILES['health'])) {
            $health = $_FILES['health'];
        } else {
            $health = '';
        }
        if (isset($_FILES['identification'])) {
            $identification = $_FILES['identification'];
        } else {
            $identification = '';
        }
        if (isset($_FILES['teacherphoto'])) {
            $teacherphoto = $_FILES['teacherphoto'];
        } else {
            $teacherphoto = '';
        }
        $experiancefields = json_decode($postData['experiancefields']);
        //print_r($experiancefields); die;
        //print_r($teacherphoto);
        //print_r($identification);
        //print_r($health); die;

        $teacherphone = $postData['teacherphone'];
        $teacheremail = $postData['teacheremail'];
        $signatureImg = "";


        $result = $this->User_model->teacherExist($teacheremail, $teacherphone);

        if ($result) {
            $return['success'] = "false";
            $return['message'] = "Already Exists.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }


        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Teacher Profile Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $uploadPath = 'img/teacher/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['health']['name'])) {
            if (!$this->upload->do_upload('health')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg1 = $this->upload->data();
                $health = $uplodimg1['file_name'];
            }
        }
        if (!empty($_FILES['identification']['name'])) {
            if (!$this->upload->do_upload('identification')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg2 = $this->upload->data();
                $identification = $uplodimg2['file_name'];
            }
        }
        if (!empty($_FILES['teacherphoto']['name'])) {
            if (!$this->upload->do_upload('teacherphoto')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg2 = $this->upload->data();
                $teacherphoto = $uplodimg2['file_name'];
            }
        }

        if (!empty($_FILES['signatureImg']['name'])) {


            if (!$this->upload->do_upload('signatureImg')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $signImg = $this->upload->data();
                $signatureImg = $signImg['file_name'];
            }
        }

        $schoolId = $postData['schoolId'];
        $teacherfname = $postData['teacherfname'];
        $teachermname = $postData['teachermname'];
        $teacherlname = $postData['teacherlname'];
        $teacheremail = $postData['teacheremail'];
        $teacherphone = $postData['teacherphone'];
        $teachergender = $postData['teachergender'];
        $maritalStatus = $postData['maritalStatus'];
        $spousename = $postData['spousename'];
        $spousenumber = $postData['spousenumber'];
        $date_of_joining = $postData['date_of_joining'];
        $bloodgroup = $postData['bloodgroup'];
        $date_of_birth = $postData['date_of_birth'];
        $religion = $postData['religion'];
        $schoolType = $postData['schoolType'];
        $assignclassteacher = $postData['assignclassteacher'];
        $subjectteacher = $postData['subjectteacher'];
        $teacheraddress = $postData['teacheraddress'];
        $tcountry = $postData['tcountry'];
        $tstate = $postData['tstate'];
        $tcity = $postData['tcity'];
        $tpincode = $postData['tpincode'];
        $workexp = $postData['workexp'];

        $addArr = array(
            'schoolId' => $schoolId,
            'teacherfname' => $teacherfname,
            'teachermname' => $teachermname,
            'teacherlname' => $teacherlname,
            'teacheremail' => $teacheremail,
            'teacherphone' => $teacherphone,
            'teachergender' => $teachergender,
            'maritalStatus' => $maritalStatus,
            'spousename' => $spousename,
            'spousenumber' => $spousenumber,
            'date_of_joining' => $date_of_joining,
            'bloodgroup' => $bloodgroup,
            'date_of_birth' => $date_of_birth,
            'religion' => $religion,
            'schoolType' => $schoolType,
            'assignclassteacher' => $assignclassteacher,
            'subjectteacher' => $subjectteacher,
            'teacheraddress' => $teacheraddress,
            'tcountry' => $tcountry,
            'tstate' => $tstate,
            'tcity' => $tcity,
            'tpincode' => $tpincode,
            'workexperience' => $workexp,
            'certificate' => $health,
            'document' => $identification,
            'teacherphoto' => $teacherphoto,
            'signatureImg' => $signatureImg,
            'password' => $this->settings->encryptString($postData['password']),
            'status' => '1',
            'created_date' => date('Y-m-d H:i:s'),
        );
        //print_r($addArr); die;
        $add = $this->User_model->addTeacher($addArr);
//        var_dump('id:'.$add);
        if ($add)
        {
            $userID = 'T-'.$add;
            $moduleData=array('Event','Chat','Assignment','Project','Exam','Class Board','Class Schedule');
            $settingArray=array();
            $i=0;
            foreach($moduleData as $module) {
                $settingArray[$i]['module_name'] = $module;
                $settingArray[$i]['school_id'] = $schoolId;
                $settingArray[$i]['user_id'] = $userID;
                $settingArray[$i]['user_type'] = 'teacher';
                $settingArray[$i]['is_web'] = '1';
                $settingArray[$i]['is_push'] = '1';
                $i++;
            }
            $this->db->insert_batch('notification_settings',$settingArray);
//            var_dump($add);
        }
        if ($add) {
            $emailsubject = "<h2 style='margin:0; padding:5px 0 10px;margin-bottom:15px; border-bottom: 1px solid #bbb8af;color: #020a65;'>Your school Register you as Teacher in Kidyview system.</h2>";

            $to = $teacheremail;
            $message = '<table width="614px" align="center" style="background: #F1F1F1;"><tr><td><div style="width:614px; border:1px solid #efefef; font: normal 12px Verdana, Arial, Helvetica, sans-serif; padding:2px; border:1px solid #ccc; margin:0px auto; 0">
				<div style="background:#fff; padding:15px 10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				<td align="center"><img src="' . base_url() . 'img/small_logo.png" width="150px" height="100px" alt="" /></td>
				</tr>
				</table>
				</div>
				<div style="min-height:300px; padding:10px;">' . $emailsubject . ' </div>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				<td height="25">Login Id</td>
				<td height="25">:</td>
				<td height="25">' . $to . '</td>
				</tr>
				<tr>
				<td height="25">Password</td>
				<td height="25">:</td>
				<td height="25">' . $postData['password'] . '</td>
				</tr>
				<tr>
				<td height="25">Please click below url for login:</td>
				<td height="25">:</td>
				<td height="25"><a href="' . base_url() . 'teacherlogin" style = "color: #fff; border: 1px solid #000; background: #3C9F06;">Login Here</a></td>
				</tr>
				</table>';

            //$mailResponse = $this->sendMail($to, "A registration email for kidyview", $message);
            //$edata['f']=$teacherfname;
            $sdata = $this->session->userdata('user_data');
            $edata['school_name'] = $sdata['school_name'];
            $edata['name'] = $teacherfname . ' ' . $teacherlname;
            $message = $this->load->view('emailtemplate/teacherRegisterTemplate', $edata, true);
            $mailResponse = sendKidyviewEmail($to, '', '', '', 'A registration email for kidyview', $message);

        }

        if ($add) {
            $educationalfields = json_decode($postData['educationalfields']);
            $experiancefields = json_decode($postData['experiancefields']);
            if (!empty($educationalfields)) {
                $data = array();
                for ($i = 0; $i < count($educationalfields); $i++) {
                    $data['qualification'] = $educationalfields[$i]->qualification;
                    $data['yearofpassing'] = $educationalfields[$i]->year_of_passing;
                    $data['percentage'] = $educationalfields[$i]->percentage;
                    $data['board'] = $educationalfields[$i]->board;
                    $data['certificate'] = $educationalfields[$i]->educationcertificate;
                    $data['teacher_id'] = $add;
                    $data['schoolId'] = $schoolId;

                    $add1 = $this->User_model->addTeacherEducationalFields($data);
                }
            }

            if (!empty($experiancefields)) {
                $data1 = array();
                for ($i = 0; $i < count($experiancefields); $i++) {
                    $data1['schoolname'] = $experiancefields[$i]->schoolname;
                    $data1['numberofyears'] = $experiancefields[$i]->numofyears;
                    $data1['designation'] = $experiancefields[$i]->designation;
                    $data1['datefrom'] = date_format(date_create($experiancefields[$i]->datefrom), "Y-m-d");
                    $data1['dateto'] = date_format(date_create($experiancefields[$i]->dateto), "Y-m-d");
                    $data1['employercertificate'] = $experiancefields[$i]->experiencecertificate;
                    $data1['teacher_id'] = $add;
                    $data1['schoolId'] = $schoolId;

                    $add2 = $this->User_model->addTeacherExperianceFields($data1);
                }
            }
        }

        if ($add) {
            $return['success'] = "true";
            $return['message'] = "Teacher added successfully.";
            $return['error'] = $this->error;
            $return['data'] = $add;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function editTeacher_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        //print_r($postData); die;
        if (isset($_FILES['health'])) {
            $health = $_FILES['health'];
        } else {
            $health = $postData['healthnew'];
        }
        if (isset($_FILES['identification'])) {
            $identification = $_FILES['identification'];
        } else {
            $identification = $postData['identificationnew'];
        }
        if (isset($_FILES['teacherphoto'])) {
            $teacherphoto = $_FILES['teacherphoto'];
        } else {
            $teacherphoto = $postData['teacherphotonew'];
        }
        $educationalfields = json_decode($postData['educationalfields']);
        $experiancefields = json_decode($postData['experiancefields']);
        $signatureImg = "";

        $teacherphone = $postData['teacherphone'];
        $teacheremail = $postData['teacheremail'];
        $teacherId = $postData['teacherId'];
        $result = $this->User_model->teacherExistInEditCase($teacheremail, $teacherphone, $teacherId);

        if ($result) {
            $return['success'] = "false";
            $return['message'] = "Already Exists.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }

        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Teacher Profile Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $uploadPath = 'img/teacher/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['health']['name'])) {
            if (!$this->upload->do_upload('health')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg1 = $this->upload->data();
                $health = $uplodimg1['file_name'];
            }
        }
        if (!empty($_FILES['identification']['name'])) {
            if (!$this->upload->do_upload('identification')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg2 = $this->upload->data();
                $identification = $uplodimg2['file_name'];
            }
        }
        if (!empty($_FILES['teacherphoto']['name'])) {
            if (!$this->upload->do_upload('teacherphoto')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg2 = $this->upload->data();
                $teacherphoto = $uplodimg2['file_name'];
            }
        }

        if (!empty($_FILES['signatureImg']['name'])) {


            if (!$this->upload->do_upload('signatureImg')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $signImg = $this->upload->data();
                $signatureImg = $signImg['file_name'];
            }
        }


        $teacherId = $postData['teacherId'];
        $schoolId = $postData['schoolId'];
        $teacherfname = $postData['teacherfname'];
        $teachermname = $postData['teachermname'];
        $teacherlname = $postData['teacherlname'];
        $teacheremail = $postData['teacheremail'];
        $teacherphone = $postData['teacherphone'];
        $teachergender = $postData['teachergender'];
        $maritalStatus = $postData['maritalStatus'];
        $spousename = $postData['spousename'];
        $spousenumber = $postData['spousenumber'];
        $date_of_joining = $postData['date_of_joining'];
        $bloodgroup = $postData['bloodgroup'];
        $date_of_birth = $postData['date_of_birth'];
        $religion = $postData['religion'];
        $schoolType = $postData['schoolType'];
        $assignclassteacher = $postData['assignclassteacher'];
        $subjectteacher = $postData['subjectteacher'];
        $teacheraddress = $postData['teacheraddress'];
        $tcountry = $postData['tcountry'];
        $tstate = $postData['tstate'];
        $tcity = $postData['tcity'];
        $tpincode = $postData['tpincode'];
        $workexp = $postData['workexp'];


        $updateArr['teacherfname'] = $teacherfname;
        $updateArr['teachermname'] = $teachermname;
        $updateArr['teacherlname'] = $teacherlname;
        $updateArr['teacheremail'] = $teacheremail;
        $updateArr['teacherphone'] = $teacherphone;
        $updateArr['teachergender'] = $teachergender;
        $updateArr['maritalStatus'] = $maritalStatus;
        $updateArr['spousename'] = $spousename;
        $updateArr['spousenumber'] = $spousenumber;
        $updateArr['date_of_joining'] = $date_of_joining;
        $updateArr['bloodgroup'] = $bloodgroup;
        $updateArr['date_of_birth'] = $date_of_birth;
        $updateArr['religion'] = $religion;
        $updateArr['schoolType'] = $schoolType;
        $updateArr['assignclassteacher'] = $assignclassteacher;
        $updateArr['subjectteacher'] = $subjectteacher;
        $updateArr['teacheraddress'] = $teacheraddress;
        $updateArr['tcountry'] = $tcountry;
        $updateArr['tstate'] = $tstate;
        $updateArr['tcity'] = $tcity;
        $updateArr['tpincode'] = $tpincode;
        $updateArr['workexperience'] = $workexp;
        $updateArr['certificate'] = $health;
        $updateArr['document'] = $identification;
        $updateArr['teacherphoto'] = $teacherphoto;

        if ($signatureImg != "")
            $updateArr['signatureImg'] = $signatureImg;

        if ($postData['password'] != '') {
            $updateArr['password'] = $this->settings->encryptString($postData['password']);
        }
        //print_r($updateArr); die;
        $update = $this->User_model->editTeacher($updateArr, $teacherId, $schoolId);
        //print_r($educationalfields); die;
        if (!empty($educationalfields)) {
            $data = array();
            $delete1 = $this->User_model->deleteTeacherEducationalFields($teacherId);
            for ($i = 0; $i < count($educationalfields); $i++) {
                $data['qualification'] = $educationalfields[$i]->qualification;
                $data['yearofpassing'] = $educationalfields[$i]->year_of_passing;
                $data['percentage'] = $educationalfields[$i]->percentage;
                $data['board'] = $educationalfields[$i]->board;
                $data['certificate'] = isset($educationalfields[$i]->educationcertificate) ? $educationalfields[$i]->educationcertificate : '';
                $data['teacher_id'] = $teacherId;
                $data['schoolId'] = $schoolId;

                $update1 = $this->User_model->updateTeacherEducationalFields($data, $teacherId);
            }
        }
        if (!empty($experiancefields)) {
            $data1 = array();
            $delete2 = $this->User_model->deleteTeacherExperianceFields($teacherId);
            for ($i = 0; $i < count($experiancefields); $i++) {
                $data1['schoolname'] = $experiancefields[$i]->schoolname;
                $data1['numberofyears'] = $experiancefields[$i]->numofyears;
                $data1['designation'] = $experiancefields[$i]->designation;
                $data1['datefrom'] = date_format(date_create($experiancefields[$i]->datefrom), "Y-m-d");
                $data1['dateto'] = date_format(date_create($experiancefields[$i]->dateto), "Y-m-d");
                $data1['employercertificate'] = isset($experiancefields[$i]->experiencecertificate) ? $experiancefields[$i]->experiencecertificate : '';
                $data1['teacher_id'] = $teacherId;
                $data1['schoolId'] = $schoolId;

                $update2 = $this->User_model->updateTeacherExperianceFields($data1, $teacherId);
            }
        }

        if ($update || $update1 || $update2) {
            $emailsubject = "<h2 style='margin:0; padding:5px 0 10px;margin-bottom:15px; border-bottom: 1px solid #bbb8af;color: #020a65;'>Your school edited your account in Kidyview system.</h2>";

            $to = $teacheremail;
            $message = '<table width="614px" align="center" style="background: #F1F1F1;"><tr><td><div style="width:614px; border:1px solid #efefef; font: normal 12px Verdana, Arial, Helvetica, sans-serif; padding:2px; border:1px solid #ccc; margin:0px auto; 0">
				<div style="background:#fff; padding:15px 10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				<td align="center"><img src="' . base_url() . 'img/small_logo.png" width="150px" height="100px" alt="" /></td>
				</tr>
				</table>
				</div>
				<div style="min-height:300px; padding:10px;">' . $emailsubject . '</div>';
            if ($postData['password'] != '') {
                $message .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				<td height="25">Login Id</td>
				<td height="25">:</td>
				<td height="25">' . $to . '</td>
				</tr>
				<tr>
				<td height="25">Password</td>
				<td height="25">:</td>
				<td height="25">' . $postData['password'] . '</td>
				</tr>
				<tr>
				<td height="25">Please click below url for login:</td>
				<td height="25">:</td>
				<td height="25"><a href="' . base_url() . 'teacherlogin" style = "color: #fff; border: 1px solid #000; background: #3C9F06;">Login Here</a></td>
				</tr>
				</table>';
            }

            //$mailResponse = $this->sendMail($to, "A Edit reminder email for kidyview", $message);
            $mailResponse = sendKidyviewEmail($to, '', '', '', 'A Edit reminder email for kidyview', $message);
        }

        if ($update || $update1 || $update2) {
            $return['success'] = "true";
            $return['message'] = "Teacher updated successfully.";
            $return['error'] = $this->error;
            $return['data'] = $update;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function uploadEducationcertificate_post()
    {
        if (count($_FILES) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Education Certificate Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $uploadPath = 'img/teacher/education/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['educationcertificate']['name'])) {
            if (!$this->upload->do_upload('educationcertificate')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg1 = $this->upload->data();
                $educationcertificate = $uplodimg1['file_name'];
                $return['success'] = "true";
                $return['message'] = "Education Certificate uploaded successfully.";
                $return['error'] = $this->error;
                $return['data'] = $educationcertificate;
                $this->response($return, REST_Controller::HTTP_OK);
            }
        }
    }

    public function uploadExperienceCertificate_post()
    {


        if (count($_FILES) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Experience Certificate Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $uploadPath = 'img/teacher/experience/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['experiencecertificate']['name'])) {
            if (!$this->upload->do_upload('experiencecertificate')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg1 = $this->upload->data();
                $experiencecertificate = $uplodimg1['file_name'];
                $return['success'] = "true";
                $return['message'] = "Experience Certificate uploaded successfully.";
                $return['error'] = $this->error;
                $return['data'] = $experiencecertificate;
                $this->response($return, REST_Controller::HTTP_OK);
            }
        }
    }

    public function editParent_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        if (isset($_FILES['fpic'])) {
            $fpic = $_FILES['fpic'];
        } else {
            $fpic = $postData['fatherphoto'];
        }
        if (isset($_FILES['mpic'])) {
            $mpic = $_FILES['mpic'];
        } else {
            $mpic = $postData['motherphoto'];
        }
        if (isset($_FILES['epic'])) {
            $epic = $_FILES['epic'];
        } else {
            $epic = $postData['emergencyphoto'];
        }
        /* if(isset($_FILES['gpic'])) {
				$gpic = $_FILES['gpic'];
				} else {
				$gpic = $postData['guardianphoto'];
			} */

        //print_r($fpic);
        //print_r($mpic);
        //print_r($gpic); die;
        // prd($postData);
        $fatherphone = $postData['fatherphone'];
        $fatheremail = $postData['fatheremail'];
        $motheremail = $postData['motheremail'];
        $motherphone = $postData['motherphone'];
        $parentID = $postData['parentID'];
        $result = $this->User_model->parentExistInEditCase($fatheremail, $fatherphone, $motheremail, $motherphone, $parentID);
// lq();
        $parentId = '';
        if (!empty($result)) {
            $parentId = $result->id;
            if ($parentId == $parentID) {

            } else {
                $return['success'] = "false";
                $return['message'] = "Already Exists.";
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        // if ($result) {
        // 	$return['success'] = "false";
        // 	$return['message'] = "Already Exists.";
        // 	$return['error'] = $this->error;
        // 	$return['data'] = $this->data;

        // 	$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        // }

        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Parent Profile Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $uploadPath = 'img/parent/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['fpic']['name'])) {
            if (!$this->upload->do_upload('fpic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg1 = $this->upload->data();
                $fpic = $uplodimg1['file_name'];
            }
        }
        if (!empty($_FILES['mpic']['name'])) {
            if (!$this->upload->do_upload('mpic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg2 = $this->upload->data();
                $mpic = $uplodimg2['file_name'];
            }
        }
        if (!empty($_FILES['epic']['name'])) {
            if (!$this->upload->do_upload('epic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg3 = $this->upload->data();
                $epic = $uplodimg3['file_name'];
            }
        }
        /* if (!empty($_FILES['gpic']['name'])) {
				if (!$this->upload->do_upload('gpic')) {
				$uploaderror = $this->upload->display_errors();
				$return['success'] = "false";
				$return['message'] = $uploaderror;
				$return['error'] = $this->error;
				$return['data'] = $this->data;

				$this->response($return, REST_Controller::HTTP_BAD_REQUEST);
				} else {
				$uplodimg3 = $this->upload->data();
				$gpic = $uplodimg3['file_name'];
				}
			} */
        $schoolId = $postData['schoolId'];
        $parentID = $postData['parentID'];
        $fatherfname = $postData['fatherfname'];
        $fatherlname = $postData['fatherlname'];
        $fatheroccupation = $postData['fatheroccupation'];
        $fatheremail = $postData['fatheremail'];
        $fatherphone = $postData['fatherphone'];
        $fatheraddress = $postData['fatheraddress'];
        $fcity = $postData['fcity'];
        $fstate = $postData['fstate'];
        $fpincode = $postData['fpincode'];
        $fcountry = $postData['fcountry'];
        $motherfname = $postData['motherfname'];
        $motherlname = $postData['motherlname'];
        $motheroccupation = $postData['motheroccupation'];
        $motheremail = $postData['motheremail'];
        $motherphone = $postData['motherphone'];
        $motheraddress = $postData['motheraddress'];
        $mcity = $postData['mcity'];
        $mstate = $postData['mstate'];
        $mpincode = $postData['mpincode'];
        $mcountry = $postData['mcountry'];
        $emergencyfname = $postData['emergencyfname'];
        $emergencylname = $postData['emergencylname'];
        $emergencyemail = $postData['emergencyemail'];
        $emergencyphone = $postData['emergencyphone'];
        $emergencyaddress = $postData['emergencyaddress'];
        $ecity = $postData['ecity'];
        $estate = $postData['estate'];
        $epincode = $postData['epincode'];
        $ecountry = $postData['ecountry'];
        /* $guardianfname = $postData['guardianfname'];
				$guardianlname = $postData['guardianlname'];
				$guardianemail = $postData['guardianemail'];
				$guardianphone = $postData['guardianphone'];
				$guardianaddress = $postData['guardianaddress'];
				$gcity = $postData['gcity'];
				$gstate = $postData['gstate'];
				$gpincode = $postData['gpincode'];
			$gcountry = $postData['gcountry']; */

        /* $updateArr = array(
				'fatherfname' => $fatherfname,
				'fatherlname' => $fatherlname,
				'fatheroccupation' => $fatheroccupation,
				'fatheremail' => $fatheremail,
				'fatherphone' => $fatherphone,
				'fatheraddress' => $fatheraddress,
				'fcity' => $fcity,
				'fstate' => $fstate,
				'fpincode' => $fpincode,
				'fcountry' => $fcountry,
				'motherfname' => $motherfname,
				'motherlname' => $motherlname,
				'motheroccupation' => $motheroccupation,
				'motheremail' => $motheremail,
				'motherphone' => $motherphone,
				'motheraddress' => $motheraddress,
				'mcity' => $mcity,
				'mstate' => $mstate,
				'mpincode' => $mpincode,
				'mcountry' => $mcountry,
				'guardianfname' => $guardianfname,
				'guardianlname' => $guardianlname,
				'guardianemail' => $guardianemail,
				'guardianphone' => $guardianphone,
				'guardianaddress' => $guardianaddress,
				'gcity' => $gcity,
				'gstate' => $gstate,
				'gpincode' => $gpincode,
				'gcountry' => $gcountry,
				'fatherphoto' => $fpic,
				'motherphoto' => $mpic,
				'guardianphoto' => $gpic,
			); */

        $updateArr = array(
            'fatherfname' => $fatherfname,
            'fatherlname' => $fatherlname,
            'fatheroccupation' => $fatheroccupation,
            'fatheremail' => $fatheremail,
            'fatherphone' => $fatherphone,
            'fatheraddress' => $fatheraddress,
            'fcity' => $fcity,
            'fstate' => $fstate,
            'fpincode' => $fpincode,
            'fcountry' => $fcountry,
            'motherfname' => $motherfname,
            'motherlname' => $motherlname,
            'motheroccupation' => $motheroccupation,
            'motheremail' => $motheremail,
            'motherphone' => $motherphone,
            'motheraddress' => $motheraddress,
            'mcity' => $mcity,
            'mstate' => $mstate,
            'mpincode' => $mpincode,
            'mcountry' => $mcountry,
            'emergencyfname' => $emergencyfname,
            'emergencylname' => $emergencylname,
            'emergencyemail' => $emergencyemail,
            'emergencyphone' => $emergencyphone,
            'emergencyaddress' => $emergencyaddress,
            'ecity' => $ecity,
            'estate' => $estate,
            'epincode' => $epincode,
            'ecountry' => $ecountry,
            'fatherphoto' => $fpic,
            'motherphoto' => $mpic,
            'emergencyphoto' => $epic,
        );
        // prd($updateArr);
        $update = $this->User_model->editParent($updateArr, $parentID, $schoolId);

        if ($update) {
            $emailsubject = "<h2 style='margin:0; padding:5px 0 10px;margin-bottom:15px; border-bottom: 1px solid #bbb8af;color: #020a65;'>Your Account has been edited in Kidyview system.</h2>";

            $to = $fatheremail;
            $cc1 = $motheremail;
            $cc2 = $emergencyemail;
            $message = '<table width="614px" align="center" style="background: #F1F1F1;"><tr><td><div style="width:614px; border:1px solid #efefef; font: normal 12px Verdana, Arial, Helvetica, sans-serif; padding:2px; border:1px solid #ccc; margin:0px auto; 0">
				<div style="background:#fff; padding:15px 10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				<td align="center"><img src="' . base_url() . 'img/small_logo.png" width="150px" height="100px" alt="" /></td>
				</tr>
				</table>
				</div>
				<div style="min-height:300px; padding:10px;">' . $emailsubject . '					
				<table width="100%" border="0" cellspacing="0" cellpadding="0">';

            //$mailResponse = $this->sendMailForCC($to, $cc1, $cc2, "An edit account reminder email for kidyview", $message);
            $mailResponse = sendKidyviewEmail($to, $cc1, $cc2, '', 'An edit account reminder email for kidyview', $message);
        }
        // echo $update;
        // lq();
        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Parent edited successfully.";
            $return['error'] = $this->error;
            $return['data'] = $update;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = 'already-updated';

            $this->response($return, REST_Controller::HTTP_OK);
        }
    }

    public function editDriver_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $driverphone = $postData['driverphone'];
        $driveremail = $postData['driveremail'];
        $driverId = $postData['id'];
        $result = $this->User_model->driverExistInEditCase($driveremail, $driverphone, $driverId);
        if ($result) {
            $return['success'] = "false";
            $return['message'] = "Already Exists.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }

        if (isset($_FILES['pic'])) {
            $pic = $_FILES['pic'];
        } else {
            $pic = $postData['driverphoto'];
        }
        if (isset($_FILES['document'])) {
            $document = $_FILES['document'];
        } else {
            $document = $postData['driverdocument'];
        }
        //print_r($pic);
        //print_r($document); die;

        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Driver Profile Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $uploadPath = 'img/driver/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['pic']['name'])) {
            if (!$this->upload->do_upload('pic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg1 = $this->upload->data();
                $pic = $uplodimg1['file_name'];
            }
        }
        if (!empty($_FILES['document']['name'])) {
            if (!$this->upload->do_upload('document')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg2 = $this->upload->data();
                $document = $uplodimg2['file_name'];
            }
        }

        $id = $postData['id'];
        $driverfname = $postData['driverfname'];
        $driverlname = $postData['driverlname'];
        $driveremail = $postData['driveremail'];
        $driverphone = $postData['driverphone'];
        $driverdeviceId = $postData['driverdeviceId'];
        $drivervehicle = $postData['drivervehicle'];
        $driverroute = $postData['driverroute'];
        $driverlicense = $postData['driverlicense'];
        $driverLicenseExpire = $postData['driverLicenseExpire'];
        $schoolId = $postData['schoolId'];
        $driveraddress = $postData['driveraddress'];
        $dpincode = $postData['dpincode'];
        $dcity = $postData['dcity'];
        $dstate = $postData['dstate'];
        $dcountry = $postData['dcountry'];
        $emergencyfname = $postData['emergencyfname'];
        $emergencylname = $postData['emergencylname'];
        $emergencyphone = $postData['emergencyphone'];
        $emergencyemail = $postData['emergencyemail'];

        $updateArr = array(
            'driverfname' => $driverfname,
            'driverlname' => $driverlname,
            'driveremail' => $driveremail,
            'driverphone' => $driverphone,
            'driverdeviceId' => $driverdeviceId,
            'driverVechiclenumber' => $drivervehicle,
            'driverroute' => $driverroute,
            'driverlicense' => $driverlicense,
            'driverLicenseExpire' => $driverLicenseExpire,
            'driverphoto' => $pic,
            'driverdocument' => $document,
            'driveraddress' => $driveraddress,
            'dpincode' => $dpincode,
            'dcity' => $dcity,
            'dstate' => $dstate,
            'dcountry' => $dcountry,
            'emergencyfname' => $emergencyfname,
            'emergencylname' => $emergencylname,
            'emergencyphone' => $emergencyphone,
            'emergencyemail' => $emergencyemail,
            'driverphoto' => $pic,
            'driverdocument' => $document,
        );
        //print_r($updateArr); die;
        $update = $this->User_model->editDriver($updateArr, $id, $schoolId);
        if ($update) {
            $emailsubject = "<h2 style='margin:0; padding:5px 0 10px;margin-bottom:15px; border-bottom: 1px solid #bbb8af;color: #020a65;'>Your School Edited Your Account in Kidyview system.</h2>";

            $to = $driveremail;
            $cc1 = $emergencyemail;
            $cc2 = '';
            $message = '<table width="614px" align="center" style="background: #F1F1F1;"><tr><td><div style="width:614px; border:1px solid #efefef; font: normal 12px Verdana, Arial, Helvetica, sans-serif; padding:2px; border:1px solid #ccc; margin:0px auto; 0">
				<div style="background:#fff; padding:15px 10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				<td align="center"><img src="' . base_url() . 'img/small_logo.png" width="150px" height="100px" alt="" /></td>
				</tr>
				</table>
				</div>
				<div style="min-height:300px; padding:10px;">' . $emailsubject . '					
				<table width="100%" border="0" cellspacing="0" cellpadding="0">';

            //$mailResponse = $this->sendMailForCC($to, $cc1, $cc2, "An edit account reminder email for kidyview", $message);
            $mailResponse = sendKidyviewEmail($to, $cc1, $cc2, '', 'An edit account reminder email for kidyview', $message);
        }

        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Driver edited successfully.";
            $return['error'] = $this->error;
            $return['data'] = $update;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function editSession_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $id = $postData['id'];
        $academicsession = $postData['academicsession'];
        $sessionstart = $postData['sessionstart'];
        $formattedsessionstart = $postData['formattedsessionstart'];
        $sessionend = $postData['sessionend'];
        $formattedsessionend = $postData['formattedsessionend'];
        $schoolId = $postData['schoolId'];

        $updateArr = array(
            'academicsession' => $academicsession,
            'sessionstart' => $sessionstart,
            'sessionend' => $sessionend,
            'formattedsessionstart' => $formattedsessionstart,
            'formattedsessionend' => $formattedsessionend,
        );
        //print_r($updateArr); die;
        $update = $this->User_model->editSession($updateArr, $id, $schoolId);

        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Session edited successfully.";
            $return['error'] = $this->error;
            $return['data'] = $update;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function editTerm_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $id = $postData['id'];
        $termname = $postData['term'];
        $academicsession = $postData['academicsession'];
        $termstart = $postData['termstart'];
        $formattedtermstart = $postData['formattedtermstart'];
        $termend = $postData['termend'];
        $formattedtermend = $postData['formattedtermend'];
        $schoolId = $postData['schoolId'];

        $updateArr = array(
            'termname' => $termname,
            'academicsession' => $academicsession,
            'termstart' => $termstart,
            'termend' => $termend,
            'formattedtermstart' => $formattedtermstart,
            'formattedtermend' => $formattedtermend,
        );
        //print_r($updateArr); die;
        $update = $this->User_model->editTerm($updateArr, $id, $schoolId);

        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Term edited successfully.";
            $return['error'] = $this->error;
            $return['data'] = $update;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function editClass_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $id = $postData['id'];
        $academicsession = $postData['academicsession'];
        $class = $postData['class'];
        $section = $postData['section'];
        $school_type = $postData['school_type'];
        $schoolId = $postData['schoolId'];

        $updateArr = array(
            'academicsession' => $academicsession,
            'class' => $class,
            'section' => $section,
            'school_type' => $school_type
        );

        //print_r($updateArr); die;
        $update = $this->User_model->editClass($updateArr, $id, $schoolId);
        if ($update == 'Already Exists.') {
            $return['success'] = "true";
            $return['message'] = "Section Already Exists.";
            $return['error'] = $this->error;
            $return['data'] = $update;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Class edited successfully.";
            $return['error'] = $this->error;
            $return['data'] = $update;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function editDiscussionCat_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $id = $postData['id'];
        $name = $postData['name'];
        $schoolId = $postData['schoolId'];

        $updateArr = array(
            'name' => $name,
        );

        //print_r($updateArr); die;
        $update = $this->User_model->editDiscussionCat($updateArr, $id, $schoolId);

        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Discussion Category edited successfully.";
            $return['error'] = $this->error;
            $return['data'] = $update;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function editSubject_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $id = $postData['id'];
        $subject = $postData['subject'];
        $schoolId = $postData['schoolId'];
        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Subject Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $pic = '';
            $uploadPath = 'img/subject/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['pic']['name'])) {
            if (!$this->upload->do_upload('pic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg = $this->upload->data();
                $pic = $uplodimg['file_name'];
            }
        }
        $updateArr['subject'] = $subject;
        $updateArr['type'] = $postData['type'];
        $updateArr['class'] = $postData['class'];
        $updateArr['teacher'] = $postData['teacher'];
        $updateArr['description'] = $postData['description'];
        if ($pic != '') {
            $updateArr['image'] = $pic;
        }
        $update = $this->User_model->editSubject($updateArr, $id, $schoolId);


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Subject edited successfully.";
            $return['error'] = $this->error;
            $return['data'] = $update;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function editArticle_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $pic = $_FILES;

        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Article Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $pic = '';
            $uploadPath = 'img/article/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['pic']['name'])) {
            if (!$this->upload->do_upload('pic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg = $this->upload->data();
                $pic = $uplodimg['file_name'];
            }
        }
        $title = $postData['title'];
        $description = $postData['description'];
        $schoolId = $postData['schoolId'];

        if ($pic != null) {
            $updateArr = array(
                'title' => $title,
                'schoolId' => $schoolId,
                'description' => $description,
                'pic' => $pic,
            );
        } else {
            $updateArr = array(
                'title' => $title,
                'schoolId' => $schoolId,
                'description' => $description,
            );
        }
        //print_r($updateArr); die;
        $update = $this->User_model->editArticle($updateArr, $id, $schoolId);


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Article edited successfully.";
            $return['error'] = $this->error;
            $return['data'] = $update;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function editThoughtOfTheDay_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];

        $title = $postData['title'];
        $description = $postData['description'];
        $author = $postData['author'];
        $schoolId = $postData['schoolId'];

        $updateArr = array(
            'title' => $title,
            'description' => $description,
            'author_name' => $author,
        );

        //print_r($updateArr); die;
        $update = $this->User_model->editThoughtOfTheDay($updateArr, $id, $schoolId);


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Thought Of THe Day edited successfully.";
            $return['error'] = $this->error;
            $return['data'] = $update;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function editAlbum_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $schoolId = $postData['schoolId'];
        $files = array();
        $pics = array();
        $videos = array();
        if ($postData == '') {
            $postData = $_POST;
        }
        $title = $postData['title'];
        $description = $postData['description'];
        $schoolId = $postData['schoolId'];
        $cnt = count($_FILES);

        for ($x = 0; $x < $cnt; $x++) {
            if (isset($_FILES['pic' . $x])) {
                $pics[$x] = $_FILES['pic' . $x];
            }
            if (isset($_FILES['video' . $x])) {
                $videos[$x] = $_FILES['video' . $x];
            }
        }
        //echo '<pre>'; print_r($pics);
        //echo '<pre>'; print_r($videos); die;
        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Album Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $uploadPath = 'img/album/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        for ($x = 0; $x < count($pics); $x++) {
            $_FILES['f']['name'] = $pics[$x]['name'];
            $_FILES['f']['type'] = $pics[$x]['type'];
            $_FILES['f']['tmp_name'] = $pics[$x]['tmp_name'];
            $_FILES['f']['error'] = $pics[$x]['error'];
            $_FILES['f']['size'] = $pics[$x]['size'];

            if (!empty($_FILES['f']['name'])) {
                if (!$this->upload->do_upload('f')) {
                    $uploaderror = $this->upload->display_errors();
                    $return['success'] = "false";
                    $return['message'] = $uploaderror;
                    $return['error'] = $this->error;
                    $return['data'] = $this->data;

                    $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                } else {
                    $uplodimg = $this->upload->data();
                    //$pic[$x] 	= $uplodimg['file_name'];

                    if ($_FILES['f']['name'] != '') {
                        $addArr1 = array(
                            'albumId' => $id,
                            'status' => '1',
                            'attachment' => $uplodimg['file_name'],
                        );
                    }
                    $add1 = $this->User_model->addAlbumAttachment($addArr1);
                }
            }
        }

        for ($x = 0; $x < count($videos); $x++) {
            $_FILES['f']['name'] = $videos[$x]['name'];
            $_FILES['f']['type'] = $videos[$x]['type'];
            $_FILES['f']['tmp_name'] = $videos[$x]['tmp_name'];
            $_FILES['f']['error'] = $videos[$x]['error'];
            $_FILES['f']['size'] = $videos[$x]['size'];

            if (!empty($_FILES['f']['name'])) {
                if (!$this->upload->do_upload('f')) {
                    $uploaderror = $this->upload->display_errors();
                    $return['success'] = "false";
                    $return['message'] = $uploaderror;
                    $return['error'] = $this->error;
                    $return['data'] = $this->data;

                    $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                } else {
                    $uplodimg = $this->upload->data();
                    //$pic[$x] 	= $uplodimg['file_name'];
                    if ($_FILES['f']['name'] != '') {
                        $addArr2 = array(
                            'albumId' => $id,
                            'status' => '1',
                            'attachment' => $uplodimg['file_name'],
                        );
                    }
                    $add2 = $this->User_model->addAlbumAttachment($addArr2);
                }
            }
        }
        $updateArr = array(
            'title' => $title,
            'description' => $description,
        );
        //print_r($updateArr); die;
        $update = $this->User_model->editAlbum($updateArr, $id, $schoolId);


        if (isset($update) || isset($add1) || isset($add2)) {
            $return['success'] = "true";
            $return['message'] = "Album edited successfully.";
            $return['error'] = $this->error;
            $return['data'] = $update;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function editTimeline_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $schoolId = $postData['schoolId'];
        $files = array();
        $pics = array();
        $videos = array();
        if ($postData == '') {
            $postData = $_POST;
        }
        $description = $postData['description'];
        $schoolId = $postData['schoolId'];
        $cnt = count($_FILES);

        for ($x = 0; $x < $cnt; $x++) {
            if (isset($_FILES['pic' . $x])) {
                $pics[$x] = $_FILES['pic' . $x];
            }
        }
        //echo '<pre>'; print_r($pics);
        //echo '<pre>'; print_r($videos); die;
        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Timeline Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $uploadPath = 'img/timeline/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        for ($x = 0; $x < count($pics); $x++) {
            $_FILES['f']['name'] = $pics[$x]['name'];
            $_FILES['f']['type'] = $pics[$x]['type'];
            $_FILES['f']['tmp_name'] = $pics[$x]['tmp_name'];
            $_FILES['f']['error'] = $pics[$x]['error'];
            $_FILES['f']['size'] = $pics[$x]['size'];

            if (!empty($_FILES['f']['name'])) {
                if (!$this->upload->do_upload('f')) {
                    $uploaderror = $this->upload->display_errors();
                    $return['success'] = "false";
                    $return['message'] = $uploaderror;
                    $return['error'] = $this->error;
                    $return['data'] = $this->data;

                    $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                } else {
                    $uplodimg = $this->upload->data();
                    //$pic[$x] 	= $uplodimg['file_name'];

                    if ($_FILES['f']['name'] != '') {
                        $addArr1 = array(
                            'timeline_id' => $id,
                            'status' => '1',
                            'attachment' => $uplodimg['file_name'],
                        );
                    }
                    $add1 = $this->User_model->addTimelineAttachment($addArr1);
                }
            }
        }
        $updateArr = array(
            'description' => $description,
        );
        //print_r($updateArr); die;
        $update = $this->User_model->editTimeline($updateArr, $id, $schoolId);


        if (isset($update) || isset($add1) || isset($add2)) {
            $return['success'] = "true";
            $return['message'] = "Timeline edited successfully.";
            $return['error'] = $this->error;
            $return['data'] = $update;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function editGoal_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $title = $postData['title'];
        $description = $postData['description'];
        $points = $postData['points'];
        $school = $postData['school'];

        $updateArr = array(
            'name' => $title,
            'description' => $description,
            'points' => $points,
            'school_id' => $school,
        );
        //print_r($updateArr); die;
        $update = $this->User_model->editGoal($updateArr, $id);


        if (isset($update)) {
            $return['success'] = "true";
            $return['message'] = "Goal edited successfully.";
            $return['error'] = $this->error;
            $return['data'] = $update;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function editChild_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        if (isset($_FILES['pic'])) {
            $pic = $_FILES['pic'];
        } else {
            $pic = $postData['childphoto'];
        }
        if (isset($_FILES['certificate'])) {
            $certificate = $_FILES['certificate'];
        } else {
            $certificate = $postData['childcertificate'];
        }

        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Child Profile Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $uploadPath = 'img/child/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['pic']['name'])) {
            if (!$this->upload->do_upload('pic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg1 = $this->upload->data();
                $pic = $uplodimg1['file_name'];
            }
        }
        if (!empty($_FILES['certificate']['name'])) {
            if (!$this->upload->do_upload('certificate')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg2 = $this->upload->data();
                $certificate = $uplodimg2['file_name'];
            }
        }

        $deleteIt = $postData['deleteIt'];
        $childID = $postData['childID'];
        $schoolId = $postData['schoolId'];
        $childRegisterId = $postData['childRegisterId'];
        $childfname = $postData['childfname'];
        $childmname = $postData['childmname'];
        $childlname = $postData['childlname'];
        $childgender = $postData['childgender'];
        $childclass = $postData['childclass'];
        $childdob = $postData['childdob'];
        $childemail = $postData['childemail'];
        $childhealthdetail = $postData['childhealthdetail'];
        $childallergy = $postData['childallergy'];
        $childSpecialneed = $postData['childSpecialneed'];
        $childApplicablemedication = $postData['childApplicablemedication'];
        $childbg = $postData['childbg'];
        $childaddress = $postData['childaddress'];

        $updateArr = array(
            'childRegisterId' => $childRegisterId,
            'childfname' => $childfname,
            'childmname' => $childmname,
            'childlname' => $childlname,
            'childgender' => $childgender,
            'childclass' => $childclass,
            'childdob' => $childdob,
            'childemail' => $childemail,
            'healthdetail' => $childhealthdetail,
            'allergy' => $childallergy,
            'specialneed' => $childSpecialneed,
            'applicablemedication' => $childApplicablemedication,
            'childbg' => $childbg,
            'childaddress' => $childaddress,
            'childphoto' => $pic,
            'childcertificate' => $certificate,
        );

        $update = $this->User_model->editChild($updateArr, $schoolId, $childID);

        if ($update) {
            if ($deleteIt == "1") {
                $this->db->delete('driver_student_assignment', array('studentid' => $childID, 'schoolid' => $schoolId));
            }
            $return['success'] = "true";
            $return['message'] = "Child edited successfully.";
            $return['error'] = $this->error;
            $return['data'] = $update;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = 'already-updated';

            $this->response($return, REST_Controller::HTTP_OK);
        }
    }

    public function addChild_post()
    {

        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        if (isset($_FILES['pic'])) {
            $pic = $_FILES['pic'];
        } else {
            $pic = '';
        }
        if (isset($_FILES['certificate'])) {
            $certificate = $_FILES['certificate'];
        } else {
            $certificate = '';
        }
        $current_session_data = get_current_session($postData['schoolId']);
        $countStudent = count_school_child($postData['schoolId']);
        $school_subscription_data = get_school_subscription_data($postData['schoolId'], $this->session->userdata('user_data')['subscription_id']);
        if ($school_subscription_data['no_of_usage'] == $school_subscription_data['no_of_student']) {
            $return['success'] = "false";
            $return['message'] = "You have reached your subscription limit on the number of kids that can be registered, kindly update your plan in Settings or contact hello@kidyview.com for support.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Child Profile Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $uploadPath = 'img/child/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['pic']['name'])) {
            if (!$this->upload->do_upload('pic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg1 = $this->upload->data();
                $pic = $uplodimg1['file_name'];
            }
        }
        if (!empty($_FILES['certificate']['name'])) {
            if (!$this->upload->do_upload('certificate')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg2 = $this->upload->data();
                $certificate = $uplodimg2['file_name'];
            }
        }

        $child_id = $postData['child_id'];
        $schoolId = $postData['schoolId'];
        $parentID = $postData['parentID'];
        // $childRegisterId = $postData['childRegisterId'];
        $childfname = $postData['childfname'];
        $childmname = $postData['childmname'];
        $childlname = $postData['childlname'];
        $childgender = $postData['childgender'];
        $childclass = $postData['childclass'];
        $childdob = $postData['childdob'];
        $childemail = $postData['childemail'];
        $childhealthdetail = $postData['childhealthdetail'];
        $childallergy = $postData['childallergy'];
        $childSpecialneed = $postData['childSpecialneed'];
        $childApplicablemedication = $postData['childApplicablemedication'];
        $childbg = $postData['childbg'];
        $childaddress = $postData['childaddress'];

        $addArr = array(
            'schoolId' => $postData['schoolId'],
            'parent_id' => $parentID,
            // 'childRegisterId' => $childRegisterId,
            'childfname' => $childfname,
            'childmname' => $childmname,
            'childlname' => $childlname,
            'childgender' => $childgender,
            'childclass' => $childclass,
            'childdob' => $childdob,
            'childemail' => $childemail,
            'healthdetail' => $childhealthdetail,
            'allergy' => $childallergy,
            'specialneed' => $childSpecialneed,
            'applicablemedication' => $childApplicablemedication,
            'childbg' => $childbg,
            'childaddress' => $childaddress,
            'childphoto' => $pic,
            'childcertificate' => $certificate,
            'class_session_id' => $current_session_data->id,
            'status' => '1',
            'created_date' => date('Y-m-d H:i:s'),
        );

        $add = $this->User_model->addChild($addArr, $child_id);

        if ($add) {
            $childClassArr = array(
                'school_id' => $postData['schoolId'],
                'child_id' => $add,
                'session_id' => $current_session_data->id,
                'class_id' => $childclass,
                'created_date' => date('Y-m-d H:i:s')
            );
            $this->User_model->add($childClassArr, 'child_class');

            $subsArr = array(
                'school_id' => $postData['schoolId'],
                'no_of_usage' => date('Y-m-d H:i:s')
            );
            $this->db->where('subscription_id', $this->session->userdata('user_data')['subscription_id']);
            $this->db->where('school_id', $postData['schoolId']);
            $this->db->set('no_of_usage', 'no_of_usage+1', FALSE);
            $this->db->update('school_subscription');
            $return['success'] = "true";
            $return['message'] = "Child added successfully.";
            $return['error'] = $this->error;
            $return['data'] = $add;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function addDriver_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        //$pic = $_FILES['pic'];
        if (isset($_FILES['pic'])) {
            $pic = $_FILES['pic'];
        } else {
            $pic = '';
        }
        if (isset($_FILES['document'])) {
            $document = $_FILES['document'];
        } else {
            $document = '';
        }
        //$document = $_FILES['document'];

        $driverphone = $postData['driverphone'];
        $driveremail = $postData['driveremail'];
        $result = $this->User_model->driverExist($driveremail, $driverphone);
        if ($result) {
            $return['success'] = "false";
            $return['message'] = "Already Exists.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($pic == null) {
            $pic = '';
        }
        if ($document == null) {
            $document = '';
        }

        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Driver Profile Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $uploadPath = 'img/driver/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['pic']['name'])) {
            if (!$this->upload->do_upload('pic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg1 = $this->upload->data();
                $pic = $uplodimg1['file_name'];
            }
        }
        if (!empty($_FILES['document']['name'])) {
            if (!$this->upload->do_upload('document')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg2 = $this->upload->data();
                $document = $uplodimg2['file_name'];
            }
        }

        $driverfname = $postData['driverfname'];
        $driverlname = $postData['driverlname'];
        $driveremail = $postData['driveremail'];
        $driverphone = $postData['driverphone'];
        $driverdeviceId = $postData['driverdeviceId'];
        $drivervehicle = $postData['drivervehicle'];
        $driverroute = $postData['driverroute'];
        $driverlicense = $postData['driverlicense'];
        $driverLicenseExpire = $postData['driverLicenseExpire'];
        $schoolId = $postData['schoolId'];
        $driveraddress = $postData['driveraddress'];
        $dpincode = $postData['dpincode'];
        $dcity = $postData['dcity'];
        $dstate = $postData['dstate'];
        $dcountry = $postData['dcountry'];
        $emergencyfname = $postData['emergencyfname'];
        $emergencylname = $postData['emergencylname'];
        $emergencyphone = $postData['emergencyphone'];
        $emergencyemail = $postData['emergencyemail'];
        $password = $postData['password'];

        $addArr = array(
            'schoolId' => $schoolId,
            'driverfname' => $driverfname,
            'driverlname' => $driverlname,
            'driveremail' => $driveremail,
            'driverphone' => $driverphone,
            'driverdeviceId' => $driverdeviceId,
            'driverVechiclenumber' => $drivervehicle,
            'driverroute' => $driverroute,
            'driverlicense' => $driverlicense,
            'driverLicenseExpire' => $driverLicenseExpire,
            'driverphoto' => $pic,
            'driverdocument' => $document,
            'driveraddress' => $driveraddress,
            'dpincode' => $dpincode,
            'dcity' => $dcity,
            'dstate' => $dstate,
            'dcountry' => $dcountry,
            'emergencyfname' => $emergencyfname,
            'emergencylname' => $emergencylname,
            'emergencyphone' => $emergencyphone,
            'emergencyemail' => $emergencyemail,
            'password' => $password,
            'status' => '1',
        );

        $add = $this->User_model->addDriver($addArr);
        if ($add) {
            $emailsubject = "<h2 style='margin:0; padding:5px 0 10px;margin-bottom:15px; border-bottom: 1px solid #bbb8af;color: #020a65;'>Your School Registered You As Driver In Kidyview system.</h2>";

            $to = $driveremail;
            $cc1 = $emergencyemail;
            $cc2 = '';
            $message = '<table width="614px" align="center" style="background: #F1F1F1;"><tr><td><div style="width:614px; border:1px solid #efefef; font: normal 12px Verdana, Arial, Helvetica, sans-serif; padding:2px; border:1px solid #ccc; margin:0px auto; 0">
				<div style="background:#fff; padding:15px 10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				<td align="center"><img src="' . base_url() . 'img/small_logo.png" width="150px" height="100px" alt="" /></td>
				</tr>
				</table>
				</div>
				<div style="min-height:300px; padding:10px;">' . $emailsubject . '					
				<table width="100%" border="0" cellspacing="0" cellpadding="0">';

            $mailResponse = $this->sendMailForCC($to, $cc1, $cc2, "A Register account reminder email for kidyview", $message);
        }

        if ($add) {
            $return['success'] = "true";
            $return['message'] = "Driver added successfully.";
            $return['error'] = $this->error;
            $return['data'] = $add;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function addSession_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $academicsession = $postData['academicsession'];
        $sessionstart = $postData['sessionstart'];
        $formattedsessionstart = $postData['formattedsessionstart'];
        $sessionend = $postData['sessionend'];
        $formattedsessionend = $postData['formattedsessionend'];
        $schoolId = $postData['schoolId'];

        $addArr = array(
            'schoolId' => $schoolId,
            'academicsession' => $academicsession,
            'sessionstart' => $sessionstart,
            'sessionend' => $sessionend,
            'formattedsessionstart' => $formattedsessionstart,
            'formattedsessionend' => $formattedsessionend,
            'status' => '1',
        );
        //print_r($addArr);
        $checkAlready = $this->User_model->existSession($addArr);
        // prd($checkAlready);
        if ($checkAlready > 0) {
            $return['success'] = "true";
            $return['message'] = "Session already exist for this interval.";
            $return['error'] = $this->error;
            $return['data'] = 'exist';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);

        } else {
            $add = $this->User_model->addSession($addArr);
            if ($add) {
                $return['success'] = "true";
                $return['message'] = "Session added successfully.";
                $return['error'] = $this->error;
                $return['data'] = $add;

                $this->response($return, REST_Controller::HTTP_OK);
            } else {
                $return['success'] = "false";
                $return['message'] = "Something went wrong.";
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
        }

    }

    public function addDiscussionCat_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $name = $postData['name'];
        $schoolId = $postData['schoolId'];

        $addArr = array(
            'school_id' => $schoolId,
            'name' => $name,
            'status' => '1',
        );
        //print_r($addArr); die;
        $add = $this->User_model->addDiscussionCat($addArr);

        if ($add) {
            $return['success'] = "true";
            $return['message'] = "Discussion Category added successfully.";
            $return['error'] = $this->error;
            $return['data'] = $add;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function addClass_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $academicsession = $postData['academicsession'];
        $class = $postData['class'];
        $school_type = $postData['school_type'];
        $section = $postData['section'];
        $schoolId = $postData['schoolId'];

        $addArr = array(
            //'session_id'  => get_current_session($postData['schoolId'])->id,
            'schoolId' => $schoolId,
            'academicsession' => $academicsession,
            'class' => $class,
            'school_type' => $school_type,
            'section' => $section,
            'status' => '1',
        );
        // prd($addArr);
        $add = $this->User_model->addClass($addArr);

        if ($add) {
            $return['success'] = "true";
            $return['message'] = "Class added successfully.";
            $return['error'] = $this->error;
            $return['data'] = $add;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function addSubject_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $pic = $_FILES;
        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Subject Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $pic = '';
            $uploadPath = 'img/subject/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['pic']['name'])) {
            if (!$this->upload->do_upload('pic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg = $this->upload->data();
                $pic = $uplodimg['file_name'];
            }
        }

        $subject = $postData['subject'];
        $type = $postData['type'];
        $subject_code = $postData['subject_code'];
        $schoolId = $postData['schoolId'];

        $addArr = array(
            'schoolId' => $schoolId,
            'subject' => $subject,
            'type' => $type,
            'subject_code' => $subject_code,
            'class' => $postData['class'],
            'teacher' => $postData['teacher'],
            'description' => $postData['description'],
            'image' => $pic,
            'status' => '1',
        );
        //print_r($addArr); die;
        $add = $this->User_model->addSubject($addArr);

        if ($add) {
            $return['success'] = "true";
            $return['message'] = "Subject added successfully.";
            $return['error'] = $this->error;
            $return['data'] = $add;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function addGoal_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $title = $postData['title'];
        $description = $postData['description'];
        $points = $postData['points'];
        $school = $postData['school'];

        $addArr = array(
            'name' => $title,
            'description' => $description,
            'points' => $points,
            'school_id' => $school,
        );
        //print_r($addArr); die;
        $add = $this->User_model->addGoal($addArr);

        if ($add) {
            $return['success'] = "true";
            $return['message'] = "Goal added successfully.";
            $return['error'] = $this->error;
            $return['data'] = $add;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function addEvent_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $pic = $_FILES;

        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Event Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $pic = '';
            $uploadPath = 'img/event/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['pic']['name'])) {
            if (!$this->upload->do_upload('pic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg = $this->upload->data();
                $pic = $uplodimg['file_name'];
            }
        }
        $eventtitle = $postData['eventtitle'];
        $eventvisiblity = $postData['eventvisiblity'];
        $eventdate = $postData['eventdate'];
        $eventtime = date('h:i A', strtotime($postData['eventtime']));
        // echo	$eventtime = date($postData['eventtime'], "H:i A");
        $eventaddress = $postData['eventaddress'];
        $eventdesc = $postData['eventdesc'];
        $eventtype = $postData['eventtype'];
        $eventamount = $postData['eventamount'];
        $schoolId = $postData['schoolId'];
        // prd($postData);

        if ($pic != null) {
            $addArr = array(
                'title' => $eventtitle,
                'school_id' => $schoolId,
                'visibility' => $eventvisiblity,
                'date' => $eventdate,
                'time' => $eventtime,
                'address' => $eventaddress,
                'description' => $eventdesc,
                'is_paid' => $eventtype,
                'amount' => $eventamount,
                'pic' => $pic,
            );
        } else {
            $addArr = array(
                'title' => $eventtitle,
                'school_id' => $schoolId,
                'visibility' => $eventvisiblity,
                'date' => $eventdate,
                'time' => $eventtime,
                'address' => $eventaddress,
                'description' => $eventdesc,
                'is_paid' => $eventtype,
                'amount' => $eventamount,
            );
        }

        $add = $this->User_model->addEvent($addArr);

        if ($add) {
            $pass = "KidyView";
            $text = $add;
            $encryptedUrl = encryptData($text, $pass);
            $getClassStudentData = getStudentBySchool($schoolId);
            //print_r($getClassStudentData);die;
            $studentEmailArray = array();
            if (!empty($getClassStudentData)) {
                foreach ($getClassStudentData as $studentData) {
                    $student_id = "ST-" . $studentData['id'];
                    $isNotify = notificationSettingHelper($schoolId, $student_id, 'Event');
                    $notificationData['receiver_id'] = "ST-" . $studentData['id'];
                    $notificationData['sender_id'] = "S-" . $schoolId;
                    $notificationData['to_do_id'] = $add;
                    $notificationData['school_id'] = $schoolId;
                    $notificationData['message'] = "School created an " . $eventtitle . " event on " . $eventdate . ' ' . $eventtime . "";
                    $notificationData['type'] = "event";
                    $notificationData['url'] = "calendar-list";
                    if (!empty($isNotify) && $isNotify->is_push == 1) {
                        $this->User_model->add($notificationData, 'notifications');
                    }

                }
            }
            $user_for = array();
            $eventvisiblity = explode(',', $eventvisiblity);
            if (!empty($eventvisiblity)) {
                foreach ($eventvisiblity as $uservisiblity) {
                    if ($uservisiblity == 0) {
                        array_push($user_for, 'Teacher');
                    } else {
                        array_push($user_for, 'Parent');
                    }
                }
            }
            if ($eventvisiblity == 0) {
                $user_type = 'Teacher';
            }
            if ($eventvisiblity == 1) {
                $user_type = 'Parent';
            }
            //print_r($user_for);die;
            $email_array = array();
            $getUserData = $this->User_model->getAllUserForMessage($schoolId, $user_type = '', $user_for);
            $i = 0;
            if (!empty($getUserData)) {
                foreach ($getUserData as $userData) {
                    if ($userData['email'] != '') {
                        array_push($email_array, $userData['email']);
                    }
                    $i++;
                }
                $sendData['name'] = $user_type;
                $email_array = array('yv@yopmail.com', 'yv1@yopmail.com');
                $sendData['message'] = 'Your school has added an event in the school calendar.';
                $message = $this->load->view('emailtemplate/eventTemplate', $sendData, true);
                sendKidyviewEmail($email_array, '', '', '', 'An event has been created.', $message);
            }
            $return['success'] = "true";
            $return['message'] = "Event added successfully.";
            $return['error'] = $this->error;
            $return['data'] = $add;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function addThoughtoftheday_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $title = $postData['title'];
        $description = $postData['description'];
        $author = $postData['author'];
        $schoolId = $postData['schoolId'];

        $addArr = array(
            'title' => $title,
            'school_id' => $schoolId,
            'description' => $description,
            'author_name' => $author,
            'status' => '1',
            'created_date' => date("Y:m:d H:i:s"),
        );

        $add = $this->User_model->addThoughtoftheday($addArr);

        if ($add) {
            $return['success'] = "true";
            $return['message'] = "Thought Of The Day added successfully.";
            $return['error'] = $this->error;
            $return['data'] = $add;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function addArticle_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $pic = $_FILES;
        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Article Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $pic = '';
            $uploadPath = 'img/article/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['pic']['name'])) {
            if (!$this->upload->do_upload('pic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg = $this->upload->data();
                $pic = $uplodimg['file_name'];
            }
        }
        $title = $postData['title'];
        $description = $postData['description'];
        $schoolId = $postData['schoolId'];
        $date = date('d-m-Y');

        if ($pic != null) {
            $addArr = array(
                'title' => $title,
                'schoolId' => $schoolId,
                'description' => $description,
                'created_time' => $date,
                'status' => '1',
                'pic' => $pic,
            );
        } else {
            $addArr = array(
                'title' => $title,
                'schoolId' => $schoolId,
                'description' => $description,
                'status' => '1',
                'created_time' => $date,
            );
        }
        $add = $this->User_model->addArticle($addArr);

        if ($add) {
            $return['success'] = "true";
            $return['message'] = "Article added successfully.";
            $return['error'] = $this->error;
            $return['data'] = $add;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function addGift_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $pic = $_FILES;
        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Gift Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $pic = '';
            $uploadPath = 'img/gift/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['pic']['name'])) {
            if (!$this->upload->do_upload('pic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg = $this->upload->data();
                $pic = $uplodimg['file_name'];
            }
        }
        $title = $postData['title'];
        $description = $postData['description'];
        $amount = $postData['amount'];
        $points = $postData['points'];
        $brand = $postData['brand'];
        $quantity = $postData['quantity'];
        $discount_type = $postData['discount_type'];
        $discount_value = $postData['discount_value'] ? $postData['discount_value'] : '';
        $sql = "SELECT AUTO_INCREMENT FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '" . $this->db->database . "' AND TABLE_NAME = 'gifts'";
        $row = $this->db->query($sql);
        $record = $row->row();
        $code = 'P' . strtoupper(substr($postData['title'], 0, 2)) . '0000' . $record->AUTO_INCREMENT;
        //$code = $postData['code'];

        if ($pic != null) {
            $addArr = array(
                'name' => $title,
                'amount' => $amount,
                'description' => $description,
                'points' => $points,
                'brand' => $brand,
                'code' => $code,
                'quantity' => $quantity,
                'discount_type' => $discount_type,
                'discount_value' => $discount_value,
                'status' => '1',
                'image' => $pic,
            );
        } else {
            $addArr = array(
                'name' => $title,
                'amount' => $amount,
                'description' => $description,
                'points' => $points,
                'brand' => $brand,
                'code' => $code,
                'quantity' => $quantity,
                'discount_type' => $discount_type,
                'discount_value' => $discount_value,
                'status' => '1',
            );
        }
        //print_r($addArr);dir;
        $add = $this->User_model->addGift($addArr);
        if ($add == 'exist') {
            $return['success'] = "true";
            $return['message'] = "Gift code Already exists.";
            $return['error'] = $this->error;
            $return['data'] = $add;

            $this->response($return, REST_Controller::HTTP_OK);
        } else if ($add) {
            $return['success'] = "true";
            $return['message'] = "Gift added successfully.";
            $return['error'] = $this->error;
            $return['data'] = $add;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function editGift_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $pic = $_FILES;
        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Gift Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $pic = '';
            $uploadPath = 'img/gift/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['pic']['name'])) {
            if (!$this->upload->do_upload('pic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg = $this->upload->data();
                $pic = $uplodimg['file_name'];
            }
        }
        $id = $postData['id'];
        $title = $postData['title'];
        $description = $postData['description'];
        $amount = $postData['amount'];
        $points = $postData['points'];
        $brand = $postData['brand'];
        $quantity = $postData['quantity'];
        $discount_type = $postData['discount_type'];
        $discount_value = $postData['discount_value'] ? $postData['discount_value'] : '';

        if ($pic != null) {
            $updateArr = array(
                'name' => $title,
                'amount' => $amount,
                'description' => $description,
                'points' => $points,
                'brand' => $brand,
                'image' => $pic,
                'quantity' => $quantity,
                'discount_type' => $discount_type,
                'discount_value' => $discount_value
            );
        } else {
            $updateArr = array(
                'name' => $title,
                'amount' => $amount,
                'description' => $description,
                'points' => $points,
                'brand' => $brand,
                'quantity' => $quantity,
                'discount_type' => $discount_type,
                'discount_value' => $discount_value
            );
        }
        $update = $this->User_model->editGift($updateArr, $id);

        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Gift edited successfully.";
            $return['error'] = $this->error;
            $return['data'] = $update;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function addAlbum_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        $files = array();
        $pics = array();
        $videos = array();
        if ($postData == '') {
            $postData = $_POST;
        }
        $title = $postData['title'];
        $description = $postData['description'];
        $schoolId = $postData['schoolId'];
        $cnt = count($_FILES);

        for ($x = 0; $x < $cnt; $x++) {
            if (isset($_FILES['pic' . $x])) {
                $pics[$x] = $_FILES['pic' . $x];
            }
            if (isset($_FILES['video' . $x])) {
                $videos[$x] = $_FILES['video' . $x];
            }
        }
        //echo '<pre>'; print_r($pics);
        //echo '<pre>'; print_r($videos); die;
        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Album Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $uploadPath = 'img/album/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        $addArr = array(
            'title' => $title,
            'schoolId' => $schoolId,
            'description' => $description,
            'status' => '1',
        );
        $addId = $this->User_model->addAlbum($addArr);

        for ($x = 0; $x < count($pics); $x++) {
            $_FILES['f']['name'] = $pics[$x]['name'];
            $_FILES['f']['type'] = $pics[$x]['type'];
            $_FILES['f']['tmp_name'] = $pics[$x]['tmp_name'];
            $_FILES['f']['error'] = $pics[$x]['error'];
            $_FILES['f']['size'] = $pics[$x]['size'];

            if (!empty($_FILES['f']['name'])) {
                if (!$this->upload->do_upload('f')) {
                    $uploaderror = $this->upload->display_errors();
                    $return['success'] = "false";
                    $return['message'] = $uploaderror;
                    $return['error'] = $this->error;
                    $return['data'] = $this->data;

                    $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                } else {
                    $uplodimg = $this->upload->data();
                    //$pic[$x] 	= $uplodimg['file_name'];

                    if ($_FILES['f']['name'] != '') {
                        $addArr1 = array(
                            'albumId' => $addId,
                            'status' => '1',
                            'attachment_type' => 'image',
                            'attachment' => $uplodimg['file_name'],
                        );
                    }
                    $add1 = $this->User_model->addAlbumAttachment($addArr1);
                }
            }
        }

        for ($x = 0; $x < count($videos); $x++) {
            $_FILES['f']['name'] = $videos[$x]['name'];
            $_FILES['f']['type'] = $videos[$x]['type'];
            $_FILES['f']['tmp_name'] = $videos[$x]['tmp_name'];
            $_FILES['f']['error'] = $videos[$x]['error'];
            $_FILES['f']['size'] = $videos[$x]['size'];

            if (!empty($_FILES['f']['name'])) {
                if (!$this->upload->do_upload('f')) {
                    $uploaderror = $this->upload->display_errors();
                    $return['success'] = "false";
                    $return['message'] = $uploaderror;
                    $return['error'] = $this->error;
                    $return['data'] = $this->data;

                    $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                } else {
                    $uplodimg = $this->upload->data();
                    //$pic[$x] 	= $uplodimg['file_name'];
                    if ($_FILES['f']['name'] != '') {
                        $addArr2 = array(
                            'albumId' => $addId,
                            'status' => '1',
                            'attachment_type' => 'video',
                            'attachment' => $uplodimg['file_name'],
                        );
                    }
                    $add2 = $this->User_model->addAlbumAttachment($addArr2);
                }
            }
        }
        //die;
        //$pic = implode(",",$pic);

        if ($addId) {
            $return['success'] = "true";
            $return['message'] = "Album added successfully.";
            $return['error'] = $this->error;
            $return['data'] = $addId;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function addTimeline_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        $files = array();
        $pics = array();
        if ($postData == '') {
            $postData = $_POST;
        }
        $description = $postData['description'];
        $schoolId = $postData['schoolId'];
        $schoolAdminId = $postData['schoolAdminId'];
        $cnt = count($_FILES);

        for ($x = 0; $x < $cnt; $x++) {
            if (isset($_FILES['pic' . $x])) {
                $pics[$x] = $_FILES['pic' . $x];
            }
        }
        //echo '<pre>'; print_r($pics);
        //die;
        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Timeline Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $uploadPath = 'img/timeline/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        $addArr = array(
            'user_id' => $schoolAdminId,
            'school_id' => $schoolId,
            'user_type' => 'school',
            'description' => $description,
            'status' => '1',
            'created' => date("Y-m-d H:i:s"),
        );
        $addId = $this->User_model->addTimeline($addArr);

        for ($x = 0; $x < count($pics); $x++) {
            $_FILES['f']['name'] = $pics[$x]['name'];
            $_FILES['f']['type'] = $pics[$x]['type'];
            $_FILES['f']['tmp_name'] = $pics[$x]['tmp_name'];
            $_FILES['f']['error'] = $pics[$x]['error'];
            $_FILES['f']['size'] = $pics[$x]['size'];

            if (!empty($_FILES['f']['name'])) {
                if (!$this->upload->do_upload('f')) {
                    $uploaderror = $this->upload->display_errors();
                    $return['success'] = "false";
                    $return['message'] = $uploaderror;
                    $return['error'] = $this->error;
                    $return['data'] = $this->data;

                    $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                } else {
                    $uplodimg = $this->upload->data();
                    //$pic[$x] 	= $uplodimg['file_name'];

                    if ($_FILES['f']['name'] != '') {
                        $addArr1 = array(
                            'timeline_id' => $addId,
                            'status' => '1',
                            'attachment_type' => 'image',
                            'attachment' => $uplodimg['file_name'],
                        );
                    }
                    $add1 = $this->User_model->addTimelineAttachment($addArr1);
                }
            }
        }
        //$pic = implode(",",$pic);

        if ($addId) {
            $return['success'] = "true";
            $return['message'] = "Timeline added successfully.";
            $return['error'] = $this->error;
            $return['data'] = $addId;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function editEvent_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $pic = $_FILES;

        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Event Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $pic = '';
            $uploadPath = 'img/event/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['pic']['name'])) {
            if (!$this->upload->do_upload('pic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg = $this->upload->data();
                $pic = $uplodimg['file_name'];
            }
        }

        $eventtitle = $postData['eventtitle'];
        $eventvisiblity = $postData['eventvisiblity'];
        $eventdate = $postData['eventdate'];
        // $eventtime = date($postData['eventtime'], "H:i");
        $eventtime = date('h:i A', strtotime($postData['eventtime']));
        $eventaddress = $postData['eventaddress'];
        $eventdesc = $postData['eventdesc'];
        $eventtype = $postData['eventtype'];
        $eventamount = $postData['eventamount'];
        $schoolId = $postData['schoolId'];
        $eventId = $postData['eventId'];

        if ($pic != null) {
            $updateArr = array(
                'title' => $eventtitle,
                'visibility' => $eventvisiblity,
                'date' => $eventdate,
                'time' => $eventtime,
                'address' => $eventaddress,
                'description' => $eventdesc,
                'is_paid' => $eventtype,
                'amount' => $eventamount,
                'pic' => $pic,
            );
        } else {
            $updateArr = array(
                'title' => $eventtitle,
                'visibility' => $eventvisiblity,
                'date' => $eventdate,
                'time' => $eventtime,
                'address' => $eventaddress,
                'description' => $eventdesc,
                'is_paid' => $eventtype,
                'amount' => $eventamount,
            );
        }
        // prd($updateArr);
        $update = $this->User_model->editEvent($updateArr, $schoolId, $eventId);

        if ($update) {
            $return['success'] = "true";
            $return['message'] = $this->db->last_query() . "  --Event added successfully.";
            $return['error'] = $this->error;
            $return['data'] = $update;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAdminDetails_get()
    {
        $result = $this->User_model->getAdminDetails();
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Admin details found.";
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

    public function getAllSchoolsForDashboard_get()
    {
        $result = $this->User_model->getAllSchoolsForDashboard();
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Schools details found.";
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

    public function getAllSchoolsForSchoolMngt_get()
    {
        $result = $this->User_model->getAllSchoolsForSchoolMngt();
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Schools details found.";
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

    public function getAllSchools_get()
    {
        $result = $this->User_model->getAllSchools();
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Schools details found.";
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

    public function getAllParent_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $schoolId = $postData['schoolId'];
        $result = $this->User_model->getAllParent($schoolId);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Schools details found.";
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

    public function getAllTeacher_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $schoolId = $postData['schoolId'];
        $result = $this->User_model->getAllTeacher($schoolId);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Teachers details found.";
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

    public function getAllEventsForSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getAllEventsForSchool($id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Event details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllThoughtOfTheDayForSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getAllThoughtOfTheDayForSchool($id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Thought Of The Day details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllArticleForSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getAllArticleForSchool($id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Articles details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllTimelineForSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getAllTimelineForSchool($id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Timeline details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllAlbumForSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getAllAlbumForSchool($id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Albums details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }


    public function getAllFeedback_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $userType = $postData['userType'];
        ///$schoolID = $postData['schoolId'];
        $result = $this->User_model->getAllFeedback($userType);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Feedback details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllDriverForSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getAllDriverForSchool($id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Drivers details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllSessionForSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getAllSessionForSchool($id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Sessions details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllTermForSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getAllTermForSchool($id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Terms details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllStudentForClass_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getAllStudentForClass($id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Student Listing found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllClassForSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getAllClassForSchool($id, 'All');

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Classes details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllDiscussionCatForSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getAllDiscussionCatForSchool($id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Discussion Categories details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllDiscussionForSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getAllDiscussionForSchool($id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Discussion listing found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllReportDetailsForUser_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getAllDailyReportDetailsForUser($id);
        $result1 = $this->User_model->getAllMonthlyReportDetailsForUser($id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Report Details found.";
            $return['data'] = $result;
            $return['data1'] = $result1;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllMessageForSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getAllMessageForSchool($id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Messages listing found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllSubjectForSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $class_id = $postData['class_id'];
        $result = $this->User_model->getAllSubjectForSchool($id, $class_id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Subjects details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllGoalsForSchool_get()
    {
        $result = $this->User_model->getAllGoalsForSchool();
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Goals List found.";
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

    public function getAllGiftsForSchool_get()
    {
        $result = $this->User_model->getAllGiftsForSchool();
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Gifts List found.";
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

    public function getAllTeacherForSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getAllTeacherForSchool($id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Teachers details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllStudentsForSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getAllStudentsForSchool($id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Students details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllLearningDevelopmentReportForSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getAllLearningDevelopmentReportForSchool($id);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Learning Development Report details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getSchoolDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getSchoolDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "School details found.";
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

    public function getEventDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getEventDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Event details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getDriverDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getDriverDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Driver details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getSessionDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getSessionDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Session details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getTermDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getTermDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Term details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getClassDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getClassDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Class details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getDiscussionCatDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getDiscussionCatDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Discussion Cat details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getSubjectDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getSubjectDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Subject details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getArticleDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getArticleDetails($id);
        $result1 = $this->User_model->getArticleAttachmentcommentsDetail($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Article details found.";
            $return['data'] = $result;
            $return['data1'] = $result1;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getThoughtOfTheDayDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getThoughtOfTheDayDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Thought Of The Day details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getDiscussionDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getDiscussionDetails($id);
        $result1 = $this->User_model->getDiscussionAttachmentDetails($id);
        $result2 = $this->User_model->getDiscussionAttachmentcommentsDetail($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Discussion details found.";
            $return['data'] = $result;
            $return['data1'] = $result1;
            $return['data2'] = $result2;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAlbumDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getAlbumDetails($id);
        $result1 = $this->User_model->getAlbumAttachmentDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Album details found.";
            $return['data'] = $result;
            $return['data1'] = $result1;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getLearningDevelopmentReportDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getLearningDevelopmentReportDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Learning And Development Report details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getTimelineDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getTimelineDetails($id);
        $result1 = $this->User_model->getTimelineAttachmentDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Timeline details found.";
            $return['data'] = $result;
            $return['data1'] = $result1;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getGoalDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getGoalDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Goal details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getGiftDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getGiftDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Gift details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getParentDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getParentDetails($id);
        $result1 = $this->User_model->getGuardianDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Parent details found.";
            $return['data'] = $result;
            $return['data1'] = $result1;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getTeacherDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getTeacherDetails($id);

        // prd($result);
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Teacher details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getStudentDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getStudentDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Student details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getTeacherQualificationDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getTeacherQualificationDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Teacher Qualifications details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getTeacherExperienceDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getTeacherExperienceDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Teacher Experience details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getSingleChildDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getSingleChildDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Child details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getSingleFeedbackDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getSingleFeedbackDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "feeback details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getChildDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getChildDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Child details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function deleteEvent_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->deleteEvent($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Event deleted successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function deleteTimelineComment_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->deleteTimelineComment($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Timeline Comment deleted successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function deleteAlbumComment_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->deleteAlbumComment($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Album Comment deleted successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function deleteDiscussionComment_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->deleteDiscussionComment($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Discussion Comment deleted successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function deleteArticleComment_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->deleteArticleComment($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Article Comment deleted successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function deleteGoal_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->deleteGoal($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Goal deleted successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function deleteArticle_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->deleteArticle($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Article deleted successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function deleteAttachment_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $name = $postData['attachment'];

        $result = $this->User_model->deleteAttachment($name);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Attchment deleted successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function deleteTimelineAttachment_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $name = $postData['attachment'];

        $result = $this->User_model->deleteTimelineAttachment($name);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Attchment deleted successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    private function Send_Mail($to, $subject, $body)
    {
        require_once APPPATH . "phpmailer/class.phpmailer.php";
        $from = "admin@kidyview.com";
        $mail = new PHPMailer();
        $mail->IsSMTP(true); // SMTP
        $mail->SMTPAuth = true;  // SMTP authentication
        $mail->Mailer = "smtp";
        $mail->Host = "tls://email-smtp.us-west-2.amazonaws.com"; // Amazon SES server, note "tls://" protocol
        $mail->Port = 465;                    // set the SMTP port
        $mail->Username = "AKIAIGFDQKPM5SBHZ36Q";  // SMTP  Username
        $mail->Password = "AkbUwdIMWfJMj17QixK8AA3pztYuqSjJoiDvNNIMywxt";  // SMTP Password
        $mail->SetFrom($from, 'KidyView');
        $mail->Subject = $subject;
        $mail->MsgHTML($body);
        $address = $to;
        $mail->AddAddress($address, $to);

        if (!$mail->Send())
            return false;
        else
            return true;
    }

    private function sendMail($to, $subject, $message)
    {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: admin@kidyview.com' . "\r\n";
        return mail($to, $subject, $message, $headers);
    }

    private function sendMailForCC($to, $cc1, $cc2, $subject, $message)
    {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: admin@kidyview.com' . "\r\n";
        $headers .= "CC: $cc1, $cc2";
        return mail($to, $subject, $message, $headers);
    }

    public function addHoliday_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        //print_r($postData);die('test');
        $academicsession = $postData['academicsession'];
        $holiday_title = $postData['holiday_title'];
        $holiday_date = $postData['holiday_date'];
        $schoolId = $postData['schoolId'];

        $addArr = array(
            'school_id' => $schoolId,
            'session' => $academicsession,
            'title' => $holiday_title,
            'for_date' => date('Y-m-d', strtotime($holiday_date))
        );
        $add = $this->User_model->addHoliday($addArr);
        //echo $add;die;
        if ($add == 'Already Exists.') {
            $return['success'] = "false";
            $return['message'] = "Holiday Already Exists.";
            $return['error'] = $this->error;
            $return['data'] = $add;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        if ($add > 0) {
            $return['success'] = "true";
            $return['message'] = "Holiday added successfully.";
            $return['error'] = $this->error;
            $return['data'] = $add;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllHolidayForSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $holidaydate = $postData['holiday_date'];
        $result = $this->User_model->getAllHolidayForSchool($id, $holidaydate);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Holiday details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getHolidayDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getHolidayDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Holiday details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function editHoliday_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $id = $postData['id'];
        $academicsession = $postData['academicsession'];
        $holidaytitle = $postData['holidaytitle'];
        $holiday_date = $postData['holiday_date'];
        $schoolId = $postData['schoolId'];

        $updateArr = array(
            'school_id' => $schoolId,
            'session' => $academicsession,
            'title' => $holidaytitle,
            'for_date' => date('Y-m-d', strtotime($holiday_date))
        );

        //print_r($updateArr); die;
        $update = $this->User_model->editHoliday($updateArr, $id, $schoolId);
        if ($update == 'Already Exists.') {
            $return['success'] = "true";
            $return['message'] = "Holiday Already Exists.";
            $return['error'] = $this->error;
            $return['data'] = $update;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Holiday edited successfully.";
            $return['error'] = $this->error;
            $return['data'] = $update;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function deleteHoliday_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->deleteHoliday($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Holiday deleted successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllHolidayCalendarData_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getAllHolidayCalendarData($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Holiday Calendar Data found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }


    public function getAllCalendarData_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $calendardate = $postData['calendardate'];
        $iscalendardata = $postData['iscalendardata'];
        $result = $this->User_model->getAllCalendarData($id, $calendardate, $iscalendardata);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Calendar Data found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function addRole_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $name = $postData['name'];
        $schoolId = $postData['schoolId'];

        $addArr = array(
            'name' => $name,
            'status' => '1'
        );
        //print_r($addArr); die;
        $add = $this->User_model->addRole($addArr);

        if ($add) {
            $return['success'] = "true";
            $return['message'] = "Role added successfully.";
            $return['error'] = $this->error;
            $return['data'] = $add;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllRoleForSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $result = $this->User_model->getAllROleForSchool();

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Role details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getRoleDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getRoleDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Role details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function editRole_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $name = $postData['name'];

        $updateArr = array(
            'name' => $name
        );
        $update = $this->User_model->editRole($updateArr, $id);

        if ($update == 'Already Exists.') {
            $return['success'] = "true";
            $return['message'] = "Role Already Exists.";
            $return['error'] = $this->error;
            $return['data'] = $update;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Role edited successfully.";
            $return['error'] = $this->error;
            $return['data'] = $update;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function roleDisabled_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $status = $postData['status'];

        $updateArr = array(
            'status' => $status,
        );
        $update = $this->User_model->roleDisabled($updateArr, $id);
        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Role Status Disabled Now.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }


    public function getAllActiveRoleForSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $isEdit = isset($postData['isEdit']) ? $postData['isEdit'] : 0;

        $result = $this->User_model->getAllRoleForSchool('1', $isEdit);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Role details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllPermissionModuleForSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $result = $this->User_model->getAllPermissionModuleForSchool();

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Module details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function addPrivilege_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);

        if ($postData == '') {
            $postData = $_POST;
        }
        $roleId = $postData['role_id'];
        $schoolId = $postData['schoolId'];
        $permissionData = json_decode($postData['permissionData']);

        if (!empty($permissionData)) {
            $add = $this->User_model->addPrivilege($permissionData, $roleId);

        }

        //print_r($addArr); die;


        if ($add) {
            $return['success'] = "true";
            $return['message'] = "Role added successfully.";
            $return['error'] = $this->error;
            $return['data'] = $add;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllPrivilegeForSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $result = $this->User_model->getAllPrivilegeForSchool();

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Privilege details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getPrivilegeDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $roleid = $postData['id'];
        $result = $this->User_model->getPrivilegeDetails($roleid);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Role details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function editPrivilege_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);

        if ($postData == '') {
            $postData = $_POST;
        }
        $roleId = $postData['role_id'];
        $schoolId = $postData['schoolId'];
        $permissionData = json_decode($postData['permissionData']);

        if (!empty($permissionData)) {
            $add = $this->User_model->editPrivilege($permissionData, $roleId);

        }

        if ($add) {
            $return['success'] = "true";
            $return['message'] = "Privilege updated successfully.";
            $return['error'] = $this->error;
            $return['data'] = $add;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function deletePrivilege_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->deletePrivilege($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Privilege deleted successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function addSubadmin_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        if (isset($_FILES['pic'])) {
            $pic = $_FILES['pic'];
        } else {
            $pic = 'default-profilePic.png';
        }

        $phone = $postData['phone'];
        $email = $postData['email'];
        $resultEmail = $this->User_model->subadminEmailExist($email);

        if ($resultEmail) {
            $return['success'] = "false";
            $return['message'] = "Already Email Exists.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        $resultPhone = $this->User_model->subadminPhoneExist($phone);

        if ($resultPhone) {
            $return['success'] = "false";
            $return['message'] = "Already Phone Exists.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }


        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Sub Admin Profile Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $uploadPath = 'img/school/subadmin/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['pic']['name'])) {
            if (!$this->upload->do_upload('pic')) {
                $uploaderror = $this->upload->display_errors();
                //print_r($uploaderror);die;
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg1 = $this->upload->data();
                $pic = $uplodimg1['file_name'];
            }
        }
        if ($this->session->userdata('user_role') == 'admin' || $this->session->userdata('user_role') == 'adminsubadmin') {
            $parentId = $this->session->userdata('user_data')['id'];
        } else {
            $schoolId = $postData['schoolId'];
        }

        $roleId = $postData['role_id'];
        $name = $postData['name'];
        $email = $postData['email'];
        $password = $postData['password'];
        $designation = $postData['designation'];
        $phone = $postData['phone'];
        $address = $postData['address'];
        $city = $postData['city'];
        $state = $postData['state'];
        $pincode = $postData['pincode'];
        $country = $postData['country'];
        $otherinfo = $postData['otherinfo'];

        if ($this->session->userdata('user_role') == 'admin' || $this->session->userdata('user_role') == 'adminsubadmin') {
            $addArr['parent_id'] = $parentId;
        } else {
            $addArr['school_id'] = $schoolId;
        }
        $addArr['role_id'] = $roleId;
        $addArr['name'] = $name;
        $addArr['email'] = $email;
        $addArr['password'] = md5($password);
        $addArr['designation'] = $designation;
        $addArr['phone'] = $phone;
        $addArr['address'] = $address;
        $addArr['city'] = $city;
        $addArr['state'] = $state;
        $addArr['pincode'] = $pincode;
        $addArr['country'] = $country;
        $addArr['otherinfo'] = $otherinfo;
        $addArr['pic'] = $pic;
        $addArr['status'] = '1';


        $add = $this->User_model->addSubadmin($addArr);


        if ($add) {
            $emailsubject = "<h2 style='margin:0; padding:5px 0 10px;margin-bottom:15px; border-bottom: 1px solid #bbb8af;color: #020a65;'>Your Registration successfully in Kidyview system.</h2>";

            $to = $email;

            $message = '<table width="614px" align="center" style="background: #F1F1F1;"><tr><td><div style="width:614px; border:1px solid #efefef; font: normal 12px Verdana, Arial, Helvetica, sans-serif; padding:2px; border:1px solid #ccc; margin:0px auto; 0">
				<div style="background:#fff; padding:15px 10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				<td align="center"><img src="' . base_url() . 'img/small_logo.png" width="150px" height="100px" alt="" /></td>
				</tr>
				</table>
				</div>
				<div style="min-height:300px; padding:10px;">' . $emailsubject . '					
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<h3 style="margin:0; padding:5px 0 10px;margin-bottom:15px; border-bottom: 1px solid #bbb8af;color: #020a65;">Hi</h3>
				
				
				<h3 style="margin:0; padding:5px 0 10px;margin-bottom:15px; border-bottom: 1px solid #bbb8af;color: #020a65;">Your email id and password are:</h3>
				<tr>
				<td height="25">Email Id</td>
				<td height="25">:</td>
				<td height="25">' . $email . '</td>
				</tr>
				<tr>
				<td height="25">Password</td>
				<td height="25">:</td>
				<td height="25">' . $password . '</td>
				</tr>
				<tr>
				<td height="25">Please click below url for login:</td>
				<td height="25">:</td>
				<td height="25"><a style = "color: #fff; border: 1px solid #000; background: #3C9F06;" href="' . base_url() . 'schoollogin">Login Here</a></td>
				</tr>
				</table>
				</table>';

            //$mailResponse = $this->sendMailForCC($to,'','',  "A registration email for kidyview", $message);
            $mailResponse = sendKidyviewEmail($to, '', '', '', 'A registration email for kidyview', $message);
        }

        if ($add) {
            $return['success'] = "true";
            $return['message'] = "Subadmin added successfully.";
            $return['error'] = $this->error;
            $return['data'] = $add;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllSubadminForSchool_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $schoolId = $postData['schoolId'];
        $result = $this->User_model->getAllSubadminForSchool($schoolId);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Sub Admin details found.";
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

    public function getSubadminDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getSubadminDetails($id);
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Subadmin details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function editSubadmin_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        //print_r($_FILES['pic']);die;
        if (isset($_FILES['pic'])) {
            $pic = $_FILES['pic'];
        } else {
            $pic = $postData['photo'];
        }
        if ($pic == '') {
            $pic = "default-profilePic.png";
        }
        $phone = $postData['phone'];
        $email = $postData['email'];
        $subadminID = $postData['subadminID'];
        $resultEmail = $this->User_model->subadminEmailExistInEditCase($email, $subadminID);
        if ($resultEmail) {
            $return['success'] = "false";
            $return['message'] = "Already Email Exists.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        $subadminID = $postData['subadminID'];
        $resultPhone = $this->User_model->subadminPhoneExistInEditCase($phone, $subadminID);
        if ($resultPhone) {
            $return['success'] = "false";
            $return['message'] = "Already Phone Exists.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }

        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Parent Profile Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $uploadPath = 'img/school/subadmin/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        if (!empty($_FILES['pic']['name'])) {
            if (!$this->upload->do_upload('pic')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;

                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg1 = $this->upload->data();
                $pic = $uplodimg1['file_name'];
            }
        }

        if ($this->session->userdata('user_role') == 'admin' || $this->session->userdata('user_role') == 'adminsubadmin') {
            $parentId = $this->session->userdata('user_data')['id'];
        } else {
            $schoolId = $postData['schoolId'];
        }
        $subadminId = $postData['subadminID'];
        $roleId = $postData['role_id'];
        $name = $postData['name'];
        $email = $postData['email'];
        $password = $postData['password'];
        $designation = $postData['designation'];
        $phone = $postData['phone'];
        $address = $postData['address'];
        $city = $postData['city'];
        $state = $postData['state'];
        $pincode = $postData['pincode'];
        $country = $postData['country'];
        $otherinfo = $postData['otherinfo'];
        $updateArr = array();
        if ($password != '') {
            $updateArr['password'] = md5($password);
        }
        if ($this->session->userdata('user_role') == 'admin' || $this->session->userdata('user_role') == 'adminsubadmin') {
            $updateArr['parent_id'] = $parentId;
        } else {
            $updateArr['school_id'] = $schoolId;
        }

        $updateArr['role_id'] = $roleId;
        $updateArr['name'] = $name;
        $updateArr['email'] = $email;
        $updateArr['designation'] = $designation;
        $updateArr['phone'] = $phone;
        $updateArr['address'] = $address;
        $updateArr['city'] = $city;
        $updateArr['state'] = $state;
        $updateArr['pincode'] = $pincode;
        $updateArr['country'] = $country;
        $updateArr['otherinfo'] = $otherinfo;
        $updateArr['pic'] = $pic;
        //'pic' => $pic,
        //'status' => '1',


        $update = $this->User_model->editSubadmin($updateArr, $subadminId);

        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Subadmin edited successfully.";
            $return['error'] = $this->error;
            $return['data'] = $update;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function subadminDisabled_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $status = $postData['status'];
        $updateArr = array(
            'status' => $status,
        );
        if ($this->session->userdata('user_role') == 'admin' || $this->session->userdata('user_role') == 'adminsubadmin') {
            $tbl_name = 'admin_subadmin';
        } else {
            $tbl_name = 'school_subadmin';
        }

        $update = $this->User_model->commonDisabled($updateArr, $id, $tbl_name);
        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Sub Admin Status Disabled Now.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function deleteSubadmin_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $where = array(
            'id' => $id
        );
        if ($this->session->userdata('user_role') == 'admin' || $this->session->userdata('user_role') == 'adminsubadmin') {
            $tbl_name = 'admin_subadmin';
        } else {
            $tbl_name = 'school_subadmin';
        }
        $result = $this->User_model->delete($where, $tbl_name);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Sub admin deleted successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $result;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function deleteRole_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        if ($this->session->userdata('user_role') == 'admin' || $this->session->userdata('user_role') == 'adminsubadmin') {
            $tbl_name = 'admin_role';
        } else {
            $tbl_name = 'school_role';
        }
        $chkRole = $this->User_model->checkAsignRole($id);
        if ($chkRole > 0) {
            $return['success'] = "false";
            $return['message'] = "Already Asign";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        $where = array(
            'id' => $id
        );
        $result = $this->User_model->delete($where, $tbl_name);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Role deleted successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function getStudentUsernamePassword_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        //print_r($postData);die;
        $pname = isset($postData['fname']) && $postData['fname'] != '' ? $postData['fname'] : $postData['mname'];
        $femail = $postData['femail'];
        $memail = $postData['memail'];
        $cid = $postData['childid'];
        $crid = $postData['childrid'];
        $cfname = $postData['childfname'];
        $cmname = $postData['childmname'];
        $clname = $postData['childlname'];
        $cfullname = $cfname . ' ' . $cmname . ' ' . $clname;
        $data = array();
        $school_id = $this->session->userdata('user_data')['school_id'];
        if ($school_id < 10) {
            $school_id = "0" . $school_id;
        }
        $child_login_id = substr(ucwords($cfname), 0, 1) . substr(ucwords($clname), 0, 1) . $school_id . $cid;
        $password = $this->randomPassword();
        $data['child_login_id'] = $child_login_id;
        $data['password'] = $this->settings->encryptString($password);
        $result = $this->User_model->updateChildPassword($cid, $data);
        if ($result) {
            $emailsubject = "<h2 style='margin:0; padding:5px 0 10px;margin-bottom:15px; border-bottom: 1px solid #bbb8af;color: #020a65;'>Your child login details.</h2>";

            $to = $femail;
            $bcc = $memail;

            $message = '<table width="614px" align="center" style="background: #F1F1F1;"><tr><td><div style="width:614px; border:1px solid #efefef; font: normal 12px Verdana, Arial, Helvetica, sans-serif; padding:2px; border:1px solid #ccc; margin:0px auto; 0">
				<div style="background:#fff; padding:15px 10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				<td align="center"><img src="' . base_url() . 'img/small_logo.png" width="150px" height="100px" alt="" /></td>
				</tr>
				</table>
				</div>
				<div style="min-height:300px; padding:10px;">' . $emailsubject . '					
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				<td height="25">Child Name:</td>
				<td height="25">:</td>
				<td height="25">' . $cfullname . '</td>
				</tr>
				<tr>
				<td height="25">Login Id</td>
				<td height="25">:</td>
				<td height="25">' . $child_login_id . '</td>
				</tr>
				<tr>
				<td height="25">Password</td>
				<td height="25">:</td>
				<td height="25">' . $password . '</td>
				</tr>
				<tr>
				<td height="25">Please click below url for login:</td>
				<td height="25">:</td>
				<td height="25"><a href="' . base_url() . 'studentlogin" style = "color: #fff; border: 1px solid #000; background: #3C9F06;">Login Here</a></td>
				</tr>
				</table>
				</table>';
            $childDatas['pname'] = $pname;
            $childDatas['cfullname'] = $cfullname;
            $childDatas['child_login_id'] = $child_login_id;
            $childDatas['password'] = $password;
            $message = $this->load->view('emailtemplate/childGenerateTemplate', $childDatas, true);
            $mailResponse = sendKidyviewEmail($to, $bcc, '', '', 'Your child login details for kidyview', $message);
        }


        if ($result == 1) {
            $return['success'] = "true";
            $return['message'] = "Password generated successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Password not updated.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getGroupConversationDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getGroupConversationDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Group Conversation Found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllUserForMessage_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $schoolId = $postData['school_id'];
        $userType = $postData['user_type'];
        $result = $this->User_model->getAllUserForMessage($schoolId, $userType);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All User details found.";
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

    public function addMessage_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        $files = array();
        if ($postData == '') {
            $postData = $_POST;
        }
        print_r($postData['receiver_id']);
        die;
        $message = $postData['message'];
        $user = $postData['user'];
        $schoolId = $postData['schoolId'];
        $senderId = 'SA-' . $postData['schoolId'];
        $cnt = count($_FILES);
        $pics = array();
        for ($x = 0; $x < $cnt; $x++) {
            if (isset($_FILES['pic' . $x])) {
                $pics[$x] = $_FILES['pic' . $x];
            }
        }

        if (count($_POST) == 0) {
            $return['success'] = "false";
            $return['message'] = "Invalid Message Details.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $uploadPath = 'img/message/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
        }

        $addArr = array(
            'message' => $message,
            'school_id' => $schoolId,
            'sender' => $senderId,
            'reciever' => $user,
            'created_date' => date("Y:m:d H:i:s"),
        );
        $addId = $this->User_model->addMessage($addArr);

        for ($x = 0; $x < count($pics); $x++) {
            $_FILES['f']['name'] = $pics[$x]['name'];
            $_FILES['f']['type'] = $pics[$x]['type'];
            $_FILES['f']['tmp_name'] = $pics[$x]['tmp_name'];
            $_FILES['f']['error'] = $pics[$x]['error'];
            $_FILES['f']['size'] = $pics[$x]['size'];

            if (!empty($_FILES['f']['name'])) {
                if (!$this->upload->do_upload('f')) {
                    $uploaderror = $this->upload->display_errors();
                    $return['success'] = "false";
                    $return['message'] = $uploaderror;
                    $return['error'] = $this->error;
                    $return['data'] = $this->data;

                    $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                } else {
                    $uplodimg = $this->upload->data();
                    //$pic[$x] 	= $uplodimg['file_name'];

                    if ($_FILES['f']['name'] != '') {
                        $addArr1 = array(
                            'message_id' => $addId,
                            'file_name' => $uplodimg['file_name'],
                        );
                    }
                    $add1 = $this->User_model->addMessageAttachment($addArr1);
                }
            }
        }

        if ($addId) {
            $this->load->model('teachers/Teacher_model');
            $teacher_id = explode('-', $user);
            $pass = "KidyView";
            //$pass = "SA-".$schoolId;
            $text = "SA-" . $schoolId;
            $encryptedUrl = encryptData($text, $pass);
            if ($teacher_id[0] == 'T') {
                $teacherData = $this->Teacher_model->getTeacherDetails($teacher_id[1]);
                $isNotify = notificationSettingHelper($schoolId, $user, 'Chat');
                //print_r($isNotify);die;
                //$notificationData['school_id'] = $schoolId;
                $notificationData['receiver_id'] = $user;
                $notificationData['sender_id'] = "S-" . $schoolId;
                $notificationData['to_do_id'] = $addId;
                $notificationData['message'] = "School initiate chat message for you.";
                $notificationData['type'] = "chat";
                $notificationData['url'] = "conversation/" . $encryptedUrl;
                if (!empty($isNotify) && $isNotify->is_push == 1) {
                    $this->Teacher_model->add($notificationData, 'notifications');
                }
                $teacherEmail = $teacherData->teacheremail;
                if (!empty($isNotify) && $isNotify->is_web == 1) {
                    $notificationData['user'] = "teacher";
                    $message = $this->load->view('emailtemplate/commonTemplate', $notificationData, true);
                    //sendMail($teacherEmail, $notificationData['message'], $message);
                    sendKidyviewEmail($teacherEmail, '', '', '', $notificationData['message'], $message);
                }
            } else {
                //$notificationData['school_id'] = $schoolId;
                $notificationData['receiver_id'] = $user;
                $notificationData['sender_id'] = "S-" . $schoolId;
                $notificationData['to_do_id'] = $addId;
                $notificationData['message'] = "School initiate chat message for you.";
                $notificationData['type'] = "chat";
                $notificationData['url'] = "conversation/" . $encryptedUrl;
                $this->Teacher_model->add($notificationData, 'notifications');
            }

            $return['success'] = "true";
            $return['message'] = "Message added successfully.";
            $return['error'] = $this->error;
            $return['data'] = $addId;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function sendMessage_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        };
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('receiver_id[]', 'Message', 'trim|required');
        if (empty($_FILES['files'])) {
            $this->form_validation->set_rules('message', 'Message', 'trim|required');
        }
        $error = array();
        if ($this->form_validation->run() === False) {
            $error = $this->form_validation->error_array();
            $message = validation_errors();
            $this->response(["success" => "false", 'message' => $message, 'data' => '', "error" => $error], REST_Controller::HTTP_BAD_REQUEST);
        }
        $pic = '';
        if (!empty($_FILES['files'])) {
            $uploadPath = 'img/message/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx|mp4|mp3|3gpp|3gp||avi|flv|wmv|mkv|mov|xls|xlsx';
            $config['max_size'] = 500000;
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $arrPhoto = array();
            $totalImageSize = 0;
            //size in MB
            $maxphotosize = 20;
            if (!empty($_FILES['files'])) {
                for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
                    if ($_FILES['files']['name'][$i] != '') {
                        $size = $_FILES['files']['size'][$i];
                        $totalImageSize = $totalImageSize + $size;
                    }
                }
            }
            $totalphotosize = $totalImageSize / (1024 * 1024);
            if ($totalphotosize > $maxphotosize) {
                $this->response(["status" => "error", "message" => "Attachment should not be greater than $maxphotosize MB"], REST_Controller::HTTP_BAD_REQUEST);
            }
            for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
                if ($_FILES['files']['name'][$i] != '') {
                    $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                    if ($this->upload->do_upload('file')) {
                        $uplodimg = $this->upload->data();
                        $photoData = array();
                        $photoData['file_name'] = $uplodimg['file_name'];
                        array_push($arrPhoto, $photoData);
                    } else {

                        $uploaderror = $this->upload->display_errors();
                        $return['success'] = "false";
                        $return['message'] = $uploaderror;
                        $return['error'] = $this->error;
                        $return['data'] = $this->data;
                        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                    }
                }
            }
        }
//            var_dump($this->session);
//			$sdata = $this->session->userdata('school_data');
        $sdata = $this->session->userdata('user_data');
//            var_dump($sdata);
        $sid = $sdata['id'];
        $data['message'] = $postData['message'];
        $data['sender'] = "ST-" . $sid;
        $data['school_id'] = $postData['schoolId'];
        $data['created_date'] = date('Y-m-d H:i:s');
        $tbl_name = "messages";
        $tbl_name2 = "message_attachment";
        $add = '';
        $pass = "KidyView";
        $text = $data['sender'];
        $encryptedUrl = $this->encryptData($text, $pass);
//                            var_dump($postData);
        if (!empty($postData['receiver_id'])) {
            foreach ($postData['receiver_id'] as $user) {
                $isNotify = notificationSettingHelper($postData['schoolId'], $user, 'Chat');
                $data['reciever'] = $user;
                $add = $this->smodel->add($data, $tbl_name);
                if ($add) {
                    if (!empty($arrPhoto)) {
                        foreach ($arrPhoto as $photoData) {
                            $photoData['message_id'] = $add;
                            $photoId = $this->smodel->add($photoData, $tbl_name2);
                        }
                    }
                    $notificationData['receiver_id'] = $user;
                    $notificationData['sender_id'] = "S-" . $sid;
                    $notificationData['to_do_id'] = $add;
                    $notificationData['message'] = $sdata['school_name'] . " initiate chat meaasge for you.";
                    $notificationData['type'] = "chat";
                    $notificationData['url'] = "conversation/" . $encryptedUrl;
//                    var_dump($isNotify->is_push);
                    if (!empty($isNotify) && $isNotify->is_push == 1) {
//                        var_dump($isNotify->is_push);
                        $tk = explode('-', $user);
//                        var_dump($tk);
                        $result = $this->Parent_model->parentFCMID($tk[1]);
                        $tokenData = $this->db->get_where('user_token', ['user_id' => $tk[1]])->row();
//                        var_dump($result);
                        $token = !empty($result->fcm_key) ? $result->fcm_key : '';
                        $message = $postData['message'];
                        $title = "New message";
                        $this->firebases->sendNotification($token, $title, $message);
//                        $this->model->add($notificationData, 'notifications');
                        $notify =  $this->fcm->sendPushNotification($token, $title, $message);
//                        $tokenData = $this->db->get_where('user_token', ['user_id' => $user])->row();
                        if ($tokenData) {
                            $this->sendPushNotification($token, "New Message", $postData['message']);
                        }
                    }
                }

            }
        }
        if ($add) {
            $message = "Message send successfully.";
            $return['success'] = "true";
            $return['message'] = $message;
            $return['error'] = $this->error;
            $return['data'] = $add;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    private function sendPushNotification($token, $title, $body)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = 'AAAA-yhUx78:APA91bEfw76JlVWCTr70GIc2kXpzQyrJcIm-3e0P1EH_gLKMBvR3Y4OH4ogdidklZFOQM5sIRjfYduppdefXBl7MVyeHqGZMj31e3nA6zKb_7oS7aSSOXpHU7d2iTj9d0u8PsPXLHYXo'; // Replace with your actual Firebase server key
        $notification = [
            'title' => $title,
            'body' => $body,
            'sound' => 'default'
        ];
        $data = [
            'to' => $token,
            'notification' => $notification
        ];
        $headers = [
            'Authorization: key=' . $serverKey,
            'Content-Type: application/json'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $result = curl_exec($ch);
//        if ($result === FALSE) {
//            die('Curl failed: ' . curl_error($ch));
//        }
        if ($result === FALSE) {
            log_message('error', 'Curl failed: ' . curl_error($ch));
            } else {
            log_message('info', 'FCM Response: ' . print_r($result, true));
        }
        curl_close($ch);
        }
    public function addTerm_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $term = $postData['term'];
        $academicsession = $postData['academicsession'];
        $termstart = $postData['termstart'];
        $formattedtermstart = $postData['formattedtermstart'];
        $termend = $postData['termend'];
        $formattedtermend = $postData['formattedtermend'];
        $schoolId = $postData['schoolId'];

        $addArr = array(
            'schoolId' => $schoolId,
            'termname' => $term,
            'academicsession' => $academicsession,
            'termstart' => $termstart,
            'termend' => $termend,
            'formattedtermstart' => $formattedtermstart,
            'formattedtermend' => $formattedtermend,
            'status' => '1',
        );
        //print_r($addArr); die;
        $add = $this->User_model->addTerm($addArr);

        if ($add) {
            $return['success'] = "true";
            $return['message'] = "Term added successfully.";
            $return['error'] = $this->error;
            $return['data'] = $add;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getFAQList_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getFAQList($id);
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "FAQs list successfully.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function deleteFAQ_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->deleteFAQ($id);
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "FAQs Question Deleted successfully.";
            $return['error'] = $this->error;
            $return['data'] = $result;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function updateFAQs_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $postData = array(
            'id' => $postData['faq_id'],
            'question' => $postData['question'],
            'answer' => $postData['answer'],
            'user_type' => 'Student',
            'updated_at' => date('Y-m-d H:i:s')
        );
        $result = $this->User_model->updateFAQs($postData);
        if ($result) {
            $return['success'] = true;
            $return['message'] = "Question has been updated.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function addFAQs_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $postData = array(
            'question' => $postData['question'],
            'answer' => $postData['answer'],
            'user_type' => 'Student',
            'school_id' => $postData['school_id'],
            'create_at' => date('Y-m-d H:i:s')
        );
        $result = $this->User_model->addFAQs($postData);
        if ($result) {
            $return['success'] = true;
            $return['message'] = "FAQs question has been inserted successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function addVoucher_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $sql = "SELECT AUTO_INCREMENT FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '" . $this->db->database . "' AND TABLE_NAME = 'voucher'";
        $row = $this->db->query($sql);
        $record = $row->row();
        $postData['voucher_code'] = 'V' . strtoupper(substr($postData['name'], 0, 2)) . '0000' . $record->AUTO_INCREMENT;

        $add = $this->User_model->addVoucher($postData);
        if ($add == 'exist') {
            $return['success'] = "true";
            $return['message'] = "This Product Already Mapped.";
            $return['error'] = $this->error;
            $return['data'] = $add;

            $this->response($return, REST_Controller::HTTP_OK);
        } elseif ($add) {
            $return['success'] = "true";
            $return['message'] = "Voucher added successfully.";
            $return['error'] = $this->error;
            $return['data'] = $add;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function editVoucher_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $voucherID = $postData['id'];
        //($postData);die;
        //unset($postData['id']);

        $update = $this->User_model->editVoucher($postData, $voucherID);
        if ($update == 'exist') {
            $return['success'] = "true";
            $return['message'] = "This Product Already Mapped.";
            $return['error'] = $this->error;
            $return['data'] = $update;
            $this->response($return, REST_Controller::HTTP_OK);
        } elseif ($update) {
            $return['success'] = "true";
            $return['message'] = "Voucher updated successfully.";
            $return['error'] = $this->error;
            $return['data'] = $update;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getAllVoucherForSchool_get()
    {
        $result = $this->User_model->getAllVoucherForSchool();
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Voucher List found.";
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

    public function getVoucherDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getVoucherDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Voucher details found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function deleteVoucher_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $where = array(
            'id' => $id
        );
        $tbl_name = 'voucher';
        $result = $this->User_model->delete($where, $tbl_name);
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Voucher deleted successfully.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $result;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }


    public function getDailyReport_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $studentId = $postData['studentId'];
        $School_ID = $postData['School_ID'];
        $reportDate = date('Y-m-d', strtotime($postData['reportDate']));
        $reportInput = array(
            'studentId' => $studentId,
            'School_ID' => $School_ID,
            'reportDate' => $reportDate
        );


        if ($studentId != "" && $School_ID != "" && $reportDate != "") {
            $result = $this->User_model->getDailyReport($reportInput);

            if ($result) {
                $return['success'] = "true";
                $return['message'] = "Report found.";
                $return['data'] = $result;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
            } else {
                $return['success'] = "true";
                $return['message'] = "No Data Found.";
                $return['data'] = $result;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
            }
        }
    }

    public function getMonthlyReport_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $studentId = $postData['studentId'];
        $School_ID = $postData['School_ID'];
        $reportMonth = $postData['reportMonth'];
        $reportYear = $postData['reportYear'];
        $reportDate = $reportYear . '-' . $reportMonth;
        $reportInput = array(
            'studentId' => $studentId,
            'School_ID' => $School_ID,
            'reportDate' => $reportDate
        );


        if ($studentId != "" && $School_ID != "" && $reportMonth != "" && $reportYear != "") {
            $result = $this->User_model->getMonthlyReport($reportInput);

            if ($result) {
                $return['success'] = "true";
                $return['message'] = "Report found.";
                $return['data'] = $result;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
            } else {
                $return['success'] = "true";
                $return['message'] = "No Data Found.";
                $return['data'] = $result;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
            }
        }
    }


    public function getTermReport_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $studentId = $postData['studentId'];
        $School_ID = $postData['School_ID'];
        $termID = $postData['term'];

        $reportInput = array(
            'studentId' => $studentId,
            'School_ID' => $School_ID,
            'termId' => $termID
        );


        if ($studentId != "" && $School_ID != "" && $termID != "") {
            $result = $this->User_model->getTermReport($reportInput);

            if ($result) {
                $return['success'] = "true";
                $return['message'] = "Report found.";
                $return['data'] = $result;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
            } else {
                $return['success'] = "true";
                $return['message'] = "No Data Found.";
                $return['data'] = $result;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
            }
        }
    }

    public function getAllTerms_post()
    {

        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $School_ID = $postData['School_ID'];
        if ($School_ID != "") {
            $result = $this->User_model->getAllTerms($School_ID);
            if ($result) {
                $return['success'] = "true";
                $return['message'] = "Terms found.";
                $return['data'] = $result;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
            } else {
                $return['success'] = "true";
                $return['message'] = "No Terms Found.";
                $return['data'] = $result;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
            }
        }

    }


    public function getCountryCode_post()
    {


        $result = $this->User_model->getCountryCode();
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Country Code found.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "true";
            $return['message'] = "No Country Code Found.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }


    }


    public function addSponser_post()
    {

        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $pic = "";
        if (!empty($_FILES['logophoto']['name'])) {
            $uploadPath = 'img/sponser/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('logophoto')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg1 = $this->upload->data();
                $pic = $uplodimg1['file_name'];
            }
        }


        $title = $postData['title'];
        $link = $postData['link'];
        $pic = $pic;
        $addArr = array(

            'title' => $title,
            'link' => $link,
            'pic' => $pic,
            'status' => 1,
            'created_date' => date("Y:m:d H:i:s")
        );
        $id = $this->User_model->addsponser($addArr);
        if ($id) {
            $return['success'] = "true";
            $return['message'] = "New Sponser Added Successfully";
            $return['data'] = $id;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);

        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getSponser_post()
    {
        $result = $this->User_model->allsponser();
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Sponser found.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "true";
            $return['message'] = "No Sponser Found.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
    }

    public function sponserDisabled_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $id = $postData['id'];
        $status = $postData['status'];
        $tbl_name = 'sponser';
        $updateArr = array(
            'status' => $status,
        );
        $update = $this->User_model->commonDisabled($updateArr, $id, $tbl_name);
        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Sponser Status Disabled Now.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getSponserDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getSponserDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Sponser details found.";
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

    public function updateSponser_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $pic = "";
        if (!empty($_FILES['logophoto']['name'])) {
            $uploadPath = 'img/sponser/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = '*';
            $config['max_size'] = 50000;
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('logophoto')) {
                $uploaderror = $this->upload->display_errors();
                $return['success'] = "false";
                $return['message'] = $uploaderror;
                $return['error'] = $this->error;
                $return['data'] = $this->data;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $uplodimg1 = $this->upload->data();
                $pic = $uplodimg1['file_name'];
            }
        }


        $id = $postData['id'];
        $updateArr = array(
            'title' => $postData['title'],
            'link' => $postData['link'],
        );
        if ($pic != "") {
            $updateArr['pic'] = $pic;
        }

        $result = $this->User_model->updateSponser($updateArr, $id);
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Sponser Updatd Successfully";
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

    public function deleteSponser_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->deleteSponser($id);
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Sponser deleted.";
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


    public function addCurrency_post()
    {

        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }


        $addArr = array(
            'currency_name' => $postData['currency_name'],
            'currency_code' => $postData['currency_code'],
            'currency_symbol' => $postData['currency_symbol'],
            'currency_rate' => $postData['currency_rate']
        );
        $id = $this->User_model->addCurrency($addArr);
        if ($id) {
            $return['success'] = "true";
            $return['message'] = "New Currency Added Successfully";
            $return['data'] = $id;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);

        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getCurrency_post()
    {
        $result = $this->User_model->allCurrency();
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Currency found.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "true";
            $return['message'] = "No Currency Found.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
    }


    public function deleteCurrency_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        if ($id == 1) {
            $return['success'] = "true";
            $return['message'] = "Its a default currency and cannot deleted.";
            $return['data'] = "Error";
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }


        $result = $this->User_model->deleteCurrency($id);
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Currency deleted Successfully.";
            $return['data'] = 'Successfull';
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

    public function getCurrencyDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->getCurrencyDetails($id);
        //print_r($result); die;
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Sponser details found.";
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


    public function updateCurrency_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $id = $postData['id'];
        $updateArr = array(
            'currency_name' => $postData['currency_name'],
            'currency_code' => $postData['currency_code'],
            'currency_symbol' => $postData['currency_symbol'],
            'currency_rate' => $postData['currency_rate']
        );

        $result = $this->User_model->updateCurrency($updateArr, $id);
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Currency Updatd Successfully";
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

    public function mapcurrency_post()
    {

        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }


        $addArr = array(
            'country_id' => $postData['countrycode'],
            'currency_id' => $postData['currencycode'],
        );
        $id = $this->User_model->mapcurrency($addArr);
        if ($id) {
            $return['success'] = "true";
            $return['message'] = "New Country Map Successfully";
            $return['data'] = $id;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);

        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }


    public function getUnMapCurrency_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $countryID = $postData['countryID'];
        $result = $this->User_model->unmapCurrencyList($countryID);
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Currency List found.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "true";
            $return['message'] = "No Currency Found.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
    }

    public function getCurrencyList_post()
    {

        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $countryID = $postData['countryID'];

        $result = $this->User_model->getCurrencyList($countryID);
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Currency List Data Found.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "true";
            $return['message'] = "No Currency Found.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
    }


    public function unMapCurrency_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->User_model->unMapCurrency($id);
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Currency Unmapped Successfully.";
            $return['data'] = 'Successfull';
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

    public function checkDriverChildList_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $count = 0;
        $dataArray = array();
        $id = isset($postData['childID']) ? $postData['childID'] : "";
        $schoolId = isset($postData['schoolId']) ? $postData['schoolId'] : "";
        $childclass = isset($postData['childclass']) ? $postData['childclass'] : "";

        if ((!empty($schoolId)) && (!empty($schoolId)) && (!empty($childclass))) {
            $this->db->select("dsa.*,CONCAT(d.driverfname, ' ',d.driverlname, ' (',d.drivercode,')') as driver");
            $this->db->from("driver_student_assignment as dsa");
            $this->db->join('driver as d', 'd.id = dsa.driverid');
            $this->db->where("dsa.schoolid", $schoolId);
            $this->db->where("dsa.studentid", $id);
            $query = $this->db->get();
            $driver = "";
            if ($query->num_rows() > 0) {
                $data_user = json_decode(json_encode($query->result_array()), true);
                for ($i = 0; $i < count($data_user); $i++) {
                    if ($data_user[$i]['classid'] != $childclass) {
                        $count++;
                    }
                    $driver .= $data_user[$i]['driver'] . "\n";
                }
                //$driver = substr($driver, 1);
            }
        }

        if ($count == 0) {
            $return['count'] = "0";
            $return['success'] = "true";
            $return['message'] = "No Student or No Different Class Found in driver List";
            $return['data'] = 'Successfull';
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['count'] = $count;
            $return['success'] = "true";
            $return['message'] = "This Student allready added to below Driver List With The Other Class That You Have Not Selected \n" . $driver . "If you Click on Ok Button Then This Student Will be Remove From Driver List.";
            $return['data'] = 'Successfull';
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }

    }


    public function getCheckTime_post()
    {


        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }


        $schoolId = isset($postData['school_ID']) ? $postData['school_ID'] : "";
        $studentID = isset($postData['studentID']) ? $postData['studentID'] : "";

        if ((!empty($schoolId)) && (!empty($studentID))) {
            $this->db->select("sa.check_in as check_in,sa.check_out as check_out,sa.created_at as created_at,sa.updated_at as updated_at");
            $this->db->from("student_attendance as sa");
            $this->db->where("sa.school_id", $schoolId);
            $this->db->where("sa.student_id", $studentID);
            $query = $this->db->get();

            $checkIn = array();
            $checkIn['checkIn'] = "";
            $checkIn['checkOut'] = "";

            if ($query->num_rows() > 0) {
                $data_user = json_decode(json_encode($query->row()), true);

                if ($data_user['created_at'] != "" || $data_user['created_at'] != NULL) {
                    $checkIn['checkIn'] = date('h:i A', strtotime($data_user['created_at']));
                }
                if ($data_user['updated_at'] != "" || $data_user['updated_at'] != NULL) {
                    $checkIn['checkOut'] = date('h:i A', strtotime($data_user['updated_at']));
                }
            }

        }

        $return['success'] = "true";
        $return['message'] = "Check In Check out Time";
        $return['data'] = $checkIn;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }


    public function getTransactionList_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $schoolId = isset($postData['schoolID']) ? $postData['schoolID'] : "";

        $paymentHistory = $this->User_model->getTransactionList($schoolId);
        // prd($paymentHistory);
        if ($paymentHistory) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "School payment history.";
            $return['data'] = $paymentHistory;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);

        } else {
            $return['success'] = "false";
            $return['title'] = "failed";
            $return['message'] = "No payment history found";
            $return['data'] = '';
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }


    public function getCountryCurrency_post()
    {

        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $countryid = isset($postData['countryid']) ? $postData['countryid'] : "";

        $result = $this->User_model->getCountryCurrency($countryid);
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Currency found.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "true";
            $return['message'] = "No Currency Found.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
    }


    public function callDisabled_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $status = $postData['status'];

        $updateArr = array(
            'is_call_enable' => $status,
        );

        $update = $this->User_model->changeParentStatus($updateArr, $id);


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Call Status Disabled Now.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }


    public function callDisabledTeacher_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $status = $postData['status'];

        $updateArr = array(
            'is_call_enable' => $status,
        );

        $update = $this->User_model->changeTeacherStatus($updateArr, $id);


        if ($update) {
            $return['success'] = "true";
            $return['message'] = "Call Status Disabled Now.";
            $return['error'] = $this->error;
            $return['data'] = $updateArr;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Something went wrong.";
            $return['error'] = $this->error;
            $return['data'] = $this->data;

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }


    public function getfees_post()
    {

        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['schoolID'];

        $this->db->select('
                                sum(sf.amount) as total,
                                s.currency_id as currency_id,
                                ac.currency_name as currency_name,
                                ac.currency_code as currency_code,
                                ac.currency_symbol as currency_symbol');
        $this->db->from('student_fees as sf');
        $this->db->join('school as s', 's.id=' . $id . '', 'left');
        $this->db->join('admin_currency as ac', 'ac.id=s.currency_id', 'left');
        $where = array('sf.school_id' => $id, 'sf.is_paid' => 'paid');
        $this->db->where($where);
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        $school = array();
        if ($query->num_rows() > 0) {
            $school = $query->row();
        }

        $return['success'] = "true";
        $return['message'] = "School Fees Data";
        $return['error'] = $this->error;
        $return['data'] = $school;
        $this->response($return, REST_Controller::HTTP_OK);


    }

    public function getAllSchoolSession_get()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST = $_GET;
        }
        $result = get_all_session($postData['school_id']);
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All session found.";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "Not found.";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function activityResultUpdate_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $result = $this->model->activityResultUpdate($postData);
        if ($result > 0) {

            $return['success'] = "true";
            $return['message'] = "Activity updated successfully";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);

        } else {
            $return['success'] = "false";
            $return['message'] = "Activity already updated";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function activityResultIsApproved_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $result = $this->model->activityResultIsApproved($postData);
        if ($result) {

            $return['success'] = "true";
            $return['message'] = "Result has been " . $postData['is_approved'] . " ";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);

        } else {
            $return['success'] = "false";
            $return['message'] = "Result status is already " . $postData['is_approved'] . ".";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function schoolType_get()
    {
        $res = $this->User_model->schoolTypeList();
        $return['success'] = "true";
        $return['message'] = "School Type List.";
        $return['error'] = "";
        $return['data'] = $res;
        $this->response($res, REST_Controller::HTTP_OK);
    }

    function encryptData($text, $pass)
    {
        $encryptedUrl = CryptoJSAES::encrypt($text, $pass);
        if (strpos($encryptedUrl, '/') !== false) {
            $encryptedUrl = $this->encryptData($text, $pass);
        }
        return $encryptedUrl;
    }

    public function importStudentCsvData_post()
    {
        $data = $this->session->userdata('user_data');
        $school_id = $data['id'];
        $csv = '';
        $this->load->library('csvimport');
        if (isset($_FILES['pic']) && $_FILES['pic']['tmp_name'] != '') {
            $csv = $_FILES['pic']['tmp_name'];
        }
        $csv_student_data = array();
        $csv_parent_data = array();
        $retn = 0;
        if ($csv != '') {
            $csv_data = $this->csvimport->parse_file($csv);
            if (!empty($csv_data)) {
                $i = 0;
                foreach ($csv_data as $student) {
                    $csv_student_data['schoolId'] = $school_id;
                    $csv_student_data['childfname'] = $student[0];
                    $csv_student_data['childlname'] = $student[1];
                    $csv_student_data['childgender'] = $student[2];
                    $csv_student_data['childclass'] = $student[3];
                    $csv_student_data['childdob'] = date('Y-m-d', strtotime($student[4]));
                    $csv_student_data['childemail'] = $student[5];
                    $csv_student_data['class_session_id'] = get_current_session($school_id)->id;
                    $csv_parent_data['fatherfname'] = $student[6];
                    $csv_parent_data['fatherlname'] = $student[7];
                    $csv_parent_data['fatheremail'] = $student[8];
                    $csv_parent_data['fatherphone'] = $student[9];
                    $csv_parent_data['motherfname'] = $student[10];
                    $csv_parent_data['motherlname'] = $student[11];
                    $csv_parent_data['motheremail'] = $student[12];
                    $csv_parent_data['motherphone'] = $student[13];
                    $csv_parent_data['schoolId'] = $school_id;
                    $current_session_data = get_current_session($school_id);
                    $countStudent = count_school_child($school_id);
                    $school_subscription_data = get_school_subscription_data($school_id, $this->session->userdata('user_data')['subscription_id']);
                    if ($school_subscription_data['no_of_usage'] == $school_subscription_data['no_of_student']) {
                        $return['success'] = "false";
                        $return['message'] = "You have reached your subscription limit on the number of kids that can be registered, kindly update your plan in Settings or contact hello@kidyview.com for support.";
                        $return['error'] = $this->error;
                        $return['data'] = 0;
                        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                        break;
                    }
                    if (($csv_parent_data['fatherfname'] != '' && $csv_parent_data['fatheremail'] != '' && $csv_parent_data['fatherphone'] != '') || ($csv_parent_data['motherfname'] != '' && $csv_parent_data['motheremail'] != '' && $csv_parent_data['motherphone'] != '')) {
                        $isParentExist = $this->User_model->checkParentExist($csv_parent_data);
                        if (count($isParentExist) == 0) {
                            $this->db->insert('parent', $csv_parent_data);
                            $last_parent_insert_id = $this->db->insert_id();
                            if ($last_parent_insert_id) {
                                $csv_student_data['parent_id'] = $last_parent_insert_id;
                                $csv_student_data['created_date'] = date('Y-m-d H:i:s');
                                $last_insert_id = $this->db->insert('child', $csv_student_data);
                                $last_insert_id = $this->db->insert_id();
                                $this->db->where('schoolId', $school_id);
                                $this->db->where('id', $last_parent_insert_id);
                                $this->db->set('child_id', "CONCAT(child_id,',',$last_insert_id)", FALSE);
                                $this->db->update('parent');
                                if ($last_insert_id) {
                                    $registerID = $last_insert_id . date('dmY');
                                    $updateArray = array('childRegisterId' => $registerID);
                                    $this->db->where('id', $last_insert_id);
                                    $this->db->update('child', $updateArray);
                                    $childClassArr = array(
                                        'school_id' => $school_id,
                                        'child_id' => $last_insert_id,
                                        'session_id' => get_current_session($school_id)->id,
                                        'class_id' => $csv_student_data['childclass'],
                                        'created_date' => date('Y-m-d H:i:s')
                                    );
                                    $this->User_model->add($childClassArr, 'child_class');

                                    $subsArr = array(
                                        'school_id' => $school_id,
                                        'no_of_usage' => date('Y-m-d H:i:s')
                                    );
                                    $this->db->where('subscription_id', $this->session->userdata('user_data')['subscription_id']);
                                    $this->db->where('school_id', $school_id);
                                    $this->db->set('no_of_usage', 'no_of_usage+1', FALSE);
                                    $this->db->update('school_subscription');
                                }
                                $retn = 1;
                            }
                        } else {
                            $csv_student_data['created_date'] = date('Y-m-d H:i:s');
                            $csv_student_data['parent_id'] = $isParentExist['id'];
                            $isChildExist = $this->User_model->checkChildExist($csv_student_data);
                            if ($isChildExist == 0) {
                                $this->db->insert('child', $csv_student_data);
                                $last_child_insert_id = $this->db->insert_id();
                                $this->db->where('schoolId', $school_id);
                                $this->db->where('id', $isParentExist['id']);
                                $this->db->set('child_id', "CONCAT(child_id,',',$last_child_insert_id)", FALSE);
                                $this->db->update('parent');
                                if ($last_child_insert_id) {
                                    $registerIDs = $last_child_insert_id . date('dmY');
                                    $updateArrays = array('childRegisterId' => $registerIDs);
                                    $this->db->where('id', $last_child_insert_id);
                                    $this->db->update('child', $updateArrays);
                                    if ($i == count($csv_data)) {
                                        print_r($updateArrays);
                                        echo $this->db->last_query();
                                        die;
                                    }
                                    $childClassArr = array(
                                        'school_id' => $school_id,
                                        'child_id' => $last_child_insert_id,
                                        'session_id' => get_current_session($school_id)->id,
                                        'class_id' => $csv_student_data['childclass'],
                                        'created_date' => date('Y-m-d H:i:s')
                                    );
                                    $this->User_model->add($childClassArr, 'child_class');

                                    $subsArr = array(
                                        'school_id' => $school_id,
                                        'no_of_usage' => date('Y-m-d H:i:s')
                                    );
                                    $this->db->where('subscription_id', $this->session->userdata('user_data')['subscription_id']);
                                    $this->db->where('school_id', $school_id);
                                    $this->db->set('no_of_usage', 'no_of_usage+1', FALSE);
                                    $this->db->update('school_subscription');
                                }
                                $retn = 1;
                            }

                        }
                    }
                    $i++;
                }
            }
            if ($retn == 1) {
                $return['success'] = "true";
                $return['message'] = "Student has been imported successfully.'";
                $return['data'] = $retn;
                $return['error'] = $this->error;
                $this->response($return, REST_Controller::HTTP_OK);
            } else {
                $return['success'] = "false";
                $return['message'] = "Data not imported.Pleae import again.";
                $return['error'] = $this->error;
                $return['data'] = $retn;
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $return['success'] = "false";
            $return['message'] = "Data not imported.Pleae import again.";
            $return['error'] = $this->error;
            $return['data'] = $retn;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }

    }

    public function sendStudentFormLinkToParent_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $parentEmail = array();
        print_r($postData);
        die;
        if (!empty($postData['exitParentData'])) {
            $this->db->select("email");
            $this->db->from("alluser");
            $this->db->where("school_id", $postData['id']);
            $this->db->where("user_type", "Parent");
            $this->db->where_in("id", $postData['exitParentData']);
            $query = $this->db->get();
            $parerentResult = $query->result_array();
            print_r($parerentResult);
            die;
        }
        print_r($postData);
        die;
        $result = $this->model->activityResultIsApproved($postData);
        if ($result) {

            $return['success'] = "true";
            $return['message'] = "Result has been " . $postData['is_approved'] . " ";
            $return['data'] = $result;
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);

        } else {
            $return['success'] = "false";
            $return['message'] = "Result status is already " . $postData['is_approved'] . ".";
            $return['error'] = $this->error;
            $return['data'] = '';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}