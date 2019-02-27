/* Widgets ===========================
======================================
====================================*/

function Widgets(data) { 
	Hydrator.call(this, data); 

	this.lazyload = new LazyLoad(new LazyData({elm: this.elm}), this.dataSeries);
	this.initMods();

	var self = this;
	for (var i = 0; i < this.dataSeries.length; i++)  {
		(function(data, position) {
			data.elm.addEventListener('load', function() {
				self.loadMods(data, position);
			});
		})(this.dataSeries[i], i);
	}
}

Widgets.prototype.initMods = function() {
	for (var i = 0; i < this.modsSeries.length; i++) {
		this.modsSeries[i].init(this);
	}
}

Widgets.prototype.loadMods = function(data, position) {
	for (var i = 0; i < this.modsSeries.length; i++) {
		this.modsSeries[i].load(data, position);
	}
}

Widgets.prototype.setModsSeries = function(modsSeries) { this.modsSeries = modsSeries; };
Widgets.prototype.setDataSeries = function(dataSeries) { this.dataSeries = dataSeries; };
Widgets.prototype.setElm = function(elm) { this.elm = elm; };

/* Mod ==============================
=====================================
===================================*/

function Mod(data) { Hydrator.call(this, data); }

Mod.prototype.init = function(widgets) { this.widgets = widgets };

Mod.prototype.load = function() {  };

/* ModLightbox ======================
=====================================
===================================*/

function ModLightbox(data) { Mod.call(this, data); }

ModLightbox.prototype = Object.create(Mod.prototype, {
    constructor: {
        value: Mod,
        enumerable: false,
        writable: true,
        configurable: true
    }
});

ModLightbox.prototype.init = function(widgets) {
	this.dataSeries = widgets.dataSeries;
};

ModLightbox.prototype.load = function(data, position) {
	var self = this;

	data.webComponents.callback = function() {
		var wrap = data.webComponents.wrap;
		wrap.getAttribute(self.album);

		self.action(self.dataSeries, data, position);
	};
};

ModLightbox.prototype.action = function(dataSeries, data, position) {
	var positionNext = position + 1,
		positionBack = position - 1,

		wrap = data.webComponents.wrap,
		btnNext = wrap.getElementsByClassName('lightbox__btn-next')[0],
		btnBack = wrap.getElementsByClassName('lightbox__btn-back')[0];

	if(dataSeries[positionNext]) {
		btnNext.addEventListener('click', function() {
			var nextThumb = dataSeries[positionNext].webComponents;

			data.webComponents.close(wrap);
			nextThumb.open(nextThumb.wrap);
		});
	} else { btnNext.style.display = 'none'; }

	if(dataSeries[positionBack]) {
		btnBack.addEventListener('click', function() {
			var backThumb = dataSeries[positionBack].webComponents

			data.webComponents.close(wrap);
			backThumb.open(backThumb.wrap);
		});
	} else { btnBack.style.display = 'none'; }
};

ModLightbox.prototype.setAlbum = function(album) { this.album = album; };

/* ModGalerie ========================
======================================
=====================================*/

function ModGalerie(data) { Mod.call(this, data) }

ModGalerie.prototype = Object.create(Mod.prototype, {
    constructor: {
        value: Mod,
        enumerable: false,
        writable: true,
        configurable: true
    }
});

ModGalerie.prototype.init = function(widgets) { 
	this.container = widgets.elm;
	this.containerWidth = this.container.getBoundingClientRect().width;
	this.dataLoad = widgets.lazyload.dataLoad;
	this.row = new Row();
};

ModGalerie.prototype.load = function(data, position) {
	var thumb = new Thumb(data.elm),
		currentRow = this.row;

	currentRow.addThumb(thumb);

	if(currentRow.size.width >= this.containerWidth) {
		currentRow.justify(this.containerWidth-16);
		currentRow.reinit();
	} else {
		currentRow.justifyHeight();
	}
};

ModGalerie.prototype.resizeToFit = function() {
	var contenairWidth = this.container.getBoundingClientRect().width,
        dataLoad = this.dataLoad,
        currentRow = new Row();

	for (var i = 0; i < dataLoad.length; i++)  {
		var thumb = new Thumb(dataLoad[i].elm);
		currentRow.addThumb(thumb);

		if(currentRow.size.width >= contenairWidth) {
			currentRow.justify(contenairWidth);
			currentRow.reinit();
		} else {
			currentRow.justifyHeight();
		}
	}
};

/* Thumb */

function Thumb(elm, margin) {
	this.setElm(elm);
	this.setMargin(margin);

	this.currentSize = { width: 0, height: 0 };
}

Thumb.prototype.resize = function(width, height) {
	this.elm.style.width = width + 'px';
	this.elm.style.height = height + 'px';

	this.currentSize.width = width;
	this.currentSize.height = height;
};

Thumb.prototype.getSize = function() {
	return {
		width: this.elm.naturalWidth,
		height: this.elm.naturalHeight
	};
};

Thumb.prototype.setMargin = function(margin) { this.margin = (margin ? margin : 0); };
Thumb.prototype.setElm = function(elm) { this.elm = elm; };

/* Row */

function Row() { this.reinit(); } 

Row.prototype.reinit = function() {
	Row.SUB = 0; Row.ADD = 1;

	this.size = { width: 0, height: Number.POSITIVE_INFINITY };
	this.thumbs = [];
};

Row.prototype.justifyHeight = function() {
	this.size.width = 0;

	for (var i = 0; i < this.thumbs.length; i++) {
		var thumb = this.thumbs[i],
			thumbSize = thumb.getSize(),
			subHeight = thumbSize.height - this.size.height;

		var height = thumbSize.height - subHeight,
			adjustedWidth = height * thumbSize.width / thumbSize.height;
			/*adjusted width = <user-chosen height> * original width / original height*/

		this.size.width += adjustedWidth;
		this.thumbs[i].resize(adjustedWidth, height);
	}
}

Row.prototype.justify = function(conteneurWidth) {
	this.justifyHeight();

    conteneurWidth -= (this.thumbs[0].margin * 2) * this.thumbs.length;

	if((this.size.width - conteneurWidth) < 0) {
		var modifWidth = conteneurWidth - this.size.width,
			operation = Row.ADD
    } else {
		var modifWidth = this.size.width - conteneurWidth,
			operation = Row.SUB;
    }

	for (var i = 0; i < this.thumbs.length; i++) {
		var thumb = this.thumbs[i],
			width = thumb.currentSize.width;

		/*result = <modif-width> * width / row-width*/
		var result = modifWidth * (width / this.size.width);
		width = (operation == Row.ADD) ? width + result : width - result;
		
		var adjustedHeight = width * thumb.currentSize.height / thumb.currentSize.width;
		/*adjusted height = <user-chosen width> * original height / original width*/

        this.thumbs[i].resize(width, adjustedHeight);
	}
};

Row.prototype.addThumb = function(thumb) {
	var thumbSize = thumb.getSize();
    this.thumbs.push(thumb);

    this.size.width += thumbSize.width;

    if(thumbSize.height < this.size.height) {
		this.size.height = thumbSize.height;
    }
};