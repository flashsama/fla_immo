<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://flashsama.me
 * @since      1.0.0
 *
 * @package    Fla_immo
 * @subpackage Fla_immo/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Fla_immo
 * @subpackage Fla_immo/public
 * @author     salaheddine El Ahoubi <flashsama@gmail.com>
 */
class Fla_immo_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Fla_immo_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Fla_immo_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/fla_immo-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {


		/* enqueu media to be used in front end*/
		wp_enqueue_media();
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/fla_immo-public.js', array( 'jquery' ), $this->version, false );
		
		wp_localize_script( $this->plugin_name, 'ajax_front_obj', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		

	}

	public function fla_immo_paginationtemplate($query)
	{
		?>
			<div class="pagination">
				<?php 
					echo paginate_links( array(
						'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
						'total'        => $query->max_num_pages,
						'current'      => max( 1, get_query_var( 'paged' ) ),
						'format'       => '?paged=%#%',
						'show_all'     => false,
						'type'         => 'plain',
						'end_size'     => 2,
						'mid_size'     => 1,
						'prev_next'    => true,
						'prev_text'    => sprintf( '<i></i> %1$s', __( 'Précedent', 'text-domain' ) ),
						'next_text'    => sprintf( '%1$s <i></i>', __( 'Suivant', 'text-domain' ) ),
						'add_args'     => false,
						'add_fragment' => '',
					) );
				?>
			</div>
		<?php
	}

	public function fla_immo_register_shortcodes()
	{
		add_shortcode( 'fl_offres_immo_recherche', array($this,'fla_immo_search_fillter_widget') );
		add_shortcode( 'fl_offres_immo_result', array($this,'fla_immo_search_result_widget') );
	}

	Public function fla_immo_search_fillter_widget()
	{
		$field_type_offre = get_field_object('field_5ce4ab532635e');
		$type_doffre_choices = $field_type_offre['choices'];

		$field_type_transac = get_field_object('field_5ce4ab102635d');
		$type_dtransac_choices = $field_type_transac['choices'];

		$field_secteur = get_field_object('field_5ce4ac1626361');
		$secteur_choices = $field_secteur['choices'];
		//var_dump($type_doffre_choices);
		

		$type_d_offre = isset($_GET['type_d_offre']) ? $_GET['type_d_offre'] : '';
		$transaction = isset($_GET['transaction']) ? $_GET['transaction'] : '';
		$secteur = isset($_GET['secteur']) ? $_GET['secteur'] : '';
		$surface_min = isset($_GET['surface_min']) ? $_GET['surface_min'] : '';
		$surface_max = isset($_GET['surface_max']) ? $_GET['surface_max'] : '';
		$mots_cles = isset($_GET['mots_cles']) ? $_GET['mots_cles'] : '';

		?>
		<form id="fl_immo_search_form">
		<div>
			<label for="type_d_offre">Type d'offre</label>
			<select name="type_d_offre">
				<option value="tous"  <?php if( $type_d_offre == "tous" ): ?> selected="selected"<?php endif; ?>>Tous</option>
				<?php
					foreach ($type_doffre_choices as $value => $label) {
						?>
							<option value="<?php echo $value ?>"  <?php if( $type_d_offre == $value ): ?> selected="selected"<?php endif; ?>><?php echo $label ?></option>
						<?php
					}
				?>
	
			</select>
		</div>
		<div>
			<label for="transaction">Type de transaction</label>
			<select name="transaction">
				<option value="tous"  <?php if( $transaction == "tous" ): ?> selected="selected"<?php endif; ?>>Tous</option>
				<?php
					foreach ($type_dtransac_choices as $value => $label) {
						?>
							<option value="<?php echo $value ?>"  <?php if( $transaction == $value ): ?> selected="selected"<?php endif; ?>><?php echo $label ?></option>
						<?php
					}
				?>
	
			</select>
		</div>
		<div>
			<label for="secteur">Secteur</label>
			<select name="secteur">
				<option value="tous"  <?php if( $secteur == "tous" ): ?> selected="selected"<?php endif; ?>>Tous</option>
				<?php
					foreach ($secteur_choices as $value => $label) {
						?>
							<option value="<?php echo $value ?>"  <?php if( $secteur == $value ): ?> selected="selected"<?php endif; ?>><?php echo $label ?></option>
						<?php
					}
				?>
	
			</select>
		</div>
		<div>
			<label for="surface">Surface</label>
			<input type="text" name="surface_min" id="surface_min" placeholder="min" value="<?php echo $surface_min ?>">
			<input type="text" name="surface_max" id="surface_max" placeholder="max" value="<?php echo $surface_max ?>">
		</div>
		<div>
			<label for="mots_cles">Mots clés</label>
			<input type="text" name="mots_cles" id="mots_cles" placeholder="villa..." value="<?php echo $mots_cles ?>">
		</div>

		<div><button>Rechercher</button></div>
		</form>
		<?php
	}//end function of shortcode

