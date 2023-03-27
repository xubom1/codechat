<script id="vertexShader" type="x-shader/x-vertex">
    attribute vec3 position;
    
    uniform mat4 model;
    uniform mat4 view;
    uniform mat4 projection;
 
    void main() {
        gl_Position = /**/(projection * view * model) * vec4(position, 1);
    }

</script>

<script id="fragmentShader" type="x-shader/x-fragment">

    void main() {
        gl_FragColor = vec4(1, 0, 0, 1);
    }

</script>