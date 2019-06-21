<?php
/**
 * The template for creation new annonce immo .
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Flash emploi
 */



if (!is_user_logged_in() || !current_user_can('immo_manager')) {
    //redirect to manager admin
    wp_redirect( '/manager-admin' );
    exit;
}

$agences = get_posts(array(
	'numberposts'	=> -1,
	'post_type'		=> 'fla_immo_agencies',
	'meta_key'		=> 'manager_dagence',
	'meta_value'	=> $user_ID
));




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
        <h1>Nouvelle offre</h1>
        <div class="row">
            <form>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="" id="annonce_title" type="text" class="validate">
                        <label for="annonce_title">Intitulé</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <select id="type_de_transaction" name="type_de_transaction">
                        <?php 
                            foreach ($type_de_transaction_choices as $value => $label) {
                                ?>
                                <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
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
                                <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
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
                                <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                                <?php
                            }
                        ?>
                        </select>
                        <label for="secteur">Secteur</label>
                    </div>
                </div>
                
                
                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="annonce_description" type="text" class="materialize-textarea"></textarea>
                        <label for="annonce_description">description</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="" id="annonce_surface" type="text" class="validate">
                        <label for="annonce_surface">Surface Min</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="" id="annonce_surface_2" type="text" class="validate">
                        <label for="annonce_surface_2">Surface Max</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="" id="annonce_longitude" type="text" class="validate">
                        <label for="annonce_longitude">Longitude</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="" id="annonce_latitude" type="text" class="validate">
                        <label for="annonce_latitude">Latitude</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <input value="" id="annonce_prix" type="number" class="validate">
                        <label for="annonce_prix">Prix</label>
                    </div>
                    <div class="input-field col s6">
                        <input value="" id="annonce_unite" type="text" class="validate">
                        <label for="annonce_unite">Unité</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <h3 class="left">Commission incluse</h3>
                        <div class="switch left" style="clear:both;">
                            <label>
                            Non
                            <input type="checkbox" id="annonce_commission">
                            <span class="lever"></span>
                            Oui
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="" id="annonce_numero_de_mandat" type="text" class="validate">
                        <label for="annonce_numero_de_mandat">numero de mandat</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="" id="annonce_reference_interne" type="text" class="validate">
                        <label for="annonce_reference_interne">reference interne</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <img id="annonce_img" width="100px" src="" />
                        <input type="hidden" id="annonce_img_id" value="0">
                        <a class="btn-floating btn cyan" id="upload_annonce_img_btn"><i class="material-icons">edit</i></a>
                        
                        <label for="image">Photos</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <img id="annonce_img" width="100px" src="" />
                        <input type="hidden" id="annonce_gallery_ids" value="0">
                        <a class="btn-floating btn cyan" id="upload_annonce_gallery_btn"><i class="material-icons">edit</i></a>
                        <span id="annonce_gallery_src"></span>
                        <label for="image">Galerie</label>
                    </div>
                </div>
                
                <div class="row">
                    <div class="input-field col s12">
                        <div id="annonce_agence_wrapper" class="input-field col s12">
                            <select id="annonce_agence" class="validate">
                                <option value="0">Séléctionner une agence</option>
                                <?php
                                    foreach ($agences as $agence) {
                                        ?>
                                            <option value="<?php echo $agence->ID ?>"><?php echo $agence->post_title ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                            <label for="annonce_agence">Agence</label>
                        </div>
                        
                    </div>
                </div>
                <div class="red-text card-panel" id="error_new_annonce" style="display:none;">
                    une erreur est survenu lors de l'enregistrement de vos données! veuillez resayer plus tard
                </div>
                <div class="progress" style="display:none;">
                    <div class="indeterminate"></div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <a href="#" id="add_new_annonce_btn" class="btn">Enregistrer</a>
                    </div>
                </div>

            </form>
        </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();