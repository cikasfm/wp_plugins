<?php
/*
    Plugin Name: Simple Javascript Countdown
    Plugin URI: http://blog.vilutis.lt/plugins/countdown-widget
    Description: Simple Javascript Countdown Widget
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

class SimpleJavascriptCountdown extends WP_Widget {
	
	function SimpleJavascriptCountdown() {
		parent::WP_Widget( false, 'Simple Javascript Countdown' );
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		$title = $instance['title'];
		
		$javascript = $this->makeJavascript( $instance['id'], $instance['year'], $instance['month'], $instance['day'], $instance['hour'], $instance['minute'], $instance['second'] );

		echo
		$before_widget,
		$before_title, $title, $after_title,
		$javascript,
		$after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		
		$instance['year'] = strip_tags( $new_instance['year'] );
		$instance['month'] = strip_tags( $new_instance['month'] );
		$instance['day'] = strip_tags( $new_instance['day'] );
		$instance['hour'] = strip_tags( $new_instance['hour'] );
		$instance['minute'] = strip_tags( $new_instance['minute'] );
		$instance['second'] = strip_tags( $new_instance['second'] );
		
		$instance['id'] = intval(microtime(true));
		
		return $instance;
	}
	
	function form( $instance ) {
		if ( $instance ) {
			$title = esc_attr( $instance[ 'title' ] );
			
			$year = esc_attr( $instance['year'] );
			$month = esc_attr( $instance['month'] );
			$day = esc_attr( $instance['day'] );
			$hour = esc_attr( $instance['hour'] );
			$minute = esc_attr( $instance['minute'] );
			$second = esc_attr( $instance['second'] );
		}
		else {
			$title = __( 'Countdown', 'simple-javascript-countdown' );
			
			$year = 2012;
			$month = 2;
			$day = 11;
			$hour = 18;
			$minute = 0;
			$second = 0;
		}
		
		$instance = wp_parse_args( ( array )$instance, $defaults );
		
		$this->makeInput( 'title', $title );
		$this->makeInput( 'year', $year );
		$this->makeInput( 'month', $month );
		$this->makeInput( 'day', $day );
		$this->makeInput( 'hour', $hour );
		$this->makeInput( 'minute', $minute );
		$this->makeInput( 'second', $second );
	}
	
	function makeInput( $fieldName, $value ) {
		$fieldTitle = ucfirst(strtolower($fieldName));
		?>
		<p>
		<label for="<?php echo $this->get_field_id($fieldName); ?>"><?php _e($fieldTitle . ':'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id($fieldName); ?>" name="<?php echo $this->get_field_name($fieldName); ?>" type="text" value="<?php echo $value; ?>" />
		</p>
		<?php
	}
	
	function makeJavascript( $id, $year = 2012, $month = 1, $day = 11, $hour = 18, $minute = 0, $second = 0 ) {
		$instanceName = "counter_" . $id;
		?>
<script language="JavaScript">
	<!--
	var year = <?php echo $year; ?>;			// in what year will your target be reached?
	var month = <?php echo $month - 1; ?>;				// value between 0 and 11 (0=january,1=february,...,11=december)
	var day = <?php echo $day; ?>;				// between 1 and 31
	var hour = <?php echo $hour; ?>;				// between 0 and 24
	var minute = <?php echo $minute; ?>;			// between 0 and 60
	var second = <?php echo $second; ?>;			// between 0 and 60
	var eventtext = "until the next big thing"; // text that appears next to the time left
	var endtext = "We reached the next big thing!!"; // text that appears when the target has been reached
	var end = new Date(year,month,day,hour,minute,second);
	function <?php echo $instanceName; ?>(){
	    var now = new Date();
	    if(now.getYear() < 1900)
	        yr = now.getYear() + 1900;
	    var sec = second - now.getSeconds();
	    var min = minute - now.getMinutes();
	    var hr = hour - now.getHours();
	    var dy = day - now.getDate();
	    var mnth = month - now.getMonth();
	    var yr = year - yr;
	    var daysinmnth = 32 - new Date(now.getYear(),now.getMonth(), 32).getDate();
	    if(sec < 0){
	        sec = (sec+60)%60;
	        min--;
	    }
	    if(min < 0){
	        min = (min+60)%60;
	        hr--;	
	    }
	    if(hr < 0){
	        hr = (hr+24)%24;
	        dy--;	
	    }
	    if(dy < 0){
	        dy = (dy+daysinmnth)%daysinmnth;
	        mnth--;	
	    }
	    if(mnth < 0){
	        mnth = (mnth+12)%12;
	        yr--;
	    }	
	    var sectext = " sek.";
	    var mintext = " min ";
	    var hrtext = " val., ";
	    var dytext = " d., ";
	    var mnthtext = " men, ";
	    var yrtext = " years, ";
	    if (yr == 1)
	        yrtext = " year, ";
	    if (mnth == 1)
	        mnthtext = " mėnuo, ";
	    if (dy == 1)
	        dytext = " diena, ";
	    if (hr == 1)
	        hrtext = " valanda, ";
	    if (min == 1)
	        mintext = " minute, ";
	    if (sec == 1)
	        sectext = " sekunde ";
	    if(now >= end){
	        document.getElementById("timeleft").innerHTML = endtext;
	        clearTimeout(timerID);
	    }
	    else{
		    var text = '';
		    if ( yr > 0 ) text += yr + yrtext;
		    if ( mnth > 0 ) text += mnth + mnthtext;
		    if ( dy > 0 ) text += dy + dytext;
		    if ( hr > 0 ) text += hr + hrtext;
		    if ( min > 0 ) text += min + mintext;
		    if ( sec > 0 ) text += sec + sectext;
			    
		    document.getElementById("<?php echo $instanceName; ?>").innerHTML = text;
		    //document.getElementById("<?php echo $instanceName; ?>").innerHTML = mnth + mnthtext + dy + dytext + hr + hrtext + min + mintext + sec + sectext;
	    }
	    timerID = setTimeout("<?php echo $instanceName . "()"; ?>", 1000); 
	}
	window.onload = <?php echo $instanceName; ?>;
	//-->
	</script>
<span id="<?php echo $instanceName; ?>"></span>
<?php
	}
	
}

function SimpleJavascriptCountdown_register_widgets() {
	register_widget( 'SimpleJavascriptCountdown' );
}

add_action( 'widgets_init', 'SimpleJavascriptCountdown_register_widgets' );

?>