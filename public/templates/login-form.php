<?php

defined('ABSPATH') OR die();

?>

<form id="login-form" >
    <label><?php _e('Name: ','userpost') ?><input type="text" name="name" id="name-id" required></label><br><br>
    <label><?php _e('Email: ','userpost') ?><input type="email" name="email" id="email-id" required></label><br><br>
    <?php wp_nonce_field('userpost_auth_nonce_action', 'userpost_auth_nonce'); ?>
    <button type="submit"><?php _e('Log In','userpost') ?></button>
</form>

<span id="result"></span>
<form id="add-post-form" hidden>
    <label><?php _e('Title: ','userpost') ?><input type="text" name="title" id="title-id" required></label><br><br>
    <label><?php _e('Content: ','userpost') ?><textarea name="content" id="content-id" cols="30" rows="10" required></textarea></label><br><br>
    <?php wp_nonce_field('userpost_post_nonce_action', 'userpost_post_nonce'); ?>
    <button type="submit"><?php _e('Submit','userpost') ?></button>
</form><br><br>

<div hidden id="button-div">
    <button type="submit" id="add-more"><?php _e('Add more post','userpost') ?></button>
    <a href="/wordpress"><button type="submit" id="red-home"><?php _e('Go to home page','userpost') ?></button></a>
</div>


