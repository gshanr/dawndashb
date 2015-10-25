<?php

$host = "dallas113.arvixeshared.com";
$user = "gowrir_dawndb";
$pass = "dawn1234";
$db = "gowrir_dawn";

$cursor = "cr_123456";

try
{
  $dbh = new PDO("mysql:host=$host;dbname=$db",$user,$pass);
  echo "Connected<p>";
}
catch (Exception $e)
{
  echo "Unable to connect: " . $e->getMessage() ."<p>";
}
$sth = $dbh->prepare("SELECT * FROM ActiveMotes");
$sth->execute();

/* Fetch all of the remaining rows in the result set */
print("Fetch all of the remaining rows in the result set:\n");
$result = $sth->fetchAll();
print_r($result);
//var_dump($result[0]['address']);

//$keys = array_keys($result);
$iterations=count($result);
var_dump($iterations);

for($i = 0; $i < $iterations; $i++) {
    /*Get the address and remove the white spaces*/
    var_dump($result[$i]['address']);
    $result[$i]['address'] = str_replace(' ', '', $result[$i]['address']); //removes the spaces 
    
    /*Get the sensors from metadata*/
    $getsensors="SELECT sensor FROM MetaData where address='".$result[$i]['address']."'";       
    print_r($getsensors);
    $sth = $dbh->prepare($getsensors);
    $sth->execute();
    /* Fetch all of the remaining rows in the result set */
    print("Fetch all of the remaining rows in the result set:\n");
    $sensors = $sth->fetchAll();
    print_r($sensors);
    
    /*Get the packets sent*/
    $sth = $dbh->prepare("select SUM(dawnbuffer) AS Sent FROM NetStat where address='".$result[$i]['address']."'");
    $sth->execute();
    /* Fetch all of the remaining rows in the result set */
    print("Fetch all of the remaining rows in the result set:\n");
    $sent = $sth->fetch(PDO::FETCH_ASSOC);
    print_r($sent);
    
    /*Get the packets sent*/
    $sth = $dbh->prepare("select count(*) AS Received FROM SensorData where address='".$result[$i]['address']."'");
    $sth->execute();
    /* Fetch all of the remaining rows in the result set */
    print("Fetch all of the remaining rows in the result set:\n");
    $rxd = $sth->fetch(PDO::FETCH_ASSOC);
    print_r($rxd);
    
}


/*$sth = $dbh->prepare("SELECT sensor FROM MetaData where address='00:17:0d:00:00:60:27:3a'");
$sth->execute();*/

/* Fetch all of the remaining rows in the result set */
/*print("Fetch all of the remaining rows in the result set:\n");
$sensors = $sth->fetchAll();
print_r($sensors);*/



/*$link = mysql_connect('dallas113.arvixeshared.com', 'gowrir_dawndb', 'dawn1234');
if (!$link) {
die('Could not connect: ' . mysql_error());
}

//echo 'Connected successfully';

if (!mysql_select_db('gowrir_dawn', $link)) {
//echo 'Could not select database';
exit;
}

//echo 'Database selected successfully';
$sql    = "select SUM(dawnbuffer) AS Sent FROM NetStat where address='00:17:0d:00:00:60:27:3a'";
$result = mysql_query($sql, $link);

if (!$result) {
//echo "DB Error, could not query the database\n";
//echo 'MySQL Error: ' . mysql_error();
exit;
}

$row = mysql_fetch_assoc($result);
//echo $row['Sent'];
$reliability=array();
$reliability[]=(int)$row['Sent']; //index 0 -> sent
mysql_free_result($result);

$sql    = "select count(*) AS Received FROM SensorData where address='00:17:0d:00:00:60:27:3a'";
$result = mysql_query($sql, $link);

if (!$result) {
//echo "DB Error, could not query the database\n";
//echo 'MySQL Error: ' . mysql_error();
exit;
}

$row = mysql_fetch_assoc($result);
//echo $row['Received'];
$reliability[]=(int)$row['Received']; // index 1 -> received


//$reliability[]=((float)($reliability[1]/$reliability[0]))*100;
$reliability[]=0;
if($reliability[2]>100){
    $reliability[2]=100;        //index 2 -> reliability in %
}
print_r($reliability);
mysql_free_result($result);*/


?>