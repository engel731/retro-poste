/* WebComponents =================
==================================
=================================*/

function WebComponents(data) { 
	Hydrator.call(this, data);

	this.callback = function() {};
}

WebComponents.prototype.write = function() { return this.lazydata.elm; };

WebComponents.prototype.setLazydata = function(lazydata) { this.lazydata = lazydata; };
                    
/* Resum ===================
============================
===========================*/

function Resum(data) { WebComponents.call(this, data); }

Resum.prototype = Object.create(WebComponents.prototype, {
    constructor: {
        value: WebComponents,
        enumerable: false,
        writable: true,
        configurable: true
    }
});

Resum.prototype.write = function() {
	var conteneur = document.createElement('div');
	conteneur.appendChild(this.lazydata.elm);

	var legende = document.createElement('figcaption');
	addClass(legende, 'lightbox__content');
	conteneur.appendChild(legende)

	var title = document.createElement('h3'),
	titleText = document.createTextNode(this.resum.title);
	title.appendChild(titleText);
	legende.appendChild(title);

	var content = document.createElement('p'),
	contentText = document.createTextNode(this.resum.content);
	content.appendChild(contentText);
	legende.appendChild(content);

	conteneur.appendChild(legende);
	
	return conteneur;
}

Resum.prototype.setResum = function(resum) { this.resum = resum; }

/* Lightbox ===================
===============================
==============================*/

function Lightbox(data) { WebComponents.call(this, data); }

Lightbox.prototype = Object.create(WebComponents.prototype, {
    constructor: {
        value: WebComponents,
        enumerable: false,
        writable: true,
        configurable: true
    }
});

Lightbox.prototype.write = function() { 
	var wrap = document.createElement('figure');
	addClass(wrap, 'lightbox__wrap');
	addClass(wrap, 'lightbox--close');

	var overlay = document.createElement('div');
	overlay.className = 'lightbox__overlay';
	wrap.appendChild(overlay);

	addClass(this.lazydata.elm, 'lightbox__thumb');
	wrap.appendChild(this.lazydata.elm);

	var ghost = document.createElement('div');
	addClass(ghost, 'lightbox__ghost');

	var bar = document.createElement('div');
	addClass(bar, 'lightbox__bar');

	var btnNext = document.createElement('i');
	addClass(btnNext, 'lightbox__bar__btn');
	addClass(btnNext, 'lightbox__btn-next');
	arrowNext = document.createTextNode('>');
	btnNext.appendChild(arrowNext);
	bar.appendChild(btnNext);
	
	var btnBack = document.createElement('i');
	addClass(btnBack, 'lightbox__bar__btn');
	addClass(btnBack, 'lightbox__btn-back');
	arrowBack = document.createTextNode('<');
	btnBack.appendChild(arrowBack);
	bar.appendChild(btnBack);

	ghost.appendChild(bar);
	wrap.appendChild(ghost);
	this.wrap = wrap;

	return this.action(wrap, ghost, overlay, this.lazydata.elm);
};

Lightbox.prototype.scale = function (thumb) {
	var margin = 0,
		viewportHeight = window.innerHeight,
		thumbHeight = thumb.offsetHeight,
		scaleY = (viewportHeight - margin)/thumbHeight;
		/* scale = (viewportHeight - margin)/thumbHeight*/

	var viewportWidth = document.body.clientWidth-8,
		thumbWidth = thumb.offsetWidth,
		scaleX = (viewportWidth - margin)/thumbWidth;
		/* scale = (viewportWidth - margin)/thumbWidth*/

	return (scaleX > scaleY) ? scaleY : scaleX;
}

Lightbox.prototype.calculeX = function(thumb) {
	var thumbWidth = thumb.offsetWidth,
		thumbPositionX = thumb.getBoundingClientRect().right+8,
		width = window.innerWidth; 

	return resizeX = width/2 - thumbPositionX + thumbWidth/2;
	/* Px = (overlayWidth / 2) - (thumbPositionX + thumbWidth / 2*/
}

