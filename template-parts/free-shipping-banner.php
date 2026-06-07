<?php

/**
 * Free Shipping Banner / Popup
 *
 * Displayed site-wide. Shows a dismissible info bar informing
 * visitors that shipping is free for all standard-size items.
 * The dismiss logic uses sessionStorage and works on every page.
 *
 * @package fajnestarocie
 */
?>
<div id="free-shipping-banner" class="free-shipping-banner" role="banner" aria-label="<?php esc_attr_e('Informacja o darmowej wysyłce', 'fajnestarocie'); ?>">
    <div class="free-shipping-banner__inner">
        <span class="free-shipping-banner__icon" aria-hidden="true" style="color: #e7e5e4;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="1" y="3" width="15" height="13" rx="1"></rect>
                <path d="M16 8h4l3 5v3h-7V8z"></path>
                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                <circle cx="18.5" cy="18.5" r="2.5"></circle>
            </svg>
        </span>
        <p class="free-shipping-banner__message">
            <?php esc_html_e('Darmowa wysyłka przedmiotów zakupionych w naszym sklepie', 'fajnestarocie'); ?>
            <span class="free-shipping-banner__disclaimer">
                <?php esc_html_e('* nie dotyczy produktów o ponadstandardowych gabarytach', 'fajnestarocie'); ?>
            </span>
        </p>
        <button
            class="free-shipping-banner__close"
            id="free-shipping-banner-close"
            aria-label="<?php esc_attr_e('Zamknij', 'fajnestarocie'); ?>"
            type="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                aria-hidden="true">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>
</div>
<script>
    (function() {
        var STORAGE_KEY = 'fajnestarocie_free_shipping_banner_dismissed';
        var banner = document.getElementById('free-shipping-banner');
        var closeBtn = document.getElementById('free-shipping-banner-close');

        if (!banner || !closeBtn) return;

        if (banner.dataset.bound === '1') return;
        banner.dataset.bound = '1';

        if (sessionStorage.getItem(STORAGE_KEY)) {
            banner.classList.add('free-shipping-banner--hidden');
            return;
        }

        closeBtn.addEventListener('click', function() {
            banner.classList.add('free-shipping-banner--hidden');
            sessionStorage.setItem(STORAGE_KEY, '1');
        });
    })();
</script>