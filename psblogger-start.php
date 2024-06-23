<?php
$rootfolder = site_url();

function psblogger_limitchar($str,$n){
	if (strlen($str) <= $n){
		return $str;
	}else{ 
		return substr($str,0,$n);
	}
}

function psblogger_HashMyPassword($pass){
	$Encryptkey = '121jmWFOp';
	$hash = md5($pass.$Encryptkey);
	return $hash;
}

function psblogger_redirectUrl($pg){
echo "<script>window.location.href = '".$pg."'</script>";
}

function psblogger_emailsender($to,$subject,$m) {
	$servername = $_SERVER['SERVER_NAME'];
	
	add_filter('wp_mail_content_type','psblogger_set_html_content_type');
	$headers = array('Content-Type: text/html; charset=UTF-8','From: '.$servername.' <noreply@'.$servername.'>');
	wp_mail($to,$subject,$m,$headers);
	remove_filter('wp_mail_content_type','psblogger_set_html_content_type');
}

function psblogger_set_html_content_type() {
return 'text/html';
}

///////////////////
///////////////////////
function psblogger_liker($atts){
$servername = $_SERVER['SERVER_NAME'];
$atts = shortcode_atts(array("type" => "facebook", "url" => "http://".$servername),$atts);

$type = $atts["type"];
$url = $atts["url"];
//<?php echo urlencode(get_permalink($post->id)); ? >
if($type == '' || $type == 'facebook'){
$output = '<iframe src="http://www.facebook.com/plugins/like.php?href='.$url.'&amp;layout=standard& amp;show_faces=false&amp;width=350&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="margin:15px 0 0 0;"></iframe>';
}

return $output;
}

function psblogger_list_courses($atts){
global $post,$rootfolder;

$atts = shortcode_atts(array("limitdesc" => "150", "showexcerpt" => "1", "paging" => "-1", "mt" => "", "mb" => "", "mr" => "", "ml" => "", "width" => "100%", "height" => "", "type" => "post", "category" => "", "order" => "DESC", "orderby" => "id"),$atts);

$showexcerpt = $atts["showexcerpt"];
$category = $atts["category"];
$limitdesc = $atts["limitdesc"];
$posttype = $atts["type"];
$cat = $atts["category"];
$paging = $atts["paging"];
$order = $atts["order"];
$orderby = $atts["orderby"];
$width = $atts["width"];
$height = $atts["height"];
$mb = $atts["mb"];
$mt = $atts["mt"];
$ml = $atts["ml"];
$mr = $atts["mr"];

if($width != ''){$width = 'width:'.$width.';';}
if($height != ''){$height = 'min-height:'.$height.';';}
if($mb != ''){$mb = 'margin-bottom:'.$mb.';';}
if($mt != ''){$mt = 'margin-top:'.$mt.';';}
if($mr != ''){$mr = 'margin-right:'.$mr.';';}
if($ml != ''){$ml = 'margin-left:'.$ml.';';}

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = array('posts_per_page' => $paging,'post_status' => 'publish', 'post_type' => $posttype, 'category_name' => $category, 'order' => $order, 'orderby' => $orderby, 'paged' => $paged);

$query = new WP_Query( $args );
if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
          $query->the_post();
		  $id = get_the_id();
          $meta = get_post_meta($id,'');
		  $pic = get_the_post_thumbnail();
		  $comments = wp_count_comments($id);
		  $c++;
		  if($pic == ''){$pic = '<img src="'.PSBOOKING_PATH.'/assets/images/noimage.png">';}
		  $output .= '<div class="ps-list" style="'.$width.$height.$mt.$mb.$mr.$ml.'">';
		  $output .= '<div class="ps-image">'.$pic.'</div>';
		  $output .= '<div class="ps-body" style="padding:0px;">';
		  $output .= '<h3 class="ps-hd3 ps-head">'.get_the_title().'</h3>';
		  if($showexcerpt == '1'){ $output .= psblogger_limitchar(get_the_excerpt(),$limitdesc); }
		  $output .= '<a href="getcourses/'.$id.'" title="'.get_permalink().'" class="more">Read more</a>';
		  $output .= '</div>';
		  $output .= '</div>';
		  if($c == 6){ $output .= $ads; $c = 0;}
    }
	
	$output .= posts_nav_link(' | ','<span class="prevnext">&laquo; PREVIOUS</span>','<span class="prevnext">NEXT &raquo;</span>');
	
    wp_reset_postdata();
} else {
    // none were found
}

return $output;
}


