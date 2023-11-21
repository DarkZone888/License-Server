<?php 
include("config.php");

if (isset($_GET['script']) AND isset($_GET['usekey']) AND isset($_GET['version']) AND isset($_GET['password'])) {
	// รับค่าจากลูกค่า
	$script = $_GET['script'];
	$version = $_GET['version'];
	$usekey = $_GET['usekey'];
	$license = $_GET['license'];
	$password = $_GET['password'];
	$ip = get_client_ip();

	// รับค่าจาก Sql
	$username = Getusername($ip, $script);
	$checkversion = checkversion($version,$script);
	$version_current = Getversion($script);
	$checkexpired = CheckExpired($ip, $script);
	$discordid = Getdiscordid($ip, $script);

	if ($usekey == "no") {
		if (!empty($script)) {
			if(checkIP(get_client_ip(), $script)){
				if ($checkexpired) {
					$data = array("name"=>$username, "status"=>"success", "version"=>$version_current, "password"=> $password);
					$returndata = json_encode($data);

					echo $returndata;
					logs('สคริป : [ '.$script.' ] ยืนยันสำเร็จด้วย Ip : '.get_client_ip().'', 1);
					$url = $Config['Webhook'];

					$hookObject = json_encode([
						"content" => "",
						"username" => "",
						"avatar_url" => $Config['Avatar'],
						"tts" => false,
						"embeds" => [
							[
								"title" => "",
								"type" => "rich",
								"description" => "",
								"url" => "",
								"color" => hexdec( "FFFFFF" ),
								"footer" => [
									"text" => "".$Config['Encryptby']." | ✔️ การใช้งานปกติ  - เวลา ".date("H:i:s")."",
									"icon_url" => $Config['Imagencrypt']
								],
								"image" => [
									"url" => GetImageLog($script)
								],
								"fields" => [
									[
										"name" => "🌐 Session Information",
										"value" => "**Discord : **".$discordid."\n**User : **` ".$username." ` \n **Resource : **` ".$script." ` \n**IP : **` ".$ip." `",
										"inline" => true
									],
									[
										"name" => "💻 Deverloper",
										"value" => $Config['DiscordId'],
										"inline" => true
									]
								]
							]
						]

					], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

					$ch = curl_init();

					curl_setopt_array( $ch, [
						CURLOPT_URL => $url,
						CURLOPT_POST => true,
						CURLOPT_POSTFIELDS => $hookObject,
						CURLOPT_HTTPHEADER => [
							"Content-Type: application/json"
						]
					]);

					$response = curl_exec( $ch );
					curl_close( $ch );
				} else {
					$data = array("status"=>"error","reason"=>"License is expired","version"=>$version_current, "password"=> $password);
					$returndata = json_encode($data);
					echo $returndata;

					logs('สคริป : [ '.$script.' ] License หมดอายุ : '.get_client_ip().'', 5);
					$url = $Config['Webhook'];

					$hookObject = json_encode([
						"content" => "",
						"username" => "",
						"avatar_url" => $Config['Avatar'],
						"tts" => false,
						"embeds" => [
							[
								"title" => "",
								"type" => "rich",
								"description" => "",
								"url" => "",
								"color" => hexdec( "FFFFFF" ),
								"footer" => [
									"text" => "".$Config['Encryptby']." | ❌ การใช้งานมีปัญหา - เวลา ".date("H:i:s")."",
									"icon_url" => $Config['Imagencrypt']
								],
								"image" => [
									"url" => GetImageLog($script)
								],
								"fields" => [
									[
										"name" => "🌐 Session Information",
										"value" => "**Discord : **".$discordid."\n**User : **` ".$username." ` \n **Resource : **` ".$script." ` \n**IP : **` ".$ip." `",
										"inline" => true
									],
									[
										"name" => "💻 Deverloper",
										"value" => $Config['DiscordId'],
										"inline" => true
									],
									[
										"name" => "📙 More information",
										"value" => "**Reason : **` License หมดอายุ ` \n **Request IP : **` ".$ip." ` ",
										"inline" => false
									]
								]
							]
						]
	
					], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

					$ch = curl_init();

					curl_setopt_array( $ch, [
						CURLOPT_URL => $url,
						CURLOPT_POST => true,
						CURLOPT_POSTFIELDS => $hookObject,
						CURLOPT_HTTPHEADER => [
							"Content-Type: application/json"
						]
					]);

					$response = curl_exec( $ch );
					curl_close( $ch );
				}
			}else{
				$data = array("status"=>"error","reason"=>"Not Found Ip","version"=>$version_current, "password"=> $password);
				$returndata = json_encode($data);
				echo $returndata;
				logs('สคริป : [ '.$script.' ] ยืนยันไม่สำเร็จด้วย Ip (IP) : '.get_client_ip().'', 2);

				$url = $Config['Webhook'];

				$hookObject = json_encode([
					"content" => "",
					"username" => "",
					"avatar_url" => $Config['Avatar'],
					"tts" => false,
					"embeds" => [
						[
							"title" => "",
							"type" => "rich",
							"description" => "",
							"url" => "",
							"color" => hexdec( "FFFFFF" ),
							"footer" => [
								"text" => "".$Config['Encryptby']." | ❌ การใช้งานมีปัญหา - เวลา ".date("H:i:s")."",
								"icon_url" => $Config['Imagencrypt']
							],
							"image" => [
								"url" => GetImageLog($script)
							],
							"fields" => [
								[
									"name" => "🌐 Session Information",
									"value" => "**Discord : **".$discordid."\n**User : **` ".$username." ` \n **Resource : **` ".$script." ` \n**IP : **` ".$ip." `",
									"inline" => true
								],
								[
									"name" => "💻 Deverloper",
									"value" => $Config['DiscordId'],
									"inline" => true
								],
								[
									"name" => "📙 More information",
									"value" => "**Reason : **` ไม่พบ IP ในฐานข้อมูล ` \n **Request IP : **` ".$ip." ` ",
									"inline" => false
								]
							]
						]
					]

				], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

				$ch = curl_init();

				curl_setopt_array( $ch, [
					CURLOPT_URL => $url,
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => $hookObject,
					CURLOPT_HTTPHEADER => [
						"Content-Type: application/json"
					]
				]);

				$response = curl_exec( $ch );
				curl_close( $ch );
			}
		} else {
			$data = array("status"=>"error","reason"=>"No data found in the database","version"=>$version_current, "password"=> $password);
			$returndata = json_encode($data);
			echo $returndata;
			logs('สคริป : [ '.$script.' ] ไม่พบข้อมูลในฐานข้อมูล : '.get_client_ip().'', 4);
			$url = $Config['Webhook'];

			$hookObject = json_encode([
				"content" => "",
				"username" => "",
				"avatar_url" => $Config['Avatar'],
				"tts" => false,
				"embeds" => [
					[
						"title" => "",
						"type" => "rich",
						"description" => "",
						"url" => "",
						"color" => hexdec( "FFFFFF" ),
						"footer" => [
							"text" => "".$Config['Encryptby']." | ❌ การใช้งานมีปัญหา - เวลา ".date("H:i:s")."",
							"icon_url" => $Config['Imagencrypt']
						],
						"image" => [
							"url" => GetImageLog($script)
						],
						"fields" => [
							[
								"name" => "🌐 Session Information",
								"value" => "**Discord : **".$discordid."\n**User : **` ".$username." ` \n **Resource : **` ".$script." ` \n**IP : **` ".$ip." `",
								"inline" => true
							],
							[
								"name" => "💻 Deverloper",
								"value" => $Config['DiscordId'],
								"inline" => true
							],
							[
								"name" => "📙 More information",
								"value" => "**Reason : **` ไม่พบ ข้อมูลในฐานข้อมูล ` \n **Request IP : **` ".$ip." ` ",
								"inline" => false
							]
						]
					]
				]

			], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

			$ch = curl_init();

			curl_setopt_array( $ch, [
				CURLOPT_URL => $url,
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => $hookObject,
				CURLOPT_HTTPHEADER => [
					"Content-Type: application/json"
				]
			]);

			$response = curl_exec( $ch );
			curl_close( $ch );
		}
	} elseif ($usekey == "yes") {
		if (!empty($script) AND !empty($license)) {
			if (checkLicense($license,$script)) {
				if(checkIP(get_client_ip(), $script)){
					if ($checkexpired) {
						$data = array("name"=>$username, "status"=>"success", "version"=>$version_current, "password"=> $password);
						$returndata = json_encode($data);
		
						echo $returndata;
						logs('สคริป : [ '.$script.' ] ยืนยันสำเร็จด้วย Ip : '.get_client_ip().'', 1);
						$url = $Config['Webhook'];
		
						$hookObject = json_encode([
							"content" => "",
							"username" => "",
							"avatar_url" => $Config['Avatar'],
							"tts" => false,
							"embeds" => [
								[
									"title" => "",
									"type" => "rich",
									"description" => "",
									"url" => "",
									"color" => hexdec( "FFFFFF" ),
									"footer" => [
										"text" => "".$Config['Encryptby']." | ✔️ การใช้งานปกติ  - เวลา ".date("H:i:s")."",
										"icon_url" => $Config['Imagencrypt']
									],
									"image" => [
										"url" => GetImageLog($script)
									],
									"fields" => [
										[
											"name" => "🌐 Session Information",
											"value" => "**Discord : **".$discordid."\n**User : **` ".$username." ` \n **Resource : **` ".$script." ` \n**IP : **` ".$ip." `",
											"inline" => true
										],
										[
											"name" => "💻 Deverloper",
											"value" => $Config['DiscordId'],
											"inline" => true
										]
									]
								]
							]
		
						], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
		
						$ch = curl_init();
		
						curl_setopt_array( $ch, [
							CURLOPT_URL => $url,
							CURLOPT_POST => true,
							CURLOPT_POSTFIELDS => $hookObject,
							CURLOPT_HTTPHEADER => [
								"Content-Type: application/json"
							]
						]);
		
						$response = curl_exec( $ch );
						curl_close( $ch );
					} else {
						$data = array("status"=>"error","reason"=>"License is expired","version"=>$version_current, "password"=> $password);
						$returndata = json_encode($data);
						echo $returndata;
	
						logs('สคริป : [ '.$script.' ] License หมดอายุ : '.get_client_ip().'', 5);
						$url = $Config['Webhook'];
	
						$hookObject = json_encode([
							"content" => "",
							"username" => "",
							"avatar_url" => $Config['Avatar'],
							"tts" => false,
							"embeds" => [
								[
									"title" => "",
									"type" => "rich",
									"description" => "",
									"url" => "",
									"color" => hexdec( "FFFFFF" ),
									"footer" => [
										"text" => "".$Config['Encryptby']." | ❌ การใช้งานมีปัญหา - เวลา ".date("H:i:s")."",
										"icon_url" => $Config['Imagencrypt']
									],
									"image" => [
										"url" => GetImageLog($script)
									],
									"fields" => [
										[
											"name" => "🌐 Session Information",
											"value" => "**Discord : **".$discordid."\n**User : **` ".$username." ` \n **Resource : **` ".$script." ` \n**IP : **` ".$ip." `",
											"inline" => true
										],
										[
											"name" => "💻 Deverloper",
											"value" => $Config['DiscordId'],
											"inline" => true
										],
										[
											"name" => "📙 More information",
											"value" => "**Reason : **` License หมดอายุ ` \n **Request IP : **` ".$ip." ` ",
											"inline" => false
										]
									]
								]
							]
		
						], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
	
						$ch = curl_init();
	
						curl_setopt_array( $ch, [
							CURLOPT_URL => $url,
							CURLOPT_POST => true,
							CURLOPT_POSTFIELDS => $hookObject,
							CURLOPT_HTTPHEADER => [
								"Content-Type: application/json"
							]
						]);
	
						$response = curl_exec( $ch );
						curl_close( $ch );
					}
				}else{
					$data = array("status"=>"error","reason"=>"Ip Not Found","version"=>$version_current, "password"=> $password);
					$returndata = json_encode($data);
					echo $returndata;
					logs('สคริป : [ '.$script.' ] ยืนยันไม่สำเร็จด้วย Ip (IP) : '.get_client_ip().'', 2);
	
					$url = $Config['Webhook'];
	
					$hookObject = json_encode([
						"content" => "",
						"username" => "",
						"avatar_url" => $Config['Avatar'],
						"tts" => false,
						"embeds" => [
							[
								"title" => "",
								"type" => "rich",
								"description" => "",
								"url" => "",
								"color" => hexdec( "FFFFFF" ),
								"footer" => [
									"text" => "".$Config['Encryptby']." | ❌ การใช้งานมีปัญหา - เวลา ".date("H:i:s")."",
									"icon_url" => $Config['Imagencrypt']
								],
								"image" => [
									"url" => GetImageLog($script)
								],
								"fields" => [
									[
										"name" => "🌐 Session Information",
										"value" => "**Discord : **".$discordid."\n**User : **` ".$username." ` \n **Resource : **` ".$script." ` \n**IP : **` ".$ip." `",
										"inline" => true
									],
									[
										"name" => "💻 Deverloper",
										"value" => $Config['DiscordId'],
										"inline" => true
									],
									[
										"name" => "📙 More information",
										"value" => "**Reason : **` ไม่พบ IP ในฐานข้อมูล ` \n **Request IP : **` ".$ip." ` ",
										"inline" => false
									]
								]
							]
						]
	
					], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
	
					$ch = curl_init();
	
					curl_setopt_array( $ch, [
						CURLOPT_URL => $url,
						CURLOPT_POST => true,
						CURLOPT_POSTFIELDS => $hookObject,
						CURLOPT_HTTPHEADER => [
							"Content-Type: application/json"
						]
					]);
	
					$response = curl_exec( $ch );
					curl_close( $ch );
				}
			} else {
				$data = array("status"=>"error","reason"=>"Key or Script Not Found","version"=>$version_current, "password"=> $password);
				$returndata = json_encode($data);
				echo $returndata;
					logs('สคริป : [ '.$script.' ] ยืนยันไม่สำเร็จด้วย (Key or Script): '.get_client_ip().' ['. $license .']', 3);
					$url = $Config['Webhook'];
	
					$hookObject = json_encode([
						"content" => "",
						"username" => "",
						"avatar_url" => $Config['Avatar'],
						"tts" => false,
						"embeds" => [
							[
								"title" => "",
								"type" => "rich",
								"description" => "",
								"url" => "",
								"color" => hexdec( "FFFFFF" ),
								"footer" => [
									"text" => "".$Config['Encryptby']." | ❌ การใช้งานมีปัญหา - เวลา ".date("H:i:s")."",
									"icon_url" => $Config['Imagencrypt']
								],
								"image" => [
									"url" => GetImageLog($script)
								],
								"fields" => [
									[
										"name" => "🌐 Session Information",
										"value" => "**Discord : **".$discordid."\n**User : **` ".$username." ` \n **Resource : **` ".$script." ` \n**IP : **` ".$ip." `",
										"inline" => true
									],
									[
										"name" => "💻 Deverloper",
										"value" => $Config['DiscordId'],
										"inline" => true
									],
									[
										"name" => "📙 More information",
										"value" => "**Reason : **` ไม่พบ Key ในฐานข้อมูล ` \n **Request IP : **` ".$ip." ` \n **Request Key : **` ".$license." ` ",
										"inline" => false
									]
								]
							]
						]
	
					], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
	
					$ch = curl_init();
	
					curl_setopt_array( $ch, [
						CURLOPT_URL => $url,
						CURLOPT_POST => true,
						CURLOPT_POSTFIELDS => $hookObject,
						CURLOPT_HTTPHEADER => [
							"Content-Type: application/json"
						]
					]);
	
					$response = curl_exec( $ch );
					curl_close( $ch );
			}
		} else {
			$data = array("status"=>"error","reason"=>"No data found in the database","version"=>$version_current, "password"=> $password);
			$returndata = json_encode($data);
			echo $returndata;
			logs('IP: ['.get_client_ip().'] ไม่พบข้อมูลในฐานข้อมูล', 4);
			$url = $Config['Webhook'];
	
			$hookObject = json_encode([
				"content" => "",
				"username" => "",
				"avatar_url" => $Config['Avatar'],
				"tts" => false,
				"embeds" => [
					[
						"title" => "",
						"type" => "rich",
						"description" => "",
						"url" => "",
						"color" => hexdec( "FFFFFF" ),
						"footer" => [
							"text" => "".$Config['Encryptby']." | ❌ การใช้งานมีปัญหา - เวลา ".date("H:i:s")."",
							"icon_url" => $Config['Imagencrypt']
						],
						"image" => [
							"url" => GetImageLog($script)
						],
						"fields" => [
							[
								"name" => "🌐 Session Information",
								"value" => "**Discord : **".$discordid."\n**User : **` ".$username." ` \n **Resource : **` ".$script." ` \n**IP : **` ".$ip." `",
								"inline" => true
							],
							[
								"name" => "💻 Deverloper",
								"value" => $Config['DiscordId'],
								"inline" => true
							],
							[
								"name" => "📙 More information",
								"value" => "**Reason : **` ไม่พบ ข้อมูลในฐานข้อมูล ` \n **Request IP : **` ".$ip." ` ",
								"inline" => false
							]
						]
					]
				]

			], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
	
			$ch = curl_init();
	
			curl_setopt_array( $ch, [
				CURLOPT_URL => $url,
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => $hookObject,
				CURLOPT_HTTPHEADER => [
					"Content-Type: application/json"
				]
			]);
	
			$response = curl_exec( $ch );
			curl_close( $ch );
		}
	}
}
?>
