<?php
// Hook for adding admin menus
add_action('admin_menu', 'wp_private_add_menu');

// Adding the admin Menu
function wp_private_add_menu() {
    add_submenu_page('options-general.php', 'Premium Content', 'Premium Content', 10, __FILE__, 'wp_private_add_adspage');
	//Ensure, that the needed javascripts been loaded to allow drag/drop, expand/collapse and hide/show of boxes
	wp_enqueue_script('common');
	wp_enqueue_script('wp-lists');
	wp_enqueue_script('postbox');
}

// action function for adding the administrative page
function wp_private_add_adspage() { 
	global $screen_layout_columns;
	
	add_meta_box('wp_private_how_to_block_instructions', 'How To Block Content', 'wp_private_how_to_block_instructions_HTML', 'col_1');
	add_meta_box('wp_private_how_to_block', 'How To Replace Blocked Content', 'wp_private_how_to_block_HTML', 'col_1');
	add_meta_box('wp_private_text_to_replace', 'Text To Replace Blocked Content', 'wp_private_text_to_replace_HTML', 'col_1');
	add_meta_box('wp_private_text_not_authorized', 'Text For Logged-in But Not Authorized Users', 'wp_private_text_not_authorized_HTML', 'col_1');
	add_meta_box('wp_private_who_cant_see', 'Users Who Can\'t See Blocked Content', 'wp_private_who_cant_see_HTML', 'col_1');
	add_meta_box('wp_private_custom_login_page', 'Custom Login Page', 'wp_private_custom_login_page_HTML', 'col_1');
	add_meta_box('wp_private_support_smartlogix', 'Support SmartLogix', 'wp_private_support_smartlogix_HTML', 'col_1');

	$parameters = 'wp_private_replacement_type, wp_private_before_html, wp_private_after_html, wp_private_linkback_enable, wp_private_selected_users, wp_private_not_authorized_text, wp_private_custom_login_page_url';
	wp_private_settings_page_layout($parameters, 'WP-PRIVATE : Premium Content Manager');
}

function wp_private_how_to_block_instructions_HTML() { ?>
<div style="margin: 10px 0;">
	You can block any content anywhere in your POSTS/PAGES by Surrounding the text to be privatized with [protected] and [/protected].
</div>
<?php }

function wp_private_how_to_block_HTML() { ?>
<table cellspacing="10px;">
	<tr>
		<td><input type="radio" name="wp_private_replacement_type" value="form" style="vertical-align:bottom;" <?php if(get_option('wp_private_replacement_type') == 'form') { echo " checked='checked'"; } ?> /> Replace Blocked Content with A Login Form. <img id="wp_private_login_form_help" src="<?php echo WP_PLUGIN_URL; ?>/wp-private/images/help.png" style="vertical-align:bottom;" /></td>
	</tr>
	<tr>
		<td><input type="radio" name="wp_private_replacement_type" value="link" style="vertical-align:bottom;" <?php if(get_option('wp_private_replacement_type') == 'link') { echo " checked='checked'"; } ?> /> Replace Blocked Content with Login and Register Link. <img id="wp_private_login_link_help" src="<?php echo WP_PLUGIN_URL; ?>/wp-private/images/help.png" style="vertical-align:bottom;" /></td>
	</tr>
	<tr>
		<td><input type="radio" name="wp_private_replacement_type" value="custom" style="vertical-align:bottom;" <?php if(get_option('wp_private_replacement_type') == 'custom') { echo " checked='checked'"; } ?> /> Replace Blocked Content with Custom HTML. <img id="wp_private_login_custom_help" src="<?php echo WP_PLUGIN_URL; ?>/wp-private/images/help.png" style="vertical-align:bottom;" /></td>
	</tr>
</table>
<script type="text/javascript">
	jQuery("#wp_private_login_form_help").qtip({
		content: '<img style="margin: 10px 20px 10px 0px;" src="<?php echo WP_PLUGIN_URL; ?>/wp-private/images/login_form.png"/>',
		style: { 
		width: 307,
		background: '#FFFFFF',
		color: 'black',
		textAlign: 'left',
		border: {
		width: 2,
		radius: 3,
		color: '#E2E2E2'
		},
		tip: 'topLeft',
		name: 'dark' // Inherit the rest of the attributes from the preset dark style
		}
	});
	jQuery("#wp_private_login_link_help").qtip({
		content: '<img style="margin: 10px 20px 10px 0px;" src="<?php echo WP_PLUGIN_URL; ?>/wp-private/images/login_link.png"/>',
		style: { 
		width: 307,
		background: '#FFFFFF',
		color: 'black',
		textAlign: 'left',
		border: {
		width: 2,
		radius: 3,
		color: '#E2E2E2'
		},
		tip: 'topLeft',
		name: 'dark' // Inherit the rest of the attributes from the preset dark style
		}
	});
	jQuery("#wp_private_login_custom_help").qtip({
		content: '<img style="margin: 10px 20px 10px 0px;" src="<?php echo WP_PLUGIN_URL; ?>/wp-private/images/login_custom.png"/>',
		style: { 
		width: 307,
		background: '#FFFFFF',
		color: 'black',
		textAlign: 'left',
		border: {
		width: 2,
		radius: 3,
		color: '#E2E2E2'
		},
		tip: 'topLeft',
		name: 'dark' // Inherit the rest of the attributes from the preset dark style
		}
	});
</script>
<?php }

