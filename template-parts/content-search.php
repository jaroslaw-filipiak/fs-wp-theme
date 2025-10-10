<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package fajnestarocie
 */

?>

<article class="search-result-item" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="search-result-item__photo">
        <?php fajnestarocie_post_thumbnail(); ?>
    </div>

    <div class="search-result-item__content">
        <div class="search-result-item__title">
            <?php the_title( sprintf( '<h2><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
        </div>

        <div class="search-result-item__excerpt">
            <?php the_excerpt(); ?>
        </div>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->