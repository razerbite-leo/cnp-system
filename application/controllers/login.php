<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	function __construct() {
		parent::__construct();
 		$this->load->database();
 		Engine::class_loader();

	}
	
	function user()
	{	
		$segment_3 = $this->uri->segment(3);

		Engine::appStyle('bootstrap.min.css');

		Bootstrap::modal();

		Engine::appStyle('bootstrap.min.css');
		Engine::appStyle('login.css');
		Engine::appStyle('general.css');

		Engine::appScript('confirmation.js');

		Jquery::form();

		$data['page_title'] = 'Login';

		$_SESSION['tmp']['url_hash'] = $segment_3;

		$session = $_SESSION['cnp']['login'];
		if($session) {
			$user = User::findById($this->encrypt->decode($session['user_id']));	
		} else {
			$data['firm'] = $firm = Firm::findByUrlHash($segment_3);
			if(!$firm) {
				$data['logged_user'] = $logged_user = User::findByUsername($segment_3);
				
				if($logged_user) {
					$data['firm'] 			= $firm = Firm::findById($logged_user['firm_id']);
					$data['is_username']	= true;
				}
			}
		}
		
		if(!$user) {
			$login_failed = $this->session->flashdata('login_failed');
			if($login_failed) {
				$data['error_message'] = '<div class="alert alert-error"><button data-dismiss="alert" class="close" type="button">×</button><b><center>Invalid Username or Password!</center></b></div>';
			}

			$this->load->view('login/index',$data);
		} else {
			redirect("login/module_gateway");
		}
	}

	function authenticate_account() {
		$posts = $this->input->post();
		if($posts) {
			$username = $posts['username'];
			$password = $posts['password'];

			$user 		= User::findActiveUserByUsernameOrEmail($username);
			if($user) {

				$changed_password = Password_Recovery::findCurrentTransactByUserId($user['id']);
				if($changed_password) {
					$e_id 		= urlencode($this->encrypt->encode($user['id']));
					$key_url 	= $changed_password['url_key'];
					redirect('change_password?key='.$key_url."&id=".$user['id']);
					exit;
				}

				$verified_password 	= ($this->encrypt->decode($user['password']) == $password ? true : false);
				$verified_hash 		= Password_Hash::validate_password($password,$user['hash']);
				$is_firm_active		= Firm::isFirmActive($user['firm_id']);

				if($verified_password && $verified_hash && $is_firm_active) {
					$credentials = array(
						'user_id' 		=> $this->encrypt->encode($user['id']),
						'firm_id' 		=> $this->encrypt->encode($user['firm_id']),
						'firstname' 	=> $user['firstname'],
						'middlename' 	=> $user['middlename'],
						'lastname' 		=> $user['lastname'],
						'name' 			=> $user['firstname'] . ' ' . $user['lastname'],
						'account_type' 	=> $user['account_type'],

					);

					$_SESSION['cnp']['login'] = $credentials;
					redirect("login/module_gateway");
					
				} else {
					$this->session->set_flashdata('login_failed', true);
					redirect('login/user/'.$_SESSION['tmp']['url_hash']);
				}
				
			} else {
				$this->session->set_flashdata('login_failed', true);
				redirect('login/user/'.$_SESSION['tmp']['url_hash']);
			}
		}
	}

	function change_password() {
		$get = $this->input->get();

		unset($_SESSION['cnp']);
		unset($_SESSION['tmp']);

		if($get) {

			$user_id = (int) $get['id'];
			$url_key = $get['key'];

			$changed_password = Password_Recovery::findByUserIdKey($user_id, $url_key);
			if($changed_password) {

				Engine::appStyle('bootstrap.min.css');

				Bootstrap::modal();

				Engine::appStyle('bootstrap.min.css');
				Engine::appStyle('login.css');
				Engine::appStyle('general.css');

				Engine::appScript('confirmation.js');

				Jquery::form();

				$data['page_title'] = 'Login';

				$data['cp'] = $changed_password;

				$this->load->view('login/form/change_password',$data);

			} else {
				redirect('login');
			}
		} else { redirect('login'); }
	}

	function reset_password() {
		$post = $this->input->post();
		if($post) {
			$changed_password = Password_Recovery::findByUserIdKey($post['user_id'], $post['key']);
			if($changed_password) {
				$password 		= $this->encrypt->encode($post['password']);
				$hash 			= Password_Hash::create_hash($post['password']);
				$last_update 	= date("Y-m-d H:i:s",time());

				$record = array(
					"password" 				=> $password,
					"hash" 					=> $hash,
					"last_change_password" 	=> $last_update,
				);

				User::save($record,$post['user_id']);

				$record = array(
					"is_active" 		=> NO,
				);

				Password_Recovery::save($record, $changed_password['id']);
			}
		}

	}

	function module_gateway() {
		$session = $_SESSION['cnp']['login'];
		if($session) {
			$firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		
			if($session['account_type'] == SUPER_ADMIN) {
				redirect('super');
			} else if($session['account_type'] == FIRM_ADMIN)  {
				redirect("firms");
			} else if($session['account_type'] == USER_LEVEL)  {
				redirect("cases");
			}	
		} else {
			#Engine::appStyle('login.css');
			#$data['page_title'] = 'Login';
			#$this->load->view('login/index',$data);
			redirect('login/user/'.$_SESSION['tmp']['url_hash']);
		}
		
	}

	function isUserLogin() {

		$session = $_SESSION['cnp']['login'];

		if($session) {
			$user = User::findById($this->encrypt->decode($session['user_id']));
			if($user) {
				return true;
			}
		}

		return false;
	}

	function forgot_password() {
		Engine::XmlHttpRequestOnly();

		$post = $this->input->post();
		if($post) {
			$fields = array("id,email_address"); 
			$user 	= User::findByEmailAddress($post['username'], $fields);

			if($user) {

				$random_string = random_string("unique");

				$url_key	= str_replace("+","",$this->encrypt->encode($random_string));
				$url_hash 	= Password_Hash::create_hash($random_string);

				$record = array(
					"user_id" 			=> $user['id'],
					"url_key" 			=> $url_key,
					"url_hash" 			=> $url_hash,
					"is_active" 		=> YES,
					"date_expiration" 	=> date("Y-m-d", strtotime("+3 days")),
					"date_created" 		=> date("Y-m-d H:i:s",time()),
				);

				Password_Recovery::save($record);

				/*
				$this->load->library('email');

				$this->email->from('noreply@razerbite.com', 'System Administrator');
				$this->email->to("leoangelo.diaz@gmail.com"); 
				#$this->email->cc('another@another-example.com'); 
				#$this->email->bcc('them@their-example.com'); 

				$reset_link = base_url()."change_password?key={$url_key}&id=".$user['id'];
				$msg = '
					Click the link below you faggot. <br/><br/>
					<a target="_blank" href="{$reset_link}">{$reset_link}</a>
				';

				$this->email->subject('Account Recovery');
				$this->email->message($msg);	

				$this->email->send();

				echo $this->email->print_debugger();
				*/

			}
		}
	}

	function a() {
		$this->load->library('email');
		$this->email->from('noreply@razerbite.com', 'System Administrator');
		$this->email->to("leoangelo.diaz@gmail.com");
		#$this->email->cc('another@another-example.com'); 
		#$this->email->bcc('them@their-example.com'); 

		$reset_link = base_url()."change_password?key={$url_key}&id=".$user['id'];
		$msg = '
			Click the link below you faggot. <br/><br/>
			<a target="_blank" href="{$reset_link}">{$reset_link}</a>
		';

		$this->email->subject('Account Recovery');
		$this->email->message("test");	

		echo $this->email->send();

		#echo $this->email->print_debugger();
	}

	function email2() {
		$message = "Line 1\r\nLine 2\r\nLine 3";

		// In case any of our lines are larger than 70 characters, we should use wordwrap()
		$message = wordwrap($message, 70, "\r\n");

		// Send
		echo mail('leoangelo.diaz@gmail.com', 'My Subject', $message);
	}

}

