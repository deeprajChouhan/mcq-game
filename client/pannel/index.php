<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Frames</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<link rel="apple-touch-icon" href="https://jaromvogel.com/images/frames_icons/frames_icon.png">
  
  
      <link rel="stylesheet" href="css/style.css">

  
</head>

<body>

  <div class="app-container" ng-app="framesApp" ng-controller="framesCtrl as framesCtrl" ng-class="{'webapp-container': framesCtrl.webapp}">
	<div class="canvas">
		<div
			drawing-canvas
			class="frame"
			tool="framesCtrl.tool"
			color="framesCtrl.color"
			background="framesCtrl.background_color"
			width="framesCtrl.width"
			height="framesCtrl.height"
			scale="framesCtrl.scale"
			update-undo="framesCtrl.addStateToUndo(state, type)"
			clear-redo="framesCtrl.clearRedo()"
			ng-repeat="frame in framesCtrl.frames track by $index"
			ng-show="framesCtrl.isActiveFrame($index) || framesCtrl.isPreviousFrame($index)"
			ng-class="{
				'active-frame': framesCtrl.isActiveFrame($index),
				'active-frame-opaque': framesCtrl.playing || !framesCtrl.lightbox_active || framesCtrl.frames.length == 1,
			}">
		</div>
	</div>
	<div class="gesture-center" ng-show="framesCtrl.gesture_active" style="
		left: {{framesCtrl.gesture_position.x}}px;
		top:{{framesCtrl.gesture_position.y}}px;
	"></div>
	<div class="back-button" ng-click="framesCtrl.exportAsGif()">
		<img src="https://jaromvogel.com/images/frames_icons/arrow-left.svg"/>
	</div>
	<div class="zoom-in" ng-click="framesCtrl.zoomIn()">
		<img src="https://jaromvogel.com/images/frames_icons/plus-icon.svg"/>		
	</div>
	<div class="zoom-out" ng-click="framesCtrl.zoomOut()">
		<img src="https://jaromvogel.com/images/frames_icons/minus-icon.svg"/>		
	</div>
	<div class="settings">
		<div class="settings-icon" ng-click="framesCtrl.toggleSettings()">
			<img src="https://jaromvogel.com/images/frames_icons/settings.svg" />
		</div>
		<div class="settings-container" ng-class="{'settings-container-active': framesCtrl.settings_active}">
			<div class="settings-row">
				<span>Frame Rate</span>
				<div class="framerate-control-container">
					<div class="framerate-button decrease-frame-rate" ng-click="framesCtrl.decreaseFrameRate()">
						<img src="https://jaromvogel.com/images/frames_icons/minus-icon.svg"/>
					</div>
					<div class="current-frame-rate">{{ 1 / (framesCtrl.frameduration / 1000) }} fps</div>
					<div class="framerate-button increase-frame-rate" ng-click="framesCtrl.increaseFrameRate()">
						<img src="https://jaromvogel.com/images/frames_icons/plus-icon.svg"/>
					</div>
				</div>
			</div>
			<div class="settings-row">
				Aspect Ratio
			</div>
			<div class="settings-row">
				Background Color
			</div>
			<div class="settings-row">
				Loop
			</div>
		</div>
	</div>
	<div class="playback-controls">
		<div class="buttons-container">
			<div class="playback-button" ng-click="framesCtrl.previousFrame()">
				<img src="https://jaromvogel.com/images/frames_icons/arrow-left.svg" />
			</div>
			<div class="playback-button" ng-click="framesCtrl.nextFrame()">
				<img src="https://jaromvogel.com/images/frames_icons/arrow-right.svg" />
			</div>
		</div>
		<div class="scrubbing-container">
			<div class="scrubbing-section" ng-repeat="line in framesCtrl.scrub_lines track by $index">
				<div class="major-line">
				</div>
			</div>
		</div>
		<div class="buttons-container">
			<div class="playback-button" ng-click="framesCtrl.play()" ng-show="!framesCtrl.playing">
				<img src="https://jaromvogel.com/images/frames_icons/play-button.svg" />
			</div>
			<div class="playback-button" ng-click="framesCtrl.pause()" ng-show="framesCtrl.playing">
				<img src="https://jaromvogel.com/images/frames_icons/pause-button.svg" />				
			</div>
			<div class="playback-button" ng-click="framesCtrl.addFrame()">
				<img src="https://jaromvogel.com/images/frames_icons/plus-icon.svg" />
			</div>
		</div>
	</div>
	<div class="drawing-controls">
		<div class="tool" ng-repeat="tool in framesCtrl.tools" ng-click="framesCtrl.selectTool(tool)">
			<img ng-show="!tool.active" ng-src="{{tool.icon}}" />
			<img ng-show="tool.active" ng-src="{{tool.icon_white}}"/>
		</div>
		<div class="tool color-tool">
			<div class="current-color"
				 style="background-color: hsl({{ framesCtrl.color.h }},{{ framesCtrl.color.s }}%,{{ framesCtrl.color.l }}%);"
				 ng-click="framesCtrl.toggleColorPicker()">
			</div>
			<div
				 color-picker
				 position="left"
				 control="framesCtrl.color"
				 ng-show="framesCtrl.pick_color">
			</div>
		</div>
		<div class="tool" ng-click="framesCtrl.toggleLightbox()">
			<img ng-show="framesCtrl.lightbox_active" src="https://jaromvogel.com/images/frames_icons/lightbulb_white.svg" />
			<img ng-show="!framesCtrl.lightbox_active" src="https://jaromvogel.com/images/frames_icons/lightbulb.svg" />
		</div>
		<div class="tool undo-button" ng-click="framesCtrl.undo()" ng-class="{'undo-disabled': framesCtrl.undostack.length === 0}">
			<img src="https://jaromvogel.com/images/frames_icons/undo-icon.svg" />
		</div>
		<div class="tool redo-button" ng-click="framesCtrl.redo()" ng-class="{'redo-disabled': framesCtrl.redostack.length === 0}">
			<img src="https://jaromvogel.com/images/frames_icons/redo-icon.svg" />
		</div>
	</div>
	<div class="gif-download-container" ng-show="framesCtrl.gifDownloadActive">
		<div class="gif-download-bg" ng-click="framesCtrl.dismissGifDownload()"></div>
		<div class="gif-container"></div>
		<canvas class="buffer-canvas"></canvas>
	</div>
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.14/angular.min.js'></script>
<script src='https://jaromvogel.com:9001/js/jquery.pressure.js'></script>
<script src='https://jaromvogel.com:9000/js/lib/fastclick.js'></script>
<script src='https://jaromvogel.com/js/lib/drawing.js'></script>
<script src='https://jaromvogel.com/js/lib/gifshot.min.js'></script>

  

    <script  src="js/index.js"></script>




</body>

</html>
