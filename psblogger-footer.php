<style>
#loading{ position:fixed; top:49%;left:49%; padding:5px 5px; border:#ddd solid 0px; background:none; border-radius:3px;display:none; z-index:2000;}
</style>
<div id="myModal" class="modal fade bs-example-modal-xs" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-xs">
    <div class="modal-content">
	<div class="modal-header"><h4 class="modal-title"><span id="modalhead">Important!</span><a class="close" data-dismiss="modal">&times;</a></h4></div>
      <!-- dialog body -->
      <div class="modal-body">
        <div id="modalcontent" style="padding:0;margin:0;">...</div>
      </div>
      <div class="modal-footer"></div> <!-- -->
    </div>
  </div>
</div>

<span id="loading"><img src="<?php echo PSCONTESTER_PATH.'fxn/loading.gif'; ?>" /></span>

<script type="text/javascript" src="<?php echo PSCONTESTER_PATH.'assets/js/jq110.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo PSCONTESTER_PATH.'assets/js/bootstrap.min.js'; ?>"></script>
<script>
showalert = function(message,t) {
if (message != ''){
if(t == 'success'){t='warning';}
	$('#msgbox').html('<div class="alert alert-'+t+'"><a class="close" data-dismiss="alert" style="text-decoration:none;">&times;</a><span>'+message+'</span></div>').slideDown(500).delay(10000).slideUp(500);
}
}

showalert("<?php echo $_GET[m]; ?>","success");

showmodal = function(message,h,b,f,w) {
		$('#myModal').modal('toggle');
		$('.modal-dialog').css({width: w});
		$('.modal-header').css({backgroundColor: b});
        $('#modalhead').html(h);
		$('#modalcontent').html(message);
		$('.modal-footer').html(f);
}

function loading(n){
	if(n == 1){$("#loading").fadeIn(10);}
	else{$("#loading").fadeOut(10);}
}

function popup(h,m,w,l,t){
	//loading(0);
	//$("#popup-box #title").fadeIn(10);
	if (h != ''){ $("#popup-box #title").html(h); }
	if (w == ''){ w = '400'; }
	if (l == ''){ l = '30'; }
	if (t == ''){ t = '35'; }
	if (m != ''){
		$("#popup-box #message").html(m);
		$("#popup-box").animate({"display": "block","width": w+"px","left": l+"%","top": "+"+t+"%"},500);
	}
}

function SendByAjax(qrydata,urllink,reloadlink){ 
	loading(1);
	$.ajax({
	crossOrigin: true,
    type: "POST",
    url: urllink,
    data: qrydata,
    cache: false,
    success: function(html){
		loading(0);
		res = html.split("<->");
		html = res[0];
		
		if (html == 'postremovesuccess'){
			$("#card-"+res[1]).hide();
			
		}else if (html == 'postinsertsuccess'){
			$("#pscoreplier-"+res[1]).prepend(res[2]);
		
		}else if (html == 'newpostinsertsuccess'){
			$("#pscoallposts").prepend(res[1]);
		
		}else if (html == 'postupdatesuccess'){
			$('#allmessages').prepend('<div class="msgbox success">Post successfully updated</div>');
			$('#myModal').modal('toggle');
		
		}else if (html == 'pscoinvitefriendsuccess'){
			$('#allmessages').prepend('<div class="msgbox success">Invitation successfully sent</div>');
			$('#myModal').modal('toggle');
		
		}else if (html == 'CONSTDELETEDC'){
			window.location.href = '?page=pscon_contestants&m=Record successfully deleted.';
		
		}else if (html == 'CONSTDELETEDP'){
			window.location.href = '?page=pscon_participants&m=Record successfully deleted.';
		
		}else if (html == 'CONSTDEACT'){
			window.location.href = '?page=pscon_contestants&m=Contestant successfully deactivated.';
		
		}else if (html == 'CONSTACT'){
			window.location.href = '?page=pscon_contestants&m=Contestant successfully activated.';
		
		}else if (html == 'CONSTHIDEPAY'){
			window.location.href = '?page=pscon_payments&m=Payment record successfully removed.';
		
		}else{
			alert(html);
			//showalert(html,"danger");
		}
	
	},error: function(jqXHR, textStatus, errorThrown) {
			loading(0);
			alert(errorThrown);
			//showalert(errorThrown,"danger");
	    }  
    });
}

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
$(".msgbox").slideDown(500).delay(10000).slideUp(500);
</script>

