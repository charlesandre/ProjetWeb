<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

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


		