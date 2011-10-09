<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Set salt for user password hash
|--------------------------------------------------------------------------
|
| A little salt for the password? ;)
|
*/

$config['salt'] = 'm}WGbb_VyQ"|f#]LqNxk1(`VfFENY)1z';
/*
|--------------------------------------------------------------------------
| Enable/Disable user signup confirms
|--------------------------------------------------------------------------
|
| Enable to send activation links to user email
|
*/

$config['confirm_signup'] = TRUE;

/*
|--------------------------------------------------------------------------
| Set path to the avatars
|--------------------------------------------------------------------------
|
| Relative to base url
|
*/

$config['upload_path_avatars'] = 'uploads/avatars/';

/*
|--------------------------------------------------------------------------
| Set support email
|--------------------------------------------------------------------------
|
| For example support@site.com
|
*/

$config['email'] = 'no-reply@teedb.info';

/* End of file user.php */
/* Location: ./application/modules/user/config/user.php */