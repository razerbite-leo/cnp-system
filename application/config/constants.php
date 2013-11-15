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

define("PENDING","Pending");
define("SAVED","Saved");


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
define('CNP_CASE_PARTIES_INVOLVED_CONTACT_LIST','cnp_case_parties_involved_contact_list');
define('CNP_CASE_PARTIES_INVOLVED_CONTACT_PERSON_LIST','cnp_case_parties_involved_contact_person_list');
define('CNP_CASE_INCIDENT_DESCRIPTION','cnp_case_incident_description');
define('CNP_CASE_INSURANCE','cnp_case_insurance');
define('CNP_CASE_VEHICLES','cnp_case_vehicles');
define('CNP_CASE_INJURIES_TREATMENT','cnp_case_injuries_treatment');
define('CNP_CASE_INJ_AMBULANCE','cnp_case_inj_ambulance');
define('CNP_CASE_INJ_HOSPITAL_ER','cnp_case_inj_hospital_er');
define('CNP_CASE_INJ_URGENT_CARE_CLINIC','cnp_case_inj_urgent_care_clinic');
define('CNP_CASE_INJ_IMAGING_CENTER','cnp_case_inj_imaging_center');
define('CNP_CASE_INJ_DOCTOR','cnp_case_inj_doctor');
define('CNP_CASE_INJ_CHIROPRACTOR','cnp_case_inj_chiropractor');
define('CNP_CASE_INJ_THERAPIST','cnp_case_inj_therapist');
define('CNP_CASE_INJ_REFERRED_CLIENT','cnp_case_inj_referred_client');
define('CNP_CASE_INJ_MEDICAL_PROVIDER','cnp_case_inj_medical_provider');
define('CNP_CASE_INJ_MEDICAL_PREEX_MEDICAL_CONDITION','cnp_case_inj_preex_medical_condition');
define('CNP_CASE_INJ_SUBSEQUENT_ACCIDENT','cnp_case_inj_subsequent_accident');
define('CNP_CASE_ECONOMIC_DAMAGE','cnp_case_economic_damage');
define('CNP_CASE_INVESTIGATORS_NOTE','cnp_case_investigators_note');


define('CNP_CASE','cnp_case');
define('CNP_CASE_GENERAL_INFORMATION','cnp_case_general_information');
define('CNP_CASE_PARTIES_INVOLVED','cnp_case_parties_involved');

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