<?php
//if logged in, nav bar changes
session_start();
include('db_connect.php');
include("template_head.php");
if ($loggedIn == false) {
	print '
	<div class="carprofile">You Must be Logged In to Use the List, Please Use Links above to create account or log in
	</div><script>window.stop();</script></body></html>';
	exit();
}
else {	
	$username = $_SESSION['username'];
	$firstName =$_SESSION['firstName'];
	$budget = $_SESSION['budget'];
	print '<div class = "carcompare"><script src="js/carapp.js"></script>';

	print "<h4>$firstName" . "`s Car Selections Under $budget</h4>";
	//check the db to see if the user already has a car list saved
	//connect and select the db
	if(!$dbc = mysqli_connect(DBHOST, DBUSER, DBPASS)){
	print "Database Connection Error";
	}
	if(!@mysqli_select_db($dbc, DBNAME)){
	print "Error: Database not Selected Succesfully";
	}
	//create table if one doesn't exist 
	$tableName = 'carLists';
	if (mysqli_num_rows(@mysqli_query($dbc, "SHOW TABLES LIKE '$tableName'")) == 0){
	$tableCreateQuery = "CREATE TABLE $tableName (entry_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	username VARCHAR(20) NOT NULL, ranking INT(3) NOT NULL, year INT(4) NOT NULL, make VARCHAR(20) NOT NULL, 
	model VARCHAR(30) NOT NULL, engine VARCHAR(30) NOT NULL, cylinders VARCHAR(12) NOT NULL, aspiration VARCHAR(20) NOT NULL,
	horsepower INT(3) NOT NULL, drivetrain VARCHAR(3) NOT NULL, mileage VARCHAR(10) NOT NULL, price INT(6) NOT NULL, 
	imgsource VARCHAR(150), description TEXT(400) NOT NULL)";
		if (@mysqli_query($dbc, $tableCreateQuery)){	
		print "Table Made"; }
		else{
		print "Table Error";}
	}
	//check if username already has entries
	$usernameExistsQuery = "SELECT * FROM $tableName WHERE username = '$username'";
	$usernamecheck = mysqli_query($dbc, $usernameExistsQuery);
	$userLists = mysqli_fetch_array($usernamecheck, MYSQL_ASSOC);
	//assigns $listExists variabel to true if there is a list, false if list is all new
	$listExists = true;
	if (empty($userLists)) {
		$listExists = false;
	}
?>

	<table id="carTable">
	<tr id="tableHeader">
	<th scope="col">Rank</th>
	<th scope="col">Year</th>
	<th scope="col">Make</th>
	<th scope="col">Model</th>
	<th scope="col">Engine</th>
	<th scope="col">Horsepower</th>
	<th scope="col">DriveTrain</th>
	<th scope="col">Mileage</th>
	<th scope="col">Price</th>
	<th scope="col">Edit</th>
	<th scope="col">Delete</th>
	</tr>
	<tr class="products" id = "row0">
		<td id="c_rank"></td>
		<td id="c_year"></td>
		<td id="c_make"></td>
		<td id="c_model"></td>
		<td id="c_engine"></td>
		<td id="c_horsepower"></td>
		<td id="c_drivetrain"></td>
		<td id="c_mileage"></td>
		<td id="c_price"></td>
		<td id="c_edit"></td>
		<td id="c_delete"></td>
	</tr>
	</table>
	<p class="span_wrapper">
		<span class = "normalbtn" id="start_car_add">Add a Car</span>
	</p>
	<br/>
</div>

<div class="carprofile">
	<aside class = "specaside" id = "priceaside"></aside>
	<h3>Car Profile</h3>
	<!-- javascript changes based on car selected -->
	<h4 class = "carname" id = "cartitle">Click on a car to see it's profile</h4>		
	<p class = "cardesc" id = "cardescription"><img  id = "carpic" src="" class = "carimage" alt=""/> </p>
	<p class = "pricebanner" id = "specbanner" ></h5>
</div>

