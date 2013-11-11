<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Super extends CI_Controller {
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

		Engine::appStyle('super-user-style.css');

		$data['page_title'] = 'Home';
		$data['session'] 	= $_SESSION['cnp']['login'];

		$this->load->view('super/welcome',$data);
	}

	function manage_users() {
		$this->check_user_login();

		Engine::appStyle('admin-style.css');
		Engine::appScript('javascript.js');

		$data['module']		= "manage_users";
		$data['page_title'] = "Admin :: Manage Users";
		$data['session'] 	= $_SESSION['cnp']['login'];

		$this->load->view('super/manage_users',$data);
	}

	function add_user() {
		$this->check_user_login();

		Engine::appStyle('admin-style.css');
		Engine::appScript('javascript.js');

		$data['module']		= "add_user";
		$data['page_title'] = "Admin :: Add User";
		$data['session'] 	= $_SESSION['cnp']['login'];

		$this->load->view('super/forms/add_user',$data);	
	}
}