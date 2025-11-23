<?php get_header(); ?>

<section class="py-12 lg:py-24 overflow-hidden bg-stone-200">
    <div class="container mx-auto px-4">
        <?php echo get_template_part('template-parts/breadcrumbs'); ?>
        <div class="border-t pt-4 xl:pt-16">
            <div class="flex flex-wrap items-center justify-between mb-20 -mx-4">
                <div class="w-full sm:w-2/3 px-4 mb-10 sm:mb-0">
                    <div class="sm:max-w-lg xl:max-w-none">
                        <h1 class="font-heading text-4xl xs:text-6xl"><?php woocommerce_page_title(); ?></h1>
                    </div>
                </div>
            </div>
            <!-- Filter Tags Section -->
            <?php
         
            if (is_tax('product_cat')) {
                
                $current_category = get_queried_object();
                $categories = get_terms([
                    'taxonomy' => 'product_cat',
                    'hide_empty' => true,
                    'parent' => $current_category->term_id
                ]);
                $filter_heading = 'Podkategorie';
            } else {
               
                $categories = get_terms([
                    'taxonomy' => 'product_cat',
                    'hide_empty' => true,
                    'parent' => 0
                ]);
                $filter_heading = 'Kategorie';
            }
            ?>

            <?php if (!empty($categories) && !is_wp_error($categories)) : ?>
            <div class="mb-12">
                <h3 class="text-lg font-medium text-teal-900 mb-4"><?php echo $filter_heading; ?></h3>
                <div class="flex flex-wrap gap-3">

                    <?php
                    foreach ($categories as $category) {
                        // Pomiń kategorie "bez kategorii"
                        if ($category->slug === 'uncategorized' || $category->slug === 'bez-kategorii' || $category->name === 'Bez kategorii') {
                            continue;
                        }

                        $category_link = get_term_link($category);
                        $post_count = $category->count;
                        ?>
                    <a href="<?php echo esc_url($category_link); ?>"
                        class="h-12 inline-flex mt-3 py-1 px-5 items-center justify-center font-medium border transition duration-200 <?php echo is_tax('product_cat', $category->term_id) ? 'bg-zinc-500 text-white' : 'bg-transparent border-zinc-500 text-zinc-500'; ?> hover:bg-zinc-800 hover:text-white">
                        <?php echo esc_html($category->name); ?> (<?php echo $post_count; ?>)
                    </a>
                    <?php
                    }
                    ?>

                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="product-grid mt-20 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8"
            data-max-pages="<?php echo esc_attr($GLOBALS['wp_query']->max_num_pages); ?>"
            data-category-id="<?php echo is_tax('product_cat') ? get_queried_object_id() : ''; ?>">
            <?php
            if (have_posts()) :
                while (have_posts()) :
                    the_post();
                    global $product;
                    ?>
            <div class="product-item group">
                <a href="<?php the_permalink(); ?>" class="block group">
                    <?php if (has_post_thumbnail()) : ?>
                    <img loading="lazy" class="block w-full group-hover:opacity-80 transition-opacity duration-200 mb-6 object-cover <?php echo match($GLOBALS['wp_query']->current_post % 5) {
                                        0 => 'h-64',
                                        1 => 'h-72',
                                        2 => 'h-80', 
                                        3 => 'h-88',
                                        4 => 'h-96'
                                    }; ?>" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>"
                        alt="<?php the_title(); ?>">
                    <?php else: ?>
                    <img loading="lazy" class="block w-full mb-6 object-cover h-64"
                        src="<?php echo get_template_directory_uri(); ?>/dist/images/placeholder.jpg"
                        alt="<?php the_title(); ?>">
                    <?php endif; ?>
                    <div>
                        <h4 class="text-xl font-medium group-hover:text-teal-600 transition duration-200 mb-3">
                            <?php the_title(); ?>
                        </h4>
                        <p class="text-gray-700 mb-4 text-sm">
                            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                        </p>
                        <div class="text-md font-bold text-teal-900">
                            <?php echo $product->get_price_html(); ?>
                        </div>
                    </div>
                </a>
            </div>
            <?php
                endwhile;
            endif;
            ?>
        </div>
        <!-- Pagination Controls -->
        <div class="pagination-container flex justify-center items-center mt-12 space-x-2">
            <?php
            echo paginate_links(array(
                'prev_text' => '<button class="h-12 inline-flex mt-3 py-1 px-5 items-center justify-center font-medium border transition duration-200 bg-transparent border-zinc-500 text-zinc-500 hover:bg-zinc-800 hover:text-white">Poprzednia</button>',
                'next_text' => '<button class="h-12 inline-flex mt-3 py-1 px-5 items-center justify-center font-medium border transition duration-200 bg-transparent border-zinc-500 text-zinc-500 hover:bg-zinc-800 hover:text-white">Następna</button>',
                'before_page_number' => '<button class="pagination-number h-12 inline-flex mt-3 py-1 px-5 items-center justify-center font-medium border transition duration-200 ' . (is_page() ? 'bg-zinc-500 text-white' : 'bg-transparent border-zinc-500 text-zinc-500') . ' hover:bg-zinc-800 hover:text-white">',
                'after_page_number' => '</button>'
            ));
            ?>
        </div>

        <!-- Infinite Scroll Loader -->
        <div class="infinite-scroll-loader hidden">
            <div class="loader-spinner"></div>
            <p class="loader-text">Ładowanie produktów...</p>
        </div>
    </div>
</section>

<?php get_footer(); ?>