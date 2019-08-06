<div class="list-element element-section list-group-item mb-4" data-id="<?php echo $u;?>">
	<div class="leftdrag">
		<i class="fa-fw fas fa-ellipsis-v"></i>
	</div>
	<div class="elements">
		<div class="titlecard"><?php _e('Section title','growlink');?></div>
		<div class="row">
			<div class="col-md-10">
				<div class="form-group">
					<input type="text" maxlength="20" class="form-control maxlenght" name="<?php echo $inpname;?>[title]" value="<?php echo $list['title'];?>" placeholder="<?php _e('Add a title section (20 characters)','growlink');?>">
				</div>
			</div>
			<div class="col-md-2">
				<input type="checkbox" class="toggle" value="yes" name="<?php echo $inpname;?>[active]" <?php echo (isset($list['active']) && $list['active'] == 'yes') ? "checked" : "";?>>
			</div>
		</div>
		<input type="hidden" value="section" name="<?php echo $inpname;?>[type]">
		<input type="hidden" value="position" name="<?php echo $inpname;?>[position]">
		<?php actionBtn('section','');?>
	</div>
</div>