function psblogger_list_trend($atts){
global $post,$rootfolder;

$atts = shortcode_atts(array("limitdesc" => "150", "showexcerpt" => "1", "paging" => "10", "mt" => "", "mb" => "", "mr" => "", "ml" => "", "width" => "", "height" => "", "type" => "post", "category" => "", "order" => "DESC", "orderby" => "id"),$atts);

$showexcerpt = $atts["showexcerpt"];
$category = $atts["category"];
$limitdesc = $atts["limitdesc"];
$posttype = $atts["type"];
$cat = $atts["category"];
$paging = $atts["paging"];
$order = $atts["order"];
$orderby = $atts["orderby"];
$width = $atts["width"];
$height = $atts["height"];
$mb = $atts["mb"];
$mt = $atts["mt"];
$ml = $atts["ml"];
$mr = $atts["mr"];

if($width != ''){$width = 'width:'.$width.';';}
if($height != ''){$height = 'min-height:'.$height.';';}
if($mb != ''){$mb = 'margin-bottom:'.$mb.';';}
if($mt != ''){$mt = 'margin-top:'.$mt.';';}
if($mr != ''){$mr = 'margin-right:'.$mr.';';}
if($ml != ''){$ml = 'margin-left:'.$ml.';';}

$args = array('posts_per_page' => $paging,'post_status' => 'publish', 'post_type' => $posttype, 'category_name' => $category, 'order' => $order, 'orderby' => $orderby,); ////'posts_per_page' => -1,

$query = new WP_Query( $args );
if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
          $query->the_post();
		  $id = get_the_id();
          $meta = get_post_meta($id,'');
		  $pic = get_the_post_thumbnail();
		  $comments = wp_count_comments($id);
		  $c++;
		  if($pic == ''){$pic = '<img src="'.PSBOOKING_PATH.'/assets/images/noimage.png">';}
		  $output .= '<div class="ps-list" style="'.$width.$height.$mt.$mb.$mr.$ml.'">';
		  $output .= '<div class="ps-img" style="float:left;">'.$pic.'</div>';
		  $output .= '<h3 class="ps-hd3 ps-head"><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
		  $output .= '<div style="padding:0px;">';
		  if($showexcerpt == '1'){ $output .= psblogger_limitchar(get_the_excerpt(),$limitdesc); }
		  $output .= '<div class="ps-comments">Posted On: '.get_the_date().' |  Comment ('.$comments->total_comments.')  |  <a href="'.get_permalink().'">Read more</a></div>';
		  $output .= '</div>';
		  $output .= '</div>';
		  if($c == 6){ $output .= $ads; $c = 0;}
    }
	
    wp_reset_postdata();
} else {
    // none were found
}

return $output;
}


function psblogger_older_posts($atts){
global $post,$rootfolder;

$atts = shortcode_atts(array("limitdesc" => "150", "paging" => "-1", "mt" => "", "mb" => "", "mr" => "", "ml" => "", "width" => "", "height" => "", "type" => "post", "category" => "", "order" => "ASC", "orderby" => "id"),$atts);

$category = $atts["category"];
$limitdesc = $atts["limitdesc"];
$posttype = $atts["type"];
$cat = $atts["category"];
$paging = $atts["paging"];
$order = $atts["order"];
$orderby = $atts["orderby"];
$width = $atts["width"];
$height = $atts["height"];
$mb = $atts["mb"];
$mt = $atts["mt"];
$ml = $atts["ml"];
$mr = $atts["mr"];

if($width != ''){$width = 'width:'.$width.';';}
if($height != ''){$height = 'min-height:'.$height.';';}
if($mb != ''){$mb = 'margin-bottom:'.$mb.';';}
if($mt != ''){$mt = 'margin-top:'.$mt.';';}
if($mr != ''){$mr = 'margin-right:'.$mr.';';}
if($ml != ''){$ml = 'margin-left:'.$ml.';';}

$args = array('posts_per_page' => $paging,'post_status' => 'publish', 'post_type' => $posttype, 'category_name' => $category, 'order' => $order, 'orderby' => $orderby,); ////'posts_per_page' => -1,

$query = new WP_Query( $args );
if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
          $query->the_post();
		  $id = get_the_id();
          $meta = get_post_meta($id,'');
		  $pic = get_the_post_thumbnail();
		  $comments = wp_count_comments($id);
		  
		  if($pic == ''){$pic = '<img src="'.PSBOOKING_PATH.'/assets/images/noimage.png">';}
		  $output .= '<div class="ps-list" style="'.$width.$height.$mt.$mb.$mr.$ml.'">';
		  $output .= '<span class="ps-listimg">'.$pic.'</span>';
		  $output .= '<a href="'.get_permalink().'"><strong>'.get_the_title().'</strong></a>';
		  $output .= psblogger_limitchar(get_the_excerpt(),$limitdesc);
		  $output .= '<div class="ps-listcomments">Posted On: '.get_the_date().' |  Comment ('.$comments->total_comments.')  |  <a href="'.get_permalink().'">Read more</a></div>';
		  $output .= '</div>';
    }
    wp_reset_postdata();
} else {
    $output .= 'No post for now. Check back later!';
}

return $output;
}

function psblogger_mfbvideo($atts, $content = null){
global $post,$rootfolder;

$atts = shortcode_atts(array("m" => "10px 10px", "p" => "", "width" => "320px", "height" => "200px", "vw" => "320", "vh" => "400"),$atts);

$contents = explode(",",$content);
$width = $atts["width"];
$height = $atts["height"];
$m = $atts["m"];
$p = $atts["p"];
$vw = $atts["vw"];
$vh = $atts["vh"];

if($width != ''){$width = 'width:'.$width.';';}
if($height != ''){$height = 'min-height:'.$height.';';}
if($m != ''){$m = 'margin:'.$m.';';}
if($p != ''){$p = 'padding:'.$p.';';}

if(count($contents) > 0){
	foreach($contents as $c){
		//$output .= '<div style="text-align:center;background:#111;overflow:hidden;float:left;'.$width.$height.$m.$p.'"><iframe src="https://web.facebook.com/plugins/video.php?href='.urldecode($c).'&show_text=0" width="'.$vw.'" height="'.$vh.'" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true" style=""></iframe></div>';
		$output .= '<div style="text-align:center;background:#111;overflow:hidden;float:left;'.$width.$height.$m.$p.'"><iframe width="'.$vw.'" height="'.$vh.'" src="https://www.youtube.com/embed/'.urldecode($c).'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';	
	}
}else{
	$output = 'No video. Check back later.';
}
return $output;
}
////////////////////

function psb_request_form($atts){
global $wpdb,$psb_tblrequest,$psb_products,$psb_style1,$psb_style2,$psb_btn,$psb_companyemail;

$atts = shortcode_atts(array("title" => "", "description" => "", "btnlabel" => "SUBMIT", "action" => "", "to" => ""),$atts);
$title = $atts["title"];
$description = $atts["description"];
$btnlabel = $atts["btnlabel"];
$action = $atts["action"];
$to = $atts["to"];
if($to == ''){ $to = $psb_companyemail; }

$tblrequest = $wpdb->prefix.$psb_tblrequest;

foreach($psb_products as $product){
$opts .= '<option value="'.$product.'">'.$product.'</option>';
}

if(isset($_REQUEST["dwat"]) && $_REQUEST["dwat"] == 'requestform'){
	
	if($_REQUEST["rname"] == ''){$msg .= '<div class="msgbox myerror">Name is required</div>';$showform = 1;}
	elseif($_REQUEST["remail"] == ''){$msg .= '<div class="msgbox myerror">Email is required</div>';$showform = 1;}
	elseif(!psb_isValidEmail($_REQUEST["remail"])){$msg .= '<div class="msgbox myerror">Invalid Email</div>';$showform = 1;}
	elseif($_REQUEST["rphone"] == ''){$msg .= '<div class="msgbox myerror">Phone number is required</div>';$showform = 1;}
	elseif($_REQUEST["rmessage"] == ''){$msg .= '<div class="msgbox myerror">Message is required</div>';$showform = 1;}
	else{
		$email = $_REQUEST["remail"];
		
		//insert..........
		$data = array('name' => psb_secure($_REQUEST["rname"]), 'email' => psb_secure($_REQUEST["remail"]), 'phone' => psb_secure($_REQUEST["rphone"]), 'product' => psb_secure($_REQUEST["rproduct"]), 'message' => psb_secure($_REQUEST["rmessage"]));
		$format = array('%s','%s','%s','%s','%s');
		$wpdb->insert($tblrequest,$data,$format);
		$myid = $wpdb->insert_id;
		$showform = 2;
		//send email....
		$m = 'Name: '.$_REQUEST["rname"].', Email: '.$_REQUEST["remail"].', Phone: '.$_REQUEST["rphone"].', Selected Product: '.$_REQUEST["rproduct"].',<br>Message: <br>'.$_REQUEST["rmessage"];
		psb_emailer($to,"New Request From Customer",$m);
		$msg = '<div class="msgbox mysuccess">Message successfully submitted</div>';
	}
}else{
	$showform = 0;
	$msg = '';
}

if($showform == 1){}

$output .= '<form name="frm1" action="'.$action.'" method="post">'.$title.$description.$msg;
$output .= '<input type="hidden" name="dwat" value="requestform">';
$output .= '<input type="text" name="rname" placeholder="Name *" style="'.$psb_style1.'" value="'.$_REQUEST["name"].'">';
$output .= '<input type="email" name="remail" placeholder="Email Address *" style="'.$psb_style1.'" value="'.$_REQUEST["email"].'">';
$output .= '<input type="text" name="rphone" placeholder="Phone Number *" style="'.$psb_style1.'" value="'.$_REQUEST["phone"].'">';
$output .= '<select id="product" name="rproduct" placeholder="Select A Product" style="'.$psb_style1.'">'.$opts.'</select>';
$output .= '<textarea name="rmessage" placeholder="Additional Message: " style="'.$psb_style2.'" rows="2">'.$_REQUEST[message].'</textarea>';
$output .= '<button name="rsubmit" class="pscon-button" style="'.$psb_btn.'">'.$btnlabel.'</button></form>';
return $output;
}

function psb_testimony_form($atts){
global $wpdb,$psb_tbltestimony,$psb_style1a,$psb_style2a,$psb_btn,$psb_companyemail;

$atts = shortcode_atts(array("title" => "", "description" => "", "btnlabel" => "SUBMIT", "action" => "", "to" => ""),$atts);
$title = $atts["title"];
$description = $atts["description"];
$btnlabel = $atts["btnlabel"];
$action = $atts["action"];
$to = $atts["to"];
if($to == ''){ $to = $psb_companyemail; }

$tbltestimony = $wpdb->prefix.$psb_tbltestimony;

if(isset($_REQUEST["dwat"]) && $_REQUEST["dwat"] == 'testform'){
	
	if($_REQUEST["lastname"] == ''){$msg .= '<div class="msgbox myerror">Surname is required</div>';$showform = 1;}
	elseif($_REQUEST["firstname"] == ''){$msg .= '<div class="msgbox myerror">Firstname is required</div>';$showform = 1;}
	//elseif($_REQUEST["email"] == ''){$msg .= '<div class="msgbox myerror">Email is required</div>';$showform = 1;}
	//elseif(!psb_isValidEmail($_REQUEST["email"])){$msg .= '<div class="msgbox myerror">Invalid Email</div>';$showform = 1;}
	//elseif($_REQUEST["phone"] == ''){$msg .= '<div class="msgbox myerror">Phone number is required</div>';$showform = 1;}
	elseif($_REQUEST["message"] == ''){$msg .= '<div class="msgbox myerror">Message is required</div>';$showform = 1;}
	else{
		//$email = $_REQUEST["email"];
		$time = time();
		if (!empty($_FILES['ufile1']['tmp_name'])){$pic = psb_uploader("../".psblogger_WPCPATH."/archives/","ufile1",$time);}else{$pic = "";}
		//insert..........
		$data = array('title' => psb_secure($_REQUEST["title"]),'lastname' => psb_secure($_REQUEST["lastname"]),'firstname' => psb_secure($_REQUEST["firstname"]), 'email' => psb_secure($_REQUEST["remail"]), 'phone' => psb_secure($_REQUEST["rphone"]), 'company' => psb_secure($_REQUEST["company"]), 'message' => psb_secure($_REQUEST["message"]), 'regdate' => psb_secure($time), 'photo' => psb_secure($pic)); 
		$format = array('%s','%s','%s','%s','%s','%s','%s','%s','%s');
		$wpdb->insert($tbltestimony,$data,$format);
		$myid = $wpdb->insert_id;
		$showform = 2;
		$msg .= '<div class="msgbox mysuccess">New testimony successfully added.</div>';
		$m = 'Name: '.$_REQUEST["lastname"].' '.$_REQUEST["lastname"].', Email: '.$_REQUEST["remail"].', Phone: '.$_REQUEST["rphone"].', Testimony: <br>'.$_REQUEST["rmessage"];
		psb_emailer($to,"New Request From Customer",$m);
	}
}else{
	$showform = 0;
	$msg = '';
}

if($showform == 1){}

$output .= '<form name="frm" action="'.$action.'" method="post" enctype="multipart/form-data">'.$title.$description.$msg;
$output .= '<input type="hidden" name="dwat" value="testform">';
$output .= '<select id="title" name="title" placeholder="Title:" style="'.$psb_style1a.';padding:5px;min-height:40px;"><option value="Mr">Mr</option><option value="Mrs">Mrs</option><option value="Miss">Miss</option><option value="Dr">Dr</option></select>';
$output .= '<input type="text" name="lastname" placeholder="Surname *" style="'.$psb_style1a.'" value="'.$_REQUEST["lastname"].'">';
$output .= '<input type="text" name="firstname" placeholder="Firstname *" style="'.$psb_style1a.'" value="'.$_REQUEST["firstname"].'">';
$output .= '<input type="email" name="remail" placeholder="Email Address" style="'.$psb_style1a.'" value="'.$_REQUEST["email"].'">';
$output .= '<input type="text" name="rphone" placeholder="Phone Number" style="'.$psb_style1a.'" value="'.$_REQUEST["phone"].'">';
$output .= '<strong>Attach Photo:</strong><br><input type="file" name="ufile1" style="'.$psb_style1a.'">';
$output .= '<textarea name="message" placeholder="Testimony: " style="'.$psb_style2a.'" rows="5">'.$_REQUEST[message].'</textarea>';
$output .= '<button name="submit" class="pscon-button" style="'.$psb_btn.'">'.$btnlabel.'</button></form>';
return $output;
}

function psb_list_testimony($atts){
global $wpdb,$psb_tbltestimony,$psb_style1a,$psb_style2a,$psb_btn;

$atts = shortcode_atts(array("display" => "list", "howmany" => "3", "order" => "DESC"),$atts);
$c = 1;
$display = $atts["display"];
$howmany = $atts["howmany"];
$order = $atts["order"];

$tbltestimony = $wpdb->prefix.$psb_tbltestimony;
if($order != 'DESC' && $order != 'ASC'){ $order = 'DESC'; }

$rows = $wpdb->get_results("SELECT * FROM ".psb_secure($tbltestimony)." ORDER BY id ".psb_secure($order)." LIMIT ".psb_secure($howmany));
if(count($rows) > 0){
	foreach($rows as $row){
		$photo = $row->photo;
		if (file_exists(psblogger_WPCPATH.'archives/'.$photo) && $photo != ''){
			$pix = psblogger_ARCHIVES.$photo;
		}else{
			$pix = psblogger_ARCHIVES.'noimage.jpg';
		}
		if($c < $howmany){$line = 'border-bottom:#ddd dotted 1px;margin:0 0 10px 0; padding:0 0 10px 0;'; }else{ $line = 'margin:0 0 2px 0; padding:0 0 2px 0;'; }
		$output .= '<div class="psbbox" style="'.$line.'text-align:left;font-size:11.5px;clear:both;"><img src="'.$pix.'" style="width:80px;height:auto; margin:0 10px 10px 0;border-radius:10px;float:left;" />'.$row->message.'<br><div style="font-weight:bold;text-align:right;font-size:12px;">- '.$row->title.' '.$row->lastname.' '.$row->firstname.'</div></div>';
		$c++;
	}
}else{
	echo '0 Follower found.';
}
return $output;
}


function psblogger_blog($atts){
global $post,$rootfolder;

$atts = shortcode_atts(array("mt" => "", "mb" => "", "mr" => "", "ml" => "", "width" => "100%", "height" => "", "type" => "post", "category" => "", "order" => "DESC", "orderby" => "id", "display" => "grid", "howmany" => "-1", "showdesc" => "0", "useani" => "1"),$atts);
//display - grid,list,grid1otherlist
$width = $atts["width"];
$height = $atts["height"];
$cat = $atts["category"];
$display = $atts["display"];
$howmany = $atts["howmany"];
$showdesc = $atts["showdesc"];
$useani = $atts["useani"];

if($howmany > 0){
	$args = array('post_status' => 'publish', 'post_type' => 'post','category_name' => $cat,'posts_per_page' => $howmany, 'no_found_rows' => true);
}else{
	$args = array('post_status' => 'publish', 'post_type' => 'post','category_name' => $cat,'posts_per_page' => $howmany);
}

$query = new WP_Query( $args );
if ( $query->have_posts() ) {
   while($query->have_posts()){
          $query->the_post();
		  $id = get_the_id();
		  $author = get_the_author();
		  $date = get_the_date('F j, Y'); //l F j, Y
          $meta = get_post_meta($id,'');
		  $pic = get_the_post_thumbnail();
		  $comments = get_comments_number(); //$id
		  $urllink = esc_url(get_permalink($id));
		  
		  $c++;
		  if($pic == ''){$pic = '<img src="'.PSBOOKING_PATH.'/assets/images/noimage.png">';}
		if($display == 'grid1otherlist'){
		  if($gol != '1'){
		  $output .= '<div class="col-xs-12 ps-blog" style="'.$width.$height.$mt.$mb.$mr.$ml.'">';
		  $output .= '<div class="ps-img">'.$pic.'</div>';
		  $output .= '<h3 class="psb-newhd"><a href="'.$urllink.'">'.ucwords(strtolower(get_the_title())).'</a></h3>';
		  $output .= ($showdesc == '1')?get_the_content():'';
		  $output .= '<div id="psb-newstats"><i class="fa fa-comment"></i> Comment ('.$comments.')&nbsp;&nbsp;<i class="fa fa-calendar"></i> '.$date.'&nbsp;&nbsp;<i class="fa fa-user"></i> '.$author.'</div>';
		  $output .= '</div>';
		  $gol = '1';
		  }else{
		  	//$output .= '<li class="psb-newli"><a href="'.$urllink.'" style="color:#0099FF !important;">'.ucwords(strtolower(get_the_title())).'</a></li>';
		  }
		}elseif($display == 'grid'){
		  $output .= '<div class="col-xs-12 ps-grid" style="'.$width.$height.$mt.$mb.$mr.$ml.'">';
		  $output .= '<div class="ps-img">'.$pic.'</div>';
		  $output .= '<h3 class="psb-newhd"><a href="'.$urllink.'">'.psb_limitchar(strip_tags(ucwords(strtolower(get_the_title()))),70).'</a></h3>';
		  $output .= '<div id="psb-newstats"><i class="fa fa-comment"></i> Comment ('.$comments.')&nbsp;&nbsp;<i class="fa fa-calendar"></i> '.$date.'&nbsp;&nbsp;<i class="fa fa-user"></i> '.$author.'</div>';
		  $output .= psb_limitchar(strip_tags(get_the_content()),150);
		  $output .= '<a href="'.$urllink.'" class="redlinemore">Read More</a>';
		  $output .= '</div>';
		}elseif($display == 'list'){
		}
	}
	
	//if($useani == '1'){
		//$output = '<div class="psbslider"><div class="psbslides">'.$output.'</div></div>';
	//}
	
	if($display == 'list' || $display == 'grid'){
		$output .= posts_nav_link(' | ','<span class="prevnext">&laquo; PREVIOUS</span>','<span class="prevnext">NEXT &raquo;</span>');
	}
	
    wp_reset_postdata();
} else {
    $output = 'No content. Kindly check back later.';
}

return $output;
}

function psblogger_health($atts){
global $post,$rootfolder;

$atts = shortcode_atts(array("mt" => "", "mb" => "", "mr" => "", "ml" => "", "width" => "350px", "height" => "", "type" => "post", "category" => "1", "order" => "DESC", "orderby" => "id", "display" => "grid", "howmany" => "-1", "showdesc" => "0","singlepg" => ""),$atts);
//display - grid,list,grid1otherlist
$w = $atts["width"];
$h = $atts["height"];
$cat = $atts["category"];
$display = $atts["display"];
$howmany = $atts["howmany"];
$showdesc = $atts["showdesc"];
$singlepg = $atts["singlepg"];

$width = 'width:'.$w.';';
$height = 'height:'.$h.';';

if($howmany > 0){
	$args = array('post_status' => 'publish', 'post_type' => 'post','category_name' => $cat,'posts_per_page' => $howmany, 'no_found_rows' => true);
}else{
	$args = array('post_status' => 'publish', 'post_type' => 'post','category_name' => $cat,'posts_per_page' => $howmany);
}

$query = new WP_Query( $args );
if ( $query->have_posts() ) {
    while($query->have_posts()){
          $query->the_post();
		  $id = get_the_id();
		  $author = get_the_author();
		  $date = get_the_date('F j, Y'); //l F j, Y
          $meta = get_post_meta($id,'');
		  $pic = get_the_post_thumbnail();
		  $comments = get_comments_number(); //$id
		  $urllink = ($singlepg != '')?'#':esc_url(get_permalink($id));
		  
		  $c++;
		  if($pic == ''){$pic = '<img src="'.PSBOOKING_PATH.'/assets/images/noimage.png">';}
		if($display == 'grid'){
		if($c < $howmany){ $mp = 'padding:0 10px 10px 0;'; }else{ $mp = 'padding:0 0px 10px 0;'; }
		  $output .= '<div class="ps-health" style="'.$width.$height.$mt.$mb.$mr.$ml.$mp.'">';
		  $output .= '<div class="ps-himg">'.$pic.'</div>';
		  $output .= '<h3 class="psb-hhd"><a href="'.$urllink.'">'.ucwords(strtolower(get_the_title())).'</a></h3>';
		  $output .= '<div id="psb-hstats"><i class="fa fa-comment"></i> Comment ('.$comments.')&nbsp;&nbsp;<i class="fa fa-calendar"></i> '.$date.'&nbsp;&nbsp;<i class="fa fa-user"></i> '.$author.'</div>';
		  $output .= psb_limitchar(strip_tags(get_the_content()),200).'...';
		  $output .= '<a href="'.$urllink.'" class="redlinemore">Read More</a></div>';
		  
		}else{
		  $output .= '<div class="ps-health" style="'.$width.$height.$mt.$mb.$mr.$ml.'">';
		  $output .= '<div class="ps-himg">'.$pic.'</div>';
		  $output .= '<h3 class="psb-hhd"><a href="'.$urllink.'">'.ucwords(strtolower(get_the_title())).'</a></h3>';
		  $output .= '<div id="psb-newstats"><i class="fa fa-comment"></i> Comment ('.$comments.')&nbsp;&nbsp;<i class="fa fa-calendar"></i> '.$date.'&nbsp;&nbsp;<i class="fa fa-user"></i> '.$author.'</div>';
		  $output .= psb_limitchar(strip_tags(get_the_content()),200);
		  $output .= '</div>';
		}
	}
    wp_reset_postdata();
} else {
    $output = 'No Medical/Health tip yet. Check back later.';
}

return $output;
}


function psblogger_whatsappchat($atts){
global $post,$rootfolder;

$atts = shortcode_atts(array("howmany" => "3", "img" => "2", "img1" => psblogger_PATH."/assets/whatsapp/user1.jpg", "img2" => psblogger_PATH."/assets/whatsapp/user2.jpg", "img3" => psblogger_PATH."/assets/whatsapp/user3.jpg", "num1" => "+2347000000000", "num2" => "+2347000000000", "num3" => "+2347000000000", "name1" => "Funmi Martins", "name2" => "James Alex", "name3" => "Segun Adewale", "pos1" => "Administrator", "pos2" => "IT Manager", "pos3" => "Sales Representative","btntxt"=>"Chat With Us"),$atts);
//display - grid,list,grid1otherlist
$howmany = $atts["howmany"];
$imgno = $atts["img"];
$img = psblogger_PATH."/assets/whatsapp/user".$imgno.".jpg";
$img1 = $atts["img1"];
$img2 = $atts["img2"];
$img3 = $atts["img3"];
$num1 = $atts["num1"];
$num2 = $atts["num2"];
$num3 = $atts["num3"];
$name1 = $atts["name1"];
$name2 = $atts["name2"];
$name3 = $atts["name3"];
$pos1 = $atts["pos1"];
$pos2 = $atts["pos2"];
$pos3 = $atts["pos3"];
$btntxt = $atts["btntxt"];

$img1 = ($imgno != '')?$img:$img1;

$output .= '<div id="whatstaffs" style="display:none;">';

if($howmany == '1'){

$output .= '<a href="https://web.whatsapp.com/send?phone='.$num1.'" target="_Blank" class="whatsflybtn" style="border-bottom:none;"><img src="'.$img1.'" class="whatsimg"><img src="'.psblogger_PATH.'/assets/whatsapp/icon.png" class="whatsicon whatsicon1"><div class="whatsapplbl">'.$name1.'<br>'.$pos1.' (+'.$num1.')</div></a>';

}elseif($howmany == '2'){
$output .= '<a href="https://web.whatsapp.com/send?phone='.$num1.'" target="_Blank" class="whatsflybtn"><img src="'.$img1.'" class="whatsimg"><img src="'.psblogger_PATH.'/assets/whatsapp/icon.png" class="whatsicon whatsicon1"><div class="whatsapplbl">'.$name1.'<br>'.$pos1.' (+'.$num1.')</div><br clear="all" /></a>';

$output .= '<a href="https://web.whatsapp.com/send?phone='.$num2.'" target="_Blank" class="whatsflybtn"><img src="'.$img2.'" class="whatsimg"><img src="'.psblogger_PATH.'/assets/whatsapp/icon.png" class="whatsicon whatsicon2"><div class="whatsapplbl">'.$name2.'<br>'.$pos2.' (+'.$num2.')</div><br clear="all" /></a>';

}elseif($howmany == '3'){
$output .= '<a href="https://web.whatsapp.com/send?phone='.$num1.'" target="_Blank" class="whatsflybtn"><img src="'.$img1.'" class="whatsimg"><img src="'.psblogger_PATH.'/assets/whatsapp/icon.png" class="whatsicon whatsicon1"><div class="whatsapplbl">'.$name1.'<br>'.$pos1.' (+'.$num1.')</div><br clear="all" /></a>';

$output .= '<a href="https://web.whatsapp.com/send?phone='.$num2.'" target="_Blank" class="whatsflybtn"><img src="'.$img2.'" class="whatsimg"><img src="'.psblogger_PATH.'/assets/whatsapp/icon.png" class="whatsicon whatsicon2"><div class="whatsapplbl">'.$name2.'<br>'.$pos2.' (+'.$num2.')</div><br clear="all" /></a>';

$output .= '<a href="https://web.whatsapp.com/send?phone='.$num3.'" target="_Blank" class="whatsflybtn"><img src="'.$img3.'" class="whatsimg"><img src="'.psblogger_PATH.'/assets/whatsapp/icon.png" class="whatsicon whatsicon3"><div class="whatsapplbl">'.$name3.'<br>'.$pos3.' (+'.$num3.')</div><br clear="all" /></a>';
}else{
$output .= '<a href="https://web.whatsapp.com/send?phone='.$num1.'" target="_Blank" class="whatsflybtn" style="border-bottom:none;"><img src="'.$img1.'" class="whatsimg"><img src="'.psblogger_PATH.'/assets/whatsapp/icon.png" class="whatsicon whatsicon1"><div class="whatsapplbl">'.$name1.'<br>'.$pos1.' (+'.$num1.')</div><br clear="all" /></a>';

}

$output .= '<i class="arrow-down"></i></div>';
$output .= '<a class="whatstaffsbtn" href="javascript:void();" onclick="if(document.getElementById(\'whatstaffs\').style.display === \'none\'){ document.getElementById(\'whatstaffs\').style.display = \'block\'; }else{ document.getElementById(\'whatstaffs\').style.display = \'none\'; } "><i class="fa fa-whatsapp" style="font-size:18px;"></i> '.$btntxt.'</a>';

return $output;
}
/////////////////////////////
///////////////// [psb-posts owl=true limit=10] /////////////////////////////////

function psblogger_list_posts($atts){
global $post,$rootfolder;

$atts = shortcode_atts(array("limitdesc" => "150", "showexcerpt" => "1", "limit" => "", "paging" => "-1", "mt" => "", "mb" => "", "mr" => "", "ml" => "", "width" => "", "height" => "50", "type" => "post", "category" => "", "order" => "DESC", "orderby" => "id", "owl" => false, "showads" => false),$atts);

$showexcerpt = $atts["showexcerpt"];
$category = $atts["category"];
$limitdesc = $atts["limitdesc"];
$limit = $atts["limit"];
$posttype = $atts["type"];
$cat = $atts["category"];
$paging = $atts["paging"];
$order = $atts["order"];
$orderby = $atts["orderby"];
$width = $atts["width"];
$height = $atts["height"];
$mb = $atts["mb"];
$mt = $atts["mt"];
$ml = $atts["ml"];
$mr = $atts["mr"];
$owl = $atts["owl"];
$showads = $atts["showads"];

$ads = (!$showads)?'':'<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><!-- 728x90, created 12/17/09 --><ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-1615105766149342" data-ad-slot="1483298212"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>';

if($width != ''){$width = 'width:'.$width.';';}
if($height != ''){$height = 'min-height:'.$height.';';}
if($mb != ''){$mb = 'margin-bottom:'.$mb.';';}
if($mt != ''){$mt = 'margin-top:'.$mt.';';}
if($mr != ''){$mr = 'margin-right:'.$mr.';';}
if($ml != ''){$ml = 'margin-left:'.$ml.';';}
if($owl){ $owliOpen = '<div class="item">'; $owliClose = '</div>'; $owlcOpen = '<div class="owl-carousel owl-theme">'; $owlcClose = '</div>'; $psgrid = "ps-gridowl"; }else{ $psgrid = "ps-grid"; }

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = array('posts_per_page' => $paging,'post_status' => 'publish', 'post_type' => $posttype, 'category_name' => $category, 'order' => $order, 'orderby' => $orderby, 'paged' => $paged);

$query = new WP_Query( $args );
if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
          
		  $query->the_post();
		  $id = get_the_id();
          $meta = get_post_meta($id,'');
		  $pic = get_the_post_thumbnail();
		  $comments = wp_count_comments($id);
		  $c++;
		  
		  if($pic == ''){$pic = '<img src="'.PSM_ASSETS.'images/noimage.png">';}
		  $output .= $owliOpen;
		  $output .= '<div class="'.$psgrid.'" style="'.$width.$height.$mt.$mb.$mr.$ml.'">';
		  $output .= '<div class="ps-img">'.$pic.'</div>';
		  $output .= '<div style="padding:5px 10px 10px 10px;">';
		  $output .= '<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
		  
		  if($showexcerpt == '1'){ $output .= psblogger_limitchar(get_the_excerpt(),$limitdesc); }
		  
		  $output .= '<div class="ps-comments">'.get_the_date().' |  Comment ('.$comments->total_comments.')</div>'; //  |  <a href="'.get_permalink().'" class="more">Read more</a>
		  $output .= '</div>';
		  $output .= '</div>';
		  $output .= $owliClose;
		  if($c == 6){ $output .= $ads; $c = 0;}
    }
	
	//$output .= posts_nav_link(' | ','<span class="prevnext">&laquo; PREVIOUS</span>','<span class="prevnext">NEXT &raquo;</span>');
	wp_reset_postdata();
} else {
    // none were found
}

return $owlcOpen.$output.$owlcClose;
}


////////////////////////////////////////
////////////////////////////////////////
add_shortcode("psb-posts","psblogger_list_posts");
add_shortcode("psb-liker","psblogger_liker");
add_shortcode("psb-request","psb_request_form");
add_shortcode("psb-testimony","psb_testimony_form");
add_shortcode("psb-blog","psblogger_blog");
add_shortcode("psb-health","psblogger_health");
//psb_list_testimony
add_shortcode("psb-list-testimony","psb_list_testimony");
add_shortcode("psb-whatschat","psblogger_whatsappchat");

//add_shortcode("psblogger-courses","psblogger_list_courses");
//add_shortcode("psblogger-getcourse","psblogger_course_details");
//add_shortcode("psblogger-emailer","psblogger_sendcourse_details");
//add_shortcode("psblogger-mfbvideo","psblogger_mfbvideo");
//add_shortcode("psblogger-manuallist","psblogger_manuallist");
//add_shortcode("psblogger-qapply","psblogger_quickapply");

add_filter( 'woocommerce_get_price_html', 'psb_woocommerce_hide_product_price', 10, 2 );
function psb_woocommerce_hide_product_price( $price,$product ) {
	$saleresp = 'http://mohost.com.ng/reals/sales-representative/';
	$salebtnstyle = 'font-size:12px;font-weight:bold;color:#666;padding:8px 12px;display:inline-block;border:#ccc solid 2px;border-radius:8px;';
	$hide_for_categories = array( 'special-offer' );
		
	if (is_shop() || is_product_category()) {
      if( has_term($hide_for_categories, 'product_cat', $product->get_id()) ){
	  	return $price;
	  }else{
	  	add_filter( 'woocommerce_is_purchasable', '__return_false');
		add_filter( 'woocommerce_cart_item_price', '__return_false' );
		add_filter( 'woocommerce_cart_item_subtotal', '__return_false' );
	  	return '';
	  }
    }else{
		if(is_product()){
			if( has_term($hide_for_categories, 'product_cat', $product->get_id()) ){
				return $price;
			}else{
				add_filter('woocommerce_is_purchasable', '__return_false');
				add_filter( 'woocommerce_cart_item_price', '__return_false' );
				add_filter( 'woocommerce_cart_item_subtotal', '__return_false' );
				return '<a href="'.$saleresp.'" style="'.$salebtnstyle.'">CONTACT SALES REP. FOR PRICE</a>';
			}
		}else{
			if( has_term($hide_for_categories, 'product_cat', $product->get_id()) ){
				return $price;
			}else{
				return '<a href="'.$saleresp.'" style="'.$salebtnstyle.'">Ask For Price</a>';
			}
		}
	}
}

?>