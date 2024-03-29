<pre/>
<?php
include('setters.php');
//var_dump($_POST);
error_reporting(E_ALL|E_STRICT);
ini_set("display_errors", 1);

$xml = json_decode(json_encode(simpleXML_load_file('/var/www/magento/app/etc/local.xml','SimpleXMLElement', LIBXML_NOCDATA)),true);
//var_dump($xml);

$contents = $xml['global']['resources']['default_setup']['connection'];
$connect_attributes = array_slice($contents,0,4);
$link = mysql_connect($connect_attributes['host'],$connect_attributes['username'],$connect_attributes['password']);
//var_dump($link);
if (!$link){
    create_log_entry("Error connecting to database: " . mysql_error);
    die("Could not connect: " . mysql_error());
}
create_log_entry("Successfully connected to database");
$db_selected = mysql_select_db($connect_attributes['dbname'],$link);
if (!$db_selected){
    die('Can\'t use db : ' . mysql_error());
}
if(isset($_POST['sortoption'])){
    $sortoption = $_POST["sortoption"];
}
else $sortoption = "sku";

if(isset($_POST['sortorder'])){
    $sortorder = $_POST["sortorder"];
}
else $sortorder = "ASC";


$sql = "SELECT catalog_product_entity.sku, catalog_product_entity_varchar.value, core_website.name
FROM catalog_product_entity
JOIN catalog_product_entity_varchar
ON catalog_product_entity.entity_id = catalog_product_entity_varchar.entity_id
JOIN catalog_product_website
ON catalog_product_website.product_id = catalog_product_entity.entity_id
JOIN core_website
ON catalog_product_website.website_id = core_website.website_id
WHERE catalog_product_entity_varchar.attribute_id = 96
ORDER BY {$sortoption}" . " {$sortorder}";

if((isset($_POST['limit'])) AND $_POST['limit'] > 0){
    $limit = $_POST['limit'];
    $sql .= " limit 0, {$limit}";
} else{
    $sql .= " limit 0, 30";
}

$result = mysql_query($sql);
if(!$result){
    die("Invalid query: " . mysql_error());
}

function create_log_entry($str){
$d = date("Y-m-d");
$file_path = getcwd();
$file_path .= "/logs/";
$file_path .= $d;
$file_path .= ".log";
$file = fopen($file_path, 'a+') or die("cannot open the file");
$stringData = date('H-i-s') . " : " . $_SERVER['REMOTE_ADDR'] . " : " . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . " : "
    . 'Session_id: ' . session_id() . "\n\t" . $str . "\n";
fwrite($file, "$stringData");
fclose($file);

}
create_log_entry("Test function of create log");


?>

<html>
<head>
    <title>SORT THE RESULTS</title>
</head>
<body>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    List Logs: <a href='logs.php'>View Logs</a>
    Enter Limit:<input type="text" size="12" maxlength="3" name="limit"><br /><br />
    Sort Option: SKU<input type="radio" value="sku" name="sortoption">
    Value<input type="radio" value="value" name="sortoption"><br />
    Sort Order: ASC <input type="radio" value="ASC" name="sortorder">
    DSC<input type="radio" value="desc" name="sortorder"><br /><br />
    <input type="submit" value="Submit!" size="12" name="submit"><br />
    </form>
</body>
</html>

<table>
    <tr><th>SKU</th><th>Value</th><th>Website_Name</th></tr>
<?php //if(!isset($_POST['submit'])){ /* display the form if submit is not set */} else { ?>

    <?php
    while ($row = mysql_fetch_assoc($result)){
        echo "<tr><td>" . '<a href="singlerow.php?sku=' .$row['sku'] . '">' . $row['sku'] . '</a>'.
            "</td><td>"  .$row['value'] .
            "</td><td>" . $row['name'] .
            "</td></tr>";
        }

?>
</table>

    <?php




?>
