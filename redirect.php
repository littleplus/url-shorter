<?php

function redirect($ukey){
	if(!ukeyCheck($ukey))notfound();

	$url=urlSelect($ukey);
	die(header("Location: $url"));
}
