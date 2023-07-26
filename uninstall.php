<?php

defined('ABSPATH') OR die();

if (!defined('WP_UNINSTALL_PLUGIN')) 
{
    exit;
}

global $wpdb;
$table_name = $wpdb->prefix . 'user_post';
$wpdb->query( "DROP TABLE IF EXISTS $table_name" );

$custom_post_type = 'userpost';

$post_ids = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_type = %s", $custom_post_type));

foreach ($post_ids as $post_id) 
{
    delete_post_meta($post_id, 'name');
}

$wpdb->delete($wpdb->posts, array('post_type' => $custom_post_type), array('%s'));