<div class="modal_background" id="modal_wrapper_form">
<div class="modal_content">
<span class="modal_header">Add A Car!</span>
<span class="modal_box_close" id="modal_close_btn">xx Cancel xx</span>
<p class="modal_text">Assign a rank and add your car details</p>

	<div class = "carformbackground">
		<form name="add_a_car" action="mylist.php" enctype="multipart/form-data" onsubmit="return validatecaradd('add_a_car')" method="post">
		<p class="carformprompt">Ranking (0 - 999)
		<input type="text" name="ranking" size="3" maxlength="3" />
		</p>
		<p class="carformprompt">Year (xxxx)
		<input type="text" name="year" size="4" maxlength="4" />
		</p>
		<p class="carformpromptwide">Car Make
		<input type="text" name="make" size="15" maxlength="20" />
		</p>
		<p class="carformpromptwide">Car Model
		<input type="text" name="model" size="15" maxlength="30" />
		</p>
		<p class="carformprompt">Power (HP)
		<input type="text" name="horsepower" size="3" maxlength="3" />
		</p>
		<p class="carformprompt">No. of Cylinders
		<select name="cylinders">
			<option value="2-cyl">2</option>
			<option value="3-cyl">3</option>
			<option value="4-cyl">4</option>
			<option value="5-cyl">5</option>
			<option value="6-cyl">6</option>
			<option value="8-cyl">8</option>
			<option value="10-cyl">10</option>
			<option value="12-cyl">12</option>
		</select></p>
		<p class="carformpromptwide">Engine Type
			<select name="engine_type">
			<option value="Normal Aspiration">Normal</option>
			<option value="Turbo">Turbocharged</option>
			<option value="Supercharged">Supercharged</option>
			<option value="Hybrid">Hybrid</option>
			<option value="EV">Electric Vehicle</option>
		</select></p>
		</p>	
	<p class="carformprompt">DriveTrain
		<select name="drivetrain">
			<option value="FWD">Front Wheel Drive</option>
			<option value="AWD">All Wheel Drive</option>
			<option value="RWD">Rear Wheel Drive</option>
			<option value="4WD">4 Wheel Drive</option>
		</select></p>
	<p class="carformprompt">(Optional)Photo Upload <i>Ratio 2to1,1 MB Limit</i>
	<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
	<input type="file" name="car_pic_src" /></p>
	<p class="carformprompt">Mileage
		<input type="text" name="mileage" size="7" maxlength="7" />
	</p>
	<p class="carformprompt">Price
	<input type="text" name="price" size="6" maxlength="6" />
	</p>
	<p class="carformprompt">Provide a brief description:
	<textarea name="description" cols="35" rows="4" maxlength="390" />
	Make notes on the details that matter to YOU</textarea>
	</p>
	<p class="formpromptleft">
	<input type = "submit" name="submitbtn" value="+ Add Car +" id="carsubmit"/>
	<input type = "hidden" name="submit-type" value = "newcar" />
	</p>
	</form>
</div>

</div>
</div>

<!-- Hidden form that will handle deletes (javascript will submit) -->
<div class="hidethis">
<form name="delete_car" id="delcar" action="mylist.php" enctype="multipart/form-data" method="post">
	<input type="hidden" name="submit-type" value="deletecar" />
	<input type="hidden" name="db-ID" id="setParam" />
</form>
</div>

<!-- Edit Page -->
<div class="modal_background_edit" id="modal_wrapper_form">
<div class="modal_content_edit">
<span class="modal_header">Edit Car!</span>
<span class="modal_box_close" id="edit_close_btn">xx Cancel xx</span>
<p class="modal_text">Assign a rank and add your car details</p>

	<div class = "carformbackground">
		<form name="edit_car" action="mylist.php" enctype="multipart/form-data" onsubmit="return validatecaradd('edit_car')" method="post">
		<p class="carformprompt">Ranking (0 - 999)
		<input type="hidden" name="db_id" id="f-entryID" />
		<input type="text" name="ranking" id="f-rank" size="3" maxlength="3" />
		</p>
		<p class="carformprompt">Year (xxxx)
		<input type="text" name="year" id="f-year" size="4" maxlength="4" />
		</p>
		<p class="carformpromptwide">Car Make
		<input type="text" name="make" id="f-make" size="15" maxlength="20" />
		</p>
		<p class="carformpromptwide">Car Model
		<input type="text" name="model" id="f-model" size="15" maxlength="30" />
		</p>
		<p class="carformprompt">Power (HP)
		<input type="text" name="horsepower" id="f-power" size="3" maxlength="3" />
		</p>
		<p class="carformprompt">No. of Cylinders
		<select name="cylinders" id="f-cylinders">
			<option value="2-cyl">2</option>
			<option value="3-cyl">3</option>
			<option value="4-cyl">4</option>
			<option value="5-cyl">5</option>
			<option value="6-cyl">6</option>
			<option value="8-cyl">8</option>
			<option value="10-cyl">10</option>
			<option value="12-cyl">12</option>
		</select></p>
		<p class="carformpromptwide" >Engine Type
			<select name="engine_type" id="f-asp">
			<option value="Normal Aspiration">Normal</option>
			<option value="Turbo">Turbocharged</option>
			<option value="Supercharged">Supercharged</option>
			<option value="Hybrid">Hybrid</option>
			<option value="EV">Electric Vehicle</option>
		</select></p>
		</p>	
	<p class="carformprompt">DriveTrain
		<select name="drivetrain" id="f-dt">
			<option value="FWD">Front Wheel Drive</option>
			<option value="AWD">All Wheel Drive</option>
			<option value="RWD">Rear Wheel Drive</option>
			<option value="4WD">4 Wheel Drive</option>
		</select></p>
	<p class="carformprompt"><span id="photo_prompt">(Optional)Photo Upload <i>Ratio 2to1,1 MB Limit</i></span>
	<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
	<input type="hidden" name="prev_pic_file" id="f-prevfile" />
	<input type="file" name="car_pic_src" /></p>
	<p class="carformprompt">Mileage
		<input type="text" name="mileage" id="f-mileage" size="7" maxlength="7" />
	</p>
	<p class="carformprompt">Price
	<input type="text" name="price" id="f-price" size="6" maxlength="6" />
	</p>
	<p class="carformprompt">Provide a brief description:
	<textarea name="description" id = "f-desc" cols="35" rows="4" maxlength="390" /></textarea>
	</p>
	<p class="formpromptleft">
	<input type = "submit" name="submitbtn" value="+ Update Car +" id="carsubmit"/>
	<input type = "hidden" name="submit-type" value = "editcar" />
	</p>
	</form>
