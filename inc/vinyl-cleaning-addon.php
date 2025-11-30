<?php
/**
 * Vinyl Cleaning Add-on for WooCommerce
 *
 * Adds a checkbox option to vinyl products for cleaning service (+10 zł)
 *
 * @package fajnestarocie
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Display cleaning checkbox on single product page for vinyl category
 */
add_action('woocommerce_before_add_to_cart_button', 'vinyl_cleaning_checkbox_display');
function vinyl_cleaning_checkbox_display() {
    global $product;

    // Sprawdź czy produkt jest w kategorii "winyle"
    if (!has_term('winyle', 'product_cat', $product->get_id())) {
        return;
    }

    // Wyświetl checkbox
    echo '<div class="vinyl-cleaning-addon">';
    echo '<label class="vinyl-cleaning-addon__label">';
    echo '<input type="checkbox" name="vinyl_cleaning" value="yes" class="vinyl-cleaning-addon__checkbox" />';
    echo '<span class="vinyl-cleaning-addon__text">Mycie płyty winylowej <span class="vinyl-cleaning-addon__price">(+10 zł)</span></span>';
    echo '</label>';
    echo '<p class="vinyl-cleaning-addon__description">Profesjonalne mycie płyty przed wysyłką</p>';
    echo '</div>';
}

/**
 * Add cleaning service price to cart item
 */
add_filter('woocommerce_add_cart_item_data', 'vinyl_cleaning_add_cart_item_data', 10, 3);
function vinyl_cleaning_add_cart_item_data($cart_item_data, $product_id, $variation_id) {

    if (isset($_POST['vinyl_cleaning']) && $_POST['vinyl_cleaning'] === 'yes') {
        $cart_item_data['vinyl_cleaning'] = 'yes';
        // Unikatowy klucz aby każdy item był osobno
        $cart_item_data['unique_key'] = md5(microtime().rand());
    }

    return $cart_item_data;
}

/**
 * Modify cart item price to include cleaning service
 */
add_action('woocommerce_before_calculate_totals', 'vinyl_cleaning_modify_cart_item_price');
function vinyl_cleaning_modify_cart_item_price($cart) {

    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        if (isset($cart_item['vinyl_cleaning']) && $cart_item['vinyl_cleaning'] === 'yes') {
            $original_price = $cart_item['data']->get_price();
            $new_price = $original_price + 10; // Dodaj 10 zł za mycie
            $cart_item['data']->set_price($new_price);
        }
    }
}

/**
 * Display cleaning service info in cart
 */
add_filter('woocommerce_get_item_data', 'vinyl_cleaning_display_cart_item_data', 10, 2);
function vinyl_cleaning_display_cart_item_data($item_data, $cart_item) {

    if (isset($cart_item['vinyl_cleaning']) && $cart_item['vinyl_cleaning'] === 'yes') {
        $item_data[] = array(
            'key'   => 'Dodatkowo',
            'value' => 'Mycie płyty (+10 zł)',
        );
    }

    return $item_data;
}

/**
 * Save cleaning service info to order item meta
 */
add_action('woocommerce_checkout_create_order_line_item', 'vinyl_cleaning_add_order_item_meta', 10, 4);
function vinyl_cleaning_add_order_item_meta($item, $cart_item_key, $values, $order) {

    if (isset($values['vinyl_cleaning']) && $values['vinyl_cleaning'] === 'yes') {
        $item->add_meta_data('Mycie płyty', 'Tak (+10 zł)', true);
    }
}

/**
 * Display cleaning service in admin order
 */
add_filter('woocommerce_order_item_display_meta_key', 'vinyl_cleaning_order_item_display_meta_key', 10, 3);
function vinyl_cleaning_order_item_display_meta_key($display_key, $meta, $item) {

    if ($meta->key === 'Mycie płyty') {
        return 'Usługa mycia';
    }

    return $display_key;
}