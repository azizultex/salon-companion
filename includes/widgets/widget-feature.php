<?php
/**
 * Feature Widget
 *
 * @package Salon_Companion
 */

// register RaraTheme_Companion_Testimonial_Widget widget
function salon_register_feature_widget(){
    register_widget( 'Salon_Companion_feature_Widget' );
}
add_action('widgets_init', 'salon_register_feature_widget');
 
 /**
 * Adds Salon_Companion_feature_Widget widget.
 */
class Salon_Companion_feature_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'salon_feature_widget', // Base ID
            __( 'Salon: Feature', 'salon-companion' ), // Name
            array( 'description' => __( 'A Feature Widget.', 'salon-companion' ), ) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        
        $obj         = new Salon_Companion_Functions();
        $image       = ! empty( $instance['image'] ) ? $instance['image'] : '';
        $title        = ! empty( $instance['title'] ) ? $instance['title'] : '' ;               
        $description = ! empty( $instance['description'] ) ? $instance['description'] : '';

        if( $image ) {
            $attachment_id = $image;
        }
        
        // echo $args['before_widget'];
        ob_start(); 
        ?>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="featured-item">
                <?php if( $image ){ ?>
                <div class="icon pull-left">
					<?php echo wp_get_attachment_image( $attachment_id, 'full', false, array( 'class' => 'img-responsive', 'alt' => esc_attr( $title ))) ;?>
				</div>
                <?php }?>

                <div class="text">
                	<?php if ($title): ?>
						<h5 class="title"><?php echo $title; ?></h5>
                	<?php endif ?>

                	<?php if ($description): ?>
						<?php echo wpautop( wp_kses_post( $description ) ); ?>
                	<?php endif ?>
				</div>
            </div>
        </div>
        <?php 
        $html = ob_get_clean();
        echo apply_filters( 'salon_companion_feature_widget_filter', $html, $args, $instance );   
        // echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        
        $obj         = new Salon_Companion_Functions();
        $image       = ! empty( $instance['image'] ) ? $instance['image'] : '';
        $title        = ! empty( $instance['title'] ) ? $instance['title'] : '' ;        
        $description = ! empty( $instance['description'] ) ? $instance['description'] : '';
        ?>
        <p>
        	<?php 
        		$obj->salon_companion_get_image_field( 
        			$this->get_field_id( 'image' ), 
        			$this->get_field_name( 'image' ), 
        			$image, __( 'Upload Image', 'salon-companion' ) 
        		); 
        	?>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'salon-companion' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />            
        </p>
        
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'Feature', 'salon-companion' ); ?></label>
            <textarea name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php print $description; ?></textarea>
        </p>
        
        <?php
    }
    
    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance                = array();
        
        $instance['image']       = ! empty( $new_instance['image'] ) ? esc_attr( $new_instance['image'] ) : '';
        $instance['title']        = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '' ;
        $instance['description'] = ! empty( $new_instance['description'] ) ? wp_kses_post( $new_instance['description'] ) : '';
        
        return $instance;
    }
    
}  // class Salon_Companion_feature_Widget / class Salon_Companion_feature_Widget 