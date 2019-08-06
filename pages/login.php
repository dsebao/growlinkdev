<?php

/*
Template Name: Login
*/

if(is_user_logged_in()){
	wp_redirect(home_url('/dashboard/'));
}

$state = getparams('action');

get_header();

?>
<main class="mt-5">
	<div class="container">
		<div class="row">
			<div class="col-md-4 mx-md-auto">
				<?php if($state == 'recover'){?>
				<form id="recover" class="s_form mx-md-auto mb-5" data-toggle="validator" action="" method="post">
					<div class="mb-7">
						<h3 class="h3 text-primary font-weight-normal mb-0"><?php _e('Recover your password','growlink');?> <span class="font-weight-semi-bold"><?php _e('back','growlink');?></span></h3>
						<hr>
						<div class="message"></div>
						<p><?php _e('Please enter your email','growlink');?></p>
					</div>

					<div class="form-group has-feedback">
						<input type="email" class="form-control" name="email" id="email" placeholder="<?php _e('Email Address','growlink');?>" aria-label="Email address" required="">
						<div class="help-block with-errors"></div>
					</div>

					<input type="hidden" name="action" value="sendPublicform">
					<input type="hidden" name="typeform" value="form_recover">

					<button type="submit" class="btn btn-primary btn-block mb-3"><?php _e('Search','growlink');?></button>
				</form>
				<?php } elseif($state == 'resetpass' && isset($userreset)){?>
				<form id="resetpass" class="s_form mx-md-auto mb-5" data-toggle="validator" action="" method="post">
					<div class="mb-7">
						<h3 class="h3 text-primary font-weight-normal mb-0"><?php _e('Set your new password','growlink');?></h3>
						<hr>
						<div class="message"></div>
					</div>

					<div class="form-group">
						<input type="password" class="form-control" name="pass" id="pass" placeholder="********" aria-label="********" required="">
						<div class="help-block with-errors"></div>
					</div>

					<input type="hidden" name="useremail" value="<?php echo $_GET['useremail'];?>">
					<input type="hidden" name="action" value="sendPublicform">
					<input type="hidden" name="typeform" value="form_resetpass">

					<button type="submit" class="btn btn-primary btn-block mb-3"><?php _e('Save','growlink');?></button>
				</form>
				<?php } elseif($state == 'resendvalidation'){?>
				<form id="resendvalidation" class="s_form mx-md-auto mb-5" data-toggle="validator" action="" method="post">
					<div class="mb-7">
						<h3 class="h3 text-primary font-weight-normal mb-0"><?php _e('Resend email validation','growlink');?></h3>
						<hr>
						<div class="message"></div>
					</div>

					<div class="form-group has-feedback">
						<label class="form-label" for="email"><?php _e('Email Address','growlink');?></label>
						<input type="email" class="form-control" name="email" id="email" placeholder="<?php _e('Email Address','growlink');?>" aria-label="Email address" required="">
						<div class="help-block with-errors"></div>
					</div>

					<input type="hidden" name="action" value="sendPublicform">
					<input type="hidden" name="typeform" value="form_resendvalidation">

					<button type="submit" class="btn btn-primary btn-block mb-3"><?php _e('Resend code','growlink');?></button>
				</form>
				<?php } else {?>
				<form id="login" class="s_form mx-md-auto mb-5" data-toggle="validator" action="" method="post">
					<div class="mb-7">
						<h3 class="h3 text-primary font-weight-normal mb-0"><?php _e('Welcome','growlink');?> <span class="font-weight-semi-bold"><?php _e('back','growlink');?></span></h3>
						<hr>
						<div class="message">
							<?php echo (isset($_GET['action']) && $_GET['action'] == 'resetpasssuccess') ? "<div class='alert alert-success'>" . __('Password changed succesfully','growlink') . "</div>" : "";?>
							<?php global $confirmedemail; echo (isset($confirmedemail)) ? "<div class='alert alert-success'>" . __('Thank you for confirming your email. Now you can log in','growlink') . "</div>" : "";?>
						</div>
						<p><?php _e('Login to manage your account.','growlink');?></p>
					</div>

					<div class="form-group has-feedback">
						<label class="form-label" for="email"><?php _e('Email Address','growlink');?></label>
						<input type="email" class="form-control" name="email" id="email" placeholder="<?php _e('Email Address','growlink');?>" aria-label="Email address" required="">
						<div class="help-block with-errors"></div>
					</div>
					<div class="form-group">
						<label class="form-label" for="pass"><?php _e('Password','growlink');?></label>
						<input type="password" class="form-control" name="pass" id="pass" placeholder="********" aria-label="********" required="">
						<div class="help-block with-errors"></div>
					</div>

					<div class="text-right mb-3">
						<?php echo sprintf(__("<a href='%s' class='text-muted'>Forgot Password?</a>",'growlink'),get_bloginfo('url') . "/login?action=recover");?>
					</div>

					<input type="hidden" name="action" value="sendPublicform">
					<input type="hidden" name="typeform" value="form_login">

					<button type="submit" class="btn btn-primary btn-block mb-3"><?php _e('Login','growlink');?></button>

					<p class="text-center">
						<span class="text-muted"><?php _e('Don\'t have an account?','growlink');?></span>
						<a class="" href="<?php bloginfo('url');?>/signup"><?php _e('Signup','growlink');?></a>
					</p>
				</form>
				<?php }?>
			</div>
		</div>
	</div>
</main>
<?php get_footer('login');?>