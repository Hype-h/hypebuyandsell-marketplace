<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

/**
 * Register a custom post type for Workflow Tasks
 */
function workflow_register_post_type() {
    register_post_type('workflow_task', [
        'labels' => [
            'name' => 'Workflow Tasks',
            'singular_name' => 'Workflow Task',
            'add_new' => 'Add New Task',
            'edit_item' => 'Edit Task',
            'new_item' => 'New Task',
            'view_item' => 'View Task',
            'search_items' => 'Search Tasks',
            'not_found' => 'No tasks found',
        ],
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-controls-repeat',
        'supports' => ['title', 'editor', 'custom-fields'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'workflow_register_post_type');

/**
 * Automatically approve reviews by trusted vendors
 */
function workflow_auto_approve_reviews($approved, $commentdata) {
    $user = get_user_by('email', $commentdata['comment_author_email']);
    if ($user && user_can($user, 'trusted_vendor')) {
        return 1; // Automatically approve
    }
    return $approved;
}
add_filter('pre_comment_approved', 'workflow_auto_approve_reviews', 10, 2);

/**
 * Show admin notice after plugin activation
 */
function workflow_activation_notice() {
    if (get_transient('workflow_plugin_activated')) {
        echo '<div class="notice notice-success is-dismissible">
            <p>✅ <strong>Workflow Plugin Activated!</strong> You can now create and manage workflow tasks from the admin menu.</p>
        </div>';
        delete_transient('workflow_plugin_activated');
    }
}
add_action('admin_notices', 'workflow_activation_notice');
?>
