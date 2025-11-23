<?php
/**
 * Template Name: Pola elastyczne
 *
 * @package Fajnestarocie
 */

get_header(); ?>

<?php

// Check value exists.
if( have_rows('content') ):

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

// No value.
else :
    // Display message when no flexible content exists
    echo '<div class="no-flexible-content">';
    echo '<p>No content blocks have been added yet.</p>';
    echo '</div>';
endif; ?>

<?php get_footer(); ?>