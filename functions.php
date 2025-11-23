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
	define( '_S_VERSION', '2.1.0' );
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
		wp_enqueue_script( 'fajnestarocie-front-page-scripts', get_template_directory_uri() . '/dist/assets/front-page.js', array(), _S_VERSION, false );
	}

    // cart page 
    if ( is_cart() ) {
        wp_enqueue_style( 'fajnestarocie-cart-styles', get_template_directory_uri() . '/dist/assets/cart.css', array(), _S_VERSION, false );
        wp_enqueue_script( 'fajnestarocie-cart-scripts', get_template_directory_uri() . '/dist/assets/cart.js', array(), _S_VERSION, false );
    }

    // search page styles / scripts
    if ( is_search() ) {
        wp_enqueue_style( 'fajnestarocie-search-styles', get_template_directory_uri() . '/dist/assets/search.css', array(), _S_VERSION, false );
    }

    // 404 page styles / scripts
    if ( is_404() ) {
        wp_enqueue_style( 'fajnestarocie-404-styles', get_template_directory_uri() . '/dist/assets/404.css', array(), _S_VERSION, false );
        wp_enqueue_script( 'fajnestarocie-404-scripts', get_template_directory_uri() . '/dist/assets/404.js', array(), _S_VERSION, false );
    }

	// product archive page styles / scripts
	if ( is_post_type_archive( 'product' ) || is_tax( 'product_cat' ) ) {
		wp_enqueue_style( 'fajnestarocie-archive-product-styles', get_template_directory_uri() . '/dist/assets/archive-product.css', array(), _S_VERSION, false );
		wp_enqueue_script( 'fajnestarocie-archive-product-scripts', get_template_directory_uri() . '/dist/assets/archive-product.js', array(), _S_VERSION, false );
	}
	
	// page template contact
	if ( is_page_template( 'page-templates/page-contact.php' ) ) {
		wp_enqueue_style( 'fajnestarocie-contact-styles', get_template_directory_uri() . '/dist/assets/contact.css', array(), _S_VERSION, false );
		wp_enqueue_script( 'fajnestarocie-contact-scripts', get_template_directory_uri() . '/dist/assets/contact.js', array(), _S_VERSION, false );
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
 * Load translations
 */
require get_template_directory() . '/inc/translations.php';


function fajnestarocie_include_products_in_search( $query ) {
    if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
        $query->set( 'post_type', array( 'post', 'page', 'product' ) );
        $query->set( 'post_status', 'publish' );
        
        // Note: Complete override handles the actual search
        // This just sets basic query parameters
    }
}

