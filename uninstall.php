<?php

//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
    exit();

global $wpdb;

$wpdb->query("DELETE FROM wp_options WHERE option_name LIKE '%callcap_%'");

?>
