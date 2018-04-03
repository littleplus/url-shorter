<?php
#print_r($_GET);
#print_r($_SERVER);
#die(var_dump($_SERVER));
require_once('config.php');
require_once('functions.php');

//PHP run time limit
set_time_limit(MAX_TIME_LIMIT);

//Domain Check | 域名检测
if(SITE_DOMAIN!=$_SERVER['HTTP_HOST']){
	header('Location:http://'.SITE_DOMAIN);
	exit();
}

//Regex get the key | 正则获取短代码
$shortCode=$_SERVER['REQUEST_URI'];
preg_match('/(?<=(\/))[0-9a-zA-Z]{'.MIN_UKEY_LENGTH.','.MAX_UKEY_LENGTH.'}(?=(\?|))/i',$shortCode,$matchResult);
$gUkey=trim($matchResult[0]);

//Mode Choose | 判断调用功能
if(!empty($gUkey)){
	require_once('redirect.php');
	redirect($gUkey);
}
else{
	if(trim($_GET['q'])!=''){
		require_once('shorten.php');
		shorten(trim($_GET['q']));
	}
	else{
		if($_SERVER['REQUEST_URI']!='/'){
			notfound();
		}
	}
}

//HTML Index | HTML首页
include('page.html');