<script>
$(document).ready(function() {
	$(document).on("keydown","#postcontent",function() {
		var message = $("#postcontent").val();
		if (event.keyCode == 13) { //check other browser compatibility code
			if (message != ""){
				//$('#frm1').submit();
				var datas = "dwat=csubmitnewpost&postcontent="+message;
				SendByAjax(datas,"ajax-process.php","");
			}
			$("#postcontent").val('');
			return false;
		}
	});
	
	/////////////////////////////////////
	$(document).on("keydown",".postcomment",function() {
		var message = $(this).val();
		var theid = $(this).attr("id");
		if (event.keyCode == 13) { //check other browser compatibility code
			if (message != ""){
				var datas = "dwat=pscopostreply&id="+theid+"&comment="+message;
				SendByAjax(datas,"ajax-process.php","");
			}
			$(this).val('');
			return false;
		}
	});
	///////////////////////////
	
	$(document).on("click",".pscoremovepost",function() {
		var theid = $(this).attr("id");
		var datas = "dwat=pscodeletepost&id="+theid;
		SendByAjax(datas,"ajax-process.php","");
	});
	
	//////////////// INVITE FRIENDS //////////////////////
	
	$(document).on("click","#pscoinvitefriendbtn",function() {
		var femails = $("#pscofriendemails").val();
		if(femails == ''){
			alert("Enter your friend email(s).");
		}else{
			var datas = "dwat=pscoinvitefriend&femails="+femails;
			SendByAjax(datas,"ajax-process.php","");
		}
	});
	
	//////////////// INSERT IMAGE ////////////////////
	
	$(document).on("click","#pscoinsertimgbtn",function() {
		var v = $("#pscoinsertimg").val();
		$("#postcontent").val($("#postcontent").val()+'<img src=\''+v+'\' class=\'pscopostimg\'>');
		$('#myModal').modal('toggle');
	});
	
	////////////////// INSERT VIDEO //////////////////
	
	$(document).on("click","#pscoinsertvideobtn",function() {
		var v = $("#pscoinsertvideo").val();
		$("#postcontent").val($("#postcontent").val()+'<embed src=\''+v+'\' class=\'pscopostvideo\'></emded>');
		$('#myModal').modal('toggle');
	});
	
	/////////////// EDIT POST /////////////////////
	
	$(document).on("click",".pscoeditpost",function() {
		var theid = $(this).attr("id");
		var thecontent = $("#content-body-"+theid).html();
		showmodal('Edit the content below and click update button.<br><textarea name=\'pscoupdatepost\' id=\''+theid+'\' class=\'pscoupdatepost\'>'+thecontent+'</textarea>','Edit Post','','<a href=\'javascript:;\' id=\'pscoupdatepostbtn\' class=\'pscobtn\'>Update</a>','400px');
	});
	
	$(document).on("click","#pscoupdatepostbtn",function() {
		var theid = $(".pscoupdatepost").attr("id");
		var thecontent = $(".pscoupdatepost").val();
			var datas = "dwat=pscoupdatepost&id="+theid+"&content="+thecontent;
			SendByAjax(datas,"ajax-process.php","");
		$("#content-body-"+theid).html(thecontent);
	});
	
	////////////////////////////////////
	
	$(document).on("click",".pscocommentpost",function() {
		var theid = $(this).attr("id");
		$("#pscocommentdiv-"+theid).toggle();		
	});
	//////////////////////////////////
	
	$(document).on("click",".pscoshowmore",function() {
		var theid = $(this).attr("id");
		var datas = "dwat=showmorepost&id="+theid;
		$(".pscoshowmore").hide();
		$(".pscoloading").show();
			$.ajax({
			crossOrigin: true,
			type: "POST",
			url: "ajax-process.php",
			data: datas,
			cache: false,
			success: function(html){
				$(".pscoshowmorediv").hide();
				$("#pscoallposts").append(html);
			}
			});
	});
	
	///////////////////////////
	
	
});
</script>
<?php //mysql_free_result(); ?>