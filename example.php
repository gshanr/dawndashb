<?php
// define an array with address for diferent courses
$crs = array(
  'other'=>'',
  'php-mysql'=>'php-mysql',
  'javascript'=>'javascript',
  'actionscript'=>'actionscript/lessons-as3',
  'jquery'=>'jquery/jquery-tutorials'
);

// check if there are data sent through POST, with keys "nm", "cs", and "cmt"
if(isset($_POST['nm']) && isset($_POST['cs']) && isset($_POST['cmt'])) {
  $_POST = array_map("strip_tags", $_POST);       // removes posible tags from POST

  // get data
  $nm = $_POST['nm'];
  $cs = $_POST['cs'];
  $cmt = $_POST['cmt'];

  // define a variable with the response of this script
  $rehtml = '<h4>Hy '. $nm. '</h4> Here`s the link for <b>'. $cs. '</b> Course: <a href="http://coursesweb.net/'. $crs[$cs]. '">'. $cs. '</a><br />Your comments: <i>'. $cmt. '</i>';
}
else $rehtml = 'Invalid data';

echo $rehtml;        // output (return) the response
?>