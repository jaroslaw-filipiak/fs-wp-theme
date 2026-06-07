<?php

/**
 * Free Shipping – InPost integration
 *
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

if (! defined('ABSPATH')) {
    exit;
}

// ─────────────────────────────────────────────────────────────────────────────
// Shipping class data is read from native WooCommerce configuration.
// No class/cost values are hardcoded in the theme.
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Try to read class cost from native WooCommerce shipping-method settings.
 *
 * @param int $term_id Shipping class term ID.
 * @return float|null
 */
function fajnestarocie_get_wc_shipping_class_cost($term_id)
{
    static $cost_cache = array();

    $term_id = (int) $term_id;
    if ($term_id <= 0) {
        return null;
    }

    if (array_key_exists($term_id, $cost_cache)) {
        return $cost_cache[$term_id];
    }

    if (! class_exists('WC_Shipping_Zones')) {
        $cost_cache[$term_id] = null;
        return null;
    }

    $zone_ids = array(0);
    $zones    = WC_Shipping_Zones::get_zones();

    foreach ($zones as $zone) {
        if (isset($zone['zone_id'])) {
            $zone_ids[] = (int) $zone['zone_id'];
        }
    }

    foreach (array_unique($zone_ids) as $zone_id) {
        $zone = WC_Shipping_Zones::get_zone($zone_id);
        if (! $zone) {
            continue;
        }

        $methods = $zone->get_shipping_methods(true);
        foreach ($methods as $method) {
            if (! isset($method->instance_settings)) {
                continue;
            }

            $settings = is_array($method->instance_settings) ? $method->instance_settings : array();
            $key      = 'class_cost_' . $term_id;

            if (! array_key_exists($key, $settings) || $settings[$key] === '') {
                continue;
            }

            $value = str_replace(',', '.', (string) $settings[$key]);
            if (is_numeric($value)) {
                $cost_cache[$term_id] = (float) $value;
                return $cost_cache[$term_id];
            }
        }
    }

    $cost_cache[$term_id] = null;
    return null;
}

/**
 * Return shipping surcharge for a product based on native WooCommerce class cost.
 *
 * @param WC_Product $product Product object.
 * @return float
 */
function fajnestarocie_get_shipping_surcharge_for_product($product)
{
    if (! $product instanceof WC_Product) {
        return 0.0;
    }

    if ($product->get_shipping_class() === 'individual') {
        return 0.0;
    }

    $class_id = (int) $product->get_shipping_class_id();
    if ($class_id <= 0) {
        return 0.0;
    }

    $cost = fajnestarocie_get_wc_shipping_class_cost($class_id);
    if ($cost === null || $cost < 0) {
        return 0.0;
    }

    return (float) $cost;
}

/**
 * Add shipping class surcharge to product price on frontend/cart/checkout.
 *
 * @param string|float $price   Base product price.
 * @param WC_Product   $product Product object.
 * @return string|float
 */
function fajnestarocie_apply_shipping_surcharge_to_price($price, $product)
{
    if ($price === '' || $price === null) {
        return $price;
    }

    if (is_admin() && ! wp_doing_ajax()) {
        return $price;
    }

    $base_price = (float) $price;
    if ($base_price < 0) {
        return $price;
    }

    $surcharge = fajnestarocie_get_shipping_surcharge_for_product($product);
    if ($surcharge <= 0) {
        return $price;
    }

    return (string) ($base_price + $surcharge);
}
add_filter('woocommerce_product_get_price', 'fajnestarocie_apply_shipping_surcharge_to_price', 99, 2);
add_filter('woocommerce_product_variation_get_price', 'fajnestarocie_apply_shipping_surcharge_to_price', 99, 2);
add_filter('woocommerce_product_get_regular_price', 'fajnestarocie_apply_shipping_surcharge_to_price', 99, 2);
add_filter('woocommerce_product_variation_get_regular_price', 'fajnestarocie_apply_shipping_surcharge_to_price', 99, 2);
add_filter('woocommerce_product_get_sale_price', 'fajnestarocie_apply_shipping_surcharge_to_price', 99, 2);
add_filter('woocommerce_product_variation_get_sale_price', 'fajnestarocie_apply_shipping_surcharge_to_price', 99, 2);

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
function fajnestarocie_inpost_shipping_classes()
{
    $classes = array();

    if (taxonomy_exists('product_shipping_class')) {
        $terms = get_terms(
            array(
                'taxonomy'   => 'product_shipping_class',
                'hide_empty' => false,
            )
        );

        if (! is_wp_error($terms)) {
            foreach ($terms as $term) {
                $classes[$term->slug] = array(
                    'name'  => $term->name,
                    'price' => fajnestarocie_get_wc_shipping_class_cost((int) $term->term_id),
                );
            }
        }
    }

    return apply_filters('fajnestarocie_inpost_shipping_classes', $classes);
}

// ─────────────────────────────────────────────────────────────────────────────
// 1. Make shipping free for customers
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
function fajnestarocie_make_shipping_free($rates, $package)
{
    foreach ($rates as $rate_id => $rate) {
        $rate->set_cost(0);
        // Remove any tax on shipping as well.
        $rate->set_taxes(array());
    }
    return $rates;
}
add_filter('woocommerce_package_rates', 'fajnestarocie_make_shipping_free', 100, 2);

