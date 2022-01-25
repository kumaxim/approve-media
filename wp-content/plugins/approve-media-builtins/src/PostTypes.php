<?php


namespace ApproveMedia\SystemBuiltins;


class PostTypes
{
    const PROPERTY_SLUG = 'property';

    const CITIES_SLUG = 'cities';

    public function register_property_post_type()
    {
        $labels = [
            "name" => __( "Недвижимости", "approve-media" ),
            "singular_name" => __( "Недвижимость", "approve-media" ),
        ];

        $args = [
            "label" => __( "Недвижимости", "approve-media" ),
            "labels" => $labels,
            "description" => "",
            "public" => true,
            "publicly_queryable" => true,
            "show_ui" => true,
            "show_in_rest" => true,
            "rest_base" => "",
            "rest_controller_class" => "WP_REST_Posts_Controller",
            "has_archive" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "delete_with_user" => false,
            "exclude_from_search" => false,
            "capability_type" => "post",
            "map_meta_cap" => true,
            "hierarchical" => false,
            "rewrite" => [ "slug" => "property", "with_front" => true ],
            "query_var" => true,
            "supports" => [ "title", "editor", "thumbnail", "revisions", "author" ],
            "taxonomies" => [ "property_type" ],
            "show_in_graphql" => false,
        ];

        register_post_type( self::PROPERTY_SLUG, $args );
    }

    public function register_cities_post_type()
    {
        $labels = [
            "name" => __( "Города", "approve-media" ),
            "singular_name" => __( "Город", "approve-media" ),
        ];

        $args = [
            "label" => __( "Города", "approve-media" ),
            "labels" => $labels,
            "description" => "",
            "public" => true,
            "publicly_queryable" => true,
            "show_ui" => true,
            "show_in_rest" => true,
            "rest_base" => "",
            "rest_controller_class" => "WP_REST_Posts_Controller",
            "has_archive" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "delete_with_user" => false,
            "exclude_from_search" => false,
            "capability_type" => "post",
            "map_meta_cap" => true,
            "hierarchical" => false,
            "rewrite" => [ "slug" => "cities", "with_front" => true ],
            "query_var" => true,
            "supports" => [ "title", "editor", "thumbnail" ],
            "show_in_graphql" => false,
        ];

        register_post_type( self::CITIES_SLUG, $args );
    }
}

