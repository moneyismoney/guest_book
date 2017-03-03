<?php
//
// Start (index) page
//

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

$page = 1;

if (isset($_GET['page'])) {
	$page = htmlentities($_GET['page'], ENT_QUOTES);
}

//Function email protection

function coded_email ($email) {

	$coded = bin2hex("$email");
	$coded = chunk_split($coded, 2, '%');
	$coded = '%' . substr($coded, 0, strlen($coded) - 1);
	return $coded;
}

//Pagination function

function show_pages($comments_per_page, $comments_rows, $lang_txt, $page) {

	$pagination = '';

	if ($comments_per_page < $comments_rows) {
		$pages = ceil($comments_rows / $comments_per_page);

		if ($pages >= $page) {

			if ($page == 1) {
				$pag = $page + 1;
				$pagination = '<a href="index.php?page='.$pag.'"><b>'.$lang_txt[120].'</b></a> | <a href="index.php?page='.$pages.'"><b>&raquo;</b></a>';
			} elseif ($page == $pages) {
				$pag = $page - 1;
				$pagination = '<a href="index.php?page=1"><b>&laquo;</b></a> | <a href="index.php?page='.$pag.'"><b>'.$lang_txt[119].'</b></a>';
			} else {
				$pag = $page - 1;
				$pag2 = $page + 1;
				$pagination = '<a href="index.php?page=1"><b>&laquo;</b></a> | <a href="index.php?page='.$pag.'"><b>'.$lang_txt[119].'</b></a> | <a href="index.php?page='.$pag2.'"><b>'.$lang_txt[120].'</b></a> | <a href="index.php?page='.$pages.'"><b>&raquo;</b></a>';
			}
		}
	}

return($pagination);
}

	$id = 'view';
	$limit = $page * $comments_per_page;
	$show = $limit - $comments_per_page;
	$arch_comments = file('data/comments.php');
	$comments_rows = count($arch_comments) - 1;
	$invertresults = array_reverse($arch_comments);
	$arraycomments = array();

	for ($i = 0; $i < $comments_rows; $i++) {
		$p_c = explode("|", $invertresults[$i]);

		if (!empty($p_c[2])) {

			if ($p_c[6] == "\n" || $p_c[6] == 0) {
				$arraycomments[] = $invertresults[$i];
			}
		}
	}

	$comments_rows = count($arraycomments);
	$totalp = ceil($comments_rows / $comments_per_page);
	include ('templates/'.$template.'/showcomment.php');
	$pagstring = show_pages($comments_per_page, $comments_rows, $lang_txt, $page);

	include ('templates/'.$template.'/template_index_header.php');
	template_index_header($lang_txt, $title, $home_url, $home_name, $gb_author, $gb_comment, $gb_date, $guest_lang, $id, $comments_rows, $page, $totalp, $pagstring);

	for ($i = $show; $i < $comments_rows && $i < $limit; $i++) {

		$p = explode("|", $arraycomments[$i]);
		$gb_author = $p[1];
		$gb_comment = $p[2];
		$web = $p[3];
		$gb_date = $p[4];
		$mail = $p[7];
		$location = $p[8];

		if (!empty($location)) {
			if ($location == "\n")
				$bg_location = '';
			else
				$gb_location = ' ('.$location.')';
		} else {
			$gb_location = '';
		}

		if (!empty($mail)) {
			if ($mail == "\n")
				$bg_email = '';
			else {
				$email = coded_email($mail);
				$gb_email = ' <a class="author" href="mailto:'.$email.'"><img src="templates/'.$template.'/images/email.gif" alt="Email" title="Email"/></a>';
			}
		} else {
			$gb_email = '';
		}

		if (!empty($web)) {
			if ($web == "\n")
				$bg_web = '';
			else
				$gb_web = ' <a href="http://'.$web.'"><img src="templates/'.$template.'/images/www.gif" alt="Website" title="Website"/></a>';
		} else {
			$gb_web = '';
		}


		template_showcomment($lang_txt, $gb_author, $gb_comment, $gb_date, $gb_location, $gb_email, $gb_web);
	}

	if ($ad == 1) {
		?>
		<script type="text/javascript">
		alert("<? echo $lang_txt[16]; ?>");
		</script>
		<?
	} elseif ($ad == 2) {
		?>
		<script type="text/javascript">
		alert("<? echo $lang_txt[56]; ?>");
		</script>
		<?
	} elseif ($ad == 3) {
		?>
		<script type="text/javascript">
		alert("<? echo $lang_txt[68]; ?>");
		</script>
		<?
	} elseif ($ad == 4) {
		?>
		<script type="text/javascript">
		alert("<? echo $lang_txt[76]; ?>");
		</script>
		<?
	} elseif ($ad == 5) {
		?>
		<script type="text/javascript">
		alert("<? echo $lang_txt[115]; ?>");
		</script>
		<?
	} elseif ($ad == 6) {
		?>
		<script type="text/javascript">
		alert("<? echo $lang_txt[143]; ?>");
		</script>
		<?
	} elseif ($ad == 7) {
		?>
		<script type="text/javascript">
		alert("<? echo $lang_txt[144]; ?>");
		</script>
		<?
	} elseif ($ad == 8) {
		?>
		<script type="text/javascript">
		alert("<? echo $lang_txt[142]; ?>");
		</script>
		<?
	}

	include ('templates/'.$template.'/template_index_footer.php');
	template_index_footer($lang_txt, $title, $home_url, $home_name, $gb_author, $gb_comment, $gb_date, $guest_lang, $id, $comments_rows, $page, $totalp, $pagstring);

	include ('templates/'.$template.'/template_footer.php');
	template_footer($gb_version);
}
?>