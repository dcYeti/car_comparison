

function usedCar(db_id, rank, year, make, model, engine, hp, drvtrn, milge, prce, imgfile, desc){
	this.dbID = db_id;
	this.rank = rank;
	this.year = year;
	this.make = make;
	this.model = model;
	this.engine = engine;
	this.horsepower = hp;
	this.drivetrain = drvtrn;
	this.mileage = milge;
	this.price = prce;
	this.imgfile = imgfile;
	this.desc = desc;
};

//This function will display the car's info on the display area
function displayProfile(e, carList) {
	var targetNode = e.target;
	var targetRow = targetNode.parentNode;
	var rowID = targetRow.getAttribute('id');
	rowID = rowID.trim();
	//gets index number of car based on rowID
	var carIndex = "";

	if (rowID.length > 5){
		carIndex = rowID.charAt(3);
		carIndex = carIndex + rowID.charAt(4);
		carIndex = carIndex + rowID.charAt(5);
	}
	else if (rowID.length > 4) {
		carIndex = rowID.charAt(3)
		carIndex = carIndex + rowID.charAt(4);
	}
	else {
		carIndex = rowID.charAt(3);
	}
	
	//create description string
	var carTitle = carList[carIndex].year + " " + carList[carIndex].make + " " + carList[carIndex].model;
	var titleLoc = document.getElementById('cartitle');
	titleLoc.textContent = carTitle;
	//create spec string
	var specBanner = carList[carIndex].horsepower + "hp " + carList[carIndex].engine + " " + carList[carIndex].drivetrain;
	var bannerLoc = document.getElementById('specbanner');
	bannerLoc.textContent = specBanner;
	//create rank and price sidebar
	var sidebarHTML = "<h5>Rank</h5><h5>" + carList[carIndex].rank + "</h5><h5>Mileage</h5><h5>" + carList[carIndex].mileage + "</h5>" +
						"</h5><h5>Price</h5><h5>" + carList[carIndex].price + "</h5>";
	var asideLoc = document.getElementById('priceaside');
	asideLoc.innerHTML = sidebarHTML;
	//assign photo file
	var picPath = carList[carIndex].imgfile;
	var picLoc = document.getElementById('carpic');
	picLoc.setAttribute('src', picPath);
	picLoc.setAttribute('alt', carTitle);
	//change description
	var descLoc = document.getElementById('cardescription');
	descLoc.firstChild.nextSibling.nodeValue = carList[carIndex].desc;
	window.scrollBy(0,300);
}

//For reference:
//Class Names are c_rank, c_year, c_make, c_model, c_engine, c_horsepower, c_drivetrain, c_price
function validatecaradd(form_name){
		var errorExists;
		var errorMessage;
		var carRank, carYear, carPrice, carHp;
		var carMake, carModel, carPic;
		carRank = document.forms[form_name]["ranking"].value;
		carYear = document.forms[form_name]["year"].value;
		carMake = document.forms[form_name]["make"].value;
		carHp = document.forms[form_name]["horsepower"].value;
		carModel = document.forms[form_name]["model"].value;
		carPrice = document.forms[form_name]["price"].value;
		carPic = document.forms[form_name]["car_pic_src"].value;
		//make integers of input data
		carRank = parseInt(carRank); 
		carPrice = parseInt(carPrice);
		carYear = parseInt(carYear); 
		carHp = parseInt(carHp); 
		//first check is for blank fields, then for correct data types, then for correct picture extension
	   if ((carRank == null || carYear == null || carMake == null || carModel == null || carPrice == null) ||
	   (carRank == "" || carYear == "" || carMake == "" || carModel == "" || carPrice == "")) {
			errorExists = true;
			errorMessage = "You Have Blank Fields - Please re-check your entry.";
	   }
		else if (isNaN(carRank) || isNaN(carYear) || isNaN(carHp) || isNaN(carPrice)) {
			errorExists = true;
			errorMessage = "You have invalid data types in one or more fields.  Please make sure the car's rank, year, HP, and price are all in numbers";
		}
		//Handle returns based on error value
		else if(!(carPic.substring(carPic.length - 3, carPic.length) == "png" || 
				carPic.substring(carPic.length - 3, carPic.length) == "jpg") && carPic != ""){
			errorExists = true;
			errorMessage = "Your picture must be in either .jpg or .png.  Thank you.";
		}
		else
			errorExists = false;
		
		if (errorExists){
			alert(errorMessage);
			return false;
		}
		else{
			return true;
		}
}




