<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Super extends CI_Controller {
	function __construct() {
		parent::__construct();
 		$this->load->database();
 		Engine::class_loader();
 		#date_default_timezone_set("Asia/Manila");
	}

	function index()
	{	
		$this->welcome();
	}

	function welcome() {
		$this->check_user_login();

		//Engine::appStyle('bootstrap.css');
		Engine::appStyle('bootstrap.min.css');

		Bootstrap::modal();

		Engine::appStyle('super.css');
		Engine::appStyle('general.css');
		Engine::appScript('javascript.js');
		Engine::appScript('super.js');
		Engine::appScript('confirmation.js');

		Engine::appScript("ckeditor/ckeditor.js");

		Jquery::form();
		Jquery::datatable();
		Jquery::inline_validation();
		Jquery::tipsy();
		Jquery::plup_uploader();
		Jquery::select2();

		$data['page_title'] = "CNP :: Admin";
		$data['session'] 	= $session = $_SESSION['cnp']['login'];
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));
		
		$this->load->view('super/welcome',$data);
	}

	function profile() {
		$this->check_user_login();

		Engine::appStyle('firm-admin-style.css');
		Engine::appStyle('tmp_admin-style.css');

		Jquery::form();
		Jquery::inline_validation();

		$data['page_title'] = "CNP :: Admin";
		$data['session'] 	= $session = $_SESSION['cnp']['login'];
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));
	
		$this->load->view('super/profile/index',$data);
	}

	function add_user() {
		$this->check_user_login();

		$data['firm'] 	= $firm = Firm::findAllActive();
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

		$data['session'] = $_SESSION['cnp']['login'];
		$this->load->view('super/manage_user/forms/add_user',$data);	
	}

	function manage_user_list() {
		$this->check_user_login();

		$fields = array("id,firm_id,firstname,middlename,lastname,email_address,account_type,account_status");
		$data['users'] 		= $users = User::findAllActiveUser($fields," id DESC");
		
		$data['session'] 	=  $session = $_SESSION['cnp']['login'];

		$data['user_id'] = (int) $this->encrypt->decode($session['user_id']);

		$this->load->view('super/manage_user/manage_user_list',$data);	
	}

	function check_email_address_validity() {
		$post = $this->input->post();
		$json['is_successful'] 	= true;
		if($post) {

			if($post['user_id']){
				$user_id = (int) $post['user_id'];
				$user = User::findDuplicateEmail($user_id, $post['email_address']);
				if($user)

					$json['is_successful']  = false;
					$json['message'] 		= "Email Address already exists!";
				
			} else {
				$user = User::findByEmailAddress($post['email_address']);
				if($user) {
					$json['is_successful']  = false;
					$json['message'] 		= "Email Address already exists!";
				}
			}
			
		} else {
			$json['is_successful'] = false;
			$json['message'] = "Oops! Something went wrong! Please refresh the page.";
		}

		echo json_encode($json);
	}

	function check_username_validity() {
		$post = $this->input->post();
		$json['is_successful'] 	= true;
		if($post) {
			$user = User::findByUsername($post['username']);
			if($user) {
				$json['is_successful']  = false;
				$json['message'] 		= "Username already exists!";
			}
		} else {
			$json['is_successful'] = false;
			$json['message'] = "Oops! Something went wrong! Please refresh the page.";
		}

		echo json_encode($json);
	}

	function save_firm_user() {
		$post = $this->input->post();
		if($post) {
			$post_id	= (int) $post['id'];
			$user 		= User::findById($post_id);

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

			} else {
				$filename = $user['display_image_url'];
			}

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

					$record = array(
						"firm_id" 				=> $post['firm_name'],
						"firstname" 			=> $post['firstname'],
						"middlename" 			=> $post['middlename'],
						"lastname" 				=> $post['lastname'],
						"address" 				=> $post['address_street_1'],
						"address_2" 			=> $post['address_street_2'],
						"city" 					=> $post['city'],
						"state" 				=> $post['state'],
						"zip" 					=> $post['zip_code'],
						"email_address" 		=> $post['email_address'],
						"password" 				=> $password,
						"hash" 					=> $hash,
						"account_type" 			=> $post['account_type'],
						"account_status" 		=> $post['account_status'],
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
				

			} else {
				$password 	= $this->encrypt->encode($post['password']);
				$hash 		= Password_Hash::create_hash($post['password']);

				$record = array(
					"firm_id" 			=> $post['firm_name'],
					"firstname" 		=> $post['firstname'],
					"middlename" 		=> $post['middlename'],
					"lastname" 			=> $post['lastname'],
					"address" 			=> $post['address_street_1'],
					"address_2" 		=> $post['address_street_2'],
					"city" 				=> $post['city'],
					"state" 			=> $post['state'],
					"zip" 				=> $post['zip_code'],
					"email_address" 	=> $post['email_address'],
					"username" 			=> $username,
					"password" 			=> $password,
					"hash" 				=> $hash,
					"account_type" 		=> $post['account_type'],
					"account_status" 	=> $post['account_status'],
					"display_image_url"	=> $filename,
					"date_created" 		=> date("Y-m-d H:i:s",time()),
				);

				$user_id = User::save($record);

				$name = $post['firstname'] . " " . $post['lastname'];
				$json['is_successful'] 	= true;
				$json['message']		= "Successful Added {$name} to database!";
			}

			/*
			$record = array(
				"user_id" 		=> $user_id,
				"contact_type" 	=> $post['contact_type'],
				"contact_value"	=> $post['contact'],
				"extension" 	=> $post['contact_extension'],
				"is_archive" 	=> NO,
				"date_created" 	=> date("Y-m-d H:i:s",time()),
			);
			User_Contact_List::save($record);
			*/

			foreach($post['other_contact'] as $key=>$value):
				$record = array(
					"user_id" 		=> $user_id,
					"contact_type" 	=> $value['contact_type'],
					"contact_value"	=> $value['contact_type_value'],
					"extension"	=> $value['contact_extension'],
					"is_archive" 	=> NO,
					"date_created" 	=> date("Y-m-d H:i:s",time()),
				);
				User_Contact_List::save($record);
			endforeach;

		}  else {
			$json['is_successful'] 	= false;
			$json['message']		= "Ooop! Error adding to database. Please contact web administrator!";
		}

		unset($_SESSION['tmp']['uploaded_image']['user_filename']);

		echo json_encode($json);
	}

	function debug_uniquid() {
		echo uniqid();
	}

	function firm_accounts() {
		$this->check_user_login();
		$data['firms'] 		= $firms = Firm::findAllActive("ORDER BY id DESC");
		$data['session'] 	= $_SESSION['cnp']['login'];

		$this->load->view('super/firm_accounts/firm_account_list',$data);	
	}

	function add_firm() {
		$this->check_user_login();
		//https://github.com/blueimp/jQuery-File-Upload/wiki

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

		$data['timezone'] = Timezone::findAll();

		$data['subscriptions'] 	= $subscriptions = Settings_Subscription_Plan::findAllActive("ORDER BY id ASC");
		$data['session'] 		= $_SESSION['cnp']['login'];

		$this->load->view('super/firm_accounts/forms/add_firm',$data);	
	}

	function check_email_address_firm_validity() {
		$post = $this->input->post();
		$json['is_successful'] 	= true;
		if($post) {
			if($post['firm_id']) {
				$firm_id 	= (int) $post['firm_id'];
				$firm 		= Firm::findDuplicateEmail($firm_id, $post['email_address']);
				if($firm) {
					$json['is_successful']  = false;
					$json['message'] 		= "Email Address already exists!";
				}
			} else {
				$user = Firm::findByEmailAddress($post['email_address']);
				if($user) {
					$json['is_successful']  = false;
					$json['message'] 		= "Email Address already exists!";
				}	
			}
			
		} else {
			$json['is_successful'] = false;
			$json['message'] = "Oops! Something went wrong! Please refresh the page.";
		}

		echo json_encode($json);
	}

	function save_firm() {
		$post = $this->input->post();
		if($post) {

			$subscription_id 	= (int) $post['subscription_id'];
			$post_id	 		= (int) $post['id'];

			$subscription 	= Settings_Subscription_Plan::findById($subscription_id);
			$firm 			= Firm::findById($post_id);

			$filename = $_SESSION['tmp']['uploaded_image']['firm_logo_url'];

			if($filename && $post) {

				$firm_name = strtolower(url_title(($firm['firm_name'] ? $firm['firm_name'] : $post['firm_name'])));

				$original_directory = "media/firm/".$firm_name."/";
				if(!is_dir($original_directory)) {
					mkdir($original_directory,0777,true);
				}

				$resized_directory	= "media/firm/".$firm_name."/resize/";
				if(!is_dir($resized_directory)) {
					mkdir($resized_directory,0777,true);
				}

				$thumb_directory	= "media/firm/".$firm_name."/thumb/";
				if(!is_dir($thumb_directory)) {
					mkdir($thumb_directory,0777,true);
				}

				$original_src	= "media/tmp/image/firm/".$filename;
				$original_image	= $original_directory.$filename;
				copy($original_src,$original_image);

				$resized_src	= "media/tmp/image/firm/resize/".$filename;
				$resize_image	= $resized_directory.$filename;
				copy($resized_src,$resize_image);

				$thumb_src		= "media/tmp/image/firm/thumb/".$filename;
				$thumb_image	= $thumb_directory.$filename;
				copy($thumb_src,$thumb_image);

				if($post['id']) {
					$old_filename = $firm['firm_logo_url'];
					unlink($original_directory.$old_filename);
					unlink($resized_directory.$old_filename);
					unlink($thumb_directory.$old_filename);
				}
			} else {
				$filename = $firm['firm_logo_url'];
			}

			if($post['id']) {

				if($firm) {

					$record = array(
						"timezone_id" 			=> $post['timezone_id'],
						"firm_name" 			=> $post['firm_name'],
						"address" 				=> $post['address_street_1'],
						"address_2" 			=> $post['address_street_2'],
						"city" 					=> $post['city'],
						"state" 				=> $post['state'],
						"zip" 					=> $post['zip'],
						"website_url"			=> $post['website_url'],
						"contact_person" 		=> $post['contact_person'],
						"position_firm" 		=> $post['firm_position'],
						"email_address" 		=> $post['email_address'],
						//"subscription_id" 	=> $subscription['id'],
						//"subscription_name" 	=> $subscription['subscription_name'],
						//"current_case_alloted" => $post['case_available_'.$subscription_id],
						//"remaining_case" 		=> $post['case_available_'.$subscription_id],
						"auto_renew_plan" 		=> $post['renew'],
						"firm_logo_url" 		=> $filename,
					);

					$firm_id = Firm::save($record,$post_id);

					$record = array(
						"firm_id" 				=> $firm_id,
						"subscription_name" 	=> "Test-Subscription",
						"case_alloted" 			=> 10,
						"auto_renew" 			=> YES,
						"last_modified_by" 		=> 1,
					);

					Firm_Subscription::save($record);

					$json['is_successful'] 	= true;
					$json['message']		= "Successful updated " . $post['firm_name'] . "!";

				} else {
					$json['is_successful'] 	= false;
					$json['message']		= "Ooop! Error adding to database. Please contact web administrator!";
				}
			} else {
				$subscription = Settings_Subscription_Plan::findById($post['subscription_id']);

				$this->load->helper('string');

				$salt 		= random_string('unique');
				$url_hash	= substr(md5($post['firm_name'].$salt), 0,32);

				$record = array(
					"url_hash" 				=> $url_hash,
					"timezone_id" 			=> $post['timezone_id'],
					"firm_name" 			=> $post['firm_name'],
					"address" 				=> $post['address_street_1'] . " " . $post['address_street_2'],
					"city" 					=> $post['city'],
					"state" 				=> $post['state'],
					"zip" 					=> $post['zip'],
					"website_url"			=> $post['website_url'],
					"contact_person" 		=> $post['contact_person'],
					"position_firm" 		=> $post['firm_position'],
					"email_address" 		=> $post['email_address'],
					//"subscription_id" 		=> $subscription['id'],
					//"subscription_name" 	=> $subscription['subscription_name'],
					//"current_case_alloted" 	=> $post['case_available_'.$subscription['id']],
					//"remaining_case" 		=> $post['case_available_'.$subscription['id']],
					"auto_renew_plan" 		=> $post['renew'],
					"firm_logo_url" 		=> $filename,
					"theme_id" 				=> 1,
					"is_archive" 			=> NO,
					"account_status" 		=> ACTIVE,
					"date_created" 			=> date("Y-m-d H:i:s",time()),
				);

				$firm_id = FIRM::save($record);

				$json['is_successful'] 	= true;
				$json['message']		= "Successful Added " . $post['firm_name'] . " to database!";
			}

			foreach($post['other_contact'] as $key=>$value):
				if($value['contact_type_value']) {
					$record = array(
						"firm_id" 		=> $firm_id,
						"contact_type" 	=> $value['contact_type'],
						"contact_value"	=> $value['contact_type_value'],
						"extension"		=> $value['contact_extension'],
						"is_archive" 	=> NO,
						"date_created" 	=> date("Y-m-d H:i:s",time()),
					);
					Firm_Contact_List::save($record);
				}
			endforeach;

		} else {
			$json['is_successful'] 	= false;
			$json['message']		= "Ooop! Error adding to database. Please contact web administrator!";
		}

		unset($_SESSION['tmp']['uploaded_image']['firm_logo_url']);

		echo json_encode($json);
	}

	function upload_firm_photo() {
		sleep(1);
		$json['is_uploaded'] = false;
		$file = $_FILES['photo'];
		if($file) {
			switch($_FILES['photo']['type']) {
		        case "image/jpeg" : $file_type  = ".jpg"; break;
		        case "image/png" : $file_type   = ".png"; break;
		        case "image/gif" : $file_type   = ".gif"; break;
		        default: $file_type = ".jpg";
		    }

		    $this->load->helper('string');

			$random_key = random_string('unique');
			$filename 	= $this->encrypt->sha1(basename($file['name']."$random_key")).date("hims",time())."{$file_type}";
			
			$original_path 	= 'media/tmp/image/firm/';
	        $resized_path 	= 'media/tmp/image/firm/resize/';
	        $thumb_path 	= 'media/tmp/image/firm/thumb/';

			if(!is_dir($original_path)) {
				mkdir($original_path,0777,true);
			}

			if(!is_dir($resized_path)) {
				mkdir($resized_path,0777,true);
			}

			if(!is_dir($thumb_path)) {
				mkdir($thumb_path,0777,true);
			}

			$path = "media/tmp/image/firm/$filename";

			if(move_uploaded_file($file['tmp_name'], $path)) {
				$json['is_uploaded'] = true;

		        $this->load->library('image_lib', $config);
		        $config = array(
		            'source_image' 		=> $original_path.$filename, //path to the uploaded image
		            'new_image' 		=> $resized_path,
		            'maintain_ratio' 	=> TRUE,
		            'master_dim' 		=> "auto",
		            'width' 			=> 300,
		            'height' 			=> 150,
		            'quality' 			=> 100
		        );
		        $this->image_lib->initialize($config);
		        $this->image_lib->resize();

		        $config = array(
		            'source_image' 		=> $original_path.$filename, //path to the uploaded image
		            'new_image' 		=> $thumb_path,
		            'maintain_ratio' 	=> TRUE,
		            'master_dim' 		=> "auto",
		            'width' => 36,
		            'height' => 36,
		            'quality' => 100
		        );
		        $this->image_lib->initialize($config);
		        $this->image_lib->resize();
			}

			$tmp_image = MEDIA_FOLDER."tmp/image/firm/resize/$filename";

			$_SESSION['tmp']['uploaded_image']['firm_logo_url'] = $filename;
	
			echo $tmp_image;
		}
	}

	function upload_user_photo() {
		sleep(1);
		$json['is_uploaded'] = false;
		$file = $_FILES['photo'];
		if($file) {
			switch($_FILES['photo']['type']) {
		        case "image/jpeg" : $file_type  = ".jpg"; break;
		        case "image/png" : $file_type   = ".png"; break;
		        case "image/gif" : $file_type   = ".gif"; break;
		        default: $file_type = ".jpg";
		    }

		    $this->load->helper('string');

			$random_key = random_string('unique');
			$filename 	= $this->encrypt->sha1(basename($file['name']."$random_key")).date("hims",time())."{$file_type}";

			$original_path 	= 'media/tmp/image/user/';
	        $resized_path 	= 'media/tmp/image/user/resize/';
	        $thumb_path 	= 'media/tmp/image/user/thumb/';

			if(!is_dir($original_path)) {
				mkdir($original_path,0777,true);
			}

			if(!is_dir($resized_path)) {
				mkdir($resized_path,0777,true);
			}

			if(!is_dir($thumb_path)) {
				mkdir($thumb_path,0777,true);
			}

			$path = "media/tmp/image/user/$filename";

			if(move_uploaded_file($file['tmp_name'], $path)) {
				$json['is_uploaded'] = true;

		        $this->load->library('image_lib');

		        $this->load->library('image_lib', $config);
		        $config = array(
		            'source_image' => $original_path.$filename, //path to the uploaded image
		            'new_image' => $resized_path,
		            'maintain_ratio' => FALSE,
		            'width' => 120,
		            'height' => 120,
		            'quality' => 100
		        );
		        $this->image_lib->initialize($config);
		        $this->image_lib->resize();

		        $config = array(
		            'source_image' => $original_path.$filename, //path to the uploaded image
		            'new_image' => $thumb_path,
		            'maintain_ratio' => FALSE,
		            'width' => 36,
		            'height' => 36,
		            'quality' => 100
		        );
		        $this->image_lib->initialize($config);
		        $this->image_lib->resize();

			}

			$tmp_image = MEDIA_FOLDER."tmp/image/user/$filename";

			$_SESSION['tmp']['uploaded_image']['user_filename'] = $filename;
	
			echo $tmp_image;
		}
	}

	function edit_user() {
		$post = $this->input->post();
		$success = false;
		if($post) {
			$this->check_user_login();

			$post_id 		=  (int) $post['id'];
			$data['user'] 	= $user = User::findById($post_id);

			if($user) {

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
				
				$success 			= true;
				$data['firm'] 		= $firm = Firm::findAllActive();
				$data['session']	= $session = $_SESSION['cnp']['login'];

				$data['can_delete'] = $can_delete = ( (int) $this->encrypt->decode($session['user_id']) != $post_id && $user['account_type'] != SUPER_ADMIN ? true : false );
				$this->load->view('super/manage_user/forms/edit_user',$data);
			} 
		}

		if(!$success)
		die("<script>error_404();</script>");
		
	}

	function user_current_contact_list() {
		Engine::XmlHttpRequestOnly();
		$post = $this->input->post();
		if($post) {
			$user_id =  (int) $post['user_id'];

			$data['contact_list'] = $contact_list = User_Contact_List::findAllByUserId($user_id);

			$this->load->view('super/manage_user/user_current_contact_list.php',$data);
		}
	}

	function edit_user_contact_form() {
		Engine::XmlHttpRequestOnly();
		$post 		= $this->input->post();
		$success 	= false;
		if($post) {
			$post_id 	= (int) $post['id'];
			$data['cl'] = $contact_list = User_Contact_List::findById($post_id);
			if($contact_list) {
				$success = true;
				$this->load->view('super/manage_user/forms/edit_user_contact',$data);
			}
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function save_user_contact_form() {
		$post 		= $this->input->post();
		$success 	= false;
		if($post) {
			$post_id 		= (int) $post['id'];
			$contact_list 	= User_Contact_List::findById($post_id);
			if($contact_list) {
				if($post['edit_user_contact_type'] != "Fax" && $post['edit_user_contact_type'] != "Work") {
					unset($post['edit_user_contact_extension']);
				}
				$record = array(
					"contact_type" 	=> $post['edit_user_contact_type'],
					"contact_value"	=> $post['edit_user_contact_type_value'],
					"extension" 	=> $post['edit_user_contact_extension'],
					"is_archive" 	=> NO,
				);
				User_Contact_List::save($record,$post_id);
				$success = true;

				$json['is_successful'] 	= true;
				$json['message'] 		= "Successfully updated!";
			}
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function delete_user_contact_form() {
		$post 		= $this->input->post();
		$success 	= false;

		if($post) {
			$post_id 		= (int) $post['id'];
			$data['cl'] 	= $contact_list = User_Contact_List::findById($post_id);
			if($contact_list) {
				$success = true;
				$this->load->view('super/manage_user/forms/delete_user_contact',$data);
			}
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function delete_user_contact() {
		$post 		= $this->input->post();
		$success 	= false;

		if($post) {
			$post_id 		= (int) $post['id'];
			$data['cl'] 	= $contact_list = User_Contact_List::findById($post_id);
			if($contact_list) {
				$success = true;
				User_Contact_List::delete($post_id);
			}
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function delete_user_form() {
		$post 		= $this->input->post();
		$success 	= false;

		if($post) {
			$post_id 		= (int) $post['id'];
			$data['user'] 	= $user = User::findById($post_id);
			if($user) {
				$success = true;
				$this->load->view('super/manage_user/forms/delete_user',$data);
			}
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function delete_user() {
		$post 		= $this->input->post();

		if($post) {
			$post_id 	= (int) $post['id'];
			$user 		= User::findById($post_id);

			if($user) {
				$success = true;
				User::delete($post_id);

				$json['is_successful'] 	= true;
				$json['message'] 		= "Successfully deleted!";
			}
		} else {
			$json['is_successful'] 	= false;
			$json['message']		= "Ooop! Error adding to database. Please contact web administrator!";
		}

		echo json_encode($json);
	}

	function edit_firm() {
		$post = $this->input->post();
		$success = false;
		if($post) {
			$this->check_user_login();

			$post_id 		=  (int) $post['id'];
			$data['firm'] 	= $firm = Firm::findById($post_id);

			if($firm) {

				$data['state']	= $array = array(
					"AL"=>"Alabama", "AK"=>"Alaska", "AZ"=>"Arizona", "AR"=>"Arkansas", "CA"=>"Calyofornia", "CO"=>"Colorado",
					"CT"=>"Connecticut", "DE"=>"Delaware", "DC"=>"District Of Columbia", "FL"=>"Florida", "GA"=>"Georgia", "HI"=>"Hawaii",
					"ID"=>"Idaho", "IL"=>"Illinois", "IN"=>"Indiana", "IA"=>"Iowa", "KS"=>"Kansas", "KY"=>"Kentucky",
					"LA"=>"Louisiana", "ME"=>"Maine", "MD"=>"Maryland", "MA"=>"Massachusetts", "MI"=>"Michigan", "MN"=>"Minnesota",
					"MS"=>"Mississippi", "MO"=>"Missouri", "MT"=>"Montana", "NE"=>"Nebraska", "NV"=>"Nevada", "NH"=>"New Hampshire",
					"NJ"=>"New Jersey", "NM"=>"New Mexico", "NY"=>"New York", "NC"=>"North Carolina", "ND"=>"North Dakota", "OH"=>"Ohio",
					"OK"=>"Oklahoma", "OR"=>"Oregon", "PA"=>"Pennsylvania", "RI"=>"Rhode Island", "SC"=>"South Carolina", "SD"=>"South Dakota",
					"TN"=>"Tennessee", "TX"=>"Texas", "UT"=>"Utah", "VT"=>"Vermont", "VA"=>"Virginia", "WA"=>"Washington",
					"WV"=>"West Virginia", "WI"=>"Wisconsin", "WY"=>"Wyoming"
				);

				$data['timezone'] = $a = Timezone::findAll();

				#debug_array($firm);

				$success 				= true;
				$data['subscriptions'] 	= $subscriptions = Settings_Subscription_Plan::findAllActive("ORDER BY id ASC");
				$data['session']		= $_SESSION['cnp']['login'];
				$this->load->view('super/firm_accounts/forms/edit_firm',$data);
			} 
		}

		if(!$success)
		die("<script>error_404();</script>");
		
	}

	function firm_current_contact_list() {
		$post = $this->input->post();
		if($post) {
			$firm_id =  (int) $post['firm_id'];

			$data['contact_list'] = $contact_list = Firm_Contact_List::findAllByFirmId($firm_id);

			$this->load->view('super/firm_accounts/firm_current_contact_list',$data);
		}
	}

	function edit_firm_contact_form() {
		$post 		= $this->input->post();
		$success 	= false;
		if($post) {
			$post_id 	= (int) $post['id'];
			$data['cl'] = $contact_list = Firm_Contact_List::findById($post_id);
			if($contact_list) {
				$success = true;
				$this->load->view('super/firm_accounts/forms/edit_firm_contact',$data);
			}
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function save_firm_contact_form() {
		$post 		= $this->input->post();
		$success 	= false;
		if($post) {
			$post_id 		= (int) $post['id'];
			$contact_list 	= Firm_Contact_List::findById($post_id);
			if($contact_list) {
				if($post['edit_firm_contact_type'] != "Fax" && $post['edit_firm_contact_type'] != "Work") {
					unset($post['edit_firm_contact_extension']);
				}
				$record = array(
					"contact_type" 	=> $post['edit_firm_contact_type'],
					"contact_value"	=> $post['edit_firm_contact_type_value'],
					"extension" 	=> $post['edit_firm_contact_extension'],
					"is_archive" 	=> NO,
				);
				Firm_Contact_List::save($record,$post_id);
				$success = true;

				$json['is_successful'] 	= true;
				$json['message'] 		= "Successfully updated!";
			}
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function delete_firm_contact_form() {
		$post 		= $this->input->post();
		$success 	= false;

		if($post) {
			$post_id 		= (int) $post['id'];
			$data['cl'] 	= $contact_list = Firm_Contact_List::findById($post_id);
			if($contact_list) {
				$success = true;
				$this->load->view('super/firm_accounts/forms/delete_firm_contact',$data);
			}
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function delete_firm_contact() {
		$post 		= $this->input->post();
		$success 	= false;

		if($post) {
			$post_id 		= (int) $post['id'];
			$data['cl'] 	= $contact_list = Firm_Contact_List::findById($post_id);
			if($contact_list) {
				$success = true;
				Firm_Contact_List::delete($post_id);
			}
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function delete_firm_form() {
		$post 		= $this->input->post();
		$success 	= false;

		if($post) {
			$post_id 		= (int) $post['id'];
			$data['firm'] 	= $firm = Firm::findById($post_id);
			if($firm) {
				$success = true;
				$this->load->view('super/firm_accounts/forms/delete_firm',$data);
			}
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function delete_firm() {
		$post 		= $this->input->post();

		if($post) {
			$post_id	= (int) $post['id'];
			$firm 		= Firm::findById($post_id);

			if($firm) {
				$success = true;
				//Firm::delete($post_id);

				$record = array(
					"account_status" 	=> INACTIVE,
					"is_archive" 		=> YES,
				);
				Firm::save($record,$post_id);

				$json['is_successful'] 	= true;
				$json['message'] 		= "Successfully deleted!";
			}
		} else {
			$json['is_successful'] 	= false;
			$json['message']		= "Ooop! Error adding to database. Please contact web administrator!";
		}

		echo json_encode($json);
	}

	function manage_document() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();

		$this->load->view('super/document/manage_document',$data);
	}

	function document_list_dt() {
		$this->check_user_login();

		$post = $this->input->post();
		if($post) {
			
			$data['firms'] 		= $firms = Firm::findAllActive("ORDER BY firm_name ASC");
			$data['session'] 	= $session = $_SESSION['cnp']['login'];
			$data['parent_id']	= $parent_id = (int) $post['parent_id'];
			$data['user_id'] 	= $user_id = $this->encrypt->decode($session['user_id']);
			$data['firm_id'] 	= $user_id = $this->encrypt->decode($session['firm_id']);
			$data['documents']	= $documents = Document::findAllAdminDocument($user_id,$parent_id,$firm_id,"id ASC");

			$this->load->view('super/document/document_list',$data);
		}	
	}

	function add_document_set_form() {
		$data['session'] 	= $session = $_SESSION['cnp']['login'];
		$success 			= false;

		if($session) {
			$success 	= true;
			$user_id 	= $this->encrypt->decode($session['user_id']);
			$firm_id 	= $this->encrypt->decode($session['firm_id']);
		
			$data['parent_set'] = $parent_set = Document::findAllActiveOwnDocumentSet($user_id,"ID ASC");
			$data['firms'] 		= $firms = Firm::findOtherActiveFirm($firm_id);

			$this->load->view('super/document/form/add_document_set',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function edit_document_set_form() {
		Engine::XmlHttpRequestOnly();

		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {
			$success 	= true;
			$user_id 	= $this->encrypt->decode($session['user_id']);
			$firm_id 	= $this->encrypt->decode($session['firm_id']);
			$post_id 	= (int) $post['id'];

			$data['document']	= $document = Document::findById($post_id);
			$data['parent_set'] = $parent_set = Document::findAllActiveOwnDocumentSet($user_id,"ID ASC");
			$data['firms'] 		= $firms = Firm::findOtherActiveFirm($firm_id);

			foreach(unserialize($document['visible_to']) as $key=>$value):
				$visible_to[] = $value;
			endforeach;

			$data['visible_to'] = $visible_to;

			$this->load->view('super/document/form/edit_document_set',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function save_document_set() {
		Engine::XmlHttpRequestOnly();

		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {

			if($post['id']) {

				$post_id 	= (int) $post['id'];
				$document 	= Document::findById($post_id);
				if($document) {
					if($document['file_type'] == FILE) {

						$only_me 	= 0;
						$visibility = ($post['visible_to'] ? '' : $only_me);

						$record = array(
							"title" 		=> $post['title'],
							"description" 	=> $post['description'],
							"document_text" => $post['document_text'],
							"visibility" 	=> $visibility,
							"visible_to" 	=> serialize($post['visible_to']),
							"show_to_firms" 	=> $post['show_to_firms'],
							"last_modified_by" 	=> $user['id'],
						);

					} else {
						$record = array(
							"title" 		=> $post['title'],
							"description" 	=> $post['description'],
							"visibility" 	=> $visibility,
							"visible_to" 	=> serialize($post['visible_to']),
							"show_to_firms" 	=> $post['show_to_firms'],
							"last_modified_by" 	=> $user['id'],
						);
					}
		
					$document_id 			= Document::save($record, $post_id);
					$json['is_successful'] 	= true;
					$json['message']		= "Successfully updated " . $post['title'] . "!";

				} else {
					$json['is_successful'] 	= false;
					$json['message']		= "Ooop! Error adding to database. Please contact web administrator!";
				}


			} else {
				$success 		= true;
				$user_id 		= $this->encrypt->decode($session['user_id']);

				$only_me 	= 0;
				$visibility = ($post['visible_to'] ? '' : $only_me);

				$record = array(
					"firm_id" 		=> $user['firm_id'],
					"parent_id" 	=> $post['parent'],
					"uploaded_by" 	=> $user_id,
					"title" 		=> $post['title'],
					"description" 	=> $post['description'],
					"file_type" 	=> DOCUMENT_SET,
					"visibility" 	=> $visibility,
					"visible_to" 	=> serialize($post['visible_to']),
					"is_archive" 	=> NO,
					"show_to_firms" => $post['show_to_firms'],
					"date_created" 	=> Tool::getCurrentDateTime("Y-m-d H:i:s","Asia/Manila"),
					"last_modified_by" 	=> $user['id'],
				);

				$document_id 			= Document::save($record);
				$json['is_successful'] 	= true;
				$json['message']		= "Successfully added " . $post['title'] . " document set!";
			}

			
			$document_permission = Document_Permission::findAllByDocumentId($document_id);
			foreach($document_permission as $key=>$value):
				Document_Permission::delete($value['id']);
			endforeach;

			foreach($post['visible_to'] as $key=>$value):
				if($value)
					$record = array(
						"document_id" 	=> $document_id,
						"firm_id" 		=> $value,
					);

					Document_Permission::save($record);
			endforeach;
			
			
			
		} else {
			$json['is_successful'] 	= false;
			$json['message']		= "Ooop! Error adding to database. Please contact web administrator!";
		}

		echo json_encode($json);
	}

	function delete_document_set_form() {
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {
			$post_id = (int) $post['id'];

			$data['document'] = $document = Document::findById($post_id);

			if($document) {
				$success = true;
				$this->load->view('super/document/form/delete_document_set',$data);
			}
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function delete_document_set() {
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {
			$post_id 	= (int) $post['id'];
			$document 	= Document::findById($post_id);
			if($document) {
				$success = true;
				
				$json['is_successful'] 	= true;
				$json['message']		= "Successfully deleted " . $document['title'] . " document set!";

				Document::delete($post_id);
			}
		} else {
			$json['is_successful'] 	= false;
			$json['message']		= "Ooop! Error adding to database. Please contact web administrator!";
		}
	}

	function upload_document_form() {
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {
			$success = true;
			$data['current_parent_id'] = $post['parent_id'];
			$this->load->view('super/document/form/upload_document',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function upload_case_document() {

		$success 	= false;
		$get 		= $this->input->get();
		$file 		= $_FILES['file'];
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($file && $session && $user) {

			$this->load->helper('string');
			$get_cpi 	= (int) $get['cpi'];
			$random_key = random_string('unique');

			$file_extension	= substr($file['name'], -3);
			$filename 		= $this->encrypt->sha1(basename($file['name']."$random_key")).date("hims",time()).".{$file_extension}";
			$upload_name 	= $file['name'];
			$file_type		= FILE;
			$file_size 		= $file['size'];

			$dir = "files/case_document/".$this->encrypt->decode($session['user_id'])."/";
			if(!is_dir($dir)) {
				mkdir($dir,0777,true);
			}

			$path = "$dir/$filename";
			
			if(move_uploaded_file($file['tmp_name'], $path)) {
				$record = array(
					"firm_id" 			=> $user['firm_id'],
					"parent_id" 		=> $get_cpi,
					"uploaded_by" 		=> $user['id'],
					"title" 			=> url_title(substr($upload_name, 0,-4), 'dash', true),
					"upload_name" 		=> $upload_name,
					"filename" 			=> $filename,
					"file_size" 		=> $file_size,
					"file_type" 		=> FILE,
					"file_extension" 	=> $file_extension,
					"path" 				=> $dir,
					"is_archive" 		=> NO,
					"date_created" 		=> Tool::getCurrentDateTime("Y-m-d H:i:s","Asia/Manila"),
				);

				document::save($record);
			}
		}
	}

	function edit_document_form() {
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {
			$success 	= true;
			$firm_id 	= $this->encrypt->decode($session['firm_id']);
			$user_id 	= $this->encrypt->decode($session['user_id']);
			$post_id 	= (int) $post['id'];

			$data['current_parent_id'] 	= (int) $current_parent_id;
			$data['document'] 			= $document = Document::findById($post_id);
			$data['firms'] 				= $firms = Firm::findOtherActiveFirm($firm_id);

			foreach(unserialize($document['visible_to']) as $key=>$value):
				$visible_to[] = $value;
			endforeach;
			$data['visible_to'] = $visible_to;
			$this->load->view('super/document/form/edit_document',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function delete_document_form() {
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {
			$post_id = (int) $post['id'];

			$data['document'] = $document = Document::findById($post_id);

			if($document) {
				$success = true;
				$this->load->view('super/document/form/delete_document',$data);
			}
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function delete_document() {
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {
			$post_id 	= (int) $post['id'];
			$document 	= Document::findById($post_id);
			if($document) {
				$success = true;
				
				$json['is_successful'] 	= true;
				$json['message']		= "Successfully deleted " . $document['title'] . " document set!";

				unlink($document['path'].$document['filename']);
				Document::delete($post_id);
			}
		} else {
			$json['is_successful'] 	= false;
			$json['message']		= "Ooop! Error adding to database. Please contact web administrator!";
		}
	}

	function shared_document_list_dt() {
		$this->check_user_login();

		$post = $this->input->post();
		if($post) {
			
			$data['firms'] 		= $firms = Firm::findAllActive("ORDER BY firm_name ASC");
			$data['session'] 	= $session = $_SESSION['cnp']['login'];
			$data['parent_id']	= $parent_id = (int) $post['parent_id'];
			$data['user_id'] 	= $user_id = $this->encrypt->decode($session['user_id']);
			$data['firm_id'] 	= $firm_id = $this->encrypt->decode($session['firm_id']);
			$data['documents']	= $documents = Document::findAllPublicSharedDocument($firm_id, $parent_id);

			$this->load->view('super/document/shared_document_list',$data);
		}	
	}

	function case_alloted_list() {
		$this->check_user_login();
		Engine::XmlHttpRequestOnly();

		$this->load->view('super/firm_accounts/case_alloted_list',$data);	
	}

	function case_alloted_history_list() {
		$this->check_user_login();
		Engine::XmlHttpRequestOnly();

		$this->load->view('super/firm_accounts/case_alloted_history_list',$data);	
	}

	function show_case_history_user_detailed() {
		Engine::XmlHttpRequestOnly();
		$post 		= $this->input->post();
		$success 	= false;
		if($post) {
			$success = true;
			$this->load->view('super/firm_accounts/case_alloted_history_user',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function case_login() {
		$this->check_user_login();

		$session = $_SESSION['cnp']['login'];

		$user_id = (int) $this->encrypt->decode($session['user_id']);
		$data['user'] = $user = User::findById($user_id);

		if($user) {
			unset($_SESSION['cnp']['case_login']);
			Engine::appStyle('bootstrap.min.css');

			Bootstrap::modal();

			Engine::appStyle('super.css');
			Engine::appStyle('general.css');
			Jquery::form();

			$data['page_title'] = "CNP : Login";

			$session 	= $_SESSION['cnp']['login'];

			$data['segment_user_id'] = $segment_3 = (int) $this->uri->segment(3);
			$this->load->view('super/case_login.php',$data);
		}

		
	}

	function authenticate_case_login() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();

		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user_id 	= (int) $this->encrypt->decode($session['user_id']);
		$user 		= User::findById($user_id);

		if($post && $session && $user) {

			$segment_user_id = $this->uri->segment(2);

			$password = $post['password'];

			$verified_password 	= ($this->encrypt->decode($user['password']) == $password ? true : false);
			$verified_hash 		= Password_Hash::validate_password($password,$user['hash']);
			$is_firm_active		= Firm::isFirmActive($user['firm_id']);

			if($verified_password && $verified_hash && $is_firm_active) {
				$credentials = array(
					'user_id' => $this->encrypt->encode($segment_user_id),
				);

				$_SESSION['cnp']['case_login'][$session['user_id']] = $credentials;

				$json['is_successful'] 	= true;
				$json['messsage'] 		= "Authentication Successful";
			} else {
				$json['is_successful'] 	= false;
				$json['messsage'] 		= "Ooops! Authentication Failed!";
			}
		} else {
			$json['is_successful'] 	= false;
			$json['messsage'] 		= "Ooops! Authentication Failed!";
		}

		$_SESSION['cnp']['case_login'] = array(
			'user_id' 			=> $session['user_id'],
			'account_type' 		=> $session['account_type'],
			'viewing_user_id' 	=> $post['viewing_user_id'],
		);

		$json['is_successful'] 	= true;
		echo json_encode($json);
	}

	function debug_sess() {
		$sess = $_SESSION['cnp']['login'];
		echo $this->encrypt->decode($sess['user_id']);
	}

	function view_case() {
		$session 		= $_SESSION['cnp']['login'];
		$case_session 	= $_SESSION['cnp']['case_login'];

		if($session && $case_session) {
			Engine::appStyle('bootstrap.min.css');

			Bootstrap::modal();
			Bootstrap::datetimepicker();
			
			Engine::appStyle('cases.css');
			Engine::appStyle('general.css');
			Engine::appScript('javascript.js');
			Engine::appScript('confirmation.js');
			Engine::appScript('cases.js');

			Engine::appScript('injrs-trtmnt.js');

			Jquery::form();
			Jquery::datatable();
			Jquery::inline_validation();
			Jquery::tipsy();
			Jquery::select2();
			Jquery::plup_uploader();

			$data['case_code'] = $_SESSION['cases']['code'];

			$data['page_title'] = "CNP :: Admin";
			$data['session']	= $session = $_SESSION['cnp']['login'];
			$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
			$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));
			$data['case_notes_active'] = "tab-block-active";

			$user_id 		= (int) $this->encrypt->decode($session['user_id']);
			$data['user'] 	= $user = User::findById($user_id);

			$viewing_user_id 		= (int) $case_session['viewing_user_id'];
			$data['viewing_user'] 	= $viewing_user = User::findById($viewing_user_id);

			$this->load->view('cases/welcome',$data);
		}
			
	}

	/*
	function welcome1() {
		$this->check_user_login();

		Engine::appStyle('super-user-style.css');

		$data['page_title'] = 'Home';
		$data['session'] 	= $_SESSION['cnp']['login'];

		$this->load->view('super/welcome',$data);
	}
	*/

}