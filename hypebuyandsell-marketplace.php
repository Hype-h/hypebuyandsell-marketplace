<?php
/**
 * Plugin Name: Hypebuyandsell Marketplace
 * Description: Fully-featured marketplace with category filters, sorting, product previews, and Elementor support.
 * Version: 5.0
 * Author: HypeBuyAndSell
 * Text Domain: hypebuyandsell-marketplace
 */

if (!defined('ABSPATH')) exit;

// Enqueue styles and scripts
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('hypebuyandsell-marketplace', plugin_dir_url(__FILE__) . 'style.css');
    wp_enqueue_script('hypebuyandsell-marketplace', plugin_dir_url(__FILE__) . 'script.js', [], false, true);
});

// Load translations
add_action('init', function() {
    load_plugin_textdomain('hypebuyandsell-marketplace', false, dirname(plugin_basename(__FILE__)) . '/languages');
});

// Register Elementor widget
add_action('elementor/widgets/widgets_registered', function() {
    if (defined('ELEMENTOR_PATH') || class_exists('Elementor\Widget_Base')) {
        require_once plugin_dir_path(__FILE__) . 'widget.php';
    }
});

// Shortcode
add_shortcode('marketplace_categories', function() {
    ob_start();
    ?>
    <div class="marketplace-filters">
        <select id="categoryFilter"><option value="">All Categories</option>
        <?php
            $cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => 0]);
            foreach ($cats as $c) {
                echo "<option value='$c->term_id'>$c->name</option>";
            }
        ?>
        </select>

        <select id="sortOption">
            <option value="az">Sort A–Z</option>
            <option value="za">Sort Z–A</option>
            <option value="count">Most Products</option>
        </select>
    </div>

    <div class="marketplace-container" id="marketplaceContainer">
        <?php echo do_shortcode('[render_marketplace_content]'); ?>
    </div>
    <?php
    return ob_get_clean();
});

// Internal rendering logic
add_shortcode('render_marketplace_content', function() {
    $terms = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => 0]);
    usort($terms, fn($a, $b) => strcmp($a->name, $b->name));

    foreach ($terms as $term) {
        $icon = '🛍️';
        switch ($term->name) {
            case 'Consumer Goods & Retail': $icon = '🛍️'; break;
            case 'Industry & Construction': $icon = '🏗️'; break;
            case 'Food & Agriculture': $icon = '🌾'; break;
            case 'Automotive & Transport': $icon = '🚗'; break;
            case 'Media & Entertainment': $icon = '🎬'; break;
            case 'Health & Medical': $icon = '🩺'; break;
            case 'Business, Services & Real Estate': $icon = '🏢'; break;
            case 'Financial & Insurance': $icon = '💰'; break;
            case 'Energy & Utilities': $icon = '⚡'; break;
        }

        $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
        $image = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : '';
        echo '<div class="marketplace-card" data-category="'.$term->term_id.'">';
        echo '<div class="icon">' . $icon . '</div>';
        if ($image) echo '<div class="image"><img src="' . esc_url($image) . '" alt="' . esc_attr($term->name) . '"></div>';
        echo '<h3>' . esc_html($term->name) . '</h3>';

        $children = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => $term->term_id]);
        if ($children) {
            echo '<ul class="subcategories">';
            foreach ($children as $child) {
                echo '<li>' . esc_html($child->name) . ' (' . $child->count . ')</li>';

                $products = new WP_Query([
                    'post_type' => 'product',
                    'posts_per_page' => 3,
                    'tax_query' => [[
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'terms' => $child->term_id
                    ]]
                ]);
                if ($products->have_posts()) {
                    echo '<div class="product-previews">';
                    while ($products->have_posts()) {
                        $products->the_post();
                        global $product;
                        echo '<div class="product-preview">';
                        echo get_the_post_thumbnail(get_the_ID(), 'woocommerce_thumbnail');
                        echo '<div class="product-title">' . get_the_title() . '</div>';
                        echo '<div class="product-price">' . $product->get_price_html() . '</div>';
                        woocommerce_template_loop_add_to_cart(['quantity' => 1]);
                        echo '</div>';
                    }
                    echo '</div>';
                    wp_reset_postdata();
                }
            }
            echo '</ul>';
        }
        echo '</div>';
    }
}});

// End
?>
