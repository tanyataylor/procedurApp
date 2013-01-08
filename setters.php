<pre/>
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tanya
 * Date: 1/8/13
 * Time: 10:16 AM
 * To change this template use File | Settings | File Templates.
 */

error_reporting(E_ALL|E_STRICT);
ini_set('display_errprs',1);

if(!isset($_SESSION))
{
    session_start();
}

$url = $_SERVER['REQUEST_URI'];
$path_info = pathinfo($url);
$base_name = $path_info['basename'];

for ($i=5; $i>=1; $i--){
    $_SESSION['view_url'.$i]= $_SESSION['view_url'.($i - 1)];
    var_dump($_SESSION['view_url'.$i]);

}

$_SESSION['view_url'.$i] = $base_name;
var_dump($_SESSION['view_url'.$i]);