import { Vec3, Vectors } from "./Vectors";
import { Shader } from "./Shader";
import { Mat4 } from "./Matrices";

export class Object3d{
    /**@type {(position: Vec3, scale: Vec3, rotationAngle: number, rotationAxis: Vec3) => void} */
    constructor(position, scale = new Vec3(1, 1, 1), angle = 0, axis = new Vec3(0, 1, 0)){
        this.position = position;
        this.scale = scale;
        this.rotationAngle = angle;
        this.rotationAxis = axis;
        this.model = Mat4.identity();
    }
    
    /**@type {() => void} */
    update(){
        let t = Mat4.translate(this.position.x, this.position.y, this.position.z);
        let r = Mat4.rotate(this.axis, this.angle);
        let s = Mat4.scale(this.scale.x, this.scale.y, this.scale.z);
        this.model = Mat4.multiply(Mat4.multiply(t, r), s);
    }
    
    /** @type {(shader: Shader) => void} */
    sendToShader(shader){
        shader.setMat4("model", this.model);
    }
}