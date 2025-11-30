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

//add RankMath breadcrumbs with container class
add_action( 'woocommerce_before_main_content', 'wrap_rankmath_breadcrumb', 20 );
function wrap_rankmath_breadcrumb() {
    if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
        echo '<div class="container">';
        echo '<div class="flex mb-4 items-center">';
        rank_math_the_breadcrumbs();
        echo '</div>';
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

/**
 * Customize RankMath breadcrumbs to show specific product categories
 */
function fajnestarocie_customize_rankmath_breadcrumbs( $crumbs, $class ) {
	// Only modify on single product pages
	if ( ! is_product() ) {
		return $crumbs;
	}
	
	global $post;
	$product_id = $post->ID;
	
	// Get product categories
	$product_cats = get_the_terms( $product_id, 'product_cat' );
	
	if ( $product_cats && ! is_wp_error( $product_cats ) ) {
		// Get existing breadcrumb names to avoid duplicates
		$existing_names = array();
		foreach ( $crumbs as $crumb ) {
			$existing_names[] = strtolower( $crumb[0] );
		}
		
		// Find the most specific category (child category, not parent)
		$best_category = null;
		$max_depth = -1;
		
		foreach ( $product_cats as $cat ) {
			// Skip if this category is already in breadcrumbs
			if ( in_array( strtolower( $cat->name ), $existing_names ) ) {
				continue;
			}
			
			// Count depth by checking parents
			$depth = 0;
			$current_cat = $cat;
			while ( $current_cat->parent > 0 ) {
				$depth++;
				$current_cat = get_term( $current_cat->parent, 'product_cat' );
				if ( is_wp_error( $current_cat ) ) break;
			}
			
			// Choose category with maximum depth (most specific)
			if ( $depth > $max_depth ) {
				$max_depth = $depth;
				$best_category = $cat;
			}
		}
		
		// If we found a specific category, add it
		if ( $best_category ) {
			$insert_position = count( $crumbs ) - 1; // Before last item (product name)
			
			$category_crumb = [
				$best_category->name,
				get_term_link( $best_category ),
				'hide_in_schema' => false,
			];
			
			array_splice( $crumbs, $insert_position, 0, [$category_crumb] );
		}
	}
	
	return $crumbs;
}
add_filter( 'rank_math/frontend/breadcrumb/items', 'fajnestarocie_customize_rankmath_breadcrumbs', 10, 2 );

/**
 * Add classification block to product summary for vinyl products with Schema markup
 */
function fajnestarocie_add_product_classification() {
	// Only on single product pages
	if ( ! is_product() ) {
		return;
	}
	
	global $product;
	
	// Check if product has 'winyle' category
	$product_categories = wp_get_post_terms( $product->get_id(), 'product_cat', array( 'fields' => 'slugs' ) );
	
	if ( ! is_wp_error( $product_categories ) && in_array( 'winyle', $product_categories ) ) {
		// Get classification field from ACF
		$classification = get_field( 'classification', $product->get_id() );
		
		if ( $classification ) {
			// Schema markup for vinyl classification
			$schema_data = array(
				'@context' => 'https://schema.org',
				'@type' => 'MusicRecording',
				'name' => $product->get_name(),
				'url' => get_permalink( $product->get_id() ),
				'genre' => $classification,
				'recordingOf' => array(
					'@type' => 'MusicComposition',
					'name' => $product->get_name()
				),
				'additionalProperty' => array(
					'@type' => 'PropertyValue',
					'name' => 'Klasyfikacja winyla',
					'value' => $classification,
					'propertyID' => 'vinyl_classification'
				)
			);
			
			// Output HTML with microdata
			echo '<div class="product-classification" itemscope itemtype="https://schema.org/MusicRecording">';
			echo '<meta itemprop="name" content="' . esc_attr( $product->get_name() ) . '">';
			echo '<meta itemprop="url" content="' . esc_url( get_permalink( $product->get_id() ) ) . '">';
			echo '<meta itemprop="genre" content="' . esc_attr( $classification ) . '">';
			
			echo '<div class="classification-inline">';
			echo '<div class="classification-label-value">Klasyfikacja płyty: <span class="classification-value" itemprop="genre">' . esc_html( $classification ) . '</span></div>';
			echo '<a href="https://fajnestarocie.pl/klasyfikacja-winyli/" target="_blank" class="classification-help" title="Informacja o gatunku muzycznym płyty winylowej">więcej informacji o klasyfikacji<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-external-link"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" /><path d="M11 13l9 -9" /><path d="M15 4h5v5" /></svg></a>';
			echo '</div>';
			echo '</div>';
			
			// Add JSON-LD schema
			echo '<script type="application/ld+json">' . wp_json_encode( $schema_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
		}
	}
}
// Hook after product meta (priority 45) but before sharing (priority 50)
add_action( 'woocommerce_single_product_summary', 'fajnestarocie_add_product_classification', 45 );

/**
 * Add vinyl-specific schema to existing product schema
 */
function fajnestarocie_enhance_product_schema( $markup, $product ) {
	// Only for vinyl products
	$product_categories = wp_get_post_terms( $product->get_id(), 'product_cat', array( 'fields' => 'slugs' ) );
	
	if ( ! is_wp_error( $product_categories ) && in_array( 'winyle', $product_categories ) ) {
		$classification = get_field( 'classification', $product->get_id() );
		
		if ( $classification ) {
			// Keep @type as Product but add music properties
			// WooCommerce doesn't handle array @type values properly
			$markup['genre'] = $classification;
			$markup['musicReleaseFormat'] = 'Vinyl';
			
			// Initialize additionalProperty if not exists
			if ( ! isset( $markup['additionalProperty'] ) ) {
				$markup['additionalProperty'] = array();
			}
			
			$markup['additionalProperty'][] = array(
				'@type' => 'PropertyValue',
				'name' => 'Format',
				'value' => 'Płyta winylowa'
			);
			$markup['additionalProperty'][] = array(
				'@type' => 'PropertyValue', 
				'name' => 'Klasyfikacja',
				'value' => $classification
			);
		}
	}
	
	return $markup;
}
add_filter( 'woocommerce_structured_data_product', 'fajnestarocie_enhance_product_schema', 10, 2 );