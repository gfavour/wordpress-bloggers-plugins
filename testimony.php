<?php include("psblogger-headinc.php"); ?>
<?php
function navPerPage($sql){
global $wpdb;
$post_per_page = 50;
$page  = isset( $_GET['pg'] ) ? abs( (int) $_GET['pg'] ) : 1;
$start = ( $page * $post_per_page ) - $post_per_page;

$num_of_total_posts  = $wpdb->get_results($sql);
$total = $wpdb->num_rows; // Get Total number of posts

$rows  = $wpdb->get_results($sql." LIMIT ".$start.",".$post_per_page);

if($total > 0){
	echo '<table class="styletbl" width="100%" border="0" cellpadding="0" cellspacing="0"><tr class="tblhead">
  <td>SN</td>
  <td>Name</td>
  <td>Phone No.</td>
  <td>Email</td>
  <td>Message</td>
  <td>Date/Time</td>
  <td>Action</td>
</tr>';
//Start Loop 

foreach($rows as $row){	
	$id = $row->id;
	$c++;
	$rowno = $c + $start;
	//$editbtn = '<a href="javascript:;" class="label label-default">Edit</a>';
	$delbtn = '<a href="javascript:if(confirm(\'Are you sure you want to remove selected record from list?\')){ };" class="label label-danger">Delete</a>';
	
	echo '<tr><td width="5%">'.$rowno.'</td>
<td width="10%">'.$row->title.' '.$row->lastname.' '.$row->firstname.'</td>
<td width="10%">'.$row->phone.'</td>
<td width="10%">'.$row->email.'</td>
<td width="40%">'.$row->message.'</td>
<td width="10%">'.date("d/m/Y h:i A",$row->regdate).'</td>
<td width="5%" align="center">'.$delbtn.'</td>
</tr>';
}

// PAGINATION HERE IN NICE BOOTSTRAP STYLES
echo '<div class="pagination">';
echo paginate_links( array(
'base' => add_query_arg( 'pg', '%#%' ),
'format' => '',
'prev_text' => __('&laquo;'),
'next_text' => __('&raquo;'),
'total' => ceil($total / $post_per_page),
'current' => $page,
'type' => 'list'
));
echo '</div>';

}else{
	echo '<div style="color:#f5f5f5;font-size:80px;padding:30px;text-align:center;">No testimony</div>';
}
}
?>
<div style=" width:98%;">
<h1 style="border-bottom:#ccc dotted 1px;">Testimonials<a href="?page=psb_testimony&subdwat=add" class="btn btn-sm btn-info" style="float:right;">Add New Testimony</a></h1>
<div id="msgbox"></div>
<?php 
navPerPage("SELECT * FROM ".psb_secure($psbTbltestimony)." ORDER BY id DESC ");
?>


<br clear="all" />
</div>
<style>
.styletbl{width:99%;border:#ccc solid 1px;}
.styletbl td{padding:3px 5px; border:#ccc solid 1px;}
.styletbl tr.tblhead td{ background:#ccc; font-weight:bold;}

.pagination ul.page-numbers,.pagination .page-numbers li{display:inline-block !important; list-style:none !important;}
.pagination .page-numbers li span{margin:0; padding:0;}
.pagination a.page-numbers, .pagination span.page-numbers{font-size:12px; display: inline-block; padding:5px 10px;margin: 0 2px 0 0; background:#f5f5f5; color:#333 !important; border:#eee solid 1px !important; border-radius:3px !important; text-decoration:none !important;}
.pagination span.current{background:#FF6600 !important; color:#fff !important; border:#f60 solid 1px !important; font-size:12px !important; display: inline-block !important;padding:5px 10px !important;margin: 0 2px 0 0 !important;}

</style>
<?php include("psblogger-footer.php"); ?>