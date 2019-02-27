/*© Copyright Tanguy Bazire*/

/* Hydrator ===========================
======================================
======================================*/

function Hydrator(data) {
	for (var key in data) {
		var method = 'set' + key.charAt(0).toUpperCase() + key.substring(1);
		
		if(method in this) {
			if(typeof data[key] != 'undefined') 
				this[method](data[key]);
		}
	}
}

/* Throttling ========================
======================================
======================================*/

function Throttling(method) {
	var active = false, context = this,

	fx = function(event) {
		if (!active) {
			active = true;
				
			setTimeout(function() {
				context[method](fx, event);
				active = false;
			}, 200);
		}
	};

	return fx;
}

/*DispatchEvent  =====================
======================================
=====================================*/

function DispatchEvent(name) {
	var event;
		
	if(typeof(Event) === 'function') {
	    event = new Event(name);
	}else{
	    event = document.createEvent('Event');
	    event.initEvent(name, true, true);
	}

	this.elm.dispatchEvent(event);
}

/*ClassUtility(IE9) ==================
======================================
====================================*/

function hasClass(el, className) {
    if (el.classList)
        return el.classList.contains(className);
    return !!el.className.match(new RegExp('(\s|^)' + className + '(\s|$)'));
}

function addClass(el, className) {
    if (el.classList)
        el.classList.add(className)
    else if (!hasClass(el, className))
        el.className += " " + className;
}

function removeClass(el, className) {
    if (el.classList)
        el.classList.remove(className)
    else if (hasClass(el, className))
    {
        var reg = new RegExp('(\s|^)' + className + '(\s|$)');
        el.className = el.className.replace(reg, ' ');
    }
}