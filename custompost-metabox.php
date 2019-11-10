<?php

    function create_post_your_post() {
    	register_post_type( 'your_post',
    		array(
    			'labels'       => array(
    'name'       => __( 'Your Post' ),
    			),
    			'public'       => true,
    			'hierarchical' => true,
    			'has_archive'  => true,
    			'supports'     => array(
    'title',
    'editor',
    'excerpt',
    'thumbnail',
    			),
    			'taxonomies'   => array(
    'post_tag',
    'category',
    			)
    		)
    	);
    	register_taxonomy_for_object_type( 'category', 'your_post' );
    	register_taxonomy_for_object_type( 'post_tag', 'your_post' );
    }
    add_action( 'init', 'create_post_your_post' );






    <?php
//Display custom post page.php
    $args = array(
    	'post_type' => 'your_post',
    );
    $your_loop = new WP_Query( $args );

    if ( $your_loop->have_posts() ) : while ( $your_loop->have_posts() ) : $your_loop->the_post();
    $meta = get_post_meta( $post->ID, 'your_fields', true ); ?>

    <!-- contents of Your Post -->

    <?php endwhile; endif; wp_reset_postdata(); ?>


<?php
//Create Meta box
    function add_your_fields_meta_box() {
    	add_meta_box(
    		'your_fields_meta_box', // $id
    		'Your Fields', // $title
    		'show_your_fields_meta_box', // $callback
    		'your_post', // $screen
    		'normal', // $context
    		'high' // $priority
    	);
    }
    add_action( 'add_meta_boxes', 'add_your_fields_meta_box' );
    ?>

//Echo meta field
<p>
    	<label for="your_fields[text]">Input Text</label>
    	<br>
    	<input type="text" name="your_fields[text]" id="your_fields[text]" class="regular-text" value="<?php echo $meta['text']; ?>">
    </p>

    <?php echo $meta['textarea']; ?>
To this:

<?php  if (is_array($meta) && isset($meta['textarea'])){ echo $meta['textarea']; } ?>



<?php 
//Create template page
/* Template Name: CustomPageT1 */ ?>
 
<?php get_header(); ?>
 
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php
        // Start the loop.
        while ( have_posts() ) : the_post();
 
            // Include the page content template.
            get_template_part( 'template-parts/content', 'page' );
 
            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }
 
            // End of the loop.
        endwhile;
        ?>
 
    </main><!-- .site-main -->
 
    <?php get_sidebar( 'content-bottom' ); ?>
 
</div><!-- .content-area -->
 
<?php get_sidebar(); ?>
<?php get_footer(); ?>