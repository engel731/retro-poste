(function() {
    
	var searchElement = document.getElementsByClassName('search__input')[0],
		results = document.getElementById('suggestion'),
        
        selectedResult = -1, // Permet de savoir quel résultat est sélectionné : -1 signifie "aucune sélection"
	    previousRequest, // On stocke notre précédente requête dans cette variable
    	previousValue = searchElement.value; // On fait de même avec la précédente valeur
	
	
	function getResults(keywords) { // Effectue une requête et récupère les résultats

		var xhr = new XMLHttpRequest();
		xhr.open('GET', 'services/picture/suggestion='+ encodeURIComponent(keywords));
	
		xhr.addEventListener('readystatechange', function() {
			if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
	
				var response = JSON.parse(xhr.responseText);
				
				displayResults(response);
	
			}
		});
	
		xhr.send(null);
	
		return xhr;
	}
	
	function displayResults(response) { // Affiche les résultats d'une requête
		results.style.display = response != '' ? 'block' : 'none'; // On cache le conteneur si on n'a pas de résultats
	
		if (response != '') { // On ne modifie les résultats que si on en a obtenu
			
			results.innerHTML = ''; // On vide les résultats
	
			for (var key in response) {
				var suggestionGroupe = document.getElementsByClassName('suggestion-groupe--'+key)[0];
				
				if(!suggestionGroupe) {
					var suggestionGroupe = document.createElement('div');
					suggestionGroupe.classList.add('suggestion-groupe');
					suggestionGroupe.classList.add('suggestion-groupe--'+key);

					if(key != 'Picture') {
						var suggestionGroupeHeader = document.createElement('div');
						suggestionGroupeHeader.classList.add('suggestion-groupe__header');
						suggestionGroupeHeader.appendChild(document.createTextNode(key));
						suggestionGroupe.appendChild(suggestionGroupeHeader);
					}
					
					var suggestionList = document.createElement('ul');
					suggestionList.classList.add('suggestion-list');
					suggestionList.classList.add('menu');
					suggestionGroupe.appendChild(suggestionList);
				}

				var suggestionList = suggestionGroupe.getElementsByClassName('suggestion-list')[0]; 
				suggestionGroupe.appendChild(suggestionList);
				
				for(var i = 0; i < response[key].length; i++) {
					var suggestion = document.createElement('li');
					suggestion.appendChild(document.createTextNode(response[key][i]));
					suggestionList.appendChild(suggestion);
					
					suggestion.addEventListener('click', function(e) {
						chooseResult(e.target);
					});
				}
				
				results.appendChild(suggestionGroupe);
			}
	    }
	
	}
	
	function chooseResult(result) { // Choisi un des résultats d'une requête et gère tout ce qui y est attaché
	
	    searchElement.value = previousValue = result.innerHTML; // On change le contenu du champ de recherche et on enregistre en tant que précédente valeur
	    results.style.display = 'none'; // On cache les résultats
	    result.className = ''; // On supprime l'effet de focus
	    selectedResult = -1; // On remet la sélection à "zéro"
	    searchElement.focus(); // Si le résultat a été choisi par le biais d'un clique alors le focus est perdu, donc on le réattribue
	
	}
	
	
	searchElement.addEventListener('keyup', function(e) {
		var divs = results.getElementsByTagName('li');
	
	    if (e.keyCode == 38 && selectedResult > -1) { // Si la touche pressée est la flèche "haut"
	        divs[selectedResult--].classList.remove('result_focus');
	
	        if (selectedResult > -1) { // Cette condition évite une modification de childNodes[-1], qui n'existe pas, bien entendu
				divs[selectedResult].classList.add('result_focus');
	        }
	
	    }
	
	    else if (e.keyCode == 40 && selectedResult < divs.length - 1) { // Si la touche pressée est la flèche "bas"
	
		
			results.style.display = 'block'; // On affiche les résultats
			
			if (selectedResult > -1) { // Cette condition évite une modification de childNodes[-1], qui n'existe pas, bien entendu
            	divs[selectedResult].classList.remove('result_focus');
	        }
			
			divs[++selectedResult].classList.add('result_focus');
	    }
	
	    else if (e.keyCode == 13 && selectedResult > -1) { // Si la touche pressée est "Entrée"
	
	        chooseResult(divs[selectedResult]);
	
	    }
	
    	else if (searchElement.value != previousValue) { // Si le contenu du champ de recherche a changé
	
	        previousValue = searchElement.value;
	
	        if (previousRequest && previousRequest.readyState < XMLHttpRequest.DONE) {
	            previousRequest.abort(); // Si on a toujours une requête en cours, on l'arrête
        	}
	
	        previousRequest = getResults(previousValue); // On stocke la nouvelle requête
	
	        selectedResult = -1; // On remet la sélection à "zéro" à chaque caractère écrit
	
    	}
	
	});
	
})();