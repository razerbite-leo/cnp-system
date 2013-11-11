<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cases extends CI_Controller {
	function __construct() {
		parent::__construct();
 		$this->load->database();
 		Engine::class_loader();
	}

	function index() {
		unset($_SESSION['tmp_cases']);
		unset($_SESSION['cases']['tmp_party_image']);

		$this->check_user_login();

		Engine::appStyle('bootstrap.min.css');
		Engine::appStyle('manage_cases.css');
		Engine::appStyle('general.css');
		Engine::appScript('javascript.js');
		Engine::appScript('confirmation.js');

		$_SESSION['cases']['code'] = $data['case_code'] = substr(strtoupper(date("is").random_string('unique')),0,15);

		$data['page_title'] = "CNP :: Manage Cases";
		$data['session']	= $session = $_SESSION['cnp']['login'];
		$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));
		$this->load->view('cases/manage_cases',$data);
	}

	function create() {
		$this->check_user_login();

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

		$data['page_title'] = "CNP :: Create Case";
		$data['session']	= $session = $_SESSION['cnp']['login'];
		$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));
		$data['case_notes_active'] = "tab-block-active";

		$this->load->view('cases/welcome',$data);
	}

	function scenes() {
		$this->check_user_login();

		Engine::appStyle('bootstrap.min.css');

		Bootstrap::modal();
		
		Engine::appStyle('cases.css');
		Engine::appStyle('general.css');
		Engine::appScript('javascript.js');
		Engine::appScript('confirmation.js');
		Engine::appScript('cases.js');

		Jquery::form();
		Jquery::datatable();
		Jquery::inline_validation();
		Jquery::tipsy();
		Jquery::select2();
		Jquery::plup_uploader();

		$data['page_title'] = "CNP :: Admin";
		$data['session']	= $session = $_SESSION['cnp']['login'];
		$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));

		$this->load->view('cases/welcome',$data);
	}

	function general() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		$data['session']	= $session = $_SESSION['cnp']['login'];
		$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));

		$success = false;

		if($session && $firm && $user) {
			$success = true;
			$this->load->view('cases/case_notes/general/form/general',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function add_general() {
		$this->check_user_login();
		$post = $this->validate_ajax_post();
	
		if($post) {
			$_SESSION['tmp_cases']['general'] = $post;
			$json['is_successful'] 	= true;
			$json['message'] 		= "Successfully updated!";
		} else {
			$json['is_successful'] 	= false;
			$json['message']		= "Ooop! Error adding to database. Please contact web administrator!";
		}

		echo json_encode($json);
	}

	function parties() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();

		$data['session']	= $session = $_SESSION['cnp']['login'];
		$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));

		$success 	= false;
		$post 		= $this->input->post();

		if($session && $firm && $user) {

			$success = true;
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

			$this->load->view('cases/case_notes/parties/form/parties',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
		
	}

	function party_list() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();

		$data['session']	= $session = $_SESSION['cnp']['login'];
		$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));

		$this->load->view('cases/case_notes/parties/party_list',$data);
	}

	function upload_party_image() {
		$success 	= false;
		$file 		= $_FILES['photo'];
		$session 	= $_SESSION['cnp']['login'];
		$case_sess  = $_SESSION['cases'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));
		
		if($file && $session && $user) {
			
			$this->load->helper('string');
			$get_cpi 	= (int) $get['cpi'];
			$random_key = random_string('unique');

			$file_extension	= substr($file['name'], -3);
			$filename 		= $this->encrypt->sha1(basename($file['name']."$random_key")).date("hims",time()).".{$file_extension}";
			$upload_name 	= $file['name'];

			$dir = "files/case_files/".$case_sess['code']."/images/tmp/";
			if(!is_dir($dir)) {
				mkdir($dir,0777,true);
			}
			unlink("$dir/".$_SESSION['cases']['tmp_party_image']['filename']);
			$path = "$dir/$filename";
			
			if(move_uploaded_file($file['tmp_name'], $path)) {

				$tmp_file_session = array(
					"filename" => $filename,
					"filepath" => $dir,
				);
				$_SESSION['cases']['tmp_party_image'] = $tmp_file_session;

				echo BASE_FOLDER . "{$dir}{$filename}";
			}
		}
	}

	function add_party() {
		$this->check_user_login();

		$post 		= $this->input->post();
		$case_sess 	= $_SESSION['cases'];

		if($post) {
			if($post['update'] == true) {
				$party_id = (int) $post['id'];
				$custom_array = array(
					"filename" => $case_sess['tmp_party_image']['filename'],
					"filepath" => $case_sess['tmp_party_image']['filepath'],
				);

				#$_SESSION['tmp_cases']['parties'][$party_id] = array_merge($post,$custom_array);

				$array = array(
					"party_type" 			=> $post["party_type"],
				    "party_role" 			=> $post["party_role"],
				    "prefix_title" 			=> $post["prefix_title"],
				    "client_name" 			=> $post["client_name"],
				    "gender" 				=> $post["gender"],
				    "relationship" 			=> $post["relationship"],
				    "relationship_other" 	=> $post["relationship_other"],
				    "ssn" 					=> $post["ssn"],
				    "birthdate" 			=> $post["birthdate"],
				    "address" 				=> $post["address"],
				    "city" 					=> $post["city"],
				    "state"				 	=> $post["zip"],
				    "zip" 					=> $post["occupation"],
				    "occupation" 			=> $post["occupation"],
				    "contact_person_text" 	=> $post["contact_person_text"],
				    "email_address" 		=> $post["email_address"],
				    "contact_relationship" 	=> $post["contact_relationship"],
				    "pb" 					=> $post["pb"],
				    "pb_other" 				=> $post["pb_other"],
				    "id" 					=> $post["id"],
				    "filename" => $case_sess['tmp_party_image']['filename'],
					"filepath" => $case_sess['tmp_party_image']['filepath'],

				    "contact_information"	=> $_SESSION['tmp_cases']['parties'][$party_id]['contact_information'],
				    "contact_person"		=> $_SESSION['tmp_cases']['parties'][$party_id]['contact_person'],
				);
				
				$_SESSION['tmp_cases']['parties'][$party_id] = $array;
				
				foreach($post['contact_information'] as $key=>$value):
					if($value['contact_type_value'] != "")
						$array = array(
							"contact_type" 			=> $value['contact_type'],
							"contact_type_value" 	=> $value['contact_type_value'],
							"contact_extension" 	=> $value['contact_extension'],
						);

					$_SESSION['tmp_cases']['parties'][$party_id]['contact_information'][] = $array;

				endforeach;

				foreach($post['contact_person'] as $key=>$value):
					if($value['contact_type_value'] != "")
						$array = array(
							"contact_type" 			=> $value['contact_type'],
							"contact_type_value" 	=> $value['contact_type_value'],
							"contact_extension" 	=> $value['contact_extension'],
						);

					$_SESSION['tmp_cases']['parties'][$party_id]['contact_person'][] = $array;

				endforeach;

				$json['total_party'] 	= count($_SESSION['tmp_cases']['parties']);
				$json['is_successful'] 	= true;
				$json['message'] 		= "Successfully updated!";

			} else {
				$array_count = count($_SESSION['tmp_cases']['parties']);
				$custom_array = array(
					"id"	   => $array_count,
					"filename" => $case_sess['tmp_party_image']['filename'],
					"filepath" => $case_sess['tmp_party_image']['filepath'],
				);
				$_SESSION['tmp_cases']['parties'][] = array_merge($post,$custom_array);

				$json['total_party'] 	= count($_SESSION['tmp_cases']['parties']);
				$json['is_successful'] 	= true;
				$json['message'] 		= "Successfully updated!";
			}

		} else {
			$json['is_successful'] 	= false;
			$json['message']		= "Ooop! Error adding to database. Please contact web administrator!";
		}
		echo json_encode($json);
	}

	function delete_party() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$party_id 	= (int) $post['party_id'];
		$case 		= $_SESSION['tmp_cases']['parties'][$party_id];

		if($post && $session && $user && $case) {
			$success = true;
			unset($_SESSION['tmp_cases']['parties'][$party_id]);

			$json['total_party'] = count($_SESSION['tmp_cases']['parties']);

		}
		echo json_encode($json);
	}

	function edit_party() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		$data['session']	= $session = $_SESSION['cnp']['login'];
		$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));

		$success 	= false;
		$post 		= $this->input->post();
		$party_id 	= (int) $post['party_id'];
		$party 		= $_SESSION['tmp_cases']['parties'][$party_id];

		if($session && $firm && $user && $post && $party) {
			$success = true;

			$data['party']	= $party;
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

			$this->load->view('cases/case_notes/parties/form/edit_party',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function debug_parties() {
		debug_array($_SESSION['tmp_cases']['economic_damages']);
	}

	function contact_information_list() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 				= false;
		$post 					= $this->input->post();
		$session 				= $_SESSION['cnp']['login'];
		$user 					= User::findById($this->encrypt->decode($session['user_id']));

		$party_id 				= (int) $post['party_id'];
		$contact_information 	= $_SESSION['tmp_cases']['parties'][$party_id]['contact_information'];

		if($post && $session && $user && $contact_information) {
			$data['party_id'] 				= $party_id;
			$data['contact_information'] 	= $contact_information;
			$this->load->view('cases/case_notes/parties/contact_information_list',$data);
		}
	}

	function edit_contact_information_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$data['id']			= $id = (int) $post['id'];
		$data['party_id']	= $party_id = (int) $post['party_id'];
		$data['contact'] 	= $contact = $_SESSION['tmp_cases']['parties'][$party_id]['contact_information'][$id];

		if($post && $session && $user && $contact) {
			$success = true;
			$this->load->view('cases/case_notes/parties/form/edit_contact_information',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function save_contact_information() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$id 		= (int) $post['id'];
		$party_id 	= (int) $post['party_id'];
		$contact 	= $_SESSION['tmp_cases']['parties'][$party_id]['contact_information'][$id];

		if($post && $session && $user && $contact) {
			$success = true;
			$_SESSION['tmp_cases']['parties'][$party_id]['contact_information'][$id] = $post;
		}
	}

	function delete_contact_information_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$data['id']			= $id = (int) $post['id'];
		$data['party_id']	= $party_id = (int) $post['party_id'];
		$data['contact'] 	= $contact = $_SESSION['tmp_cases']['parties'][$party_id]['contact_information'][$id];

		if($post && $session && $user && $contact) {
			$success = true;
			$this->load->view('cases/case_notes/parties/form/delete_contact_information',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function delete_contact_information() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$data['id']			= $id = (int) $post['id'];
		$data['party_id']	= $party_id = (int) $post['party_id'];
		$data['contact'] 	= $contact = $_SESSION['tmp_cases']['parties'][$party_id]['contact_information'][$id];

		if($post && $session && $user && $contact) {
			$success = true;
			unset($_SESSION['tmp_cases']['parties'][$party_id]['contact_information'][$id]);
		}
	}

	function contact_person_list() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$party_id 			= (int) $post['party_id'];
		$contact_persons 	= $_SESSION['tmp_cases']['parties'][$party_id]['contact_person'];

		if($post && $session && $user && $contact_persons) {
			$data['party_id'] 			= $party_id;
			$data['contact_persons'] 	= $contact_persons;

			$this->load->view('cases/case_notes/parties/contact_person_list',$data);
		}
	}

	function edit_contact_person_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$data['id']			= $id = (int) $post['id'];
		$data['party_id']	= $party_id = (int) $post['party_id'];
		$data['contact'] 	= $contact = $_SESSION['tmp_cases']['parties'][$party_id]['contact_person'][$id];

		if($post && $session && $user && $contact) {
			$success = true;
			$this->load->view('cases/case_notes/parties/form/edit_contact_person',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function save_contact_person() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$id 		= (int) $post['id'];
		$party_id 	= (int) $post['party_id'];
		$contact 	= $_SESSION['tmp_cases']['parties'][$party_id]['contact_person'][$id];

		if($post && $session && $user && $contact) {
			$success = true;
			$_SESSION['tmp_cases']['parties'][$party_id]['contact_person'][$id] = $post;
		}
	}

	function delete_contact_person_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$data['id']			= $id = (int) $post['id'];
		$data['party_id']	= $party_id = (int) $post['party_id'];
		$data['contact'] 	= $contact = $_SESSION['tmp_cases']['parties'][$party_id]['contact_person'][$id];

		if($post && $session && $user && $contact) {
			$success = true;
			$this->load->view('cases/case_notes/parties/form/delete_contact_person',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function delete_contact_person() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$data['id']			= $id = (int) $post['id'];
		$data['party_id']	= $party_id = (int) $post['party_id'];
		$data['contact'] 	= $contact = $_SESSION['tmp_cases']['parties'][$party_id]['contact_person'][$id];

		if($post && $session && $user && $contact) {
			$success = true;
			unset($_SESSION['tmp_cases']['parties'][$party_id]['contact_person'][$id]);
		}
	}

	function incident_description() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		$data['session']	= $session = $_SESSION['cnp']['login'];
		$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));

		$success 	= false;
		$post 		= $this->input->post();

		if($session && $firm && $user) {

			$success = true;
			$this->load->view('cases/case_notes/incident_description/form/incident_description',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
		
	}

	function add_incident_description() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		$post = $this->input->post();

		if($post) {
			$_SESSION['tmp_cases']['incident_description'] = $post;
			$json['is_successful'] 	= true;
			$json['message'] 		= "Successfully updated!";
		} else {
			$json['is_successful'] 	= false;
			$json['message']		= "Ooop! Error adding to database. Please contact web administrator!";
		}

		echo json_encode($json);
	}

	function insurance() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		$data['session']	= $session = $_SESSION['cnp']['login'];
		$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));

		$success 	= false;
		$post 		= $this->input->post();

		if($session && $firm && $user) {

			$success = true;
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

			$this->load->view('cases/case_notes/insurance/form/insurance',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
		
	}

	function add_insurance() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		$post = $this->input->post();

		if($post) {
			if($post['update'] == true) {
				$post_id = (int) $post['id'];
				$_SESSION['tmp_cases']['insurance'][$post_id] = $post;
			} else {
				$array_count = count($_SESSION['tmp_cases']['insurance']);
				$custom_array = array(
					"id"	   => $array_count,
				);
				$_SESSION['tmp_cases']['insurance'][] = array_merge($post,$custom_array);
			}

			$json['total_party'] 	= count($_SESSION['tmp_cases']['insurance']);
			$json['is_successful'] 	= true;
			$json['message'] 		= "Successfully updated!";

		} else {
			$json['is_successful'] 	= false;
			$json['message']		= "Ooop! Error adding to database. Please contact web administrator!";
		}

		echo json_encode($json);
	}

	function insurance_list() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		$data['session']	= $session = $_SESSION['cnp']['login'];
		$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));

		$this->load->view('cases/case_notes/insurance/insurance_list',$data);
	}

	function edit_insurance() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		$data['session']	= $session = $_SESSION['cnp']['login'];
		$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));

		$success 		= false;
		$post 			= $this->input->post();
		$insurance_id 	= (int) $post['insurance_id'];
		$insurance 		= $_SESSION['tmp_cases']['insurance'][$insurance_id];

		#debug_array($insurance);

		if($session && $firm && $user && $post && $insurance) {
			$success = true;

			$data['insurance']	= $insurance;
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

			$this->load->view('cases/case_notes/insurance/form/edit_insurance',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function delete_insurance() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$insurance_id 	= (int) $post['insurance_id'];
		$case 			= $_SESSION['tmp_cases']['insurance'][$insurance_id];

		if($post && $session && $user && $case) {
			$success = true;
			unset($_SESSION['tmp_cases']['insurance'][$insurance_id]);

			$json['total_insurance'] = count($_SESSION['tmp_cases']['insurance']);

		}
		echo json_encode($json);
	}

	function vehicles() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		$data['session']	= $session = $_SESSION['cnp']['login'];
		$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));

		$success 	= false;
		$post 		= $this->input->post();

		if($session && $firm && $user) {

			$success = true;
			$this->load->view('cases/case_notes/vehicles/form/vehicles',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
		
	}

	function add_vehicles() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		$post = $this->input->post();

		if($post) {
			if($post['update'] == true) {
				$post_id = (int) $post['id'];
				$_SESSION['tmp_cases']['vehicles'][$post_id] = $post;
			} else {
				$array_count = count($_SESSION['tmp_cases']['vehicles']);
				$custom_array = array(
					"id"	   => $array_count,
				);
				$_SESSION['tmp_cases']['vehicles'][] = array_merge($post,$custom_array);
			}

			$json['total_vehicles']	= count($_SESSION['tmp_cases']['vehicles']);
			$json['is_successful'] 	= true;
			$json['message'] 		= "Successfully updated!";

		} else {
			$json['is_successful'] 	= false;
			$json['message']		= "Ooop! Error adding to database. Please contact web administrator!";
		}

		echo json_encode($json);
	}

	function vehicle_list() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();

		$data['session']	= $session = $_SESSION['cnp']['login'];
		$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));

		$this->load->view('cases/case_notes/vehicles/vehicle_list',$data);
	}

	function edit_vehicle() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		$data['session']	= $session = $_SESSION['cnp']['login'];
		$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));

		$success 	= false;
		$post 		= $this->input->post();
		$vehicle_id = (int) $post['vehicle_id'];
		$vehicle	= $_SESSION['tmp_cases']['vehicles'][$vehicle_id];

		if($session && $firm && $user && $post && $vehicle) {
			$success = true;
			$data['vehicle']	= $vehicle;
			$this->load->view('cases/case_notes/vehicles/form/edit_vehicle',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function delete_vehicle() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$vehicle_id	= (int) $post['vehicle_id'];
		$case 		= $_SESSION['tmp_cases']['vehicles'][$vehicle_id];

		if($post && $session && $user && $case) {
			$success = true;
			unset($_SESSION['tmp_cases']['vehicles'][$vehicle_id]);

			$json['total_vehicles'] = count($_SESSION['tmp_cases']['vehicles']);

		}
		echo json_encode($json);
	}

	function injuries_treatments() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		$data['session']	= $session = $_SESSION['cnp']['login'];
		$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));

		$success = false;

		if($session && $firm && $user) {
			$success = true;
			$this->load->view('cases/case_notes/injuries_treatments/form/injuries_treatments',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function ambulance_list() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));
		$ambulances = $_SESSION['tmp_cases']['injuries_treatments']['ambulance'];

		if($session && $user) {
			$success = true;

			$data['ambulances'] = $ambulances;

			$this->load->view('cases/case_notes/injuries_treatments/ambulance_list',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function add_ambulance_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($session && $user) {
			$success = true;
			$this->load->view('cases/case_notes/injuries_treatments/form/add_ambulance',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function edit_ambulance_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$post_id	= (int) $post['id'];
		$ambulance 	= $_SESSION['tmp_cases']['injuries_treatments']['ambulance'][$post_id];

		if($session && $user && $post && $ambulance) {
			$success = true;

			$data['ambulance'] = $ambulance;

			$this->load->view('cases/case_notes/injuries_treatments/form/edit_ambulance',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function save_ambulance() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {

			$post_id = (int) $post['id'];
			if($post['update'] == true) {
				$_SESSION['tmp_cases']['injuries_treatments']['ambulance'][$post_id] = $post;
			} else {
				$array_count = count($_SESSION['tmp_cases']['injuries_treatments']['ambulance']);
				$custom_array = array(
					"id"	   => $array_count,
				);

				$_SESSION['tmp_cases']['injuries_treatments']['ambulance'][] = array_merge($post,$custom_array);
			}

			$json['is_successful'] 	= true;
		}

		echo json_encode($json);
	}

	function delete_ambulance() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$id 		= (int) $post['id'];

		unset($_SESSION['tmp_cases']['injuries_treatments']['ambulance'][$id]);
	}

	function hospital_er_list() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));
		$list 		= $_SESSION['tmp_cases']['injuries_treatments']['hospital_er'];

		if($session && $user) {
			$success = true;

			$data['list'] = $list;

			$this->load->view('cases/case_notes/injuries_treatments/hospital_er_list',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function add_hospital_er_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($session && $user) {
			$success = true;
			$this->load->view('cases/case_notes/injuries_treatments/form/add_hospital_er',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function edit_hospital_er_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$post_id	= (int) $post['id'];
		$hospital 	= $_SESSION['tmp_cases']['injuries_treatments']['hospital_er'][$post_id];

		if($session && $user && $post && $hospital) {

			$success = true;

			$data['hospital'] = $hospital;

			$this->load->view('cases/case_notes/injuries_treatments/form/edit_hospital_er',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function save_hospital_er() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {

			$post_id = (int) $post['id'];
			if($post['update'] == true) {
				$_SESSION['tmp_cases']['injuries_treatments']['hospital_er'][$post_id] = $post;
			} else {
				$array_count = count($_SESSION['tmp_cases']['injuries_treatments']['hospital_er']);
				$custom_array = array(
					"id"	   => $array_count,
				);

				$_SESSION['tmp_cases']['injuries_treatments']['hospital_er'][] = array_merge($post,$custom_array);
			}

			$json['is_successful'] 	= true;
		}

		echo json_encode($json);
	}

	function delete_hospital_er() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$id 		= (int) $post['id'];

		unset($_SESSION['tmp_cases']['injuries_treatments']['hospital_er'][$id]);
	}

	function urgent_care_clinic_list() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));
		$list 		= $_SESSION['tmp_cases']['injuries_treatments']['urgent_care_clinic'];

		if($session && $user) {
			$success = true;

			$data['list'] = $list;

			$this->load->view('cases/case_notes/injuries_treatments/urgent_care_clinic_list',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function add_urgent_care_clinic_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($session && $user) {
			$success = true;
			$this->load->view('cases/case_notes/injuries_treatments/form/add_urgent_care_clinic',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function edit_urgent_care_clinic_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$post_id	= (int) $post['id'];
		$clinic 	= $_SESSION['tmp_cases']['injuries_treatments']['urgent_care_clinic'][$post_id];

		if($session && $user && $post && $clinic) {

			$success = true;

			$data['clinic'] = $clinic;

			$this->load->view('cases/case_notes/injuries_treatments/form/edit_urgent_care_clinic',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function delete_urgent_care_clinic() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$id 		= (int) $post['id'];

		unset($_SESSION['tmp_cases']['injuries_treatments']['urgent_care_clinic'][$id]);
	}

	function save_urgent_care_clinic() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {

			$post_id = (int) $post['id'];
			if($post['update'] == true) {
				$_SESSION['tmp_cases']['injuries_treatments']['urgent_care_clinic'][$post_id] = $post;
			} else {
				$array_count = count($_SESSION['tmp_cases']['injuries_treatments']['urgent_care_clinic']);
				$custom_array = array(
					"id"	   => $array_count,
				);

				$_SESSION['tmp_cases']['injuries_treatments']['urgent_care_clinic'][] = array_merge($post,$custom_array);
			}

			$json['is_successful'] 	= true;
		}

		echo json_encode($json);
	}

	function imaging_center_list() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));
		$list 		= $_SESSION['tmp_cases']['injuries_treatments']['imaging_center'];

		if($session && $user) {
			$success = true;

			$data['list'] = $list;

			$this->load->view('cases/case_notes/injuries_treatments/imaging_center_list',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function add_imaging_center_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($session && $user) {
			$success = true;
			$this->load->view('cases/case_notes/injuries_treatments/form/add_imaging_center',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function edit_imaging_center_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$post_id	= (int) $post['id'];
		$ic 		= $_SESSION['tmp_cases']['injuries_treatments']['imaging_center'][$post_id];

		if($session && $user && $post && $ic) {

			$success = true;

			$data['ic'] = $ic;

			$this->load->view('cases/case_notes/injuries_treatments/form/edit_imaging_center',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function save_imaging_center() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {

			$post_id = (int) $post['id'];
			if($post['update'] == true) {
				$_SESSION['tmp_cases']['injuries_treatments']['imaging_center'][$post_id] = $post;
			} else {
				$array_count = count($_SESSION['tmp_cases']['injuries_treatments']['imaging_center']);
				$custom_array = array(
					"id"	   => $array_count,
				);

				$_SESSION['tmp_cases']['injuries_treatments']['imaging_center'][] = array_merge($post,$custom_array);
			}

			$json['is_successful'] 	= true;
		}

		echo json_encode($json);
	}

	function delete_imaging_center() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$id 		= (int) $post['id'];

		unset($_SESSION['tmp_cases']['injuries_treatments']['imaging_center'][$id]);
	}

	function doctor_list() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));
		$list 		= $_SESSION['tmp_cases']['injuries_treatments']['doctors'];


		if($session && $user) {
			$success = true;

			$data['list'] = $list;

			$this->load->view('cases/case_notes/injuries_treatments/doctor_list',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function add_doctor_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($session && $user) {
			$success = true;
			$this->load->view('cases/case_notes/injuries_treatments/form/add_doctor',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function edit_doctor_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$post_id	= (int) $post['id'];
		$doctor		= $_SESSION['tmp_cases']['injuries_treatments']['doctors'][$post_id];

		if($session && $user && $post && $doctor) {

			$success = true;

			$data['doctor'] = $doctor;

			$this->load->view('cases/case_notes/injuries_treatments/form/edit_doctor',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function save_doctor() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {

			$post_id = (int) $post['id'];
			if($post['update'] == true) {
				$_SESSION['tmp_cases']['injuries_treatments']['doctors'][$post_id] = $post;
			} else {
				$array_count = count($_SESSION['tmp_cases']['injuries_treatments']['doctors']);
				$custom_array = array(
					"id"	   => $array_count,
				);

				$_SESSION['tmp_cases']['injuries_treatments']['doctors'][] = array_merge($post,$custom_array);
			}

			$json['is_successful'] 	= true;
		}

		echo json_encode($json);
	}

	function delete_doctor() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$id 		= (int) $post['id'];

		unset($_SESSION['tmp_cases']['injuries_treatments']['doctors'][$id]);
	}

	function chiropractor_list() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));
		$list 		= $_SESSION['tmp_cases']['injuries_treatments']['chiropractors'];


		if($session && $user) {
			$success = true;

			$data['list'] = $list;

			$this->load->view('cases/case_notes/injuries_treatments/chiropractor_list',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function add_chiropractor_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($session && $user) {
			$success = true;
			$this->load->view('cases/case_notes/injuries_treatments/form/add_chiropractor',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function edit_chiropractor_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$post_id		= (int) $post['id'];
		$chiropractor	= $_SESSION['tmp_cases']['injuries_treatments']['chiropractors'][$post_id];

		if($session && $user && $post && $chiropractor) {

			$success = true;

			$data['chiropractor'] = $chiropractor;

			$this->load->view('cases/case_notes/injuries_treatments/form/edit_chiropractor',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function save_chiropractor() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {

			$post_id = (int) $post['id'];
			if($post['update'] == true) {
				$_SESSION['tmp_cases']['injuries_treatments']['chiropractors'][$post_id] = $post;
			} else {
				$array_count = count($_SESSION['tmp_cases']['injuries_treatments']['chiropractors']);
				$custom_array = array(
					"id"	   => $array_count,
				);

				$_SESSION['tmp_cases']['injuries_treatments']['chiropractors'][] = array_merge($post,$custom_array);
			}

			$json['is_successful'] 	= true;
		}

		echo json_encode($json);
	}

	function delete_chiropractor() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$id 		= (int) $post['id'];

		unset($_SESSION['tmp_cases']['injuries_treatments']['chiropractors'][$id]);
	}

	function therapist_list() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));
		$list 		= $_SESSION['tmp_cases']['injuries_treatments']['therapists'];


		if($session && $user) {
			$success = true;

			$data['list'] = $list;

			$this->load->view('cases/case_notes/injuries_treatments/therapist_list',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function add_therapist_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($session && $user) {
			$success = true;
			$this->load->view('cases/case_notes/injuries_treatments/form/add_therapist',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function edit_therapist_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$post_id	= (int) $post['id'];
		$th			= $_SESSION['tmp_cases']['injuries_treatments']['therapists'][$post_id];

		if($session && $user && $post && $th) {

			$success = true;

			$data['th'] = $th;

			$this->load->view('cases/case_notes/injuries_treatments/form/edit_therapist',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function save_therapist() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {

			$post_id = (int) $post['id'];
			if($post['update'] == true) {
				$_SESSION['tmp_cases']['injuries_treatments']['therapists'][$post_id] = $post;
			} else {
				$array_count = count($_SESSION['tmp_cases']['injuries_treatments']['therapists']);
				$custom_array = array(
					"id"	   => $array_count,
				);

				$_SESSION['tmp_cases']['injuries_treatments']['therapists'][] = array_merge($post,$custom_array);
			}

			$json['is_successful'] 	= true;
		}

		echo json_encode($json);
	}

	function delete_therapy() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$id 		= (int) $post['id'];

		unset($_SESSION['tmp_cases']['injuries_treatments']['therapists'][$id]);
	}

	function referred_client_list() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));
		$list 		= $_SESSION['tmp_cases']['injuries_treatments']['referred_client'];


		if($session && $user) {
			$success = true;

			$data['list'] = $list;

			$this->load->view('cases/case_notes/injuries_treatments/referred_client_list',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function add_referred_client_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($session && $user) {
			$success = true;
			$this->load->view('cases/case_notes/injuries_treatments/form/add_referred_client',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function save_referred_client() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {

			$post_id = (int) $post['id'];
			if($post['update'] == true) {
				$_SESSION['tmp_cases']['injuries_treatments']['referred_client'][$post_id] = $post;
			} else {
				$array_count = count($_SESSION['tmp_cases']['injuries_treatments']['referred_client']);
				$custom_array = array(
					"id"	   => $array_count,
				);

				$_SESSION['tmp_cases']['injuries_treatments']['referred_client'][] = array_merge($post,$custom_array);
			}

			$json['is_successful'] 	= true;
		}

		echo json_encode($json);
	}

	function edit_referred_client_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$post_id	= (int) $post['id'];
		$rc			= $_SESSION['tmp_cases']['injuries_treatments']['referred_client'][$post_id];

		if($session && $user && $post && $rc) {

			$success = true;

			$data['rc'] = $rc;

			$this->load->view('cases/case_notes/injuries_treatments/form/edit_referred_client',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function delete_referred_client() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$id 		= (int) $post['id'];

		unset($_SESSION['tmp_cases']['injuries_treatments']['referred_client'][$id]);
	}

	function medical_provider_list() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));
		$list 		= $_SESSION['tmp_cases']['injuries_treatments']['medical_provider'];


		if($session && $user) {
			$success = true;

			$data['list'] = $list;

			$this->load->view('cases/case_notes/injuries_treatments/medical_provider_list',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function add_medical_provider_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($session && $user) {
			$success = true;
			$this->load->view('cases/case_notes/injuries_treatments/form/add_medical_provider',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function edit_medical_provider_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$post_id	= (int) $post['id'];
		$mp			= $_SESSION['tmp_cases']['injuries_treatments']['medical_provider'][$post_id];

		if($session && $user && $post && $mp) {

			$success = true;

			$data['mp'] = $mp;

			$this->load->view('cases/case_notes/injuries_treatments/form/edit_medical_provider',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function save_medical_provider() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {

			$post_id = (int) $post['id'];
			if($post['update'] == true) {
				$_SESSION['tmp_cases']['injuries_treatments']['medical_provider'][$post_id] = $post;
			} else {
				$array_count = count($_SESSION['tmp_cases']['injuries_treatments']['medical_provider']);
				$custom_array = array(
					"id"	   => $array_count,
				);

				$_SESSION['tmp_cases']['injuries_treatments']['medical_provider'][] = array_merge($post,$custom_array);
			}

			$json['is_successful'] 	= true;
		}

		echo json_encode($json);
	}

	function delete_medical_provider() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$id 		= (int) $post['id'];

		unset($_SESSION['tmp_cases']['injuries_treatments']['medical_provider'][$id]);
	}

	function preex_medical_condition_list() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));
		$list 		= $_SESSION['tmp_cases']['injuries_treatments']['preex_medical_condition'];


		if($session && $user) {
			$success = true;

			$data['list'] = $list;

			$this->load->view('cases/case_notes/injuries_treatments/preex_medical_condition_list',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function add_preex_medical_condition_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($session && $user) {
			$success = true;
			$this->load->view('cases/case_notes/injuries_treatments/form/add_preex_medical_condition',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function edit_preex_medical_condition_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$post_id	= (int) $post['id'];
		$pre		= $_SESSION['tmp_cases']['injuries_treatments']['preex_medical_condition'][$post_id];

		if($session && $user && $post && $pre) {

			$success = true;

			$data['pre'] = $pre;

			$this->load->view('cases/case_notes/injuries_treatments/form/edit_preex_medical_condition',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function save_preex_medical_condition() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {

			$post_id = (int) $post['id'];
			if($post['update'] == true) {
				$_SESSION['tmp_cases']['injuries_treatments']['preex_medical_condition'][$post_id] = $post;
			} else {
				$array_count = count($_SESSION['tmp_cases']['injuries_treatments']['preex_medical_condition']);
				$custom_array = array(
					"id"	   => $array_count,
				);

				$_SESSION['tmp_cases']['injuries_treatments']['preex_medical_condition'][] = array_merge($post,$custom_array);
			}

			$json['is_successful'] 	= true;
		}

		echo json_encode($json);
	}

	function delete_preex_medical_condition() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$id 		= (int) $post['id'];

		unset($_SESSION['tmp_cases']['injuries_treatments']['preex_medical_condition'][$id]);
	}

	function subsequent_accident_list() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));
		$list 		= $_SESSION['tmp_cases']['injuries_treatments']['subsequent_accident'];


		if($session && $user) {
			$success = true;

			$data['list'] = $list;

			$this->load->view('cases/case_notes/injuries_treatments/subsequent_accident_list',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function add_subsequent_accident_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($session && $user) {
			$success = true;
			$this->load->view('cases/case_notes/injuries_treatments/form/add_subsequent_accident',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function edit_subsequent_accident_form() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$success 	= false;
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$post_id	= (int) $post['id'];
		$sa			= $_SESSION['tmp_cases']['injuries_treatments']['subsequent_accident'][$post_id];

		if($session && $user && $post && $sa) {

			$success = true;

			$data['sa'] = $sa;

			$this->load->view('cases/case_notes/injuries_treatments/form/edit_subsequent_accident',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function save_subsequent_accident() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($post && $session && $user) {

			$post_id = (int) $post['id'];
			if($post['update'] == true) {
				$_SESSION['tmp_cases']['injuries_treatments']['subsequent_accident'][$post_id] = $post;
			} else {
				$array_count = count($_SESSION['tmp_cases']['injuries_treatments']['subsequent_accident']);
				$custom_array = array(
					"id"	   => $array_count,
				);

				$_SESSION['tmp_cases']['injuries_treatments']['subsequent_accident'][] = array_merge($post,$custom_array);
			}

			$json['is_successful'] 	= true;
		}

		echo json_encode($json);
	}

	function delete_subsequent_accident() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();
		
		$post 		= $this->input->post();
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		$id 		= (int) $post['id'];

		unset($_SESSION['tmp_cases']['injuries_treatments']['subsequent_accident'][$id]);
	}


	function debug_session() {
		debug_array($_SESSION['tmp_cases']);
	}

	function add_injuries_treatments() {
		$this->check_user_login();
		$post = $this->validate_ajax_post();
	
		if($post) {

			if(!$_SESSION['tmp_cases']['injuries_treatments']) {
				$_SESSION['tmp_cases']['injuries_treatments'] = $post;
			} else {
				$_SESSION['tmp_cases']['injuries_treatments'] = array_merge($_SESSION['tmp_cases']['injuries_treatments'],$post);
			}
			
			$json['is_successful'] 	= true;
			$json['message'] 		= "Successfully updated!";
		} else {
			$json['is_successful'] 	= false;
			$json['message']		= "Ooop! Error adding to database. Please contact web administrator!";
		}

		echo json_encode($json);
	}

	function economic_damages() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();

		$data['session']	= $session = $_SESSION['cnp']['login'];
		$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));

		$success = false;

		if($session && $firm && $user) {
			$success = true;

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

			$this->load->view('cases/case_notes/economic_damages/form/economic_damages',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}

	function add_economic_damages() {
		$this->check_user_login();
		$post = $this->validate_ajax_post();
	
		if($post) {
			$_SESSION['tmp_cases']['economic_damages'] = $post;
			$json['is_successful'] 	= true;
			$json['message'] 		= "Successfully updated!";
		} else {
			$json['is_successful'] 	= false;
			$json['message']		= "Ooop! Error adding to database. Please contact web administrator!";
		}

		echo json_encode($json);
	}

	function notes() {
		Engine::XmlHttpRequestOnly();
		$this->check_user_login();

		$data['session']	= $session = $_SESSION['cnp']['login'];
		$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));

		$success = false;

		if($session && $firm && $user) {
			$success = true;
			$this->load->view('cases/case_notes/notes/form/notes',$data);
		}

		if(!$success)
		die("<script>error_404();</script>");
	}


	function add_notes() {
		$this->check_user_login();
		$post = $this->validate_ajax_post();
	
		if($post) {
			$_SESSION['tmp_cases']['notes'] = $post;
			$json['is_successful'] 	= true;
			$json['message'] 		= "Successfully updated!";
		} else {
			$json['is_successful'] 	= false;
			$json['message']		= "Ooop! Error adding to database. Please contact web administrator!";
		}

		echo json_encode($json);
	}

	function validate_ajax_post() {
		Engine::XmlHttpRequestOnly();
		$post = $this->input->post();

		if($post) {
			return $post;
		} else {
			die(DEFAULT_ERROR);
		}
	}

	function documents() {
		$this->check_user_login();

		Engine::appStyle('bootstrap.min.css');

		Bootstrap::modal();
		Bootstrap::datetimepicker();
		
		Engine::appStyle('cases.css');
		Engine::appStyle('general.css');
		Engine::appScript('javascript.js');
		Engine::appScript('confirmation.js');
		Engine::appScript('cases-documents.js');

		Jquery::form();
		Jquery::datatable();
		Jquery::inline_validation();
		Jquery::tipsy();
		Jquery::select2();
		Jquery::plup_uploader();
		Jquery::signaturepad();

		$params = array(
			"firm_id" => (int) $this->encrypt->decode($_SESSION['cnp']['login']['firm_id']),
			"fields"  => array("id,firm_id,parent_id,main_document_id,title")
		);
		$data['document_sets'] = $document_sets = Document::findAllAvailableDocumentSets($params);

		$data['case_code'] = $_SESSION['cases']['code'];

		$data['page_title'] = "CNP :: Documents";
		$data['session']	= $session = $_SESSION['cnp']['login'];
		$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));
		$data['documents_active'] = "tab-block-active";

		$this->load->view('cases/document/index',$data);
	}

	function document_list_dt() {
		$this->check_user_login();

		$data['session'] 	= $session = $_SESSION['cnp']['login'];
		$data['parent_id']	= $parent_id = (int) $post['parent_id'];
		

		$data['show_breadcrumbs'] = self::create_breadcrumbs($parent_id);

		$this->load->view('cases/document/document_list_ss',$data);
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

		$get 		= $this->input->get();
		$session 	= $_SESSION['cnp']['login'];

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
				4 => "date_accepted",
			);

			$order_by 	= $rows[$sorting] . " {$order_type}";
			$limit  	= $display_start . ", 10";

			$params = array(
				"firm_id" 	=> (int) $this->encrypt->decode($session['firm_id']),
				"parent_id" => (int) $get['document_set_id'],
				"search" 	=> $query,
				"fields" 	=> $fields,
				"order"  	=> $order_by,
				"limit"  	=> $limit,
			);

			#debug_array($params);

			$documents 		= Document::generateUserDocumentsDatatable($params);
			$total_records 	= Document::countUserDocumentsDatatable($params);

			$output = array(
				"sEcho" => $get['sEcho'],
				"iTotalRecords" => $total_records,
				"iTotalDisplayRecords" => $total_records,
				"aaData" => array()
			);

			foreach($documents as $key=>$value):

				$is_checked = ($_SESSION['cases']['preapprove_document'][$value['id']] ? 'checked="checked"' : '');
				$title_link = '
					<a href="javascript:void(0);" onclick="javascript:preview_document('.$value['id'].')">'.$value['title'].'</a>
				';

				$row = array(
					'0' => '<input type="checkbox" id="ck_'.$value['id'].'" ' . $is_checked . ' onclick="javascript:preapproved_document('.$value['id'].')">',
					'1' => $title_link,
					'2' => character_limiter($value['description'], 100),
					'3' => $value['date_accepted'],
				);
				
				$output['aaData'][] = $row;

			endforeach;
		} else {
			$output = array(
				"sEcho" => $get['sEcho'],
				"iTotalRecords" => 0,
				"iTotalDisplayRecords" => 0,
				"aaData" => array()
			);
		}
		
		echo json_encode($output);
	}

	function preprocess_document() {
		$post = $this->validate_ajax_post();

		if($post) {
			$post_id = (int) $post['id'];

			if($post['is_approved'] == 1) {
				$_SESSION['cases']['preapprove_document'][$post_id] = true;
			} else {
				unset($_SESSION['cases']['preapprove_document'][$post_id]);
			}
		}
		
	}

	function preview_document() {
		$this->check_user_login();
		$post = $this->validate_ajax_post();
		
		$post_id = (int) $post['id'];
		$data['document'] = $document =  Document::findById($post_id);

		if($post && $document) {

			$session = $_SESSION['cnp']['login'];

			$firm_id = (int) $this->encrypt->decode($session['firm_id']);
			$firm = Firm::findById($firm_id);

			$firm_name 	= strtolower(url_title($firm['firm_name']));
			$firm_logo	= ($firm['firm_logo_url'] == "" ? BASE_FOLDER ."themes/images/logo.png" : MEDIA_FOLDER . "firm/{$firm_name}/resize/" . $firm['firm_logo_url']); 

			$data['firm_logo'] = $firm_logo;
			$this->load->view('cases/document/form/preview_document',$data);

		} else {
			die(DEFAULT_ERROR);
		}
	}

	function accept_document() {
		$this->check_user_login();
		$post = $this->validate_ajax_post();

		$session 			= $_SESSION['cnp']['login'];
		$document_session 	= $_SESSION['cases']['preapprove_document'];

		if($post && $session) {

			foreach($document_session as $key=>$value):

				$document 	= Document::findById($key);
				
				$firm 	= Firm::findById($document['firm_id']);
				$tz 	= Timezone::findById($firm['timezone_id']);

				$sign 	= ($tz['sign'] == "neg" ? '-' : '+');
				date_default_timezone_set($tz['timezone_code']);

				$record = array(
					"is_accepted" 	=> YES,
					"date_accepted" => date("Y-m-d H:i:s",time()),
				);

				Document::save($record,$key);

				$output = filter_input(INPUT_POST, 'output', FILTER_UNSAFE_RAW);
				if (json_decode($output)) {
					$signature 		= $this->encrypt->encode($output);
					$signature_hash = Password_Hash::create_hash($output);
					$ip_address 	= $this->input->ip_address();
				}

				$record = array(
					"document_id" 		=> $key,
					"title" 			=> $document['title'],
					"description" 		=> $document['description'],
					"document_text" 	=> $document['document_text'],
					"signature" 		=> $signature,
					"signature_hash" 	=> $signature_hash,
					"ip_address" 		=> $ip_address,
					"date_accepted" 	=> date("Y-m-d H:i:s",time()),
					"date_created" 		=> date("Y-m-d H:i:s",time()),
					"last_update_by" 	=> (int) $this->encrypt->decode($session['user_id']),
				);

				$arr[] = $record;

				#Case_Document::save($record);
				
			endforeach;

			
			$_SESSION['tmp_cases']['document'] = $arr;
			debug_array($_SESSION['tmp_cases']['document']);
		}
	}

	function photos() {
		$this->check_user_login();

		Engine::appStyle('bootstrap.min.css');

		Bootstrap::modal();
		Bootstrap::datetimepicker();
		
		Engine::appStyle('cases.css');
		Engine::appStyle('general.css');
		Engine::appScript('javascript.js');
		Engine::appScript('confirmation.js');
		Engine::appScript('cases-photos.js');

		Jquery::form();
		Jquery::datatable();
		Jquery::tipsy();
		Jquery::select2();
		Jquery::plup_uploader();

		$data['case_code'] = $_SESSION['cases']['code'];
		$data['photos_active'] = "tab-block-active";

		$data['page_title'] = "CNP :: Manage Photos";
		$data['session']	= $session = $_SESSION['cnp']['login'];
		$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));

		$this->load->view('cases/photos/index',$data);
	}

	function uploaded_file_list() {
		$this->check_user_login();
		Engine::XmlHttpRequestOnly();

		$data['files'] = $session = $_SESSION['tmp_cases']['photo'];
		$this->load->view('cases/photos/uploaded_file_list',$data);
	}

	function upload_photo_form() {
		Engine::XmlHttpRequestOnly();

		$session = $_SESSION['cnp']['login'];
		if($session) {
			$this->load->view('cases/photos/form/upload_case_photo',$data);
		}
	}

	function upload_case_photo() {
		$success 	= false;

		$file 		= $_FILES['file'];
		$session 	= $_SESSION['cnp']['login'];
		$user 		= User::findById($this->encrypt->decode($session['user_id']));

		if($file && $session && $user) {

			$this->load->helper('string');
			$random_key = random_string('unique');

			$file_extension	= substr($file['name'], -3);
			$raw_name 		= $this->encrypt->sha1(basename($file['name']."$random_key")).date("hims",time());
			$upload_name 	= $file['name'];
			$file_size 		= $file['size'];

			$dir = "files/case_photos/tmp/";
			if(!is_dir($dir)) {
				mkdir($dir,0777,true);
			}

			$path = "$dir/$raw_name.{$file_extension}";
				
			if(move_uploaded_file($file['tmp_name'], $path)) {
				$arr = array(
					"base_dir" 		=> $dir,
					"raw_name" 		=> $raw_name,
					"upload_name" 	=> $upload_name,
					"size" 			=> $file_size
				);
				$_SESSION['tmp_cases']['photo'][] = $arr;
				/*
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
		        */
			}
		}
	}

	function submit() {
		$this->check_user_login();

		Engine::appStyle('bootstrap.min.css');

		Bootstrap::modal();
		Bootstrap::datetimepicker();
		
		Engine::appStyle('cases.css');
		Engine::appStyle('general.css');
		Engine::appScript('javascript.js');
		Engine::appScript('confirmation.js');
		Engine::appScript('cases-photos.js');

		Jquery::form();
		Jquery::datatable();
		Jquery::tipsy();
		Jquery::select2();
		Jquery::plup_uploader();

		$data['case_code'] 	= $_SESSION['cases']['code'];
		$data['cn'] 		= $_SESSION['tmp_cases'];

		$data['submit_active'] = "tab-block-active";

		$data['page_title'] = "CNP :: Manage Photos";
		$data['session']	= $session = $_SESSION['cnp']['login'];
		$data['firm'] 		= $firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		$data['user'] 		= $user = User::findById($this->encrypt->decode($session['user_id']));

		$this->load->view('cases/submit/index',$data);
	}

}
