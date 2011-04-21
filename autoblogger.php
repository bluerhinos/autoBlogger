<?php

include('autoblogger.conf');

if($conf['timezone'])
	date_default_timezone_set($conf['timezone']);

if($conf['debug']) echo "Auto Blogger Started\n";

$stayinloop = 1;
while($stayinloop){
	
	foreach($conf['watch-dirs'] as $curdir){
		
		checkoutdir($curdir['path']);
		
	}
	
	sleep($conf['sleep']);
}

exit();


function checkoutdir($curdir){
	
	if($conf['debug']) echo "Checking: $curdir\n";
	
	global $conf;
	
	$dir = scandir($curdir);
	if(file_exists("{$curdir}/{$conf['catchfile']}"))
		$cache = unserialize(file_get_contents("{$curdir}/{$conf['catchfile']}"));
	foreach($dir as $item){
		
		$skip = 0; foreach($conf['ignores'] as $ignore){ if(preg_match($ignore, $item)){ $skip = 1; break; } } //Ingnores
		if($skip) continue;
		
		$log[$item] = 1; 
		
		if($cache[$item]['found']) continue;
		
		if(is_dir("$curdir/$item")){
			checkoutdir("$curdir/$item");
			continue;
		}
		
		$file_md5 = md5_file("$curdir/$item");
	
		$cache[$item] = array("md5"=>$file_md5, "found"=>1);
	
		if($conf['debug']) echo "$item Found\n";
	
		foreach($conf['hooks'] as $type=>$hook){
			switch($hook['chk']){
				case "ext":
					if(substr($item,strrpos($item,".")+1) == $hook['val'])
						proc_file($type, "$curdir/$item", $hook['function']);
				break;
			}
		}
	
	
	}
	
	foreach($cache as $item=>$val){
		if(!$log[$item])
			$cache[$item]['found'] = 0;
	}
	
	file_put_contents("{$curdir}/{$conf['catchfile']}",serialize($cache));
	
}

function proc_file($type, $file, $function){
	global $conf;
	
	$post = $conf['defaults'][$type];
	call_user_func_array($function, array($file, &$post));
	
	$xml = simplexml_load_string('<?xml version="1.0"?><post/>');
	$xml->addChild('title', $post['title']);
	$xml->addChild('section', $conf['defaults'][$type]['section']);
	$author = $xml->addChild('author');
		$author->addChild('username',$conf['blog']['author']);
	$xml->addChild('content',$post['content']);
	$post['datetime'];
	if($post['datetime'])
		$xml->addChild('datetime', date("c",$post['datetime']));

	$xml->addChild('blog_sname',$post['blog_sname']);
	if(is_array($post['meta'])){
		$meta = $xml->addChild('metadata');
		foreach($post['meta'] as $k=>$v){
			$meta->addChild($k,$v);
		}
	}
	
	
	if(is_array($post['data'])){
		$datax = $xml->addChild('attached_data');
		foreach($post['data'] as $data){
			$dataitme = $datax->addChild('data', adddata($data));
			$dataitme->addAttribute('type', 'local');
		}
	}
	
	
	
	
	
	
	$url = "{$conf['blog']['base']}/api/rest/addpost/uid/{$conf['blog']['uid']}";
	
		$ch = curl_init($url);
		 curl_setopt($ch, CURLOPT_POST      ,1);
		 curl_setopt($ch, CURLOPT_POSTFIELDS    ,array("request"=>$xml->asXML()));
		 curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
		 curl_setopt($ch, CURLOPT_HEADER      ,0);  // DO NOT RETURN HTTP HEADERS
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
		$Rec_Data = curl_exec($ch);
		
}

//
//	$file = file_get_contents("081710_PGSE_7Li.tnt");
//	$file = file_get_contents("081610_7Li_Reference.tnt");
//	$file = file_get_contents("081710_7Li_GradAmpOn_NotPulsing.tnt");
//	$file = file_get_contents("081710_7Li_Reference.tnt");
//
//read_tnt("081710_PGSE_7Li.tnt");



//proc("files/110222_test1_tetrakis_A.tnt");






function adddata(&$data){
	global $conf;
	
	$xml = simplexml_load_string('<?xml version="1.0"?><dataset/>');
	$xml->addChild('title', $data['title']);
	$tdata = $xml->addChild('data');
		$datai = $tdata->addChild('dataitem', base64_encode($data['content']));
		$datai->addAttribute('type', 'inline');
		$datai->addAttribute('main', '1');
		$datai->addAttribute('ext', $data['ext']);
		$datai->addAttribute('filename', $data['filename']);
		
		$url = "{$conf['blog']['base']}/api/rest/adddata/uid/{$conf['blog']['uid']}";

			$ch = curl_init($url);
			 curl_setopt($ch, CURLOPT_POST      ,1);
			 curl_setopt($ch, CURLOPT_POSTFIELDS    ,array("request"=>$xml->asXML()));
			 curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
			 curl_setopt($ch, CURLOPT_HEADER      ,0);  // DO NOT RETURN HTTP HEADERS
			 curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
			 $Rec_Data = curl_exec($ch);
		$xmlr = simplexml_load_string( $Rec_Data );
		if($xmlr->status_code == "200")
			return (int)$xmlr->data_id;
}




function readline(&$file,&$pos,$no,$type="str",$debug=false){

	global $conf;
	
	$ret = substr($file,$pos,$no);
	
	if($debug){
		echo "{$no}\t{$pos}\t";
		for($i=0;$i<$no;$i++){
			printf(":%x",ord($ret{$i})); 
		}
		echo "\n";
	}
	
	switch($type){

		case "int":
		for($i=0;$i<$no;$i++){
			$ii = $no - $i;
			$sum += ord($ret{$i})*pow(256,($i)); 
		}
		$ret = $sum;
		break;
		case "long":	
			$ret = unpack("l",$ret);
			$ret = $ret[1];
		break;
			case "ulong":	
				$ret = unpack("L",$ret);
				$ret = $ret[1];
			break;
		case "short":	
			$ret = unpack("s",$ret);
			$ret = $ret[1];
		break;
		case "ushort":	
			$ret = unpack("S",$ret);
			$ret = $ret[1];
		break;
			case "float":	
				$ret = unpack("f",$ret);
				$ret = $ret[1];
			break;
		case "double":
			
			$ret = unpack("d",$ret);
			$ret = $ret[1];
		break;
		case "str+":
			if(($chm = strpos($ret,"\0"))!==false && ord($ret{0})<128)
				$ret = substr($ret,0,$chm);
			else
				$ret = "";
		break;
	}
	
	


	$pos += $no;
	return $ret;
}

?>