import { Camera } from "./renderer3d/Camera";
import { Mat4 } from "./renderer3d/Matrices";
import { Shader } from "./renderer3d/Shader";
import { Model } from "./renderer3d/Model";
import { Texture } from "./renderer3d/Texture";
import { Vectors } from "./renderer3d/Vectors";

const canvas = document.getElementsByTagName('canvas')[0];
canvas.width = canvas.clientWidth;
canvas.height = canvas.clientHeight;

/** @type {WebGLRenderingContext} */
const gl = canvas.getContext("webgl");

if (!gl){
    console.error("failed to load webgl, it is possible that your browser do not support it !");
}

gl.enable(gl.DEPTH_TEST);
gl.depthFunc(gl.LESS);
gl.enable(gl.CULL_FACE);
//gl.cullFace(gl.FRONT);

//shader
/** @type {Shader} */
let shader = new Shader(gl, "vertexShader", "fragmentShader");
shader.use();

//camera
/** @type {Camera} */
let camera = new Camera([0, 0, 3], 0, 0, canvas.width / canvas.height,  Math.PI * .5, .1, 100);
camera.sendToShader(shader);

//model
/** @type {Model} */
const model1 = new Model(gl, '../../assets/logo.obj');

//texture
const image = new Texture(gl, '../../assets/codechat.jpg');

let pos = [5,0,-5];
let speed = [-.05,2,-.25];
let acc = [0,0,0];
const g = [0,-9.81,0];

let rotSpeed = .7;
let rotAngle = 0; 

const floorY = -20;

function anim(){
    if (model1.mesh) {

        //animation
        acc = Vectors.add(g, Vectors.multiply(speed, -.5));
        speed = Vectors.add(speed, Vectors.multiply(acc, .01)); //accelleration
        pos = Vectors.add(pos, speed);  //speed

        rotSpeed *= .995;
        rotAngle += rotSpeed;
        
        if (pos[1] < floorY){
            pos[1] = floorY;
            speed[1] *= -.95;
        }
        

        //render
        gl.viewport(0, 0, canvas.width, canvas.height);
        gl.clearColor(0,0,0,0);
        gl.clear(gl.COLOR_BUFFER_BIT | gl.DEPTH_BUFFER_BIT);

        const t = Mat4.translate(pos[0], pos[1], pos[2]); //
        //const t = Mat4.translate(500, 350, -0); //
        const r = Mat4.rotate([0, 1, 0], rotAngle);
        const s = Mat4.identity(25);

        let model = Mat4.multiply(Mat4.multiply(t, r), s);
        
        shader.setMat4("model", model);

        canvas.width = canvas.clientWidth;
        canvas.height = canvas.clientHeight;

        camera.aspect = canvas.width / canvas.height;
        camera.update();
        camera.sendToShader(shader);

        model1.draw(shader);
    }

    requestAnimationFrame(anim);
}

anim();