<?php
/*
 * Plugin Name: LBYT - LB Youtube
 * Description: Insert with shortcode the last published youtube video from a channel.
 * Version: 1.0.0
 * Author: Lucas Bacciotti Moreira
 * Author URI: https://profiles.wordpress.org/baciotti/
 * License: GPLv2 or later
*/

use LBYT\Plugin;
use LBYT\SettingsPage;
use LBYT\Shortcode;

require_once "autoload.php";

add_action('plugins_loaded', 'lbyt_init');
function lbyt_init()
{
    $plugin = new Plugin();
    $plugin['path'] = realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR;
    $plugin['url'] = plugin_dir_url(__FILE__);
    $plugin['version'] = '1.0.0';
    $plugin['settings_page_properties'] = array(
        'page_title' => 'LB Youtube',
        'menu_title' => 'LB Youtube',
        'capability' => 'manage_options',
        'menu_slug' => 'lbyt-settings',
        'option_group' => 'lbyt_option_group',
        'option_name' => 'lbyt_youtube_option_name',
        'icon_url' => 'dashicons-youtube',
    );

    $plugin['settings_page'] = function ($plugin) {
        return new SettingsPage($plugin['settings_page_properties']);
    };

    $plugin['shortcode'] = function ($plugin) {
        return new Shortcode($plugin['settings_page_properties']);
    };

    $plugin->run();
}