<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| SYSTEM USERS
|--------------------------------------------------------------------------
|
|
*/

define("SUPER_ADMIN","Super Administrator");
define("TECH_ADMIN","Tech Adminitrator");
define("FIRM_ADMIN","Firm Administrator");
define("TECH_STAFF","Tech Staff");
define("USER_LEVEL","User Level");

/*
|--------------------------------------------------------------------------
| DATABASE TABLE NAMES
|--------------------------------------------------------------------------
|
|
*/

/*
	STATUS
*/

define("YES","Yes");
define("NO","No");
define("ACTIVE","Active");
define("INACTIVE","Inactive");


/*
	PARTIES
*/
define("CLIENT","Client");
define("DEFENDANT","Defendant");

define("OWNER","Owner");

/*
	DOCUMENT
*/
define("DOCUMENT_SET","Document Set");
define("DOCUMENT_IMAGE","Document Image");
define("DOCUMENT","Document");

/*
	TABLES
*/
define('CNP_USER','cnp_user');
define('CNP_USER_CONTACT_LIST','cnp_user_contact_list');
define('CNP_FIRM','cnp_firm');
define('CNP_FIRM_CONTACT_LIST','cnp_firm_contact_list');
define('CNP_SETTINGS_SUBSCRIPTION_PLAN','cnp_settings_subscription_plan');
define('CNP_DOCUMENT','cnp_document');
define('CNP_DOCUMENT_PERMISSION','cnp_document_permission');
define('CNP_CASE_FIRM_SUBSCRIPTION','cnp_case_firm_subscription');
define('CNP_PASSWORD_RECOVERY','cnp_password_recovery');
define('CNP_TIMEZONE','cnp_timezone');
define('CNP_CASE_DOCUMENT','cnp_case_document');

define('CNP_CASE','cnp_case');
define('CNP_CASE_GENERAL_INFORMATION','cnp_case_general_information');

define("ORIGINAL_DOC","Original");
define("BRANCH_DOC","Branch");

define("DEFAULT_ERROR","Ooops! Error occured. Please contact web administrator!");

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */