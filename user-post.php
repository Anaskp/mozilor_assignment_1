<?php

/**
 * Plugin Name: User Post
 * Plugin URI:  https://user_post.com
 * Author:      Anas
 * Author URI:  https://user_post.com
 * Description: Your users can share article
 * Version:     1.0.0
 * License:     GPL-2.0+
 * text-domain: userpost
 * Domain Path: /languages
*/

/*
Page visitors can share some content. Visitors details such as name and email store in custom database named wp_user_post. The visitors can share title and content and it will store in wordpress table posts under post type userpost. The admin can see these details in admin and can delete also.
*/


defined('ABSPATH') OR die();

if(! class_exists('UserPost'))
{

	/**
	 * Initialisation of the plugin
	 */
    class UserPost
    {
		/**
		 * Instance variable for UserPost
		 * @var 
		 */
        private static $instance = null;

		
		/**
		 * UserPost constructor
		 */
		private function __construct() 
        {
			$this->initializeHooks();
			$this->setupDatabase();
			define('UP_MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ));
			add_action('init',array($this,'setupTranslation'));
			
		}

		/**
		 * Setting Userpost instance
		 * @return mixed
		 */
		public static function getInstance() 
        {
			if ( is_null( self::$instance ) ) 
            {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * To load language folder for translation 
		 * @return void
		 */
		public function setupTranslation(){
			load_theme_textdomain('userpost',plugins_url(). '/user-post/languages');
		}

		/**
		 * To activate admin class only if admin and always public class
		 * @return void
		 */
		private function initializeHooks() 
        {
			if ( is_admin() ) 
            {
				require_once( 'admin/UP_AdminClass.php' );
			}
			require_once( 'public/UP_PublicClass.php' );
		}

		/**
		 * Create database while activating plugin
		 * @return void
		 */
		private function setupDatabase() 
		{
			require_once( 'admin/UserDatabase.php' );

			register_activation_hook( __FILE__, array( 'UserDatabase', 'setUp' ) );
		}
    }
}

UserPost::getInstance();


// //not belong to user post
// add_action('admin_enqueue_scripts', 'enqueue_script');
//  function enqueue_script(){
// 	wp_enqueue_script( 'admin-script', plugins_url() . '/user-post/admin/js/scripts.js', array('jquery') );
// 	wp_localize_script( 'admin-script', 'public_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
// }

// // creating tab 'Settings Demo Tab' in woocommerce settings

// function add_settings_tab( $settings_tabs ) {
// 	$settings_tabs['test'] = __( 'Settings Demo Tab', 'userpost' );
// 	return $settings_tabs;
// }
 
// add_filter( 'woocommerce_settings_tabs_array', 'add_settings_tab',21 );

// // creating section in newly created tab

// function add_settings_fields() {
//     woocommerce_admin_fields( array(
//         array(
//             'title' => __( 'Settings Demo Tab', 'userpost' ),
//             'type'  => 'title',
//             'desc'  => '',
//             'id'    => 'test'
//         ),
//         array(
//             'title'    => __( 'Input Field', 'userpost' ),
//             'desc'     => __( 'This is an input field.', 'userpost' ),
//             'id'       => 'test_input_field',
//             'type'     => 'text',
//             'css'      => 'min-width:300px;',
//             'default'  => '',
//             'desc_tip' => true,
//         ),
//         array(
//             'type' => 'sectionend',
//             'id'   => 'test'
//         )
//     ) );
// }
// add_action( 'woocommerce_settings_tabs_test', 'add_settings_fields' );

// function save_settings_fields() {
//     woocommerce_update_options( array(
//         array(
//             'title'    => __( 'Input Field', 'userpost' ),
//             'desc'     => __( 'This is an input field.', 'userpost' ),
//             'id'       => 'test_input_field',
//             'type'     => 'text',
//             'css'      => 'min-width:300px;',
//             'default'  => '',
//             'desc_tip' => true,
//         )
//     ) );
// }
// add_action( 'woocommerce_update_options_test', 'save_settings_fields' );

// //----------------------
// //creating section under products tab

// add_filter( 'woocommerce_get_sections_products', 'wcslider_add_section' );
// function wcslider_add_section( $sections ) {
	
// 	$sections['wcslider'] = __( 'WC Slider', 'userpost' );
// 	return $sections;
	
// }

// //adding fields in section created before
// add_filter( 'woocommerce_get_settings_products' , 'freeship_get_settings' , 10, 2 );

// function freeship_get_settings( $settings, $current_section ) {
//          $custom_settings = array();
//          if( 'wcslider' == $current_section ) {

//               $custom_settings =  array(

// 					array(
// 					        'name' => __( 'WC Slider' ),
// 					        'type' => 'title',
// 					        'desc' => __( 'WC Slider description' ),
// 					        'id'   => 'free_shipping' 
// 					),

// 					   array(
// 						'name' => __( 'Enable Free shipping notices' ),
// 						'type' => 'checkbox',
// 						'desc' => __( 'Show the free shipping threshold on product page'),
// 						'id'	=> 'enable'
		
// 					),
		
// 					array(
// 						'name' => __( 'Message' ),
// 						'type' => 'text',
// 						'desc' => __( 'Message to display on the notice'),
// 						'desc_tip' => true,
// 						'id'	=> 'msg_threshold'
		
// 					),
		
// 					array(
// 						'name' => __( 'Message when free shipping reached' ),
// 						'type' => 'text',
// 						'desc' => __( 'Message to display when free shipping is reached'),
// 						'desc_tip' => true,
// 						'id'	=> 'msg_free'
		
// 					),
		
// 					array(
// 						'name' => __( 'Position' ),
// 						'type' => 'select',
// 						'desc' => __( 'Position of the notice on the product page'),
// 						'desc_tip' => true,
// 						'id'	=> 'position',
// 						'options' => array(
		
// 								  'top' => __( 'Top' ),
// 								  'bottom' => __('Bottom')
		
// 						)
		
// 					),
					
// 					array(
// 						'name' => __( 'Text Color' ),
// 						'type' => 'color',
// 						'desc' => __( 'Color of the text in the notice'),
// 						'desc_tip' => true,
// 						'id'	=> 'color',
		
// 					),
		
// 					 array( 'type' => 'sectionend', 'id' => 'free_shipping' ),

// 		);

// 	       return $custom_settings;
//        } else {
//         	return $settings;
//        }

// }

// // direct checkout

// function buy_now_button() {
//     global $product;
//     $link = $product->add_to_cart_url();
//     $link = add_query_arg( 'buy_now', 'true', $link );
//     echo '<a href="' . esc_url( $link ) . '" class="single_add_to_cart_button button alt">Buy Now</a>';
// }
// add_action( 'woocommerce_after_add_to_cart_button', 'buy_now_button' );

// function buy_now_redirect( $url ) {
//     if ( isset( $_REQUEST['buy_now'] ) && $_REQUEST['buy_now'] == 'true' ) {
//         global $woocommerce;
//         $checkout_url = wc_get_checkout_url();
//         return $checkout_url;
//     } else {
//         return $url;
//     }
// }
// add_filter( 'woocommerce_add_to_cart_redirect', 'buy_now_redirect' );




