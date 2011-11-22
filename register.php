<?php
/*
 * Template Name: Register
 */


if ('POST' == $_SERVER['REQUEST_METHOD'] && wp_verify_nonce($_POST['icnonsense'], 'register') ) :
    require 'functions/register.php';

    $result = icps_register_user($_POST);
endif; // has registration data been supplied in a valid way?

wp_enqueue_style('register');

get_header();

?>

<div id="content">

    <form id="registration" name="registration" method="post">
    
        <label class="row text">
	    <span class="label">First name</span>
	    <input type="text" name="first_name" />
	</label>

        <label class="row text">
	    <span class="label">Last name</span>
	    <input type="text" name="last_name" />
	</label>

        <label class="row email">
	    <span class="label">Email</span>
	    <input type="email" name="email" />
	</label>

        <label class="row select">
	    <span class="label">Country of residence</span>
	    <input type="text" name="country" />
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

	<label class="row submit">
	    <input type="submit" name="submit" class="button submit" value="Submit registration" />
	    <?php wp_nonce_field('register', 'icnonsense', true) ?>
	</label>
    </form>
</div> <!-- #content -->

<div class="clear"></div>
<?php

get_footer();
