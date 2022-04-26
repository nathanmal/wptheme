<?php 
namespace WPTheme; 
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js" lang="en">
<head>
<!-- Begin head tag -->

    <!-- Meta tags -->
    <?php wpt_partial('head/meta'); ?>

    <!-- Fonts -->
    <?php wpt_partial('head/fonts'); ?>

    <!-- Head -->
    <?php wp_head() ?>

<!-- End head tag-->
</head>


<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
<!-- Begin body tag -->  

    <?php do_action( 'wpt_body_open' ); ?>

    <!-- Begin body header -->
    <?php wpt_partial('header'); ?>
    <!-- End body header -->

    <!-- Begin main page element -->
    <main id="main" role="main">