function wp_private_text_to_replace_HTML() { ?>
<table cellspacing="10px;">
	<tr valign="top">
		<td>HTML to Insert<br>Before protected Area<br>(For Non Logged in users)</td>
		<td width="15px"></td>
		<td>
			<textarea style="width: 350px; height: 140px;" name="wp_private_before_html" id="wp_private_before_html"><?php echo get_option('wp_private_before_html'); ?></textarea><br>
			<small>eg : This is protected Content. Please Login to read</small>
		</td>
	</tr>
	<tr><td colspan="3">&nbsp;</td></tr>
	<tr valign="top">
		<td>HTML to Insert<br>After protected Area<br>(For Non Logged in users)</td>
		<td width="15px"></td>
		<td>
			<textarea style="width: 350px; height: 140px;" name="wp_private_after_html" id="wp_private_after_html"><?php echo get_option('wp_private_after_html'); ?></textarea><br>
			<small>eg : Enter your user name and password above to access premiun Content</small>
		</td>
	</tr>
</table>
<?php }

function wp_private_text_not_authorized_HTML() { ?>
<div style="margin: 10px 0;">
	<textarea style="width: 100%; height: 250px;" name="wp_private_not_authorized_text" id="wp_private_not_authorized_text"><?php echo get_option('wp_private_not_authorized_text'); ?></textarea>
</div>
<?php }

