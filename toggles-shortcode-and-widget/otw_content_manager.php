<?php
/**
Plugin Name: Toggles Shortcode And Widgets
Plugin URI: http://OTWthemes.com
Description:  Create Toggles. Nice and easy interface. Insert anywhere in your site - page/post editor, sidebars, template files.
Author: OTWthemes
Version: 1.14
Author URI: https://codecanyon.net/user/otwthemes/portfolio?ref=OTWthemes
*/

load_plugin_textdomain('otw_tgsw',false,dirname(plugin_basename(__FILE__)) . '/languages/');

load_plugin_textdomain('otw-shortcode-widget',false,dirname(plugin_basename(__FILE__)) . '/languages/');

$wp_tgsw_tmc_items = array(
	'page'              => array( array(), esc_html__( 'Pages', 'otw_tgsw' ) ),
	'post'              => array( array(), esc_html__( 'Posts', 'otw_tgsw' ) )
);

$wp_tgsw_agm_items = array(
	'page'              => array( array(), esc_html__( 'Pages', 'otw_tgsw' ) ),
	'post'              => array( array(), esc_html__( 'Posts', 'otw_tgsw' ) )
);

$wp_tgsw_cs_items = array(
	'page'              => array( array(), esc_html__( 'Pages', 'otw_tgsw' ) ),
	'post'              => array( array(), esc_html__( 'Posts', 'otw_tgsw' ) )
);

$otw_tgsw_plugin_url = plugin_dir_url( __FILE__);
$otw_tgsw_css_version = '1.8';
$otw_tgsw_js_version = '1.8';
$otw_tgsw_plugin_id = 'c5bf57d6475698fab514de4f7372d904';

$otw_tgsw_plugin_options = get_option( 'otw_tgsw_plugin_options' );

//include functons
require_once( plugin_dir_path( __FILE__ ).'/include/otw_tgsw_functions.php' );

//otw components
$otw_tgsw_shortcode_component = false;
$otw_tgsw_form_component = false;
$otw_tgsw_validator_component = false;
$otw_tgsw_factory_component = false;
$otw_tgsw_factory_object = false;


//load core component functions
@include_once( 'include/otw_components/otw_functions/otw_functions.php' );

if( !function_exists( 'otw_register_component' ) ){
	wp_die( 'Please include otw components' );
}

//register form component
otw_register_component( 'otw_form', dirname( __FILE__ ).'/include/otw_components/otw_form/', $otw_tgsw_plugin_url.'include/otw_components/otw_form/' );

//register validator component
otw_register_component( 'otw_validator', dirname( __FILE__ ).'/include/otw_components/otw_validator/', $otw_tgsw_plugin_url.'include/otw_components/otw_validator/' );

//register factory component
otw_register_component( 'otw_factory', dirname( __FILE__ ).'/include/otw_components/otw_factory/', $otw_tgsw_plugin_url.'/include/otw_components/otw_factory/' );

//register shortcode component
otw_register_component( 'otw_shortcode', dirname( __FILE__ ).'/include/otw_components/otw_shortcode/', $otw_tgsw_plugin_url.'include/otw_components/otw_shortcode/' );

/** 
 *call init plugin function
 */
add_action('init', 'otw_tgsw_init' );
add_action('widgets_init', 'otw_tgsw_widgets_init' );

?>