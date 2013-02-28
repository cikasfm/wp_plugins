<?php
/*
    Plugin Name: List Pages Plugin
    Plugin URI: http://blog.vilutis.lt/plugins/list-pages-plugin
    Description: This plugin would check for empty content page and create list of links all children automatically
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

function listPagesFilterContent( $the_content ) {
	if ( strlen( trim( $the_content ) ) == 0 ) {
		$lp_post = $GLOBALS['post'];
		$args = array( 'child_of' => $lp_post->ID );
		wp_list_pages( $args );
	}
	return $the_content;
}

add_filter( 'the_content', 'listPagesFilterContent' );

?>