<?php
/**
 * The template for displaying all single real estate agency.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Flash emploi
 */
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
        while ( have_posts() ) : the_post();
        ?>
        <div class="immosingle">
            <h1><?php the_title(); ?></h1>
            <img src="<?php echo get_field('logo')['url']; ?>">
            <p><?php the_field('presentation'); ?></p>
            <h2>Responsable : <span><?php echo get_field('responsable'); ?></span></h2>
            <h2>Email : <span><?php echo get_field('email'); ?></span></h2>
            <h2>Téléphone : <span><?php echo get_field('tel'); ?></span></h2>
            <h2>Site : <span><?php echo get_field('site'); ?></span></h2>
            <h2>Adresse : <span><?php echo get_field('adresse') . ", " . get_field('ville') . " " . get_field('code_postal'); ?></span></h2>
            
            <h3>Les offres de cette agence : </h3>
            <?php 
                $aid = (int)get_the_ID();
                $offres_immo = get_posts(array(
                    'numberposts'	=> -1,
                    'post_type'		=> 'fla_immo_offers',
                    'meta_query' => array(
                        array(
                            'key' => 'agence', // name of custom field
                            'value' => $aid,
                            'compare' => '='
                        )
                    )
                ));
                ?>
                <ul class="collection">
                <?php
                foreach ($offres_immo as $offre) {
                    ?>
                    <li class="collection-item"><a href="<?php echo get_the_permalink( $offre->ID); ?>"><?php echo $offre->post_title; ?></a></li>
                    <?php
                }
            ?>
            </ul>

        </div>
        <?php
		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();