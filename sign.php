<?php
//---------------------------------------------------------------------
// Main page of insertion
//---------------------------------------------------------------------
session_start();

ini_set('arg_separator.output','&amp;');

include ('header.php');

if ($gb_offline == 0) {

	echo $gb_message;

} elseif ($banned == 1) {

	echo $lang_txt[58];

} else {

	$ad = 0;
	$action = '';
	$id = '';

	if ($_GET) {
		$ad = htmlentities($_GET['ad'], ENT_QUOTES);
		$action = htmlentities($_GET['action'], ENT_QUOTES);
	}

	//Security code
	$randcode = array();
	$_SESSION['scode'] = '';

	for ($i = 0; $i < 4; $i++)   {
		$randcode[$i] = substr('ACDEFGHJKLMNPRTXY123479', rand(0,22), 1);
	}

	$_SESSION['scode'] = $randcode;

	if ($show_seccode == 0) {
		$securitycode = '<tr><td>'.$lang_txt[74].'</td><td valign="top"><img src="image.php" alt="'.$lang_txt[74].'" title="'.$lang_txt[74].'" style="border: 1px solid #000000" /><p /><input type="text" name="seccode" size="4" maxlength="4" /></td></tr>';
		$js_seccode = ' if (document.signform.seccode.value.length <= 0){alert(\''.$lang_txt[75].'\'); document.signform.seccode.select(); return false}';
	} else {
		$securitycode = '';
		$js_seccode = '';
	}

	$id = 'sign';
	include ('templates/'.$template.'/template_sign.php');
	template_sign($lang_txt, $title, $home_url, $home_name, $guest_lang, $id, $ip, $securitycode, $characters_per_post, $js_seccode);

	include ('templates/'.$template.'/template_footer.php');
	template_footer($gb_version);
}
?>