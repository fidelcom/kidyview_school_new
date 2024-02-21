<?php



defined('BASEPATH') OR exit('No direct script access allowed');



class SchoolLogin extends CI_Controller {



    public function __construct() {

        parent::__construct();



        $this->load->helper('cookie');

        if ($this->input->cookie('remember_user', TRUE)) {

            $this->input->cookie('remember_user', TRUE);
        }
    }

    public function index($page = 'login') {

        $data['title'] = ucfirst($page); // Capitalize the first letter
        $data['image'] = $this->getImage();
        $data['bgimage'] = $this->getBgImage();
	$data['subscriptionData'] = $this->subscriptionData();
        $this->load->view("schoolLogin", $data);

    }
    public function signup($page = 'signup') {

        $data['title'] = ucfirst($page);
        $data['image'] = $this->getImage();
        $data['bgimage'] = $this->getBgImage();
        $data['subscriptionData'] = $this->subscriptionData();
        $data['countryData'] = $this->getCountryList();
        $this->load->view("signup/schoolSignup", $data);

    }
    public function subscription($page = 'signup') {

        $data['title'] = ucfirst($page);
        $data['image'] = $this->getImage();
        $data['bgimage'] = $this->getBgImage();
        $data['subscriptionData'] = $this->subscriptionData();
        $data['countryData'] = $this->getCountryList();
        $this->load->view("schoolSubscription", $data);

    }
    public function subscriptionData()
    {
        $this->db->where("status","1");
        $this->db->order_by("type");
        $query = $this->db->get("subscription");
        if($query->num_rows() > 0)
        {
            $data=$query->result_array();
            for($i=0;$i<count($data);$i++){
            $featureData=$this->feature_list($data[$i]['id']);
            $data[$i]['featureData']=$featureData;
            }
            return $data;
        }
        else
        {
            return array();
        }
    }