Lightbox.prototype.calculeY = function(thumb) {
	var thumbHeight = thumb.offsetHeight,
		thumbPositionY = thumb.getBoundingClientRect().top,
		height = window.innerHeight; 

	return  resizeY = height/2 - thumbPositionY - thumbHeight/2
	/* Py = (overlayHeight / 2) - (thumbPositionY + thumbHeight / 2) */
}

Lightbox.prototype.open = function(wrap) {
	var ghost = wrap.getElementsByClassName('lightbox__ghost')[0],
		thumb = wrap.getElementsByClassName('lightbox__thumb')[0];

	if(wrap.hasAttribute('class') && hasClass(wrap, 'lightbox--close')) {
		if(!ghost.getElementsByTagName('img')[0]) {
	 		this.vhd.load(ghost);
	 	}
		
		addClass(wrap, 'lightbox--open');
		removeClass(wrap, 'lightbox--close');
		ghost.style.display = 'block';

		var	multiplier = this.scale(thumb) * 100,
			maxMultiplier = 250;
		
		multiplier = (multiplier > maxMultiplier ? maxMultiplier : multiplier);

		ghost.style.width = multiplier+'%'; 
		ghost.style.height = multiplier+'%';

		ghost.style.transform = 'translate('+this.calculeX(ghost)+'px,'+this.calculeY(ghost)+'px)';
	}
}

Lightbox.prototype.close = function(wrap) {
	var overlay = wrap.getElementsByClassName('lightbox__overlay')[0],
		ghost = wrap.getElementsByClassName('lightbox__ghost')[0];

	addClass(wrap, 'lightbox--close');
	removeClass(wrap, 'lightbox--open');
	ghost.style.transform = 'translate(0px,0px)';
	ghost.style.display = 'none';
}

Lightbox.prototype.action = function(wrap, ghost, overlay, thumb) {
	var lightboxDom = this;

	thumb.addEventListener('click', function() { lightboxDom.open(wrap); });
	overlay.addEventListener('click', function() { lightboxDom.close(wrap); });

	return wrap;
};

Lightbox.prototype.setVhd = function(vhd) { this.vhd = vhd; };

/* DuplexBox ==================
==================================
==================================*/

function DuplexBox(data) { WebComponents.call(this, data); }

DuplexBox.prototype = Object.create(WebComponents.prototype, {
    constructor: {
        value: WebComponents,
        enumerable: false,
        writable: true,
        configurable: true
    }
});

DuplexBox.prototype.write = function() {
	var contenair = document.createElement('div');
	addClass(contenair, 'duplex-block');
	addClass(contenair, 'duplex-block--back');

	var front = document.createElement('div');
	addClass(front, 'duplex-block');
	addClass(front, 'duplex-block__front');
	front.appendChild(this.lazydata.elm);

	var back = document.createElement('figcaption');
	addClass(back, 'duplex-block__face');
	addClass(back, 'duplex-block__back');

	var btn = document.createElement('div');
	addClass(btn, 'duplex-block__btn');
	btn.appendChild(document.createTextNode('Retourner'));

	this.back.load(back);

	return this.action(contenair, front, back, btn);
};

DuplexBox.prototype.action = function(contenair, front, back, btn) {
	btn.addEventListener('click', function() { // Back
		if(hasClass(contenair, 'duplex-block--back')) {
			addClass(contenair, 'duplex-block--front')
			removeClass(contenair, 'duplex-block--back')
			
			front.style.transform = 'rotateY(180deg)';
			back.style.opacity = 1;
		} else { // Front
			addClass(contenair, 'duplex-block--back')
			removeClass(contenair, 'duplex-block--front')
			
			front.style.transform = 'rotateY(0)';
			back.style.opacity = 0;
		}
	});

	return contenair;
};

DuplexBox.prototype.setBack = function(back) { this.back = back };