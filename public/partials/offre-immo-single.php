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
        $agence = get_field('agence');
        $managerID = get_field('manager_dagence', $agence->ID)['ID'];

        ?>
        <div>
        <?php
        var_dump($user_ID,$managerID);
        
        if(is_user_logged_in() && $user_ID == $managerID){
            echo 'you can edit';
            ?>
            <a class="btn" href="/edit-annonce?id=<?php echo (int)get_the_ID(); ?>" id="fla_edit_annonce_immo_btn" >Modifier l'offre</a>
            <?php 
        }else {
            echo 'you can not edit';
        } ?>
        </div>
        <div class="immosingle">
            <div class="immo_featured_img" style="background-image:url(<?php echo get_field('gallerie')['url']; ?>);"></div>
            <?php 
            $gallerie_photos = get_post_meta(get_the_ID(), 'fla_immo_offer_gallery', true);
            $photos_arr      = explode(',',$gallerie_photos);
            var_dump($photos_arr);
            ?>
            <ul class="gallery_list">
            <?php
            foreach ($photos_arr as $photoid) {
                 
                ?>
                
                <li><a href="<?php echo wp_get_attachment_url($photoid);  ?>"><img src="<?php echo wp_get_attachment_thumb_url($photoid); ?>"></a></li>
                <?php
                
            }
            ?>
            </ul>
            <h1><?php the_title(); ?></h1>
            <p><?php the_field('description'); ?></p>
            <h2>Type de transaction : <span><?php echo get_field('type_de_transaction')['label']; ?></span></h2>
            <h2>Type d'offre : <span><?php echo get_field('type_doffre')['label']; ?></span></h2>
            <h2>Surface : <span><?php echo get_field('surface'); ?>m²</span></h2>
            <h2>Surface 2: <span><?php echo get_field('surface_2'); ?>m²</span></h2>
            <h2>Secteur : <span><?php echo get_field('secteur')['label']; ?></span></h2>
            <h2>Prix : <span><?php echo get_field('prix').' '; echo (get_field('unite'))?get_field('unite'):'€'; ?> </span><em>commision <?php echo (get_field('commission_incluse'))?'incluse':'non incluse'; ?></em></h2>
            <h2>Numéro de mandat : <span><?php echo get_field('numero_de_mandat'); ?></span></h2>
            <h2>Réference Interne : <span><?php echo get_field('reference_interne'); ?></span></h2>
            <?php $agence = get_field('agence'); ?>
            <h2>Agence : <span><a href="<?php echo get_permalink($agence->ID); ?>"><?php echo $agence->post_title; ?></a></span></h2>
            <hr>
            <h3>Demande d'information</h3>
            <?php
                echo do_shortcode( '[contact-form-7 id="1376" title="demande d\'information - offre immo"]');
            ?>

        </div>
        <?php
		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();