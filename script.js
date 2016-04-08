
var images = new Array();

images.push("paysage1.png");
images.push("gens.png");
images.push("paysage3.png");
images.push("selfie.png");
images.push("paysage2.png");



var pointeur = 0;

function ChangerImage(){
	document.getElementById("diapoAccueil").src = images[pointeur];
	 
	if(pointeur < images.length - 1){
		pointeur++;
	}

	else{
		pointeur = 0;
	}
	 
	window.setTimeout("ChangerImage()", 5000)
}



	// Charge la fonction
window.onload = function(){
	ChangerImage();
}

function new_div()
{
	// crée un nouveau nœud d'élément <span> vide
// sans aucun ID, attribut ou contenu
var sp1 = document.createElement("span");

// lui donne un attribut id appelé 'nouveauSpan'
sp1.setAttribute("id", "nouveauSpan");

// crée un peu de contenu pour cet élément.
var sp1_content = document.createTextNode("Ceci est un nouvel élément span. ");

// ajoute ce contenu au nouvel élément
sp1.appendChild(sp1_content);

// Obtient une référence de l'élément devant lequel on veut insérer notre nouveau span
var sp2 = document.getElementById("elementEnfant");

// Obtient une référence du nœud parent
var parentDiv = sp2.parentNode;

// insère le nouvel élément dans le DOM avant sp2
parentDiv.insertBefore(sp1, sp2);
}
		

		function ajoutPhoto()
{
	width = 300;
height = 200;
if(window.innerWidth)
{
   	var left = (window.innerWidth-width)/2;
  	var top = (window.innerHeight-height)/2;
}
else
{
  	var left = (document.body.clientWidth-width)/2;
  	var top = (document.body.clientHeight-height)/2;
}
popup = window.open('Ajouter une photo', 'popup', 'height=400, width=300');
popup.document.write('<h1>Ceci est un test</h1>');
popup.document.write('</form>');

}

