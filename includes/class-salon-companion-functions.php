<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://keendevs.com
 * @since      1.0.0
 */
class Salon_Companion_Functions {
	/**
     * Retrieves the image field.
     *  
     * @link https://pippinsplugins.com/retrieve-attachment-id-from-image-url/
     */
    function salon_companion_get_image_field( $id, $name, $image, $label ){
        $output = '';
        $output .= '<div class="widget-upload">';
        $output .= '<label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label><br/>';
        $output .= '<input id="' . esc_attr( $id ) . '" class="salon-upload" type="hidden" name="' . esc_attr( $name ) . '" value="' . esc_attr( $image ) . '" placeholder="' . __('No file chosen', 'salon-companion') . '" />' . "\n";
        if ( function_exists( 'wp_enqueue_media' ) ) {
            if ( $image == '' ) {
                $output .= '<input id="upload-' . esc_attr( $id ) . '" class="salon-upload-button button" type="button" value="' . __('Upload', 'salon-companion') . '" />' . "\n";
            } else {
                $output .= '<input id="upload-' . esc_attr( $id ) . '" class="salon-upload-button button" type="button" value="' . __('Change', 'salon-companion') . '" />' . "\n";
            }
        } else {
            $output .= '<p><i>' . __('Upgrade your version of WordPress for full media support.', 'salon-companion') . '</i></p>';
        }

        $output .= '<div class="salon-screenshot" id="' . esc_attr( $id ) . '-image">' . "\n";

        if ( $image != '' ) {
            $remove = '<a class="salon-remove-image">'.__('Remove Image','salon-companion').'</a>';
            $attachment_id = $image;
            $image_url = wp_get_attachment_image_url( $attachment_id, 'full');
            $image = preg_match('/(^.*\.jpg|jpeg|png|gif|ico*)/i', $image_url);
            if ( $image ) {
                $output .= '<img src="' . esc_url( $image_url ) . '" alt="" />' . $remove;
            } else {
                // Standard generic output if it's not an image.
                $output .= '<small>' . __( 'Please upload valid image file.', 'salon-companion' ) . '</small>';
            }     
        }
        $output .= '</div></div>' . "\n";
        
        echo $output;
    }

	/**
	 * Get all the registered image sizes along with their dimensions
	 *
	 * @global array $_wp_additional_image_sizes
	 *
	 * @link http://core.trac.wordpress.org/ticket/18947 Reference ticket
	 * @return array $image_sizes The image sizes
	 */
	function salon_get_all_image_sizes() {
		global $_wp_additional_image_sizes;
		$default_image_sizes = array( 'thumbnail', 'medium', 'large', 'full' );
		 
		foreach ( $default_image_sizes as $size ) {
			$image_sizes[$size]['width']	= intval( get_option( "{$size}_size_w") );
			$image_sizes[$size]['height'] = intval( get_option( "{$size}_size_h") );
			$image_sizes[$size]['crop']	= get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
		}
		
		if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) )
			$image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
			
		return $image_sizes;
	}
}
new Salon_Companion_Functions;