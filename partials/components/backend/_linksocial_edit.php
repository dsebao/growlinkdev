<div class="list-element element-social list-group-item mb-4" data-id="<?php echo $u;?>">
	<div class="leftdrag">
		<i class="fa-fw fas fa-ellipsis-v"></i>
	</div>
	<div class="elements">
		<div class="titlecard"><?php _e('Social link','growlink');?></div>
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<select name="<?php echo $inpname;?>[socialtype]" class="form-control"  data-e="<?php echo $u;?>">
								<?php createOption(array('facebook' => 'Facebook','twitter' => 'Twitter','whatsapp' => 'WhatsApp','instagram' => 'Instagram','spotify'=>'Spotify','youtube' => 'YouTube','twitch' => 'Twitch','telegram' => 'Telegram','vk' => 'VK','snapchat' => 'Snapchat'),$list['socialtype']);?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<input type="text" class="form-control" name="<?php echo $inpname;?>[username]" value="<?php echo $list['username'];?>" placeholder="<?php _e('Your username or number','growlink');?>">
						</div>
					</div>
					<div class="col-md-2 text-right">
						<input type="checkbox" class="toggle" value="yes" name="<?php echo $inpname;?>[active]" <?php echo (isset($list['active']) && $list['active'] == 'yes') ? "checked" : "";?>>
					</div>
				</div>
				<input type="hidden" value="social" name="<?php echo $inpname;?>[type]">
				<input type="hidden" value="<?php echo $list['position'];?>" name="<?php echo $inpname;?>[position]">
				<?php $star = (isset($list['starred'])) ? $list['starred'] : "";?>
				<?php actionBtn('',$star);?>
			</div>
		</div>
		<div class="datapanel"></div>
	</div>
</div>