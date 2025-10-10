<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package fajnestarocie
 */

get_header();
?>

<main id="primary" class="site-main container mx-auto">

    <?php if ( have_posts() ) : ?>

    <header class="page-header flex items-center justify-start gap-3">

        <p class="search-results-for"><?php pll_e('Wyniki wyszukiwania dla:'); ?></p>
        <p class="search-results-query">"<?php echo get_search_query(); ?>"</p>

    </header><!-- .page-header -->

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
    </div>
</main><!-- #main -->

<?php
get_sidebar();
get_footer();