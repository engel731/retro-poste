/* Galerie ===========================
======================================
======================================*/

function Galerie(picture, container, album) {
	this.dataSeries = [];
	this.setContainer(container);
	this.setAlbum(album);

	for (var i = 0; i < picture.length; i++) {
		var webComponents = new WebComponents();

		if(picture[i].resum) {
			webComponents = new Resum({
				resum: picture[i].resum
			});
		}

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

	this.load();
}

Galerie.prototype.load = function() {
	var galerie = new Widgets({
		elm: this.container,
		dataSeries: this.dataSeries,
		modsSeries: [new ModLightbox({album: this.album}), new ModGalerie()]
	});

	window.addEventListener('load', function() { galerie.modsSeries[1].resizeToFit() });
	window.addEventListener('resize', function() { galerie.modsSeries[1].resizeToFit() });
}

Galerie.prototype.setContainer = function(container) { this.container = container; }
Galerie.prototype.setAlbum = function(album) { this.album = album; }