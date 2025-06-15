<?php
/**
 * HBS Marketplace - Core Pages Shortcodes and Templates
 */

function hbsvd_logo_header() {
    return '<div class="hbsvd-logo-header"><img src="/wp-content/uploads/hbs-logo.png" alt="HBS Logo"><h1>Welcome to HBS Marketplace</h1></div>';
}
function hbsvd_container_wrap($title, $shortcode) {
    return '<section class="hbsvd-content-section"><div class="hbsvd-container"><h3>' . $title . '</h3>' . do_shortcode($shortcode) . '</div></section>';
}

add_shortcode('hbsvd_checkout_page', function () {
    return hbsvd_logo_header() . hbsvd_container_wrap('Secure Checkout', '[woocommerce_checkout]');
});
add_shortcode('hbsvd_cart_page', function () {
    return hbsvd_logo_header() . hbsvd_container_wrap('Your Cart', '[woocommerce_cart]');
});
add_shortcode('hbsvd_account_page', function () {
    return hbsvd_logo_header() . hbsvd_container_wrap('My Account', '[woocommerce_my_account]');
});
add_shortcode('hbsvd_faq_page', function () {
    return hbsvd_logo_header() . hbsvd_container_wrap('Frequently Asked Questions', '[sp_easyaccordion id="123"]');
});
add_shortcode('hbsvd_contact_form', function () {
    return hbsvd_logo_header() . hbsvd_container_wrap('Contact Us', '[contact-form-7 id="456" title="Contact form"]');
});
add_shortcode('hbsvd_my_orders', function () {
    return hbsvd_logo_header() . hbsvd_container_wrap('My Orders', '[woocommerce_my_account order]');
});
add_shortcode('hbsvd_refund_policy', function () {
    return hbsvd_logo_header() . '<section class="hbsvd-content-section"><div class="hbsvd-container"><h3>Refund and Returns Policy</h3><p>Our refund and returns policy lasts 14 days...</p></div></section>';
});
add_shortcode('hbsvd_registration_page', function () {
    return hbsvd_logo_header() . hbsvd_container_wrap('Register', '[woocommerce_my_account]');
});
add_shortcode('hbsvd_vendor_registration', function () {
    return hbsvd_logo_header() . hbsvd_container_wrap('Register as a Vendor', '[wcfm_vendor_registration]');
});
add_shortcode('hbsvd_store_list', function () {
    return hbsvd_logo_header() . hbsvd_container_wrap('Store Directory', '[wcfm_stores]');
});
add_shortcode('hbsvd_store_manager', function () {
    return hbsvd_logo_header() . hbsvd_container_wrap('Store Manager', '[wcfm_store_manager]');
});
add_shortcode('hbsvd_subscribe_form', function () {
    return hbsvd_logo_header() . hbsvd_container_wrap('Subscribe for Updates', '[mc4wp_form id="789"]');
});
add_shortcode('hbsvd_vendor_marketplace_chooser', function () {
    return hbsvd_logo_header() . hbsvd_container_wrap('Choose Your Marketplace', '[custom_marketplace_selector]');
});
