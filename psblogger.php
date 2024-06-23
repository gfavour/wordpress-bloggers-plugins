<?php
/*
Plugin Name: PS-Blogger
Plugin URI: https://www.progmatech.com
Description: This is wordpress plugin mainly for those that want to display their post in a different style way and to do some certain task.
Version: 0.1
Author: Progmatech Solutions
Author URI: http://www.progmatech.com
*/
define('psblogger_PATH', plugins_url('/', __FILE__)); 
define('psblogger_CPATH', 'client/');
define('psblogger_PLUGINDIR',plugin_dir_path( __DIR__ ));
define('psblogger_WPCPATH','wp-content/plugins/psblogger/');
define('psblogger_ARCHIVES', plugins_url('/archives/', __FILE__));
define('PSM_ASSETS', plugins_url('/assets/', __FILE__));

function psblogger_fxn(){
//add_menu_page('psblogger','PS Blogger','manage_options','psblogger','psblogger_init_fxn','',7); //documentation functions
//add_submenu_page('psblogger','Customer Requests', 'request', 'manage_options','psb_request','psblogger_menu1_fxn');
//add_submenu_page('psblogger','Testimonials', 'Testimonials', 'manage_options','psb_testimony','psblogger_menu2_fxn');
//add_submenu_page('psblogger','Documentation', 'Payments', 'manage_options','pscon_payments','PSCONTESTER_menu8_fxn');
}

function PSCONTESTER_init_fxn(){
	include("requests.php");
}

function psblogger_menu1_fxn(){
	include("requests.php");
}
function psblogger_menu2_fxn(){
	if($_GET[subdwat] == 'add'){
		include("testimony-add.php");
	}else{
		include("testimony.php");
	}
}

function psblogger_formatcurrency($amt){
	$pssign = '&#8358; '; //dollar - &#36;
	$amount = $pssign.number_format($amt,2);
	return $amount;
}

function psblogger_hook_files(){
	wp_register_style('psblogger_css',PSM_ASSETS.'css/style.css');
	wp_enqueue_style('psblogger_css');
	wp_register_style('psblogger_css',PSM_ASSETS.'css/fontawesome450.css');
	wp_enqueue_style('psblogger_fontawesome');
	wp_enqueue_style('psm_owlc1', PSM_ASSETS.'owlcarousel/assets/owl.carousel.min.css', array());
	wp_enqueue_style('psm_owlc2', PSM_ASSETS.'owlcarousel/assets/owl.theme.default.min.css', array());
	
wp_enqueue_script('psm_owlcjs', PSM_ASSETS.'owlcarousel/owl.carousel.js', array('jquery'), false, true);
wp_enqueue_script('psm_myowlcjs', PSM_ASSETS.'owlcarousel/owl-mine.js', array('jquery'), false, true);
		
}

add_action('admin_menu','psblogger_fxn');
add_action( 'wp_enqueue_scripts', 'psblogger_hook_files' );

//Set database.....
include("psblogger-dbm.php");
register_activation_hook( __FILE__, 'psbTestimonial_table');
register_activation_hook( __FILE__, 'psbRequest_table');

include("psblogger-allfxns.php");
//Shortcode
include("psblogger-start.php");
include("psblogger-icons.php");
?>