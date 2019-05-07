<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.keendevs.com/
 * @since      1.0.0
 *
 * @package    Salon_Companion
 * @subpackage Salon_Companion/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Salon_Companion
 * @subpackage Salon_Companion/admin
 * @author     KeenDevs <keendevs@gmail.com>
 */
class Salon_Companion_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action('add_meta_boxes', [ $this, 'salon_package_metabox' ], 10, 2);
        add_action('save_post', [ $this, 'salon_package_metabox_save' ], 10, 2);

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Salon_Companion_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Salon_Companion_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/salon-companion-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Salon_Companion_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Salon_Companion_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/salon-companion-admin.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( $this->plugin_name, 'salon_companion_uploader', array(
        	'upload' => __( 'Upload', 'salon-companion' ),
        	'change' => __( 'Change', 'salon-companion' ),
        	'msg'    => __( 'Please upload a valid image file.', 'salon-companion' )
    	));

	}

	/**
	* Get post types for templates
	*
	* @return array of default settings
	*/
	public function salon_get_posttype_array() {           
		$posts = array(
			'package' => array( 
				'singular_name'		  => __( 'Package', 'salon-companion' ),
				'general_name'		  => __( 'Packages', 'salon-companion' ),
				'dashicon'			  => 'dashicons-editor-table',
				'taxonomy'			  => 'package_category',
				'taxonomy_slug'		  => 'package-category',
				'has_archive'         => true,		
				'exclude_from_search' => false,
				'show_in_nav_menus'	  => true,
				'show_in_rest'   	  => true,
				'supports' 			  => array( 'title' ),
				'rewrite' 			  => array( 'slug' => 'package' ),
				'hierarchical'		  => true
			),
		);
        // Parse incoming $args into an array and merge it with $defaults
        $posts  = apply_filters( 'salon_get_posttype_array', $posts );
        return $posts;
	}

	/**
	 * Register post types.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	function salon_register_post_types() {
		$myarray = $this->salon_get_posttype_array();
		foreach ($myarray as $key => $value) {
			$labels = array(
				'name'                  => $value['general_name'],
				'singular_name'         => $value['singular_name'],
				'menu_name'             => $value['general_name'],
				'name_admin_bar'        => $value['singular_name'],
				'archives'              => sprintf(__('%s Archives', 'salon-companion'), $value['singular_name']),
				'attributes'            => sprintf(__('%s Attributes', 'salon-companion'), $value['singular_name']),
				'parent_item_colon'     => sprintf(__('%s Parent', 'salon-companion'), $value['singular_name']),
				'all_items'             => sprintf(__('All %s', 'salon-companion'), $value['general_name']),
				'add_new_item'          => sprintf(__('Add New %s', 'salon-companion'), $value['singular_name']),
				'add_new'               => __( 'Add New', 'salon-companion' ),
				'new_item'              => sprintf(__('New %s', 'salon-companion'), $value['singular_name']),
				'edit_item'             => sprintf(__('Edit %s', 'salon-companion'), $value['singular_name']),
				'update_item'           => sprintf(__('Update %s', 'salon-companion'), $value['singular_name']),
				'view_item'             => sprintf(__('View %s', 'salon-companion'), $value['singular_name']),
				'view_items'            => sprintf(__('View %s', 'salon-companion'), $value['singular_name']),
				'search_items'          => sprintf(__('Search %s', 'salon-companion'), $value['singular_name']),
				'not_found'             => __( 'Not found', 'salon-companion' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'salon-companion' ),
				'featured_image'        => __( 'Featured Image', 'salon-companion' ),
				'set_featured_image'    => __( 'Set featured image', 'salon-companion' ),
				'remove_featured_image' => __( 'Remove featured image', 'salon-companion' ),
				'use_featured_image'    => __( 'Use as featured image', 'salon-companion' ),
				'insert_into_item'      => sprintf(__('Insert into %s', 'salon-companion'), $value['singular_name']),
				'uploaded_to_this_item' => sprintf(__('Uploaded to this %s', 'salon-companion'), $value['singular_name']),
				'items_list'            => sprintf(__('%s list', 'salon-companion'), $value['singular_name']),
				'items_list_navigation' => sprintf(__('%s list navigation', 'salon-companion'), $value['singular_name']),
				'filter_items_list'     => sprintf(__('Filter %s list', 'salon-companion'), $value['singular_name']),
			);
			$args = array(
				'label'                 => $value['singular_name'],
				'description'           => sprintf(__('%s Post Type', 'salon-companion'), $value['singular_name']),
				'labels'                => $labels,
				'supports'              => $value['supports'],
				'hierarchical'          => false,
				'public'                => true,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'show_in_rest'          => $value['show_in_rest'],
				'menu_icon'             => $value['dashicon'],
				'show_in_admin_bar'     => true,
				'show_in_nav_menus'     => $value['show_in_nav_menus'],
				'can_export'            => true,
				'has_archive'           => $value['has_archive'],		
				'exclude_from_search'   => $value['exclude_from_search'],
				'publicly_queryable'    => true,
				'capability_type'       => 'post',
				'rewrite'               => $value['rewrite'],
			);
			register_post_type( $key, $args );
	    	flush_rewrite_rules();
		}
	}

	/**
	 * Register a taxonomy, post_types_categories for the post types.
	 *
	 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	function salon_create_post_type_taxonomies() {
		// Add new taxonomy, make it hierarchical
		$myarray = $this->salon_get_posttype_array();
		foreach ($myarray as $key => $value) {
			if(isset($value['taxonomy']))
			{
				$labels = array(
					'name'              => sprintf(__('%s Categories', 'salon-companion'), $value['singular_name']),
					'singular_name'     => sprintf(__('%s Categories', 'salon-companion'), $value['singular_name']),
					'search_items'      => __( 'Search Categories', 'salon-companion' ),
					'all_items'         => __( 'All Categories', 'salon-companion' ),
					'parent_item'       => __( 'Parent Categories', 'salon-companion' ),
					'parent_item_colon' => __( 'Parent Categories:', 'salon-companion' ),
					'edit_item'         => __( 'Edit Categories', 'salon-companion' ),
					'update_item'       => __( 'Update Categories', 'salon-companion' ),
					'add_new_item'      => __( 'Add New Categories', 'salon-companion' ),
					'new_item_name'     => __( 'New Categories Name', 'salon-companion' ),
					'menu_name'         => sprintf(__('%s Categories', 'salon-companion'), $value['singular_name']),
				);

				$args = array(
					'hierarchical'      => isset( $value['hierarchical'] ) ? $value['hierarchical']:true,
					'labels'            => $labels,
					'show_ui'           => true,
					'show_admin_column' => true,
					'show_in_nav_menus' => true,
					'rewrite'           => array( 'slug' => $value['taxonomy_slug'], 'hierarchical' => isset( $value['hierarchical'] ) ? $value['hierarchical']:true ),
				);
				register_taxonomy( $value['taxonomy'], array( $key ), $args );
			}
		}
	}

	/**
	 * Package Custo metabox
	 *
	 */
	public function salon_package_metabox() {
        add_meta_box(
            'salon_package',
            'Package and Plan',
            [ $this, 'salon_package_render' ],
            'package',
            'normal',
            'high'
        );
    }

    public function salon_package_render($post) {
         global $post;
        // We'll use this nonce field later on when saving.
        wp_nonce_field( 'salon_package_metabox_nonce', 'meta_box_nonce' );
    ?>
        <div id="package_meta_box">
            <style>
                #package_meta_box p {
                    display: grid;
                    grid-template-columns: repeat(12, 1fr);
                    grid-gap: 15px;
                }
                #package_meta_box p label {
                    font-weight: bold;
                    width: 100%;
                }
                #package_meta_box p input {
                    width: 100%;
                    display: block;
                    font-weight: normal;
                }
                #package_meta_box p .button {
                    align-self: end;
                }
                #package_meta_box p label[for="package_title"] {
                    grid-column: 1/10;
                }
                #package_meta_box p label[for="package_price"] {
                    grid-column: 10/12;
                }
                
            </style>
            <?php
            //get the saved meta as an array
            $packages = get_post_meta($post->ID,'package',false);
            $i = 0;
            if ( count( $packages ) > 0 ) {
                if(!empty($packages)){
                    foreach( $packages as $package ) {
                        if ($package) {
                            foreach( $package as $pack ) {
                                if ( isset( $pack['title'] ) || isset( $pack['track'] ) ) {
                                    printf( '<p><label for="package_title">Title<input type="text" name="package[%1$s][title]" value="%2$s" id="package_title"></label><label for="package_price">Price<input type="text" name="package[%1$s][price]" value="%3$s" id="package_price"></label><span class="button button-danger remove">%4$s</span></p>', $i, $pack['title'], $pack['price'], __( 'Remove', 'salon' ) );
                                    $i = $i +1;
                                }
                            }
                        }
                    }
                }    
            }
            ?>
            <span id="here"></span>
            <span class="button button-primary add"><?php _e('Add New Plan', 'salon'); ?></span>
            <script>
                var $ =jQuery.noConflict();
                $(document).ready(function() {
                    var count = <?php echo $i; ?>;
                    $(".add").click(function() {
                        count = count + 1;
                        $('#here').append('<p><label for="package_title">Title<input type="text" name="package['+count+'][title]" value="" id="package_title"></label><label for="package_price">Price<input type="text" name="package['+count+'][price]" value="" id="package_price"></label><span class="button button-danger remove">Remove</span></p>' );
                        return false;
                    });
                    $(".remove").live('click', function() {
                        $(this).parent().remove();
                    });
                });
            </script>
        </div>
        <?php
    }

    public function salon_package_metabox_save($post_id){

        if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'salon_package_metabox_nonce' ) ){
            return true;
        }
        if (!current_user_can("edit_post", $post_id)) {
            return $post_id;
        }
        if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) {
            return $post_id;
        }

        //save database
        $packages = $_POST['package'];
        update_post_meta($post_id,'package',$packages);

        return $post_id;
    }

}
