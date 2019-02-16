var vertexHeight = 15000,
  planeDefinition = 100,
  planeSize = 1245000,
  totalObjects = 100000,
  background = "#73b2ce",//0x555555,
  meshColor = "#006fa2";//0x000000;

var container = document.createElement('div');
document.body.appendChild( container );


var camera = new THREE.PerspectiveCamera(55, window.innerWidth / window.innerHeight,1, 400000)
camera.position.z = 550000;
camera.position.y =10000;
camera.lookAt( new THREE.Vector3(0,6000,0) );


var scene = new THREE.Scene();
scene.fog = new THREE.Fog( background, 1, 300000 );

var	plane = new THREE.Mesh( new THREE.PlaneGeometry( planeSize, planeSize, planeDefinition, planeDefinition ), new THREE.MeshBasicMaterial( { color: meshColor, wireframe: false } ) );
plane.rotation.x -=Math.PI*.5;

scene.add( plane );


var geometry = new THREE.Geometry();
for (i = 0; i < totalObjects; i ++) 
{ 
  var vertex = new THREE.Vector3();
  vertex.x = Math.random()*planeSize-(planeSize*.5);
  vertex.y = Math.random()*100000;
  vertex.z = Math.random()*planeSize-(planeSize*.5);
  geometry.vertices.push( vertex );
}


var material = new THREE.ParticleBasicMaterial( { size: 200 });

var renderer = new THREE.WebGLRenderer();
renderer.setSize(window.innerWidth, window.innerHeight);
renderer.setClearColor(background, 1);
container.appendChild( renderer.domElement );


updatePlane();
function updatePlane() { 
  for (var i = 0; i < plane.geometry.vertices.length; i++) 
  { 
    plane.geometry.vertices[i].z += Math.random()*vertexHeight -vertexHeight; 
  } 
};

render();
function render() {
  requestAnimationFrame( render );
  camera.position.z -= 150;
  renderer.render( scene, camera );
}