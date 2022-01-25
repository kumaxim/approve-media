<?php

define('APPROVE_MEDIA_NONCE_SUBMIT_NEW_PROPERTY', 'approve-media-new-property-submit');
define('APPROVE_MEDIA_AJAX_ACTION_SUBMIT_NEW_PROPERTY', 'approve_media_submit_new_property');

$approve_media_includes = [
    '/widgets/PropertyCitiesWidget.php',
];

// Include files.
foreach ($approve_media_includes as $file) {
    require_once get_theme_file_path($file);
}

add_action('wp_enqueue_scripts', 'approve_media_enqueue_styles', 99);

function approve_media_enqueue_styles()
{
    wp_enqueue_style('approve-media-style', get_stylesheet_directory_uri() . '/style.css', ['understrap-styles'], '1.0');
    wp_enqueue_script('approve-media-scripts', get_stylesheet_directory_uri() . '/js/scripts.js', ['jquery'], '1.0', true);
    wp_localize_script('approve-media-scripts', 'approveMedia', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'name' => APPROVE_MEDIA_AJAX_ACTION_SUBMIT_NEW_PROPERTY,
        'security' => wp_create_nonce(APPROVE_MEDIA_NONCE_SUBMIT_NEW_PROPERTY),
    ]);
}

add_action('widgets_init', 'approve_media_register_property_cities_widget');

function approve_media_register_property_cities_widget()
{
    register_widget(ApproveMedia\Theme\Widgets\PropertyCitiesWidget::class);
}

add_action('pre_get_posts', 'approve_media_display_properties_on_frontpage');

function approve_media_display_properties_on_frontpage(\WP_Query $query)
{
    if ($query->is_main_query() && $query->is_home()) {
        $query->set('post_type', ['property']);
    }
}

function approve_media_get_properties_in_city($city_id)
{
    $properties = new \WP_Query([
        'posts_per_page' => 10,
        'post_status' => 'publish',
        'post_type' => 'property',
        'meta_key' => 'property-city',
        'meta_value' => is_numeric($city_id) ? $city_id : 0,
        'order' => 'DESC',
        'orderby' => 'date'
    ]);

    while ($properties->have_posts()) {
        $properties->the_post();

        $property_id = get_the_ID();

        yield [
            'ID' => $property_id,
            'post_title' => get_the_title(),
            'permalink' => get_the_permalink(),
            'thumbnail' => get_the_post_thumbnail(),
            'property_square' => get_field('property-square'),
            'property_price' => get_field('property-price'),
            'property_address' => get_field('property-address'),
            'property_living_square' => get_field('property-living-square'),
            'property_level' => get_field('property-level'),
        ];
    }

    wp_reset_postdata();

    return false;
}

function approve_media_get_property_types() {
    $types = get_terms(['taxonomy' => 'property_type', 'hide_empty' => false]);

    if ( $types instanceof \WP_Error ) {
        throw new \RuntimeException($types->get_error_message());
    }

    foreach ($types as $type) {
        yield [
            'id' => $type->term_id,
            'title' => $type->name,
        ];
    }
}

function approve_media_get_city_list()
{
    $cities = new \WP_Query([
        'posts_per_page' => -1,
        'post_type' => 'cities',
        'post_status' => 'publish',
        'order' => 'ASC',
        'orderby' => 'title'
    ]);

    while ($cities->have_posts()) {
        $cities->the_post();

        yield [
            'id' => get_the_ID(),
            'title' => get_the_title()
        ];
    }

    wp_reset_postdata();

    return false;
}

add_action('wp_ajax_' . APPROVE_MEDIA_AJAX_ACTION_SUBMIT_NEW_PROPERTY, 'approve_media_submit_new_property_form');
add_action('wp_ajax_nopriv_' . APPROVE_MEDIA_AJAX_ACTION_SUBMIT_NEW_PROPERTY, 'approve_media_submit_new_property_form');

