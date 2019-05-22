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
		?>
		<form id="fl_immo_search_form">
		<div>
			<label for="type_d_offre">Type d'offre</label>
			<select name="type_d_offre">
				<option value="tout">Tout</option>
				<option value="lld">Location longue durée</option>
				<option value="lcd">Location courte durée</option>
				<option value="vente">Vente</option>
			</select>
		</div>
		<div>
			<label for="transaction">Type de transaction</label>
			<input type="text" name="transaction" id="transaction">
		</div>
		<div>
			<label for="secteur">Secteur</label>
			<input type="text" name="secteur" id="secteur">
		</div>
		<div>
			<label for="secteur">Surface</label>
			<input type="text" name="surface_min" id="surface_min" placeholder="min">
			<input type="text" name="surface_max" id="surface_max" placeholder="max">
		</div>
		<div>
			<label for="secteur">Mots clés</label>
			<input type="text" name="mots_cles" id="mots_cles" placeholder="min">
		</div>

		<div><button>Rechercher</button></div>
		</form>
		<?php
	}//end function of shortcode

	Public function fla_immo_search_result_widget()
	{
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
		// if ($type_de_contrat != "" && $type_de_contrat != "tout") {
		// 	# code...
		// 	$metaquery_arr[] = array(
		// 		'key'		=> 'type_de_contrat',
		// 		'value'		=> $type_de_contrat,
		// 		'compare'	=> '='
		// 	);
		// 	$args['meta_query'] = $metaquery_arr;
		// 	// $args['meta_key'] = 'type_de_contrat';
		// 	// $args['meta_value'] = $type_de_contrat;
			
		// }
		// if ($fonction != "" && $fonction != "tout") {
		// 	# code...
		// 	$metaquery_arr[] = array(
		// 		'key'		=> 'fonction',
		// 		'value'		=> $fonction,
		// 		'compare'	=> '='
		// 	);
		// 	$args['meta_query'] = $metaquery_arr;
			
		// }
		//var_dump($args);
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
				?>
				
					<div class="result_item">
						<a href="<?php the_permalink(); ?>">
							<div>
								<h3><?php the_title(); ?></h3>
								<em><?php echo get_the_modified_date(); ?></em>
								<h5><?php the_field('type_doffre') ?></h5>
								<h5><?php the_field('secteur') ?></h5>
								<img style="height: 100px;" src="<?php echo get_field('gallerie')['url']; ?>" />
								<?php 
								$agences = get_field('agence');
								var_dump($agences);
								// if( $agences ): ?>
								 	<?php //foreach( $agences as $p): // variable must be called $p (IMPORTANT)
								// 		//var_dump($p);
								// 		?>
								 			<h2><?php// echo get_the_title($p->ID); ?></h2>
								 	<?php //endforeach; ?>
									
								 <?php //endif; 
								// ?>
								<p><?php echo substr(get_field('description'),0,120).'...';  ?></p>
							</div>
						</a>
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

}
