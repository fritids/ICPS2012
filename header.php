<?php ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL); ?>

<!DOCTYPE html>
<html lang="nl">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <title><?php
            global $post;
            wp_title( '|', true, 'right' );
            bloginfo( 'name' );
            ?>
        </title>
        <link rel="stylesheet" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

        <?php wp_head(); ?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-18940602-15']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
    </head>
<body <?= body_class(); ?>>

<div id="wrapper">
<div id="container">
  <div id="head">
    <img src="<?php bloginfo('template_directory') ?>/images/icps-logo.png" alt="ICPS 2012"/>
    
    <?php wp_nav_menu('menu=primary&container=false&depth=1'); ?>
    
    <div id="header-image"></div>


    <?php 
    $subpages = wp_list_pages('echo=0&title_li=&child_of=' . $post->ID);
    
    if($subpages || $post->post_parent) :
        ?>
          <div class="submenu">
            <ul>
            <?php
               if($subpages) :
                   echo $subpages;
               elseif($post->post_parent) :
                   wp_list_pages('title_li=&child_of=' . $post->post_parent);
               endif; /* submenu type */
            ?>
            </ul>
         </div>
    <?php
    else :
        ?>
        <div class="pusher"></div>
        <?php
    endif; /* display submenu */
    ?>
    <div class="clear"></div>
  </div>

