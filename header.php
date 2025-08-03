<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package fajnestarocie
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Cormorant+Garamond:400|Roboto+Mono:400&amp;subset=latin">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">

    <!-- favicon -->
    <link rel="icon" type="image/png" href="<?php echo get_theme_file_uri() ?>/dist/images/favicon-96x96.png"
        sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="<?php echo get_theme_file_uri() ?>/dist/images/favicon.svg" />
    <link rel="shortcut icon" href="<?php echo get_theme_file_uri() ?>/dist/images/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180"
        href="<?php echo get_theme_file_uri() ?>/dist/images/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="fajnestarocie" />
    <link rel="manifest" href="<?php echo get_theme_file_uri() ?>/dist/images/site.webmanifest" />


    <!-- Google Tag Manager -->
    <script>
    (function(w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start': new Date().getTime(),
            event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s),
            dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-P3LWJMMV');
    </script>
    <!-- End Google Tag Manager -->

    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div id="page" class="site">
        <?php get_template_part('template-parts/navigation'); ?>