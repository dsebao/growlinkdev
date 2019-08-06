<div class="list-element element-section list-group-item mb-4" data-id="">
	<div class="leftdrag">
		<i class="fa-fw fas fa-ellipsis-v"></i>
	</div>
	<div class="elements">
		<div class="titlecard"><?php _e('Section title','growlink');?></div>
		<div class="row">
			<div class="col-md-10">
				<div class="form-group">
					<input type="text" maxlength="20" class="form-control maxlenght" name="title" value="" placeholder="<?php _e('Add a title section (20 characters)','growlink');?>" data-e="<?php echo $e;?>">
				</div>
			</div>
			<div class="col-md-2">
				<input type="checkbox" class="toggle" name="active" value="yes" data-e="<?php echo $e;?>">
			</div>
		</div>
		<input type="hidden" value="section" name="type" data-e="<?php echo $e;?>">
		<?php actionBtn('section');?>
	</div>
</div>