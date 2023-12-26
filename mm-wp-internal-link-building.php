<?php

/**
 * Plugin Name: MM WP Internal Link Building
 * Plugin URI: https://budiharyono.id/
 * Description: Internal Link Building for WordPress
 * Version: Beta.v1.0.0
 * Author: Budi Haryono
 * Author URI: https://budiharyono.id/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html 
 */

defined('ABSPATH') or die('No script kiddies please!');

require_once(plugin_dir_path(__FILE__) . 'init.php');
require_once(plugin_dir_path(__FILE__) . 'options.php');


function mm_ilb_style_script()
{
    wp_enqueue_style('mm-ilb-style', plugin_dir_url(__FILE__) . 'css/ilb.css', array(), '1.0.0', 'all');
    wp_enqueue_script('mm-ilb-script', plugin_dir_url(__FILE__) . 'js/ilb.js', array('jquery'), '1.0.0', true);
}
add_action(('admin_enqueue_scripts'), 'mm_ilb_style_script');




function mm_wp_internal_link_building_filter_content($content)
{
    $fields = carbon_get_theme_option('mm_wp_ilb');
    $open_in_new_tab = carbon_get_theme_option('mm_wp_ilb_open_new_tab') === true;

    if (!empty($fields)) {
        foreach ($fields as $field) {
            $keyword = $field['mm_wp_ilb_keyword'];
            $url = $field['mm_wp_ilb_url'];
            $rel_attributes = [];

            if ($field['mm_wp_ilb_dofollow'] !== true) {
                $rel_attributes[] = 'nofollow';
            }
            if ($field['mm_wp_ilb_noopener'] === true) {
                $rel_attributes[] = 'noopener';
            }
            if ($field['mm_wp_ilb_noreferrer'] === true) {
                $rel_attributes[] = 'noreferrer';
            }

            $rel_attribute_string = implode(' ', $rel_attributes);
            $target = $open_in_new_tab ? ' target="_blank"' : '';

            // Check if the keyword exists in the content
            if (stripos($content, $keyword) !== false) {
                $replacement = sprintf(
                    '<a href="%s" title="%s"%s rel="%s">%s</a>',
                    esc_url($url),
                    esc_attr($keyword),
                    $target,
                    esc_attr($rel_attribute_string),
                    esc_html($keyword)
                );

                // Replace only the first occurrence of the keyword with a link
                $content = preg_replace('/' . preg_quote($keyword, '/') . '/', $replacement, $content, 1);
            }
        }
    }

    return $content;
}

add_filter('the_content', 'mm_wp_internal_link_building_filter_content');
