<?php
/**
 * Plugin Name:       WP Code
 * Plugin URI:
 * Description:       Easily add CSS/JavaScript in header or footer or body of WordPress website.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Onkar Singh
 * Author URI:
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wp-code
 * Domain Path:       languages
 */
 //No direct access, please
defined( 'ABSPATH' ) || wp_die( 'No access...' );
 /**
* Main Class
*/
if(  !class_exists( 'WPCODE' )  ){
	class WPCODE{
		public function __construct() {
			// activation hook
			register_activation_hook( __FILE__, function(){
				delete_transient( 'wp_promotion_disabled' );
			} );
			// init plugin data
			$WPC_data 				   = get_file_data( __FILE__, [ 'Version' => 'Version' ] );
			$this->plugin              = new stdClass;
			$this->plugin->name        = 'wp-code';
			$this->plugin->displayName = 'WP Code';
			$this->debug_mode          = !0;
			$this->plugin->version     = $WPC_data[ 'Version' ];
			$this->plugin->path        = plugin_dir_path( __FILE__ );
			$this->plugin->url         = plugin_dir_url( __FILE__ );
			$this->plugin->assets 	   = plugin_dir_url( __FILE__ ).'assets/';
			$this->promotion_disabled  = get_transient( 'wp_promotion_disabled' ) ? !0: 0;
			$this->header_priority     = get_option( 'header_priority', 10 );
			$this->footer_priority     = get_option( 'footer_priority', 10 );
			$this->body_open_supported = function_exists( 'wp_body_open' ) && version_compare( get_bloginfo( 'version' ), '5.2', '>=' );

			// admin hooks
			add_action( 'admin_init', [ $this, 'plugin_settings' ]  );
			add_action( 'admin_enqueue_scripts', [ $this, 'wpCodeScripts' ]  );
			add_action( 'admin_menu', [ $this, 'WPCodeMenu' ]  );
			add_action( 'admin_notices', [ $this, 'WPCodeNotices' ]  );
			add_action( 'wp_ajax_' . $this->plugin->name . '_dismiss_wpCode_notices', [ $this, 'dismisWPCodeNotices' ]  );

			// front-end Hooks and filters
			add_action( 'wp_head', [ $this, 'ScriptsInHeader' ], $this->header_priority  );
			add_action( 'wp_footer', [ $this, 'ScriptsInFooter' ], $this->footer_priority  );

			if (  $this->body_open_supported  ) {
				add_action( 'wp_body_open', [ $this, 'ScriptsInBody' ], 1  );
			}
		}

		// callbacks for action and filters using into plugin
		function plugin_settings(){
		}

		//

		function wpCodeScripts(){
			$ver 		= $this->debug_mode ? time() : $this->plugin->version;
			$cssFile 	= $_REQUEST[ 'page' ] != 'wp-code' ? 'banner' : 'wp-code';
			wp_enqueue_style( $cssFile, $this->plugin->assets.'/'.$cssFile.'.css', [  ], $ver,'all' );
			wp_enqueue_script( 'wp-js', $this->plugin->assets.'/wp-code.js', [ 'jquery' ], $ver, 1 );
		}

		// function adding to menu
		function WPCodeMenu(){
			add_menu_page( $this->plugin->displayName, $this->plugin->displayName, 'manage_options', $this->plugin->name, [ $this, 'wpCodeMenuCallback' ], "dashicons-align-wide", 75 );
		}

		// callback for admin add_menu_page
		function wpCodeMenuCallback(){

		}
		// adding admin notices regarding to plugin
		function WPCodeNotices(){
			// no banner if the someone close it
			if(  $this->promotion_disabled  ) return;
			require_once $this->plugin->path.'inc/notification.php';
		}
		// dismiss admin notices callback
		function dismisWPCodeNotices(){
			if(  !check_ajax_referer( 'close-promotion', 'nonce' )  ) return;
			set_transient( 'wp_promotion_disabled', true );
			wp_die(  );
		}

		// adding code to header
		function ScriptsInHeader(){

		}

		// function to add code to footer
		function ScriptsInFooter(){

		}
		// function to add code into body tag
		function ScriptsInBody(){

		}
	}
}
$wpCode = new WPCODE();
