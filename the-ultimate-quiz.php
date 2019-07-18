<?php
/*
Plugin Name: The Ultimate Quiz
Plugin URI:  plugins.hire-expert-developer.com/the-ultimate-quiz/
Description: A simpele exam quiz plugin.
Version:     1.0
Author:      Shrikant Yadav
Author URI:  http://shrikant-y.hire-expert-developer.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
*/


//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TUQ_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

// Including files 
require_once ( TUQ_PLUGIN_PATH . 'includes/tuq-shortcode.php' ); 
require_once ( TUQ_PLUGIN_PATH . 'includes/tuq-settings.php' );
require_once ( TUQ_PLUGIN_PATH . 'includes/tuq-ajax-functions.php' ); 


function tuq_wp_enqueue_scripts() {

		// Styles 
 		wp_enqueue_style( 'tuq-style', plugins_url( 'css/tuq-style.css', __FILE__ ) );

 		// Script 
 		wp_enqueue_script( 'tuq-ajax-js', plugins_url( 'js/tuq-ajax.js', __FILE__ ), array( 'jquery'), '20160520', true );

		$count_posts = wp_count_posts('post');
		$published_posts = $count_posts->publish;

		$options = get_option('tuq_settings_option');
		$auto_load_posts = $options['tuq_post_auto_load']; 

		// AjaxURL
		wp_localize_script( 'tuq-ajax-js', 'AJAXOBJ', array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'tuq_security' => wp_create_nonce( 'tuq_setting_nonce_action' ),
			 ));
		

 		wp_enqueue_script( 'tuq-scripts-js', plugins_url( 'js/tuq-scripts.js', __FILE__ ), array( 'jquery'), '20160520', true );

}
add_action( 'wp_enqueue_scripts', 'tuq_wp_enqueue_scripts' );


function tuq_admin_enqueue_scripts() {

		global $pagenow, $typenow;
		 
		// Admin Styles 
 		wp_enqueue_style( 'tuq-admin-style', plugins_url( 'css/tuq-admin-style.css', __FILE__ ) );
 		
 		// Admin Scripts
 		wp_enqueue_script( 'tuq-admin-scripts', plugins_url( 'js/tuq-admin-scripts.js', __FILE__ ), array( 'jquery'), '20160520', true );
 		

}
add_action( 'admin_enqueue_scripts', 'tuq_admin_enqueue_scripts' );

