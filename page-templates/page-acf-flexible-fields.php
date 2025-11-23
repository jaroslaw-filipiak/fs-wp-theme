<?php
/**
 * Template Name: Pola elastyczne
 *
 * @package Fajnestarocie
 */

get_header(); ?>

<main id="primary" class="site-main">
<?php

// default content
while ( have_posts() ) :
    the_post();

    get_template_part( 'template-parts/content', 'page' );

    // If comments are open or we have at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) :
        comments_template();
    endif;

endwhile; // End of the loop.
?>
</main>

<?php
// Collect used layouts for asset enqueueing
$used_layouts = array();

// First pass: collect all layouts used on this page
if( have_rows('content') ):
while ( have_rows('content') ) : the_row();
$used_layouts[] = get_row_layout();
endwhile;
endif;

// Enqueue ACF component assets based on used layouts
if( !empty($used_layouts) ) {
fajnestarocie_enqueue_acf_assets( array_unique($used_layouts) );
}

// Second pass: render components
// Check value exists.
if( have_rows('content') ): ?>

<div id="acf-flexible-content">
<?php
// Loop through rows.
while ( have_rows('content') ) : the_row();

// Get current layout name
$layout = get_row_layout();

// Construct component path
$component_path = get_template_directory() . '/components/acf/' . $layout . '.php';

// Check if component file exists and include it
if( file_exists($component_path) ) {
include $component_path;
} else {
// Fallback: display error in development or default content
if( defined('WP_DEBUG') && WP_DEBUG ) {
echo '<div style="padding: 20px; background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; margin: 10px 0;">';
    echo '<strong>Missing ACF Component:</strong> ' . esc_html($layout) . '.php<br>';
    echo '<strong>Expected path:</strong> ' . esc_html($component_path);
    echo '</div>';
}
}

// End loop.
endwhile;
?>
</div>

<?php
// No value.
else :
// Display message when no flexible content exists
echo '<div class="no-flexible-content">';
    echo '<p>No content blocks have been added yet.</p>';
    echo '</div>';
endif; ?>

<?php get_footer(); ?>