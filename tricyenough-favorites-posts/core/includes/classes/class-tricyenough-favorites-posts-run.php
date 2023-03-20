<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Tricyenough_Favorites_Posts_Run
 *
 * Thats where we bring the plugin to life
 *
 * @package		TRICYENOUG
 * @subpackage	Classes/Tricyenough_Favorites_Posts_Run
 * @author		vishvajit kumar
 * @since		1.0.0
 */
class Tricyenough_Favorites_Posts_Run{

	/**
	 * Our Tricyenough_Favorites_Posts_Run constructor 
	 * to run the plugin logic.
	 *
	 * @since 1.0.0
	 */
	function __construct(){
		$this->add_hookss();
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOKS
	 * ###
	 * ######################
	 */

	/**
	 * Registers all WordPress and plugin related hooks
	 *
	 * @access	private
	 * @since	1.0.0
	 * @return	void
	 */
	private function add_hookss(){
	
		add_action( 'wp_enqueue_scripts', array( $this, 'favorite_enqueue_backend_scripts_and_styles' ), 21 );
		add_action( 'plugins_loaded', array( $this, 'add_wp_webhooks_integrations' ), 9 );
	
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOK CALLBACKS
	 * ###
	 * ######################
	 */

	/**
	 * Enqueue the backend related scripts and styles for this plugin.
	 * All of the added scripts andstyles will be available on every page within the backend.
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function favorite_enqueue_backend_scripts_and_styles() 
   {
		wp_enqueue_style( 'favorite-fontend-styles', TRICYENOUG_PLUGIN_URL . 'core/includes/assets/css/backend-styles.css', array(), TRICYENOUG_VERSION, 'all' );

			wp_enqueue_script( 'favorite-backend-scripts', TRICYENOUG_PLUGIN_URL . 'core/includes/assets/js/favorite-scripts.js', array('jquery'), TRICYENOUG_VERSION, false );

		wp_localize_script( 'favorite-backend-scripts', 'tricyenoug', array(
			'plugin_name'   	=> __( TRICYENOUG_NAME, 'tricyenough-favorites-posts' ),
		));
		wp_localize_script( 'favorite-backend-scripts', 'favorites_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}

	/**
	 * ####################
	 * ### WP Webhooks 
	 * ####################
	 */

	/*
	 * Register dynamically all integrations
	 * The integrations are available within core/includes/integrations.
	 * A new folder is considered a new integration.
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function add_wp_webhooks_integrations(){

		// Abort if WP Webhooks is not active
		if( ! function_exists('WPWHPRO') ){
			return;
		}

		$custom_integrations = array();
		$folder = TRICYENOUG_PLUGIN_DIR . 'core' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'integrations';

		try {
			$custom_integrations = WPWHPRO()->helpers->get_folders( $folder );
		} catch ( Exception $e ) {
			WPWHPRO()->helpers->log_issue( $e->getTraceAsString() );
		}

		if( ! empty( $custom_integrations ) ){
			foreach( $custom_integrations as $integration ){
				$file_path = $folder . DIRECTORY_SEPARATOR . $integration . DIRECTORY_SEPARATOR . $integration . '.php';
				WPWHPRO()->integrations->register_integration( array(
					'slug' => $integration,
					'path' => $file_path,
				) );
			}
		}
	}

}
