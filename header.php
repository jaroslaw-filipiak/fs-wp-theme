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

    <!-- cookies -->

    <link rel="stylesheet" id="silktide-consent-manager-css"
        href="<?php echo get_theme_file_uri() ?>/dist/silktide-consent-manager.css">
    <script src="<?php echo get_theme_file_uri() ?>/dist/silktide-consent-manager.js"></script>
    <script>
    silktideCookieBannerManager.updateCookieBannerConfig({
        background: {
            showBackground: true
        },
        cookieIcon: {
            position: "bottomLeft"
        },
        cookieTypes: [{
                id: "niezb_dne",
                name: "Niezbędne",
                description: "<p>Te pliki cookie są niezbędne do prawidłowego funkcjonowania witryny i nie można ich wyłączyć. Pomagają one między innymi w logowaniu i ustawianiu preferencji prywatności.</p>",
                required: true,
                onAccept: function() {

                }
            },
            {
                id: "analityczne",
                name: "Analityczne",
                description: "<p>Te pliki cookie pomagają nam ulepszać witrynę, śledząc, które strony są najpopularniejsze i w jaki sposób odwiedzający poruszają się po witrynie.</p>",
                required: false,
                onAccept: function() {
                    gtag('consent', 'update', {
                        analytics_storage: 'granted',
                    });
                    dataLayer.push({
                        'event': 'consent_accepted_analityczne',
                    });
                },
                onReject: function() {
                    gtag('consent', 'update', {
                        analytics_storage: 'denied',
                    });
                }
            },
            {
                id: "reklamowe",
                name: "Reklamowe",
                description: "<p>Te pliki cookie zapewniają dodatkowe funkcje i personalizację, aby ulepszyć Twoje doświadczenia. Mogą być ustawiane przez nas lub przez partnerów, z których usług korzystamy.</p>",
                required: false,
                onAccept: function() {
                    gtag('consent', 'update', {
                        ad_storage: 'granted',
                        ad_user_data: 'granted',
                        ad_personalization: 'granted',
                    });
                    dataLayer.push({
                        'event': 'consent_accepted_reklamowe',
                    });
                },
                onReject: function() {
                    gtag('consent', 'update', {
                        ad_storage: 'denied',
                        ad_user_data: 'denied',
                        ad_personalization: 'denied',
                    });
                }
            }
        ],
        text: {
            banner: {
                description: "<font color=\"#39434c\"><span style=\"letter-spacing: 0.34px;\">Na naszej stronie internetowej używamy plików cookie, aby ulepszyć komfort użytkowania, dostarczać spersonalizowane treści i analizować ruch. <a href=\"https://fajnestarocie.pl/polityka-prywatnosci/\" target=\"_blank\">Polityka prywatności</a>.</span></font>",
                acceptAllButtonText: "Akceptuje",
                acceptAllButtonAccessibleLabel: "Akceptuje",
                rejectNonEssentialButtonText: "Odrzucam",
                rejectNonEssentialButtonAccessibleLabel: "Odrzucam",
                preferencesButtonText: "Preferencje",
                preferencesButtonAccessibleLabel: "Preferencje"
            },
            preferences: {
                title: "Dostosuj swoje preferencje dotyczące plików cookie",
                description: "<p>Szanujemy Twoje prawo do prywatności. Możesz nie zezwolić na niektóre rodzaje plików cookie. Twoje preferencje dotyczące plików cookie będą miały zastosowanie na całej naszej stronie internetowej.</p>",
                creditLinkText: "skrypt cookies",
                creditLinkAccessibleLabel: "consent manager"
            }
        }
    });
    </script>


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