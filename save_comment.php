<?php
//
// Action after button submission
//
session_start();

include ('data/config.php');
include ('languages/'.$language);

$error_l = '';

function errorlog($error_l, $ip_guest) {

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

	$inser = "$id|$error_l|$error_date|$ip_guest|\n";
	$fil = fopen('data/error_log.php', 'a');
	fwrite($fil, $inser);
	fclose($fil);
}

if (isset($HTTP_COOKIE_VARS["post"])) {

	?>
	<script type="text/javascript">
	location.href="index.php?ad=1"
	</script>
	<?

} else {

	$securiry_code = '';
	$nick = '';
	$web = '';
	$email = '';
	$comment = '';
	$location = '';
	$ip_guest = '';

	if ($_POST) {
		$nick = $_POST['nick'];
		$web = $_POST['web'];
		$email = $_POST['email'];
		  if (isset($_POST['location'])){
              $location = $_POST['location'];
          }        
		$comment = $_POST['comment'];
		$ip_guest = $_POST['ip_guest'];
          if (isset($_POST['seccode'])){
              $security_code = strtolower($_POST['seccode']);
          } 
		
	}

	//Strip out javascript and html elements.

	do {
		$oldstring = $nick;
		$nick = preg_replace('#</*(applet|meta|xml|blink|link|style|script|embed|object|iframe|frame|frameset|ilayer|layer|bgsound|title|base)[^>]*>#i',"", $nick);
	} while ($oldstring != $nick);

	do {
		$oldstring = $comment;
		$comment = preg_replace('#</*(applet|meta|xml|blink|link|style|script|embed|object|iframe|frame|frameset|ilayer|layer|bgsound|title|base)[^>]*>#i',"", $comment);
	} while ($oldstring != $comment);

	do {
		$oldstring = $web;
		$web = preg_replace('#</*(applet|meta|xml|blink|link|style|script|embed|object|iframe|frame|frameset|ilayer|layer|bgsound|title|base)[^>]*>#i',"", $web);
	} while ($oldstring != $web);

	do {
		$oldstring = $location;
		$location = preg_replace('#</*(applet|meta|xml|blink|link|style|script|embed|object|iframe|frame|frameset|ilayer|layer|bgsound|title|base)[^>]*>#i',"", $location);
	} while ($oldstring != $location);

	do {
		$oldstring = $email;
		$email = preg_replace('#</*(applet|meta|xml|blink|link|style|script|embed|object|iframe|frame|frameset|ilayer|layer|bgsound|title|base)[^>]*>#i',"", $email);
	} while ($oldstring != $email);

	$nick = preg_replace('#</*\w+:\w[^>]*>#i',"",$nick);
	$comment = preg_replace('#</*\w+:\w[^>]*>#i',"",$comment);
	$web = preg_replace('#</*\w+:\w[^>]*>#i',"",$web);
	$location = preg_replace('#</*\w+:\w[^>]*>#i',"",$location);
	$email = preg_replace('#</*\w+:\w[^>]*>#i',"",$email);
	$nick = htmlspecialchars($nick, ENT_QUOTES);
	$comment = htmlspecialchars($comment, ENT_QUOTES);
	$web = htmlspecialchars($web, ENT_QUOTES);
	$email = htmlspecialchars($email, ENT_QUOTES);
	$location = htmlspecialchars($location, ENT_QUOTES);

	//Spam filter in action here. :)

	$spam_log = 0;
	$arch_spam = file('data/spam_filter.php');
	$spamlog_lenght = count($arch_spam) - 1;
	$spam_str = array_reverse($arch_spam);

	for ($i = 0; $i < $spamlog_lenght; $i++) {
		$spamsearch = explode("|", $spam_str[$i]);
		if (preg_match($spamsearch[1], $web) || preg_match($spamsearch[1], $comment) || preg_match($spamsearch[1], $email) || preg_match($spamsearch[1], $location)) {
			$spam_log = 1;
		}
	}

	//Another SPAM protection.

	$spamcount = 0;

	if (preg_match("href|http", $comment)) {
		$spamcount = 1;
	}

	if ($ip_guest == '' || $ip_guest == 'unknown') {
		$spamcount = 1;
	}

	//checking for empty fields

	$badflag == 0;

	if ($nick == '' || $comment == '') {
		$badflag = 1;
	}

	$seccode = array();

	$sessioncode = '';

	$seccode = $_SESSION['scode'];

	for ($i = 0; $i < 4; $i++) {
		$sessioncode .= $seccode[$i];
	}

	$sessioncode = strtolower($sessioncode);

	$fielderror = 0;

	if ($show_seccode == 1) {
		$fielderror = 0;
	} else {

		//checking if security code is correct and paragraphs size

		if ($security_code == $sessioncode) {
			$paragraphs = explode("\n", $comment);
			$total_p = count($paragraphs);

			if (strlen($paragraphs[0]) > 80) {
				$comment = $comment.'<br /><br />';
			}

		} else {
			$fielderror = 1;
		}
	}

    echo "<h1>Checking Email = $email</h1> and regexp = ";
    if (
        preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)
        )
        echo "Regexp = true";
    exit;
    
	if ($spamcount == 1) {

		?>
		<script type="text/javascript">
		location.href="index.php?ad=7"
		</script>
		<?

	} elseif (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email) && !empty($email)) {

		?>
		<script type="text/javascript">
		location.href="index.php?ad=8"
		</script>
		<?

	} elseif ($spam_log == 1) {

		?>
		<script type="text/javascript">
		location.href="index.php?ad=6"
		</script>
		<?

	} elseif ($fielderror == 1) {
		$error_l = $lang_txt[76];
		errorlog($error_l, $ip_guest);

		?>
		<script type="text/javascript">
		location.href="index.php?ad=4"
		</script>
		<?
	} elseif ($total_p > $paragraphs_per_post) {

		$error_l = $lang_txt[56];
		errorlog($error_l, $ip_guest);

		?>
		<script type="text/javascript">
		location.href="index.php?ad=2"
		</script>
		<?

	} elseif ($badflag == 1) {
		?>
		<script type="text/javascript">
		location.href="index.php?ad=3"
		</script>
		<?
	} else {

		$c_time = $post_protection * 60;

		setcookie("post","post",time()+$c_time);

		$hm = $dt_gmt * 60;
		$hms = $hm * 60;

		$comment_date = gmdate("$date_format, $time_format", time()+($hms));

		$changesomechars = array('\&quot;','\&#039;','|','(',')',':','&amp;','$');
		$newchars = array('&quot;','&#39;','l','&#40;','&#41;','&#58;','&','&#36;');

		$web = str_replace($changesomechars, $newchars, $web);
		$nick = str_replace($changesomechars, $newchars, $nick);
		$email = str_replace($changesomechars, $newchars, $email);
		$location = str_replace($changesomechars, $newchars, $location);

		//Insert Smileys
		$comment = str_replace('[:)]','<img src="smileys/happy.gif" alt="happy" border="0" />', $comment);
		$comment = str_replace('[angry;]','<img src="smileys/angry.gif" alt="angry" border="0" />', $comment);
		$comment = str_replace('[??]','<img src="smileys/confused.gif" alt="confused" border="0" />', $comment);
		$comment = str_replace('[:(]','<img src="smileys/sad.gif" alt="sad" border="0" />', $comment);
		$comment = str_replace('[:X]','<img src="smileys/sick.gif" alt="sick" border="0" />', $comment);
		$comment = str_replace('[:D]','<img src="smileys/smile.gif" alt="smile" border="0" />', $comment);
		$comment = str_replace('[:P]','<img src="smileys/tongue.gif" alt="tongue" border="0" />', $comment);
		$comment = str_replace('[;)]','<img src="smileys/wink.gif" alt="wink" border="0" />', $comment);
		$comment = str_replace('[grin;]','<img src="smileys/grin.gif" alt="grin" border="0" />', $comment);
		$comment = str_replace('[cry;]','<img src="smileys/cry.gif" alt="cry" border="0" />', $comment);
		$comment = str_replace('[B)]','<img src="smileys/cool.gif" alt="cool" border="0" />', $comment);
		$comment = str_replace('[:/]','<img src="smileys/undecided.gif" alt="undecided" border="0" />', $comment);

		$comment = str_replace($changesomechars, $newchars, $comment);

		//Insert BBCode

		$bbcode_chars = array('[b]','[/b]','[s]','[/s]','[i]','[/i]','[font underline]','[tt]','[/tt]','[list]','[/list]','[li]','[/li]','[align=center]','[align=right]','[/align]','[sup]','[/sup]','[sub]','[/sub]','[font color=','[/font]',']');
		$htmlcode_chars = array('<b>','</b>','<del>','</del>','<i>','</i>','<span style="text-decoration: underline">','<tt>','</tt>','<ul>','</ul>','<li>','</li>','<div align="center">','<div align="right">','</div>','<sup>','</sup>','<sub>','</sub>','<span style="color:','</span>','">');

		$comment = str_replace($bbcode_chars, $htmlcode_chars, $comment);

		//censored words filter

		if ($allow_badwords == 1) {

			$arch_censored = file('data/censored_words.php');
			$censored_rows = count($arch_censored);

			for ($i = 1; $i < $censored_rows; $i++) {
				$c = explode("|",$arch_censored[$i]);
				$comment = str_replace($c[1],'*****', $comment);
				$nick = str_replace($c[1],'*****', $nick);
				$location = str_replace($c[1],'*****', $location);
			}
		}

		$arch_comments = file('data/comments.php');
		$lines = count($arch_comments);

		if ($lines == 1) {
			$id = 1;
		} else {
			$p = explode("|",$arch_comments[$lines - 1]);
			$id = $p[0] + 1;
		}

		if ($m_approval == 0)
			$approved = 1;
		else
			$approved = 0;

		$replacement = '<br /><br />';
		$comment = preg_replace("((\r\n)+)", $replacement, $comment);

		//Get the ip address again
		$ip_guest = $_SERVER['REMOTE_ADDR'];

		$inser="$id|$nick|$comment|$web|$comment_date|$ip_guest|$approved|$email|$location|\n";
		$fil = fopen('data/comments.php', 'a');
		flock($fil, 2);
		fwrite($fil,$inser);
		flock($fil, 3);
		fclose($fil);

		if ($email_notif == 0 && !empty($admin_email)) {

			//Proceed to send an email notification.
		
			$m_headers = "MIME-Version: 1.0\r\n";
			$m_headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$m_headers .= "From: $admin_email\r\n";

			mail($admin_email, $lang_txt[139], $lang_txt[140], $m_headers);
		}

		if ($m_approval == 0) {
			?>
			<script type="text/javascript">
			location.href="index.php?ad=5"
			</script>
			<?
		} else {
			?>
			<script type="text/javascript">
			location.href="index.php"
			</script>
			<?
		}
	}
}
