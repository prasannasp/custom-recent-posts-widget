<?php
class Custom_Recent_Posts_Widget extends WP_Widget {
			
	function __construct() {
    	$widget_ops = array(
			'classname'   => 'widget_recent_entries', 
			'description' => __('Display a list of recent post entries from one or more categories. You can choose the number of posts to show.')
		);
    	parent::__construct('custom-recent-posts', __('Custom Recent Posts'), $widget_ops);
	}

	function widget($args, $instance) {
           
			extract( $args );
		
			$title = apply_filters( 'widget_title', empty($instance['title']) ? 'Recent Posts' : $instance['title'], $instance, $this->id_base);	
			$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
			
			if ( ! $number = absint( $instance['number'] ) ) $number = 5;
						
			if( ! $cats = $instance["cats"] )  $cats='';
					
			// array to call recent posts.
			
			$crpw_args=array(
						   
				'showposts' => $number,
				'category__in'=> $cats,
				);
			
			$crp_widget = null;
			$crp_widget = new WP_Query($crpw_args);
			
			echo $before_widget;
			
			// Widget title
			
			echo $before_title;
			echo $instance["title"];
			echo $after_title;
			
			// Post list in widget
			
			echo "<ul>\n";
			
		while ( $crp_widget->have_posts() )
		{
			$crp_widget->the_post();
		?>
			<li class="crpw-item">

				<a  href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent link to <?php the_title_attribute(); ?>" class="crpw-title"><?php the_title(); ?></a>
				<?php if ( $show_date ) : ?>
				<span class="crpw-date"><?php echo "("; ?><?php echo get_the_date(); ?><?php echo ")"; ?></span>
			<?php endif; ?>
		
			</li>
		<?php

		}

		 wp_reset_query();

		echo "</ul>\n";
		echo $after_widget;

	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
        	$instance['cats'] = $new_instance['cats'];
		$instance['number'] = absint($new_instance['number']);
		$instance['show_date'] = (bool) $new_instance['show_date'];
	     
        		return $instance;
	}
	
	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : 'Recent Posts';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
		
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
                        
        <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
        <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
        
        <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
        
         <p>
            <label for="<?php echo $this->get_field_id('cats'); ?>"><?php _e('Select categories to include in the recent posts list:');?> 
            
                <?php
                   $categories=  get_categories('hide_empty=0');
                     echo "<br/>";
                     foreach ($categories as $cat) {
                         $option='<input type="checkbox" id="'. $this->get_field_id( 'cats' ) .'[]" name="'. $this->get_field_name( 'cats' ) .'[]"';
                            if (is_array($instance['cats'])) {
                                foreach ($instance['cats'] as $cats) {
                                    if($cats==$cat->term_id) {
                                         $option=$option.' checked="checked"';
                                    }
                                }
                            }
                            $option .= ' value="'.$cat->term_id.'" />';
			    $option .= '&nbsp;';
                            $option .= $cat->cat_name;
                            $option .= '<br />';
                            echo $option;
                         }
                    
                    ?>
            </label>
        </p>
        
<?php
	}
}

function crpw_register_widgets() {
	register_widget( 'Custom_Recent_Posts_Widget' );
}

add_action( 'widgets_init', 'crpw_register_widgets' );
?>
