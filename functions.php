<?php
/**
 * fajnestarocie functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package fajnestarocie
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function fajnestarocie_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on fajnestarocie, use a find and replace
		* to change 'fajnestarocie' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'fajnestarocie', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// add_theme_support( 'post-thumbnails' );


	//template parts support
	// add_theme_support( 'wp-block-template-parts' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'fajnestarocie' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'fajnestarocie_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'fajnestarocie_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function fajnestarocie_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'fajnestarocie_content_width', 640 );
}
add_action( 'after_setup_theme', 'fajnestarocie_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function fajnestarocie_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'fajnestarocie' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'fajnestarocie' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'fajnestarocie_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function fajnestarocie_scripts() {
	//main global styles / scripts
	wp_enqueue_style( 'fajnestarocie-main-styles', get_template_directory_uri() . '/dist/assets/main.css', array(), _S_VERSION );
	wp_enqueue_style( 'fajnestarocie-style', get_stylesheet_uri(), array(), _S_VERSION );

	wp_enqueue_script( 'fajnestarocie-main-scripts', get_template_directory_uri() . '/dist/assets/main.js', array(), _S_VERSION, true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// single product styles / scripts
	if ( is_singular( 'product' ) ) {
		wp_enqueue_style( 'fajnestarocie-single-product-styles', get_template_directory_uri() . '/dist/assets/single-product.css', array(), _S_VERSION, false );
		wp_enqueue_script( 'fajnestarocie-single-product-scripts', get_template_directory_uri() . '/dist/assets/single-product.js', array(), _S_VERSION, false );
		wp_enqueue_script( 'fajnestarocie-lightbox-scripts', get_template_directory_uri() . '/public/libs/lightbox/js/lightbox.min.js', array('jquery'), _S_VERSION, false );
		wp_enqueue_style( 'fajnestarocie-lightbox-styles', get_template_directory_uri() . '/public/libs/lightbox/css/lightbox.min.css', array(), _S_VERSION, false );
	}

	// front page styles / scripts
	if ( is_front_page() ) {
		wp_enqueue_style( 'fajnestarocie-front-page-styles', get_template_directory_uri() . '/dist/assets/front-page.css', array(), _S_VERSION, false );
		wp_enqueue_script( 'fajnestarocie-front-page-scripts', get_template_directory_uri() . '/dist/assets/front-page.js', array('jquery'), _S_VERSION, false );
	}
}
add_action( 'wp_enqueue_scripts', 'fajnestarocie_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Handle subscription form
 */
require get_template_directory() . '/inc/subscription-form.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Register custom post type for client reviews
 */
add_action('init', function() {
    register_post_type('olx_review', array(
        'labels' => array(
            'name' => 'Opinie klientów',
            'singular_name' => 'Opinia klienta',
        ),
        'public' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-testimonial',
        'supports' => array('title', 'custom-fields'),
    ));
});