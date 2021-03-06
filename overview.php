<?php
/*
** Template name: Overview
*/

if( !isset($current_user) )
  $current_user = wp_get_current_user();

if(!(in_array('administrator', $current_user->roles) || in_array('editor', $current_user->roles))) { require '404.php'; die; }

wp_enqueue_style('overview');
wp_enqueue_script('jquery');
wp_enqueue_script('overview');
require 'functions/overview.php';

$fields = icps_overview_fields();

?>
<!DOCTYPE html>
<html>
<head>
<meta name="robots" content="noindex, nofollow">
<title>Applicants overview</title>

<?php wp_head() ?>
</head>
<body>
<div id="superlijst">
<button id="reverse">Reverse</button>
<table id="overview">
<thead>
<tr>
<th>#</th>
<?php foreach($fields as $field): ?><th data-key="<?php echo $field['name'] ?>"><?php echo $field['nicename'] ?></th><?php endforeach; ?>
  <th>Totaal</th>
  <th>Verschil</th>
  <th>Door</th>
  <th>Betaald</th>
  <th>Jij moet</th>
</thead>
<tbody>

</tbody>
</table>
</div>
<div id="uinfo">
  <textarea></textarea>
  <button>hup</button>

  <div id="uinfo-div">
    <ul id="uinfo-list"></ul>
  </div>
</div>