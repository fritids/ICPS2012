<?php
/*
** Template name: Check-In
*/

if( !isset($current_user) )
  $current_user = wp_get_current_user();

if(!(in_array('administrator', $current_user->roles) || in_array('editor', $current_user->roles))) { require '404.php'; die; }

wp_enqueue_style('check-in');
  wp_enqueue_style('check-in_print');
wp_enqueue_script('jquery');
wp_enqueue_script('check-in');
wp_enqueue_script('tmpl');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Check-In</title>
  <?php wp_head() ?>
<!--  <link rel="alternate stylesheet" title="normale" href="/wp-content/themes/icps2012/styles/check-in.css">
  <link rel="alternate stylesheet" title="printasdf" href="/wp-content/themes/icps2012/styles/check-in_print.css">-->
</head>
<body>
  <div id="wrapper">
    <img src="http://www.icps2012.com/wp-content/themes/icps2012/images/icps-logo.png" id="logo"/>
    <input name="livesearch" id="live"></input>

    <ul id="results">

    </ul>
    <div id="user-dialog"><div class="user-data"></div> <span class="close">x</span></div>
  </div>

  <div id="print">
    <div id="information" class="a4">
      <div class="print-wrapper">
<img src="<?php echo bloginfo('template_directory') ?>/images/icps-logo.png" alt="Logo" class="logo"/>
<h1>ICPS 2012 Participant Contract</h1>
      <p class="head">By signing this document, you confirm that the following information is correct, and that you agree to the terms and conditions as stated below.</p>
      <dl class="personal-info"></dl>

      <h3>Bicycle:</h3>
    
      <ul>
        <li>The renter of the bicycle is responsible for any damage to the bicycle during the period of rental.</li>
  <li>The renter has to pay 150,- EUR if the bicycle is stolen and the renter has the key.</li>
  <li>The renter has to pay 625,- EUR if the bicycle is stolen and the renter does not have the key.</li>
  <li>The renter has to pay 625,- EUR if the renter does not return the bicycle.</li>
  <li>The renter has to pay 20,- EUR if the renter hands in the bicycle without the key.</li>
  <li>The renter is obligate to report any damage to the bicycle or a stolen bicycle to the organisation immediately.</li>
  <li>The organisation provides a good lock for the bicycle.</li>
      </ul>

      <h3>Accommodation:</h3>
      <ul>
  <li>The tenant has to pay 30,- EUR if the tenant loses his pass.</li>
  <li>The tenant has to pay 7,50 EUR if the tenant loses the key to his accommodation.</li>
      </ul>

     <dl class="sign">
       <dt class="date">Date:</dt><dd>August 4th 2012</dd>
       <dt class="signature">Signature:</dt><dd></dd>
     </dl>
</div>
    </div>

    <div id="tear" class="a4">
<div class="print-wrapper">
<div id="receipt">
<img src="<?php echo bloginfo('template_directory') ?>/images/icps-logo.png" alt="Logo" class="logo"/>
<h1>ICPS 2012 Check-In Receipt</h1>
<p class="head">Info</p>
<dl class="personal-info"></dl>
</div>
<hr class="tear" />

</div>

    </div>
  </div>
  </body>

  </html>
