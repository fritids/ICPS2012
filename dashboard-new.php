<?php
/*
** Template name: Dashboard-2.0
*/

require 'functions/register.php';

$errors = array();

if ('POST' == $_SERVER['REQUEST_METHOD'] ) :
    if($_POST['intent'] == 'login' ) :
        if(wp_verify_nonce($_POST['icnonsense'], 'login') ) :
	    $cred = array('user_login' => $_POST['email'], 'user_password' => $_POST['password'], 'remember' => false);
            $cred = array_map('mysql_real_escape_string', $cred);

            $current_user = wp_signon($cred, true);
  
            if( is_wp_error($current_user) ) : 
                $errors[] = 1; 
                $current_user = null;
            endif;
        else : die();
        endif;
    endif;
endif;

wp_enqueue_script( 'jqui' );
wp_enqueue_style( 'jquicss');
get_header();



if( !isset($current_user) )
  $current_user = wp_get_current_user();

if('POST' == $_SERVER['REQUEST_METHOD'] ) :
   if ($_POST['intent'] == 'udetails') :
     if(wp_verify_nonce($_POST['icnonsense'], 'udetails') ) :
        $outcome = icps_update_udetails($current_user->ID, $_POST);
	if(!$outcome) : $errors[] = 2; endif;
     else : die;
     endif;
  endif;
endif;

?>

<div id="content">

<?php
if($current_user->ID === 0) : // no user logged in, display login screen
?>

<form name="login" id="loginform" method="post">
    <?php if(!empty($errors) ) : ?>
    <div id="errors">
      <?php if(in_array(1, $errors) ) echo "Unfortunately, this email/password-combination does not match up. Please try again."; ?>
    </div>
    <?php 
    endif; // errors
    ?>
    <label class="row text">
      <span class="label">Email address</span>
      <input type="text" name="email" />
    </label>

    <label class="row text">
      <span class="label">Password</span>
      <input type="password" name="password" />
    </label>

  <label class="row submit">
    <input type="submit" name="submit" class="button submit" value="Login" />
    <input type="hidden" name="intent" value="login" />
    <?php wp_nonce_field('login', 'icnonsense', true) ?>
  </label>

  <div class="row">
    <span><a href="/wp-login.php?action=lostpassword">Lost password?</a></span>
  </div>

</form>

<?php
else : // user is logged in

?>
  <h2>User dashboard</h2>
  
  <h3><?php echo $current_user->user_firstname . ' ' . $current_user->user_lastname ?></h3>
  
  <div id="application">
    <h4>Application</h4>      
    <?php
    $a_status = (int) get_user_meta($current_user->ID, 'application_status', true);
    if($a_status === 1) :
      ?>
      <div id="application-status" class="pending">Pending</div>
      <?php
    elseif($a_status % 4 >= 2) :
      ?>
      <?php if(!empty($errors)) : ?>
      <div id="errors">
          <?php if(in_array(2, $errors) ) echo "You must agree to our terms and conditions in order to proceed."; ?>
      </div>
      <?php endif; ?>
      <div id="application-status" class="approved">
        <div class="progress application check"><p>Application approved</p></div>
	<?php if($a_status % 8 >= 4) : ?>
          <div class="progress further-information check">
	       <p>Personal details complete</p>
          </div>
	<?php else : ?>
	  <div class="progress further-information">
	      <p>Please provide personal information below</p>
	  </div>
	<?php endif; ?>

	<?php if($a_status % 16 >= 8) : ?>
	  <div class="progress payment check">
	    <p>Payment received</p>
	  </div>
	<?php else : ?>
	  <div class="progress payment">
	    <p>Waiting for payment</p>
	  </div>
	<?php endif; ?>

        <div class="clear"></div>
      </div>

<div id="personal-information">
<form name="udetails" id="udetails" action="" method="post"  <?php echo ($a_status % 8 >= 4) ? 'class="collapse"' : '' ?>>
<legend <?php echo ($a_status % 8 >= 4) ? 'class="complete"' : '' ?>>Personal details</legend>
<div class="fieldwrapper">
<?php 
$fields = icps_user_editable_fields($current_user->ID);

$i = 0;
foreach($fields as $field) :

  if($i == 0 || $field['type'] == 'labeled-checkbox') echo '<div class="row">';
?>

<label class="<?php echo $field['double'] ? 'splitrow' : 'row' ?> <?php echo $field['type'] ?>">
<span class="label"><?php echo $field['nicename'] ?></span>
<?php if($field['type'] == 'text' || $field['type'] == 'date') : ?>
    <input type="text" name="<?php echo $field['name'] ?>" value="<?php echo $field['value'] ?>"/>
<?php elseif ($field['type'] == 'country') : 
?>
    <?php require('inc/countries.html') ?>
    <script>$(function() {     $('select[name=country]').val('<?php echo $field['value'] ?>'); });</script>
<?php elseif ($field['type'] == 'labeled-checkbox' ) : ?>
    <input type="checkbox" name="<?php echo $field['name'] ?>" <?php echo $field['value'] == 'on' ? 'checked="checked"' : '' ?> />
<?php elseif ($field['type'] == 'checkbox-sub' ) : ?>
    <input type="text" name="<?php echo $field['name'] ?>" value="<?php echo $field['value'] ?>" />

<?php endif; ?>
</label>
<?php 

if($i == 1 || $field['type'] == 'checkbox-sub') echo '</div><div class="clear"></div>';
$i++;
endforeach;
?>

<label class="row terms">
<span class="label">I agree to the <a href="#" id="toggleterms">terms and conditions</a>.</span>
<input type="checkbox" name="term_agree" <?php echo ($a_status % 8 >= 4) ? 'checked="checked"' : '' ?> />
</label>
<div class="clear"></div>

<div id="terms">
<ul>
<li>Applicants will receive a bicycle for transportation around town. In case the bike is damaged or stolen, the applicant will have to pay for the expenses made.</li>
<li>Cancelling is possible until May 1. After this date, we will not be able to refund your registration fee.</li>
<li>In case you fail to obtain a visa for travelling to the Netherlands, we will not be able to refund your registration fee. So, please double-check whether you need one!</li>
</ul>
</div>

<label class="row submit">
    <input type="submit" name="submit" class="button submit" value="Submit" />
    <input type="hidden" name="intent" value="udetails" />
    <?php wp_nonce_field('udetails', 'icnonsense', true) ?>
</label>
<script>
$(function() {
    $('label.date input').datepicker({changeYear: true, yearRange: '1950:2000', dateFormat: 'd MM yy'});
    <?php echo ($a_status % 8 >= 4) ? "$('#udetails legend').click(function() { $('#udetails').toggleClass('collapse'); });" : "" ?>
    $('a#toggleterms').click(function(e) { e.preventDefault(); $('#terms').toggle() } );
});
</script>
</div>
</form>
</div>
      <?php
    endif;
    ?>
  </div>

  <p>In due time, you will be able to upload a lecture or poster, which will then be reviewed by the organising committee. Please note: giving a lecture or providing a poster is not compulsory!</p>
  <div id="lecture">
    <h4>Lecture</h4>
    
  </div>

  <div id="poster">
    <h4>Poster</h4>
  </div>
  
  <div id="change-password">
    <p>If you want to change your password, you can do so <a href="/wp-login.php?action=lostpassword">here</a>.</p>
  </div>

  <div id="logout">
    <p><a href="/logout">Log out</a></p>
  </div>
  
<?php
endif; // is user logged in?
?>

</div>
<?php get_sidebar() ?>


<div class="clear"></div>

<?php get_footer() ?>