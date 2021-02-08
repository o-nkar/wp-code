<?php
/**
 * Plugin Name:       WP Code
 * Plugin URI:
 * Description:       add CSS/JavaScript code to WP header/footer/body of WordPress frontend easily.
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
 if ( ! defined( 'ABSPATH' ) ){
	exit;
 }

 /**
* WPCODE Main Class
*/
 if( !class_exists('WPCODE') ){

	class WPCODE{
	/**
	* Constructor
	*/
		public function __construct() {
			$WPC_data = get_file_data( __FILE__, [ 'Version' => 'Version' ] );
			// plugin data
			$this->plugin                           = new stdClass;
			$this->plugin->name                  	= 'wp-code';
			$this->plugin->displayName              = 'WP Code';
			$this->plugin->version                  = $WPC_data['Version'];
			$this->plugin->path                     = plugin_dir_path( __FILE__ );
			$this->plugin->url                      = plugin_dir_url( __FILE__ );
			$this->body_open_supported              = function_exists( 'wp_body_open' ) && version_compare( get_bloginfo( 'version' ), '5.2', '>=' );

			// admin hooks
			add_action(
				'admin_init',
				[ $this, 'plugin_settings' ]
			);

			add_action(
				'admin_enqueue_scripts',
				[ $this, 'wpCodeScripts' ]
			);

			add_action(
				'admin_menu',
				[ $this, 'WPCodeMenu' ]
			);

			add_action(
				'admin_notices',
				[ $this, 'WPCodeNotices' ]
			);

			add_action(
				'wp_ajax_' . $this->plugin->name . '_dismiss_wpCode_notices',
				[ $this, 'dismisWPCodeNotices' ]
			);

			// frontend Hooks and filters
			add_action(
				'wp_head',
				[ $this, 'ScriptsInHeader' ],
				get_option( 'header_priority', 10 )
			);

			add_action(
				'wp_footer',
				[ $this, 'ScriptsInFooter' ],
				get_option( 'footer_priority', 10 )
			);

			if ( $this->body_open_supported ) {
				add_action(
					'wp_body_open',
					[ $this, 'ScriptsInBody' ],
					1
				);
			}
		}
		
		// make plugin settings
		function plugin_settings(){
			
		}
		
		// 
		function wpCodeScripts(){
			
		}
		
		// function adding to menu
		function WPCodeMenu(){
			
		}
		
		// adding admin notices regarding to plugin
		function WPCodeNotices(){
			
		}
		// dismiss admin notices callback
		function dismisWPCodeNotices(){
			
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
 
