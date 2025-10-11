<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

<?php while ( have_posts() ) : ?>
<?php the_post(); ?>

<div class="container">
    <?php wc_get_template_part( 'content', 'single-product' ); ?>

    <div class="divider my-10 border-b"></div>

    <div class="upsell-products">
        <?php woocommerce_upsell_display(); ?>
    </div>
</div>

<?php endwhile; // end of the loop. ?>

<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>



<!-- sticky bar -->
<div class="single-product-sticky-bar">
    <div class="single-product-sticky-bar__inner">
        <div class="single-product-sticky-bar__product-title">
            <h1><?php the_title(); ?></h1>
        </div>
        <div class="single-product-sticky-bar__content">
            <div class="single-product-sticky-bar__product-add-to-cart">
                <a href="<?php echo esc_url( wc_get_cart_url() . '?add-to-cart=' . get_the_ID() ); ?>"
                    class="single-product-sticky-bar__product-add-to-cart-button">
                    Dodaj do koszyka
                    (<?php $product = wc_get_product( get_the_ID() ); echo wc_price( $product->get_price() ); ?>)
                </a>
            </div>
        </div>
    </div>
</div>

<?php
get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */