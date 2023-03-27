import { Object3d } from "./Object3d";
import { Vec3, Vectors } from "./Vectors";  
import { Mat4 } from "./Matrices";
import { Shader } from "./Shader";

export class Camera extends Object3d{
    /**@type {(position: Vec3, yaw: number, pitch: number, aspect: number, fov: number, zNear: number, zFar: number) => void} */
    constructor(position, yaw, pitch, aspect, fov = Math.PI / 2, zNear = .1, zFar = 100){
        super(position);
        this.yaw = yaw;
        this.pitch = pitch;
        this.aspect = aspect;
        this.fov = fov;
        this.zNear = zNear;
        this.zFar = zFar;

        this.update();
    }

    update(){
        let direction = [
            Math.cos(this.pitch) * Math.sin(this.yaw),
            Math.sin(this.pitch),
            Math.cos(this.pitch) * Math.cos(this.yaw)
        ];
        
        direction = Vectors.multiply(this.position, -1);

        this.projection = Mat4.projection(this.aspect, this.fov, this.zNear, this.zFar);
        this.view = Mat4.view(this.position, Vectors.add(this.position, direction), [0, 1, 0]);
        this.projection = perspective(Math.PI / 2, 16/9, .1, 200);

        //this.view = Mat4.view([34, 3, 3], [0, 0, 0], [0, 1, 0]);
    }

    /**@type {(shader: Shader) => void} */
    sendToShader(shader){
        shader.setMat4("projection", this.projection);
        shader.setMat4("view", this.view);
    }
}