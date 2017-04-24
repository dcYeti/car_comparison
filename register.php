<?php include('db_connect.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<script>
	//get info from form
	<?php 
		//This will get the path for the AJAX check and put it in a JS variable
		echo "var txtFilePath = '" . $filePath . "';"; 
	?>

	function validateform(){
		var usersname = document.forms["registeraccount"]["username"].value;
		var nameofperson = document.forms["registeraccount"]["firstname"].value;
		var pass1 = document.forms["registeraccount"]["passwordinput"].value;
		var pass2 = document.forms["registeraccount"]["passwordinputverify"].value;
		//we assume username is unique unless we find out otherwise
		var usernameExists = false;
		var xhr = new XMLHttpRequest();
		//find if username exists
		xhr.onload = function(){
			if(xhr.status == 200){
				var totalfile = xhr.responseText.toString();
				var username4check = usersname.trim().concat("@");
				var stringSearchIndex = totalfile.search(username4check);
				if (stringSearchIndex > -1){
					usernameExists = true;				
				}
				}
			else {alert ('Problem connecting with database, please try again later');  return false;}
			}
	today = new Date();
	today = today.getTime();
	xhr.open('GET', txtFilePath + '?cache=' + today, false);
	xhr.send(null);
		
	if ((usersname == null || nameofperson == null || pass1 == null || pass2 == null) ||
	   (usersname == "" || nameofperson == "" || pass1 == "" || pass2 == "")){
		var errorMessage = "You Have Blank Fields, Please Re-Check Form";
		alert(errorMessage);
		return false;
	}
	else if (usernameExists){
		var errorMessage = "The username you selected already is taken.  Please select another";
		alert(errorMessage);
		return false;
		}
	else if (pass1 != pass2){
		var errorMessage = "Your passwords Do Not Match, Please re-Check";
		alert(errorMessage);
		return false;
	}
	else{
		return true;
	}
	}
	
	</script>
	<title>Car Comparison Site Register Account</title>
	<link href="cssstyles/styles.css" type="text/css" rel="stylesheet" />	
	<link href="cssstyles/formstyles.css" type="text/css" rel="stylesheet" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	</head>

<?php 
include("template_head.php");
?>


<div class = "formbackground">
	<h4>Register An Account and Create Your Own Car List!</h4>
	<i>This is a web project hosted on a site with no SSL Encryption - Do not use personal info or info used for other sites!</i>
	<form name="registeraccount" action="processregister.php" onsubmit="return validateform()" method="post">
	<p class="formprompt">Select A Username: 
	<input type="text" name="username" size="18" maxlength="20" />
	</p>
	<p class="formprompt">What's Your First Name?
	<input type="input" name="firstname" size="18" maxlength="20" />
	</p>
	<p class="formprompt">Select Password: 
	<input type="password" name="passwordinput" size="18" maxlength="20" />
	</p>
	<p class="formprompt">Re-type Your Password: 
	<input type="password" name="passwordinputverify" size="18" maxlength="20" />
	</p>
	<p class="formprompt">Select A Maximum Budget for Your Car
	<select name="budget">
		<option value="5k">$5,000</option>
		<option value="10k">$10,000</option>
		<option value="15k">$15,000</option>
		<option value="20k">$20,000</option>
		<option value="25k">$25,000</option>
		<option value="30k">$30,000</option>		
		<option value="35k">$35,000</option>
		<option value="40k">$40,000</option>
		<option value="50k">$50,000</option>
		<option value="no-max">No Max</option>	
	</select>
	</p>
	<p class="formpromptleft"><br/>
	<input type = "submit" name="submitbtn" value="submit" id="smit"/>
	</p>
	</form>
</div>

</body>
</html>
