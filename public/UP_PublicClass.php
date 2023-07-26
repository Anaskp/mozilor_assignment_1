<?php

defined('ABSPATH') OR die();

if(! class_exists('UP_PublicClass'))
{

    /**
     * To deal with hooks in public 
     */
    class UP_PublicClass
    {

        /**
         * trigger all add_action and add_filter required in public
         * @return void
         */
        public function init()
        {
            add_shortcode('UP_add_post',array($this, 'renderAuthLogin'));
            add_action('wp_enqueue_scripts', array($this,'enqueue_script'));
            add_action('wp_ajax_auth_submission', array($this, 'process_auth_submission'));
            add_action('wp_ajax_nopriv_auth_submission', array($this, 'process_auth_submission'));
            add_action('wp_ajax_post_submission', array($this, 'post_submission'));
            add_action('wp_ajax_nopriv_post_submission', array($this, 'post_submission'));
        }

        /**
         * Add script file to public enable ajax
         * @return void
         */
        public function enqueue_script()
        {
            wp_enqueue_script( 'public-script', plugins_url() . '/user-post/public/js/scripts.js', array('jquery') );
            wp_localize_script( 'public-script', 'public_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

        }

        /**
         * Insert user details name and email to database wp_userpost
         * if email exists in database update name else add name and email
         * @return void
         */
        public function process_auth_submission()
        {    
              
            check_ajax_referer( 'userpost_auth_nonce_action', 'nonce' );

            global $wpdb;

            $table_name = $wpdb->prefix . 'user_post';
        
            $name = sanitize_text_field($_POST['name']);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

            $sql = "SELECT * 
                    FROM $table_name
                    WHERE  user_email = '$email'";

            $result = $wpdb->get_row($wpdb->prepare($sql));

            if(!$result)
            {
                $wpdb->insert($table_name, 
                array('user_name' => $name, 
                'user_email' => $email
                ));
            }else
            {
                $sql = "SELECT id 
                    FROM $table_name
                    WHERE  user_email = '$email'";

                $result = $wpdb->get_row($wpdb->prepare($sql));
                $wpdb->update($table_name,array('user_name' => $name),array( 'id' => $result->id ));
            }
            echo 'success';
        }

        /**
         * Show form to front panel via short codes
         * @return bool|string
         */
        public function renderAuthLogin()
        {
            ob_start();
            include UP_MY_PLUGIN_PATH . 'public/templates/login-form.php';
            return ob_get_clean();
        }

        /**
         * Add user crated post title and content to created custom post type userpost
         * update post meta to get posted user name
         * @return void
         */
        public function post_submission()
        {
            check_ajax_referer( 'userpost_post_nonce_action', 'nonce' );

            $title = sanitize_text_field($_POST['title']);
            $content = sanitize_textarea_field($_POST['content']);
            $name = sanitize_text_field($_POST['username']);

            $post_data = array(
                'post_title' => $title ,
                'post_content' => $content . '<br>'. __('Author','userpost') .' : ' . $name ,
                'post_status' => 'publish',
                'post_type' => 'userpost', 
            );

            $post_id = wp_insert_post($post_data);
            

            if (!is_wp_error($post_id)) 
            {
                update_post_meta($post_id, 'name', $name);
                echo 'success';
            } else {
                echo 'error';
            }

            wp_die();
        }
    }
}

$up_public = new UP_PublicClass();
$up_public->init();
