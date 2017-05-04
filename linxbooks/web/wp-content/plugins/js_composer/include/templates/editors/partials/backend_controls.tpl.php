<div class="vc_controls<?php echo !empty($extended_css) ? ' '.$extended_css : '' ?>">
	<div class="vc_controls-<?php echo $position ?>">
		<a class="vc_control-btn vc_element-name vc_element-move">
				<span class="vc_btn-content"
				      title="<?php printf( __( 'Drag to move %s', 'js_composer' ), $name ) ?>"><?php echo __( $name, 'js_composer' ); ?></span>
		</a>
		<?php foreach($controls as $control): ?>
		<?php if($control === 'add'): ?>
		<a class="vc_control-btn vc_control-btn-prepend vc_edit" href="#"
		   title="<?php printf( __( 'Prepend to %s', 'js_composer' ), $name ) ?>"><span
		  class="vc_btn-content"><span class="icon"></span></span></a>
		<?php elseif($control === 'edit'): ?>
			<a class="vc_control-btn vc_control-btn-edit" href="#"
		   title="<?php printf( __( 'Edit %s', 'js_composer' ), $name ) ?>"><span
		  class="vc_btn-content"><span class="icon"></span></span></a>
		<?php elseif($control === 'clone'): ?>
		<a class="vc_control-btn vc_control-btn-clone" href="#"
		   title="<?php printf( __( 'Clone %s', 'js_composer' ), $name ) ?>"><span
		  class="vc_btn-content"><span class="icon"></span></span></a>
		<?php elseif($control === 'delete'): ?>
		<a class="vc_control-btn vc_control-btn-delete" href="#"
		   title="<?php printf( __( 'Delete %s', 'js_composer' ), $name ) ?>"><span
		  class="vc_btn-content"><span class="icon"></span></span></a>
		<?php endif; ?>
  		<?php endforeach; ?>
	</div>
</div>