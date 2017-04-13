<?php
//if logged in, nav bar changes
session_start();
if (!((isset($_COOKIE['MP4'])) && htmlentities($_COOKIE['MP4']) == '12C')){	
	   	$loggedIn = false;
		include("template_head.php");
		print '
		<div class="carprofile">You Must be Logged In to Use the List, Please Use Links above to create account or log in
		</div><script>window.stop();</script></body></html>';
	}
	else{
		$loggedIn = true;
	}
include("template_head.php");
$username = $_SESSION['username'];
$firstName =$_SESSION['firstName'];
$budget = $_SESSION['budget'];
print '<div class = "carcompare"><script src="js/carJSON.js"></script>';

print "<h4>$firstName" . "`s Car Selections Under $budget</h4>";
//check the db to see if the user already has a car list saved
	//connect and select the db
	$dbName = 'anthopd6_carcomparison';
	if(!$dbc = mysqli_connect($host, $dbUser, $dbPass)){
	print "Database Connection Error";
	}
	if(!@mysqli_select_db($dbName, $dbc)){
	print "Error: Database not Selected Succesfully";
	}
	//create table if one doesn't exist 
	$tableName = 'carLists';
	if (mysql_num_rows(@mysql_query("SHOW TABLES LIKE '$tableName'")) == 0){
	$tableCreateQuery = "CREATE TABLE $tableName (entry_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	username VARCHAR(20) NOT NULL, ranking INT(3) NOT NULL, year INT(4) NOT NULL, make VARCHAR(20) NOT NULL, 
	model VARCHAR(30) NOT NULL, engine VARCHAR(30) NOT NULL, horsepower INT(3) NOT NULL, drivetrain VARCHAR(3)
	NOT NULL, price INT(6) NOT NULL, imgsource VARCHAR(150), description TEXT(400) NOT NULL)";
		if (@mysql_query($tableCreateQuery, $dbc)){	
		print "Table Made"; }
		else{
		print "Table Error";}
	}
	//check if username already has entries
	$usernameExistsQuery = "SELECT * FROM $tableName WHERE username = '$username'";
	$usernamecheck = mysql_query($usernameExistsQuery, $dbc);
	$userLists = mysql_fetch_array($usernamecheck);
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
	<th scope="col">Price</th>
	</tr>
	<tr class="products" id = "row0">
		<td id="c_rank"></td>
		<td id="c_year"></td>
		<td id="c_make"></td>
		<td id="c_model"></td>
		<td id="c_engine"></td>
		<td id="c_horsepower"></td>
		<td id="c_drivetrain"></td>
		<td id="c_price"></td>
	</tr>
	</table>
	<p class="span_wrapper">
		<span class = "normalbtn" id="start_car_add">Add a Car</span>
	</p>
	<br/>
</div>

<div class="carprofile">
	<h3>Car Profile</h3>
	<!-- javascript changes based on car selected -->
	<h4 class = "carname" id = "cartitle">Click on a car to see it's profile</h4>
	<p class = "cardesc" id = "cardescription"><img  id = "carpic" src="" class = "carimage" alt=""/> </p>
	<aside class = "specaside" id = "priceaside"></aside>
	<p class = "pricebanner" id = "specbanner" ></h5>
</div>

<div class="modal_background" id="modal_wrapper_form">
<div class="modal_content">
<span class="modal_header">Add A Car!</span><p class="modal_text">Assign a rank and add your car details</p>
	<div class = "carformbackground">
		<form name="add_a_car" action="mylist.php" enctype="multipart/form-data" onsubmit="return validatecaradd()" method="post">
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
	<p class="carformpromptwide">(Optional)Photo Upload <i>Ratio 2to1,1 MB Limit</i>
	<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
	<input type="file" name="car_pic_src" /></p>
	<p class="carformprompt" id="extrabuffer">Price
	<input type="text" name="price" size="6" maxlength="6" />
	</p>
	<p class="carformpromptxwide">Provide a brief description:
	<textarea name="description" cols="35" rows="4" maxlength="390" />
	Make notes on the details that matter to YOU</textarea>
	</p>
	<p class="formpromptleft">
	<input type = "submit" name="submitbtn" value="+ Add Car +" id="carsubmit"/>
	</p>
	</form>
