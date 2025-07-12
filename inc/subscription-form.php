<?php 


if ( ! function_exists( 'sanitize_text_field' ) ) {
    require_once( ABSPATH . 'wp-includes/pluggable.php' );
}


add_action('wp_ajax_newsletter_subscribe', 'handle_newsletter_subscribe_ajax');
add_action('wp_ajax_nopriv_newsletter_subscribe', 'handle_newsletter_subscribe_ajax');


function create_newsletter_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        email varchar(100) NOT NULL,
        name varchar(100) DEFAULT '' NOT NULL,
        date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function handle_newsletter_subscribe_ajax() {
    if (!isset($_POST['newsletter_nonce']) || !wp_verify_nonce($_POST['newsletter_nonce'], 'newsletter_subscribe_nonce')) {
        wp_send_json_error(['message' => 'Błąd bezpieczeństwa.']);
    }

    $email = sanitize_email($_POST['email']);
    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';

    if (!is_email($email)) {
        wp_send_json_error(['message' => 'Nieprawidłowy adres e-mail.']);
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';

    if (!$wpdb->get_var("SHOW TABLES LIKE '$table_name'")) {
        create_newsletter_table();
    }

    // check if email already exists
    $exists = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE email = %s", $email));
    if ($exists > 0) {
        wp_send_json_error(['message' => 'Ten adres e-mail jest już zapisany do newslettera.']);
    }

    $wpdb->insert(
        $table_name,
        [
            'email' => $email,
            'name' => $name,
            'date' => current_time('mysql')
        ],
        ['%s', '%s', '%s']
    );

    wp_send_json_success(['message' => 'Dziękujemy za zapis do newslettera!']);
}