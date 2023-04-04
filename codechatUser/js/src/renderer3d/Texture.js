export class Texture{
    constructor(gl, imagepath){
        this.gl = gl;
        this.id = gl.createTexture();
        gl.bindTexture(gl.TEXTURE_2D, this.id);
        
        // let's assume all images are not a power of 2
        gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_S, gl.CLAMP_TO_EDGE);
        gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_T, gl.CLAMP_TO_EDGE);
        gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR);

        
        this.width = 1;
        this.height = 1;
        this.img = new Image();

        const object = this;
        this.img.addEventListener('load', function() {
            object.width = object.img.width;
            object.height = object.img.height;
        
            object.gl.bindTexture(gl.TEXTURE_2D, object.id);
            object.gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, object.img);
           
        });
        this.img.src = imagepath;
    }

    /** @type {() => void} */
    bind(){
        this.gl.bindTexture(this.gl.TEXTURE_2D, this.id);
    }
}