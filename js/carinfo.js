/*These are basic descriptions.  Ideally I'd want these pulled from a separate data file but can't implement now */
var buickdesc = "The 4-cyl Turbo Verano produces 250 hp without carrying a lot of weight.  Surprisingly fast!";
var acuradesc = "The 4-cyl Acura is a slower, but luxurious ride from acura that is compact but sprite";
var subarudesc = "With legendary Subaru rally AWD roots, the Legacy is a nimble handler and relatively powerful.  Cabin not as luxurious.";
var mkzhybriddesc = "A quiet and luxurious hybrid that is peppier than the CT200h.  Large cabin and such are luxurious!";
var chevyvoltdesc = "This marvel of engineering is not the fastest, however you cannot beat the EV performance";
var audis4desc = "This 350hp monster in a compact sedan is like a sherpa of the car world.  Small but very powerful!";
var fiestadesc = "This 3-cyl Turbo is a darling in the automotive world.  It produces ridiculous torque for it's volume and with its light weight never feels underpowered";


function usedCar(rank, year, make, model, engine, hp, drvtrn, prce, imgfile, desc){
	this.rank = rank;
	this.year = year;
	this.make = make;
	this.model = model;
	this.engine = engine;
	this.horsepower = hp;
	this.drivetrain = drvtrn;
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
	var sidebarHTML = "<h5>Rank</h5><h5>" + carList[carIndex].rank + "</h5><h5>Price</h5><h5>" + carList[carIndex].price + "</h5>";
	var asideLoc = document.getElementById('priceaside');
	asideLoc.innerHTML = sidebarHTML;
	//assign photo file
	var picPath = "images/" + carList[carIndex].imgfile;
	var picLoc = document.getElementById('carpic');
	picLoc.setAttribute('src', picPath);
	picLoc.setAttribute('alt', carTitle);
	//change description
	var descLoc = document.getElementById('cardescription');
	descLoc.firstChild.nextSibling.nodeValue = carList[carIndex].desc;
}




var buick = new usedCar(1, "2013", "Buick", "Verano", "4-cyl Normal", "170", "FWD", "$14000", "buickverano.jpg", buickdesc);
var acura = new usedCar(2, "2013", "Acura", "ILX", "4-cyl Normal", "140", "FWD", "$15000", "acurailx.jpg", acuradesc);
var subaru = new usedCar(3, "2014", "Subaru", "Legacy", "4-cyl Normal", "140", "AWD", "$13000", "subarulegacy.jpg", subarudesc);
var lincoln = new usedCar(4, "2013", "Lincoln", "MKZ Hybrid", "4-cyl Hybrid", "188", "FWD", "$18000", "mkzhybrid.jpg", mkzhybriddesc);
var chevy = new usedCar(5, "2013", "Chevy", "Volt", "4-cyl Plugin Hybrid", "188", "FWD", "$17000", "chevyvolt.jpg", chevyvoltdesc);
var audi = new usedCar(6, "2010", "Audi", "S4", "6-cyl Supercharged", "350", "AWD", "$27000", "audis4.jpg", audis4desc);
var ford = new usedCar(7, "2013", "Ford", "Fiesta SFE", "3-cyl Turbo", "123", "FWD", "$13000", "fiestasfe.jpg", fiestadesc);

var carList = [buick, acura, subaru, lincoln, chevy, audi, ford];


//For reference:
//Class Names are c_rank, c_year, c_make, c_model, c_engine, c_horsepower, c_drivetrain, c_price

//target placeHolders declaration
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
		case "c_price":
			rowNode[j].textContent = carList[i].price;
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
		case "c_price":
			newNode = document.createElement('td');
			newText = document.createTextNode(carList[i].price);
			newNode.appendChild(newText);
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




