<?php
/*
Plugin Name: Hypebuyandsell Marketplace
Plugin URI: https://github.com/yourprofile/hypebuyandsell-marketplace
Description: A professional multi-vendor WooCommerce plugin with advanced category filtering, Elementor support, and vendor integration.
Version: 1.0.0
Author: Glen David
Author URI: https://hypebuyandsell.com
License: GPL2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: hypebuyandsell
Domain Path: /languages
*/

defined('ABSPATH') or die('No script kiddies please!');

// Load plugin files
include_once plugin_dir_path(__FILE__) . 'includes/class-marketplace-init.php';
include_once plugin_dir_path(__FILE__) . 'includes/class-marketplace-shortcode.php';
include_once plugin_dir_path(__FILE__) . 'includes/class-vendor-bridge.php';
include_once plugin_dir_path(__FILE__) . 'admin/class-marketplace-admin.php';

// Load styles
function hypebuyandsell_enqueue_scripts() {
    wp_enqueue_style('hypebuyandsell-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_enqueue_script('hypebuyandsell-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), false, true);
}
add_action('wp_enqueue_scripts', 'hypebuyandsell_enqueue_scripts');
?>