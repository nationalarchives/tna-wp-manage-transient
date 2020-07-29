<?php
/**
 * Plugin Name: TNA WP Manage Transient
 * Plugin URI: https://github.com/nationalarchives/tna-wp-manage-transient
 * Description: The National Archives plugin.
 * Version: 1.0
 * Author: Chris Bishop
 * Author URI: https://github.com/nationalarchives
 * License: GPL2
 */

/* Included functions */
include 'transient-admin.php';

if ( is_admin() ){
    add_action( 'admin_menu', 'tna_transient_add_menu_item' );
}


