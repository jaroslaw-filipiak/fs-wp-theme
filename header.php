<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package fajnestarocie
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Cormorant+Garamond:400|Roboto+Mono:400&amp;subset=latin">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div id="page" class="site">

        <section x-data="{ mobileNavOpen: false }" class="overflow-hidden bg-stone-200 pb-24">
            <nav class="mx-4 py-6 border-b">
                <div class="container mx-auto px-4">
                    <div class="relative flex items-center justify-between">
                        <div class="flex items-center">
                            <a href="<?php echo home_url('/'); ?>" class="inline-block">{{ logotyp }}</a>
                            <ul class="hidden md:flex ml-10">
                                <li class="mr-8"><a class="inline-block text-teal-900 hover:text-teal-700 font-medium"
                                        href="<?php echo home_url('/o-nas'); ?>">O nas</a></li>
                                <li class="mr-8"><a class="inline-block text-teal-900 hover:text-teal-700 font-medium"
                                        href="<?php echo home_url('/kolekcje'); ?>">Kolekcje</a></li>
                                <li class="mr-8"><a class="inline-block text-teal-900 hover:text-teal-700 font-medium"
                                        href="<?php echo home_url('/kontakt'); ?>">Kontakt</a></li>
                                <li><a class="inline-block text-teal-900 hover:text-teal-700 font-medium"
                                        href="<?php echo home_url('/nowosci'); ?>">Nowości</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <div :class="{'block': mobileNavOpen, 'hidden': !mobileNavOpen}"
                class="hidden fixed top-0 left-0 bottom-0 w-full xs:w-5/6 xs:max-w-md z-50">
                <div x-on:click="mobileNavOpen = !mobileNavOpen" class="fixed inset-0 bg-violet-900 opacity-20"></div>
                <nav class="relative flex flex-col py-7 px-10 w-full h-full bg-white overflow-y-auto">
                    <div class="flex items-center justify-between">
                        <a href="#" class="inline-block">
                            <img class="h-8" src="flow-assets/logos/sign-logo-flow.svg" alt="">
                        </a>
                        <div class="flex items-center">
                            <a href="#"
                                class="inline-flex py-2.5 px-4 mr-6 items-center justify-center text-sm font-medium text-teal-900 hover:text-white border border-teal-900 hover:bg-teal-900 rounded-full transition duration-200">Login</a>
                            <button x-on:click="mobileNavOpen = !mobileNavOpen">
                                <svg id="svg_0405deacfacc41ac889c005658d941c5" width="32" height="32"
                                    viewbox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"></svg>
                            </button>
                        </div>
                    </div>
                    <div class="pt-20 pb-12 mb-auto">
                        <ul class="flex-col">
                            <li class="mb-6"><a class="inline-block text-teal-900 hover:text-teal-700 font-medium"
                                    href="#">About us</a></li>
                            <li class="mb-6"><a class="inline-block text-teal-900 hover:text-teal-700 font-medium"
                                    href="#">Team</a></li>
                            <li class="mb-6"><a class="inline-block text-teal-900 hover:text-teal-700 font-medium"
                                    href="#">Solutions</a></li>
                            <li><a class="inline-block text-teal-900 hover:text-teal-700 font-medium" href="#">Blog</a>
                            </li>
                        </ul>
                    </div>
                    <div class="flex items-center justify-between">
                        <a href="#" class="inline-flex items-center text-lg font-medium text-teal-900">
                            <span>
                                <svg id="svg_a27143035501ed4d80bfe366fc444167" width="32" height="32"
                                    viewbox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"></svg>
                            </span>
                            <span class="ml-2">Newsletter</span>
                        </a>
                        <div class="flex items-center">
                            <a href="#" class="inline-block mr-4">
                                <svg id="svg_5243e70380a8a394f557ed11e558755d" width="20" height="20"
                                    viewbox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"></svg>
                            </a>
                            <a href="#" class="inline-block mr-4">
                                <svg id="svg_84bb186c87a895aff74a72f5d0c3acc7" width="24" height="24"
                                    viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"></svg>
                            </a>
                            <a href="#" class="inline-block">
                                <svg id="svg_d0dd1fd35206702d293dee2b1852a1a7" width="24" height="24"
                                    viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"></svg>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </section>