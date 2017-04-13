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
?>



<!DOCTYPE html>
<?php define("CLOSER", "</div> </body> </html>"); ?>
<html>
<head>
	<title>Car Comparison Site</title>
	<link href="cssstyles/styles.css" type="text/css" rel="stylesheet" />
	<link href="cssstyles/formstyles.css" type="text/css" rel="stylesheet" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	</head>
<!-- This will escape to PHP to find the appropraite navbar link -->

<body>
<header>
Car Comparison List Utility<br/>
<nav>
	<ul>
		<a href="../index.html"><li class="navbar"></li></a>
		<a href="index.php"><li class="navbar">Home</li></a>
		<li class="spacer">spacer</li>
		<?php
			if ($loggedIn == 'yes'){ print '
			<a href="mylist.php"><li class ="navbar">MY LIST</li></a> 
			<a href="logout.php"><li class="navbar">Log Out</li></a>'; }
			else { print '
			<a href="register.php"><li class="navbar">Create Account</li></a>
			<a href="login.php"><li class="navbar">Have an Account? Log In</li></a>'; }
		?>
	</ul>
</nav>
</header>