	Public function fla_immo_search_result_widget()
	{
		$type_d_offre = isset($_GET['type_d_offre']) ? $_GET['type_d_offre'] : '';
		$transaction = isset($_GET['transaction']) ? $_GET['transaction'] : '';
		$secteur = isset($_GET['secteur']) ? $_GET['secteur'] : '';
		$surface_min = isset($_GET['surface_min']) ? $_GET['surface_min'] : '';
		$surface_max = isset($_GET['surface_max']) ? $_GET['surface_max'] : '';
		$mots_cles = isset($_GET['mots_cles']) ? $_GET['mots_cles'] : '';
		// WP_Query arguments
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		$args = array (
			'post_type'              => array( 'fla_immo_offers' ),
			'post_status'            => array( 'publish' ),
			'order'                  => 'ASC',
			'orderby'                => 'menu_order',
			'posts_per_page'         => 9,
			'paged'                  => $paged
		);

		$metaquery_arr = array(
			'relation'		=> 'AND'
		);
		if ($type_d_offre != "" && $type_d_offre != "tous") {
			# code...
			$metaquery_arr[] = array(
				'key'		=> 'type_doffre',
				'value'		=> $type_d_offre,
				'compare'	=> '='
			);
		}
		if ($transaction != "" && $transaction != "tous") {
			# code...
			$metaquery_arr[] = array(
				'key'		=> 'type_de_transaction',
				'value'		=> $transaction,
				'compare'	=> '='
			);
		}
		if ($secteur != "" && $secteur != "tous") {
			# code...
			$metaquery_arr[] = array(
				'key'		=> 'secteur',
				'value'		=> $secteur,
				'compare'	=> '='
			);
		}
		if ($surface_min != "" || $surface_max != "") {
			# code...
			$surface_min = ($surface_min != "")?(int)$surface_min:0;
			$surface_max = ($surface_max != "")?(int)$surface_max:999999999;
			$metaquery_arr[] = array(
				'key'		=> 'surface',
				'value'		=> array($surface_min, $surface_max),
				'compare' => 'BETWEEN',
				'type' => 'NUMERIC'
			);
		}
		$args2 = $args;
		$args2['meta_query'] = $metaquery_arr;
		if ($mots_cles != "" ) {
			# code...
			
			$args2['search_title'] = $mots_cles;
			$metaquery_arr[] = array(
				'key'		=> 'description',
				'value'		=> $mots_cles,
				'compare' => 'LIKE',
				'type' => 'TEXT'
			);
		}




		$args['meta_query'] = $metaquery_arr;
		// The Query
		$offres_immo  = new WP_Query( $args );
		$offres_immo2 = new WP_Query( $args2 );
		
		//var_dump($offres_immo,$offres_immo2);

		$idsOfFirstResult = array_map(function($p){
			return $p->ID;
		},$offres_immo->posts);

		foreach ($offres_immo2->posts as $p) {
			if (!in_array($p->ID,$idsOfFirstResult)) {
				array_push($offres_immo->posts,$p);
				$offres_immo->post_count++;
			}
		}

		//var_dump($offres_immo);

		//die('hard');
		// The Loop
		if ( $offres_immo->have_posts() ) {
			//var_dump($emplois);
			echo "<h3>Nombre de resulta : " . ($offres_immo->found_posts) . "</h3>"
			?>
			<div class="result_container">
				<?php
			while ( $offres_immo->have_posts() ) {
				$offres_immo->the_post();
				if (get_post_type() != 'fla_immo_offers') {
					continue;
				}
				?>
					<div class="card">
						<div class="card-image">
							<img src="<?php echo get_field('gallerie')['url']; ?>">
							<a class="btn-floating halfway-fab waves-effect waves-light red" href="<?php the_permalink(); ?>"><i class="material-icons">add</i></a>
						</div>
						<div class="card-content">
							<span class="card-title"><?php the_title(); ?></span>
							<p><?php echo (substr(get_field('description'),0,120).'...');  ?></p>

								<span><?php echo get_field('surface') ?> m²,</span>
								<span style="font-weight:bold;"><?php echo get_field('secteur')['label'] ?></span>
								<span class="new badge red" data-badge-caption="€"><?php echo get_field('prix') ?></span>
							
						</div>
					</div>
				
				<?php
			}
			?> </div> 
			<?php $this->fla_immo_paginationtemplate($offres_immo); ?>
			<?php
		} else {
			// no posts found
			echo '<h2>aucun resultat</h2>';
		}

		// Restore original Post Data
		wp_reset_postdata();
	}//end function of shortcode

