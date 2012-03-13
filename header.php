<?php ini_set('display_errors', 0); ini_set('display_startup_errors', 0); error_reporting(E_ALL); ?>

<!DOCTYPE html>
<html lang="nl">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
<?php if(is_page('dashboard-2-0') || is_page('sandbox') || is_page('overview')) : ?><meta name="robots" content="noindex"/><?php endif; ?>
        <title><?php
            global $post;
            wp_title( '|', true, 'right' );
            bloginfo( 'name' );
            ?>
        </title>
        <link rel="stylesheet" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
        <link rel="icon" type="image/png" href="http://www.icps2012.com/favicon.png">
        <link href="https://plus.google.com/116607613287448254559" rel="publisher" />
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
<body <?php echo body_class(); ?>>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div id="wrapper">
<div id="container">
  <div id="head">
    <a href="http://www.icps2012.com/"><img src="<?php bloginfo('template_directory') ?>/images/icps-logo.png" alt="ICPS 2012"/></a>
    
    <?php wp_nav_menu('menu=main&container=false&depth=1'); ?>
    
    <div id="header-image"><img src="<?php bloginfo('template_directory') ?>/images/skyline_web.png" alt="header image"/></div>


    <?php
    if(isset($post->ID)) : 
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
        endif;
    else :
        ?>
        <div class="pusher"></div>
        <?php
    endif; /* display submenu */
    ?>
    <div class="clear"></div>
  </div> <!-- #head -->

