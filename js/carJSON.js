//this js will be included near the head to provide constructors and display functions

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
	var picPath = carList[carIndex].imgfile;
	var picLoc = document.getElementById('carpic');
	picLoc.setAttribute('src', picPath);
	picLoc.setAttribute('alt', carTitle);
	//change description
	var descLoc = document.getElementById('cardescription');
	descLoc.firstChild.nextSibling.nodeValue = carList[carIndex].desc;
	window.scrollBy(0,300);
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
}



