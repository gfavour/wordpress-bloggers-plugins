<?php include("psblogger-headinc.php"); ?>
<div style=" width:98%;">
<h1 style="border-bottom:#ccc dotted 1px; margin-bottom:20px;">New Testimonials <a href="?page=psb_testimony" class="btn btn-sm btn-default" style="float:right;">Back to Testimony</a></h1>

<div id="msgbox"></div>
<div style="display:block; margin:10px 0; width:65%;">
<?php 
echo do_shortcode('[psb-testimony title="" description="" btnlabel="Submit"]'); 
?>
</div>

<br clear="all" /><br clear="all" />
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