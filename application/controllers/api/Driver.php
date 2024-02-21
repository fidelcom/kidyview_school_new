<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Driver extends REST_Controller {

    public $error = array();
    public $data = array();

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('user_role') == 'school' OR $this->session->userdata('user_role') == 'schoolsubadmin') {
            $this->token->validate();
        }
        $this->load->library('form_validation');
        $this->load->library("security");
        $this->load->model("driver/driver_model", 'driver');
        $this->load->model('team_model');
        $this->load->library('settings');
    }

    private function sendMail($to, $subject, $message) {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: info@kidyview.com' . "\r\n";
        return mail($to, $subject, $message, $headers);
    }

    private function sendMailForCC($to, $cc1, $cc2, $subject, $message) {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: info@kidyview.com' . "\r\n";
        $headers .= "CC: $cc1, $cc2";
        return mail($to, $subject, $message, $headers);
    }

//    public function index_get() {
//        $schoolID = $this->input->get('school_id');
//        $res = $this->driver_model->data($schoolID);
//        $return['success'] = "true";
//        $return['message'] = "Driver List.";
//        $return['error'] = "";
//        $return['data'] = $res;
//        $this->response($return, REST_Controller::HTTP_OK);
//    }

    public function addRoute_post() {

        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        
        $route_stops = array_values(array_filter($_POST['route_stops']));
        
        if(!empty($route_stops)){
            $latitude = array_values(array_filter($_POST['latitude']));  
            $longitude = array_values(array_filter($_POST['longitude']));
            $latLong =  array();
            for($j=0;$j<count($route_stops);$j++) {
              $latLong['latLong']['latitude'][$j] = isset($latitude[$j]) ? $latitude[$j] : '';
              $latLong['latLong']['longitude'][$j] = isset($longitude[$j]) ? $longitude[$j] : '';  
            }
        }
            
            
        //echo '<pre>';
        //print_r($latLong);
        //exit;     

        $result = $this->driver->routeExist($postData['route_title']);
        if ($result) {
            $return['success'] = "false";
            $return['message'] = "Already Exists.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {

            $route_title = $postData['route_title'];
            $route_start = $postData['route_start'];
            $route_end = $postData['route_end'];
            $schoolId = $postData['schoolId'];

            $addArr = array(
                'schoolId' => $schoolId,
                'route_title' => $route_title,
                'route_start' => $route_start,
                'route_end' => $route_end,
                'stops' => serialize($route_stops),
                'lat_long' => serialize($latLong)
             
            );
            $id = $this->driver->addRoute($addArr);
            if ($id) {
                $updateArray = array('route_code' => '00' . $id);
                $this->db->where('id', $id);
                $this->db->update('route', $updateArray);
                $return['success'] = "true";
                $return['message'] = "Route added successfully.";
                $return['error'] = $this->error;
                $return['data'] = $id;
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

    public function updateroute_post() {

        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }


        $result = $this->driver->routeExist($postData['route_title'], $postData['id']);
        if ($result) {
            $return['success'] = "false";
            $return['message'] = "Already Exists.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {

            $route_title = $postData['route_title'];
            $route_start = $postData['route_start'];
            $route_end = $postData['route_end'];
            $route_stops = array_values(array_filter($_POST['route_stops']));

            
           if(!empty($route_stops)){
            $latitude = array_values(array_filter($_POST['latitude']));  
            $longitude = array_values(array_filter($_POST['longitude']));
            $latLong =  array();
            
            for($j=0;$j<count($route_stops);$j++) {
              $latLong['latLong']['latitude'][$j] = isset($latitude[$j]) ? $latitude[$j] : '';
              $latLong['latLong']['longitude'][$j] = isset($longitude[$j]) ? $longitude[$j] : '';  
             }
            }
            
        //echo '<pre>';
        //print_r($latLong);
        //exit;   

            $addArr = array(
                'route_title' => $route_title,
                'route_start' => $route_start,
                'route_end' => $route_end,
                'stops' => serialize($route_stops),
                'lat_long' => serialize($latLong)
            );
            $result = $this->driver->updateRoute($addArr, $postData['id']);
            if ($result) {
                $return['success'] = "true";
                $return['message'] = "Updated successfully.";
                $return['error'] = $this->error;
                $return['data'] = $postData['id'];
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

    public function getAllRoute_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $res = $this->driver->getAllRoute($postData['schoolId']);
        $return['success'] = "true";
        $return['message'] = "Route List.";
        $return['error'] = "";
        $return['data'] = $res;
        $this->response($return, REST_Controller::HTTP_OK);
    }

    public function getRoute_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $res = $this->driver->getRoute($postData['id']);
        $return['success'] = "true";
        $return['message'] = "Route Found.";
        $return['error'] = "";
        $return['data'] = $res;
        $this->response($return, REST_Controller::HTTP_OK);
    }

    public function addvehicle_post() {

        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $result = $this->driver->vehicleNumberExist($postData);
        if ($result) {
            $return['success'] = "false";
            $return['message'] = "Already Exists.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $pic = "";
            if (!empty($_FILES['pic']['name'])) {
                $uploadPath = 'img/driver/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = '*';
                $config['max_size'] = 50000;
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

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

            $schoolId = $postData['schoolId'];
            $vehicle_type = $postData['vehicle_type'];
            $vehicle_name = $postData['vehicle_name'];
            $vehicle_brand = $postData['vehicle_brand'];
            $vehicle_number = $postData['vehicle_number'];
            $model = $postData['model'];
            $colour = $postData['colour'];
            $plate_number = $postData['plate_number'];
            $routes = $postData['routes'];
            $photo = $pic;
            $addArr = array(
                'schoolId' => $schoolId,
                'vehicle_type' => $vehicle_type,
                'vehicle_name' => $vehicle_name,
                'vehicle_number' => $vehicle_number,
                'model' => $model,
                'colour' => $colour,
                'plate_number' => $plate_number,
                'vehicle_brand' => $vehicle_brand,
                'route' => $routes,
                'photo' => $photo
            );
            $id = $this->driver->addVehicle($addArr);
            if ($id) {
                $updateArray = array('vcode' => 'V-00' . $id);
                $this->db->where('id', $id);
                $this->db->update('vehicle', $updateArray);

                $return['success'] = "true";
                $return['message'] = "New Vehicle Added Successfully.";
                $return['error'] = $this->error;
                $return['data'] = $id;
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

    public function getAllvehicle_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $res = $this->driver->getAllvehicle($postData['schoolId']);
        $return['success'] = "true";
        $return['message'] = "Route List.";
        $return['error'] = "";
        $return['data'] = $res;
        $this->response($return, REST_Controller::HTTP_OK);
    }

    public function getVehicle_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $res = $this->driver->getVehicle($postData['id']);
        $return['success'] = "true";
        $return['message'] = "Route List.";
        $return['error'] = "";
        $return['data'] = $res;
        $this->response($return, REST_Controller::HTTP_OK);
    }

    public function updatevehicle_post() {

        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }

        $result = $this->driver->vehicleNumberExist($postData, $postData['id']);
        if ($result) {
            $return['success'] = "false";
            $return['message'] = "Already Exists.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $pic = $postData['oldphoto'];
            if (!empty($_FILES['pic']['name'])) {
                $uploadPath = 'img/driver/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = '*';
                $config['max_size'] = 50000;
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

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

            $id = $postData['id'];
            $vehicle_type = $postData['vehicle_type'];
            $vehicle_name = $postData['vehicle_name'];
            $vehicle_brand = $postData['vehicle_brand'];
            $vehicle_number = $postData['vehicle_number'];
            $model = $postData['model'];
            $colour = $postData['colour'];
            $plate_number = $postData['plate_number'];
            $routes = $postData['routes'];
            $photo = $pic;
            $addArr = array(
                'vehicle_type' => $vehicle_type,
                'vehicle_name' => $vehicle_name,
                'vehicle_number' => $vehicle_number,
                'model' => $model,
                'colour' => $colour,
                'plate_number' => $plate_number,
                'vehicle_brand' => $vehicle_brand,
                'route' => $routes,
                'photo' => $photo
            );
            $result = $this->driver->updatevehicle($addArr, $id);
            if ($result) {
                $return['success'] = "true";
                $return['message'] = "Vehicle Updated Successfully.";
                $return['error'] = $this->error;
                $return['data'] = $id;
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

    ######################### Add Driver Section #############################

    public function addDriver_post() {
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

        $drivervehicle = $postData['drivervehicle'];
        $vehcleData = $this->driver->VehicleUsed($postData['drivervehicle'],$postData['schoolId']);
        if ($vehcleData) {
            $return['success'] = "false";
            $return['message'] = "Vehicle Exists.";
            $return['error'] = $this->error;
            $return['data'] = 'Selected Vehicle all ready used by Driver ' . $vehcleData->driverfname . ' ' . $vehcleData->driverlname . ' (' . $vehcleData->drivercode . '). For using the selected vehicle you have to disable the '.$vehcleData->driverfname . ' ' . $vehcleData->driverlname . ' (' . $vehcleData->drivercode.') or update the '.$vehcleData->driverfname . ' ' . $vehcleData->driverlname . ' (' . $vehcleData->drivercode . ')  vehicle';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }

        $driverphone = $postData['driverphone'];
        $driveremail = $postData['driveremail'];
        $result = $this->driver->driverExist($driveremail, $driverphone);
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
            'drivervehicle' => $drivervehicle,
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
            'created_date'=> date('Y-m-d H:i:s'), 
        );

        $add = $this->driver->addDriver($addArr);
        if ($add) {
            $updateArray = array('drivercode' => 'D-00' . $add);
            $this->db->where('id', $add);
            $this->db->update('driver', $updateArray);
            $emailsubject = "<h2 style='margin:0; padding:5px 0 10px;margin-bottom:15px; border-bottom: 1px solid #bbb8af;color: #020a65;'>Your School Registered You As Driver In Kidyview system.</h2>";
            $to = $driveremail;
            $cc1 = $emergencyemail;
            $cc2 = '';

            $whitelist = array('127.0.0.1', '::1');
            if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
                $message = '<table width="614px" align="center" style="background: #F1F1F1;"><tr><td><div style="width:614px; border:1px solid #efefef; font: normal 12px Verdana, Arial, Helvetica, sans-serif; padding:2px; border:1px solid #ccc; margin:0px auto; 0">
				<div style="background:#fff; padding:15px 10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				<td align="center"><img src="' . base_url() . 'img/small_logo.png" width="150px" height="100px" alt="" /></td>
				</tr>
				</table>
				</div>
				<div style="min-height:300px; padding:10px;">' . $emailsubject . '					
				<table width="100%" border="0" cellspacing="0" cellpadding="0">';

                //$mailResponse = $this->sendMailForCC($to, $cc1, $cc2, "A Register account reminder email for kidyview", $message);
                $mailResponse = sendKidyviewEmail($email,$cc1, $cc2,'','A Register account reminder email for kidyview', $message);
            }
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

    ########################  End Add Driver Section #########################
    ######################## Get All The Driver ##############################

    public function getAllDriverForSchool_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->driver->getAllDriverForSchool($id);

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

    ###################   End Get All The Driver ####################################    
    #################### Edit Driver #############################################

    public function editDriver_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $driverphone = $postData['driverphone'];
        $driveremail = $postData['driveremail'];
        $driverId = $postData['id'];

        $drivervehicle = $postData['drivervehicle'];
        $vehcleData = $this->driver->VehicleUsed($postData['drivervehicle'],$postData['schoolId'],$driverId);
        if ($vehcleData) {
            $return['success'] = "false";
            $return['message'] = "Vehicle Exists.";
            $return['error'] = $this->error;
            $return['data'] = 'Selected Vehicle all ready used by Driver ' . $vehcleData->driverfname . ' ' . $vehcleData->driverlname . ' (' . $vehcleData->drivercode . '). For using the selected vehicle you have to disable the '.$vehcleData->driverfname . ' ' . $vehcleData->driverlname . ' (' . $vehcleData->drivercode.') or update the '.$vehcleData->driverfname . ' ' . $vehcleData->driverlname . ' (' . $vehcleData->drivercode . ')  vehicle';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }

        $result = $this->driver->driverExistInEditCase($driveremail, $driverphone, $driverId);
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
            'drivervehicle' => $drivervehicle,
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
        $update = $this->driver->editDriver($updateArr, $id, $schoolId);
        if ($update) {
            $whitelist = array('127.0.0.1', '::1');
            if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
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
                $mailResponse = sendKidyviewEmail($to,$cc1, $cc2,'','An edit account reminder email for kidyview', $message);
            }
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

    ############ End Edit Driver ###########################################################            
    ############ Driver Details #######################################

    public function getDriverDetails_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $result = $this->driver->getDriverDetails($id);
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

    ############ End Driver Details ###################################  
    
    
    
    
    
    ############# Driver Disable #####################################

    public function driverDisabled_post() {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $id = $postData['id'];
        $status = $postData['status'];
        $schoolid = $postData['schoolid'];
     
        $updateArr = array(
            'status' => $status,
        );
        
        $driverData = $this->driver->getdriverDetail($id,$schoolid);
        $vehcleData = $this->driver->VehicleUsed($driverData->drivervehicle,$schoolid);
        
        $datamsg = "";
        $message = "";
        $done = 0;
        $update = true;
        if($updateArr['status']==1)
        {
            if(isset($driverData->drivervehicle) && $driverData->drivervehicle!="") {
                
                if($vehcleData) {
                   $done = 0; 
                   $datamsg = 'This Driver Vehicle allready in used'; 
                   $message =  ' This Driver Vehicle is allready used by Driver ' . $vehcleData->driverfname . ' ' . $vehcleData->driverlname . ' (' . $vehcleData->drivercode . '). for enabling it you have to disable the '.$vehcleData->driverfname . ' ' . $vehcleData->driverlname . ' (' . $vehcleData->drivercode.') or change the '.$driverData->driverfname . ' ' . $driverData->driverlname . ' (' . $driverData->drivercode.') vehicle.';
                 }
                 else {
                   $this->driver->driverDisabled($updateArr, $id); 
                   $done = 1;
                   $datamsg = 'Successfull';
                   $message = 'Driver Status Enable Now';
                 }
                  
            }
            else {
              $done = 0;; 
              $datamsg = 'Error';
              $message = 'Unkonown Error Occured';
            }
        }
        else {
          $this->driver->driverDisabled($updateArr, $id); 
          $done = 1;
          $datamsg = 'Successfull';
          $message = 'Driver Status Disabled Now';
        }
       
        
        if ($update) {
            $return['success'] = "true";
            $return['done'] = $datamsg;
            $return['message'] = $message;
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

    ############# End Driver Disable #################################
    
    
    ###################  Scholl All Section Class List ###############
    
    public function getAllSectionClass_post() {

      $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $schoolid = $postData['schoolId'];
        $result = $this->driver->getAllSectionClass($schoolid);

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
    
    ###################  End Scholl All Section Class List ###############
    
    ################### Get All Student ################################
    public function getAllStudents_post() {
    $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $schoolid = $postData['schoolId'];
        $classSection = $postData['classSection'];
        $result = $this->driver->getAllStudents($schoolid,$classSection);

        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Student list";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "No Student found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    ################### Get All Student ################################
    
    
    ###################### Assign Students #############################
     public function assignStudents_post() {
         
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $schoolid = $postData['schoolId'];
        $classSection = $postData['classSection'];
        $driver = $postData['driver'];
        $students = $postData['student'];
        
        $conArray =  array(
           'schoolid' =>$schoolid,
           'classSection' =>$classSection,
           'driver' =>$driver,
        );
        
        $isExistArray =  array(
           'schoolid' =>$schoolid,
           'students' =>$students,
        );
       
        
        
         $isPrevAssigned = $this->driver->isPrevAssigned($isExistArray);
         if($isPrevAssigned['count']==1) {
          $return['success'] = "false";
          $return['message'] = "Some students allready assigned previously to you or other driver. ";
          $return['preAssign'] = $isPrevAssigned['assignList'];
          $return['error'] = 'Already Exists';
          $this->response($return, REST_Controller::HTTP_BAD_REQUEST);   
         }
         
        
        
        
        $studentExist = $this->driver->getStudents($conArray);
        $count = array();
        $done = array();
       
        
        for($i=0;$i<count($students);$i++) {
            
            if(count($studentExist)>0 &&  $this->checkIfExist($students[$i],$studentExist)==1 )
            {
                $count[] = $students[$i]; 
            }
           else 
           {
                 $addArr = array(
                'schoolid' => $conArray['schoolid'],
                'classid' => $conArray['classSection'],
                'driverid' =>$conArray['driver'],
                'studentid' => $students[$i],
                'created_date' =>date('Y-m-d H:i:s'),
                );
                $id = $this->driver->assignStudents($addArr);
                if($id) $done[] = $id;
           }
            
        }
        $message = "";
        $assignment = (count($count)>0) ? $this->showAssignment($count,$conArray) : '';
        if(count($count)>0) {
            $str = (count($count)>1) ? ' They are ' : ' it is ';
            $message = " Number of ".count($count)." Students not added because".$str."allready assign previously.";
            
        }
     
        if (count($done)>0) {
            $return['success'] = "true";
            $return['message'] = "Student Assign Successfully.".$message;
            $return['data'] = $done;
             $return['preAssign'] = $assignment;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "true";
            $return['message'] = "Error : No Student Added.Looks Like They Are Allready Assign Previously";
            $return['error'] = $this->error;
            $return['preAssign'] = $assignment;
            $this->response($return, REST_Controller::HTTP_OK);
        }
    }
    
    ##################### End Assign Students ##########################
    
    public function checkIfExist($value,$arrayList){
        $flag = 0;
        if(empty($arrayList))
         return $flag;  
        
         for($i=0;$i<count($arrayList);$i++)
         {
             if($arrayList[$i]['studentid']==$value){
             $flag = 1;   
             break;
             }
             
         }
       return $flag;  
    }
    
    public function showAssignment($students,$conArray){
    
        $string = array();
        $dataArray = array(); 
        
        if(empty($students))
        return $string;
       
        $query = "SELECT 
                  d.id as id,
                  CONCAT(d.driverfname, ' ',d.driverlname, ' (',d.drivercode,')') as driver, 
                  CONCAT(c.childfname, ' ',c.childmname, ' ', c.childlname,' (',c.childRegisterId,')') as student 
                  FROM driver_student_assignment as dsa 
                  LEFT join driver as d on d.id = dsa.driverid
                  LEFT join child as c on c.id = dsa.studentid 
                  WHERE dsa.driverid ='".$conArray['driver']."' And  dsa.schoolid ='".$conArray['schoolid']."' And dsa.classid = '".$conArray['classSection']."' And  dsa.studentid IN(".implode(',',$students).")";
        
        $query = $this->db->query($query);
        //echo $this->db->last_query(); exit;
        if ($query->num_rows() > 0) {
          $dataArray   = $query->result_array();
        } else {
           $dataArray = array();
        }
       
        if(count($dataArray)>0){
         for($i=0;$i<count($dataArray);$i++) {
             $string[$i]['assigned'] = 'Warning : '.$dataArray[$i]['student']. " All ready assigned To " . $dataArray[$i]['driver'];
            } 
          }
        
       return $string;
        
    }
    
    public function getDriverAssignList_post(){
    
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $schoolid = $postData['schoolId'];
        $driver = $postData['driver'];
        $result = $this->driver->getDriverAssignList($schoolid,$driver);
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "All Student list";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "false";
            $return['message'] = "No Student found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
     }
    
     
     public function deleteVehicle_post()
     {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $schoolid = $postData['schoolId'];
        $VehicleID = $postData['VehicleID'];
        $vehcleData = $this->driver->VehicleUsed($VehicleID,$schoolid);
        if ($vehcleData) {
            $return['success'] = "true";
            $return['done'] = '0';
            $return['data'] = "This Vehicle allready in used";
            $return['message'] = ' This Vehicle is allready used by Driver ' . $vehcleData->driverfname . ' ' . $vehcleData->driverlname . ' (' . $vehcleData->drivercode . ')';
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else 
        {
            $retData = $this->driver->deleteVehicle($schoolid,$VehicleID);
            if ($retData) {
            $return['done'] = '1';    
            $return['success'] = "true";
            $return['message'] = "Vehicle Deleted Successfully";
            $return['data'] = $VehicleID;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
            } else {
            $return['done'] = '0';     
            $return['success'] = "false";
            $return['message'] = "Error Occured While Deleting Vehicle";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }    
        }
     }
     
     
     public function deleteRoute_post()
     {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $schoolid = $postData['schoolId'];
        $RouteID = $postData['RouteID'];
        $vehcleData = $this->driver->routeUsed($RouteID,$schoolid);
        if ($vehcleData) {
            $return['success'] = "true";
            $return['done'] = '0';
            $return['data'] = $vehcleData;
            $return['message'] = "Error : Below are the Vehicle Which is currently using this root";
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else 
        {
            $retData = $this->driver->deleteRoute($schoolid,$RouteID);
            if ($retData) {
            $return['done'] = '1';    
            $return['success'] = "true";
            $return['message'] = "Route Deleted Successfully";
            $return['data'] = $RouteID;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
            } else {
            $return['done'] = '0';     
            $return['success'] = "false";
            $return['message'] = "Error Occured While Deleting Route";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }    
        }
     }
     
     
     public function deleteAssignStudent_post()
     {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $schoolid = $postData['schoolId'];
        $assignId = $postData['assignId'];
        $driverId = $postData['driverID'];
        
        $query = $this->db->query("SELECT * FROM daily_driver_journey WHERE schoolid = '".$schoolid."' And driverId = '".$driverId."' And date(created_date)='".date('Y-m-d')."'");
        if ($query->num_rows() > 0) {
        $return['done'] = '0';     
        $return['success'] = "false";
        $return['message'] = "This student is allready in today journey and it cannot deleted.";
        $return['error'] = $this->error;
        $return['data'] = '';
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);  
            
        }
        
        $retData = $this->driver->deleteAssignStudent($schoolid,$assignId);
        if ($retData) {
        $return['done'] = '1';    
        $return['success'] = "true";
        $return['message'] = "Student Unlink Successfully";
        $return['data'] = $assignId;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
        } else {
        $return['done'] = '0';     
        $return['success'] = "false";
        $return['message'] = "Error Occured While Unlink The Student";
        $return['error'] = $this->error;
        $return['data'] = '';
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }    
     }
     
     
     public function journeyLogStudents_post(){
    
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
            $postData = $_POST;
        }
        $schoolid = isset($postData['schoolId']) ? $postData['schoolId'] : "";
        $driverID = isset($postData['driverID']) ? $postData['driverID'] : "";
        $studentID = isset($postData['studentID']) ? $postData['studentID'] : "";
        $result = $this->driver->journeyLogStudents($schoolid,$driverID,$studentID);
        if ($result) {
            $return['success'] = "true";
            $return['message'] = "Student Journey Log Found";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        } else {
            $return['success'] = "true";
            $return['message'] = "No Student Journey Log Found.";
            $return['data'] = $result;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
     }
     
       
}
