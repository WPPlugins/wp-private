<?php
/*
Plugin Name: wp-private
Plugin URI: http://www.wp-private.smartlogix.co.in/
Description: Privatize parts of posts from unauthorized users. Begin protected content with [protected] and end hidden content with [/protected].
Version: 1.5
Author: Namith Jawahar
Author URI: http://www.smartlogix.co.in/

Surround the text to be privatized with [protected] and [/protected]
*/

/*  Copyright 2009  NAMITH JAWAHAR  (website : http://www.smartlogix.co.in)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
register_activation_hook(__FILE__, "wp_private_install");
require_once (dirname(__FILE__) . '/includes/essentials.php');
require_once (dirname(__FILE__) . '/includes/install.php');
require_once (dirname(__FILE__) . '/includes/admin.php');
require_once (dirname(__FILE__) . '/includes/hook.php');
?>