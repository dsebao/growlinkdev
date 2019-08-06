<?php

//Get the header
get_header('bio');

//Loop over landing info
if (have_posts()) : while (have_posts()) : the_post();

	//Get the design style
	$databio = maybe_unserialize(get_post_meta($post->ID, 'design_data',true));
	$integrations = maybe_unserialize(get_post_meta($post->ID, 'option_data',true));

	//Define the Bio ID person
	$userpost = $post->post_author;

?>
<main id="profile-page-user" class="py-4 <?php echo $databio['site-hero'];?> <?php echo $databio['site-herodata'];?>" data-idlanding="<?php echo $post->ID;?>">
	<div class="cover"></div>
	<div class="container">
		<div class="row">
			<div class="text-center col-md-6 mx-auto mb-3 mb-md-5">
				<div class="avatar mb-3">
                    <img class="site-border" src="<?php echo get_avatarimg_url(get_avatar(intval($post->post_author),100));?>" width="100" height="100" alt="<?php echo $theuser->display_name;?>">
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

	<section class="links-card <?php echo $databio['site-viewdesign'];?>">
		<div class="container">
			<div class="row">
				<div class="col-md-6 mx-auto">
					<div class="maingridparent">
					<?php

					$data = cleanOnlyElements(get_post_meta($post->ID));
					$neworder = reorderLinksPosition($data);

					if(!empty($neworder)){
						foreach ($neworder as $list) {

							if($list['type'] == 'section' && isset($list['active']) && $list['active'] == 'yes'){
								include(get_stylesheet_directory() . '/partials/components/front/front_section_card.php');
							} elseif($list['type'] == 'link' && isset($list['active']) && $list['active'] == 'yes'){
								include(get_stylesheet_directory() . '/partials/components/front/front_link_card.php');
							} elseif($list['type'] == 'email' && isset($list['active']) && $list['active'] == 'yes'){
								if($integrations['option-mailchimp'] != '' && $integrations['option-mailchimp-list'] != '')
									include(get_stylesheet_directory() . '/partials/components/front/front_email_card.php');
							} elseif($list['type'] == 'social' && isset($list['active']) && $list['active'] == 'yes'){
								include(get_stylesheet_directory() . '/partials/components/front/front_social_card.php');
							} elseif($list['type'] == 'text' && isset($list['active']) && $list['active'] == 'yes'){
								include(get_stylesheet_directory() . '/partials/components/front/front_text_card.php');
							}
						}
					}?>
					</div>
				</div>
			</div>
			<div class="text-center">
				<?php
				$aff_id = affwp_get_affiliate_id($userpost);?>
				<p><?php _e('Powered by','growlink');?> <a href="<?php bloginfo('url');?>/signup?ref=<?php echo $aff_id;?>">Growlink</a></p>
			</div>
		</div>
	</section>
</main>
<?php endwhile; endif;?>

<?php

//Save the visitor data to db
addvisitor($post->ID);

get_footer('bio');?>