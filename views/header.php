<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Page title -->
    <?php WPTheme\Theme::title() ?> 
    <!-- Mobile -->
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- Ping Back -->
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

<?php if( wpt_setting('assets_use_cdn') ) { ?>
    <!-- Bootstrap CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Font Awesome CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/solid.min.css" integrity="sha256-8DcgqUGhWHHsTLj1qcGr0OuPbKkN1RwDjIbZ6DKh/RA=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/brands.min.css" integrity="sha256-UZFVAO0Fn854ajzdWnJ2Oze6k1X4LNqE2RJPW3MBfq8=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/fontawesome.min.css" integrity="sha256-/sdxenK1NDowSNuphgwjv8wSosSNZB0t5koXqd7XqOI=" crossorigin="anonymous" />
<?php } else { ?>
    <link rel="stylesheet" href="<?= WPTheme\Theme::asset('package/bootstrap/bootstrap-4.3.1/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= WPTheme\Theme::asset('package/fontawesome/fontawesome-free-5.11.2/css/solid.min.css') ?>">
    <link rel="stylesheet" href="<?= WPTheme\Theme::asset('package/fontawesome/fontawesome-free-5.11.2/css/brands.min.css') ?>">
    <link rel="stylesheet" href="<?= WPTheme\Theme::asset('package/fontawesome/fontawesome-free-5.11.2/css/fontawesome.min.css') ?>">
<?php } ?>

    <!-- Generate Head -->
    <?php wp_head() ?>
</head>
<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">