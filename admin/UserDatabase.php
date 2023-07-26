<?php

defined('ABSPATH') OR die();

if(!class_exists('UserDatabase'))
{

    /**
     * Class to create database
     */
    class UserDatabase
    {
        /**
         * Create database name wp_user_post with columns id, username and enmail
         * @return void
         */
        public static function setUp(){
            global $wpdb;
    
            $table_name = $wpdb->prefix . 'user_post';
            $charset_collate = $wpdb->get_charset_collate();
    
            $sql= "CREATE TABLE $table_name (
                   id int(11) NOT NULL AUTO_INCREMENT ,
                   user_name text NOT NULL,
                   user_email text NOT NULL,
                   PRIMARY KEY (id)
            ) $charset_collate";
    
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);  
        }
    }
}