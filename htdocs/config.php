<?php 
session_start();
date_default_timezone_set("Asia/Bangkok");
$date = date("Y-m-d H:i:s");

// การตั้งค่าทั่วไป

$domain = "https://127.0.0.1";            // Server Domain Name ไม่ต้องมี / ตามหลัง
$config_username = "admin";                              // Username
$config_password = "12345";                        // Password

// ตั้งค่า log 
$Config['DiscordId'] = '<@907872627715112960>';     // iddiscord
$Config['Webhook'] = 'https://discord.com/api/webhooks/1176474480537763850/q1-5fQJ4qM9SjkHh5Vt6Cw0bsucD7lnvdBJOv68hn68CB0ciuRJYSkShqfyY95DtC_Q_';        // Webhook ไว้เก็บข้อมูล
$Config['Avatar'] = "https://store.kidbright.info/upload/cover-image/1544265083-nDP3ez.png"; // โปรไฟล์บอท
$Config['Encryptby'] = "LOG"; // เข้ารหัสโดยใครก็ว่าปาย
$Config['Imagencrypt'] = "https://blog-media.byjusfutureschool.com/bfs-blog/2022/08/18080659/Article-Page-61.png"; // โลโก้ตัวล้อค

// function

function connDB() {
    $host	  = "127.0.0.1";                            // Mysql Host
    $port     = "3306";                                 // Mysql Port
    $username = "root";                                 // Mysql Username
    $password = "";                                     // Mysql Password
    $database = "license_server";                       // Mysql Database Name

    $db_host2  = $host.":".$port;
    @$conn= mysqli_connect($db_host2,$username,$password,$database)or die("ไม่สามารถเชื่อมต่อกับ mysql ได้ | ".mysqli_connect_error($conn));
    mysqli_set_charset($conn,"utf8");
    return $conn;
}

function generateKey($length = 13) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $keys = 'Dark_';
    for ($i = 0; $i < $length; $i++) {
        $keys .= $characters[rand(0, $charactersLength - 1)];
    }
    return $keys;
}

function GetImageLog($script) {
	$Geturl = "SELECT * FROM list_script WHERE script='$script'";
	$queryurl = mysqli_query(connDB(),$Geturl);
	$resulturl = mysqli_fetch_assoc($queryurl);
	$haveurl = mysqli_num_rows($queryurl);
    if ($resulturl['image']) {
		return $resulturl['image'];
	}else{
		return "https://i.pinimg.com/originals/75/c2/f8/75c2f842863ae2df6b3ac2d0a4d63026.gif";
	}
}

function Getdiscordid($ip, $script){
	$sql = "SELECT * FROM license WHERE ip = '$ip' and script = '$script'";
	$query = mysqli_query(connDB(),$sql);
	$result = mysqli_fetch_assoc($query);
    $row = mysqli_num_rows($query);

	if ($row == 1) {
        return $result['discord'];
	}else{
		return "` - `";
	}
}

function gen_key_check(){
    $key = generateKey();
    $old_key = checkLicense2($key);
    if($old_key == false){
        return $key;
    }else{
        return "Press Refresh";
    }
}

function checkLicense2($license){
    $sql = "SELECT * FROM license WHERE license = '$license'";
    $query = mysqli_query(connDB(),$sql);
    $row = mysqli_num_rows($query);

    if ($row == 1) {
        return true;
    }else{
        return false;
    }
}

function checkLicense($license,$script){
	$sql = "SELECT * FROM license WHERE license = '$license' AND script='$script'";
	$query = mysqli_query(connDB(),$sql);
	$row = mysqli_num_rows($query);

	if ($row == 1) {
		return true;
	}else{
		return false;
	}
}

function CheckExpired($ip, $script){
	$sql = "SELECT * FROM license WHERE ip = '$ip' AND script = '$script'";
	$query = mysqli_query(connDB(),$sql);
	$row = mysqli_num_rows($query);
	$result = mysqli_fetch_assoc($query);

	if ($row == 1) {
		if ($result['expired'] >= date("Y-m-d")) {
            return true;
        } elseif ($result['expired'] == 'ไม่จำกัด') {
            return true;
        } else {
            return false;
        }
    } else {
        return true;
    }
}

function checkversion($version,$script){
	$sql = "SELECT * FROM list_script WHERE version = '$version' AND script='$script'";
	$query = mysqli_query(connDB(),$sql);
	$row = mysqli_num_rows($query);

	if ($row == 1) {
		return true;
	}else{
		return false;
	}
}

function checkIP($ip, $script){
	$sql = "SELECT * FROM license WHERE ip = '$ip' AND script = '$script'";
	$query = mysqli_query(connDB(),$sql);
	$row = mysqli_num_rows($query);

	if ($row == 1) {
		return true;
	}else{
		return false;
	}
}

function Getusername($ip, $script){
	$sql = "SELECT * FROM license WHERE ip = '$ip' AND script = '$script'";
	$query = mysqli_query(connDB(),$sql);
	$result = mysqli_fetch_assoc($query);
    $row = mysqli_num_rows($query);
    if ($row == 1) {
        return $result['name'];
	} else {
		return "-";
    }
}

function Getversion($script){
	$sql = "SELECT * FROM list_script WHERE script = '$script'";
	$query = mysqli_query(connDB(),$sql);
	$result = mysqli_fetch_assoc($query);
	$row = mysqli_num_rows($query);
    if ($row == 1) {
        return $result['version'];
	} else {
		return "1.0";
    }

}

function logs($txt,$status) {
    mysqli_query(connDB(),"INSERT INTO logs (descript,status) VALUES ('$txt','$status')");
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function status_color($status){
    if($status == 1){
        return '<span class="label label-success"> สำเร็จ </span>';
    }elseif($status == 2){
        return '<span class="label label-danger"> IP ไม่ถูกต้อง </span>';
    }elseif($status == 3){
        return '<span class="label label-danger"> คีย์หรือสคริปไม่ถูกต้อง </span>';
    }elseif($status == 4){
        return '<span class="label label-danger"> ไม่พบข้อมูลในฐานข้อมูล </span>';
    }elseif($status == 5){
        return '<span class="label label-danger"> license หมดอายุ </span>';
    }else{
        return '<span class="label label-danger"> ไม่ทราบ </span>';
    }
}

?>