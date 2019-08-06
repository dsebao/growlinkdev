<?php

/*
Template Name: User Design
*/

checklogin('/login/');

global $theuser;

$idbio = getBio($theuser->ID,'id');
$databio = maybe_unserialize(get_post_meta($idbio, 'design_data',true));
$integrations = maybe_unserialize(get_post_meta($idbio, 'option_data',true));

$data = cleanOnlyElements(get_post_meta($idbio));
$dataforpreview = array();
if(!empty($data)){
	foreach ($data as $k => $j) {
		$list = maybe_unserialize($j[0]);
		$dataforpreview[] = $list;
	}
}
$dataforpreview = array_sort($dataforpreview, 'position', SORT_ASC);

get_header('app');
?>
	<main id="user-design-page">
		<div class="container">
			<h1><?php _e('Design','growlink');?></h1>
			<div class="row">
				<div class="col-md-8">
					<div class="card my-3">
						<form action="" class="designsave">
							<div class="card-body card-form p-md-5">
								<div class="row mb-5">
									<div class="col-md-3">
										<div class="avatar mb-4 px-md-0 px-5">
											<input type="hidden" name="avatar" class="avatar-input" value="<?php echo get_avatarimg_url(get_avatar(intval($theuser->ID),160));?>">
						                    <img src="<?php echo get_avatarimg_url(get_avatar(intval($theuser->ID),160));?>" class="rounded-circle mb-3 avatar-img w-100" alt="<?php echo $theuser->display_name;?>">
						                    <a href="" class="btn btn-primary uploadmediabtn"><?php _e('Change avatar','growlink');?></a>
						                </div>
									</div>
									<div class="col-md-9">
										<div class="form-group has-feedback">
											<label for="site-title"><?php _e('Site Title','growlink');?></label>
											<input class="form-control" type="text" name="site-title" id="site-title" value="<?php echo $databio['site-title'];?>" placeholder="<?php _e('My Business name','growlink');?>" required>
											<div class="help-block with-errors"></div>
										</div>
										<div class="form-group has-feedback">
											<label for="site-intro"><?php _e('Intro text (140 characters)','growlink');?></label>
											<textarea name="site-intro" id="site-intro" class="form-control" rows="3"><?php echo $databio['site-intro'];?></textarea>
											<div class="help-block with-errors"></div>
										</div>
									</div>
								</div>

								<div class="mb-5">

									<h2 class="mb-3"><?php _e('Header','growlink');?></h2>

									<ul class="nav nav-pills mb-3 p-3" id="tab-hero-selector" role="tablist" data-active="<?php echo $databio['site-hero'];?>">
										<li class="nav-item ">
									    	<a class="nav-link active" id="empty" data-toggle="pill" href="#theme-empty" role="tab" aria-controls="theme-premade" aria-selected="true"><?php _e('Blank','growlink');?></a>
									  	</li>
									 	<li class="nav-item ">
									    	<a class="nav-link" id="pattern" data-toggle="pill" href="#theme-premade" role="tab" aria-controls="theme-premade" aria-selected="true"><?php _e('Pattern','growlink');?></a>
									  	</li>
									  	<li class="nav-item">
									    	<a class="nav-link" id="image" data-toggle="pill" href="#theme-image" role="tab" aria-controls="theme-image" aria-selected="false"><?php _e('Image','growlink');?></a>
									  	</li>
									  	<li class="nav-item">
									    	<a class="nav-link" id="color" data-toggle="pill" href="#theme-flatcolor" role="tab" aria-controls="theme-flatcolor" aria-selected="false"><?php _e('Color','growlink');?></a>
									  	</li>
									  	<input type="hidden" name="hero" value="pattern">
									</ul>

									<div class="tab-content" id="tab-hero-selectorContent">
										<div class="tab-pane fade show active" id="theme-empty" role="tabpanel" aria-labelledby="empty">
										</div>
										<div class="tab-pane fade" id="theme-premade" role="tabpanel" aria-labelledby="pattern">
											<div class="theme-selector mb-4">
												<div class="row text-center">
													<?php
													for ($i=0; $i <= 7; $i++) {?>
													<div class="col-4 col-md-3">
														<label class="color-radio">
															<input type="radio" name="site-color-theme" value="theme-<?php echo $i;?>" <?php echo ($databio['site-color-theme'] == 'theme-' . $i) ? "checked" : "";?>>
															<span class="check theme-<?php echo $i;?>"></span>
														</label>
													</div>
													<?php }?>

												</div>
											</div>
										</div>
									  	<div class="tab-pane fade" id="theme-image" role="tabpanel" aria-labelledby="image">
											<label class="custom-image-design color-radio">

												<a href="" class="theme-custom-image uploadmediabtn">
													<?php if($databio['site-hero'] == 'image' && $databio['site-herodata'] != ''){?>
														<img src="<?php echo $databio['site-herodata'];?>" class="imgcustom">
														<input type="hidden" name="custombackground" class="custombackground" value="<?php echo $databio['site-herodata'];?>">
													<?php } else {?>
														<img src="" class="imgcustom" style="display:none">
														<input type="hidden" name="custombackground" class="custombackground" value="">
													<?php }?>
													<svg class="w-100" width="62px" height="62px" viewBox="0 0 62 62" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="picture" fill="#4137CF" fill-rule="nonzero"><path d="M30.9991733,0 C13.8789992,0 0,13.879758 0,31.0001033 C0,48.1204487 13.8789992,62 30.9991733,62 C48.1193475,62 62,48.1198287 62,31.0001033 C61.9997933,13.879138 48.1193475,0 30.9991733,0 Z M14.6217641,46.881668 C13.7990187,46.881668 13.1327209,46.2159836 13.1327209,45.3932299 L13.1327209,16.6063568 C13.1327209,15.7840164 13.7990187,15.1179186 14.6217641,15.1179186 L47.3780292,15.1179186 C48.2007747,15.1179186 48.8670724,15.7842231 48.8670724,16.6063568 L48.8670724,32.5366956 L46.6360909,32.5366956 L45.3657024,32.5366956 L45.3657024,18.5657961 L16.6001973,18.5657961 L16.6001973,37.7916965 L18.2430016,37.7916965 L24.8809725,27.4402107 L29.3171021,34.357046 L31.5201835,37.7919032 L33.4300029,37.7919032 L30.2719085,32.8675745 L32.3301155,29.6579876 L37.5466236,37.7914899 L39.6498843,37.7914899 L39.6498843,39.522352 L39.6498843,42.9142219 L39.6498843,45.0582176 L41.7938586,45.0582176 L44.4914966,45.0582176 L44.4914966,46.8818747 L14.6217641,46.8818747 L14.6217641,46.881668 Z M42.8348456,25.0155569 C42.8348456,26.7168653 41.4551297,28.0965949 39.7538384,28.0965949 C38.052547,28.0965949 36.6728312,26.7168653 36.6728312,25.0155569 C36.6728312,23.3142486 38.052547,21.9345189 39.7538384,21.9345189 C41.4551297,21.9345189 42.8348456,23.3148686 42.8348456,25.0155569 Z M50.0275135,42.9140152 L50.0275135,47.7548492 L46.6367109,47.7548492 L46.6367109,46.881668 L46.6367109,42.9140152 L41.794892,42.9140152 L41.794892,39.5221454 L46.6367109,39.5221454 L46.6367109,34.6813114 L48.8676925,34.6813114 L50.0277202,34.6813114 L50.0277202,39.5221454 L54.8689191,39.5221454 L54.8689191,42.9140152 L50.0275135,42.9140152 Z" id="Shape"></path></g></g></svg>
												</a>
											</label>
									  	</div>
									  	<div class="tab-pane" id="theme-flatcolor" role="tabpanel" aria-labelledby="color">
											<label class="color-radio">
												<span class="colorpicker-inline">
													<input type="text" name="herocolor" id="inline" class="form-control minicolor-inline" value="<?php echo ($databio['site-hero'] == 'color' && $databio['site-herodata'] != '') ? $databio['site-herodata'] : '#00c76b';?>">
												</span>
											</label>
									  	</div>
									</div>
								</div>
								<div class="mb-5">
									<h2 class="mb-3"><?php _e('General Appearance','growlink');?></h2>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group has-feedback">
												<label for="site-font"><?php _e('Font Family','growlink');?></label>
												<div id="font-picker-design" data-selected="<?php echo $databio['site-font'];?>"></div>
												<input type="hidden" value="<?php echo $databio['site-font'];?>" name="site-font" class="input-fontpicker">
												<div class="help-block with-errors"></div>
											</div>
										</div>
									</div>


									<div class="row">
										<div class="col-md-4">
											<div class="form-group has-feedback">
												<label for="site-bgcolor" class="mr-3 d-block"><?php _e('Background Color','growlink');?></label>
												<input class="form-control colorpicker" type="text" name="site-bgcolor" id="site-bgcolor" value="<?php echo $databio['site-bgcolor'];?>">
												<div class="help-block with-errors"></div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group has-feedback">
												<label for="site-color-text" class="mr-3 d-block"><?php _e('Color text','growlink');?></label>
												<input class="form-control colorpicker" type="text" name="site-color-text" id="site-color-text" value="<?php echo $databio['site-color-text'];?>">
												<div class="help-block with-errors"></div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group has-feedback">
												<label for="site-color-link" class="mr-3 d-block"><?php _e('Links color','growlink');?></label>
												<input class="form-control colorpicker" type="text" name="site-color-link" id="site-color-link" value="<?php echo $databio['site-color-link'];?>">
												<div class="help-block with-errors"></div>
											</div>
										</div>

									</div>

									<div class="form-group has-feedback">
										<label for="site-font"><?php _e('Rounded corners','growlink');?></label>
										<br>
										<input type="radio" class="toggle" name="roundedcorners" value="16" <?php echo (isset($databio['site-roundedcorners']) && $databio['site-roundedcorners'] == '16') ? "checked" : "";?>>
										<div class="help-block with-errors"></div>
									</div>

									<div class="form-group">

										<label for=""><?php _e('Link display view','growlink');?></label>

										<div class="row">
											<div class="col-6 col-md-3">
												<label class="icon-radio">
													<input type="radio" name="site-viewdesign" value="list" <?php echo ($databio['site-viewdesign'] == 'list') ? "checked" : "";?>>
													<span class="item"><svg class="w-100" width="80px" height="80px" viewBox="0 0 80 80" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect id="Rectangle" stroke="#4137CF" stroke-width="4" x="2" y="2" width="76" height="76" rx="2"></rect><rect id="Rectangle-4" fill="#4137CF" x="8" y="59" width="64" height="9"></rect><rect id="Rectangle-4" fill="#B8B6D0" x="8" y="13" width="64" height="17"></rect><rect id="Rectangle-4" fill="#B8B6D0" x="8" y="36" width="64" height="17"></rect></g></svg><span class="text d-inline-block mt-2 text-center"><?php _e('List view','growlink');?></span></span>
												</label>
											</div>
											<div class="col-6 col-md-3">
												<label class="icon-radio">
													<input type="radio" name="site-viewdesign" value="grid" <?php echo ($databio['site-viewdesign'] == 'grid') ? "checked" : "";?>>
													<span class="item"><svg class="w-100" width="80px" height="80px" viewBox="0 0 80 80" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect id="Rectangle-4" fill="#4137CF" x="8" y="59" width="30" height="9"></rect><rect id="Rectangle-4" fill="#4137CF" x="42" y="59" width="30" height="9"></rect><rect id="Rectangle" stroke="#4137CF" stroke-width="4" x="2" y="2" width="76" height="76" rx="2"></rect><rect id="Rectangle-4" fill="#B8B6D0" x="8" y="13" width="30" height="17"></rect><rect id="Rectangle-4" fill="#B8B6D0" x="42" y="13" width="30" height="17"></rect><rect id="Rectangle-4" fill="#B8B6D0" x="8" y="36" width="30" height="17"></rect><rect id="Rectangle-4" fill="#B8B6D0" x="42" y="36" width="30" height="17"></rect></g></svg><span class="text d-inline-block mt-2 text-center"><?php _e('Grid view','growlink');?></span></span>
												</label>
											</div>
										</div>
									</div>
								</div>
								<input type="hidden" name="action" value="sendform">
								<input type="hidden" name="typeform" value="form_design">
								<input type="hidden" name="idbio" value="<?php echo $idbio;?>">
								<button type="submit" class="btn btn-primary btn-lg"><?php _e('Save Design','growlink');?></button>
							</div><!-- End card body -->
						</form>
					</div>
				</div>
				<?php if(!wp_is_mobile()){?>

				<div class="col-md-4 d-none d-md-block">
					<div class="sticky">
						<div id="preview" class="px-md-3 pt-md-0 mb-5">
							<div class="phonewrap">
								<div class="notch"></div>
								<div class="screenpage" id="fireLoaderPreview" data-integrations='<?php echo json_encode($integrations);?>' data-avatar='<?php echo get_avatarimg_url(get_avatar(intval($theuser->ID),100));?>' data-design='<?php echo json_encode($databio);?>' data-elements='<?php echo json_encode($dataforpreview);?>'>
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
<?php get_footer('app');?>