<?php
/*
    Plugin Name: Google Translate Toolbar Widget
    Plugin URI: http://blog.vilutis.lt/plugins/google-translate-toolbar-widget
    Description: Google Translate Toolbar Widget based on http://translate.google.com/translate_tools
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

class GoogleTranslateToolbar extends WP_Widget {
	
	function GoogleTranslateToolbar() {
		parent::WP_Widget( false, 'Google Translate Toolbar' );
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		$title = $instance['title'];
		$text = html_entity_decode( $instance['text'] );

		echo
		$before_widget,
		$before_title, $title, $after_title,
		$text,
		$after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['text'] = htmlentities( $new_instance['text'] );
		return $instance;
	}
	
	function form( $instance ) {
		if ( $instance ) {
			$title = esc_attr( $instance[ 'title' ] );
		}
		else {
			$title = __( 'Google Translate', 'google-translate-toolbar' );
		}
		
		$instance = wp_parse_args( ( array )$instance, $defaults );
		?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e('Insert HTML code from http://translate.google.com/translate_tools below.', 'google-translate-toolbar'); ?></label>
		<textarea id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" rows="10" cols="16" class="widefat"><?php echo $instance['text']; ?></textarea>
		</p>
		<?php
	}
	
}

function GoogleTranslateToolbar_register_widgets() {
	register_widget( 'GoogleTranslateToolbar' );
}

add_action( 'widgets_init', 'GoogleTranslateToolbar_register_widgets' );

?>