function makeTable(carList){
//Make the table with input of carList
var rowNode, mainTable, nodeClass, rowLoc;
for (var i = 0; i < carList.length; i++){
	if (i == 0){
	rowNode = document.getElementsByTagName('td');
	rowLoc = [rowNode[0].parentNode];
	rowLoc[i].addEventListener('click', function(e) {displayProfile(e, carList);}, false);
	//go through row one by one
	for (var j = 0; j < rowNode.length; j++)
	{
		nodeClass = rowNode[j].getAttribute('id');
		switch (nodeClass)
		{
		case "c_rank":
			rowNode[j].textContent = carList[i].rank;
			break;
		case "c_year":
			rowNode[j].textContent = carList[i].year;
			break;
		case "c_make":
			rowNode[j].textContent = carList[i].make;
			break;
		case "c_model":
			rowNode[j].textContent = carList[i].model;
			break;
		case "c_engine":
			rowNode[j].textContent = carList[i].engine;
			break;
		case "c_horsepower":
			rowNode[j].textContent = carList[i].horsepower;
			break;
		case "c_drivetrain":
			rowNode[j].textContent = carList[i].drivetrain;
			break;
		case "c_mileage":
			rowNode[j].textContent = carList[i].mileage;
			break;
		case "c_price":
			rowNode[j].textContent = carList[i].price;
			break;
		case "c_edit":
			rowNode[j].innerHTML = '<i class="fa fa-pencil-square-o editlink" id = "edt-db' + carList[i].dbID + '" aria-hidden="true">Edit</i>';
			break;
		case "c_delete":
			rowNode[j].innerHTML = '<i class="fa fa-times deletelink" id = "del-db' + carList[i].dbID + '" aria-hidden="true">Delete</i>';
			break;
		default:
			rowNode[j].textContent = "error";
			break;
		}
	}
		
	}
	else
	//this will create and add table elements for rows 2 through end of list
	{
	var newNode;
	var newRow;
	var newText;
	newRow = document.createElement('tr');
	newRow.setAttribute('class', 'products');
	newRow.setAttribute('id', 'row' + i);
	mainTable = document.getElementById('carTable');
	rowNode = document.querySelectorAll('td[id]');
	//go through row one by one
	for (var j = 0; j < rowNode.length; j++)
	{
		nodeClass = rowNode[j].getAttribute('id');
		switch (nodeClass)
		{
		case "c_rank":
			newNode = document.createElement('td');
			newText = document.createTextNode(carList[i].rank);
			newNode.appendChild(newText);
			newRow.appendChild(newNode);
			newRow.insertBefore(newNode, newRow.lastChild);
			break;
		case "c_year":
			newNode = document.createElement('td');
			newText = document.createTextNode(carList[i].year);
			newNode.appendChild(newText);
			newRow.appendChild(newNode);
			newRow.insertBefore(newNode, newRow.lastChild);
			break;
		case "c_make":
			newNode = document.createElement('td');
			newText = document.createTextNode(carList[i].make);
			newNode.appendChild(newText);
			newRow.appendChild(newNode);
			newRow.insertBefore(newNode, newRow.lastChild);
			break;
		case "c_model":
			newNode = document.createElement('td');
			newText = document.createTextNode(carList[i].model);
			newNode.appendChild(newText);
			newRow.appendChild(newNode);
			newRow.insertBefore(newNode, newRow.lastChild);
			break;
		case "c_engine":
			newNode = document.createElement('td');
			newText = document.createTextNode(carList[i].engine);
			newNode.appendChild(newText);
			newRow.appendChild(newNode);
			newRow.insertBefore(newNode, newRow.lastChild);
			break;
		case "c_horsepower":
			newNode = document.createElement('td');
			newText = document.createTextNode(carList[i].horsepower);
			newNode.appendChild(newText);
			newRow.appendChild(newNode);
			newRow.insertBefore(newNode, newRow.lastChild);
			break;
		case "c_drivetrain":
			newNode = document.createElement('td');
			newText = document.createTextNode(carList[i].drivetrain);
			newNode.appendChild(newText);
			newRow.appendChild(newNode);
			newRow.insertBefore(newNode, newRow.lastChild);
			break;
		case "c_mileage":
			newNode = document.createElement('td');
			newText = document.createTextNode(carList[i].mileage);
			newNode.appendChild(newText);
			newRow.appendChild(newNode);
			newRow.insertBefore(newNode, newRow.lastChild);
			break;
		case "c_price":
			newNode = document.createElement('td');
			newText = document.createTextNode(carList[i].price);
			newNode.appendChild(newText);
			newRow.appendChild(newNode);
			newRow.insertBefore(newNode, newRow.lastChild);
			break;
		case "c_edit":
			newNode = document.createElement('td');
			var editText = '<i class="fa fa-pencil-square-o editlink" id = "edt-db' + carList[i].dbID + '" aria-hidden="true">Edit</i>';
			newNode.innerHTML = editText;
			newRow.appendChild(newNode);
			newRow.insertBefore(newNode, newRow.lastChild);
			break;
		case "c_delete":
			newNode = document.createElement('td');
			var delText = '<i class="fa fa-times deletelink" id = "del-db' + carList[i].dbID + '" aria-hidden="true">Delete</i>';
			newNode.innerHTML = delText;
			newRow.appendChild(newNode);
			newRow.insertBefore(newNode, newRow.lastChild);
			break;
		}
	}	
	rowLoc.push(newRow);
	rowLoc[i].addEventListener('click', function(e) {displayProfile(e, carList);}, false);
	mainTable.appendChild(newRow);
	mainTable.insertBefore(newRow, mainTable.lastChild);
	}
}
}


//For reference:
//Class Names are c_rank, c_year, c_make, c_model, c_engine, c_horsepower, c_drivetrain, c_price


