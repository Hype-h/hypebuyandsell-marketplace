<?php
/*
Plugin Name: HypeBuy&Sell Workflow Plugin
Plugin URI: https://github.com/Hype-h/hypebuyandsell-marketplace
Description: A workflow automation system for marketplace tasks, vendors, orders, and reviews.
Version: 1.0.0
Author: Hype-h
Author URI: https://github.com/Hype-h
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
GitHub Plugin URI: https://github.com/Hype-h/hypebuyandsell-marketplace
Primary Branch: main
*/

defined('ABSPATH') || exit;

// Set activation flag for admin notice
function workflow_plugin_activate() {
    set_transient('workflow_plugin_activated', true, 5);
}
register_activation_hook(__FILE__, 'workflow_plugin_activate');

// Load plugin hooks
require_once plugin_dir_path(__FILE__) . 'includes/hooks.php';
?>
