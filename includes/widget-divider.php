<?php/** * Divider Widget * Used to add a new row of widgets. * * @since 0.1 */class Scroller_Widget_Divider extends WP_Widget {	function Scroller_Widget_Divider() {		$widget_ops = array( 'description' => __( 'New row of widgets' ) );		$this->WP_Widget( "scroller-divider", __( 'Area Scroller :: Divider' ), $widget_ops, null );	}	function widget( $args, $instance ) {		echo '</div><div class="item">';	}	function update( $new_instance, $old_instance ) {		$instance = $old_instance;		return $instance;	}	function form( $instance ) { ?>	<?php }}