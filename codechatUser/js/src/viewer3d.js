import { Camera } from "./renderer3d/Camera";
import { Mat4 } from "./renderer3d/Matrices";
import { Shader } from "./renderer3d/Shader";
import { Vec3, Vectors, Vec4 } from "./renderer3d/Vectors";

const canvas = document.getElementsByTagName('canvas')[0];
canvas.width = 800;
canvas.height = 550;

/** @type {WebGLRenderingContext} */
const gl = canvas.getContext("webgl");

if (!gl){
    console.error("failed to load webgl, it is possible that your browser do not support it !");
}

//shader
/** @type {Shader} */
let shader = new Shader(gl, "vertexShader", "fragmentShader");
shader.use();

//camera
/** @type {Camera} */
let camera = new Camera(new Vec3(6, 0, 3), 0, 0, 16/9, 80);
camera.sendToShader(shader);

//
let vertices = new Float32Array([
    0, 0, 0, 
    1, 0, 0,
    0, 1, 0, 
    1, 0, 0,
    0, 1, 0, 
    1, 1, 0
]);

//initialization
let buffer = gl.createBuffer();
gl.bindBuffer(gl.ARRAY_BUFFER, buffer);
gl.bufferData(gl.ARRAY_BUFFER, vertices, gl.STATIC_DRAW);

var posAttribLocation = shader.getAttribLocation("position");

gl.enableVertexAttribArray(posAttribLocation);
gl.vertexAttribPointer(posAttribLocation, 3, gl.FLOAT, false, 12, 0);


function anim(){
    requestAnimationFrame(anim);

    camera.update();
    camera.sendToShader(shader);

    const t = Mat4.translate(.1, 0, .3); //Date.now() / 600
    const r = Mat4.rotate([0, 0, 1], Math.PI / 2);
    const s = Mat4.identity(5.5);

    let model = Mat4.multiply(Mat4.multiply(t, r), s);
    model = Mat4.identity(2);
    shader.setMat4("model", model);

    gl.clearColor(.7, 1, 1, 1);
    gl.clear(gl.COLOR_BUFFER_BIT | gl.DEPTH_BUFFER_BIT);
    gl.drawArrays(gl.TRIANGLES, 0, 6);
}

anim();

window.onkeydown = function(event){
    const speed = .5;
    if (event.code === 'KeyW'){
        camera.position = Vectors.add(camera.position, Vectors.multiply([1, 0, 0], speed));
        console.log(camera.position);
    }
    if (event.code === 'KeyS'){
        camera.position = Vectors.add(camera.position, Vectors.multiply([1, 0, 0], -speed));
        console.log(camera.position);
    }
    if (event.code === 'KeyA'){
        camera.position = Vectors.add(camera.position, Vectors.multiply([0, 0, 1], speed));
        console.log(camera.position);
    }
    if (event.code === 'KeyD'){
        camera.position = Vectors.add(camera.position, Vectors.multiply([0, 0, 1], -speed));
        console.log(camera.position);
    }
    if (event.code === 'Space'){
        camera.position = Vectors.add(camera.position, Vectors.multiply([0, 1, 0], speed));
        console.log(camera.position);
    }
    if (event.code === 'ControlLeft'){
        camera.position = Vectors.add(camera.position, Vectors.multiply([0, 1, 0], -speed));
        console.log(camera.position);
    }
}