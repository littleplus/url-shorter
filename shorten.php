<?php

function shorten($url){
	$result=['error'=>0,'ukey'=>null];

	$ukey=urlInsert(['url'=>$url]);
	if(!$ukey){
		$result['error']=1;
	}
	else{
		$result['ukey']=$ukey;
	}

	jsonRender($result);
}
