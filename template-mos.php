<?php
/**
 * Template name: Main Course Page
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

<div id="primary" class="content-area no-sidebar">
    <main id="main" class="site-main" role="main">
        <?php
        // Start the loop.
        while ( have_posts() ) : the_post();

            // Include the page content template. ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="entry-content">
                    <?php
                    the_content();

                    // WP_Query arguments
                    $args = array (
                        'post_parent'           => $post->ID,
                        'post_type'             => array( 'page' ),
                        'orderby'               => 'menu_order',
                        'order'                 => 'ASC'
                    );

                    // The Query
                    $modules_query = new WP_Query( $args );

                    // The Loop
                    if ( $modules_query->have_posts() ) {
                        echo '<section class="module-container">';
                        while ( $modules_query->have_posts() ) {
                            $modules_query->the_post();

                            echo '<section class="module ' . $post->post_name . '">';
                            echo '<a href="' . get_permalink() . '">';
                            the_post_thumbnail();
                            echo '<h2>';
                            // custom title if available
                            if ( get_post_meta($id, 'landing-page-title', true) ) {
                                echo get_post_meta($id, 'landing-page-title', true);
                            } else {
                                echo get_the_title();
                            }
                            echo '</h2>';
                            echo '</a>';
                            echo '</section>';
                        }
                        echo '</section><!-- .module-container -->';
                    }

                    // Restore original Post Data
                    wp_reset_postdata();
                    ?>
                </div><!-- .entry-content -->

                <?php
                    edit_post_link(
                        sprintf(
                            /* translators: %s: Name of current post */
                            __( 'Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ),
                            the_title( '', '', false )
                        ),
                        '<footer class="entry-footer"><span class="edit-link">',
                        '</span></footer><!-- .entry-footer -->'
                    );
                ?>

            </article><!-- #post-## -->

            <?php
            // End of the loop.
        endwhile;
        ?>

    </main><!-- .site-main -->

    <?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_footer(); ?>
