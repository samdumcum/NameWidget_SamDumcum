<?php
/*
	Plugin Name: Name Widget
	Description: A widget for adding your name in a sidebar.
	Plugin URI: https://gist.github.com/JLeuze/475bdd6bd6095b7bdf7c
	Author: Josh Leuze edited by Sam Dumcum
	Author URI: http://www.samdumcum.com/
	License: GPL2
	Version: 1.0
*/

/**
 * Adds Name widget with modifications (this is the Widget Class); self contained class you're reusing.
 	Creating your unique name / prefix for your functions.
 	Making a unique version of the WP Widget
 */
class JL_Name_Widget extends WP_Widget {

    /**
     * Register widget with WordPress so that it can be called later from Plugins.
     	This sets up the options for the widget
     */
    function __construct() {
        parent::__construct(
            'name', // Base ID - name (for when you drag widget in) - part of class 'name' so you could style all "name" widgets
            __('Name Widget', 'jl_name_widget'), // Name 
            array( 'description' => __( 'A widget for adding your name.', 'jl_name_widget' ), ) // Args (description of what the widget is, and its name, the array puts them in a list)
        );
    }

    /**
     * Front-end display of widget - These are parameters we are establishing that we want displayed
     * 
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        $jl_name = apply_filters( 'widget_title', $instance['jl_name'] );
        $jl_last = apply_filters( 'widget_title', $instance['jl_last'] );
        $jl_age = apply_filters( 'widget_title', $instance['jl_age'] );

		/* This section creates the form display
		*/
		/* echoing things out in the 'before' and after widget between front and back end
			Established in functions.php
		*/
		// the span or ' ' sections in 'before_title' is to help with styling so you can determine if you want H2 or 3 tags, etc
        echo $args['before_widget'];
            echo $args['before_title'] . '<span>First Name</span> (people call me)' . $args['after_title'];
           	//  if the jl name is not empty, we're going to output it in a paragraph
            if ( ! empty( $jl_name ) ) {
                echo '<p>' . $jl_name . '</p>';
            }    
            echo $args['before_title'] . '<span>Last Name</span> (my real name is)' . $args['after_title'];
            if ( ! empty( $jl_last ) ) {
                echo '<p>' . $jl_last . '</p>';
            } 
            echo $args['before_title'] . '<span>Age</span> (Ive lived under the sea for)' . $args['after_title'];
            if ( ! empty( $jl_age ) ) {
                echo '<p>' . $jl_age . '</p>';    
                
            }
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
    	// setting the default name - checking to see if there's already a name option, then that will be loaded
        if ( isset( $instance[ 'jl_name' ] ) ) {
            $jl_name = $instance[ 'jl_name' ];
        }
        // if there's no name 'jl_name' called then 'Batman'  will be loaded (same for all)
        else {
            $jl_name = __( 'Batman', 'jl_name_widget' );
        }
        
        
        if ( isset( $instance[ 'jl_last' ] ) ) {
            $jl_last = $instance[ 'jl_last' ];
        }
        else {
            $jl_last = __( 'Dark Knight', 'jl_name_widget' );
        }
        
        if ( isset( $instance[ 'jl_age' ] ) ) {
            $jl_age = $instance[ 'jl_age' ];
        }
        else {
            $jl_age = __( 'None of Your Business', 'jl_name_widget' );
        }
        
        ?>
        <p>
        <!-- second part of form; the echo calls the jl_name field. the _e translates the text to print out the label field that you'll see on the back end and put your name into -->
        <label for="<?php echo $this->get_field_id( 'jl_name' ); ?>"><?php _e( 'Name:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'jl_name' ); ?>" name="<?php echo $this->get_field_name( 'jl_name' ); ?>" type="text" value="<?php echo esc_attr( $jl_name ); ?>">
        </p>
          <p>
        <!-- echo prints the get field id (pulls the 'jl_last'), prints last, creates the label field and makes the typing area, "text" allows text with the attributes of jl_last -->
        <label for="<?php echo $this->get_field_id( 'jl_last' ); ?>"><?php _e( 'Last:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'jl_last' ); ?>" name="<?php echo $this->get_field_name( 'jl_last' ); ?>" type="text" value="<?php echo esc_attr( $jl_last ); ?>">
        </p>
         <p>
        <label for="<?php echo $this->get_field_id( 'jl_age' ); ?>"><?php _e( 'Age:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'jl_age' ); ?>" name="<?php echo $this->get_field_name( 'jl_age' ); ?>" type="text" value="<?php echo esc_attr( $jl_age ); ?>">
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
     
     	Stripped tags removes any bad content
     */
 
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['jl_name'] = ( ! empty( $new_instance['jl_name'] ) ) ? strip_tags( $new_instance['jl_name'] ) : '';
        $instance['jl_last'] = ( ! empty( $new_instance['jl_last'] ) ) ? strip_tags( $new_instance['jl_last'] ) : '';
        $instance['jl_age'] = ( ! empty( $new_instance['jl_age'] ) ) ? strip_tags( $new_instance['jl_age'] ) : '';


        return $instance;
    }

} // class JL_Name_Widget

// register Name widget
function jl_register_name_widget() {
    register_widget( 'JL_Name_Widget' );
}
add_action( 'widgets_init', 'jl_register_name_widget' );
 
?>    