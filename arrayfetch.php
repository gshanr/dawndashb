<?php

$host = "dallas113.arvixeshared.com";
$user = "gowrir_dawndb";
$pass = "dawn1234";
$db = "gowrir_dawn";

$cursor = "cr_123456";

try
{
  $dbh = new PDO("mysql:host=$host;dbname=$db",$user,$pass);
  //echo "Connected<p>";
}
catch (Exception $e)
{
  echo "Unable to connect: " . $e->getMessage() ."<p>";
}
$sth = $dbh->prepare("SELECT * FROM ActiveMotes");
$sth->execute();

/* Fetch all of the remaining rows in the result set */
//print("Fetch all of the remaining rows in the result set:\n");
$result = $sth->fetchAll();
//print_r($result);
//var_dump($result[0]['address']);

//$keys = array_keys($result);
$iterations=count($result);
//var_dump($iterations);

for($i = 0; $i < $iterations; $i++) {

    /*Get the address and remove the white spaces*/
    //var_dump($result[$i]['address']);
    $result[$i]['address'] = str_replace(' ', '', $result[$i]['address']); //removes the spaces 
    $statarray[$i]['address']=$result[$i]['address'];
    $statarray[$i]['ltc']=$result[$i]['ltc'];
    /*Get the sensors from metadata*/
    $getsensors="SELECT sensor FROM MetaData where address='".$result[$i]['address']."'";       
    //print_r($getsensors);
    $sth = $dbh->prepare($getsensors);
    $sth->execute();
    /* Fetch all of the remaining rows in the result set */
    //print("Fetch all of the remaining rows in the result set:\n");
    $sensors = $sth->fetchAll();
    //print_r($sensors);
    $statarray[$i]['sensors']=$sensors;
    
    /*Get the packets sent*/
    $sth = $dbh->prepare("select SUM(dawnbuffer) AS Sent FROM NetStat where address='".$result[$i]['address']."'");
    $sth->execute();
    /* Fetch all of the remaining rows in the result set */
    //print("Fetch all of the remaining rows in the result set:\n");
    $sent = $sth->fetch(PDO::FETCH_ASSOC);
    //print_r($sent);
    $statarray[$i]['sent']=$sent;
    
    /*Get the packets sent*/
    $sth = $dbh->prepare("select count(*) AS Received FROM SensorData where address='".$result[$i]['address']."'");
    $sth->execute();
    /* Fetch all of the remaining rows in the result set */
    //print("Fetch all of the remaining rows in the result set:\n");
    $rxd = $sth->fetch(PDO::FETCH_ASSOC);
    //print_r($rxd);
    $statarray[$i]['rxd']=$rxd;
    
}
//var_dump($statarray);
echo json_encode($statarray,TRUE);

?>