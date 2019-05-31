<?php
/**
 * The template for displaying all single real estate.
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
            <div class="immo_featured_img" style="background-image:url(<?php echo get_field('gallerie')['url']; ?>);"></div>
            <h1><?php the_title(); ?></h1>
            <p><?php the_field('description'); ?></p>
            <h2>Type de transaction : <span><?php echo get_field('type_de_transaction')['label']; ?></span></h2>
            <h2>Type d'offre : <span><?php echo get_field('type_doffre')['label']; ?></span></h2>
            <h2>Surface : <span><?php echo get_field('surface'); ?>m²</span></h2>
            <h2>Secteur : <span><?php echo get_field('secteur')['label']; ?></span></h2>
            <h2>Prix : <span><?php echo get_field('prix'); ?> €</span><em>commision <?php echo (get_field('commission_incluse'))?'incluse':'non incluse'; ?></em></h2>
            <h2>Numéro de mandat : <span><?php echo get_field('numero_de_mandat'); ?></span></h2>
            <?php $agence = get_field('agence'); ?>
            <h2>Agence : <span><a href="<?php echo get_permalink($agence->ID); ?>"><?php echo $agence->post_title; ?></a></span></h2>

        </div>
        <?php
		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();