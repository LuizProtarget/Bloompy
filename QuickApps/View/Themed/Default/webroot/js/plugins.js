// Avoid `console` errors in browsers that lack a console.
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

var JOMOS = {
	window:{width:0,height:0,element:$(window),isLoaded:false},
	engine:{
		isLoading:false,
		setLoading: function(b){
			if(b!=this.isLoading){
				if(b) $('body>#loading').css('display','block'); else $('body>#loading').css('display','');
				this.isLoading = b;
			}
		},
		onHashChange: function(){
			/* NO INTERNET EXPLORER 7 O EVENTO NÃO É DISPARADO. COGITAR WORKARROUND. */
			console.log('ON HASH CHANGE');
			var delay=0;
			var newHashObj = [];
			var newPageObj = null;
			if(!(typeof document.location.hash == 'undefined' || document.location.hash == ""))
				newHashObj = document.location.hash.substr(2).split('/')
				
			$('nav li').removeClass('selected');
			
			if(newHashObj.length > 0){
				
				$('nav ul li a[href="#/'+newHashObj[0]+'"]').parent().addClass('selected');
				
				if((JOMOS.app.currentHash == null || JOMOS.app.currentHash.length == 0) || (JOMOS.app.currentHash != null && JOMOS.app.currentHash.length > 0 && JOMOS.app.currentHash[0] != newHashObj[0])){
					console.log('TRANSITION OUT EVENT CREATED AND WAITING');
					$(JOMOS.engine).one('trasitionout_completed',function(e){
						console.log('TRANSITION OUT COMPLETED',e);
						if(JOMOS.app.currentPage && typeof JOMOS.app.currentPage.config != 'undefined'){
							if(JOMOS.app.currentPage.config.keepalive)
								$(JOMOS.app.currentPage.domElement).css('display','none');
							else
							{
								JOMOS.app.currentPage.initialized = false;		
								$(JOMOS.app.currentPage.domElement).parent().css('min-height',($(window).height()-120-241));	
								$(JOMOS.app.currentPage.domElement).remove();
							}
						}
						
						JOMOS.app.currentHash = newHashObj;
						console.log('LOOKING FOR THE NEW PAGE OBJECT');
						newPageObj = JOMOS.engine.findPageByHash(newHashObj);
						
						
						$(JOMOS.engine).one('trasitionin_completed',function(){
							if(typeof newPageObj.onHashChange == 'function')
								newPageObj.onHashChange(newHashObj);
							else 
								JOMOS.engine.defaultPageOnHashChange(newHashObj);
						});
						
						$(JOMOS.engine).one('initialize_completed',function(){
							if(typeof newPageObj.onTransitionIn == 'function')
								newPageObj.onTransitionIn();
							else
								$(JOMOS.engine).trigger('trasitionin_completed');
						});
						
						
						
						if(typeof newPageObj != 'undefined' && newPageObj != null){
					
							JOMOS.app.currentPage = newPageObj;
							
							
							
							if((typeof newPageObj.initialized == 'undefined' || !newPageObj.initialized) && (typeof newPageObj.rawHtml == 'undefined')){
								
								if(newPageObj.type == 'ajax'){
									var ajaxSettings = $.extend({
										url: newPageObj.config.url,
										type: 'GET',
										async:true,
										dataType: 'html'
									},newPageObj.config.additionalAjaxSettings);
									
									
									JOMOS.engine.setLoading(true);
									$.ajax(ajaxSettings).complete(function(data,code){
										JOMOS.engine.setLoading(false);
										newPageObj.rawHtml = data.responseText;
										newPageObj.initialized = true;
										if(typeof newPageObj.config.containerSelector == 'string'){
											var pageHtml = $(newPageObj.rawHtml);
											$(newPageObj.config.containerSelector).css('min-height','');	
											$(newPageObj.config.containerSelector).append(pageHtml);
											newPageObj.domElement = pageHtml;
											
										}
										
										if(typeof newPageObj.onInitialize == 'function')
											newPageObj.onInitialize();
										else $(JOMOS.engine).trigger('initialize_completed')
									})
									
									
								} else {
									
								}
									
							} else {
								$(newPageObj.config.containerSelector).css('min-height','');	
								if(newPageObj.config.keepalive && typeof newPageObj.domElement != 'undefined'){
									$(newPageObj.domElement).css('display','');
									$(JOMOS.engine).trigger('initialize_completed');
								} else {
									$(newPageObj.config.containerSelector).append(newPageObj.domElement);
									if(typeof newPageObj.onInitialize == 'function')
										newPageObj.onInitialize();
									else $(JOMOS.engine).trigger('initialize_completed')
								}
								
							}
							
						}
						
					});
				}
				if(JOMOS.app.currentHash != null && JOMOS.app.currentHash.length > 0){
					
					if(JOMOS.app.currentHash[0] != newHashObj[0]){
						/* CASO HAJA MUDANÇA DE PÁGINA */	
						console.log('TRANSITION OUT START',JOMOS.app.currentPage.hash);
						if(typeof JOMOS.app.currentPage.onTransitionOut == 'function'){
							JOMOS.app.currentPage.onTransitionOut();
						} else
							$(JOMOS.engine).trigger('trasitionout_completed');
						
					} else if(JOMOS.app.currentHash.join('/') != newHashObj.join('/')){
						/* CASO APENAS HAJA MUDANÇA INTERNA DA PÁGINA */
						
						JOMOS.app.currentHash = newHashObj;
						
						if(typeof JOMOS.app.currentPage.onHashChange == 'function')
							JOMOS.app.currentPage.onHashChange(newHashObj);
						else 
							JOMOS.engine.defaultPageOnHashChange(newHashObj);
							
					} else return;
					
					
				} else $(JOMOS.engine).trigger('trasitionout_completed');
				
			} 

		},
		
		defaultPageOnHashChange:function(hashObj){
			
		},
		
		findPageByHash: function(hashObj){
			if(typeof hashObj == 'string') hashObj = [hashObj];
			console.log('FIND PAGE BY HASH',hashObj.join('/'));
			for(var x = 0; x < JOMOS.app.pages.length; x++){
				if(JOMOS.app.pages[x].hash == hashObj[0]) return JOMOS.app.pages[x];
			}
		}
	},
	app:{},
	helpers:{
		isEmail: function(a) {var r = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;return r.test(a);},
		inputPlaceholder:function(e){
			var n='data-placeholder';$(e).focus(function(){if($(e).val()==$(e).attr(n))$(e).val('');}).blur(function(){if($(e).val()=='')$(e).val($(e).attr(n));});
		}
	}
};


