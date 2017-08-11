<?php
add_shortcode('protected', 'wp_private_protected_shortcode');

function wp_private_protected_shortcode($atts, $content = null) {
	if(wp_private_is_loggedin()) {
		if(wp_private_is_user_approved()) {
			return do_shortcode($content);
		} else {
			return get_option('wp_private_not_authorized_text');
		}
	} else {
		return wp_private_get_logged_out_data();
	}
}

add_filter('the_content', 'wp_private_content');

function wp_private_content($content) {
	$begin = strpos($content, '<!--protected-->');
	$end = strpos($content, '<!--/protected-->');
	if($begin != $end) {
		$prefix = substr($content,0,$begin);
		$suffix = substr($content,$end,strlen($content));
		if(wp_private_is_loggedin()) {
			if(wp_private_is_user_approved()) {
				return $content;
			} else {
				return $prefix.get_option('wp_private_not_authorized_text').$suffix;
			}
		} else {
			return $prefix.wp_private_get_logged_out_data().$suffix;
		}
	} else {
		return $content;
	}
}

add_shortcode('loginform', 'wp_private_loginform_shortcode');

function wp_private_loginform_shortcode($atts, $content = null) {
	global $user_login;
	if(wp_private_is_loggedin()) {
		return 'Hello, '.$user_login.'. <a href="'.wp_logout_url($_SERVER['REQUEST_URI']).'" title="Logout">Logout</a>';
	} else {
		$redirect = $_SERVER['REQUEST_URI'];
		if(!empty($_GET['redirect'])) {
			$redirect = urldecode($_GET['redirect']);
		}
		return '<form action="'.get_bloginfo('url').'/wp-login.php" method="post">
					<table>				
						<tr><td align="left"><label>User Name</label></td><td>:</td><td><input type="text" name="log" id="log" value="'.wp_specialchars(stripslashes($user_login), 1).'" size="22" /></td></tr>
						<tr><td align="left"><label>Password</label></td><td>:</td><td><input type="password" name="pwd" id="pwd" size="22" /></td></tr>
						<tr valign="bottom"><td align="right" colspan="3"><input type="submit" value="Login" name="submit" class="submit_bt" /><input type="hidden" name="redirect_to" value="'.$redirect.'"/></td></tr>
					</table>
				</form>';
	}
}
?>