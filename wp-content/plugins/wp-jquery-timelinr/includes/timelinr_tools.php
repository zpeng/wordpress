<?php

/**
 * Backend Class for use in all Yoast plugins
 * Version 0.2
 */

if (!class_exists('Broobe_TL_Plugin_Admin')) {
	class Broobe_TL_Plugin_Admin {
		
		var $optionname = 'timelinr_options';
		
		function Broobe_TL_Plugin_Admin() {
		}	
		
		/**
		 * Create a Checkbox input field
		 */
		function checkbox($id) {
			$options = get_option( $this->optionname );
			$checked = false;
			if ( isset($options[$id]) && $options[$id] == 1 )
				$checked = true;
			return '<input type="checkbox" id="'.$id.'" name="'.$id.'"'. checked($checked,true,false).'/>';
		}

		/**
		 * Create a Text input field
		 */
		function textinput($id) {
			$options = get_option( $this->optionname );
			$val = '';
			if ( isset( $options[$id] ) )
				$val = $options[$id];
			return '<input class="text" type="text" id="'.$id.'" name="'.$id.'" size="30" value="'.$val.'"/>';
		}

		/**
		 * Create a dropdown field
		 */
		function select($id, $options, $multiple = false) {
			$opt = get_option($this->optionname);
			$output = '<select class="select" name="'.$id.'" id="'.$id.'">';
			foreach ($options as $val => $name) {
				$sel = '';
				if ($opt[$id] == $val)
					$sel = ' selected="selected"';
				if ($name == '')
					$name = $val;
				$output .= '<option value="'.$val.'"'.$sel.'>'.$name.'</option>';
			}
			$output .= '</select>';
			return $output;
		}
		
		/**
		 * Create a potbox widget
		 */
		function postbox($id, $title, $content) {
		?>
			<div id="<?php echo $id; ?>" class="postbox">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3 class="hndle"><span><?php echo $title; ?></span></h3>
				<div class="inside">
					<?php echo $content; ?>
				</div>
			</div>
		<?php
		}	


		/**
		 * Create a form table from an array of rows
		 */
		function form_table($rows) {
			$content = '<table class="form-table">';
			$i = 1;
			foreach ($rows as $row) {
				$class = '';
				if ($i > 1) {
					$class .= 'yst_row';
				}
				if ($i % 2 == 0) {
					$class .= ' even';
				}
				$content .= '<tr id="'.$row['id'].'_row" class="'.$class.'"><th valign="top" scrope="row">';
				if (isset($row['id']) && $row['id'] != '')
					$content .= '<label for="'.$row['id'].'">'.$row['label'].':</label>';
				else
					$content .= $row['label'];
				$content .= '</th><td valign="top">';
				$content .= $row['content'];
				$content .= '</td></tr>'; 
				if ( isset($row['desc']) && !empty($row['desc']) ) {
					$content .= '<tr class="'.$class.'"><td colspan="2" class="yst_desc"><small>'.$row['desc'].'</small></td></tr>';
				}
					
				$i++;
			}
			$content .= '</table>';
			return $content;
		}

		/**
		 * Create a "plugin like" box.
		 */
		function plugin_like($hook = '') {
			if (empty($hook)) {
				$hook = $this->hook;
			}
			$content = '<p>'.__('Why not do any or all of the following:', 'gawp_yoast' ).'</p>';
			$content .= '<ul>';
			$content .= '<li><a href="'.$this->homepage.'">'.__('Link to it so other folks can find out about it.', 'gawp_yoast' ).'</a></li>';
			$content .= '<li><a href="http://wordpress.org/extend/plugins/'.$hook.'/">'.__('Give it a 5 star rating on WordPress.org.', 'gawp_yoast' ).'</a></li>';
			$content .= '<li><a href="http://wordpress.org/extend/plugins/'.$hook.'/">'.__('Let other people know that it works with your WordPress setup.', 'gawp_yoast' ).'</a></li>';
			$content .= '</ul>';
			$this->postbox($hook.'like', __( 'Like this plugin?', 'gawp_yoast' ), $content);
		}	
		
		/**
		 * Info box with link to the bug tracker.
		 */
		function plugin_support($hook = '') {
			if (empty($hook)) {
				$hook = $this->hook;
			}
			$content = '<p>'.sprintf( __( 'If you\'ve found a bug in this plugin, please submit it in the <a href="%s">Yoast Bug Tracker</a> with a clear description.', 'gawp_yoast' ), 'http://yoast.com/bugs/google-analytics/').'</p>';
			$this->postbox($this->hook.'support', __('Found a bug?', 'gawp_yoast' ), $content);
		}


		function text_limit( $text, $limit, $finish = ' [&hellip;]') {
			if( strlen( $text ) > $limit ) {
		    	$text = substr( $text, 0, $limit );
				$text = substr( $text, 0, - ( strlen( strrchr( $text,' ') ) ) );
				$text .= $finish;
			}
			return $text;
		}
		
		function get_date_format( $date, $format) {
			$timelineDate = explode("-", $date);
			
			if ($format == 'yy') {
				return $timelineDate[0];
			} elseif ($format == 'yy/mm') {
				return $timelineDate[0]."/".$timelineDate[1];
			} elseif ($format == 'mm/yy') {
				return $timelineDate[1]."/".$timelineDate[0];
			} else  {
				return "";
			}
			
		}

	}
}