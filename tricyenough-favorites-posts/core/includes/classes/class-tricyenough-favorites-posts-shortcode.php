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
class Tricyenough_Favorites_Posts_shortcode{

	/**
	 * Our Tricyenough_Favorites_Posts_Run constructor 
	 * to run the plugin logic.
	 *
	 * @since 1.0.0
	 */
	function __construct(){
		$this->add_hooks();

	}
    private function add_hooks()
    {
       add_shortcode( 'favourite-post-btn', array(&$this, 'get_favorites_add_link' ) );
       add_shortcode( 'favourite-bookmark-list', array(&$this, 'get_bookmark_list' ) );
    }
     public function get_favorites_add_link($title = 'BookMark Game')
    {
    	    $helper = new Tricyenough_Favorites_Posts_Helpers();
            $postid = get_the_ID();
            $userid = get_current_user_id();
            if ( is_user_logged_in() ) {
                if ( !$helper->check_favorite_posts($postid,$userid) ) {
                    if ( is_user_logged_in() ) { 
                        return '<form id="save_bookmark" style="display: inline;">
                                <input type="hidden" value="1" name="save_later" />
                                <input type="hidden" value="'.get_the_ID().'" name="post_id" class="fp_id" />
                                <input type="hidden" value="'.get_current_user_id().'" name="user_id" class="fp_user_id" />
                                <input type="hidden" name="action" value="savePost" id="form-action">
                                <button class="btn btn-dark" name="save">
                                <i id="bookmark_icon" class="fa fa-bookmark-o"></i></button>
                            </form>';
                    }
                } else {
                    if ( get_post_type() == 'tools' ) {
                        echo $helper->get_favorites_remove_link('Remove');
                    } elseif ( get_post_type() == 'tools' ) {
                        echo $helper->get_favorites_remove_link('Remove bookmark');
                    } else {
                        echo $helper->get_favorites_remove_link('Remove bookmark');
                    }
                }
            } else {
                return '<a href="" class="must_login">Read Later</a>';
            }
    }
    public function get_bookmark_list()
    {
        $userid = get_current_user_id();
        $db = new Tricyenough_Favorites_Posts_Database();
        $tools=$db->get_favorite_posts($userid);
        foreach ($tools as $tool) {
            $feat_image = get_the_post_thumbnail_url($tool->post_id,'homepage-most-viewed');
        echo "<div class='col-md-4 d-flex'>";
        echo '<div class="card" style="width: 20rem;">
         <img class="card-img-top" src="'.$feat_image.'" alt="'.get_the_title($tool->post_id).'">
          <div class="card-body">
            <a href="'.get_permalink($tool->post_id).'"><h5 class="card-title">'.get_the_title($tool->post_id).'</h5></a>
             </div> 
          </div>';

        echo "</div>";
        }
    }
}
