<?php
//avoid direct calls to this file where wp core files not present
if (!function_exists ('add_action')) {
		header('Status: 403 Forbidden');
		header('HTTP/1.1 403 Forbidden');
		exit();
}

// Pre-2.6 compatibility
if ( ! defined( 'WP_CONTENT_URL' ) )
      define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
      define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
      define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
      define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
	  
function wp_private_settings_page_layout($page_parameters, $page_title) { ?>
<style type="text/css">
#submit {
	background: green none repeat scroll 0% 0% !important;
	height: 60px;
	font-weight: bold;
	font-size: 26px !important;
	width: 80%;
	margin:auto;
	display: block;
}
.inside {
	font-size: 13px !important;
}
#wp_private_before_html_tbl, #wp_private_after_html_tbl, #wp_private_not_authorized_text_tbl {
	border: 1px solid #DFDFDF;
}
.widefat tbody th.check-column {
	padding:7px 0;
	vertical-align:bottom;
}
.widefat td {
	padding:7px;
	vertical-align:top;
}
</style>
<script type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/wp-private/js/jquery.qtip-1.0.0-rc3.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('url'); ?>/wp-includes/js/tinymce/tiny_mce.js"></script>
<div id="post_ads_container" class="wrap">
<div class="icon32" style="background: url(<?php echo WP_PLUGIN_URL; ?>/wp-private/images/lock.png) no-repeat;"><br></div>
<h2><?php echo $page_title; ?></h2>
<div class="updated fade below-h2" id="message" style="opacity:0;display:none;"><p>Changes have been made to this page.  Please click <b>Save Changes</b> to make them permanent</p></div>
<?php wp_private_show_support_options(); ?>
<form method="post" action="options.php">
<?php
wp_nonce_field('update-options');
wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );
?>
			<div id="poststuff" class="metabox-holder has-right-sidebar">
				<div id="side-info-column" class="inner-sidebar">
				<p style="text-align:center;">
					<script type="text/javascript" src="http://www.wp-insert.smartlogix.co.in/wp-content/plugins/wp-adnetwork/wp-adnetwork.php?showad=1"></script>
				</p>
				<?php do_meta_boxes('col_2','advanced',null); ?>
				<p class="submit wp-insert-submit">
					<input type="hidden" name="action" value="update" />
					<input type="hidden" name="page_options" value="<?php echo $page_parameters; ?>" />
					<input type="submit" id="submit" class="button-primary button-wp-private" value="<?php _e('Save Changes') ?>" />
				</p>
				</div>
				<div id="post-body" class="has-sidebar">				
					<div id="post-body-content" class="has-sidebar-content">
						<?php do_meta_boxes('col_1','advanced',null); ?>
					</div>
				</div>
				<br class="clear"/>			
			</div>	
		</form>
		</div>
	<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready( function($) {
			// close postboxes that should be closed
			jQuery('.if-js-closed').removeClass('if-js-closed').addClass('closed');
			jQuery('.postbox').addClass('closed');
			// postboxes setup
			postboxes.add_postbox_toggles('wp-insert');
		});
		//]]>
	</script>
</div>
<?php }

function wp_private_show_support_options() { ?>
	<table class="form-table">
		<tr valign="bottom">
			<th scope="row">
				<small><span style="color:#FF0000;"><b>Donate a few Dollars</b></span><br/><span style="color:#008E04;">Support our FREE Plugins</span><br/>You Might Also Like <a target="_blank" href="http://wordpress.org/extend/plugins/wp-insert/">WP-INSERT</a></small>
			</th>
			<td width="100px">
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="7834514">
				<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form>
			</td>
			<td>
			<b>Think we have done a great job?</b><br/><a target="_blank" href="http://wordpress.org/extend/plugins/wp-private/">Rate the plugin</a> or <a target="_blank" href="http://www.smartlogix.co.in/">Leave Us a Comment</a><br/>
			<b></b>Let us match your blog to your website : <a target="_blank" href="http://www.smartlogix.co.in/request-a-free-quote/">Request a Quote</a></td>
		</tr>
	</table>
<?php }

function wp_private_is_user_approved() {
	global $current_user, $user_ID;
	$isUserApproved = true;
	if($user_ID) {
		$users = explode(",", get_option('wp_private_selected_users'));
		foreach($users as $user) {
			if(($user_ID == $user) || ($current_user == 0)) {
				$isUserApproved = false;
			}
		}
		if($isUserApproved) {
			return true;
		} else {
			return false; 
		}
	} else {
		return false;
	}
}

function wp_private_is_loggedin() {
	global $user_ID;
	if($user_ID) {
		return true;
	} else {
		return false;
	}
}

function wp_private_get_logged_out_data() {
	if(get_option('wp_private_linkback_enable')) {
		$linkback = '<span style="float:left;font-family:times New Roman;font-size:9px;">Content Protected by <a href="http://www.smartlogix.co.in" title="The Wordpress Experts">SmartLogix</a></span>';
	} else {
		$linkback = '';
	}
	
	$prefix = get_option('wp_private_before_html');
	$suffix = get_option('wp_private_after_html');
				
	if(get_option('wp_private_replacement_type') == 'form') {
		return $prefix.'<form action="'.get_bloginfo('url').'/wp-login.php" method="post">
					<table>				
						<tr><td align="left"><label>User Name</label></td><td>:</td><td><input type="text" name="log" id="log" value="'.wp_specialchars(stripslashes($user_login), 1).'" size="22" /></td></tr>
						<tr><td align="left"><label>Password</label></td><td>:</td><td><input type="password" name="pwd" id="pwd" size="22" /></td></tr>
						<tr valign="bottom"><td align="right" colspan="3">'.$linkback.'<input type="submit" value="Login" name="submit" class="submit_bt" /><input type="hidden" name="redirect_to" value="'.$_SERVER['REQUEST_URI'].'"/></td></tr>
					</table>
				</form>'.$suffix;
	} else if(get_option('wp_private_replacement_type') == 'link') {
		if(get_option('wp_private_custom_login_page_url')) {
			$loginLink =  get_option('wp_private_custom_login_page_url');
			if(strpos($loginLink, '?')) {
				$loginLink .= '&redirect='.urlencode($_SERVER['REQUEST_URI']);
			} else {
				$loginLink .= '?redirect='.urlencode($_SERVER['REQUEST_URI']);
			}
		} else {
			$loginLink =  get_option('siteurl').'/wp-login.php';
		}
		return $prefix.'Please <a href="'.$loginLink.'">Login</a> or <a href="'.get_option('siteurl').'/wp-register.php">Register</a> for access.'.$suffix;
	} else {
		return $prefix.$suffix;
	}
}
?>