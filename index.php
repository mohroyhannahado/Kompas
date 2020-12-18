<?php
set_time_limit(0);

header("X-Robots-Tag: noindex, nofollow", true);
header('Access-Control-Allow-Origin: *');

function getImaged($url){
		$agent = "Mozilla/5.0 (Linux; U; Android 4.0.3; ".rand(0,9999)."; LG-L160L Build/IML".rand(0,9).") AppleWebkit/534.".rand(0,9)."0 (KHTML, like Gecko) Version/".rand(1,5).".".rand(1,9)." Mobile Safari/".rand(10,99)."4.30";
		$ch = curl_init ($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$resource = curl_exec($ch);
		curl_close ($ch);
		return $resource;
}
function diqirim($d){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,'https://ikan.nasihosting.com/');
	curl_setopt($ch, CURLOPT_POSTFIELDS, "has=".md5($d)."&bolb=".$d);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

if(isset($_GET['i']) AND !empty($_GET['i']))
{
	$dg = getImaged(base64_decode(trim($_GET['i'])));
	$bur = base64_encode(base64_encode($dg));
	$has = md5($bur);
	$dicek = diqirim($bur);
	if(isset($dicek) AND !empty($dicek) AND strpos($dicek, 'i0.wp.com/ikan.nasihosting.com') !== false){
		header('location: '.$dicek);
	}else{
		echo 'gagal';
	}
	exit;
}else{
	echo 'GET i';
}

?>