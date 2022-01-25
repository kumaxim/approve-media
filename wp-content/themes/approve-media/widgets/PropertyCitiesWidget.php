<?php

namespace ApproveMedia\Theme\Widgets;

class PropertyCitiesWidget extends \WP_Widget
{
    public function __construct()
    {
        $opts = [
            'description' => 'Список городов со ссылками на страницы их архивов, где размещены объекты недвижимости',
        ];

        parent::__construct('approve-media-property-cities', __('Города объектов', 'approve-media'), $opts);
    }

    public function widget($args, $instance)
    {
        $title = apply_filters( 'widget_title', empty($instance['title']) ? __('Список городов', 'approve-media') : $instance['title'] );

        echo $args['before_widget'];

        if ( ! empty($title) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $cities = new \WP_Query([
            'posts_per_page' => -1,
            'post_type' => 'cities',
            'post_status' => 'publish'
        ]);

        if ( $cities->have_posts() ) {
            echo '<ul class="list-unstyled">';

            while ($cities->have_posts()) {
                $cities->the_post();

                echo sprintf('<li id="city-%d"><a href="%s">%s</a></li>', get_the_ID(), get_the_permalink(), get_the_title()) . PHP_EOL;
            }

            echo '</ul>';
        }

        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'approve-media' );

        echo '<p>';
        echo sprintf('<label for="%s">%s</label>', esc_attr( $this->get_field_id( 'title' ) ), esc_attr_e( 'Title:', 'approve-media' ));
		echo sprintf(
		    '<input class="widefat" id="%s" name="%s" type="text", value="%s"',
            esc_attr( $this->get_field_id( 'title' ) ),
            esc_attr( $this->get_field_name( 'title' ) ),
            esc_attr( $title )
        );
        echo '</p>';
    }

    public function update($new_instance, $old_instance)
    {
        $instance = [];
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';

        return $instance;
    }


}