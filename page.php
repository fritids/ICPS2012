<?php
/* 
Template Name: Standaard
*/
?>
<?php get_header() ?>

<div id="content">
    <h2><?php echo $post->post_title ?></h2>
    <?php echo $post->post_content ?>
</div>

<?php get_sidebar() ?>

<div class="clear"></div>
    
<?php get_footer() ?>