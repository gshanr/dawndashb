<?php
//echo "Hello World";
//xdebug_start_code_coverage();
$link = mysql_connect('dallas113.arvixeshared.com', 'gowrir_dawndb', 'dawn1234');
if (!$link) {
die('Could not connect: ' . mysql_error());
}

//echo 'Connected successfully';

if (!mysql_select_db('gowrir_dawn', $link)) {
//echo 'Could not select database';
exit;
}

//echo 'Database selected successfully';
$sql    = 'select SUM(dawnbuffer) AS Sent FROM NetStat';
$result = mysql_query($sql, $link);

if (!$result) {
//echo "DB Error, could not query the database\n";
//echo 'MySQL Error: ' . mysql_error();
exit;
}

$row = mysql_fetch_assoc($result);
//echo $row['Sent'];
$reliability=array();
$reliability[]=(int)$row['Sent'];
mysql_free_result($result);

$sql    = 'select count(*) AS Received FROM SensorData';
$result = mysql_query($sql, $link);

if (!$result) {
//echo "DB Error, could not query the database\n";
//echo 'MySQL Error: ' . mysql_error();
exit;
}

$row = mysql_fetch_assoc($result);
//echo $row['Received'];
$reliability[]=(int)$row['Received'];


$reliability[]=((float)($reliability[1]/$reliability[0]))*100;
if($reliability[2]>100){
    $reliability[2]=100;
}




mysql_free_result($result);

mysql_close($link);
echo json_encode($reliability,TRUE);
//var_dump(xdebug_get_code_coverage());
?>
