<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Tricyenough_Favorites_Posts_Helpers
 *
 * This class contains repetitive functions that
 * are used globally within the plugin.
 *
 * @package		TRICYENOUG
 * @subpackage	Classes/Tricyenough_Favorites_Posts_Helpers
 * @author		vishvajit kumar
 * @since		1.0.0
 */
class Tricyenough_Favorites_Posts_Helpers{

	/**
	 * ######################
	 * ###
	 * #### CALLABLE FUNCTIONS
	 * ###
	 * ######################
	 */
    function __construct(){
        $this->add_hooks();
    }

    private function add_hooks()
    {
       //add_shortcode( 'favourite-post-btn', array(&$this, 'get_favorites_add_link' ) );
       add_action( 'wp_ajax_savePost', array( $this, 'savePost' ));
       add_action( 'wp_ajax_nopriv_savePost', array( $this, 'savePost' ));

       add_action( 'wp_ajax_savePost', array( $this, 'savePost' ) );    //execute when wp logged in
       add_action( 'wp_ajax_nopriv_savePost', array( $this, 'savePost' )); //execute when logged out

       add_action( 'wp_ajax_removBookmark', array( $this, 'removBookmark' ) );    //execute when wp logged in
       add_action( 'wp_ajax_nopriv_removBookmark', array( $this, 'removBookmark' )); //execute when logged out
       add_action('wp_body_open', array( $this, 'custom_content_after_body_open_tag'));
    }
   
   public function check_favorite_posts($post_id, $user_id)
   {
    global $wpdb;
    $match = $wpdb->get_results("SELECT * FROM wp_favorite_posts WHERE post_id = '$post_id'
                AND user_id = '$user_id'");
    if ( !empty($match) ) :
        return TRUE;
     else :
        return FALSE;
    endif;
    }
// Get Remove Button
function get_favorites_remove_link($title = 'Remove', $class = NULL){
    // Remove from DB
    if ( is_user_logged_in() ) {
        return '
            <form id="remove_bookmark" class="remove" style="display: inline;">
                <input type="hidden" value="1" name="remove_it" />
                <input type="hidden" value="'.get_the_ID().'" name="post_id" class="fp_id" />
                <input type="hidden" value="'.get_current_user_id().'" name="user_id" class="fp_user_id" />
                <input type="hidden" value="removBookmark" name="action" />
                <button class="btn btn-dark remove_it_now '.$class.'" name="" ><i id="bookmark_icon" class="fa fa-bookmark" style="color: #fdfdfd;"></i>
                </button>
            </form>
        ';
    }
}
public function savePost() 
{
    $database = new Tricyenough_Favorites_Posts_Database();
    $the_post = $_POST['post_id'];
    $the_user = $_POST['user_id'];
    $result=$database->saveBookmark($the_post,$the_user);
    if (!empty($result) ) {
        return true;
    }else{
        return false;
    }
    exit;
    exit;
}
public function removBookmark()
{
    $database = new Tricyenough_Favorites_Posts_Database();
    $the_post = $_POST['post_id'];
    $the_user = $_POST['user_id'];
    $result=$database->removeBookmark($the_post,$the_user);
    if (!empty($result) ) {
        return true;
    }else{
        return false;
    }
    exit;
    
   }
   function custom_content_after_body_open_tag() {

    ?>
    <section class="favorites-popup">
  <div class="close">X</div>
  <div class="popup__content">
     <h5 id="favorite_popup_msg" class="text-center" style="margin-top: 25%;color: #000 !important;">Bookmark Success</h5>
  </div>
</section> 
    <?php

}




}
