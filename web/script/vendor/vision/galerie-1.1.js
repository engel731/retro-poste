/* Galerie ===========================
======================================
======================================*/

function Galerie(picture, container, album) {
	this.dataSeries = [];
	this.setContainer(container);
	this.setAlbum(album);
	
	// On parcours les donnée des images envoyer par le server
	for (var i = 0; i < picture.length; i++) {
		// Le WebComponents par defaut
		var webComponents = new WebComponents();

		// Si on a un resumé, on créer un WebComponents Resum
		if(picture[i].resum) {
			webComponents = new Resum({
				resum: picture[i].resum
			});
		}

		// On créer le WebComponents LazyThumb
		this.dataSeries.push(new LazyThumb({
			src: picture[i].minUrl,
			alt: picture[i].alt,

			WebComponents: new Lightbox({
				vhd: new LazyThumb({
					src: picture[i].url, 
					alt: picture[i].alt,

					WebComponents: webComponents
				})
			})
		}));
	}
}

Galerie.prototype.load = function() {
	var galerie = new Widgets({
		elm: this.container,
		dataSeries: this.dataSeries,
		modsSeries: [new ModLightbox({album: this.album}), new ModGalerie()]
	});

	window.addEventListener('load', function() { galerie.modsSeries[1].resizeToFit(); });
	window.addEventListener('resize', function() { galerie.modsSeries[1].resizeToFit(); });
}

Galerie.prototype.setContainer = function(container) { this.container = container; }
Galerie.prototype.setAlbum = function(album) { this.album = album; }