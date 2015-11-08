<?php

$period=$_POST['period'];
$payload=$_POST['payload'];
$traffic=$_POST['optionsRadios'];

echo $period*1000;
echo $payload;
echo $traffic;

$period=1000*$period;

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
    $result[$i]['address'] = str_replace(' ', '', $result[$i]['address']); //removes the spaces
    echo $result[$i]['address'];
    
    $getcount="SELECT count(*) as count FROM MetaData where address='".$result[$i]['address']."'";  
    $sth = $dbh->prepare($getcount);
    $sth->execute();
    /* Fetch all of the remaining rows in the result set */
    //print("Fetch all of the remaining rows in the result set:\n");
    $count = $sth->fetchAll();    
    var_dump($count);
    if($count[0]['count']>=5){
        echo "All the interfacaes are used";
    }else if($count[0]['count']==0){
        echo "Relay nodes without interfaces";
    }else{
        if($traffic==0 and $payload<64){
            echo "peripheral can be plugged into this node";
            $getbandwidth="select currentBW AS Bbw FROM BaseBandwidth";  
            $sth = $dbh->prepare($getbandwidth);
            $sth->execute();
            /* Fetch all of the remaining rows in the result set */
            //print("Fetch all of the remaining rows in the result set:\n");
            $bandwidth = $sth->fetchAll();    
            //var_dump($bandwidth);
            //echo intval($bandwidth[0]['Bbw']);
            //echo intval($period);
            if(intval($bandwidth[0]['Bbw'])<intval($period)){
                echo "Peripheral does not require additional bandwidth";
            }else{
                echo "Peripheral requires additional bandwidth";
            }
        }else if($traffic==0 and $payload > 64){
            echo "peripheral can be plugged in, but requires additional bandwidth";
        }else if($traffic ==1 and $payload<64){
            echo "peripheral can be plugged into this node";
        }else if($traffic==1 and $payload>64){
            echo "peripheral can be plugged in, but requires additional bandwidth";
        }else if($traffic==2){
            $getbursty="select count(if(traffic=2,1,Null)) as bc from MetaData where address='".$result[$i]['address']."'";  
            $sth = $dbh->prepare($getbursty);
            $sth->execute();
            /* Fetch all of the remaining rows in the result set */
            //print("Fetch all of the remaining rows in the result set:\n");
            $bcount = $sth->fetchAll();    
            var_dump($bcount);
            if($bcount[0]['bc']>0){
            echo "This node already has a bursty peripheral.";
           
            }
            else{
            echo "Plug in the bursty peripheral";    
            }
        }
    
    }
}
?>
