<?php
require_once('config.php');

//PDO Connection | 数据库连接
try{
	$dbc = new PDO('mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME.';charset=utf8mb4',DB_USER,DB_PASS);
	$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
	if(DEBUG_MODE)die($e->getMessage());
	die('Fail to Connect the Database.');
}

// Insert URL to database | 插入链接到数据库
function urlInsert($params){
	$url=$params['url'].'';
	$host=parse_url($url)['host'];
	if(empty($host)){
		$host=parse_url('http://'.$url)['host'];
		$url='http://'.$url;
	}
	$ip=trim(end(split(',',$_SERVER['HTTP_X_FORWARDED_FOR'])));
	
	do{
		$ukey=ukeyGen();
	}while(ukeyCheck($ukey));
	
	global $dbc;
	try{
		$stmt = $dbc->prepare("INSERT INTO `url` (`domain`, `url`, `ukey`, `ip`) VALUES 
							(:host, :url, :ukey, :ip)");
		$stmt->bindParam(':host',$host);
		$stmt->bindParam(':url',$url);
		$stmt->bindParam(':ukey',$ukey);
		$stmt->bindParam(':ip',$ip);
		$stmt->execute();

		if($stmt->rowCount()){
			return $ukey;
		}
		else{
			return false;
		}

	} catch (Exception $e) {
		if(DEBUG_MODE)die($e->getMessage());
		die('Fail to excute command');
	}
}

// Get the url by short key | 根据短代码获取原链接
function urlSelect($ukey){
	if(ukeyCheck($ukey)){
		global $dbc;
		try{
			$stmt = $dbc->prepare("SELECT `url` FROM `url` WHERE ukey = :ukey LIMIT 1");
			$stmt->bindParam(':ukey',$ukey);
			$stmt->execute();
		} catch (Exception $e) {
			if(DEBUG_MODE)die($e->getMessage());
		}
		$result=$stmt->fetch(PDO::FETCH_ASSOC);
		if(!empty(trim($result['url'])))return $result['url'];
		else return null;
	}

}

// Url short key generate | 短链接代码生成(去掉了容易混淆的字母)
function ukeyGen(){
	$s='23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
	$sLength=strlen($s)-1;
	$length=rand(MIN_UKEY_LENGTH,MAX_UKEY_LENGTH);
	$result='';
	for($i=0;$i<$length;$i++){
		$result.=$s[rand(0,$sLength)];
	}
	return $result;
}

// Check the Url short key exist | 短链接代码是否存在
function ukeyCheck($ukey){
	global $dbc;
	try{
		$stmt = $dbc->prepare("SELECT `ukey` FROM `url` WHERE ukey = :ukey LIMIT 1");
		$stmt->bindParam(':ukey',$ukey);
		$stmt->execute();
		
		if($result=$stmt->fetch(PDO::FETCH_ASSOC)){
			return true;
		} else {
			return false;
		}

	} catch (Exception $e) {
		if(DEBUG_MODE)die($e->getMessage());
	}
}

//404 Page | 404页面
function notfound(){
	die("<html><div id='box' style='background-image:url(\"https://ww4.sinaimg.cn/large/a15b4afegy1fpxnu2r0bkj207407sdft\");width: 256px;height: 280px;transform: translateY(-50%);margin: 0 auto;position: relative;top: 50%;'></div></html>");
}

//Json Render | Json格式化返回
function jsonRender($content){
	header("Content-Type:application/json; charset=UTF-8");
	echo json_encode($content);
	die();
}

