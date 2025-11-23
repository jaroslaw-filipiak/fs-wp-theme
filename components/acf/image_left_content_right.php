<?php
/**
 * ACF Flexible Content Component: Image Left + Content Right
 * Layout: image_left_content_right
 */

// Get the sub fields
$content = get_sub_field('content');
$image = get_sub_field('image');
$custom_classes = get_sub_field('custom_classes');
?>

<section class="acf-component acf-image-left-content-right <?php echo $custom_classes; ?>">

    <?php if( $image ): ?>
    <div class="image-container">
        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?: 'Content image'); ?>"
            class="w-full h-auto rounded-lg shadow-lg" loading="lazy">
    </div>
    <?php endif; ?>

    <?php if( $content ): ?>
    <div class="content-container">
        <div class="prose prose-lg max-w-none">
            <?php echo wp_kses_post($content); ?>
        </div>
    </div>
    <?php endif; ?>

</section>