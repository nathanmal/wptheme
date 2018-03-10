<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Page title -->
    <title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
    <!-- Mobile -->
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <!-- Ping Back -->
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <!-- Provide baseURL for javascript -->
    <script type="text/javascript">
    	window.baseURL = '<?php echo site_url();?>';
    </script>
    <!-- Begin wp_head -->
    <?php wp_head() ?>
    <!-- End wp_head -->
</head>
<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">