	public function fla_immo_single_custom_post_template($single) {

		global $post;

		/* Checks for single template by post type */
		if ( $post->post_type == 'fla_immo_offers' ) {
			
			if ( file_exists( plugin_dir_path( __FILE__ ) . 'partials/offre-immo-single.php' ) ) {
				return plugin_dir_path( __FILE__ ) . 'partials/offre-immo-single.php';
			}
		}

		if ( $post->post_type == 'fla_immo_agencies' ) {
			
			if ( file_exists( plugin_dir_path( __FILE__ ) . 'partials/agence-immo-single.php' ) ) {
				return plugin_dir_path( __FILE__ ) . 'partials/agence-immo-single.php';
			}
		}

		// if ( $post->post_type == 'fla_sollicitation' ) {
			
		// 	if ( file_exists( plugin_dir_path( __FILE__ ) . 'partials/sollicitation-single.php' ) ) {
		// 		return plugin_dir_path( __FILE__ ) . 'partials/sollicitation-single.php';
		// 	}
		// }

		return $single;

	}//end function

	public function fla_immo_routing($template)
	{
		$url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
		switch ($url_path) {
			case 'edit-annonce':
				// load the file if exists
				$load = locate_template(array(plugin_dir_path( __FILE__ ).'partials/annonce-edit.php'), true, false);
				
				if ($load === "") {
					$template = plugin_dir_path( __FILE__ ).'partials/annonce-edit.php';
				}
				break;
			case 'ajouter-annonce':
				// load the file if exists
				$load = locate_template(array(plugin_dir_path( __FILE__ ).'partials/annonce-new.php'), true, false);
				
				if ($load === "") {
					$template = plugin_dir_path( __FILE__ ).'partials/annonce-new.php';
				}
				break;
			case 'edit-agence':
				// load the file if exists
				$load = locate_template(array(plugin_dir_path( __FILE__ ).'partials/agence-immo-edit.php'), true, false);
				
				if ($load === "") {
					$template = plugin_dir_path( __FILE__ ).'partials/agence-immo-edit.php';
				}
				break;
			default:
				break;
		}
		
			return $template;
	}

	public function fla_immo_title_filter($where, $wp_query){
		global $wpdb;
	
		if($search_term = $wp_query->get( 'search_title' )){
			/*using the esc_like() in here instead of other esc_sql()*/
			$search_term = $wpdb->esc_like($search_term);
			$search_term = ' \'%' . $search_term . '%\'';
			$where .= ' AND ' . $wpdb->posts . '.post_title LIKE '.$search_term;
		}
	
		return $where;
	}//end function