    public function feature_list($subscription_id=''){
        $this->db->where("subscription_id",$subscription_id);
        $this->db->where("is_enable","1");
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

    private function getImage(){

        $this->db->where("id",2);

        $query = $this->db->get("login_image");

        

        if($query->num_rows() == 1)

        {

            return $query->row()->image;

        }

        else

        {

            return 'kids.jpg';

        }

    }

    private function getBgImage(){

        $this->db->where("id",2);

        $query = $this->db->get("login_image");

        

        if($query->num_rows() == 1)

        {

            return $query->row()->bg_image;

        }

        else

        {

            return 'kids.jpg';

        }

    }



    public function fogetPassword($page = 'login') {



        $form_data = array('username' => $this->input->post('username'));

        $this->load->model('user');

        $userData = $this->user->getUser($form_data);



        $errorMessage = array();



        if (!$userData) {

            $errorMessage = array(

                'message_type' => 'error',

                'message' => 'User Name Not Found!!!',

                'color' => '#F78C8C'

            );

        } else {

            $username = $userData['username'];

            $password = $userData['password'];

            $email = $userData['email'];



            $subject = 'Password Recovery';





            $message = "<table width='600'>

				<tr>

				<td colspan=2><center><B>Account Detail</B></center></td>

				</tr>

				<tr>

				<td><B>User Name</B> </td><td>: " . $username . "</td>

				</tr>

				<tr>

				<td><B>Password</B> </td><td>: " . $password . "</td>

				</tr>

				</table>			

                ";

            // To send HTML mail, the Content-type header must be set

            $headers = 'MIME-Version: 1.0' . "\r\n";

            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";



            // Additional headers

            $headers .= 'From: info@amistos.com' . "\r\n";

            $to = $email;







            // Mail it

            $mail = mail($to, $subject, $message, $headers);



            if (!$mail) {

                $errorMessage = array(

                    'message_type' => 'Error',

                    'message' => 'Mail has been sent on your email id.',

                    'color' => '#F78C8C'

                );

            } else {

                $errorMessage = array(

                    'message_type' => 'Success',

                    'message' => 'Mail has been sent on your email id.',

                    'color' => '#E8F4D2'

                );

            }

        }



        $this->session->set_userdata($errorMessage);



        redirect('login');

    }



    public function validate_login() {

        $form_data = array(

            'username' => $this->input->post('UserName'),

            'password' => $this->input->post('Password')

        );

        $this->load->model('user');

        $userData = $this->user->getUser($form_data);





        if ($userData != false) {

            $remember = $this->input->post('remember');



            if ($remember == 'remember') {

                $this->input->set_cookie('remember_user', $this->input->post('UserName'), 3600);

                $this->input->set_cookie('remember_password', $this->input->post('Password'), 3600);

            }



            $data = array(

                'is_logged_in' => true,

                'user_data' => $userData,

                'user_role' => $userData['role']

            );



            $this->session->set_userdata($data);

            //print_r($data);

            //die;		

            switch ($userData['role']) {

                case 'admin':

                    redirect('owner');

                    exit;



                default :

                    redirect('administrator');

            }

        } else {

            $page = "administrator";

            $data['title'] = ucfirst($page); // Capitalize the first letter



            $errorMessage = array(

                'message_type' => 'error',

                'message' => 'Invalid Login Credentials!!!<br/>Please Enter Valid Credentials.',

                'color' => '#F78C8C'

            );

            $this->session->set_userdata($errorMessage);



            redirect('administrator');

        }

    }
	 public function logout() {
			$this->session->sess_destroy();
			redirect('schoolLogin');
	 
	 }
         
       public function getCountryList(){
        $this->db->select("code.id as id, CONCAT('+',code.phonecode) as code, code.name as country");
        $this->db->from("country_codes code");
        $query = $this->db->get();
        
        if($query->num_rows() >0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }
    
    public function allCurrency() 
        {
        $postData = json_decode(file_get_contents('php://input'), true);
        $newData = array();
	if ($postData == '') {
	$postData = $_POST;
	}
       
        $countryID = $postData['countrycode']; 
        $dataQuery = "select ac.* from admin_currency as ac where ac.id IN (select currency_id from map_currency where country_id=".$countryID.")";
        $query = $this->db->query($dataQuery); 
         if($query->num_rows() > 0) {
            $newData = $query->result_array();
         } 
         echo json_encode($newData);  
           
         }
        
        
        
    public function newAmount() 
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        $newData = array();
	if ($postData == '') {
	$postData = $_POST;
	}
       
          $id = $postData['currencyID'];      
          $this->db->select("*");
          $this->db->where('id',$id);
          $query = $this->db->get('admin_currency'); 
           
        if($query->num_rows() > 0) 
        {
         $newArray = array();   
         $curData  = json_decode(json_encode($query->row()), true);    
         $currencyPrice = $curData['currency_rate'];       
         $subcription = $this->subscriptionData();
         
         for($i=0;$i<count($subcription);$i++) {
            $newval = $subcription[$i]['amount'];
            if($id==1){
            $newArray[$i+1]['id'] = $subcription[$i]['id']; 
            $newArray[$i+1]['base_currency'] = 'NGN';
            $newArray[$i+1]['base_price'] = $subcription[$i]['amount'];
            $newArray[$i+1]['validity'] = $subcription[$i]['validity'];
            $newArray[$i+1]['new_currency_symbol'] = $curData['currency_symbol'];
            $newArray[$i+1]['new_currency_rate'] = $curData['currency_rate'];
            $newArray[$i+1]['new_currency_converted_amount'] = number_format($newval,2);   
            } 
            else {
            $newval = ($subcription[$i]['amount']>0) ? ($subcription[$i]['amount']/$currencyPrice):$subcription[$i]['amount']; 
            $newArray[$i+1]['id'] = $subcription[$i]['id']; 
            $newArray[$i+1]['base_currency'] = 'NGN';
            $newArray[$i+1]['base_price'] = $subcription[$i]['amount'];
            $newArray[$i+1]['validity'] = $subcription[$i]['validity'];
            $newArray[$i+1]['new_currency_symbol'] = $curData['currency_symbol'];
            $newArray[$i+1]['new_currency_rate'] = $curData['currency_rate'];
            $newArray[$i+1]['new_currency_converted_amount'] = number_format($newval,2);   
            }
            
            
          }
         
        }
         echo json_encode($newArray);    
        }      

}

