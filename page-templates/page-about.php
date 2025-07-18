<?php

/*
Template Name: About
*/

?>

<?php get_header(); ?>

<section class="relative py-12 lg:pt-20 lg:py-32 overflow-hidden bg-stone-200">
    <div class="container mx-auto px-4 relative">
        <div class="max-w-6xl mx-auto text-center" >

        
             <h1 class="font-heading text-5xl sm:text-6xl mb-8 lg:mb-12">Od lat przemierzamy europejskie targi, aukcje i prywatne
             kolekcje w poszukiwaniu wyjątkowych przedmiotów z duszą.</h1>

             <img loading="lazy" class="hidden lg:block" src="<?php echo wp_upload_dir()['baseurl']; ?>/2025/07/logo-draw.avif" alt="Logo">
            
            <h2 class="text-2xl mg:text-4xl text-teal-900 font-medium mb-10"> Każdy antyk i element vintage, który trafia do
                naszej oferty, jest starannie wyselekcjonowany pod kątem jakości, autentyczności i unikalnego
                charakteru. Wierzymy, że prawdziwe piękno tkwi w przedmiotach z historią - tych, które noszą w sobie
                ślady czasu i opowiadają swoje własne historie. </h2>

            <h3 class="text-xl md:text-2xl text-teal-900 font-medium mb-10">
               Nasza pasja do odkrywania zapomnianych skarbów sprawia,
                że każda wizyta w naszym sklepie to podróż przez różne epoki i style. Pomagamy tworzyć wnętrza pełne
                charakteru, gdzie każdy detal ma swoje miejsce i znaczenie.
            </h3>

           
            <a href="mailto:info@fajnestarocie.pl"
                class="inline-flex py-4 px-6 items-center justify-center text-lg font-medium text-white border transition duration-200 bg-zinc-500 hover:bg-zinc-800">info@fajnestarocie.pl</a>
        </div>
    </div>
</section>

<?php get_footer(); ?>