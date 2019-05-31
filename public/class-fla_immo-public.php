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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/fla_immo-public.js', array( 'jquery' ), $this->version, false );

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
		$args = array (
			'post_type'              => array( 'fla_immo_offers' ),
			'post_status'            => array( 'publish' ),
			'nopaging'               => true,
			'order'                  => 'ASC',
			'orderby'                => 'menu_order',
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
		
		if ($mots_cles != "" ) {
			# code...
			$args['search_title'] = $mots_cles;
			// $metaquery_arr[] = array(
			// 	'key'		=> 'description',
			// 	'value'		=> $mots_cles,
			// 	'compare' => 'LIKE',
			// 	'type' => 'TEXT'
			// );
		}




		$args['meta_query'] = $metaquery_arr;
		// The Query
		$offres_immo = new WP_Query( $args );
		//var_dump($offres_immo);

		// The Loop
		if ( $offres_immo->have_posts() ) {
			//var_dump($emplois);
			echo "<h3>Nombre de resulta : " . count($offres_immo->posts) . "</h3>"
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
			?> </div> <?php
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

	public function fla_immo_title_filter($where, &$wp_query){
		global $wpdb;
	
		if($search_term = $wp_query->get( 'search_title' )){
			/*using the esc_like() in here instead of other esc_sql()*/
			$search_term = $wpdb->esc_like($search_term);
			$search_term = ' \'%' . $search_term . '%\'';
			$where .= ' AND ' . $wpdb->posts . '.post_title LIKE '.$search_term;
		}
	
		return $where;
	}

}
