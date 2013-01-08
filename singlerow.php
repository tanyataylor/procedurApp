<pre/>
<?php
include('setters.php');
error_reporting(E_ALL|E_STRICT);
ini_set('display_errprs',1);



$xml = json_decode(json_encode(simpleXML_load_file('/var/www/magento/app/etc/local.xml','SimpleXMLElement', LIBXML_NOCDATA)),true);
//var_dump($xml);
$contents = $xml['global']['resources']['default_setup']['connection'];
$connect_attributes = array_slice($contents,0,4);
$link = mysql_connect($connect_attributes['host'],$connect_attributes['username'],$connect_attributes['password']);
//var_dump($link);
if (!$link){
    die("Could not connect: " . mysql_error());
}
$db_selected = mysql_select_db($connect_attributes['dbname'],$link);
if (!$db_selected){
    die('Can\'t use db : ' . mysql_error());
}


$sql = "SELECT catalog_product_entity.sku, catalog_product_entity_varchar.value, core_website.name
FROM catalog_product_entity
JOIN catalog_product_entity_varchar
ON catalog_product_entity.entity_id = catalog_product_entity_varchar.entity_id
JOIN catalog_product_website
ON catalog_product_website.product_id = catalog_product_entity.entity_id
JOIN core_website
ON catalog_product_website.website_id = core_website.website_id
WHERE catalog_product_entity_varchar.attribute_id = 96 AND catalog_product_entity.sku = '" .$_GET['sku']. "'";

$result = mysql_query($sql);
if(!$result){
    die("Invalid query: " . mysql_error());
}
?>
<table>
    <tr><th>SKU</th><th>Value</th><th>Website_Name</th></tr>
<?php //if(!isset($_POST['submit'])){ /* display the form if submit is not set */} else { ?>

    <?php
    while ($row = mysql_fetch_assoc($result)){
        echo "<tr><td>" .$row['sku'] .
            "</td><td>" .$row['value'] .
            "</td><td>" . $row['name'] .
            "</td></tr>";
    }







//var_dump($row);
?>
</table>
    </br>
<a href="proceduralApp.php">Go back to previous page</a>