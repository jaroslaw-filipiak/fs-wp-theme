<?php
/**
 * Free Shipping – InPost integration
 *
 * • Registers InPost shipping classes in WooCommerce (if not yet present).
 * • Zeroes out all shipping costs visible to the customer (shipping is "free"
 *   from the customer's perspective; the shipping cost is already included in
 *   the product price).
 * • Adds an admin product-list column that shows the estimated InPost cost for
 *   each product based on its assigned shipping class.
 * • Shows a "Darmowa wysyłka" badge on single-product pages (excluding the
 *   "individual" class, which requires personal arrangement).
 *
 * @package fajnestarocie
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ─────────────────────────────────────────────────────────────────────────────
// InPost shipping class reference prices (PLN incl. VAT).
// Keys must match the WooCommerce shipping-class slugs registered below.
// Prices can be overridden via the 'fajnestarocie_inpost_shipping_classes'
// filter so that a child theme / plugin can supply live rates.
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Return InPost shipping class definitions.
 *
 * Each entry:
 *   slug  => [
 *     'name'  => Display name (visible in WooCommerce admin),
 *     'price' => Reference price in PLN (used only for admin tracking),
 *   ]
 *
 * @return array
 */
function fajnestarocie_inpost_shipping_classes() {
    $classes = array(
        'inpost-gabaryt-a' => array(
            'name'  => 'InPost Paczkomat – Gabaryt A (maks. 8×38×64 cm)',
            'price' => 9.99,
        ),
        'inpost-gabaryt-b' => array(
            'name'  => 'InPost Paczkomat – Gabaryt B (maks. 19×38×64 cm)',
            'price' => 10.99,
        ),
        'inpost-gabaryt-c' => array(
            'name'  => 'InPost Paczkomat – Gabaryt C (maks. 41×38×64 cm)',
            'price' => 12.99,
        ),
        'inpost-kurier-s'  => array(
            'name'  => 'InPost Kurier – S (do 1 kg)',
            'price' => 14.99,
        ),
        'inpost-kurier-m'  => array(
            'name'  => 'InPost Kurier – M (1–5 kg)',
            'price' => 18.99,
        ),
        'inpost-kurier-l'  => array(
            'name'  => 'InPost Kurier – L (5–10 kg)',
            'price' => 22.99,
        ),
        'inpost-kurier-xl' => array(
            'name'  => 'InPost Kurier – XL (10–20 kg, ponadstandardowy)',
            'price' => 28.99,
        ),
        'individual'       => array(
            'name'  => 'Indywidual – cena wysyłki uzgadniana indywidualnie',
            'price' => null,
        ),
    );

    return apply_filters( 'fajnestarocie_inpost_shipping_classes', $classes );
}

// ─────────────────────────────────────────────────────────────────────────────
// 1. Auto-register InPost shipping classes in WooCommerce
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Create InPost shipping classes in WooCommerce if they do not already exist.
 * Runs on 'init' so that it is available as early as possible without
 * duplicating work on every request (uses a transient guard).
 */
function fajnestarocie_register_inpost_shipping_classes() {
    // Only run in admin context or during cron; skip on every front-end hit.
    if ( ! is_admin() && ! ( defined( 'DOING_CRON' ) && DOING_CRON ) ) {
        return;
    }

    // Use a transient to avoid the DB query on every admin page load.
    if ( get_transient( 'fajnestarocie_shipping_classes_registered' ) ) {
        return;
    }

    $classes = fajnestarocie_inpost_shipping_classes();

    foreach ( $classes as $slug => $data ) {
        $existing = get_term_by( 'slug', $slug, 'product_shipping_class' );
        if ( ! $existing ) {
            wp_insert_term(
                $data['name'],
                'product_shipping_class',
                array( 'slug' => $slug )
            );
        }
    }

    set_transient( 'fajnestarocie_shipping_classes_registered', true, DAY_IN_SECONDS );
}
add_action( 'init', 'fajnestarocie_register_inpost_shipping_classes' );

/**
 * Clear the registration transient whenever shipping classes are changed in
 * the WooCommerce admin, so new or renamed classes are picked up immediately.
 */
