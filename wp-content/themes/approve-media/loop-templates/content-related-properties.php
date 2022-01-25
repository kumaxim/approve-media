<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>
<div class="wrapper" id="single-wrapper">
    <h3><?php echo __('10 последних объектов в ', 'approve-media') . $post->post_title ?></h3>
    <?php foreach (approve_media_get_properties_in_city($post->ID) as $property): ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 my-2">
                    <a href="<?php echo $property['permalink'] ?>" target="_blank">
                        <?php echo $property['post_title'] ?>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <a href="<?php echo $property['permalink'] ?>" target="_blank">
                        <?php echo $property['thumbnail'] ?>
                    </a>
                </div>
                <div class="col-8">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="pb-2">
                                        <span class="font-weight-bold"><?php echo __('Площадь', 'approve-media') ?>:</span>
                                        <br>
                                        <?php echo esc_html($property['property_square']) ?>
                                        <?php echo __('кв.м.', 'approve-media') ?>
                                    </li>
                                    <li>
                                        <span class="font-weight-bold"><?php echo __('Этаж', 'approve-media') ?>:</span>
                                        <br>
                                        <?php echo esc_html($property['property_level']) ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="pb-2">
                                        <span class="font-weight-bold"><?php echo __('Жилая площадь', 'approve-media') ?>:</span>
                                        <br>
                                        <?php echo esc_html($property['property_living_square']) ?>
                                        <?php echo __('кв.м.', 'approve-media') ?>
                                    </li>
                                    <li>
                                        <span class="font-weight-bold"><?php echo __('Стоимость', 'approve-media') ?>:</span>
                                        <br>
                                        <?php echo esc_html($property['property_price']) ?>
                                        <span>руб</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <span class="font-weight-bold"><?php echo __('Адрес', 'approve-media') ?>:</span>
                                <p><?php echo esc_html($property['property_address']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if ( ! isset($property)): ?>
        <p class="alert alert-warning" role="alert">
            <?php echo __('В этом городе не размещено ни одного объекта нендивижимости', 'approve-media') ?>
        </p>
    <?php endif; ?>
</div>
<?php