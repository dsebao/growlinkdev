<?php

/*
Template Name: Signup
*/

if(is_user_logged_in()){
	wp_redirect(home_url('/dashboard/'));
}

get_header();
?>
<main class="mt-5">
	<div class="container">
		<div class="row">
			<div class="col-md-4 mx-md-auto">
				<form id="signup" class="s_form mx-md-auto" data-toggle="validator" action="" method="post">
					<!-- Title -->
					<div class="mb-7">
						<h1 class="h3 text-primary font-weight-normal mb-0"><?php _e('Welcome to','growlink');?> <span class="font-weight-semi-bold">Growlink</span></h1>
						<hr>
						<p><?php _e('Fill out the form to get started.','growlink');?></p>
					</div>
					<!-- End Title -->

					<div class="message"></div>

					<!-- Form Group -->
					<div class="form-group has-feedback">
						<label class="form-label" for="username"><?php _e('Username','growlink');?></label>
						<input type="text" class="form-control" name="username" id="username" placeholder="<?php _e('Username','growlink');?>" aria-label="Username" required="">
						<div class="help-block with-errors"></div>
					</div>
					<!-- End Form Group -->

					<!-- Form Group -->
					<div class="form-group has-feedback">
						<label class="form-label" for="email"><?php _e('Email address','growlink');?></label>
						<input type="email" class="form-control" name="email" id="email" placeholder="<?php _e('Email address','growlink');?>" aria-label="Email address" required="">
						<div class="help-block with-errors"></div>
					</div>
					<!-- End Form Group -->
					<!-- Form Group -->
					<div class="form-group">
						<label class="form-label" for="pass"><?php _e('Password','growlink');?></label>
						<input type="password" data-minlength="6" class="form-control" name="pass" id="pass" placeholder="********" aria-label="********" required="">
						<div class="help-block with-errors"></div>
					</div>
					<!-- End Form Group -->

					<!-- Checkbox -->
					<div class="mb-5">
						<div class="form-group custom-control custom-checkbox d-flex align-items-center text-muted has-feedback">
							<input type="checkbox" class="custom-control-input" id="termsCheckbox" name="termsCheckbox" required="">
							<label class="custom-control-label" for="termsCheckbox">
								<small>
								<?php echo sprintf('I agree to the <a class="link-muted" href="%s/terms">Terms and Conditions</a>','growlink',get_bloginfo("url"));?>
								</small>
							</label>
							<div class="help-block with-errors"></div>
						</div>
					</div>
					<!-- End Checkbox -->

					<!-- Button -->
					<div class="row align-items-center mb-5">
						<div class="col-5 col-sm-6">
							<span class="text-muted"><?php _e('Already have an account?','growlink');?></span>
							<a class="" href="<?php bloginfo('url');?>/login"><?php _e('Login','growlink');?></a>
						</div>
						<div class="col-7 col-sm-6 text-right">
							<input type="hidden" name="action" value="sendPublicform">
							<input type="hidden" name="typeform" value="form_signup">

							<button type="submit" class="btn btn-primary"><?php _e('Get Started','growlink');?></button>
						</div>
					</div>


					<!-- End Button -->
				</form>
			</div>
		</div>
	</div>
</main>
<?php get_footer('login');?>