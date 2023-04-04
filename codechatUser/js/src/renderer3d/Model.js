import { Mesh } from "./Mesh";
import { Utils } from "./Utils";
import { Vertex } from "./Vertex";

export class Model{

    /**@type { (gl: WebGLRenderingContext, filepath: string) => void} */
    constructor(gl, filepath){
        //save webgl context
        this.gl = gl;

        //buffer
        const vertices = [];
        const model = this;

        //read obj file
        let file = Utils.readFile(filepath);
        file.then(function(text){
            /** @type {Array<String>} */
            const lines = text.split('\n');

            const posLines = Utils.parseObjSearchKeywordInLine(lines, 'v');
            const normLines = Utils.parseObjSearchKeywordInLine(lines, 'vn');
            const uvLines = Utils.parseObjSearchKeywordInLine(lines, 'vt');
            const faceLines = Utils.parseObjSearchKeywordInLine(lines, 'f');
            
            //read positions
            const positions = [];
            Utils.parseObjParseLinesOfloats(posLines, positions);
            
            //read normals
            const normals = [];
            Utils.parseObjParseLinesOfloats(normLines, normals);
            
            //read uvs
            const uvs = [];
            Utils.parseObjParseLinesOfloats(uvLines, uvs);

            //fill vertices
            faceLines.forEach(function(line){
                let triangles = line.split(' ').filter(w => w.includes('/'));
                if (triangles.length !== 3) console.warn('file : ', filepath, ' has faces that aren\'t triangles !');

                triangles = triangles.map(function(inputVertex) {
                    const vertexIndices = inputVertex.split('/').map(index => parseInt(index))
                    vertices.push(new Vertex(
                        positions[vertexIndices[0] - 1],
                        uvs[vertexIndices[1] - 1],
                        normals[vertexIndices[2] - 1],
                    ));
                });
            });

            //create mesh
            model.mesh = new Mesh(gl, vertices);
        });
    }

    /**@type { (Shader: shader) => void} */
    draw(shader){
        if (this.mesh)
            this.mesh.draw(shader);
    }
}