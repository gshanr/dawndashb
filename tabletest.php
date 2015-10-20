<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pwd = 'lptm42b';

$database = 'gowrir_dawn';
$table = 'ActiveMotes';



if (!mysql_connect('dallas113.arvixeshared.com', 'gowrir_dawndb', 'dawn1234'))
    die("Can't connect to database");

if (!mysql_select_db($database))
    die("Can't select database");

// sending query
$result = mysql_query("SELECT * FROM {$table}");
if (!$result) {
    die("Query to show fields from table failed");
}

$fields_num = mysql_num_fields($result);

$html = stripslashes("<h1>Table: {$table}</h1>");
$html .= stripslashes("<table border='1'><tr>");
// printing table headers
for($i=0; $i<$fields_num; $i++)
{
    $field = mysql_fetch_field($result);
    $html.= stripslashes("<td>{$field->name}</td>");
}
$html .= stripslashes("</tr>");
// printing table rows
while($row = mysql_fetch_row($result))
{
    $html .= "<tr>";

    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable
    foreach($row as $cell)
        $html .= stripslashes("<td>$cell</td>");

    $html .= stripslashes("</tr>");
}

mysql_free_result($result);
//echo htmlentities(stripslashes($html),ENT_QUOTES);
$html = str_replace('/','',$html);
$html = str_replace('"', '', $html);  

echo json_encode(htmlentities(stripslashes($html),ENT_NOQUOTES),TRUE);
?>
