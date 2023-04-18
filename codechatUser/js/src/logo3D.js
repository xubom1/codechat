import { Camera } from "./renderer3d/Camera";
import { Mat4 } from "./renderer3d/Matrices";
import { Shader } from "./renderer3d/Shader";
import { Model } from "./renderer3d/Model";
import { Texture } from "./renderer3d/Texture";

let angle = Math.PI * .5;

window.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementsByClassName('logo3D')[0];

    function rot(){
        angle += Math.PI * 2;
    }

    canvas.onmouseover = rot;

    window.onkeydown = rot;

    if (!canvas) {
        throw '\ndid not find any canvas for logo3D !';
    }

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

    //shader
    /** @type {Shader} */
    let shader = new Shader(gl, "vertexShader", "fragmentShader");
    shader.use();

    //camera
    /** @type {Camera} */
    let camera = new Camera([0, 0, 3], 0, 0, canvas.width / canvas.height,  Math.PI * .5, .1, 100);

    //model
    /** @type {Model} */
    const model1 = new Model(gl, '../../assets/logo.obj');

    //texture
    const image = new Texture(gl, '../../assets/codechat.jpg');
    image.bind();

    

    function anim(){
        if (angle > 0){
            angle *= .98;
        }

        //render
        gl.viewport(0, 0, canvas.width, canvas.height);
        gl.clearColor(0,0,0,0);
        gl.clear(gl.COLOR_BUFFER_BIT | gl.DEPTH_BUFFER_BIT);

        const t = Mat4.translate(0, 0, -20);
        const r = Mat4.rotate([0, 1, 0], Math.PI * .5 + angle);
        const s = Mat4.identity(43);

        let model = Mat4.multiply(Mat4.multiply(t, r), s);
        
        shader.setMat4("model", model);

        canvas.width = canvas.clientWidth * 2;
        canvas.height = canvas.clientHeight * 2;

        camera.aspect = canvas.width / canvas.height;
        camera.update();
        camera.sendToShader(shader);

        model1.draw(shader);

        requestAnimationFrame(anim);
    }

    anim();
});