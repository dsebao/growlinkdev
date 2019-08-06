<div class="list-element element-news list-group-item mb-4" data-id="<?php echo $u;?>">
	<div class="leftdrag">
		<i class="fa-fw fas fa-ellipsis-v"></i>
	</div>
	<div class="elements">
		<div class="titlecard"><?php _e('Email suscription','growlink');?></div>
		<div class="row">
			<div class="col-md-10">
				<div class="form-group">
					<input type="text" class="form-control maxlenght" name="<?php echo $inpname;?>[title]" maxlength="20" value="<?php echo $list['title'];?>" placeholder="<?php _e('Email subscription title (20 characters)','growlink');?>">
					<span class="chars-remaining"></span>
				</div>
				<div class="form-group">
					<input type="text" maxlength="70" class="form-control maxlenght" name="<?php echo $inpname;?>[description]" value="<?php echo $list['description'];?>" placeholder="<?php _e('Email subscription description (70 characters)','growlink');?>">
				</div>
			</div>
			<div class="col-md-2">
				<input type="checkbox" class="toggle emailToggleCard" value="yes" name="<?php echo $inpname;?>[active]" <?php echo (isset($list['active']) && $list['active'] == 'yes') ? "checked" : "";?>>
			</div>
		</div>
		<input type="hidden" value="email" name="<?php echo $inpname;?>[type]">

		<?php $star = (isset($list['starred'])) ? $list['starred'] : "";?>
		<?php actionBtn('',$star);?>

		<div class="alert-mailapi alert alert-success mb-0 alert-dismissible fade show" style="display:none" role="alert">
			<?php echo sprintf(__('<small>Remember to define MAILCHIMP API KEY and LIST ID in <a class="alert-link" href="%s">Integrations</a> page.</small>','growlink'),get_bloginfo('url') . "/dashboard/integrations/");?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    			<span aria-hidden="true">&times;</span>
  			</button>
		</div>
		<div class="datapanel"></div>
	</div>
</div>