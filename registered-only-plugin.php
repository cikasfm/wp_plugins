<?php
/*
    Plugin Name: Registered Users Only Plugin
    Plugin URI: http://zilvinas.vilutis.lt/plugins/registered-only-plugin
    Description: Activate this plugin to restrict access to your entire weblog to logged in, registered users of the weblog.
    Author: Zilvinas Vilutis
    Version: 0.1
    Author URI: http://zilvinas.vilutis.lt
    
    
    
    Copyright 2012  Zilvinas Vilutis  ( email : zilvinas at vilutis dot lt )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.
    
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * WP HOOKS
 **/
add_action('init', 'registered_users_only');
/**
 * END WP HOOKS
 **/

function registered_users_only() {
    $login_url = "/wp-login.php";
    if ( !is_user_logged_in() && substr( $_SERVER['PHP_SELF'], 0, strlen( $login_url ) ) != $login_url ) {
        auth_redirect();
    }
}
?>