<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Page title -->
    <?= Theme::title() ?>
    <!-- Mobile -->
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- Ping Back -->
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <!-- Generate Head -->
    <?php wp_head() ?>
</head>
<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">