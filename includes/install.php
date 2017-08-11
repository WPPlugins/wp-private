<?php
function wp_private_install() {
if(!get_option('wp_private_replacement_type')) { add_option("wp_private_replacement_type", 'form', '', 'yes'); }
if(!get_option('wp_private_linkback_enable')) { add_option("wp_private_linkback_enable", '1', '', 'yes'); }
if(!get_option('wp_private_before_html')) { add_option("wp_private_before_html", '<br/><div id="wp-private-box"><b>This is protected content. ', '', 'yes'); }
if(!get_option('wp_private_after_html')) { add_option("wp_private_after_html", '</b></div><br/>', '', 'yes'); }
if(!get_option('wp_private_not_authorized_text')) { add_option("wp_private_after_html", '<b>You are not permitted to view Premium Content</b>', '', 'yes'); }
}
?>