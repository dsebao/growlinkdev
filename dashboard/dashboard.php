<?php

/*
Template Name: User Dashboard
*/

checklogin('/login/');

global $theuser;

$idbio = getBio($theuser->ID,'id');

$databio = maybe_unserialize(get_post_meta($idbio, 'design_data',true));
$integrations = maybe_unserialize(get_post_meta($idbio, 'option_data',true));

cookieCreator($theuser->ID,$idbio);

get_header('app');
?>
	<main>
		<div class="container px-md-0">
			<div class="row">
				<div class="col-md-8">

					<form id="statebio" action="" method="post" class="mb-5">
						<div id="listLinksContainer" class="list-group">
							<?php
							$data = cleanOnlyElements(get_post_meta($idbio));
							$dataforpreview = array();
							if(!empty($data)){
								foreach ($data as $k => $j) {
									$list = maybe_unserialize($j[0]);

									//create an array for generate the preview
									$dataforpreview[] = $list;

									//Clean ID for data Sortable
									$u = str_replace('element-', '', $k);
									$inpname = 'element['.$u.']';
									if($list['type'] == 'section'){
										include(get_stylesheet_directory() . '/partials/components/backend/_sectionelement_edit.php');
									} elseif($list['type'] == 'link'){
										include(get_stylesheet_directory() . '/partials/components/backend/_linkelement_edit.php');
									} elseif($list['type'] == 'email'){
										include(get_stylesheet_directory() . '/partials/components/backend/_emailelement_edit.php');
									} elseif($list['type'] == 'social'){
										include(get_stylesheet_directory() . '/partials/components/backend/_linksocial_edit.php');
									}
								}
							}
							?>
						</div>

						<div class="addcontent mb-4 mt-md-3" data-idbiopage="<?php echo $idbio;?>">
						<div class="tap"><?php _e('Tap to add content','growlink');?></div>
					</div>

					<div class="modal fade modal-blank" id="addcontent-modal" tabindex="-1" role="dialog" aria-labelledby="addcontent-modallabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="addcontent-modallabel"><?php _e('Add content','growlink');?></h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="#999"><path d="M16.192 6.344L11.949 10.586 7.707 6.344 6.293 7.758 10.535 12 6.293 16.242 7.707 17.656 11.949 13.414 16.192 17.656 17.606 16.242 13.364 12 17.606 7.758z"/></svg>
									</button>
								</div>
								<div class="modal-body">
									<ul class="addcontent_list">
										<li>
											<a class="add-element-btn" href="#" data-type="section">
												<svg width="80px" height="80px" viewBox="0 0 80 80" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect id="Rectangle" stroke="#4137CF" stroke-width="4" x="2" y="2" width="76" height="76" rx="2"></rect><rect id="Rectangle-4" fill="#4137CF" x="8" y="35" width="64" height="9"></rect><rect id="Rectangle-4" fill="#B8B6D0" x="8" y="14" width="64" height="17"></rect><rect id="Rectangle-4" fill="#B8B6D0" x="8" y="49" width="64" height="17"></rect></g></svg>
												<?php echo __('Add a section title','growlink');?>
											</a>
										</li>
										<li>
											<a class="add-element-btn" href="#" data-type="link">
												<svg width="80px" height="80px" viewBox="0 0 80 80" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect id="Rectangle" stroke="#4137CF" stroke-width="4" x="2" y="2" width="76" height="76" rx="2"></rect><rect id="Rectangle-2" fill="#4137CF" x="6" y="26" width="25" height="25" rx="2"></rect><rect id="Rectangle-3" fill="#4137CF" x="34" y="26" width="30" height="4"></rect><rect id="Rectangle-4" fill="#B8B6D0" x="34" y="35" width="38" height="4"></rect><rect id="Rectangle-4" fill="#B8B6D0" x="34" y="41" width="38" height="4"></rect><rect id="Rectangle-4" fill="#B8B6D0" x="34" y="47" width="38" height="4"></rect></g></svg>
												<?php echo __('Add a link with an image','growlink');?>
											</a>
										</li>
										<li>
											<a class="add-element-btn" href="#" data-type="email">
												<svg width="80px" height="80px" viewBox="0 0 80 80" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect id="Rectangle" stroke="#4137CF" stroke-width="4" x="2" y="2" width="76" height="76" rx="2"></rect><rect id="Rectangle-4" fill="#4137CF" x="8" y="30" width="64" height="4"></rect><rect id="Rectangle-4" fill="#4137CF" x="8" y="37" width="64" height="4"></rect><rect id="Rectangle-4" fill="#4137CF" x="8" y="44" width="64" height="4"></rect></g></svg>
												<?php echo __('Add an email suscription (MailChimp)','growlink');?>
											</a>
										</li>
										<li>
											<a class="add-element-btn" href="#" data-type="social">
												<svg width="80px" height="80px" viewBox="0 0 80 80" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect id="Rectangle" stroke="#4137CF" stroke-width="4" x="2" y="2" width="76" height="76" rx="2"></rect><rect id="Rectangle-2" fill="#4137CF" x="6" y="26" width="25" height="25" rx="2"></rect><rect id="Rectangle-3" fill="#4137CF" x="34" y="26" width="30" height="4"></rect><rect id="Rectangle-4" fill="#B8B6D0" x="34" y="35" width="38" height="4"></rect><rect id="Rectangle-4" fill="#B8B6D0" x="34" y="41" width="38" height="4"></rect><rect id="Rectangle-4" fill="#B8B6D0" x="34" y="47" width="38" height="4"></rect></g></svg>
												<?php echo __('Add a social or messaging account','growlink');?>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>

					<div class="savesection">
						<input type="hidden" name="idbio" value="<?php echo $idbio;?>">
						<input type="hidden" name="action" value="sendform">
						<input type="hidden" name="typeform" value="saveState">
						<input type="hidden" id="order-elements" name="order" value="">
						<button class="btn btn-lg btn-primary" type="submit"><?php echo __('Save and preview','growlink');?></button>
					</div>
				</form>


				</div>
				<?php if(!wp_is_mobile()){?>

				<div class="col-md-4 d-none d-md-block">
					<div class="sticky">
						<div id="preview" class="px-md-3 pt-md-0 mb-5">
							<div class="phonewrap">
								<div class="notch"></div>
								<div class="screenpage" id="fireLoaderPreview">
									<p class="text-center text-gray py-5"><?php _e('Save to see the preview','growlink');?></p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php }?>
			</div>
		</div>
	</main>

	<script>
		<?php $dataforpreview = array_sort($dataforpreview, 'position', SORT_ASC);?>
		var dataelements = <?php echo json_encode($dataforpreview);?>;
		var design = <?php echo json_encode($databio);?>;
		var avatar = "<?php echo get_avatarimg_url(get_avatar(intval($theuser->ID),100));?>";
		var integrations = <?php echo json_encode($integrations);?>;
	</script>

<?php get_footer('app');?>