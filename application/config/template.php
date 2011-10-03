<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Set the theme
|--------------------------------------------------------------------------
|
| Theme is set by default to standart html5boilerplate template.
| New theme can be create under view/templates and must contain header.php and footer.php
|
*/

$template['theme'] = 'default';

/*
|--------------------------------------------------------------------------
| Add layout views
|--------------------------------------------------------------------------
|
| Add views load between header and footer
| Dont forget to autoload used libs and helper classes
|
*/

$template['layouts'] = array();

/*
|--------------------------------------------------------------------------
| Set header data
|--------------------------------------------------------------------------
|
| Header data will be set in the <head> tag inside header.php
| Set page title, author and a small description
|
*/

$template['title'] = 'Title change in template config file';
$template['author'] = 'Author change in template config file';
$template['description'] = 'Description  hange in template config file';

/*
|--------------------------------------------------------------------------
| Google analytics ID
|--------------------------------------------------------------------------
|
| Set the google analytic ID for your site
|
*/

$template['google_analytic_id'] = 'UAXXXXXXXX1';

/*
 * Note: css, js must be define in the template cause of Ant Builder
 */