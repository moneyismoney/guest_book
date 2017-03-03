<?php

function template_showcomment($lang_txt, $gb_author, $gb_comment, $gb_date, $gb_location, $gb_email, $gb_web) {

?>
<div class="message"><? echo $gb_comment; ?></div>
<div class="info"><img src="templates/default/images/post.gif" alt="post"/> <? echo $lang_txt[4]; ?> <b><? echo $gb_author; ?></b><? echo $gb_location; ?><? echo $gb_email; ?><? echo $gb_web; ?> - <? echo $gb_date; ?></div>
<?

}

?>