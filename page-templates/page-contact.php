<?php

/*
Template Name: Contact
*/

?>

<?php get_header(); ?>

<section class="py-12 bg-stone-200 ">
    <div class="container mx-auto px-4">
        <div class="flex mb-4 items-center">
            <svg id="svg_85912698b993b93c6b63ac76dd597b00" width="8" height="8" viewbox="0 0 9 9" fill="none"
                xmlns="http://www.w3.org/2000/svg"></svg>
            <span class="inline-block ml-2 text-sm font-medium text-teal-900"><?php the_title(); ?></span>
        </div>
        <div class="border-t pt-16">
            <div class="max-w-lg mx-auto lg:max-w-none">
                <div class="flex flex-wrap -mx-4">
                    <!-- form -->
                    <div class="w-full lg:w-1/2 px-4 mb-12 lg:mb-0 ">
                        <div class="py-7">
                            <h1 class="font-heading text-4xl sm:text-6xl tracking-sm mb-6">
                                <?php the_field( 'title' ); ?></h1>
                            <p class="text-lg text-gray-700 mb-10"><?php the_field( 'subtitle' ); ?></p>
                            <?php echo do_shortcode('[contact-form-7 id="b198eb7" title="Kontakt"]'); ?>
                        </div>
                    </div>
                    <?php $contact_img = get_field( 'contact_img' ); ?>
                    <?php if($contact_img): ?>
                    <!-- img -->
                    <div style="background-image: url('<?php echo esc_url( $contact_img['url'] ); ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;"
                        class="w-full lg:w-1/2 px-4 bg-stone-300 ">
                        <div class="lg:max-w-md lg:ml-auto h-full"></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>


<?php get_footer(); ?>