<div class="list-element element-social list-group-item mb-4" data-id="">
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
							<select name="socialtype" class="form-control"  data-e="<?php echo $e;?>">
								<?php createOption(array('facebook' => 'Facebook','twitter' => 'Twitter','whatsapp' => 'WhatsApp','instagram' => 'Instagram','spotify' => 'Spotify','youtube' => 'YouTube','twitch' => 'Twitch','telegram' => 'Telegram','vk' => 'VK','snapchat' => 'Snapchat'));?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<input type="text" class="form-control" name="username" value="" placeholder="<?php _e('Your username or number','growlink');?>" data-e="<?php echo $e;?>">
						</div>
					</div>
					<div class="col-md-2 text-right">
						<input type="checkbox" class="toggle" name="active" value="yes" data-e="<?php echo $e;?>">
					</div>
				</div>
				<input type="hidden" value="social" name="type" data-e="<?php echo $e;?>">
				<?php actionBtn('social');?>
			</div>
		</div>
	</div>
</div>