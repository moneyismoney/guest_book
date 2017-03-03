<?php

// Check headers

include ('data/config.php');

if (isset($HTTP_COOKIE_VARS["lang"])) {
	$guest_lang = $HTTP_COOKIE_VARS["lang"];

	$lang_filename = 'languages/'.$HTTP_COOKIE_VARS["lang"];

	if (is_file($lang_filename)) {
		include ('languages/'.$guest_lang);
	} else {
		$guest_lang = $language;
		include ('languages/'.$language);
	}
} else {
	$guest_lang = $language;
	include ('languages/'.$language);
}

$ip = $_SERVER['REMOTE_ADDR'];

$ip_g = explode(".", $ip);
$ip_1 = $ip_g[0].'.*.*.*';
$ip_2 = $ip_g[0].'.'.$ip_g[1].'.*.*';
$ip_3 = $ip_g[0].'.'.$ip_g[1].'.'.$ip_g[2].'.*';

$banned = 0;

//Checking ban IPs

$arch_ip = file('data/ban_ip.php');
$ip_rows = count($arch_ip);

for ($i = 1; $i < $ip_rows; $i++) {
	$p_ip = explode("|", $arch_ip[$i]);

	if ($p_ip[1] == $ip || $p_ip[1] == $ip_1 || $p_ip[1] == $ip_2 || $p_ip[1] == $ip_3) {
		$banned = 1;
		$i = $ip_rows + 1;
	}
}

if ($gb_offline == 0) {

	echo '&nbsp;';

} elseif ($banned == 1) {

	echo '&nbsp;';

} else {

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="<? echo $lang_txt[1]; ?>" lang="<? echo $lang_txt[1]; ?>">
<head>
<title><? echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<? echo $lang_txt[0]; ?>" />
<script src="functions.js" type="text/javascript"></script>
<link href="templates/<? echo $template; ?>/style.css" rel="stylesheet" type="text/css" />
<?

if ($guest_lang == 'arabic.inc') {
	echo '<!-- Special style format for arabic language --><style>#container { text-align:right; direction:rtl; }</style>'."\n";	
}

?>
</head>

<!--
Only for test task
-->
<?

}

?>