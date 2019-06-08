<?php
/**
 * The template for displaying all single real estate agency.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Flash Immo
 */
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
        while ( have_posts() ) : the_post();
        $managerID = get_field('manager_dagence', (int)get_the_ID())['ID'];
        var_dump($managerID,$user_ID);
        if (is_user_logged_in() && $managerID === $user_ID) {
            echo 'you can edit';
            ?>
            <a href="/edit-agence?id=<?php echo get_the_ID(); ?>" class="btn">Modifier infos</a>
            <?php
        }
        ?>

        <div class="immosingle">
            <h1><?php the_title(); ?></h1>
            <h5>logo</h5>
            <img src="<?php echo get_field('logo')['url']; ?>">
            <h5>vitrine</h5>
            <img src="<?php echo get_field('vitrine')['url']; ?>">
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
                    <li class="collection-item" id="item_<?php echo $offre->ID; ?>">
                        <a href="<?php echo get_the_permalink( $offre->ID); ?>"><?php echo $offre->post_title; ?></a>
                        <div class="secondary-content">
                            <a href="<?php echo $offre->guid; ?>" class="btn-floating btn-small"><i class="material-icons right">remove_red_eye</i></a>
                            <a href="/edit-annonce?id=<?php echo $offre->ID; ?>" class="btn-floating btn-small"><i class="material-icons right">edit</i></a>
                            <a href="#" data="<?php echo $offre->ID; ?>" class="btn-floating btn-small red delete_offre_btn"><i class="material-icons right">delete</i></a>
                            <a href="#" data="<?php echo $offre->ID; ?>" class="btn-floating btn-small red archive_offre_btn"><i class="material-icons right">archive</i></a>
                        </div>
                    </li>
                    <?php
                }
                ?>
                </ul>
                <div class="right">
                Ajouter une offre <a href="/ajouter-annonce" class="btn-floating right" id="" ><i class="material-icons right">add</i></a>
                </div>
                <div style="clear: both;"></div>

        </div>
        <?php
		endwhile; // End of the loop.
		?>
        <!-- modal confirmation -->
        <div id="delete_confirm_modal" class="modal">
            <div class="modal-content">
                <h4>Confirmer la suppression</h4>
                <p>Voulez vous supprimer cette offre ?</p>
                <input type="hidden" id="offre_id_to_delete" value="0">
                <div class="preloader-wrapper active" style="display:none">
                    <div class="spinner-layer spinner-red-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                    </div>
                </div>
                <div style="display:none;" class="error_container"><p>une erreur s'est produite, impossible de supprimer l'offre, veuillez ressayer plus tard!</p><a href="#!" class="modal-close waves-effect waves-green btn">Fermer</a></div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn">Non</a>
                <a href="#!" id="delete_offre_confirm" class="waves-effect waves-green btn red">Oui</a>
            </div>
        </div>
        <!-- end modal -->

        <!-- modal confirmation archive-->
        <div id="archive_confirm_modal" class="modal">
            <div class="modal-content">
                <h4>Confirmer l'archivage'</h4>
                <p>Voulez vous archiver cette offre ?</p>
                <input type="hidden" id="offre_id_to_archive" value="0">
                <div class="preloader-wrapper active" style="display:none">
                    <div class="spinner-layer spinner-red-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                    </div>
                </div>
                <div style="display:none;" class="error_container"><p>une erreur s'est produite, impossible d'archiver' l'offre. Veuillez ressayer plus tard!</p><a href="#!" class="modal-close waves-effect waves-green btn">Fermer</a></div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn">Non</a>
                <a href="#!" id="archive_offre_immo_confirm" class="waves-effect waves-green btn red">Oui</a>
            </div>
        </div>
        <!-- end modal -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();