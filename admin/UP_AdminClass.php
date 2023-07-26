<?php

defined('ABSPATH') OR die();

if(! class_exists('UP_AdminClass'))
{

    /**
     * To deal with hooks in admin panel
     */
    class UP_AdminClass
    {
        /**
         * trigger all add_action and add_filter required in admin panel
         * @return void
         */
        public function init()
        {
            add_action('init' , array($this,'create_custom_post_page'));
            add_action('admin_menu', array( $this, 'user_post_sub_menu' ) );
            add_action('admin_enqueue_scripts', array($this,'enqueue_script'));
            add_filter('manage_userpost_posts_columns', array($this,'manage_userpost_column'));
            add_action('manage_userpost_posts_custom_column', array($this, 'fill_userpost_column'),10,2);
            add_action('wp_ajax_delete_user', array($this, 'delete_user'));
            add_action('wp_ajax_delete_post', array($this, 'delete_post'));
        }

        
        /**
         * Add script file to admin panel enable ajax
         * @return void
         */
        public function enqueue_script(){
            wp_enqueue_script( 'admin-script', plugins_url() . '/user-post/admin/js/scripts.js', array('jquery') );
            wp_localize_script( 'admin-script', 'public_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
        }

        /**
         * Delete post from wp_posts table
         * @return void
         */
        public function delete_post()
        {
            global $wpdb;
            $post_id = $_POST['userId'];
            delete_post_meta($post_id, 'name');
            $wpdb->delete($wpdb->posts,array('id' => $post_id));

            echo 'success';
        }

        /**
         * Delete user from database
         * @return void
         */
        public function delete_user(){
            global $wpdb;
            $table_name = $wpdb->prefix . 'user_post';
            $id = $_POST['userId'];
            $wpdb->delete( $table_name, array( 'id' => $id ) );
            echo 'success';
        }
        

        /**
         * To fill custom post meta to columns
         * @param array $column
         * @param int $post_id
         * @return void
         */
        public function fill_userpost_column($column, $post_id){
            switch($column){
                case 'title' :
                    echo esc_html(get_the_title($post_id));
                    break;
                case 'name' :
                    echo esc_html(get_post_meta($post_id,'name',true));
                    break;
                case 'delete' :
                    echo '<button id="'. $post_id .'" class="delete-post">'. __('Delete','userpost') .'</button>';
                    break;
                case 'content' :
                    {
                        $length = 21;
                        $content = get_post_field('post_content', $post_id);
                        $trimmed_content = wp_trim_words($content, $length);
                        echo esc_html($trimmed_content);
                break;
                    }
            }
        }

        /**
         * To add custom fields to userpost post columns
         * @param mixed $columns
         * @return array
         */
        public function manage_userpost_column($columns){
            unset($columns['date']);

            $columns['title'] = __('Title', 'userpost');
            $columns['content'] = __('Content', 'userpost');
            $columns['name'] = __('Author', 'userpost');
            $columns['delete'] = __('Delete', 'userpost');

            
            return $columns;
        }

        /**
         * To create custom post type name user post
         * @return void
         */
        public function create_custom_post_page(){

            $args = array(
                'public' => true,
                'has_archive' => true,
                'menu_position' => 81,
                'publicly_queryable' => true,
                'show_in_menu' => true,
                'supports' => array('title', 'editor','thumbnail'),
                'labels' => [
                    'name' => __('User posts','userpost'),
                    'singular_name' => __('User post','userpost'),
                    'edit_item' => __('View User Posts','userpost'),
                ],
                'rewrite'     => array( 'slug' => 'userpost' ),
            );
        
            register_post_type('userpost', $args);

        }

        /**
         * To add a sub menu page under userpost custom post page named User Datails
         * @return void
         */
        public function user_post_sub_menu(){
            add_submenu_page( 'edit.php?post_type=userpost',
				__('User Details','userpost'),
				__('User Details','userpost'),
				'administrator',
				'user_details',
				array( $this, 'render_sub_menu' ) );
        }

        /**
         * Fetch User details from database to User Details SubMenu
         * @return void
         */
        public function render_sub_menu(){
            global $wpdb;
            $table_name = $wpdb->prefix . 'user_post';
            $results = $wpdb->get_results("SELECT * FROM $table_name");
            ?>
            <div class="wrap">
                <h1><?php __('User Details','userpost') ?></h1>
                <table class="wp-list-table widefat fixed striped" id="up-user-id">
                    <thead>
                        <tr>
                            <th><?php _e('ID','userpost') ?></th>
                            <th><?php _e('Name','userpost') ?></th>
                            <th><?php _e('Email','userpost') ?></th>
                            <th><?php _e('Delete User','userpost') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($results as $result) {
                            echo "<tr>";
                            echo '<td>' . $result->id . '</td>';
                            echo '<td>' . $result->user_name . '</td>';
                            echo '<td>' . $result->user_email . '</td>';
                            echo '<td><button id="'. $result->id .'" class="delete-user-btn delete-user">'. __('Delete','userpost') .'</button></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody> 
                    
                </table>
            </div>
            <?php
        }
    }
}

$up_adminclass= new UP_AdminClass();
$up_adminclass->init();