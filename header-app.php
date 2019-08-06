<?php $theuser = wp_get_current_user();?>
<!DOCTYPE html>
<html>
<head>
  <title><?php wp_title('');?></title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Barlow:300,400,500,700" rel="stylesheet">
  <?php wp_head();?>
</head>
<body <?php body_class('u-custombox-no-scroll');?>>
	<?php do_action('after_body_open_tag'); ?>

	<?php include('partials/dash/navlink.php');?>