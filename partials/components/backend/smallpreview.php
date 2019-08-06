<?php
$databio = maybe_unserialize(get_post_meta($idbio, 'design_data',true));
$integrations = maybe_unserialize(get_post_meta($idbio, 'option_data',true));
?>
<main id="profile-page-user" class="py-4 <?php echo $databio['site-color-theme'];?>" data-idlanding="<?php echo $idbio;?>">
	<div class="cover"></div>
	<div class="container">
		<div class="row">
			<div class="text-center col-md-12 mx-auto mb-3">
				<div class="avatar mb-3">
                    <img src="<?php echo get_avatarimg_url(get_avatar($theuser->ID));?>" width="100" height="100" alt="<?php echo $theuser->display_name;?>">
                </div>
                <div class="name">
					<?php echo $databio['site-title'];?>
                </div>
                <div class="smallbio lead">
					<?php echo $databio['site-intro'];?>
                </div>
			</div>
		</div>
	</div>

	<section class="links-card <?php echo $databio['site-gridtype'];?>">
		<div class="container">
			<div class="row">
				<div class="col-md-12 mx-auto">
					<div class="maingridparent">
					<?php

					$data = cleanOnlyElements(get_post_meta($idbio));
					$neworder = reorderLinksPosition($data);

					if(!empty($neworder)){
						foreach ($neworder as $list) {

							if($list['type'] == 'section' && isset($list['active']) && $list['active'] == 'yes'){
							} elseif($list['type'] == 'link' && isset($list['active']) && $list['active'] == 'yes'){
								include(get_stylesheet_directory() . '/partials/components/front/front_link_card.php');
							} elseif($list['type'] == 'email' && isset($list['active']) && $list['active'] == 'yes'){
								if($integrations['option-mailchimp'] != '' && $integrations['option-mailchimp-list'] != '')
									include(get_stylesheet_directory() . '/partials/components/front/front_email_card.php');
							} elseif($list['type'] == 'social' && isset($list['active']) && $list['active'] == 'yes'){
								include(get_stylesheet_directory() . '/partials/components/front/front_social_card.php');
							}

						}
					}?>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>


