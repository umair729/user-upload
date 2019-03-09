<?php
//parameters from Command Line
$options = getopt("f:c:h:d:u:p:r:i");

if(isset($options["i"]))
{
    help();
    die();
}

if(isset($options["f"]))
{
    $csvFile = $options["f"];
    $extension = end(explode('.', $csvFile));

    if($extension != 'csv')
    {
       echo 'This is not a valid CSV file';
       die();
    }
}

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

$db = $options["d"];
$username = $options["u"];

connectDb($dbhost, $username, $password, $db);

function connectDb($host, $name, $pass, $dbase)
{
    mysql_connect($host,$name,$pass) or die (mysql_error());
    mysql_select_db($dbase) or die (mysql_error());
}

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

//read data from file and save into DB
$h = fopen($csvFile, "r");
$flag = 0;
while ((($emapData = fgetcsv($h, 1000, ",")) !== FALSE) && $emapData[0]) 
{
    if(isset($options["r"]))
    {
        print "Data did not enter into database because of DRY RUN";
        break;
    }
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

function help()
{
    print "Please follow these commands to run the program...\n";
    print "-f parameter for CSV FILE, -c parameter for Create Table\n-u parameter for DB Username, -p parameter for DB Password\n-r parameter for Dry Run and -h parameter for HELP\n";
    print "\n";
    print "To run the Program please use this Command:\nuser_upload.php -f users.csv -h hostname -d DBNAME -u DBusername -p DBpassword -c create-table\n";
    print "\n";
    print "To just create table please use this Command:\nuser_upload.php -c create-table -h hostname -d DBNAME -u DBusername -p DBpassword\n";
    print "\n";
    print "For Dry Run, Please add -r parameter in above command like -r dry-run\n";
    print "\n";
    print "To check all commands (HELP), please use command:\nuser_upload.php -i help\n";
}

fclose($h);

?>