function approve_media_submit_new_property_form()
{
    check_ajax_referer(APPROVE_MEDIA_NONCE_SUBMIT_NEW_PROPERTY, 'security');

    $details = [];

    if (false === filter_var($_REQUEST['title'], FILTER_SANITIZE_STRING)) {
        $error = new \WP_Error(500, __('Неверное значение поля "Название объекта": поле не должно быть пустым', 'approve-media'));
        wp_send_json_error($error);
    }

    $details['post_title'] = filter_var($_REQUEST['title'], FILTER_SANITIZE_STRING);

    if (false === filter_var($_REQUEST['desc'], FILTER_SANITIZE_STRING)) {
        $error = new \WP_Error(500, __('Неверное значение поля "Описание объекта": поле не должно быть пустым', 'approve-media'));
        wp_send_json_error($error);
    }

    $details['post_content'] = filter_var($_REQUEST['desc'], FILTER_SANITIZE_STRING);

    if (false === filter_var($_REQUEST['city'], FILTER_SANITIZE_NUMBER_INT)) {
        $error = new \WP_Error(500, __('Неверное значение поля "Город": поле не должно быть пустым', 'approve-media'));
        wp_send_json_error($error);
    }

    $city_id = (int) filter_var($_REQUEST['city'], FILTER_SANITIZE_NUMBER_INT);
    $city = get_post($city_id);

    if (false === ($city instanceof \WP_Post)) {
        $error = new \WP_Error(500, __('Неверное значение поля "Город": указанный Вами город не существует', 'approve-media'));
        wp_send_json_error($error);
    }

    $details['meta_city'] = $city;

    if (false === filter_var($_REQUEST['address'], FILTER_SANITIZE_STRING)) {
        $error = new \WP_Error(500, __('Неверное значение поля "Адрес объекта": поле не должно быть пустым', 'approve-media'));
        wp_send_json_error($error);
    }

    $details['meta_address'] = filter_var($_REQUEST['address'], FILTER_SANITIZE_STRING);

    if (false === filter_var($_REQUEST['square'], FILTER_SANITIZE_NUMBER_INT)) {
        $error = new \WP_Error(500, __('Неверное значение поля "Площадь объекта": поле не должно быть пустым', 'approve-media'));
        wp_send_json_error($error);
    }

    $details['meta_square'] = (int) filter_var($_REQUEST['square'], FILTER_SANITIZE_NUMBER_INT);

    if (false === filter_var($_REQUEST['living_square'], FILTER_SANITIZE_NUMBER_INT)) {
        $error = new \WP_Error(500, __('Неверное значение поля "Жилая площадь": поле не должно быть пустым', 'approve-media'));
        wp_send_json_error($error);
    }

    $details['meta_living_square'] = (int) filter_var($_REQUEST['living_square'], FILTER_SANITIZE_NUMBER_INT);

    if (false === filter_var($_REQUEST['level'], FILTER_SANITIZE_NUMBER_INT)) {
        $error = new \WP_Error(500, __('Неверное значение поля "Этаж": поле не должно быть пустым', 'approve-media'));
        wp_send_json_error($error);
    }

    $details['meta_level'] = (int) filter_var($_REQUEST['level'], FILTER_SANITIZE_NUMBER_INT);

    if (false === filter_var($_REQUEST['price'], FILTER_SANITIZE_NUMBER_INT)) {
        $error = new \WP_Error(500, __('Неверное значение поля "Стоимость": поле не должно быть пустым', 'approve-media'));
        wp_send_json_error($error);
    }

    $details['meta_price'] = (int) filter_var($_REQUEST['price'], FILTER_SANITIZE_NUMBER_INT);

    if ( false === filter_var($_REQUEST['property_type'], FILTER_SANITIZE_NUMBER_INT)) {
        $error = new \WP_Error(500, __('Неверное значение поля "Тип объекта": поле не должно быть пустым', 'approve-media'));
        wp_send_json_error($error);
    }

    $details['property_type'] = (int) filter_var($_REQUEST['property_type'], FILTER_SANITIZE_NUMBER_INT);

    $category = get_term($details['property_type'], 'property_type');

    if ( false === ($category instanceof \WP_Term)) {
        $error = new \WP_Error(500, __('Неверное значение поля "Тип объекта": выбранной категории не существует', 'approve-media'));
        wp_send_json_error($error);
    }

    if ( $details['meta_square'] < $details['meta_living_square']) {
        $error = new \WP_Error(
            500,
            __('Неверное значение поля "Площадь объекта": значение поля должно быть больше или равно значению поля "Жилая площадь"', 'approve-media')
        );
        wp_send_json_error($error);
    }

    $property_id = wp_insert_post(
        [
            'post_title' => $details['post_title'],
            'post_content' => $details['post_content'],
            'post_status' => 'draft',
            'post_type' => 'property',
        ],
        true
    );

    if ($property_id instanceof \WP_Error) {
        wp_send_json_error($property_id);
    }

    $term_ids = wp_set_object_terms($property_id, $details['property_type'], 'property_type');

    if ( $term_ids instanceof \WP_Error ) {
        $error = new \WP_Error(500, __('Неверное значение поля "Тип объекта": невозможно назначить выбранный тип', 'approve-media'));
        wp_send_json_error($error);
    }

    update_field('property-city', $details['meta_city'], $property_id);
    update_field('property-address', $details['meta_address'], $property_id);
    update_field('property-square', $details['meta_square'], $property_id);
    update_field('property-living-square', $details['meta_living_square'], $property_id);
    update_field('property-price', $details['meta_price'], $property_id);
    update_field('property-level', $details['meta_level'], $property_id);

    wp_send_json_success(['property_id' => $property_id], 200);
}