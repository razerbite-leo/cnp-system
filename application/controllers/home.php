<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct() {
		parent::__construct();
 		Engine::class_loader();
 		$this->check_user_login();

	}

	function index()
	{	
		$session = $_SESSION['cnp']['login'];
		if($session['account_type'] == SUPER_ADMIN) {
			redirect("super");
		}
	}

}