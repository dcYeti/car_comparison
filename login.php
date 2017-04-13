<?php
$loggedIn = false;
include('db_connect.php');

//start output buffer, set variables for nav bar based on cookie existence.
ob_start();

//if logged in, a message telling user to log out first will appear.
if (isset($_COOKIE['MP4'])){	
	if (htmlentities($_COOKIE['MP4']) == '12C'){
		//credentials are authentic, Tell user to log out to log in to different accoutn
		$loggedIn = true;
		include("template_head.html");
		print '
		<div class = "carprofile">You are already logged in.  To view or create another account, please log out first.
		';
		}
}
else {
//handle form or accept credentials
//handle form submission if receiving data
//check if form is being submitted
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  //first check - to see if the fields are filled out
  if (empty($_POST['username']) || empty($_POST['passwordtry'])){
	include("template_head.php");
	print '
	<div class = "carprofile">
	<h4>You are missing one or both fields - Please try again.</h4>';
  }
  else
  {
	//get the info the user is submitting, store to variable
	$username4check = strtolower(trim($_POST['username']));
	$password4check = $_POST['passwordtry'];

	//connect and select the db
	$dbName = 'anthopd6_carcomparison';
	if(!$dbc = mysqli_connect(localhost, anthopd6_stthng, israel2020)){
	print "Database Connection Error";
	}
	if(!@mysqli_select_db($dbName, $dbc)){
	print "Error: Database not Selected Succesfully";
	}
	//check to see if the username's there
	$tableName = 'car_users';
	$usernameExistsQuery = "SELECT * FROM $tableName WHERE username = '$username4check'";
	$usernamecheck = mysqli_query($usernameExistsQuery, $dbc);
	$userInfo = mysqli_fetch_array($usernamecheck);
	
	$trueName = $userInfo['username'];
	$truePass = $userInfo['password'];
	$trueFirstName = $userInfo['firstname'];
	$trueBudget = $userInfo['budget'];
	  if (($username4check == $trueName) && ($password4check == $truePass)){
		//set cookie and start session
		$loggedIn = true;
		include("template_head.php");
		setcookie('MP4', "12C", time()+7200);
		session_start();
		$_SESSION['firstName'] = $trueFirstName;
		$_SESSION['username'] = $trueName;
		$_SESSION['budget'] = $trueBudget;
		print '<div class="carprofile">';
		print "<h4>You are now logged in!  Make Your Car List by Selecting <b>MY LIST</b> above</h4>";
	  }
	  else {
		include("template_head.php");
		print '<div class="carprofile">';
		print '<h4>Your username or password is not correct!  Try again.</h4>';	
	  }
	mysql_close($dbc);
  }
}
else{
	//The initial form
	include("template_head.php");
	print '
	<div class = "carprofile">
	<h4>Enter Your Account Info and Start Your Car List</h4>
	<form name="registeraccount" action="login.php" method="post">
	<p class="formprompt">Enter Your Username: 
	<input type="text" name="username" size="18" maxlength="20" />
	</p>
	<p class="formprompt">Enter Your Password?
	<input type="password" name="passwordtry" size="18" maxlength="20" />
	</p>
	<p class="formpromptleft"><br/>
	<input type = "submit" name="submitbtn" value="submit" id="smit"/>
	</p>
	</form>';
}
}
	print CLOSER;
	ob_end_flush();
?>