// ─────────────────────────────────────────────────────────────────────────────
// 4. Admin: show estimated shipping cost in the product list
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Register a "Koszt wysyłki" column in the WooCommerce product list table.
 *
 * @param  array $columns
 * @return array
 */
function fajnestarocie_add_shipping_cost_column($columns)
{
    // Insert after 'price' column if present, otherwise at the end.
    $new_columns = array();
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'price') {
            $new_columns['shipping_cost'] = __('Koszt wysyłki', 'fajnestarocie');
        }
    }
    if (! isset($new_columns['shipping_cost'])) {
        $new_columns['shipping_cost'] = __('Koszt wysyłki', 'fajnestarocie');
    }
    return $new_columns;
}
add_filter('manage_edit-product_columns', 'fajnestarocie_add_shipping_cost_column');

/**
 * Output the shipping cost value for a given product row.
 *
 * @param string $column  Current column key.
 * @param int    $post_id Product post ID.
 */
function fajnestarocie_render_shipping_cost_column($column, $post_id)
{
    if ($column !== 'shipping_cost') {
        return;
    }

    $product = wc_get_product($post_id);
    if (! $product) {
        echo '—';
        return;
    }

    $shipping_class = $product->get_shipping_class();
    $classes        = fajnestarocie_inpost_shipping_classes();

    if (! $shipping_class) {
        echo '<span class="fajnestarocie-shipping-no-class">' . esc_html__('Brak klasy', 'fajnestarocie') . '</span>';
        return;
    }

    if ($shipping_class === 'individual') {
        echo '<span class="fajnestarocie-shipping-individual">' . esc_html__('Indywidual', 'fajnestarocie') . '</span>';
        return;
    }

    if (isset($classes[$shipping_class])) {
        $price = $classes[$shipping_class]['price'];

        if ($price !== null) {
            echo '<strong>' . wc_price($price) . '</strong>';
            return;
        }

        echo '<span class="fajnestarocie-shipping-no-class">' . esc_html__('Brak ceny', 'fajnestarocie') . '</span>';
        return;
    }

    echo '<span class="fajnestarocie-shipping-unknown">' . esc_html($shipping_class) . '</span>';
}
add_action('manage_product_posts_custom_column', 'fajnestarocie_render_shipping_cost_column', 10, 2);

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
function fajnestarocie_save_shipping_cost_to_order_item($item, $cart_item_key, $values, $order)
{
    $product = $item->get_product();
    if (! $product) {
        return;
    }

    $shipping_class = $product->get_shipping_class();
    $classes        = fajnestarocie_inpost_shipping_classes();

    if ($shipping_class && isset($classes[$shipping_class])) {
        $class_data = $classes[$shipping_class];
        $item->add_meta_data('_shipping_class_label', $class_data['name'], true);

        if ($class_data['price'] !== null) {
            $item->add_meta_data('_shipping_cost_inpost', $class_data['price'], true);
        }
    }
}
add_action('woocommerce_checkout_create_order_line_item', 'fajnestarocie_save_shipping_cost_to_order_item', 10, 4);

/**
 * Display shipping cost meta in the admin order detail view.
 *
 * @param  string               $display_key
 * @param  WC_Meta_Data         $meta
 * @param  WC_Order_Item        $item
 * @return string
 */
function fajnestarocie_order_item_shipping_cost_label($display_key, $meta, $item)
{
    if ($meta->key === '_shipping_cost_inpost') {
        return __('Koszt wysyłki (InPost)', 'fajnestarocie');
    }
    if ($meta->key === '_shipping_class_label') {
        return __('Klasa wysyłki', 'fajnestarocie');
    }
    return $display_key;
}
add_filter('woocommerce_order_item_display_meta_key', 'fajnestarocie_order_item_shipping_cost_label', 10, 3);

/**
 * Format the shipping cost value in the admin order detail view.
 *
 * @param  string        $display_value
 * @param  WC_Meta_Data  $meta
 * @param  WC_Order_Item $item
 * @return string
 */
function fajnestarocie_order_item_shipping_cost_value($display_value, $meta, $item)
{
    if ($meta->key === '_shipping_cost_inpost') {
        return wc_price(floatval($meta->value));
    }
    return $display_value;
}
add_filter('woocommerce_order_item_display_meta_value', 'fajnestarocie_order_item_shipping_cost_value', 10, 3);

// ─────────────────────────────────────────────────────────────────────────────
// 6. Admin: enqueue styles for the shipping cost column
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Output inline admin CSS for the shipping cost column labels.
 * Keeps styling out of the PHP output while avoiding a separate HTTP request
 * for such a small amount of admin-only CSS.
 */
function fajnestarocie_admin_shipping_cost_styles()
{
    $screen = get_current_screen();
    if (! $screen || $screen->id !== 'edit-product') {
        return;
    }
?>
    <style id="fajnestarocie-shipping-cost-admin">
        .fajnestarocie-shipping-no-class,
        .fajnestarocie-shipping-unknown {
            color: #999;
        }

        .fajnestarocie-shipping-individual {
            color: #0073aa;
            font-weight: 600;
        }
    </style>
<?php
}
add_action('admin_head', 'fajnestarocie_admin_shipping_cost_styles');
