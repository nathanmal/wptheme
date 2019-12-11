<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <!-- Meta Tags -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Page title -->
    <?php WPTheme\Theme::title() ?> 
    <!-- Mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <!-- Ping Back -->
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Assistant:400,700&display=swap" rel="stylesheet">
    <!-- Generate Head -->
    <?php wp_head() ?>
    <!-- End Generate Head -->
</head>
<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">