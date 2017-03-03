<?php

function template_index_header($lang_txt, $title, $home_url, $home_name, $gb_author, $gb_comment, $gb_date, $guest_lang, $id, $comments_rows, $page, $totalp, $pagstring) {

?>
<body>

<div id="container">

<!--
Default template
-->

<!-- Template index_header Begin -->

<div class="main">
	<p><b><? echo $title; ?></b></p>
</div>

<div class="header1">
	<a href="<? echo $home_url; ?>"><b><? echo $home_name; ?></b></a> | 
	<a href="sign.php"><b><? echo $lang_txt[82]; ?></b></a>
</div>

<div class="langbox">
	<form name="formlang" action="change_lang.php" method="post">
		<input type="hidden" name="id" value="<? echo $id; ?>" />
<? echo $lang_txt[101]; ?> &nbsp;
		<select name="lang" onchange="formlang.submit()">
<?

$dir = 'languages';

if (is_dir($dir)) {

	if ($dh = opendir($dir)) {

		while (($file = readdir($dh)) != false) {

			if ($file != '.' && $file != '..' && $file != 'index.php') {
				$file_d = explode(".", $file);
				$s_lang = explode(".", $guest_lang);

				if ($s_lang[0] == $file_d[0]) {
					echo '<option value="'.$file.'" selected="selected">'.$file_d[0].'</option>';
				} else {
					echo '<option value="'.$file.'">'.$file_d[0].'</option>';
				}
			}
		}
		closedir($dh);
	}
}

?>
		</select>
	</form>
</div>

<div class="header2">
	<b><? echo $lang_txt[3]; ?> <? echo $comments_rows; ?> | <? echo $lang_txt[117]; ?> <? echo $page; ?> <? echo $lang_txt[118]; ?> <? echo $totalp; ?></b>
</div>

<div class="pages">
	<? echo $pagstring; ?>
</div>

<!-- Template index_header End -->
<?

}

?>
