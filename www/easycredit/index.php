<?php
	$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$url = stristr($url, "?");

	if($lang == "uk"){
		header("Location: https://credit4u.site/easycredit/ua/{$url}");
	}else{
		header("Location: https://credit4u.site/easycredit/ru/{$url}");
	}


?>