<?php 
namespace WPTheme; 
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js" lang="en">
<head>
    <!-- Meta Tags -->
    <meta charset="utf-8" />
    <!-- IE Compatibility -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Page title -->
    <?php wpt_title(); ?>
    <!-- Mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <!-- Ping Back -->
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <?php wpt_partial('head/fonts'); ?>

    <?php wp_head() ?>

</head>
<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
    <?php wp_body_open(); ?>
    
    <?php wpt_partial('header'); ?>

    <!-- Begin main page element -->
    <main id="page" role="main">
