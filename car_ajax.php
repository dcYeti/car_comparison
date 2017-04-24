<?php

header('Content-Type: application/json');
require('db_connect.php'); //Gets DB Credentials

$dbID = $_GET['db_id'];

//Connect with DB and extrac the particular car info
if(!$dbc = mysqli_connect(DBHOST, DBUSER, DBPASS)){
	echo "Database Connection Error";
}
if(!@mysqli_select_db($dbc, DBNAME)){
	echo "Error: Database not Selected Succesfully";
}
$tableName = 'carLists'; //Name of the car table

$carQuery = "SELECT * FROM $tableName WHERE entry_id=$dbID";

$carQueryExec = mysqli_query($dbc, $carQuery);
$carResults = mysqli_fetch_array($carQueryExec, MYSQL_ASSOC);

//Upon successful extraction of data, the response text array is filled using same keys as db column names
$responseText = array(); //This will be ultimate array that will get encoded
$responseText['entry_id'] 	= $carResults['entry_id'];
$responseText['username'] 	= $carResults['username'];
$responseText['ranking'] 	= $carResults['ranking'];
$responseText['year'] 		= $carResults['year'];
$responseText['make'] 		= $carResults['make'];
$responseText['model'] 		= $carResults['model'];
$responseText['engine'] 	= $carResults['engine'];
$responseText['cylinders'] 	= $carResults['cylinders'];
$responseText['aspiration'] = $carResults['aspiration'];
$responseText['horsepower'] = $carResults['horsepower'];
$responseText['drivetrain'] = $carResults['drivetrain'];
$responseText['mileage'] 	= $carResults['mileage'];
$responseText['price'] 		= $carResults['price'];
$responseText['imgsource'] 	= $carResults['imgsource'];
$responseText['description'] = $carResults['description'];


echo json_encode($responseText);

?>