<!doctype html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Barlow:300,400,500,700" rel="stylesheet">
	<?php


	if (have_posts()) : while (have_posts()) : the_post();
		$databio = maybe_unserialize(get_post_meta($post->ID, 'option_data',true));

		//Title Bio
		echo "<title>";
		echo ($databio['option-titletag'] != '') ? $databio['option-titletag'] : wp_title('');
		echo "</title>";

		//Google analytics
		($databio['option-ga'] != '') ? GaCode($databio['option-ga']) : "";

		//Facebook Pixel
		($databio['option-fbpixel'] != '') ? FbCode($databio['option-fbpixel']) : "";

		//Favicon
		($databio['option-favicon'] != '') ? faviconCode($databio['option-favicon']) : "";
	?>
	<meta property="og:title" content="<?php echo ($databio['option-titletag'] != '') ? $databio['option-titletag'] : __('GROWLINK','growlink');?>"/>
	<meta property="og:type" content="website" />
	<meta property="og:url" content="<?php the_permalink();?>" />
	<meta property="og:image" content="<?php echo ($databio['option-ographimg'] != '') ? "https://cdn.filestackcontent.com/" . $databio['option-ographimg'] : "";?>" />
	<meta property="og:description" content="<?php echo $databio['option-dsc'];?>" />
	<meta property="og:site_name" content="<?php bloginfo('sitename');?>"/>

	<?php
	endwhile; endif;
	wp_head();
	?>

</head>
<body <?php body_class('u-custombox-no-scroll');?>>
	<?php do_action('after_body_open_tag'); ?>
