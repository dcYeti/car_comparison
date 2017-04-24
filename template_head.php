<?php
if (isset($_COOKIE['MP4'])){	
	if (htmlentities($_COOKIE['MP4']) == '12C'){
    	$loggedIn = true;
	}
	else {$loggedIn = false;}
	}		
	else
	{	
        $loggedIn = false;
	}

	//In some cases, the $loggedIn variable will need to be overridden to get menu bar options even when cookie is or isn't set
	if (isset($overrideTrue) && $overrideTrue = true){
		$loggedIn = true;
	}
	if (isset($overrideFalse) && $overrideFalse == true){
		$loggedIn = false;
	}

?>



<!DOCTYPE html>
<?php define("CLOSER", "</div> </body> </html>"); ?>
<html>
<head>
	<title>Car Comparison Site</title>
	<link href="cssstyles/styles.css" type="text/css" rel="stylesheet" />
	<link href="cssstyles/formstyles.css" type="text/css" rel="stylesheet" />
	<link rel="stylesheet" href="../font-awesome-4.6.3/css/font-awesome.min.css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	</head>
<!-- This will escape to PHP to find the appropraite navbar link -->

<body>
<header>
<h2>Car Comparison List Utility</h2>
<nav>
	<ul>
		<a href="../index.html"><li class="navbar"></li></a>
		<a href="index.php"><li class="navbar">Home</li></a>
		<li class="spacer">spacer</li>
		<?php
			if ($loggedIn == true){ print '
			<a href="mylist.php"><li class ="navbar">MY LIST</li></a> 
			<a href="logout.php"><li class="navbar">Log Out</li></a>'; }
			else { print '
			<a href="register.php"><li class="navbar">Create Account</li></a>
			<a href="login.php"><li class="navbar">Have an Account? Log In</li></a>'; }
		?>
	</ul>
</nav>
</header>
