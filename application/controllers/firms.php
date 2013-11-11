<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Firms extends CI_Controller {
	function __construct() {
		parent::__construct();
 		$this->load->database();
 		Engine::class_loader();

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
		Jquery::select2();
		Jquery::plup_uploader();
		Jquery::signaturepad();

		$data['page_title'] = "CNP :: Admin";
		$data['session']	= $session = $_SESSION['cnp']['login'];
		$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));

		$this->load->view('firms/welcome',$data);
	}

	function debug_signaturepad_output() {
		$post = $this->input->post();

		debug_array($post);
	}

	function account_settings() {

		$data['session'] = $session = $_SESSION['cnp']['login'];
		if($session) {

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

			$data['firm'] = $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
			$this->load->view("firms/forms/account_settings",$data);
		} else {
			die("<script>error_404();</script>");
		}
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
		            'source_image' => $original_path.$filename, //path to the uploaded image
		            'new_image' => $resized_path,
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
		            'maintain_ratio' 	=> FALSE,
		            'master_dim' 		=> "auto",
		            'width' 			=> 36,
		            'height' 			=> 36,
		            'quality' 			=> 100
		        );
		        $this->image_lib->initialize($config);
		        $this->image_lib->resize();
			}

			$tmp_image = MEDIA_FOLDER."tmp/image/firm/$filename";

			$_SESSION['tmp']['uploaded_image']['firm_logo_url'] = $filename;
	
			echo $tmp_image;
		}
	}

	function firm_current_contact_list() {
		$post = $this->input->post();
		if($post) {
			$firm_id =  (int) $post['firm_id'];

			$data['contact_list'] = $contact_list = Firm_Contact_List::findAllByFirmId($firm_id);

			$this->load->view('firms/firm_current_contact_list',$data);
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
				$this->load->view('firms/forms/edit_firm_contact',$data);
			}
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function save_firm_contact_form() {
		Engine::XmlHttpRequestOnly();

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
		Engine::XmlHttpRequestOnly();

		$post 		= $this->input->post();
		$success 	= false;

		if($post) {
			$post_id 		= (int) $post['id'];
			$data['cl'] 	= $contact_list = Firm_Contact_List::findById($post_id);
			if($contact_list) {
				$success = true;
				$this->load->view('firms/forms/delete_firm_contact',$data);
			}
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function delete_firm_contact() {
		Engine::XmlHttpRequestOnly();

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

	function save_firm() {

		$post = $this->input->post();
		if($post) {

			if($post['id']) {

				$subscription_id 	= (int) $post['subscription_id'];
				$post_id	 		= (int) $post['id'];

				$subscription = Settings_Subscription_Plan::findById($subscription_id);
				$firm = Firm::findById($post_id);

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
						//"subscription_id" 		=> $subscription['id'],
						//"subscription_name" 	=> $subscription['subscription_name'],
						//"current_case_alloted" 	=> $post['case_available_'.$subscription_id],
						//"remaining_case" 		=> $post['case_available_'.$subscription_id],
						"auto_renew_plan" 		=> $post['renew'],
						"firm_logo_url" 		=> $filename,
					);

					$firm_id = FIRM::save($record,$post_id);

					$json['is_successful'] 	= true;
					$json['message']		= "Successful updated " . $post['firm_name'] . "!";

				} else {
					$json['is_successful'] 	= false;
					$json['message']		= "Ooop! Error adding to database. Please contact web administrator!";
				}
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

	function manage_user_list() {
		Engine::XmlHttpRequestOnly();

		$this->check_user_login();
		$data['session'] 	= $session = $_SESSION['cnp']['login'];

		$data['user_id'] = $user_id = (int) $this->encrypt->decode($session['user_id']);

		$firm_id		= (int) $this->encrypt->decode($session['firm_id']);
		$fields 		= array('id,firstname,middlename,lastname,email_address,account_type,account_status');
		$data['users'] 	= $users = User::findAllActiveOrdinaryUsersByFirmId($firm_id, $fields, " id DESC");

		$this->load->view('firms/manage_user/manage_user_list',$data);	
	}

	function add_user() {
		Engine::XmlHttpRequestOnly();

		$this->check_user_login();

		$session 			= $_SESSION['cnp']['login'];
		$data['firm_id'] 	= $this->encrypt->decode($session['firm_id']);

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
		$this->load->view('firms/manage_user/forms/add_user',$data);	
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

				$thumb_directory	= "media/user/".$username."/thumb/";
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

	function check_email_address_validity() {
		Engine::XmlHttpRequestOnly();

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
		Engine::XmlHttpRequestOnly();
		
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

	function edit_user() {
		Engine::XmlHttpRequestOnly();
		
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

				$data['can_update'] = $can_update = ( (int) $this->encrypt->decode($session['user_id']) != $post_id ? false : true );

				$this->load->view('firms/manage_user/forms/edit_user',$data);
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

			$this->load->view('firms/manage_user/user_current_contact_list.php',$data);
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

	function delete_user_form() {
		$post 		= $this->input->post();
		$success 	= false;

		if($post) {
			$post_id 		= (int) $post['id'];
			$data['user'] 	= $user = User::findById($post_id);
			if($user) {
				$success = true;
				$this->load->view('firms/manage_user/forms/delete_user',$data);
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

	function delete_user_contact_form() {
		$post 		= $this->input->post();
		$success 	= false;

		if($post) {
			$post_id 		= (int) $post['id'];
			$data['cl'] 	= $contact_list = User_Contact_List::findById($post_id);
			if($contact_list) {
				$success = true;
				$this->load->view('firms/manage_user/forms/delete_user_contact',$data);
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

	function manage_document() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();

		$post = $this->input->post();

		$data['current_parent_id'] = ($post['parent_id'] ? (int) $post['parent_id'] : 0);
		$this->load->view('firms/document/manage_document',$data);
	}

	function document_list_dt() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();

		$post = $this->input->post();
		if($post) {
			
			$data['firms'] 		= $firms = Firm::findAllActive("ORDER BY firm_name ASC");
			$data['session'] 	= $session = $_SESSION['cnp']['login'];
			$data['parent_id']	= $parent_id = (int) $post['parent_id'];
			$data['user_id'] 	= $user_id = $this->encrypt->decode($session['user_id']);
			$data['firm_id'] 	= $firm_id = $this->encrypt->decode($session['firm_id']);
			$data['documents']	= $documents = Document::findAllActiveFirmSharedFiles($user_id,$parent_id,$firm_id,"sort ASC, id DESC");

			$data['show_breadcrumbs'] = self::create_breadcrumbs($parent_id);

			#$this->load->view('firms/document/document_list',$data);
			$this->load->view('firms/document/document_list_ss',$data);
		}	
	}

	function create_breadcrumbs($parent_id) {
		$str = "";

		$fields = array("id,parent_id,title");
		$document = Document::findById($parent_id, $fields);

		$id = $document['parent_id'];
		if($document['parent_id']) {
			$has_parent = true;
			while($has_parent):
				$a = Document::findById($id);
				if($a) {
					$id = $a['parent_id'];
					$breadcrumbs[] = array(
						"id" => $a['id'],
						"title" => $a['title'],
					);
				} else {
					$breadcrumbs[] = array(
						"id" => 0,
						"title" => "root"
					);
					$has_parent = false;
					break;
				}
			endwhile;
		} else {
			$breadcrumbs[] = array(
				"id" => 0,
				"title" => "Root"
			);
		}

		foreach(array_reverse($breadcrumbs) as $key=>$value):
			$str .= '<a href="javascript:void(0);" onclick="javascript:document_list('.$value['id'].')">'.character_limiter($value['title'], 3).'</a> &raquo ';
		endforeach;
		$str .= character_limiter($document['title'], 10);

		return $str;
	}

	function get_document_list() {
		Engine::XmlHttpRequestOnly();
		$get = $this->input->get();
		$session = $_SESSION['cnp']['login'];

		if($get) {
			$sorting 	= (int) $get['iSortCol_0'];
			$query   	= $get['sSearch'];
			$order_type	= strtoupper($get['sSortDir_0']);

			$display_start 	= (int) $get['iDisplayStart'];

			// header fields
			$rows = array(
				0 => "id",
				1 => "id",
				2 => "title",
				3 => "description",
				4 => "file_type",
				5 => "last_modified",
			);

			$order_by 	= $rows[$sorting] . " {$order_type}";
			$limit  	= $display_start . ", 10";

			$user_id    = (int) $this->encrypt->decode($session['user_id']);
			$firm_id    = (int) $this->encrypt->decode($session['firm_id']);
			$parent_id  = (int) $get['current_parent_id'];


			$params = array(
				"user_id" 	=> $user_id,
				"parent_id" => $parent_id,
				"firm_id" 	=> $firm_id,
				"query"		=> $query,
				"fields" 	=> array("id,parent_id,uploaded_by,title,description,file_type,is_visible,last_modified"),
				"order" 	=> "sort ASC, id DESC",
				"limit"  	=> $limit

			);

			$documents = Document::findAllActiveFirmSharedFiles($params);
			$total_records = Document::countAllActiveFirmSharedFiles($params);

			$current_parent_id = (int) $get['current_parent_id'];

			$output = array(
				"sEcho" => $get['sEcho'],
				"iTotalRecords" => $total_records,
				"iTotalDisplayRecords" => $total_records,
				"aaData" => array()
			);

			foreach($documents as $key=>$value):

				$total_assigned = "";
				$visible_row 	= "";
				$is_visible 	= "";

				if($value['file_type'] == DOCUMENT_SET) {

					$total_assigned = Document::countAllActiveFileByParentId($value['id']);

					$action_link = '
						<a href="javascript:void(0);" onclick="javascript:edit_document_set('.$value['id'].')" class="edit_firm_current_contact" original-title="Edit"><i class="icon-pencil"></i></a>
						<a href="javascript:void(0);" onclick="javascript:delete_document_set('.$value['id'].')" class="delete_firm_current_contact" original-title="Delete"><i class="icon-trash"></i></a>
					';

					$title_row = '<a href="javascript:void(0);" onclick="javascript:document_list('.$value['id'].')" >'.$value['title']." (".$total_assigned . ")".'</a>';

				} else if($value['file_type'] == DOCUMENT) {
					$action_link = '
						<a href="javascript:void(0);" onclick="javascript:edit_document('.$value['id'].')" class="edit_firm_current_contact" original-title="Edit"><i class="icon-pencil"></i></a>
						<a href="javascript:void(0);" onclick="javascript:delete_document('.$value['id'].')" class="delete_firm_current_contact" original-title="Delete"><i class="icon-trash"></i></a>
					';

					$is_visible = ($value['is_visible'] == "Yes" ? 'checked="checked"' : "");

					$visible_row = "<input type='checkbox' " . $is_visible . " id='cb_visible_".$value['id']."' style='margin-bottom:3px;margin-left:20px;' onclick='javascript:change_document_visibility(".$value['id'].");'>";
					$title_row = $value['title'];
				} else if($value['file_type'] == DOCUMENT_IMAGE) {
					$action_link = '
						<a href="javascript:void(0);" onclick="javascript:edit_document_image('.$value['id'].')" class="edit_firm_current_contact" original-title="Edit"><i class="icon-pencil"></i></a>
						<a href="javascript:void(0);" onclick="javascript:delete_document_image('.$value['id'].')" class="delete_firm_current_contact" original-title="Delete"><i class="icon-trash"></i></a>
					';
				} else {
					$title_row = $value['title'];
				}

				#$fields = array("id,title");
				#$parent = Document::findById($current_parent_id, $fields);

				$row = array(
					'0' => "<div class='ss_table_icons'>{$action_link}</div>",
					'1' => $visible_row,
					'2' => $title_row,
					'3' => $value['description'],
					'4' => $value['file_type'],
					'5' => $value['last_modified'],
				);
			$output['aaData'][] = $row;
			endforeach;
		}
		
		echo json_encode($output);
	}

	function change_document_visibility() {
		Engine::XmlHttpRequestOnly();
		$post = $this->input->post();

		$is_visible = "No";
		if($this->validate_post_request()) {

			$post_id = (int) $post['id'];

			$is_visible = ($post['is_visible'] == "Yes" ? "Yes" : "No");
			$record = array(
				"is_visible" => $is_visible
			);
			Document::save($record, $post_id);
		}

		return $is_visible;
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

			$this->load->view('firms/document/shared_document_list',$data);
		}	
	}

	function upload_document_image_form() {
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {
			$success = true;
			$data['current_parent_id'] 	= $current_parent_id =  $post['parent_id'];
			//$data['other_document_set']	= Document::findAllOtherDocumentSet($current_parent_id,$firm_id,$user_id);

			$firm_id = (int) $this->encrypt->decode($session['firm_id']);
			$user_id = (int) $this->encrypt->decode($session['user_id']);
			$fields = array("id,title");
			$data['document_sets'] = $document_sets = Document::findAllDocumentSets($firm_id,$user_id,$fields);

			foreach($document_sets as $key=>$value):
				$arr[] = $value['id'];
			endforeach;
			$data['available_sets'] = $a = implode(",",$arr);

			$this->load->view('firms/document/form/upload_document_image',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function serialize_document_set() {
		Engine::XmlHttpRequestOnly();
		$post = $this->input->post();
		$_SESSION['tmp']['document_set'] = $post['a'];
	}

	function debug_session() {
		$session 	= $_SESSION['cnp']['login'];
		debug_array($session);
	}

	function upload_case_document_image() {
		$success 	= false;
		$get 		= $this->input->get();
		$post 		= $this->input->post();
		$file 		= $_FILES['file'];
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));


		if($file && $session && $user) {

			$this->load->helper('string');
			$get_cpi 	= (int) $get['cpi'];
			$random_key = random_string('unique');

			$file_extension	= substr($file['name'], -3);
			$raw_name 		= $this->encrypt->sha1(basename($file['name']."$random_key")).date("hims",time());
			$upload_name 	= $file['name'];
			$file_type		= DOCUMENT_IMAGE;
			$file_size 		= $file['size'];

			$dir = "files/case_document/".$this->encrypt->decode($session['firm_id'])."/";
			if(!is_dir($dir)) {
				mkdir($dir,0777,true);
			}

			$resized_directory	= "{$dir}resize/";
			if(!is_dir($resized_directory)) {
				mkdir($resized_directory,0777,true);
			}

			$path = "$dir/$raw_name.{$file_extension}";
				
			if(move_uploaded_file($file['tmp_name'], $path)) {
				$record = array(
					"firm_id" 			=> $user['firm_id'],
					"parent_id" 		=> $get_cpi,
					"uploaded_by" 		=> $user['id'],
					"title" 			=> url_title(substr($upload_name, 0,-4), 'dash', true),
					"upload_name" 		=> $upload_name,
					"filename" 			=> $raw_name.".".$file_extension,
					"file_size" 		=> $file_size,
					"file_type" 		=> DOCUMENT_IMAGE,
					"file_extension" 	=> $file_extension,
					"path" 				=> $dir,
					"is_archive" 		=> NO,
					"date_created" 		=> Tool::getCurrentDateTime("Y-m-d H:i:s","Asia/Manila"),
				);

				document::save($record);

				$this->load->library('image_lib', $config);
		        $config = array(
		            'source_image' => $path, //path to the uploaded image
		            'new_image' => $resized_directory,
		            'maintain_ratio' => TRUE,
		            'width' => 120,
		            'height' => 120,
		            'quality' => 100
		        );
		        $this->image_lib->initialize($config);
		        $this->image_lib->resize();
			}

			$counter = 0;
			$document_set = $_SESSION['tmp']['document_set'];
			foreach($document_set as $key => $value):

				$new_path = "{$dir}/{$raw_name}_{$counter}.{$file_extension}";
				if(copy($path,$new_path)) {
					$record = array(
						"firm_id" 			=> $user['firm_id'],
						"parent_id" 		=> $value,
						"uploaded_by" 		=> $user['id'],
						"title" 			=> url_title(substr($upload_name, 0,-4), 'dash', true),
						"upload_name" 		=> $upload_name,
						"filename" 			=> "{$raw_name}_{$counter}.{$file_extension}",
						"file_size" 		=> $file_size,
						"file_type" 		=> DOCUMENT_IMAGE,
						"file_extension" 	=> $file_extension,
						"path" 				=> $dir,
						"is_archive" 		=> NO,
						"date_created" 		=> Tool::getCurrentDateTime("Y-m-d H:i:s","Asia/Manila"),
					);

					document::save($record);

					$this->load->library('image_lib', $config);
			        $config = array(
			            'source_image' => $new_path, //path to the uploaded image
			            'new_image' => $resized_directory,
			            'maintain_ratio' => TRUE,
			            'width' => 120,
			            'height' => 120,
			            'quality' => 100
			        );
			        $this->image_lib->initialize($config);
			        $this->image_lib->resize();
				}
			$counter++;
			endforeach;
			unset($_SESSION['tmp']['document_set']);
		}
	}

	function add_document_set_form() {
		Engine::XmlHttpRequestOnly();
		$data['session'] 	= $session = $_SESSION['cnp']['login'];
		$success 			= false;

		if($session) {
			$success 	= true;
			$user_id 	= $this->encrypt->decode($session['user_id']);
			$firm_id 	= $this->encrypt->decode($session['firm_id']);
		
			$data['parent_set'] = $parent_set = Document::findAllActiveOwnDocumentSet($user_id,"ID ASC");
			$data['firms'] 		= $firms = Firm::findOtherActiveFirm($firm_id);

			$this->load->view('firms/document/form/add_document_set',$data);
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

			$this->load->view('firms/document/form/edit_document_set',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function save_document_set() {

		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {

			if($post['id']) {

				$post_id 	= (int) $post['id'];
				$document 	= Document::findById($post_id);

				if($document) {
					if($document['file_type'] == DOCUMENT) {

						$only_me 	= 0;
						$visibility = ($post['visible_to'] ? '' : $only_me);

						$record = array(
							"title" 		=> $post['title'],
							"description" 	=> $post['description'],
							"document_text" => $post['document_text'],
							"visibility" 	=> $visibility,
							"visible_to" 	=> serialize($post['visible_to']),
							"sort" 			=> 2,
							"last_modified_by" 	=> $user['id'],
						);

					} else if($document['file_type'] == DOCUMENT_SET) {

						$record = array(
							"title" 		=> $post['title'],
							"description" 	=> $post['description'],
							"visibility" 	=> $visibility,
							"visible_to" 	=> serialize($post['visible_to']),
							"last_modified_by" 	=> $user['id'],
						);
					} else if($document['file_type'] == DOCUMENT_IMAGE) {
						$filename = $_SESSION['tmp']['uploaded_image']['document_image_filename'];

						if($filename) {

    						$original_directory = "files/case_document/".$this->encrypt->decode($session['firm_id'])."/";
							if(!is_dir($dir)) {
								mkdir($dir,0777,true);
							}

							$resized_directory	= "{$original_directory}resize/";
							if(!is_dir($resized_directory)) {
								mkdir($resized_directory,0777,true);
							}

							$original_src 	= "media/tmp/image/document/{$filename}";
							$original_image	= $original_directory.$filename;
							copy($original_src,$original_image);

							$resized_src 	= "media/tmp/image/document/resize/{$filename}";
							$resized_image	= $resized_directory.$filename;
							copy($resized_src,$resized_image);

							$thumb_src 	= "media/tmp/image/document/thumb/{$filename}";

							$old_filename = $document['filename'];
							unlink($original_directory.$old_filename);
							unlink($resized_directory.$old_filename);

							unlink($original_src);
							unlink($resized_src);
							unlink($thumb_src);
						}

						$record = array(
							"title" 		=> $post['title'],
							"description" 	=> $post['description'],
							"filename" 		=> ($filename ? $filename : $document['filename']),
							"visibility" 	=> $visibility,
							"visible_to" 	=> serialize($post['visible_to']),
							"last_modified_by" 	=> $user['id'],
							"sort" 			=> 2,
						);

					}
		
					$document_id 			= Document::save($record, $post_id);
					$json['is_successful'] 	= true;
					$json['message']		= "Successfully updated " . $post['title'] . "!";
					unset($_SESSION['tmp']['uploaded_image']['document_image_filename']);

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
					"sort" 			=> 1,
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

	function add_document_form() {
		Engine::XmlHttpRequestOnly();

		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {
			$success 	= true;
			$firm_id 	= $this->encrypt->decode($session['firm_id']);
			$user_id 	= $this->encrypt->decode($session['user_id']);
			$post_id 	= (int) $post['id'];

			$data['current_parent_id'] 	= $current_parent_id = (int) $post['current_parent_id'];
			//$data['other_document_set']	= Document::findAllOtherDocumentSet($current_parent_id,$firm_id,$user_id);

			$fields = array("id,title");
			$data['document_sets'] = $document_sets = Document::findAllDocumentSets($firm_id,$user_id,$fields);

			foreach($document_sets as $key=>$value):
				if($value['id'] != $current_parent_id)
					$arr[] = $value['id'];
			endforeach;
			$data['available_sets'] = $a = implode(",",$arr);

			$this->load->view('firms/document/form/add_document',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function edit_document_form() {
		Engine::XmlHttpRequestOnly();

		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {
			$success 	= true;
			$firm_id 	= $this->encrypt->decode($session['firm_id']);
			$user_id 	= $this->encrypt->decode($session['user_id']);
			$post_id 	= (int) $post['id'];

			$data['current_parent_id'] 	= (int) $post['current_parent_id'];
			$data['document'] 			= $document = Document::findById($post_id);
			$data['firms'] 				= $firms = Firm::findOtherActiveFirm($firm_id);

			$params = array(
				"id" 		=> $document['id'],
				"fields" 	=> array("id,parent_id,title"),
			);

			$document_copies = Document::findAllDocumentCopies($params);
			foreach($document_copies as $key=>$value):
				$parent_copies[] = $value['parent_id'];
				$doc_copies[]  	 = $value['id'];
			endforeach;

			$fields = array("id,title");
			$document_sets = Document::findAllDocumentSets($firm_id,$user_id,$fields);

			foreach($document_sets as $key=>$value):

				$is_locked = in_array($value['id'],array_unique($parent_copies));
				$arr[] = array(
					"id" 	=> $value['id'],
					"text" 	=> $value['title'],
					"locked" 	=> $is_locked
				);
			endforeach;
			$data['available_sets'] 	= $a = json_encode($arr);

			$data['doc_copies'] = implode(",", $doc_copies);

			$data['signature'] = $this->encrypt->decode($document['signature']);

			$this->load->view('firms/document/form/edit_document',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function update_document() {
		if($this->validate_ajax_post()) {
			$post = $this->input->post();

			$session 	= $_SESSION['cnp']['login'];
			$user 		= User::findById($this->encrypt->decode($session['user_id']));

			$post_id 	= (int) $post['id'];
			$document 	= Document::findById($post_id);

			if($document) {

				$record = array(
					"title" 		=> $post['title'],
					"description" 	=> $post['description'],
					"document_text" => $post['document_text'],
					"ip_address" 	=> $ip_address,
					"file_type" 	=> DOCUMENT,
					"is_archive" 	=> NO,
					"last_modified_by" 	=> $user['id'],
				);

				Document::save($record, $post_id);

				if($document['document_type'] == ORIGINAL_DOC) {
					$document_sets 	= explode(",", $post['document_sets']);
					$doc_copies 	= explode(",", $post['doc_copies']);

					foreach($doc_copies as $b):
						Document::save($record, $b);
					endforeach;

					$params = array(
						"id" 		=> $post_id,
						"fields" 	=> array("id,parent_id,title"),
					);
					$document_copies = Document::findAllDocumentCopies($params);
					foreach($document_copies as $key=>$value):
						$parent_copies[] = $value['parent_id'];
					endforeach;
					
					foreach($document_sets as $a):
						
						if(!in_array($a, $parent_copies)) {

							$document = Document::findById($post_id);
							$array = array(
								"firm_id" 			=> $document['firm_id'],
								"parent_id" 		=> $a,
								"main_document_id" 	=> $post_id,
								"uploaded_by" 		=> $user['id'],
								"document_type"		=> BRANCH_DOC,
								"sort" 				=> 2,
								"date_created" 		=> Tool::getCurrentDateTime("Y-m-d H:i:s","Asia/Manila"),
								"last_modified_by" 	=> $user['id'],
							);

							$record = array_merge($record,$array);
							Document::save($record);
							#debug_array($rec);
						}
					endforeach;
				}

				$json['is_successful'] 	= true;
				$json['message']		= "Successfully updated " . $post['title'] . "!";


			} else {

				$json['is_successful'] 	= false;
				$json['message']		= "Ooop! Error adding to database. Please contact web administrator!";
			}
		}

		echo json_encode($json);
	}

	function validate_ajax_post() {
		Engine::XmlHttpRequestOnly();
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {
			return true;
		} else {
			die("<script>error_404();</script>");
		}
	}


	function save_document() {
		Engine::XmlHttpRequestOnly();

		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {

			if($post['id']) {
				$post_id = (int) $post['id'];
				$record = array(
					"title" 		=> $post['title'],
					"description" 	=> $post['description'],
					"document_text" => $post['document_text'],
					"file_type" 	=> DOCUMENT,
					"is_archive" 	=> NO,
					"last_modified_by" 	=> $user['id'],
				);

				Document::save($record,$post_id);
				$json['is_successful'] 	= true;
				$json['message']		= "Successfully updated " . $post['title'] . "!";
			} else {
				$record = array(
					"firm_id" 		=> $user['firm_id'],
					"parent_id" 	=> $post['parent'],
					"uploaded_by" 	=> $user['id'],
					"title" 		=> $post['title'],
					"description" 	=> $post['description'],
					"document_text" => $post['document_text'],
					"file_type" 	=> DOCUMENT,
					"document_type"	=> ORIGINAL_DOC,
					"is_archive" 	=> NO,
					"sort" 			=> 2,
					"date_created" 	=> Tool::getCurrentDateTime("Y-m-d H:i:s","Asia/Manila"),
					"last_modified_by" 	=> $user['id'],
				);

				$main_document_id = Document::save($record);

				foreach($post['add_document_set'] as $key=>$value):

					$record = array(
						"firm_id" 			=> $user['firm_id'],
						"parent_id" 		=> $value,
						"main_document_id" 	=> $main_document_id,
						"uploaded_by" 		=> $user['id'],
						"title" 			=> $post['title'],
						"description" 		=> $post['description'],
						"document_text" 	=> $post['document_text'],
						"file_type" 		=> DOCUMENT,
						"document_type"		=> BRANCH_DOC,
						"is_archive" 		=> NO,
						"sort" 				=> 2,
						"date_created" 		=> Tool::getCurrentDateTime("Y-m-d H:i:s","Asia/Manila"),
						"last_modified_by" 	=> $user['id'],
					);

					Document::save($record);

				endforeach;

				
				$json['is_successful'] 	= true;
				$json['message']		= "Successfully updated " . $post['title'] . "!";
			}
		}

		echo json_encode($json);

	}

	function delete_document_form() {
		Engine::XmlHttpRequestOnly();

		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {
			$post_id = (int) $post['id'];

			$data['document'] = $document = Document::findById($post_id);

			if($document) {
				$success = true;
				$this->load->view('firms/document/form/delete_document',$data);
			}
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function delete_document_top_form() {
		Engine::XmlHttpRequestOnly();

		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {
			$post_id = (int) $post['id'];

			$data['document'] = $document = Document::findById($post_id);

			if($document) {
				$success = true;
				$this->load->view('firms/document/form/delete_document_top',$data);
			}
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function delete_document() {
		Engine::XmlHttpRequestOnly();

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

	function delete_document_set_form() {
		Engine::XmlHttpRequestOnly();

		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {
			$post_id = (int) $post['id'];

			$data['document'] = $document = Document::findById($post_id);

			if($document) {
				$success = true;
				$this->load->view('firms/document/form/delete_document_set',$data);
			}
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function delete_document_set() {
		Engine::XmlHttpRequestOnly();
		
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

	function delete_document_image_form() {
		Engine::XmlHttpRequestOnly();

		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {
			$post_id = (int) $post['id'];

			$data['document'] = $document = Document::findById($post_id);

			if($document) {
				$success = true;
				$this->load->view('firms/document/form/delete_document_image',$data);
			}
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function edit_document_image_form() {
		Engine::XmlHttpRequestOnly();

		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {
			$post_id 	= (int) $post['id'];
			$data['document'] = $document = Document::findById($post_id);
			if($document) {
				$success = true;

				$this->load->view('firms/document/form/edit_document_image',$data);
			}
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function upload_document_image() {
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

			$original_path 	= 'media/tmp/image/document/';
	        $resized_path 	= 'media/tmp/image/document/resize/';
	        $thumb_path 	= 'media/tmp/image/document/thumb/';

			if(!is_dir($original_path)) {
				mkdir($original_path,0777,true);
			}

			if(!is_dir($resized_path)) {
				mkdir($resized_path,0777,true);
			}

			if(!is_dir($thumb_path)) {
				mkdir($thumb_path,0777,true);
			}

			$path = "media/tmp/image/document/$filename";

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

			$tmp_image = MEDIA_FOLDER."tmp/image/document/$filename";

			$_SESSION['tmp']['uploaded_image']['document_image_filename'] = $filename;
	
			echo $tmp_image;
		}
	}

	function delete_document_image() {
		Engine::XmlHttpRequestOnly();

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
				$json['message']		= "Successfully deleted " . $document['title'] . " document image!";

				unlink($document['path'].$document['filename']);
				unlink($document['path']."resize/".$document['filename']);
				Document::delete($post_id);
			}
		} else {
			$json['is_successful'] 	= false;
			$json['message']		= "Ooop! Error adding to database. Please contact web administrator!";
		}
	}

	function validate_post_request() {
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {
			return true;
		} else {
			return false;
		}
	}



}