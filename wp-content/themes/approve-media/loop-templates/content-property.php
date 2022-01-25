<?php
/**
 * Partial template for content in page.php
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php echo sprintf('<h1 class="entry-title"><a href="%s">%s</a></h1>', get_the_permalink(), get_the_title()) ?>

	</header><!-- .entry-header -->

	<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>


	<div class="entry-content">
        <div class="border mt-2 px-2">
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-unstyled mb-0">
                        <li class="mt-2">
                            <strong><?php echo __('Площадь', 'approve-media') ?>:</strong>
                            <?php echo get_field('property-square') ?>
                            <?php echo __('кв.м.', 'approve-media') ?>
                        </li>
                        <li class="mt-2">
                            <strong><?php echo __('Жилая площадь', 'approve-media') ?>:</strong>
                            <?php echo get_field('property-living-square') ?>
                            <?php echo __('кв.м.', 'approve-media') ?>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-unstyled mb-0">
                        <li class="mt-2">
                            <strong><?php echo __('Этаж', 'approve-media') ?>:</strong>
                            <?php echo get_field('property-level') ?>
                        </li>
                        <li class="mt-2">
                            <strong><?php echo __('Стоимость', 'approve-media') ?>:</strong>
                            <?php echo get_field('property-price') ?>
                            <?php echo __('руб.', 'approve-media') ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mt-2">
                    <?php $property_city_object = get_field('property-city') ?>
                    <td colspan="2"><strong><?php echo __('Город', 'approve-media') ?>:</strong> <?php echo $property_city_object->post_title ?></td>
                </div>
            </div>
            <div class="row">
                <div class="col-12 my-2">
                    <strong><?php echo __('Адрес', 'approve-media') ?>:</strong>
                    <?php echo get_field('property-address') ?>
                </div>
            </div>
        </div>
        <?php if (is_singular()): ?>
            <p class="px-2"></p>
            <p class="font-weight-bolder"><?php echo __('Описание объекта', 'approve-media')?></p>
            <?php the_content(); ?>
            <?php understrap_link_pages(); ?>
        <?php else: ?>
            <div class="propetry-desc">
                <p class="px-2"></p>
                <p class="font-weight-bolder"><?php echo __('Описание объекта', 'approve-media')?></p>
                <span class="collapse" id="collapse-desc-<?php echo $post->ID ?>" aria-expanded="false">
                    <?php the_content(); ?>
                    <?php understrap_link_pages(); ?>
                </span>
                <a role="button"
                   class="collapsed"
                   data-toggle="collapse"
                   href="#collapse-desc-<?php echo $post->ID ?>"
                   aria-expanded="false"
                   aria-controls="collapse-desc-<?php echo $post->ID ?>"></a>
            </div>
        <?php endif; ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
        <p>
            <span class="font-weight-bolder"><?php echo __('Категория объекта', 'approve-media')?>:</span>
            <?php echo get_the_term_list($post->ID, 'property_type') ?>
        </p>

		<?php understrap_edit_post_link(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
