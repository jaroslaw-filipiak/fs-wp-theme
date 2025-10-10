<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package fajnestarocie
 */

get_header();
?>

<main id="primary" class="site-main container mx-auto">

    <section class="error-404 not-found">
        <header class="page-header">
            <h1 class="page-title">
                <?php pll_e( 'Upss! Strona nie została znaleziona.' ); ?></h1>
        </header><!-- .page-header -->

        <div class="page-content">
            <p class="page-description">
                <?php pll_e( 'Wygląda na to, że nie ma nic na tej stronie. Może spróbuj znaleźć coś na innych stronach lub wyszukać?' ); ?>
            </p>
        </div><!-- .page-content -->
    </section><!-- .error-404 -->

</main><!-- #main -->

<?php
get_footer();