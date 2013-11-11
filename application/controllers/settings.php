<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {
	function __construct() {
		parent::__construct();
 		$this->load->database();
 		Engine::class_loader();
 		date_default_timezone_set("Asia/Manila");
	}

	function account() {
		$this->check_user_login();

		Engine::appStyle('bootstrap.min.css');

		Bootstrap::modal();

		Engine::appStyle('firms.css');
		Engine::appStyle('general.css');
		Engine::appScript('javascript.js');
		Engine::appScript('firms.js');
		Engine::appScript('confirmation.js');

		Engine::appScript("ckeditor/ckeditor.js");

		Jquery::form();
		Jquery::datatable();
		Jquery::inline_validation();
		Jquery::tipsy();

		$data['page_title'] = "CNP :: Profile Settings";
		$data['session'] 	= $session = $_SESSION['cnp']['login'];
		$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));

		$data['account_settings'] = 'super-active';

		$data['timezone'] = Timezone::findAll();

		$data['state']	= $array = array(
			"AL"=>"Alabama", "AK"=>"Alaska", "AZ"=>"Arizona", "AR"=>"Arkansas", "CA"=>"California", "CO"=>"Colorado",
			"CT"=>"Connecticut", "DE"=>"Delaware", "DC"=>"District Of Columbia", "FL"=>"Florida", "GA"=>"Georgia", "HI"=>"Hawaii",
			"ID"=>"Idaho", "IL"=>"Illinois", "IN"=>"Indiana", "IA"=>"Iowa", "KS"=>"Kansas", "KY"=>"Kentucky",
			"LA"=>"Louisiana", "ME"=>"Maine", "MD"=>"Maryland", "MA"=>"Massachusetts", "MI"=>"Michigan", "MN"=>"Minnesota",
			"MS"=>"Mississippi", "MO"=>"Missouri", "MT"=>"Montana", "NE"=>"Nebraska", "NV"=>"Nevada", "NH"=>"New Hampshire",
			"NJ"=>"New Jersey", "NM"=>"New Mexico", "NY"=>"New York", "NC"=>"North Carolina", "ND"=>"North Dakota", "OH"=>"Ohio",
			"OK"=>"Oklahoma", "OR"=>"Oregon", "PA"=>"Pennsylvania", "RI"=>"Rhode Island", "SC"=>"South Carolina", "SD"=>"South Dakota",
			"TN"=>"Tennessee", "TX"=>"Texas", "UT"=>"Utah", "VT"=>"Vermont", "VA"=>"Virginia", "WA"=>"Washington",
			"WV"=>"West Virginia", "WI"=>"Wisconsin", "WY"=>"Wyoming"
		);
		
		$this->load->view('settings/profile/forms/account_settings',$data);
	}

	function profile() {
		$this->check_user_login();

		//Engine::appStyle('bootstrap.css');
		Engine::appStyle('bootstrap.min.css');

		Bootstrap::modal();

		Engine::appStyle('firms.css');
		Engine::appStyle('general.css');
		Engine::appScript('settings.js');
		Engine::appScript('confirmation.js');

		Jquery::form();
		Jquery::inline_validation();
		Jquery::tipsy();

		$data['page_title'] = "CNP :: Profile Settings";
		$data['session'] 	= $session = $_SESSION['cnp']['login'];
		$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));

		$data['security_settings'] = 'super-active';
		
		$this->load->view('settings/profile/index',$data);
	}

	function edit_profile_settings_form() {
		$session = $_SESSION['cnp']['login'];
		$data['user'] = $user = User::findById($this->encrypt->decode($session['user_id']));
		if($user) {
			$this->load->view('settings/profile/forms/edit_profile',$data);
		} else { die("<script>error_404();</script>"); }
	}

	function save_profile() {
		$post = $this->input->post();
		if($post) {
			if($post['id']) {
				$post_id	= (int) $post['id'];
				$user 		= User::findById($post_id);
				if($user) {
					if($post['password']) {
						$password 		= $this->encrypt->encode($post['password']);
						$hash 			= Password_Hash::create_hash($post['password']);
						$last_update 	= date("Y-m-d H:i:s",time());
					} else {
						$password 		= $user['password'];
						$hash 			= $user['hash'];
						$last_update 	= $user['last_update'];
					}

					$username 	= strtolower($post['firstname'].$post['lastname'].uniqid().date("ymd"));
					$filename 	= $_SESSION['tmp']['uploaded_image']['user_filename'];
					if($filename != "" && $post) {
						$username 	= strtolower(($post['id'] ? $user['username'] : $username));
					
						$original_directory = "media/user/".$username."/";
						if(!is_dir($original_directory)) {
							mkdir($original_directory,0777,true);
						}

						$resized_directory	= "media/user/".$username."/resize/";
						if(!is_dir($resized_directory)) {
							mkdir($resized_directory,0777,true);
						}

						$thumb_directory = "media/user/".$username."/thumb/";
						if(!is_dir($thumb_directory)) {
							mkdir($thumb_directory,0777,true);
						}

						$original_src	= "media/tmp/image/user/".$filename;
						$original_image	= $original_directory.$filename;
						copy($original_src,$original_image);

						$resized_src	= "media/tmp/image/user/resize/".$filename;
						$resize_image	= $resized_directory.$filename;
						copy($resized_src,$resize_image);

						$thumb_src		= "media/tmp/image/user/thumb/".$filename;
						$thumb_image	= $thumb_directory.$filename;
						copy($thumb_src,$thumb_image);

						if($post['id']) {
							$old_filename = $user['display_image_url'];
							unlink($original_directory.$old_filename);
							unlink($resized_directory.$old_filename);
							unlink($thumb_directory.$old_filename);
						}

						unset($_SESSION['tmp']['uploaded_image']['user_filename']);

					} else {
						$filename = $user['display_image_url'];
					}
					

					$record = array(
						"firstname" 			=> $post['firstname'],
						"middlename" 			=> $post['middlename'],
						"lastname" 				=> $post['lastname'],
						"address" 				=> $post['address_street_1'] . " " . $post['address_street_2'],
						"email_address" 		=> $post['email_address'],
						"password" 				=> $password,
						"hash" 					=> $hash,
						"display_image_url"		=> $filename,
						"last_change_password" 	=> $last_update,
					);

					$user_id = User::save($record,$post_id);

					$name = $post['firstname'] . " " . $post['lastname'];
					$json['is_successful'] 	= true;
					$json['message']		= "Successfully Updated {$name}!";

				} else {
					$json['is_successful'] 	= false;
					$json['message']		= "Ooop! Error adding to database. Please contact web administrator!";
				}
			}
		} else {
			$json['is_successful'] 	= false;
			$json['message']		= "Ooop! Error adding to database. Please contact web administrator!";
		}

		echo json_encode($json);
	}

	function user_logout() {
		session_destroy();
		redirect("login/user/".$_SESSION['tmp']['url_hash']);
	}

	function case_alloted_list() {
		$this->check_user_login();
		Engine::XmlHttpRequestOnly();

		$this->load->view('settings/profile/case_alloted_list',$data);	
	}


}