	public function fla_immo_update_annonce_immo() {
		//init output object
		$output = new StdClass();
		$output->status = 'success';
		$output->errorText = '';
		$output->result = '';

		//retrieve post data

		$annonceID = (isset($_POST['id'])) ? $_POST['id'] : '';
		$title = (isset($_POST['title'])) ? $_POST['title'] : '';
		
		$description = (isset($_POST['description'])) ? $_POST['description'] : '';
		$type_de_transactiion = (isset($_POST['type_de_transactiion'])) ? $_POST['type_de_transactiion'] : '';
		$type_doffre = (isset($_POST['type_doffre'])) ? $_POST['type_doffre'] : '';
		$secteur = (isset($_POST['secteur'])) ? $_POST['secteur'] : '';
		$surface = (isset($_POST['surface'])) ? $_POST['surface'] : '';
		$surface2 = (isset($_POST['surface2'])) ? $_POST['surface2'] : '';
		$longitude = (isset($_POST['longitude'])) ? $_POST['longitude'] : '';
		$latitude = (isset($_POST['latitude'])) ? $_POST['latitude'] : '';
		$prix = (isset($_POST['prix'])) ? $_POST['prix'] : '';
		$unite = (isset($_POST['unite'])) ? $_POST['unite'] : '';
		$commission = (isset($_POST['commission'])) ? $_POST['commission'] : '';
		$num_mandat = (isset($_POST['num_mandat'])) ? $_POST['num_mandat'] : '';
		$ref_interne = (isset($_POST['ref_interne'])) ? $_POST['ref_interne'] : '';
		$annonce_img_id = (isset($_POST['annonce_img_id'])) ? $_POST['annonce_img_id'] : '';
		$annonce_gallery = (isset($_POST['annonce_gallery'])) ? $_POST['annonce_gallery'] : '';

	

		$annonce_fields_arr = array(
			'type_de_transaction'  => $type_de_transactiion,
			'type_doffre'          => $type_doffre,
			'description'          => $description,
			'surface'              => $surface,
			'surface_2'            => $surface2,
			'secteur'              => $secteur,
			'prix'                 => $prix,
			'unite'                => $unite,
			'longitude'            => $longitude,
			'latitude'             => $latitude,
			'commission_incluse'   => $commission,
			'numero_de_mandat'     => $num_mandat,
			'reference_interne'    => $ref_interne,
			'gallerie'             => $annonce_img_id

		);

		//if id of annonce immo not defined exit and throw error
		if ($annonceID === '') {
			$output->status = 'error';
			$output->errorText = 'offre immo ID not found';
			echo  json_encode($output);
			wp_die();
		}

		//update the post title
		$currentAnnonce = array(
			'ID'           => $annonceID,
			'post_title'   => $title
		);

		$annonce_updated = wp_update_post($currentAnnonce, true);
		//if post title not updated halt and throw error
		if (is_wp_error($annonce_updated)) {
			
			$output->status = 'error';
			$errors = $annonce_updated->get_error_messages();
			foreach ($errors as $error) {
				$output->errorText .= " ".$error;
			}
			echo  json_encode($output);
			wp_die();
		}else {
			//if post title update then update extra fields (acf)
			foreach ($annonce_fields_arr as $field_name => $field_value) {
				$field_updated = update_field($field_name, $field_value, $annonceID);
				//if a field not updated throw error
				if (!$field_updated) {
					$output->errorText .= 'can\'t update ' .$field_name.' ';
				}
			}

			//$annonce_gallery
			update_post_meta(
				$annonceID,
				'fla_immo_offer_gallery',
				$annonce_gallery
			);
		}

		echo  json_encode($output);
		wp_die();

	}//end function

