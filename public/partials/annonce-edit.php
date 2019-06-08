<?php
/**
 * The template for editing annonce immo .
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Flash emploi
 */



$annonce_ID = isset($_GET['id'])?$_GET['id']:0;
$agence = get_field('agence', $annonce_ID);
$managerID = get_field('manager_dagence', $agence->ID)['ID'];
if (!is_user_logged_in() || $user_ID != $managerID || $annonce_ID == 0) {
    //redirect to manager admin
    wp_redirect( '/manager-admin' );
    exit;
}


//var_dump(get_field('fiche_de_poste', $emploi_ID));

$type_de_transaction = get_field('type_de_transaction', $annonce_ID)['value'];
$type_doffre        = get_field('type_doffre', $annonce_ID)['value'];
$secteur    = get_field('secteur', $annonce_ID)['value'];

$field_type_de_transaction = get_field_object('field_5ce4ab102635d');
$type_de_transaction_choices = $field_type_de_transaction['choices'];

$field_type_doffre = get_field_object('field_5ce4ab532635e');
$type_doffre_choices = $field_type_doffre['choices'];

$field_secteur = get_field_object('field_5ce4ac1626361');
$secteur_choices = $field_secteur['choices'];


//die('hard');

        
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
        <h1>Offre ID = <?php echo $annonce_ID; ?></h1>
        <div class="row">
            <form>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="<?php echo get_the_title( $annonce_ID ) ?>" id="annonce_title" type="text" class="validate">
                        <input type="hidden" value="<?php echo $annonce_ID; ?>" id="annonce_id">
                        <label for="annonce_title">Intitulé</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <select id="type_de_transaction" name="type_de_transaction">
                        <?php 
                            foreach ($type_de_transaction_choices as $value => $label) {
                                ?>
                                <option value="<?php echo $value; ?>" <?php if( $type_de_transaction == $value ): ?> selected="selected"<?php endif; ?>><?php echo $label; ?></option>
                                <?php
                            }
                        ?>
                        </select>
                        <label for="type_de_transaction">Type de transaction</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <select id="type_doffre" name="type_doffre">
                        <?php 
                            foreach ($type_doffre_choices as $value => $label) {
                                ?>
                                <option value="<?php echo $value; ?>" <?php if( $type_doffre == $value ): ?> selected="selected"<?php endif; ?>><?php echo $label; ?></option>
                                <?php
                            }
                        ?>
                        </select>
                        <label for="type_doffre">Type d'offre'</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <select id="secteur" name="secteur">
                        <?php 
                            foreach ($secteur_choices as $value => $label) {
                                ?>
                                <option value="<?php echo $value; ?>" <?php if( $secteur == $value ): ?> selected="selected"<?php endif; ?>><?php echo $label; ?></option>
                                <?php
                            }
                        ?>
                        </select>
                        <label for="secteur">Secteur</label>
                    </div>
                </div>
                
                
                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="annonce_description" type="text" class="materialize-textarea"><?php the_field('description', $annonce_ID); ?></textarea>
                        <label for="annonce_description">description</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="<?php the_field('surface', $annonce_ID); ?>" id="annonce_surface" type="text" class="validate">
                        <label for="annonce_surface">Surface Min</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="<?php the_field('surface_2', $annonce_ID); ?>" id="annonce_surface_2" type="text" class="validate">
                        <label for="annonce_surface_2">Surface Max</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="<?php the_field('longitude', $annonce_ID); ?>" id="annonce_longitude" type="text" class="validate">
                        <label for="annonce_longitude">Longitude</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="<?php the_field('latitude', $annonce_ID); ?>" id="annonce_latitude" type="text" class="validate">
                        <label for="annonce_latitude">Latitude</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <input value="<?php the_field('prix', $annonce_ID); ?>" id="annonce_prix" type="text" class="validate">
                        <label for="annonce_prix">Prix</label>
                    </div>
                    <div class="input-field col s6">
                        <input value="<?php the_field('unite', $annonce_ID); ?>" id="annonce_unite" type="text" class="validate">
                        <label for="annonce_unite">Unité</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <h3 class="left">Commission incluse</h3>
                        <div class="switch left" style="clear:both;">
                            <label>
                            Non
                            <input type="checkbox" id="annonce_commission" <?php echo ((int)get_field('commission_incluse', $annonce_ID) == 1)?'checked':''; ?>>
                            <span class="lever"></span>
                            Oui
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="<?php the_field('numero_de_mandat', $annonce_ID); ?>" id="annonce_numero_de_mandat" type="text" class="validate">
                        <label for="annonce_numero_de_mandat">numero de mandat</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="<?php the_field('reference_interne', $annonce_ID); ?>" id="annonce_reference_interne" type="text" class="validate">
                        <label for="annonce_reference_interne">reference interne</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                            <?php $annonce_img = (object)get_field('gallerie', $annonce_ID); ?>
                        <img id="annonce_img" width="100px" src="<?php echo (isset($annonce_img->url))?$annonce_img->url:''; ?>" />
                        <input type="hidden" id="annonce_img_id" value="<?php echo (isset($annonce_img->ID))?$annonce_img->ID:0; ?>">
                        <a class="btn-floating btn cyan" id="upload_annonce_img_btn"><i class="material-icons">edit</i></a>
                        
                        <label for="image">Photos</label>
                    </div>
                </div>

                
                <div class="row">
                    <div class="input-field col s12">
                        <input disabled value="<?php echo get_the_title($agence->ID); ?>" id="annonce_agence" type="text" class="validate">
                        <label for="annonce_agence">Agence</label>
                    </div>
                </div>
                <div class="red-text card-panel" id="error_update_annonce" style="display:none;">
                    une erreur est survenu lors de l'enregistrement de vos données! veuillez resayer plus tard
                </div>
                <div class="progress" style="display:none;">
                    <div class="indeterminate"></div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <a href="#" id="update_annonce_btn" class="btn">Enregistrer</a>
                    </div>
                </div>

            </form>
        </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();