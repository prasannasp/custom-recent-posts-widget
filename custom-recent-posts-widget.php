<?php
/*
Plugin Name: Custom Recent Posts Widget
Plugin URI: http://www.prasannasp.net/custom-recent-posts-widget
Description: Displays a list of recent posts from multiple categories or from a single category in widgetized areas. You can select the number of posts to display in widget settings. Widget title can be changed.
Version: 1.0
Author: Prasanna SP
Author URI: http://www.prasannasp.net/
*/

/*  Copyright 2012  Prasanna SP  (email : prasanna@prasannasp.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

include_once( 'includes/crpw-style.php' );

class Custom_Recent_Posts_Widget extends WP_Widget {
			
	function __construct() {
    	$widget_ops = array(
			'classname'   => 'custom_recent_posts_widget', 
			'description' => __('Display a list of recent post entries from one or more categories. You can choose the number of posts to show.')
		);
    	parent::__construct('custom-recent-posts', __('Custom Recent Posts'), $widget_ops);
	}


	function widget($args, $instance) {
           
			extract( $args );
		
			$title = apply_filters( 'widget_title', empty($instance['title']) ? 'Recent Posts' : $instance['title'], $instance, $this->id_base);	
			
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

			<li class="recent-post-item">

				<a  href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent link to <?php the_title_attribute(); ?>"class="post-title"><?php the_title(); ?></a>
		
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
	     
        		return $instance;
	}
	
	
	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : 'Recent Posts';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
		
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
                  

                        
        <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
        <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
        
        
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

// register Custom_Recent_Posts_Widget
add_action( 'widgets_init', create_function( '', 'return register_widget("Custom_Recent_Posts_Widget");' ) );
?>