<?php
    $phone = get_field('phone', 'option')
?>


<div id="mobile-nav" class="fixed top-0 left-0 bottom-0 w-[0vw] z-50 overflow-hidden transition-all duration-300 ">
    <!-- overlay -->
    <div class="fixed right-0 top-0 inset-0 bg-zinc-500 bg-opacity-50 mobile-nav-overlay w-[0vw] overflow-hidden">
    </div>

    <div class="relative flex flex-col justify-between py-12 px-10 w-full h-full bg-white ">

        <!-- menu -->
        <nav class="pt-20 pb-12 w-full h-full flex items-center justify-center">


            <ul class="flex flex-col items-center justify-center  animation-fade-in text-xl gap-6">
                <li><a class="hvr__item-dark inline-block text-teal-900 hover:text-teal-700 font-medium text-center "
                        href="<?php echo home_url('/o-nas'); ?>">O nas</a></li>
                <li><a class=" hvr__item-dark inline-block text-teal-900 hover:text-teal-700 font-medium text-center"
                        href="<?php echo wc_get_page_permalink('shop'); ?>">Produkty</a></li>
                <?php if(function_exists('pll_e')): ?>
                <li><a class=" hvr__item-dark inline-block text-teal-900 hover:text-teal-700 font-medium text-center"
                        href="<?php echo home_url('/kontakt'); ?>"><?php pll_e('Kontakt') ?></a></li>
                <?php endif; ?>
                <li><a class=" hvr__item-dark inline-block text-teal-900 hover:text-teal-700 font-medium text-center"
                        href="<?php echo home_url('/blog'); ?>">Blog</a></li>
            </ul>

        </nav>

        <!-- phone -->
        <div class="flex items-center justify-between">

            <div class="flex flex-col items-center justify-center mx-auto gap-4">
                <?php if(function_exists('pll_e')): ?>
                <p><?php pll_e('Zadzwoń do Nas') ?></p>
                <?php endif; ?>
                <div class="flex items-center gap-2">
                    <a href="tel:<?php echo $phone ?>"
                        class="flex py-2 px-4 items-center justify-center text-md font-medium text-white border transition duration-200 bg-zinc-500 hover:bg-zinc-800">

                        <svg fill="#fff" class="mr-4" height="32px" width="32px" version="1.1" id="Layer_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 511.996 511.996" xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M508.245,246.953L363.435,102.133c-5.001-5.001-13.099-5.001-18.099,0c-5.001,5-5.001,13.099,0,18.099l122.965,122.965
			H12.8c-7.074,0-12.8,5.726-12.8,12.8c0,7.074,5.726,12.8,12.8,12.8h455.492L345.327,391.763c-5.001,5-5.001,13.099,0,18.099
			c5.009,5.001,13.099,5.001,18.108,0l144.811-144.811C513.246,260.051,513.246,251.953,508.245,246.953z" />
                                </g>
                            </g>
                        </svg>

                        <div class="inline-flex whitespace-nowrap min-w-[90px]"><?php echo $phone ?></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>