<?php
include("template_head.php");
include("db_connect.php");
$username = strtolower($_POST['username']);
$name = $_POST['firstname'];
$password = $_POST['passwordinput'];
$budget = $_POST['budget'];

//mySQL connection say a prayer!
$dbc = mysqli_connect(DBHOST,DBUSER,DBPASS) or die('Failure to connect to MySQL Server');
	$createDBQuery = 'CREATE DATABASE IF NOT EXISTS ' . DBNAME;

if(@mysqli_query($dbc, $createDBQuery)) {       //Checks for DB and create if not there

//assign table create query to car_users
	$tableName = 'car_users';

	/* keep this code for reference - antiquated way to check for presence of table 
	if (mysqli_num_rows(@mysqli_query("SHOW TABLES LIKE '$tableName'")) == 0){ */
	$tableCreateQuery = "CREATE TABLE IF NOT EXISTS $tableName (entry_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	username VARCHAR(20) NOT NULL, firstname VARCHAR(20) NOT NULL, password CHAR(40) NOT NULL,
	budget VARCHAR(20) NOT NULL)";
	@mysqli_select_db($dbc, DBNAME);
		if (@mysqli_query($dbc, $tableCreateQuery)) {  }
		else{
		print "Table Error";}

	//write info to appropriate columns: entry_id, username, firstname, password, budget
	$insertQuery = "INSERT INTO $tableName (username, firstname, password, budget) VALUES 
	('$username', '$name', SHA1('$password'), '$budget')";
	if (!@mysqli_query($dbc, $insertQuery)){
		print "error inserting user data to database";   }
	
	//this is a general list of usernames used by ajax to check if username exists before hitting validation
	//add to file - javascript will pull file and check for repeats

	if(is_writable($filePath)){
		$username4storage = trim($username) . "@";
		file_put_contents($filePath, $username4storage, FILE_APPEND | LOCK_EX); 
		}
	else{ print "error writing username to file";}
	mysqli_close($dbc);

print '<div class="carcompare">';
print "Hello $name - Your account has been set up.  <br/>
Your username is <b>$username</b><br/>Please use link above to login<br/>";
print "Keep your car selections under $budget </p>";
echo CLOSER;

}
?>

