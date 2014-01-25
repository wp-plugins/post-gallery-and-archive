<?php
/*
Plugin Name: post gallery
Plugin URI: http://www.zeevm.co.il
Description: creates a post gallery/post archive, just create a new page/post and use the shortcode: [post-gallery cat="1" words="10"]
Version: 0.1
Author URI: ze'ev ma'ayan
Author URI: http://www.zeevm.co.il

/*  TM zeev.co.il */
add_action('init', 'process_post');
//limit number of words in the text under the img
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }	
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}
 
function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }	
  $content = preg_replace('/\[.+\]/','', $content);
  $content = apply_filters('the_content', $content); 
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}
//create shortcode things
function process_post(){ 
function button_shortcode( $atts, $content = null ) {
   extract( shortcode_atts( array(
      'cat' => 'cat',
	  'words' => 'words'
      ), $atts ) );?>
	  <ul class="zeevul">
<?php query_posts( array ( 'cat' => $cat, 'posts_per_page' => 999));
if (have_posts()) : while (have_posts()) : the_post();
  // do whatever you want
?>
<li>
					<h2 href="<?php the_permalink(); ?>"><?php the_title(); ?></h2>
					<?php
                if(has_post_thumbnail()) { ?>
                    <div class="entry-thumbnail">
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail();?></a>
                    </div>
            <?php } else { ?>
                <div class="entry-thumbnail">
                    <a href="<?php the_permalink(); ?>"><img src="<?php echo plugins_url(); ?>/post-gallery/default-img.png" alt="Image Unavailable" /></a>
                </div>
            <?php } ?>

<p><?php echo excerpt($words); ?></p>
<a href="<?php the_permalink(); ?>">קרא עוד >></a>
	</li>
<?php
endwhile;
wp_reset_query();
?><?php endif;
// style it up
 ?>
</ul>
<style>
ul.zeevul {
width:100%;
}
ul.zeevul li {
list-style:none!important;
float:left;
width:29%;
margin-left:15px;
margin-top:20px;
}
ul.zeevul li img{
width:100%;
height:150px;
}
ul.zeevul li img:hover{
opacity:0.6;
filter:alpha(opacity=60); /* For IE8 and earlier */
}
</style>
<?php
 
} 
Function archive()  { return sheker();}
add_shortcode('post-gallery', 'button_shortcode');
}?>