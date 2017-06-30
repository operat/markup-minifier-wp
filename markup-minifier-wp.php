<?php
/*
Plugin Name: Markup Minifier WP
Plugin URI: https://github.com/operat/markup-minifier-wp
GitHub Plugin URI: https://github.com/operat/markup-minifier-wp
Description: Minify HTML code by removing line breaks and spaces to reduce file size and improve performance.
Version: 1.2
Author: Operat
Author URI: https://www.operat.de
License: GNU GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

if (!defined('WPINC')) { die; }

define('MARKUP_MINIFIER_WP_NAME', 'Markup Minifier WP');
define('MARKUP_MINIFIER_WP_DESCRIPTION', 'Minify HTML code by removing line breaks and spaces to reduce file size and improve performance.');
define('MARKUP_MINIFIER_WP_URL', 'https://github.com/operat/markup-minifier-wp');

require_once 'MarkupMinifierWP.MarkupMinifier.php';
require_once 'MarkupMinifierWP.PluginManager.php';

add_action('get_header', array('MarkupMinifierWP_PluginManager', 'startMinifier'));
register_activation_hook(__FILE__, array('MarkupMinifierWP_PluginManager', 'setDefaultOptions'));

if (is_admin()) {
   require_once 'MarkupMinifierWP.SettingsPage.php';
   $settingsPage = new MarkupMinifierWP_SettingsPage();
}
