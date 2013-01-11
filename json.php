<?php

$dbhost = 'localhost';
$dbuser = 'slabeste_scroll';
$dbpass = 'a9poker';
include "colors.php";
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die                      ('Error connecting to mysql');

$dbname = 'slabeste_scroll';
mysql_select_db($dbname);

if ( isset($_POST[count])) {
$nr = $_POST[count];
$pmin = $_POST[pmin];
$pmax = $_POST[pmax];
$nrelem = $_POST[nrelem];
$nr1=$nr-0;
if ($_POST[color]!=""){
$a = sort_posts_by_color($_POST[color],$_POST[variatie],$_POST[minim]);
$ids = join(',',$a);
$qu = "product_id IN ($ids) and";
if (empty($a))
$qu="";
}else {
$qu="";
}
if ($_POST[tip]=="search") {
$q="SELECT * FROM test where ".$qu." (title like '%$_POST[val]%' OR description like '%$_POST[val]%') and category like '%$_POST[sex]%' and subcategory like '%$_POST[categorie]%' and price between '$pmin' and '$pmax' LIMIT ".$nr1." , ".$nrelem;
}
else
$q="SELECT price,product_id,title,aff_code,brand,image_urls,category,subcategory,description FROM test where ".$qu." price between '$pmin' and '$pmax' and category like '%$_POST[sex]%' and subcategory like '%$_POST[categorie]%' LIMIT ".$nr1." , ".$nrelem;
if ( isset($_POST[celmaiieftin])) {
$q1="select MIN(tbl.price) as 'ieftin',MAX(tbl.price) as 'scump' from ($q) as tbl";
$result1 = mysql_query($q1);
$row1 = mysql_fetch_array($result1);
print json_encode($row1);
//echo $q;
//echo $q;
}
$result = mysql_query($q);
$rows = array();
//$a = sort_posts_by_color("FFFFCC",$variance,$minimum);
if ( !isset($_POST[celmaiieftin])) {
while($r = mysql_fetch_assoc($result)) {
///echo $r[product_id];
//if ( in_array($r[product_id],$a))
    $rows[] = $r;
}
print json_encode($rows);

}
//print_r($a);

}



?>