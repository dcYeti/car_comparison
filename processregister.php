<?php
include("template_head.html");
$username = strtolower($_POST['username']);
$name = $_POST['firstname'];
$password = $_POST['passwordinput'];
$budget = $_POST['budget'];

//mySQL connection say a prayer!
$dbName = 'anthopd6_carcomparison';
if(!$dbc = mysql_connect(localhost, anthopd6_stthng, israel2020)){
	print "Database Connection Error";
}
if(!@mysql_select_db($dbName, $dbc)){
	print "Error: Database not Selected Succesfully";
}
//assign table create query to car_users
$tableName = 'car_users';
if (mysql_num_rows(@mysql_query("SHOW TABLES LIKE '$tableName'")) == 0){
	$tableCreateQuery = "CREATE TABLE $tableName (entry_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	username VARCHAR(20) NOT NULL, firstname VARCHAR(20) NOT NULL, password VARCHAR(20) NOT NULL,
	budget VARCHAR(20) NOT NULL)";
		if (@mysql_query($tableCreateQuery, $dbc)){	print "Table Made"; }
		else{
		print "Table Error";}
	}
	//write info to appropriate columns: entry_id, username, firstname, password, budget
	$insertQuery = "INSERT INTO $tableName (username, firstname, password, budget) VALUES 
	('$username', '$name', '$password', '$budget')";
	if (!@mysql_query($insertQuery, $dbc)){
		print "error inserting user data to database";   }
	
	//this is a general list of usernames used by ajax to check if username exists before hitting validation
	//add to file - javascript will pull file and check for repeats
	$filePath = "../../carcomparisondata/usernamelist.txt";
	if(is_writable($filePath)){
		$username4storage = trim($username) . "@";
		file_put_contents($filePath, $username4storage, FILE_APPEND | LOCK_EX); 
		}
	else{ print "error writing username to file";}
	mysql_close($dbc);

print '<div class="carcompare">';
print "Hello $name - Your account has been set up.  <br/>
Your username is <b>$username</b><br/>Please use link above to login<br/>";
print "Keep your car selections under $budget </p>";
print CLOSER;
?>