	public function fla_immo_add_new_annonce_immo()
	{
		//init output object
		$output = new StdClass();
		$output->status = 'success';
		$output->errorText = '';
		$output->result = '';

		//retrieve post data

		$title = (isset($_POST['title'])) ? $_POST['title'] : '';
		
		$description = (isset($_POST['description'])) ? $_POST['description'] : '';
		$type_de_transactiion = (isset($_POST['type_de_transactiion'])) ? $_POST['type_de_transactiion'] : '';
		$type_doffre = (isset($_POST['type_doffre'])) ? $_POST['type_doffre'] : '';
		$secteur = (isset($_POST['secteur'])) ? $_POST['secteur'] : '';
		$surface = (isset($_POST['surface'])) ? $_POST['surface'] : '';
		$surface2 = (isset($_POST['surface2'])) ? $_POST['surface2'] : '';
		$longitude = (isset($_POST['longitude'])) ? $_POST['longitude'] : '';
		$latitude = (isset($_POST['latitude'])) ? $_POST['latitude'] : '';
		$prix = (isset($_POST['prix'])) ? $_POST['prix'] : '';
		$unite = (isset($_POST['unite'])) ? $_POST['unite'] : '';
		$commission = (isset($_POST['commission'])) ? $_POST['commission'] : '';
		$num_mandat = (isset($_POST['num_mandat'])) ? $_POST['num_mandat'] : '';
		$ref_interne = (isset($_POST['ref_interne'])) ? $_POST['ref_interne'] : '';
		$agence = (isset($_POST['agence'])) ? (int)$_POST['agence'] : '';
		$annonce_img_id = (isset($_POST['annonce_img_id'])) ? $_POST['annonce_img_id'] : '';
		$annonce_gallery = (isset($_POST['annonce_gallery'])) ? $_POST['annonce_gallery'] : '';


		$annonce_fields_arr = array(
			'type_de_transaction'  => $type_de_transactiion,
			'type_doffre'          => $type_doffre,
			'description'          => $description,
			'surface'              => $surface,
			'surface_2'            => $surface2,
			'secteur'              => $secteur,
			'prix'                 => $prix,
			'unite'                => $unite,
			'longitude'            => $longitude,
			'latitude'             => $latitude,
			'commission_incluse'   => $commission,
			'numero_de_mandat'     => $num_mandat,
			'reference_interne'    => $ref_interne,
			'agence'               => $agence,
			'gallerie'             => $annonce_img_id
		);

		//create new post
		$newAnnonce = array(
			'post_title'     => $title,
			'post_type'      => 'fla_immo_offers',
			'post_status'    => 'publish',
			'comment_status' => 'closed',
			'ping_status'    => 'closed'
		);

		$annonce_added = wp_insert_post( $newAnnonce, true );
		//if post title not added halt and throw error
		if (is_wp_error($annonce_added)) {
			
			$output->status = 'error';
			$errors = $annonce_added->get_error_messages();
			foreach ($errors as $error) {
				$output->errorText .= " ".$error;
			}
			echo  json_encode($output);
			wp_die();
		}else {
			//if post added then update extra fields (acf)
			
			foreach ($annonce_fields_arr as $field_name => $field_value) {
				$field_updated = update_field($field_name, $field_value, $annonce_added);
				//if a field not updated throw error
				if (!$field_updated) {
					$output->errorText .= 'can\'t update ' .$field_name.' ';
				}
			}//end foreach

			//$annonce_gallery
			update_post_meta(
				$annonce_added,
				'fla_immo_offer_gallery',
				$annonce_gallery
			);
		}

		$new_annonce_url = get_the_permalink( $annonce_added);

		$output->result = $new_annonce_url;

		echo  json_encode($output);
		wp_die();
		
	}//end function