</div>

</div>
</div>



<?php
}
//if data is being submitted, it will process first
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['submit-type'] == 'newcar'){
  //data is validated with javascript before coming here
	//store the data to variables
	$carRank = $_POST['ranking'];  $carYear = $_POST['year']; $carMake = trim($_POST['make']);
	$carModel = trim($_POST['model']); $carEngine = $_POST['cylinders'] . " " . $_POST['engine_type'];
	$carCyl = $_POST['cylinders']; $carAspiration = $_POST['engine_type'];
	$carHp = $_POST['horsepower']; $carDt = $_POST['drivetrain']; $carPrice = $_POST['price'];
	$carDesc = trim($_POST['description']); $carMileage = $_POST['mileage']; 
	
	$carDesc = htmlspecialchars($carDesc, ENT_QUOTES);
	$carMake = htmlspecialchars($carMake, ENT_QUOTES);
	$carModel = htmlspecialchars($carModel, ENT_QUOTES);
	//check to see if duplicate (such as with resending data)
	$checkQuery = "SELECT * FROM $tableName WHERE ranking='$carRank' AND year='$carYear' AND model='$carModel'
	AND engine='$carEngine' AND drivetrain='$carDt' AND price='$carPrice' AND description='$carDesc'";
	$checkPath = mysqli_query($dbc, $checkQuery);
	$results = mysqli_fetch_array($checkPath, MYSQL_ASSOC);
	if (empty($results)){
	$currentEntryUnique = true;
	} else {
		$currentEntryUnique = false;
	}
		
	if ($currentEntryUnique){
		//validate picture for upload and reassign to webroot directory
		if (!empty($_FILES['car_pic_src']['name']))
		{
			$fileError = $_FILES['car_pic_src']['error'];
			$carPic = $_FILES['car_pic_src']['name'];
			//exception handling
			if ($fileError > 0){
				if ($fileError == 2){
					$fileErrorMsg = "Your picture is too large (1000kb limit)";
				}
				else {$fileErrorMsg = "There was a problem uploading your pic";}
				$fileErrorMsg = $fileErrorMsg . "- Press OK to continue without picture, or cancel to retry";
				print "<div><script>
						var goFwd = confirm('$fileErrorMsg');
						if (goFwd == false){ window.stop(); }</script></div>";
				$carPic = null;			
				}
			else {  //this code runs upon successful photo selection
					//First make directory for user if it doesn't exist
				if(!file_exists($picStoragePath . $username)){
					mkdir($picStoragePath . $username);
				}
				//Move file to specified directory
				if(!move_uploaded_file($_FILES['car_pic_src']['tmp_name'], 
						$picStoragePath . $username . "/" . $_FILES['car_pic_src']['name'])){
						print "<div>Unknown Error Uploading Pictures</div>";
				}
				$carPic = $picStoragePath . $username . "/" . $carPic;
		
			}
		}
		else {
			$carPic = null;
		}
		
	
	//entry is determined unique with picture taken care of, now to insert into DB
	$insertQuery = "INSERT INTO $tableName (username, ranking, year, make, model, engine, cylinders, aspiration, horsepower, drivetrain,
	mileage, price, imgsource, description) VALUES ('$username', '$carRank', '$carYear', '$carMake', '$carModel', '$carEngine', '$carCyl',
	'$carAspiration', '$carHp','$carDt', '$carMileage', '$carPrice', '$carPic', '$carDesc')";
	if(@mysqli_query($dbc, $insertQuery)){}
	else {
		print "<div>Problem inserting car into db</div>";
	}	
}
	//now that car is in database - will make Javascript
	makeJavascriptforDisplay();
	
} 
else if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['submit-type'] == 'editcar') 
{
	$carRank = $_POST['ranking'];  $carYear = $_POST['year']; $carMake = trim($_POST['make']);
	$carModel = trim($_POST['model']); $carEngine = $_POST['cylinders'] . " " . $_POST['engine_type'];
	$carCyl = $_POST['cylinders']; $carAspiration = $_POST['engine_type'];
	$carHp = $_POST['horsepower']; $carDt = $_POST['drivetrain']; $carPrice = $_POST['price'];
	$carDesc = trim($_POST['description']); $carMileage = $_POST['mileage']; $cardbID = $_POST['db_id'];
	
	$carDesc = htmlspecialchars($carDesc, ENT_QUOTES);
	$carMake = htmlspecialchars($carMake, ENT_QUOTES);
	$carModel = htmlspecialchars($carModel, ENT_QUOTES);

	if (!empty($_FILES['car_pic_src']['name']))
	{
		$fileError = $_FILES['car_pic_src']['error'];
		$carPic = $_FILES['car_pic_src']['name'];
		//exception handling
		if ($fileError > 0){
			if ($fileError == 2){
				$fileErrorMsg = "Your picture is too large (1000kb limit)";
			}
			else {$fileErrorMsg = "There was a problem uploading your pic";}
			$fileErrorMsg = $fileErrorMsg . "- Press OK to continue without picture, or cancel to retry";
			print "<div><script>
					var goFwd = confirm('$fileErrorMsg');
					if (goFwd == false){ window.stop(); }</script></div>";
			$carPic = null;			
			}
		else {  //this code runs upon successful photo selection
				//First make directory for user if it doesn't exist
			if(!file_exists($picStoragePath . $username)){
				mkdir($picStoragePath . $username);
			}
			//Move file to specified directory
			if(!move_uploaded_file($_FILES['car_pic_src']['tmp_name'], 
					$picStoragePath . $username . "/" . $_FILES['car_pic_src']['name'])){
					print "<div>Unknown Error Uploading Pictures</div>";
			}
			$carPic = $picStoragePath . $username . "/" . $carPic;
	
		}
	}
	else if (!empty($_POST['prev_pic_file'])) {
		$carPic = $_POST['prev_pic_file'];
	}
	else {
		$carPic = null;
	}

	//update the DB with following query
	
	$updateQuery = "UPDATE $tableName SET ranking='$carRank', year='$carYear', make='$carMake', model='$carModel', engine='$carEngine',
		cylinders='$carCyl', aspiration='$carAspiration', horsepower='$carHp', drivetrain='$carDt', mileage='$carMileage', price='$carPrice',
		imgsource='$carPic', description='$carDesc' WHERE entry_id = $cardbID";
	if(@mysqli_query($dbc, $updateQuery)) { }
	else { echo "<div>Problem Updating</div>"; }

	makeJavascriptforDisplay();

}
else if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['submit-type'] == 'deletecar') {
	$entryID = $_POST['db-ID'];
	$deleteQ = "DELETE FROM $tableName WHERE entry_id= $entryID";
	@mysqli_query($dbc, $deleteQ);
	makeJavascriptforDisplay();
}
else if ($listExists){
	makeJavascriptforDisplay();
}


