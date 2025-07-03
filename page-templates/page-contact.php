<?php

/*
Template Name: Contact
*/

?>

<?php get_header(); ?>

<section class="py-12 lg:py-24 bg-stone-200 ">
    <div class="container mx-auto px-4">
        <div class="flex mb-4 items-center">
            <svg id="svg_85912698b993b93c6b63ac76dd597b00" width="8" height="8" viewbox="0 0 9 9" fill="none"
                xmlns="http://www.w3.org/2000/svg"></svg>
            <span class="inline-block ml-2 text-sm font-medium text-teal-900">Kontakt</span>
        </div>
        <div class="border-t pt-16">
            <div class="max-w-lg mx-auto lg:max-w-none">
                <div class="flex flex-wrap -mx-4">
                    <div class="w-full lg:w-1/2 px-4 mb-12 lg:mb-0">
                        <div class="max-w-lg py-7">
                            <h1 class="font-heading text-4xl sm:text-6xl tracking-sm mb-6">Skontaktuj się z nami</h1>
                            <p class="text-lg text-gray-700 mb-10">Bardzo chętnie udzielimy więcej informacji o naszych
                                produktach</p>
                            <form action="">
                                <label for="" class="block mb-1 text-md font-medium">Imię</label>
                                <input type="text"
                                    class="w-full px-4 py-3 mb-6 outline-none ring-offset-0 focus:ring-2  shadow">
                                <label for="" class="block mb-1 text-md font-medium">Email</label>
                                <input type="text"
                                    class="w-full px-4 py-3 mb-6 outline-none ring-offset-0 focus:ring-2  shadow">
                                <label for="" class="block mb-1 text-md font-medium">
                                    <span>Wiadomość</span>
                                </label>
                                <textarea
                                    class="w-full px-4 py-3 mb-6 outline-none ring-offset-0 focus:ring-2  shadow resize-vertical min-h-32"
                                    placeholder="Wpisz swoją wiadomość..."></textarea>
                                <button
                                    class="inline-flex py-4 px-6 items-center justify-center text-lg font-medium text-white border transition duration-200 bg-zinc-500 hover:bg-zinc-800 w-full">
                                    <span class="mr-2">Wyślij</span>
                                    <svg width="21" height="20" viewbox="0 0 21 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.25 10H15.75" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M10.5 4.75L15.75 10L10.5 15.25" stroke="currentColor"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="w-full lg:w-1/2 px-4 bg-stone-300">
                        <div class="lg:max-w-md lg:ml-auto h-full"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php get_footer(); ?>