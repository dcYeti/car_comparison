<?php
//if logged in, nav bar changes
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

include("template_head.html");
?>

<div class = "carcompare">

	<h4>Anthony's Top Choice Used Cars Under $20k</h4>
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
</div>

<div class="carprofile">
	<h3>Car Profile</h3>
	<!-- javascript changes based on car selected -->
	<h4 class = "carname" id = "cartitle">Click on a car to see it's profile</h4>
	<p class = "cardesc" id = "cardescription"><img  id = "carpic" src="" class = "carimage" alt=""/> </p>
	<aside class = "specaside" id = "priceaside"></aside>
	<p class = "pricebanner" id = "specbanner" ></h5>
    <script src="js/carinfo.js"></script>
</div>

</body>
</html>
