<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <!-- Meta Tags -->
    <meta charset="utf-8" />
    <!-- IE Compatibility -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Page title -->
    <?php WPTheme\Theme::title() ?> 
    <!-- Mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <!-- Ping Back -->
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <!-- Generate Head -->
    <?php wp_head() ?>
    <!-- End Generate Head -->
</head>
<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
<!-- Page header / navigation -->
<header id="header" class="header-fixed" role="navigation">
  <?php WPTheme\Theme::partial('navbar'); ?>
</header>
<!-- End Page header / navigation -->