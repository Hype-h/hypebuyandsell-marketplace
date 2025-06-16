<?php
// Installer to create necessary pages on plugin activation
function hypebuyandsell_create_pages() {
    $pages = array(
        'marketplace' => array(
            'title' => 'Marketplace',
            'content' => '[marketplace_categories]'
        ),
        'vendor-dashboard' => array(
            'title' => 'Vendor Dashboard',
            'content' => 'This is your vendor dashboard.'
        )
    );

    foreach ($pages as $slug => $page) {
        if (!get_page_by_path($slug)) {
            wp_insert_post(array(
                'post_title' => $page['title'],
                'post_name' => $slug,
                'post_content' => $page['content'],
                'post_status' => 'publish',
                'post_type' => 'page'
            ));
        }
    }
}
register_activation_hook(__FILE__, 'hypebuyandsell_create_pages');
?>