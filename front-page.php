<?php get_header(); ?>

<section class="bg-stone-200 overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="py-12 md:pt-20 md:pb-32">
            <div class="flex flex-wrap -mx-4 xl:items-center">
                <div class="w-full lg:w-1/2 px-4 mb-8 lg:mb-0">
                    <div class="max-w-lg lg:max-w-none mx-auto">
                        <h1 class="font-heading text-5xl xs:text-6xl sm:text-7xl xl:text-8xl tracking-tight">
                            Antyki dla Twojego Domu </h1>
                    </div>
                </div>
                <div class="w-full lg:w-1/2 px-4">
                    <div class="max-w-lg lg:max-w-none mx-auto">
                        <p class="text-lg text-gray-700 mb-10 font-heading">Odkrywamy najpiękniejsze antyki i
                            elementy vintage w całej Europie, aby przynieść do Twojego domu kawałek historii
                            pełen charakteru. Każdy przedmiot to unikalna opowieść - od francuskich secesyjnych
                            lamp po angielskie porcelanowe serwisy, wszystko starannie wyselekcjonowane dla
                            miłośników wyjątkowego stylu.</p>
                        <a href="#categories"
                            class="inline-flex py-4 px-6 items-center justify-center text-lg font-medium text-white border transition duration-200 bg-zinc-500 hover:bg-zinc-800">Przeglądaj
                            spośród <?php echo wp_count_posts('product')->publish; ?> ofert</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex -mx-4 products-slider transform rotate-1 z-20">
        <div class="swiper-wrapper relative top-20 z-20">
                <?php
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 40,
                    'orderby' => 'date',
                    'order' => 'DESC'
                );
                $latest_products = new WP_Query($args);
                
                if($latest_products->have_posts()) :
                    while($latest_products->have_posts()) : $latest_products->the_post();
                        $product = wc_get_product(get_the_ID());
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                ?>
                    <div class="swiper-slide px-2 sm:px-4 group ">
                        <a class="relative" href="<?php the_permalink(); ?>">
                            <img class="block w-full h-full object-cover" src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>">
                            <div class="absolute top-0 left-0 w-full h-full bg-black/50 flex items-end justify-center pb-24 px-12 text-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                <h3 class="text-white text-2xl font-bold"><?php the_title(); ?></h3>
                            </div>
                        </a>
                    </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
        </div>

    
        <div class="fajnestarocie-swiper-button-prev">

            <svg class="fill-white rotate-180" width="44" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                    viewBox="0 0 511.996 511.996" xml:space="preserve">
                <g>
                    <g>
                        <path d="M508.245,246.953L363.435,102.133c-5.001-5.001-13.099-5.001-18.099,0c-5.001,5-5.001,13.099,0,18.099l122.965,122.965
                            H12.8c-7.074,0-12.8,5.726-12.8,12.8c0,7.074,5.726,12.8,12.8,12.8h455.492L345.327,391.763c-5.001,5-5.001,13.099,0,18.099
                            c5.009,5.001,13.099,5.001,18.108,0l144.811-144.811C513.246,260.051,513.246,251.953,508.245,246.953z"/>
                    </g>
                </g>
            </svg>

        </div>

        <div class="fajnestarocie-swiper-button-next">

            <svg class="fill-white" width="44" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                viewBox="0 0 511.996 511.996" xml:space="preserve">
            <g>
                <g>
                    <path d="M508.245,246.953L363.435,102.133c-5.001-5.001-13.099-5.001-18.099,0c-5.001,5-5.001,13.099,0,18.099l122.965,122.965
                        H12.8c-7.074,0-12.8,5.726-12.8,12.8c0,7.074,5.726,12.8,12.8,12.8h455.492L345.327,391.763c-5.001,5-5.001,13.099,0,18.099
                        c5.009,5.001,13.099,5.001,18.108,0l144.811-144.811C513.246,260.051,513.246,251.953,508.245,246.953z"/>
                </g>
            </g>
            </svg>

        </div>

    
    </div>
</section>

<section id="categories" class="py-12 lg:py-24 overflow-hidden bg-stone-200">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto mb-10 text-center">
            <h1 class="font-heading text-4xl md:text-5xl mb-6 mt-12 lg:mt-24 leading-relaxed">Nasze kolekcje stale się odnawiają dzięki
                regularnym podróżom po europejskich targach i aukcjach.</h1>
            <h3 class="font-heading mb-16 leading-relaxed text-lg pb-6">Najnowsza dostawa z czerwca 2025 to prawdziwa
                niespodzianka - od niemieckich lamp naftowych i duńskich barometrów po kryształowe patery i masywne
                świeczniki, które czekają na swoich nowych właścicieli.</h3>

                <h4 class="font-heading  leading-relaxed text-3xl md:text-4xl mt-12 lg:mt-24 max-w-112 mx-auto">Najpopularniejsze kategorie produktów</h4>

        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-center py-12 lg:py-24">
            <?php
            $args = array(
                'taxonomy'     => 'product_cat',
                'orderby'      => 'name',
                'hide_empty'   => true,
                'parent'       => 0,
                'exclude'      => array(get_option('default_product_cat'))  
            );
            $product_categories = get_terms($args);
            
            if (!empty($product_categories)) :
                foreach ($product_categories as $category) :
                    $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                    $image = wp_get_attachment_url($thumbnail_id);
                    if (!$image) {
                        $image = wc_placeholder_img_src();
                    }
                ?>
                <div class="group">
                        <div class="group-hover:bg-zinc-800 py-10 px-12 transition-background-color duration-300">
                            <a href="<?php echo get_term_link($category); ?>">
                                <!-- narazie bez foto -->
                                <img class="block w-72 h-96 object-cover hidden" src="<?php echo $image; ?>" alt="<?php echo $category->name; ?>">
                                <h3 class="text-3xl mt-4 text-center font-medium group-hover:text-white"><?php echo $category->name; ?></h3>
                                <p class="text-center text-gray-600 group-hover:text-white"><?php echo $category->count; ?> produktów</p>
                            </a>
                        </div>
                </div>
            <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>

