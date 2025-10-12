<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package fajnestarocie
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function fajnestarocie_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 150,
			'single_image_width'    => 300,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'fajnestarocie_woocommerce_setup' );



/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function fajnestarocie_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'fajnestarocie_woocommerce_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function fajnestarocie_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'fajnestarocie_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'fajnestarocie_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function fajnestarocie_woocommerce_wrapper_before() {
		?>
<main id="primary" class="site-main">
    <?php
	}
}
add_action( 'woocommerce_before_main_content', 'fajnestarocie_woocommerce_wrapper_before' );

if ( ! function_exists( 'fajnestarocie_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function fajnestarocie_woocommerce_wrapper_after() {
		?>
</main><!-- #main -->
<?php
	}
}
add_action( 'woocommerce_after_main_content', 'fajnestarocie_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'fajnestarocie_woocommerce_header_cart' ) ) {
			fajnestarocie_woocommerce_header_cart();
		}
	?>
*/

if ( ! function_exists( 'fajnestarocie_woocommerce_cart_link_fragment' ) ) {
/**
* Cart Fragments.
*
* Ensure cart contents update when products are added to the cart via AJAX.
*
* @param array $fragments Fragments to refresh via AJAX.
* @return array Fragments to refresh via AJAX.
*/
function fajnestarocie_woocommerce_cart_link_fragment( $fragments ) {
ob_start();
fajnestarocie_woocommerce_cart_link();
$fragments['a.cart-contents'] = ob_get_clean();

return $fragments;
}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'fajnestarocie_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'fajnestarocie_woocommerce_cart_link' ) ) {
/**
* Cart Link.
*
* Displayed a link to the cart including the number of items present and the cart total.
*
* @return void
*/
function fajnestarocie_woocommerce_cart_link() {
?>
<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>"
    title="<?php esc_attr_e( 'View your shopping cart', 'fajnestarocie' ); ?>">
    <?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'fajnestarocie' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
    <span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span
        class="count"><?php echo esc_html( $item_count_text ); ?></span>
</a>
<?php
	}
}

if ( ! function_exists( 'fajnestarocie_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function fajnestarocie_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
<ul id="site-header-cart" class="site-header-cart">
    <li class="<?php echo esc_attr( $class ); ?>">
        <?php fajnestarocie_woocommerce_cart_link(); ?>
    </li>
    <li>
        <?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
    </li>
</ul>
<?php
	}
}

// add container class to woocommerce content
function add_container_before_woocommerce_content() {
    echo '<div class="container-woocommerce-fajnestarocie">';
}
add_action('woocommerce_before_main_content', 'add_container_before_woocommerce_content', 10);

function close_container_after_woocommerce_content() {
    echo '</div>';
}
add_action('woocommerce_after_main_content', 'close_container_after_woocommerce_content', 10);

// woo custom product gallery 
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);

function custom_show_product_images() {
    global $product;
    if (!$product) {
        $product = wc_get_product(get_the_ID());
    }
    get_template_part('woocommerce/single-product-gallery');
}
add_action('woocommerce_before_single_product_summary', 'custom_show_product_images', 20);


// remove breadcrumbs WooCommerce
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

//add breadcrumbs with container class
add_action( 'woocommerce_before_main_content', 'wrap_woocommerce_breadcrumb', 20 );
function wrap_woocommerce_breadcrumb() {
    if ( function_exists( 'woocommerce_breadcrumb' ) ) {
        echo '<div class="container">';
        woocommerce_breadcrumb();
        echo '</div>';
    }
}

/**
 * Disable purchasability for products with 'individual' shipping class
 *
 * @param bool $purchasable
 * @param WC_Product $product
 * @return bool
 */
function fajnestarocie_disable_individual_shipping_purchase( $purchasable, $product ) {
    if ( $product->get_shipping_class() === 'individual' ) {
        return false;
    }
    return $purchasable;
}
add_filter( 'woocommerce_is_purchasable', 'fajnestarocie_disable_individual_shipping_purchase', 10, 2 );

/**
 * Display custom message for products with 'individual' shipping class
 *
 * @return void
 */
function fajnestarocie_individual_shipping_message() {
    global $product;

    if ( ! $product ) {
        return;
    }

    if ( $product->get_shipping_class() === 'individual' ) {
        echo '<div class="individual-shipping-notice" style="margin: 20px 0; padding: 15px; background-color: #f0f0f0; border-left: 4px solid #0073aa;">';
        echo '<p style="margin: 0; font-size: 16px; font-weight: 500;">';
        echo esc_html__( 'Zadzwoń do nas w celu ustalenia kosztów dostawy', 'fajnestarocie' );
        echo '</p>';
        echo '</div>';
    }
}
add_action( 'woocommerce_single_product_summary', 'fajnestarocie_individual_shipping_message', 30 );

/**
 * Add body class for products with 'individual' shipping class
 *
 * @param array $classes
 * @return array
 */
function fajnestarocie_individual_shipping_body_class( $classes ) {
    if ( is_product() ) {
        global $product;

        if ( $product && $product->get_shipping_class() === 'individual' ) {
            $classes[] = 'product-shipping-individual';
        }
    }

    return $classes;
}
add_filter( 'body_class', 'fajnestarocie_individual_shipping_body_class' );