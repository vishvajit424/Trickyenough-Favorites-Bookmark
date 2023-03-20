<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Tricyenough_Favorites_Posts_Database
 *
 * This class contains repetitive functions that
 * are used globally within the plugin.
 *
 * @package		TRICYENOUG
 * @subpackage	Classes/Tricyenough_Favorites_Posts_Database
 * @author		vishvajit kumar
 * @since		1.0.0
 */
class Tricyenough_Favorites_Posts_Database
{
	function __construct()
	{
		register_activation_hook(__FILE__,array($this, 'database_install'));

	}
    //  
	public function database_install() {
               global $wpdb;
               $table_name = $wpdb->prefix . 'favorites_posts';
              $charset_collate = $wpdb->get_charset_collate();
               $query = "CREATE TABLE " . $wpdb->prefix . "favorite_posts
               (id INT AUTO_INCREMENT,
               post_id INT NOT NULL,
               user_id INT NOT NULL,
               PRIMARY KEY (id))";
               require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
               $wpdb->get_results($query);
	}

    public function saveBookmark($the_post,$the_user)
    {
        // Save to DB
            global $wpdb;
            $check = $wpdb->get_results("
                SELECT *
                FROM wp_favorite_posts
                WHERE post_id = '$the_post'
                AND user_id = '$the_user'
            ");
            if ( empty($check) ) {
              $result =  $wpdb->insert( 'wp_favorite_posts', array( 'post_id' => $the_post, 'user_id' => $the_user), array( '%d', '%d' ) );
            }
    }
    public function removeBookmark($the_post,$the_user)
    {
        // remove to DB
        global $wpdb;
        $check = $wpdb->get_results("
        SELECT *
        FROM wp_favorite_posts
        WHERE post_id = '$the_post'
        AND user_id = '$the_user'");
        if ( !empty($check) ) {
           $result = $wpdb->delete( 'wp_favorite_posts', array( 'post_id' => $the_post, 'user_id' => $the_user), array( '%d', '%d' ) );
         }
    }
    public function get_favorite_posts($userid) 
    {
        global $wpdb;
        $match = $wpdb->get_results("
            SELECT wp_posts.ID, wp_favorite_posts.post_id
            FROM wp_posts
            INNER JOIN wp_favorite_posts
            ON wp_posts.ID=wp_favorite_posts.post_id
            AND wp_favorite_posts.user_id = '$userid'
            ORDER BY wp_posts.ID
        ");
        if ( !empty($match) ) {
           return $match;
        }
        // if ( !empty($match) ) {
        //     $favorites = array();
        //     foreach ( $match as $post ){
        //         $favorites[] = $post->ID;
        //     }
        //     return $favorites;
        // } else {
        //     return FALSE;
        // }
     }
}

$tri_shortcode = new Tricyenough_Favorites_Posts_Database();