function fajnestarocie_setup_fulltext_indexes() {
    global $wpdb;
    
    // Check if FULLTEXT index exists
    $index_exists = $wpdb->get_var("
        SELECT COUNT(*) FROM INFORMATION_SCHEMA.STATISTICS 
        WHERE table_schema = '{$wpdb->dbname}' 
        AND table_name = '{$wpdb->posts}' 
        AND index_name = 'fulltext_search_idx'
    ");
    
    // Create FULLTEXT index if it doesn't exist
    if ( ! $index_exists ) {
        $wpdb->query("
            ALTER TABLE {$wpdb->posts} 
            ADD FULLTEXT fulltext_search_idx (post_title, post_content, post_excerpt)
        ");
    }
}


/**
 * Optimized search for posts and WooCommerce products
 * Direct SQL query with FULLTEXT support for maximum performance
 */
function fajnestarocie_optimized_product_search( $posts, $query ) {
    // Only handle main search queries
    if ( ! $query->is_search() || is_admin() || ! $query->is_main_query() ) {
        return $posts;
    }
    
    $search_term = trim( $query->get( 's' ) );
    if ( empty( $search_term ) ) {
        return $posts;
    }
    
    global $wpdb;
    static $cache = array();
    
    // Simple cache for repeated searches
    $cache_key = md5( $search_term );
    if ( isset( $cache[ $cache_key ] ) ) {
        return $cache[ $cache_key ];
    }
    
    $clean_term = $wpdb->esc_like( $search_term );
    
    // Check if FULLTEXT index exists for better performance
    $has_fulltext = $wpdb->get_var("
        SELECT COUNT(*) FROM INFORMATION_SCHEMA.STATISTICS 
        WHERE table_schema = '{$wpdb->dbname}' 
        AND table_name = '{$wpdb->posts}' 
        AND index_name = 'fulltext_search_idx'
    ");
    
    if ( $has_fulltext ) {
        // Use FULLTEXT for better relevance and speed
        $sql = $wpdb->prepare( "
            SELECT p.ID, p.post_title, p.post_content, p.post_excerpt, p.post_date, p.post_type,
                   MATCH(p.post_title, p.post_content, p.post_excerpt) AGAINST(%s IN NATURAL LANGUAGE MODE) as relevance
            FROM {$wpdb->posts} p
            WHERE p.post_type IN ('post', 'page', 'product')
            AND p.post_status = 'publish'
            AND (
                MATCH(p.post_title, p.post_content, p.post_excerpt) AGAINST(%s IN NATURAL LANGUAGE MODE)
                OR p.post_title LIKE %s
                OR EXISTS (
                    SELECT 1 FROM {$wpdb->postmeta} pm 
                    WHERE pm.post_id = p.ID 
                    AND pm.meta_value LIKE %s
                    AND pm.meta_key IN ('_sku', '_product_attributes')
                )
            )
            ORDER BY relevance DESC, p.post_title LIKE %s DESC, p.post_date DESC
            LIMIT 20
        ", $search_term, $search_term, "%{$clean_term}%", "%{$clean_term}%", "%{$clean_term}%" );
    } else {
        // Fallback to LIKE queries
        $sql = $wpdb->prepare( "
            SELECT p.ID, p.post_title, p.post_content, p.post_excerpt, p.post_date, p.post_type
            FROM {$wpdb->posts} p
            WHERE p.post_type IN ('post', 'page', 'product')
            AND p.post_status = 'publish'
            AND (
                p.post_title LIKE %s
                OR p.post_content LIKE %s  
                OR p.post_excerpt LIKE %s
                OR EXISTS (
                    SELECT 1 FROM {$wpdb->postmeta} pm 
                    WHERE pm.post_id = p.ID 
                    AND pm.meta_value LIKE %s
                    AND pm.meta_key IN ('_sku', '_product_attributes')
                )
            )
            ORDER BY p.post_title LIKE %s DESC, p.post_date DESC
            LIMIT 20
        ", "%{$clean_term}%", "%{$clean_term}%", "%{$clean_term}%", "%{$clean_term}%", "%{$clean_term}%" );
    }
    
    $results = $wpdb->get_results( $sql );
    
    if ( $results ) {
        // Convert to WP_Post objects for theme compatibility
        $post_objects = array();
        foreach ( $results as $result ) {
            $post_objects[] = new WP_Post( $result );
        }
        
        $cache[ $cache_key ] = $post_objects;
        return $post_objects;
    }
    
    $cache[ $cache_key ] = array();
    return array();
}

// Hook up the optimized search functions
add_action( 'pre_get_posts', 'fajnestarocie_include_products_in_search' );
add_action( 'init', 'fajnestarocie_setup_fulltext_indexes' );
add_filter( 'the_posts', 'fajnestarocie_optimized_product_search', 10, 2 );

/**
 * Set products per page for shop archive
 */
function fajnestarocie_products_per_page( $query ) {
	if ( ! is_admin() && $query->is_main_query() && ( is_post_type_archive( 'product' ) || is_tax( 'product_cat' ) ) ) {
		$query->set( 'posts_per_page', 40 );
	}
}
add_action( 'pre_get_posts', 'fajnestarocie_products_per_page' );

/**
 * Register REST API endpoint for infinite scroll products
 */
function fajnestarocie_register_products_api() {
	register_rest_route( 'fajnestarocie/v1', '/products', array(
		'methods'  => 'GET',
		'callback' => 'fajnestarocie_get_products_ajax',
		'permission_callback' => '__return_true',
		'args' => array(
			'page' => array(
				'default' => 1,
				'sanitize_callback' => 'absint',
			),
			'category' => array(
				'default' => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
		),
	) );
}
add_action( 'rest_api_init', 'fajnestarocie_register_products_api' );

/**
 * AJAX handler for loading products
 */
function fajnestarocie_get_products_ajax( $request ) {
	$page = $request->get_param( 'page' );
	$category_id = $request->get_param( 'category' );

	// Przygotuj argumenty zapytania
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => 40,
		'paged'          => $page,
		'post_status'    => 'publish',
	);

	// Dodaj filtr kategorii jeśli jest podany
	if ( ! empty( $category_id ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => $category_id,
			),
		);
	}

	$query = new WP_Query( $args );
	$products = array();

	// Tablica z klasami wysokości obrazków (tak jak w archive-product.php)
	$height_classes = array( 'h-64', 'h-72', 'h-80', 'h-88', 'h-96' );
	$index = 0;

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			global $product;

			// Wybierz klasę wysokości obrazka cyklicznie
			$image_class = $height_classes[ $index % 5 ];
			$index++;

			// Pobierz obrazek produktu
			$image_url = has_post_thumbnail()
				? get_the_post_thumbnail_url( get_the_ID(), 'full' )
				: get_template_directory_uri() . '/dist/images/placeholder.jpg';

			$products[] = array(
				'id'        => get_the_ID(),
				'title'     => get_the_title(),
				'excerpt'   => wp_trim_words( get_the_excerpt(), 20 ),
				'permalink' => get_permalink(),
				'image'     => $image_url,
				'imageClass' => $image_class,
				'price'     => $product->get_price_html(),
			);
		}
	}

	wp_reset_postdata();

	return rest_ensure_response( array(
		'products'   => $products,
		'page'       => $page,
		'max_pages'  => $query->max_num_pages,
		'found'      => $query->found_posts,
	) );
}