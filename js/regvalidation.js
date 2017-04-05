
function validateform(){
	
	
	//assign field values to variables for analysis
	var username = document.forms["registeraccount"]["username"].value;
	var nameofperson = document.forms["registeraccount"]["firstname"].value;
	var pass1 = document.forms["registeraccount"]["passwordinput"].value;
	var pass2 = document.forms["registeraccount"]["passwordinputverify"].value;
	
	if (username == null || nameofperson = null || pass1 = null || pass2 || null){
		var errorMessage = "You Have Blank Fields, Please Re-Check Form";
		alert(errorMessage);
		return false;
	}
	else if (pass1 != pass2){
		var errorMessage = "Your passwords Do Not Match";
		alert(errorMessage);
		return false;
	}
	else{
		return true;
	}
}

