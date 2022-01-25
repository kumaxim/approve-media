<?php


namespace ApproveMedia\SystemBuiltins;


class Taxonomies
{
    const PROPERTY_TYPE_SLUG = 'property_type';

    public function register_property_type_taxonomy()
    {
        $labels = [
            "name" => __( "Тип Недвижимостей", "approve-media" ),
            "singular_name" => __( "Тип Недвижимости", "approve-media" ),
        ];


        $args = [
            "label" => __( "Тип Недвижимостей", "approve-media" ),
            "labels" => $labels,
            "public" => true,
            "publicly_queryable" => true,
            "hierarchical" => false,
            "show_ui" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "query_var" => true,
            "rewrite" => [ 'slug' => 'property_type', 'with_front' => true, ],
            "show_admin_column" => false,
            "show_in_rest" => true,
            "show_tagcloud" => false,
            "rest_base" => "property_type",
            "rest_controller_class" => "WP_REST_Terms_Controller",
            "show_in_quick_edit" => false,
            "show_in_graphql" => false,
        ];

        register_taxonomy( self::PROPERTY_TYPE_SLUG, [ "property" ], $args );
    }
}
