//Denne siden er utviklet av Ole, siste gang endret 09.03.2018
function visLastOppForm(){
	var container = document.getElementById('lastOppContainer');
	container.style.display = "block";
	container.focus();
}
function skjulLastOppForm(){
	document.getElementById('lastOppContainer').style.display = "none";
}
function hentFil(event) {
	var bildet = document.getElementById('visning');
	bildet.src = URL.createObjectURL(event.target.files[0]);
}
function endreBeskrivelsen(){
	var beskrivelsen = document.getElementById('brukerBeskrivelse');
	beskrivelsen.readOnly = false;
	beskrivelsen.style.backgroundColor = "white";
	beskrivelsen.style.color = "black";
	beskrivelsen.focus();
	document.getElementById('lagreBeskrivelse').style.display = "block";
	document.getElementById('beskrivelseKnapp').style.display = "none";
	document.getElementById('avbrytBeskrivelse').style.display = "block";
}
function avbrytBeskrivelsen() {
	var beskrivelsen = document.getElementById('brukerBeskrivelse');
	beskrivelsen.readOnly = true;
	beskrivelsen.style.backgroundColor = "#4c4c4c";
	beskrivelsen.style.color = "white";
	document.getElementById('lagreBeskrivelse').style.display = "none";
	document.getElementById('beskrivelseKnapp').style.display = "block";
	document.getElementById('avbrytBeskrivelse').style.display = "none";
}

function visInteresseForm(){
	document.getElementById('interesseForm').style.display = "block";
	document.getElementById('flereInteresser').style.display = "none";
	document.getElementById('manglerInteresser').style.display = "block";
	document.getElementById('bryter').focus();
}

function avbrytInteresseForm(){
	document.getElementById('interesseForm').style.display = "none";
	document.getElementById('flereInteresser').style.display = "block";
	document.getElementById('manglerInteresser').style.display = "none";
	manglerInteresser
}

function leggTilListen(){	
	var menyen = document.getElementById("velgInteresser");
    var valg = document.createElement("option");
	valg.value = document.getElementById('nyInteresse').value;
    valg.text = document.getElementById('nyInteresse').value;
    menyen.add(valg);
}

function visStudiumForm(){
	document.getElementById('studiumForm').style.display = "block";
	document.getElementById('flereStudium').style.display = "none";
	document.getElementById('studiumTekst').focus();
}

function avbrytStudiumForm(){
	document.getElementById('studiumForm').style.display = "none";
	document.getElementById('flereStudium').style.display = "block";
}

function infoEndringer(){
	var inputFelt = document.getElementsByClassName("brukerInput");
	var data = document.getElementsByClassName("hentetBrukerInfo");
	var i;
	for (i = 0; i < inputFelt.length; i++) {
		inputFelt[i].value = data[i].textContent;
		inputFelt[i].style.display = "block";
		data[i].style.display = "none";
	}
	var bursdag = document.getElementById("uformatertDato").textContent;
	if(bursdag != null){
		document.getElementById("fodselsdato").value = bursdag;
	}
	document.getElementById("knappBrukerInfo").style.display = "none";
	document.getElementById("lagreInfo").style.display = "block";
	document.getElementById("avbrytBrukerInfo").style.display = "block";
}

function avbrytInfoEndringer(){
	var inputFelt = document.getElementsByClassName("brukerInput");
	var i;
	var data = document.getElementsByClassName("hentetBrukerInfo");
	for (i = 0; i < inputFelt.length; i++) {
		inputFelt[i].style.display = "none";
		data[i].style.display = "block";
	}

	document.getElementById("knappBrukerInfo").style.display = "block";
	document.getElementById("avbrytBrukerInfo").style.display = "none";
	document.getElementById("lagreInfo").style.display = "none";
}
