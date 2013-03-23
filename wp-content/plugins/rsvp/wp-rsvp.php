<?php
/**
 * @package rsvp
 * @author MDE Development, LLC
 * @version 1.6.5
 */
/*
Plugin Name: RSVP 
Text Domain: rsvp-plugin
Plugin URI: http://wordpress.org/extend/plugins/rsvp/
Description: This plugin allows guests to RSVP to an event.  It was made initially for weddings but could be used for other things.  
Author: MDE Development, LLC
Version: 1.6.5
Author URI: http://mde-dev.com
License: GPL
*/
#
# INSTALLATION: see readme.txt
#
# USAGE: Once the RSVP plugin has been installed, you can set the custom text 
#        via Settings -> RSVP Options in the  admin area. 
#      
#        To add, edit, delete and see rsvp status there will be a new RSVP admin
#        area just go there.
# 
#        To allow people to rsvp create a new page and add "rsvp-pluginhere" to the text

	session_start();
	define("ATTENDEES_TABLE", $wpdb->prefix."attendees");
	define("ASSOCIATED_ATTENDEES_TABLE", $wpdb->prefix."associatedAttendees");
	define("QUESTIONS_TABLE", $wpdb->prefix."rsvpCustomQuestions");
	define("QUESTION_TYPE_TABLE", $wpdb->prefix."rsvpQuestionTypes");
	define("ATTENDEE_ANSWERS", $wpdb->prefix."attendeeAnswers");
	define("QUESTION_ANSWERS_TABLE", $wpdb->prefix."rsvpCustomQuestionAnswers");
	define("QUESTION_ATTENDEES_TABLE", $wpdb->prefix."rsvpCustomQuestionAttendees");
	define("EDIT_SESSION_KEY", "RsvpEditAttendeeID");
	define("EDIT_QUESTION_KEY", "RsvpEditQuestionID");
	define("RSVP_FRONTEND_TEXT_CHECK", "rsvp-pluginhere");
	define("OPTION_GREETING", "rsvp_custom_greeting");
	define("OPTION_THANKYOU", "rsvp_custom_thankyou");
	define("OPTION_DEADLINE", "rsvp_deadline");
	define("OPTION_OPENDATE", 'rsvp_opendate');
	define("OPTION_YES_VERBIAGE", "rsvp_yes_verbiage");
	define("OPTION_NO_VERBIAGE", "rsvp_no_verbiage");
	define("OPTION_KIDS_MEAL_VERBIAGE", "rsvp_kids_meal_verbiage");
	define("OPTION_VEGGIE_MEAL_VERBIAGE", "rsvp_veggie_meal_verbiage");
	define("OPTION_NOTE_VERBIAGE", "rsvp_note_verbiage");
  define("RSVP_OPTION_HIDE_NOTE", "rsvp_hide_note_field");
	define("OPTION_HIDE_VEGGIE", "rsvp_hide_veggie");
	define("OPTION_HIDE_KIDS_MEAL", "rsvp_hide_kids_meal");
	define("OPTION_HIDE_ADD_ADDITIONAL", "rsvp_hide_add_additional");
	define("OPTION_NOTIFY_ON_RSVP", "rsvp_notify_when_rsvp");
	define("OPTION_NOTIFY_EMAIL", "rsvp_notify_email_address");
	define("OPTION_DEBUG_RSVP_QUERIES", "rsvp_debug_queries");
	define("OPTION_WELCOME_TEXT", "rsvp_custom_welcome");
	define("OPTION_RSVP_QUESTION", "rsvp_custom_question_text");
	define("OPTION_RSVP_CUSTOM_YES_NO", "rsvp_custom_yes_no");
	define("OPTION_RSVP_PASSCODE", "rsvp_passcode");
	define("RSVP_DB_VERSION", "9");
	define("QT_SHORT", "shortAnswer");
	define("QT_MULTI", "multipleChoice");
	define("QT_LONG", "longAnswer");
	define("QT_DROP", "dropdown");
	define("QT_RADIO", "radio");
  define("RSVP_START_PARA", "<p class=\"rsvpParagraph\">");
  define("RSVP_END_PARA", "</p>\r\n");
  define("RSVP_START_CONTAINER", "<div id=\"rsvpPlugin\">\r\n");
  define("RSVP_END_CONTAINER", "</div>\r\n");
  define("RSVP_START_FORM_FIELD", "<div class=\"rsvpFormField\">\r\n");
  define("RSVP_END_FORM_FIELD", "</div>\r\n");
  
  $my_plugin_file = __FILE__;

  if (isset($plugin)) {
    $my_plugin_file = $plugin;
  }
  else if (isset($mu_plugin)) {
    $my_plugin_file = $mu_plugin;
  }
  else if (isset($network_plugin)) {
    $my_plugin_file = $network_plugin;
  }

  define('RSVP_PLUGIN_FILE', $my_plugin_file);
  define('RSVP_PLUGIN_PATH', WP_PLUGIN_DIR.'/'.basename(dirname($my_plugin_file)));
	if((isset($_GET['page']) && (strToLower($_GET['page']) == 'rsvp-admin-export')) || 
		 (isset($_POST['rsvp-bulk-action']) && (strToLower($_POST['rsvp-bulk-action']) == "export"))) {
		add_action('init', 'rsvp_admin_export');
	}
	
	require_once("rsvp_frontend.inc.php");
	/*
	 * Description: Database setup for the rsvp plug-in.  
	 */
	function rsvp_database_setup() {
		global $wpdb;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		require_once("rsvp_db_setup.inc.php");
	}
	
	function rsvp_install_passcode_field() {
		global $wpdb;
		$table = ATTENDEES_TABLE;
		$sql = "SHOW COLUMNS FROM `$table` LIKE 'passcode'";
		if(!$wpdb->get_results($sql)) {
			$sql = "ALTER TABLE `$table` ADD `passcode` VARCHAR(50) NOT NULL DEFAULT '';";
			$wpdb->query($sql);
		}
	}
	
	/**
	 * This generates a random 6 character passcode to be used for guests when the option is enabled.
	 */
	function rsvp_generate_passcode() {
		$length = 6;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$passcode = "";

    for ($p = 0; $p < $length; $p++) {
        $passcode .= $characters[mt_rand(0, strlen($characters))];
    }

    return $passcode;
	}

	function rsvp_admin_guestlist_options() {
		
		if(get_option(OPTION_RSVP_PASSCODE) == "Y") {
			global $wpdb;
			
			rsvp_install_passcode_field();
			
			$sql = "SELECT id, passcode FROM ".ATTENDEES_TABLE." WHERE passcode = ''";
			$attendees = $wpdb->get_results($sql);
			foreach($attendees as $a) {
				$newPasscode = rsvp_generate_passcode();
				$wpdb->update(ATTENDEES_TABLE, 
											array("passcode" => rsvp_generate_passcode()), 
											array("id" => $a->id), 
											array("%s"), 
											array("%d"));
			}
		}
?>
		<script type="text/javascript" language="javascript">
			jQuery(document).ready(function() {
				jQuery("#rsvp_opendate").datepicker();
				jQuery("#rsvp_deadline").datepicker();
			});
		</script>
		<div class="wrap">
			<h2>RSVP Guestlist Options</h2>
			<form method="post" action="options.php">
				<?php settings_fields( 'rsvp-option-group' ); ?>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><label for="rsvp_opendate">RSVP Open Date:</label></th>
						<td align="left"><input type="text" name="rsvp_opendate" id="rsvp_opendate" value="<?php echo htmlspecialchars(get_option(OPTION_OPENDATE)); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="rsvp_deadline">RSVP Deadline:</label></th>
						<td align="left"><input type="text" name="rsvp_deadline" id="rsvp_deadline" value="<?php echo htmlspecialchars(get_option(OPTION_DEADLINE)); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="rsvp_custom_greeting">Custom Greeting:</label></th>
						<td align="left"><textarea name="rsvp_custom_greeting" id="rsvp_custom_greeting" rows="5" cols="60"><?php echo htmlspecialchars(get_option(OPTION_GREETING)); ?></textarea></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="rsvp_custom_welcome">Custom Welcome:</label></th>
						<td align="left">Default is: &quot;There are a few more questions we need to ask you if you could please fill them out below to finish up the RSVP process.&quot;<br />
							<textarea name="rsvp_custom_welcome" id="rsvp_custom_welcome" rows="5" cols="60"><?php echo htmlspecialchars(get_option(OPTION_WELCOME_TEXT)); ?></textarea></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="rsvp_custom_question_text">RSVP Question Verbiage:</label></th>
						<td align="left">Default is: &quot;So, how about it?&quot;<br />
							<input type="text" name="rsvp_custom_question_text" id="rsvp_custom_question_text" 
							value="<?php echo htmlspecialchars(get_option(OPTION_RSVP_QUESTION)); ?>" size="65" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="rsvp_yes_verbiage">RSVP Yes Verbiage:</label></th>
						<td align="left"><input type="text" name="rsvp_yes_verbiage" id="rsvp_yes_verbiage" 
							value="<?php echo htmlspecialchars(get_option(OPTION_YES_VERBIAGE)); ?>" size="65" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="rsvp_no_verbiage">RSVP No Verbiage:</label></th>
						<td align="left"><input type="text" name="rsvp_no_verbiage" id="rsvp_no_verbiage" 
							value="<?php echo htmlspecialchars(get_option(OPTION_NO_VERBIAGE)); ?>" size="65" /></td>
					</tr>
					<!--<tr valign="top">
						<th scope="row"><label for="rsvp_custom_yes_no">Custom Yes/No Questions</label></th>
						<td align="left">
							This option allows a user to add in multiple yes or no options for when a user rsvps. This will over ride anything specified for the "RSVP Yes Verbiage" and "RSVP No Verbiage" options. The format of each question should be in the format:<br />
							value | Text user to see and each on it's own line.<br /><br />
							An example:<br />
							Yes | Yes, I will gladly come<br /> 
							Eh | Eh, I don't really know you and I know you are only inviting me for a gift
							<br /><br />
							<strong>Note:</strong> If you do not set a question with a value of "Yes" and one with a value of "No" the RSVP "Yes" and "No" counts will not be correct.
							<br /><br />
							<textarea name="rsvp_custom_yes_no" id="rsvp_custom_yes_no" rows="5" cols="60"><?php echo htmlspecialchars(get_option(OPTION_RSVP_CUSTOM_YES_NO)); ?></textarea> 
						</td>
					</tr>-->
					<tr valign="top">
						<th scope="row"><label for="rsvp_kids_meal_verbiage">RSVP Kids Meal Verbiage:</label></th>
						<td align="left"><input type="text" name="rsvp_kids_meal_verbiage" id="rsvp_kids_meal_verbiage" 
							value="<?php echo htmlspecialchars(get_option(OPTION_KIDS_MEAL_VERBIAGE)); ?>" size="65" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="rsvp_hide_kids_meal">Hide Kids Meal Question:</label></th>
						<td align="left"><input type="checkbox" name="rsvp_hide_kids_meal" id="rsvp_hide_kids_meal" 
							value="Y" <?php echo ((get_option(OPTION_HIDE_KIDS_MEAL) == "Y") ? " checked=\"checked\"" : ""); ?> /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="rsvp_veggie_meal_verbiage">RSVP Vegetarian Meal Verbiage:</label></th>
						<td align="left"><input type="text" name="rsvp_veggie_meal_verbiage" id="rsvp_veggie_meal_verbiage" 
							value="<?php echo htmlspecialchars(get_option(OPTION_VEGGIE_MEAL_VERBIAGE)); ?>" size="65" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="rsvp_hide_veggie">Hide Vegetarian Meal Question:</label></th>
						<td align="left"><input type="checkbox" name="rsvp_hide_veggie" id="rsvp_hide_veggie" 
							value="Y" <?php echo ((get_option(OPTION_HIDE_VEGGIE) == "Y") ? " checked=\"checked\"" : ""); ?> /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="rsvp_note_verbiage">Note Verbiage:</label></th>
						<td align="left"><textarea name="rsvp_note_verbiage" id="rsvp_note_verbiage" rows="3" cols="60"><?php 
							echo htmlspecialchars(get_option(OPTION_NOTE_VERBIAGE)); ?></textarea></td>
					</tr>
          <tr valign="top">
            <th scope="row"><label for="rsvp_hide_note_field">Hide Note Field:</label></th>
            <td align="left"><input type="checkbox" name="rsvp_hide_note_field" id="rsvp_hide_note_field" value="Y" 
              <?php echo ((get_option(RSVP_OPTION_HIDE_NOTE) == "Y") ? " checked=\"checked\"" : ""); ?> /></td>
          </tr>
					<tr valign="top">
						<th scope="row"><label for="rsvp_custom_thankyou">Custom Thank You:</label></th>
						<td align="left"><textarea name="rsvp_custom_thankyou" id="rsvp_custom_thankyou" rows="5" cols="60"><?php echo htmlspecialchars(get_option(OPTION_THANKYOU)); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="rsvp_hide_add_additional">Do not allow additional guests</label></th>
						<td align="left"><input type="checkbox" name="rsvp_hide_add_additional" id="rsvp_hide_add_additional" value="Y" 
							<?php echo ((get_option(OPTION_HIDE_ADD_ADDITIONAL) == "Y") ? " checked=\"checked\"" : ""); ?> /></td>
					</tr>
					<tr>
						<th scope="row"><label for="rsvp_notify_when_rsvp">Notify When Guest RSVPs</label></th>
						<td align="left"><input type="checkbox" name="rsvp_notify_when_rsvp" id="rsvp_notify_when_rsvp" value="Y" 
							<?php echo ((get_option(OPTION_NOTIFY_ON_RSVP) == "Y") ? " checked=\"checked\"" : ""); ?> /></td>
					</tr>
					<tr>
						<th scope="row"><label for="rsvp_notify_email_address">Email address to notify</label></th>
						<td align="left"><input type="text" name="rsvp_notify_email_address" id="rsvp_notify_email_address" value="<?php echo htmlspecialchars(get_option(OPTION_NOTIFY_EMAIL)); ?>"/></td>
					</tr>
					<tr>
						<th scope="ropw"><label for="<?php echo OPTION_RSVP_PASSCODE; ?>">Require a Passcode to RSVP:</label></th>
						<td align="left"><input type="checkbox" name="<?php echo OPTION_RSVP_PASSCODE; ?>" id="<?php echo OPTION_RSVP_PASSCODE; ?>" value="Y" 
							 <?php echo ((get_option(OPTION_RSVP_PASSCODE) == "Y") ? " checked=\"checked\"" : ""); ?> /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="rsvp_debug_queries">Debug RSVP Queries:</label></th>
						<td align="left"><input type="checkbox" name="rsvp_debug_queries" id="rsvp_debug_queries" 
							value="Y" <?php echo ((get_option(OPTION_DEBUG_RSVP_QUERIES) == "Y") ? " checked=\"checked\"" : ""); ?> /></td>
					</tr>
				</table>
				<input type="hidden" name="action" value="update" />
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
				</p>
			</form>
		</div>
<?php
	}
	
	function rsvp_admin_guestlist() {
		global $wpdb;		
		
		if(get_option("rsvp_db_version") != RSVP_DB_VERSION) {
			rsvp_database_setup();
		}
		rsvp_install_passcode_field();
		if((count($_POST) > 0) && ($_POST['rsvp-bulk-action'] == "delete") && (is_array($_POST['attendee']) && (count($_POST['attendee']) > 0))) {
			foreach($_POST['attendee'] as $attendee) {
				if(is_numeric($attendee) && ($attendee > 0)) {
					$wpdb->query($wpdb->prepare("DELETE FROM ".ASSOCIATED_ATTENDEES_TABLE." WHERE attendeeID = %d OR associatedAttendeeID = %d", 
																			$attendee, 
																			$attendee));
					$wpdb->query($wpdb->prepare("DELETE FROM ".ATTENDEES_TABLE." WHERE id = %d", 
																			$attendee));
				}
			}
		}
		
		$sql = "SELECT id, firstName, lastName, rsvpStatus, note, kidsMeal, additionalAttendee, veggieMeal, personalGreeting, passcode FROM ".ATTENDEES_TABLE;
		$orderBy = " lastName, firstName";
		if(isset($_GET['sort'])) {
			if(strToLower($_GET['sort']) == "rsvpstatus") {
				$orderBy = " rsvpStatus ".((strtolower($_GET['sortDirection']) == "desc") ? "DESC" : "ASC") .", ".$orderBy;
			}else if(strToLower($_GET['sort']) == "attendee") {
				$direction = ((strtolower($_GET['sortDirection']) == "desc") ? "DESC" : "ASC");
				$orderBy = " lastName $direction, firstName $direction";
			}	else if(strToLower($_GET['sort']) == "kidsmeal") {
				$orderBy = " kidsMeal ".((strtolower($_GET['sortDirection']) == "desc") ? "DESC" : "ASC") .", ".$orderBy;
			}	else if(strToLower($_GET['sort']) == "additional") {
				$orderBy = " additionalAttendee ".((strtolower($_GET['sortDirection']) == "desc") ? "DESC" : "ASC") .", ".$orderBy;
			}	else if(strToLower($_GET['sort']) == "vegetarian") {
				$orderBy = " veggieMeal ".((strtolower($_GET['sortDirection']) == "desc") ? "DESC" : "ASC") .", ".$orderBy;
			}			
		}
		$sql .= " ORDER BY ".$orderBy;
		$attendees = $wpdb->get_results($sql);
		$sort = "";
		$sortDirection = "asc";
		if(isset($_GET['sort'])) {
			$sort = $_GET['sort'];
		}
		
		if(isset($_GET['sortDirection'])) {
			$sortDirection = $_GET['sortDirection'];
		}
	?>
		<script type="text/javascript" language="javascript">
			jQuery(document).ready(function() {
				jQuery("#cb").click(function() {
					if(jQuery("#cb").attr("checked")) {
						jQuery("input[name='attendee[]']").attr("checked", "checked");
					} else {
						jQuery("input[name='attendee[]']").removeAttr("checked");
					}
				});
			});
		</script>
		<div class="wrap">	
			<div id="icon-edit" class="icon32"><br /></div>	
			<h2>List of current attendees</h2>
			<form method="post" id="rsvp-form" enctype="multipart/form-data">
				<input type="hidden" id="rsvp-bulk-action" name="rsvp-bulk-action" />
				<input type="hidden" id="sortValue" name="sortValue" value="<?php echo htmlentities($sort, ENT_QUOTES); ?>" />
				<input type="hidden" name="exportSortDirection" value="<?php echo htmlentities($sortDirection, ENT_QUOTES); ?>" />
				<div class="tablenav">
					<div class="alignleft actions">
						<select id="rsvp-action-top" name="action">
							<option value="" selected="selected"><?php _e('Bulk Actions', 'rsvp'); ?></option>
							<option value="delete"><?php _e('Delete', 'rsvp'); ?></option>
						</select>
						<input type="submit" value="<?php _e('Apply', 'rsvp'); ?>" name="doaction" id="doaction" class="button-secondary action" onclick="document.getElementById('rsvp-bulk-action').value = document.getElementById('rsvp-action-top').value;" />
						<input type="submit" value="<?php _e('Export Attendees', 'rsvp'); ?>" name="exportButton" id="exportButton" class="button-secondary action" onclick="document.getElementById('rsvp-bulk-action').value = 'export';" />
					</div>
					<?php
						$yesResults = $wpdb->get_results("SELECT COUNT(*) AS yesCount FROM ".ATTENDEES_TABLE." WHERE rsvpStatus = 'Yes'");
						$noResults = $wpdb->get_results("SELECT COUNT(*) AS noCount FROM ".ATTENDEES_TABLE." WHERE rsvpStatus = 'No'");
						$noResponseResults = $wpdb->get_results("SELECT COUNT(*) AS noResponseCount FROM ".ATTENDEES_TABLE." WHERE rsvpStatus = 'NoResponse'");
						$kidsMeals = $wpdb->get_results("SELECT COUNT(*) AS kidsMealCount FROM ".ATTENDEES_TABLE." WHERE kidsMeal = 'Y'");
						$veggieMeals = $wpdb->get_results("SELECT COUNT(*) AS veggieMealCount FROM ".ATTENDEES_TABLE." WHERE veggieMeal = 'Y'");
					?>
					<div class="alignright">RSVP Count -  
						Yes: <strong><?php echo $yesResults[0]->yesCount; ?></strong> &nbsp; &nbsp;  &nbsp; &nbsp; 
						No: <strong><?php echo $noResults[0]->noCount; ?></strong> &nbsp; &nbsp;  &nbsp; &nbsp; 
						No Response: <strong><?php echo $noResponseResults[0]->noResponseCount; ?></strong> &nbsp; &nbsp;  &nbsp; &nbsp; 
						Kids Meals: <strong><?php echo $kidsMeals[0]->kidsMealCount; ?></strong> &nbsp; &nbsp;  &nbsp; &nbsp; 
						Veggie Meals: <strong><?php echo $veggieMeals[0]->veggieMealCount; ?></strong>
					</div>
					<div class="clear"></div>
				</div>
			<table class="widefat post fixed" cellspacing="0">
				<thead>
					<tr>
						<th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox" id="cb" /></th>
						<th scope="col" id="attendeeName" class="manage-column column-title" style="">Attendee</a> &nbsp;
							<a href="admin.php?page=rsvp-top-level&amp;sort=attendee&amp;sortDirection=asc">
								<img src="<?php echo plugins_url(); ?>/rsvp/uparrow<?php 
									echo ((($sort == "attendee") && ($sortDirection == "asc")) ? "_selected" : ""); ?>.gif" width="11" height="9" 
									alt="Sort Ascending Attendee Status" title="Sort Ascending Attendee Status" border="0"></a> &nbsp;
							<a href="admin.php?page=rsvp-top-level&amp;sort=attendee&amp;sortDirection=desc">
								<img src="<?php echo plugins_url(); ?>/rsvp/downarrow<?php 
									echo ((($sort == "attendee") && ($sortDirection == "desc")) ? "_selected" : ""); ?>.gif" width="11" height="9" 
									alt="Sort Descending Attendee Status" title="Sort Descending Attendee Status" border="0"></a>
						</th>			
						<th scope="col" id="rsvpStatus" class="manage-column column-title" style="">RSVP Status &nbsp;
							<a href="admin.php?page=rsvp-top-level&amp;sort=rsvpStatus&amp;sortDirection=asc">
								<img src="<?php echo plugins_url(); ?>/rsvp/uparrow<?php 
									echo ((($sort == "rsvpStatus") && ($sortDirection == "asc")) ? "_selected" : ""); ?>.gif" width="11" height="9" 
									alt="Sort Ascending RSVP Status" title="Sort Ascending RSVP Status" border="0"></a> &nbsp;
							<a href="admin.php?page=rsvp-top-level&amp;sort=rsvpStatus&amp;sortDirection=desc">
								<img src="<?php echo plugins_url(); ?>/rsvp/downarrow<?php 
									echo ((($sort == "rsvpStatus") && ($sortDirection == "desc")) ? "_selected" : ""); ?>.gif" width="11" height="9" 
									alt="Sort Descending RSVP Status" title="Sort Descending RSVP Status" border="0"></a>
						</th>
						<?php if(get_option(OPTION_HIDE_KIDS_MEAL) != "Y") {?>
						<th scope="col" id="kidsMeal" class="manage-column column-title" style="">Kids Meal	 &nbsp;
								<a href="admin.php?page=rsvp-top-level&amp;sort=kidsMeal&amp;sortDirection=asc">
									<img src="<?php echo plugins_url(); ?>/rsvp/uparrow<?php 
										echo ((($sort == "kidsMeal") && ($sortDirection == "asc")) ? "_selected" : ""); ?>.gif" width="11" height="9" 
										alt="Sort Ascending Kids Meal Status" title="Sort Ascending Kids Meal Status" border="0"></a> &nbsp;
								<a href="admin.php?page=rsvp-top-level&amp;sort=kidsMeal&amp;sortDirection=desc">
									<img src="<?php echo plugins_url(); ?>/rsvp/downarrow<?php 
										echo ((($sort == "kidsMeal") && ($sortDirection == "desc")) ? "_selected" : ""); ?>.gif" width="11" height="9" 
										alt="Sort Descending Kids Meal Status" title="Sort Descending Kids Meal Status" border="0"></a>
						</th>
						<?php } ?>
						<th scope="col" id="additionalAttendee" class="manage-column column-title" style="">Additional Attendee		 &nbsp;
									<a href="admin.php?page=rsvp-top-level&amp;sort=additional&amp;sortDirection=asc">
										<img src="<?php echo plugins_url(); ?>/rsvp/uparrow<?php 
											echo ((($sort == "additional") && ($sortDirection == "asc")) ? "_selected" : ""); ?>.gif" width="11" height="9" 
											alt="Sort Ascending Additional Attendees Status" title="Sort Ascending Additional Attendees Status" border="0"></a> &nbsp;
									<a href="admin.php?page=rsvp-top-level&amp;sort=additional&amp;sortDirection=desc">
										<img src="<?php echo plugins_url(); ?>/rsvp/downarrow<?php 
											echo ((($sort == "additional") && ($sortDirection == "desc")) ? "_selected" : ""); ?>.gif" width="11" height="9" 
											alt="Sort Descending Additional Attendees Status" title="Sort Descending Additional Atttendees Status" border="0"></a>
						</th>
						<?php if(get_option(OPTION_HIDE_VEGGIE) != "Y") {?>
						<th scope="col" id="veggieMeal" class="manage-column column-title" style="">Vegetarian			 &nbsp;
										<a href="admin.php?page=rsvp-top-level&amp;sort=vegetarian&amp;sortDirection=asc">
											<img src="<?php echo plugins_url(); ?>/rsvp/uparrow<?php 
												echo ((($sort == "vegetarian") && ($sortDirection == "asc")) ? "_selected" : ""); ?>.gif" width="11" height="9" 
												alt="Sort Ascending Vegetarian Status" title="Sort Ascending Vegetarian Status" border="0"></a> &nbsp;
										<a href="admin.php?page=rsvp-top-level&amp;sort=vegetarian&amp;sortDirection=desc">
											<img src="<?php echo plugins_url(); ?>/rsvp/downarrow<?php 
												echo ((($sort == "vegetarian") && ($sortDirection == "desc")) ? "_selected" : ""); ?>.gif" width="11" height="9" 
												alt="Sort Descending Vegetarian Status" title="Sort Descending Vegetarian Status" border="0"></a>
						</th>
						<?php } ?>
						<th scope="col" id="customMessage" class="manage-column column-title" style="">Custom Message</th>
						<th scope="col" id="note" class="manage-column column-title" style="">Note</th>
						<?php
						if(get_option(OPTION_RSVP_PASSCODE) == "Y") {
						?>
							<th scope="col" id="passcode" class="manage-column column-title" style="">Passcode</th>
						<?php
						}
						
						?>
						<?php
							$qRs = $wpdb->get_results("SELECT id, question FROM ".QUESTIONS_TABLE." ORDER BY sortOrder, id");
							if(count($qRs) > 0) {
								foreach($qRs as $q) {
						?>
							<th scope="col" class="manage-column -column-title"><?php echo htmlentities(stripslashes($q->question)); ?></th>
						<?php		
								}
							}
						?>
						<th scope="col" id="associatedAttendees" class="manage-column column-title" style="">Associated Attendees</th>
					</tr>
				</thead>
			</table>
			<div style="overflow: auto;height: 450px;">
				<table class="widefat post fixed" cellspacing="0">
				<?php
					$i = 0;
					foreach($attendees as $attendee) {
					?>
						<tr class="<?php echo (($i % 2 == 0) ? "alternate" : ""); ?> author-self">
							<th scope="row" class="check-column"><input type="checkbox" name="attendee[]" value="<?php echo $attendee->id; ?>" /></th>						
							<td>
								<a href="<?php echo get_option("siteurl"); ?>/wp-admin/admin.php?page=rsvp-admin-guest&amp;id=<?php echo $attendee->id; ?>"><?php echo htmlentities(stripslashes($attendee->firstName)." ".stripslashes($attendee->lastName)); ?></a>
							</td>
							<td><?php echo $attendee->rsvpStatus; ?></td>
							<?php if(get_option(OPTION_HIDE_KIDS_MEAL) != "Y") {?>
							<td><?php 
								if($attendee->rsvpStatus == "NoResponse") {
									echo "--";
								} else {
									echo (($attendee->kidsMeal == "Y") ? "Yes" : "No"); 
								}?></td>
								<?php } ?>
							<td><?php 
								if($attendee->rsvpStatus == "NoResponse") {
									echo "--";
								} else {
									echo (($attendee->additionalAttendee == "Y") ? "Yes" : "No"); 
								}
							?></td>
							<?php if(get_option(OPTION_HIDE_VEGGIE) != "Y") {?>
							<td><?php 
								if($attendee->rsvpStatus == "NoResponse") {
									echo "--";
								} else {
									echo (($attendee->veggieMeal == "Y") ? "Yes" : "No"); 
								}	
									?></td>
							<?php } ?>
							<td><?php
								echo nl2br(stripslashes(trim($attendee->personalGreeting)));
							?></td>
							<td><?php echo nl2br(stripslashes(trim($attendee->note))); ?></td>
							<?php
							if(get_option(OPTION_RSVP_PASSCODE) == "Y") {
							?>
								<td><?php echo $attendee->passcode; ?></td>
							<?php	
							}
								$sql = "SELECT question, answer FROM ".QUESTIONS_TABLE." q 
									LEFT JOIN ".ATTENDEE_ANSWERS." ans ON q.id = ans.questionID AND ans.attendeeID = %d 
									ORDER BY q.sortOrder";
								$aRs = $wpdb->get_results($wpdb->prepare($sql, $attendee->id));
								if(count($aRs) > 0) {
									foreach($aRs as $a) {
							?>
									<td><?php echo htmlentities(stripslashes($a->answer)); ?></td>
							<?php
									}
								}
							?>
							<td>
							<?php
								$sql = "SELECT firstName, lastName FROM ".ATTENDEES_TABLE." 
								 	WHERE id IN (SELECT attendeeID FROM ".ASSOCIATED_ATTENDEES_TABLE." WHERE associatedAttendeeID = %d) 
										OR id in (SELECT associatedAttendeeID FROM ".ASSOCIATED_ATTENDEES_TABLE." WHERE attendeeID = %d)";
							
								$associations = $wpdb->get_results($wpdb->prepare($sql, $attendee->id, $attendee->id));
								foreach($associations as $a) {
									echo htmlentities(stripslashes($a->firstName." ".$a->lastName))."<br />";
								}
							?>
							</td>
						</tr>
					<?php
						$i++;
					}
				?>
				</table>
			</div>
			</form>
		</div>
	<?php
	}
	
	function rsvp_admin_export() {
		global $wpdb;
			$sql = "SELECT id, firstName, lastName, rsvpStatus, note, kidsMeal, additionalAttendee, veggieMeal, passcode 
							FROM ".ATTENDEES_TABLE;
							
							$orderBy = " lastName, firstName";
							if(isset($_POST['sortValue'])) {
								if(strToLower($_POST['sortValue']) == "rsvpstatus") {
									$orderBy = " rsvpStatus ".((strtolower($_POST['exportSortDirection']) == "desc") ? "DESC" : "ASC") .", ".$orderBy;
								}else if(strToLower($_POST['sortValue']) == "attendee") {
									$direction = ((strtolower($_POST['exportSortDirection']) == "desc") ? "DESC" : "ASC");
									$orderBy = " lastName $direction, firstName $direction";
								}	else if(strToLower($_POST['sortValue']) == "kidsmeal") {
									$orderBy = " kidsMeal ".((strtolower($_POST['exportSortDirection']) == "desc") ? "DESC" : "ASC") .", ".$orderBy;
								}	else if(strToLower($_POST['sortValue']) == "additional") {
									$orderBy = " additionalAttendee ".((strtolower($_POST['exportSortDirection']) == "desc") ? "DESC" : "ASC") .", ".$orderBy;
								}	else if(strToLower($_POST['sortValue']) == "vegetarian") {
									$orderBy = " veggieMeal ".((strtolower($_POST['exportSortDirection']) == "desc") ? "DESC" : "ASC") .", ".$orderBy;
								}			
							}
							$sql .= " ORDER BY ".$orderBy;
			$attendees = $wpdb->get_results($sql);
			$csv = "\"Attendee\",\"RSVP Status\",";
			
			if(get_option(OPTION_HIDE_KIDS_MEAL) != "Y") {
				$csv .= "\"Kids Meal\",";
			}
			$csv .= "\"Additional Attendee\",";
			
			if(get_option(OPTION_HIDE_VEGGIE) != "Y") {
				$csv .= "\"Vegatarian\",";
			}
      if(get_option(OPTION_RSVP_PASSCODE) == "Y") {
        $csv .= "\"Passcode\",";
      }
			$csv .= "\"Note\",\"Associated Attendees\"";
			
			$qRs = $wpdb->get_results("SELECT id, question FROM ".QUESTIONS_TABLE." ORDER BY sortOrder, id");
			if(count($qRs) > 0) {
				foreach($qRs as $q) {
					$csv .= ",\"".stripslashes($q->question)."\"";
				}
			}
			
			$csv .= "\r\n";
			foreach($attendees as $a) {
				$csv .= "\"".stripslashes($a->firstName." ".$a->lastName)."\",\"".($a->rsvpStatus)."\",";
				
				if(get_option(OPTION_HIDE_KIDS_MEAL) != "Y") {
					$csv .= "\"".(($a->kidsMeal == "Y") ? "Yes" : "No")."\",";
				}
				
				$csv .= "\"".(($a->additionalAttendee == "Y") ? "Yes" : "No")."\",";
				
				if(get_option(OPTION_HIDE_VEGGIE) != "Y") {
					$csv .= "\"".(($a->veggieMeal == "Y") ? "Yes" : "No")."\",";
				}
        
        if(get_option(OPTION_RSVP_PASSCODE) == "Y") {
          $csv .= "\"".(($a->passcode))."\",";
        }
				
				$csv .= "\"".(str_replace("\"", "\"\"", stripslashes($a->note)))."\",\"";
			
				$sql = "SELECT firstName, lastName FROM ".ATTENDEES_TABLE." 
				 	WHERE id IN (SELECT attendeeID FROM ".ASSOCIATED_ATTENDEES_TABLE." WHERE associatedAttendeeID = %d) 
						OR id in (SELECT associatedAttendeeID FROM ".ASSOCIATED_ATTENDEES_TABLE." WHERE attendeeID = %d)";
		
				$associations = $wpdb->get_results($wpdb->prepare($sql, $a->id, $a->id));
				foreach($associations as $assc) {
					$csv .= trim(stripslashes($assc->firstName." ".$assc->lastName))."\r\n";
				}
				$csv .= "\"";
				
				$qRs = $wpdb->get_results("SELECT id, question FROM ".QUESTIONS_TABLE." ORDER BY sortOrder, id");
				if(count($qRs) > 0) {
					foreach($qRs as $q) {
						$aRs = $wpdb->get_results($wpdb->prepare("SELECT answer FROM ".ATTENDEE_ANSWERS." WHERE attendeeID = %d AND questionID = %d", $a->id, $q->id));
						if(count($aRs) > 0) {
							$csv .= ",\"".stripslashes($aRs[0]->answer)."\"";
						} else {
							$csv .= ",\"\"";
						}
					}
				}
				
				$csv .= "\r\n";
			}
			if(isset($_SERVER['HTTP_USER_AGENT']) && preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT'])) {
				// IE Bug in download name workaround
				ini_set( 'zlib.output_compression','Off' );
			}
			header('Content-Description: RSVP Export');
			header("Content-Type: application/vnd.ms-excel", true);
			header('Content-Disposition: attachment; filename="rsvpEntries.csv"'); 
			echo $csv;
			exit();
	}
	
	function rsvp_admin_import() {
		global $wpdb;
		if(count($_FILES) > 0) {
			check_admin_referer('rsvp-import');
			require_once("Excel/reader.php");
			$data = new Spreadsheet_Excel_Reader();
			$data->read($_FILES['importFile']['tmp_name']);
			if($data->sheets[0]['numCols'] >= 2) {
				$count = 0;
				for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
					$fName = trim($data->sheets[0]['cells'][$i][1]);
					$lName = trim($data->sheets[0]['cells'][$i][2]);
					$personalGreeting = (isset($data->sheets[0]['cells'][$i][4])) ? $personalGreeting = $data->sheets[0]['cells'][$i][4] : "";
          $passcode = (isset($data->sheets[0]['cells'][$i][5])) ? $data->sheets[0]['cells'][$i][5] : "";
					if(!empty($fName) && !empty($lName)) {
						$sql = "SELECT id FROM ".ATTENDEES_TABLE." 
						 	WHERE firstName = %s AND lastName = %s ";
						$res = $wpdb->get_results($wpdb->prepare($sql, $fName, $lName));
						if(count($res) == 0) {
							$wpdb->insert(ATTENDEES_TABLE, array("firstName" 				=> $fName, 
																									 "lastName" 				=> $lName,
																									 "personalGreeting" => $personalGreeting, 
                                                   "passcode"         => $passcode), 
																						 array('%s', '%s', '%s', '%s'));
							$count++;
						}
					}
				}
				
				if($data->sheets[0]['numCols'] >= 3) {
					// There must be associated users so let's associate them
					for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
						$fName = trim($data->sheets[0]['cells'][$i][1]);
						$lName = trim($data->sheets[0]['cells'][$i][2]);
						if(!empty($fName) && !empty($lName) && (count($data->sheets[0]['cells'][$i]) >= 3)) {
							// Get the user's id 
							$sql = "SELECT id FROM ".ATTENDEES_TABLE." 
							 	WHERE firstName = %s AND lastName = %s ";
							$res = $wpdb->get_results($wpdb->prepare($sql, $fName, $lName));
							if((count($res) > 0) && isset($data->sheets[0]['cells'][$i][3])) {
								$userId = $res[0]->id;
								
								// Deal with the assocaited users...
								$associatedUsers = explode(",", trim($data->sheets[0]['cells'][$i][3]));
								if(is_array($associatedUsers)) {
									foreach($associatedUsers as $au) {
										$user = explode(" ", trim($au), 2);
										// Three cases, they didn't enter in all of the information, user exists or doesn't.  
										// If user exists associate the two users
										// If user does not exist add the user and then associate the two
										if(is_array($user) && (count($user) == 2)) {
											$sql = "SELECT id FROM ".ATTENDEES_TABLE." 
											 	WHERE firstName = %s AND lastName = %s ";
											$userRes = $wpdb->get_results($wpdb->prepare($sql, trim($user[0]), trim($user[1])));
											if(count($userRes) > 0) {
												$newUserId = $userRes[0]->id;
											} else {
												// Insert them and then we can associate them...
												$wpdb->insert(ATTENDEES_TABLE, array("firstName" => trim($user[0]), "lastName" => trim($user[1])), array('%s', '%s'));
												$newUserId = $wpdb->insert_id;
												$count++;
											}
											
											$wpdb->insert(ASSOCIATED_ATTENDEES_TABLE, array("attendeeID" => $newUserId, 
																																			"associatedAttendeeID" => $userId), 
																																array("%d", "%d"));
																																
											$wpdb->insert(ASSOCIATED_ATTENDEES_TABLE, array("attendeeID" => $userId, 
																																			"associatedAttendeeID" => $newUserId), 
																																array("%d", "%d"));
										}
									}
								}
							}
						}
					}
				}
			?>
			<p><strong><?php echo $count; ?></strong> total records were imported.</p>
			<p>Continue to the RSVP <a href="admin.php?page=rsvp-top-level">list</a></p>
			<?php
			}
		} else {
		?>
			<form name="rsvp_import" method="post" enctype="multipart/form-data">
				<?php wp_nonce_field('rsvp-import'); ?>
				<p>Select an excel file (only xls please, xlsx is not supported....yet) in the following format:<br />
				<strong>First Name</strong> | <strong>Last Name</strong> | <strong>Associated Attendees*</strong> | <strong>Custom Message</strong> | <strong>Passcode</strong>
				</p>
				<p>
				* associated attendees should be separated by a comma it is assumed that the first space encountered will separate the first and last name.
				</p>
				<p>A header row is not expected.</p>
				<p><input type="file" name="importFile" id="importFile" /></p>
				<p><input type="submit" value="Import File" name="goRsvp" /></p>
			</form>
		<?php
		}
	}
	
	function rsvp_admin_guest() {
		global $wpdb;
		if((count($_POST) > 0) && !empty($_POST['firstName']) && !empty($_POST['lastName'])) {
			check_admin_referer('rsvp_add_guest');
			$passcode = (isset($_POST['passcode'])) ? $_POST['passcode'] : "";
			
			if(isset($_SESSION[EDIT_SESSION_KEY]) && is_numeric($_SESSION[EDIT_SESSION_KEY])) {
				$wpdb->update(ATTENDEES_TABLE, 
											array("firstName" => trim($_POST['firstName']), 
											      "lastName" => trim($_POST['lastName']), 
											      "personalGreeting" => trim($_POST['personalGreeting']), 
														"rsvpStatus" => trim($_POST['rsvpStatus'])), 
											array("id" => $_SESSION[EDIT_SESSION_KEY]), 
											array("%s", "%s", "%s", "%s"), 
											array("%d"));
				rsvp_printQueryDebugInfo();
				$attendeeId = $_SESSION[EDIT_SESSION_KEY];
				$wpdb->query($wpdb->prepare("DELETE FROM ".ASSOCIATED_ATTENDEES_TABLE." WHERE attendeeId = %d", $attendeeId));
			} else {
				$wpdb->insert(ATTENDEES_TABLE, array("firstName" => trim($_POST['firstName']), 
				                                     "lastName" => trim($_POST['lastName']),
																						 "personalGreeting" => trim($_POST['personalGreeting']), 
																						 "rsvpStatus" => trim($_POST['rsvpStatus'])), 
				                               array('%s', '%s', '%s', '%s'));
				rsvp_printQueryDebugInfo();
					
				$attendeeId = $wpdb->insert_id;
			}
			
			if(isset($_POST['associatedAttendees']) && is_array($_POST['associatedAttendees'])) {
				foreach($_POST['associatedAttendees'] as $aid) {
					if(is_numeric($aid) && ($aid > 0)) {
						$wpdb->insert(ASSOCIATED_ATTENDEES_TABLE, array("attendeeID"=>$attendeeId, "associatedAttendeeID"=>$aid), array("%d", "%d"));
						rsvp_printQueryDebugInfo();
					}
				}
			}
			
			if(get_option(OPTION_RSVP_PASSCODE) == "Y") {
				if(empty($passcode)) {
					$passcode = rsvp_generate_passcode();
				}
				$wpdb->update(ATTENDEES_TABLE, 
											array("passcode" => trim($passcode)), 
											array("id"=>$attendeeId), 
											array("%s"), 
											array("%d"));
			}
		?>
			<p>Attendee <?php echo htmlentities(stripslashes($_POST['firstName']." ".$_POST['lastName']));?> has been successfully saved</p>
			<p>
				<a href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=rsvp-top-level">Continue to Attendee List</a> | 
				<a href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=rsvp-admin-guest">Add a Guest</a> 
			</p>
	<?php
		} else {
			$attendee = null;
			unset($_SESSION[EDIT_SESSION_KEY]);
			$associatedAttendees = array();
			$firstName = "";
			$lastName = "";
			$personalGreeting = "";
			$rsvpStatus = "NoResponse";
			$passcode = "";
			
			if(isset($_GET['id']) && is_numeric($_GET['id'])) {
				$attendee = $wpdb->get_row("SELECT id, firstName, lastName, personalGreeting, rsvpStatus, passcode FROM ".ATTENDEES_TABLE." WHERE id = ".$_GET['id']);
				if($attendee != null) {
					$_SESSION[EDIT_SESSION_KEY] = $attendee->id;
					$firstName = stripslashes($attendee->firstName);
					$lastName = stripslashes($attendee->lastName);
					$personalGreeting = stripslashes($attendee->personalGreeting);
					$rsvpStatus = $attendee->rsvpStatus;
					$passcode = stripslashes($attendee->passcode);
					
					// Get the associated attendees and add them to an array
					$associations = $wpdb->get_results("SELECT associatedAttendeeID FROM ".ASSOCIATED_ATTENDEES_TABLE." WHERE attendeeId = ".$attendee->id.
																						 " UNION ".
																						 "SELECT attendeeID FROM ".ASSOCIATED_ATTENDEES_TABLE." WHERE associatedAttendeeID = ".$attendee->id);
					foreach($associations as $aId) {
						$associatedAttendees[] = $aId->associatedAttendeeID;
					}
				} 
			} 
	?>
			<form name="contact" action="admin.php?page=rsvp-admin-guest" method="post">
				<?php wp_nonce_field('rsvp_add_guest'); ?>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save'); ?>" />
				</p>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><label for="firstName">First Name:</label></th>
						<td align="left"><input type="text" name="firstName" id="firstName" size="30" value="<?php echo htmlentities($firstName); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="lastName">Last Name:</label></th>
						<td align="left"><input type="text" name="lastName" id="lastName" size="30" value="<?php echo htmlentities($lastName); ?>" /></td>
					</tr>
					<?php
					if(get_option(OPTION_RSVP_PASSCODE) == "Y") {
					?>
						<tr valign="top">
							<th scope="row"><label for="passcode">Passcode:</label></th>
							<td align="left"><input type="text" name="passcode" id="passcode" size="30" value="<?php echo htmlentities($passcode); ?>" maxlength="6" /></td>
						</tr>
					<?php	
					}					
					?>
					<tr>
						<th scope="row"><label for="rsvpStatus">RSVP Status</label></th>
						<td align="left">
							<select name="rsvpStatus" id="rsvpStatus" size="1">
								<option value="NoResponse" <?php
									echo (($rsvpStatus == "NoResponse") ? " selected=\"selected\"" : "");
								?>>No Response</option>
								<option value="Yes" <?php
									echo (($rsvpStatus == "Yes") ? " selected=\"selected\"" : "");
								?>>Yes</option>									
								<option value="No" <?php
									echo (($rsvpStatus == "No") ? " selected=\"selected\"" : "");
								?>>No</option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row" valign="top"><label for="personalGreeting">Custom Message:</label></th>
						<td align="left"><textarea name="personalGreeting" id="personalGreeting" rows="5" cols="40"><?php echo htmlentities($personalGreeting); ?></textarea></td>
					</tr>
					<tr valign="top">
						<th scope="row">Associated Attendees:</th>
						<td align="left">
							<select name="associatedAttendees[]" multiple="multiple" size="5" style="height: 200px;">
								<?php
									$attendees = $wpdb->get_results("SELECT id, firstName, lastName FROM ".$wpdb->prefix."attendees ORDER BY lastName, firstName");
									foreach($attendees as $a) {
										if($a->id != $_SESSION[EDIT_SESSION_KEY]) {
								?>
											<option value="<?php echo $a->id; ?>" 
															<?php echo ((in_array($a->id, $associatedAttendees)) ? "selected=\"selected\"" : ""); ?>><?php echo htmlentities(stripslashes($a->firstName)." ".stripslashes($a->lastName)); ?></option>
								<?php
										}
									}
								?>
							</select>
						</td>
					</tr>
				<?php
				if(($attendee != null) && ($attendee->id > 0)) {
					$sql = "SELECT question, answer FROM ".ATTENDEE_ANSWERS." ans 
						INNER JOIN ".QUESTIONS_TABLE." q ON q.id = ans.questionID 
						WHERE attendeeID = %d 
						ORDER BY q.sortOrder";
					$aRs = $wpdb->get_results($wpdb->prepare($sql, $attendee->id));
					if(count($aRs) > 0) {
				?>
				<tr>
					<td colspan="2">
						<h4>Custom Questions Answered</h4>
						<table cellpadding="2" cellspacing="0" border="0">
							<tr>
								<th>Question</th>
								<th>Answer</th>
							</tr>
				<?php
						foreach($aRs as $a) {
				?>
							<tr>
								<td><?php echo stripslashes($a->question); ?></td>
								<td><?php echo stripslashes($a->answer); ?></td>
							</tr>
				<?php
						}
				?>
						</table>
					</td>
				</tr>
				<?php
					}
				}
				?>
				</table>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save'); ?>" />
				</p>
			</form>
<?php
		}
	}
	
	function rsvp_admin_questions() {
		global $wpdb;
		
		if((count($_POST) > 0) && ($_POST['rsvp-bulk-action'] == "delete") && (is_array($_POST['q']) && (count($_POST['q']) > 0))) {
			foreach($_POST['q'] as $q) {
				if(is_numeric($q) && ($q > 0)) {
					$wpdb->query($wpdb->prepare("DELETE FROM ".QUESTIONS_TABLE." WHERE id = %d", $q));
					$wpdb->query($wpdb->prepare("DELETE FROM ".ATTENDEE_ANSWERS." WHERE questionID = %d", $q));
				}
			}
		} else if((count($_POST) > 0) && ($_POST['rsvp-bulk-action'] == "saveSortOrder")) {
			$sql = "SELECT id FROM ".QUESTIONS_TABLE;
			$sortQs = $wpdb->get_results($sql);
			foreach($sortQs as $q) {
				if(is_numeric($_POST['sortOrder'.$q->id]) && ($_POST['sortOrder'.$q->id] >= 0)) {
					$wpdb->update(QUESTIONS_TABLE, 
												array("sortOrder" => $_POST['sortOrder'.$q->id]), 
												array("id" => $q->id), 
												array("%d"), 
												array("%d"));
					rsvp_printQueryDebugInfo();
				}
			}
		}
		
		$sql = "SELECT id, question, sortOrder FROM ".QUESTIONS_TABLE." ORDER BY sortOrder ASC";
		$customQs = $wpdb->get_results($sql);
	?>
		<script type="text/javascript" language="javascript">
			jQuery(document).ready(function() {
				jQuery("#cb").click(function() {
					if(jQuery("#cb").attr("checked")) {
						jQuery("input[name='q[]']").attr("checked", "checked");
					} else {
						jQuery("input[name='q[]']").removeAttr("checked");
					}
				});
				
				jQuery("#customQuestions").tableDnD({
					onDrop: function(table, row) {
						var rows = table.tBodies[0].rows;
            for (var i=0; i<rows.length; i++) {
                jQuery("#sortOrder" + rows[i].id).val(i);
            }
	        	
					}
				});
			});
		</script>
		<div class="wrap">	
			<div id="icon-edit" class="icon32"><br /></div>	
			<h2>List of current custom questions</h2>
			<form method="post" id="rsvp-form" enctype="multipart/form-data">
				<input type="hidden" id="rsvp-bulk-action" name="rsvp-bulk-action" />
				<div class="tablenav">
					<div class="alignleft actions">
						<select id="rsvp-action-top" name="action">
							<option value="" selected="selected"><?php _e('Bulk Actions', 'rsvp'); ?></option>
							<option value="delete"><?php _e('Delete', 'rsvp'); ?></option>
						</select>
						<input type="submit" value="<?php _e('Apply', 'rsvp'); ?>" name="doaction" id="doaction" class="button-secondary action" onclick="document.getElementById('rsvp-bulk-action').value = document.getElementById('rsvp-action-top').value;" />
						<input type="submit" value="<?php _e('Save Sort Order', 'rsvp'); ?>" name="saveSortButton" id="saveSortButton" class="button-secondary action" onclick="document.getElementById('rsvp-bulk-action').value = 'saveSortOrder';" />
					</div>
					<div class="clear"></div>
				</div>
			<table class="widefat post fixed" cellspacing="0">
				<thead>
					<tr>
						<th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox" id="cb" /></th>
						<th scope="col" id="questionCol" class="manage-column column-title" style="">Question</th>			
					</tr>
				</thead>
			</table>
			<div style="overflow: auto;height: 450px;">
				<table class="widefat post fixed" cellspacing="0" id="customQuestions">
				<?php
					$i = 0;
					foreach($customQs as $q) {
					?>
						<tr class="<?php echo (($i % 2 == 0) ? "alternate" : ""); ?> author-self" id="<?php echo $q->id; ?>">
							<th scope="row" class="check-column"><input type="checkbox" name="q[]" value="<?php echo $q->id; ?>" /></th>						
							<td>
								<a href="<?php echo get_option("siteurl"); ?>/wp-admin/admin.php?page=rsvp-admin-custom-question&amp;id=<?php echo $q->id; ?>"><?php echo htmlentities(stripslashes($q->question)); ?></a>
								<input type="hidden" name="sortOrder<?php echo $q->id; ?>" id="sortOrder<?php echo $q->id; ?>" value="<?php echo $q->sortOrder; ?>" />
							</td>
						</tr>
					<?php
						$i++;
					}
				?>
				</table>
			</div>
			</form>
		</div>
	<?php
	}
	
	function rsvp_admin_custom_question() {
		global $wpdb;
		$answerQuestionTypes = array(2,4,5);
		
		$radioQuestionType = $wpdb->get_results("SELECT id FROM ".QUESTION_TYPE_TABLE." WHERE questionType = 'radio'");
		if($radioQuestionType == 0) {
			$wpdb->insert(QUESTION_TYPE_TABLE, array("questionType" => "radio", "friendlyName" => "Radio"), array('%s', '%s'));
			rsvp_printQueryDebugInfo();
		}
		
		if((count($_POST) > 0) && !empty($_POST['question']) && is_numeric($_POST['questionTypeID'])) {
			check_admin_referer('rsvp_add_custom_question');
			if(isset($_SESSION[EDIT_QUESTION_KEY]) && is_numeric($_SESSION[EDIT_QUESTION_KEY])) {
				$wpdb->update(QUESTIONS_TABLE, 
											array("question" => trim($_POST['question']), 
											      "questionTypeID" => trim($_POST['questionTypeID']), 
														"permissionLevel" => ((trim($_POST['permissionLevel']) == "private") ? "private" : "public")), 
											array("id" => $_SESSION[EDIT_QUESTION_KEY]), 
											array("%s", "%d", "%s"), 
											array("%d"));
				rsvp_printQueryDebugInfo();
				$questionId = $_SESSION[EDIT_QUESTION_KEY];
				
				$answers = $wpdb->get_results($wpdb->prepare("SELECT id FROM ".QUESTION_ANSWERS_TABLE." WHERE questionID = %d", $questionId));
				if(count($answers) > 0) {
					foreach($answers as $a) {
						if(isset($_POST['deleteAnswer'.$a->id]) && (strToUpper($_POST['deleteAnswer'.$a->id]) == "Y")) {
							$wpdb->query($wpdb->prepare("DELETE FROM ".QUESTION_ANSWERS_TABLE." WHERE id = %d", $a->id));
						} elseif(isset($_POST['answer'.$a->id]) && !empty($_POST['answer'.$a->id])) {
							$wpdb->update(QUESTION_ANSWERS_TABLE, 
													  array("answer" => trim($_POST['answer'.$a->id])), 
													  array("id"=>$a->id), 
													  array("%s"), 
													  array("%d"));
							rsvp_printQueryDebugInfo();
						}
					}
				}
			} else {
				$wpdb->insert(QUESTIONS_TABLE, array("question" => trim($_POST['question']), 
				                                     "questionTypeID" => trim($_POST['questionTypeID']), 
																						 "permissionLevel" => ((trim($_POST['permissionLevel']) == "private") ? "private" : "public")),  
				                               array('%s', '%d', '%s'));
				rsvp_printQueryDebugInfo();
				$questionId = $wpdb->insert_id;
			}
			
			if(isset($_POST['numNewAnswers']) && is_numeric($_POST['numNewAnswers']) && 
			   in_array($_POST['questionTypeID'], $answerQuestionTypes)) {
				for($i = 0; $i < $_POST['numNewAnswers']; $i++) {
					if(isset($_POST['newAnswer'.$i]) && !empty($_POST['newAnswer'.$i])) {
						$wpdb->insert(QUESTION_ANSWERS_TABLE, array("questionID"=>$questionId, "answer"=>$_POST['newAnswer'.$i]));
						rsvp_printQueryDebugInfo();
					}
				}
			}
			
			if(strToLower(trim($_POST['permissionLevel'])) == "private") {
				$wpdb->query($wpdb->prepare("DELETE FROM ".QUESTION_ATTENDEES_TABLE." WHERE questionID = %d", $questionId));
				if(isset($_POST['attendees']) && is_array($_POST['attendees'])) {
					foreach($_POST['attendees'] as $aid) {
						if(is_numeric($aid) && ($aid > 0)) {
							$wpdb->insert(QUESTION_ATTENDEES_TABLE, array("attendeeID"=>$aid, "questionID"=>$questionId), array("%d", "%d"));
							rsvp_printQueryDebugInfo();
						}
					}
				}
			}
		?>
			<p>Custom Question saved</p>
			<p>
				<a href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=rsvp-admin-questions">Continue to Question List</a> | 
				<a href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=rsvp-admin-custom-question">Add another Question</a> 
			</p>
		<?php
		} else {
			$questionTypeId = 0;
			$question = "";
			$isNew = true;
			$questionId = 0;
			$permissionLevel = "public";
			$savedAttendees = array();
			unset($_SESSION[EDIT_QUESTION_KEY]);
			if(isset($_GET['id']) && is_numeric($_GET['id'])) {
				$qRs = $wpdb->get_results($wpdb->prepare("SELECT id, question, questionTypeID, permissionLevel FROM ".QUESTIONS_TABLE." WHERE id = %d", $_GET['id']));
				if(count($qRs) > 0) {
					$isNew = false;
					$_SESSION[EDIT_QUESTION_KEY] = $qRs[0]->id;
					$questionId = $qRs[0]->id;
					$question = stripslashes($qRs[0]->question);
					$permissionLevel = stripslashes($qRs[0]->permissionLevel);
					$questionTypeId = $qRs[0]->questionTypeID;
					
					if($permissionLevel == "private") {
						$aRs = $wpdb->get_results($wpdb->prepare("SELECT attendeeID FROM ".QUESTION_ATTENDEES_TABLE." WHERE questionID = %d", $questionId));
						if(count($aRs) > 0) {
							foreach($aRs as $a) {
								$savedAttendees[] = $a->attendeeID;
							}
						}
					}
				}
			} 
			
			$sql = "SELECT id, questionType, friendlyName FROM ".QUESTION_TYPE_TABLE;
			$questionTypes = $wpdb->get_results($sql);
			?>
				<script type="text/javascript">
					function addAnswer(counterElement) {
						var currAnswer = jQuery("#numNewAnswers").val();
						if(isNaN(currAnswer)) {
							currAnswer = 0;
						}
				
						var s = "<tr>\r\n"+ 
							"<td align=\"right\" width=\"75\"><label for=\"newAnswer" + currAnswer + "\">Answer:</label></td>\r\n" + 
							"<td><input type=\"text\" name=\"newAnswer" + currAnswer + "\" id=\"newAnswer" + currAnswer + "\" size=\"40\" /></td>\r\n" + 
						"</tr>\r\n";
						jQuery("#answerContainer").append(s);
						currAnswer++;
						jQuery("#numNewAnswers").val(currAnswer);
						return false;
					}
				
					jQuery(document).ready(function() {
						
						<?php
						if($isNew || !in_array($questionTypeId, $answerQuestionTypes)) {
						 	echo 'jQuery("#answerContainer").hide();';
						}
						
						if($isNew || ($permissionLevel == "public")) {
						?>
							jQuery("#attendeesArea").hide();
						<?php
						}
						?>
						jQuery("#questionType").change(function() {
							var selectedValue = jQuery("#questionType").val();
							if((selectedValue == 2) || (selectedValue == 4) || (selectedValue == 5)) {
								jQuery("#answerContainer").show();
							} else {
								jQuery("#answerContainer").hide();
							}
						})
						
						jQuery("#permissionLevel").change(function() {
							if(jQuery("#permissionLevel").val() != "public") {
								jQuery("#attendeesArea").show();
							} else {
								jQuery("#attendeesArea").hide();
							}
						})
					});
				</script>
				<form name="contact" action="admin.php?page=rsvp-admin-custom-question" method="post">
					<input type="hidden" name="numNewAnswers" id="numNewAnswers" value="0" />
					<?php wp_nonce_field('rsvp_add_custom_question'); ?>
					<p class="submit">
						<input type="submit" class="button-primary" value="<?php _e('Save'); ?>" />
					</p>
					<table id="customQuestions" class="form-table">
						<tr valign="top">
							<th scope="row"><label for="questionType">Question Type:</label></th>
							<td align="left"><select name="questionTypeID" id="questionType" size="1">
								<?php
									foreach($questionTypes as $qt) {
										echo "<option value=\"".$qt->id."\" ".(($questionTypeId == $qt->id) ? " selected=\"selected\"" : "").">".$qt->friendlyName."</option>\r\n";
									}
								?>
							</select>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="question">Question:</label></th>
							<td align="left"><input type="text" name="question" id="question" size="40" value="<?php echo htmlentities($question); ?>" /></td>
						</tr>
						<tr>
							<th scope="row"><label for="permissionLevel">Question Permission Level:</label></th>
							<td align="left"><select name="permissionLevel" id="permissionLevel" size="1">
								<option value="public" <?php echo ($permissionLevel == "public") ? " selected=\"selected\"" : ""; ?>>Public</option>
								<option value="private" <?php echo ($permissionLevel == "private") ? " selected=\"selected\"" : ""; ?>>Private</option>
							</select></td>
						</tr>
						<tr>
							<td colspan="2">
								<table cellpadding="0" cellspacing="0" border="0" id="answerContainer">
									<tr>
										<th>Answers</th>
										<th align="right"><a href="#" onclick="return addAnswer();">Add new Answer</a></th>
									</tr>
									<?php
									if(!$isNew) {
										$aRs = $wpdb->get_results($wpdb->prepare("SELECT id, answer FROM ".QUESTION_ANSWERS_TABLE." WHERE questionID = %d", $questionId));
										if(count($aRs) > 0) {
											foreach($aRs as $answer) {
										?>
												<tr>
													<td width="75" align="right"><label for="answer<?php echo $answer->id; ?>">Answer:</label></td>
													<td><input type="text" name="answer<?php echo $answer->id; ?>" id="answer<?php echo $answer->id; ?>" size="40" value="<?php echo htmlentities(stripslashes($answer->answer)); ?>" />
													 &nbsp; <input type="checkbox" name="deleteAnswer<?php echo $answer->id; ?>" id="deleteAnswer<?php echo $answer->id; ?>" value="Y" /><label for="deleteAnswer<?php echo $answer->id; ?>">Delete</label></td>
												</tr>
										<?php
											}
										}
									}
									?>
								</table>
							</td>
						</tr>
						<tr id="attendeesArea">
							<th scope="row"><label for="attendees">Attendees allowed to answer this question:</label></th>
							<td>
								<select name="attendees[]" id="attendees" style="height:75px;" multiple="multiple">
								<?php
									$attendees = $wpdb->get_results("SELECT id, firstName, lastName FROM ".$wpdb->prefix."attendees ORDER BY lastName, firstName");
									foreach($attendees as $a) {
								?>
									<option value="<?php echo $a->id; ?>" 
													<?php echo ((in_array($a->id, $savedAttendees)) ? " selected=\"selected\"" : ""); ?>><?php echo htmlentities(stripslashes($a->firstName)." ".stripslashes($a->lastName)); ?></option>
								<?php
									}
								?>
								</select>
							</td>
						</tr>
					</table>
				</form>
		<?php
		}
	}
	
	function rsvp_modify_menu() {
		
		add_options_page('RSVP Options',	//page title
	                   'RSVP Options',	//subpage title
	                   'manage_options',	//access
	                   'rsvp-options',		//current file
	                   'rsvp_admin_guestlist_options'	//options function above
	                   );
		$page = add_menu_page("RSVP Plugin", 
									"RSVP Plugin", 
									"publish_posts", 
									"rsvp-top-level", 
									"rsvp_admin_guestlist");
		add_action('admin_print_scripts-' . $page, 'rsvp_admin_scripts'); 
		$page = add_submenu_page("rsvp-top-level", 
										 "Add Guest",
										 "Add Guest",
										 "publish_posts", 
										 "rsvp-admin-guest",
										 "rsvp_admin_guest");
		add_action('admin_print_scripts-' . $page, 'rsvp_admin_scripts'); 
		add_submenu_page("rsvp-top-level", 
										 "RSVP Export",
										 "RSVP Export",
										 "publish_posts", 
										 "rsvp-admin-export",
										 "rsvp_admin_export");
		add_submenu_page("rsvp-top-level", 
										 "RSVP Import",
										 "RSVP Import",
										 "publish_posts", 
										 "rsvp-admin-import",
										 "rsvp_admin_import");
		$page = add_submenu_page("rsvp-top-level", 
										 "Custom Questions",
										 "Custom Questions",
										 "publish_posts", 
										 "rsvp-admin-questions",
										 "rsvp_admin_questions");
		add_action('admin_print_scripts-' . $page, 'rsvp_admin_scripts'); 
		$page = add_submenu_page("rsvp-top-level", 
										 "Add Custom Question",
										 "Add Custom Question",
										 "publish_posts", 
										 "rsvp-admin-custom-question",
										 "rsvp_admin_custom_question");
										 
        add_action('admin_print_scripts-' . $page, 'rsvp_admin_scripts'); 
	}
	
	function rsvp_register_settings() {
		register_setting('rsvp-option-group', OPTION_OPENDATE);
		register_setting('rsvp-option-group', OPTION_GREETING);
		register_setting('rsvp-option-group', OPTION_THANKYOU);
		register_setting('rsvp-option-group', OPTION_HIDE_VEGGIE);
		register_setting('rsvp-option-group', OPTION_HIDE_KIDS_MEAL);
		register_setting('rsvp-option-group', OPTION_NOTE_VERBIAGE);
		register_setting('rsvp-option-group', OPTION_VEGGIE_MEAL_VERBIAGE);
		register_setting('rsvp-option-group', OPTION_KIDS_MEAL_VERBIAGE);
		register_setting('rsvp-option-group', OPTION_YES_VERBIAGE);
		register_setting('rsvp-option-group', OPTION_NO_VERBIAGE);
		register_setting('rsvp-option-group', OPTION_DEADLINE);
		register_setting('rsvp-option-group', OPTION_THANKYOU);
		register_setting('rsvp-option-group', OPTION_HIDE_ADD_ADDITIONAL);
		register_setting('rsvp-option-group', OPTION_NOTIFY_EMAIL);
		register_setting('rsvp-option-group', OPTION_NOTIFY_ON_RSVP);
		register_setting('rsvp-option-group', OPTION_DEBUG_RSVP_QUERIES);
		register_setting('rsvp-option-group', OPTION_WELCOME_TEXT);
		register_setting('rsvp-option-group', OPTION_RSVP_QUESTION);
		register_setting('rsvp-option-group', OPTION_RSVP_CUSTOM_YES_NO);
		register_setting('rsvp-option-group', OPTION_RSVP_PASSCODE);
    register_setting('rsvp-option-group', RSVP_OPTION_HIDE_NOTE);
		
		wp_register_script('jquery_table_sort', plugins_url('jquery.tablednd_0_5.js',__FILE__));
		wp_register_script('jquery_ui', rsvp_getHttpProtocol()."://ajax.microsoft.com/ajax/jquery.ui/1.8.5/jquery-ui.js");
		wp_register_style('jquery_ui_stylesheet', rsvp_getHttpProtocol()."://ajax.microsoft.com/ajax/jquery.ui/1.8.5/themes/redmond/jquery-ui.css");
	}
	
	function rsvp_admin_scripts() {
		wp_enqueue_script("jquery_table_sort");
		wp_enqueue_script("jquery_ui");
		wp_enqueue_style( 'jquery_ui_stylesheet');
	}
	
	function rsvp_init() {
		wp_register_script('jquery_validate', rsvp_getHttpProtocol()."://ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/jquery.validate.min.js");
    wp_register_script('rsvp_plugin', plugins_url("rsvp_plugin.js", RSVP_PLUGIN_FILE));
    wp_register_style('rsvp_css', plugins_url("rsvp_plugin.css", RSVP_PLUGIN_FILE));
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery_validate');
    wp_enqueue_script('rsvp_plugin');
    wp_enqueue_style("rsvp_css");
    
		
		load_plugin_textdomain('rsvp-plugin', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}
	
	function rsvp_printQueryDebugInfo() {
		global $wpdb;
		
		if(get_option(OPTION_DEBUG_RSVP_QUERIES) == "Y") {
			echo "<br />Sql Output: ";
			$wpdb->print_error();
			echo "<br />";
		}
	}
	
	/*
	This function checks to see if the page is running over SSL/HTTPs and will return the proper HTTP protocol.
	
	Postcondition: The caller will receive the proper HTTP protocol to use at the beginning of a URL. 
	*/
	function rsvp_getHttpProtocol() {
		if(isset($_SERVER['HTTPS'])  && (trim($_SERVER['HTTPS']) != "")) {
			return "https";
		}
		return "http";
	}
  
  function rsvp_getCurrentPageURL() {
     $pageURL = rsvp_getHttpProtocol();
     
     $pageURL .= "://";
     if ($_SERVER["SERVER_PORT"] != "80") {
      $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
     } else {
      $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
     }
     return $pageURL;
  }
	
	add_action('admin_menu', 'rsvp_modify_menu');
	add_action('admin_init', 'rsvp_register_settings');
	add_action('init', 'rsvp_init');
	add_filter('the_content', 'rsvp_frontend_handler');
	register_activation_hook(__FILE__,'rsvp_database_setup');
?>
