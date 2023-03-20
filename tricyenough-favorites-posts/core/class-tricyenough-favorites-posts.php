<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'Tricyenough_Favorites_Posts' ) ) :

	/**
	 * Main Tricyenough_Favorites_Posts Class.
	 *
	 * @package		TRICYENOUG
	 * @subpackage	Classes/Tricyenough_Favorites_Posts
	 * @since		1.0.0
	 * @author		vishvajit kumar
	 */
	final class Tricyenough_Favorites_Posts {

		/**
		 * The real instance
		 *
		 * @access	private
		 * @since	1.0.0
		 * @var		object|Tricyenough_Favorites_Posts
		 */
		private static $instance;

		/**
		 * TRICYENOUG helpers object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Tricyenough_Favorites_Posts_Helpers
		 */
		public $helpers;

		/**
		 * TRICYENOUG settings object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Tricyenough_Favorites_Posts_Settings
		 */
		public $settings;

		/**
		 * Throw error on object clone.
		 *
		 * Cloning instances of the class is forbidden.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to clone this class.', 'tricyenough-favorites-posts' ), '1.0.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to unserialize this class.', 'tricyenough-favorites-posts' ), '1.0.0' );
		}

		/**
		 * Main Tricyenough_Favorites_Posts Instance.
		 *
		 * Insures that only one instance of Tricyenough_Favorites_Posts exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @access		public
		 * @since		1.0.0
		 * @static
		 * @return		object|Tricyenough_Favorites_Posts	The one true Tricyenough_Favorites_Posts
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Tricyenough_Favorites_Posts ) ) {
				self::$instance					= new Tricyenough_Favorites_Posts;
				self::$instance->base_hooks();
				self::$instance->includes();
				self::$instance->helpers		= new Tricyenough_Favorites_Posts_Helpers();
				self::$instance->settings		= new Tricyenough_Favorites_Posts_Settings();
				self::$instance->database		= new Tricyenough_Favorites_Posts_Database();
                self::$instance->shortcode		= new Tricyenough_Favorites_Posts_Shortcode();

				//Fire the plugin logic
				self::$instance->run = new Tricyenough_Favorites_Posts_Run();

				/**
				 * Fire a custom action to allow dependencies
				 * after the successful plugin setup
				 */
				do_action( 'TRICYENOUG/plugin_loaded' );
			}

			return self::$instance;
		}

		/**
		 * Include required files.
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function includes() {
			require_once TRICYENOUG_PLUGIN_DIR . 'core/includes/classes/class-tricyenough-favorites-posts-helpers.php';
			require_once TRICYENOUG_PLUGIN_DIR . 'core/includes/classes/class-tricyenough-favorites-posts-settings.php';
			require_once TRICYENOUG_PLUGIN_DIR . 'core/includes/classes/class-tricyenough-favorites-posts-database.php';
			require_once TRICYENOUG_PLUGIN_DIR . 'core/includes/classes/class-tricyenough-favorites-posts-shortcode.php';

			require_once TRICYENOUG_PLUGIN_DIR . 'core/includes/classes/class-tricyenough-favorites-posts-run.php';
		}

		/**
		 * Add base hooks for the core functionality
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function base_hooks() {
			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access  public
		 * @since   1.0.0
		 * @return  void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'tricyenough-favorites-posts', FALSE, dirname( plugin_basename( TRICYENOUG_PLUGIN_FILE ) ) . '/languages/' );
		}

	}

endif; // End if class_exists check.