<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Account extends CI_Controller
{
    public function index() {
      $this->load->view('template/header'); 
      if (!$this->session->userdata('logged_in')) {	//check if user already login
        if (get_cookie('remember')) { // check if user activate the "remember me" feature  
          $username = get_cookie('username'); //get the username from cookie
          $password = get_cookie('password'); //get the username from cookie
          if ($this->User_model->login($username, $password)) {  //check username and password correct
            $user_data = array('username' => $username,'logged_in' => true );
            $this->session->set_userdata($user_data); //set user status to login in session
            $this->load->view('file',array('error' => ' ')); //if user already logined show upload page
          }
        }else{
          redirect('login'); //if user already logined direct user to home page
        }
      }else{
        $user = $this->session->userdata('username');
        $data ['collection'] = $this->get_info($user); 
        $this->load->view('account/account', $data);
        $this->load->view('template/footer');
      }
    }

    function get_info($user) {
      $this->load->model('user_model');
      $results = $this->user_model->account($user);
      if ($results) {
          return ($results);
      }
    }

    function settings ($name) {
      $this->load->helper('url');
      $data['error']= "";
      $data['text']= $name;
      $this->load->view('template/header'); 
      $this->load->view('account/settings', $data); 
      $this->load->view('template/footer'); 
    }

    public function change ($type) {
      $this->load->helper('form');
      $info = $this->input->post('val'); //getting password from login form
      $this->load->model('User_model');		//load user model
      $this->User_model->change($type, $info, $_SESSION["username"]);
      $this->index();
    }

    public function question () {
      $this->load->helper('form');
      $answer = $this->input->post('newAnswer'); //getting password from login form
      $question = $this->input->post('newQuestion'); //getting password from login form
      $this->load->model('user_model');		//load user model
      if ($question && $answer) {
        $this->user_model->question($question, $answer, $_SESSION["username"]);
      }
      $this->load->view('template/header');
      $data['error']= "";
      $user =  $this->user_model->account($_SESSION["username"]);
      $data['question'] = $user[6];
      $data['answer']= $user[7];
      $this->load->view('account/question', $data);
    }

    public function hidden($current) {
      $new = !$current;
      $this->load->model('user_model');		//load user model
      $this->user_model->change("hidden", $new, $_SESSION["username"]);
      $this->index();
    }

    public function verify() {
      $this->load->model('user_model');		//load user model
      $code = random_int(100000, 999999);
      $email = $this->user_model->get_single("email", $_SESSION["username"]);
      $this->verify_email($code, $email);
      $this->user_model->change("verify_code", $code, $_SESSION["username"]);
      $this->load->view('template/header'); 
      $data['result'] = '';
      $this->load->view('account/verify', $data); 
      $this->load->view('template/footer'); 
    }

    public function verify_email($code, $email) {
      $msg = "Greetings. Your email verification code for your account is: ".$code;
      $config = Array(
          'protocol' => 'smtp',
          'smtp_host' => 'mailhub.eait.uq.edu.au',
          'smtp_port' => 25,
          'mailtype' => 'html',
          'charset' => 'iso-8859-1',
          'wordwrap' => TRUE ,
          'mailtype' => 'html',
          'starttls' => true,
          'newline' => "\r\n"
          );
          
      $this->email->initialize($config);
      $this->email->from('s4583074@student.uq.edu.au',get_current_user());
      $this->email->to($email);
      $this->email->subject("Account Verification");
      $this->email->message($msg);
      $this->email->send();
    }

    public function check_verify() {
      $this->load->helper('form');
      $inputCode = $this->input->post('code');
      $this->load->model('user_model');		//load user model
      $this->load->view('template/header'); 
      if ($this->user_model->check_code($inputCode, $_SESSION["username"])) {
        $data['result']= "Congrats! Your account has been successfully verified.";
        $this->user_model->change("verify_code", 0, $_SESSION["username"]);
        $this->user_model->change("verify", 1, $_SESSION["username"]);
        $this->load->view('account/verified'); 
      } else {
        $data['result']= "Unfortunately, the code you input is incorrect. If this issue persists, try to get another code sent and attempt the process again.";
        $this->load->view('account/verify', $data); 
      }
      $this->load->view('template/footer'); 
    }

    public function verify_phone() {
      $this->load->model('user_model');		//load user model
      $code = random_int(100000, 999999);
      $phone = $this->user_model->get_single("phone_number", $_SESSION["username"]);
      $this->phone_code($code, $phone);
      $this->user_model->change("verify_code", $code, $_SESSION["username"]);
      $this->load->view('template/header'); 
      $data['result'] = '';
      $data['code'] = $code;
      $this->load->view('account/verifyphone', $data); 
      $this->load->view('template/footer'); 
    }

    public function phone_code($code, $phone) {
        $msg = "Greetings. Your SMS verification code for your account is: ".$code;
        $senderid = "Bouwman";
        $to       = $phone;
        
              // Account details
        $apiKey = urlencode('ZmU4MDUyNjk5MDNlNTFiNzUyODRkMmJkMDY2NTE0N2M');
        
        // Message details
        $number = $phone;
        $sender = urlencode('Bouwman');
        $message = rawurlencode($msg);
        // Prepare data for POST request
        $data = array('apikey' => $apiKey, 'numbers' => $number, "sender" => $sender, "message" => $message, "test" => true);
        
        // Send the POST request with cURL
        $ch = curl_init('https://api.txtlocal.com/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        
        // Process your response here
        echo $response;
    }

    public function check_phone() {
      $this->load->helper('form');
      $inputCode = $this->input->post('code');
      $this->load->model('user_model');		//load user model
      $this->load->view('template/header'); 
      if ($this->user_model->check_code($inputCode, $_SESSION["username"])) {
        $data['result']= "Congrats! Your account has been successfully verified.";
        $this->user_model->change("verify_code", 0, $_SESSION["username"]);
        $this->user_model->change("phone_verified", 1, $_SESSION["username"]);
        $this->load->view('account/verifiedphone'); 
      } else {
        $data['result']= "Unfortunately, the code you input is incorrect. If this issue persists, try to get another code sent and attempt the process again.";
        $this->load->view('account/verifyphone', $data); 
      }
      $this->load->view('template/footer'); 
    }
}
?>


