<?php
//
// Main login page
//

include ('data/config.php');
include ('languages/'.$language);

if (getenv("HTTP_X_FORWARDED_FOR")) {
	$ip = getenv("HTTP_X_FORWARDED_FOR");
} else {
	$ip = getenv("REMOTE_ADDR");
}

$loginchek = false;

$nick = $_POST['nick'];
$nick = htmlentities($nick,ENT_QUOTES);
$nick = str_replace("\&#039;","&#039;", $nick);
$nick = str_replace('\&quot;','&quot;', $nick);
$nick = str_replace('$','&#36;', $nick);
$pass = $_POST['pass'];
$password = md5($pass);
$user = strtolower($nick);
	
$arch_admin = file('data/user_admin.php');

for ($i = 1; $i < count($arch_admin); $i++) {
	$p = explode("|",$arch_admin[$i]);
	$name = strtolower($p[1]);

	if ($password == $p[2] && $user == $name) {
		$loginchek = true;
		$username = $p[1];
	}
}

//Session cookie for 1 hour.

if ($loginchek) { 
	setcookie("nick",$username,time()+3600); 
	setcookie("pass",$password,time()+3600);
	
	?>
	<script type="text/javascript"> 
	location.href = "admin.php";
	</script> 
	<?
} else {

	//Error log script

	$arch_errors = file('data/error_log.php');
	$lines_e = count($arch_errors);

	$error_date = date("F d, Y, g:i:s A");

	if ($lines_e == 1) {
		$id = 1;
	} else {
		$p = explode("|",$arch_errors[$lines_e - 1]);
		$id = $p[0] + 1;
	}

	$inser = "$id|$lang_txt[22]|$error_date|$ip|\n";
	$fil = fopen('data/error_log.php', 'a');
	fwrite($fil, $inser);
	fclose($fil);

	?>
	<script type="text/javascript"> 
	location.href = "admin.php?action=login&error=1";
	</script> 
	<?
}
?>