function wp_private_who_cant_see_HTML() { ?>
<table cellspacing="0" class="widefat fixed" style="margin: 0 0 10px;">
<thead>
	<tr class="thead">
		<th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox" onchange="pickAll(this)" id="users_selectall_1"></th>
		<th style="" class="manage-column column-username" id="username" scope="col">Username</th>
		<th style="" class="manage-column column-name" id="name" scope="col">Name</th>
	</tr>
</thead>
<tfoot>
	<tr class="thead">
		<th style="" class="manage-column column-cb check-column" scope="col"><input type="checkbox" onchange="pickAll(this)" id="users_selectall_2"></th>
		<th style="" class="manage-column column-username" scope="col">Username</th>
		<th style="" class="manage-column column-name" scope="col">Name</th>
	</tr>
</tfoot>
<tbody class="list:user user-list" id="users">
	<?php
	$blogusers = get_users_of_blog(); //gets registered users
	$users = '';
	if ($blogusers) {
		$count = 0;
		foreach ($blogusers as $bloguser) {
			$user = get_userdata($bloguser->user_id);
			if($users != "") { $users .= ",".$user->ID; } else { $users = $user->ID; } ?>
			<tr<?php if(($count % 2) == 0) { echo ' class="alternate"'; } $count++; ?>>
				<th class="check-column" scope="row"><input onchange="pickUser(<?php echo $user->ID; ?>)" type="checkbox" value="<?php echo $user->ID; ?>" id="user_<?php echo $user->ID; ?>" name="users[]"></th>
				<td class="username column-username"><strong><a href="profile.php"><?php echo $user->user_login; ?></a></strong></td>
				<td class="name column-name"><?php echo $user->first_name." ".$user->last_name; ?></td>
			</tr>
		<?php }
	}
	else { echo "No Users!"; }
	?>
</tbody>
</table>
<small>Select the Users who dont have the privilage to see the premium content</small>
<input id="wp_private_selected_users" name="wp_private_selected_users" type="hidden" value="<?php echo get_option('wp_private_selected_users'); ?>" />
<input id="wp_private_all_users" type="hidden" value="<?php echo $users; ?>" />
<script type="text/javascript">
	var temp = document.getElementById('wp_private_all_users').value;
	var allUsers = temp.split(",");
	temp = document.getElementById('wp_private_selected_users').value;
	var selectedUsers = temp.split(",");
	for(var i = 0; i < selectedUsers.length; i++) {
		if(document.getElementById('user_'+selectedUsers[i])) {
			document.getElementById('user_'+selectedUsers[i]).checked = true;
		}
	}
	
	function pickUser(id) {
		if(document.getElementById('user_'+id)) {
			if(document.getElementById('user_'+id).checked == true) {
				selectedUsers.push(id);
			} else {
				var index;
				for(var i = 0; i < selectedUsers.length; i++) {
					if(selectedUsers[i] == id) {
						index = i;				}
				}
				selectedUsers.splice(index, 1);
			}
		}
		document.getElementById('wp_private_selected_users').value = selectedUsers.join(',');
		document.getElementById("users_selectall_1").checked = false;
		document.getElementById("users_selectall_2").checked = false;
	}
	
	function pickAll(sender) {
		if(sender.checked == true) {
			document.getElementById('wp_private_selected_users').value = document.getElementById('wp_private_all_users').value;
			temp = document.getElementById('wp_private_selected_users').value;
			selectedUsers = temp.split(",");
		} else {
			document.getElementById('wp_private_selected_users').value = "";
			selectedUsers = null;
		}
	}
</script>
<?php }

function wp_private_custom_login_page_HTML() { ?>
<div style="margin: 10px 0;">
	You can show the custom Login Form anywhere in your POSTS/PAGES by using the shortcode [loginform]. 
</div>
<table cellspacing="10px;">
	<tr valign="top">
		<td>Custom Login Page URL</td>
		<td width="15px"></td>
		<td>
			<input type="text" style="width: 350px;" name="wp_private_custom_login_page_url" id="wp_private_custom_login_page_url" value="<?php echo get_option('wp_private_custom_login_page_url'); ?>" /><br>
			<small>This is URL to the page where you have pasted in the shortcode [loginform]</small>
		</td>
	</tr>
</table>
<?php }

function wp_private_support_smartlogix_HTML() { ?>
<div style="margin: 10px 0;">
	<input type="checkbox" checked="checked" value="1"  style="vertical-align: bottom;" name="wp_private_linkback_enable" id="wp_private_linkback_enable"> Support SmartLogix. <img id="wp_private_linkback_help" src="<?php echo WP_PLUGIN_URL; ?>/wp-private/images/help.png" style="vertical-align:bottom;" />
</div>
<script type="text/javascript">
	jQuery("#wp_private_linkback_help").qtip({
		content: 'Shows a tiny "Content Protected by SmartLogix" message in the Login Form.<br/>(We Really appreciate you leaving this option enabled)',
		style: { 
		width: 400,
		background: '#FFFFFF',
		color: 'black',
		textAlign: 'left',
		border: {
		width: 2,
		radius: 3,
		color: '#E2E2E2'
		},
		tip: 'topLeft',
		name: 'dark' // Inherit the rest of the attributes from the preset dark style
		}
	});
</script>
<?php }
?>