// jquery.parallax.js
// 2.0
// Stephen Band
//
// Project and documentation site:
// webdev.stephband.info/jparallax/
//
// Repository:
// github.com/stephband/jparallax

(function(jQuery, undefined) {
	// VAR
	var debug = true,
	    
	    options = {
	    	mouseport:     'body',  // jQuery object or selector of DOM node to use as mouseport
	    	xparallax:     true,    // boolean | 0-1 | 'npx' | 'n%'
	    	yparallax:     true,    //
	    	xorigin:       0.5,     // 0-1 - Sets default alignment. Only has effect when parallax values are something other than 1 (or true, or '100%')
	    	yorigin:       0.5,     //
	    	decay:         0.66,    // 0-1 (0 instant, 1 forever) - Sets rate of decay curve for catching up with target mouse position
	    	frameDuration: 30,      // Int (milliseconds)
	    	freezeClass:   'freeze' // String - Class added to layer when frozen
	    },
	
	    value = {
	    	left: 0,
	    	top: 0,
	    	middle: 0.5,
	    	center: 0.5,
	    	right: 1,
	    	bottom: 1
	    },
	
	    rpx = /^\d+\s?px$/,
	    rpercent = /^\d+\s?%$/,
	    
	    win = jQuery(window),
	    doc = jQuery(document),
	    mouse = [0, 0];
	
	var Timer = (function(){
		var debug = false;
		
		// Shim for requestAnimationFrame, falling back to timer. See:
		// see http://paulirish.com/2011/requestanimationframe-for-smart-animating/
		var requestFrame = (function(){
		    	return (
		    		window.requestAnimationFrame ||
		    		window.webkitRequestAnimationFrame ||
		    		window.mozRequestAnimationFrame ||
		    		window.oRequestAnimationFrame ||
		    		window.msRequestAnimationFrame ||
		    		function(fn, node){
		    			return window.setTimeout(function(){
		    				fn();
		    			}, 25);
		    		}
		    	);
		    })();
		
		function Timer() {
			var callbacks = [],
				nextFrame;
			
			function noop() {}
			
			function frame(){
				var cbs = callbacks.slice(0),
				    l = cbs.length,
				    i = -1;
				
				if (debug) { console.log('timer frame()', l); }
				
				while(++i < l) { cbs[i].call(this); }
				requestFrame(nextFrame);
			}
			
			function start() {
				if (debug) { console.log('timer start()'); }
				this.start = noop;
				this.stop = stop;
				nextFrame = frame;
				requestFrame(nextFrame);
			}
			
			function stop() {
				if (debug) { console.log('timer stop()'); }
				this.start = start;
				this.stop = noop;
				nextFrame = noop;
			}
			
			this.callbacks = callbacks;
			this.start = start;
			this.stop = stop;
		}

		Timer.prototype = {
			add: function(fn) {
				var callbacks = this.callbacks,
				    l = callbacks.length;
				
				// Check to see if this callback is already in the list.
				// Don't add it twice.
				while (l--) {
					if (callbacks[l] === fn) { return; }
				}
				
				this.callbacks.push(fn);
				if (debug) { console.log('timer add()', this.callbacks.length); }
			},
		
			remove: function(fn) {
				var callbacks = this.callbacks,
				    l = callbacks.length;
				
				// Remove all instances of this callback.
				while (l--) {
					if (callbacks[l] === fn) { callbacks.splice(l, 1); }
				}
				
				if (debug) { console.log('timer remove()', this.callbacks.length); }
				
				if (callbacks.length === 0) { this.stop(); }
			}
		};
		
		return Timer;
	})();
	
	function parseCoord(x) {
		return (rpercent.exec(x)) ? parseFloat(x)/100 : x;
	}
	
	function parseBool(x) {
		return typeof x === "boolean" ? x : !!( parseFloat(x) ) ;
	}
	
	function portData(port) {
		var events = {
		    	'mouseenter.parallax': mouseenter,
		    	'mouseleave.parallax': mouseleave
		    },
		    winEvents = {
		    	'resize.parallax': resize
		    },
		    data = {
		    	elem: port,
		    	events: events,
		    	winEvents: winEvents,
		    	timer: new Timer()
		    },
		    layers, size, offset;
		
		function updatePointer() {
			data.pointer = getPointer(mouse, [true, true], offset, size);
		}
		
		function resize() {
			size = getSize(port);
			offset = getOffset(port);
			data.threshold = getThreshold(size);
		}
		
		function mouseenter() {
			data.timer.add(updatePointer);
		}
		
		function mouseleave(e) {
			data.timer.remove(updatePointer);
			data.pointer = getPointer([e.pageX, e.pageY], [true, true], offset, size);
		}

		win.on(winEvents);
		port.on(events);
		
		resize();
		
		return data;
	}
	
	function getData(elem, name, fn) {
		var data = elem.data(name);
		
		if (!data) {
			data = fn ? fn(elem) : {} ;
			elem.data(name, data);
		}
		
		return data;
	}
	
	function getPointer(mouse, parallax, offset, size){
		var pointer = [],
		    x = 2;
		
		while (x--) {
			pointer[x] = (mouse[x] - offset[x]) / size[x] ;
			pointer[x] = pointer[x] < 0 ? 0 : pointer[x] > 1 ? 1 : pointer[x] ;
		}
		
		return pointer;
	}
	
	function getSize(elem) {
		return [elem.width(), elem.height()];
	}
	
	function getOffset(elem) {
		var offset = elem.offset() || {left: 0, top: 0},
			borderLeft = elem.css('borderLeftStyle') === 'none' ? 0 : parseInt(elem.css('borderLeftWidth'), 10),
			borderTop = elem.css('borderTopStyle') === 'none' ? 0 : parseInt(elem.css('borderTopWidth'), 10),
			paddingLeft = parseInt(elem.css('paddingLeft'), 10),
			paddingTop = parseInt(elem.css('paddingTop'), 10);
		
		return [offset.left + borderLeft + paddingLeft, offset.top + borderTop + paddingTop];
	}
	
	function getThreshold(size) {
		return [1/size[0], 1/size[1]];
	}
	
	function layerSize(elem, x, y) {
		return [x || elem.outerWidth(), y || elem.outerHeight()];
	}
	
	function layerOrigin(xo, yo) {
		var o = [xo, yo],
			i = 2,
			origin = [];
		
		while (i--) {
			origin[i] = typeof o[i] === 'string' ?
				o[i] === undefined ?
					1 :
					value[origin[i]] || parseCoord(origin[i]) :
				o[i] ;
		}
		
		return origin;
	}
	
	function layerPx(xp, yp) {
		return [rpx.test(xp), rpx.test(yp)];
	}
	
	function layerParallax(xp, yp, px) {
		var p = [xp, yp],
		    i = 2,
		    parallax = [];
		
		while (i--) {
			parallax[i] = px[i] ?
				parseInt(p[i], 10) :
				parallax[i] = p[i] === true ? 1 : parseCoord(p[i]) ;
		}
		
		return parallax;
	}
	
	function layerOffset(parallax, px, origin, size) {
		var i = 2,
		    offset = [];
		
		while (i--) {
			offset[i] = px[i] ?
				origin[i] * (size[i] - parallax[i]) :
				parallax[i] ? origin[i] * ( 1 - parallax[i] ) : 0 ;
		}
		
		return offset;
	}
	
	function layerPosition(px, origin) {
		var i = 2,
		    position = [];
		
		while (i--) {
			if (px[i]) {
				// Set css position constant
				position[i] = origin[i] * 100 + '%';
			}
			else {
			
			}
		}
		
		return position;
	}
	
	function layerPointer(elem, parallax, px, offset, size) {
		var viewport = elem.offsetParent(),
			pos = elem.position(),
			position = [],
			pointer = [],
			i = 2;
		
		// Reverse calculate ratio from elem's current position
		while (i--) {
			position[i] = px[i] ?
				// TODO: reverse calculation for pixel case
				0 :
				pos[i === 0 ? 'left' : 'top'] / (viewport[i === 0 ? 'outerWidth' : 'outerHeight']() - size[i]) ;
			
			pointer[i] = (position[i] - offset[i]) / parallax[i] ;
		}
		
		return pointer;
	}
	
	function layerCss(parallax, px, offset, size, position, pointer) {
		var pos = [],
		    cssPosition,
		    cssMargin,
		    x = 2,
		    css = {};
		
		while (x--) {
			if (parallax[x]) {
				pos[x] = parallax[x] * pointer[x] + offset[x];
				
				// We're working in pixels
				if (px[x]) {
					cssPosition = position[x];
					cssMargin = pos[x] * -1;
				}
				// We're working by ratio
				else {
					cssPosition = pos[x] * 100 + '%';
					cssMargin = pos[x] * size[x] * -1;
				}
				
				// Fill in css object
				if (x === 0) {
					css.left = cssPosition;
					css.marginLeft = cssMargin;
				}
				else {
					css.top = cssPosition;
					css.marginTop = cssMargin;
				}
			}
		}
		
		return css;
	}
	
	function pointerOffTarget(targetPointer, prevPointer, threshold, decay, parallax, targetFn, updateFn) {
		var pointer, x;
		
		if ((!parallax[0] || Math.abs(targetPointer[0] - prevPointer[0]) < threshold[0]) &&
		    (!parallax[1] || Math.abs(targetPointer[1] - prevPointer[1]) < threshold[1])) {
		    // Pointer has hit the target
		    if (targetFn) { targetFn(); }
		    return updateFn(targetPointer);
		}
		
		// Pointer is nowhere near the target
		pointer = [];
		x = 2;
		
		while (x--) {
			if (parallax[x]) {
				pointer[x] = targetPointer[x] + decay * (prevPointer[x] - targetPointer[x]);
			}
		}
			
		return updateFn(pointer);
	}
	
	function pointerOnTarget(targetPointer, prevPointer, threshold, decay, parallax, targetFn, updateFn) {
		// Don't bother updating if the pointer hasn't changed.
		if (targetPointer[0] === prevPointer[0] && targetPointer[1] === prevPointer[1]) {
			return;
		}
		
		return updateFn(targetPointer);
	}
	
	function unport(elem, events, winEvents) {
		elem.off(events).removeData('parallax_port');
		win.off(winEvents);
	}
	
	function unparallax(node, port, events) {
		port.elem.off(events);
		
		// Remove this node from layers
		port.layers = port.layers.not(node);
		
		// If port.layers is empty, destroy the port
		if (port.layers.length === 0) {
			unport(port.elem, port.events, port.winEvents);
		}
	}
	
	function unstyle(parallax) {
		var css = {};
		
		if (parallax[0]) {
			css.left = '';
			css.marginLeft = '';
		}
		
		if (parallax[1]) {
			css.top = '';
			css.marginTop = '';
		}
		
		elem.css(css);
	}
	
	jQuery.fn.parallax = function(o){
		var options = jQuery.extend({}, jQuery.fn.parallax.options, o),
		    args = arguments,
		    elem = options.mouseport instanceof jQuery ?
		    	options.mouseport :
		    	jQuery(options.mouseport) ,
		    port = getData(elem, 'parallax_port', portData),
		    timer = port.timer;
		
		return this.each(function(i) {
			var node      = this,
			    elem      = jQuery(this),
			    opts      = args[i + 1] ? jQuery.extend({}, options, args[i + 1]) : options,
			    decay     = opts.decay,
			    size      = layerSize(elem, opts.width, opts.height),
			    origin    = layerOrigin(opts.xorigin, opts.yorigin),
			    px        = layerPx(opts.xparallax, opts.yparallax),
			    parallax  = layerParallax(opts.xparallax, opts.yparallax, px),
			    offset    = layerOffset(parallax, px, origin, size),
			    position  = layerPosition(px, origin),
			    pointer   = layerPointer(elem, parallax, px, offset, size),
			    pointerFn = pointerOffTarget,
			    targetFn  = targetInside,
			    events = {
			    	'mouseenter.parallax': function mouseenter(e) {
			    		pointerFn = pointerOffTarget;
			    		targetFn = targetInside;
			    		timer.add(frame);
			    		timer.start();
			    	},
			    	'mouseleave.parallax': function mouseleave(e) {
			    		// Make the layer come to rest at it's limit with inertia
			    		pointerFn = pointerOffTarget;
			    		// Stop the timer when the the pointer hits target
			    		targetFn = targetOutside;
			    	}
			    };
			
			function updateCss(newPointer) {
				var css = layerCss(parallax, px, offset, size, position, newPointer);
				elem.css(css);
				pointer = newPointer;
			}
			
			function frame() {
				pointerFn(port.pointer, pointer, port.threshold, decay, parallax, targetFn, updateCss);
			}
			
			function targetInside() {
				// Pointer hits the target pointer inside the port
				pointerFn = pointerOnTarget;
			}
			
			function targetOutside() {
				// Pointer hits the target pointer outside the port
				timer.remove(frame);
			}
			
			
			if (jQuery.data(node, 'parallax')) {
				elem.unparallax();
			}
			
			jQuery.data(node, 'parallax', {
				port: port,
				events: events,
				parallax: parallax
			});
			
			port.elem.on(events);
			port.layers = port.layers? port.layers.add(node): jQuery(node);
			
			/*function freeze() {
				freeze = true;
			}
			
			function unfreeze() {
				freeze = false;
			}*/
			
			/*jQuery.event.add(this, 'freeze.parallax', freeze);
			jQuery.event.add(this, 'unfreeze.parallax', unfreeze);*/
		});
	};
	
	jQuery.fn.unparallax = function(bool) {
		return this.each(function() {
			var data = jQuery.data(this, 'parallax');
			
			// This elem is not parallaxed
			if (!data) { return; }
			
			jQuery.removeData(this, 'parallax');
			unparallax(this, data.port, data.events);
			if (bool) { unstyle(data.parallax); }
		});
	};
	
	jQuery.fn.parallax.options = options;
	
	// Pick up and store mouse position on document: IE does not register
	// mousemove on window.
	doc.on('mousemove.parallax', function(e){
		mouse = [e.pageX, e.pageY];
	});
}(jQuery));



