<?php 
namespace WPTheme; 
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js" lang="en">
<head>
<!-- Begin head tag -->

    <!-- Meta tags -->
    <?php wpt_partial('global/meta'); ?>

    <!-- Fonts -->
    <?php wpt_partial('global/fonts'); ?>

    <!-- Head -->
    <?php wp_head() ?>

<!-- End head tag-->
</head>


<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
<!-- Begin body tag -->  

    <?php 
        /** Hook action - wpt_body_open */
        do_action( 'wpt_body_open' ); 
    ?>

    <?php
        /** Outputs the site header */
        wpt_partial('global/header');
    ?>
    
    <!-- Begin main page element -->
    <main id="main" role="main">