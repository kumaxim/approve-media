<?php
/*
Plugin Name: Approve Media Builtins
Description: Встроенные функции, необходимые для работы темы Approve Media: добавление типов "Недвижимость", "Города" и ассоциированных с ними дополнительных полей и т.п.
Author: Maxim Kudryavtsev
Version: 1.0
License: Proprietary
Author URI: https://k-maxim.ru/
*/

defined( 'WPINC' ) || die( 'Access restricted' );

use ApproveMedia\SystemBuiltins\ACFHelper;
use ApproveMedia\SystemBuiltins\ACFields;
use ApproveMedia\SystemBuiltins\PostTypes;
use ApproveMedia\SystemBuiltins\Taxonomies;

function run_approve_media_545b4ff31720d4aba0418873d239668ea76d8073() {
    require __DIR__ . '/vendor/autoload.php';

    if (defined('WP_CLI') && WP_CLI) {
        \WP_CLI::add_command('approve-media', ACFHelper::class);
    }

    if( function_exists('acf_add_local_field_group') ) {
        acf_add_local_field_group(ACFields::get_fields());
    }

    $post_types = new PostTypes();
    add_action( 'init', [$post_types, 'register_cities_post_type'] );
    add_action( 'init', [$post_types, 'register_property_post_type'] );

    $taxonomies = new Taxonomies();
    add_action( 'init', [$taxonomies, 'register_property_type_taxonomy'] );
}

run_approve_media_545b4ff31720d4aba0418873d239668ea76d8073();