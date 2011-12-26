<?php
/*
**Template Name: Programme
*/

wp_enqueue_script('jquery');

wp_enqueue_script('programme');
?>
<?php get_header() ?>

<div id="content" role="main">
  <h2><?php echo $post->post_title ?></h2>

  <div id="programme-timetable">
    <div id="hours">
      <div class="hour">08:00</div>
      <div class="hour">09:00</div>
      <div class="hour">10:00</div>
      <div class="hour">11:00</div>
      <div class="hour">12:00</div>
      <div class="hour">13:00</div>
      <div class="hour">14:00</div>
      <div class="hour">15:00</div>
      <div class="hour">16:00</div>
      <div class="hour">17:00</div>
      <div class="hour">18:00</div>
      <div class="hour">19:00</div>
      <div class="hour">20:00</div>
      <div class="hour last">21:00</div>
    </div>
    <div class="day-column"></div>
    <div class="day-column"></div>
    <div class="day-column"></div>
    <div class="day-column"></div>
    <div class="day-column"></div>
    <div class="day-column"></div>
    <div class="day-column"></div>
  </div>
</div>

<?php get_sidebar() ?>

<div class="clear"></div>

<?php get_footer() ?>