<?php
/*
** Template name: Dashboard
*/

get_header();

$current_user = wp_get_current_user();
?>
<div id="content">
  <h2>User dashboard</h2>
  
  <h3><?php echo $current_user->user_firstname . ' ' . $current_user->user_lastname ?></h3>
  
  <div id="application">
    <h4>Application</h4>      
  </div>

  <div id="lecture">
    <h4>Lecture</h4>
  </div>

  <div id="poster">
    <h4>Poster</h4>
  </div>
  
</div>
<?php get_sidebar() ?>


<div class="clear"></div>

<?php get_footer() ?>