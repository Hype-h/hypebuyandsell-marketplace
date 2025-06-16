<?php
// Enhanced setup wizard with tabs and vendor detection
add_action('admin_menu', 'hypebuyandsell_add_admin_menu');
function hypebuyandsell_add_admin_menu() {
    add_menu_page(
        'Hypebuyandsell Setup',
        'Hypebuyandsell',
        'manage_options',
        'hypebuyandsell-setup',
        'hypebuyandsell_setup_page',
        'dashicons-admin-generic',
        60
    );
}

function hypebuyandsell_setup_page() {
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'welcome';
    ?>
    <div class="wrap">
        <h1 class="nav-tab-wrapper">
            <a href="?page=hypebuyandsell-setup&tab=welcome" class="nav-tab <?php echo $active_tab == 'welcome' ? 'nav-tab-active' : ''; ?>">Welcome</a>
            <a href="?page=hypebuyandsell-setup&tab=appearance" class="nav-tab <?php echo $active_tab == 'appearance' ? 'nav-tab-active' : ''; ?>">Appearance</a>
            <a href="?page=hypebuyandsell-setup&tab=vendors" class="nav-tab <?php echo $active_tab == 'vendors' ? 'nav-tab-active' : ''; ?>">Vendor Settings</a>
        </h1>

        <div style="padding: 20px; background: #fff; border: 1px solid #ccc;">
            <?php
            if ($active_tab == 'welcome') {
                echo '<h2>Welcome to Hypebuyandsell Marketplace!</h2>';
                echo '<p>Use this setup wizard to configure your marketplace. Select a tab above to begin.</p>';
            } elseif ($active_tab == 'appearance') {
                ?>
                <form method="post" action="options.php">
                    <?php
                    settings_fields('hypebuyandsell_settings_group');
                    do_settings_sections('hypebuyandsell-setup');
                    submit_button();
                    ?>
                </form>
                <?php
            } elseif ($active_tab == 'vendors') {
                echo '<h2>Vendor Integration</h2>';
                if (class_exists('WeDevs_Dokan')) {
                    echo '<p><strong>Dokan</strong> is installed and active. Vendor features are enabled.</p>';
                } elseif (defined('WCFM_VERSION')) {
                    echo '<p><strong>WCFM Marketplace</strong> is installed and active. Vendor features are enabled.</p>';
                } else {
                    echo '<p>No vendor plugin detected. Please install Dokan or WCFM for full marketplace support.</p>';
                }
            }
            ?>
        </div>
    </div>
    <?php
}

add_action('admin_init', 'hypebuyandsell_register_settings');
function hypebuyandsell_register_settings() {
    register_setting('hypebuyandsell_settings_group', 'hypebuyandsell_theme_color');
    add_settings_section('hypebuyandsell_main_section', 'Appearance Settings', null, 'hypebuyandsell-setup');

    add_settings_field('theme_color', 'Primary Theme Color', function() {
        $value = get_option('hypebuyandsell_theme_color', '#764ba2');
        echo '<input type="text" name="hypebuyandsell_theme_color" value="' . esc_attr($value) . '" class="regular-text" />';
    }, 'hypebuyandsell-setup', 'hypebuyandsell_main_section');
}
?>