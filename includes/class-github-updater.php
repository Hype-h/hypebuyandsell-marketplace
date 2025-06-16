<?php
// GitHub Updater Integration
add_filter('pre_set_site_transient_update_plugins', 'hypebuyandsell_github_plugin_update');
add_filter('plugins_api', 'hypebuyandsell_github_plugin_info', 20, 3);

define('HYPEBUYANDSELL_GITHUB_USER', 'Hype-h');
define('HYPEBUYANDSELL_GITHUB_REPO', 'hypebuyandsell-marketplace');

function hypebuyandsell_github_plugin_update($transient) {
    if (empty($transient->checked)) return $transient;

    $plugin_slug = plugin_basename(__FILE__);
    $plugin_data = get_plugin_data(__FILE__);
    $github_api_url = "https://api.github.com/repos/" . HYPEBUYANDSELL_GITHUB_USER . "/" . HYPEBUYANDSELL_GITHUB_REPO . "/releases/latest";

    $response = wp_remote_get($github_api_url, [
        'headers' => ['Accept' => 'application/vnd.github.v3+json']
    ]);

    if (is_wp_error($response)) return $transient;

    $body = json_decode(wp_remote_retrieve_body($response));
    if (!isset($body->tag_name)) return $transient;

    $latest_version = ltrim($body->tag_name, 'v');
    $current_version = $plugin_data['Version'];

    if (version_compare($latest_version, $current_version, '>')) {
        $transient->response[$plugin_slug] = (object)[
            'slug' => $plugin_slug,
            'plugin' => $plugin_slug,
            'new_version' => $latest_version,
            'url' => $body->html_url,
            'package' => $body->assets[0]->browser_download_url,
        ];
    }

    return $transient;
}

function hypebuyandsell_github_plugin_info($res, $action, $args) {
    if ($action !== 'plugin_information') return false;
    if ($args->slug !== plugin_basename(__FILE__)) return $res;

    $github_api_url = "https://api.github.com/repos/" . HYPEBUYANDSELL_GITHUB_USER . "/" . HYPEBUYANDSELL_GITHUB_REPO . "/releases/latest";
    $response = wp_remote_get($github_api_url, [
        'headers' => ['Accept' => 'application/vnd.github.v3+json']
    ]);

    if (is_wp_error($response)) return $res;

    $body = json_decode(wp_remote_retrieve_body($response));
    if (!isset($body->tag_name)) return $res;

    return (object)[
        'name' => 'Hypebuyandsell Marketplace',
        'slug' => plugin_basename(__FILE__),
        'version' => ltrim($body->tag_name, 'v'),
        'author' => '<a href="#">Hypebuyandsell</a>',
        'homepage' => $body->html_url,
        'sections' => ['description' => 'Marketplace plugin auto-updated from GitHub.'],
        'download_link' => $body->assets[0]->browser_download_url,
    ];
}
?>