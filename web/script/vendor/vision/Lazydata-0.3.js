/*© Copyright Tanguy Bazire*/

/* LazyData ======================
==================================
==================================*/

function LazyData(data) {
	this.webComponents = new WebComponents(data);
	
	Hydrator.call(this, data);

	this.webComponents.setLazydata(this);
}

LazyData.prototype.isVisible = function(callback) {
	var thumbContenair = this.elm.parentNode.parentNode.parentNode.parentNode;

	window.addEventListener('load', Throttling.call(this, 'lookAtContainer'));
	window.addEventListener('scroll', Throttling.call(this, 'lookAtContainer'));

	this.elm.addEventListener('isVisible', callback);
}

LazyData.prototype.lookAtContainer = function(fx, event) {
	var thumbContenair = this.elm.parentNode.parentNode.parentNode.parentNode;

	if(this.elm.getBoundingClientRect().top <= window.innerHeight
	&& this.elm.getBoundingClientRect().bottom >= 0) {
		DispatchEvent.call(this, 'isVisible');

		window.removeEventListener('load', fx);
		window.removeEventListener('scroll', fx);
	}
}

LazyData.prototype.load = function(container) {
	container.appendChild(this.webComponents.write());
	this.webComponents.callback();
};

LazyData.prototype.setElm = function(elm) { this.elm = elm; };
LazyData.prototype.setWebComponents = function(webComponents) { this.webComponents = webComponents; };

/* LazyThumb ========================
=====================================
=====================================*/

function LazyThumb(data) {
	data.elm = new Image(); 

	LazyData.call(this, data);
}

LazyThumb.prototype = Object.create(LazyData.prototype, {
    constructor: {
        value: LazyData,
        enumerable: false,
        writable: true,
        configurable: true
    }
});

LazyThumb.prototype.load = function(contenair) {
	var lazyThumb = this;

	this.elm.addEventListener('load', function() {
		lazyThumb.elm.setAttribute('alt', lazyThumb.alt);

		contenair.appendChild(lazyThumb.webComponents.write());
		lazyThumb.webComponents.callback();
	});

	this.elm.src = this.src;
};

LazyThumb.prototype.setSrc = function(src) { this.src = src; };
LazyThumb.prototype.setAlt = function(alt) { this.alt = alt; };