<?php

function template_sign($lang_txt, $title, $home_url, $home_name, $guest_lang, $id, $ip, $securitycode, $characters_per_post, $js_seccode) {

?>
<body>

<div id="container">

<!-- Template sign Begin -->

<div class="main">
	<p><b><? echo $title; ?></b></p>
</div>

<div class="header1">
	<a href="<? echo $home_url; ?>"><b><? echo $home_name; ?></b></a> | 
	<a href="index.php"><b><? echo $lang_txt[107]; ?></b></a>
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

<div class="table">
	<form name="signform" action="save_comment.php" method="post" onsubmit="javascript:if (document.signform.nick.value.length <= 0){alert('<? echo $lang_txt[14]; ?>'); document.signform.nick.select(); return false} if (document.signform.comment.value.length <= 0){alert('<? echo $lang_txt[15]; ?>'); document.signform.comment.select(); return false} if (document.signform.comment.value.length > <? echo $characters_per_post; ?>){alert('<? echo $lang_txt[55]; ?>'); document.signform.comment.select(); return false}<? echo $js_seccode; ?>">
		<input type="hidden" name="ip_guest" value="<? echo $ip; ?>" />
		<table>
			<tr><td colspan="2"><b><? echo $lang_txt[6]; ?></b><hr /></td></tr>
			<tr><td><? echo $lang_txt[7]; ?> </td><td><input type="text" name="nick" size="20" maxlength="18" /> <? echo $lang_txt[57]; ?> <b><? echo $ip; ?></b></td></tr>
			<tr><td><? echo $lang_txt[8]; ?>* </td><td>http:// <input type="text" name="web" size="35" maxlength="60" /></td></tr>
			<tr><td><? echo $lang_txt[121]; ?>* </td><td><input type="text" name="email" size="25" maxlength="50" /></td></tr>
			<!--<tr><td><? echo $lang_txt[122]; ?>* </td><td><input type="text" name="location" size="15" maxlength="15" /></td></tr>
            -->
			<tr><td>&nbsp;</td><td>
			<a href="javascript:change('[b][/b]')"><img src="bbcode/bold.gif" border="0" alt="bold" /></a>
			<a href="javascript:change('[i][/i]')"><img src="bbcode/italic.gif" border="0" alt="italic" /></a>
			<a href="javascript:change('[font underline][/font]')"><img src="bbcode/underline.gif" border="0" alt="underline" /></a>
			<a href="javascript:change('[s][/s]')"><img src="bbcode/del.gif" border="0" alt="del" /></a>
			<a href="javascript:change('[align=center][/align]')"><img src="bbcode/center.gif" border="0" alt="center" /></a>
			<a href="javascript:change('[align=right][/align]')"><img src="bbcode/right.gif" border="0" alt="right" /></a>
			<a href="javascript:change('[sup][/sup]')"><img src="bbcode/sup.gif" border="0" alt="sup" /></a>
			<a href="javascript:change('[sub][/sub]')"><img src="bbcode/sub.gif" border="0" alt="sub" /></a>
			<a href="javascript:change('[list][li][/li][li][/li][/list]')"><img src="bbcode/list.gif" border="0" alt="list" /></a>
			<a href="javascript:change('[tt][/tt]')"><img src="bbcode/teletype.gif" border="0" alt="teletype" /></a>
			<select name="color" class="cajatexto" onchange="javascript:if (document.signform.color.value != '-') {change('[font color='+document.signform.color.value+'][/font]'); }">
				<option value="-" selected="selected">Text Color</option>
				<option value="red">Red</option>
				<option value="blue">Blue</option>
				<option value="green">Green</option>
				<option value="yellow">Yellow</option>
				<option value="orange">Orange</option>
			</select>			
			</td></tr>
			<tr><td valign="top">
			<a href="javascript:change('[:)]')"><img src="smileys/happy.gif" border="0" alt="happy" /></a>
			<a href="javascript:change('[:D]')"><img src="smileys/smile.gif" border="0" alt="smile" /></a>
			<a href="javascript:change('[:(]')"><img src="smileys/sad.gif" border="0" alt="sad" /></a><br />
			<a href="javascript:change('[;)]')"><img src="smileys/wink.gif" border="0" alt="wink" /></a>
			<a href="javascript:change('[:P]')"><img src="smileys/tongue.gif" border="0" alt="tongue" /></a>
			<a href="javascript:change('[??]')"><img src="smileys/confused.gif" border="0" alt="confused" /></a><br />
			<a href="javascript:change('[angry;]')"><img src="smileys/angry.gif" border="0" alt="angry" /></a>
			<a href="javascript:change('[:X]')"><img src="smileys/sick.gif" border="0" alt="sick" /></a>
			<a href="javascript:change('[grin;]')"><img src="smileys/grin.gif" border="0" alt="grin" /></a><br />
			<a href="javascript:change('[cry;]')"><img src="smileys/cry.gif" border="0" alt="cry" /></a>
			<a href="javascript:change('[B)]')"><img src="smileys/cool.gif" border="0" alt="cool" /></a>
			<a href="javascript:change('[:/]')"><img src="smileys/undecided.gif" border="0" alt="undecided" /></a>
			</td>
			<td><textarea name="comment" cols="60" rows="5"></textarea></td>
			</tr>
<? echo $securitycode; ?>
			<tr><td>&nbsp;</td><td><input type="submit" value="<? echo $lang_txt[10]; ?>" name="submit" /> <input type="reset" value="<? echo $lang_txt[11]; ?>" /></td></tr>
		</table>
	</form>
<p>* <? echo $lang_txt[12]; ?><br />
<? echo $lang_txt[13]; ?><br />
<? echo $lang_txt[132]; ?></p>

</div>

<!-- Template sign End -->
<?

}

?>