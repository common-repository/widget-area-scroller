<div class="wrap">
	<?php screen_icon() ?>
	<h2>Widget Area Scroller</h2>
	<form method="post" action="">
		<?php if( ! empty( $wp_registered_sidebars ) ) : foreach( $wp_registered_sidebars as $area ) : ?>
			<?php $active = in_array( $area['id'], $this->areas ) ? true : false; ?>
			<div class="area">
				<h4><label><input type="checkbox" name="areas[]" value="<?php echo $area['id'] ?>" <?php checked( $active, true ) ?> /> <?php echo $area['name'] ?></label></h4>
				<div class="area-options" style="display: <?php echo ( $active ) ? 'block' : 'none'; ?>">
					Panels height: <input type="text" class="small-text" name="config[<?php echo $area['id'] ?>][height]" value="<?php echo $this->options[$area['id']]['height'] ?>" /> px
				</div>
			</div>
		<?php endforeach; endif; ?>
		<?php submit_button() ?>
	</form>
</div><!-- .wrap -->