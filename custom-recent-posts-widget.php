<?php
/*
Plugin Name: Custom Recent Posts Widget
Plugin URI: http://www.prasannasp.net/custom-recent-posts-widget/
Description: This plugin creates a new widget which lets you display a list of recent posts based on categories or tags in widgetized areas. You can select the number of posts to display in widget settings. Widget title can be changed.
Version: 2.1.1
Author: Prasanna SP
Author URI: http://www.prasannasp.net/
*/

/*  This file is part of Custom Recent Posts Widget plugin. Copyright 2012 Prasanna SP (email: prasanna@prasannasp.net)

    Custom Recent Posts Widget plugin is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Custom Recent Posts Widget plugin is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Custom Recent Posts Widget plugin.  If not, see <http://www.gnu.org/licenses/>.
*/

/**
 * All magics are in /includes directory! So, just include them.
*/

define( 'CRPW_PLUGIN_PATH', plugin_dir_path(__FILE__) );
include CRPW_PLUGIN_PATH . 'includes/crpw-cat.php'; // Categories widget file
include CRPW_PLUGIN_PATH . 'includes/crpw-tag.php'; // Tags widget file

?>
