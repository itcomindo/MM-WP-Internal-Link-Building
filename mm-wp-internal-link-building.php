<?php

/**
 * Plugin Name: MM WP Internal Link Building
 * Plugin URI: https://budiharyono.id/
 * Description: Internal Link Building for WordPress
 * Version: Beta.v1.0.1
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
    $open_in_new_tab = carbon_get_theme_option('mm_wp_ilb_open_new_tab');
    $replaced_keywords = array();

    if (!empty($fields)) {
        foreach ($fields as $field) {
            $keyword = $field['mm_wp_ilb_keyword'];
            $url = $field['mm_wp_ilb_url'];

            // Skip jika keyword sudah digantikan
            if (in_array($keyword, $replaced_keywords)) {
                continue;
            }

            $rel_attributes = [];
            if (!$field['mm_wp_ilb_dofollow']) {
                $rel_attributes[] = 'nofollow';
            }
            if ($field['mm_wp_ilb_noopener']) {
                $rel_attributes[] = 'noopener';
            }
            if ($field['mm_wp_ilb_noreferrer']) {
                $rel_attributes[] = 'noreferrer';
            }

            $rel_attribute_string = implode(' ', $rel_attributes);
            $target = $open_in_new_tab ? ' target="_blank"' : '';

            $replacement = sprintf(
                '<a href="%s" title="%s"%s rel="%s">%s</a>',
                esc_url($url),
                esc_attr($keyword),
                $target,
                esc_attr($rel_attribute_string),
                esc_html($keyword)
            );

            // Proses hanya konten dalam tag <p>
            $content = preg_replace_callback('/<p>(.*?)<\/p>/si', function ($matches) use ($keyword, $replacement, &$replaced_keywords) {
                $paragraph_content = $matches[1];

                if (!in_array($keyword, $replaced_keywords) && stripos($paragraph_content, $keyword) !== false) {
                    $paragraph_content = preg_replace('/\b' . preg_quote($keyword, '/') . '\b/', $replacement, $paragraph_content, 1);
                    $replaced_keywords[] = $keyword;
                }

                return '<p>' . $paragraph_content . '</p>';
            }, $content);
        }
    }

    return $content;
}

add_filter('the_content', 'mm_wp_internal_link_building_filter_content');