<section class="p-4 bg-stone-100">
    <div class="py-16 px-4 sm:px-8 rounded-3xl bg-stone-300 relative -top-34">
        <div class="container mx-auto px-4">
            <div class="flex mb-4 items-center">
                <svg width="8" height="8" viewbox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="4" cy="4" r="4" fill="#022C22"></circle>
                </svg>
                <span class="inline-block ml-2 text-sm font-medium text-teal-900">O nas</span>
            </div>
            <div class="border-t pt-16 border-zinc-400">
                <div class="max-w-lg mx-auto lg:max-w-none">
                    <div class="flex flex-wrap -mx-4">
                        <div class="w-full lg:w-2/3 px-4 mb-12 lg:mb-0">
                            <div class="max-w-3xl">
                                <h1 class="font-heading text-5xl sm:text-6xl mb-6 max-w-2xl leading-relaxed">Pasja do autentycznej historii</h1>
                                <p class="text-lg text-gray-700 font-heading"> Jako doświadczeni kolekcjonerzy i
                                    miłośnicy historii, od lat podróżujemy po całej Europie w poszukiwaniu wyjątkowych
                                    antyków i przedmiotów vintage. Nasza misja jest prosta, lecz głęboka: odkrywanie i
                                    ratowanie pięknych obiektów z przeszłości, które zasługują na drugie życie w
                                    nowoczesnych domach. Wierzymy, że każdy antyk niesie ze sobą duszę i opowieść, która
                                    może wzbogacić Twoje wnętrze i stworzyć niepowtarzalny klimat pełen charakteru i
                                    elegancji.</p>
                            </div>
                        </div>
                        <div class="w-full lg:w-1/3 px-4">
                            <div>
                                <div class="mb-16">
                                    <span class="block text-5xl"><?php echo wp_count_posts('product')->publish; ?></span>
                                    <p class="text-gray-700 text-xl mt-3">Unikalne antyki w ofercie</p>
                                </div>
                                <div class="mb-16">
                                    <span class="block text-5xl"><?php echo wp_count_posts('olx_review')->publish; ?></span>
                                    <p class="text-gray-700 text-xl mt-3">Opini na olx</p>
                                </div>
                                <div class="mb-16">
                                    <span class="block text-5xl">20</span>
                                    <p class="text-gray-700 text-xl mt-3">Krajów, z których sprowadzamy towary</p>
                                </div>
                                <div class="mb-16">
                                    <span class="block text-5xl">18 </span>
                                    <p class="text-gray-700 text-xl mt-3">Wieków reprezentowanych w kolekcji</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-12 lg:py-24 overflow-hidden bg-white">
    <div class="container mx-auto px-4">
        <div class="flex mb-4 items-center">
            <svg width="8" height="8" viewbox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="4" cy="4" r="4" fill="#022C22"></circle>
            </svg>
            <span class="inline-block ml-2 text-sm font-medium">Opinie klientów</span>
        </div>
        <div class="border-t border-white border-opacity-25 pt-14">
            <div class="max-w-sm sm:max-w-md md:max-w-none mb-20">
                <h1 class="font-heading text-5xl sm:text-6xl">Co mówią nasi klienci?</h1>
            </div>
            <div class="flex -mx-4 pb-16">
                <div class="reviews-slider swiper">
                    <div class="swiper-wrapper">
                        <?php
                        $args = array(
                            'post_type' => 'olx_review',
                            'posts_per_page' => -1,
                            'meta_query' => array(
                                array(
                                    'key' => 'reviewTags',
                                    'value' => '',
                                    'compare' => '!='
                                )
                            )
                        );
                        $reviews = new WP_Query($args);
                        
                        if($reviews->have_posts()) :
                            while($reviews->have_posts()) : $reviews->the_post();
                        ?>
                        <!-- item -->
                        <div class="swiper-slide flex-shrink-0 w-full sm:w-100 xl:w-1/3 px-4">
                            <div class="flex flex-col h-full p-10 bg-stone-100">
                                <p class="text-2xl font-medium mb-10">"<?php echo get_post_meta(get_the_ID(), 'reviewTags', true); ?>"</p>
                                <div class="mt-auto flex items-center">
                                    <div>
                                        <span class="block text-xl font-medium"><?php echo get_post_meta(get_the_ID(), 'reviewerName', true); ?>, Olx</span>
                                        <span class="block text-lg">Dot. <?php echo get_post_meta(get_the_ID(), 'reviewText', true); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- item -->
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                            ?>
                    </div>
                </div>
            </div>
            <div class="relative h-1 reviews-slider-scrollbar"></div>
        </div>
    </div>
</section>

<?php get_footer(); ?>