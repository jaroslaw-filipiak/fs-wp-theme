<?php
/**
 * Template Name: Blog
 *
 * @package Fajnestarocie
 */

get_header(); ?>

<main id="primary" class="site-main">
    <div class="container mx-auto py-12 lg:py-24 px-4">

        <?php
		// Page header
		while ( have_posts() ) :
			the_post();
		?>
        <header class="page-header mb-12">
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php if ( get_the_content() ) : ?>
            <div class="page-description text-lg text-gray-600 max-w-3xl">
                <?php the_content(); ?>
            </div>
            <?php endif; ?>
        </header>
        <?php endwhile; ?>

        <?php
		// Pagination
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		// Query blog posts
		$blog_query = new WP_Query( array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 9,
			'paged'          => $paged,
		) );

		if ( $blog_query->have_posts() ) : ?>

        <div class="blog-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            <?php while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>

            <article id="post-<?php the_ID(); ?>"
                <?php post_class( 'blog-card flex flex-col bg-white shadow-md hover:shadow-lg transition-shadow duration-300' ); ?>>

                <div class="blog-card__image overflow-hidden">
                    <?php if ( has_post_thumbnail() ) : ?>
                    <a href="<?php the_permalink(); ?>" class="block">
                        <?php the_post_thumbnail( 'medium_large', array(
										'class' => 'w-full h-48 lg:h-56 object-cover hover:scale-105 transition-transform duration-300',
									) ); ?>
                    </a>
                    <?php else : ?>
                    <a href="<?php the_permalink(); ?>" class="block  h-48 lg:h-56 flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </a>
                    <?php endif; ?>
                </div>

                <div class="blog-card__content p-5 lg:p-6">
                    <h2 class="blog-card__title text-xl lg:text-2xl font-heading mb-3 leading-tight">
                        <a href="<?php the_permalink(); ?>" class="hover:text-teal-700 transition-colors duration-200">
                            <?php the_title(); ?>
                        </a>
                    </h2>

                    <div class="blog-card__excerpt text-gray-600 text-sm lg:text-base mb-4 line-clamp-3">
                        <?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?>
                    </div>

                    <div class="blog-card__meta flex items-center justify-between text-sm text-gray-500">
                        <time datetime="<?php echo get_the_date( 'c' ); ?>">
                            <?php echo get_the_date( 'j F Y' ); ?>
                        </time>
                        <a href="<?php the_permalink(); ?>" class="btn-main btn-main--small">
                            <?php esc_html_e( 'Czytaj dalej', 'fajnestarocie' ); ?> &rarr;
                        </a>
                    </div>
                </div>

            </article>

            <?php endwhile; ?>
        </div>

        <?php
			// Pagination
			$total_pages = $blog_query->max_num_pages;

			if ( $total_pages > 1 ) : ?>
        <nav class="blog-pagination flex items-center justify-center gap-2 mt-12 lg:mt-16">
            <?php
					// Previous page
					if ( $paged > 1 ) : ?>
            <a href="<?php echo get_pagenum_link( $paged - 1 ); ?>"
                class="px-4 py-2 bg-zinc-500 text-white hover:bg-zinc-800 transition-colors duration-200">
                &larr; <?php esc_html_e( 'Poprzednia', 'fajnestarocie' ); ?>
            </a>
            <?php endif; ?>

            <?php
					// Page numbers
					$range = 2;
					$start = max( 1, $paged - $range );
					$end = min( $total_pages, $paged + $range );

					// First page
					if ( $start > 1 ) : ?>
            <a href="<?php echo get_pagenum_link( 1 ); ?>"
                class="px-4 py-2 hover:bg-gray-100 transition-colors duration-200">1</a>
            <?php if ( $start > 2 ) : ?>
            <span class="px-2 text-gray-400">...</span>
            <?php endif; ?>
            <?php endif; ?>

            <?php
					// Page range
					for ( $i = $start; $i <= $end; $i++ ) :
						if ( $i == $paged ) : ?>
            <span class="px-4 py-2 bg-zinc-500 text-white"><?php echo $i; ?></span>
            <?php else : ?>
            <a href="<?php echo get_pagenum_link( $i ); ?>"
                class="px-4 py-2 hover:bg-gray-100 transition-colors duration-200"><?php echo $i; ?></a>
            <?php endif;
					endfor; ?>

            <?php
					// Last page
					if ( $end < $total_pages ) :
						if ( $end < $total_pages - 1 ) : ?>
            <span class="px-2 text-gray-400">...</span>
            <?php endif; ?>
            <a href="<?php echo get_pagenum_link( $total_pages ); ?>"
                class="px-4 py-2 hover:bg-gray-100 transition-colors duration-200"><?php echo $total_pages; ?></a>
            <?php endif; ?>

            <?php
					// Next page
					if ( $paged < $total_pages ) : ?>
            <a href="<?php echo get_pagenum_link( $paged + 1 ); ?>"
                class="px-4 py-2 bg-zinc-500 text-white hover:bg-zinc-800 transition-colors duration-200">
                <?php esc_html_e( 'Następna', 'fajnestarocie' ); ?> &rarr;
            </a>
            <?php endif; ?>
        </nav>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

        <?php else : ?>

        <div class="no-posts text-center py-12">
            <p class="text-lg text-gray-600"><?php esc_html_e( 'Brak wpisów do wyświetlenia.', 'fajnestarocie' ); ?></p>
        </div>

        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>