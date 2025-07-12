<?php get_header(); ?>


<section class="py-12 lg:py-24 overflow-hidden bg-stone-200">
    <div class="container mx-auto px-4">
        <div class="flex mb-4 items-center">
            <svg id="svg_2fcf097058cb7e4ce3e79e8bfd5757d4" width="8" height="8" viewbox="0 0 9 9" fill="none"
                xmlns="http://www.w3.org/2000/svg"></svg>
            <span class="inline-block ml-2 text-sm font-medium text-teal-900">Produkty</span>
        </div>
        <div class="border-t pt-16">
            <div class="flex flex-wrap items-center justify-between mb-20 -mx-4">
                <div class="w-full sm:w-2/3 px-4 mb-10 sm:mb-0">
                    <div class="sm:max-w-lg xl:max-w-none">
                        <h1 class="font-heading text-4xl xs:text-6xl">Sklep</h1>
                    </div>
                </div>
            </div>
            <!-- Filter Tags Section -->
            <div class="mb-12">
                <h3 class="text-lg font-medium text-teal-900 mb-4">Filtruj wg. kategorii</h3>
                <div class="flex flex-wrap gap-3">
                   

                    <?php
                    $categories = get_terms([
                        'taxonomy' => 'product_cat',
                        'hide_empty' => true
                    ]);

                    if (!empty($categories) && !is_wp_error($categories)) {
                        foreach ($categories as $category) {
                          
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
                    }
                    ?>

                  
                </div>
            </div>
        </div>
        <div class="product-grid mt-20 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            if (have_posts()) :
                while (have_posts()) :
                    the_post();
                    global $product;
                    ?>
                    <div class="product-item group">
                        <a href="<?php the_permalink(); ?>" class="block">
                            <?php if (has_post_thumbnail()) : ?>
                                <img class="block w-full h-64 mb-6 object-cover" 
                                     src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" 
                                     alt="<?php the_title(); ?>">
                            <?php endif; ?>
                            <div>
                                <h4 class="text-xl font-medium group-hover:text-teal-600 transition duration-200 mb-3">
                                    <?php the_title(); ?>
                                </h4>
                                <p class="text-gray-700 mb-4 text-sm">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                </p>
                                <div class="text-2xl font-bold text-teal-900">
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
    </div>
</section>

<?php get_footer(); ?>