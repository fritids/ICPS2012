<?php
/*
** Template name: Dashboard-2.0
*/

$errors = array();

if ('POST' == $_SERVER['REQUEST_METHOD'] && wp_verify_nonce($_POST['icnonsense'], 'login') ) :
  $cred = array('user_login' => $_POST['email'], 'user_password' => $_POST['password'], 'remember' => false);
  $cred = array_map('mysql_real_escape_string', $cred);

  $current_user = wp_signon($cred, true);
  
  if( is_wp_error($current_user) ) : 
    $errors[] = 1; 
    $current_user = null;
  endif;

elseif ('POST' == $_SERVER['REQUEST_METHOD'] && !wp_verify_nonce($_POST['icnonsense'], 'login') ) :
  die();
endif;


get_header();



if( !isset($current_user) )
  $current_user = wp_get_current_user();

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
    <?php wp_nonce_field('login', 'icnonsense', true) ?>
  </label>

  <div class="row">
    <span><a href="/wp-login.php?action=lostpassword">Lost password?</a></span>
  </div>

</form>

<?php
else : // user is logged in

add_user_meta( $current_user->ID, 'application_status', 1, true );
?>
  <h2>User dashboard</h2>
  
  <h3><?php echo $current_user->user_firstname . ' ' . $current_user->user_lastname ?></h3>
  
  <div id="application">
    <h4>Application</h4>      
    <?php
    $a_status = get_user_meta($current_user->ID, 'application_status', true);

    if($a_status === 1) :
      ?>
      <div id="application-status" class="pending">Pending</div>
      <?php
    else :
      ?>
      
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