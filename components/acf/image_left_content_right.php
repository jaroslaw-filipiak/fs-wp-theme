<?php
/**
 * ACF Flexible Content Component: Image Left + Content Right
 * Layout: image_left_content_right
 */

// Get the sub fields
$content = get_sub_field('content');
$image = get_sub_field('image');
?>

<section class="acf-component acf-image-left-content-right">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            
            <?php if( $image ): ?>
            <div class="image-container">
                <img 
                    src="<?php echo esc_url($image['url']); ?>" 
                    alt="<?php echo esc_attr($image['alt']); ?>"
                    class="w-full h-auto rounded-lg shadow-lg"
                    loading="lazy"
                >
            </div>
            <?php endif; ?>
            
            <?php if( $content ): ?>
            <div class="content-container">
                <div class="prose prose-lg max-w-none">
                    <?php echo wp_kses_post($content); ?>
                </div>
            </div>
            <?php endif; ?>
            
        </div>
    </div>
</section>
