<?php
/*
    Plugin Name: Restrict Email Plugin
    Plugin URI: http://blog.vilutis.lt/plugins/restrict-email-plugin
    Description: Plugin to restrict users registration with a specific email domain
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
add_action('register_post','validate_email_domain',10,3);
/**
 * END WP HOOKS
 **/

function validate_email_domain( $login, $email, $errors ){
	
	$email_valid = is_email( $email );
	
	$valid_domains = array(		// refactor this to be configured
			"exigenservices.com",
			"exigeninsurance.com",
			"exigengroup.com" );
	
	if ( $email_valid ) {
	    $email_valid = false;
		list( $name, $domain ) = explode( '@', $email, 2 );
		
		if ( strtolower($name) != strtolower($login) ) {
		    $errors->add( 'username_error', __( '- Your username must match the left part of the email address, e.g. if your email address is \'firstname.lastname@domain.com\' then your username must be \'firstname.lastname\'' ) );
		}
		
		foreach ( $valid_domains as $valid_domain ) {
			if ( $valid_domain == strtolower( $domain ) ) {
				$email_valid = true;
				break;
			}
		}
	}
	
	if ( !$email_valid ) {
		$errors->add( 'domain_error', __( '- Only Exigen employees with work e-mail address can register' ) );
	}
}

?>