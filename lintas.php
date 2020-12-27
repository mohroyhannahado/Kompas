<?php
session_start();

function ScrapeBRH($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 1 tidak tampil
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_REFERER, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.102 Safari/537.36');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'accept: */*',
    'accept-language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7,ru;q=0.6,da;q=0.5,mt;q=0.4,pt;q=0.3,de;q=0.2',
    'referer: '.$url,
    'dnt: 1',
    'pragma: no-cache'
));
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

function klindesk($d)
{
	$d = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $d);
	$d = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $d);
	$d = preg_replace('/(<[^>]+) height=".*?"/i', '$1', $d);
	$d = preg_replace('/(<[^>]+) width=".*?"/i', '$1', $d);
	$d = preg_replace('/(<[^>]+) class=".*?"/i', '$1', $d);
	$d = preg_replace('/(<[^>]+) id=".*?"/i', '$1', $d);
	$d = strip_tags($d, '<table><tr><td><th><tbody><img><br>');
	$d = str_replace('//', 'https://i0.wp.com/', $d);
	$d = str_replace('https://', 'https://i0.wp.com/', $d);
	$d = str_replace('https:https://i0.wp.com/i0.wp.com/', 'https://i0.wp.com/', $d);
	$d = str_replace('https://i0.wp.com/i0.wp.com/', 'https://i0.wp.com/', $d);
	for($u=1;$u<=7;$u++){
		$d = str_replace('  ', ' ', $d);
	}
	$d = str_replace(' >', '>', $d);
	return $d;
}

function PostMobileBRH($pat, $isidata)
{
	$agent = "Mozilla/5.0 (Windows NT 6.".rand(1,9)."; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/7".rand(1,9).".".rand(1,9).".3".rand(10,99)."4.70 Safari/".rand(100,999).".36";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://lintas.pw/pos.php');
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, array($pat => $isidata));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 1 tidak tampil
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
	curl_setopt($ch, CURLOPT_VERBOSE, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

if(isset($_GET['id']))
{
	$dt = ScrapeBRH('https://www.aliexpress.com/item/'.$_GET['id'].'.html');
	$ex1 = explode('data: ', $dt);
	$ex2 = explode("csrfToken: '", $ex1[1]);
	$isine = trim($ex2[0]);
	if(substr($isine, -1)==',')
	{
		$djs = json_decode(substr_replace($isine, "", -1), true);
		//$deskc = klindesk(ScrapeBRH($djs['descriptionModule']['descriptionUrl']));
		$ked = $djs['pageModule']['keywords'];
		$spek = array();
		foreach($djs['specsModule']['props'] as $pr)
		{
			$spek[] = array($pr['attrName'], ucfirst($pr['attrValue']));
		}
		shuffle($spek);
		$spek = json_encode($spek);
		$gbre = array();
		foreach($djs['imageModule']['imagePathList'] as $iml)
		{
			$gbre[] = klindesk($iml);
		}
		shuffle($gbre);
		$gbre = json_encode($gbre);
		
		//echo "$gbre<br><br><br>$ked<br>$spek";
		echo PostMobileBRH('isi', json_encode(array($_GET['id'], $gbre, $spek, $ked)));
	}
	exit;
}else{
	//$dt = ScrapeBRH('https://www.aliexpress.com/category/200001115/swimming.html?trafficChannel=main&catName=swimming&CatId=200001115&ltype=wholesale&SortType=price_asc&minPrice=20&maxPrice=90000&page=1&groupsort=1');
	include "kwd.php";
	
	$page = 1;
	if(isset($_GET['page']) AND is_numeric($_GET['page']))
	{
		$pagen = $_GET['page']+1;
		$page = $_GET['page'];
	}else{
		$pagen = $page;
	}
	if(isset($_GET['page']) AND $_GET['page']==4)
	{
		$_SESSION['kwl'] = $_SESSION['kwl']+1;
		if(isset($kwl[$_SESSION['kwl']]) AND !empty($kwl[$_SESSION['kwl']]))
		{
			header('location: ?kw='.$kwl[$_SESSION['kwl']].'&page=1');
		}else{
			exit;
		}
	}
	if(isset($_GET['kw']))
	{
		$kw = $_GET['kw'];
	}else{
		$kw = $kwl[0];
		$_SESSION['kwl'] = 0;
	}
	$keword = $kw;
	
	$dt = ScrapeBRH('https://www.aliexpress.com/wholesale?trafficChannel=main&d=y&CatId=0&SearchText='.urlencode($keword).'&ltype=wholesale&SortType=default&minPrice=10&maxPrice=900000&page='.$page);
	$ex1 = explode('{"mods"', $dt);
	//$ex2 = explode('}]}]};', $ex1[1]);
	$ex2 = explode('window.runParams.csrfToken', $ex1[1]);
	
	$isine = trim($ex2[0]);
	if(substr($isine, -1)==';')
	{
		$djs = json_decode('{"mods"'.substr_replace($isine, "", -1), true);
		$jsn = array();
		foreach($djs['items'] as $df)
		{
			$productId	= trim($df['productId']);
			$title		= trim($df['title']);
			$imageUrl	= str_replace('//', '', str_replace('_220x220xz.jpg', '', $df['imageUrl']));
			$price		= trim($df['price']);
			//echo "<h1>$title - <a href=\"?id=$productId\" target=\"_blank\">$productId</a></h1>$price<br><img src=\"$imageUrl?w=100\"><br><hr>";
			$jsn[] = array($productId, $title, $imageUrl, $price);
		}
		echo "<a href=\"?page=$pagen&kw=$keword\">Next</a> &nbsp; <a href=\"?\">Reset</a><hr>";
		echo PostMobileBRH('judul', json_encode($jsn));
	}
}
?><meta http-equiv="refresh" content="<?=rand(2,5)?>; url=?page=<?=$pagen?>&kw=<?=$keword?>">