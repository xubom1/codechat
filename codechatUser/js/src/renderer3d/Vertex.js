import { Vec3 } from "./Vectors";

export class Vertex{
    constructor(position, uv = [0, 0], normal = [0, 1, 0]){
        this.position = position;
        this.uv = uv;
        this.normal = normal;
    }

    /** @type { () => array} */
    toArray(){
        return Object.entries(this).map((tmp) => (tmp[1])).reduce((prev, curr) => (prev.concat(curr)));
    }
}