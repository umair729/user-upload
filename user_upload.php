<?php

$options = getopt("f:c:h:d:u:p:");
$csvFile = $options["f"];

$dbhost = '';

if(isset($options["u"]) && isset($options["p"]) && isset($options['d']))
{
    if(isset($options["h"]))
    {
        $dbhost = $options["h"];
    }
    else
    {
        $dbhost = 'localhost';
    }
}
else
{
    die('Please enter correct command line arguments -h Database Host -u Username, -p Password, -d Database name...');
}

//$dbhost = $options["h"];
$db = $options["d"];
$username = $options["u"];
$password = isset($options["p"]);
$password = '';
connectDb($dbhost, $username, $password, $db);

function connectDb($host, $name, $pass, $dbase)
{
    //var_dump($host, $name, $pass, $dbase); die();
    $conn = mysql_connect($host,$name,$pass) or die (mysql_error());
    mysql_select_db($dbase) or die (mysql_error());
}

//$createTable = $options["c"];
if(isset($options["c"]))
{
    $create = "CREATE TABLE IF NOT EXISTS users (
    id int NOT NULL auto_increment PRIMARY KEY,
    name varchar (50) NOT NULL,
    surname varchar (50) NOT NULL,
    email varchar (50) NOT NULL
    )";

    $results = mysql_query($create) or die (mysql_error());

    die("The table has been created or updated");
}
    
$h = fopen($csvFile, "r");
$flag = 0;
while ((($emapData = fgetcsv($h, 1000, ",")) !== FALSE) && $emapData[0]) 
{
    if($flag == 0)
    {
        $flag++;
    }
    else
    {
        $emapData[0] = ucfirst($emapData[0]);
        $emapData[1] = ucfirst($emapData[1]);
        $emapData[2] = strtolower($emapData[2]);
        if (!filter_var($emapData[2], FILTER_VALIDATE_EMAIL)) 
        {
            echo("$emapData[2] is not a valid email address\n");
            $emapData[2] = ' ';
            
        } 
        sqlQuery($emapData[0], $emapData[1], $emapData[2]);
    }
}

function sqlQuery($fname, $sname, $email)
{
    $sql = "INSERT into users(name,surname,email) values('$fname','$sname','$email')";
    mysql_query($sql);
}

fclose($h);
?>

<?php

//$number = 1;
//$out = array();
//while($number <= 100){
//	if($number % 3 == 0 && $number % 5 == 0)
//		array_push($out, 'foobar');
//	else if($number % 3 == 0)
//		array_push($out, 'foo');
//	else if($number % 5 == 0)
//		array_push($out, 'bar');
//	else
//		array_push($out, "$number");
//	$number++;
//}
//echo implode(', ', $out);
?>
