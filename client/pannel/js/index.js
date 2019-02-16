var app = angular.module('framesApp', ['drawingTools']);

app.controller('framesCtrl', function ($scope, $window) {

	var framesCtrl = this;
	
	// Add padding to top if this is being run as an iOS web app
    var checkWebApp = function () {
    	if (window.navigator.standalone && window.innerWidth < window.innerHeight) {
    		framesCtrl.webapp = true;
            framesCtrl.offset_top = 20;
    	} else {
    		framesCtrl.webapp = false;
            framesCtrl.offset_top = 0;
    	}
    };
    checkWebApp();
    angular.element($window).bind('resize', function() {
        window.setTimeout(function() {
            checkWebApp();
            $scope.$apply();
        }, 0);
    });

	framesCtrl.background_color = "wheat";
	
	framesCtrl.width = 500;
	framesCtrl.height = 500;
	
	framesCtrl.scrub_lines = new Array(10);

	framesCtrl.toggleSettings = function () {
		framesCtrl.settings_active = !framesCtrl.settings_active;	
	};
	
	framesCtrl.tools = [
		{
			'name': 'pencil',
			'icon': 'https://jaromvogel.com:9001/images/move_icons/Pencil.svg',
			'icon_white': 'https://jaromvogel.com:9001/images/move_icons/Pencil_white.svg',
			'brush_src': 'https://jaromvogel.com:9001/images/PencilBrush.png',
			'line_width': 5,
			'opacity': 1,
			'width_range': [2,12],
		}, {
			'name': 'pen',
			'icon': 'https://jaromvogel.com:9001/images/move_icons/Pen.svg',
			'icon_white': 'https://jaromvogel.com:9001/images/move_icons/Pen_white.svg',
			'line_width': 2,
			'opacity': 1,
			'width_range': [2,100],
		}, {
			'name': 'shape_pencil',
			'icon': 'https://jaromvogel.com:9001/images/move_icons/Shape_pencil.svg',
			'icon_white': 'https://jaromvogel.com:9001/images/move_icons/Shape_pencil_white.svg',
			'line_width': 2,
			'opacity': 1,
		}, {
			'name': 'eraser',
			'icon': 'https://jaromvogel.com:9001/images/move_icons/Eraser.svg',
			'icon_white': 'https://jaromvogel.com:9001/images/move_icons/Eraser_white.svg',
			'line_width': 30,
			'opacity': 1,
			'width_range': [1,100],
		}
	];
	
	framesCtrl.setBrush = function () {
		if (framesCtrl.tool.brush_src) {
			var brush = new Image();
			brush.crossOrigin = "Anonymous";
			brush.onload = function () {
				framesCtrl.tool.brush = brush;
			}
			brush.src = framesCtrl.tool.brush_src;
		}
	};
		
	framesCtrl.selectTool = function (tool) {
		if (tool.active && tool.name == 'eraser') {
			framesCtrl.clearCanvas();
		}
		framesCtrl.tools.forEach(function (item) {
			item.active = false;
		});
		framesCtrl.tool = tool;
		framesCtrl.setBrush();
		tool.active = true;
	};

	framesCtrl.selectTool(framesCtrl.tools[0]);
	
	framesCtrl.color = {
		h: 14,
		s: 100,
		l: 62,
	};
	
	framesCtrl.pick_color = false;
	
	framesCtrl.toggleColorPicker = function () {
		framesCtrl.pick_color = !framesCtrl.pick_color;
	};
	
	framesCtrl.opacity_range = [0,1];
	
	framesCtrl.clearCanvas = function () {
		// Get Base Canvas
		var canvas = angular.element('.base-canvas');
		// Get the drawing context
		var context = canvas[framesCtrl.active_frame].getContext('2d');
		// Clear the canvas
		context.clearRect(0, 0, canvas.width(), canvas.height());
	};
	
	framesCtrl.lightbox_active = true;
	
	framesCtrl.toggleLightbox = function () {
		framesCtrl.lightbox_active = !framesCtrl.lightbox_active;	
	};
	
	framesCtrl.frames = [null];
	
	framesCtrl.active_frame = 0;
	
	framesCtrl.nextFrame = function () {
		framesCtrl.active_frame ++;
		if (framesCtrl.active_frame > framesCtrl.frames.length - 1) {
			framesCtrl.active_frame = 0;
		}
	};
	
	framesCtrl.previousFrame = function () {
		framesCtrl.active_frame --;
		if (framesCtrl.active_frame < 0) {
			framesCtrl.active_frame = framesCtrl.frames.length - 1;
		}
	};
	
	framesCtrl.isActiveFrame = function (index) {
		return index == framesCtrl.active_frame;
	};
	
	framesCtrl.loop = true;
	
	framesCtrl.isPreviousFrame = function (index) {
		// Lightbox last frame under first frame if looping is true
		if (framesCtrl.active_frame === 0 && framesCtrl.loop) {
			return index == framesCtrl.frames.length - 1;
		}
		return index == framesCtrl.active_frame - 1;
	};
	
	framesCtrl.addFrame = function () {
		framesCtrl.frames.push(null);
		framesCtrl.nextFrame();
		var added_frame = framesCtrl.active_frame;
		framesCtrl.addStateToUndo(added_frame, 'newframe');
	};
	
	framesCtrl.deleteFrame = function () {
		framesCtrl.frames.splice(framesCtrl.active_frame, 1);	
	};
	
	framesCtrl.framerate = 5;
	framesCtrl.updateFrameDuration = function () {
		framesCtrl.frameduration = (1 / framesCtrl.framerate) * 1000;
	};
	framesCtrl.updateFrameDuration();
	framesCtrl.increaseFrameRate = function () {
		if (framesCtrl.framerate < 30) {
			framesCtrl.framerate += 1;
		}
		framesCtrl.updateFrameDuration();
	};
	framesCtrl.decreaseFrameRate = function () {
		if (framesCtrl.framerate > 1) {
			framesCtrl.framerate -= 1;
		}		
		framesCtrl.updateFrameDuration();
	};
	
	framesCtrl.play = function () {
		framesCtrl.playing = true;
		framesCtrl.playback = setInterval (function () {
			framesCtrl.nextFrame();
			$scope.$apply();
		}, framesCtrl.frameduration);
	};

	framesCtrl.pause = function () {
		framesCtrl.playing = false;
		clearInterval(framesCtrl.playback);
	};
	
	var getXPosition = function (event) {
		var position = null;
		if (event.type == 'mousemove' || event.type == 'mousedown' || event.type == 'mouseup') {
			position = event.pageX;
		} else if (event.type == 'touchmove' || event.type == 'touchdown' || event.type == 'touchend') {
			position = event.originalEvent.touches[0].pageX;
		}
		return position;
	};
	
	var scrubbar = angular.element('.scrubbing-container');
	
	scrubbar.on('mousedown touchstart', function (event) {
		event.preventDefault();
		framesCtrl.scrubbing = true;
		framesCtrl.scrub_initial = getXPosition(event);
	});
	
	$(document).on('touchstart', function (event) {
		if (event.originalEvent.touches.length == 2) {
			framesCtrl.undogesture = true;
		} else if (event.originalEvent.touches.length == 3) {
			framesCtrl.redogesture = true;
		}
	});
	
	$(document).on('mousemove touchmove', function (event) {
		if (framesCtrl.scrubbing === true) {
			event.preventDefault();
			framesCtrl.lightbox_active = false;
			framesCtrl.scrub_final = getXPosition(event);
			if (framesCtrl.scrub_final - framesCtrl.scrub_initial > 15) {
				framesCtrl.scrub_initial = framesCtrl.scrub_final;
				framesCtrl.nextFrame();
				$scope.$apply();
			} else if (framesCtrl.scrub_final - framesCtrl.scrub_initial < -15) {
				framesCtrl.scrub_initial = framesCtrl.scrub_final;
				framesCtrl.previousFrame();
				$scope.$apply();
			}
		}
	});
	
	$(document).on('mouseup touchend', function (event) {
		if (event.type == 'touchend' && framesCtrl.undogesture === true) {
			framesCtrl.undo();
			framesCtrl.undogesture = false;
		} else if (event.type == 'touchend' && framesCtrl.redogesture === true) {
			console.log('should redo');
			framesCtrl.redo();
			framesCtrl.redogesture = false;
		}
		if (framesCtrl.scrubbing === true) {
			framesCtrl.scrubbing = false;
			framesCtrl.lightbox_active = true;
			$scope.$apply();
		}
	});
	
	function Point (x, y) {
		this.x = x;
		this.y = y;
	}

	var getScaledCanvasPosition = function (position) {
		var scaled_position = position;
		scaled_position.x = scaled_position.x / framesCtrl.scale;
		scaled_position.y = scaled_position.y / framesCtrl.scale;
		return scaled_position;
	};
	
	// Returns position in canvas for touch or mouse events
	var getCanvasPosition = function (position) {
		var base_canvas = angular.element('.canvas');
		var offsetx = base_canvas.offset().left;
		var offsety = base_canvas.offset().top;
		var newposition = new Point();
		newposition.x = position.x - offsetx;
		newposition.y = position.y - offsety;
		if (framesCtrl.scale !== 1) {
			newposition = getScaledCanvasPosition(newposition);
		}
		return newposition;
	};

	framesCtrl.offsetTransform = function () {
		var width_initial = framesCtrl.width;
		var height_initial = framesCtrl.height;
		var transform = function(length) {
			var length_transformed = length * framesCtrl.scale;
			var padding = (length - length_transformed) / 2;
			var length_offset = padding * (framesCtrl.origin.x / (length / 2)) - padding;
			return length_offset;
		};
		var offset = new Point(
			transform(width_initial),
			transform(height_initial)
		);
		return offset;
	};
	
	// Transform Canvas Logic
	framesCtrl.scale = 1;
	framesCtrl.lastscale = 1;
	framesCtrl.rotation = 0;
	framesCtrl.lastrotation = 0;
	framesCtrl.translate = {
		initial: new Point(0,0),
		final:	 new Point(0,0),
		delta:	 new Point(0,0)
	};
	framesCtrl.last_translation = new Point(0,0);
	framesCtrl.makeTransform = function () {
		angular.element('.canvas').css({
			transform: 'translate(' + framesCtrl.translate.delta.x + 'px,' + framesCtrl.translate.delta.y + 'px) rotate(' + framesCtrl.rotation + 'deg) scale(' + framesCtrl.scale + ',' + framesCtrl.scale + ')',
		});
	};
	framesCtrl.zoomIn = function () {
		if (framesCtrl.scale < 5) {
			framesCtrl.scale += 0.1;
			framesCtrl.makeTransform();
		}
	};
	framesCtrl.zoomOut = function () {
		if (framesCtrl.scale > 0.5) {
			framesCtrl.scale -= 0.1;
			framesCtrl.makeTransform();
		}
	};

	angular.element($window).on('gesturestart', function(event) {
		framesCtrl.gesture_active = true;
		framesCtrl.translate.initial = {
			x: event.originalEvent.pageX,
			y: event.originalEvent.pageY
		};
		// need to get position within transformed canvas
		framesCtrl.origin = getCanvasPosition(framesCtrl.translate.initial);
		framesCtrl.offset = framesCtrl.offsetTransform();
	});
	// zoom / rotation for mobile with pinch
	angular.element($window).on('gesturechange', function(event) {
		framesCtrl.undogesture = false;
		framesCtrl.redogesture = false;
		var newscale = framesCtrl.lastscale * event.originalEvent.scale;
		if (newscale > 5) {
			newscale = 5;
		} else if (newscale < 0.5) {
			newscale = 0.5;
		}
		framesCtrl.scale = newscale;
		
		var newrotation = framesCtrl.lastrotation + event.originalEvent.rotation;
		if (newrotation > -5 && newrotation < 5) {
			newrotation = 0;
		}
		// uncomment when you can get the transformed point
		// framesCtrl.rotation = newrotation;

		framesCtrl.translate.final = {
			x: event.originalEvent.pageX,
			y: event.originalEvent.pageY
		};
		framesCtrl.translate.delta = {
			x: framesCtrl.translate.final.x - framesCtrl.translate.initial.x + framesCtrl.last_translation.x,
			y: framesCtrl.translate.final.y - framesCtrl.translate.initial.y + framesCtrl.last_translation.y
		};
		
		framesCtrl.makeTransform();
		framesCtrl.gesture_position = framesCtrl.translate.final;
		$scope.$apply();
	});
	angular.element($window).on('gestureend', function(event) {
		framesCtrl.gesture_active = false;
		framesCtrl.lastscale = framesCtrl.scale;
		framesCtrl.lastrotation = framesCtrl.rotation;
		framesCtrl.last_translation = {
			x: framesCtrl.translate.delta.x,
			y: framesCtrl.translate.delta.y
		};
		// framesCtrl.last_origin = framesCtrl.origin;
		$scope.$apply();
	});
	
	// Undo / Redo Logic (drawing states pushed from drawing.js)
	framesCtrl.undostack = [];
	framesCtrl.redostack = [];
	framesCtrl.addStateToUndo = function (state, type) {
		var undo_obj = {
			frame: framesCtrl.active_frame,
			type: type,
			state: state,
		};
		framesCtrl.undostack.push(undo_obj);
		if (type == 'drawing') {
			$scope.$apply();
		}
	};
	framesCtrl.undo = function () {
		if (framesCtrl.undostack.length > 0) {
			var undostate = framesCtrl.undostack.pop();
			if (undostate.type == 'drawing') {				
				var frame_canvas = angular.element('.base-canvas')[undostate.frame];
				var frame_context = frame_canvas.getContext('2d');
				// get current state and push to redostack before continuing
				var redo_obj = {
					frame: framesCtrl.active_frame,
					type: 'drawing',
					state: frame_canvas.toDataURL(),
				};
				framesCtrl.redostack.push(redo_obj);
				framesCtrl.active_frame = undostate.frame;
				frame_context.clearRect(0, 0, framesCtrl.width, framesCtrl.height);
				var image = new Image();
				image.onload = function () {
					frame_context.drawImage(image, 0, 0, framesCtrl.width, framesCtrl.height);
				};
				image.src = undostate.state;
			} else if (undostate.type == 'newframe') {
				framesCtrl.frames.splice(undostate.state, 1);
				framesCtrl.active_frame = undostate.state - 1;
				framesCtrl.redostack.push(undostate);
			}
		}
	};
	framesCtrl.redo = function () {
		if (framesCtrl.redostack.length > 0) {
			var redostate = framesCtrl.redostack.pop();
			if (redostate.type == 'drawing') {
				var frame_canvas = angular.element('.base-canvas')[redostate.frame];
				var frame_context = frame_canvas.getContext('2d');
				// get current state and push to undostack before continuing
				var undo_obj = {
					frame: framesCtrl.active_frame,
					type: 'drawing',
					state: frame_canvas.toDataURL(),
				};
				framesCtrl.undostack.push(undo_obj);
				framesCtrl.active_frame = redostate.frame;
				frame_context.clearRect(0, 0, framesCtrl.width, framesCtrl.height);
				var image = new Image();
				image.onload = function () {
					frame_context.drawImage(image, 0, 0, framesCtrl.width, framesCtrl.height);	
				};
				image.src = redostate.state;
			} else if (redostate.type == 'newframe') {
				framesCtrl.frames.splice(redostate.state, 0, null);
				framesCtrl.active_frame = redostate.state;
				framesCtrl.undostack.push(redostate);
			}
		}
	};
	framesCtrl.clearRedo = function () {
		framesCtrl.redostack = [];
	};
	
	// Create and Export GIF version
	framesCtrl.gifDownloadActive = false;
	
	framesCtrl.dismissGifDownload = function () {
		framesCtrl.gifDownloadActive = false;
	};
	
	framesCtrl.exportAsGif = function () {
		var buffercanvas = angular.element('.buffer-canvas');
		var bufferctx = buffercanvas[0].getContext('2d');
		buffercanvas.attr({
			width: framesCtrl.width * window.devicePixelRatio,
			height: framesCtrl.height * window.devicePixelRatio,
		});
		buffercanvas.css({
			height: framesCtrl.height + 'px',
			width: framesCtrl.width + 'px',
		});
		bufferctx.scale(
			window.devicePixelRatio,
			window.devicePixelRatio
		);
		var allframes = angular.element('.base-canvas');
		var imagelist = [];
		var drawFrame = function (index) {
			bufferctx.clearRect(0, 0, framesCtrl.width, framesCtrl.height);
			bufferctx.beginPath();
			bufferctx.rect(0, 0, framesCtrl.width, framesCtrl.height);
			bufferctx.fillStyle = framesCtrl.background_color;
			bufferctx.fill();
			bufferctx.drawImage(allframes[index], 0, 0);
			var image = new Image();
			image.crossOrigin = "Anonymous";
			image.onload = function () {
				imagelist.push(image);
				if (index < framesCtrl.frames.length - 1) {
					index += 1;
					drawFrame(index);
				} else if (index == framesCtrl.frames.length - 1 ) {
					framesCtrl.creategif(imagelist);
				}
			}
			image.src = bufferctx.canvas.toDataURL();				
		};
		drawFrame(0);
		framesCtrl.gifDownloadActive = true;
	};
	
	framesCtrl.creategif = function (imagelist) {
		gifshot.createGIF({
			'images': imagelist,
			'interval': '.' + framesCtrl.frameduration,
			'gifWidth': framesCtrl.width,
			'gifHeight': framesCtrl.height,
		},function(obj) {
			if(!obj.error) {
				var gifimage = obj.image,
				animatedImage = new Image();
				animatedImage.crossOrigin = "Anonymous";
				animatedImage.src = gifimage;
				var gif_box = angular.element('.gif-container');
				var previousgif = gif_box.find('img');
				previousgif.remove();
				gif_box.append(animatedImage);
				$scope.$apply();
			}
		});
	};
});

// Use 3rd party library to eliminate stupid 300 ms delay
app.run(function() {
    FastClick.attach(document.body);
});