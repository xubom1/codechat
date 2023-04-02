export class Shader{
    /** 
     * @type {(gl: WebGLRenderingContext, vertexShaderId : string, fragmentShaderId : string) => void}
    */
    constructor(gl, vertexShaderId, fragmentShaderId){

        /**@type {WebGLRenderingContext} */
        this.gl = gl;
        
        let vertexShaderSource = document.getElementById(vertexShaderId).text;
        let fragmentShaderSource = document.getElementById(fragmentShaderId).text;

        //vertex shader
        let vertexShader = gl.createShader(gl.VERTEX_SHADER);
        gl.shaderSource(vertexShader, vertexShaderSource);
        gl.compileShader(vertexShader);

        if (!gl.getShaderParameter(vertexShader, gl.COMPILE_STATUS)) {
        const info = gl.getShaderInfoLog(vertexShader);
        throw `Could not compile WebGL program. \n\n${info}`;
        }

        //fragment shader
        let fragmentShader = gl.createShader(gl.FRAGMENT_SHADER);
        gl.shaderSource(fragmentShader, fragmentShaderSource);
        gl.compileShader(fragmentShader);

        if (!gl.getShaderParameter(fragmentShader, gl.COMPILE_STATUS)) {
        const info = gl.getShaderInfoLog(fragmentShader);
        throw `Could not compile WebGL program. \n\n${info}`;
        }

        //program
        this.program = gl.createProgram();
        gl.attachShader(this.program, vertexShader);
        gl.attachShader(this.program, fragmentShader);
        gl.linkProgram(this.program);

        if (!gl.getProgramParameter(this.program, gl.LINK_STATUS)) {
            const info = gl.getProgramInfoLog(this.program);
            throw `Could not compile WebGL program. \n\n${info}`;
        }
    }

    /**@type {() => void}*/
    use(){
        this.gl.useProgram(this.program);
    }

    /**@type {(name: string) => number} */
    getAttribLocation(name){
        return this.gl.getAttribLocation(this.program, name);
    }

    /**@type {(name: string, value: any) => void} */
    set(name, value){
        this.use();
        if (typeof(value) == "number"){
            this.setFloat(name, value);
        }
        else if (typeof(value) == "boolean"){
            this.setInt(name, value);
        }
        else {
            console.error(`the type: ${typeof(value)} , is not supported by shader.set() ! `);
        }
    }

    /**@type {(name: string, value: number) => void} */
    setFloat(name, value){
        this.use();
        this.gl.uniform1f(this.gl.getUniformLocation(this.program, name), value);
    }

    /**@type {(name: string, value: number) => void} */
    setInt(name, value){
        this.use();
        this.gl.uniform1i(this.gl.getUniformLocation(this.program, name), value);
    }

    /**@type {(name: string, value: boolean) => void} */
    setBool(name, value){
        this.use();
        this.setInt(name, value);
    }

    /**@type {(name: string, mat: Array) => void} */
    setMat4(name, mat){
        this.use();
        this.gl.uniformMatrix4fv(this.gl.getUniformLocation(this.program, name), false, mat);
    }
}

