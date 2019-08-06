<?php

/*
Template Name: Report
*/


get_header();
?>
<main class="mt-5">
	<div class="container">
		<div class="row">
			<div class="col-md-9 mx-md-auto mb-5">
				<div class="card">
					<div class="card-body p-md-5">
						<form id="signup" class="s_form mx-md-auto" data-toggle="validator" action="" method="post">
							<!-- Title -->
							<div class="mb-7">
								<h1 class="h3 text-primary font-weight-normal mb-0"><?php _e('Report Violation','growlink');?></span></h1>
								<hr>
							</div>
							<!-- End Title -->

							<div class="message"></div>

							<div class="row">
								<div class="col-md-6">
									<!-- Form Group -->
									<div class="form-group has-feedback">
										<label class="form-label" for="name"><?php _e('Name','growlink');?></label>
										<input type="text" class="form-control" name="name" id="name" placeholder="<?php _e('Name','growlink');?>" aria-label="<?php _e('Name','growlink');?>" required="">
										<div class="help-block with-errors"></div>
									</div>
									<!-- End Form Group -->
								</div>
								<div class="col-md-6">
									<!-- Form Group -->
									<div class="form-group has-feedback">
										<label class="form-label" for="email"><?php _e('Email address','growlink');?></label>
										<input type="email" class="form-control" name="email" id="email" placeholder="<?php _e('Email address','growlink');?>" aria-label="<?php _e('Email address','growlink');?>" required="">
										<div class="help-block with-errors"></div>
									</div>
									<!-- End Form Group -->
								</div>
							</div>

							<div class="form-group">
								<label for=""><?php _e('Message','growlink');?></label>
								<textarea name="message" id="message" rows="3" class="form-control"></textarea>
							</div>


							<!-- Button -->
							<div class="row align-items-center mb-5">
								<div class="col-12 text-left">
									<input type="hidden" name="action" value="sendPublicform">
									<input type="hidden" name="typeform" value="form_contact">

									<button type="submit" class="btn btn-primary"><?php _e('Send message','growlink');?></button>
								</div>
							</div>

							<!-- End Button -->
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<?php get_footer('login');?>