<?php
// Vendor plugin integrations (Dokan/WCFM)
if (class_exists('WeDevs_Dokan')) {
    add_action('dokan_store_profile_frame_after', function($store_user, $store_info) {
        echo '<div class="hypebuyandsell-vendor-section">Custom vendor content for Dokan</div>';
    });
}

if (defined('WCFM_VERSION')) {
    add_action('wcfmmp_store_tab_content', function($store_id) {
        echo '<div class="hypebuyandsell-vendor-section">Custom vendor content for WCFM</div>';
    });
}
?>