</div>
<span class="modal_box_close" id="modal_close_btn">xx Cancel xx</span>
</div>
</div>


<?php
//if data is being submitted, it will process first
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  //data is validated with javascript before coming here
	//store the data to variables
	$carRank = $_POST['ranking'];  $carYear = $_POST['year']; $carMake = trim($_POST['make']);
	$carModel = trim($_POST['model']); $carEngine = $_POST['cylinders'] . " " . $_POST['engine_type'];
	$carHp = $_POST['horsepower']; $carDt = $_POST['drivetrain']; $carPrice = $_POST['price'];
	$carPic = $_POST['car_pic_src']; $carDesc = trim($_POST['description']);
	
	$carDesc = htmlspecialchars($carDesc, ENT_QUOTES);
	$carMake = htmlspecialchars($carMake, ENT_QUOTES);
	$carModel = htmlspecialchars($carModel, ENT_QUOTES);
	//check to see if duplicate (such as with resending data)
	$checkQuery = "SELECT * FROM $tableName WHERE ranking='$carRank' AND year='$carYear' AND model='$carModel'
	AND engine='$carEngine' AND drivetrain='$carDt' AND price='$carPrice' AND description='$carDesc'";
	$checkPath = mysql_query($checkQuery, $dbc);
	$results = mysql_fetch_array($checkPath);
	if (empty($results)){
	$currentEntryUnique = true;
	} else {
		$currentEntryUnique = false;
	}
		
	if ($currentEntryUnique){
		//validate picture for upload and reassign to webroot directory
		if (!empty($_FILES['car_pic_src']['name'])){
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
			else {   //this code runs upon successful photo selection
				$picStoragePath = "../../carcomparisondata/user_photos/";
				if(!move_uploaded_file($_FILES['car_pic_src']['tmp_name'], 
				"../../carcomparisondata/user_photos/{$_FILES['car_pic_src']['name']}")){
					print "<div>Unknown Error Uploading Pictures</div>";
				}
				$carPic = $picStoragePath . $carPic;		
			}
		}
		else {
			$carPic = null;
		}
		
	
	//entry is determined unique with picture taken care of, now to insert into DB
	$insertQuery = "INSERT INTO $tableName (username, ranking, year, make, model, engine, horsepower, drivetrain,
	price, imgsource, description) VALUES ('$username', '$carRank', '$carYear', '$carMake', '$carModel', '$carEngine',
	'$carHp','$carDt', '$carPrice', '$carPic', '$carDesc')";
	if(@mysql_query($insertQuery, $dbc)){}
	else {
		print "<div>Problem inserting car into db</div>";
	}	
}
	//now that car is in database - will make Javascript
	makeJavascriptforDisplay();
	
} 
else if ($listExists){
	makeJavascriptforDisplay();
}


print "<script src='js/carapp.js'></script>";
print "</body></html>";
//mysql_close($dbc);
//functions defined here

function makeJavascriptforDisplay(){
	global $dbName, $username, $tableName, $dbc;
	//get car info, querying based on username
	$getInfoQuery = "SELECT * FROM $tableName WHERE username='$username' ORDER BY ranking ASC";
	if($carDataPull = mysql_query($getInfoQuery, $dbc)){
		//what follows is Javascript to create objects used in the display
		$carNo = 0;
		$carIndex = "car";
		print "<div><script>var carList = new Array();";
		while ($carResults = mysql_fetch_array($carDataPull)){
			$carNo = $carNo + 1;
			$carIndex = "car" . $carNo;
			print "var $carIndex = new usedCar('{$carResults['ranking']}', '{$carResults['year']}','{$carResults['make']}',
			'{$carResults['model']}','{$carResults['engine']}','{$carResults['horsepower']}','{$carResults['drivetrain']}',
			'{$carResults['price']}','{$carResults['imgsource']}','{$carResults['description']}');";
			print "carList.push($carIndex);";
		}
		//carList is now made - now to call Javascript display function
		
		print "makeTable(carList);";
		print "</script></div>";
	}
	else {print "<div>Problem getting data from DB</div>"; }
}
mysql_close($dbc);
?>