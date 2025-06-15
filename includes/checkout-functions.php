<?php
/**
 * Vendor Dashboard Template Matching HypeBuy&Sell Homepage
 */

function hbsvd_vendor_dashboard_shortcode() {
    if (!is_user_logged_in()) {
        return '<p>You must be logged in to view your vendor dashboard.</p>';
    }

    $user_id = get_current_user_id();
    $store_url = function_exists('wcfm_get_vendor_store_url') ? wcfm_get_vendor_store_url($user_id) : '#';

    ob_start();
    ?>
    <div class="hbsvd-logo-header">
        <img src="/wp-content/uploads/hbs-logo.png" alt="HBS Logo">
        <h1>Welcome to HBS Marketplace</h1>
    </div>
    <section class="hbsvd-hero-section">
        <div class="hbsvd-hero-content">
            <h2>📦 Welcome to Your Vendor Dashboard</h2>
            <p>Manage your products, orders, reports and storefront efficiently.</p>
            <div class="hbsvd-button-grid">
                <a href="/shop-manager/products" class="hbsvd-btn">🛒 Manage Products</a>
                <a href="/shop-manager/orders" class="hbsvd-btn">📦 View Orders</a>
                <a href="/shop-manager/coupons" class="hbsvd-btn">🎟️ Coupons</a>
                <a href="/shop-manager/reports" class="hbsvd-btn">📈 Reports</a>
                <a href="/shop-manager/settings" class="hbsvd-btn">⚙️ Store Settings</a>
                <a href="<?php echo esc_url($store_url); ?>" class="hbsvd-btn">🌐 View Storefront</a>
            </div>
        </div>
    </section>
    <section class="hbsvd-content-section">
        <div class="hbsvd-container">
            <h3>🛍️ Your Products</h3>
            <?php echo do_shortcode('[products author="' . esc_attr($user_id) . '" limit="8" columns="4"]'); ?>
        </div>
    </section>
    <section class="hbsvd-analytics-section">
        <div class="hbsvd-container">
            <h3>📊 Sales Analytics</h3>
            <?php echo do_shortcode('[hbsvd_analytics]'); ?>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('hbsvd_vendor_dashboard', 'hbsvd_vendor_dashboard_shortcode');

add_action('wp_head', function () {
    echo '<style>
    .hbsvd-logo-header{text-align:center;padding:20px 0;background:#fff}
    .hbsvd-logo-header img{height:60px;margin-bottom:10px}
    .hbsvd-logo-header h1{margin:0;font-size:24px;color:#f68b1e}
    .hbsvd-hero-section{background:linear-gradient(135deg,#f68b1e,#e47911);color:#fff;padding:40px;text-align:center}
    .hbsvd-hero-content h2{font-size:32px;font-weight:bold;margin-bottom:20px}
    .hbsvd-hero-content p{font-size:16px;margin-bottom:30px}
    .hbsvd-button-grid{display:flex;flex-wrap:wrap;gap:20px;justify-content:center}
    .hbsvd-btn{background:#fff;color:#f68b1e;padding:12px 20px;border-radius:8px;font-weight:bold;text-decoration:none;transition:.3s;box-shadow:0 3px 6px rgba(0,0,0,.1)}
    .hbsvd-btn:hover{background:#e47911;color:#fff;box-shadow:0 5px 12px rgba(0,0,0,.2)}
    .hbsvd-content-section,.hbsvd-analytics-section{padding:30px;background:#fff}
    .hbsvd-container{max-width:1000px;margin:0 auto}
    .hbsvd-container h3{font-size:24px;font-weight:bold;color:#f68b1e;margin-bottom:20px}
    </style>';
});
