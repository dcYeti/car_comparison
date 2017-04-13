<?php
//if logged in, nav bar changes

include("template_head.php");

if ($loggedIn == false) {
	include("intro.php");
}
else {
	include ('member_home.php');
}	

?>


<!--  	Exclude running script on home page  
		<script src="js/carinfo.js"></script>  -->
</body>
</html>
