<div class="list-element element-news list-group-item mb-4" data-id="">
	<div class="leftdrag">
		<i class="fa-fw fas fa-ellipsis-v"></i>
	</div>
	<div class="elements">
		<div class="titlecard"><?php _e('Email suscription','growlink');?></div>
		<div class="row">
			<div class="col-md-10">
				<div class="form-group">
					<input type="text" class="form-control maxlenght" name="title" value="" maxlength="20" placeholder="<?php _e('Email subscription title (20 characters)','growlink');?>" data-e="<?php echo $e;?>">
				</div>
				<div class="form-group">
					<input type="text" class="form-control maxlenght" name="description" value="" maxlength="70" placeholder="<?php _e('Email subscription description (70 characters)','growlink');?>" data-e="<?php echo $e;?>">
				</div>
			</div>
			<div class="col-md-2">
				<input type="checkbox" name="active" class="toggle emailToggleCard" value="yes" data-e="<?php echo $e;?>">
			</div>
		</div>
		<input type="hidden" value="email" name="type" data-e="<?php echo $e;?>">
		<?php actionBtn('email');?>

		<div class="alert-mailapi alert alert-success mb-0 alert-dismissible fade show" style="display:none" role="alert">
			<small><?php echo sprintf(__('Remember to define MAILCHIMP API KEY and LIST ID in <a class="alert-link" href="%s">Integrations</a> page.','growlink'),get_bloginfo('url') . "/dashboard/integrations/");?></small>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    			<span aria-hidden="true">&times;</span>
  			</button>
		</div>
		<div class="datapanel"></div>
	</div>
</div>