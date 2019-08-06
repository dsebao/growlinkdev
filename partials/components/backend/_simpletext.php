<div class="list-element element-text list-group-item mb-4" data-id="">
	<div class="leftdrag">
		<i class="fa-fw fas fa-ellipsis-v"></i>
	</div>
	<div class="elements">
		<div class="titlecard"><?php _e('Text box','growlink');?></div>
		<div class="row">
			<div class="col-md-10">
				<div class="form-group">
					<input type="text" maxlength="20" class="form-control maxlenght" name="title" value="" placeholder="<?php _e('Add a title (20 characters)','growlink');?>" data-e="<?php echo $e;?>">
				</div>
				<div class="form-group">
					<input type="text" maxlength="70" class="form-control maxlenght" name="text" value="" placeholder="<?php _e('Add a text (70 characters)','growlink');?>" data-e="<?php echo $e;?>">
				</div>
			</div>
			<div class="col-md-2">
				<input type="checkbox" class="toggle" name="active" value="yes" data-e="<?php echo $e;?>">
			</div>
		</div>
		<input type="hidden" value="text" name="type" data-e="<?php echo $e;?>">
		<?php actionBtn('text');?>
	</div>
</div>