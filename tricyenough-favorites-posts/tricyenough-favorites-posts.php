<?php
/**
 * Tricyenough Favorites Posts
 *
 * @package       TRICYENOUG
 * @author        vishvajit kumar
 * @license       gplv2
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   Tricyenough Favorites Posts
 * Plugin URI:    https://www.trickyenough.com/
 * Description:   Tricyenough Favorites Posts
 * Version:       1.0.0
 * Author:        vishvajit kumar
 * Author URI:    https://www.trickyenough.com/
 * Text Domain:   tricyenough-favorites-posts
 * Domain Path:   /languages
 * License:       GPLv2
 * License URI:   https://www.gnu.org/licenses/gpl-2.0.html
 *
 * You should have received a copy of the GNU General Public License
 * along with Tricyenough Favorites Posts. If not, see <https://www.gnu.org/licenses/gpl-2.0.html/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
// Plugin name
define( 'TRICYENOUG_NAME',			'Tricyenough Favorites Posts' );

// Plugin version
define( 'TRICYENOUG_VERSION',		'1.0.0' );

// Plugin Root File
define( 'TRICYENOUG_PLUGIN_FILE',	__FILE__ );

// Plugin base
define( 'TRICYENOUG_PLUGIN_BASE',	plugin_basename( TRICYENOUG_PLUGIN_FILE ) );

// Plugin Folder Path
define( 'TRICYENOUG_PLUGIN_DIR',	plugin_dir_path( TRICYENOUG_PLUGIN_FILE ) );

// Plugin Folder URL
define( 'TRICYENOUG_PLUGIN_URL',	plugin_dir_url( TRICYENOUG_PLUGIN_FILE ) );

/**
 * Load the main class for the core functionality
 */
require_once TRICYENOUG_PLUGIN_DIR . 'core/class-tricyenough-favorites-posts.php';

/**
 * The main function to load the only instance
 * of our master class.
 *
 * @author  vishvajit kumar
 * @since   1.0.0
 * @return  object|Tricyenough_Favorites_Posts
 */
function TRICYENOUG() {
	return Tricyenough_Favorites_Posts::instance();
}

TRICYENOUG();
