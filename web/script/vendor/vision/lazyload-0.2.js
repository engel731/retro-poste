/* LazyLoad ==========================
======================================
======================================*/

function LazyLoad(container, Lazydata) {
	this.data = [];
	this.dataLoad = [];

	this.setContenair(container);
	this.setLazyData(Lazydata);

	var self = this;

	this.start = function() {
		// On verifie qu'il reste des données a chargé

		if (self.data.length !== 0) {
			var i = 0;

			/*On utilise setInterval sur 20 ms pour l'iteration.
			Si moin de 50 données on été chargé et qu'il reste des données a chargé on continu*/
			var poll = setInterval(function() {
				if (i <= 50 && self.data.length !== 0) {
					/*On ajoute la "donnée chargé" au tableau correspondant 
					puis on la suprimme du tabeau des "donnée a "chargé"*/
					self.dataLoad.push(self.data[0]);
					self.data[0].load(self.contenair.elm);
					self.data.splice(0, 1);

					i++;
				} else {
					/*Sinon, on verifie que la derniere donnée chargé soit visible
					pour recommencer*/
					self.lastLoad().isVisible(self.start);
					clearInterval(poll);
				}
			}, 20);
		}
	};

	// On verifie que le contenair soir visible pour commencer
	this.contenair.isVisible(function() {
		if(self.isStart()) self.start();
	});
}

LazyLoad.prototype.lastLoad = function() {
	return this.dataLoad[this.dataLoad.length - 1];
}

LazyLoad.prototype.isStart = function() {
	return this.dataLoad.length === 0;
}

LazyLoad.prototype.setContenair = function(contenair) { 
	this.contenair = contenair;
}

LazyLoad.prototype.setLazyData = function(lazydata) {
	if(lazydata) {
		for (var i = 0; i < lazydata.length; i++) {
			this.data.push(lazydata[i]);
		}
	} else { 
		console.error('Vous devez placer des donnée à charger !'); 
	}
};