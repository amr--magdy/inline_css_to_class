<?php
$variable_name = "page_name_";
$file_name = "file.txt";
$file_name_out = "file2.php";

/***********************************************************************************************/
$full_page = file_get_contents($file_name);
$css_file = "";
$full_page = str_replace("<?php","php%php",$full_page);
$full_page_tag = explode("<",$full_page);
foreach ($full_page_tag as &$value) {
//    $value = explode(">",$value);
}
$counter = 1;
$full_page = "";
for ( $i = 0; $i < count($full_page_tag) ;$i++){
	$exist_style = strpos($full_page_tag[$i],"style=");
	if ( $exist_style ){
			$style_part = explode('style="',$full_page_tag[$i]);
			$style = explode('"',$style_part[1]);
			$style = $style[0];
			$exist_id = strpos($full_page_tag[$i],"id=");
			$exist_class = strpos($full_page_tag[$i],"class=");
			$exist_php = strpos($style,'php%php');
			if ( $exist_php > 0 )
			$exist_php = true;
			else
			$exist_php = false;
			if ( (!$exist_id && !$exist_class) || (!$exist_id && $exist_class) && $style != "display:none;"&&$style!="display:none" && !$exist_php ){
				$full_page_tag[$i] = str_replace('style="'.$style.'"','id="'.$variable_name.$counter.'"',$full_page_tag[$i]);
				$css_file .= "#".$variable_name.$counter.'{
'.$style.'}
';
				$counter++;
			}
			else if ( $exist_id && !$exist_class && $style != "display:none;"&&$style!="display:none" && !$exist_php  ){
				$full_page_tag[$i] = str_replace('style="'.$style.'"','class="'.$variable_name.$counter.'"',$full_page_tag[$i]);
				$css_file .= ".".$variable_name.$counter.'{
'.$style.'
}
';
				$counter++;
			}
			else if ( $exist_id && $exist_class && $style != "display:none;"&&$style!="display:none" && !$exist_php  ){
				$full_page_tag[$i] = str_replace('style="'.$style.'"',"",$full_page_tag[$i]);
				$full_page_tag[$i] = str_replace('class="','class="'.$variable_name.$counter." ",$full_page_tag[$i]);
				$css_file .= ".".$variable_name.$counter.'{
'.$style.'
}
';
				$counter++;
			}
	}
	$full_page .= '<'.$full_page_tag[$i];

}
$full_page = str_replace("php%php","<?php",$full_page);

file_put_contents($file_name_out,$full_page);
file_put_contents("style.css",$css_file);
?>