/*
 *	jQuery OwlCarousel v1.22
 *  
 *	Copyright (c) 2013 Bartosz Wojciechowski
 *	http://www.owlgraphic.com/owlcarousel
 *
 *	Licensed under MIT
 *
 */

eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('7(O 2X.2r!=="b"){2X.2r=b(e){b t(){}t.3U=e;q 41 t}}(b(e,t,n,r){9 i={3y:b(t,n){9 r=c;r.6=e.3W({},e.2l.1S.6,t);9 i=n;9 s=e(n);r.$p=s;r.3L()},3L:b(){9 t=c;7(O t.6.2H==="b"){t.6.2H.14(c,[t.$p])}7(O t.6.2h==="3T"){9 n=t.6.2h;b r(e){7(O t.6.2v==="b"){t.6.2v.14(c,[e])}m{9 n="";1A(9 r 3R e["h"]){n+=e["h"][r]["1J"]}t.$p.27(n)}t.2B()}e.4x(n,r)}m{t.2B()}},2B:b(){9 e=c;e.1I();e.$p.C({1O:0});e.3O();e.3N();e.1p();e.4v=0;e.k=0;e.2n=e.$p.4j();e.E=e.2n.2G;e.3K();e.R=e.$p.Q(".h-1J");e.L=e.$p.Q(".h-1f");e.1P=e.6.v;e.11="D";e.28;e.3H();e.3F()},3H:b(){9 e=c;e.2Q();e.2Z();e.3E();e.2f();e.3D();e.3C();e.2b();7(e.6.J===j){e.6.J=4d}e.12();e.$p.Q(".h-1f").C("3A","3z");7(!e.$p.2x(":2y")){e.2A()}m{X(b(){e.$p.2E({1O:1},1m)},10)}e.4i=d;e.1Y();7(O e.6.2N==="b"){e.6.2N.14(c,[e.$p])}},1Y:b(){9 e=c;7(e.6.1H===j){e.1H()}7(e.6.1t===j){e.1t()}7(e.6.29===j){e.29()}7(O e.6.2R==="b"){e.6.2R.14(c,[e.$p])}},2S:b(){9 e=c;e.2A();e.2Q();e.2Z();e.3x();e.2f();e.1Y()},3w:b(e){9 t=c;X(b(){t.2S()},0)},2A:b(){9 e=c;1b(e.28);7(!e.$p.2x(":2y")){e.$p.C({1O:0});1b(e.1i)}m{q d}e.28=3v(b(){7(e.$p.2x(":2y")){e.3w();e.$p.2E({1O:1},1m);1b(e.28)}},4e)},3K:b(){9 e=c;e.2n.4h(\'<H M="h-1f">\').3t(\'<H M="h-1J"></H>\');e.$p.Q(".h-1f").3t(\'<H M="h-1f-32">\');e.1G=e.$p.Q(".h-1f-32");e.$p.C("3A","3z")},1I:b(){9 e=c;9 t=e.$p.1F(e.6.1I);9 n=e.$p.1F(e.6.26);7(!t){e.$p.K(e.6.1I)}7(!n){e.$p.K(e.6.26)}},2Q:b(){9 n=c;7(n.6.2o===d){q d}7(n.6.3r===j){n.6.v=n.1P=1;n.6.1w=d;n.6.1x=d;n.6.1D=d;n.6.1C=d;q d}9 r=e(t).16();7(r>(n.6.1w[0]||n.1P)){n.6.v=n.1P}7(r<=n.6.1w[0]&&n.6.1w!==d){n.6.v=n.6.1w[1]}7(r<=n.6.1x[0]&&n.6.1x!==d){n.6.v=n.6.1x[1]}7(r<=n.6.1D[0]&&n.6.1D!==d){n.6.v=n.6.1D[1]}7(r<=n.6.1C[0]&&n.6.1C!==d){n.6.v=n.6.1C[1]}7(n.6.v>n.E){n.6.v=n.E}},3D:b(){9 n=c,r;7(n.6.2o!==j){q d}9 i=e(t).16();e(t).45(b(){7(e(t).16()!==i){7(n.6.J!==d){1b(n.1i)}4a(r);r=X(b(){i=e(t).16();n.2S()},n.6.3q)}})},3x:b(){9 e=c;7(e.1p===j){7(e.Z[e.k]>e.1Q){e.1B(e.Z[e.k])}m{e.1B(0);e.k=0}}m{7(e.Z[e.k]>e.1Q){e.1v(e.Z[e.k])}m{e.1v(0);e.k=0}}7(e.6.J!==d){e.2I()}},3p:b(){9 t=c;9 n=0;9 r=t.E-t.6.v;t.R.1U(b(i){e(c).C({16:t.N}).z("h-1J",2O(i));7(i%t.6.v===0||i===r){7(!(i>r)){n+=1}}e(c).z("h-25",n)})},3o:b(){9 e=c;9 t=0;9 t=e.R.2G*e.N;e.L.C({16:t*2,15:0});e.3p()},2Z:b(){9 e=c;e.3n();e.3o();e.3l();e.2T()},3n:b(){9 e=c;e.N=2U.4I(e.$p.16()/e.6.v)},2T:b(){9 e=c;e.B=e.E-e.6.v;9 t=e.E*e.N-e.6.v*e.N;t=t*-1;e.1Q=t;q t},3k:b(){q 0},3l:b(){9 e=c;e.Z=[0];9 t=0;1A(9 n=0;n<e.E;n++){t+=e.N;e.Z.3Y(-t)}},3E:b(){9 t=c;7(t.6.1y===j||t.6.1k===j){t.F=e(\'<H M="h-47"/>\').48("49",!t.1g).4c(t.$p)}7(t.6.1k===j){t.3j()}7(t.6.1y===j){t.3h()}},3h:b(){9 t=c;9 n=e(\'<H M="h-4g"/>\');t.F.1n(n);t.1o=e("<H/>",{"M":"h-G",27:t.6.2c[0]||""});t.1q=e("<H/>",{"M":"h-D",27:t.6.2c[1]||""});n.1n(t.1o).1n(t.1q);n.A("21.F 24.F",\'H[M^="h"]\',b(n){n.1r();7(e(c).1F("h-D")){t.D()}m{t.G()}})},3j:b(){9 t=c;t.1d=e(\'<H M="h-1k"/>\');t.F.1n(t.1d);t.1d.A("21.F 24.F",".h-1e",b(n){n.1r();7(2O(e(c).z("h-1e"))!==t.k){t.1u(2O(e(c).z("h-1e")),j)}})},3g:b(){9 t=c;7(t.6.1k===d){q d}t.1d.27("");9 n=0;9 r=t.E-t.E%t.6.v;1A(9 i=0;i<t.E;i++){7(i%t.6.v===0){n+=1;7(r===i){9 s=t.E-t.6.v}9 o=e("<H/>",{"M":"h-1e"});9 u=e("<3c></3c>",{4b:t.6.2u===j?n:"","M":t.6.2u===j?"h-4X":""});o.1n(u);o.z("h-1e",r===i?s:i);o.z("h-25",n);t.1d.1n(o)}}t.2w()},2w:b(){9 t=c;t.1d.Q(".h-1e").1U(b(n,r){7(e(c).z("h-25")===e(t.R[t.k]).z("h-25")){t.1d.Q(".h-1e").13("1M");e(c).K("1M")}})},2z:b(){9 e=c;7(e.6.1y===d){q d}7(e.6.1N===d){7(e.k===0&&e.B===0){e.1o.K("V");e.1q.K("V")}m 7(e.k===0&&e.B!==0){e.1o.K("V");e.1q.13("V")}m 7(e.k===e.B){e.1o.13("V");e.1q.K("V")}m 7(e.k!==0&&e.k!==e.B){e.1o.13("V");e.1q.13("V")}}},2f:b(){9 e=c;e.3g();e.2z();7(e.F){7(e.6.v===e.E){e.F.3b()}m{e.F.4D()}}},4E:b(){9 e=c;7(e.F){e.F.4H()}},D:b(e){9 t=c;t.k+=t.6.1E===j?t.6.v:1;7(t.k>t.B+(t.6.1E==j?t.6.v-1:0)){7(t.6.1N===j){t.k=0;e="17"}m{t.k=t.B;q d}}t.1u(t.k,e)},G:b(e){9 t=c;7(t.6.1E===j&&t.k>0&&t.k<t.6.v){t.k=0}m{t.k-=t.6.1E===j?t.6.v:1}7(t.k<0){7(t.6.1N===j){t.k=t.B;e="17"}m{t.k=0;q d}}t.1u(t.k,e)},1u:b(e,t){9 n=c;7(O n.6.2F==="b"){n.6.2F.14(c,[n.$p])}7(e>=n.B){e=n.B}m 7(e<=0){e=0}n.k=e;9 r=n.Z[e];7(n.1p===j){n.1z=d;7(t===j){n.1R("1s");X(b(){n.1z=j},n.6.1s)}m 7(t==="17"){n.1R(n.6.1T);X(b(){n.1z=j},n.6.1T)}m{n.1R("1a");X(b(){n.1z=j},n.6.1a)}n.1B(r)}m{7(t===j){n.1v(r,n.6.1s)}m 7(t==="17"){n.1v(r,n.6.1T)}m{n.1v(r,n.6.1a)}}7(n.6.1k===j){n.2w()}7(n.6.1y===j){n.2z()}7(n.6.J!==d){n.2I()}n.1Y();7(O n.6.2K==="b"){n.6.2K.14(c,[n.$p])}},T:b(){9 e=c;e.2M="T";1b(e.1i)},2I:b(){9 e=c;7(e.2M!=="T"){e.12()}},12:b(){9 e=c;e.2M="12";7(e.6.J===d){q d}1b(e.1i);e.1i=3v(b(){7(e.k<e.B&&e.11==="D"){e.D(j)}m 7(e.k===e.B){7(e.6.17===j){e.1u(0,"17")}m{e.11="G";e.G(j)}}m 7(e.11==="G"&&e.k>0){e.G(j)}m 7(e.11==="G"&&e.k===0){e.11="D";e.D(j)}},e.6.J)},1R:b(e){9 t=c;7(e==="1a"){t.L.C(t.1W(t.6.1a))}m 7(e==="1s"){t.L.C(t.1W(t.6.1s))}m 7(O e!=="3T"){t.L.C(t.1W(e))}},1W:b(e){9 t=c;q{"-1X-W":"1Z "+e+"1h 22","-23-W":"1Z "+e+"1h 22","-o-W":"1Z "+e+"1h 22",W:"1Z "+e+"1h 22"}},39:b(){q{"-1X-W":"","-23-W":"","-o-W":"",W:""}},38:b(e){q{"-1X-P":"18("+e+"1j, w, w)","-23-P":"18("+e+"1j, w, w)","-o-P":"18("+e+"1j, w, w)","-1h-P":"18("+e+"1j, w, w)",P:"18("+e+"1j, w,w)"}},1B:b(e){9 t=c;t.L.C(t.38(e))},35:b(e){9 t=c;t.L.C({15:e})},1v:b(e,t){9 n=c;n.2a=d;n.L.T(j,j).2E({15:e},{3V:t||n.6.1a,34:b(){n.2a=j}})},1p:b(){9 e=c;9 t="18(w, w, w)";9 r=n.3X("H");r.3s.33="  -23-P:"+t+"; -1h-P:"+t+"; -o-P:"+t+"; -1X-P:"+t+"; P:"+t;9 i=/18\\(w, w, w\\)/g;9 s=r.3s.33.40(i);9 o=s!==U&&s.2G===1;e.1p=o;q o},3O:b(){9 e=c;e.1g="42"3R t||43.44},3C:b(){9 e=c;7(e.6.1L!==d||e.6.1K!==d){e.36();e.37()}},3N:b(){9 e=c;9 t=["s","e","x"];e.S={};7(e.6.1L===j&&e.6.1K===j){t=["3a.h 2C.h","2t.h 3d.h","21.h 3e.h 24.h"]}m 7(e.6.1L===d&&e.6.1K===j){t=["3a.h","2t.h","21.h 3e.h"]}m 7(e.6.1L===j&&e.6.1K===d){t=["2C.h","3d.h","24.h"]}e.S["3f"]=t[0];e.S["2q"]=t[1];e.S["2d"]=t[2]},37:b(){9 e=c;e.$p.A("4w.h","3i",b(e){e.1r()});e.$p.4y("2C.4z",b(){q d})},36:b(){b o(e){7(e.31){q{x:e.31[0].2V,y:e.31[0].3m}}m{7(e.2V!==r){q{x:e.2V,y:e.3m}}m{q{x:e.4L,y:e.4N}}}}b u(t){7(t==="A"){e(n).A(i.S["2q"],f);e(n).A(i.S["2d"],l)}m 7(t==="Y"){e(n).Y(i.S["2q"]);e(n).Y(i.S["2d"])}}b a(n){9 n=n.2J||n||t.2D;7(i.2a===d){q d}7(i.1z===d){q d}7(i.6.J!==d){1b(i.1i)}7(i.1g!==j&&!i.L.1F("2p")){i.L.K("2p")}i.I=0;i.19=0;e(c).C(i.39());9 r=e(c).3u();s.2e=r.15;s.2Y=o(n).x-r.15;s.2W=o(n).y-r.46;u("A");s.1V=d;s.2s=n.1c||n.3B}b f(r){9 r=r.2J||r||t.2D;i.I=o(r).x-s.2Y;i.2i=o(r).y-s.2W;i.19=i.I-s.2e;7(O i.6.2g==="b"&&s.30!==j&&i.I!==0){s.30=j;i.6.2g.14(c)}7(i.19>8||i.19<-8&&i.1g===j){r.1r?r.1r():r.4f=d;s.1V=j}7((i.2i>10||i.2i<-10)&&s.1V===d){e(n).Y("2t.h")}9 u=b(){q i.19/5};9 a=b(){q i.1Q+i.19/5};i.I=2U.2T(2U.3k(i.I,u()),a());7(i.1p===j){i.1B(i.I)}m{i.35(i.I)}}b l(n){9 n=n.2J||n||t.2D;n.1c=n.1c||n.3B;s.30=d;7(i.1g!==j){i.L.13("2p")}7(i.I!==0){9 r=i.3G();i.1u(r);7(s.2s===n.1c&&i.1g!==j){e(n.1c).A("2P.3I",b(t){t.4k();t.4l();t.1r();e(n.1c).Y("2P.3I")});9 o=e.4m(n.1c,"4n")["2P"];9 a=o.4o();o.4p(0,0,a)}}u("Y")}9 i=c;9 s={2Y:0,2W:0,4q:0,2e:0,3u:U,4r:U,4s:U,1V:U,4t:U,2s:U};i.2a=j;i.$p.A(i.S["3f"],".h-1f",a)},4u:b(){9 t=c;t.$p.Y(".h");e(n).Y(".h")},3G:b(){9 e=c,t;9 t=e.3J();7(t>e.B){e.k=e.B;t=e.B}m 7(e.I>=0){t=0;e.k=0}q t},3J:b(){9 t=c;9 n=t.Z;9 r=t.I;9 i=U;e.1U(n,b(e,s){7(r-t.N/20>n[e+1]&&r-t.N/20<s&&t.2m()==="15"){i=s;t.k=e}m 7(r+t.N/20<s&&r+t.N/20>n[e+1]&&t.2m()==="3M"){i=n[e+1];t.k=e+1}});q t.k},2m:b(){9 e=c,t;7(e.19<0){t="3M";e.11="D"}m{t="15";e.11="G"}q t},3F:b(){9 e=c;e.$p.A("h.D",b(){e.D()});e.$p.A("h.G",b(){e.G()});e.$p.A("h.12",b(t,n){e.6.J=n;e.12();e.2j="12"});e.$p.A("h.T",b(){e.T();e.2j="T"})},2b:b(){9 e=c;7(e.6.2b===j&&e.1g!==j&&e.6.J!==d){e.$p.A("4A",b(){e.T()});e.$p.A("4B",b(){7(e.2j!=="T"){e.12()}})}},1H:b(){9 t=c;7(t.6.1H===d){q d}1A(9 n=0;n<t.E;n++){9 i=e(t.R[n]),s=i.z("h-1J"),o=i.Q(".4C"),u;7(i.z("h-1l")===r){o.3b();i.K("3P").z("h-1l","4F")}m 7(i.z("h-1l")==="1l"){4G}7(t.6.3Q===j){u=s>=t.k}m{u=j}7(u&&s<t.k+t.6.v){i.z("h-1l","1l");9 a=o.z("2L");7(a){o[0].2L=a;o.4J("z-2L")}o.4K(1m);i.13("3P")}}},1t:b(){b s(){i+=1;7(n.3S(0).34){o()}m 7(i<=4M){X(s,1m)}m{t.1G.C("2k","")}}b o(){9 n=e(t.R[t.k]).2k();t.1G.C("2k",n+"1j");7(!t.1G.1F("1t")){X(b(){t.1G.K("1t")},0)}}9 t=c;9 n=e(t.R[t.k]).Q("3i");7(n.3S(0)!==r){9 i=0;s()}m{o()}},29:b(){9 t=c;e(t.R).13("1M");1A(9 n=t.k;n<t.k+t.6.v;n++){e(t.R[n]).K("1M")}}};e.2l.1S=b(t){q c.1U(b(){9 n=2X.2r(i);n.3y(t,c);e.z(c,"1S",n)})};e.2l.1S.6={v:5,1w:[4O,4],1x:[4P,3],1D:[4Q,2],1C:[4R,1],3r:d,1a:1m,1s:4S,J:d,2b:d,17:j,1T:4T,1y:d,2c:["G","D"],1N:j,1E:d,1k:j,2u:d,2o:j,3q:1m,1I:"h-4U",26:"h-26",1H:d,3Q:j,1t:d,2h:d,2v:d,1L:j,1K:j,2H:d,2N:d,2F:d,2K:d,2R:d,2g:d,29:d}})(4V,4W,3Z)',62,308,'||||||options|if||var||function|this|false||||owl||true|currentSlide||else|||elem|return|||||items|0px|||data|on|maximumSlide|css|next|itemsAmount|owlControls|prev|div|newPosX|autoPlay|addClass|owlWrapper|class|itemWidth|typeof|transform|find|owlItems|ev_types|stop|null|disabled|transition|setTimeout|off|positionsInArray||playDirection|play|removeClass|apply|left|width|goToFirst|translate3d|newRelativeX|slideSpeed|clearInterval|target|paginationWrapper|page|wrapper|isTouch|ms|autoPlaySpeed|px|pagination|loaded|200|append|buttonPrev|support3d|buttonNext|preventDefault|paginationSpeed|autoHeight|goTo|css2slide|itemsDesktop|itemsDesktopSmall|navigation|isCss3Finish|for|transition3d|itemsMobile|itemsTablet|scrollPerPage|hasClass|wrapperOuter|lazyLoad|baseClass|item|touchDrag|mouseDrag|active|goToFirstNav|opacity|orignalItems|maximumPixels|swapTransitionSpeed|owlCarousel|goToFirstSpeed|each|sliding|addTransition|webkit|eachMoveUpdate|all||touchend|ease|moz|mouseup|roundPages|theme|html|checkVisible|addClassActive|isCssFinish|stopOnHover|navigationText|end|relativePos|updateControls|startDragging|jsonPath|newPosY|hoverStatus|height|fn|moveDirection|userItems|responsive|grabbing|move|create|targetElement|touchmove|paginationNumbers|jsonSuccess|checkPagination|is|visible|checkNavigation|watchVisibility|logIn|mousedown|event|animate|beforeMove|length|beforeInit|checkAp|originalEvent|afterMove|src|apStatus|afterInit|Number|click|updateItems|afterAction|updateVars|max|Math|pageX|offsetY|Object|offsetX|calculateAll|dragging|touches|outer|cssText|complete|css2move|gestures|disabledEvents|doTranslate|removeTransition|touchstart|hide|span|mousemove|touchcancel|start|updatePagination|buildButtons|img|buildPagination|min|loops|pageY|calculateWidth|appendWrapperSizes|appendItemsSizes|responsiveRefreshRate|singleItem|style|wrap|position|setInterval|reload|updatePosition|init|block|display|srcElement|moveEvents|response|buildControls|customEvents|getNewPosition|onStartup|disable|improveClosest|wrapItems|loadContent|right|eventTypes|checkTouch|loading|lazyFollow|in|get|string|prototype|duration|extend|createElement|push|document|match|new|ontouchstart|navigator|msMaxTouchPoints|resize|top|controls|toggleClass|clickable|clearTimeout|text|appendTo|5e3|500|returnValue|buttons|wrapAll|onstartup|children|stopImmediatePropagation|stopPropagation|_data|events|pop|splice|baseElWidth|minSwipe|maxSwipe|dargging|clearEvents|wrapperWidth|dragstart|getJSON|bind|disableTextSelect|mouseover|mouseout|lazyOwl|show|destroyControls|checked|continue|remove|round|removeAttr|fadeIn|clientX|50|clientY|1199|979|768|479|800|1e3|carousel|jQuery|window|numbers'.split('|'),0,{}))