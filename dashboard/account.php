<?php

/*
Template Name: User account
*/

checklogin('/login/');

global $theuser;

get_header('app');
?>
	<main id="user-account-page">
		<div class="container">
			<h1>My Account</h1>
			<div class="row">
				<div class="col-md-10">

					<div class="card my-4">
						<div class="card-body card-form p-md-4">
							<div class="mb-5">
								<h2 class="mb-3"><?php _e('Social Connect','growlink');?></h2>
								<div class="form-group has-feedback">
									<label for="account-email"><?php _e('Instagram','growlink');?></label>

									<?php
									$u = connectIG($theuser->ID);
									if($u){?>
										<p class="my-3">
										<button value="logininstagram" name="instagram_login" type="" class="btn px-4 btn-outline-dark" disabled>
											<?php _e('Connected as','growlink');?> @<?php echo $u;?>
											<svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" role="presentation" width="24px" height="24px"><path d="M7.8,2H16.2C19.4,2 22,4.6 22,7.8V16.2C22,19.4 19.4,22 16.2,22H7.8C4.6,22 2,19.4 2,16.2V7.8C2,4.6 4.6,2 7.8,2M7.6,4C5.61,4 4,5.61 4,7.6V16.4C4,18.39 5.61,20 7.6,20H16.4C18.39,20 20,18.39 20,16.4V7.6C20,5.61 18.39,4 16.4,4H7.6M17.25,5.5C17.94,5.5 18.5,6.06 18.5,6.75C18.5,7.44 17.94,8 17.25,8C16.56,8 16,7.44 16,6.75C16,6.06 16.56,5.5 17.25,5.5M12,7C14.76,7 17,9.24 17,12C17,14.76 14.76,17 12,17C9.24,17 7,14.76 7,12C7,9.24 9.24,7 12,7M12,9C10.34,9 9,10.34 9,12C9,13.66 10.34,15 12,15C13.66,15 15,13.66 15,12C15,10.34 13.66,9 12,9Z"></path></svg>
										</button>
										</p>
									<?php } else {?>
										<form method='post' action=''>
										<p class="my-3">
											<button type="submit" value="logininstagram" name="instagram_login" class="btn px-4 btn-outline-instagram">
												<?php _e('Connect with instagram','growlink');?>
												<svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" role="presentation" width="24px" height="24px"><path d="M7.8,2H16.2C19.4,2 22,4.6 22,7.8V16.2C22,19.4 19.4,22 16.2,22H7.8C4.6,22 2,19.4 2,16.2V7.8C2,4.6 4.6,2 7.8,2M7.6,4C5.61,4 4,5.61 4,7.6V16.4C4,18.39 5.61,20 7.6,20H16.4C18.39,20 20,18.39 20,16.4V7.6C20,5.61 18.39,4 16.4,4H7.6M17.25,5.5C17.94,5.5 18.5,6.06 18.5,6.75C18.5,7.44 17.94,8 17.25,8C16.56,8 16,7.44 16,6.75C16,6.06 16.56,5.5 17.25,5.5M12,7C14.76,7 17,9.24 17,12C17,14.76 14.76,17 12,17C9.24,17 7,14.76 7,12C7,9.24 9.24,7 12,7M12,9C10.34,9 9,10.34 9,12C9,13.66 10.34,15 12,15C13.66,15 15,13.66 15,12C15,10.34 13.66,9 12,9Z"></path></svg>
											</button>
										</p>
									</form>
									<?php }?>
								</div>
							</div>
						</div>
					</div>

					<div class="card my-4">
						<div class="card-body card-form p-md-4">
								<form action="" class="s_form" data-toggle="validator">
									<div class="form-group has-feedback">
										<label for="name"><?php _e('Full name','growlink');?></label>
										<input class="form-control" type="text" name="name" id="name" value="<?php echo $theuser->display_name;?>" placeholder="<?php _e('Your full name','growlink');?>" required>
										<div class="help-block with-errors"></div>
									</div>

									<div class="form-group has-feedback">
										<label for="account-email"><?php _e('Email','growlink');?></label>
										<input class="form-control" type="email" name="account-email" id="account-email" value="<?php echo $theuser->user_email;?>" placeholder="@" required>
										<div class="help-block with-errors"></div>
									</div>

									<div class="form-group has-feedback">
										<label for="account-pass"><?php _e('Change your password','growlink');?></label>
										<input class="form-control" type="password" name="account-pass" id="account-pass" value="" placeholder="******">
										<div class="help-block with-errors"></div>
									</div>

									<div class="message"></div>

									<input type="hidden" name="action" value="sendform">
									<input type="hidden" name="typeform" value="form_account">
									<button type="submit" class="btn btn-primary btn-lg"><?php _e('Save','growlink');?></button>
								</form>
							</div><!-- End card body -->

					</div>
				</div>
			</div>
		</div>
	</main>

<?php get_footer('app');?>