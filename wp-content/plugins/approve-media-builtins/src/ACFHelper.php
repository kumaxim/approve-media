<?php


namespace ApproveMedia\SystemBuiltins;


class ACFHelper extends \WP_CLI_Command
{
    /**
     * @throws \WP_CLI\ExitException
     *
     * Записи об объектах недвижимости генерировались при помощи плагига FakerPress
     * Этим кодом я решил ненмого поправить заголовки созданных постов для соответствия их заданной тестовым
     * заданием предметной области
     */
    public function change_property_titles()
    {
        $properties = new \WP_Query([
            'posts_per_page' => -1,
            'post_type' => 'property'
        ]);

        while ($properties->have_posts()) {
            $properties->the_post();

            $post_id = get_the_ID();

            $type = get_the_terms($post_id, 'property_type');
            $square = get_post_meta($post_id, 'property-square', true);
            $level = get_post_meta($post_id, 'property-level', true);

            $city_id = get_post_meta($post_id, 'property-city', true);
            $city = get_post($city_id);

            $title = sprintf('%s в %s площадью %d кв.м. на %d этаже', $type[0]->name, $city->post_title, $square, $level);

            $is_error = wp_update_post(['ID' => $post_id, 'post_title' => $title], true);

            if ( $is_error instanceof \WP_Error) {
                \WP_CLI::error(
                    sprintf('Error while updating title of property_id=%d. Reason: %s',  $post_id, $is_error->get_error_message())
                );
            }

            \WP_CLI::success(
                sprintf('Property title in property_id=%d successfully updated to "%s"', $post_id, $title)
            );

        }

        wp_reset_postdata();

        \WP_CLI::success('Finished Successfully');
    }

    /**
     * Значения полей "этаж", "площадь" и т.д. также генерировались при помощи плагина FakerPress
     * Однако, ACF не видит сгенерированные им значения, поскольку для хранения значений дополнительных полей
     * использует свой формат.
     *
     * Этим кодом я устраняю это, что дает мне возможность отображать значения дополнительных полей в шаблоне, используя
     * функции ACF, например get_field()
     */
    public function adopt_meta_value_for_acf()
    {
        $properties = new \WP_Query([
            'posts_per_page' => -1,
            'post_type' => 'property'
        ]);

        while ($properties->have_posts()) {
            $properties->the_post();

            $post_id = get_the_ID();

            $city_key = 'property-city';
            $city_id = get_post_meta($post_id, $city_key, true);
            update_field($city_key, get_post($city_id), $post_id);

            $meta_keys = ['property-square', 'property-price', 'property-address', 'property-living-square', 'property-level'];

            foreach ($meta_keys as $meta_key) {
                $value = get_post_meta($post_id, $meta_key, true);
                update_field($meta_key, $value, $post_id);
            }
        }

        wp_reset_postdata();

        \WP_CLI::success('Finished Successfully');
    }
}