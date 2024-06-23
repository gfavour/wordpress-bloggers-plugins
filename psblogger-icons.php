<?php
function psb_icons_incfiles(){
	wp_register_style('psbfontawesome_icons',psblogger_PATH.'assets/fontawesome450/css/font-awesome.min.css');
	wp_enqueue_style('psbfontawesome_icons');
}
add_action( 'wp_enqueue_scripts', 'psb_icons_incfiles' );

add_shortcode("psblogger-icon","psb_icons_handler");

//By category..........
//[ps-icon icon="fa-facebook" color="#fff" bg="#fff"]
function psb_icons_handler($atts){
$atts = shortcode_atts(array("icon" => "", "link" => "#","color" => "#fff","bg" => "#888","size" => "18","l_space" => "3","r_space" => "3","t_space" => "3","b_space" => "3","round" => "3","pad" => "10px"),$atts);

$icon = $atts["icon"];
$link = $atts["link"];
$color = 'color:'.$atts["color"].';';
$bg = 'background-color:'.$atts["bg"].';';
$size = 'font-size:'.$atts["size"].'px;';
$round = 'border-radius:'.$atts["round"].'px;';
$padding = 'padding:'.$atts["pad"].';';

$lspace = $atts["l_space"];
$rspace = $atts["r_space"];
$tspace = $atts["t_space"];
$bspace = $atts["b_space"];

//start coding.......
if ($icon == ''){
$output = "";
}else{

if ($lspace != ''){$margin .= 'margin-left:'.$lspace.'px;';}
if ($rspace != ''){$margin .= 'margin-right:'.$rspace.'px;';}
if ($tspace != ''){$margin .= 'margin-top:'.$tspace.'px;';}
if ($bspace != ''){$margin .= 'margin-bottom:'.$bspace.'px;';}

if($link == '' || $link == '#'){$link = '#';}
if ($bg == '-' || $bg == ''){$bg = '';}
$output .= '<a href="'.$link.'" style="display:inline-block;margin:2px;'.$round.$margin.$color.$bg.$size.$padding.'" class="fa '.$icon.'"></a>';
}

return $output;
}

?>