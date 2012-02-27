<?php
/*
 * Template Name: Register
 */

$errors = array();
if ('POST' == $_SERVER['REQUEST_METHOD'] && wp_verify_nonce($_POST['icnonsense'], 'register') ) :
    require 'functions/register.php';

    
    $result = icps_register_user($_POST);
    $user_id = null;

    if($result[0] === false) : //something went wrong!
        $errors[] = $result[1];

    else :
        $user_id = $result[1];
    endif; // did an error occur?
elseif ('POST' == $_SERVER['REQUEST_METHOD'] && !wp_verify_nonce($_POST['icnonsense'], 'register') ) :
    die("You don\'t seem to have arrived here from the right page. For security reasons, we cannot accept the submitted data.");
endif; // has registration data been supplied in a valid way?

wp_enqueue_style('register');

get_header();

if( empty($errors) && isset($user_id) ) : // have we actually registered a user?
    ?>
    <div id="content">
        <p>Thank you for your application. An email has been sent to the supplied address, in which you will find your password for logging on to your user profile.</p>
    </div><!-- #content -->

    <div class="clear"></div>
    <?php

else :
?>

<div id="content">

    <h2>Apply for ICPS 2012</h2>
    <?php echo $post->post_content ?>
    <?php
    if(!empty($errors) ) :
        ?>
        <div id="errors">
            <?php if(in_array(1, $errors) ) echo "The supplied email address isn't valid!"; ?>
            <?php if(in_array(2, $errors) ) echo "The supplied email address has already been registered."; ?>
        </div>
        <?php
    endif; // errors
    ?>
    <form id="registration" name="registration" method="post">
    
        <div class="row">
            <label class="splitrow text">
    	        <span class="label">First name</span>
                <input type="text" name="first_name" />
            </label>

            <label class="splitrow text">
                <span class="label">Last name</span>
                <input type="text" name="last_name" />
            </label>
        </div>
    
	<div class="clear"></div>

        <label class="row email">
	    <span class="label">Email</span>
	    <input type="email" name="email" />
	</label>

        <label class="row select">
	    <span class="label">Country of residence</span>
	    <?php require('inc/countries.html') ?>	    
	</label>

        <label class="row text">
	    <span class="label">University</span>
	    <input type="text" name="university" />
	</label>

        <label class="row text">
	    <span class="label">Study</span>
	    <input type="text" name="study" />
	</label>

        <div class="row radio">
	    <span class="label">Level</span>
	    <label><input type="radio" name="level" value="undergraduate" /> Undergraduate </label>
	    <label><input type="radio" name="level" value="graduate" /> Graduate </label>
	    <label><input type="radio" name="level" value="phd" /> PhD </label>
	</div>

        <label class="row checkbox">
	    <input type="checkbox" name="contribute" />
	    <span class="label">I'm interested in giving a student lecture, or supplying a poster.</span>
	</label>
        
        <div class="clear"></div>

	<label class="row submit">
	    <input type="submit" name="submit" class="button submit" value="Submit registration" />
	    <?php wp_nonce_field('register', 'icnonsense', true) ?>
	</label>
    </form>
</div> <!-- #content -->

<?php get_sidebar() ?>

<div class="clear"></div>
<?php

endif; // has valid data been supplied?
get_footer();
