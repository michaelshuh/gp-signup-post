<?php
/*
Plugin Name: GP Signup Post
Plugin URI: http://github.com/gp-signup-post
Description: Declares a plugin that will create a custom post type displaying google form signups.
Version: 1.0
Author: Michael Shuh
Author URI: https://github.com/michaelshuh
License: GPLv2
*/

    add_action('init', 'create_gp_signup_post');

    function create_gp_signup_post() {
        register_post_type( 'gp_signup_posts',
            array(
                'labels' => array(
                    'name' => 'Signup Posts',
                    'singular_name' => 'Signup Post',
                    'add_new' => 'Add New',
                    'add_new_item' => 'Add New Signup Post',
                    'edit' => 'Edit',
                    'edit_item' => 'Edit Signup Post',
                    'new_item' => 'New Signup Post',
                    'view' => 'View',
                    'view_item' => 'View Signup Post',
                    'search_items' => 'Search Signup Posts',
                    'not_found' => 'No Signup Posts found',
                    'not_found_in_trash' => 'No Signup Posts found in Trash',
                    'parent' => 'Parent Signup Post'
                ),

                'public' => true,
                'menu_position' => 15,
                'supports' => array( 'title', 'editor', 'thumbnail'),
                'rewrite'  => array( 'slug' => 'signups' ),
                'has_archive' => true
            )
        );
    }
    
    add_action('admin_init', 'gp_my_admin');
    
    function gp_my_admin() {
        add_meta_box( 'gp_signup_post_meta_box',
            'Signup Post Details',
            'display_gp_signup_post_meta_box',
            'gp_signup_posts', 'normal', 'high'
        );
    }
    
    add_action( 'wp_enqueue_scripts', 'gp_signup_posts_scripts' );
    
    function gp_signup_posts_scripts() {
    	wp_enqueue_style( 'signup_post_style', plugins_url( 'signup_post_style.css', __FILE__ ) );
    }

    
    add_action( 'save_post', 'add_gp_signup_post_fields', 10, 2 );

	function add_gp_signup_post_fields( $signup_post_id, $signup_post ) {
	    // Check post type for movie reviews
	    if ( $signup_post->post_type == 'gp_signup_posts' ) {
	        // Store data in post meta table if present in post data
	        if ( isset( $_POST['gp_signup_post_image'] ) && $_POST['gp_signup_post_image'] != '' ) {
	            update_post_meta( $signup_post_id, 'gp_signup_post_image', $_POST['gp_signup_post_image'] );
	        }
	        if ( isset( $_POST['gp_signup_post_form'] ) && $_POST['gp_signup_post_form'] != '' ) {
	            update_post_meta( $signup_post_id, 'gp_signup_post_form', $_POST['gp_signup_post_form'] );
	        }
	        if ( isset( $_POST['gp_signup_post_form_height'] ) && $_POST['gp_signup_post_form_height'] != '' ) {
	            update_post_meta( $signup_post_id, 'gp_signup_post_form_height', $_POST['gp_signup_post_form_height'] );
	        }
	    }
	}
	
	add_filter( 'template_include', 'include_template_function', 1 );
	
	function include_template_function( $template_path ) {
	    if ( get_post_type() == 'gp_signup_posts' ) {
	        if ( is_single() ) {
	            // checks if the file exists in the theme first,
	            // otherwise serve the file from the plugin
	            if ( $theme_file = locate_template( array ( 'single-gp_signup_posts.php' ) ) ) {
	                $template_path = $theme_file;
	            } else {
	                $template_path = plugin_dir_path( __FILE__ ) . '/single-gp_signup_posts.php';
	            }
	        } elseif ( is_archive() ) {
				if ( $theme_file = locate_template( array ( 'archive-gp_signup_posts.php' ) ) ) {
					$template_path = $theme_file;
				} else { 
					$template_path = plugin_dir_path( __FILE__ ) . '/archive-gp_signup_posts.php';
				}
			}
		}
	    return $template_path;
	}

function display_gp_signup_post_meta_box( $signup_post ) {
    // Retrieve current image and google form based on post ID
    $post_image = esc_html( get_post_meta( $signup_post->ID, 'gp_signup_post_image', true ) );
    $post_form = esc_html( get_post_meta( $signup_post->ID, 'gp_signup_post_form', true ) );
	$post_form_height = intval( get_post_meta( $signup_post->ID, 'gp_signup_post_form_height', true ) );
?>
    <table>
        <tr>
            <td style="width: 100%">Image URL</td>
            <td><input type="text" size="80" name="gp_signup_post_image" value="<?php echo $post_image; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Form URL</td>
            <td><input type="text" size="80" name="gp_signup_post_form" value="<?php echo $post_form; ?>" /></td>
        </tr>
		<tr>
            <td style="width: 100%">Form Height</td>
            <td><input type="text" size="10" name="gp_signup_post_form_height" value="<?php echo $post_form_height; ?>" /></td>
        </tr>
    </table>
<?php
	}
?>
