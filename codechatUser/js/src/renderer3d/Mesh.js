import {Vertex} from "./Vertex";

export class Mesh{
    /**@type {(gl: WebGLRenderingContext, vertices: Array<Vertex>, indices: Array<Vertex>) => void} */
    constructor(gl, vertices, indices = []){
        //console.log(vertices);

        //save gl context
        this.gl = gl;
        
        //create a float32 vertex buffer
        let buf = [];
        vertices.map((vertex) => buf = buf.concat(vertex.toArray()));
        buf = new Float32Array(buf);

        this.vertexBuffer = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, this.vertexBuffer);
        gl.bufferData(gl.ARRAY_BUFFER, buf, gl.STATIC_DRAW);

        //indices checks
        if (indices.length % 3) console.warn('Mesh indices count cant be divided by 3 !');
        this.indexed = Boolean(indices.length);
        if (this.indexed)
            this.verticesCount = indices.length;
        else 
            this.verticesCount = vertices.length;

        if (this.indexed){
            //create an int16 indices buffer
            this.IndexBuffer = gl.createBuffer();
            gl.bindBuffer(gl.ELEMENT_ARRAY_BUFFER, this.IndexBuffer);
            gl.bufferData(gl.ELEMENT_ARRAY_BUFFER, new Uint16Array(indices), gl.STATIC_DRAW);
        }
    }

    /**@type {(Shader: shader)=> void}*/
    draw(shader){
        const posAttribLocation = shader.getAttribLocation("position");
        const uvAttribLocation = shader.getAttribLocation("uv");
        const normAttribLocation = shader.getAttribLocation("normal");

        //bind vertex buffer
        this.gl.bindBuffer(this.gl.ARRAY_BUFFER, this.vertexBuffer);

        const sizeOfFloat = 4;
        const stride = (3 + 2 + 3) * sizeOfFloat;

        this.gl.enableVertexAttribArray(posAttribLocation);
        this.gl.vertexAttribPointer(posAttribLocation, 3, this.gl.FLOAT, false, stride, 0 * sizeOfFloat);

        this.gl.enableVertexAttribArray(uvAttribLocation);
        this.gl.vertexAttribPointer(uvAttribLocation, 2, this.gl.FLOAT, false, stride, 3 * sizeOfFloat);

        this.gl.enableVertexAttribArray(normAttribLocation);
        this.gl.vertexAttribPointer(normAttribLocation, 3, this.gl.FLOAT, false, stride, 5 * sizeOfFloat);

        shader.use();
        //bind indices buffer
        if (this.indexed){
            this.gl.bindBuffer(this.gl.ELEMENT_ARRAY_BUFFER, this.IndexBuffer);

            //draw call
            this.gl.drawElements(this.gl.TRIANGLES, this.verticesCount, this.gl.UNSIGNED_SHORT, 0);
        }
        else{
            this.gl.drawArrays(this.gl.TRIANGLES, 0, this.verticesCount);
        }
    }
};