print "<script src='js/carform.js'></script>";
print "</body></html>";
//mysql_close($dbc);
//functions defined here

function makeJavascriptforDisplay(){
	global $dbName, $username, $tableName, $dbc;
	//get car info, querying based on username
	$getInfoQuery = "SELECT * FROM $tableName WHERE username='$username' ORDER BY ranking ASC";
	if($carDataPull = mysqli_query($dbc, $getInfoQuery)){
		//what follows is Javascript to create objects used in the display
		$carNo = 0;
		$carIndex = "car";
		print "<div><script>var carList = new Array();";
		while ($carResults = mysqli_fetch_array($carDataPull, MYSQL_ASSOC)){
			$carNo = $carNo + 1;
			$carIndex = "car" . $carNo;
			print "var $carIndex = new usedCar('{$carResults['entry_id']}','{$carResults['ranking']}', '{$carResults['year']}','{$carResults['make']}','{$carResults['model']}','{$carResults['engine']}','{$carResults['horsepower']}','{$carResults['drivetrain']}','{$carResults['mileage']}','{$carResults['price']}','{$carResults['imgsource']}','{$carResults['description']}');";
			print "carList.push($carIndex);";
		}
		//carList is now made - now to call Javascript display function
		
		print "makeTable(carList);";
		print "</script></div>";
	}
	else {print "<div>Problem getting data from DB</div>"; }
}


mysqli_close($dbc);
?>