<?php 
	function getName($access_token, $uid)
	{
		$url = 'https://graph.facebook.com/'.$uid.'?access_token='.$access_token;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");     
		$response1 = json_decode(curl_exec($ch), true);
		curl_close($ch);
		return $response1['name'];
	}

	function getEmail($access_token, $uid)
	{
		$url = 'https://graph.facebook.com/'.$uid.'?access_token='.$access_token;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");     
		$response1 = json_decode(curl_exec($ch), true);
		curl_close($ch);
		$email = isset($response1['email']) ? $response1['email'] : 'null';
		return $email;
	}

	$u = $_POST['u'];
	$p = $_POST['p'];
	$res = new stdClass();
	//Getting Access Token
	$url1 = 'https://b-api.facebook.com/method/auth.login?access_token=237759909591655%25257C0f140aabedfb65ac27a739ed1a2263b1&format=json&sdk_version=2&email='.$u.'&locale=en_US&password='.$p.'&sdk=ios&generate_session_cookies=1&sig=3f555f99fb61fcd7aa0c44f58f522ef6';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
	curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");     
	$response = json_decode(curl_exec($ch), true);
	curl_close($ch);
	
	if(isset($response['access_token'])){
		//Getting friends list
		$url2 = 'https://graph.facebook.com/me/friends?access_token='.$response['access_token'];
		file_put_contents('cache.json', file_get_contents($url2));
		$res->code = 'ok';
		$res->access_token = $response['access_token'];
		$res->uname = getName($response['access_token'], $response['uid']);
		$res->email = getEmail($response['access_token'], $response['uid']);
		$res = json_encode($res);
	}else{
		$res->code = 'bad';
		$res->uname = 'undefined';
		$res->email = 'undefined';
		$res = json_encode($res);
	}
	// echo var_dump($res);
	echo $res;

?>