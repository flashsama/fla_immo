<?php
/**
 * The template for editing agence immo .
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy
 *
 * @package Flash emploi
 */



$agence_ID = isset($_GET['id'])?$_GET['id']:0;

$managerID = get_field('manager_dagence', $agence_ID)['ID'];
if (!is_user_logged_in() || $user_ID != $managerID || $agence_ID == 0) {
    //redirect to manager admin
    wp_redirect( '/manager-admin' );
    exit;
}



        
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
        <h1>Modifier entreprise : <?php echo get_the_title( $agence_ID ); ?></h1>
        <div class="row">
            <form>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="<?php echo get_the_title( $agence_ID ) ?>" id="agence_title" type="text" class="validate">
                        <input type="hidden" value="<?php echo $agence_ID; ?>" id="agence_id">
                        <label for="agence_title">Intitulé</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="<?php the_field('responsable', $agence_ID); ?>" id="agence_responsable" type="text" class="validate">
                        <label for="agence_responsable">Responsable</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="agence_description" type="text" class="materialize-textarea"><?php the_field('presentation', $agence_ID); ?></textarea>
                        <label for="agence_description">Présentation</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="<?php the_field('email', $agence_ID); ?>" id="agence_email" type="text" class="validate">
                        <label for="agence_email">Email</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="<?php the_field('tel', $agence_ID); ?>" id="agence_tel" type="text" class="validate">
                        <label for="agence_tel">Téléphone</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="<?php the_field('site', $agence_ID); ?>" id="agence_site" type="text" class="validate">
                        <label for="agence_site">Site</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="agence_adresse" type="text" class="materialize-textarea"><?php the_field('adresse', $agence_ID); ?></textarea>
                        <label for="agence_adresse">Adresse</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="<?php the_field('ville', $agence_ID); ?>" id="agence_ville" type="text" class="validate">
                        <label for="agence_ville">Ville</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="<?php the_field('code_postal', $agence_ID); ?>" id="agence_cp" type="text" class="validate">
                        <label for="agence_cp">Code postal</label>
                    </div>
                </div>
                

                <div class="row">
                    <div class="input-field col s12">
                            <?php $agence_logo = (object)get_field('logo', $agence_ID); ?>
                        <img id="agence_logo" width="100px" src="<?php echo (isset($agence_logo->url))?$agence_logo->url:''; ?>" />
                        <input type="hidden" id="agence_logo_id" value="<?php echo (isset($agence_logo->ID))?$agence_logo->ID:0; ?>">
                        <a class="btn-floating btn cyan" id="upload_agence_logo_btn"><i class="material-icons">edit</i></a>
                        
                        <label for="agence_logo">Logo</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                            <?php $agence_vitrine = (object)get_field('vitrine', $agence_ID); ?>
                        <img id="agence_vitrine" width="100px" src="<?php echo (isset($agence_vitrine->url))?$agence_vitrine->url:''; ?>" />
                        <input type="hidden" id="agence_vitrine_id" value="<?php echo (isset($agence_vitrine->ID))?$agence_vitrine->ID:0; ?>">
                        <a class="btn-floating btn cyan" id="upload_agence_vitrine_btn"><i class="material-icons">edit</i></a>
                        
                        <label for="agence_vitrine">Vitrine</label>
                    </div>
                </div>

                
                
                <div class="red-text card-panel" id="error_update_agence" style="display:none;">
                    une erreur est survenu lors de l'enregistrement de vos données! veuillez resayer plus tard
                </div>
                <div class="progress" style="display:none;">
                    <div class="indeterminate"></div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <a href="#" id="update_agence_btn" class="btn">Enregistrer</a>
                    </div>
                </div>

            </form>
        </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();