	public function fla_immo_update_agence_immo()
	{
		//init output object
		$output = new StdClass();
		$output->status = 'success';
		$output->errorText = '';
		$output->result = '';



		//retrive post data
		$agenceID = (isset($_POST['id'])) ? (int)$_POST['id'] : '';
		$title = (isset($_POST['title'])) ? $_POST['title'] : '';
		$responsable = (isset($_POST['responsable'])) ? $_POST['responsable'] : '';
		$presentation = (isset($_POST['presentation'])) ? $_POST['presentation'] : '';
		$email = (isset($_POST['email'])) ? $_POST['email'] : '';
		$tel = (isset($_POST['tel'])) ? $_POST['tel'] : '';
		$adresse = (isset($_POST['adresse'])) ? $_POST['adresse'] : '';
		$ville = (isset($_POST['ville'])) ? $_POST['ville'] : '';
		$code_postal = (isset($_POST['code_postal'])) ? $_POST['code_postal'] : '';
		$agence_logo_id = (isset($_POST['agence_logo_id'])) ? $_POST['agence_logo_id'] : '';
		$agence_vitrine_id = (isset($_POST['agence_vitrine_id'])) ? $_POST['agence_vitrine_id'] : '';
		$site = (isset($_POST['site'])) ? $_POST['site'] : '';
		

	


		$agence_fields_arr = array(
			'responsable'   => $responsable,
			'presentation'  => $presentation,
			'email'         => $email,
			'tel'           => $tel,
			'site'          => $site,
			'adresse'       => $adresse,
			'ville'         => $ville,
			'code_postal'   => $code_postal,
			'logo'          => $agence_logo_id,
			'vitrine'       => $agence_vitrine_id,
		);

		//if id of annonce immo not defined exit and throw error
		if ($agenceID === '') {
			$output->status = 'error';
			$output->errorText = 'offre immo ID not found';
			echo  json_encode($output);
			wp_die();
		}

		//update the post title
		$currentAgence = array(
			'ID'           => $agenceID,
			'post_title'   => $title
		);

		$agence_updated = wp_update_post($currentAgence, true);
		//if post title not updated halt and throw error
		if (is_wp_error($agence_updated)) {
			
			$output->status = 'error';
			$errors = $agence_updated->get_error_messages();
			foreach ($errors as $error) {
				$output->errorText .= " ".$error;
			}
			echo  json_encode($output);
			wp_die();
		}else {
			//if post title update then update extra fields (acf)
			foreach ($agence_fields_arr as $field_name => $field_value) {
				$field_updated = update_field($field_name, $field_value, $agenceID);
				//if a field not updated throw error
				if (!$field_updated) {
					$output->errorText .= 'can\'t update ' .$field_name.' ';
				}
			}
		}

		echo  json_encode($output);
		wp_die();
	}//end function

	public function fla_immo_delete_offre_immo()
	{
		//init output object
		$output = new StdClass();
		$output->status = 'success';
		$output->errorText = '';
		$output->result = '';

		//collect data
		$offreID = isset($_POST['id_to_delete'])?(int)$_POST['id_to_delete']:0;

		if ($offreID == 0) {
			$output->status = 'error';
			echo json_encode($output);
			wp_die();
		}

		$currentOffreImmo = array(
			'ID'           => $offreID,
			'post_status'   => 'trash'
		);

		$offre_updated = wp_update_post($currentOffreImmo, true);
		//if post title not updated halt and throw error
		if (is_wp_error($offre_updated)) {
			
			$output->status = 'error';
			$errors = $offre_updated->get_error_messages();
			foreach ($errors as $error) {
				$output->errorText .= " ".$error;
			}
			echo  json_encode($output);
			wp_die();
		}

		echo  json_encode($output);
		wp_die();
	}//end function

	public function fla_immo_archive_offre_immo()
	{
		//init output object
		$output = new StdClass();
		$output->status = 'success';
		$output->errorText = '';
		$output->result = '';

		//collect data
		$offreID = isset($_POST['id_to_archive'])?(int)$_POST['id_to_archive']:0;
		
		if ($offreID == 0) {
			$output->status = 'error';
			$output->errorText .= "no id found";
			echo json_encode($output);
			wp_die();
		}

		$currentOffreImmo = array(
			'ID'           => $offreID,
			'post_status'   => 'draft'
		);

		$offre_updated = wp_update_post($currentOffreImmo, true);
		//if post title not updated halt and throw error
		if (is_wp_error($offre_updated)) {
			
			$output->status = 'error';
			$errors = $offre_updated->get_error_messages();
			foreach ($errors as $error) {
				$output->errorText .= " ".$error;
			}
			echo  json_encode($output);
			wp_die();
		}

		echo  json_encode($output);
		wp_die();
	}//end function

	
	

}//end class
