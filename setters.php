<?php

error_reporting(E_ALL|E_STRICT);
ini_set('display_errprs',1);

if(!isset($_SESSION))
{
    session_start();
}

$arr = array();
$url = $_SERVER['REQUEST_URI'];
$path_info = pathinfo($url);
$base_name = $path_info['basename'];

$expire=time()+60*60*24*30;

for ($i=5; $i>=1; $i--){
    $_SESSION['view_url'.$i]= $_SESSION['view_url'.($i - 1)];
    $arr[]=$_SESSION['view_url'.$i];
    setcookie("last_urls", serialize($arr) , $expire);
}

$_SESSION['view_url'.$i] = $base_name;
//echo ("This is URL - _SESSION: <br />");
//var_dump($arr);               //----------------------SESSION
//var_dump($_SESSION);

$cookie_urls= $_COOKIE['last_urls'];
//var_dump($cookie_urls);

$str = $cookie_urls;
$str1 = explode( ';', $str);
//var_dump($str1);
$cookie_arr = array();
foreach($str1 as $single){
    //var_dump($single);
    $findme = '"';
    $position = strpos($single,$findme);
    if ($position !== false){
        //echo "The string {$findme} was found at position {$position}";
        $get_str = substr($single,$position);
        $cookie_arr[] = $get_str;

    }
    else { }
}
//echo ("<br />This is URL - _COOKIES: <br />");
//var_dump($cookie_arr);   //------------------------COOKIE
//var_dump($_COOKIE);

echo "Render SESSION and COOKIE: <br />";
if (empty($arr)){
    echo "SESSION is empty, printing COOKIE";
    foreach($cookie_arr as $key=>$value){
        echo "Site {$key} cookie : {$value} <br/>";
    }
}else {
    echo "Printing SESSION: <br/>";
    foreach($arr as $key=>$value){
        echo "Site {$key} session : {$value} <br/>";
    }
}
