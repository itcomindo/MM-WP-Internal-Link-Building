<?php

/**
 * Options Page
 */

defined('ABSPATH') or die('No script kiddies please!');

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'mm_wp_internal_link_building_options');
function mm_wp_internal_link_building_options()
{
    Container::make('theme_options', 'Internal Links')
        ->add_fields([
            Field::make('checkbox', 'mm_wp_ilb_open_new_tab', 'Open in New Tab')
                ->set_option_value('yes')
                ->set_default_value(true),
            Field::make('complex', 'mm_wp_ilb', 'Internal Links')
                ->set_classes('mm-ilb-complex')
                ->add_fields([
                    //dofollow
                    Field::make('checkbox', 'mm_wp_ilb_dofollow', 'Dofollow?')
                        ->set_width(33)
                        ->set_option_value('yes')
                        ->set_default_value(true),
                    //noopener
                    Field::make('checkbox', 'mm_wp_ilb_noopener', 'Noopener?')
                        ->set_width(33)
                        ->set_option_value('yes')
                        ->set_default_value(true),
                    //noreferrer
                    Field::make('checkbox', 'mm_wp_ilb_noreferrer', 'Noreferrer?')
                        ->set_width(33)
                        ->set_option_value('yes')
                        ->set_default_value(true),
                    //keyword
                    Field::make('text', 'mm_wp_ilb_keyword', 'Keyword')
                        ->set_width(50),
                    //url
                    Field::make('text', 'mm_wp_ilb_url', 'URL')
                        ->set_width(50),
                ])
        ]);
}
