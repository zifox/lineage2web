<?php
//пароль
if(!defined('INCONFIG')){Header("Location: ../index.php"); die();}

function is_theme($theme) {
	return file_exists("themes/$theme/head.php") && file_exists("themes/$theme/foot.php");
}

function get_themes() {
	$handle = opendir("themes");
	$themelist = array();
	while ($file = readdir($handle)) {
		if (is_theme($file) && $file != "." && $file != "..") {
			$themelist[] = $file;
		}
	}
	closedir($handle);
	sort($themelist);
	return $themelist;
}

function theme_selector($sel_theme = "", $use_fsw = false) {
	global $DEFAULTBASEURL;
	$themes = get_themes();
	$content = "<select name=\"theme\"".($use_fsw ? " onchange=\"window.location='$DEFAULTBASEURL/changetheme.php?theme='+this.options[this.selectedIndex].value\"" : "").">\n";
	foreach ($themes as $theme)
		$content .= "<option value=\"$theme\"".($theme == $sel_theme ? " selected" : "").">$theme</option>\n";
	$content .= "</select>";
	return $content;
}

function select_theme() {
	global $default_theme;
	if ($user->logedin())
		$theme = $CURUSER["theme"];
	else
		$theme = $default_theme;
	if (!is_theme($theme))
		$theme = $default_theme;
	return $theme;
}
?>