function fajnestarocie_clear_shipping_class_transient() {
    delete_transient( 'fajnestarocie_shipping_classes_registered' );
}
add_action( 'created_product_shipping_class', 'fajnestarocie_clear_shipping_class_transient' );
add_action( 'edited_product_shipping_class',  'fajnestarocie_clear_shipping_class_transient' );
add_action( 'deleted_product_shipping_class', 'fajnestarocie_clear_shipping_class_transient' );

// ─────────────────────────────────────────────────────────────────────────────
// 2. Make shipping free for customers
//    All shipping method costs are zeroed out at the package-rate level so
//    that the customer always sees "Darmowa wysyłka / Free shipping".
//    Products with the 'individual' shipping class are non-purchasable (handled
//    in inc/woocommerce.php) so they never reach this filter.
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Zero out all shipping costs so the customer pays nothing extra for shipping.
 *
 * @param  array $rates  Array of WC_Shipping_Rate objects keyed by rate ID.
 * @param  array $package The shipping package.
 * @return array
 */
function fajnestarocie_make_shipping_free( $rates, $package ) {
    foreach ( $rates as $rate_id => $rate ) {
        $rate->set_cost( 0 );
        // Remove any tax on shipping as well.
        $rate->set_taxes( array() );
    }
    return $rates;
}
add_filter( 'woocommerce_package_rates', 'fajnestarocie_make_shipping_free', 100, 2 );

// ─────────────────────────────────────────────────────────────────────────────
// 3. "Darmowa wysyłka" badge on single-product pages
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Append a "Darmowa wysyłka" badge to the product price HTML.
 * Skipped for products with the 'individual' shipping class (they are
 * non-purchasable and display their own contact message).
 *
 * @param  string     $price_html
 * @param  WC_Product $product
 * @return string
 */
function fajnestarocie_free_shipping_badge( $price_html, $product ) {
    if ( ! is_singular( 'product' ) ) {
        return $price_html;
    }

    if ( $product->get_shipping_class() === 'individual' ) {
        return $price_html;
    }

    $badge = '<span class="free-shipping-badge">'
        . esc_html__( 'Darmowa wysyłka', 'fajnestarocie' )
        . '</span>';

    return $price_html . $badge;
}
add_filter( 'woocommerce_get_price_html', 'fajnestarocie_free_shipping_badge', 20, 2 );

// ─────────────────────────────────────────────────────────────────────────────
// 4. Admin: show estimated shipping cost in the product list
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Register a "Koszt wysyłki" column in the WooCommerce product list table.
 *
 * @param  array $columns
 * @return array
 */
function fajnestarocie_add_shipping_cost_column( $columns ) {
    // Insert after 'price' column if present, otherwise at the end.
    $new_columns = array();
    foreach ( $columns as $key => $value ) {
        $new_columns[ $key ] = $value;
        if ( $key === 'price' ) {
            $new_columns['shipping_cost'] = __( 'Koszt wysyłki', 'fajnestarocie' );
        }
    }
    if ( ! isset( $new_columns['shipping_cost'] ) ) {
        $new_columns['shipping_cost'] = __( 'Koszt wysyłki', 'fajnestarocie' );
    }
    return $new_columns;
}
add_filter( 'manage_edit-product_columns', 'fajnestarocie_add_shipping_cost_column' );

/**
 * Output the shipping cost value for a given product row.
 *
 * @param string $column  Current column key.
 * @param int    $post_id Product post ID.
 */
function fajnestarocie_render_shipping_cost_column( $column, $post_id ) {
    if ( $column !== 'shipping_cost' ) {
        return;
    }

    $product = wc_get_product( $post_id );
    if ( ! $product ) {
        echo '—';
        return;
    }

    $shipping_class = $product->get_shipping_class();
    $classes        = fajnestarocie_inpost_shipping_classes();

    if ( ! $shipping_class ) {
        echo '<span class="fajnestarocie-shipping-no-class">' . esc_html__( 'Brak klasy', 'fajnestarocie' ) . '</span>';
        return;
    }

    if ( $shipping_class === 'individual' ) {
        echo '<span class="fajnestarocie-shipping-individual">' . esc_html__( 'Indywidual', 'fajnestarocie' ) . '</span>';
        return;
    }

    if ( isset( $classes[ $shipping_class ] ) && $classes[ $shipping_class ]['price'] !== null ) {
        $price = $classes[ $shipping_class ]['price'];
        echo '<strong>' . wc_price( $price ) . '</strong>';
        return;
    }

    echo '<span class="fajnestarocie-shipping-unknown">' . esc_html( $shipping_class ) . '</span>';
}
add_action( 'manage_product_posts_custom_column', 'fajnestarocie_render_shipping_cost_column', 10, 2 );

