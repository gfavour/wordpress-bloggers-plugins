<?php get_header(); ?>

<div class="ps-container">
<div class="ps-bodycontent">
		<?php
		if (have_posts()){
		  the_post();
		  //$query->the_post();
          $meta = get_post_meta(get_the_id(),'');
		  $title = get_the_title();
		  $output .= '<div style="padding-bottom:50px;">';
		  $output .= '<h1 class="ps-hd3">'.$title.'</h1>';
		  
		  $output .= '<span style="background:#f5f5f5;padding:5px 5px 0 5px;display:inline-block;">'.get_the_post_thumbnail().'</span>';
		  $output .= '<div style="padding:10px 10px;">';
		  //$output .= '<h3 class="ps-hd3">'.get_the_title().'</h3>';
		  $output .= '<div class="ps-price" style="margin-bottom:15px;"><strong>Price:</strong> '.formatcurrency($meta["price_per_night"][0]).'</div>';
		  $output .= '<i class="fa fa-male"> <strong>Adult:</strong> '.$meta["no_of_adult"][0].'</i>';
		  $output .= '&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-child"> <strong>Children:</strong> '.$meta["no_of_children"][0].'</i><br>';
		  
		  $output .= '<div style="margin-bottom:15px;"><strong>Amenities/Facilities:</strong><br>'.$meta['amenities'][0].'</div>';
		  
		  
		  $output .= get_the_content();
		  // echo wp_trim_words( get_the_content(), 15, '...' );  $meta['shortdescription'][0];
		  
		  $output .= '</div>';
		  $output .= '</div>';
		  echo  $output;
		}
	  ?>
</div>
<div class="ps-sidemenu"><?php get_sidebar(); //echo do_shortcode("[psbooking-form rtype='".$title."']"); ?></div>
<br clear="all" />
</div>
<?php get_footer(); ?>
