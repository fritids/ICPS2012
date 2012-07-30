<?php
/*
** Template name: Check-In
*/

if( !isset($current_user) )
  $current_user = wp_get_current_user();

if(!(in_array('administrator', $current_user->roles) || in_array('editor', $current_user->roles))) { require '404.php'; die; }

wp_enqueue_style('check-in');
wp_enqueue_script('jquery');
wp_enqueue_script('check-in');
wp_enqueue_script('tmpl');
?>
<!DOCTYPE html>
<html>
<head>
<title>Check-In</title>
<?php wp_head() ?>
</head>
<body>
<div id="wrapper">
<img src="http://www.icps2012.com/wp-content/themes/icps2012/images/icps-logo.png" id="logo"/>
<input name="livesearch" id="live"></input>

<ul id="results">

</ul>
<div id="user-dialog"><div class="user-data"></div> <span class="close">x</span></div>
</div>

</body>

</html>
