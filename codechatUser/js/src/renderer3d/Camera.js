import { Object3d } from "./Object3d";
import { Vectors } from "./Vectors";  
import { Mat4 } from "./Matrices";
import { Shader } from "./Shader";

function projeter3D(largeur, hauteur, profondeur) {
    // Note: cette matrice inverse aussi l'axe Y qui regarde vers le bas
    return [
       2 / largeur, 0, 0, 0,
       0, -2 / hauteur, 0, 0,
       0, 0, 2 / profondeur, 0,
      -1, 1, 0, 1,
    ];
  }

export class Camera extends Object3d{
    /**@type {(position: array, yaw: number, pitch: number, aspect: number, fov: number, zNear: number, zFar: number) => void} */
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
        
        //this.projection = projeter3D(700 * this.aspect, 700, 400);
        
    }

    /**@type {(shader: Shader) => void} */
    sendToShader(shader){
        shader.setMat4("projection", this.projection);
        shader.setMat4("view", this.view);
    }
}