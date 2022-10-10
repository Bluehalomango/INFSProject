<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {
	public function index()
	{
		$data['error']= "";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		if (!$this->session->userdata('logged_in'))//check if user already login
		{
			$user_data = array(
				'logged_in' => false 	//create session variable
			);
			$this->session->set_userdata($user_data); //set user status to login in session
			if (get_cookie('remember')) { // check if user activate the "remember me" feature  
				$username = get_cookie('username'); //get the username from cookie
				$password = get_cookie('password'); //get the username from cookie
				if ($this->check_details($username, $password) )//check username and password correct
				{
					$user_data = array(
						'username' => $username,
						'logged_in' => true 	//create session variable
					);
					$this->session->set_userdata($user_data); //set user status to login in session
					redirect('store'); // direct user home page
				}
			}else{
				$this->load->view('login/login', $data);	//if username password incorrect, show error msg and ask user to login
			}
		}else{
			redirect('store'); // direct user home page
		}
		$this->load->view('template/footer');
	}

	public function check_login() {
		$this->load->model('User_model');		//load user model
		$data['error']= "<div class=\"alert alert-danger\" role=\"alert\"> Incorrect username or password </div> ";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$username = $this->input->post('username'); //getting password from login form
		$remember = $this->input->post('remember'); //getting username from login form
		$password = $this->input->post('password'); //getting remember checkbox from login form
		$recaptcha = $this->input->post('g-recaptcha-response'); //getting remember checkbox from login form
		$secret_key = '6LdjE74aAAAAAPt_ONPZgvz7ly1PUYiRldFhVuQ_';
		$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secret_key) .  '&response=' . urlencode($recaptcha);
        $response = file_get_contents($url);
		$responseKeys = json_decode($response,true);
		if($responseKeys["success"]) {
			if(!$this->session->userdata('logged_in')){	//Check if user already login
				if ( $this->check_details($username, $password) )//check username and password
				{
					$user_data = array(
						'username' => $username,
						'logged_in' => true 	//create session variable
					);
					if($remember) { // if remember me is activated create cookie
						set_cookie("username", $username, '300'); //set cookie username
						set_cookie("password", $password, '300'); //set cookie password
						set_cookie("remember", $remember, '300'); //set cookie remember
					}	
					$this->session->set_userdata($user_data); //set user status to login in session
					redirect('store'); // direct user home page
				}else
				{
					$this->load->view('login/login', $data);	//if username password incorrect, show error msg and ask user to login
				}
			} else{
				{
					redirect('store'); //if user already logined direct user to home page
				}
			$this->load->view('template/footer');
		}
	}
	$data['error']= "<div class=\"alert alert-danger\" role=\"alert\"> Please either check the reCAPTCHA or become a human. </div> ";
	$this->load->view('login/login', $data);	//if username password incorrect, show error msg and ask user to login
		
	}
	
	public function check_details($username, $password) {
		if ($this->User_model->check_user($username)) {
			$salt = $this->get_salt($username);
			echo $salt;
			$encryptedPassword = $password.$salt;
			$encryptedPassword = $this->hash($encryptedPassword);
			echo $encryptedPassword;
			return $this->User_model->login($username, $encryptedPassword);
		}
		return false;
	}

	public function get_salt($username) {
		return $this->User_model->get_single('salt', $username);
	}

	public function logout()
	{
		$this->load->helper('url');
		session_unset();
		session_destroy();
		redirect('login'); // redirect user back to login
	}

	public function create() 
	{
		$data['error']= "";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$this->load->view('login/create_account', $data);
		$this->load->view('template/footer');
	}

	public function create_account() 
	{
		$this->load->model('User_model');
		$data['error']= "";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$username = $this->input->post('username'); //getting password from form
		$password = $this->input->post('password'); //getting remember checkbox from form
		$salt = $this->encrypt($password);
		$encryptedPassword = $this->password_handle($password, $salt);
		$code = $this->User_model->create($username, $password, $salt, $encryptedPassword); 		//check username and password
		switch($code) {
			case 0:
				$user_data = array(
					'username' => $username,
					'logged_in' => true 	//create session variable
				);
				$this->session->set_userdata($user_data); //set user status to login in session
				redirect('store'); // direct user home page
				break;
			case 1:
				$data['error']= "<div class=\"alert alert-danger\" role=\"alert\"> Invalid Username. Please ensure your username is at least 7 characters long. </div> ";
				break;
			case 2:				
				$data['error']= "<div class=\"alert alert-danger\" role=\"alert\"> Invalid Password. Please ensure your password is at least 7 characters long and contains at least 1 non-alphanumeric character. </div> ";
				break;
			case 3:				
				$data['error']= "<div class=\"alert alert-danger\" role=\"alert\"> That username is already in use. Please choose a new username. </div> ";
				break;
		}
		$this->load->view('login/create_account', $data);
		$this->load->view('template/footer');
	}

	public function password_handle($password, $salt) {
		$encryptedPassword = $password.$salt;
		$encryptedPassword = $this->hash($encryptedPassword);
		return $encryptedPassword;
	}

	public function encrypt($password) {
		$salt = random_int(1000000000, 999999999999999);
		$salt = dechex($salt);
		return $salt;
	}

	public function hash($password) {
		return hash("sha1",$password);
	}

	public function forgot ($user = NULL) {
		$this->load->helper('form');
		$this->load->model('user_model');
		$this->load->view('template/header');
		$data['error']= "";
		if ($user) {
			$data['user']= $user;
		} else {
			$userID = $this->input->post('username');
			$data['user']= $userID;
		}
		$answer = $this->input->post('answer');
		$password = $this->input->post('password');		
		if ($password) {			
			if($this->user_model->create(NULL, $password, NULL, NULL) != 2) {
				$salt = $this->encrypt($password);
				$encryptedPassword = $this->password_handle($password, $salt);
				$this->user_model->change('password', $encryptedPassword, $user);
				$this->user_model->change('salt', $salt, $user);
				redirect('login');
			} else {
				$data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Invalid Password. Please ensure your password is at least 7 characters long and contains at least 1 non-alphanumeric character. </div> ";
				$this->load->view('login/password', $data);
			}
		} else if($answer) {
			if($this->user_model->check_question($user, $answer)) {
				$this->load->view('login/password', $data);
			} else {
				$data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Incorrect Answer. </div> ";
				$user =  $this->user_model->account($user);
				$data['question'] = $user[6];
				$data['answer']= $user[7];
				$this->load->view('login/question', $data);
			}
		} else if ($userID) {
			if ($this->user_model->check_user($userID)) {	
				$user = $this->user_model->account($userID);
				$data['question'] = $user[6];
				$data['answer']= $user[7];
				if ($user[7] == NULL || $user[6] == NULL) {
					$data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Warning, no secret question is currently set for that account. </div> ";
					$this->load->view('login/forgot', $data);
				} else {
					$this->load->view('login/question', $data);
				}
			} else {
				$data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Invalid Username. This username does not exist in our database. </div> ";
				$this->load->view('login/forgot', $data);
			}
		} else {
			$this->load->view('login/forgot', $data);
		}
	}
}
?>