<?php
$product = wc_get_product(get_the_ID());
$attachment_ids = $product->get_gallery_image_ids();
$thumbnail_id = get_post_thumbnail_id();

$images_length = count($attachment_ids);
?>



<div class="single-product-gallery">
    <div class="single-product-gallery-images images-length-<?php echo $images_length; ?>">
        <?php
       
        if (!$product || !is_object($product) || !method_exists($product, 'get_gallery_image_ids')) {
            $product = wc_get_product(get_the_ID());
        }
        
        if ($product && is_object($product)) {
            $attachment_ids = $product->get_gallery_image_ids();
            $thumbnail_id = get_post_thumbnail_id();
            $i = 0;
            
            if ($attachment_ids) {
                foreach ($attachment_ids as $attachment_id) {
                    $i++;
                    ?>
        <div  class="single-product-gallery-image single-product-gallery-image-<?php echo $i; ?>">  
            <a href="<?php echo wp_get_attachment_url($attachment_id); ?>" data-lightbox="gallery" >
                <img src="<?php echo wp_get_attachment_url($attachment_id); ?>"
                    alt="<?php echo get_post_meta($attachment_id, '_wp_attachment_image_alt', true); ?>">
            </a>
        </div>
        <?php
                }
            }
        }
        ?>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        lightbox.option({
            'resizeDuration': 400,
            'wrapAround': true,
            'albumLabel': 'Zdjęcie %1 z %2',
            'fadeDuration': 400,
            'imageFadeDuration': 400,
            'resizeDuration': 400,
        })
    });
</script>

