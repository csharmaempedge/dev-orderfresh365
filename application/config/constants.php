<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
define('SQUAREUP_ENVIRONMENT',		'sandbox');
define('SQUAREUP_ACCESS_TOKEN',		'EAAAEOT1aEc1128Jw9UbEcPAUN8qLlRhbkvZ28yOEmPJZ8h7NgknswLeHiKqn4ua');
define('SQUAREUP_FORM_JS',		'https://js.squareupsandbox.com/v2/paymentform');
define('SQUAREUP_APPLICATION_ID', 'sandbox-sq0idb-Uk7yxyBzPioJhOxPp1W1pQ');
define('SQUAREUP_LOCATION_ID', 'LK4YCS7WD8Y6C');




/*define('SQUAREUP_ENVIRONMENT',		'production');
define('SQUAREUP_ACCESS_TOKEN',		'EAAAEJ_5a2zm19IdpX20aer0RwsUMlEpRpeRvoDi-4Viw1-aReAr9vGIfzoz1a4F');
define('SQUAREUP_FORM_JS',		'https://js.squareup.com/v2/paymentform');
define('SQUAREUP_APPLICATION_ID', 'sq0idp-tghxW1dkYIsC0t7QIUZk5g');
define('SQUAREUP_LOCATION_ID', 'LXYHZXWV41F99');*/

define('membership_width',		'512');
define('membership_height',		'512');
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