<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "login/module_gateway";
$route['404_override'] = '';

$route['user_gateway'] 	= "login/module_gateway";
$route['login'] 		= "login/user";
$route['login/user/(:any)'] = "login/user/$1";
$route['logout'] 		= "settings/user_logout";
$route['my_profile'] 	= "settings/profile";

$route['authenticate/case/(:any)'] 	= "super/case_login/$1";
$route['view/case'] 				= "super/view_case";
$route['super_case_login/(:any)'] 	= "super/authenticate_case_login/$1";

$route['change_password'] = "login/change_password";

//super
$route['save_document_set'] 	= "super/save_document_set";
$route['upload_case_document'] 	= "super/upload_case_document";







/* End of file routes.php */
/* Location: ./application/config/routes.php */