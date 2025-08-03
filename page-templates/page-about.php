<?php

/*
Template Name: About
*/

?>

<?php get_header();

$email = get_field('email', 'option'); 

?>


<section class="relative py-12 lg:pt-20 lg:py-32 overflow-hidden bg-stone-200">
    <div class="container mx-auto px-4 relative">
        <div class="max-w-6xl mx-auto text-center" >

        
             <h1 class="font-heading text-5xl sm:text-6xl mb-8 lg:mb-12"><?php the_field( 'heading' ); ?></h1>

             <?php $image = get_field( 'image' ); ?>
                <?php if ( $image ) : ?>
                    <img loading="lazy" class="hidden lg:block" src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" />
             <?php endif; ?>


             <?php the_field( 'text' ); ?>

           
            <a href="mailto:<?php echo $email; ?>"
                class="inline-flex py-4 px-6 items-center justify-center text-lg font-medium text-white border transition duration-200 bg-zinc-500 hover:bg-zinc-800"><?php echo $email; ?>
            </a>
            
        </div>
    </div>
</section>

<?php get_footer(); ?>