//this js will be included near the head to provide constructors and display functions

function openModalForm(){
	var modalLoc = document.getElementsByClassName('modal_background');
	modalLoc[0].style.display = 'block';
	//assign event listener to modal close button
	var modalCloseLoc = document.getElementById('modal_close_btn');
	modalCloseLoc.addEventListener('click', closeModalForm, false);
	modalCloseLoc.addEventListener('mouseover', 
	function(){modalCloseLoc.setAttribute('class', 'modal_box_close_hi');}, false);
	modalCloseLoc.addEventListener('mouseout', 
	function(){modalCloseLoc.setAttribute('class', 'modal_box_close');}, false);
	}

function closeModalForm(){
	var modalLoc = document.getElementsByClassName('modal_background');
	modalLoc[0].style.display = 'none';
}

//activates add car button
var buttonLoc = document.getElementById('start_car_add');
buttonLoc.addEventListener('mouseover', function(){buttonLoc.setAttribute('class', 'rolloverbtn');}, false);
buttonLoc.addEventListener('mouseout', function(){buttonLoc.setAttribute('class', 'normalbtn');}, false);
buttonLoc.addEventListener('click', openModalForm, false);


//THe following are to add highlighting to the edit and delete buttons
function hiRed(e){
	var cellLoc = e.currentTarget.parentNode;
	cellLoc.style.backgroundColor = '#8B0000';
}

function hiYellow(e){
	var cellLoc = e.currentTarget.parentNode;
	cellLoc.style.backgroundColor = '#FFFF66';
}

function retHi(e){
	var cellLoc = e.currentTarget.parentNode;
	cellLoc.style.backgroundColor = '';
}

//The following are to activate edit screen when edit link is picked
//this js will be included near the head to provide constructors and display functions

function closeEditForm(){
	var modalLoc = document.getElementsByClassName('modal_background_edit');
	modalLoc[0].style.display = 'none';
}

//The following functions are to open the edit form and insert the values for the current entry
function fillValues(carV) {
	document.getElementById('f-entryID').value 	= carV.entry_id;
	document.getElementById('f-rank').value 	= carV.ranking;
	document.getElementById('f-year').value 	= carV.year;
	document.getElementById('f-make').value 	= carV.make;
	document.getElementById('f-model').value 	= carV.model;
	document.getElementById('f-power').value 	= carV.horsepower;
	document.getElementById('f-mileage').value 	= carV.mileage;
	document.getElementById('f-price').value 	= carV.price;
	document.getElementById('f-desc').value 	= carV.description;
	document.getElementById('f-prevfile').value = carV.imgsource;

	//Adjust selected items for drop down menus
	var cylSel = document.getElementById('f-cylinders');
	for (var i = 0; i < cylSel.options.length; i++){
		if (cylSel.options[i].value == carV.cylinders){
			cylSel.selectedIndex = i;
		}
	}
	var aspSel = document.getElementById('f-asp');
	for (i = 0; i < aspSel.options.length; i++){
		if (aspSel.options[i].value == carV.aspiration){
			aspSel.selectedIndex = i;
		}
	}
	var dtSel = document.getElementById('f-dt');
	for (i = 0; i < dtSel.options.length; i++){
		if (dtSel.options[i].value == carV.drivetrain){
			dtSel.selectedIndex = i;
		}
	}

	//Show photo dialog if existing photo is uploaded
	if (carV.imgsource.trim() != '') {
		var photoText = "You already have a photo uploaded for this car... to use another one, select it below";
		document.getElementById('photo_prompt').innerHTML = photoText;
	}
	

}


function openEditForm(e) {
	var linkLoc = e.currentTarget;
	var dbID = linkLoc.id.substr(6,linkLoc.id.length - 1);
	
	//First open the modal window
	var modalLoc = document.getElementsByClassName('modal_background_edit');
	modalLoc[0].style.display = 'block';
	//assign event listener to modal close button
	var modalCloseLoc = document.getElementById('edit_close_btn');
	modalCloseLoc.addEventListener('click', closeEditForm, false);
	modalCloseLoc.addEventListener('mouseover', 
	function(){modalCloseLoc.setAttribute('class', 'modal_box_close_hi');}, false);
	modalCloseLoc.addEventListener('mouseout', 
	function(){modalCloseLoc.setAttribute('class', 'modal_box_close');}, false);

	//Now, call the server to fill in existing values
	var xhr = new XMLHttpRequest();
	xhr.onload = function() {
		if (xhr.status === 200) {
			//parse return text to JSON object
			//call fillValues function and send JSON object
			var carValues = JSON.parse(xhr.responseText);
			fillValues(carValues);
		}
		else {
			alert("Problem Querying the Server for Car Data");
		}
	}
	var ajaxFileLoc = 'car_ajax.php';
	var getRequest = ajaxFileLoc + "?db_id=" + dbID; 
	xhr.open('GET', getRequest, true);
	xhr.send(null);
}

var editLoc = document.getElementsByClassName('editlink');
for (var i = 0; i < editLoc.length; i++) {
	editLoc[i].addEventListener('click', openEditForm, false);
	editLoc[i].addEventListener('mouseover', hiYellow, false);
	editLoc[i].addEventListener('mouseout', retHi, false);
}

//The following functions are for the delete entry
function processDelete(e) {
	if (confirm('Are you sure you want to delete this entry?')) {
    	var linkLoc = e.currentTarget;
		var dbID = linkLoc.id.substr(6,linkLoc.id.length - 1);
		document.getElementById("setParam").value = dbID;
		//submit form
		document.getElementById("delcar").submit();
	} else {
		return;
	}
}

var editLoc = document.getElementsByClassName('deletelink');
for (var i = 0; i < editLoc.length; i++) {
	editLoc[i].addEventListener('click', processDelete, false);
	editLoc[i].addEventListener('mouseover', hiRed, false);
	editLoc[i].addEventListener('mouseout', retHi, false);
}