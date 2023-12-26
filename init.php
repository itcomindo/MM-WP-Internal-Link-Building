<?php

/**
 * Initialize the plugin
 */

defined('ABSPATH') or die('No script kiddies please!');


/**
 *=========================
 *NAME: Load Carbon Fields
 *=========================
 */
function mm_wp_internal_link_building_cf()
{
    require_once(plugin_dir_path(__FILE__) . 'vendor/autoload.php');
    \Carbon_Fields\Carbon_Fields::boot();
}

/**
 * Load Carbon Fields When Needed
 */
function mm_wp_internal_link_building_cf_loader()
{
    if (!function_exists('carbon_fields_boot_plugin')) {
        mm_wp_internal_link_building_cf();
    }
}
add_action('plugins_loaded', 'mm_wp_internal_link_building_cf_loader');
