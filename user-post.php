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
