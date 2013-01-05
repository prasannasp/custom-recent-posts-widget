<?php
class CRPW_Tags_Widget extends WP_Widget {
			
	function __construct() {
    	$widget_ops = array(
			'classname'   => 'widget_recent_entries', 
			'description' => __('Display a list of recent post entries from one or more Tags. You can choose the number of posts to show.')
		);
    	parent::__construct('recent-posts-by-tags', __('Custom Recent Posts by Tags'), $widget_ops);
	}

	function widget($args, $instance) {
           
			extract( $args );
		
			$title = apply_filters( 'widget_title', empty($instance['title']) ? 'Recent Posts' : $instance['title'], $instance, $this->id_base);
			$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;	
			
			if ( ! $number = absint( $instance['number'] ) ) $number = 5;
						
			if( ! $tags = $instance["tags"] )  $tags='';
			
						
			// array to call recent posts.
			
			$crpw_tag_args=array(
						   
				'showposts' => $number,
				'tag__in'=> $tags,
															
				);
			
			$crpw_tag_widget = null;
			$crpw_tag_widget = new WP_Query($crpw_tag_args);
			
			
			echo $before_widget;
			
			
			// Widget title
			
			echo $before_title;
			echo $instance["title"];
			echo $after_title;
			
			// Post list in widget
			
			echo "<ul>\n";
			
		while ( $crpw_tag_widget->have_posts() )
		{
			$crpw_tag_widget->the_post();
		?>

			<li class="crpw-tag-item">

				<a  href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent link to <?php the_title_attribute(); ?>" class="crpw-tag-title"><?php the_title(); ?></a>
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
        	$instance['tags'] = $new_instance['tags'];
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
            <label for="<?php echo $this->get_field_id('tags'); ?>"><?php _e('Select Tags to include in the recent posts list:');?> 
            
                <?php
                   $tags =  get_tags('hide_empty=0');
                     echo "<br/>";
                     foreach ($tags as $tag) {
                         $option='<input type="checkbox" id="'. $this->get_field_id( 'tags' ) .'[]" name="'. $this->get_field_name( 'tags' ) .'[]"';
                            if (is_array($instance['tags'])) {
                                foreach ($instance['tags'] as $tags) {
                                    if($tags==$tag->term_id) {
                                         $option=$option.' checked="checked"';
                                    }
                                }
                            }
                            $option .= ' value="'.$tag->term_id.'" />';
                            $option .= '&nbsp;';
                            $option .= $tag->name . ' ';
                            $option .= '<br />';
                            echo $option;
                         }
                    
                    ?>
            </label>
        </p>
        
<?php
	}
}

function crpw_tag_register_widget() {
	register_widget( 'CRPW_Tags_Widget' );
}

add_action( 'widgets_init', 'crpw_tag_register_widget' );
?>
