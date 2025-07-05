<div class="product-gallery">
    <div class="product-gallery-images">
        <div class="product-gallery-image">
            <?php 
            $thumbnail_url = get_the_post_thumbnail_url();
            if ($thumbnail_url) {
                echo '<img src="' . esc_url($thumbnail_url) . '" alt="' . esc_attr(get_the_title()) . '">';
            }
            ?>
        </div>
    </div>
    <?php
        // Ensure $product is a valid WooCommerce product object
        if (!$product || !is_object($product) || !method_exists($product, 'get_gallery_image_ids')) {
            $product = wc_get_product(get_the_ID());
        }
        
        if ($product && is_object($product)) {
            $attachment_ids = $product->get_gallery_image_ids();
            $thumbnail_id = get_post_thumbnail_id();
            
            if ($attachment_ids) {
                foreach ($attachment_ids as $attachment_id) {
                    // Skip the first gallery image if it's the same as the thumbnail
                    if ($attachment_id == $thumbnail_id) {
                        continue;
                    }
                    ?>
    <div class="product-gallery-image">
        <img src="<?php echo wp_get_attachment_url($attachment_id); ?>"
            alt="<?php echo get_post_meta($attachment_id, '_wp_attachment_image_alt', true); ?>">
    </div>
    <?php
                }
            }
        }
        ?>
</div>
</div>