// ─────────────────────────────────────────────────────────────────────────────
// 5. Admin: show shipping cost in the order item meta
//    When an order is placed, store the estimated shipping cost as order item
//    meta so it is visible in the order admin and can be used for accounting.
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Store estimated InPost shipping cost on each order line item.
 *
 * @param WC_Order_Item_Product $item
 * @param string                $cart_item_key
 * @param array                 $values
 * @param WC_Order              $order
 */
function fajnestarocie_save_shipping_cost_to_order_item( $item, $cart_item_key, $values, $order ) {
    $product = $item->get_product();
    if ( ! $product ) {
        return;
    }

    $shipping_class = $product->get_shipping_class();
    $classes        = fajnestarocie_inpost_shipping_classes();

    if ( $shipping_class && isset( $classes[ $shipping_class ] ) ) {
        $class_data = $classes[ $shipping_class ];
        if ( $class_data['price'] !== null ) {
            $item->add_meta_data( '_shipping_cost_inpost', $class_data['price'], true );
            $item->add_meta_data( '_shipping_class_label', $class_data['name'], true );
        } elseif ( $shipping_class === 'individual' ) {
            $item->add_meta_data( '_shipping_class_label', $class_data['name'], true );
        }
    }
}
add_action( 'woocommerce_checkout_create_order_line_item', 'fajnestarocie_save_shipping_cost_to_order_item', 10, 4 );

/**
 * Display shipping cost meta in the admin order detail view.
 *
 * @param  string               $display_key
 * @param  WC_Meta_Data         $meta
 * @param  WC_Order_Item        $item
 * @return string
 */
function fajnestarocie_order_item_shipping_cost_label( $display_key, $meta, $item ) {
    if ( $meta->key === '_shipping_cost_inpost' ) {
        return __( 'Koszt wysyłki (InPost)', 'fajnestarocie' );
    }
    if ( $meta->key === '_shipping_class_label' ) {
        return __( 'Klasa wysyłki', 'fajnestarocie' );
    }
    return $display_key;
}
add_filter( 'woocommerce_order_item_display_meta_key', 'fajnestarocie_order_item_shipping_cost_label', 10, 3 );

/**
 * Format the shipping cost value in the admin order detail view.
 *
 * @param  string        $display_value
 * @param  WC_Meta_Data  $meta
 * @param  WC_Order_Item $item
 * @return string
 */
function fajnestarocie_order_item_shipping_cost_value( $display_value, $meta, $item ) {
    if ( $meta->key === '_shipping_cost_inpost' ) {
        return wc_price( floatval( $meta->value ) );
    }
    return $display_value;
}
add_filter( 'woocommerce_order_item_display_meta_value', 'fajnestarocie_order_item_shipping_cost_value', 10, 3 );

// ─────────────────────────────────────────────────────────────────────────────
// 6. Admin: enqueue styles for the shipping cost column
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Output inline admin CSS for the shipping cost column labels.
 * Keeps styling out of the PHP output while avoiding a separate HTTP request
 * for such a small amount of admin-only CSS.
 */
function fajnestarocie_admin_shipping_cost_styles() {
    $screen = get_current_screen();
    if ( ! $screen || $screen->id !== 'edit-product' ) {
        return;
    }
    ?>
    <style id="fajnestarocie-shipping-cost-admin">
        .fajnestarocie-shipping-no-class,
        .fajnestarocie-shipping-unknown { color: #999; }
        .fajnestarocie-shipping-individual { color: #0073aa; font-weight: 600; }
    </style>
    <?php
}
add_action( 'admin_head', 'fajnestarocie_admin_shipping_cost_styles' );
