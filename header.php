<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Barlow:300,400,500,700" rel="stylesheet">


	<?php
	if (have_posts()) : while (have_posts()) : the_post();
	$title = get_post_meta($post->ID, 'growlink_metatitle', true);
	$desc = get_post_meta($post->ID, 'growlink_metatitle', true);
	$keys = get_post_meta($post->ID, 'growlink_metatitle', true);
	?>
	<title><?php echo (get_post_meta($post->ID, 'growlink_metatitle', true)) ? get_post_meta($post->ID, 'growlink_metatitle', true) : get_bloginfo( 'name' ) ." | " . wp_title( '|', true, 'right' );?></title>

	<meta name="title" content="<?php echo $title;?>">
	<meta name="description" content="<?php echo $desc;?>">

	<!-- Open Graph / Facebook -->
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?php the_permalink();?>">

	<meta property="og:title" content="<?php echo $title;?>">
	<meta property="og:description" content="<?php echo $title;?>">
	<?php if(my_image($post->ID, 'large')){?>
		<meta property="og:image" content="<?php echo my_image($post->ID, 'large');?>">
		<meta property="twitter:image" content="<?php echo my_image($post->ID, 'large');?>">
	<?php }?>

	<!-- Twitter -->
	<meta property="twitter:card" content="summary_large_image">
	<meta property="twitter:url" content="<?php the_permalink();?>">
	<meta property="twitter:title" content="<?php echo $title;?>">
	<meta property="twitter:description" content="<?php echo $desc;?>">
	<?php endwhile; endif;?>

	<?php wp_head();?>
	<?php echo growlink_getoption('header_scripts');?>
</head>
<body <?php body_class('u-custombox-no-scroll');?>>
	<?php do_action('after_body_open_tag'); ?>

	<?php include('partials/public/nav.php');?>