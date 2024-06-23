<?php
$rootfolder = site_url();
$psb_subfolder = "Reals";
$psb_companyname = "RealsGroup";
$psb_urlroot = "https://www.realsgroup.com/";
$psb_companyurl = "https://www.realsgroup.com";
$psb_companydomain = "www.realsgroup.com";
$psb_companyemail = "admin@realsgroup.com";

$googleads = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><!-- 728x90, created 12/17/09 --><ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-1615105766149342" data-ad-slot="1483298212"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>';

$psb_style1 = 'width:100%;padding:5px 10px; margin:0 0 5px 0 !important; border:#ddd solid 1px;border-radius:5px;background: rgb(240,240,240);background: linear-gradient(180deg, rgba(240,240,240,1) 0%, rgba(255,255,255,1) 35%, rgba(255,255,255,1) 100%);';

$psb_style2 = 'width:100%;padding:5px 10px; margin:0 0 5px 0 !important; border:#ddd solid 1px;border-radius:5px; height:70px !important;background: rgb(240,240,240);background: linear-gradient(180deg, rgba(240,240,240,1) 0%, rgba(255,255,255,1) 35%, rgba(255,255,255,1) 100%);';

$psb_style1a = 'width:100%;padding:10px 10px; margin:0 0 5px 0 !important; border:#ccc solid 1px;border-radius:5px;background: rgb(240,240,240);background: linear-gradient(180deg, rgba(240,240,240,1) 0%, rgba(255,255,255,1) 35%, rgba(255,255,255,1) 100%);';

$psb_style2a = 'width:100%;padding:10px 10px; margin:0 0 5px 0 !important; border:#ccc solid 1px;border-radius:5px; height:100px !important;background: rgb(240,240,240);background: linear-gradient(180deg, rgba(240,240,240,1) 0%, rgba(255,255,255,1) 35%, rgba(255,255,255,1) 100%);';

$psb_btn = 'background: rgb(255,102,0);background: linear-gradient(180deg, rgba(255,102,0,1) 0%, rgba(255,153,0,1) 100%);padding:5px 15px;border-radius:5px;color:#fff;font-size:12px;border:1px #f60 solid;';

$psb_sexes = array('M'=>'Male','F'=>'Female');
$psb_products = ["Analgesic","Anti-Ulcerant","Anti-Biotics","Anti-Diabetics","Anti-Emetic Suspension","Anti-Fungal","Anti-Helmintics","Anti-Histamine","Anti-Hypertensives","Anti-Infectives","Anti-Lipidemia","Anti-Malaria","Cold And Cough","Dietary Supplement","Nutritional Supplement"];
////////////////////////////////////////////////////////////////////////////

function psb_save_session($n,$v){
	$_SESSION["psb"][$n] = $v;
}

function psb_get_session($n){
	//global $wp_session;
	$r = !empty($_SESSION["psb"][$n])?$_SESSION["psb"][$n] : '';
	return $r;
}

function psb_RecordExist($sql){
	global $wpdb;
	$results = $wpdb->get_row($sql); //
	if(count($results) > 0){return true;}else{ return false;}
}

function psb_EmailExist($email,$table){
	global $wpdb;
	$result = $wpdb->get_row("SELECT id FROM ".psb_secure($table)." WHERE email = '".psb_secure($email)."'"); //
	if($result->id != ''){return true;}else{ return false;}
}

function psb_GetField($sql){
	global $wpdb,$psco_table_contestants;
	$result = $wpdb->get_row($sql);
	return $result->email;
}

function psb_limitchar($str,$n){
	if (strlen($str) <= $n){
		return $str;
	}else{ 
		return substr($str,0,$n);
	}
}

function psb_secure($str){
	//$str = mysql_escape_string($str);
	$srt = esc_sql(stripslashes_deep($str));
	return $str;
}

function psb_HashMyPassword($pass){
	$Encryptkey = 'WIF56735';
	$hash = md5($pass.$Encryptkey);
	return $hash;
}

function psb_redirectUrl($pg){
echo "<script>window.location.href = '".mysql_escape_string($pg)."'</script>";
}

function psb_sendemail($to,$subject,$msg) {
	$m = new MyMail();
	$m->SendMail($to,$subject,$msg);
}

function psb_emailer($to,$subject,$m){
global $psb_companyemail;
	ini_set("send_from","noreply@".$_SERVER['SERVER_NAME']);
	$mailheaders = "Content-type:text/html; charset=ISO-8859-1\n";
	$mailheaders .= "From: ".$psb_companyemail."\n";
	if (mail($to,$subject,$m,$mailheaders,"-f ".$psb_companyemail)){}
}

function psb_AlphaNumId($start=0,$strnum=8, $strtot=1) { 
		if ($strtot > 200){
			return 0;
		}else{
			for ($i=1; $i<=$strtot; $i++){
				$s = strtoupper(md5(uniqid(rand()."76KJG6TTS657",true))); 
				if ($guidText == ""){ $guidText = substr($s,$start,$strnum); }
				else{
				$guidText .= ",".substr($s,$start,$strnum);
				//substr($s,0,8) . '-' .substr($s,8,4) . '-' . substr($s,12,4). '-' . substr($s,16,4). '-' . substr($s,20);
				}
			} 
			return $guidText;
		}
}
	
function psb_NumId($start=0,$strnum=8, $strtot=1) { 
		if ($strtot > 200){
			return 0;
		}else{
			for ($i=1; $i<=$strtot; $i++){
				$s = strtoupper(uniqid(rand(1000000,9999999999)."TYY64DES657",true));
				$t = time();
				if ($guidText == ""){ 
					$guidText = substr($s,$start,$strnum);
				}else{
					$guidText .= ",".substr($s,$start,$strnum);
				}//substr($t,5,5).
			} 
			return $guidText;
		}
}
	
function psb_ordinal($number){
	$ends = array('th','st','nd','rd','th','th','th','th','th','th');
	if ((($number % 100) >= 11) && (($number % 100) <= 13))
		return $number.'th';
	else
	return $number.$ends[$number % 10];
}

function psb_getAge($d,$m,$y){	
	$myage = (date("md",date("U",mktime(0,0,0,$m,$d,$y))) > date("md")? ((date("Y") - $y) - 1):(date("Y") - $y));
	return $myage;
}

function psb_thisPage(){
	$p = split("/",$_SERVER['PHP_SELF']);
	$c = count($p);
	$p = $p[$c-1];
	$p = split(".php",$p);
	return $p[0];
}

function psb_isValidEmail($email){ 
	//$emailb = filter_var($email, FILTER_SANITIZE_EMAIL);
    //return filter_var($emailb, FILTER_VALIDATE_EMAIL);
	return preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email);
}

function psb_getip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function psb_timeago($timestamp) {
    $date = new \DateTime();
	$date->setTimestamp($timestamp);
	$interval = $date->diff(new \DateTime('now'));
	$y = $interval->format('%y');
	$m = $interval->format('%m');
	$d = $interval->format('%d');
	$h = $interval->format('%h');
	$i = $interval->format('%i');
	$s = $interval->format('%s'); 
	if($y > 0){$r .= $y.' years ';}
	if($m > 0){$r .= $m.' months ';}
	if($d > 0){$r .= $d.' days ';}
	if($h > 0){$r .= $h.' hrs ';}
	if($i > 0){$r .= $i.' mins ';}
	if($s > 0){$r .= $s.' secs ';}
	return $r;
}

function psb_uploader($target,$ufname,$prefix=''){
set_time_limit(0);
global $filepath,$filetype;

if (!is_dir($target)){
	mkdir($target,0755);
}else{
	if (!is_writable($target)){
		chmod($target, 0755); //0666
	}
}

$filetype = $_FILES[$ufname]['type'];
$Name  = basename($_FILES[$ufname]['name']);
$newname = time();
$ext = strrchr($Name, '.'); 
$getRname1 = explode('.',$Name);
$getRname = $getRname1[0];	

if($filetype == "application/octet-stream" || $filetype == "image/jpg" || $filetype == "image/jpeg" || $filetype == "image/pjpeg" || $filetype == "image/gif" || $filetype == "image/png" || $filetype == "application/pdf" || $filetype == "application/doc" || $filetype == "application/docx" || $filetype == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" || $filetype == "audio/mp3" || $filetype == "audio/mpeg" || $filetype == "audio/x-mpeg" || $filetype == "audio/x-mp3" || $filetype == "audio/mpeg3" || $filetype == "audio/x-mpeg3" || $filetype == "audio/mpg" || $filetype == "audio/x-mpg" || $filetype == "audio/x-mpegaudio" || $filetype == "audio/mp4" || $filetype == "audio/ogg"){
	
	$finalname = 'F'.$prefix.$ext; //$getRname.$ext
	move_uploaded_file($_FILES[$ufname]['tmp_name'],$target.$finalname);
	$filepath = $finalname;
}else{
	$filepath = ""; 
}
	return $filepath;
}
///////////////////////
function getFields($sql,$field){
	global $wpdb;
	
	if ($sql != ""){
	$rows = $wpdb->get_results($sql);
		if (count($rows) > 0){
			return $rows[0]->$field;
		}else{
			return "0";
		}
	}else{
		return "0";
	}
}
?>